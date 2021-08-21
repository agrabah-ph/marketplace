<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelInfo extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'model_id',
        'model_type',
        'type',
        'text_1',
        'text_2',
        'text_3'
    ];

    public function info()
    {
        return $this->morphTo();
    }
}
