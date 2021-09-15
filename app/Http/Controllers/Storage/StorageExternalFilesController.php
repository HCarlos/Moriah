<?php

namespace App\Http\Controllers\Storage;

use App\Classes\GeneralFunctios;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use http\Exception;

class StorageExternalFilesController extends Controller{


    protected $redirectTo = 'archivos_config';
    protected $F;
    protected $msg = "";

    public function __construct(){
        $this->middleware('auth');
        $this->F = new GeneralFunctios();
    }

    public function subirArchivoBase(Request $request){

        @ini_set( 'upload_max_size' , '1024M' );
        @ini_set( 'post_max_size', '1024M');
        @ini_set( 'max_execution_time', '12000' );

        $data    = $request->all(['categ_file','base_file']);
        try {
        $validator = Validator::make($data, [
            'categ_file' => "required|filled",
            'base_file' => "required|max:".config('ibt.file_max_bytes')."|mimes:xls,xlsx,doc,docx,ppt,pptx,txt,mp4,jpeg,jpg",
        ]);
        if ($validator->fails()){
            return redirect($this->redirectTo)
                ->withErrors($validator)
                ->withInput();
        }
            //dd($data);
        $file = $request->file('base_file');
        $fileName = $data['categ_file'];
        //dd($fileName);
        Storage::disk('externo')->put($fileName, File::get($file));
        return redirect($this->redirectTo);
       }catch (Exception $e){
            dd($e->getMessage());
        }

    }

    public function quitarArchivoBase($driver,$archivo)
    {
        Storage::disk($driver)->delete($archivo);
        $e1 = Storage::disk($driver)->exists($archivo);
        if ($e1) {
            Storage::disk($driver)->delete($archivo);
        }
        return redirect($this->redirectTo);

    }

    public function archivos_config(){
        $user = Auth::user();

        return view('layouts.Catalogos.Archivo._archivo_edit',[
            "titulo" => "Configuración de Archivos",
            "item"     => null,
            "User"     => $user,
            'Route'    => 'subirArchivoBase',
            'Method'   => 'POST',
            'msg'      => $this->msg,
            'IsNew'    => true,
            'IsUpload' => true,
            "archivos" => Storage::disk('externo')->allFiles(),
        ]);
    }



}
