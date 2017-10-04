<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteSettings extends Model
{
    protected $fillable = ['theater_url', 'wp_url','max_file_size_in_gb'];
}
