<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    // Show the list of posts (with search and category filters)
    public function index(Request $request)
    {
        $query = $request->input('query'); // Search term for title and description
        $categoryName = $request->input('category_name'); // Category name filter
        $filter = $request->input('filter'); // Optional filter: 'last_month', 'current_month', 'last_year'

        $postsQuery = Post::query()
            ->when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where('title', 'like', "%$query%")
                    ->orWhere('description', 'like', "%$query%");
            })
            ->when($categoryName, function ($queryBuilder) use ($categoryName) {
                return $queryBuilder->whereHas('category', function ($query) use ($categoryName) {
                    $query->where('name', 'like', "%$categoryName%");
                });
            })
            ->when($filter, function ($queryBuilder) use ($filter) {
                $date = Carbon::now();

                switch ($filter) {
                    case 'last_month':
                        $startOfLastMonth = $date->copy()->subMonth()->startOfMonth();
                        $endOfLastMonth = $date->copy()->subMonth()->endOfMonth();
                        return $queryBuilder->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth]);

                    case 'current_month':
                        $startOfCurrentMonth = $date->copy()->startOfMonth();
                        $endOfCurrentMonth = $date->copy()->endOfMonth();
                        return $queryBuilder->whereBetween('created_at', [$startOfCurrentMonth, $endOfCurrentMonth]);

                    case 'last_year':
                        $startOfLastYear = $date->copy()->subYear()->startOfYear();
                        $endOfLastYear = $date->copy()->subYear()->endOfYear();
                        return $queryBuilder->whereBetween('created_at', [$startOfLastYear, $endOfLastYear]);

                    default:
                        return $queryBuilder;
                }
            });

        $posts = $postsQuery->get();

        return response()->json(['posts' => $posts]);
    }

    // Store a newly created post in the database
    public function store(Request $request)
    {
        // Log the incoming request data to check what is being sent
        \Log::info('Request Data:', $request->all());

        // Validate the incoming request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video' => 'nullable|mimes:mp4,avi,mkv|max:20480',
            'status' => 'required|boolean',
            'tags' => 'nullable|array',  // tags field should be an array
            'tags.*' => 'exists:tags,id', // individual tag IDs should exist in the tags table
        ]);

        // Handle image upload if exists
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        // Handle video upload if exists
        if ($request->hasFile('video')) {
            $validated['video'] = $request->file('video')->store('videos', 'public');
        }

        // Create the post using the validated data
        $post = Post::create($validated);

        // Attach tags to the post if tags are provided
        if (!empty($validated['tags'])) {
            $post->tags()->sync($validated['tags']);
        }

        // Return the created post as JSON response with status code 201 (Created)
        return response()->json($post->load('tags'), 201);
    }

    // Show a specific post by ID
    public function show($id)
    {
        $post = Post::with('tags')->findOrFail($id); // Eager load tags

        return response()->json($post);
    }

    // Update an existing post
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        // Validate the incoming request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'video' => 'nullable|mimes:mp4,avi,mkv|max:20480',
            'status' => 'required|boolean',
            'tags' => 'array|exists:tags,id' // Add this line to validate tags
        ]);

        // Handle image upload (delete old image if exists)
        if ($request->hasFile('image')) {
            if ($post->image) {
                \Storage::delete('public/' . $post->image);
            }
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        // Handle video upload (delete old video if exists)
        if ($request->hasFile('video')) {
            if ($post->video) {
                \Storage::delete('public/' . $post->video);
            }
            $validated['video'] = $request->file('video')->store('videos', 'public');
        }

        // Update the post with validated data
        $post->update($validated);

        // Attach the tags to the post (many-to-many relationship)
        if ($request->has('tags')) {
            $post->tags()->sync($request->tags); // Sync the tags (attach new and detach removed)
        }

        return response()->json($post);
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

        return response()->json(['message' => 'Post deleted successfully']);
    }
}
