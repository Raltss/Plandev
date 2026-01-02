<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Board;
use Illuminate\Support\Facades\Auth;
use Flux\Flux;

class BoardIndex extends Component
{
    public $title = '';
    public ?Board $editingBoard = null; // Holds the board we are currently editing

    // This clears the form and opens the "Create" modal
    public function showCreateModal()
    {
        $this->reset('title', 'editingBoard');
        Flux::modal('board-modal')->show();
    }

    // This fills the form and opens the "Edit" modal
    public function editBoard(Board $board)
    {
        $this->editingBoard = $board;
        $this->title = $board->title;
        Flux::modal('board-modal')->show();
    }

    public function save()
    {
        $this->validate(['title' => 'required|min:3']);

        if ($this->editingBoard) {
            $this->editingBoard->update(['title' => $this->title]);
        } else {
            Auth::user()->boards()->create(['title' => $this->title]);
        }

        $this->reset('title', 'editingBoard');
        Flux::modal('board-modal')->close();
    }

    public function render()
    {
        return view('livewire.board-index', [
            'boards' => Auth::user()->boards()->latest()->get()
        ]);
    }
}