<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'display_name',
    ];

    public function units()
    {
        return $this->morphMany(Unit::class, 'model');
    }

}
