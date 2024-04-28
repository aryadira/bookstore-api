<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\RentReturnController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);

//protected route
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::delete('/auth/logout', [AuthController::class, 'logout']);

    // books
    Route::get('/books', [BookController::class, 'index']);
    Route::post('/books', [BookController::class, 'store']);
    Route::get('/books/{id}', [BookController::class, 'show']);
    Route::put('/books/{id}', [BookController::class, 'update']);
    Route::delete('/books/{id}', [BookController::class, 'destroy']);

    // books by user
    Route::get('/users/{id}/books', [BookController::class, 'showByUser']);

    // rent by user
    Route::get('/users/rents', [RentController::class, 'showRentByUser']);
    Route::post('/users/rent-book/{book_id}', [RentController::class, 'storeRent']);
    Route::post('/users/return-book/{book_id}', [RentReturnController::class, 'returnRent']);

    // yg bisa cuma admin
    Route::middleware('restrictRole:admin')->group(function () {
        // Route::get('/users', [PostController::class, 'show'])->middleware('restrictRole:admin');
        // Route::put('/users/{id}', [PostController::class, 'update'])->middleware('restrictRole:moderator');
    });
});
