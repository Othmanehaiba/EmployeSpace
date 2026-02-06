<div>
    <form action="{{ route('dashboard') }}" method="GET" class="flex gap-2">
        <input
            type="text"
            name="q"
            value="{{ request('q') }}"
            placeholder="Rechercher un utilisateur..."
            class="flex-1 px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
        />
        <button type="submit" class="px-4 py-2 bg-gray-800 text-white text-sm font-semibold rounded-md hover:bg-gray-700">
            Rechercher
        </button>
    </form>
</div>
