<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Films extends Model
{
	use Notifiable;

    protected $fillable = [
        'title', 'challenges','genre', 'biography', 'is_feature'
    ];
}
