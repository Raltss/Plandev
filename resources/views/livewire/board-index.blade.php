<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <flux:heading size="xl">My Boards</flux:heading>
        <flux:button wire:click="showCreateModal" variant="primary">New Board</flux:button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($boards as $board)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-indigo-500 p-6 relative">
                <div class="absolute top-2 right-2">
                    <flux:button wire:click="editBoard({{ $board->id }})" icon="pencil" variant="ghost" size="sm" />
                </div>

                <h3 class="text-lg font-bold text-zinc-900">{{ $board->title }}</h3>
                
                <div class="mt-4 flex justify-between items-center">
                    <a href="/boards/{{ $board->id }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
                        Open Board →
                    </a>
                    <span class="text-xs text-gray-400">
                        {{ $board->created_at->diffForHumans() }}
                    </span>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12 bg-gray-50 rounded-lg border-2 border-dashed border-zinc-300">
                <p class="text-gray-500">No boards found. Create your first one!</p>
            </div>
        @endforelse
    </div>

    <flux:modal name="board-modal" class="md:w-96">
        <form wire:submit="save" class="space-y-6">
            <flux:heading size="lg">{{ $editingBoard ? 'Edit Board' : 'Create Board' }}</flux:heading>
            <flux:input wire:model="title" label="Title" placeholder="e.g. Marketing Campaign" />
            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary">Save Board</flux:button>
            </div>
        </form>
    </flux:modal>
</div>