<?php

namespace App\Http\Controllers\Storage;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StorageExternosController extends Controller
{
    protected $redirectTo = '/';

    public function __construct(){
        $this->middleware('auth');
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

//            Storage::putFileAs(
//                'externo', $request->file('base_file'), $fileName
//            );

            return redirect($this->redirectTo);

        }catch (Exception $e){
            dd($e->getMessage());
        }

    }

}
