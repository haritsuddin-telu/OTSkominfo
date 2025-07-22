<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserTableController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    // Route::get('/table', function () {
    //     return view('table');
    // })->name('table');
});


Route::get('/table', [UserTableController::class, 'index'])->name('table');
Route::get('/users', [UserTableController::class, 'index'])->name('users.index');
Route::get('/users/{id}/edit', [UserTableController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [UserTableController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserTableController::class, 'destroy'])->name('users.destroy');