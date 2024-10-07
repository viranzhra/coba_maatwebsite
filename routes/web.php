<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::post('/users', [UserController::class, 'preview'])->name('users.preview');
Route::get('users-export', [UserController::class, 'export'])->name('users.export');
Route::post('users-import', [UserController::class, 'import'])->name('users.import');
// Route::post('/users', [UserController::class, 'preview'])->name('users.preview');


Route::get('/', function () {
    return view('welcome');
});
