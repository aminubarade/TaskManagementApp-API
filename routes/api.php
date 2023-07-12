<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;






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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); 

Route::post('/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');

Route::middleware(['api'])->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/user/{user:username}', [UserController::class, 'show']);
    Route::post('/user', [UserController::class, 'store']);
    Route::put('user/{user:username}', [UserController::class, 'update']);
});

//auth routes 

//all users APIs


//Task APIs


//Todo APIs



// Route::middleware('api')->group(function () {
//     Route::get('/users', [UserController::class, 'index']);
// });


