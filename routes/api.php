<?php

use App\Http\Controllers\customerController;
use Illuminate\Support\Facades\Route;

Route::get('/customers',[customerController::class, 'index']);

Route::get('/customers/{id}', [customerController::class,'show']);

Route::post('/customers', [customerController::class,'store']);

Route::put('/customers/{id}',[customerController::class,'update'] );

Route::patch('/customers/{id}',[customerController::class,'updatePartial'] );

Route::delete('/customers/{id}', [customerController::class,'destroy']);
