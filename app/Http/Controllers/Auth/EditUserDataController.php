<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Funciones\FuncionesController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use App\User;

class EditUserDataController extends Controller
{
   
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo            = '/home';
    protected $redirectToAlumno      = '/home_alumno';
    protected $redirectToError       = '/edit';
    protected $redirectToChangeEmail = '/showEditProfileEmail/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    protected function update(Request $request)
    {
        $ip     = $_SERVER['REMOTE_ADDR'];
        $host   = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $idemp  = 1;

        $validator = Validator::make($request->all(), [
            'nombre_completo' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect($this->redirectToError)
                        ->withErrors($validator)
                        ->withInput();
        }else{
            $user = Auth::user();
            // $input = $request->only('nombre_completo', 'twitter', 'facebook', 'instagram');
            $input = $request->all();
            $user->nombre_completo = $request->input('nombre_completo');
            $user->twitter = $request->input('twitter');
            $user->facebook = $request->input('facebook');
            $user->instagram = $request->input('instagram');
            $user->idemp = $idemp;
            $user->ip = $ip;
            $user->host = $host;
            $user->save();
            return redirect(
                $user->hasRole('alumno') ?
                    $this->redirectToAlumno :
                    $this->redirectTo
            );
        }

    }

    protected function changeEmailUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        if ($validator->fails()) {
            return redirect($this->redirectToChangeEmail)
                ->withErrors($validator)
                ->withInput();
        }else{
            $user = Auth::user();
            // $input = $request->only('nombre_completo', 'twitter', 'facebook', 'instagram');
            $F = new FuncionesController();
            $input = $request->all();
            $user->email = $request->input('email');
            $user->idemp = $F->getIHE(0);
            $user->ip = $F->getIHE(1);
            $user->host = $F->getIHE(2);
            $user->save();
            return redirect(
                $user->hasRole('alumno') ?
                    $this->redirectToAlumno :
                    $this->redirectTo
            );
        }

    }

    protected function showEditUserData(){
        $user = Auth::user();
        return view('auth.edit',compact("user"));
    }

    protected function showEditProfilePhoto(){
        $user = Auth::user();
        return view('storage.profile_photo',compact("user"));
    }

    protected function showEditProfileEmail(){
        $user = Auth::user();
        return view('storage.profile_email',compact("user"));
    }


}