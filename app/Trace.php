<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trace extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reference',
        'code',
        'url',
        'image',
        'image_path',
        'active',
        'delivered',
        'user_id'
    ];

    protected $appends = [
        'trace',
        'status',
        'receiver',
        'dispatch',
        'timeline'
    ];

    public function info()
    {
        return $this->morphMany(ModelInfo::class, 'model');
    }

    public function getTraceAttribute()
    {
        $data = $this->morphMany(ModelInfo::class, 'model')->where('type', 'status')->orderBy('id', 'desc')->first();
        return $data->value_0;
    }

    public function getTimelineAttribute()
    {
        return $this->morphMany(ModelInfo::class, 'model')->where('type', 'status')->orderBy('id', 'desc')->get();
    }

    public function getStatusAttribute()
    {
        $data = $this->morphMany(ModelInfo::class, 'model')->where('type', 'status')->orderBy('id', 'desc')->first();
        return $data->value_0.': '. $data->value_1;
    }

    public function getReceiverAttribute()
    {
        return $this->morphMany(ModelInfo::class, 'model')->where('type', 'receiver')->first();
    }

    public function getDispatchAttribute()
    {
        return $this->morphMany(ModelInfo::class, 'model')->where('type', 'dispatch')->first();
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'trace_id')->with('product', 'farmer', 'leader');
    }
}
