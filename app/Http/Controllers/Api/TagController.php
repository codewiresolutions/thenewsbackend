<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::all(); // Retrieve all tags
        return response()->json($tags); // Return tags as JSON response
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255|unique:tags',
        ]);

        // Create the tag and save it to the database
        $tag = Tag::create($request->only('name'));

        // Return a JSON response
        return response()->json([
            'message' => 'Tag created successfully!',
            'tag' => $tag
        ], 201); // HTTP Status 201 - Created
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Find the tag by ID
        $tag = Tag::find($id);

        // If the tag does not exist, return a 404 response
        if (!$tag) {
            return response()->json(['message' => 'Tag not found'], 404);
        }

        // Return the tag data as a JSON response
        return response()->json($tag);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the tag by ID
        $tag = Tag::find($id);

        // If the tag does not exist, return a 404 response
        if (!$tag) {
            return response()->json(['message' => 'Tag not found'], 404);
        }

        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $id,
        ]);

        // Update the tag in the database
        $tag->update($request->only('name'));

        // Return a JSON response
        return response()->json([
            'message' => 'Tag updated successfully!',
            'tag' => $tag
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the tag by ID
        $tag = Tag::find($id);

        // If the tag does not exist, return a 404 response
        if (!$tag) {
            return response()->json(['message' => 'Tag not found'], 404);
        }

        // Delete the tag from the database
        $tag->delete();

        // Return a JSON response
        return response()->json(['message' => 'Tag deleted successfully!']);
    }
}
