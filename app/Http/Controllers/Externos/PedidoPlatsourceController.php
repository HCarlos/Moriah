<?php

namespace App\Http\Controllers\Externos;

use App\Models\SIIFAC\Empresa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SIIFAC\Paquete;
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
    protected $paquete_id    = 0;
    protected $paquete       = "";
    protected $alumno        = "";
    protected $grado         = "";
    protected $grupo         = "";
    protected $ref0          = "";
    protected $ref1          = "";
    protected $ref2          = "";
    protected $ref3          = "";
    protected $empresa       = "";
    protected $idalumno_ps   = "";


    public function header($pdf){
        $pdf->AddPage();
        $pdf->setY(10);
        $pdf->setX(10);
        $pdf->SetTextColor(0,0,0);

        $pdf->SetFont('Arial','B',12);
        $pdf->Image('assets/img/logo-arji.gif',10,10,20,20);
        $pdf->Cell(25,$this->alto,"","",0,"L");
        $pdf->Cell(150,$this->alto,utf8_decode($this->empresa),"",0,"L");
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
        $pdf->Ln();
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
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(15,$this->alto,"ESTATUS:",0,0,"R");
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(15,$this->alto,$this->status,0,1,"L");
        $pdf->SetFont('Arial','B',10);
        $pdf->SetFillColor(192,192,192);
        $pdf->Cell(25,$this->alto,"ALUMNO:",0,0,"R");
        $pdf->Cell(10,$this->alto,$this->idalumno_ps,0,0,"R");
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(105,$this->alto,utf8_decode(trim($this->alumno)),0,0,"L");
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(15,$this->alto,"GRADO:",0,0,"R");
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(15,$this->alto,$this->grado,0,1,"L");
        $pdf->SetFont('Arial','B',10);
        $pdf->SetFillColor(192,192,192);
        $pdf->Cell(25,$this->alto,"PAQUETE:",0,0,"R");
        $pdf->Cell(10,$this->alto,$this->paquete_id,0,0,"R");
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(105,$this->alto,utf8_decode(trim($this->paquete)),0,0,"L");
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(15,$this->alto,"GRUPO:",0,0,"R");
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(15,$this->alto,$this->grupo,0,1,"L");
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
        $Paq               = Paquete::find($Ped->paquete_id);
        $this->timex       = Carbon::now()->format('d-m-Y H:i:s');
        $this->folio       = $pedido_id;
        $this->cliente_id  = $Ped->user_id;
        $this->cliente     = $Ped->user->FullName;
        $this->status      = $Ped->isactivo ? "VIGENTE" : "CANCELADO";
        $this->referencia  = $Ped->referencia;
        $this->title       = "P  E  D  I  D  O";
        $this->observaciones = $Ped->observaciones;
        $this->paquete_id    = $Paq->id;
        $this->paquete       = $Paq->codigo.' '.$Paq->descripcion_paquete;
        $Emp               = Empresa::find($Paq->empresa_id);
        $this->empresa     = $Emp->rs;

        $this->ref0 = substr($Ped->referencia,0,4);
        $this->ref1 = substr($Ped->referencia,4,4);
        $this->ref2 = substr($Ped->referencia,8,4);
        $this->ref3 = substr($Ped->referencia,12,4);

        $this->alumno      = trim($Ped->nombre_completo_alumno);
        $this->grado       = trim($Ped->grado);
        $this->grupo       = trim($Ped->grupo);
        $this->idalumno_ps = $Ped->idalumno_ps;

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

        $this->alto  = 6;

        $pdf->SetFont('Arial','',8);
        $pdf->Cell(60,$this->alto,utf8_decode("REFERENCIA Ó CONCEPTO PARA PAGAR: "),0,0,"L");
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(50,$this->alto,$this->ref0.' '.$this->ref1.' '.$this->ref2.' '.$this->ref3,0,1,"L");
        $pdf->setX(10);
        
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(60,$this->alto,utf8_decode("OBSERVACIONES DE COMPRA Y ENTREGA: "),0,1,"L");
        $pdf->SetFont('Arial','B',8);
        // $pdf->Cell(195,$this->alto,utf8_decode($Ped->observaciones),0,1,"L");
        $pdf->setX(10);
        $pdf->MultiCell(195, 6, utf8_decode($Ped->observaciones),'', 'L');
        $pdf->setX(10);

        $pdf->SetFont('Arial','',8);
        $pdf->Cell(60,$this->alto,utf8_decode("FECHA DE VENCIMIENTO: "),0,0,"L");
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(50,$this->alto,$Ped->fecha_vencimiento,0,1,"L");
        $pdf->setX(10);

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(60,$this->alto,utf8_decode("DATOS PARA EL DEPOSITO: "),0,1,"L");
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(120,$this->alto,utf8_decode("ALIMENTOS ESPECIALIZADOS DE TABASCO, S.A."),0,1,"L");
        $pdf->Cell(60,$this->alto,utf8_decode("BANCO SANTANDER"),0,1,"L");
        $pdf->Cell(60,$this->alto,utf8_decode("CTA: 6550 6038 586"),0,1,"L");
        $pdf->Cell(60,$this->alto,utf8_decode("CLABE: 0147 9065 5060 3858 69"),0,1,"L");
        $pdf->setX(10);
        $pdf->Ln();

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(60,$this->alto,utf8_decode("IMPORTANTE: "),0,1,"L");
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(195,$this->alto,utf8_decode("Referencia Alfanumérica:____________(anotar la que generó su pedido)"),0,1,"L");
        $pdf->Cell(195,$this->alto,utf8_decode("Enviar comprobante de pago y datos de facturación en caso de requerirlo al correo: caja_arji@hotmail.com"),0,1,"L");
        $pdf->setX(10);
        $pdf->Ln();

        $pdf->Output();
        exit;
    }




}
