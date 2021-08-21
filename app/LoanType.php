<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanType extends Model
{
    public function product()
    {
        return $this->hasMany(LoanProduct::class, 'loan_type_id')->with('loan');
    }
}
