<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use Illuminate\Support\Facades\Route;

// Create User (Admin)
Route::post('/register', [AuthController::class, 'register'])->middleware(['auth:sanctum', 'role:admin']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    // Book Management (Admin/Librarian)
    Route::middleware('role:admin|librarian')->group(function () {
        Route::post('/books', [BookController::class, 'store']);
        Route::put('/books/{id}', [BookController::class, 'update']);
        Route::delete('/books/{id}', [BookController::class, 'destroy']);
    });

    // Access Books
    Route::get('/books', [BookController::class, 'index']); // Available to all

    // Borrow Management (Admin/Member)
    Route::middleware('role:admin|member')->group(function () {
        Route::post('/borrow', [BorrowController::class, 'borrow']);
        Route::patch('/borrow/{id}/return', [BorrowController::class, 'returnBook']);
    });
});
