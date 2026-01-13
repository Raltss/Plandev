<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = ['title', 'description', 'board_list_id', 'due_date', 'position'];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function boardList()
    {
        return $this->belongsTo(BoardList::class);
    }
}
