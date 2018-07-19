<?php

namespace App\Http\Controllers\Excel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use PHPExcel_Cell;
use PHPExcel_Cell_DataType;
use PHPExcel_Cell_IValueBinder;
use PHPExcel_Cell_DefaultValueBinder;

//class ImportFileController extends Controller
//{
//    //
//}


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
