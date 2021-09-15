<?php

namespace App\View\Components\Inputs;

use Illuminate\View\Component;

class SelectForm extends Component{


    public $nombre;
    public $nombrees;
    public $cols;
    public $class;
    public $valor;
    public $arr;
    /**
     * Create a new component instance.
     *
     * @return valor
     */
    public function __construct(string $nombre = null, string $nombrees = null, string $cols = null, string $class = null, array $arr = null, $valor = null){
        //dd($this->arr);

        $this->nombre     = $nombre ?? 'TextField_'.time();
        $this->nombrees   = $nombrees ?? $this->nombre;
        $this->cols       = $cols ?? 2;
        $this->class      = $class ?? '';
        $this->arr        = $arr ?? [];
        $this->valor      = $valor ?? '';

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        //dd($this->arr);
        return view('components.inputs.select-form');
    }
}
