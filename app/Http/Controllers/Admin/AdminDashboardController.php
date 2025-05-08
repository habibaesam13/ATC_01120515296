<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Services\EventService;
class AdminDashboardController extends Controller
{
    protected $categoryService;
    protected $eventService;

    public function __construct(CategoryService $categoryService,EventService $eventService)
    {
        $this->categoryService = $categoryService;
        $this->eventService=$eventService;
    }

    public function index()
    {
        $categories = $this->categoryService->getAllCategories();
        $events=$this->eventService->getAllEvents();
        return view('Admin.dashboard', compact(['categories','events']));
    }
}
