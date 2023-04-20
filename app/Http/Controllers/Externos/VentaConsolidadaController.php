<?php

namespace App\Http\Controllers\Externos;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\SIIFAC\Producto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VentaConsolidadaController extends Controller{

    protected $alto     = 6;
    protected $aFT      = 205;
    protected $timex    = "";
    protected $f1       = "";
    protected $f2       = "";
    protected $empresa  = "";
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
        $pdf->Cell(150,$this->alto,utf8_decode($this->empresa),"",0,"L");
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
        $pdf->Cell(72,$this->alto,"VENTA CONSOLIDADA POR PRODUCTO | ","",0,"L");
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(65,$this->alto,Auth::user()->username,"",0,"L");
        $pdf->SetFont('Arial','',7);
        $pdf->SetFillColor(0,212,212);
        $pdf->Cell(33, $this->alto, utf8_decode("Página " . $pdf->PageNo() . " de {nb}"), "", 1,"R");
        $pdf->setX(10);
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B',7);
        $pdf->SetFillColor(196,196,196);
        $pdf->Cell(20, $this->alto, 'FECHA', "LTB", 0,"R", true);
        $pdf->Cell(20, $this->alto, 'CODIGO', "LTB", 0,"R", true);
        $pdf->Cell(100, $this->alto, 'PRODUCTO / SERVICIO', "LTB", 0,"L", true);
        $pdf->Cell(15, $this->alto, 'CANTIDAD', "LTB", 0,"R", true);
        $pdf->Cell(25, $this->alto, 'PRECIO COSTO', "LTB", 0,"R", true);
        $pdf->Cell(20, $this->alto, 'TOTAL', "LTRB", 1,"R", true);
        $pdf->SetFillColor(255,255,255);
        $pdf->setX(10);
    }
    protected function footer($pdf){
        $pdf->Ln(5);
        $pdf->setX(10);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(25,$this->alto,"","",0,"L");
        $pdf->Cell(42,$this->alto," ","",0,"L");
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(95,$this->alto,"","",0,"L");
        $pdf->SetFont('Arial','',7);
        $pdf->SetFillColor(0,212,212);
        $pdf->Cell(33, $this->alto, utf8_decode("Página " . $pdf->PageNo() . " de {nb}"), "", 1,"R");
        $pdf->setX(10);
    }

    public function imprimir_venta_consolidada_por_producto($f1,$f2,$pdf,$Movs,$empresa)
    {
        $this->f1 = $f1;
        $this->f2 = $f2;
        $this->empresa = $empresa;
        $this->timex = Carbon::now()->format('d-m-Y h:m:s a');

        $pdf->AliasNbPages();
        $this->header($pdf);
        $pdf->SetFillColor(32,32,32);
        $pdf->SetFont('Arial','',6);
        $total = 0;
        foreach ($Movs as $Mov){

            $pdf->setX(10);
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(20, $this->alto, $this->F->fechaEspanol($Mov->fecha), "LTB", 0,"R");
            $pdf->Cell(20, $this->alto, $Mov->codigo, "LTB", 0,"R");
            $pdf->SetFont('Arial','',6);
            $pdf->Cell(100, $this->alto, utf8_decode(trim($Mov->descripcion)), "LTB", 0,"L");
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(15, $this->alto, number_format($Mov->cantidad,2), "LRB", 0,"R");
            $pdf->Cell(25, $this->alto, number_format($Mov->pc,2), "LRB", 0,"R");
            $pdf->Cell(20, $this->alto, number_format($Mov->totalimporte,2), "LRB", 1,"R");
            $total += $Mov->totalimporte;
            if ($pdf->getY() > 230 ){
                $this->footer($pdf);
                $this->header($pdf);
                $pdf->SetFillColor(32,32,32);
                $pdf->SetFont('Arial','',6);
            }
        }
        $pdf->setX(10);
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(180, $this->alto, "VENTA TOTAL $", "LRB", 0,"R");
        $pdf->Cell(20, $this->alto, number_format($total,2), "LRB", 1,"R");
        $pdf->Output();
    }



}
