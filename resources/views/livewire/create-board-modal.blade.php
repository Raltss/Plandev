<div>
    @if($isOpen)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Create New Board</h3>
                <button wire:click="closeModal" class="text-gray-500 hover:text-gray-700 text-2xl">
                    ✕
                </button>
            </div>
            
            <form wire:submit="save">
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Title</label>
                    <input 
                        type="text" 
                        wire:model="title"
                        class="w-full border rounded-md px-3 py-2"
                        placeholder="Enter board title">
                    @error('title') 
                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Description (optional)</label>
                    <textarea 
                        wire:model="description"
                        rows="3"
                        class="w-full border rounded-md px-3 py-2"
                        placeholder="Enter board description"></textarea>
                    @error('description') 
                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                    @enderror
                </div>
                
                <div class="flex gap-2 justify-end">
                    <button 
                        type="button"
                        wire:click="closeModal"
                        class="px-4 py-2 border rounded-md hover:bg-gray-50">
                        Cancel
                    </button>
                    <button 
                        type="submit"
                        class="px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800">
                        Create
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>