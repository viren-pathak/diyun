<?php

namespace App\Http\Controllers;

use App\Models\Debate;
use App\Models\User;
use Illuminate\Http\Request;

class DebateController extends Controller
{
    public function createDebate(Request $request)
    {
        $request->validate([
            'isDebatePublic' => 'required|boolean',
            'title' => 'required|string|max:255',
            'thesis' => 'required|string|max:255',
            'isSingleThesis' => 'required|boolean',
            'image' => 'required|image|max:2048',
            'tags' => 'required|string',
        ]);
    
        // Store data in the session
        $request->session()->put([
            'isDebatePublic' => $request->isDebatePublic,
            'title' => $request->title,
            'thesis' => $request->thesis,
            'isSingleThesis' => $request->isSingleThesis,
            'tags' => $request->tags,
            'backgroundinfo' => $request->backgroundinfo,
        ]);
    
        // Handle image upload
        $imagePath = $request->file('image')->store('debate-images', 'public');

        // Convert tags string to an array
        $tags = explode(',', $request->tags);

        // Convert tags array to JSON
        $tagsJson = json_encode($tags);
            // Store unique tags in the tags table
        foreach ($tags as $tag) {
            $existingTag = Tag::where('tag', $tag)->first();

            if (!$existingTag) {
                // Tag does not exist, insert it
                Tag::create([
                    'tag' => $tag,
                    // Add tag_image if needed
                ]);
            }
        }
        
        // Store data in the database
        Debate::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'thesis' => $request->thesis,
            'tags' => $tagsJson,
            'backgroundinfo' => $request->backgroundinfo,
            'image' => $imagePath,
            'isDebatePublic' => $request->isDebatePublic,
            'isSingleThesis' => $request->isSingleThesis,
        ]);
    
        // Clear session data
        $request->session()->forget(['isDebatePublic', 'title', 'thesis', 'isSingleThesis', 'tags', 'backgroundinfo']);
    
        return redirect()->route('home');
    }
    
    
    


    public function getAllDebates(Request $request)
    {
        $debates = Debate::whereNull('parent_id')->get();
    
        // Prepend the base URL to the image path
        $debates->transform(function ($debate) {
            $debate->image = asset('storage/' . $debate->image);
            return $debate;
        });
    
        return view('home', compact('debates'));
    }
    
    
}