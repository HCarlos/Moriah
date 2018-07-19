<?php

namespace App\Http\Controllers\Excel;

use App\Http\Controllers\Controller;


class ImportFileController extends Controller
{

    public static function getFileInicio($extension){
        return storage_path('exports') . '/inicio.' . $extension;
    }

    public static function getFileExistencias($extension){
        return storage_path('exports') . '/base.' . $extension;
    }

    public static function getFileInventario($extension){
        return storage_path('exports') . '/inventario.' . $extension;
    }

    public static function getFileCompra($extension){
        return storage_path('exports') . '/compra.' . $extension;
    }

}
