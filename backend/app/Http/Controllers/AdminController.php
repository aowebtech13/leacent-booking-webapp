<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Profile;
use App\Models\Referral;
use App\Models\ReferralClick;
use App\Models\User;
use App\Models\UserRole;
use App\Models\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
   

    /**
     * Get admin dashboard statistics
     */
    public function dashboard()
    {
        $stats = [
            'total_admins' => User::whereHas('roles', function ($query) {
                $query->where('role', 'admin');
            })->count(),
            'recent_users' => User::with('profile')->latest()->take(5)->get(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }

    /**
     * Get all users with pagination and search
     */
    public function getUsers(Request $request)
    {
        $query = User::with(['profile', 'roles', 'activeSubscription', 'referrals']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('profile', function ($profile) use ($search) {
                        $profile->where('full_name', 'like', "%{$search}%")
                            ->orWhere('company_name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by role
        if ($request->has('role') && $request->role) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('role', $request->role);
            });
        }

        $users = $query->paginate($request->get('per_page', 15));

        $users->getCollection()->transform(function ($user) {
            $user->referral_count = $user->referrals()->where('status', 'completed')->count();

            return $user;
        });

        return response()->json([
            'success' => true,
            'data' => $users,
        ]);
    }

    /**
     * Get single user details
     */
    public function getUser($id)
    {
        $user = User::with(['profile', 'roles', 'subscriptions' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $user,
        ]);
    }

   

    /**
     * Update user
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:admin,user',

            // Profile fields
            'full_name' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
        ]);

        // Update user basic info
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->password) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        // Update profile
        $profileData = $request->only([
            'full_name', 'company_name', 'phone_number',
            'address', 'city', 'state', 'country',
        ]);

        if ($user->profile) {
            $user->profile->update($profileData);
        } else {
            $profileData['user_id'] = $user->id;
            Profile::create($profileData);
        }

        // Update role
        $user->roles()->delete(); // Remove existing roles
        UserRole::create([
            'user_id' => $user->id,
            'role' => $request->role,
        ]);

        return response()->json([
            'success' => true,
            'data' => $user->load(['profile', 'roles']),
            'message' => 'User updated successfully',
        ]);
    }

    /**
     * Delete user
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Don't allow deleting the last admin
        if ($user->isAdmin()) {
            $adminCount = User::whereHas('roles', function ($query) {
                $query->where('role', 'admin');
            })->count();

            if ($adminCount <= 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete the last admin user',
                ], 400);
            }
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully',
        ]);
    }

    /**
     * Get admin profile
     */
    public function getProfile(Request $request)
    {
        $admin = $request->user()->load(['profile', 'roles']);

        return response()->json([
            'success' => true,
            'data' => $admin,
        ]);
    }

    /**
     * Update admin profile
     */
    public function updateProfile(Request $request)
    {
        $admin = $request->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($admin->id)],
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',

            // Profile fields
            'full_name' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
        ]);

        // Verify current password if changing password
        if ($request->password) {
            if (! $request->current_password) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current password is required to change password',
                ], 400);
            }

            if (! Hash::check($request->current_password, $admin->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current password is incorrect',
                ], 400);
            }
        }

        // Update user basic info
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->password) {
            $userData['password'] = Hash::make($request->password);
        }

        $admin->update($userData);

        // Update profile
        $profileData = $request->only([
            'full_name', 'company_name', 'phone_number',
            'address', 'city', 'state', 'country',
        ]);

        if ($admin->profile) {
            $admin->profile->update($profileData);
        } else {
            $profileData['user_id'] = $admin->id;
            Profile::create($profileData);
        }

        return response()->json([
            'success' => true,
            'data' => $admin->load(['profile', 'roles']),
            'message' => 'Profile updated successfully',
        ]);
    }

   


    /**
     * Get user activity logs
     */
    public function getActivityLogs(Request $request)
    {
        $query = UserLog::with(['user.profile'])->latest();

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->has('action') && $request->action) {
            $query->where('action', $request->action);
        }

        $logs = $query->paginate($request->get('per_page', 20));

        return response()->json([
            'success' => true,
            'data' => $logs,
        ]);
    }

    /**
     * Get currently online users
     */
    public function getOnlineUsers()
    {
        // Consider a user online if they were seen in the last 5 minutes
        $onlineUsers = User::with(['profile', 'roles', 'activeSubscription'])
            ->where('last_seen_at', '>=', now()->subMinutes(5))
            ->orderBy('last_seen_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $onlineUsers,
        ]);
    }
}
