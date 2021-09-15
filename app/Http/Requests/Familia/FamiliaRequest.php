<?php

namespace App\Http\Requests\Familia;

use App\Classes\GeneralFunctios;
use App\Models\Catalogos\Familia;
use App\Models\User;
use App\Models\User\Permission;
use App\Models\User\Role;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;

class FamiliaRequest extends FormRequest{



    protected $redirectRoute = 'editFamilia';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
    'username' => ['required | min:4 | unique:users'],
     */
    public function rules()
    {
        return [
            'familia' => ['required','min:4'],
        ];
    }

    public function messages()
    {
        return [
            'familia.required' => 'El :attribute requiere por lo menos de 4 caracter',

        ];
    }

    public function attributes()
    {
        return [
            'familia' => 'Familia',
        ];
    }

    public function manage(){
        try {
            $Familia = [
                'familia'       => strtoupper(trim($this->familia)),
            ];
            if ($this->id == 0) {
                $user = Familia::create($Familia);
            } else {
                $user = Familia::find($this->id);
                $user->update($Familia);
            }
        }catch (QueryException $e){
            return $e->getMessage();
        }
        return $user;
    }

    public function attachMember(){
        try {
            $Familia = [
                'familia'       => strtoupper(trim($this->familia)),
            ];
            if ($this->id == 0) {
                $user = Familia::create($Familia);
            } else {
                $user = Familia::find($this->id);
                $user->update($Familia);
            }
        }catch (QueryException $e){
            return $e->getMessage();
        }
        return $user;
    }

    protected function getRedirectUrl()
    {
        $url = $this->redirector->getUrlGenerator();
        if ($this->id > 0){
            return $url->route($this->redirectRoute,['Id'=>$this->id]);
        }else{
            return $url->route("newFamilia");
        }
    }



}
