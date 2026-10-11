<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
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
use App\Http\Controllers\Ecommerce\CategoryController;
use App\Http\Controllers\Ecommerce\ProductController;
use App\Http\Controllers\Ecommerce\TagController;
use App\Http\Controllers\Ecommerce\CartController;
use App\Http\Controllers\Ecommerce\OrderController;
use App\Http\Controllers\Ecommerce\AdminOrderController;
use App\Http\Controllers\Ecommerce\AdminPaymentController;


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
        Route::post('verify', [PaymentController::class, 'verifyPayment']);
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

Route::get('tags', [TagController::class, 'index']);
Route::get('tags/{id}', [TagController::class, 'show']);

Route::get('products', [ProductController::class, 'index']);
Route::get('products/total', [ProductController::class, 'total']);
Route::get('products/{id}', [ProductController::class, 'show']);
Route::get('products/{id}/related', [ProductController::class, 'related']);

// Books catalog (public read)
Route::get('books', [BookController::class, 'index']);
Route::get('books/total', [BookController::class, 'total']);
Route::get('books/{id}', [BookController::class, 'show']);
Route::get('books/{id}/preview', [BookController::class, 'preview']);

// Protected book reading (requires active access)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('books/{id}/read', [BookController::class, 'read']);
});

// Protected cart & orders
Route::middleware('auth:sanctum')->group(function () {
    Route::get('cart', [CartController::class, 'show']);
    Route::post('cart/items', [CartController::class, 'addItem']);
    Route::put('cart/items', [CartController::class, 'updateItem']);
    Route::delete('cart/items', [CartController::class, 'removeItem']);
    Route::delete('cart', [CartController::class, 'clear']);

    // Checkout page summary (computed cart totals, tax, shipping, payment methods)
    Route::get('checkout', [OrderController::class, 'checkout']);

    Route::get('orders', [OrderController::class, 'index']);
    Route::get('orders/{id}', [OrderController::class, 'show']);
    Route::post('orders', [OrderController::class, 'store']);
    Route::post('orders/{id}/pay', [OrderController::class, 'pay']);
    Route::post('orders/{id}/manual-payment', [OrderController::class, 'submitManualPayment']);
    Route::post('orders/{id}/cancel', [OrderController::class, 'cancel']);
    Route::post('orders/verify', [OrderController::class, 'verify']);
});

// Guest checkout (no authentication required)
Route::post('orders/guest', [OrderController::class, 'storeGuest']);
Route::post('orders/guest/{id}/pay', [OrderController::class, 'pay']);
Route::post('orders/guest/{id}/manual-payment', [OrderController::class, 'submitManualPayment']);
Route::post('orders/guest/{id}/cancel', [OrderController::class, 'cancel']);

// Admin ecommerce CRUD
Route::middleware('admin')->group(function () {
    Route::post('categories', [CategoryController::class, 'store']);
    Route::put('categories/{id}', [CategoryController::class, 'update']);
    Route::delete('categories/{id}', [CategoryController::class, 'destroy']);

    Route::post('tags', [TagController::class, 'store']);
    Route::put('tags/{id}', [TagController::class, 'update']);
    Route::delete('tags/{id}', [TagController::class, 'destroy']);

    Route::post('products', [ProductController::class, 'store']);
    Route::put('products/{id}', [ProductController::class, 'update']);
    Route::delete('products/{id}', [ProductController::class, 'destroy']);

    // Purchases submitted to the admin area
    Route::get('admin/orders/stats', [AdminOrderController::class, 'stats']);
    Route::get('admin/orders', [AdminOrderController::class, 'index']);
    Route::get('admin/orders/{id}', [AdminOrderController::class, 'show']);
    Route::put('admin/orders/{id}/status', [AdminOrderController::class, 'updateStatus']);

    // Manual payment verification
    Route::get('admin/payments', [AdminPaymentController::class, 'index']);
    Route::get('admin/payments/{id}', [AdminPaymentController::class, 'show']);
    Route::get('admin/payments/{id}/receipt', [AdminPaymentController::class, 'receipt']);
    Route::post('admin/payments/{id}/verify', [AdminPaymentController::class, 'verify']);
    Route::post('admin/payments/{id}/reject', [AdminPaymentController::class, 'reject']);
});

// Top products sales (weekly/monthly)
Route::middleware('auth:sanctum')->get('admin/top-products-sales', [\App\Http\Controllers\Ecommerce\TopProductsSalesController::class, '__invoke']);

// Health check route
Route::get('health', function () {
    return response()->json([
        'success' => true,
        'message' => 'LivinusAPI is running',
        'timestamp' => now()->toISOString(),
    ]);
});
