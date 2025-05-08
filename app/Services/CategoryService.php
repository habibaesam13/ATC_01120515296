<?php

namespace App\Services;

use App\Models\Category;
use GuzzleHttp\Psr7\Request;

class CategoryService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function getAllCategories()
    {
        $categories = Category::with('events') ->paginate(10);
        if ($categories->isEmpty()) {
            return "No Cateogy Found!";
        }
        return $categories;
    }
    public function store($newCategoryData){
        $existingCategory = Category::where('name', $newCategoryData['name'])->first();
        
        if ($existingCategory) {
            return -1;
        }

        // If no existing category, create a new one
        Category::create([
            'name' => $newCategoryData['name'],
        ]);

        return 1;
    }
    public function update($categoryId, $newName)
{
    $category = Category::find($categoryId);

    if (!$category) {
        return -1; // Category not found
    }

    // Check for duplicate name (case-insensitive), excluding current category
    $existingCategory = Category::whereRaw('LOWER(name) = ?', [strtolower($newName['name'])])
        ->where('id', '!=', $categoryId)
        ->first();

    if ($existingCategory) {
        return -2; // Name already exists in another category
    }

    $category->name = $newName['name'];
    $category->save();

    return 1;
}

    public function destroy($categoryId){
        $category = Category::find($categoryId);

        if (!$category) {
            return -1;
        } 
        $category->delete();
        return 1;
    }
    public function find($id)
    {
        return Category::find($id);
    }
    
    // public function getCategoryId($category){
    //     $categoryRecord = Category::where('name', $category)->first();
    //     return $categoryRecord?$categoryRecord->id:-1;
    // }
}
