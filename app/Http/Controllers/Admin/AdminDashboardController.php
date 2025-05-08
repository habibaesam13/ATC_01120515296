<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Services\EventService;
use App\Services\UserService;
class AdminDashboardController extends Controller
{
    protected $categoryService;
    protected $eventService;
    protected $userService;

    public function __construct(CategoryService $categoryService,EventService $eventService,UserService $userService)
    {
        $this->categoryService = $categoryService;
        $this->eventService=$eventService;
        $this->userService=$userService;
    }

    public function index()
    {
        $categories = $this->categoryService->getAllCategories();
        $events=$this->eventService->getAllEvents();
        $users=$this->userService->getAllUsers();
        return view('Admin.dashboard', compact(['categories','events','users']));
    }
}
