<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KendaraanController;

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

});
