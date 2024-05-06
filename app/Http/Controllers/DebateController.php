<?php

namespace App\Http\Controllers;

use App\Models\Debate;
use App\Models\User;
use Illuminate\Http\Request;

class DebateController extends Controller
{

    public function showStep1Form()
    {
        return view('debate.debate-step1');
    }

    public function processStep1(Request $request)
    {
        $request->validate([
            'isDebatePublic' => 'required|boolean',
        ]);

        // Store data in session or temporary storage
        $request->session()->put('isDebatePublic', $request->isDebatePublic);

        return redirect()->route('debate.step2');
    }

    public function showStep2Form()
    {
        return view('debate.debate-step2');
    }

    public function processStep2(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'thesis' => 'required|string|max:255',
        ]);
    
        // Retrieve data from session or temporary storage
        $isDebatePublic = $request->session()->get('isDebatePublic');
    
        // Store data in session or temporary storage
        $request->session()->put('title', $request->title);
        $request->session()->put('thesis', $request->thesis);
    
        // Redirect to step 3
        return redirect()->route('debate.step3');
    }
    

    public function showStep3Form()
    {
        return view('debate.debate-step3');
    }

    public function processStep3(Request $request)
    {
        $request->validate([
            'isSingleThesis' => 'required|boolean',
        ]);

        // Retrieve data from session or temporary storage
        $isDebatePublic = $request->session()->get('isDebatePublic');
        $title = $request->session()->get('title');
        $thesis = $request->session()->get('thesis');

        // Store data in session or temporary storage
        $request->session()->put('isSingleThesis', $request->isSingleThesis);

        return redirect()->route('debate.step4');
    }

    public function showStep4Form()
    {
        return view('debate.debate-step4');
    }

    public function processStep4(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
            'tags' => 'required|string',
            'backgroundinfo' => 'required|string',
        ]);
    
        $user = auth('sanctum')->user();
    
        // Retrieve data from session or temporary storage
        $isDebatePublic = $request->session()->get('isDebatePublic');
        $isSingleThesis = $request->session()->get('isSingleThesis');
        $title = $request->session()->get('title');
        $thesis = $request->session()->get('thesis');
    
        // Store validated data in the database
        $imagePath = $request->file('image')->store('debate-images', 'public');
    
        Debate::create([
            'user_id' => $user->id,
            'title' => $title,
            'thesis' => $thesis,
            'tags' => $request->tags,
            'backgroundinfo' => $request->backgroundinfo,
            'image' => $imagePath,
            'isDebatePublic' => $isDebatePublic,
            'isSingleThesis' => $isSingleThesis,
        ]);
    
        // Clear session or temporary storage
        $request->session()->forget('isDebatePublic');
        $request->session()->forget('isSingleThesis');
        $request->session()->forget('title');
        $request->session()->forget('thesis');
    
        // Redirect to a success page or dashboard
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
