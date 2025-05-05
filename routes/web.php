<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
/* public routes */
Route::get('/', function () {
    return view('welcome');
});

Route::get("/login",function(){
    return view("Auth.login");
})->name("login");
Route::post("/login",[AuthController::class,"login"])->name("auth.login");

Route::get("/register",function(){
    return view("Auth.signup");
})->name("register");
Route::post("/register",[AuthController::class,"register"])->name("auth.register");

/* protected routes */

