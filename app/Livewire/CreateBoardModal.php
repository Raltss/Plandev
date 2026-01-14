<?php

namespace App\Livewire;

use App\Models\Board;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CreateBoardModal extends Component
{
    public $isOpen = false;

    public $title = '';

    public $description = '';

    protected $listeners = ['openCreateModal' => 'openModal'];

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->reset(['title', 'description']);
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'nullable|max:1000',
        ]);

        Board::create([
            'title' => $this->title,
            'description' => $this->description,
            'user_id' => Auth::id(),
        ]);

        $this->dispatch('boardCreated');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.create-board-modal');
    }
}
