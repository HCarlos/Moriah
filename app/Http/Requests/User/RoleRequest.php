<?php

namespace App\Http\Requests\User;

use App\Classes\GeneralFunctios;
use App\Models\User;
use App\Models\User\Permission;
use App\Models\User\Role;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest{



    protected $redirectRoute    = 'editRole';
    protected $redirectRouteNew = 'newRole';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function validationData(){
        $attributes = parent::all();
        $attributes['name']        = strtoupper(trim($attributes['name']));
        $attributes['abreviatura'] = strtoupper(trim($attributes['abreviatura']));
        $this->replace($attributes);
        return parent::all();
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
            'name' => ['required','min:4','unique:roles,name,'.$this->id],
            'color' => ['required'],
            'abreviatura' => ['required','min:3','unique:roles,abreviatura,'.$this->id],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El :attribute requiere por lo menos de 4 caracter',
            'name.unique' => 'El :attribute ya existe',
            'name.required' => 'El :attribute es obligatorio',
            'name.unique' => 'El :attribute ya existe',
            'color.required' => 'Se requiere el :attribute',
            'abreviatura.required' => 'Se requiere el :attribute',
            'abreviatura.unique' => 'El :attribute ya existe',
            'abreviatura.min' => 'El :attribute requiere por lo menos de 1 caracter',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Rol',
            'descripcion' => 'Descripción',
            'color' => 'Color',
            'abreviatura' => 'Abreviatura',
        ];
    }

    public function manageUser(){

        try {

            $Role = [
                'name'             => strtoupper(trim($this->name)),
                'descripcion'      => trim($this->descripcion),
                'color'            => trim($this->color),
                'abreviatura'      => strtoupper(trim($this->abreviatura)),
            ];

            if ($this->id == 0) {
                $obj = Role::create($Role);
            } else {
                $obj = Role::find($this->id);
                $obj->update($Role);
            }
        }catch (QueryException $e){
            $obj = $e->getMessage();
        }
        return $obj;
    }

    protected function getRedirectUrl()
    {
        $url = $this->redirector->getUrlGenerator();
        if ($this->id > 0){
            return $url->route($this->redirectRoute,['Id'=>$this->id]);
        }else{
            return $url->route($this->redirectRouteNew);
        }
    }




}
