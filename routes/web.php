<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('doctor', 'App\Http\Controllers\DoctorController')
    ->only([
        'index',
        ]);

Route::get('doctor/{id}/availabilities', 'App\Http\Controllers\AvailabilityController@index')
    ->name('availability.index');

Route::resource('booking', 'App\Http\Controllers\BookingController')
    ->only([
        'index',
        'store',
        ])
    ->middleware('auth');

Route::get('booking/{id}/cancel', 'App\Http\Controllers\BookingController@destroy')
    ->name('booking.destroy');


require __DIR__.'/auth.php';
