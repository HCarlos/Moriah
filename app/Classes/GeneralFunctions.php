<?php


namespace App\Classes;


use Illuminate\Support\Facades\Session;

class GeneralFunctions
{
    private static $instance;

    public static $metodos_pago =
        [
            0 => "Efectivo",
            3 => "Tarjeta de Crédito",
            2 => "TEF",
            1 => "Cheque Nominativo",
            4 => "Monedero Electrónico",
            6 => "Vales de Despensa",
            7 => "Tarjeta de Debito",
            8 => "Tarjeta de Servicio",
            100 => "-",
            5 => "Nota de Crédito",
            101 => "-",
            600 => "Descuento vía Nómina"
        ];

    public static $movtos_inventario =
        [
            200 => "Salida por Faltante",
            300 => "Salida por Merma",
            400 => "Devolución Sobre Compra"
        ];

    public static $metodos_pagos_complete =
        [
            0 => "Efectivo",
            3 => "Tarjeta de Crédito",
            2 => "TEF",
            1 => "Cheque Nominativo",
            4 => "Monedero Electrónico",
            6 => "Vales de Despensa",
            7 => "Tarjeta de Debito",
            8 => "Tarjeta de Servicio",
            100 => "-",
            5 => "Nota de Crédito",
            101 => "-",
            200 => "Salida por Faltante",
            300 => "Salida por Merma",
            400 => "Devolución Sobre Compra",
            102 => "-",
            600 => "Descuento vía Nómina",
            103 => "-",
            9 => "Otros"
        ];


    protected function __construct() {

    }

    public static function getInstance() {
        if (empty(GeneralFunctions::$instance)) {
            GeneralFunctions::$instance = new GeneralFunctions();
        }

        return GeneralFunctions::$instance;
    }

    public static function getTiposMovto($Status){
        $mp = "";
        switch ($Status){
            case 0:
                $mp = "INICIO";
                break;
            case 1:
                $mp = "COMPRA";
                break;
            case 2:
                $mp = "VENTA";
                break;
            case 11:
                $mp = "ENTRADA NC";
                break;
            case 12:
                $mp = "SALIDA NC";
                break;
            case 200:
                $mp = "FALTANTE";
                break;
            case 300:
                $mp = "MERMA";
                break;
            case 400:
                $mp = "DEV S/COMPRA";
                break;
            case 500:
                $mp = "SOBRANTE";
                break;
            case 600:
                $mp = "DEV P/PROV";
                break;
            default:
                $mp = "Indefinido";
                break;
        }
        return $mp;
    }

    public static function Get_Empresa_Id(){
        return intval(Session::get('Empresa_Id'));
    }

    public static function getImporteIVA($tieneIVA, $ImporteAplicar){
        switch ($tieneIVA){
            case 0:
                $IVA = 0;
            case 1:
                $IVA = $ImporteAplicar / 1.16;
        }
        return $ImporteAplicar - $IVA;
    }

}