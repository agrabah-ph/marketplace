<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BfarNotifications extends Model
{
    protected $fillable = [
        'from',
        'product',
        'quantity',
        'unit_of_measure',
        'destination',
        'com_leader_user_id',
        'date_of_travel',
        'type_of_vehicle'
    ];

    public function community_leader()
    {
        return $this->hasOne(User::class, 'id','com_leader_user_id');
    }
}
