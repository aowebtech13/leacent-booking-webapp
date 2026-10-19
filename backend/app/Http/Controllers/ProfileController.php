<?php

namespace App\Http\Controllers;

use App\Models\BookPayment;
use App\Models\BookReadingProgress;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user()->load(['profile', 'roles']);

        return response()->json([
            'success' => true,
            'data' => $user,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'full_name' => 'sometimes|string|max:255',
            'avatar_url' => ['sometimes', 'nullable', 'string', 'regex:/^(https?:\/\/|data:image\/)/i'],
            'phone' => 'sometimes|string|max:20',
            'company_name' => 'sometimes|string|max:255',
            'phone_number' => 'sometimes|string|max:20',
            'address' => 'sometimes|string|max:500',
            'about_me' => 'sometimes|string|max:2000',
            'facebook_url' => 'sometimes|url|max:255',
            'twitter_url' => 'sometimes|url|max:255',
            'linkedin_url' => 'sometimes|url|max:255',
        ]);

        $user = $request->user();
        $profile = $user->profile;

        $profile->update($request->only([
            'full_name',
            'avatar_url',
            'phone',
            'company_name',
            'phone_number',
            'address',
            'about_me',
            'facebook_url',
            'twitter_url',
            'linkedin_url',
        ]));

        return response()->json([
            'success' => true,
            'data' => $user->load(['profile', 'roles']),
            'message' => 'Profile updated successfully',
        ]);
    }

    public function getWalletTransactions(Request $request)
    {
        $walletTransactions = $request->user()->walletTransactions()
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $walletTransactions,
        ]);
    }

    /**
     * GET /api/profile/books-spending
     *
     * Money the authenticated user spent on books: lifetime total, the last
     * week compared to the week before, and a daily breakdown used by the
     * dashboard "Money Spent" chart.
     */
    public function getBooksSpending(Request $request)
    {
        $days = 30;

        $payments = BookPayment::where('user_id', $request->user()->id)
            ->where('status', BookPayment::STATUS_ACTIVE)
            ->get(['amount', 'currency', 'paid_at', 'created_at']);

        $currency = $payments->first()?->currency ?: 'NGN';

        $now = now();
        $lastWeekStart = $now->copy()->subDays(6)->startOfDay();
        $previousWeekStart = $now->copy()->subDays(13)->startOfDay();

        $series = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $series[$now->copy()->subDays($i)->format('Y-m-d')] = 0.0;
        }

        $lastWeek = 0.0;
        $previousWeek = 0.0;

        foreach ($payments as $payment) {
            $paidAt = $payment->paid_at ?: $payment->created_at;
            if (! $paidAt) {
                continue;
            }

            $amount = (float) $payment->amount;
            $date = $paidAt->format('Y-m-d');

            if (array_key_exists($date, $series)) {
                $series[$date] += $amount;
            }

            if ($paidAt->gte($lastWeekStart)) {
                $lastWeek += $amount;
            } elseif ($paidAt->gte($previousWeekStart)) {
                $previousWeek += $amount;
            }
        }

        $changePercent = null;
        if ($previousWeek > 0) {
            $changePercent = round((($lastWeek - $previousWeek) / $previousWeek) * 100, 1);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'total' => round((float) $payments->sum('amount'), 2),
                'currency' => $currency,
                'purchases' => $payments->count(),
                'last_week' => round($lastWeek, 2),
                'previous_week' => round($previousWeek, 2),
                'change_percent' => $changePercent,
                'series' => collect($series)
                    ->map(fn ($amount, $date) => [
                        'date' => $date,
                        'amount' => round($amount, 2),
                    ])
                    ->values(),
            ],
        ]);
    }

    /**
     * GET /api/profile/book-plan-transaction
     * Latest subscription book-plan payment for the authenticated user.
     */
    public function getLatestBookPlanTransaction(Request $request)
    {
        $payment = BookPayment::with(['bookPlan', 'user'])
            ->where('user_id', $request->user()->id)
            ->where('payment_type', BookPayment::TYPE_SUBSCRIPTION)
            ->whereIn('status', [BookPayment::STATUS_ACTIVE, BookPayment::STATUS_PENDING])
            ->latest('paid_at')
            ->first();

        return response()->json([
            'success' => true,
            'data' => $payment,
        ]);
    }

    /**
     * GET /api/profile/money-spent
     * Get total money spent by authenticated user on book payments.
     */
    public function getMoneySpent(Request $request)
    {
        $totalSpent = BookPayment::where('user_id', $request->user()->id)
            ->where('status', BookPayment::STATUS_ACTIVE)
            ->where('amount', '>', 0)
            ->sum('amount');

        return response()->json([
            'success' => true,
            'data' => [
                'total_spent' => (float) $totalSpent,
                'currency' => 'NGN',
            ],
        ]);
    }

    /**
     * GET /api/profile/book-reading-stats
     * Get book reading statistics for authenticated user.
     */
    public function getBookReadingStats(Request $request)
    {
        $user = $request->user();
        $completedBooks = BookReadingProgress::where('user_id', $user->id)
            ->where('is_completed', true)
            ->count();
        $inProgressBooks = BookReadingProgress::where('user_id', $user->id)
            ->where('is_completed', false)
            ->count();
        $totalReadingTime = BookReadingProgress::where('user_id', $user->id)
            ->sum('progress_percentage'); // just a placeholder metric if needed

        return response()->json([
            'success' => true,
            'data' => [
                'completed_books' => $completedBooks,
                'in_progress_books' => $inProgressBooks,
                'total_progress_entries' => BookReadingProgress::where('user_id', $user->id)->count(),
            ],
        ]);
    }
}
