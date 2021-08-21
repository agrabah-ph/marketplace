<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanProvider extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function profile()
    {
        return $this->morphOne(Profile::class, 'model');
    }

    public function products()
    {

    }
}
