<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @forelse($boards as $board)
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-indigo-500 p-6">
            <h3 class="text-lg font-bold">{{ $board->title }}</h3>
            <p class="text-gray-500 text-sm mt-2">{{ $board->description }}</p>

            <div class="mt-4 flex justify-between items-center">
                <a href="#" class="text-indigo-600 hover:text-indigo-900 font-medium">
                    Open Board →
                </a>
                <span class="text-xs text-gray-400">
                    Created {{ $board->created_at->diffForHumans() }}
                </span>
            </div>
        </div>
    @empty
        <div class="col-span-3 text-center py-12 bg-gray-50 rounded-lg border-2 border-dashed">
            <p class="text-gray-500">
                No boards found. Create your first one!
            </p>
        </div>
    @endforelse
</div>
