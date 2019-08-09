<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookStatController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('authors')->group(function() {
    Route::get('/', [AuthorController::class, 'index']);
    Route::post('/', [AuthorController::class, 'store']);
    Route::get('{author}', [AuthorController::class, 'show']);
    Route::put('{author}', [AuthorController::class, 'update']);
    Route::delete('{author}', [AuthorController::class, 'destroy']);
});

Route::prefix('books')->group(function() {
    Route::get('stat', BookStatController::class);

    Route::get('/', [BookController::class, 'index']);
    Route::post('/', [BookController::class, 'store']);
    Route::get('{book}', [BookController::class, 'show']);
    Route::put('{book}', [BookController::class, 'update']);
    Route::delete('{book}', [BookController::class, 'destroy']);
});
