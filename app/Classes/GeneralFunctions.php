<?php


namespace App\Classes;


class GeneralFunctions
{
    private static $instance;

    public static $metodos_pago =
        [
            0 => "Efectivo",
            1 => "Tarjeta de Crédito",
            2 => "Tarjeta de Debito",
            3 => "Cheque Nominativo",
            4 => "Transferencia Electrónica de Fondos",
            100 => "-",
            5 => "Nota de Crédito",
            500 => "-",
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
            1 => "Tarjeta de Crédito",
            2 => "Tarjeta de Debito",
            3 => "Cheque Nominativo",
            4 => "Transferencia Electrónica de Fondos",
            100 => "-",
            5 => "Nota de Crédito",
            100 => "-",
            200 => "Salida por Faltante",
            300 => "Salida por Merma",
            400 => "Devolución Sobre Compra",
            500 => "-",
            600 => "Descuento vía Nómina"
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


}