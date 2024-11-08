<?php

use App\Http\Controllers\driveUserController;
use App\Http\Middleware\authMiddleware;
use Illuminate\Support\Facades\Route;

Route::post('sign-up',[driveUserController::class,'signUp']);
Route::post('login',[driveUserController::class,'login']);
Route::get('user',[driveUserController::class,'me'])->middleware(authMiddleware::class);
Route::get('logout',[driveUserController::class,'logout'])->middleware(authMiddleware::class);