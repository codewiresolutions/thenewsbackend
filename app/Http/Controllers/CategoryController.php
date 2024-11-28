<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Show all categories
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    // Show the form for creating a new category
    public function create()
    {
        return view('categories.create');
    }

    // Create a new category
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories,slug|max:255',
            'state' => 'required|boolean',
        ]);

        // Create the category in the database
        Category::create($validated);

        // Redirect back to index page with a success message
        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }

    // Show the form for editing an existing category
    public function edit($id)
    {
        $category = Category::findOrFail($id);  // Find the category by ID, or throw a 404 error
        return view('categories.edit', compact('category'));
    }

    // Update an existing category
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories,slug,' . $category->id . '|max:255',
            'state' => 'required|boolean',
        ]);

        // Update the category in the database
        $category->update($validated);

        // Redirect back to index page with a success message
        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.show', compact('category'));
    }
    
    // Delete a category
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Delete the category
        $category->delete();

        // Redirect back to index page with a success message
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }
}
