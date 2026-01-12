<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = ['board_list_id', 'title', 'description', 'position'];

    public function boardList()
    {
        return $this->belongsTo(BoardList::class);
    }
}
