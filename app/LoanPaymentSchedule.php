<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class LoanPaymentSchedule extends Model
{
    //
    protected $fillable = [
        'loan_id',
        'due_date',
        'paid_date',
        'payable_amount',
        'paid_amount',
        'status',
    ];

    public function toArray()
    {
        $array = parent::toArray();
        $array['due_date_display'] = Carbon::parse($this->due_date)->toFormattedDateString();
        $array['status_display'] = ucfirst($this->status);
        return $array;
    }
}
