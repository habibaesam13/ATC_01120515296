<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\CategoryService;
class CategoryDashboardController extends Controller
{
    /*categories*/
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    public function index()
    {
        $categories = $this->categoryService->getAllCategories();

        if (!$categories) {
            return "No Categories found";
        }

        return view('Admin.dashboard', compact('categories'));
    }
    public function addCategory(){
        return view("Admin.categories.create");
    }
    public function storeCategory(Request $request){
        $category=$request->validate(
            ["name"=>'required|string|max:255']
        );
        $result = $this->categoryService->store($category);
        if($result){
            return redirect()->route('admin.dashboard')->with('success', "Category added successfully");
        }
        return back()->with('error', "Category is already exists");
    }
    public function updateCategory($id){
        $category = $this->categoryService->find($id);

    if (!$category) {
        return redirect()->route('admin.dashboard')->with('error', 'Category not found');
    }

    return view("Admin.categories.edit", compact('category'));
    }
    public function editCategory(Request $request,$id){
        $categoryName=$request->validate(
            ["name"=>'required|string|max:255']
        );
        $result=$this->categoryService->update($id,$categoryName);
        return $result? redirect()->route('admin.dashboard')->with('success', "Category added successfully"):
        back()->with('error', "Category is already exists");
    }

    public function destroyCategory($id){
        $result=$this->categoryService->destroy($id);
        return $result?redirect()->route('admin.dashboard')->with('success', "Category deleted successfully"):
        back()->with('error', "Category is already exists");
    }
}
