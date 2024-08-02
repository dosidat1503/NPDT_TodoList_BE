<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController; // Add this line to import the TaskController class

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

Route::post('/saveTask', [TaskController::class, 'saveTask']);
Route::get('/getTasks', [TaskController::class, 'getTasks']);
Route::put('/updateTask', [TaskController::class, 'updateTask']); 
Route::put('/updateStateTask', [TaskController::class, 'updateStateTask']);
Route::put('/deleteTask', [TaskController::class, 'deleteTask']);