<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class ReverseBidding extends Model implements HasMedia
{
    //
    use HasMediaTrait;

    protected $fillable= [
        'user_id',
        'name',
        'description',
        'quantity',
        'duration',
        'expiration_time',
        'asking_price',
        'buying_price',
        'area',
        'method',
        'status',
    ];


}
