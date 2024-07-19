<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/product',  [ApiController::class, 'index']);
Route::post('/product',  [ApiController::class, 'store']);