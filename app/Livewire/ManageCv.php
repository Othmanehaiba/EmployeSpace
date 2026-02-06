<?php

namespace App\Livewire;

use App\Models\CandidateCv;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Skill;
use Livewire\Component;

class ManageCv extends Component
{
    public CandidateCv $cv;

    public string $title = '';
    public string $summary = '';

    // Education form
    public string $edu_degree = '';
    public string $edu_school = '';
    public ?int $edu_start_year = null;
    public ?int $edu_end_year = null;

    // Experience form
    public string $exp_position = '';
    public string $exp_company = '';
    public ?string $exp_start_date = null;
    public ?string $exp_end_date = null;
    public string $exp_description = '';

    // Skill form
    public string $skill_name = '';

    protected $rules = [
        'title' => 'required|string|max:255',
        'summary' => 'nullable|string|max:2000',
    ];

    public function mount(CandidateCv $cv)
    {
        $this->cv = $cv;
        $this->title = $cv->title ?? '';
        $this->summary = $cv->summary ?? '';
    }

    public function updateCv()
    {
        $this->validate();

        $this->cv->update([
            'title' => $this->title,
            'summary' => $this->summary,
        ]);

        session()->flash('cv-updated', 'CV mis à jour avec succès.');
    }

    // Education CRUD
    public function addEducation()
    {
        $this->validate([
            'edu_degree' => 'required|string|max:255',
            'edu_school' => 'required|string|max:255',
            'edu_start_year' => 'nullable|integer|min:1950|max:2030',
            'edu_end_year' => 'nullable|integer|min:1950|max:2030',
        ]);

        $this->cv->educations()->create([
            'degree' => $this->edu_degree,
            'school' => $this->edu_school,
            'start_year' => $this->edu_start_year,
            'end_year' => $this->edu_end_year,
        ]);

        $this->reset(['edu_degree', 'edu_school', 'edu_start_year', 'edu_end_year']);
        $this->cv->refresh();
    }

    public function removeEducation(int $educationId)
    {
        Education::where('id', $educationId)
            ->where('candidate_cv_id', $this->cv->id)
            ->delete();

        $this->cv->refresh();
    }

    // Experience CRUD
    public function addExperience()
    {
        $this->validate([
            'exp_position' => 'required|string|max:255',
            'exp_company' => 'required|string|max:255',
            'exp_start_date' => 'nullable|date',
            'exp_end_date' => 'nullable|date',
            'exp_description' => 'nullable|string|max:2000',
        ]);

        $this->cv->experiences()->create([
            'position' => $this->exp_position,
            'company' => $this->exp_company,
            'start_date' => $this->exp_start_date,
            'end_date' => $this->exp_end_date,
            'description' => $this->exp_description,
        ]);

        $this->reset(['exp_position', 'exp_company', 'exp_start_date', 'exp_end_date', 'exp_description']);
        $this->cv->refresh();
    }

    public function removeExperience(int $experienceId)
    {
        Experience::where('id', $experienceId)
            ->where('candidate_cv_id', $this->cv->id)
            ->delete();

        $this->cv->refresh();
    }

    // Skills CRUD
    public function addSkill()
    {
        $this->validate([
            'skill_name' => 'required|string|max:100',
        ]);

        // Find or create skill
        $skill = Skill::firstOrCreate(['name' => trim($this->skill_name)]);

        // Attach to CV if not already attached
        if (!$this->cv->skills->contains($skill->id)) {
            $this->cv->skills()->attach($skill->id);
        }

        $this->reset('skill_name');
        $this->cv->refresh();
    }

    public function removeSkill(int $skillId)
    {
        $this->cv->skills()->detach($skillId);
        $this->cv->refresh();
    }

    public function render()
    {
        return view('livewire.manage-cv', [
            'educations' => $this->cv->educations,
            'experiences' => $this->cv->experiences,
            'skills' => $this->cv->skills,
        ]);
    }
}
