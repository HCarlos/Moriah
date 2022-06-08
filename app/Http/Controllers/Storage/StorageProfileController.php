<?php

namespace App\Http\Controllers\Storage;

use App\Classes\GeneralFunctions;
use App\Http\Controllers\Funciones\FuncionesController;
use http\Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class StorageProfileController extends Controller
{
    protected $redirectTo = 'showEditProfilePhoto/';
    protected $Empresa_Id = 0;
    protected $F;

    public function __construct(){
        $this->middleware('auth');
        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }
        $this->F = new FuncionesController();
    }

    public function subirArchivoProfile(Request $request){

        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        $ip   = $_SERVER['REMOTE_ADDR'];
        $host = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $data = $request->all();
        $user = Auth::User();

        try {
            $validator = Validator::make($data, [
                'photo' => "required|mimes:jpg,jpeg,gif,png,JPG,JPEG,GIF,PNG|max:10000",
            ]);
            if ($validator->fails()){
                return redirect('showEditProfilePhoto/')
                    ->withErrors($validator)
                    ->withInput();

            }
            $file = $request->file('photo');
            $ext = $file->extension();
            $fileName = $user->id.'.' . $ext;
            Storage::disk('profile')->put($fileName, File::get($file));
            $user->root = 'profile/';
            $user->filename = $fileName;
            $user->ip = $ip;
            $user->host = $host;
            $user->idemp = $this->Empresa_Id;
            $user->save();
            return redirect($this->redirectTo);

        }catch (Exception $e){
            dd($e);
        }

        if ( $user->hasRole('user') || $user->hasRole('administrator') || $user->hasRole('alumno') ) {
            return redirect($this->redirectTo);
        }

//    }else{
//dd( $user->hasRole('administrator') );


    }

    public function quitarArchivoProfile(Request $request){
        $user = Auth::user();
        Storage::disk('profile')->delete($user->filename);
        $this->F->deleteImages($user,'profile');
        $user->filename = '';
        $user->root = '';
        $user->save();

        if ($user->hasRole('user') || $user->hasRole('administrator') || $user->hasRole('alumno') ) {
            return redirect($this->redirectTo);
        }

    }
}
