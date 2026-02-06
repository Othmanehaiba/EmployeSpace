<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class SearchUsers extends Component
{
    public string $query = '';
    public $results = [];

    public function updatedQuery()
    {
        if (strlen($this->query) >= 2) {
            $this->results = User::where('id', '!=', auth()->id())
                ->where(function ($q) {
                    $q->where('name', 'like', "%{$this->query}%")
                      ->orWhere('email', 'like', "%{$this->query}%")
                      ->orWhere('speciallity', 'like', "%{$this->query}%");
                })
                ->limit(10)
                ->get();
        } else {
            $this->results = [];
        }
    }

    public function render()
    {
        return view('livewire.search-users');
    }
}
