<?php

namespace App\Http\Controllers;

use App\Models\Debate;
use App\Models\User;
use App\Models\Tag;
use App\Models\DebateComment;
use App\Models\Vote;
use App\Models\DebateRole;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $debate = Debate::create([
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
    
        // Assign the "Owner" role to the user who creates the debate
        DebateRole::create([
            'user_id' => auth()->id(),
            'root_id' => $debate->id,
            'role' => 'owner',
        ]);
    
        // Clear session data
        $request->session()->forget(['isDebatePublic', 'title', 'thesis', 'isSingleThesis', 'tags', 'backgroundinfo']);
    
        return redirect()->route('home');
    }
    
    public function single(Request $request, $slug)
    {
        // Find the debate by slug
        $debate = Debate::where('slug', $slug)->firstOrFail();
    
        // Find the root debate
        $rootDebate = $this->findRootDebate($debate);
    
         // Check if the request came from the homepage
        if ($request->query('from') === 'debate-card') {
            // Increment total_views for the root debate
            $rootDebate->increment('total_views');
        }

        // Retrieve pro and con arguments for the debate
        $pros = Debate::where('parent_id', $debate->id)->where('side', 'pro')->get();
        $cons = Debate::where('parent_id', $debate->id)->where('side', 'con')->get();
    
        $activeDebateId = $request->query('active');
        
        // Retrieve comments for the debate
        $comments = $this->getAllComments($debate);

        // Find ancestors of the debate
        $ancestors = [];
        $claim = $debate;
    
        // Traverse up the parent chain until reaching the root or parent_id is null
        while ($claim->parent_id !== null) {
            $claim = Debate::findOrFail($claim->parent_id);
            $ancestors[] = $claim;
        }
    
        // Set a variable to indicate whether to hide the buttons
        $hideButtons = false;
        // Reverse the ancestors array to display from root to selected claim
        $ancestors = array_reverse($ancestors);
    
        // Function to get votes count
        $getVotesCount = function ($debateId) {
            $votesCount = [];
            for ($i = 0; $i <= 4; $i++) {
                $votesCount[$i] = Vote::where('debate_id', $debateId)->where('rating', $i)->count();
            }
            return $votesCount;
        };
    
        // Get vote counts for the current debate
        $votesCount = $getVotesCount($debate->id);
    
        // Get vote counts for ancestors, pros, and cons
        $ancestorsVotesCount = [];
        foreach ($ancestors as $ancestor) {
            $ancestorsVotesCount[$ancestor->id] = $getVotesCount($ancestor->id);
        }
    
        $prosVotesCount = [];
        foreach ($pros as $pro) {
            $prosVotesCount[$pro->id] = $getVotesCount($pro->id);
        }
    
        $consVotesCount = [];
        foreach ($cons as $con) {
            $consVotesCount[$con->id] = $getVotesCount($con->id);
        }
    

        // Get average votes for the current debate
        $averageVotes['debate'] = $this->getAverageVotes($debate->id);

        // Calculate average votes for pros
        foreach ($pros as $pro) {
            $averageVotes['pros'][$pro->id] = $this->getAverageVotes($pro->id);
        }

        // Calculate average votes for cons
        foreach ($cons as $con) {
            $averageVotes['cons'][$con->id] = $this->getAverageVotes($con->id);
        }

        // Calculate average votes for ancestors
        foreach ($ancestors as $ancestor) {
            $averageVotes['ancestors'][$ancestor->id] = $this->getAverageVotes($ancestor->id);
        }

         // Get the user's claims in the current debate hierarchy
        $myClaims = $this->getMyClaims($request, $slug);

        // Get the user's contributions (claims, comments, and votes) in the current debate hierarchy
        $myContributions = $this->getMyContributions($slug);
    
        // Get debate statistics
        $debateStats = $this->getDebateStatistics($debate);
    
        // Get debate data
        $debatePopupData = $this->getDebatePopupData($debate);

        return view('debate.single', compact('debate', 'pros', 'cons', 'comments', 'hideButtons', 'ancestors', 'rootDebate', 'votesCount', 'ancestorsVotesCount', 'prosVotesCount', 'consVotesCount', 'averageVotes', 'myClaims', 'myContributions', 'debateStats', 'debatePopupData'));
    }
    
    
    
    public function getDebatePopupData($debate)
    {
        // Get tags for the debate from the 'tags' column in the 'debate' table
        $tags = json_decode($debate->tags);
        
        // Get all debate IDs in the hierarchy
        $debateIds = Debate::where('root_id', $debate->id)->orWhere('id', $debate->id)->pluck('id');
        
        // Get participants (unique users) who created debates, commented, or voted in the hierarchy
        $userIds = [];
        $userIds = array_merge($userIds, Debate::whereIn('id', $debateIds)->pluck('user_id')->toArray());
        $userIds = array_merge($userIds, DebateComment::whereIn('debate_id', $debateIds)->pluck('user_id')->toArray());
        $userIds = array_merge($userIds, Vote::whereIn('debate_id', $debateIds)->pluck('user_id')->toArray());
        $uniqueUserIds = array_unique($userIds);
        
        // Get user data
        $participants = User::whereIn('id', $uniqueUserIds)->get();
        
        // Get user contributions
        $participantData = [];
        foreach ($participants as $participant) {
            $claimsCount = Debate::whereIn('id', $debateIds)->where('user_id', $participant->id)->count();
            $votesCount = Vote::whereIn('debate_id', $debateIds)->where('user_id', $participant->id)->count();
            $commentsCount = DebateComment::whereIn('debate_id', $debateIds)->where('user_id', $participant->id)->count();
            $totalContributions = $claimsCount + $votesCount + $commentsCount;
        
            $participantData[] = [
                'user' => $participant,
                'claims_count' => $claimsCount,
                'votes_count' => $votesCount,
                'total_contributions' => $totalContributions
            ];
        }
        
        return [
            'tags' => $tags,
            'participants' => $participantData,
        ];
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

        // Calculate statistics for each debate
        $debateStats = $debates->map(function ($debate) {
            $stats = $this->getDebateStatistics($debate);
            $debate->total_claims = $stats['total_claims'];
            $debate->total_votes = $stats['total_votes'];
            $debate->total_participants = $stats['total_participants'];
            $debate->total_views = $stats['total_views'];
            $debate->total_contributions = $stats['total_contributions'];
            return $debate;
        });
    
        return view('tags.single', compact('debates', 'tag', 'debateStats'));
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

    public function getDebateStatistics($debate)
    {
        // Get all debate IDs in the hierarchy
        $debateIds = Debate::where('root_id', $debate->id)->orWhere('id', $debate->id)->pluck('id');

        // Total claims: all debates in the hierarchy
        $totalClaims = Debate::whereIn('id', $debateIds)->count();

        // Total votes: all votes in the hierarchy
        $totalVotes = Vote::whereIn('debate_id', $debateIds)->count();

        // Total participants: unique users who created debates, commented, or voted in the hierarchy
        $userIds = [];
        $userIds = array_merge($userIds, Debate::whereIn('id', $debateIds)->pluck('user_id')->toArray());
        $userIds = array_merge($userIds, DebateComment::whereIn('debate_id', $debateIds)->pluck('user_id')->toArray());
        $userIds = array_merge($userIds, Vote::whereIn('debate_id', $debateIds)->pluck('user_id')->toArray());
        $totalParticipants = count(array_unique($userIds));

        // Total views: views of the root debate only
        $totalViews = $debate->total_views;

        // Total contributions: sum of votes, comments, and claims
        $totalComments = DebateComment::whereIn('debate_id', $debateIds)->count();
        $totalContributions = $totalVotes + $totalComments + $totalClaims;

        return [
            'total_claims' => $totalClaims,
            'total_votes' => $totalVotes,
            'total_participants' => $totalParticipants,
            'total_views' => $totalViews,
            'total_contributions' => $totalContributions,
        ];
    }


    public function getHomeData(Request $request)
    {
        $latestTags = Tag::latest()->take(5)->get();
        $debates = Debate::whereNull('parent_id')->latest()->get();
    
        // Prepend the base URL to the image path for debates
        $debates->transform(function ($debate) {
            $debate->image = asset('storage/' . $debate->image);
            return $debate;
        });
    
        // Calculate statistics for each debate
        $debateStats = $debates->map(function ($debate) {
            $stats = $this->getDebateStatistics($debate);
            $debate->total_claims = $stats['total_claims'];
            $debate->total_votes = $stats['total_votes'];
            $debate->total_participants = $stats['total_participants'];
            $debate->total_views = $stats['total_views'];
            $debate->total_contributions = $stats['total_contributions'];
            return $debate;
        });

        // Get sum data
        $sumData = $this->getSumData();

        // Get top contributors
        $topContributors = $this->getTopContributors();

        return view('home', compact('latestTags', 'debateStats', 'sumData', 'topContributors'));
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
    
    public function addComment(Request $request, $debateId)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        $comment = new DebateComment();
        $comment->user_id = Auth::id();
        $comment->debate_id = $debateId;
        $comment->comment = $request->comment;
        $comment->save();

        return redirect()->back()->with('success', 'Comment added successfully.');
    }

    // Method to retrieve all comments for a debate
    public function getAllComments($debate)
    {
        // Retrieve comments for the debate and its ancestors
        $debateIds = Debate::where('id', $debate->id)
                            ->orWhere('parent_id', $debate->id)
                            ->pluck('id');

        $comments = DebateComment::whereIn('debate_id', $debateIds)
                                    ->with('user')
                                    ->get();
        
        return $comments->toArray();
    }

        // Helper method to find the root debate
    private function findRootDebate($debate)
    {
        // Traverse up the parent chain until reaching the root or parent_id is null
        while ($debate->parent_id !== null) {
            $debate = Debate::findOrFail($debate->parent_id);
        }
    
        return $debate;
    }
    
    
    public function editRootDebate(Request $request, $slug)
    {
        // Find the root debate
        $rootDebate = Debate::where('slug', $slug)->firstOrFail();
    
        // Check if the form is submitted
        if ($request->isMethod('post')) {
            // Validate the form data
            $request->validate([
                'image' => 'image|max:2048', // Update image if provided
                'title' => 'required|string|max:255', // Title is required
                'backgroundinfo' => 'nullable|string|max:500', // Background info is optional
                'tags' => 'required|string', // Tags are required
            ]);
    
            // Handle image upload if provided
            if ($request->hasFile('image')) {
                // Delete the old image from storage
                Storage::disk('public')->delete($rootDebate->image);
    
                // Store the new image
                $imagePath = $request->file('image')->store('debate-images', 'public');
                // Update the image path
                $rootDebate->image = $imagePath;
            }
    
            // Update other fields
            $rootDebate->title = $request->title;
            $rootDebate->backgroundinfo = $request->backgroundinfo;
            // Convert tags string to an array and lowercase each tag
            $tags = array_map('strtolower', explode(',', $request->tags));
            // Convert tags array to JSON
            $tagsJson = json_encode(array_values(array_unique($tags)));
            $rootDebate->tags = $tagsJson;
            // Save the changes
            $rootDebate->save();
    
            return redirect()->route('settings', ['slug' => $rootDebate->slug])->with('success', 'Debate information updated successfully');
        }
    
        return view('debate.edit', compact('rootDebate'));
    }


    public function settings(Request $request, $slug)
    {
        // Find the root debate
        $rootDebate = Debate::where('slug', $slug)->firstOrFail();

        // Retrieve participants
        $participants = $this->getParticipants($rootDebate);

        // Set a variable to indicate whether to hide the buttons
        $hideButtons = true;

        return view('debate.settings', compact('rootDebate', 'participants', 'hideButtons'));
    }
    
    // New method to retrieve all participants in the debate hierarchy
    private function getParticipants($rootDebate)
    {
        // Retrieve all debates in the hierarchy
        $debateIds = Debate::where('id', $rootDebate->id)
            ->orWhere('root_id', $rootDebate->id)
            ->pluck('id')
            ->toArray();
    
        // Retrieve all users who created the debates
        $debateUsers = User::whereIn('id', Debate::whereIn('id', $debateIds)->pluck('user_id'))->get();
    
        // Retrieve all users who commented on the debates
        $commentUsers = User::whereIn('id', DebateComment::whereIn('debate_id', $debateIds)->pluck('user_id'))->get();
    
        // Merge and return unique users
        $participants = $debateUsers->merge($commentUsers)->unique('id');
    
        // Prepend the storage path to the profile picture URL
        foreach ($participants as $participant) {
            $participant->profile_picture_url = asset('storage/' . $participant->profile_picture);
    
            // Attach roles related to the specific debate
            $participant->roles_for_debate = $participant->roles($rootDebate->id)->get();
        }
    
        return $participants;
    }

    public function vote(Request $request, $debateId)
    {
        $debate = Debate::findOrFail($debateId);

        if (!$debate->voting_allowed) {
            return redirect()->back()->with('error', 'Voting is not allowed for this debate.');
        }

        $vote = Vote::updateOrCreate(
            [
                'debate_id' => $debateId,
                'user_id' => auth()->id()
            ],
            [
                'rating' => $request->input('rating')
            ]
        );

        $debate->increment('total_votes');

        return redirect()->back()->with('success', 'Your vote has been submitted.');
    }

    // Add the deleteVote method to your DebateController
    public function deleteVote(Request $request, $debateId)
    {
        // Find the vote to delete
        $vote = Vote::where('debate_id', $debateId)
                    ->where('user_id', auth()->id())
                    ->first();

        if (!$vote) {
            return redirect()->back()->with('error', 'You have not voted for this debate.');
        }

        // Delete the vote
        $vote->delete();

         // Decrement total_votes
        $debate = Debate::findOrFail($debateId);
        $debate->decrement('total_votes');
        

        return redirect()->back()->with('success', 'Your vote has been deleted.');
    }

    // Add the getAverageVotes method to your DebateController
    public function getAverageVotes($debateId)
    {
        // Get all votes for the debate
        $votes = Vote::where('debate_id', $debateId)->get();

        if ($votes->isEmpty()) {
            return 0; // Return 0 if there are no votes
        }

        // Calculate the sum of votes multiplied by 25
        $sum = $votes->sum('rating') * 25;

        // Calculate the average by dividing the sum by the number of votes
        $average = $sum / $votes->count();

        return $average;
    }

    public function getMyClaims(Request $request, $slug)
    {
        // Find the root debate by slug
        $debate = Debate::where('slug', $slug)->firstOrFail();
    
        // Get the root debate ID
        $rootId = $this->findRootId($debate->id);
    
        // Get all debates in the hierarchy
        $debateIds = Debate::where('root_id', $rootId)->orWhere('id', $rootId)->pluck('id');
    
        // Get all claims created by the current user in the hierarchy
        $myClaims = Debate::whereIn('id', $debateIds)
                          ->where('user_id', Auth::id())
                          ->get();
    
        return $myClaims;
    }

    private function getMyContributions($slug)
    {
        // Find the root debate by slug
        $debate = Debate::where('slug', $slug)->firstOrFail();
    
        // Get the root debate ID
        $rootId = $this->findRootId($debate->id);
    
        // Get all debates in the hierarchy
        $debateIds = Debate::where('root_id', $rootId)->orWhere('id', $rootId)->pluck('id');
    
        // Get all claims created by the current user in the hierarchy
        $myClaims = Debate::whereIn('id', $debateIds)
                          ->where('user_id', Auth::id())
                          ->get();
    
        // Get all comments created by the current user in the hierarchy
        $myComments = DebateComment::whereIn('debate_id', $debateIds)
                                   ->where('user_id', Auth::id())
                                   ->get();
    
        // Get all votes created by the current user in the hierarchy
        $myVotes = Vote::whereIn('debate_id', $debateIds)
                       ->where('user_id', Auth::id())
                       ->get();
    
        // Combine all contributions into a single collection
        $contributions = collect();
    
        foreach ($myClaims as $claim) {
            $contributions->push([
                'type' => 'claim',
                'data' => $claim,
                'created_at' => $claim->created_at,
            ]);
        }
    
        foreach ($myComments as $comment) {
            $contributions->push([
                'type' => 'comment',
                'data' => $comment,
                'created_at' => $comment->created_at,
            ]);
        }
    
        foreach ($myVotes as $vote) {
            $contributions->push([
                'type' => 'vote',
                'data' => $vote,
                'created_at' => $vote->created_at,
            ]);
        }
    
        // Sort the contributions by created_at in descending order
        $sortedContributions = $contributions->sortByDesc('created_at');
    
        return $sortedContributions;
    }
    

}