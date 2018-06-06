<?php

namespace App\Http\Controllers\Externos;

use App\Models\SIIFAC\Producto;
use App\Models\SIIFAC\Venta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

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
        $venta = Venta::find($venta_id);

        Excel::create('Ventas', function($excel) use ($venta, $venta_id) {
            $excel->setTitle('Venta');
            $excel->setDescription('archivo de venta');
            $C = 6;
            $excel->sheet('venta '.$venta_id, function($sheet) use ($venta,$C) {
//                $sheet->fromArray($venta, null, 'A1', false, false);
                $sheet->cell('C'.$C,'Hola Mundo');
            });
        })->download('xlsx');
    }



}
