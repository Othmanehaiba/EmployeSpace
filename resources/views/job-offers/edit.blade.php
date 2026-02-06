<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier l'offre : {{ $jobOffer->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('job-offers.update', $jobOffer) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <x-input-label for="title" value="Titre du poste *" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $jobOffer->title)" required />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="contract_type" value="Type de contrat *" />
                            <select id="contract_type" name="contract_type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                @foreach($contractTypes as $key => $label)
                                    <option value="{{ $key }}" {{ old('contract_type', $jobOffer->contract_type) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('contract_type')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="location" value="Localisation" />
                            <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location', $jobOffer->location)" placeholder="Ex: Paris, Remote..." />
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="start_date" value="Date de début" />
                            <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full" :value="old('start_date', $jobOffer->start_date?->format('Y-m-d'))" />
                            <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="description" value="Description du poste *" />
                            <textarea id="description" name="description" rows="6" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('description', $jobOffer->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="image" value="Image du poste" />
                            <div class="mt-2 mb-2">
                                <img src="{{ Storage::url($jobOffer->image_path) }}" alt="Image actuelle" class="w-32 h-32 object-cover rounded-lg">
                                <p class="text-xs text-gray-500 mt-1">Image actuelle</p>
                            </div>
                            <input id="image" name="image" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200" />
                            <p class="text-xs text-gray-500 mt-1">Laisser vide pour conserver l'image actuelle</p>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('job-offers.index') }}" class="text-gray-600 hover:text-gray-900">Annuler</a>
                            <x-primary-button>Mettre à jour</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
