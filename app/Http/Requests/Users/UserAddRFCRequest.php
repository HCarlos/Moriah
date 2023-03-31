<?php

namespace App\Http\Requests\Users;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserAddRFCRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    public function manage(){
        $msg = "OK";
        try {
            $user_id = $this->user_id;
            $rfcsarray = $this->rfcs;
            foreach ($rfcsarray as $rfc) {
                $user = User::find($user_id);
                $user->attach($rfc);
                $msg = "Proceso ejecutado con éxito";
            }
        }catch (\Exception $e){
            $msg =  $e->getMessage();
            throw new HttpResponseException(response()->json( $msg->Message($e->getMessage()), 422));
        }
        return $msg;
    }

}
