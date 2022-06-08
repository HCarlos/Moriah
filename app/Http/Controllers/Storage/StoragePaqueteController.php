<?php

namespace App\Http\Controllers\Storage;

use App\Classes\GeneralFunctions;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\SIIFAC\Paquete;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use League\Flysystem\Exception;

class StoragePaqueteController extends Controller
{
    protected $redirectTo = '/home';
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

    public function subirArchivoPaquete(Request $request, Paquete $oPaquete){

        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        $data    = $request->all();
        $idItem  = $data['idItem'];

        $validator = Validator::make($data, [
            'file' => "required|mimes:jpg,jpeg,gif,png,video/mp4,pdf,zip,rar,xz|max:20000",
        ]);

        if ($validator->fails()) {

            return redirect("imagen_paquete/$idItem")
                ->withErrors($validator)
                ->withInput();

        }

        try {
            $file = $request->file('file');
            $prod = Paquete::all()->where('empresa_id', $this->Empresa_Id)->where('id',$idItem)->first();

            $ext = $file->extension();
            $fileName = $idItem.'.'.$ext;
            Storage::disk('paquete')->put($fileName, File::get($file));
            $prod->root = 'paquete/';
            $prod->filename = $fileName;
            $prod->save();

        }catch (Exception $e){
            dd($e);
        }

        return redirect("imagen_paquete/$idItem");

    }

    public function quitarArchivoPaquete($idItem=0)
    {
        $oProd = Paquete::findOrFail($idItem);
        Storage::disk('paquete')->delete($oProd->filename);
        $this->F->deleteImages($oProd,'paquete');
        $oProd->filename = '';
        $oProd->root = '';
        $oProd->save();

        return redirect("imagen_paquete/$idItem");

    }
}
