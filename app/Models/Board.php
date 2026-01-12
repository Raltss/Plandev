<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Board extends Model
{
    use LogsActivity;

    protected $fillable = ['title', 'description', 'user_id'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }

    public function lists()
    {
        return $this->hasMany(BoardList::class)->orderBy('position');
    }
}
