<?php

namespace App\Http\Controllers\Externos;

use App\Classes\GeneralFunctions;
use App\Http\Controllers\Classes\PDF_Diag;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\SIIFAC\Empresa;
use App\Models\SIIFAC\Ingreso;
use App\Models\SIIFAC\Venta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\PanelControlOneRequest;

class CorteCajaController extends Controller{

    protected $alto     = 6;
    protected $aFT      = 205;
    protected $timex    = "";
    protected $f1       = "";
    protected $f2       = "";
    protected $vendedor = "";
    protected $empresa  = "";
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
        $pdf->Cell(32,$this->alto,"CORTE DE CAJA | ","",0,"L");
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(110,$this->alto,$this->vendedor,"",0,"L");
        $pdf->SetFont('Arial','',7);
        $pdf->SetFillColor(0,212,212);
        $pdf->Cell(33, $this->alto, utf8_decode("Página " . $pdf->PageNo() . " de {nb}"), "", 1,"R");
        $pdf->setX(10);
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(10, $this->alto, 'ID', "LTB", 0,"R");
        $pdf->Cell(10, $this->alto, 'VENTA', "LTB", 0,"R");
        $pdf->Cell(15, $this->alto, 'TIPO', "LTB", 0,"L");
        $pdf->Cell(58, $this->alto, 'CLIENTE', "LTB", 0,"L");
        $pdf->Cell(19, $this->alto, 'VENDEDOR', "LTB", 0,"L");
        $pdf->Cell(15, $this->alto, 'FECHA', "LTB", 0,"R");
        $pdf->Cell(22, $this->alto, utf8_decode('MÉTODO PAGO'), "LTB", 0,"L");
        $pdf->Cell(30, $this->alto, 'REFERENCIA', "LTB", 0,"L");
        $pdf->Cell(17, $this->alto, 'IMPORTE', "LTRB", 1,"R");
        $pdf->setX(10);
    }

    public function imprimir_Venta($f1,$f2,$vendedor,$pdf,$Movs,$empresa)
    {
        $this->f1 = $f1;
        $this->f2 = $f2;
        $this->vendedor = $vendedor;
        $this->empresa = $empresa;
        $this->timex = Carbon::now()->format('d-m-Y h:m:s a');

        $pdf->AliasNbPages();
        $this->header($pdf);
        $pdf->SetFillColor(32,32,32);
        $pdf->SetFont('Arial','',6);
        $totalPagado = $totalContado = $totalCredito = 0;
        foreach ($Movs as $Mov){
            //dd($Mov);
            $totalPagado += $Mov->total;
            $pdf->setX(10);
            $pdf->SetFont('arialn','',8);
            $pdf->Cell(10, $this->alto, $Mov->id, "LTB", 0,"R");
            $pdf->Cell(10, $this->alto, $Mov->venta_id, "LTB", 0,"R");
            $pdf->Cell(15, $this->alto, utf8_decode(trim($Mov->tipoventa)), "LTB", 0,"L");
            $pdf->Cell(58, $this->alto, utf8_decode(trim($Mov->cliente->FullName)), "LTB", 0,"L");
            $pdf->Cell(19, $this->alto, utf8_decode(trim($Mov->vendedor->username)), "LTB", 0,"L");
            $pdf->Cell(15, $this->alto, $this->F->fechaEspanol($Mov->fecha), "LTB", 0,"R");
            $pdf->Cell(22, $this->alto, substr(utf8_decode($Mov->metodo_pago),0,20), "LTB", 0,"L");
            $pdf->Cell(30, $this->alto, utf8_decode(trim($Mov->referencia)), "LTB", 0,"L");
            $totalContado += $Mov->total;
            $pdf->SetFont('AndaleMono','',7);
            $pdf->Cell(17, $this->alto, number_format($Mov->total,2), "LTRB", 1,"R");
        }
        $pdf->setX(10);
        if ($Movs->count() > 0){
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(179, $this->alto, 'TOTAL $ ', "LB", 0,"R");
            $pdf->SetFont('AndaleMonoMTStdBold','',7);
            $pdf->Cell(17, $this->alto, number_format($totalPagado,2), "LRB", 1,"R");
        }else{
            $pdf->SetFont('Arial','BI',10);
            $pdf->Cell(196, 20, 'NO SE ENCONTRARON DATOS', "LBR", 1,"C");
        }
        $pdf->Output();
    }

    protected function show_panel_consulta_1(){
        $Cajeros = Venta::select(['vendedor_id'])
            ->distinct()
            ->get();
        $Cajeros->each(function ($v) { $v->FullName = trim($v->vendedor->username).' - '.trim($v->vendedor->FullName); });
        $Cajeros = $Cajeros->sortBy('FullName')->pluck('FullName','vendedor_id');
//        $metodo_pagos = Venta::$metodos_pago;
        $metodo_pagos =  GeneralFunctions::$metodos_pagos_complete;

        $empresas     = Empresa::all()->sortBy('id')->pluck('ncomer','id');

        return view('catalogos.reportes.panel_reporte_1',[
            "tableName"    => "",
            "cajeros"      => $Cajeros,
            'metodo_pagos' => $metodo_pagos,
            "empresas"     => $empresas,
            'msg'          => '',
        ]);

    }

    protected function create_corte_caja_1(PanelControlOneRequest $request){
        $pdf  = new PDF_Diag('P','mm','Letter');
        $pdf->addFont('AndaleMono');
        $pdf->addFont('arialn');        
        $pdf->addFont('AndaleMonoMTStdBold');

        $data = $request->all();
        $tipo_reporte = $data['tipo_reporte'];
        if ($tipo_reporte==0){
            $request->createReportPDF01($pdf);
        }else{
            $request->ventaRealizada($pdf);
        }
        return redirect()->route('show_panel_consulta_1');
    }


}
