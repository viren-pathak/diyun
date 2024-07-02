<?php

namespace App\Http\Controllers;

use App\Models\Debate;
use App\Models\User;
use App\Models\Tag;
use App\Models\DebateComment;
use App\Models\Vote;
use App\Models\DebateRole;
use App\Models\DebateBookmark;
use App\Models\DebateInviteLink;
use App\Models\Thanks;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\DebateInvite;


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

        // Get the user's bookmarks in the current debate hierarchy
        $bookmarkedDebates = $this->getUserBookmarks($slug);

        return view('debate.single', compact('debate', 'pros', 'cons', 'comments', 'hideButtons', 'ancestors', 'rootDebate', 'votesCount', 'ancestorsVotesCount', 'prosVotesCount', 'consVotesCount', 'averageVotes', 'myClaims', 'myContributions', 'debateStats', 'debatePopupData', 'bookmarkedDebates'));
    }
    
    
    
    public function getDebatePopupData($debate)
    {
        // Check if the current debate is a root debate or a child debate
        if ($debate->root_id !== null) {
            // Fetch the root debate
            $rootDebate = Debate::find($debate->root_id);
        } else {
            // Current debate is already a root debate
            $rootDebate = $debate;
        }
    
        // Get tags for the root debate from the 'tags' column in the 'debate' table
        $tags = json_decode($rootDebate->tags);
    
        // Get all debate IDs in the hierarchy
        $debateIds = Debate::where('root_id', $rootDebate->id)->orWhere('id', $rootDebate->id)->pluck('id');
    
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
    
    
    public function getDiyunInNumber()
    {
        // Get the sum of total_claims from debates table
        $totalClaims = Debate::count();
    
        // Get the count of votes from votes table
        $totalVotes = Vote::count();
    
        // Calculate total_contributions as sum of votes, comments, and claims
        $totalContributions = Vote::count() + DebateComment::count() + Debate::count();
    
        // Get the count of debates with parent_id as null from debates table
        $debateCount = Debate::whereNull('parent_id')->count();
    
        // Prepare the sumData array
        $sumData = [
            'total_claims' => $totalClaims,
            'total_votes' => $totalVotes,
            'total_contributions' => $totalContributions,
            'debate_count' => $debateCount,
        ];
    
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
        // Check if the current debate is a root debate or a child debate
        if ($debate->root_id !== null) {
            // Fetch the root debate
            $rootDebate = Debate::find($debate->root_id);
        } else {
            // Current debate is already a root debate
            $rootDebate = $debate;
        }
    
        // Get all debate IDs in the hierarchy
        $debateIds = Debate::where('root_id', $rootDebate->id)->orWhere('id', $rootDebate->id)->pluck('id');
    
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
        $totalViews = $rootDebate->total_views;
    
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

    protected function getDebateContributors($debate)
    {
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
        
        // Prepare contributor data
        $contributors = $participants->map(function ($participant) {
            return [
                'username' => $participant->username,
                'profile_picture' => $participant->profile_picture ? asset( $participant->profile_picture) : asset('uploads/default-avatar.png'),
            ];
        });
    
        return $contributors;
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
    
        // Calculate statistics for each debate and get contributors
        $debateStats = $debates->map(function ($debate) {
            $stats = $this->getDebateStatistics($debate);
            $debate->total_claims = $stats['total_claims'];
            $debate->total_votes = $stats['total_votes'];
            $debate->total_participants = $stats['total_participants'];
            $debate->total_views = $stats['total_views'];
            $debate->total_contributions = $stats['total_contributions'];
            $debate->contributors = $this->getDebateContributors($debate);
            return $debate;
        });

        // Get sum data
        $sumData = $this->getDiyunInNumber();

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

        // Check and assign role
        $this->checkAndAssignRole(Auth::id(), $rootId, 'writer');
    
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

        // Check and assign role
        $this->checkAndAssignRole(Auth::id(), $rootId, 'writer');
    
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

        // Find the root debate ID
        $rootId = $this->findRootId($debateId);
    
        // Check and assign role
        $this->checkAndAssignRole(Auth::id(), $rootId, 'suggester');
    
        return redirect()->back()->with('success', 'Comment added successfully.');
    }

    public function editComment(Request $request, $commentId)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        $comment = DebateComment::findOrFail($commentId);

        // Check if the logged-in user is the owner of the comment
        if (Auth::id() !== $comment->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $comment->comment = $request->comment;
        $comment->save();

        return response()->json(['success' => true]);
    }

    public function deleteComment(Request $request, $id)
    {
        $comment = DebateComment::find($id);
    
        if ($comment) {
            $comment->delete();
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false, 'error' => 'Comment not found'], 404);
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
    
        // Check if the user is authenticated and the owner of the debate
        $isOwner = auth()->check() && auth()->user()->id === $rootDebate->user_id;
    
        // Check if the form is submitted
        if ($request->isMethod('post')) {
            if (!$isOwner) {
                return redirect()->route('debate.single', ['slug' => $rootDebate->slug])->with('error', 'You do not have permission to edit this debate.');
            }
    
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
    
            // Update voting_allowed field based on checkbox state
            $rootDebate->voting_allowed = $request->has('voting_allowed');
    
            // Save the changes
            $rootDebate->save();
    
            // Update voting_allowed for all child debates recursively
            $this->updateVotingAllowed($rootDebate, $rootDebate->voting_allowed);
    
            return redirect()->route('settings', ['slug' => $rootDebate->slug])->with('success', 'Debate information updated successfully');
        }
    
        return view('debate.edit', compact('rootDebate', 'isOwner'));
    }
    
    /**
     * Recursively update voting_allowed for all child debates
     */
    private function updateVotingAllowed($rootDebate, $votingAllowed)
    {
        // Update current debate's voting_allowed
        $rootDebate->voting_allowed = $votingAllowed;
        $rootDebate->save();
    
        // Update voting_allowed for all child debates recursively
        foreach ($rootDebate->children as $childDebate) {
            $this->updateVotingAllowed($childDebate, $votingAllowed);
        }
    }
    
    public function updateDebateTitle(Request $request, $id)
    {
        // Find the debate by ID
        $debate = Debate::findOrFail($id);
    
        // Check if the user is authenticated and the owner of the debate
        if (!auth()->check() || auth()->user()->id !== $debate->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
        ]);
    
        // Generate a unique slug for the updated title
        $slug = Str::slug($request->input('title'));
        $existingSlugCount = Debate::where('slug', 'like', "{$slug}%")->where('id', '<>', $id)->count();
        if ($existingSlugCount > 0) {
            $slug .= '-' . ($existingSlugCount + 1);
        }
    
        // Update the title and slug
        $debate->title = $request->title;
        $debate->slug = $slug;
        $debate->save();
    
        return response()->json(['success' => 'Title updated successfully', 'title' => $debate->title, 'slug' => $debate->slug]);
    }
    
    

    public function settings(Request $request, $slug)
    {
        // Find the root debate
        $rootDebate = Debate::where('slug', $slug)->firstOrFail();

        // Retrieve participants
        $participants = $this->getParticipants($rootDebate);

        // Set a variable to indicate whether to hide the buttons
        $hideButtons = true;

        // Check if the user is authenticated and the owner of the debate
        $isOwner = auth()->check() && auth()->user()->id === $rootDebate->user_id;
    
        return view('debate.settings', compact('rootDebate', 'participants', 'hideButtons', 'isOwner'));
    }
    
    // New method to retrieve all participants in the debate hierarchy
    private function getParticipants($rootDebate)
    {
        // Retrieve all roles in the debate hierarchy
        $roles = DebateRole::where('root_id', $rootDebate->id)->with('user')->get();

        // Extract unique users
        $participants = $roles->pluck('user')->unique('id');

        // Prepend the storage path to the profile picture URL and attach roles
        foreach ($participants as $participant) {
            $participant->profile_picture_url = asset( $participant->profile_picture);
    
            // Attach roles related to the specific debate
            $participant->roles_for_debate = $roles->where('user_id', $participant->id);
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

        // Find the root debate ID
        $rootId = $this->findRootId($debateId);
    
        // Check and assign role
        $this->checkAndAssignRole(Auth::id(), $rootId, 'suggester');
    
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
    

    public function bookmark(Request $request)
    {
        // Validate request data
        $request->validate([
            'debate_id' => 'required',
        ]);
    
        // Get the authenticated user's ID
        $userId = auth()->id();
    
        // Check if the debate is already bookmarked
        $bookmark = DebateBookmark::where('user_id', $userId)->where('debate_id', $request->debate_id)->first();
    
        if ($bookmark) {
            // If bookmarked, remove the bookmark
            $bookmark->delete();
            return response()->json(['isBookmarked' => false, 'message' => 'Bookmark removed successfully']);
        } else {
            // If not bookmarked, add the bookmark
            DebateBookmark::create([
                'user_id' => $userId,
                'debate_id' => $request->debate_id,
            ]);

        // Find the root debate ID
        $rootId = $this->findRootId($request->debate_id);
    
        // Check and assign role
        $this->checkAndAssignRole(Auth::id(), $rootId, 'viewer');

            return response()->json(['isBookmarked' => true, 'message' => 'Debate bookmarked successfully!']);
        }
    }

        
    public function isBookmarked(Request $request)
    {
        $debateId = $request->input('debate_id');
        $isBookmarked = DebateBookmark::where('debate_id', $debateId)->where('user_id', Auth::id())->exists();

        return response()->json(['isBookmarked' => $isBookmarked]);
    }
    
    public function getUserBookmarks($slug)
    {
        // Find the root debate by slug
        $debate = Debate::where('slug', $slug)->firstOrFail();

        // Get the root debate ID
        $rootId = $this->findRootId($debate->id);

        // Get all debates in the hierarchy
        $debateIds = Debate::where('root_id', $rootId)->orWhere('id', $rootId)->pluck('id');

        // Get all bookmarked debates by the current user in the hierarchy
        $bookmarkedDebates = DebateBookmark::whereIn('debate_id', $debateIds)
                                    ->where('user_id', Auth::id())
                                    ->get();

        return $bookmarkedDebates;
    }

    
    public function sendInvite(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'role' => 'required|string',
            'debate_id' => 'required|integer'
        ]);
    
        // Fetch the invited user by email
        $invitedUser = User::where('email', $request->email)->first();
    
        // If the user doesn't exist in the system, return an error message
        if (!$invitedUser) {
            return response()->json(['error' => 'User not registered'], 404);
        }
    
        // Check if the user already has a role in the debate
        $existingRole = DebateRole::where('user_id', $invitedUser->id)
            ->where('root_id', $request->debate_id)
            ->first();
    
        if ($existingRole) {
            return response()->json(['error' => 'User already in debate'], 400);
        }
    
        // Fetch the debate
        $debate = Debate::findOrFail($request->debate_id);
    
        // Get the authenticated user (invitedBy)
        $invitedBy = Auth::user();
    
        // Construct the invite URL
        $inviteUrl = url('/debate/' . $debate->slug . '?active=' . $request->debate_id . '&invite' . '&role=' . $request->role);
        $inviteMessage = $request->message;
    
        // Send the invite email
        Mail::to($request->email)->send(new DebateInvite($inviteUrl, $inviteMessage, $invitedBy, $debate));
    
        // Create DebateRole entry for the invited user
        DebateRole::create([
            'root_id' => $request->debate_id,
            'user_id' => $invitedUser->id,
            'role' => $request->role,
        ]);
    
        return response()->json(['success' => true]);
    }

    protected function checkAndAssignRole($userId, $rootId, $newRole)
    {
        $rolesHierarchy = [
            'owner' => 1,
            'admin' => 2,
            'editor' => 3,
            'writer' => 4,
            'suggester' => 5,
            'viewer' => 6,
        ];

        // Fetch existing role of the user in the debate hierarchy
        $existingRole = DebateRole::where('user_id', $userId)
            ->where('root_id', $rootId)
            ->first();

        // Check if the user already has a role and its position in the hierarchy
        if ($existingRole) {
            $existingRoleLevel = $rolesHierarchy[$existingRole->role];
            $newRoleLevel = $rolesHierarchy[$newRole];

            // Assign the new role only if it is higher in the hierarchy
            if ($newRoleLevel < $existingRoleLevel) {
                $existingRole->role = $newRole;
                $existingRole->save();
            }
        } else {
            // If the user doesn't have any role, assign the new role
            DebateRole::create([
                'user_id' => $userId,
                'root_id' => $rootId,
                'role' => $newRole,
            ]);
        }
    }


    public function storeThanks(Request $request)
    {
        $request->validate([
            'activity_id' => 'required|integer',
            'activity_type' => 'required|string|in:debate,comment',
        ]);
    
        $thankedOn = $request->activity_type;
    
        if ($thankedOn === 'debate') {
            $activity = Debate::findOrFail($request->activity_id);
        } else if ($thankedOn === 'comment') {
            $activity = DebateComment::findOrFail($request->activity_id);
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid activity type.']);
        }
    
        // Check if the user is trying to thank themselves
        if ($activity->user_id == Auth::id()) {
            return response()->json(['success' => false, 'message' => 'You cannot thank yourself.']);
        }
    
        $alreadyThanked = Thanks::where('thanked_by_user_id', Auth::id())
            ->where('thanked_activity_id', $request->activity_id)
            ->where('thanked_on', $thankedOn)
            ->exists();
    
        if ($alreadyThanked) {
            return response()->json(['success' => false, 'message' => 'You have already thanked this ' . $thankedOn . '.', 'thanked' => true]);
        }
    
        Thanks::create([
            'thanked_by_user_id' => Auth::id(),
            'thanked_on' => $thankedOn,
            'thanked_activity_id' => $request->activity_id,
            'thanked_to_user_id' => $activity->user_id,
        ]);
    
        return response()->json(['success' => true, 'thanked' => true]);
    }



    public function checkThanksStatus($type, $id)
    {
        $thankedOn = $type;

        if ($thankedOn === 'debate') {
            $activity = Debate::findOrFail($id);
        } else if ($thankedOn === 'comment') {
            $activity = DebateComment::findOrFail($id);
        } else {
            return response()->json(['thanked' => false]);
        }

        $alreadyThanked = Thanks::where('thanked_by_user_id', Auth::id())
            ->where('thanked_activity_id', $id)
            ->where('thanked_on', $thankedOn)
            ->exists();

        return response()->json(['thanked' => $alreadyThanked]);
    }


}