<?php

use App\Http\Controllers\driveUserController;
use Illuminate\Support\Facades\Route;

Route::post('sign-up',[driveUserController::class,'signUp']);