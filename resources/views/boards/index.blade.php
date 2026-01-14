<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between mb-8">
                <h2 class="font-semibold text-xl text-white leading-tight">
                    {{ __('My Boards') }}
                </h2>
                <button 
                    x-data 
                    @click="$dispatch('openCreateModal')"
                    class="font-semibold text-lg text-white leading-tight">
                    Create
                </button>
            </div>
            @livewire('board-list')
        </div>
    </div>

    @livewire('create-board-modal')
</x-app-layout>