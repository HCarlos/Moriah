<?php

namespace App\Http\Controllers\Storage;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Funciones\FuncionesController;

class StorageExternosController extends Controller
{
    protected $redirectTo = 'archivos-config';
    protected $F;

    public function __construct(){
        $this->middleware('auth');
        $this->F = new FuncionesController();
    }

    public function subirArchivoBase(Request $request)
    {
        $data    = $request->all();
        $this->redirectTo = 'archivos-config';
        try {
            $validator = Validator::make($data, [
                'base_file' => "required|mimes:xls,xlsx,doc,docx,ppt,pptx,txt,mp4,jpeg,jpg",
            ]);
            if ($validator->fails()){
                return redirect('archivos-config')
                    ->withErrors($validator)
                    ->withInput();
            }
            $file = $request->file('base_file');
            $ext = $file->extension();
            $fileName = "base." . $ext;

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




}
