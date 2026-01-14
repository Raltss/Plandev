<div class="p-6">
    <div 
        x-data="{
            init() {
                let el = this.$refs.listsContainer;
                Sortable.create(el, {
                    animation: 100,
                    handle: '.list-header',
                    ghostClass: 'opacity-40',
                    draggable: '.sortable-list',
                    onEnd: (evt) => {
                        let order = Array.from(el.children)
                            .filter(child => child.dataset.listId)
                            .map(child => parseInt(child.dataset.listId));
                        $wire.updateListOrder(order);
                    }
                });
            }
        }"
        x-ref="listsContainer"
        class="flex items-start gap-4 overflow-x-auto pb-4">
        
        @foreach($lists as $list)
            <div data-list-id="{{ $list->id }}" class="sortable-list bg-gray-100 rounded-lg p-4 min-w-[300px] max-w-[300px] flex-shrink-0 flex flex-col max-h-[calc(82vh-150px)]">
                <!-- List Header with drag handle -->
                <div class="list-header mb-4 cursor-move flex-shrink-0">
                    @if($editingListId === $list->id)
                        <!-- Edit Mode -->
                        <form wire:submit="updateList" class="flex gap-2">
                            <input 
                                type="text" 
                                wire:model="editingListTitle"
                                class="flex-1 border rounded px-2 py-1 text-lg font-semibold"
                                autofocus>
                            <button type="submit" class="text-green-600 hover:text-green-800">
                                ✓
                            </button>
                            <button 
                                type="button" 
                                wire:click="cancelEditList"
                                class="text-red-600 hover:text-red-800">
                                ✕
                            </button>
                        </form>
                    @else
                        <!-- View Mode -->
                        <div class="flex justify-between items-start gap-2">
                            <h3 class="font-semibold text-lg break-words flex-1 min-w-0">{{ $list->title }}</h3>
                            <div x-data="{ open: false }" class="relative flex-shrink-0">
                                <button @click="open = !open" class="text-gray-500 hover:text-gray-700 p-1">
                                    ⋯
                                </button>
                                <div 
                                    x-show="open" 
                                    @click.away="open = false"
                                    class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg z-10 py-1">
                                    <button 
                                        wire:click="startEditingList({{ $list->id }}, '{{ $list->title }}')"
                                        @click="open = false"
                                        class="block w-full text-left px-4 py-2 hover:bg-gray-100">
                                        Rename list
                                    </button>
                                    <button 
                                        wire:click="deleteCardModal({{ $list->id }})"
                                        @click="open = false"
                                        class="block w-full text-left px-4 py-2 hover:bg-gray-100 text-red-600">
                                        Delete list
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Cards with Sortable -->
                <div 
                    x-data="{
                        init() {
                            let el = this.$el;
                            let listId = {{ $list->id }};
                            Sortable.create(el, {
                                group: 'cards',
                                animation: 150,
                                ghostClass: 'opacity-50',
                                onEnd: (evt) => {
                                    // Get the NEW list ID from the container the card was dropped into
                                    let newListId = parseInt(evt.to.closest('[data-list-id]').dataset.listId);
                                    let order = Array.from(evt.to.children)
                                        .map(child => parseInt(child.dataset.cardId));
                                    $wire.updateCardOrder(newListId, order);
                                }
                            });
                        }
                    }"
                    class=" overflow-y-auto flex-1 mb-4 {{ count($list->cards) > 0 ? 'space-y-2' : '' }}">
                    @foreach($list->cards as $card)
                        <div 
                            data-card-id="{{ $card->id }}" 
                            wire:click="openEditCardModal({{ $card->id }})"
                            class="bg-white p-3 rounded shadow-sm hover:shadow-md transition cursor-pointer">
                            <h4 class="font-medium truncate">{{ $card->title }}</h4>
                            @if($card->due_date)
                                <div class="flex items-center gap-1 mt-2 text-xs text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ \Carbon\Carbon::parse($card->due_date)->format('M d, Y') }}
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>

                <button 
                    wire:click="openCardModal({{ $list->id }})"
                    class="w-full text-left text-gray-600 hover:bg-gray-200 p-2 rounded flex-shrink-0">
                    + Add a card
                </button>
            </div>
        @endforeach

        <button 
            wire:click="$set('showListModal', true)"
            class="bg-gray-100 hover:bg-gray-200 rounded-lg p-4 min-w-[300px] max-w-[300px] max-h-[60px] flex-shrink-0 text-gray-600 font-medium">
            + Add another list
        </button>
    </div>

    <!-- Create List Modal -->
    @if($showListModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                <h3 class="text-xl font-semibold mb-4">Create List</h3>
                
                <form wire:submit="createList">
                    <input 
                        type="text" 
                        wire:model="listTitle"
                        class="w-full border rounded-md px-3 py-2 mb-4"
                        placeholder="Enter list title"
                        autofocus>
                    @error('listTitle') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    
                    <div class="flex gap-2 justify-end">
                        <button 
                            type="button"
                            wire:click="$set('showListModal', false)"
                            class="px-4 py-2 border rounded-md">
                            Cancel
                        </button>
                        <button 
                            type="submit"
                            class="px-4 py-2 bg-black text-white rounded-md">
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Create Card Modal -->
    @if($showCardModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                <h3 class="text-xl font-semibold mb-4">Create Card</h3>
                
                <form wire:submit="createCard">
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Title</label>
                        <input 
                            type="text" 
                            wire:model="cardTitle"
                            class="w-full border rounded-md px-3 py-2"
                            placeholder="Enter card title">
                        @error('cardTitle') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Description (optional)</label>
                        <textarea 
                            wire:model="cardDescription"
                            rows="3"
                            class="w-full border rounded-md px-3 py-2"
                            placeholder="Enter card description"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Due Date (optional)</label>
                        <input 
                            type="date" 
                            wire:model="cardDueDate"
                            class="w-full border rounded-md px-3 py-2">
                        @error('cardDueDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="flex gap-2 justify-end">
                        <button 
                            type="button"
                            wire:click="$set('showCardModal', false)"
                            class="px-4 py-2 border rounded-md">
                            Cancel
                        </button>
                        <button 
                            type="submit"
                            class="px-4 py-2 bg-black text-white rounded-md">
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Delete List Modal -->
    @if($showDeleteModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                <h3 class="text-xl font-semibold mb-4">Are you sure you want to delete this list?</h3>
                <p class="text-gray-600 mb-6">All cards in this list will also be deleted.</p>
                            
                <div class="flex gap-2 justify-end">
                    <button 
                        type="button"
                        wire:click="$set('showDeleteModal', false)"
                        class="px-4 py-2 border rounded-md">
                        No
                    </button>
                    <button 
                        wire:click="deleteList"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Yes, Delete
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Edit Card Modal -->
    @if($showEditCardModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold">Edit Card</h3>
                    <button 
                        wire:click="$set('showEditCardModal', false)"
                        class="text-gray-500 hover:text-gray-700">
                        ✕
                    </button>
                </div>
                
                <form wire:submit="updateCard">
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Title</label>
                        <input 
                            type="text" 
                            wire:model="editingCardTitle"
                            class="w-full border rounded-md px-3 py-2"
                            placeholder="Enter card title">
                        @error('editingCardTitle') 
                            <span class="text-red-500 text-sm">{{ $message }}</span> 
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Description</label>
                        <textarea 
                            wire:model="editingCardDescription"
                            rows="4"
                            class="w-full border rounded-md px-3 py-2"
                            placeholder="Enter card description"></textarea>
                        @error('editingCardDescription') 
                            <span class="text-red-500 text-sm">{{ $message }}</span> 
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Due Date (optional)</label>
                        <input 
                            type="date" 
                            wire:model="editingCardDueDate"
                            class="w-full border rounded-md px-3 py-2">
                        @error('editingCardDueDate') 
                            <span class="text-red-500 text-sm">{{ $message }}</span> 
                        @enderror
                    </div>
                    
                    <div class="flex gap-2 justify-between">
                        <button 
                            type="button"
                            wire:click="openDeleteCardModal({{ $editingCardId }})"
                            class="px-4 py-2 text-red-600 hover:bg-red-50 rounded-md">
                            Delete Card
                        </button>
                        <div class="flex gap-2">
                            <button 
                                type="button"
                                wire:click="$set('showEditCardModal', false)"
                                class="px-4 py-2 border rounded-md">
                                Cancel
                            </button>
                            <button 
                                type="submit"
                                class="px-4 py-2 bg-black text-white rounded-md">
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Delete Card Modal -->
    @if($showDeleteCardModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                <h3 class="text-xl font-semibold mb-4">Delete Card?</h3>
                <p class="text-gray-600 mb-6">Are you sure you want to delete this card? This action cannot be undone.</p>
                            
                <div class="flex gap-2 justify-end">
                    <button 
                        type="button"
                        wire:click="$set('showDeleteCardModal', false)"
                        class="px-4 py-2 border rounded-md">
                        Cancel
                    </button>
                    <button 
                        wire:click="deleteCard"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>