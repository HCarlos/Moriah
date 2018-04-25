<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
//        $this->middleware('guest');
    }

    public function username()
    {
        return 'username';
    }

    public function redirectPath()
    {
        $user = Auth::user();
        if ( $user->hasRole(['administrator',
            'usuario_venta_libros','usuario_admin_venta_libros',
            'usuario_venta_uniformes','usuario_admin_venta_uniformess',
            'usuario_venta_cuadernos','usuario_admin_venta_cuadernos'
        ]) ){
            $this->redirectTo = '/home';
            return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
//        }elseif( $user->hasRole('alumno') ){
//            $this->redirectTo = '/home_alumno';
//            return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home_alumno';
//        }elseif( $user->hasRole('administrator') ){
//            $this->redirectTo = '/home';
//            return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
        }


    }


}
