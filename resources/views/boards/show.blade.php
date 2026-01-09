<x-app-layout>
    <div class="py-6">
        <div class="max-w-full mx-auto px-4">
            <h1 class="text-2xl font-bold text-white mb-2">{{ $board->title }}</h1>
            @if($board->description)
                <p class="text-gray-300 mb-6">{{ $board->description }}</p>
            @endif
            
            @livewire('board-view', ['board' => $board])
        </div>
    </div>
</x-app-layout>