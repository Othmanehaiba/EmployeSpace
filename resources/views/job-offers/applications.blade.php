<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Candidatures pour : {{ $jobOffer->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('job-offers.index') }}" class="text-gray-600 hover:text-gray-900">
                    ← Retour aux offres
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <h3 class="font-semibold text-gray-800">{{ $jobOffer->title }}</h3>
                        <p class="text-sm text-gray-500">{{ $jobOffer->contract_type }} • {{ $jobOffer->location ?? 'Non précisé' }}</p>
                        <span class="inline-block mt-2 px-2 py-1 text-xs rounded-full {{ $jobOffer->isOpen() ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $jobOffer->isOpen() ? 'Ouverte' : 'Clôturée' }}
                        </span>
                    </div>

                    <h4 class="font-semibold text-gray-700 mb-4">{{ $applications->total() }} candidature(s)</h4>

                    @forelse($applications as $application)
                        <div class="border-b border-gray-200 py-4 last:border-0">
                            <div class="flex items-start gap-4">
                                @if($application->candidate->photo)
                                    <img src="{{ Storage::url($application->candidate->photo) }}" alt="{{ $application->candidate->name }}" class="w-12 h-12 rounded-full object-cover">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-500 font-semibold">{{ substr($application->candidate->name, 0, 1) }}</span>
                                    </div>
                                @endif

                                <div class="flex-1">
                                    <a href="{{ route('users.show', $application->candidate) }}" class="font-semibold text-gray-900 hover:text-blue-600">
                                        {{ $application->candidate->name }}
                                    </a>
                                    <p class="text-sm text-gray-500">{{ $application->candidate->email }}</p>
                                    @if($application->candidate->candidateCv)
                                        <p class="text-sm text-gray-600">{{ $application->candidate->candidateCv->title }}</p>
                                    @endif
                                    <p class="text-xs text-gray-400 mt-1">Postulé le {{ $application->created_at->format('d/m/Y à H:i') }}</p>
                                    
                                    @if($application->message)
                                        <div class="mt-2 p-3 bg-gray-50 rounded text-sm text-gray-700">
                                            <strong>Message :</strong> {{ $application->message }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-8">Aucune candidature reçue pour cette offre.</p>
                    @endforelse
                </div>

                <div class="px-6 pb-6">
                    {{ $applications->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
