<div>
    <div class="relative">
        <input
            type="text"
            wire:model.live.debounce.300ms="query"
            placeholder="Rechercher un utilisateur..."
            class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
        />

        @if(strlen($query) >= 2)
            <div class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-md shadow-lg max-h-64 overflow-y-auto">
                @forelse($results as $user)
                    <a href="{{ route('users.show', $user) }}" class="flex items-center gap-3 p-3 hover:bg-gray-50 border-b last:border-b-0">
                        @if($user->photo)
                            <img src="{{ Storage::url($user->photo) }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover">
                        @else
                            <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                <span class="text-sm text-gray-500 font-semibold">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                        @endif
                        <div>
                            <p class="font-semibold text-gray-800 text-sm">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $user->speciallity ?? $user->email }}</p>
                        </div>
                        @if(!auth()->user()->friends->contains($user->id) && !auth()->user()->hasPendingFriendRequestTo($user))
                            <form action="{{ route('friends.request.send', $user) }}" method="POST" class="ml-auto" onclick="event.stopPropagation();">
                                @csrf
                                <button type="submit" class="px-2 py-1 text-xs bg-indigo-600 text-white rounded hover:bg-indigo-700">
                                    Ajouter
                                </button>
                            </form>
                        @endif
                    </a>
                @empty
                    <p class="p-3 text-sm text-gray-500">Aucun utilisateur trouvé.</p>
                @endforelse
            </div>
        @endif
    </div>
</div>
