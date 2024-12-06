<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // This method will show all posts, with an optional filter by category and search by title or description
    public function index(Request $request)
    {
        $query = $request->input('query'); // Search term for title and description
        $categoryId = $request->input('category_id'); // Category filter

        // Get all categories
        $categories = Category::all();

        // Build the query with search and optional category filter
        $posts = Post::query()
            ->when($query, function ($queryBuilder) use ($query) {
                // Search in title and description fields
                return $queryBuilder->where('title', 'like', "%$query%")
                    ->orWhere('description', 'like', "%$query%");
            })
            ->when($categoryId, function ($queryBuilder) use ($categoryId) {
                // Apply category filter if it's provided
                return $queryBuilder->where('category_id', $categoryId);
            })
            ->paginate(10); // Use paginate() for paginated results

        return response()->json([
            'posts' => $posts,
            'categories' => $categories,
        ]);
    }

    // Store a newly created post in the database
    public function store(Request $request)
    {
        // Validate form data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video' => 'nullable|mimes:mp4,avi,mkv|max:20480',
            'status' => 'required|boolean',
            'tags' => 'nullable|string', // Tags field is optional and should be a string
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        // Handle video upload
        if ($request->hasFile('video')) {
            $validated['video'] = $request->file('video')->store('videos', 'public');
        }

        // Create the post
        $post = Post::create($validated);

        // Handle tags input (comma-separated)
        if ($request->tags) {
            $tags = explode(',', $request->tags);
            $tags = array_map('trim', $tags);

            foreach ($tags as $tagName) {
                // Create the tag if it doesn't exist
                $tag = Tag::firstOrCreate(['name' => $tagName]);

                // Attach the tag to the post
                $post->tags()->attach($tag);
            }
        }

        return response()->json([
            'message' => 'Post created successfully!',
            'post' => $post,
        ]);
    }

    // Show a specific post by ID
    public function show($id)
    {
        $post = Post::with('tags', 'category')->findOrFail($id);

        return response()->json($post);
    }

    // Update an existing post in the database
    public function update(Request $request, Post $post)
    {
        // Validate form data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video' => 'nullable|mimes:mp4,avi,mkv|max:20480',
            'status' => 'required|boolean',
            'tags' => 'nullable|string',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($post->image) {
                \Storage::delete('public/' . $post->image);
            }
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        // Handle video upload
        if ($request->hasFile('video')) {
            if ($post->video) {
                \Storage::delete('public/' . $post->video);
            }
            $validated['video'] = $request->file('video')->store('videos', 'public');
        }

        // Update the post
        $post->update($validated);

        // Handle tags input (comma-separated)
        if ($request->tags) {
            $tags = explode(',', $request->tags);
            $tags = array_map('trim', $tags);

            $post->tags()->sync([]);
            foreach ($tags as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $post->tags()->attach($tag);
            }
        }

        return response()->json([
            'message' => 'Post updated successfully!',
            'post' => $post,
        ]);
    }

    // Delete a post
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // Delete associated image and video if they exist
        if ($post->image) {
            \Storage::delete('public/' . $post->image);
        }

        if ($post->video) {
            \Storage::delete('public/' . $post->video);
        }

        // Delete the post
        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully!',
        ]);
    }
}
