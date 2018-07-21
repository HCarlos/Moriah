<?php

namespace App\Http\Controllers\Excel;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class ImportFileController extends Controller
{

    public static function getFileInicio($extension){
        return storage_path('externo') . '/inicio.' . $extension;
    }

    public static function getFileExistencias($extension){
//        $fl = Storage::disk('externo')->get('/base.' . $extension);
        return storage_path('app/public/externo') . '/base.' . $extension;
//        return $fl;
    }

    public static function getFileInventario($extension){
        return storage_path('externo') . '/inventario.' . $extension;
    }

    public static function getFileCompra($extension){
        return storage_path('externo') . '/compra.' . $extension;
    }

}
