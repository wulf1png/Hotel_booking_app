<?php

use App\Http\Controllers\HotelBookingController;

Route::get('/', [HotelBookingController::class, 'index']);
Route::post('/', [HotelBookingController::class, 'index']);
