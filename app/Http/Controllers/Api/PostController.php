<?php

namespace App\Http\Controllers\Api; // Correct namespace

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    // Show the list of posts (replacing the "index" method to return JSON)
    public function index(Request $request)
    {
        // Get the search term and category filter (now using category name)
        $query = $request->input('query');         // Search term for title and description
        $categoryName = $request->input('category_name');  // Category name filter
    
        // Build the query with search and optional category name filter
        $postsQuery = Post::query()
            ->when($query, function($queryBuilder) use ($query) {
                // Search in title and description fields
                return $queryBuilder->where('title', 'like', "%$query%")
                                     ->orWhere('description', 'like', "%$query%");
            })
            ->when($categoryName, function($queryBuilder) use ($categoryName) {
                // Join posts with categories and filter by category name
                return $queryBuilder->whereHas('category', function($query) use ($categoryName) {
                    $query->where('name', 'like', "%$categoryName%");  // Assuming 'name' is the category name field
                });
            });
    
        // Retrieve the posts (without pagination for now, you can use paginate() if needed)
        $posts = $postsQuery->get();
    
        // Return the posts data as a JSON response
        return response()->json([
            'posts' => $posts
        ]);
    }
    
    

    // Show the form for creating a new post (This is a typical form, so no change required)
    public function create()
    {
        $categories = Category::all(); // Get all categories
        return response()->json($categories); // Return categories as JSON response
    }

    // Store a newly created post in the database
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Validate image
            'video' => 'nullable|mimes:mp4,avi,mkv|max:20480',  // Validate video file types and size
            'status' => 'required|boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        // Handle video upload
        if ($request->hasFile('video')) {
            $validated['video'] = $request->file('video')->store('videos', 'public');
        }

        // Create the post using the validated data
        $post = Post::create($validated);

        // Return the created post as JSON response with status code 201 (Created)
        return response()->json($post, 201);
    }

    // Show a specific post by ID
    public function show($id)
    {
        $post = Post::findOrFail($id); // Find post by ID

        // Return the post data as a JSON response
        return response()->json($post);
    }

    public function update(Request $request, $id)
    {
        // Debugging removed dd() call
        $post = Post::findOrFail($id); // Find the post by its ID
    
        // Validate the incoming request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'video' => 'nullable|mimes:mp4,avi,mkv|max:20480',
            'status' => 'required|boolean',
        ]);
    
        // Handle image upload (delete old image if exists)
        if ($request->hasFile('image')) {
            if ($post->image) {
                \Storage::delete('public/' . $post->image); // Delete the old image
            }
            $validated['image'] = $request->file('image')->store('images', 'public');
        }
    
        // Handle video upload (delete old video if exists)
        if ($request->hasFile('video')) {
            if ($post->video) {
                \Storage::delete('public/' . $post->video); // Delete the old video
            }
            $validated['video'] = $request->file('video')->store('videos', 'public');
        }
    
        // Update the post with validated data
        $post->update($validated);
    
        // Return the updated post as a JSON response
        return response()->json($post);
    }
    

    // Delete a post
    public function destroy($id)
    {
        $post = Post::findOrFail($id); // Find the post by its ID

        // Delete the image file if it exists
        if ($post->image) {
            \Storage::delete('public/' . $post->image);
        }

        // Delete the video file if it exists
        if ($post->video) {
            \Storage::delete('public/' . $post->video);
        }

        // Delete the post
        $post->delete();

        // Return a success message as JSON response
        return response()->json(['message' => 'Post deleted successfully']);
    }
}
