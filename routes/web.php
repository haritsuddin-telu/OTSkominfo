<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserTableController;
use App\Http\Controllers\OTSController;
use app\http\Controllers\RolePermissionController;
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
    'role:admin',
    'redirect.by.role',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    // Route::get('/table', function () {
    //     return view('table');
    // })->name('table');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:pegawai',
    'redirect.by.role',
])->group(function () {
    Route::get('/ots', [OTSController::class, 'form'])->name('ots.form');
    Route::post('/ots', [OTSController::class, 'store'])->name('ots.store');
    Route::get('/ots/{slug}', [OTSController::class, 'show'])->name('ots.show')->middleware('signed');
});

Route::get('/table', [UserTableController::class, 'index'])->name('table');
Route::get('/users', [UserTableController::class, 'index'])->name('users.index');
Route::get('/users/{id}/edit', [UserTableController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [UserTableController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserTableController::class, 'destroy'])->name('users.destroy');

// All protected routes already use 'auth:sanctum', config('jetstream.auth_session'), and 'verified' middleware.
// This ensures users are redirected to login if not authenticated.
// For extra clarity, add a fallback route for unauthorized access:

Route::fallback(function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    abort(404);
});