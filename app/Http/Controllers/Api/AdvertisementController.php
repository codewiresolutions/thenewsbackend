<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdvertisementController extends Controller
{
    // List all advertisements
    public function index()
    {
        $advertisements = Advertisement::all();

        // Append file URLs for video and image
        foreach ($advertisements as $ad) {
            $ad->video = $ad->video ? asset('storage/' . $ad->video) : null;
            $ad->image = $ad->image ? asset('storage/' . $ad->image) : null;
        }

        return response()->json($advertisements, 200);
    }

    // Store a new advertisement
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video' => 'nullable|file|mimes:mp4,mov,avi|max:20480', // 20 MB limit
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:5120', // 5 MB limit
            'active' => 'required|boolean',
        ]);

        // Handle file uploads
        if ($request->hasFile('video')) {
            $validatedData['video'] = $request->file('video')->store('videos', 'public');
        }

        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('images', 'public');
        }

        $advertisement = Advertisement::create($validatedData);

        return response()->json($advertisement, 201);
    }

    // Show a single advertisement
    public function show(Advertisement $advertisement)
    {
        $advertisement->video = $advertisement->video ? asset('storage/' . $advertisement->video) : null;
        $advertisement->image = $advertisement->image ? asset('storage/' . $advertisement->image) : null;

        return response()->json($advertisement, 200);
    }

    // Update an existing advertisement
    public function update(Request $request, Advertisement $advertisement)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'video' => 'nullable|file|mimes:mp4,mov,avi|max:20480',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:5120',
            'active' => 'sometimes|boolean',
        ]);

        // Handle file uploads
        if ($request->hasFile('video')) {
            // Delete the old video if exists
            if ($advertisement->video) {
                Storage::disk('public')->delete($advertisement->video);
            }
            $validatedData['video'] = $request->file('video')->store('videos', 'public');
        }

        if ($request->hasFile('image')) {
            // Delete the old image if exists
            if ($advertisement->image) {
                Storage::disk('public')->delete($advertisement->image);
            }
            $validatedData['image'] = $request->file('image')->store('images', 'public');
        }

        $advertisement->update($validatedData);

        return response()->json($advertisement, 200);
    }

    // Delete an advertisement
    public function destroy(Advertisement $advertisement)
    {
        // Delete associated files if they exist
        if ($advertisement->video) {
            Storage::disk('public')->delete($advertisement->video);
        }
        if ($advertisement->image) {
            Storage::disk('public')->delete($advertisement->image);
        }

        $advertisement->delete();

        return response()->json(['message' => 'Advertisement deleted successfully'], 200);
    }
}
