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
    protected $IdNC        = 0;
    protected $aFT         = 205;
    protected $timex       = "";
    protected $folio       = "";
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
    protected $empresa_id  = 0;
    protected $subtitulo   = "";


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
        $pdf->Cell(145,$this->alto,utf8_decode($this->title),"",0,"C",true);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(15,$this->alto,"ID: ","",0,"R");
        $pdf->SetFont('Arial','',8);
        $pdf->SetFillColor(240,240,240);
        $pdf->Cell(10,$this->alto,$this->IdNC,"",1,"R");
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
        $VD                = NotaCreditoDetalle::query()
                            ->where('nota_credito_id',$nota_credito_id)
                            ->get();
        $this->timex       = Carbon::now()->format('d-m-Y H:i:s');
        $this->folio       = $Ven->consecutivo <= 0 ? $nota_credito_id : $Ven->consecutivo;
        $this->IdNC        = $Ven->id;
        $this->cliente_id  = $Ven->user_id;
        $this->cliente     = $Ven->user->FullName;
        $Emp               = Empresa::find($Ven->empresa_id);
        $this->empresa     = $Emp->rs;
        $this->empresa_id  = $Emp->id;

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
            $pdf->Cell(25,$this->alto,number_format($vd->cant,2),1,0,"C");
            $pdf->Cell(145,$this->alto,utf8_decode($vd->descripcion_producto),1,0,"L");
            $pdf->Cell(25,$this->alto,number_format($vd->importe,2),1,1,"R");
            $pdf->setX(10);
        }
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(170,$this->alto,"TOTAL A UTILIZAR $ ",1,0,"R",true);
        $pdf->Cell(25,$this->alto,number_format($Ven->importe,2),1,1,"R",true);
        $pdf->setX(10);

        $VD = Ingreso::query()
            ->where('nota_credito_id',$nota_credito_id)
            ->get();
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
        $pdf->Output('I','nota-credito-'.$this->empresa_id.'-'.$this->IdNC.'-'.$this->folio.'.pdf');

        exit;
    }

    public function header_list_01($pdf){
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
        $pdf->Cell(150,$this->alto,utf8_decode("Av. México Núm. 2, Col. Del Bosque, Villahermosa, Tabasco. CP 86160"),"",1,"L");
        $pdf->setX(10);
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(25,$this->alto,"","",0,"L");
        $pdf->Cell(145,$this->alto,utf8_decode($this->title),"",1,"L",true);
        $pdf->ln(5);
        $pdf->setX(10);
        $this->alto  = 10;
        $pdf->SetFont('Arial','B',8);
        $pdf->SetFillColor(192,192,192);
        $pdf->Cell(25,$this->alto,"ID/FOLIO",1,0,"R",true);
        $pdf->Cell(25,$this->alto,"FECHA",1,0,"C",true);
        $pdf->Cell(25,$this->alto,"SUBTOTAL",1,0,"R",true);
        $pdf->Cell(25,$this->alto,"IVA",1,0,"R",true);
        $pdf->Cell(25,$this->alto,"IMPORTE",1,0,"R",true);
        $pdf->Cell(25,$this->alto,"UTILIZADO",1,0,"R",true);
        $pdf->Cell(25,$this->alto,"PENDIENTE",1,1,"R",true);
        $this->alto  = 6;
        $pdf->setX(10);
    }
    public function listadoNotaDeCredito($f1,$f2,$Movs,$empresa,$tipo_reporte){

        $this->timex       = Carbon::now()->format('d-m-Y_H:i:s');

        $Emp               = $empresa;
        $this->empresa     = trim($empresa->rs);
        $this->empresa_id  = $Emp->id;

        $this->status      = "";
        $this->folio       = "";
        $suf               = $tipo_reporte == 3 ? "PV" : "PC";
        $this->subtitulo   = "(" . $suf . ")";
        $this->title       = "LISTADO DE NOTAS DE CRÉDITO " . $this->subtitulo;
        $pdf               = new FPDF('P','mm','Letter');
        $pdf->AliasNbPages();
        $pdf->SetFillColor(192,192,192);
        $this->header_list_01($pdf);
        $this->alto  = 10;
        $total = 0;
        $pdf->SetFont('Arial','',8);
        foreach ($Movs as $nc){
//            dd($nc);
            if ($nc->Saldo>0){
                $lSaldo = number_format($nc->Saldo,2);
            }else{
                $lSaldo = "";
            }
            $lSaldoUtitlizado = number_format($nc->SaldoUtilizado,2);
            $_total = $nc::totalNotaCreditoPorPrecio($nc->id,$tipo_reporte,2);
            $total  += $_total;
            $folio = $nc->consecutivo <= 0 ? $nc->id : $nc->consecutivo;
            $pdf->Cell(25,$this->alto,$folio,1,0,"R");
            $pdf->Cell(25,$this->alto,Carbon::parse($nc->fecha)->format('d-m-Y'),1,0,"C");
            $pdf->Cell(25,$this->alto,number_format($nc::totalNotaCreditoPorPrecio($nc->id,$tipo_reporte,0),2),1,0,"R");
            $pdf->Cell(25,$this->alto,number_format($nc::totalNotaCreditoPorPrecio($nc->id,$tipo_reporte,1),2),1,0,"R");
            $pdf->Cell(25,$this->alto,number_format($_total,2),1,0,"R");
            $pdf->Cell(25,$this->alto,$lSaldoUtitlizado,1,0,"R");
            $pdf->Cell(25,$this->alto,$lSaldo,1,1,"R");
            $pdf->setX(10);
        }
        $pdf->SetFont('Arial','B',8);
        $pdf->SetFillColor(192,192,192);
        $pdf->Cell(100,$this->alto,"TOTAL",1,0,"R",true);
        $pdf->Cell(25,$this->alto,number_format($total,2),1,0,"R",true);
        $pdf->Cell(25,$this->alto,"",1,0,"R",true);
        $pdf->Cell(25,$this->alto,"",1,1,"R",true);

        $pdf->Ln();
        $pdf->Output('I','listado-notas-credito-'.$this->empresa_id.'-'.$this->timex.'.pdf');

        exit;
    }


    public function header_list_02($pdf){
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
        $pdf->Cell(150,$this->alto,utf8_decode("Av. México Núm. 2, Col. Del Bosque, Villahermosa, Tabasco. CP 86160"),"",1,"L");
        $pdf->setX(10);
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(25,$this->alto,"","",0,"L");
        $pdf->Cell(145,$this->alto,utf8_decode($this->title),"",1,"L",true);
        $pdf->ln(5);
        $pdf->setX(10);
        $this->alto  = 10;
        $pdf->SetFont('Arial','B',6);
        $pdf->SetFillColor(192,192,192);
        $pdf->Cell(10,$this->alto,"FOLIO",1,0,"L",true);
        $pdf->Cell(20,$this->alto,"FECHA",1,0,"C",true);
        $pdf->Cell(70,$this->alto,"CLIENTE",1,0,"L",true);
        $pdf->Cell(25,$this->alto,"IMPORTE",1,0,"R",true);
        $pdf->Cell(25,$this->alto,"UTILIZADO",1,0,"R",true);
        $pdf->Cell(25,$this->alto,"PENDIENTE",1,1,"R",true);
        $this->alto  = 6;
        $pdf->setX(10);
    }
    public function listadoClientesSaldoAFavor($Movs,$empresa)
    {
        $this->timex       = Carbon::now()->format('d-m-Y_H:i:s');

        $Emp               = $empresa;
        $this->empresa     = trim($empresa->rs);
        $this->empresa_id  = $Emp->id;

        $this->status      = "";
        $this->folio       = "";
        $this->title       = "LISTADO DE CLIENTE CON SALDO A FAVOR " . $this->subtitulo;
        $pdf               = new FPDF('P','mm','Letter');
        $pdf->AliasNbPages();
        $pdf->SetFillColor(192,192,192);
        $this->header_list_02($pdf);
        $this->alto  = 10;
        $total = 0;
        $pdf->SetFont('Arial','',7);
        foreach ($Movs as $item){
            foreach ($item->Notas_Credito as $nc){

//            dd($nc);
            if ($nc->saldo>0){
                $lSaldo = number_format($nc->Saldo,2);
            }else{
                $lSaldo = "";
            }
            $lSaldoUtitlizado = number_format($nc->importe_utilizado,2);
            $_total = $nc->saldo_utilizado;
            $total  += $_total;
            $folio = $nc->consecutivo <= 0 ? $nc->id : $nc->consecutivo;
            $pdf->Cell(10,$this->alto,$folio,1,0,"R");
            $pdf->Cell(20,$this->alto,Carbon::parse($nc->fecha)->format('d-m-Y'),1,0,"C");
            $pdf->Cell(70,$this->alto,$nc->user->FullName,1,0,"L");
            $pdf->Cell(25,$this->alto,number_format($nc->importe,2),1,0,"R");
            $pdf->Cell(25,$this->alto,$lSaldoUtitlizado,1,0,"R");
            $pdf->Cell(25,$this->alto,$lSaldo,1,1,"R");
            $pdf->setX(10);
        }
        }
        $pdf->SetFont('Arial','B',8);
        $pdf->SetFillColor(192,192,192);
        $pdf->Cell(100,$this->alto,"TOTAL",1,0,"R",true);
        $pdf->Cell(25,$this->alto,number_format($total,2),1,0,"R",true);
        $pdf->Cell(25,$this->alto,"",1,0,"R",true);
        $pdf->Cell(25,$this->alto,"",1,1,"R",true);

        $pdf->Ln();
        $pdf->Output('I','listado-clientes-saldo-favor-'.$this->empresa_id.'-'.$this->timex.'.pdf');

        exit;
    }



}
