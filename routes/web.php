<?php

use App\Http\Controllers;
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

Route::get('/', Controllers\DashboardController::class)->name('dashboard');
Route::get('/nuestros-servicios', [Controllers\ServiceController::class, 'index'])->name('services.index');
Route::get('/testimonios', [Controllers\TestimonyController::class, 'index'])->name('testimonies.index');

Route::get('/contacto', [Controllers\MessageController::class, 'index'])->name('messages.index');
Route::post('/contacto', [Controllers\MessageController::class, 'store'])->name('messages.store');

Route::middleware('auth')->group(function () {
   Route::get('/php-info', Controllers\PhpInfoController::class)->name('phpInfo');
});

require __DIR__.'/auth.php';
