<?php


namespace App\Classes;



class LoadTemplateExcel{

    public static function getFileInicio($extension){
        return storage_path('externo') . '/inicio.' . $extension;
    }

    public static function getFileExistencias($extension){
        return storage_path('app/public/externo') . '/base.' . $extension;
    }

    public static function getFileTemplate($file){
        //dd(env('EXTERNO_ROOT_LOCAL') . $file );
        return env('EXTERNO_ROOT_LOCAL') . $file;
    }

    public static function getDirFormatUser($extension){
        return storage_path('app/public/externo') . '/base.' . $extension;
    }

    public static function getFileInventario($extension){
        return storage_path('externo') . '/inventario.' . $extension;
    }

    public static function getFileCompra($extension){
        return storage_path('externo') . '/compra.' . $extension;
    }


}
