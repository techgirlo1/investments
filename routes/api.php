<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvestmentController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// User Registration
Route::post('/register', [AuthController::class, 'register'])->name('register');

// User Login
 Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:api')->group(function () {
     // User Profile
       Route::get('/profile', [AuthController::class, 'profile'])->name('profile');

     // investment
       Route::post('/investments', [InvestmentController::class, 'create']);
       Route::get('/investments', [InvestmentController::class, 'showInvestments']);
 
    });

//User interface and Repository injection
Route::get('/users', [AuthController::class, 'index']);
Route::get('/users/{userId}', [AuthController::class, 'userById']);

//Investment interface and repository injection
Route::get('/investments', [InvestmentController::class, 'index']);
Route::get('/investments/{investmentId}', [InvestmentController::class, 'investmentById']);
