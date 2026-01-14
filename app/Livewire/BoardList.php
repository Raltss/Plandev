<?php

namespace App\Livewire;

use App\Models\Board;
use Livewire\Component;

class BoardList extends Component
{
    protected $listeners = ['boardCreated' => '$refresh'];

    public function render()
    {
        return view('livewire.board-list', [
            'boards' => Board::where('user_id', auth()->id())->get()
        ]);
    }
}
