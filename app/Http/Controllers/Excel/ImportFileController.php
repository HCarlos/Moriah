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


class ImportFileController extends PHPExcel_Cell_DefaultValueBinder implements PHPExcel_Cell_IValueBinder
{


    public function bindValue(PHPExcel_Cell $cell, $value = null)
    {
        if ($cell->getColumn() !== 'D') {

            $cell->setValueExplicit($value, PHPExcel_Cell_DataType::TYPE_STRING);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }
    private static function getFileNameBaseExistenca(){
        return 'base.xls';
    }
    public static function getFileNameOutExistenca(){
        return 'base_tmp.xls';
    }
    public static function getFileExistencias(){
        return storage_path('exports') . '/' . static::getFileNameBaseExistenca();
    }
    public static function setFileExistencias(){
        return storage_path('excel') . '/' . static::getFileNameBaseExistenca();
    }
//    public static function openFileExistencias(){
//        return env('APP_URL').env('EXCEL_URL'). '/' . static::getFileNameExistenca();
//    }

}
