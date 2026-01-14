<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Board;
use Illuminate\Support\Facades\Auth;

class DeleteBoardModal extends Component
{
    public $isOpen = false;
    public $board;
    protected $listeners = ['openDeleteBoardModal' => 'openModal'];

    public function mount(Board $board)
    {
        $this->board = $board;
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function delete()
    {
        // Make sure user owns the board
        if ($this->board && $this->board->user_id === Auth::id()) {
            $this->board->delete();
            return redirect()->route('boards.index');
        }
    }

    public function render()
    {
        return view('livewire.delete-board-modal');
    }
}