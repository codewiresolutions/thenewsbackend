<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::all(); // Retrieve all tags

        // Return a view with the tags data
        return view('tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the view for creating a tag
        return view('tags.create');
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
        Tag::create($request->only('name'));

        // Redirect back to the index page with a success message
        return redirect()->route('tags.index')->with('success', 'Tag created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Find the tag by ID
        $tag = Tag::findOrFail($id);

        // Return the view with the tag data
        return view('tags.show', compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Find the tag by ID
        $tag = Tag::findOrFail($id);

        // Return the view for editing the tag
        return view('tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the tag by ID
        $tag = Tag::findOrFail($id);

        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $id,
        ]);

        // Update the tag in the database
        $tag->update($request->only('name'));

        // Redirect back to the index page with a success message
        return redirect()->route('tags.index')->with('success', 'Tag updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the tag by ID
        $tag = Tag::findOrFail($id);

        // Delete the tag from the database
        $tag->delete();

        // Redirect back to the index page with a success message
        return redirect()->route('tags.index')->with('success', 'Tag deleted successfully!');
    }
}
