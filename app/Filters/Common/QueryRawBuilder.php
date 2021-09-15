<?php


namespace App\Filters\Common;


use Illuminate\Support\Facades\DB;

class QueryRawBuilder extends DB {

    protected static $arrPersonas = ["imagen_persona","pariente_persona","registro_fiscal_persona","persona_rolesorigendatsopersona","persona_vehiculo"];
    protected static $arrRegistro = ["contrato_registro_fiscal","imagen_registro_fiscal","registro_fiscal_persona","registro_fiscal_ubicacion"];
    protected static $arrUbicacio = ["imagen_ubicacion","persona_ubicacion","registro_fiscal_ubicacion"];
    protected static $arrMunicipi = ["ciudad_municipio","estado_municipio","localidad_municipio","municipio_ubicacion"];

    protected static $objs         = [];
    protected static $ids          = [];

    /**
     * QueryRawBuilder constructor.
     */
    public function __construct(){
        self::$objs = [self::$arrPersonas, self::$arrRegistro, self::$arrUbicacio, self::$arrMunicipi];
        self::$ids  = ['persona_id', 'rfc_id', 'ubicacion_id', 'municipio_id'];
    }


    public static function  RemoveItemFromPivot($id,$param) {
        $IsDelete = false;
        $tables = self::$objs[$param];
        $raw = self::$ids[$param];

        foreach ($tables as $t => $value){
            $Per = self::table($value)
                ->select('id')
                ->whereRaw($raw." = ".$id)
                ->get();

            if ( count($Per) > 0 ) {
                $IsDelete = true;
                break;
            }
        }
        return $IsDelete;
    }

    public static function  UpdateItemFromPivot($id,$value_old,$value_new,$param) {
        $IsUpdate = false;
        $tables = self::$objs[$param];
        $raw = self::$ids[$param];

        foreach ($tables as $t => $value){
            $Per = self::table($value)
                ->whereRaw($raw." = ".$id)
                ->update([$value_old => $value_new]);;

            if ( count($Per) > 0 ) {
                $IsUpdate = true;
                break;
            }
        }
        return $IsUpdate;

    }


    public static function getNotarios(){
        return self::table('persona_role AS pr')
            ->leftJoin('personas AS p', 'pr.persona_id', '=', 'p.id')
            ->select('p.id',self::raw("CONCAT(p.ap_paterno, ' ', p.ap_materno, ' ', p.nombre) AS FullName"))
            ->whereRaw( 'pr.role_id = 2' )
            ->orderBy('fullname')
            ->get();
    }


}
