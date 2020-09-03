<?php

namespace App\Http\Controllers\Externos;

use App\Models\SIIFAC\Empresa;
use App\Models\SIIFAC\Ingreso;
use App\Models\SIIFAC\NotaCredito;
use App\Models\SIIFAC\NotaCreditoDetalle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use FPDF;
use App\User;
use App\Models\SIIFAC\Venta;

class NotaCreditoPrintController extends Controller
{

    protected $alto        = 6;
    protected $aFT         = 205;
    protected $timex       = "";
    protected $foli0       = "";
    protected $cliente_id  = 0;
    protected $vendedor_id = 0;
    protected $cliente     = "";
    protected $vendedor    = "";
    protected $status      = "";
    protected $metodo_pago = "";
    protected $referencia  = "";
    protected $tipo_venta  = "";
    protected $title       = "";
    protected $empresa     = "";


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
        $pdf->SetFont('Arial','',6);
        $pdf->Cell(25,$this->alto,utf8_decode($this->tipo_venta),0,0,"R");
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(30,$this->alto,$this->status,0,1,"R");
        $pdf->Ln(5);
        $pdf->setX(10);
        $this->alto  = 10;
        $pdf->SetFont('Arial','B',10);
        $pdf->SetFillColor(192,192,192);
        $pdf->Cell(25,$this->alto,"CANT.",1,0,"C",true);
        $pdf->Cell(145,$this->alto,utf8_decode("DESCRIPCIÓN"),1,0,"L",true);
        $pdf->Cell(25,$this->alto,"IMPORTE",1,1,"R",true);
        $this->alto  = 6;
        $pdf->setX(10);
    }

    public function print_nota_credito($nota_credito_id)
    {
        $Ven               = NotaCredito::find($nota_credito_id);
        $VD                = NotaCreditoDetalle::all()->where('nota_credito_id',$nota_credito_id);
        $this->timex       = Carbon::now()->format('d-m-Y H:i:s');
        $this->folio       = $nota_credito_id;

        $this->cliente_id  = $Ven->user_id;
        $this->cliente     = $Ven->user->FullName;
        $Emp               = Empresa::find($Ven->empresa_id);
        $this->empresa     = $Emp->rs;

        $this->status      = "";
        $this->metodo_pago = strtoupper($Ven->MetodoPago);
        $this->referencia  = $Ven->referencia;
        $this->tipo_venta  = strtoupper($Ven->TipoVenta);
        $this->title       = "NOTA DE CRÉDITO";
        $pdf               = new FPDF('P','mm','Letter');
        $pdf->AliasNbPages();
        $pdf->SetFillColor(192,192,192);
        $this->header($pdf);
        $this->alto  = 10;
        $pdf->SetFont('Arial','',8);
        foreach ($VD as $vd){
            $pdf->Cell(25,$this->alto,number_format($vd->cant,0),1,0,"C");
            $pdf->Cell(145,$this->alto,utf8_decode($vd->descripcion_producto),1,0,"L");
            $pdf->Cell(25,$this->alto,number_format($vd->importe,2),1,1,"R");
            $pdf->setX(10);
        }
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(170,$this->alto,"TOTAL A UTILIZAR $ ",1,0,"R",true);
        $pdf->Cell(25,$this->alto,number_format($Ven->importe,2),1,1,"R",true);
        $pdf->setX(10);

        $VD = Ingreso::all()->where('nota_credito_id',$nota_credito_id);
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(25,$this->alto,"","",0,"L");
        $pdf->Cell(145,$this->alto,utf8_decode("HISTORIAL DE USO"),"",1,"C",false);
        $pdf->setX(10);

        $pdf->SetFont('Arial','B',10);
        $pdf->SetFillColor(192,192,192);
        $pdf->Cell(40,$this->alto,"FECHA",1,0,"C",true);
        $pdf->Cell(60,$this->alto,utf8_decode("MÉTODO DE PAGO"),1,0,"L",true);
        $pdf->Cell(65,$this->alto,utf8_decode("REFERENCIA"),1,0,"L",true);
        $pdf->Cell(30,$this->alto,"IMPORTE",1,1,"R",true);
        $this->alto  = 6;
        $pdf->setX(10);
        $pdf->SetFont('Arial','',8);
        foreach ($VD as $vd){
            $pdf->Cell(40,$this->alto,Carbon::parse($vd->fecha)->format('d-m-Y H:i:ss a'),1,0,"C");
            $pdf->Cell(60,$this->alto,utf8_decode($vd->MetodoPago),1,0,"L");
            $pdf->Cell(65,$this->alto,utf8_decode($vd->referencia),1,0,"L");
            $pdf->Cell(30,$this->alto,number_format($vd->total,2),1,1,"R");
            $pdf->setX(10);

        }
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(165,$this->alto,"TOTAL UTILIZADO $ ",1,0,"R",true);
        $pdf->Cell(30,$this->alto,number_format($Ven->SaldoUtilizado,2),1,1,"R",true);
        $pdf->setX(10);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(165,$this->alto,"SALDO A FAVOR $ ",1,0,"R",true);
        $pdf->Cell(30,$this->alto,number_format($Ven->Saldo,2),1,1,"R",true);
        $pdf->setX(10);

        $pdf->Ln();
        $pdf->Output();

        exit;
    }



}
