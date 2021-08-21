<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanProduct extends Model
{
    //
    protected $fillable = [
        "loan_provider_id",
        "name",
        "loan_type_id",
        "description",
        "amount",
        "duration",
        "interest_rate",
        "timing",
        "allowance",
        "first_allowance",
        "disclosure",
    ];

    public function provider()
    {
        return $this->belongsTo(LoanProvider::class, 'loan_provider_id')->with('profile');
    }

    public function type()
    {
        return $this->belongsTo(LoanType::class, 'loan_type_id');
    }

    public function toArray()
    {
        $array = parent::toArray();
        $timingName = '';
        switch ($this->timing){
            case 'monthly':
                $timingName = 'Months';
                break;
            case 'day':
                $timingName = 'Days';
        }
        $array['timing_name'] = $timingName;
        $array['disclosure_html'] = nl2br($this->disclosure).'<br><br>';
        return $array;
    }

    public function loan()
    {
        return $this->hasMany(Loan::class, 'loan_product_id');
    }
}
