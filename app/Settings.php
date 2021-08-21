<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{

    protected $fillable = [
        'name', 'display_name', 'value', 'is_active'
    ];

}
