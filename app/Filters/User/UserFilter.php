<?php


namespace App\Filters\User;


use App\Classes\GeneralFunctios;
use App\Filters\Common\QueryFilter;
use Illuminate\Support\Carbon;

class UserFilter extends QueryFilter {

    public function rules(): array{
        return [
            'IdP'              => '',
            'search'           => '',
            'ap_paterno'       => '',
            'ap_materno'       => '',
            'nombre'           => '',
            'curp'             => '',
            'fecha_inicial'    => '',
            'fecha_final'      => '',
            'role_id'          => '',
            'user_id_anterior' => '',
        ];
    }

    public function IdP($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "") {return $query;}
        return $query->where("id",$search);
    }


    public function search($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "") {return $query;}

        $F        = new GeneralFunctios();
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
//        return $query->whereRaw("ap_paterno >= ? AND ap_paterno <= CONCAT(?,'z')","{$search}");
        return $query->whereRaw("ap_paterno like ?", "%{$search}%");
    }

    public function ap_materno($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "") {return $query;}
        $search = strtoupper(trim($search));
        return $query->whereRaw("ap_materno like ?", "%{$search}%");
//        return $query->whereRaw("ap_materno >= ? AND ap_materno <= CONCAT(?,'Z')","{$search}");
    }

    public function nombre($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "") {return $query;}
        $search = strtoupper(trim($search));
        return $query->whereRaw("nombre like ?", "%{$search}%");
//        return $query->whereRaw("nombre >= ? AND nombre <= CONCAT(?,'Z')","{$search}");
    }

    public function curp($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "") {return $query;}
        $search = strtoupper(trim($search));
        return $query->whereRaw("curp like ?", "%{$search}%");
    }

    public function fecha_inicial($query, $search)
    {
        if (is_null($search) || empty ($search) || trim($search) == "") {return $query;}
        $search = Carbon::createFromFormat('Y-m-d', $search);
        return $query->whereDate('fecha_nacimiento', '>=', $search);
    }

    public function fecha_final($query, $search)
    {
        if (is_null($search) || empty ($search) || trim($search) == "") {return $query;}
        $search = Carbon::createFromFormat('Y-m-d', $search);
        return $query->whereDate('fecha_nacimiento', '<=', $search);
    }

    public function role_id($query, $role_id){
        if (is_null($role_id) ) {return $query;}
        if (empty ($role_id)) {return $query;}
        return $query->whereHas('roles', function ($q) use ($role_id) {
            $q->where('role_id', $role_id);
        });
    }

    public function user_id_anterior($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "") {return $query;}
        return $query->where("user_id_anterior",$search);
    }

}
