<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    // Display a list of all articles
    public function index()
    {
        $articles = Article::with('author')->get(); // Get all articles with their authors
        return response()->json($articles);
    }

    // Store a new article
    public function store(Request $request)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Image validation
            'video' => 'nullable|file|mimes:mp4,avi,mov,mkv|max:50000', // Video file validation
            'author_id' => 'required|exists:authors,id', // Ensure the author exists
        ]);

        // Handle image upload if present
        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('articles/images', 'public');
        }

        // Create the new article and associate it with the author
        $article = Article::create($validatedData);

        return response()->json(['message' => 'Article created successfully!', 'article' => $article], 201);
    }

    // Display a specific article
    public function show($id)
    {
        $article = Article::with('author')->find($id); // Load the article with its author

        if (!$article) {
            return response()->json(['message' => 'Article not found'], 404);
        }

        return response()->json($article);
    }

    // Update an existing article
    public function update(Request $request, $id)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Image validation
            'video' => 'nullable|file|mimes:mp4,avi,mov,mkv|max:50000', // Video file validation
            'author_id' => 'nullable|exists:authors,id', // Ensure the author exists
        ]);

        // Find the article by ID
        $article = Article::find($id);

        if (!$article) {
            return response()->json(['message' => 'Article not found'], 404);
        }

        // Handle image upload if present
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($article->image && Storage::exists('public/' . $article->image)) {
                Storage::delete('public/' . $article->image);
            }
            $validatedData['image'] = $request->file('image')->store('articles/images', 'public');
        }

        // Update the article and assign the author_id if provided
        $article->update($validatedData);

        return response()->json(['message' => 'Article updated successfully!', 'article' => $article]);
    }

    // Delete an article
    public function destroy($id)
    {
        $article = Article::find($id);

        if (!$article) {
            return response()->json(['message' => 'Article not found'], 404);
        }

        // Delete the image file if it exists
        if ($article->image && Storage::exists('public/' . $article->image)) {
            Storage::delete('public/' . $article->image);
        }

        // Delete the article
        $article->delete();

        return response()->json(['message' => 'Article deleted successfully']);
    }
}
