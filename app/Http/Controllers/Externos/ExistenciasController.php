<?php

namespace App\Http\Controllers\Externos;

use App\Classes\GeneralFunctions;
use App\Http\Controllers\Controller;

use App\Models\SIIFAC\Empresa;
use App\Models\SIIFAC\Producto;
use Carbon\Carbon;
use FPDF;

class ExistenciasController extends Controller
{
    protected $alto        = 6;
    protected $aFT         = 205;
    protected $timex       = "";
    protected $empresa     = "";

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
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(25,$this->alto,"","",0,"L");
        $pdf->Cell(145,$this->alto,utf8_decode("EXISTENCIAS DE ARTICULOS"),"",0,"C",true);
        $pdf->SetFont('Arial','',7);
        $pdf->SetFillColor(0,212,212);
        $pdf->Cell(28, $this->alto, utf8_decode("Página " . $pdf->PageNo() . " de {nb}"), "", 1,"R");
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
        $pdf->Cell(125,$this->alto,utf8_decode("DESCRIPCIÓN"),1,0,"L",true);
        $pdf->Cell(20,$this->alto,"EXISTENCIA",1,0,"R",true);
        $pdf->Cell(20,$this->alto,"FALTANTE",1,0,"R",true);
        $pdf->Cell(20,$this->alto,"SOBRANTE",1,1,"R",true);
        $this->alto  = 6;
        $pdf->setX(10);
    }

    public function imprimir_existencias(){

        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        $Prod              = Producto::all()
                                ->where('empresa_id',$this->Empresa_Id)
                                ->where('status_producto','>',0)->sortBy('descripcion');
        // dd($Prod);
        $this->timex       = Carbon::now()->format('d-m-Y H:i:s');
        $P                 = $Prod->first();
        $Emp               = Empresa::find($this->Empresa_Id);
        $this->empresa     = $Emp->rs;

        $pdf               = new FPDF('P','mm','Letter');

        $pdf->AliasNbPages();
        $pdf->SetFillColor(192,192,192);
        $this->header($pdf);
        $this->alto  = 8;
        $pdf->SetFont('Arial','',8);
        $i = 1;
        foreach ($Prod as $prd){
            $pdf->Cell(10,$this->alto,number_format($prd->id,0),1,0,"C");
            $pdf->Cell(125,$this->alto,utf8_decode($prd->descripcion),1,0,"L");
            $pdf->Cell(20,$this->alto,number_format($prd->exist,2,'.',','),1,0,"C");
            $pdf->Cell(20,$this->alto,'',1,0,"C");
            $pdf->Cell(20,$this->alto,'',1,1,"C");
            $pdf->setX(10);
            if ($pdf->getY() >= 248 && $i < $Prod->count() ){
                $this->header($pdf);
                $this->alto  = 8;
                $pdf->SetFont('Arial','',8);
            }
            ++$i;
        }

        $pdf->Ln();
        $pdf->Output();
        exit;

    }
}
