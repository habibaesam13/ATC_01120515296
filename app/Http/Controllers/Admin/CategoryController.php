<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function create()
    {
        return view("Admin.categories.create");
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => 'required|string|max:255'
        ]);

        $result = $this->categoryService->store($data);

        return $result === 1
            ? redirect()->route('admin.dashboard')->with('success', "Category added successfully")
            : back()->with('error', "Category already exists");
    }

    public function edit($id)
    {
        $category = $this->categoryService->find($id);

        return $category
            ? view("Admin.categories.edit", compact('category'))
            : redirect()->route('admin.dashboard')->with('error', 'Category not found');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            "name" => 'required|string|max:255'
        ]);

        $result = $this->categoryService->update($id, $data);

        if ($result === 1) {
            return redirect()->route('admin.dashboard')->with('success', "Category updated successfully");
        } elseif ($result === -2) {
            return back()->with('error', "A category with that name already exists");
        } else {
            return back()->with('error', "Category not found");
        }
    }

    public function destroy($id)
    {
        $result = $this->categoryService->destroy($id);

        return $result === 1
            ? redirect()->route('admin.dashboard')->with('success', "Category deleted successfully")
            : back()->with('error', "Category not found");
    }
}
