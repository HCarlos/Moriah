<?php

namespace App\Http\Controllers\Externos;

use App\Http\Controllers\Classes\PDF_Diag;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\SIIFAC\Ingreso;
use App\Models\SIIFAC\Venta;
use Illuminate\Http\Request;

class CorteCajaController extends Controller
{

    protected $alto     = 6;
    protected $aFT      = 205;
    protected $timex    = "";
    protected $f1       = "";
    protected $f2       = "";
    protected $vendedor = "";
    protected $cliente  = "";
    protected $F;

    public function __construct(){
        $this->middleware('auth');
        $this->F = (new FuncionesController);
    }

    protected function header($pdf){
        $pdf->AddPage();
        $pdf->setY(10);
        $pdf->setX(10);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFillColor(192,192,192);
        $pdf->SetFont('Arial','B',12);
        $pdf->Image('assets/img/logo-arji.gif',10,10,20,20);
        $pdf->Cell(25,$this->alto,"","",0,"L");
        $pdf->Cell(150,$this->alto,utf8_decode("COMERCIALIZADORA ARJÍ A.C."),"",0,"L");
        $pdf->SetFont('Arial','',7);
        $pdf->SetFillColor(212,212,212);
        $pdf->Cell(20,$this->alto,$this->timex,"",1,"R");
        $pdf->setX(10);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(25,$this->alto,"","",0,"L");
        $pdf->Cell(11,$this->alto,"Desde: ","",0,"L");
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(20,$this->alto,$this->f1,"",0,"L");
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(10,$this->alto,"Hasta: ","",0,"L");
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(20,$this->alto,$this->f2,"",1,"L");
        $pdf->setX(10);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(25,$this->alto,"","",0,"L");
        $pdf->Cell(32,$this->alto,"CORTE DE CAJA | ","",0,"L");
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(110,$this->alto,$this->vendedor,"",0,"L");
        $pdf->SetFont('Arial','',7);
        $pdf->SetFillColor(0,212,212);
        $pdf->Cell(33, $this->alto, utf8_decode("Página " . $pdf->PageNo() . " de {nb}"), "", 1,"R");
        $pdf->setX(10);
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(10, $this->alto, 'ID', "LTB", 0,"R");
        $pdf->Cell(10, $this->alto, 'VENTA', "LTB", 0,"R");
        $pdf->Cell(10, $this->alto, 'TIPO', "LTB", 0,"L");
        $pdf->Cell(63, $this->alto, 'CLIENTE', "LTB", 0,"L");
        $pdf->Cell(19, $this->alto, 'VENDEDOR', "LTB", 0,"L");
        $pdf->Cell(15, $this->alto, 'FECHA', "LTB", 0,"R");
        $pdf->Cell(22, $this->alto, utf8_decode('MÉTODO PAGO'), "LTB", 0,"L");
        $pdf->Cell(30, $this->alto, 'REFERENCIA', "LTB", 0,"L");
        $pdf->Cell(17, $this->alto, 'IMPORTE', "LTRB", 1,"R");
        $pdf->setX(10);
    }

    protected function imprimir_Venta($pdf, $data)
    {
        $f1    = $this->F->fechaDateTimeFormat($data['fecha1']);
        $f2    = $this->F->fechaDateTimeFormat($data['fecha2'],true);
        $vendedor_id = $data['vendedor_id'];
        $metodo_pago = $data['metodo_pago'];

        $Movs = Ingreso::select()
            ->where('fecha','>=', $f1)
            ->where('fecha','<=', $f2)
            ->whereHas('vendedores', function ($q) use($vendedor_id) {
                if ($vendedor_id > 0)
                    $q->where('vendedor_id', $vendedor_id);
            })
//            ->whereHas('ventas', function ($q) use($metodo_pago) {
//                if ($metodo_pago >= 0 && $metodo_pago <= 999 )
//                    $q->where('metodo_pago', $metodo_pago);
//            })
            ->orderBy('fecha')
            ->get();

//        dd($Movs);
        $m = $Movs->first();
        $this->f1 = $this->F->fechaEspanol($data['fecha1']);
        $this->f2 = $this->F->fechaEspanol($data['fecha2']);
        if ( !is_null($m) )
            $this->vendedor = trim($m->vendedor->FullName);

        $pdf->AliasNbPages();
        $this->header($pdf);
        $pdf->SetFillColor(32,32,32);
        $pdf->SetFont('Arial','',6);
        $totalPagado = $totalContado = $totalCredito = 0;
        foreach ($Movs as $Mov){
            $totalPagado += $Mov->total;
            $pdf->setX(10);
            $pdf->SetFont('arialn','',8);
            $pdf->Cell(10, $this->alto, $Mov->id, "LTB", 0,"R");
            $pdf->Cell(10, $this->alto, $Mov->venta_id, "LTB", 0,"R");
            $pdf->Cell(10, $this->alto, utf8_decode(trim($Mov->tipoventa)), "LTB", 0,"L");
            $pdf->Cell(63, $this->alto, utf8_decode(trim($Mov->cliente->FullName)), "LTB", 0,"L");
            $pdf->Cell(19, $this->alto, utf8_decode(trim($Mov->vendedor->FullName)), "LTB", 0,"L");
            $pdf->Cell(15, $this->alto, $this->F->fechaEspanol($Mov->fecha), "LTB", 0,"R");
            $pdf->Cell(22, $this->alto, substr(utf8_decode(Venta::$metodos_pago[$Mov->metodo_pago]),0,20), "LTB", 0,"L");
            $pdf->Cell(30, $this->alto, utf8_decode(trim($Mov->referencia)), "LTB", 0,"L");
            $totalContado += $Mov->total;
            $pdf->SetFont('AndaleMono','',7);
            $pdf->Cell(17, $this->alto, number_format($Mov->total,2), "LTRB", 1,"R");
        }
        $pdf->setX(10);
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(179, $this->alto, 'TOTAL $ ', "LB", 0,"R");
        $pdf->SetFont('andalemonomtstdbold','',7);
        $pdf->Cell(17, $this->alto, number_format($totalPagado,2), "LRB", 1,"R");
        $pdf->Output();

    }


    protected function panel_consulta_1(){
        $Cajeros = Venta::select(['vendedor_id'])
            ->distinct()
            ->get();
        $Cajeros->each(function ($v) { $v->FullName = trim($v->vendedor->FullName); });
        $Cajeros = $Cajeros->sortBy('FullName')->pluck('FullName','vendedor_id');
        $Cajeros->prepend('Todos', '0');
        $metodo_pagos = Venta::$metodos_pago;
        $metodo_pagos[999] = 'Todos';

        return view('catalogos.reportes.panel_reporte_1',[
            "tableName" => "",
            "cajeros" => $Cajeros,
            'metodo_pagos' => $metodo_pagos,
        ]);

    }

    protected function corte_de_caja_1(Request $request){
        $data = $request->all();
        $pdf  = new PDF_Diag('P','mm','Letter');
        $this->imprimir_Venta($pdf, $data);
    }


}
