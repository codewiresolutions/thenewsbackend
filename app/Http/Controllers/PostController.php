<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // This method will show all posts, with an optional filter by category and search by title or description
    public function index(Request $request)
    {
        // Get the search term and category filter
        $query = $request->input('query');         // Search term for title and description
        $categoryId = $request->input('category_id');  // Category filter

        // Get all categories to show in the category dropdown
        $categories = Category::all();

        // Build the query with search and optional category filter
        $posts = Post::query()
            ->when($query, function($queryBuilder) use ($query) {
                // Search in title and description fields
                return $queryBuilder->where('title', 'like', "%$query%")
                                     ->orWhere('description', 'like', "%$query%");
            })
            ->when($categoryId, function($queryBuilder) use ($categoryId) {
                // Apply category filter if it's provided
                return $queryBuilder->where('category_id', $categoryId);
            })
            ->paginate(10);  // Use paginate() for paginated results

        // Pass both posts, categories, and the selected category to the view
        return view('posts.index', compact('posts', 'categories'));
    }

    // Show the form for creating a new post
    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    // Store a newly created post in the database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video' => 'nullable|mimes:mp4,avi,mkv|max:20480',
            'status' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        if ($request->hasFile('video')) {
            $validated['video'] = $request->file('video')->store('videos', 'public');
        }

        Post::create($validated);

        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }

    // Show the form for editing an existing post
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    // Show a specific post by ID
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show', compact('post'));
    }

    // Update an existing post in the database
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video' => 'nullable|mimes:mp4,avi,mkv|max:20480',
            'status' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($post->image) {
                \Storage::delete('public/' . $post->image);
            }
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        if ($request->hasFile('video')) {
            if ($post->video) {
                \Storage::delete('public/' . $post->video);
            }
            $validated['video'] = $request->file('video')->store('videos', 'public');
        }

        $post->update($validated);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully!');
    }

    // Delete a post
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if ($post->image) {
            \Storage::delete('public/' . $post->image);
        }

        if ($post->video) {
            \Storage::delete('public/' . $post->video);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully!');
    }
}
