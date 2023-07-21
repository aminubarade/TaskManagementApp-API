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

Route::post('/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');

Route::group(['middleware' => ['auth']],function () {

});

//auth routes 

//all users APIs

Route::get('/users', [UserController::class, 'index']);
Route::get('/user/{user:username}', [UserController::class, 'show']);
Route::post('/user', [UserController::class, 'store']);
Route::put('user/{user:username}', [UserController::class, 'update']);
Route::delete('task/{task:task}', [TaskController::class, 'destroy']);


//Task APIs
Route::get('/tasks', [TaskController::class, 'index']);
Route::get('/task/{task:task}', [TaskController::class, 'show']);
Route::post('/task', [TaskController::class, 'store']);
Route::put('task/{task:task}', [TaskController::class, 'update']);
Route::delete('task/{task:task}', [TaskController::class, 'destroy']);


//Todo APIs
Route::get('/task/todos', [TodokController::class, 'index']);
Route::get('/task/{todo:todo}', [TodoController::class, 'show']);
Route::post('/task/todo', [TodoController::class, 'store']);
Route::put('task/{todo:todo}', [TodoController::class, 'update']);
Route::delete('task/{todo:todo}', [TodoController::class, 'destroy']);






