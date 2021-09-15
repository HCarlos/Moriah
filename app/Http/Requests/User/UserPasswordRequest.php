<?php

namespace App\Http\Requests\User;

use App\Classes\MessageAlertClass;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CurrentPassword;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class UserPasswordRequest extends FormRequest{


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    protected $redirectRoute = "editPasswordUser";

    public function authorize()
    {
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
            'password_actual' => 'required|min:6',
            'password_actual' => new CurrentPassword(),
            'password' => 'required|confirmed|min:6',
        ];
    }

    public function messages()
    {

        return [
            'password_actual.required' => 'Se requiere el :attribute.',
            'password_actual.min' => 'El :attribute debe ser por lo menos de 6 caracteres.',
            'password_actual.current_password' => 'El :attribute no es correcto.',
            'password.required' => 'Se requiere el :attribute.',
            'password.min' => ':attribute debe ser por lo menos de 6 caracteres.',
            'password.confirmed' => 'La confirmación del password no coincide con el nuevo password.',
        ];
    }

    public function attributes()
    {
        return [
            'password_actual' => 'Password Actual',
            'password' => 'Password',
            'password_confirmation' => 'Confirmar Password',
        ];
    }

    /**
     * Get the sanitized input for the request.
     *
     * @return array
     */
    public function sanitize()
    {
        return $this->only('password');
    }

    public function UserPasswordRequest(){

        try {
            $user = Auth::user();
//            dd($user);
            $user->password  = bcrypt(trim($this->password));
            $user->save();
            auth()->login($user);
        }catch (QueryException $e){
            $Msg = new MessageAlertClass();
            return $Msg->Message($e);
        }
        //return redirect()->route($this->redirectRoute);

        $this->getRedirectUrl();

    }

    protected function getRedirectUrl()
    {
        $url = $this->redirector->getUrlGenerator();
        if ($this->id > 0){
            return $url->route($this->redirectRoute,['Id'=>$this->id]);
        }else{
            return $url->route('editPasswordUser');
        }
    }



}
