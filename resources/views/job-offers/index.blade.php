<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mes offres d'emploi
            </h2>
            <a href="{{ route('job-offers.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                + Nouvelle offre
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @forelse($offers as $offer)
                        <div class="border-b border-gray-200 py-4 last:border-0 flex items-start gap-4">
                            <img src="{{ Storage::url($offer->image_path) }}" alt="{{ $offer->title }}" class="w-20 h-20 object-cover rounded-lg">
                            
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <h3 class="font-semibold text-lg text-gray-900">{{ $offer->title }}</h3>
                                    <span class="px-2 py-1 text-xs rounded-full {{ $offer->isOpen() ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $offer->isOpen() ? 'Ouverte' : 'Clôturée' }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500">{{ $offer->contract_type }} • {{ $offer->location ?? 'Non précisé' }}</p>
                                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($offer->description, 150) }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $offer->applications_count }} candidature(s)</p>
                            </div>

                            <div class="flex flex-col gap-2">
                                <a href="{{ route('job-offers.applications', $offer) }}" class="text-sm text-blue-600 hover:underline">
                                    Voir candidatures
                                </a>
                                @if($offer->isOpen())
                                    <a href="{{ route('job-offers.edit', $offer) }}" class="text-sm text-gray-600 hover:underline">
                                        Modifier
                                    </a>
                                    <form method="POST" action="{{ route('job-offers.close', $offer) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-sm text-orange-600 hover:underline" onclick="return confirm('Clôturer cette offre ?')">
                                            Clôturer
                                        </button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('job-offers.destroy', $offer) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-600 hover:underline" onclick="return confirm('Supprimer cette offre ?')">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-8">Vous n'avez pas encore créé d'offre d'emploi.</p>
                    @endforelse
                </div>

                <div class="px-6 pb-6">
                    {{ $offers->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
