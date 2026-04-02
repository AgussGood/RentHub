<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::prefix('admin/returns')->name('admin.returns.')->group(function () {
        Route::get('/', [ReturnController::class, 'adminIndex'])->name('index');
        Route::get('/{return}', [ReturnController::class, 'adminShow'])->name('show');
        Route::get('/{return}/inspect', [ReturnController::class, 'adminInspect'])->name('inspect');
        Route::post('/{return}/complete', [ReturnController::class, 'adminComplete'])->name('complete');
    });

    Route::prefix('admin/bookings')->name('admin.bookings.')->group(function () {
        Route::get('/', [BookingController::class, 'adminIndex'])->name('index');
        Route::get('/{booking}', [BookingController::class, 'adminShow'])->name('show');
        Route::post('/{booking}/update-status', [BookingController::class, 'updateStatus'])->name('updateStatus');
    });

    Route::prefix('admin/reviews')->name('admin.reviews.')->group(function () {
        Route::get('/', [ReviewController::class, 'adminIndex'])->name('index');
        Route::get('/{review}', [ReviewController::class, 'adminShow'])->name('show');
        Route::put('/{review}/update-status', [ReviewController::class, 'updateStatus'])->name('updateStatus');
        Route::delete('/{review}', [ReviewController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('kendaraan', KendaraanController::class);
    });
});

Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/welcome', [FrontController::class, 'index'])->name('welcome');
    Route::get('/cars', [FrontController::class, 'cars'])->name('cars');
    Route::get('/car/{kendaraan}', [FrontController::class, 'show'])->name('car.show');
    Route::get('/kendaraan/{kendaraan}', [FrontController::class, 'show'])->name('kendaraan.show');

    Route::get('bookings/history', [BookingController::class, 'history'])->name('bookings.history');
    Route::get('bookings/create/{kendaraan}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::put('bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

    Route::get('returns/create/{booking}', [ReturnController::class, 'create'])->name('returns.create');
    Route::post('returns', [ReturnController::class, 'store'])->name('returns.store');

    Route::get('reviews/create/{booking}', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('reviews', [ReviewController::class, 'store'])->name('reviews.store');

    Route::get('/returns/{return}/print', [ReturnController::class, 'print'])
        ->name('returns.print')
        ->middleware('auth');

});

Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::get('returns/{return}', [ReturnController::class, 'show'])->name('returns.show');

    Route::get('/payments/view/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    Route::get('/payments/{bookingId}', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');

    Route::post('/payments/midtrans/redirect/{bookingId}', [PaymentController::class, 'midtransRedirect'])
        ->name('payments.midtrans.redirect');
    Route::get('/payments/midtrans/success/{bookingId}', [PaymentController::class, 'midtransSuccess'])
        ->name('payments.midtrans.success');
    Route::get('/payments/midtrans/error/{bookingId}', [PaymentController::class, 'midtransError'])
        ->name('payments.midtrans.error');
    Route::get('/payments/midtrans/pending/{bookingId}', [PaymentController::class, 'midtransPending'])
        ->name('payments.midtrans.pending');

    Route::get('/payments/penalty/{returnId}', [PaymentController::class, 'createPenalty'])
        ->name('payments.penalty.create');
    Route::post('/payments/penalty/store', [PaymentController::class, 'storePenalty'])
        ->name('payments.penalty.store');
    Route::post('/payments/penalty/midtrans/{returnId}', [PaymentController::class, 'midtransPenaltyRedirect'])
        ->name('payments.penalty.midtrans.redirect');
    Route::get('/payments/penalty/midtrans/success/{returnId}', [PaymentController::class, 'midtransPenaltySuccess'])
        ->name('payments.penalty.midtrans.success');
    Route::get('/payments/penalty/midtrans/error/{returnId}', [PaymentController::class, 'midtransPenaltyError'])
        ->name('payments.penalty.midtrans.error');
    Route::get('/payments/penalty/midtrans/pending/{returnId}', [PaymentController::class, 'midtransPenaltyPending'])
        ->name('payments.penalty.midtrans.pending');
});

Route::post('/payments/midtrans/notification', [PaymentController::class, 'midtransNotification'])
    ->name('payments.midtrans.notification');

Route::post('/payments/penalty/midtrans/notification', [PaymentController::class, 'midtransPenaltyNotification'])
    ->name('payments.penalty.midtrans.notification');
