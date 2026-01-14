<div>
    @if($isOpen)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Are you sure to delete this board?</h3>
                <button wire:click="closeModal" class="text-gray-500 hover:text-gray-700 text-2xl">
                    ✕
                </button>
            </div>
                
                <div class="flex gap-2 justify-end">
                    <button 
                        type="button"
                        wire:click="closeModal"
                        class="px-4 py-2 border rounded-md hover:bg-gray-50">
                        Cancel
                    </button>
                    <button 
                        type="button"
                        wire:click="delete"
                        class="px-4 py-2 border bg-red-600 text-white rounded-md">
                        Delete
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>