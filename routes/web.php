<?php

use App\Http\Controllers\RazorpayController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/home', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified', 'role:user'])->name('dashboard');

require __DIR__.'/auth.php';


Route::middleware(['auth', 'role:user', 'verified'])->group(function(){
    Route::post('/payment', [RazorpayController::class, 'make_payment'])->name('make-payment');
    // Route::post('/payment', [RazorpayController::class, 'showPaymentPage']);
});

Route::post('/razorpay-hook', [RazorpayController::class, 'hook']);
