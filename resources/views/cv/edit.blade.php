<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier mon CV
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('cv.show') }}" class="text-gray-600 hover:text-gray-900">
                    ← Voir mon CV
                </a>
            </div>

            <livewire:manage-cv :cv="$cv" />
        </div>
    </div>
</x-app-layout>
