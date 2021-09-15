<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CompareMunicipioIdRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    private $municipio_id_1;
    private $municipio_id_2;
    private $ciudad;

    public function __construct($municipio_id_1, $municipio_id_2,$search_ciudad)
    {
//        dd($municipio_id_1.' , '.$municipio_id_2);
        $this->municipio_id_1 = $municipio_id_1;
        $this->municipio_id_2 = $municipio_id_2;
        $this->ciudad         = $search_ciudad;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($this->ciudad){

            if ($this->municipio_id_2 == 0 && $this->municipio_id_1 > 0){} return true;

            if (
                ($this->municipio_id_2 > 0) && ($this->municipio_id_1 > 0) &&
                ($this->municipio_id_1 == $this->municipio_id_2)
            ) return true;
            return false;

        } else return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Hay problemas entre el Municipio de la Localidad y el Municipio de la Ciudad.';
    }
}
