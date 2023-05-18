<?php

namespace App\Http\Controllers\Externos;

use App\Models\SIIFAC\Empresa;
use App\Models\SIIFAC\EmpresaVenta;
use App\Models\SIIFAC\Ingreso;
use App\Models\SIIFAC\Movimiento;
use App\Models\SIIFAC\Venta;
use App\Models\SIIFAC\VentaDetalle;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use FPDF;

class TicketController extends Controller
{
    protected $alto        = 6;
    protected $aFT         = 205;
    protected $timex       = "";
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
    protected $venta_id    = 0;
    protected $empresa_id  = 0;
    /**
     * @var int
     */
    private $folio;


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
        $pdf->Cell(5,$this->alto,"","",0,"C",false);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(10,$this->alto,"ID: ","",0,"R");
        $pdf->SetFont('Arial','',8);
        $pdf->SetFillColor(240,240,240);
        $pdf->Cell(10,$this->alto,$this->venta_id,"",1,"R");
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
        $pdf->setX(10);
        $pdf->SetFont('Arial','B',10);
        $pdf->SetFillColor(192,192,192);
        $pdf->Cell(25,$this->alto,"VENDEDOR:",0,0,"R");
        $pdf->Cell(10,$this->alto,$this->vendedor_id,0,0,"R");
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(105,$this->alto,utf8_decode(trim($this->vendedor)),0,0,"L");
        $pdf->SetFont('Arial','B',6);
        $pdf->Cell(25,$this->alto,utf8_decode("MÉTODO DE PAGO:"),0,0,"R");
        $pdf->SetFont('Arial','',6);
        $pdf->Cell(30,$this->alto,utf8_decode($this->metodo_pago.' '.$this->referencia),0,1,"R");
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



    public function print_tiket($venta_id)
    {
        $Ven               = Venta::find($venta_id);
        $IsCompra = str_contains($Ven->MetodoPago,'Compra');
        if ($IsCompra){
            $VD            = Movimiento::all()->where('venta_id',$venta_id);
        }else{
            $VD            = VentaDetalle::all()->where('venta_id',$venta_id);
        }
        $this->venta_id    = $venta_id;
        $this->timex       = Carbon::now()->format('d-m-Y H:i:s');
        $this->folio       = Venta::getFolioImpreso($Ven->empresa_id, $venta_id);
        $this->cliente_id  = $Ven->user->id;
        $this->vendedor_id = $Ven->vendedor->id;
        $this->cliente     = $Ven->user->FullName;
        $this->vendedor    = $Ven->vendedor->FullName;
        $this->status      = $Ven->isPagado() ? "PAGADO" : "NO PAGADO";
        $this->metodo_pago = strtoupper($Ven->MetodoPago);
        $this->referencia  = $Ven->referencia;
        $this->tipo_venta  = strtoupper($Ven->TipoVenta);
        $this->title       = "NOTA DE REMISIÓN";
        $Emp               = Empresa::find($Ven->empresa_id);
        $this->empresa     = $Emp->rs;
        $this->empresa_id  = $Emp->id;

        $pdf               = new FPDF('P','mm','Letter');

        $pdf->AliasNbPages();
        $pdf->SetFillColor(192,192,192);
        $this->header($pdf);
        $this->alto  = 10;
        $pdf->SetFont('Arial','',8);
        $Total = 0;
        foreach ($VD as $vd){

            if ($IsCompra){
                $total = $vd->salida * $vd->cu;
                $Total += $total;
                $pdf->Cell(25,$this->alto,number_format($vd->salida,2),1,0,"C");
                $pdf->Cell(145,$this->alto,utf8_decode($vd->producto->descripcion).' :: '.$vd->cu.' c/u',1,0,"L");
                $pdf->Cell(25,$this->alto,number_format($total,2),1,1,"R");
            }else{
                $total = $vd->total;
                $Total += $total;
            $pdf->Cell(25,$this->alto,number_format($vd->cantidad,2),1,0,"C");
            $pdf->Cell(145,$this->alto,utf8_decode($vd->descripcion),1,0,"L");
            $pdf->Cell(25,$this->alto,number_format($vd->total,2),1,1,"R");
            }
//            $pdf->Cell(30,$this->alto,number_format($total,2),1,1,"R");
            $pdf->setX(10);
        }
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(170,$this->alto,"TOTAL A PAGAR $ ",1,0,"R",true);
        $pdf->Cell(25,$this->alto,number_format($Total,2),1,1,"R",true);
        $pdf->setX(10);

        $pdf->Ln();
        $pdf->Output('D','nota-remision-'.$this->empresa_id.'-'.$this->venta_id.'-'.$this->folio.'.pdf');
        exit;
    }


    public function header2($pdf){
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
        $pdf->Cell(145,$this->alto,utf8_decode($this->title),"",0,"C",true);
        $pdf->Cell(5,$this->alto,"","",0,"C",false);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(10,$this->alto,"ID: ","",0,"R");
        $pdf->SetFont('Arial','',8);
        $pdf->SetFillColor(240,240,240);
        $pdf->Cell(10,$this->alto,$this->venta_id,"",1,"R");
        $pdf->Ln(7);
        $pdf->setX(10);
        $this->alto  = 10;
        $pdf->SetFont('Arial','B',10);
        $pdf->SetFillColor(192,192,192);
        $pdf->Cell(40,$this->alto,"FECHA",1,0,"C",true);
        $pdf->Cell(60,$this->alto,utf8_decode("MÉTODO DE PAGO"),1,0,"L",true);
        $pdf->Cell(65,$this->alto,utf8_decode("REFERENCIA"),1,0,"L",true);
        $pdf->Cell(30,$this->alto,"IMPORTE",1,1,"R",true);
        $this->alto  = 6;
        $pdf->setX(10);
    }

    public function print_history_pay($venta_id)
    {
        $Ven               = Venta::find($venta_id);
        $IsCompra = str_contains($Ven->MetodoPago,'Compra');
        if ($IsCompra){
            $VD            = Movimiento::all()->where('venta_id',$venta_id);
        }else{
            $VD            = Ingreso::all()->where('venta_id',$venta_id);
        }

        $this->venta_id    = $venta_id;
        $this->timex       = Carbon::now()->format('d-m-Y h:i:s a');
        $this->folio       = Venta::getFolioImpreso($Ven->empresa_id, $venta_id);
        $this->cliente_id  = $Ven->user_id;
        $this->vendedor_id = $Ven->vendedor_id;
        $this->cliente     = $Ven->user->FullName;
        $this->vendedor    = $Ven->vendedor->FullName;
        $this->status      = "";
        $this->metodo_pago = strtoupper($Ven->MetodoPago);
        $this->referencia  = $Ven->referencia;
        $this->tipo_venta  = strtoupper($Ven->TipoVenta);
        $this->title       = "HISTORIAL DE PAGOS";
        $Emp               = Empresa::find($Ven->empresa_id);
        $this->empresa     = $Emp->rs;
        $this->empresa_id  = $Emp->id;

        $pdf               = new FPDF('P','mm','Letter');

        $pdf->AliasNbPages();
        $pdf->SetFillColor(192,192,192);
        $this->header2($pdf);
        $this->alto  = 10;
        $pdf->SetFont('Arial','',8);
        //dd($Ven);
        $Total = 0;
        foreach ($VD as $vd){
            $pdf->Cell(40,$this->alto,Carbon::parse($vd->fecha)->format('d-m-Y H:i:ss a'),1,0,"C");
            if ($IsCompra){
                $total = $vd->salida * $vd->cu;
                $Total += $total;
                $pdf->Cell(60,$this->alto,utf8_decode($vd->Status),1,0,"L");
                $pdf->Cell(65,$this->alto,"---",1,0,"L");
            }else{
                $total = $vd->total;
                $Total += $total;
                $pdf->Cell(60,$this->alto,utf8_decode($vd->MetodoPago),1,0,"L");
                $pdf->Cell(65,$this->alto,utf8_decode($vd->referencia),1,0,"L");
            }
            $pdf->Cell(30,$this->alto,number_format($total,2),1,1,"R");
            $pdf->setX(10);
        }
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(165,$this->alto,"TOTAL PAGADO $ ",1,0,"R",true);
        $pdf->Cell(30,$this->alto,number_format($Total,2),1,1,"R",true);
        $pdf->setX(10);

        $pdf->Ln();
        $pdf->Output('D','historial-pagos-'.$this->empresa_id.'-'.$this->venta_id.'-'.$this->folio.'.pdf');

        exit;

    }

}
