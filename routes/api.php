<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TodoController;






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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// }); 

Route::post('/register', [AuthController::class, 'registerUser']);
Route::post('/login', [AuthController::class, 'login']);


Route::group(['middleware' => 'auth:api'], function() {
    Route::post('/logout', [AuthController::class, 'logout']);
});


Route::group(['middleware' => 'auth:api'], function() {
   
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'getAllUsers']);
        Route::get('/view/{id}', [UserController::class, 'viewUser']);
        Route::put('update/{id}', [UserController::class, 'updateUser']);
        Route::delete('/delete/{id}', [UserController::class, 'deleteUser']);
    });


    Route::prefix('tasks')->group(function () {
        Route::post('/create', [TaskController::class, 'createTask']);
        Route::get('/', [TaskController::class, 'getAllTasks']);
        Route::get('/view/{id}', [TaskController::class, 'viewTask']);
        Route::put('/update/{id}', [TaskController::class, 'updateTask']);
        Route::delete('/delete/{id}', [TaskController::class, 'deleteTask']);
        Route::patch('/disable-task/{id}', [TaskController::class, 'disableTask']);
    });


    Route::prefix('todos')->group(function () {
        Route::get('/', [UserController::class, 'getAllTodos']);
        
    });











});







