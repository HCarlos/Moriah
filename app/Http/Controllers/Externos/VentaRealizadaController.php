<?php

namespace App\Http\Controllers\Externos;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\SIIFAC\Venta;
use Carbon\Carbon;

class VentaRealizadaController extends Controller
{
    protected $alto     = 6;
    protected $aFT      = 205;
    protected $timex    = "";
    protected $f1       = "";
    protected $f2       = "";
    protected $vendedor = "";
    protected $empresa  = "";
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
        $pdf->Cell(37,$this->alto,"VENTA REALIZADA | ","",0,"L");
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(105,$this->alto,$this->vendedor,"",0,"L");
        $pdf->SetFont('Arial','',7);
        $pdf->SetFillColor(0,212,212);
        $pdf->Cell(33, $this->alto, utf8_decode("Página " . $pdf->PageNo() . " de {nb}"), "", 1,"R");
        $pdf->setX(10);
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(10, $this->alto, 'ID', "LTB", 0,"R");
        $pdf->Cell(10, $this->alto, 'FOLIO', "LTB", 0,"R");
        $pdf->Cell(15, $this->alto, 'TIPO', "LTB", 0,"L");
        $pdf->Cell(65, $this->alto, 'CLIENTE', "LTB", 0,"L");
        $pdf->Cell(30, $this->alto, 'VENDEDOR', "LTB", 0,"L");
        $pdf->Cell(15, $this->alto, 'FECHA', "LTB", 0,"R");
        $pdf->Cell(17, $this->alto, 'IMPORTE', "LTB", 0,"R");
        $pdf->Cell(17, $this->alto, 'ABONO', "LTB", 0,"R");
        $pdf->Cell(17, $this->alto, 'RESTA', "LTRB", 1,"R");
        $pdf->setX(10);
    }

    public function imprimir_Venta($f1,$f2,$vendedor,$pdf,$Movs,$empresa,$m)
    {
        $this->f1 = $f1;
        $this->f2 = $f2;
        $this->vendedor = $vendedor;
        $this->empresa = $empresa;
        $this->empresa_id = $m->empresa_id;
        $this->timex = Carbon::now()->format('d-m-Y_h:m:s_a');

        $pdf->AliasNbPages();
        $this->header($pdf);
        $pdf->SetFillColor(32,32,32);
        $pdf->SetFont('Arial','',6);
        $total = $abono = $tresta = 0;
        foreach ($Movs as $Mov){
//            $Ven = Venta::find($Mov->venta_id);
//            dd($Mov);
//            $pdf->setX(10);
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(10, $this->alto, $Mov->id, "LTB", 0,"R");
            $pdf->Cell(10, $this->alto, utf8_decode(trim($Mov::getFolioImpreso($Mov->empresa_id, $Mov->id))), "LTB", 0,"R");
//            $pdf->Cell(10, $this->alto, "", "LTB", 0,"R");
            $pdf->Cell(15, $this->alto, utf8_decode(trim($Mov->tipoventa)), "LTB", 0,"L");
            $pdf->Cell(65, $this->alto, utf8_decode(trim($Mov->user->FullName)), "LTB", 0,"L");
            $pdf->Cell(30, $this->alto, utf8_decode(trim($Mov->vendedor->username)), "LTB", 0,"L");
            $pdf->Cell(15, $this->alto, $this->F->fechaEspanol($Mov->fecha), "LTB", 0,"R");
            $total += $Mov->total;
            $abonos = $Mov->Abonos;
            $abono += $abonos;
            $resta  = ($Mov->total - $abonos);
            $tresta += $resta;
            $pdf->SetFont('AndaleMono','',7);
            $pdf->Cell(17, $this->alto, number_format($Mov->total,2), "LTB", 0,"R");
            $pdf->Cell(17, $this->alto, number_format($abonos,2), "LTB", 0,"R");
            $pdf->Cell(17, $this->alto, number_format($resta,2), "LTRB", 1,"R");
        }
        $pdf->setX(10);
        if ($Movs->count() > 0){
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(145, $this->alto, 'TOTAL $ ', "LB", 0,"R");
            $pdf->SetFont('AndaleMonoMTStdBold','',7);
            $pdf->Cell(17, $this->alto, number_format($total,2), "LRB", 0,"R");
            $pdf->Cell(17, $this->alto, number_format($abono,2), "LRB", 0,"R");
            $pdf->Cell(17, $this->alto, number_format($tresta,2), "LRB", 1,"R");
        }else{
            $pdf->SetFont('Arial','BI',10);
            $pdf->Cell(196, 20, 'NO SE ENCONTRARON DATOS', "LBR", 1,"C");
        }
        $pdf->Output('D','venta-realizada-'.$this->empresa_id.'-'.$this->timex.'.pdf');
    }

}
