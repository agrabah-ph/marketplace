<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class LoanPayment extends Model
{
    //


    public function toArray()
    {
        $array = parent::toArray();
        $array['paid_date_formatted'] = Carbon::parse($this->due_date)->toFormattedDateString();
        $array['payment_method'] = ucfirst($this->payment_method);
        return $array;
    }
}
