<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Temp extends Model
{
    protected $fillable = ['user_id', 'rand_token'];
}
