<?php


namespace App\Filters\Common;


use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

abstract class QueryFilter{

    protected $valid = [];

    abstract public function rules(): array;

    public function applyTo($query, array $filters){
        $rules = $this->rules();
        $validator = Validator::make(array_intersect_key($filters, $rules), $rules);
        $this->valid = $validator->valid();
        foreach ($this->valid as $name => $value) {
            $this->applyFilter($query, $name, $value);
        }
        return $query;
    }

    protected function applyFilter($query, $name, $value){
        if (method_exists($this, $name)) {
            $this->$name($query, $value);
        } else {
            $query->where($name, $value);
        }
    }

    public function valid()
    {
        return $this->valid;
    }

}
