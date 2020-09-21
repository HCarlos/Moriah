<?php

namespace App\Http\Requests;

use App\Http\Controllers\Externos\CorteCajaController;
use App\Http\Controllers\Externos\VentaRealizadaController;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\SIIFAC\Ingreso;
use App\Models\SIIFAC\Venta;
use Illuminate\Foundation\Http\FormRequest;

class PanelControlOneRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    protected $redirectTo = "show_panel_consulta_1";

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'fecha1' => ['required','date'],
            'fecha2' => ['required','date','after_or_equal:fecha1'],
//            'fecha2' => ['required', 'email', 'unique:users,email'],
//            'password' => 'required',
//            'role' => ['nullable', Rule::in(Role::getList())],
//            'bio' => 'required',
//            'twitter' => ['nullable', 'present', 'url'],
//            'profession_id' => [
//                'nullable', 'present',
//                Rule::exists('professions', 'id')->whereNull('deleted_at')
//            ],
//            'skills' => [
//                'array',
//                Rule::exists('skills', 'id'),
//            ],
        ];

    }

    public function messages()
    {
        return [
            'fecha1.required' => 'Se requiere esta fecha',
            'fecha2.required' => 'Se requiere esta fecha',
            'fecha2.after_or_equal' => 'Debe ser mayor ó igual',
        ];
    }

    public function createReportPDF01($pdf)
    {
        $F = (new FuncionesController);

        $f1          = $F->fechaDateTimeFormat($this->fecha1);
        $f2          = $F->fechaDateTimeFormat($this->fecha2,true);
        $vendedor_id = $this->vendedor_id;
        $metodo_pago = $this->metodo_pago;
        $tipo_venta  = $this->tipo_venta;
        $empresa_id  = $this->empresa_id;

        $Movs = Ingreso::query()
            ->where('fecha','>=', $f1)
            ->where('fecha','<=', $f2)
            ->where(function ($q) use($tipo_venta) {
                if ($tipo_venta > -1)
                    $q->where('tipoventa', $tipo_venta);
            })
            ->whereHas('vendedores', function ($q) use($vendedor_id) {
                if ($vendedor_id > 0)
                    $q->where('vendedor_id', $vendedor_id);
            })
            ->whereHas('ventas', function ($q) use($metodo_pago) {
                if ($metodo_pago >= 0 && $metodo_pago < 999 )
                    $q->where('metodo_pago', $metodo_pago);
            })
            ->orderBy('fecha')
            ->get();

        $m = $Movs->first();
        $f1 = $F->fechaEspanol($this->fecha1);
        $f2 = $F->fechaEspanol($this->fecha2);
        $vendedor = 'none';
        $empresa = 'none';
        if ( !is_null($m) ){
            $vendedor = trim($m->vendedor->FullName);
            $empresa = trim($m->empresa->rs);

        }
        $x = new CorteCajaController();
        $x->imprimir_Venta($f1,$f2,$vendedor,$pdf,$Movs,$empresa);

    }

    public function ventaRealizada($pdf)
    {
        $F = (new FuncionesController);

        $f1          = $F->fechaDateTimeFormat($this->fecha1);
        $f2          = $F->fechaDateTimeFormat($this->fecha2,true);

        // dd($f1.' => '.$f2);

        $vendedor_id = $this->vendedor_id;
        $metodo_pago = $this->metodo_pago;
        $tipo_venta  = $this->tipo_venta;
        $empresa_id  = $this->empresa_id;

        $Movs = Venta::query()
            ->where('fecha','>=', $f1)
            ->where('fecha','<=', $f2)
            ->where(function ($q) use($tipo_venta) {
                if ($tipo_venta > -1)
                    $q->where('tipoventa', $tipo_venta);
            })
            ->whereHas('vendedores', function ($q) use($vendedor_id) {
                if ($vendedor_id > 0)
                    $q->where('vendedor_id', $vendedor_id);
            })
            ->orderBy('fecha')
            ->get();
        

            // dd($Movs);

        $m = $Movs->first();
        $f1 = $F->fechaEspanol($this->fecha1);
        $f2 = $F->fechaEspanol($this->fecha2);
        $vendedor = 'none';
        $empresa = 'none';
        if ( !is_null($m) ){
            $vendedor = trim($m->vendedor->FullName);
            $empresa = trim($m->empresa->rs);
        }

        $x = new VentaRealizadaController();
        $x->imprimir_Venta($f1,$f2,$vendedor,$pdf,$Movs,$empresa);

    }



}
