<?php

namespace App\Http\Controllers\Externos;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PDF_EAN13;
use App\Models\SIIFAC\Producto;

class BarCodeController extends Controller
{
    protected $alto          = 6;
    protected $aFT           = 205;
    protected $timex         = "";
    protected $producto_name = "";
    protected $codigo        = "";
    protected $pv            = "";

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
        $pdf->Cell(170,$this->alto,utf8_decode("Av. México Núm. 2, Col. Del Bosque, Villahermosa, Tabasco. CP 86160"),"",1,"L");
        $pdf->setX(10);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(25,$this->alto,"","",0,"L");
        $pdf->Cell(145,$this->alto,utf8_decode("CÓDIGOS DE BARRA"),"",0,"L");
        $pdf->SetFont('Arial','',7);
        $pdf->SetFillColor(0,212,212);
        $pdf->Cell(28, $this->alto, utf8_decode("Página " . $pdf->PageNo() . " de {nb}"), "", 1,"R");
        $pdf->setX(10);
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(195,$this->alto,utf8_decode($this->producto_name),"",0,"C",true);
        $this->alto  = 6;
        $pdf->Ln(5);
        $pdf->setX(10);
    }

    public function imprimir_todos_codigos_barras()
    {
    }
    public function imprimir_codigo_barra($producto_id)
    {
        $Prod                = Producto::find($producto_id);

        $pdf                 = new PDF_EAN13('P','mm','Letter');
        $this->producto_name = $Prod->shortdesc;
        $this->codigo        = $Prod->codigo;
        $this->pv            = $Prod->pv;


        $pdf->AliasNbPages();
        $pdf->SetFillColor(192,192,192);
        $this->header($pdf);
        $this->alto  = 8;
        $pdf->SetFillColor(32,32,32);
        $pdf->SetFont('Arial','',6);
        $c= 0;
        $x = 17.5;
        $y = $pdf->getY()+10;
        for ($i = 1; $i <= $Prod->exist; $i++){
            $pdf->SetFillColor(212,212,212);
            $pdf->Rect($x-7.5,$y-5,49,35,'');
            $pdf->SetFillColor(32,32,32);
            $pdf->EAN13($x,$y,$Prod->codigo,16,.35,$this->producto_name,$this->pv);
            if ($c>2){
                $x = 17.5;
                $pdf->setX($x);
                $pdf->setY( $y+35 );
                $y = $pdf->getY();
                $c=0;
            }else{
                $pdf->setX($x+49);
                $x = $pdf->getX();
                $c++;
            }

            //$pdf->Ln(30);
        }

        $pdf->Ln();

        $pdf->Output();
        exit;

    }


}
