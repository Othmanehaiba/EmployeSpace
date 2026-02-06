<div>
    <!-- Search & Filters -->
    <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
        <div class="grid md:grid-cols-3 gap-4">
            <div class="md:col-span-2">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Rechercher par titre, entreprise, lieu..." class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
            </div>
            <div>
                <select wire:model.live="contractType" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="">Tous les contrats</option>
                    @foreach($contractTypes as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Results -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($offers as $offer)
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                <img src="{{ Storage::url($offer->image_path) }}" alt="{{ $offer->title }}" class="w-full h-40 object-cover">
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 line-clamp-1">{{ $offer->title }}</h3>
                    <p class="text-sm text-gray-500">{{ $offer->company_name ?? 'Entreprise' }}</p>
                    <div class="flex flex-wrap gap-2 mt-2">
                        <span class="text-xs px-2 py-1 bg-gray-100 rounded-full text-gray-600">{{ $offer->contract_type }}</span>
                        @if($offer->location)
                            <span class="text-xs px-2 py-1 bg-gray-100 rounded-full text-gray-600">{{ $offer->location }}</span>
                        @endif
                    </div>
                    <p class="text-sm text-gray-600 mt-2 line-clamp-2">{{ Str::limit($offer->description, 100) }}</p>
                    <div class="mt-4">
                        <a href="{{ route('jobs.show', $offer) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 w-full justify-center">
                            Voir l'offre
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="md:col-span-2 lg:col-span-3 bg-white shadow-sm sm:rounded-lg p-8 text-center">
                <p class="text-gray-500">Aucune offre trouvée.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $offers->links() }}
    </div>
</div>
