<?php

namespace App\Http\Controllers;

use App\Models\BookPayment;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user()->load(['profile', 'roles', 'referral']);

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
            'data' => $user->load(['profile', 'roles', 'referral']),
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
}
