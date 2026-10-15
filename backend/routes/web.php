<?php

use App\Http\Controllers\AdminWebController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AdminWebController::class, 'showLogin'])->name('login');
        Route::post('login', [AdminWebController::class, 'login'])->name('login.submit');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('logout', [AdminWebController::class, 'logout'])->name('logout');
        Route::get('/', [AdminWebController::class, 'dashboard'])->name('dashboard');

        Route::get('users', [AdminWebController::class, 'users'])->name('users.index');
        Route::get('users/export', [AdminWebController::class, 'exportUsers'])->name('users.export');
        Route::get('users/create', [AdminWebController::class, 'createUser'])->name('users.create');
        Route::post('users', [AdminWebController::class, 'storeUser'])->name('users.store');
        Route::get('users/{user}', [AdminWebController::class, 'editUser'])->name('users.edit');
        Route::put('users/{user}', [AdminWebController::class, 'updateUser'])->name('users.update');
        Route::post('users/{user}/plan', [AdminWebController::class, 'updateUserPlan'])->name('users.plan');
        Route::delete('users/{user}', [AdminWebController::class, 'destroyUser'])->name('users.destroy');

        Route::get('subscriptions', [AdminWebController::class, 'subscriptions'])->name('subscriptions.index');
        Route::put('subscriptions/{subscription}', [AdminWebController::class, 'updateSubscription'])->name('subscriptions.update');

        Route::get('transactions', [AdminWebController::class, 'transactions'])->name('transactions.index');
        Route::get('transactions/export', [AdminWebController::class, 'exportTransactions'])->name('transactions.export');

        Route::get('orders', [AdminWebController::class, 'orders'])->name('orders.index');
        Route::get('orders/{order}', [AdminWebController::class, 'showOrder'])->name('orders.show');
        Route::put('orders/{order}/status', [AdminWebController::class, 'updateOrderStatus'])->name('orders.update-status');
        Route::get('orders/{order}/receipt', [AdminWebController::class, 'viewReceipt'])->name('orders.receipt');
        Route::post('orders/{order}/verify', [AdminWebController::class, 'verifyPayment'])->name('orders.verify');
         Route::post('orders/{order}/reject', [AdminWebController::class, 'rejectPayment'])->name('orders.reject');

        
        Route::get('activity-logs', [AdminWebController::class, 'activityLogs'])->name('activity-logs');
        Route::get('finances', [AdminWebController::class, 'finances'])->name('finances');

        Route::get('customers', [AdminWebController::class, 'customers'])->name('customers.index');
        Route::delete('customers/{customer}', [AdminWebController::class, 'destroyCustomer'])->name('customers.destroy');

        // Invoice
        Route::get('invoice-1', [App\Http\Controllers\InvoiceController::class, 'index'])->name('invoice_1');
        Route::get('invoice/{id}', [App\Http\Controllers\InvoiceController::class, 'show'])->name('invoice.show');

        Route::get('profile', [AdminWebController::class, 'profile'])->name('profile');
        Route::put('profile', [AdminWebController::class, 'updateProfile'])->name('profile.update');









        // Reports
        Route::get('reports/sales', [AdminWebController::class, 'reportsSales'])->name('reports.sales');
        Route::get('reports/sales-return', [AdminWebController::class, 'reportsSalesReturn'])->name('reports.sales_return');
        Route::get('reports/customer-order', [AdminWebController::class, 'reportsCustomerOrder'])->name('reports.customer_order');

        // Notifications (admin web)
        Route::prefix('notifications')->name('notifications.')->group(function () {
            Route::get('/', [NotificationController::class, 'index'])->name('index');
            Route::get('/unread-count', [NotificationController::class, 'unreadCount'])->name('unread-count');
            Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('mark-as-read');
            Route::post('/read-all', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
            Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
        });

    });
});


Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
    ->middleware(['signed'])
    ->name('verification.verify');
