<?php

namespace App\Http\Controllers\Externos;

use App\Http\Controllers\Classes\PDF_Diag;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\SIIFAC\Pedido;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class VantasListadoController extends Controller{
    
    public function __construct(){
        $this->middleware('auth');
        $this->F = (new FuncionesController);
    }

    protected $alto = 6;
    protected $empresa = "None";

    protected function header($pdf){
        $pdf->AddPage();
        $pdf->setY(10);
        $pdf->setX(10);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFillColor(192,192,192);
        $pdf->SetFont('Arial','B',12);
        $pdf->Image('assets/img/logo-arji.gif',10,10,20,20);
        $pdf->Cell(25,$this->alto,"","",0,"L");
        $pdf->Cell(215,$this->alto,utf8_decode($this->empresa),"",0,"L");
        $pdf->SetFont('Arial','',7);
        $pdf->SetFillColor(212,212,212);
        $pdf->Cell(20,$this->alto,$this->timex,"",1,"R");
        $pdf->setX(10);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(25,$this->alto,"","",0,"L");
        $pdf->Cell(11,$this->alto,"Desde: ","",0,"L");
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(30,$this->alto,$this->f1,"",0,"L");
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(10,$this->alto,"Hasta: ","",0,"L");
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(20,$this->alto,$this->f2,"",1,"L");
        $pdf->setX(10);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(25,$this->alto,"","",0,"L");
        $pdf->Cell(200,$this->alto,"LISTADO DE VENTAS REALIZADAS","",0,"L");
        $pdf->SetFont('Arial','',7);
        $pdf->SetFillColor(0,212,212);
        $pdf->Cell(38, $this->alto, utf8_decode("Página " . $pdf->PageNo() . " de {nb}"), "", 1,"R");
        $pdf->setX(10);
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(10, $this->alto, 'ID', "LTB", 0,"R");
        $pdf->Cell(55, $this->alto, 'CLIENTE', "LTB", 0,"L");
        $pdf->Cell(55, $this->alto, 'PAQUETE', "LTB", 0,"L");
        $pdf->Cell(140, $this->alto, 'OBSERVACIONES', "LRTB", 1,"C");
        $pdf->setX(10);
    }

    public function imprimirListadoVentas($f1,$f2)
    {
        $this->f1 = $f1;
        $this->f2 = $f2;
        $items = Session::get('items');
        

        $Emp = $items->first();
        $this->empresa = $Emp->empresa->rs;
        $this->timex = Carbon::now()->format('d-m-Y h:m:s a');
        $pdf  = new PDF_Diag('L','mm','Letter');
        $pdf->addFont('AndaleMono');
        $pdf->addFont('arialn');        
        $pdf->addFont('AndaleMonoMTStdBold');

        $pdf->AliasNbPages();
        $this->header($pdf);
        $pdf->SetFillColor(32,32,32);
        $pdf->SetFont('Arial','',6);
        $total = 0;
        foreach ($items as $Mov){
            $pdf->setX(10);
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(10, $this->alto, $Mov->id, "LTB", 0,"R");
            $pdf->Cell(55, $this->alto, utf8_decode(trim($Mov->user->FullName)), "LTB", 0,"L");
            $Ped = Pedido::find($Mov->pedido_id);
            if ($Mov->paquete_id > 0)
                $pdf->Cell(55, $this->alto, utf8_decode(trim($Mov->paquete->FullDescription)), "LTB", 0,"L");
            else if ( !is_null($Ped) )
                $pdf->Cell(55, $this->alto, utf8_decode(trim($Ped->FullDescription)), "LTB", 0,"L");
            else 
                $pdf->Cell(55, $this->alto, utf8_decode(trim($Mov->TipoVenta)), "LTB", 0,"L");

            $pdf->SetFont('Arialn','',7);
            if ( !is_null($Ped) )
                $pdf->Cell(140, $this->alto, utf8_decode(trim($Ped->observaciones)), "LRTB", 1,"L");
            else    
                $pdf->Cell(140, $this->alto, '', "LRTB", 1,"L");
  
            $total += $Mov->total;
        }
        $pdf->setX(10);
        if ($items->count() > 0){
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(103, $this->alto, 'TOTAL $ ', "LB", 0,"R");
            $pdf->SetFont('AndaleMonoMTStdBold','',7);
            $pdf->Cell(17, $this->alto, number_format($total,2), "LRB", 1,"R");
        }else{
            $pdf->SetFont('Arial','BI',10);
            $pdf->Cell(260, 20, 'NO SE ENCONTRARON DATOS', "LBR", 1,"C");
        }
        $pdf->Output();
    }

}
