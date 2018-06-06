<?php

namespace App\Http\Controllers\Externos;



use App\Models\SIIFAC\Venta;
use App\Models\SIIFAC\VentaDetalle;
use App\Http\Controllers\Controller;
use FPDF;

class TicketController extends Controller
{
    protected $alto = 6;
    protected $aFT  = 205;


    public function print_tiket($venta_id)
    {
        $Ven = Venta::find($venta_id);
        $VD  = VentaDetalle::all()->where('venta_id',$venta_id);

//        Fpdf::AddPage();
//        Fpdf::SetFont('Courier', 'B', 18);
//        Fpdf::Cell(50, 25, 'Hello World!');
//        Fpdf::Output();

        $pdf = new FPDF('P','mm','Letter');
        $pdf->AliasNbPages();
        $pdf->SetFillColor(192,192,192);
        $pdf->AddPage();
        $pdf->setY(5);
        $pdf->setX(5);
        $pdf->SetTextColor(0,0,0);

        $pdf->SetFont('Arial','B',12);
        $pdf->Image('assets/img/welcome.jpg',5,5,25,25);
        $pdf->Cell(25,$this->alto,"","",0);
        $pdf->Cell(180,$this->alto,utf8_decode("Colegio Arjí A.C."),"",1,"C");
        $pdf->Ln(25);
        $pdf->setX(5);

//        $pdf->SetFont('Arial','B',12);
//        $pdf->cell(25,8,"ID",1,"","C");
//        $pdf->cell(45,8,"Name",1,"","L");
//        $pdf->cell(35,8,"Address",1,"","L");
        $pdf->Ln();
        $pdf->Output();
        exit;


//        return view ($oView.$views,
//            [
//                'user' => $user,
//                'venta_id'    => $venta_id,
//                'Url'         => '/store_venta_detalle_normal_ajax',
//            ]
//        );

    }

}
