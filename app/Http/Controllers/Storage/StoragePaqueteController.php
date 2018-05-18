<?php

namespace App\Http\Controllers\Storage;

use App\Models\SIIFAC\Paquete;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use League\Flysystem\Exception;

class StoragePaqueteController extends Controller
{
    protected $redirectTo = '/home';
    public function __construct(){
        $this->middleware('auth');
    }

    public function subirArchivoPaquete(Request $request, Paquete $oPaquete)
    {

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
            $prod = Paquete::all()->where('id',$idItem)->first();

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
        $oProd->filename = '';
        $oProd->root = '';
        $oProd->save();

        return redirect("imagen_paquete/$idItem");

    }
}
