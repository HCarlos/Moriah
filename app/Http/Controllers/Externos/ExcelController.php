<?php

namespace App\Http\Controllers\Externos;

use App\Http\Controllers\Excel\ImportFileController;
use App\Models\SIIFAC\Producto;
use App\Models\SIIFAC\Venta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelController extends Controller
{

    public function index()
    {
        Excel::create('Report2016', function($excel) {
            $excel->setTitle('My awesome report 2016');
            $excel->setCreator('Me')->setCompany('Our Code World');
            $excel->setDescription('A demonstration to change the file properties');
            $data = [12,"Hey",123,4234,5632435,"Nope",345,345,345,345];

            $excel->sheet('Sheet 1', function ($sheet) use ($data) {
                $sheet->setOrientation('landscape');
                $sheet->fromArray($data, NULL, 'A3');
            });

        })->download('xlsx');

    }

    public function show($venta_id)
    {
        $venta = Venta::find($venta_id)->toArray();
        //dd($venta);
/*
        Excel::create('Ventas', function($excel) use ($venta, $venta_id) {
            $excel->setTitle('Venta');
            $excel->setDescription('archivo de venta');
            $C = 6;
            $excel->sheet('venta '.$venta_id, function($sheet) use ($venta,$C) {
//                $sheet->fromArray($venta, null, 'A1', false, false);
                $sheet->cell('C'.$C,'Hola Mundo');
            });
        })->download('xlsx');


*/
        $C = 6;

        $mifile = ImportFileController::getFileExistencias();
//        Excel::load($mifile)->byConfig('excel::import.sheets', function($sheet) {
        Excel::load($mifile, function($reader) use ($venta, $venta_id)  {
            //dd($reader);

            $C = 6;

        })->get();

        $template = ImportFileController::getFileExistencias();
        $source   = ImportFileController::setFileExistencias();
//        $open     = ImportFileController::openFileExistencias();
        $FileName = ImportFileController::getFileNameOutExistenca();
/*
//        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($template);
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($template);

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('B7', 'Hello World !');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
//        header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
//        header("Content-type:   application/x-msexcel; charset=utf-8");
//        header("Expires: 0");
//        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
//        header("Cache-Control: private",false);

*/
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        $spreadsheet = $reader->load($template);
        //        $spreadsheet = IOFactory::load($template);


        $worksheet = $spreadsheet->getActiveSheet();



        $worksheet->getCell('A1')->setValue('John');
        $worksheet->getCell('A2')->setValue('Smith');

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        header("Content-type:   application/x-msexcel; charset=utf-8");

//        header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
//       header('Content-Disposition: attachment; filename=05featuredemo.xls');

        header('Content-Disposition: attachment; filename="05featuredemo.xls"');

        $writer->save("05featuredemo.xls");
//
//        header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
//        header("Content-type:   application/x-msexcel; charset=utf-8");
//        header("Expires: 0");
//        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
////        $writer->save('write.xlsx');
//
////        header('Content-Disposition: attachment; filename='.$FileName);
//        header('Content-Disposition: attachment; filename="write.xlsx"');

  //      $writer->save($source);

//        $writer->save('write.xlsx');


    }



}
