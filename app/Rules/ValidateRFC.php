<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidateRFC implements Rule
{

    private $RFC;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($rfc){
        $this->RFC = $rfc;
    }

    private static function convert_int_to_char_for_ctype($int)
    {
        if (!\is_int($int)) {
            return $int;
        }

        if ($int < -128 || $int > 255) {
            return (string) $int;
        }

        if ($int < 0) {
            $int += 256;
        }

        return \chr($int);
    }

    public static function ctype_alpha($text)
    {
        $text = self::convert_int_to_char_for_ctype($text);

        return \is_string($text) && '' !== $text && !preg_match('/[^A-Za-zÑñ&]/', $text);
    }

    protected function valida_rfc($valor){
        $valor = str_replace("-", "", $valor);
        $cuartoValor = substr($valor, 3, 1);
        //RFC sin homoclave
        if(strlen($valor)==10){
            $letras = substr($valor, 0, 4);
            $numeros = substr($valor, 4, 6);
            if (self::ctype_alpha($letras) && ctype_digit($numeros)) {
                return true;
            }
            return false;
        }
        // Sólo la homoclave
        else if (strlen($valor) == 3) {
            $homoclave = $valor;
            if(ctype_alnum($homoclave)){
                return true;
            }
            return false;
        }
        //RFC Persona Moral.
        else if (ctype_digit($cuartoValor) && strlen($valor) == 12) {
            $letras = substr($valor, 0, 3);
            $numeros = substr($valor, 3, 6);
            $homoclave = substr($valor, 9, 3);
            if (self::ctype_alpha($letras) && ctype_digit($numeros) && ctype_alnum($homoclave)) {
                return true;
            }
            return false;
            //RFC Persona Física.
        } else if (self::ctype_alpha($cuartoValor) && strlen($valor) == 13) {
            $letras = substr($valor, 0, 4);
            $numeros = substr($valor, 4, 6);
            $homoclave = substr($valor, 10, 3);
            if (self::ctype_alpha($letras) && ctype_digit($numeros) && ctype_alnum($homoclave)) {
                return true;
            }
            return false;
        }else {
            return false;
        }
    }//fin validaRFC


    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->valida_rfc($this->RFC);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El RFC es incorrecto.';
    }
}
