<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class minHoursRule implements Rule
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
     * Determine if the validation rule passes that value is greater than or equal than the min limit 
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
		$value = floatval($value );
	       return $value >= floatval(env('MIN_HOURS_LIMIT'));

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Hours cannot be less than ' . env('MIN_HOURS_LIMIT');
    }
}
