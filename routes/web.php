<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CategoryDashboardController;

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


    Route::prefix('admin')->middleware([AuthMiddleware::class, RoleMiddleware::class . ':admin'])->group(function () {
        Route::get('/', [CategoryDashboardController::class, 'index'])->name('admin.dashboard');
        
        //add category
        Route::get("/categories/create",[CategoryDashboardController::class, 'addCategory'])->name('admin.categories.create');
        Route::post("/categories/create",[CategoryDashboardController::class, 'storeCategory'])->name('admin.categories.store');
        //update category
        Route::get("/categories/edit/{id}", [CategoryDashboardController::class, 'updateCategory'])->name('admin.categories.edit');
        Route::put("/categories/edit/{id}", [CategoryDashboardController::class, 'editCategory'])->name('admin.categories.update');
        //delet category
        Route::delete("/categories/delete/{id}",[CategoryDashboardController::class, 'destroyCategory'])->name('admin.categories.destroy');

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
//booking routes
Route::middleware([
    AuthMiddleware::class,
    RoleMiddleware::class . ':user',
])->group(function () {
    Route::get('/events/{eventId}', [EventController::class, 'show'])->name('events.show');  // Event details page
    Route::post('/events/{eventId}/book', [TicketController::class, 'book'])->name('tickets.book');  // Book event ticket
    Route::get('/booking/success', [TicketController::class, 'bookingSuccess'])->name('booking.success');  // Booking success page
    Route::delete('/events/{id}/unbook', [TicketController::class, 'unbook'])->name('ticket.unbook');
});


    //main page
    Route::middleware([
        AuthMiddleware::class,
        RoleMiddleware::class . ':user',
    ])->group(function () {
        Route::get('/homepage',[EventController::class,"index"])->name("home page");
    });