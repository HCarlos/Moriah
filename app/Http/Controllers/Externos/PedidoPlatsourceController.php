<?php

namespace App\Http\Controllers\Externos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SIIFAC\Pedido;
use App\Models\SIIFAC\PedidoDetalle;
use Carbon\Carbon;
use FPDF;

class PedidoPlatsourceController extends Controller{
    
    protected $alto        = 6;
    protected $aFT         = 205;
    protected $timex       = "";
    protected $foli0       = "";
    protected $cliente_id  = 0;
    protected $cliente     = "";
    protected $status      = "";
    protected $referencia  = "";
    protected $title       = "";
    protected $observaciones = "";


    public function header($pdf){
        $pdf->AddPage();
        $pdf->setY(10);
        $pdf->setX(10);
        $pdf->SetTextColor(0,0,0);

        $pdf->SetFont('Arial','B',12);
        $pdf->Image('assets/img/logo-arji.gif',10,10,20,20);
        $pdf->Cell(25,$this->alto,"","",0,"L");
        $pdf->Cell(150,$this->alto,utf8_decode("COMERCIALIZADORA ARJÍ A.C."),"",0,"L");
        $pdf->SetFont('Arial','',7);
        $pdf->SetFillColor(212,212,212);
        $pdf->Cell(20,$this->alto,$this->timex,"",1,"R");
        $pdf->setX(10);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(25,$this->alto,"","",0,"L");
        $pdf->Cell(150,$this->alto,utf8_decode("Av. México Núm. 2, Col. Del Bosque, Villahermosa, Tabasco. CP 86160"),"",0,"L");
        $pdf->Cell(10,$this->alto,"FOLIO: ","",0,"R");
        $pdf->SetFont('Arial','',8);
        $pdf->SetFillColor(240,240,240);
        $pdf->Cell(10,$this->alto,$this->folio,"",1,"R");
        $pdf->setX(10);
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(25,$this->alto,"","",0,"L");
        $pdf->Cell(145,$this->alto,utf8_decode($this->title),"",1,"C",true);
        $pdf->Ln(5);
        $pdf->Line(32,11,32,29);
        $pdf->Line(32.5,11,32.5,29);
        $pdf->Line(33,11,33,29);
        $pdf->setX(10);
        $pdf->SetFont('Arial','B',10);
        $pdf->SetFillColor(192,192,192);
        $pdf->Cell(25,$this->alto,"CLIENTE:",0,0,"R");
        $pdf->Cell(10,$this->alto,$this->cliente_id,0,0,"R");
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(105,$this->alto,utf8_decode(trim($this->cliente)),0,0,"L");
        $pdf->Cell(30,$this->alto,$this->status,0,1,"R");
        $pdf->Ln(5);
        $pdf->setX(10);
        $this->alto  = 10;
        $pdf->SetFont('Arial','B',10);
        $pdf->SetFillColor(192,192,192);
        $pdf->Cell(25,$this->alto,"CANT.",1,0,"C",true);
        $pdf->Cell(120,$this->alto,utf8_decode("DESCRIPCIÓN"),1,0,"L",true);
        $pdf->Cell(25,$this->alto,"PRECIO",1,0,"C",true);
        $pdf->Cell(25,$this->alto,"IMPORTE",1,1,"R",true);
        $this->alto  = 6;
        $pdf->setX(10);
    }



    public function print_pedido($pedido_id){
        $Ped               = Pedido::find($pedido_id);
        $Pdd               = PedidoDetalle::all()->where('pedido_id',$pedido_id);
        $this->timex       = Carbon::now()->format('d-m-Y H:i:s');
        $this->folio       = $pedido_id;
        $this->cliente_id  = $Ped->user_id;
        $this->cliente     = $Ped->user->FullName;
        $this->status      = $Ped->isactivo ? "VIGENTE" : "CANCELADO";
        $this->referencia  = $Ped->referencia;
        $this->title       = "P  E  D  I  D  O";
        $this->observaciones = $Ped->observaciones;

        $pdf               = new FPDF('P','mm','Letter');

        $pdf->AliasNbPages();
        $pdf->SetFillColor(192,192,192);
        $this->header($pdf);
        $this->alto  = 10;
        $pdf->SetFont('Arial','',8);
        $importe = 0;
        $total = 0;
        foreach ($Pdd as $Pd){
            $importe = $Pd->cant * $Pd->pv;
            $pdf->Cell(25,$this->alto,number_format($Pd->cant,0),1,0,"C");
            $pdf->Cell(120,$this->alto,utf8_decode($Pd->descripcion_producto),1,0,"L");
            $pdf->Cell(25,$this->alto,number_format($Pd->pv,0),1,0,"C");
            $pdf->Cell(25,$this->alto,number_format($importe,2),1,1,"R");
            $pdf->setX(10);
        }
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(170,$this->alto,"TOTAL A PAGAR $ ",1,0,"R",true);
        $pdf->Cell(25,$this->alto,number_format($Ped->total_internet,2),1,1,"R",true);
        $pdf->setX(10);

        $pdf->SetFont('Arial','',8);
        $pdf->Cell(60,$this->alto,utf8_decode("REFERENCIA Ó CONCEPTO PARA PAGAR: "),0,0,"L");
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(50,$this->alto,$Ped->referencia,0,1,"L");
        $pdf->setX(10);

        $pdf->SetFont('Arial','',10);
        $pdf->Cell(195,$this->alto,utf8_decode($Ped->observaciones),0,1,"L");
        $pdf->setX(10);

        $pdf->Ln();
        $pdf->Output();
        exit;
    }




}
