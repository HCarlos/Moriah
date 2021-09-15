<?php

namespace App\View\Components\Inputs;

use Illuminate\View\Component;

class TextField extends Component{

    public $tipo;
    public $nombre;
    public $nombrees;
    public $cols;
    public $cols1;
    public $class;
    public $class1;
    public $valor;
    public $deshabilitado;
    public $sololectura;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $tipo = null, string $nombre = null, string $nombrees = null, string $cols = null, string $cols1 = null, string $class = null, string $class1 = null, string $valor = null, bool $deshabilitado = null, bool $sololectura = null){



        $this->tipo          = $tipo ?? 'text';
        $this->nombre        = $nombre ?? 'TextField_'.time();
        $this->nombrees      = $nombrees ?? $this->nombre;
        $this->cols          = $cols ?? 2;
        $this->cols1         = $cols1 ?? null;
        $this->class         = $class ?? '';
        $this->class1        = $class1 ?? '';
        $this->valor         = $valor ?? '';
        $this->deshabilitado = $deshabilitado ?? '';
        $this->sololectura   = $sololectura ?? '';


    }

    public function deshabilitado(){
        return $this->deshabilitado ? ' disabled ' : '';
    }

    public function sololectura(){
        return $this->sololectura ? ' readonly ' : '';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.inputs.text-field');
    }
}
