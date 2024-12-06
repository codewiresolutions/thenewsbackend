<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    // Show a list of all authors
    public function index()
    {
        $authors = Author::all(); // Get all authors
        return response()->json($authors);
    }

    // Show the form for creating a new author (if applicable)
    public function create()
    {
        // For API-based systems, this might just return a view or something else, but for API it could be a simple response
        return response()->json(['message' => 'Create author form']);
    }

    // Store a newly created author in storage
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'picture' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|email|unique:authors,email', // Ensure email is unique
        ]);

        // Create the new author using validated data
        $author = Author::create($validatedData);

        return response()->json(['message' => 'Author created successfully!', 'author' => $author], 201);
    }

    // Display the specified author
    public function show($id)
    {
        // Find author by ID or return a 404 error if not found
        $author = Author::find($id);

        if (!$author) {
            return response()->json(['message' => 'Author not found'], 404);
        }

        return response()->json($author);
    }

    // Show the form for editing the specified author (if applicable)
    public function edit($id)
    {
        // Return form details (if needed for a web app), for API you might not need this
        $author = Author::find($id);

        if (!$author) {
            return response()->json(['message' => 'Author not found'], 404);
        }

        return response()->json($author);
    }

    // Update the specified author in storage
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'picture' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|email|unique:authors,email,' . $id, // Ignore email uniqueness for the current author
        ]);

        // Find the author by ID or return 404 if not found
        $author = Author::find($id);

        if (!$author) {
            return response()->json(['message' => 'Author not found'], 404);
        }

        // Update the author's data
        $author->update($validatedData);

        return response()->json(['message' => 'Author updated successfully!', 'author' => $author]);
    }

    // Remove the specified author from storage
    public function destroy($id)
    {
        // Find the author by ID or return 404 if not found
        $author = Author::find($id);

        if (!$author) {
            return response()->json(['message' => 'Author not found'], 404);
        }

        // Delete the author
        $author->delete();

        return response()->json(['message' => 'Author deleted successfully']);
    }
}
