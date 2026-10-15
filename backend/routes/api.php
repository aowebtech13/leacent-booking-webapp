<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookReadingProgressController;
use App\Http\Controllers\CaseReminderController;
use App\Http\Controllers\ComplianceController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\NotificationController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::post('contact', [ContactController::class, 'sendEmail']);

Route::prefix('auth')->middleware('throttle:10,1')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::match(['get', 'post'], 'forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
    Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('resend-otp', [AuthController::class, 'resendOtp']);
});

// Payment webhook (must be outside auth middleware)
Route::post('payment/webhook', [PaymentController::class, 'webhook']);

// Public referral tracking
Route::get('referral/track/{code}', [ProfileController::class, 'trackReferralClick']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::prefix('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
        Route::post('change-password', [AuthController::class, 'changePassword']);
        Route::delete('user', [AuthController::class, 'destroy']);
    });

    // Profile routes
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show']);
        Route::put('/', [ProfileController::class, 'update']);
        Route::get('referral', [ProfileController::class, 'getReferralInfo']);
        Route::get('balance', [ProfileController::class, 'getBalance']);
        Route::get('transactions', [ProfileController::class, 'getWalletTransactions']);
    });

    // Customer (create-customers dashboard form) routes
    Route::prefix('customers')->group(function () {
        Route::get('/', [CustomerController::class, 'index']);
        Route::post('/', [CustomerController::class, 'store']);
        Route::put('{id}', [CustomerController::class, 'update']);
        Route::delete('{id}', [CustomerController::class, 'destroy']);
    });

    // Payment routes
    Route::prefix('payment')->group(function () {
        Route::get('methods', [PaymentController::class, 'methods']);
        Route::get('order/{id}', [PaymentController::class, 'order']);
        Route::post('initialize', [PaymentController::class, 'initializePayment']);
        Route::post('verify', [PaymentController::class, 'verify']);
        Route::post('upload-receipt', [PaymentController::class, 'uploadReceipt']);
    });

    // Notification routes
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index']);
        Route::get('/unread-count', [NotificationController::class, 'unreadCount']);
        Route::post('/{id}/read', [NotificationController::class, 'markAsRead']);
        Route::post('/read-all', [NotificationController::class, 'markAllAsRead']);
        Route::delete('/{id}', [NotificationController::class, 'destroy']);
    });

    // Admin routes (protected with admin middleware)
    Route::middleware('admin')->prefix('admin')->group(function () {
        // Dashboard
        Route::get('dashboard', [AdminController::class, 'dashboard']);

        // User management
        Route::prefix('users')->group(function () {

            Route::get('/', [AdminController::class, 'getUsers']);
            Route::get('online', [AdminController::class, 'getOnlineUsers']);
            Route::get('activity-logs', [AdminController::class, 'getActivityLogs']);
            Route::post('/', [AdminController::class, 'createUser']);
            Route::get('{id}', [AdminController::class, 'getUser']);
            Route::put('{id}', [AdminController::class, 'updateUser']);
            Route::delete('{id}', [AdminController::class, 'deleteUser']);
            Route::put('{id}/plan', [AdminController::class, 'updateUserPlan']);
        });

        // The Ledger - complete audit trail of all financial interactions.
        // Admins can view payments and accept/reject them.
        Route::get('transactions', [TransactionController::class, 'index']);
        Route::get('transactions/{id}', [TransactionController::class, 'show']);
        Route::post('transactions/{id}/accept', [TransactionController::class, 'accept']);
        Route::post('transactions/{id}/reject', [TransactionController::class, 'reject']);
        
        // Admin profile
        Route::prefix('profile')->group(function () {
            Route::get('/', [AdminController::class, 'getProfile']);
            Route::put('/', [AdminController::class, 'updateProfile']);
        });

        // Referral analytics removed from admin.
        // Route::prefix('referrals')->group(function () {
        //     Route::get('/', [AdminController::class, 'getReferralAnalytics']);
        //     Route::get('user/{userId}', [AdminController::class, 'getUserReferrals']);
        // });
    });
});

// Ecommerce (public read)

// Public category/product endpoints
Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{id}', [CategoryController::class, 'show']);

Route::get('tags', function () {
    return response()->json(['data' => []]);
});
Route::get('tags/{id}', function () {
    return response()->json(['data' => []]);
});

// Books catalog (public read)
Route::get('books', [BookController::class, 'index']);
Route::get('books/total', [BookController::class, 'total']);
Route::get('books/{id}', [BookController::class, 'show']);
Route::get('books/{id}/preview', [BookController::class, 'preview']);

// Protected book reading (requires active access)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('books/{id}/read', [BookController::class, 'read']);

    // Reading progress (save / resume position)
    Route::get('books/{id}/progress', [BookReadingProgressController::class, 'show']);
    Route::post('books/{id}/progress', [BookReadingProgressController::class, 'update']);
});

// Health check route
Route::get('health', function () {
    return response()->json([
        'success' => true,
        'message' => 'LivinusAPI is running',
        'timestamp' => now()->toISOString(),
    ]);
});
