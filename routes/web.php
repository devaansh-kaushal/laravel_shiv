<?php

use Illuminate\Support\Facades\Route;

use  App\Http\Controllers\UserController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[UserController::class,'getAllUser']);
Route::post('save',[UserController::class,'saveUser']);
Route::post('delete',[UserController::class,'deleteUser']);
Route::post('edit',[UserController::class,'editUser']);
