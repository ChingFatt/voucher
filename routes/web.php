<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Vouchers;
use App\Http\Livewire\Locations;

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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('voucher', Vouchers::class)->name('voucher');

Route::get('location', Locations::class)->name('location');