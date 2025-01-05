<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/createPerson', [App\Http\Controllers\Api\PersonController::class,'store']);
Route::get('/getAllPerson', [App\Http\Controllers\Api\PersonController::class,'index']);
Route::put('/updatePerson/{id}', [App\Http\Controllers\Api\PersonController::class,'update']);
Route::delete('/deletePerson/{id}', [App\Http\Controllers\Api\PersonController::class,'destroy']);
Route::get('/search/{search}', [App\Http\Controllers\Api\PersonController::class,'search']);