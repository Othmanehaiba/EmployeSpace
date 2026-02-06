<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $jobOffer->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('jobs.index') }}" class="text-gray-600 hover:text-gray-900">
                    ← Retour aux offres
                </a>
            </div>

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <img src="{{ Storage::url($jobOffer->image_path) }}" alt="{{ $jobOffer->title }}" class="w-full h-64 object-cover">
                
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $jobOffer->title }}</h1>
                            <p class="text-gray-600 mt-1">{{ $jobOffer->company_name ?? 'Entreprise' }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $jobOffer->isOpen() ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $jobOffer->isOpen() ? 'Ouverte' : 'Clôturée' }}
                        </span>
                    </div>

                    <div class="flex flex-wrap gap-4 mb-6 text-sm text-gray-600">
                        <span class="flex items-center gap-1">
                            📄 {{ $jobOffer->contract_type }}
                        </span>
                        @if($jobOffer->location)
                            <span class="flex items-center gap-1">
                                📍 {{ $jobOffer->location }}
                            </span>
                        @endif
                        @if($jobOffer->start_date)
                            <span class="flex items-center gap-1">
                                📅 Début : {{ $jobOffer->start_date->format('d/m/Y') }}
                            </span>
                        @endif
                    </div>

                    <div class="prose max-w-none mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Description du poste</h3>
                        <div class="text-gray-700 whitespace-pre-line">{{ $jobOffer->description }}</div>
                    </div>

                    @if($jobOffer->isOpen())
                        @if($hasApplied)
                            <div class="p-4 bg-blue-50 rounded-lg text-blue-800">
                                ✅ Vous avez déjà postulé à cette offre.
                            </div>
                        @else
                            <div class="border-t pt-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Postuler à cette offre</h3>
                                <form method="POST" action="{{ route('jobs.apply', $jobOffer) }}">
                                    @csrf
                                    <div class="mb-4">
                                        <x-input-label for="message" value="Message de motivation (optionnel)" />
                                        <textarea id="message" name="message" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Présentez-vous brièvement et expliquez pourquoi vous êtes intéressé par ce poste...">{{ old('message') }}</textarea>
                                        <x-input-error :messages="$errors->get('message')" class="mt-2" />
                                    </div>
                                    <x-primary-button>Envoyer ma candidature</x-primary-button>
                                </form>
                            </div>
                        @endif
                    @else
                        <div class="p-4 bg-gray-100 rounded-lg text-gray-600">
                            Cette offre est clôturée et n'accepte plus de candidatures.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
