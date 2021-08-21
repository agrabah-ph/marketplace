<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    public function info()
    {
        return $this->morphMany(ModelInfo::class, 'model');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function farmer()
    {
        return $this->belongsTo(Farmer::class, 'farmer_id')->with('profile');
    }

    public function leader()
    {
        return $this->belongsTo(Farmer::class, 'leader_id')->with('profile');
    }
}
