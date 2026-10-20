<?php

namespace App\Http\Controllers;

use App\Models\BookPayment;
use App\Models\BookPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BookPlanController extends Controller
{
    /**
     * Bank account details customers transfer to.
     */
    private function bankDetails(): array
    {
        $bank = config('ecommerce.bank_transfer');

        return [
            'account_name' => $bank['account_name'],
            'account_number' => $bank['account_number'],
            'bank_name' => $bank['bank_name'],
            'instructions' => $bank['instructions'],
        ];
    }

    /**
     * GET /api/book-plans
     * Active subscription plans available to customers.
     */
    public function index(Request $request)
    {
        $plans = BookPlan::query()
            ->active()
            ->ordered()
            ->get([
                'id',
                'name',
                'slug',
                'description',
                'price',
                'currency',
                'billing_cycle',
                'access_duration_days',
                'unlimited_books',
                'book_limit',
                'can_download',
                'can_read_offline',
                'is_featured',
                'features',
            ]);

        return response()->json([
            'success' => true,
            'data' => $plans,
        ]);
    }

    /**
     * GET /api/book-plans/bank-details
     * Account details used for manual (bank transfer) payments.
     */
    public function bankDetailsEndpoint(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $this->bankDetails(),
        ]);
    }

    /**
     * POST /api/book-plans/{bookPlan}/subscribe
     *
     * Start a subscription: creates a pending book payment the customer
     * settles by bank transfer. Payment verification is manual and happens
     * in the Laravel admin area.
     */
    public function subscribe(Request $request, BookPlan $bookPlan)
    {
        if (! $bookPlan->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'This plan is not available.',
            ], 422);
        }

        $user = $request->user();

        // Reuse an existing pending payment for the same plan so the
        // customer can simply continue with the transfer they started.
        $pending = BookPayment::where('user_id', $user->id)
            ->where('book_plan_id', $bookPlan->id)
            ->where('status', BookPayment::STATUS_PENDING)
            ->latest('id')
            ->first();

        if ($pending) {
            return response()->json([
                'success' => true,
                'message' => 'You already have a pending payment for this plan.',
                'data' => $this->paymentPayload($pending),
            ]);
        }

        $payment = BookPayment::create([
            'user_id' => $user->id,
            'book_id' => null,
            'book_plan_id' => $bookPlan->id,
            'payment_type' => BookPayment::TYPE_PLAN,
            'status' => BookPayment::STATUS_PENDING,
            'amount' => $bookPlan->price,
            'currency' => $bookPlan->currency,
            'payment_method' => 'bank_transfer',
            'payment_reference' => $this->generateReference(),
            'notes' => 'Subscription to '.$bookPlan->name,
            'meta' => [
                'plan_name' => $bookPlan->name,
                'plan_slug' => $bookPlan->slug,
                'billing_cycle' => $bookPlan->billing_cycle,
            ],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Subscription started. Complete the bank transfer and upload your receipt.',
            'data' => $this->paymentPayload($payment),
        ], 201);
    }

    /**
     * GET /api/book-plans/payments
     * The authenticated user's subscription payments.
     */
    public function myPayments(Request $request)
    {
        $payments = BookPayment::where('user_id', $request->user()->id)
            ->whereIn('payment_type', [BookPayment::TYPE_PLAN, BookPayment::TYPE_SUBSCRIPTION])
            ->with('bookPlan')
            ->latest('id')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $payments->map(fn (BookPayment $payment) => $this->paymentPayload($payment))->values(),
        ]);
    }

    /**
     * POST /api/book-plans/payments/{payment}/receipt
     * Upload the bank transfer receipt for a pending subscription payment.
     */
    public function uploadReceipt(Request $request, BookPayment $payment)
    {
        $user = $request->user();

        if ($payment->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not allowed to update this payment.',
            ], 403);
        }

        if ($payment->status !== BookPayment::STATUS_PENDING) {
            return response()->json([
                'success' => false,
                'message' => 'This payment is not awaiting a receipt.',
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'receipt' => 'required|file|image|max:5120', // up to 5MB
            'payment_reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:2000',
        ]);
        $validator->validate();

        if ($payment->payment_receipt) {
            Storage::disk('public')->delete($payment->payment_receipt);
        }

        $path = $request->file('receipt')->store('receipts', 'public');

        $payment->payment_receipt = $path;
        $payment->payment_method = $payment->payment_method ?: 'bank_transfer';

        if ($request->filled('payment_reference')) {
            $payment->payment_reference = $request->get('payment_reference');
        }

        if ($request->filled('notes')) {
            $payment->notes = $request->get('notes');
        }

        $meta = $payment->meta ?: [];
        $meta['receipt_uploaded_at'] = now()->toIso8601String();
        $payment->meta = $meta;

        $payment->save();

        return response()->json([
            'success' => true,
            'message' => 'Receipt submitted successfully. Awaiting manual verification.',
            'data' => $this->paymentPayload($payment),
        ], 201);
    }

    /**
     * Reference the customer quotes when making the bank transfer.
     */
    private function generateReference(): string
    {
        return 'LEAC-'.strtoupper(Str::random(8));
    }

    /**
     * Uniform payload for a subscription payment.
     */
    private function paymentPayload(BookPayment $payment): array
    {
        return [
            'id' => $payment->id,
            'status' => $payment->status,
            'amount' => (float) $payment->amount,
            'currency' => $payment->currency,
            'payment_method' => $payment->payment_method,
            'payment_reference' => $payment->payment_reference,
            'notes' => $payment->notes,
            'rejection_reason' => $payment->rejection_reason,
            'has_receipt' => (bool) $payment->payment_receipt,
            'receipt_url' => $payment->payment_receipt
                ? Storage::disk('public')->url($payment->payment_receipt)
                : null,
            'paid_at' => optional($payment->paid_at)->toIso8601String(),
            'verified_at' => optional($payment->verified_at)->toIso8601String(),
            'created_at' => optional($payment->created_at)->toIso8601String(),
            'plan' => $payment->bookPlan ? [
                'id' => $payment->bookPlan->id,
                'name' => $payment->bookPlan->name,
                'slug' => $payment->bookPlan->slug,
                'description' => $payment->bookPlan->description,
                'price' => (float) $payment->bookPlan->price,
                'currency' => $payment->bookPlan->currency,
                'billing_cycle' => $payment->bookPlan->billing_cycle,
                'access_duration_days' => $payment->bookPlan->access_duration_days,
                'features' => $payment->bookPlan->features ?? [],
            ] : null,
            'bank' => $this->bankDetails(),
        ];
    }
}
