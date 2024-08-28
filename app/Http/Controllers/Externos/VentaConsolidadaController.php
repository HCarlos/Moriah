<?php

namespace App\Http\Controllers\Externos;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\SIIFAC\Movimiento;
use App\Models\SIIFAC\Producto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VentaConsolidadaController extends Controller{

    protected $alto     = 6;
    protected $aFT        = 205;
    protected $timex      = "";
    protected $f1         = "";
    protected $f2         = "";
    protected $empresa    = "";
    protected $empresa_id = 0;
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
        $pdf->Cell(25,$this->alto,$this->timex,"",1,"R");
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
        $pdf->Cell(95,$this->alto,utf8_decode("VENTA CONSOLIDADA POR ARTÍCULOS (INDIVIDUAL) | "),"",0,"L");
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(45,$this->alto,Auth::user()->username,"",0,"L");
        $pdf->SetFont('Arial','',7);
        $pdf->SetFillColor(0,212,212);
        $pdf->Cell(38, $this->alto, utf8_decode("Página " . $pdf->PageNo() . " de {nb}"), "", 1,"R");
        $pdf->setX(10);
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B',7);
        $pdf->SetFillColor(196,196,196);
        $pdf->Cell(20, $this->alto, 'FECHA', "LTB", 0,"R", true);
        $pdf->Cell(20, $this->alto, utf8_decode('CÓDIGO'), "LTB", 0,"R", true);
        $pdf->Cell(100, $this->alto, utf8_decode('A  R  T  Í  C  U  L  O'), "LTB", 0,"L", true);
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

    public function imprimir_venta_consolidada_por_producto($f1,$f2,$pdf,$Movs,$Emp)
    {
        $this->f1 = $f1;
        $this->f2 = $f2;
        $this->empresa = $Emp->empresa;
        $this->empresa_id = $Emp->id;
        $this->timex = Carbon::now()->format('d-m-Y::h:m:s::a');

        $pdf->AliasNbPages();
        $this->header($pdf);
        $pdf->SetFillColor(32,32,32);
        $pdf->SetFont('Arial','',6);
        $total = 0;
        $F = (new FuncionesController);
        foreach ($Movs as $Mov){
            $f1          = $F->fechaDateTimeFormat($Mov->fecha);
            $f2          = $F->fechaDateTimeFormat($Mov->fecha,true);
            $Mv = Movimiento::query()
                ->where('fecha','>=', $f1)
                ->where('fecha','<=', $f2)
                ->where('producto_id',$Mov->producto_id)
                ->where('codigo','=',$Mov->codigo)
                ->first();
            if ($Mv){
                $cp = $Mv->costo_promedio;
                $hp = $Mv->costo_promedio * $Mov->cantidad;
            }else{
                $cp = 0.00;
                $hp = 0.00;
            }
            $pdf->setX(10);
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(20, $this->alto, $this->F->fechaEspanol($Mov->fecha), "LTB", 0,"R");
            $pdf->Cell(20, $this->alto, $Mov->codigo, "LTB", 0,"R");
            $pdf->SetFont('Arial','',6);
            $pdf->Cell(100, $this->alto, utf8_decode(trim($Mov->descripcion)), "LTB", 0,"L");
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(15, $this->alto, number_format($Mov->cantidad,2), "LRB", 0,"R");
            $pdf->Cell(25, $this->alto, number_format($cp,2), "LRB", 0,"R");
            $pdf->Cell(20, $this->alto, number_format($hp,2), "LRB", 1,"R");
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
        $pdf->Output('I','venta-consolidada-producto-'.$this->empresa_id.'-'.$this->timex.'.pdf');
    }

    protected function header_grupal($pdf){
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
        $pdf->Cell(92,$this->alto,utf8_decode("VENTA CONSOLIDADA POR ARTÍCULOS (GRUPAL) | "),"",0,"L");
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(48,$this->alto,Auth::user()->username,"",0,"L");
        $pdf->SetFont('Arial','',7);
        $pdf->SetFillColor(0,212,212);
        $pdf->Cell(33, $this->alto, utf8_decode("Página " . $pdf->PageNo() . " de {nb}"), "", 1,"R");
        $pdf->setX(10);
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B',7);
        $pdf->SetFillColor(196,196,196);
        $pdf->Cell(15, $this->alto, utf8_decode('ID'), "LTB", 0,"R", true);
        $pdf->Cell(25, $this->alto, utf8_decode('CÓDIGO'), "LTB", 0,"R", true);
        $pdf->Cell(130, $this->alto, utf8_decode('A    R    T    Í    C    U    L    O'), "LTB", 0,"L", true);
        $pdf->Cell(25, $this->alto, 'CANTIDAD', "LTBR", 1,"R", true);
        $pdf->SetFillColor(255,255,255);
        $pdf->setX(10);
    }

    protected function footer_grupal($pdf){
        $pdf->Ln(5);
        $pdf->setX(10);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(200,$this->alto,"","",1,"R");
        $pdf->SetFont('Arial','',7);
        $pdf->SetFillColor(0,212,212);
        $pdf->Cell(197, $this->alto, utf8_decode("Página " . $pdf->PageNo() . " de {nb}"), "", 1,"R");
        $pdf->setX(10);
    }

    public function imprimir_venta_consolidada_por_producto_grupal($f1,$f2,$ff1,$ff2,$pdf,$Movs,$Emp)
    {
        $this->f1 = $f1;
        $this->f2 = $f2;
        $this->empresa = $Emp->empresa;
        $this->empresa_id = $Emp->id;
        $this->timex = Carbon::now()->format('d-m-Y::h:m:s::a');

        $pdf->AliasNbPages();
        $this->header_grupal($pdf);
        $pdf->SetFillColor(32,32,32);
        $pdf->SetFont('Arial','',6);
        $total = 0;
        $F = (new FuncionesController);
        foreach ($Movs as $Mov){
//            $f1          = $F->fechaDateTimeFormat($f1,false,1); // $F->fechaDateTimeFormat($Mov->fecha);
//            $f2          = $F->fechaDateTimeFormat($f2, true,1); // $F->fechaDateTimeFormat($Mov->fecha,true);
            $Mv = Movimiento::query()
                ->where('fecha','>=', $ff1)
                ->where('fecha','<=', $ff2)
                ->where('producto_id',$Mov->producto_id)
                ->where('codigo','=',$Mov->codigo)
                ->first();
            if ($Mv){
                $cp = $Mv->costo_promedio;
                $hp = $Mv->costo_promedio * $Mov->cantidad;
            }else{
                $cp = 0.00;
                $hp = 0.00;
            }
            $pdf->setX(10);
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(15, $this->alto, $Mov->producto_id, "LTB", 0,"R");
            $pdf->Cell(25, $this->alto, $Mov->codigo, "LTB", 0,"R");
            $pdf->Cell(130, $this->alto, utf8_decode(trim($Mov->descripcion)), "LTB", 0,"L");
            $pdf->Cell(25, $this->alto, number_format($Mov->cantidad,2), "LRBR", 1,"R");
            $total += $Mov->cantidad;
            if ($pdf->getY() > 230 ){
                $this->footer_grupal($pdf);
                $this->header_grupal($pdf);
                $pdf->SetFillColor(32,32,32);
                $pdf->SetFont('Arial','',6);
            }
        }
        $pdf->setX(10);
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(170, $this->alto, "TOTAL ", "LRB", 0,"R");
        $pdf->Cell(25, $this->alto, number_format($total,2), "LRB", 1,"R");
        $pdf->Output('I','venta-consolidada-producto-grupal-'.$this->empresa_id.'-'.$this->timex.'.pdf');
    }


}
