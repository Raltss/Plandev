<x-app-layout>
    <div class="py-6">
        <div class="max-w-full mx-auto px-4">
            <div class="flex justify-between items-start px-6 mb-2 mt-4"> 
                <div>
                    <h1 class="text-2xl font-bold text-white mb-2">{{ $board->title }}</h1>
                    @if($board->description)
                        <p class="text-gray-300 mb-6">{{ $board->description }}</p>
                    @endif
                </div>
                <button 
                    x-data 
                    @click="$dispatch('openDeleteBoardModal')" 
                    class="text-red-500 mt-4 mx-6">
                    Delete Board
                </button>
            </div>
            
            @livewire('board-view', ['board' => $board])
            @livewire('delete-board-modal', ['board' => $board])
        </div>
    </div>
</x-app-layout>