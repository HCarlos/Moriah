<?php

namespace App\Http\Controllers\Storage;

use App\Http\Controllers\Controller;
use App\Models\Catalogos\Familia;
use App\Models\User;
use Illuminate\Http\Request;

use App\Classes\LoadTemplateExcel;
use App\Models\Catalogos\Domicilios\Ubicacion;
use App\Models\Catalogos\Personas\Persona;
use Carbon\Carbon;
use Exception;

use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;


class StorageListaCatalogosController extends Controller{


    public function listUsuariosToXlsx(Request $request){
        ini_set('max_execution_time', 900);
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

//        $data = $request->only(['search','items']);
        $Items = $request->session()->get('items');

        //var_dump(extension_loaded('zip'));

        $C0 = 6;
        $C = $C0;

        try {
            $file_external = trim(config("ibt.archivos.fmt_lista_usuarios"));
            $arrFE = explode('.',$file_external);
            $extension = Str::ucfirst($arrFE[1]);

            $archivo =  LoadTemplateExcel::getFileTemplate($file_external);
            $reader = IOFactory::createReader($extension);
            $spreadsheet = $reader->load($archivo);
            $sh = $spreadsheet->setActiveSheetIndex(0);


            $sh->setCellValue('K1', Carbon::now()->format('d-m-Y h:m:s'));


            foreach ($Items as $item) {

                //dd($item->id);

                $item = User::find($item->id);

                $fechaEjecucion = Carbon::parse($item->fecha_nacimiento)->format('d-m-Y'); //Carbon::createFromFormat('d-m-Y', $item->fecha_nacimiento);
                $letras = ['Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ'];
                $sh
                    ->setCellValue('A' . $C, $item->curp)
                    ->setCellValue('B' . $C, $item->nombre)
                    ->setCellValue('C' . $C, $item->ap_paterno)
                    ->setCellValue('D' . $C, $item->ap_materno)
                    ->setCellValue('E' . $C, $item->fecha_nacimiento)
                    ->setCellValue('F' . $C, $item->StrGenero)
                    ->setCellValue('G' . $C, $item->celulares)
                    ->setCellValue('H' . $C, $item->telefonos)
                    ->setCellValue('I' . $C, $item->emails)
                    ->setCellValue('J' . $C, $item->user_adress->calle)
                    ->setCellValue('K' . $C, $item->user_adress->num_ext)
                    ->setCellValue('L' . $C, $item->user_adress->num_int)
                    ->setCellValue('M' . $C, $item->user_adress->colonia)
                    ->setCellValue('N' . $C, $item->user_adress->cp)
                    ->setCellValue('O' . $C, $item->user_adress->localidad)
                    ->setCellValue('P' . $C, $item->user_adress->municipio)
                    ->setCellValue('Q' . $C, $item->user_adress->estado)
                    ->setCellValue('R' . $C, $item->user_data_extend->lugar_nacimiento)
                    ->setCellValue('S' . $C, $item->user_data_extend->ocupacion)
                    ->setCellValue('T' . $C, $item->user_data_extend->profesion)
                    ->setCellValue('U' . $C, $item->user_data_extend->lugar_trabajo)
                    ->setCellValue('V' . $C, $item->user_data_social->red_social)
                    ->setCellValue('W' . $C, $item->user_data_social->username_red_social)
                    ->setCellValue('X' . $C, $item->user_data_social->alias_red_social);
                $j = 0;
                foreach ($item->familiares as $fam){
                    $par = $fam->getParentesco($fam->pivot->familiar_parentesco_id);
                    $sh
                        ->setCellValue($letras[$j++] . $C, $par)
                        ->setCellValue($letras[$j++] . $C, $fam->FullName)
                        ->setCellValue($letras[$j++] . $C, $fam->telefonos)
                        ->setCellValue($letras[$j++] . $C, $fam->celulares)
                        ->setCellValue($letras[$j++] . $C, $fam->emails);
                    $j++;
                }
                $sh
                    ->setCellValue($letras[$j] . $C, $item->pais);
                $C++;

            }
            $Cx = $C  - 1;
            $oVal = $sh->getCell('G1')->getValue();
            $sh->setCellValue('B'.$C, 'TOTAL DE REGISTROS')
                ->setCellValue('C'.$C, '=COUNT(A'.$C0.':A'.$Cx.')');

            $sh->getStyle('A'.$C0.':G'.$C)->getFont()
                ->setName('Arial')
                ->setSize(8);

            $sh->getStyle('A'.$C.':G'.$C)->getFont()->setBold(true);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="_'.$arrFE[0].'.'.$arrFE[1].'"');
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





    public function listFamiliasToXlsx(Request $request){
        ini_set('max_execution_time', 900);
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

//        $data = $request->only(['search','items']);
        $Items = $request->session()->get('items');

        //var_dump(extension_loaded('zip'));

        $C0 = 6;
        $C = $C0;

        try {
            $file_external = trim(config("ibt.archivos.fmt_lista_familias"));
            $arrFE = explode('.',$file_external);
            $extension = Str::ucfirst($arrFE[1]);

            $archivo =  LoadTemplateExcel::getFileTemplate($file_external);
            $reader = IOFactory::createReader($extension);
            $spreadsheet = $reader->load($archivo);
            $sh = $spreadsheet->setActiveSheetIndex(0);


            $sh->setCellValue('K1', Carbon::now()->format('d-m-Y h:m:s'));


            foreach ($Items as $item) {

                //dd($item->id);

                $item = Familia::find($item->id);

                $fechaEjecucion = Carbon::parse($item->fecha_nacimiento)->format('d-m-Y'); //Carbon::createFromFormat('d-m-Y', $item->fecha_nacimiento);
                $letras = ['Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ'];
                $sh
                    ->setCellValue('A' . $C, $item->familia);
                $C++;

            }
            $Cx = $C  - 1;
            $oVal = $sh->getCell('G1')->getValue();
            $sh->setCellValue('B'.$C, 'TOTAL DE REGISTROS')
                ->setCellValue('C'.$C, '=COUNT(A'.$C0.':A'.$Cx.')');

            $sh->getStyle('A'.$C0.':G'.$C)->getFont()
                ->setName('Arial')
                ->setSize(8);

            $sh->getStyle('A'.$C.':G'.$C)->getFont()->setBold(true);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="_'.$arrFE[0].'.'.$arrFE[1].'"');
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
