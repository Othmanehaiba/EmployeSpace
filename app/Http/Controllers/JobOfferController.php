<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class JobOfferController extends Controller
{
    /**
     * Display list of recruiter's job offers.
     */
    public function index(Request $request): View
    {
        $offers = $request->user()
            ->jobOffers()
            ->withCount('applications')
            ->latest()
            ->paginate(10);

        return view('job-offers.index', compact('offers'));
    }

    /**
     * Show form to create a new job offer.
     */
    public function create(): View
    {
        return view('job-offers.create', [
            'contractTypes' => JobOffer::CONTRACT_TYPES,
        ]);
    }

    /**
     * Store a new job offer.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'contract_type' => ['required', 'string', 'in:' . implode(',', array_keys(JobOffer::CONTRACT_TYPES))],
            'location' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'image' => ['required', 'image', 'max:2048'],
        ]);

        $imagePath = $request->file('image')->store('job-offers', 'public');

        $offer = $request->user()->jobOffers()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'contract_type' => $validated['contract_type'],
            'location' => $validated['location'] ?? null,
            'start_date' => $validated['start_date'] ?? null,
            'image_path' => $imagePath,
            'company_name' => $request->user()->recruteur?->company_name,
            'status' => JobOffer::STATUS_OPEN,
        ]);

        return redirect()->route('job-offers.index')
            ->with('success', 'Offre créée avec succès.');
    }

    /**
     * Show a specific job offer.
     */
    public function show(JobOffer $jobOffer): View
    {
        $this->authorize('view', $jobOffer);
        
        return view('job-offers.show', compact('jobOffer'));
    }

    /**
     * Show form to edit a job offer.
     */
    public function edit(JobOffer $jobOffer): View
    {
        $this->authorize('update', $jobOffer);

        return view('job-offers.edit', [
            'jobOffer' => $jobOffer,
            'contractTypes' => JobOffer::CONTRACT_TYPES,
        ]);
    }

    /**
     * Update a job offer.
     */
    public function update(Request $request, JobOffer $jobOffer): RedirectResponse
    {
        $this->authorize('update', $jobOffer);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'contract_type' => ['required', 'string', 'in:' . implode(',', array_keys(JobOffer::CONTRACT_TYPES))],
            'location' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'contract_type' => $validated['contract_type'],
            'location' => $validated['location'] ?? null,
            'start_date' => $validated['start_date'] ?? null,
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            if ($jobOffer->image_path) {
                Storage::disk('public')->delete($jobOffer->image_path);
            }
            $data['image_path'] = $request->file('image')->store('job-offers', 'public');
        }

        $jobOffer->update($data);

        return redirect()->route('job-offers.index')
            ->with('success', 'Offre mise à jour avec succès.');
    }

    /**
     * Close a job offer.
     */
    public function close(JobOffer $jobOffer): RedirectResponse
    {
        $this->authorize('update', $jobOffer);

        $jobOffer->close();

        return redirect()->route('job-offers.index')
            ->with('success', 'Offre clôturée avec succès.');
    }

    /**
     * View applications for a job offer.
     */
    public function applications(JobOffer $jobOffer): View
    {
        $this->authorize('view', $jobOffer);

        $applications = $jobOffer->applications()
            ->with(['candidate', 'candidate.candidateCv'])
            ->latest()
            ->paginate(20);

        return view('job-offers.applications', [
            'jobOffer' => $jobOffer,
            'applications' => $applications,
        ]);
    }

    /**
     * Delete a job offer.
     */
    public function destroy(JobOffer $jobOffer): RedirectResponse
    {
        $this->authorize('delete', $jobOffer);

        if ($jobOffer->image_path) {
            Storage::disk('public')->delete($jobOffer->image_path);
        }

        $jobOffer->delete();

        return redirect()->route('job-offers.index')
            ->with('success', 'Offre supprimée avec succès.');
    }
}
