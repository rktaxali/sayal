<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class maxHoursRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
	 
	 protected  $min_hours;
	  protected  $max_hours;
	 
	 
    public function __construct()
    {
		
	}
	
    /**
     * Determine if the validation rule passes that value is less than or equal to the max limit 
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
		$value = floatval($value );
	       return $value <=  floatval(env('MAX_HOURS_LIMIT'));

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Hours cannot be greater than ' . env('MAX_HOURS_LIMIT');
    }
}
