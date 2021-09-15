<?php


namespace App\Filters\Catalogo\Persona;


use App\Filters\Common\QueryFilter;
use App\Http\Classes\uip3funcions;

class PersonaFilter  extends QueryFilter {



    public function rules(): array{
        return [
            'Id'          => '',
            'search'      => '',
            'ap_paterno'  => '',
            'ap_materno'  => '',
            'nombre'      => '',
            'curp'         => '',
            'roles'       => '',
        ];
    }

    public function Id($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "") {return $query;}
        return $query->where("id",">","0");
    }


    public function search($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "") {return $query;}

        $F        = new uip3funcions();
        $tsString = $F->string_to_tsQuery( $search,' & ');

        return $query->whereRaw("searchtext @@ to_tsquery('spanish', ?)", [$tsString])
            ->orderByRaw("ts_rank(searchtext, to_tsquery('spanish', ?)) ASC", [$tsString]);


//        $search = strtoupper($search);
//        return $query->where(function ($query) use ($search) {
//            $query->whereRaw("CONCAT(ap_paterno,' ',ap_materno,' ',nombre) like ?", "%{$search}%")
//                ->orWhereRaw("UPPER(curp) like ?", "%{$search}%")
//                ->orWhere('id', 'like', "%{$search}%");
//        });


    }

    public function ap_paterno($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "") {return $query;}
        $search = strtoupper(trim($search));
        return $query->whereRaw("ap_paterno >= ? AND ap_paterno <= CONCAT(?,'Z')","{$search}");
    }

    public function ap_materno($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "") {return $query;}
        $search = strtoupper(trim($search));
//        return $query->whereRaw("ap_materno like ?", "%{$search}%");
        return $query->whereRaw("ap_materno >= ? AND ap_materno <= CONCAT(?,'Z')","{$search}");
    }

    public function nombre($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "") {return $query;}
        $search = strtoupper(trim($search));
//        return $query->whereRaw("nombre like ?", "%{$search}%");
        return $query->whereRaw("nombre >= ? AND nombre <= CONCAT(?,'Z')","{$search}");
    }

    public function curp($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "") {return $query;}
        $search = strtoupper(trim($search));
        return $query->whereRaw("curp like ?", "%{$search}%");
    }

}
