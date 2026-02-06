<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mes candidatures
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @forelse($applications as $application)
                        <div class="border-b border-gray-200 py-4 last:border-0">
                            <div class="flex items-start gap-4">
                                <img src="{{ Storage::url($application->jobOffer->image_path) }}" alt="{{ $application->jobOffer->title }}" class="w-16 h-16 object-cover rounded-lg">
                                
                                <div class="flex-1">
                                    <a href="{{ route('jobs.show', $application->jobOffer) }}" class="font-semibold text-gray-900 hover:text-blue-600">
                                        {{ $application->jobOffer->title }}
                                    </a>
                                    <p class="text-sm text-gray-500">{{ $application->jobOffer->company_name ?? 'Entreprise' }}</p>
                                    <p class="text-sm text-gray-600">{{ $application->jobOffer->contract_type }} • {{ $application->jobOffer->location ?? 'Non précisé' }}</p>
                                    <p class="text-xs text-gray-400 mt-1">Postulé le {{ $application->created_at->format('d/m/Y à H:i') }}</p>
                                </div>

                                <span class="px-2 py-1 text-xs rounded-full {{ $application->jobOffer->isOpen() ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $application->jobOffer->isOpen() ? 'Offre ouverte' : 'Offre clôturée' }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-8">Vous n'avez pas encore postulé à des offres.</p>
                    @endforelse
                </div>

                <div class="px-6 pb-6">
                    {{ $applications->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
