<div class="p-6">
    <div class="flex gap-4 overflow-x-auto pb-4">
        @foreach($lists as $list)
            <div class="bg-gray-100 rounded-lg p-4 min-w-[300px] max-w-[300px] flex-shrink-0">
                <!-- List Header -->
                <div class="mb-4">
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
                        <div class="flex justify-between items-center">
                            <h3 class="font-semibold text-lg">{{ $list->title }}</h3>
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="text-gray-500 hover:text-gray-700 p-1">
                                    ⋯
                                </button>
                                <div 
                                    x-show="open" 
                                    @click.away="open = false"
                                    class="absolute right-0 w-48 bg-white rounded-lg shadow-lg z-10 py-1">
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
                
                <!-- Cards -->
                <div class="space-y-2 mb-4">
                    @foreach($list->cards as $card)
                        <div class="bg-white p-3 rounded shadow-sm hover:shadow-md transition">
                            <h4 class="font-medium">{{ $card->title }}</h4>
                            @if($card->description)
                                <p class="text-sm text-gray-600 mt-1">{{ $card->description }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>

                <button 
                    wire:click="openCardModal({{ $list->id }})"
                    class="w-full text-left text-gray-600 hover:bg-gray-200 p-2 rounded">
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