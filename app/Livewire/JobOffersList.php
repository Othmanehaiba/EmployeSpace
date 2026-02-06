<?php

namespace App\Livewire;

use App\Models\JobOffer;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Lazy;

#[Lazy]
class JobOffersList extends Component
{
    use WithPagination;

    public string $search = '';
    public string $contractType = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'contractType' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingContractType()
    {
        $this->resetPage();
    }

    public function placeholder()
    {
        return view('livewire.job-offers-list-placeholder');
    }

    public function render()
    {
        $query = JobOffer::open()->with('recruteur');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'ilike', "%{$this->search}%")
                  ->orWhere('description', 'ilike', "%{$this->search}%")
                  ->orWhere('company_name', 'ilike', "%{$this->search}%")
                  ->orWhere('location', 'ilike', "%{$this->search}%");
            });
        }

        if ($this->contractType) {
            $query->where('contract_type', $this->contractType);
        }

        $offers = $query->latest()->paginate(12);

        return view('livewire.job-offers-list', [
            'offers' => $offers,
            'contractTypes' => JobOffer::CONTRACT_TYPES,
        ]);
    }
}
