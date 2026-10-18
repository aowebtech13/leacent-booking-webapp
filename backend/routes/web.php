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


        // Books management
        Route::prefix('books')->name('books.')->group(function () {
            Route::get('/', [AdminWebController::class, 'books'])->name('index');
            Route::get('create', [AdminWebController::class, 'createBook'])->name('create');
            Route::post('/', [AdminWebController::class, 'storeBook'])->name('store');
            Route::get('{book}', [AdminWebController::class, 'editBook'])->name('edit');
            Route::put('{book}', [AdminWebController::class, 'updateBook'])->name('update');
            Route::delete('{book}', [AdminWebController::class, 'destroyBook'])->name('destroy');
        });

        // Authors management
        Route::prefix('authors')->name('authors.')->group(function () {
            Route::get('/', [AdminWebController::class, 'authors'])->name('index');
            Route::get('create', [AdminWebController::class, 'createAuthor'])->name('create');
            Route::post('/', [AdminWebController::class, 'storeAuthor'])->name('store');
            Route::get('{author}', [AdminWebController::class, 'editAuthor'])->name('edit');
            Route::put('{author}', [AdminWebController::class, 'updateAuthor'])->name('update');
        Route::delete('{author}', [AdminWebController::class, 'destroyAuthor'])->name('destroy');
    });

        // Categories (admin web) - uses dedicated web controller that returns Blade redirects.
        Route::get('categories', [\App\Http\Controllers\Ecommerce\AdminCategoryWebController::class, 'index'])->name('categories.index');
        Route::get('categories/create', [\App\Http\Controllers\Ecommerce\AdminCategoryWebController::class, 'create'])->name('categories.create');
        Route::post('categories', [\App\Http\Controllers\Ecommerce\AdminCategoryWebController::class, 'store'])->name('categories.store');
        Route::get('categories/{id}/edit', [\App\Http\Controllers\Ecommerce\AdminCategoryWebController::class, 'edit'])->name('categories.edit');
        Route::put('categories/{id}', [\App\Http\Controllers\Ecommerce\AdminCategoryWebController::class, 'update'])->name('categories.update');
        Route::delete('categories/{id}', [\App\Http\Controllers\Ecommerce\AdminCategoryWebController::class, 'destroy'])->name('categories.destroy');
        Route::post('categories/update-orders', [\App\Http\Controllers\Ecommerce\AdminCategoryWebController::class, 'updateOrders'])->name('categories.update.orders');

        // Invoice
        Route::get('invoice-1', [App\Http\Controllers\InvoiceController::class, 'index'])->name('invoice_1');
        Route::get('invoice/{id}', [App\Http\Controllers\InvoiceController::class, 'show'])->name('invoice.show');

        Route::get('profile', [AdminWebController::class, 'profile'])->name('profile');
        Route::put('profile', [AdminWebController::class, 'updateProfile'])->name('profile.update');









        // Reports
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
