<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;  
use App\Http\Controllers\AuthController;  

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('refresh', [AuthController::class, 'refresh']);

// Các route yêu cầu xác thực JWT
Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'getAuthenticatedUser']);
    
    Route::post('/addTask', [TaskController::class, 'addTask']);
    
    Route::get('/getTask/{id}', [TaskController::class, 'getTask']);
    Route::put('/updateTask', [TaskController::class, 'updateTask']);
    Route::put('/updateStateTask', [TaskController::class, 'updateStateTask']);
    Route::put('/deleteTask', [TaskController::class, 'deleteTask']);
    Route::get('/searchTask', [TaskController::class, 'searchTask']);
    Route::get('/getTasks', [TaskController::class, 'getTasks']);
});
