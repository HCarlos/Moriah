<?php

namespace App\Http\Controllers\Externos;

// use App\Http\Controllers\PDF_EAN13;
use App\Http\Controllers\Classes\PDF_EAN13;
use App\Models\SIIFAC\Empresa;
use App\Models\SIIFAC\Movimiento;
use App\Models\SIIFAC\Producto;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use FPDF;

class TarjetaMovtosController extends Controller
{
    protected $alto          = 6;
    protected $aFT           = 205;
    protected $timex         = "";
    protected $producto_name = "";
    protected $empresa       = "";

    public function header($pdf){
        $pdf->AddPage();
        $pdf->setY(10);
        $pdf->setX(10);
        $pdf->SetTextColor(0,0,0);

        $pdf->SetFont('Arial','B',12);
        $pdf->Image('assets/img/logo-arji.gif',10,10,20,20);
        $pdf->Cell(25,$this->alto,"","",0,"L");
        $pdf->Cell(150,$this->alto,utf8_decode(""),"",0,"L");
        $pdf->SetFont('Arial','',7);
        $pdf->SetFillColor(212,212,212);
        $pdf->Cell(20,$this->alto,$this->timex,"",1,"R");
        $pdf->setX(10);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(25,$this->alto,"","",0,"L");
        $pdf->Cell(170,$this->alto,utf8_decode("Av. México Núm. 2, Col. Del Bosque, Villahermosa, Tabasco. CP 86160"),"",1,"L");
        $pdf->setX(10);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(25,$this->alto,"","",0,"L");
        $pdf->Cell(145,$this->alto,utf8_decode("M O V I M I E N T O S"),"",0,"L");
        $pdf->SetFont('Arial','',7);
        $pdf->SetFillColor(0,212,212);
        $pdf->Cell(28, $this->alto, utf8_decode("Página " . $pdf->PageNo() . " de {nb}"), "", 1,"R");
        $pdf->setX(10);
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(195,$this->alto,utf8_decode($this->producto_name),"",0,"C",true);
        $pdf->Ln(5);
        $pdf->Line(32,11,32,29);
        $pdf->Line(32.5,11,32.5,29);
        $pdf->Line(33,11,33,29);
        $pdf->Ln(5);
        $pdf->setX(10);
        $this->alto  = 10;
        $pdf->SetFont('Arial','B',8);
        $pdf->SetFillColor(192,192,192);
        $pdf->Cell(10,$this->alto,"ID",1,0,"C",true);
        $pdf->Cell(20,$this->alto,"FECHA",1,0,"L",true);
        $pdf->Cell(20,$this->alto,"ENTRADA",1,0,"R",true);
        $pdf->Cell(20,$this->alto,"SALIDA",1,0,"R",true);
        $pdf->Cell(20,$this->alto,"EXIST.",1,0,"R",true);
        $pdf->Cell(20,$this->alto,"PU",1,0,"R",true);
        $pdf->Cell(20,$this->alto,"DEBE",1,0,"R",true);
        $pdf->Cell(20,$this->alto,"HABER",1,0,"R",true);
        $pdf->Cell(20,$this->alto,"SALDO",1,0,"R",true);
        $pdf->Cell(25,$this->alto,"TIPO",1,1,"R",true);
        $this->alto  = 6;
        $pdf->setX(10);
    }

    public function imprimir_tarjeta_movtos($producto_id)
    {
        $Prod                = Producto::find($producto_id);
        $Movs                = Movimiento::all()->where('producto_id',$producto_id)->sortBy('id');
        $this->timex         = Carbon::now()->format('d-m-Y H:i:s');
        $Emp                 = Empresa::find($Prod->empresa_id);
        $this->empresa       = $Emp->rs;

        $pdf                 = new PDF_EAN13('P','mm','Letter');
        $this->producto_name = $Prod->descripcion;

        $pdf->AliasNbPages();
        $pdf->SetFillColor(192,192,192);
        $pdf->SetFont('Arial','',6);
        $pdf->addFont('AndaleMono');
        $pdf->addFont('arialn');        
        $pdf->addFont('AndaleMonoMTStdBold');
        $pdf->addFont('AndaleMono');
        $pdf->addFont('arialn');

        $this->header($pdf);
        $this->alto  = 8;
        $pdf->SetFont('Arial','',8);
        $i = 1;
        foreach ($Movs as $mv){
            $fecha      = new Carbon($mv->fecha);
            $entrada    = $mv->entrada==0?'':number_format($mv->entrada,0,'.',',');
            $salida     = $mv->salida==0?'':number_format($mv->salida,0,'.',',');
            $existencia = $mv->existencia==0?'':number_format($mv->existencia,0,'.',',');
            $pu         = $mv->pu==0?'':number_format($mv->pu,0,'.',',');
            $debe       = $mv->debe==0?'':number_format($mv->debe,0,'.',',');
            $haber      = $mv->haber==0?'':number_format($mv->haber,0,'.',',');
            $saldo      = $mv->saldo==0?'':number_format($mv->saldo,0,'.',',');
            $status     = $mv->Status;
            $pdf->Cell(10,$this->alto,$mv->id,1,0,"C");
            $pdf->Cell(20,$this->alto,$fecha->format('d-m-Y'),1,0,"L");
            $pdf->Cell(20,$this->alto,$entrada,1,0,"R");
            $pdf->Cell(20,$this->alto,$salida,1,0,"R");
            if ($i == $Movs->count() ) {
                $pdf->SetFont('Arial','B',10);
            }
            $pdf->Cell(20,$this->alto,$existencia,1,0,"R");
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(20,$this->alto,$pu,1,0,"R");
            $pdf->Cell(20,$this->alto,$debe,1,0,"R");
            $pdf->Cell(20,$this->alto,$haber,1,0,"R");
            if ($i == $Movs->count() ) {
                $pdf->SetFont('Arial','B',10);
            }
            $pdf->Cell(20,$this->alto,$saldo,1,0,"R");
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(25,$this->alto,$status,1,1,"R");
            $pdf->setX(10);
            if ($pdf->getY() >= 248 && $i < $Movs->count() ){
                $this->header($pdf);
                $this->alto  = 8;
                $pdf->SetFont('Arial','',8);
            }
            ++$i;
        }


        $pdf->SetFillColor(32,32,32);
        $pdf->SetFont('Arial','',6);
        $pdf->EAN13(10,$pdf->getY()+10,$Prod->codigo,16,.35,'',$pu );

        $pdf->Ln();



        $pdf->Output();
        exit;

    }
}
