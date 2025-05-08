<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\system\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\system\EventController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
/* public routes */

Route::get('/', function () {
    return view("Auth.login") ;
});

Route::get("/login", function () {
    return view("Auth.login");
})->name("login");
Route::post("/login", [AuthController::class, "login"])->name("auth.login");

Route::get("/register", function () {
    return view("Auth.signup");
})->name("register");
Route::post("/register", [AuthController::class, "register"])->name("auth.register");
Route::post('logout', [authController::class, 'logout'])->name('logout');

/* protected routes */

    //Admin Routes
    Route::prefix('admin')->middleware([AuthMiddleware::class, RoleMiddleware::class . ':admin'])->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // Category routes
    Route::get("/categories/create", [CategoryController::class, 'create'])->name('categories.create');
    Route::post("/categories/create", [CategoryController::class, 'store'])->name('categories.store');
    Route::get("/categories/edit/{id}", [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put("/categories/edit/{id}", [CategoryController::class, 'update'])->name('categories.update');
    Route::delete("/categories/delete/{id}", [CategoryController::class, 'destroy'])->name('categories.destroy');

        // Event routes
    Route::get("/events/show/{id}",[EventController::class, 'show'])->name('events.show');
    Route::get("/events/create", [EventController::class, 'create'])->name('events.create');
    Route::post("/events/create", [EventController::class, 'store'])->name('events.store');
    Route::get("/events/edit/{id}",[EventController::class, 'edit'])->name('events.edit');
    route::put("/events/edit/{id}",[EventController::class, 'update'])->name('events.update');
    Route::delete('/events/delete/{id}',[EventController::class, 'destroy'])->name('events.destroy');

    //user routes
    Route::get("/users/show/{id}",[UserController::class, 'show'])->name('users.show');
    Route::get("/users/create", [UserController::class, 'create'])->name('users.create');
    Route::post("/users/create", [UserController::class, 'store'])->name('users.store');
    Route::get("/users/edit/{id}",[UserController::class, 'edit'])->name('users.edit');
    Route::put("/users/edit/{id}",[UserController::class, 'update'])->name('users.update');
    Route::delete('/users/delete/{id}',[UserController::class, 'destroy'])->name('users.destroy');

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



//main page
    Route::middleware([
        AuthMiddleware::class,
        RoleMiddleware::class . ':user',
    ])->group(function () {
        Route::get('/homepage',[EventController::class,"index"])->name("home page");
    });