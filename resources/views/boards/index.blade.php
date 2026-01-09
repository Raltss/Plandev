<x-app-layout>
    <x-page-header>
      <button 
            x-data 
            @click="$dispatch('openCreateModal')"
            class="font-semibold text-xl leading-tight bg-black text-white p-2 rounded-md">
            CREATE
        </button>
    </x-page-header>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-white leading-tight mb-8">
                {{ __('My Boards') }}
            </h2>
            @livewire('board-list')
        </div>
    </div>

    @livewire('create-board-modal')
</x-app-layout>