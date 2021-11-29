<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PurchaseOrderSubmitOffer implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $items = $value;
        foreach($items as $item){

            if($item <= 0)
               return false;
        }

        return true;


    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Item can not be 0 value!';
    }
}
