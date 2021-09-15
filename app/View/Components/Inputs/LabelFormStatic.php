<?php

namespace App\View\Components\Inputs;

use Illuminate\View\Component;

class LabelFormStatic extends Component{

    public $cols;
    public $class0;
    public $class1;
    public $label;
    public $deshabilitado;
    public $sololectura;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $cols = null, string $class0 = null, string $class1 = null, string $label = null, bool $deshabilitado = null, bool $sololectura = null){

        $this->cols = $cols ?? 2;
        $this->class0 = $class0 ?? '';
        $this->class1 = $class1 ?? '';
        $this->label = $label ?? '';
        $this->deshabilitado = $deshabilitado ?? '';
        $this->sololectura = $sololectura ?? '';

        // dd($this->label);

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
        return view('components.inputs.label-form-static');
    }
}
