<?php

namespace App\Http\Controllers;

use App\Models\Debate;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
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
    
        // Convert tags string to an array and lowercase each tag
        $tags = array_map('strtolower', explode(',', $request->tags));
    
        // Convert tags array to JSON
        $tagsJson = json_encode(array_values(array_unique($tags)));// Remove duplicate tags
    
        // Store unique lowercase tags in the tags table
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

        // Generate a unique slug
        $slug = Str::slug($request->title);
        $existingSlugCount = Debate::where('slug', 'like', "{$slug}%")->count();
        if ($existingSlugCount > 0) {
            $slug .= '-' . ($existingSlugCount + 1);
        }

        // Store data in the database
        Debate::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'slug' => $slug,
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
    
    public function single($slug)
    {
        // Find the debate by slug
        $debate = Debate::where('slug', $slug)->firstOrFail();
    
        // Get the selected claim's title
        $selectedClaimTitle = $debate->title;
    
        // Find the pros and cons for this debate
        $pros = Debate::where('parent_id', $debate->id)->where('side', 'pro')->get();
        $cons = Debate::where('parent_id', $debate->id)->where('side', 'con')->get();
    
        // Pass the debate, pros, cons, and selected claim title data to the view
        return view('debate.single', compact('debate', 'pros', 'cons', 'selectedClaimTitle'));
    }
    
    
    

    public function getChildArguments($slug)
    {
        // Find the debate by slug
        $debate = Debate::where('slug', $slug)->firstOrFail();
        
        // Find child debates for the selected debate's ID
        $pros = Debate::where('parent_id', $debate->id)->where('side', 'pro')->get();
        $cons = Debate::where('parent_id', $debate->id)->where('side', 'con')->get();
        
        // Return child debates as JSON response
        return response()->json(['pros' => $pros, 'cons' => $cons]);
    }
    
    
    public function getDebatesByTag(Request $request, $tagName)
    {
        // Find tag by name
        $tag = Tag::where('tag', $tagName)->first();
    
        if (!$tag) {
            // Tag not found, return empty
            $debates = collect();
        } else {
            // Find debates containing the specified tag
            $debates = Debate::whereJsonContains('tags', $tagName)->get();
            
            // Prepend the base URL to the image path
            $debates->transform(function ($debate) {
                $debate->image = asset('storage/' . $debate->image);
                return $debate;
            });
        }
    
        return view('tags.single', compact('debates', 'tag'));
    }
    
    
    public function getSumData()
    {
        // Get the sum of total_claims, total_votes, and total_contributions
        $sumData = [
            'total_claims' => User::sum('total_claims'),
            'total_votes' => User::sum('total_votes'),
            'total_contributions' => User::sum('total_contributions'),
        ];
    
        // Get the count of debates with parent_id as null
        $debateCount = Debate::whereNull('parent_id')->count();
    
        // Add the count of debates to the sum data
        $sumData['debate_count'] = $debateCount;
    
        return $sumData; // Return just the data, not the view
    }
    
    public function getTopContributors()
    {
        // Retrieve top contributors from the users table in descending order of total_contributions
        $topContributors = User::orderBy('total_contributions', 'desc')->take(20)->get();
    
        return $topContributors;
    }

    public function getHomeData(Request $request)
    {
        $latestTags = Tag::latest()->take(10)->get();
        $debates = Debate::whereNull('parent_id')->latest()->get();
    
        // Prepend the base URL to the image path for debates
        $debates->transform(function ($debate) {
            $debate->image = asset('storage/' . $debate->image);
            return $debate;
        });
    
        // Get sum data
        $sumData = $this->getSumData();

        // Get sum data
        $topContributors = $this->getTopContributors();
        
        return view('home', compact('latestTags', 'debates', 'sumData', 'topContributors'));
    }
    
    
    public function getAllTags()
    {
        $tags = Tag::orderBy('tag')->get();
        return view('tags.all', compact('tags'));
    }



    public function addPro(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        // Find the root debate ID
        $rootId = $this->findRootId($id);
    
        // Generate a unique slug for the pro argument
        $slug = Str::slug($request->input('title'));
        $existingSlugCount = Debate::where('slug', 'like', "{$slug}%")->count();
        if ($existingSlugCount > 0) {
            $slug .= '-' . ($existingSlugCount + 1);
        }
    
        $debate = new Debate();
        $debate->user_id = Auth::id();
        $debate->title = $request->input('title');
        $debate->side = 'pro'; // Indicate this is a pro argument
        $debate->slug = $slug;
        $debate->parent_id = $id;
        $debate->root_id = $rootId; // Set the root debate ID
        $debate->save();

        return redirect()->back()->with('success', 'Pro argument added successfully');
    }

    public function addCon(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        // Find the root debate ID
        $rootId = $this->findRootId($id);
    
        // Generate a unique slug for the con argument
        $slug = Str::slug($request->input('title'));
        $existingSlugCount = Debate::where('slug', 'like', "{$slug}%")->count();
        if ($existingSlugCount > 0) {
            $slug .= '-' . ($existingSlugCount + 1);
        }
    
        $debate = new Debate();
        $debate->user_id = Auth::id();
        $debate->title = $request->input('title');
        $debate->side = 'con'; // Indicate this is a con argument
        $debate->slug = $slug;
        $debate->parent_id = $id;
        $debate->root_id = $rootId; // Set the root debate ID
        $debate->save();

        return redirect()->back()->with('success', 'Con argument added successfully');
    }
    
    // Helper method to find the root debate ID
    private function findRootId($id)
    {
        $debate = Debate::findOrFail($id);
    
        // Traverse up the parent chain until we find the root debate
        while ($debate->parent_id !== null) {
            $debate = Debate::findOrFail($debate->parent_id);
        }
    
        return $debate->id;
    }
    


}