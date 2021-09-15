<?php

namespace App\View\Components\Modals;

use Illuminate\View\Component;

class Blurred extends Component{
    public $TituloModal;
    public $CuerpoModal;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $TituloModal = null, string $CuerpoModal = null)
    {
        $this->TituloModal = $TituloModal ?? '';
        $this->CuerpoModal = $CuerpoModal ?? '';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modals.blurred');
    }
}
