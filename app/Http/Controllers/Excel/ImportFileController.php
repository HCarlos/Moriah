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
        return storage_path('app/public/externo') . '/base.' . $extension;
    }

    public static function getFileVentas1List($extension){
        return storage_path('app/public/externo') . '/ventas1.' . $extension;
        // return storage_path('externo') . '/ventas1.' . $extension;
    }
        
    public static function getFileInventario($extension){
        return storage_path('externo') . '/inventario.' . $extension;
    }

    public static function getFileCompra($extension){
        return storage_path('externo') . '/compra.' . $extension;
    }

}
