<?php

namespace App\Http\Controllers\Externos;

use App\Http\Controllers\Excel\ImportFileController;
use App\Models\SIIFAC\Producto;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelController extends Controller
{

    public function show()
    {
        $Prod  = Producto::select(['id','descripcion','exist'])->orderBy('descripcion')->get();

        $C0 = 6;
        $C = $C0;

        // Extrension File;
        $extension = "Xls";
        $ext_fila  = "xls";
        try {
            $archivo =  ImportFileController::getFileExistencias($ext_fila);
            $reader = IOFactory::createReader($extension);
            $spreadsheet = $reader->load($archivo);
            $sh = $spreadsheet->setActiveSheetIndex(0);

            $sh->setCellValue('K1', Carbon::now()->format('d-m-Y h:m:s'));
            foreach ($Prod as $v){
                    $sh
                    ->setCellValue('A'.$C, $v->id)
                    ->setCellValue('B'.$C, $v->descripcion)
                    ->setCellValue('C'.$C, $v->exist);
                $C++;
            }
//            $spreadsheet->getActiveSheet()->getCell('B7')->getDataValidation();
            $Cx = $C  - 1;
            $oVal = $sh->getCell('G1')->getValue();
            $sh->setCellValue('B'.$C, 'TOTAL DE ARTÍCULOS')
            ->setCellValue('C'.$C, '=SUM(C1:C'.$Cx.')')
            ->setCellValue('G'.$C, $oVal);

            $sh->getStyle('A'.$C0.':G'.$C)->getFont()
                ->setName('Arial')
                ->setSize(8);

            $sh->getStyle('A'.$C.':G'.$C)->getFont()->setBold(true);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="productos_.'.$ext_fila.'"');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            header('Cache-Control: cache, must-revalidate');
            header('Pragma: public');
            $writer = IOFactory::createWriter($spreadsheet, $extension);
            $writer->save('php://output');
            exit;

        } catch (Exception $e) {
            echo 'Ocurrio un error al intentar abrir el archivo ' . $e;
        }

    }



}
