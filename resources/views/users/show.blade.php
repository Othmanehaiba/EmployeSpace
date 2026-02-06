<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Profil utilisateur
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-3">
                <p class="text-lg font-semibold text-gray-900">{{ $user->name }}</p>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>

                <div class="pt-3 border-t">
                    <p class="text-sm text-gray-700"><span class="font-semibold">Spécialité:</span> {{ $user->speciallity }}</p>
                    <p class="text-sm text-gray-700"><span class="font-semibold">Bio:</span> {{ $user->bio }}</p>
                </div>

                <div class="pt-3">
                    <a href="{{ route('dashboard') }}" class="text-sm underline text-gray-600">
                        ← Retour au dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
