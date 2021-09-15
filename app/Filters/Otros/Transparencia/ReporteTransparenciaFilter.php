<?php


namespace App\Filters\Otros\Transparencia;


use App\Filters\Common\QueryFilter;

class ReporteTransparenciaFilter extends QueryFilter{

    public function rules(): array{
        return [
            'search' => '',
        ];
    }

    public function search($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "") {return $query;}
        $search = strtoupper($search);
        return $query->where(function ($query) use ($search) {
            return $query->whereRaw("UPPER(folio) like ?", "%{$search}%")
                ->orWhereRaw("UPPER(nombre_peticionario) like ?", "%{$search}%")
                ->orWhereRaw("UPPER(solicitud) like ?", "%{$search}%")
                ->orWhereRaw("UPPER(dependencia) like ?", "%{$search}%");
        });
    }

}
