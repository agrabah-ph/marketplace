<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanDisbursement extends Model
{
    public function info()
    {
        return $this->morphTo();
    }
}
