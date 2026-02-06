<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard — Chercheur d'emploi
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <p class="text-gray-700">
                    Bonjour <span class="font-semibold">{{ $user->name }}</span> 👋
                </p>
                <p class="text-sm text-gray-500 mt-1">
                    Bienvenue sur votre espace candidat.
                </p>
            </div>

            <div class="grid sm:grid-cols-2 gap-6">
                <a href="{{ route('cv.show') }}" class="bg-white shadow-sm sm:rounded-lg p-6 hover:shadow-md transition-shadow block">
                    <h3 class="font-semibold text-gray-800">📄 Mon CV</h3>
                    <p class="text-sm text-gray-500 mt-1">Gérer mon profil, formations, expériences et compétences.</p>
                </a>

                <a href="{{ route('jobs.index') }}" class="bg-white shadow-sm sm:rounded-lg p-6 hover:shadow-md transition-shadow block">
                    <h3 class="font-semibold text-gray-800">💼 Offres d'emploi</h3>
                    <p class="text-sm text-gray-500 mt-1">Rechercher et consulter les offres, postuler.</p>
                </a>

                <a href="{{ route('applications.my') }}" class="bg-white shadow-sm sm:rounded-lg p-6 hover:shadow-md transition-shadow block">
                    <h3 class="font-semibold text-gray-800">📋 Mes candidatures</h3>
                    <p class="text-sm text-gray-500 mt-1">Suivre mes candidatures envoyées.</p>
                </a>

                <a href="{{ route('profile.edit') }}" class="bg-white shadow-sm sm:rounded-lg p-6 hover:shadow-md transition-shadow block">
                    <h3 class="font-semibold text-gray-800">⚙️ Mon profil</h3>
                    <p class="text-sm text-gray-500 mt-1">Modifier mes informations personnelles.</p>
                </a>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-6">
    <h3 class="font-semibold text-gray-800 text-lg">Friends</h3>

    {{-- Notifications --}}
    <div>
        <h4 class="font-semibold text-gray-700">Notifications</h4>

        @forelse($notifications as $notif)
            <div class="mt-3 p-4 border rounded-lg">
                <p class="text-sm text-gray-700">
                    {{ $notif->data['message'] ?? 'Notification' }} —
                    <span class="font-semibold">{{ $notif->data['sender_name'] ?? 'Utilisateur' }}</span>
                </p>

                <div class="mt-3 flex gap-2">
                    <form method="POST" action="{{ route('friends.request.accept', $notif->data['friend_request_id']) }}">
                        @csrf
                        <input type="hidden" name="notification_id" value="{{ $notif->id }}">
                        <button class="px-3 py-2 rounded-md bg-green-600 text-white text-sm">
                            Accepter
                        </button>
                    </form>

                    <form method="POST" action="{{ route('friends.request.reject', $notif->data['friend_request_id']) }}">
                        @csrf
                        <input type="hidden" name="notification_id" value="{{ $notif->id }}">
                        <button class="px-3 py-2 rounded-md bg-red-600 text-white text-sm">
                            Refuser
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-500 mt-2">Aucune notification.</p>
        @endforelse
    </div>

    {{-- Suggestions --}}
    <div>
        <h4 class="font-semibold text-gray-700">Ajouter des amis</h4>

        {{-- Search users --}}
        <div class="mt-4">
            <h4 class="font-semibold text-gray-700 mb-2">Rechercher un utilisateur</h4>
            <livewire:search-users />
        
            @if(!empty($q))
                <p class="text-xs text-gray-500 mt-2">Résultats pour: <span class="font-semibold">{{ $q }}</span></p>
        
                <div class="mt-3 grid sm:grid-cols-2 gap-3">
                    @forelse($results as $u)
                        <div class="p-4 border rounded-lg flex items-center justify-between">
                            <div>
                                <p class="font-semibold text-gray-800">{{ $u->name }}</p>
                                <p class="text-xs text-gray-500">{{ $u->speciallity }}</p>
                                <p class="text-xs text-gray-400">{{ $u->email }}</p>
                            </div>
        
                            <div class="flex gap-2">
                                <a href="{{ route('users.show', $u->id) }}" class="px-3 py-2 rounded-md border text-sm">
                                    Profil
                                </a>
        
                                <form method="POST" action="{{ route('friends.request.send', $u->id) }}">
                                    @csrf
                                    <button class="px-3 py-2 rounded-md bg-gray-900 text-white text-sm">
                                        Ajouter
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Aucun utilisateur trouvé.</p>
                    @endforelse
                </div>
            @endif
        </div>


        <div class="mt-3 grid sm:grid-cols-2 gap-3">
            @forelse($suggestions as $u)
                <div class="p-4 border rounded-lg flex items-center justify-between">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $u->name }}</p>
                        <p class="text-xs text-gray-500">{{ $u->speciallity }}</p>
                    </div>

                    <form method="POST" action="{{ route('friends.request.send', $u->id) }}">
                        @csrf
                        <button class="px-3 py-2 rounded-md bg-gray-900 text-white text-sm">
                            Ajouter
                        </button>
                    </form>
                </div>
            @empty
                <p class="text-sm text-gray-500">Aucune suggestion pour le moment.</p>
            @endforelse
        </div>
    </div>

    {{-- Friends list --}}
    <div>
        <h4 class="font-semibold text-gray-700">Mes amis</h4>

        <div class="mt-3 grid sm:grid-cols-2 gap-3">
            @forelse($friends as $f)
                <div class="p-4 border rounded-lg">
                    <p class="font-semibold text-gray-800">{{ $f->name }}</p>
                    <p class="text-xs text-gray-500">{{ $f->speciallity }}</p>
                </div>
            @empty
                <p class="text-sm text-gray-500">Tu n’as pas encore d’amis.</p>
            @endforelse
        </div>
    </div>
</div>


        </div>
    </div>
</x-app-layout>
