<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class JobSearchController extends Controller
{
    /**
     * Search and list open job offers.
     */
    public function index(Request $request): View
    {
        $query = JobOffer::open()->with('recruteur');

        // Search by title or contract type
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Filter by contract type
        if ($contractType = $request->get('contract_type')) {
            $query->where('contract_type', $contractType);
        }

        $offers = $query->latest()->paginate(12);

        return view('jobs.index', [
            'offers' => $offers,
            'search' => $search ?? '',
            'contractType' => $contractType ?? '',
            'contractTypes' => JobOffer::CONTRACT_TYPES,
        ]);
    }

    /**
     * Show a job offer details.
     */
    public function show(JobOffer $jobOffer): View
    {
        $hasApplied = auth()->user()->hasAppliedTo($jobOffer);

        return view('jobs.show', [
            'jobOffer' => $jobOffer,
            'hasApplied' => $hasApplied,
        ]);
    }

    /**
     * Apply to a job offer.
     */
    public function apply(Request $request, JobOffer $jobOffer): RedirectResponse
    {
        $user = $request->user();

        // Check if already applied
        if ($user->hasAppliedTo($jobOffer)) {
            return back()->with('error', 'Vous avez déjà postulé à cette offre.');
        }

        // Check if offer is still open
        if (!$jobOffer->isOpen()) {
            return back()->with('error', 'Cette offre est clôturée.');
        }

        $validated = $request->validate([
            'message' => ['nullable', 'string', 'max:2000'],
        ]);

        JobApplication::create([
            'job_offer_id' => $jobOffer->id,
            'candidate_user_id' => $user->id,
            'message' => $validated['message'] ?? null,
        ]);

        return redirect()->route('jobs.show', $jobOffer)
            ->with('success', 'Votre candidature a été envoyée avec succès.');
    }

    /**
     * List my applications.
     */
    public function myApplications(Request $request): View
    {
        $applications = $request->user()
            ->jobApplications()
            ->with('jobOffer')
            ->latest()
            ->paginate(10);

        return view('jobs.my-applications', compact('applications'));
    }
}
