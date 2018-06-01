<?php

namespace App\Http\Controllers\Storage;

use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\SIIFAC\Producto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use League\Flysystem\Exception;

class StorageProductoController extends Controller
{
    protected $redirectTo = '/home';
    protected $F;
    public function __construct(){
        $this->middleware('auth');
        $this->F = new FuncionesController();
    }

    public function subirArchivoProducto(Request $request, Producto $oProducto)
    {

        $data    = $request->all();
        $idItem  = $data['idItem'];

        $validator = Validator::make($data, [
            'file' => "required|mimes:jpg,jpeg,gif,png,video/mp4,pdf,zip,rar,xz|max:20000",
        ]);

        if ($validator->fails()) {

            return redirect("imagen_producto/$idItem")
                ->withErrors($validator)
                ->withInput();

        }

        try {
            $file = $request->file('file');
            $prod = Producto::all()->where('id',$idItem)->first();

            $ext = $file->extension();
            $fileName = $idItem.'.'.$ext;
            Storage::disk('producto')->put($fileName, File::get($file));
            $prod->root = 'producto/';
            $prod->filename = $fileName;
            $prod->save();

        }catch (Exception $e){
            dd($e);
        }

        return redirect("imagen_producto/$idItem");

    }

    public function quitarArchivoProducto($idItem=0)
    {
        $oProd = Producto::findOrFail($idItem);
        Storage::disk('producto')->delete($oProd->filename);
        $this->F->deleteImages($oProd,'producto');
        $oProd->filename = '';
        $oProd->root = '';
        $oProd->save();

        return redirect("imagen_producto/$idItem");

    }
}
