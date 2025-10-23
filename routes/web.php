<?php

use App\Http\Controllers\PhoneController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('phone');
});

Route::post('/validate-phone', [PhoneController::class, 'validateAndLookup'])
    ->name('phone.validate');
