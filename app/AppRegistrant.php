<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class AppRegistrant extends Model
{
    //

    protected $fillable = [
        'app',
        'role_id'
    ];

    public function role(){
        return $this->belongsTo(Role::class, 'role_id');
    }
}
