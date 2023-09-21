<?php

namespace App\Http\Controllers\Externos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Excel\ImportFileController;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use function Sodium\add;
use Illuminate\Support\Facades\Session;
use App\Models\SIIFAC\Pedido;


class VentasListadoExcelController extends Controller{



    public function imprimirListadoVentasExcel()
    {

        // Extrension File;
        $extension = "Xlsx";
        $ext_fila  = "xlsx";
        try {
            $archivo =  ImportFileController::getFileVentas1List($ext_fila);
            $reader = IOFactory::createReader($extension);
            $spreadsheet = $reader->load($archivo);
            $sh = $spreadsheet->setActiveSheetIndex(0);

            $sh->setCellValue('K1', Carbon::now()->format('d-m-Y h:m:s'));
            $items = Session::get('items');

            $C0 = 6;
            $C = $C0;

            foreach ($items as $i){
                    $Ped = Pedido::find($i->pedido_id);

                    if ($i->paquete_id > 0)     
                        $a =  utf8_decode(trim($i->paquete->FullDescription));                               
                    else if ( !is_null($Ped) )
                        $a =  utf8_decode(trim($Ped->FullDescription));                               
                    else 
                        $a =  utf8_decode(trim($i->TipoVenta));                                   

                    if ( !is_null($Ped) )
                        $b =  utf8_decode(trim($Ped->observaciones));                                   
                    else    
                        $b =  '';

                    $c =  $i->total;

                    $sh

                    ->setCellValue('A'.$C, $i->id)
                    ->setCellValue('B'.$C, $i->getFolioImpreso($i->empresa_id,$i->id))
                    ->setCellValue('C'.$C, $i->user->FullName)
                    ->setCellValue('D'.$C, $a)
                    ->setCellValue('E'.$C, $c)
                    ->setCellValue('F'.$C, $b);

                $C++;
            }
//            $spreadsheet->getActiveSheet()->getCell('B7')->getDataValidation();
            $Cx = $C  - 1;
            $oVal = $sh->getCell('G1')->getValue();
            $sh->setCellValue('B'.$C, 'TOTAL DE ARTÍCULOS')
            ->setCellValue('E'.$C, '=SUM(E1:E'.$Cx.')')
            ->setCellValue('G'.$C, $oVal);

            $sh->getStyle('A'.$C0.':G'.$C)->getFont()
                ->setName('Arial')
                ->setSize(8);

            $sh->getStyle('A'.$C.':G'.$C)->getFont()->setBold(true);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="ventas1_.'.$ext_fila.'"');
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
