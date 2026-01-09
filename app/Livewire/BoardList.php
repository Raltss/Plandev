<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Board;
use Illuminate\Support\Facades\Auth;

class BoardList extends Component
{
    protected $listeners = ['boardCreated' => '$refresh'];
    public function render()
    {
        return view('livewire.board-list', [
            'boards' => Board::latest()->get(),
        ]);
    }
}