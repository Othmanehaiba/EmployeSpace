<?php

namespace App\Http\Controllers;

use App\Models\CandidateCv;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CvController extends Controller
{
    /**
     * Display the CV.
     */
    public function show(Request $request): View
    {
        $user = $request->user();
        $cv = $user->candidateCv;

        return view('cv.show', compact('user', 'cv'));
    }

    /**
     * Show the CV edit form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        
        // Create CV if it doesn't exist
        $cv = $user->candidateCv ?? CandidateCv::create([
            'user_id' => $user->id,
            'title' => 'Mon profil',
        ]);

        $cv->load(['educations', 'experiences', 'skills']);

        return view('cv.edit', compact('cv'));
    }
}
