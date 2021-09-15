<?php


namespace App\Filters\Catalogo\Persona;


use App\Filters\Catalogo\Registro_Fiscal\RFCFilterRules;
use App\Http\Classes\uip3funcions;
use App\Models\Catalogos\Personas\Persona;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Boolean;

class PersonaDBQueryBuilderClass extends DB {

    protected $max_reg_con = 0;
    protected $min_reg_con = 0;
    protected $lim_max_reg = 0;
    protected $lim_min_reg = 0;

    protected $SelectP  = array('id' ,'ap_paterno', 'ap_materno', 'nombre', 'curp', 'fecha_nacimiento','genero');
    protected $SelectPU = array('pu.id as IdPU', 'p.id', 'u.id as IdU' ,'p.ap_paterno', 'p.ap_materno', 'p.nombre', 'p.curp', 'p.fecha_nacimiento','p.genero', 'u.calle', 'u.num_ext', 'u.num_int', 'u.localidad', 'u.municipio', 'u.estado', 'u.pais', 'u.cp');


    /**
     * PersonaDBQueryBuilderClass constructor.
     * @param int $max_reg_con
     * @param int $min_reg_con
     * @param int $lim_max_reg
     * @param int $lim_min_reg
     */
    public function __construct(){
        $this->lim_max_reg = config('uip3erc.limite_maximo_registros');
        $this->lim_min_reg = config('uip3erc.limite_minimo_registros');
        $this->max_reg_con = config('uip3erc.maximo_registros_consulta');
        $this->min_reg_con = config('uip3erc.minimo_registros_consulta');
    }

    public function DBQueryInicio($filters, $Paginate){

                $items = Persona::query()
                    ->filterBySearch($filters)
                    ->orderByDesc('id')
                    ->limit($this->lim_max_reg)
                    ->get();


        return $items;

    }

    public function DBQueryInicioExpedientePersona($filters, $Paginate){

        $items = Persona::query()
            ->where('is_expediente',1)
            ->filterBySearch($filters)
            ->orderByDesc('id')
            ->get();


        return $items;

    }

    public function DBQueryPersonas($filters, $Paginate){
        $rRFC = new PersonaFilterRules();
        $Where = $rRFC->wherePersonaOnly($filters);

        $where = " ";
        foreach ($Where as $f){
            if ($where ==" " && $f != ""){
                $where .=$f." ";
            }else{
                if ($f != "")
                    $where .= "AND ".$f." ";
            }
        }

        $items = Persona::select($this->SelectP)
            ->whereRaw( $where )
            ->orderByDesc('id')
            ->offset(0)
            ->limit($this->lim_max_reg)
            ->get();
        return $items;

    }

    public function DBQueryPersonaUbicacion($filters, $Paginate){
        $rRFC = new PersonaFilterRules();
        $Where = $rRFC->wherePersonaDB($filters);

        $where = " ";
        foreach ($Where as $f){
            if ($where ==" " && $f != ""){
                $where .=$f." ";
            }else{
                if ($f != "")
                    $where .= "AND ".$f." ";
            }
        }

        if($where == ""){
            $where = " pu.id > 0 ";
        }

        //dd($where);

        $items = self::table('persona_ubicacion AS pu')
            ->leftJoin('personas AS p', 'pu.persona_id', '=', 'p.id')
            ->leftJoin('ubicaciones AS u', 'pu.ubicacion_id', '=', 'u.id')
            ->select($this->SelectPU)
            ->whereRaw( $where )
            ->orderByDesc('p.id')
            ->offset(0)
            ->limit($this->lim_max_reg)
            ->get();

//      dd($items);

        return $items;

    }

    public function DBQuerySearch($search, $Paginate){
        $filters  = $search;
        $F        = new uip3funcions();
        $tsString = $F->string_to_tsQuery( strtoupper($filters),' & ');

        $items = self::table('persona_ubicacion AS pu')
            ->leftJoin('personas AS p', 'pu.persona_id', '=', 'p.id')
            ->leftJoin('ubicaciones AS u', 'pu.ubicacion_id', '=', 'u.id')
            ->whereRaw( "p.searchtext @@ to_tsquery('spanish', ?)", [$tsString] )
            ->select($this->SelectPU)
            ->orderByRaw("ts_rank(p.searchtext, to_tsquery('spanish', ?)) ASC", [$tsString])
            ->orderByDesc('p.id')
            ->offset(0)
            ->limit($this->lim_max_reg)
            ->get();
        return $items;

    }


}
