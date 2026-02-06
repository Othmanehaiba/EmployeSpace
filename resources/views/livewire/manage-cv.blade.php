<div class="space-y-6">
    <!-- CV Info -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Informations générales</h3>
        
        @if(session('cv-updated'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('cv-updated') }}
            </div>
        @endif

        <form wire:submit="updateCv">
            <div class="mb-4">
                <x-input-label for="title" value="Titre du profil *" />
                <x-text-input wire:model="title" id="title" type="text" class="mt-1 block w-full" placeholder="Ex: Développeur Fullstack, Comptable Senior..." />
                @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <x-input-label for="summary" value="Résumé / À propos" />
                <textarea wire:model="summary" id="summary" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Présentez-vous brièvement..."></textarea>
                @error('summary') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <x-primary-button>Enregistrer</x-primary-button>
        </form>
    </div>

    <!-- Experiences -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">💼 Expériences professionnelles</h3>

        @foreach($experiences as $exp)
            <div class="flex items-start justify-between mb-3 p-3 bg-gray-50 rounded-lg">
                <div>
                    <p class="font-semibold text-gray-900">{{ $exp->position }}</p>
                    <p class="text-sm text-gray-600">{{ $exp->company }}</p>
                    <p class="text-xs text-gray-500">{{ $exp->start_date?->format('M Y') ?? '?' }} - {{ $exp->end_date?->format('M Y') ?? 'Présent' }}</p>
                </div>
                <button wire:click="removeExperience({{ $exp->id }})" class="text-red-600 hover:text-red-800 text-sm">
                    Supprimer
                </button>
            </div>
        @endforeach

        <div class="border-t pt-4 mt-4">
            <p class="text-sm font-medium text-gray-700 mb-2">Ajouter une expérience</p>
            <div class="grid md:grid-cols-2 gap-3">
                <div>
                    <x-text-input wire:model="exp_position" type="text" class="w-full" placeholder="Poste *" />
                    @error('exp_position') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <x-text-input wire:model="exp_company" type="text" class="w-full" placeholder="Entreprise *" />
                    @error('exp_company') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <x-text-input wire:model="exp_start_date" type="date" class="w-full" />
                </div>
                <div>
                    <x-text-input wire:model="exp_end_date" type="date" class="w-full" placeholder="Laisser vide si en cours" />
                </div>
                <div class="md:col-span-2">
                    <textarea wire:model="exp_description" rows="2" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm" placeholder="Description (optionnel)"></textarea>
                </div>
            </div>
            <button wire:click="addExperience" type="button" class="mt-3 inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200">
                + Ajouter
            </button>
        </div>
    </div>

    <!-- Education -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">🎓 Formation</h3>

        @foreach($educations as $edu)
            <div class="flex items-start justify-between mb-3 p-3 bg-gray-50 rounded-lg">
                <div>
                    <p class="font-semibold text-gray-900">{{ $edu->degree }}</p>
                    <p class="text-sm text-gray-600">{{ $edu->school }}</p>
                    <p class="text-xs text-gray-500">{{ $edu->start_year ?? '?' }} - {{ $edu->end_year ?? 'Présent' }}</p>
                </div>
                <button wire:click="removeEducation({{ $edu->id }})" class="text-red-600 hover:text-red-800 text-sm">
                    Supprimer
                </button>
            </div>
        @endforeach

        <div class="border-t pt-4 mt-4">
            <p class="text-sm font-medium text-gray-700 mb-2">Ajouter une formation</p>
            <div class="grid md:grid-cols-2 gap-3">
                <div>
                    <x-text-input wire:model="edu_degree" type="text" class="w-full" placeholder="Diplôme *" />
                    @error('edu_degree') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <x-text-input wire:model="edu_school" type="text" class="w-full" placeholder="École *" />
                    @error('edu_school') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <x-text-input wire:model="edu_start_year" type="number" min="1950" max="2030" class="w-full" placeholder="Année début" />
                </div>
                <div>
                    <x-text-input wire:model="edu_end_year" type="number" min="1950" max="2030" class="w-full" placeholder="Année fin" />
                </div>
            </div>
            <button wire:click="addEducation" type="button" class="mt-3 inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200">
                + Ajouter
            </button>
        </div>
    </div>

    <!-- Skills -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">🛠️ Compétences</h3>

        <div class="flex flex-wrap gap-2 mb-4">
            @foreach($skills as $skill)
                <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">
                    {{ $skill->name }}
                    <button wire:click="removeSkill({{ $skill->id }})" class="ml-2 text-red-500 hover:text-red-700">&times;</button>
                </span>
            @endforeach
        </div>

        <div class="flex gap-2">
            <x-text-input wire:model="skill_name" type="text" class="flex-1" placeholder="Nouvelle compétence (ex: Laravel, Excel, Anglais...)" />
            <button wire:click="addSkill" type="button" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200">
                + Ajouter
            </button>
        </div>
        @error('skill_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>
</div>
