<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mon CV
            </h2>
            <a href="{{ route('cv.edit') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                Modifier
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(!$cv)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 text-center">
                    <p class="text-gray-500 mb-4">Vous n'avez pas encore créé votre CV.</p>
                    <a href="{{ route('cv.edit') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Créer mon CV
                    </a>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <!-- Header -->
                    <div class="p-6 border-b">
                        <div class="flex items-center gap-4">
                            @if($user->photo)
                                <img src="{{ Storage::url($user->photo) }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-full object-cover">
                            @else
                                <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-2xl text-gray-500 font-semibold">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                                <p class="text-lg text-gray-600">{{ $cv->title }}</p>
                                @if($user->speciallity)
                                    <p class="text-sm text-gray-500">{{ $user->speciallity }}</p>
                                @endif
                            </div>
                        </div>
                        @if($cv->summary)
                            <p class="mt-4 text-gray-700">{{ $cv->summary }}</p>
                        @endif
                    </div>

                    <!-- Experiences -->
                    <div class="p-6 border-b">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">💼 Expériences professionnelles</h2>
                        @forelse($cv->experiences as $exp)
                            <div class="mb-4 last:mb-0">
                                <h3 class="font-semibold text-gray-900">{{ $exp->position }}</h3>
                                <p class="text-gray-600">{{ $exp->company }}</p>
                                <p class="text-sm text-gray-500">
                                    {{ $exp->start_date?->format('M Y') ?? '?' }} - {{ $exp->end_date?->format('M Y') ?? 'Présent' }}
                                </p>
                                @if($exp->description)
                                    <p class="text-sm text-gray-700 mt-1">{{ $exp->description }}</p>
                                @endif
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">Aucune expérience ajoutée.</p>
                        @endforelse
                    </div>

                    <!-- Education -->
                    <div class="p-6 border-b">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">🎓 Formation</h2>
                        @forelse($cv->educations as $edu)
                            <div class="mb-4 last:mb-0">
                                <h3 class="font-semibold text-gray-900">{{ $edu->degree }}</h3>
                                <p class="text-gray-600">{{ $edu->school }}</p>
                                <p class="text-sm text-gray-500">
                                    {{ $edu->start_year ?? '?' }} - {{ $edu->end_year ?? 'Présent' }}
                                </p>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">Aucune formation ajoutée.</p>
                        @endforelse
                    </div>

                    <!-- Skills -->
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">🛠️ Compétences</h2>
                        @if($cv->skills->count() > 0)
                            <div class="flex flex-wrap gap-2">
                                @foreach($cv->skills as $skill)
                                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">{{ $skill->name }}</span>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-sm">Aucune compétence ajoutée.</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
