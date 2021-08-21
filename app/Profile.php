<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'model_id',
        'model_type',
        'first_name',
        'middle_name',
        'last_name',
        'mobile',
        'address',
        'education',
        'four_ps',
        'pwd',
        'indigenous',
        'livelihood',
        'farm_lot',
        'farming_since',
        'organization',
        'status',
        'dob',
        'pob',
        'gender',
        'civil_status',
        'citizenship',
        'gross_monthly_income',
        'monthly_expenses',
    ];

    protected $appends = [
        'bday'
    ];

    public function info()
    {
        return $this->morphTo();
    }

    public function getBdayAttribute()
    {
        return Carbon::parse($this->attributes['dob'])->toFormattedDateString();
    }

    public function getSecondaryInfoAttribute($value)
    {
        return unserialize($value);
    }

    public function getSpouseComakerInfoAttribute($value)
    {
        return unserialize($value);
    }

    public function getFarmingInfoAttribute($value)
    {
        return unserialize($value);
    }

    public function getEmploymentInfoAttribute($value)
    {
        return unserialize($value);
    }

    public function getIncomeAssetInfoAttribute($value)
    {
        return unserialize($value);
    }
}
