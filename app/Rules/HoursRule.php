<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class HoursRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
	 
	 protected  $min_hours;
	  protected  $max_hours;
	 
	 
    public function __construct( $min_hours = null)
    {
		$this->min_hours = floatval($min_hours);
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
	//	dd($attribute, floatval($value ), $this->min_hours );
       return floatval($value ) >= $this->min_hours ;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Max Hours must be greater than or equal to Min Hours ';
    }
}
