<?php

namespace App\Http\Controllers\Api;


use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    // Get all categories
    public function index()
    {
        $categories = Category::all();
        return response()->json([
            'data' => $categories
        ], Response::HTTP_OK);
    }

    // Store a new category
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories,slug|max:255',
            'state' => 'required|boolean',
        ]);

        $category = Category::create($validated);

        return response()->json([
            'message' => 'Category created successfully!',
            'data' => $category
        ], Response::HTTP_CREATED);
    }

    // Get a single category
    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Category not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'data' => $category
        ], Response::HTTP_OK);
    }

    // Update a category
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Category not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories,slug,' . $category->id . '|max:255',
            'state' => 'required|boolean',
        ]);

        $category->update($validated);

        return response()->json([
            'message' => 'Category updated successfully!',
            'data' => $category
        ], Response::HTTP_OK);
    }

    // Delete a category
    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Category not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully!'
        ], Response::HTTP_NO_CONTENT);
    }

    public function postsByCategory($id){

        $posts =  Post::where('category_id',$id)->get();

        return response()->json([
            'data' => $posts
        ], Response::HTTP_OK);
    }
}
