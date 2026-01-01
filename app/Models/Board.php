<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class Board extends Model
{
    use LogsActivity;

    protected $fillable = ['title', 'description', 'user_id'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }
}
