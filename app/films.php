<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class films extends Model
{
    
    public static function getFilm($id)
    {
        return Films::where('id', $id)->get();
    }
}
