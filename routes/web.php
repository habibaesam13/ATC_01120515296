<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use GuzzleHttp\Middleware;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\RoleMiddleware;

/* public routes */

Route::get('/', function () {
    return view('welcome');
});

Route::get("/login", function () {
    return view("Auth.login");
})->name("login");
Route::post("/login", [AuthController::class, "login"])->name("auth.login");

Route::get("/register", function () {
    return view("Auth.signup");
})->name("register");
Route::post("/register", [AuthController::class, "register"])->name("auth.register");

/* protected routes */
    //Admin Routes
Route::prefix("/admin")->middleware([
    AuthMiddleware::class,
    RoleMiddleware::class . ':admin',
])->group(function () {
    Route::get('/dashboard', function(){
        return view("Admin.dashboard");
    })->name("admin.dashboard");
});
    //User Routes
Route::prefix("/user")->middleware([
    AuthMiddleware::class,
    RoleMiddleware::class . ':user',
])->group(function () {
    Route::get('/dashboard', function(){
        return view("User.dashboard");
    })->name("user.dashboard");
});