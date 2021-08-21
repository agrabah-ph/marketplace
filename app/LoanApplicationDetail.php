<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanApplicationDetail extends Model
{
    public function getInfoLoanDetailAttribute($value)
    {
        return unserialize($value);
    }
    public function getCreditFinancialInfoAttribute($value)
    {
        return unserialize($value);
    }
    public function getTradeReferenceInfoAttribute($value)
    {
        return unserialize($value);
    }
    public function getReferenceIdAttribute($value)
    {
        return unserialize($value);
    }
}
