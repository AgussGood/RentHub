<?php
use App\Http\Controllers\Api\BookingApiController;
use App\Http\Controllers\Api\PaymentApiController;
use App\Http\Controllers\Api\ProfileApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReturnController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'apiLogin']);
Route::post('/register', [AuthController::class, 'apiRegister']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'apiLogout']);

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::apiResource('kendaraan', KendaraanController::class)
        ->names([
            'index'   => 'api.kendaraan.index',
            'store'   => 'api.kendaraan.store',
            'show'    => 'api.kendaraan.show',
            'update'  => 'api.kendaraan.update',
            'destroy' => 'api.kendaraan.destroy',
        ]);
});

Route::get('/kendaraan', [KendaraanController::class, 'index']);
Route::get('/kendaraan/{kendaraan}', [KendaraanController::class, 'show']);

Route::get('/image/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);
    if (! file_exists($fullPath)) {
        abort(404);
    }
    $mimeType = mime_content_type($fullPath);
    return response()->file($fullPath, [
        'Access-Control-Allow-Origin' => '*',
        'Content-Type'                => $mimeType,
    ]);
})->where('path', '.*');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/customer/dashboard', [AuthController::class, 'apiCustomerDashboard']);
    Route::get('/profile', [ProfileApiController::class, 'show']);
    Route::post('/profile/update', [ProfileApiController::class, 'update']);
    Route::put('/profile/password', [ProfileApiController::class, 'updatePassword']);

    Route::post('/bookings', [BookingApiController::class, 'store']);
    Route::get('/bookings/history', [BookingApiController::class, 'history']);
    Route::post('/bookings/{id}/cancel', [BookingApiController::class, 'cancel']);

    Route::prefix('payments')->group(function () {
        Route::post('/', [PaymentApiController::class, 'store']);
        Route::post('/midtrans/{bookingId}', [PaymentApiController::class, 'midtransToken']);
        Route::get('/{bookingId}', [PaymentApiController::class, 'show']);
    });
    
Route::get('/reviews', [ReviewController::class, 'apiIndex']);

});

Route::middleware('auth:sanctum')->prefix('returns')->group(function () {
    Route::get('/', [ReturnController::class, 'index']);
    Route::post('/', [ReturnController::class, 'apiStore']);
    Route::get('/{id}', [ReturnController::class, 'apiShow']);
    Route::post('/{id}/penalty/pay', [ReturnController::class, 'payPenalty']);
});
