<?php

namespace App\Livewire;

use App\Models\Board;
use App\Models\BoardList;
use App\Models\Card;
use Livewire\Component;

class BoardView extends Component
{
    public $board;

    public $showListModal = false;

    public $showCardModal = false;

    public $showDeleteModal = false;

    public $listToDelete = null;

    public $listTitle = '';

    public $cardTitle = '';

    public $cardDescription = '';

    public $selectedListId = null;

    public $editingListId = null;

    public $editingListTitle = '';

    public $showEditCardModal = false;
    public $showDeleteCardModal = false;
    public $editingCardId = null;
    public $editingCardTitle = '';
    public $editingCardDescription = '';
    public $cardToDelete = null;
    public $editingCardDueDate = null;

    public function mount(Board $board)
    {
        $this->board = $board;
    }

    public function createList()
    {
        $this->validate([
            'listTitle' => 'required|min:1|max:255',
        ]);

        BoardList::create([
            'board_id' => $this->board->id,
            'title' => $this->listTitle,
            'position' => $this->board->lists()->count(),
        ]);

        $this->listTitle = '';
        $this->showListModal = false;
    }

    public function openCardModal($listId)
    {
        $this->selectedListId = $listId;
        $this->showCardModal = true;
    }

    public function createCard()
    {
        $this->validate([
            'cardTitle' => 'required|min:1|max:255',
        ]);

        $list = BoardList::find($this->selectedListId);

        Card::create([
            'board_list_id' => $this->selectedListId,
            'title' => $this->cardTitle,
            'description' => $this->cardDescription,
            'position' => $list->cards()->count(),
        ]);

        $this->cardTitle = '';
        $this->cardDescription = '';
        $this->showCardModal = false;
        $this->selectedListId = null;
    }

    public function render()
    {
        return view('livewire.board-view', [
            'lists' => $this->board->lists()->with('cards')->get(),
        ]);
    }

    public function startEditingList($listId, $currentTitle)
    {
        $this->editingListId = $listId;
        $this->editingListTitle = $currentTitle;
    }

    public function updateList()
    {
        $this->validate([
            'editingListTitle' => 'required|min:1|max:255',
        ]);

        $list = BoardList::find($this->editingListId);
        $list->update(['title' => $this->editingListTitle]);

        $this->editingListId = null;
        $this->editingListTitle = '';
    }

    public function cancelEditList()
    {
        $this->editingListId = null;
        $this->editingListTitle = '';
    }

    public function deleteList()
    {
        if ($this->listToDelete) {
            BoardList::find($this->listToDelete)->delete();
            $this->listToDelete = null;
            $this->showDeleteModal = false;
        }
    }

    public function deleteCardModal($listId)
    {
        $this->listToDelete = $listId;
        $this->showDeleteModal = true;
    }

    public function updateListOrder($orderedIds)
    {
        foreach ($orderedIds as $index => $id) {
            BoardList::where('id', $id)->update(['position' => $index]);
        }

    }

    public function updateCardOrder($listId, $orderedIds)
    {
        foreach ($orderedIds as $index => $id) {
            Card::where('id', $id)->update([
                'position' => $index,
                'board_list_id' => $listId,
            ]);
        }
    }

    public function openEditCardModal($cardId)
    {
        $card = Card::find($cardId);
        $this->editingCardId = $cardId;
        $this->editingCardTitle = $card->title;
        $this->editingCardDescription = $card->description ?? '';
        $this->editingCardDueDate = $card->due_date ? $card->due_date->format('Y-m-d') : '';
        $this->showEditCardModal = true;
    }

    public function updateCard()
    {
        $this->validate([
            'editingCardTitle' => 'required|min:1|max:255',
            'editingCardDescription' => 'nullable|max:1000',
            'editingCardDueDate' => 'nullable|date',
        ]);

        Card::find($this->editingCardId)->update([
            'title' => $this->editingCardTitle,
            'description' => $this->editingCardDescription,
            'due_date' => $this->editingCardDueDate,
        ]);

        $this->showEditCardModal = false;
        $this->reset(['editingCardId', 'editingCardTitle', 'editingCardDescription']);
    }

    public function openDeleteCardModal($cardId)
    {
        $this->cardToDelete = $cardId;
        $this->showDeleteCardModal = true;
    }

    public function deleteCard()
    {
        if ($this->cardToDelete) {
            Card::find($this->cardToDelete)->delete();
            $this->cardToDelete = null;
            $this->showDeleteCardModal = false;
        }
    }
}
