<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidateCURP implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $ciudad;
    private $CURP;
    private $REGEX_CURP = "[A-Z][A,E,I,O,U,X][A-Z]{2}[0-9]{2}[0-1][0-9][0-3][0-9][M,H][A-Z]{2}[B,C,D,F,G,H,J,K,L,M,N,Ñ,P,Q,R,S,T,V,W,X,Y,Z]{3}[0-9,A-Z][0-9]";


    public function __construct($CURP)
    {
        $this->CURP = $CURP;
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
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }



}
