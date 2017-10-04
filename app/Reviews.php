<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
	protected $fillable = [
          'title', 'description','user_id', 'film_id','rate_elements','helpfullreview'
        ];
    
    public function __construct($value='')
    {
    	
    }
}
