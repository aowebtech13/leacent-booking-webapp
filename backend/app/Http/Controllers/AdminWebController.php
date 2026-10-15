<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Referral;
use App\Models\ReferralClick;

use App\Models\User;
use App\Models\UserRole;
use App\Models\UserLog;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\Book;
use App\Models\Author;
use App\Notifications\ManualPaymentRejectedNotification;
use App\Notifications\ManualPaymentVerifiedNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AdminWebController extends Controller
{
    private const PLAN_PRICING = [
        'Free' => ['monthly' => 0, 'yearly' => 0],
        'Student' => ['monthly' => 6000, 'yearly' => 66000],
        'Pro' => ['monthly' => 15000, 'yearly' => 165000],
        'Max' => ['monthly' => 21000, 'yearly' => 231000],
        'Team' => ['monthly' => 37500, 'yearly' => 412500],
        // Legacy support
        'free' => ['monthly' => 0, 'yearly' => 0],
        'basic' => ['monthly' => 15000, 'yearly' => 165000],
        'premium' => ['monthly' => 21000, 'yearly' => 231000],
        'enterprise' => ['monthly' => 37500, 'yearly' => 412500],
    ];

    public function showLogin()
    {
        /** @var User|null $user */
        $user = Auth::user();
        if ($user && $user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            /** @var User|null $user */
            $user = Auth::user();
            if (! $user || ! $user->isAdmin()) {
                Auth::logout();

                return back()->withErrors([
                    'email' => 'You do not have admin access.',
                ])->onlyInput('email');
            }

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Invalid credentials provided.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        $stats = [
            'total_admins' => User::whereHas('roles', fn ($query) => $query->where('role', 'admin'))->count(),
            'online_users' => User::where('last_seen_at', '>=', now()->subMinutes(5))->count(),
            'total_customers' => Customer::count(),
            'total_orders' => Order::count(),
            'total_debt' => (float) Profile::sum('balance'),
            'total_revenue' => (float) Transaction::whereIn('status', ['accepted', 'completed'])->sum('amount'),
            'total_cost' => (float) Order::sum('total'),
            'total_visitors' => User::count(),
        ];

        $recentCustomers = User::whereHas('roles', fn ($query) => $query->where('role', 'customer'))
            ->with('profile')
            ->latest()
            ->take(5)
            ->get();

        // Top customers by total purchase count and total price from orders
        $topCustomers = Customer::with(['user.profile'])
            ->withCount(['orders as total_purchases' => function ($query) {
                $query->select(DB::raw('COUNT(*)'));
            }])
            ->withSum(['orders as total_price' => function ($query) {
                $query->select(DB::raw('COALESCE(SUM(total), 0)'));
            }], 'total')
            ->whereHas('orders')
            ->orderByDesc('total_purchases')
            ->take(8)
            ->get()
            ->map(function ($customer) {
                return (object) [
                    'id' => $customer->id,
                    'name' => trim($customer->first_name . ' ' . ($customer->last_name ?? '')),
                    'total_purchases' => (int) ($customer->total_purchases ?? 0),
                    'total_price' => (float) ($customer->total_price ?? 0),
                    'customer_number' => '#' . str_pad($customer->id, 6, '0', STR_PAD_LEFT),
                ];
            });

        // Recent user activity logs (login/logout actions)
        $userLogs = UserLog::with(['user.profile'])
            ->latest()
            ->take(8)
            ->get()
            ->map(function ($log) {
                $userName = $log->user?->name ?? 'Unknown User';
                $actionText = $log->action === 'login' ? 'Logged in' : 'Logged out';
                $deviceInfo = $log->device ? " via {$log->device}" : '';
                return (object) [
                    'id' => $log->id,
                    'user_name' => $userName,
                    'action' => $log->action,
                    'action_text' => $actionText,
                    'device_info' => $deviceInfo,
                    'ip_address' => $log->ip_address,
                    'created_at' => $log->created_at,
                    'time' => $log->created_at->format('h:i A'),
                    'date' => $log->created_at->format('d M Y'),
                ];
            });

        // Recent orders (latest 8 with customer, items, and product images)
        $recentOrders = Order::with(['customer', 'items.product.images'])
            ->latest()
            ->take(8)
            ->get()
            ->map(function ($order) {
                // Get first item for product info
                $firstItem = $order->items->first();
                $product = $firstItem?->product;
                $firstImage = $product?->images->first();
                $productImageUrl = $firstImage
                    ? asset('storage/' . $firstImage->image_path)
                    : asset('assets/images/dashboard-2/order/sub-product/16.png');

                // Determine customer name
                $customerName = $order->customer
                    ? trim(($order->customer->first_name ?? '') . ' ' . ($order->customer->last_name ?? ''))
                    : ($order->billing_name ?? 'Guest');

                if (empty(trim($customerName)) || $customerName === 'Guest') {
                    $customerName = $order->billing_name ?? 'Guest';
                }

                // Total quantity
                $totalQty = (int) $order->items->sum('quantity');

                // Status label and button class
                $statusLabel = ucfirst($order->status);
                $statusButtonClass = 'button-light-info txt-info'; // default for pending

                switch ($order->status) {
                    case Order::STATUS_COMPLETED:
                    case Order::STATUS_PAID:
                        $statusLabel = 'Delivered';
                        $statusButtonClass = 'button-light-success txt-success';
                        break;
                    case Order::STATUS_PROCESSING:
                    case Order::STATUS_SHIPPED:
                        $statusLabel = 'In Progress';
                        $statusButtonClass = 'button-light-warning txt-warning';
                        break;
                    case Order::STATUS_CANCELLED:
                        $statusLabel = 'Canceled';
                        $statusButtonClass = 'button-light-danger txt-danger';
                        break;
                    case Order::STATUS_PENDING:
                    default:
                        $statusLabel = 'Pending';
                        $statusButtonClass = 'button-light-info txt-info';
                        break;
                }

                return (object) [
                    'id' => $order->id,
                    'order_number' => '#' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
                    'product_name' => $product?->name ?? 'N/A',
                    'product_image' => $productImageUrl,
                    'customer_name' => $customerName,
                    'quantity' => $totalQty . ' PCS',
                    'total_price' => number_format((float) $order->total, 2),
                    'order_date' => $order->created_at->format('d M,Y'),
                    'status' => $order->status,
                    'status_label' => $statusLabel,
                    'status_button_class' => $statusButtonClass,
                ];
            });

        // Sales Statistical Overview - monthly sales data for last 12 months
        $monthlySalesData = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthStart = $month->copy()->startOfMonth();
            $monthEnd = $month->copy()->endOfMonth();

            $monthlySalesData[] = (float) Order::whereIn('payment_status', [Order::PAYMENT_PAID, Order::PAYMENT_PENDING_VERIFICATION])
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->sum('total');
        }

        // Monthly Target data
        $currentMonthSales = (float) Order::whereIn('payment_status', [Order::PAYMENT_PAID, Order::PAYMENT_PENDING_VERIFICATION])
            ->where('created_at', '>=', now()->startOfMonth())
            ->sum('total');

        $last6MonthsTotal = (float) Order::whereIn('payment_status', [Order::PAYMENT_PAID, Order::PAYMENT_PENDING_VERIFICATION])
            ->where('created_at', '>=', now()->subMonths(6))
            ->sum('total');

        $monthlyTarget = $last6MonthsTotal > 0 ? round(($last6MonthsTotal / 6) * 1.2) : 10000;
        $monthlyAchievement = $monthlyTarget > 0 ? min(100, round(($currentMonthSales / $monthlyTarget) * 100)) : 0;

        $todaySales = (float) Order::whereIn('payment_status', [Order::PAYMENT_PAID, Order::PAYMENT_PENDING_VERIFICATION])
            ->where('created_at', '>=', now()->startOfDay())
            ->sum('total');

        return view('admin.dashboard.index', compact(
            'stats',
            'recentCustomers',
            'topCustomers',
            'userLogs',
            'recentOrders',
            'monthlySalesData',
            'monthlyTarget',
            'monthlyAchievement',
            'currentMonthSales',
            'todaySales'
        ));
    }


    public function users(Request $request)
    {
        // Subscriptions removed: always show plan as Free.
        $query = User::with(['profile', 'roles']);


        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%")
                    ->orWhereHas('profile', function ($profileQuery) use ($request) {
                        $profileQuery->where('full_name', 'like', "%{$request->search}%")
                            ->orWhere('company_name', 'like', "%{$request->search}%");
                    });
            });
        }

        if ($request->filled('role')) {
            $query->whereHas('roles', fn ($roleQuery) => $roleQuery->where('role', $request->role));
        }

        // plan filter removed (subscriptions removed)


        $users = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function updateUserPlan(Request $request, User $user)
    {
        $data = $request->validate([
            'plan' => ['required', Rule::in(array_keys(self::PLAN_PRICING))],
            'billing_cycle' => ['nullable', Rule::in(['monthly', 'yearly'])],
            'end_date' => ['nullable', 'date'],
        ]);

        $selectedPlan = $data['plan'];
        $billingCycle = $data['billing_cycle'] ?? ($user->activeSubscription?->billing_cycle ?? 'monthly');
        $endDate = !empty($data['end_date']) ? Carbon::parse($data['end_date']) : ($billingCycle === 'yearly' ? Carbon::now()->addYear() : Carbon::now()->addMonth());

        // Deactivate all current active subscriptions
        Subscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->update(['status' => 'expired']);

        $subscriptionPayload = [
            'user_id' => $user->id,
            'plan' => $selectedPlan,
            'status' => 'active',
            'billing_cycle' => $billingCycle,
            'amount' => $this->getPlanAmount($selectedPlan, $billingCycle),
            'currency' => $user->activeSubscription?->currency ?? 'NGN',
            'start_date' => Carbon::now(),
            'end_date' => $endDate,
            'cancelled_at' => null,
            'auto_renew' => false,
        ];

        // Subscription::create($subscriptionPayload);

        return back()->with('status', $user->name."'s plan updated to ".$selectedPlan.'.');
    }

    public function profile(Request $request)
    {
        $admin = $request->user()->load('profile');
        $logoUrl = $admin->profile && $admin->profile->avatar_url
            ? Storage::url($admin->profile->avatar_url)
            : null;

        return view('admin.profile', compact('admin', 'logoUrl'));
    }

    public function updateProfile(Request $request)
    {
        $admin = $request->user()->load('profile');

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($admin->id)],
'logo' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,webp,bmp,svg,avif', 'max:2048'],
            'current_password' => ['nullable', 'string'],
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ]);

        $admin->name = $data['name'];
        $admin->email = $data['email'];

        if (! empty($data['password'])) {
            if (empty($data['current_password']) || ! Hash::check($data['current_password'], $admin->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.'])->withInput();
            }

            $admin->password = Hash::make($data['password']);
        }

        $admin->save();

        $profile = $admin->profile ?: new Profile(['user_id' => $admin->id]);
        $profile->email = $data['email'];
        $profile->full_name = $data['name'];

        if ($request->hasFile('logo')) {
            if ($profile->avatar_url) {
                Storage::disk('public')->delete($profile->avatar_url);
            }

            $profile->avatar_url = $request->file('logo')->store('admin-logos', 'public');
        }

        $profile->save();

        return back()->with('status', 'Profile updated successfully.');
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $data = $this->validateUserPayload($request);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $this->syncProfile($user, $data);
        $this->syncRole($user, $data['role']);

        return redirect()->route('admin.users.index')->with('status', 'User created successfully.');
    }

    public function editUser(User $user)
    {
        $user->load(['profile', 'roles']);

        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $data = $this->validateUserPayload($request, $user->id, false);

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'] ? Hash::make($data['password']) : $user->password,
        ]);

        $this->syncProfile($user, $data);
        $this->syncRole($user, $data['role']);

        return redirect()->route('admin.users.index')->with('status', 'User updated successfully.');
    }

    public function destroyUser(User $user)
    {
        if ($user?->isAdmin()) {
            $adminCount = User::whereHas('roles', fn ($query) => $query->where('role', 'admin'))->count();
            if ($adminCount <= 1) {
                return back()->withErrors(['error' => 'Cannot delete the last admin user.']);
            }
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('status', 'User deleted successfully.');
    }

    public function exportUsers()
    {
        $users = User::with('activeSubscription')->get();
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="users_export_' . now()->format('Y-m-d_H-i-s') . '.csv"',
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Name', 'Email', 'Plan']);

            foreach ($users as $user) {
                $plan = $user->activeSubscription ? $user->activeSubscription->plan : 'Free';
                fputcsv($file, [$user->name, $user->email, $plan]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function subscriptions(Request $request)
    {
        $query = Subscription::with(['user.profile']);

        if ($request->filled('search')) {
            $query->whereHas('user', function ($userQuery) use ($request) {
                $userQuery->where('name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('plan')) {
            $query->where('plan', $request->plan);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $subscriptions = $query->where('amount', '>', 0) // Only paid plans usually
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    public function transactions(Request $request)
    {
        $query = Transaction::with(['user', 'order']);

        // Search functionality
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('reference', 'like', "%{$request->search}%")
                    ->orWhere('description', 'like', "%{$request->search}%")
                    ->orWhereHas('user', function ($userQuery) use ($request) {
                        $userQuery->where('name', 'like', "%{$request->search}%")
                            ->orWhere('email', 'like', "%{$request->search}%");
                    });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Date range filter
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // Summary Statistics (calculated before pagination)
        $isFiltered = $request->filled('search') || $request->filled('status') || $request->filled('from_date') || $request->filled('to_date');

        $summary = [
            'total_count' => (clone $query)->count(),
            'total_revenue' => $isFiltered ? (float) (clone $query)->whereIn('status', ['completed', 'accepted'])->sum('amount') : 0,
            'pending_count' => (clone $query)->where('status', 'pending')->count(),
            'failed_count' => (clone $query)->whereIn('status', ['failed', 'rejected'])->count(),
        ];

        $transactions = $query->orderByDesc('created_at')->paginate(20)->withQueryString();

        return view('admin.transactions.index', compact('transactions', 'summary'));
    }

    public function orders(Request $request)
    {
        $query = \App\Models\Order::with(['user.profile']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('billing_name', 'like', "%{$search}%")
                    ->orWhere('billing_email', 'like', "%{$search}%")
                    ->orWhere('id', $search)
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $orders = $query->orderByDesc('created_at')->paginate(20)->withQueryString();

        $statuses = \App\Models\Order::validStatuses();
        $paymentStatuses = ['unpaid', 'paid', 'failed', 'refunded'];

        return view('admin.orders.index', compact('orders', 'statuses', 'paymentStatuses'));
    }

    public function updateOrderStatus(Request $request, \App\Models\Order $order)
    {
        $request->validate([
            'status' => ['required', 'in:' . implode(',', \App\Models\Order::validStatuses())],
            'notes' => 'nullable|string|max:2000',
        ]);

        $wasPaid = $order->isPaid();
        $wasCancelled = $order->isCancelled();

        $order->status = $request->status;

        if ($request->status === \App\Models\Order::STATUS_PAID && ! $wasPaid) {
            $order->payment_status = \App\Models\Order::PAYMENT_PAID;
        }

        if ($request->filled('notes')) {
            $order->notes = $request->notes;
        }

        $order->save();

        // Keep the Ledger in sync when an admin marks an order as paid.
        if ($request->status === \App\Models\Order::STATUS_PAID && ! $wasPaid) {
            $type = $order->payment_method === 'flutterwave'
                ? Transaction::TYPE_ORDER_PAYMENT
                : Transaction::TYPE_MANUAL_PAYMENT;

            Transaction::findOrCreateForOrder(
                $order,
                $type,
                Transaction::STATUS_PENDING
            )->settle(Transaction::STATUS_COMPLETED, $request->user()->id);
        }

        if ($request->status === \App\Models\Order::STATUS_CANCELLED && ! $wasCancelled) {
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
        }

        return redirect()
            ->route('admin.orders.index', request()->only(['search', 'status', 'payment_status', 'from_date', 'to_date']))
            ->with('success', 'Order #' . $order->id . ' updated to ' . ucfirst($order->status) . '.');
    }

    public function showOrder(Order $order)
    {
        $order->load(['user', 'items.product', 'verifier']);

        return view('admin.orders.show', compact('order'));
    }

    public function viewReceipt(Order $order)
    {
        if (! $order->payment_receipt || ! Storage::disk('public')->exists($order->payment_receipt)) {
            return back()->with('error', 'Receipt not found for this order.');
        }

        return view('admin.orders.receipt', compact('order'));
    }

    public function verifyPayment(Request $request, Order $order)
    {
        $request->validate([
            'notes' => 'nullable|string|max:2000',
        ]);

        if ($order->isPaid()) {
            return back()->with('error', 'Payment has already been verified.');
        }

        if (! $order->isPendingVerification()) {
            return back()->with('error', 'There is no pending payment to verify for this order.');
        }

        $admin = $request->user();
        $order->markVerified($admin->id, $request->get('notes'));

        // Keep the Ledger in sync with the admin's verification.
        Transaction::findOrCreateForOrder(
            $order,
            Transaction::TYPE_MANUAL_PAYMENT,
            Transaction::STATUS_PENDING
        )->settle(Transaction::STATUS_ACCEPTED, $admin->id);

        $order->user->notify(new ManualPaymentVerifiedNotification(
            orderId: $order->id,
            amount: $order->amount_paid ?? $order->total,
            currency: $order->currency,
        ));

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success', 'Payment verified successfully for Order #' . $order->id . '.');
    }

    public function rejectPayment(Request $request, Order $order)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:2000',
            'notes' => 'nullable|string|max:2000',
        ]);

        if ($order->payment_status === Order::PAYMENT_FAILED) {
            return back()->with('error', 'Payment has already been rejected.');
        }

        if (! $order->isPendingVerification()) {
            return back()->with('error', 'There is no pending payment to reject for this order.');
        }

        $admin = $request->user();
        $order->markRejected(
            $admin->id,
            $request->get('rejection_reason'),
            $request->get('notes')
        );

        // Keep the Ledger in sync with the admin's rejection.
        Transaction::findOrCreateForOrder(
            $order,
            Transaction::TYPE_MANUAL_PAYMENT,
            Transaction::STATUS_PENDING
        )->settle(Transaction::STATUS_REJECTED, $admin->id, $request->get('rejection_reason'));

        $order->user->notify(new ManualPaymentRejectedNotification(
            orderId: $order->id,
            reason: $request->get('rejection_reason'),
        ));

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success', 'Payment rejected for Order #' . $order->id . '.');
    }

    public function exportTransactions(Request $request)
    {
        $query = Transaction::with(['user', 'order']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('reference', 'like', "%{$request->search}%")
                    ->orWhere('description', 'like', "%{$request->search}%")
                    ->orWhereHas('user', function ($userQuery) use ($request) {
                        $userQuery->where('name', 'like', "%{$request->search}%")
                            ->orWhere('email', 'like', "%{$request->search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $transactions = $query->orderByDesc('created_at')->get();
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="transactions_export_' . now()->format('Y-m-d_H-i-s') . '.csv"',
        ];

        $callback = function() use ($transactions) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Date', 'User Name', 'User Email', 'Type', 'Reference', 'Amount', 'Currency', 'Status', 'Order ID', 'Payment Method']);

            foreach ($transactions as $tx) {
                fputcsv($file, [
                    $tx->created_at->format('Y-m-d H:i:s'),
                    $tx->user->name,
                    $tx->user->email,
                    $tx->type,
                    $tx->reference,
                    $tx->amount,
                    $tx->currency,
                    $tx->status,
                    $tx->order_id,
                    $tx->payment_method,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function updateSubscription(Request $request, Subscription $subscription)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['active', 'cancelled', 'expired', 'pending'])],
        ]);

        $subscription->update([
            'status' => $data['status'],
            'cancelled_at' => $data['status'] === 'cancelled' ? now() : null,
        ]);

        return back()->with('status', 'Subscription updated successfully.');
    }

private function getPlanAmount(string $plan, string $cycle = 'monthly'): float
    {
        $planKey = ucfirst(strtolower($plan));
        return (float) (self::PLAN_PRICING[$planKey][$cycle] ?? 0);
    }

    public function customers(Request $request)
    {
        $query = Customer::with(['user', 'orders']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $customers = $query->orderByDesc('created_at')->paginate(20)->withQueryString();

        return view('admin.customers.index', compact('customers'));
    }

    public function destroyCustomer(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('admin.customers.index')->with('status', 'Customer deleted successfully.');
    }


    /* ------------------------------------------------------------------ */
    /* Books Management                                                   */
    /* ------------------------------------------------------------------ */

    public function books(Request $request)
    {
        $query = Book::with('author')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('isbn', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', filter_var($request->get('is_active'), FILTER_VALIDATE_BOOLEAN));
        }

        $books = $query->paginate(20)->withQueryString();

        return view('admin.books.index', compact('books'));
    }

    public function createBook()
    {
        $authors = Author::where('is_active', true)->orderBy('name')->get();

        return view('admin.books.create', compact('authors'));
    }

    public function storeBook(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:books',
            'author' => 'nullable|string|max:255',
            'author_id' => 'nullable|exists:authors,id',
            'isbn' => 'nullable|string|max:255|unique:books',
            'publisher' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'publication_year' => 'nullable|integer|min:1000|max:9999',
            'page_count' => 'nullable|integer|min:1',
            'format' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'file_path' => 'nullable|string|max:255',
            'cover_image_path' => 'nullable|string|max:255',
            'preview_path' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'is_premium' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean',
            'tags' => 'sometimes|array',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = \Illuminate\Support\Str::slug($data['title']);
        }

        $data['price'] = $data['price'] ?? 0;
        $data['is_premium'] = $data['is_premium'] ?? false;
        $data['is_active'] = $data['is_active'] ?? true;
        $data['is_featured'] = $data['is_featured'] ?? false;

        Book::create($data);

        return redirect()->route('admin.books.index')->with('status', 'Book created successfully.');
    }

    public function editBook(Book $book)
    {
        $book->load('author');
        $authors = Author::where('is_active', true)->orderBy('name')->get();

        return view('admin.books.edit', compact('book', 'authors'));
    }

    public function updateBook(Request $request, Book $book)
    {
        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'slug' => 'sometimes|string|max:255|unique:books,slug,' . $book->id,
            'author' => 'sometimes|nullable|string|max:255',
            'author_id' => 'sometimes|nullable|exists:authors,id',
            'isbn' => 'sometimes|nullable|string|max:255|unique:books,isbn,' . $book->id,
            'publisher' => 'sometimes|nullable|string|max:255',
            'language' => 'sometimes|nullable|string|max:255',
            'category' => 'sometimes|nullable|string|max:255',
            'publication_year' => 'sometimes|nullable|integer|min:1000|max:9999',
            'page_count' => 'sometimes|nullable|integer|min:1',
            'format' => 'sometimes|nullable|string|max:50',
            'description' => 'sometimes|nullable|string',
            'file_path' => 'sometimes|nullable|string|max:255',
            'cover_image_path' => 'sometimes|nullable|string|max:255',
            'preview_path' => 'sometimes|nullable|string|max:255',
            'price' => 'sometimes|nullable|numeric|min:0',
            'is_premium' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean',
            'tags' => 'sometimes|array',
        ]);

        $book->update($data);

        return redirect()->route('admin.books.index')->with('status', 'Book updated successfully.');
    }

    public function destroyBook(Book $book)
    {
        if ($book->file_path) {
            Storage::disk('public')->delete($book->file_path);
        }
        if ($book->cover_image_path) {
            Storage::disk('public')->delete($book->cover_image_path);
        }
        if ($book->preview_path) {
            Storage::disk('public')->delete($book->preview_path);
        }

        $book->delete();

        return redirect()->route('admin.books.index')->with('status', 'Book deleted successfully.');
    }


    /* ------------------------------------------------------------------ */
    /* Authors Management                                                 */
    /* ------------------------------------------------------------------ */

    public function authors(Request $request)
    {
        $query = Author::withCount('books')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('bio', 'like', "%{$search}%");
            });
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', filter_var($request->get('is_active'), FILTER_VALIDATE_BOOLEAN));
        }

        $authors = $query->paginate(20)->withQueryString();

        return view('admin.authors.index', compact('authors'));
    }

    public function createAuthor()
    {
        return view('admin.authors.index');
    }

    public function storeAuthor(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:authors',
            'bio' => 'nullable|string',
            'email' => 'nullable|email|max:255|unique:authors',
            'phone' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'avatar' => 'nullable|string|max:255',
            'is_active' => 'sometimes|boolean',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
        }

        Author::create($data);

        return redirect()->route('admin.authors.index')->with('status', 'Author created successfully.');
    }

    public function editAuthor(Author $author)
    {
        return view('admin.authors.index', compact('author'));
    }

    public function updateAuthor(Request $request, Author $author)
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'slug' => 'sometimes|string|max:255|unique:authors,slug,' . $author->id,
            'bio' => 'sometimes|nullable|string',
            'email' => 'sometimes|nullable|email|max:255|unique:authors,email,' . $author->id,
            'phone' => 'sometimes|nullable|string|max:255',
            'website' => 'sometimes|nullable|url|max:255',
            'avatar' => 'sometimes|nullable|string|max:255',
            'is_active' => 'sometimes|boolean',
        ]);

        $author->update($data);

        return redirect()->route('admin.authors.index')->with('status', 'Author updated successfully.');
    }

    public function destroyAuthor(Author $author)
    {
        $author->books()->update(['author_id' => null]);

        $author->delete();

        return redirect()->route('admin.authors.index')->with('status', 'Author deleted successfully.');
    }
    private function validateUserPayload(Request $request, ?int $userId = null, bool $isCreating = true): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($userId)],
            'password' => [$isCreating ? 'required' : 'nullable', 'string', 'min:8'],
            'role' => ['required', Rule::in(['admin', 'user'])],
            'full_name' => ['nullable', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:100'],
        ]);
    }

    private function syncProfile(User $user, array $data): void
    {
        $profileData = [
            'full_name' => $data['full_name'] ?? null,
            'company_name' => $data['company_name'] ?? null,
            'phone_number' => $data['phone_number'] ?? null,
            'address' => $data['address'] ?? null,
            'city' => $data['city'] ?? null,
            'state' => $data['state'] ?? null,
            'country' => $data['country'] ?? null,
            'email' => $user->email,
        ];

        if ($user->profile) {
            $user->profile->update($profileData);
        } else {
            $profileData['user_id'] = $user->id;
            Profile::create($profileData);
        }
    }

    private function syncRole(User $user, string $role): void
    {
        $user->roles()->delete();
        UserRole::create([
            'user_id' => $user->id,
            'role' => $role,
        ]);
    }

    

    public function activityLogs(Request $request)
    {
        $query = UserLog::with(['user.profile'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        $logs = $query->paginate(30)->withQueryString();

        // Also get currently online users for the same page
        $onlineUsers = User::with(['profile', 'roles', 'activeSubscription'])
            ->where('last_seen_at', '>=', now()->subMinutes(5))
            ->orderBy('last_seen_at', 'desc')
            ->get();

        return view('admin.activity-logs', compact('logs', 'onlineUsers'));
    }

    public function finances()
    {
        $subscriptions = Subscription::whereIn('status', ['active', 'successful'])
            ->whereNotNull('amount')
            ->where('amount', '>', 0)
            ->get();

        $totalIncome = (float) $subscriptions->sum('amount');
        $monthlySales = Subscription::whereIn('status', ['active', 'successful'])
            ->where('created_at', '>=', now()->startOfMonth())
            ->count();
        
        // Assuming 10% operational cost for net income
        $netIncome = $totalIncome * 0.9;

        // Prepare monthly chart data (last 6 months)
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthStart = $month->copy()->startOfMonth();
            $monthEnd = $month->copy()->endOfMonth();
            
            $monthlyData[] = [
                'label' => $month->format('M Y'),
                'income' => (float) Subscription::whereIn('status', ['active', 'successful'])
                    ->whereBetween('created_at', [$monthStart, $monthEnd])
                    ->sum('amount'),
                'sales' => Subscription::whereIn('status', ['active', 'successful'])
                    ->whereBetween('created_at', [$monthStart, $monthEnd])
                    ->count()
            ];
        }

        // Prepare pie chart data for income variations (by plan)
        $planDistribution = $subscriptions->groupBy('plan')
            ->map(fn($group) => (float) $group->sum('amount'))
            ->toArray();

        return view('admin.finances', compact(
            'totalIncome',
            'monthlySales',
            'netIncome',
            'monthlyData',
            'planDistribution'
        ));
    }

    /**
     * Report: Products - List products with total sold count, price, and rating.
     */
    public function reportsProducts()
    {
        $products = Product::with('images')->withCount(['orderItems as total_sold' => function ($q) {
                $q->select(DB::raw('COALESCE(SUM(quantity), 0)'));
            }])
            ->orderByDesc('total_sold')
            ->get()
            ->map(function ($product) {
                $rating = min(5, max(1, (int) ceil($product->total_sold / 10)));
                $fullStars = $rating;
                $emptyStars = 5 - $rating;
                return (object) [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'total_sold' => (int) ($product->total_sold ?? 0),
                    'price' => (float) ($product->sale_price ?: $product->price),
                    'image' => $product->images->first()?->url ?? asset('assets/images/dashboard-8/product-categories/laptop.png'),
                    'full_stars' => $fullStars,
                    'empty_stars' => $emptyStars,
                ];
            });

        return view('reports.products', compact('products'));
    }

    /**
     * Report: Sales - Monthly sales summary with totals, averages, and growth.
     */
    public function reportsSales()
    {
        $monthlySales = Order::select(
                DB::raw("DATE_FORMAT(created_at, '%m') as month_num"),
                DB::raw("DATE_FORMAT(created_at, '%Y') as year"),
                DB::raw('COALESCE(SUM(total), 0) as total_sales'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('COALESCE(AVG(total), 0) as avg_order_value')
            )
            ->whereIn('payment_status', [Order::PAYMENT_PAID, Order::PAYMENT_PENDING_VERIFICATION])
            ->groupBy('year', 'month_num')
            ->orderBy('year')
            ->orderBy('month_num')
            ->get();

        $monthNames = ['', 'January', 'February', 'March', 'April', 'May', 'June',
                        'July', 'August', 'September', 'October', 'November', 'December'];

        $allMonths = [];
        $prevSales = null;
        for ($m = 1; $m <= 12; $m++) {
            $monthData = $monthlySales->firstWhere('month_num', str_pad($m, 2, '0', STR_PAD_LEFT));
            $totalSales = $monthData ? (float) $monthData->total_sales : 0;
            $totalOrders = $monthData ? (int) $monthData->total_orders : 0;
            $avgOrder = $monthData ? (float) $monthData->avg_order_value : 0;

            if ($prevSales !== null && $prevSales > 0) {
                $growth = round((($totalSales - $prevSales) / $prevSales) * 100);
            } else {
                $growth = $totalSales > 0 ? 100 : 0;
            }

            $allMonths[] = (object) [
                'month' => $monthNames[$m],
                'total_sales' => $totalSales,
                'avg_order_value' => $avgOrder,
                'total_orders' => $totalOrders,
                'growth' => $growth,
            ];
            $prevSales = $totalSales;
        }

        return view('reports.sales', compact('allMonths'));
    }

/**
     * Report: Sales Return - Monthly return summary.
     * Uses simulated data for demo purposes, and falls back to real data when available.
     */
    public function reportsSalesReturn()
    {
        $monthNames = ['', 'January', 'February', 'March', 'April', 'May', 'June',
                        'July', 'August', 'September', 'October', 'November', 'December'];

        $reasons = ['Damaged Package', 'Defective Item', 'Received the wrong item', 'Item Arrived Late', 'Repeat Order'];

        // Try to get real data from cancelled/refunded orders
        $monthlyReturns = Order::select(
                DB::raw("DATE_FORMAT(created_at, '%m') as month_num"),
                DB::raw("DATE_FORMAT(created_at, '%Y') as year"),
                DB::raw('COALESCE(SUM(total), 0) as total_return'),
                DB::raw('COUNT(*) as returned_count')
            )
            ->where(function ($q) {
                $q->whereIn('payment_status', [Order::PAYMENT_FAILED, Order::PAYMENT_REFUNDED])
                  ->orWhere('status', Order::STATUS_CANCELLED);
            })
            ->groupBy('year', 'month_num')
            ->orderBy('year')
            ->orderBy('month_num')
            ->get();

        $allMonths = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthData = $monthlyReturns->firstWhere('month_num', str_pad($m, 2, '0', STR_PAD_LEFT));

            // Generate simulated data for each month for demo purposes
            $allMonths[] = (object) [
                'month' => $monthNames[$m],
                'total_items' => random_int(5, 45),
                'ordered' => random_int(14, 300),
                'returned' => $monthData ? (int) $monthData->returned_count : random_int(1, 20),
                'reason' => $reasons[array_rand($reasons)],
                'total_replace' => random_int(1, 10),
                'total_return' => $monthData ? (float) $monthData->total_return : round((float) random_int(250, 900), 2),
            ];
        }

        // Pending payments for verification
        $pendingPayments = Order::with('user')
            ->where('payment_status', Order::PAYMENT_PENDING_VERIFICATION)
            ->orderByDesc('created_at')
            ->get();

        // Payment history from the transaction ledger
        $paymentHistory = \App\Models\Transaction::with(['order', 'user', 'verifier'])
            ->whereIn('type', [\App\Models\Transaction::TYPE_ORDER_PAYMENT, \App\Models\Transaction::TYPE_MANUAL_PAYMENT])
            ->orderByDesc('created_at')
            ->get();

        return view('reports.sales_return', compact('allMonths', 'pendingPayments', 'paymentHistory'));
    }

    /**
     * Report: Customer Order - Customers with order stats.
     */
    public function reportsCustomerOrder()
    {
        $customers = Customer::with(['user.profile', 'orders.items'])
            ->withCount(['orders as order_count'])
            ->withSum(['orders as total_spent' => function ($q) {
                $q->whereIn('payment_status', [Order::PAYMENT_PAID, Order::PAYMENT_PENDING_VERIFICATION]);
            }], 'total')
            ->orderByDesc('order_count')
            ->get()
            ->map(function ($customer) {
                $productCount = \App\Models\OrderItem::whereIn('order_id', $customer->orders->pluck('id'))
                    ->sum('quantity');

                $avatar = $customer->user?->profile?->avatar_url
                    ? Storage::url($customer->user->profile->avatar_url)
                    : asset('assets/images/user/6.jpg');

                return (object) [
                    'id' => $customer->id,
                    'name' => trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? '')),
                    'email' => $customer->user?->email ?? 'unknown@example.com',
                    'avatar' => $avatar,
                    'order_count' => (int) ($customer->order_count ?? 0),
                    'product_count' => (int) $productCount,
                    'total_spent' => (float) ($customer->total_spent ?? 0),
                ];
            });

        // If no customers with orders exist, supplement with additional simulated customers
        if ($customers->isEmpty()) {
            $simulatedCustomers = [];
            $names = [
                ['Floyd Miles', 'floyd@gmail.com'],
                ['Celine Stokes', 'celine@gmail.com'],
                ['Ila Malone', 'ila@gmail.com'],
                ['Poppy Mosley', 'poppy@gmail.com'],
                ['Eileen Portillo', 'eileen@gmail.com'],
                ['Ruben Charles', 'ruben@gmail.com'],
                ['Sullivan Thomas', 'sullivan@gmail.com'],
                ['Jeffrey Daniel', 'jeffrey@gmail.com'],
            ];
            foreach ($names as $i => $n) {
                $simulatedCustomers[] = (object) [
                    'id' => $i + 1,
                    'name' => $n[0],
                    'email' => $n[1],
                    'avatar' => asset('assets/images/dashboard-11/user/' . ($i + 1) . '.jpg'),
                    'order_count' => random_int(100, 1000),
                    'product_count' => random_int(100, 880),
                    'total_spent' => round(random_int(1500, 99000), 2),
                ];
            }
            $customers = collect($simulatedCustomers);
        }

        return view('reports.customer_order', compact('customers'));
    }

    public function affiliates(Request $request)
    {
        $query = User::whereHas('referrals')
            ->with(['profile', 'activeSubscription'])
            ->withCount('referrals');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('profile', function ($p) use ($search) {
                        $p->where('full_name', 'like', "%{$search}%");
                    });
            });
        }

        $affiliates = $query->paginate(20)->withQueryString();

        return view('admin.affiliates.index', compact('affiliates'));
    }

    public function updateAffiliateBalance(Request $request, User $user)
    {
        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:0'],
            'action' => ['required', Rule::in(['add', 'remove'])],
            'reason' => ['nullable', 'string', 'max:255'],
        ]);

        $profile = $user->profile ?: $user->profile()->create(['user_id' => $user->id, 'email' => $user->email]);
        
        $amount = (float) $data['amount'];
        $oldBalance = (float) ($profile->balance ?? 0);
        
        if ($data['action'] === 'add') {
            $newBalance = $oldBalance + $amount;
        } else {
            $newBalance = max(0, $oldBalance - $amount);
        }

        $profile->update(['balance' => $newBalance]);

        \App\Models\WalletTransaction::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'type' => $data['action'] === 'add' ? 'credit' : 'debit',
            'description' => $data['reason'] ?? 'Admin balance adjustment',
            'reference' => 'admin_' . time(),
        ]);

        return back()->with('status', "Affiliate balance updated successfully for {$user->name}. New balance: ".number_format($newBalance, 2));
    }
}
