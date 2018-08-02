<?php

namespace App\Http\Controllers\Externos;

use App\Http\Controllers\Classes\PDF_Diag;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\SIIFAC\Movimiento;
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
        $pdf->Cell(75, $this->alto, 'CLIENTE', "LTB", 0,"L");
        $pdf->Cell(36, $this->alto, 'VENDEDOR', "LTB", 0,"L");
        $pdf->Cell(15, $this->alto, 'FECHA', "LTB", 0,"R");
        $pdf->Cell(20, $this->alto, utf8_decode('CRÉDITO'), "LTB", 0,"R");
        $pdf->Cell(20, $this->alto, 'CONTADO', "LTB", 0,"R");
        $pdf->Cell(20, $this->alto, 'IMPORTE', "LTRB", 1,"R");
        $pdf->setX(10);
    }

    protected function imprimir_Venta($pdf, $data)
    {
        $f1    = $this->F->fechaDateTimeFormat($data['fecha1']);
        $f2    = $this->F->fechaDateTimeFormat($data['fecha2'],true);
        $vendedor_id = $data['vendedor_id'];

        if ($vendedor_id>0){
            $Movs = Venta::all()
                    ->where('vendedor_id',$vendedor_id)
                    ->where('fecha','>=', $f1)
                    ->where('fecha','<=', $f2)
                    ->sortBy('fecha');
        }else{
            $Movs = Venta::all()
                    ->where('fecha','>=', $f1)
                    ->where('fecha','<=', $f2)
                    ->sortBy('fecha');
        }

        $m = $Movs->first();
        $this->f1 = $this->F->fechaEspanol($data['fecha1']);
        $this->f2 = $this->F->fechaEspanol($data['fecha2']);
        $this->vendedor = trim($m->vendedor->FullName);

        $pdf->AliasNbPages();
        $this->header($pdf);
        $pdf->SetFillColor(32,32,32);
        $pdf->SetFont('Arial','',6);
        $totalPagado = $totalContado = $totalCredito = 0;
        foreach ($Movs as $Mov){
            $totalPagado += $Mov->total_pagado;
            $pdf->setX(10);
            $pdf->SetFont('arialn','',8);
            $pdf->Cell(10, $this->alto, $Mov->id, "LTB", 0,"R");
            $pdf->Cell(75, $this->alto, utf8_decode($Mov->user->FullName), "LTB", 0,"L");
            $pdf->Cell(36, $this->alto, utf8_decode($Mov->vendedor->FullName), "LTB", 0,"L");
            $pdf->Cell(15, $this->alto, $this->F->fechaEspanol($Mov->fecha), "LTB", 0,"R");
            $pdf->SetFont('AndaleMono','',7);
            if($Mov->TipoDeVenta == 1){
                $pdf->Cell(20, $this->alto, number_format($Mov->total,2), "LTB", 0,"R");
                $pdf->Cell(20, $this->alto, "", "LTB", 0,"R");
                $totalCredito += $Mov->total;
            }else{
                $pdf->Cell(20, $this->alto, "", "LTB", 0,"R");
                $pdf->Cell(20, $this->alto, number_format($Mov->total,2), "LTB", 0,"R");
                $totalContado += $Mov->total;
            }
            $pdf->Cell(20, $this->alto, number_format($Mov->total_pagado,2), "LTRB", 1,"R");
        }
        $pdf->setX(10);
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(136, $this->alto, 'TOTAL $ ', "LB", 0,"R");
        $pdf->SetFont('andalemonomtstdbold','',7);
        $pdf->Cell(20, $this->alto, number_format($totalCredito,2), "LTB", 0,"R");
        $pdf->Cell(20, $this->alto, number_format($totalContado,2), "LTB", 0,"R");
        $pdf->Cell(20, $this->alto, number_format($totalPagado,2), "LRB", 1,"R");
        $pdf->Output();

    }


    protected function panel_consulta_1(){
        $Cajeros = Venta::select(['vendedor_id'])
            ->distinct()
            ->get();
        $Cajeros->each(function ($v) { $v->FullName = trim($v->vendedor->FullName); });
        $Cajeros = $Cajeros->sortBy('FullName')->pluck('FullName','vendedor_id');
        $Cajeros->prepend('Todos', '0');

        return view('catalogos.reportes.panel_reporte_1',[
            "tableName" => "",
            "cajeros" => $Cajeros,
        ]);

    }

    protected function corte_de_caja_1(Request $request){
        $data = $request->all();
        $pdf  = new PDF_Diag('P','mm','Letter');
        $this->imprimir_Venta($pdf, $data);
    }


}
