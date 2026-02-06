<div class="animate-pulse">
    <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
        <div class="grid md:grid-cols-3 gap-4">
            <div class="md:col-span-2 h-10 bg-gray-200 rounded"></div>
            <div class="h-10 bg-gray-200 rounded"></div>
        </div>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @for($i = 0; $i < 6; $i++)
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="w-full h-40 bg-gray-200"></div>
                <div class="p-4 space-y-3">
                    <div class="h-5 bg-gray-200 rounded w-3/4"></div>
                    <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                    <div class="h-4 bg-gray-200 rounded w-full"></div>
                    <div class="h-10 bg-gray-200 rounded w-full"></div>
                </div>
            </div>
        @endfor
    </div>
</div>
