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

    // This request is used by Django api service to authorize its requests bearer tokens
    // by putting request in middlewares sanctum and verify admin, it performs neccesary checks.
    Route::post('/authorize-service-request', function(){
        return response()->json([ 'message' => 'Request authorized'], 201);
    })->name('service_authorization');
});
