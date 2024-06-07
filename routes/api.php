<?php

use App\Http\Controllers\AuthenticationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\UserController;

Route::post('/login', [AuthenticationController::class, 'login'])->name('login');

Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout')->middleware('auth:sanctum');

Route::group(['middleware' => ['auth:sanctum', 'verify_admin_role:admin']], function () {
    Route::resource('/users', UserController::class);
    Route::resource('/authors', AuthorController::class);
    Route::resource('/books', BookController::class);
    Route::get('/export/authors/books', [ExportController::class, 'exportData']);
});
