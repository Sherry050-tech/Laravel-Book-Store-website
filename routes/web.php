<?php
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\FeedbackController; // ⬅️ ADDED THIS
use Illuminate\Support\Facades\Route;

// ── Public Routes ─────────────────────────────────────────────
Route::get('/', [BookController::class, 'home'])->name('home');
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

// ── Auth Routes (Breeze) ──────────────────────────────────────
require __DIR__.'/auth.php';

// ── User Routes ───────────────────────────────────────────────
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/dashboard', [BookController::class, 'dashboard'])->name('dashboard');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{book}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::delete('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    // Profile
    Route::get('/profile', [OrderController::class, 'profile'])->name('profile');
    Route::patch('/profile', [OrderController::class, 'updateProfile'])->name('profile.update');

    // Feedback (User Side) ⬅️ ADDED THIS
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
});

// ── Admin Routes ──────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminBookController::class, 'dashboard'])->name('dashboard');

    // Books CRUD
    Route::resource('books', AdminBookController::class);

    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
    Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');

    // Users
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::patch('/users/{user}/toggle', [AdminUserController::class, 'toggle'])->name('users.toggle');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Feedbacks (Admin Side) ⬅️ ADDED THIS
    // Note: 'admin/' prefix and 'admin.' name are automatically added by the group!
    Route::get('/feedbacks', [FeedbackController::class, 'indexAdmin'])->name('feedbacks.index');
});