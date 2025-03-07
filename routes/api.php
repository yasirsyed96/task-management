<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\TaskController;


Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});


Route::middleware('auth:sanctum')->group( function () {
    Route::resource('products', ProductController::class);

    Route::apiResource('tasks', TaskController::class);
    Route::post('/tasks/{task}/upload-image', [TaskController::class, 'uploadImage']);
    Route::get('/tasks/{task}/download-image', [TaskController::class, 'downloadImage']);
});

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
