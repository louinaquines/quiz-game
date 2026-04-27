<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoomController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/rooms', [RoomController::class, 'create']);
    Route::post('/rooms/join', [RoomController::class, 'join']);
});

?>
