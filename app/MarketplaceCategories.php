<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class MarketplaceCategories extends model implements HasMedia
{
    use HasMediaTrait;

    protected $fillable = [
        'parent_id',
        'name',
        'display_name',
        'is_active',
        'sorting',
    ];

    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl('logo');
    }
    public function getLogoAttribute()
    {
        return $this->getImageAttribute();
    }

    public function parentCat()
    {
        return $this->hasOne(MarketplaceCategories::class,'id','parent_id');
    }

    public function childrenCat()
    {
        return $this->hasMany(MarketplaceCategories::class,'parent_id');
    }

    public function toArray()
    {
        $array = parent::toArray();
        $array['logo'] = $this->getImageAttribute();
        return $array;
    }
}
