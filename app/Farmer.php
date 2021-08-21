<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function leader()
    {
        return $this->belongsTo(Farmer::class, 'leader_id');
    }

    public function profile()
    {
        return $this->morphOne(Profile::class, 'model');
    }

    public function disbursement()
    {
        return $this->morphOne(LoanDisbursement::class, 'model');
    }

    public function inventory()
    {
        return $this->hasMany(Inventory::class, 'farmer_id');
    }

    public function listing()
    {
        return $this->hasMany(Inventory::class, 'farmer_id')->where('status', 'Accepted');
    }

    public function spotMarket()
    {
        return $this->morphMany(SpotMarket::class, 'model');
    }

    public function loans()
    {
        return $this->morphMany(Loan::class, 'borrower')->with('payment_schedules', 'product', 'provider');
    }

    public function activeLoans()
    {
        return $this->morphMany(Loan::class, 'borrower')
            ->where(function($q){
                $q->where('status', 'Active')->orWhere('status', 'Pending');
            })
            ->with('payment_schedules', 'product', 'provider');
    }

}
