<?php

namespace App\Http\Requests;

use App\Classes\GeneralFunctions;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\SIIFAC\Movimiento;
use App\Models\SIIFAC\NotaCredito;
use App\Models\SIIFAC\NotaCreditoDetalle;
use App\Models\SIIFAC\Producto;
use App\Models\SIIFAC\Venta;
use App\Models\SIIFAC\VentaDetalle;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;

class NotaCreditoRequest extends FormRequest
{



    protected $redirectRoute = 'index_notacredito/' ;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
        ];
    }


    public function manage()
    {
        $msg = "OK";
        $IsValid = false;
        foreach ($this->vd_id as $key => $value){
            if ($value >= 1) $IsValid = true;
        }

        if (!$IsValid){
            return "No se encontraron datos para guardar";
        }

        $Item = [];
        try {
            $this->id = intval($this->id);
            $this->venta_id = intval($this->venta_id);
            // dd($this->id);
            if ( $this->id <= 0 || is_null($this->id) ){
                $Ven = Venta::find($this->venta_id);
                $Item = [
                    'user_id'          => $Ven->user_id,
                    'venta_id'         => $this->venta_id,
                    'empresa_id'       => $Ven->empresa_id,
                    'fecha'            => now(),
                    ];
                //dd($Item);
                $NC = NotaCredito::create($Item);
                $suma = 0;
                foreach ($this->vd_id as $key => $value){
                    if ($value > 0) {
                        $arrVal = explode('_',$key);
//                        dd($arrVal[0]);
                        $Prod = Producto::find($arrVal[2]);
                        $vd = VentaDetalle::find($arrVal[0]);
                        $Importe = $value * $vd->pv;

//                        $pIva = floatval($vd->iva) > 0 ? 0.160000 : 0;
                        $pIva   = GeneralFunctions::getImporteIVA($Prod->tieneIVA(),$Importe);

//                        $Subtotal = $Importe + $Iva;

                        $Subtotal = $Importe;

                        $Item = [
                            'user_id'          => $Ven->user_id,
                            'nota_credito_id'  => $NC->id,
                            'venta_id'         => $this->venta_id,
                            'venta_detalle_id' => $arrVal[0],
                            'empresa_id'       => $Ven->empresa_id,
                            'producto_id'      => $Prod->id,
                            'fecha'            => now(),
                            'codigo'           => $Prod->codigo,
                            'descripcion_producto' => $Prod->descripcion,
                            'pv'               => $vd->pv,
                            'cant'             => $value,
                            'importe'          => $Subtotal,
                            'empresa_id'       => $Ven->empresa_id
                        ];

                        $NCD = NotaCreditoDetalle::create($Item);
                        // dd($NCD);
                        $vd->cantidad_devuelta = $vd->cantidad_devuelta + $value;
                        $xd = $vd->save();

                        $resp = Movimiento::agregarDesdeNotaCreditoDetalle($NCD);
//                        dd($resp);

                        $suma += $Subtotal;
                    }
                }
                $NC->importe = $suma;
                $NC->save();
                NotaCredito::totalNotaCreditoFromDetalle($NC->id);
            }else{

            }

        }catch (QueryException $e){
            $msg =  $e->getMessage();
            return $msg;
//            dd($msg);

        }
        return $msg;

    }

    public function attaches($Item){
//        $Item->prioridades()->attach($this->prioridad_id);
//        $Item->origenes()->attach($this->origen_id);
//        $Item->dependencias()->attach($this->dependencia_id,['servicio_id'=>$this->servicio_id,'estatu_id'=>$this->estatus_id,'fecha_movimiento' => now() ]);
//        $Item->ubicaciones()->attach($this->ubicacion_id);
//        $Item->servicios()->attach($this->servicio_id);

        return $Item;
    }

    public function detaches($Item){
//        $Item->prioridades()->detach($this->prioridad_id);
//        $Item->origenes()->detach($this->origen_id);
//        $Item->dependencias()->detach($this->dependencia_id);
//        $Item->ubicaciones()->detach($this->ubicacion_id);
//        $Item->servicios()->detach($this->servicio_id);

//        $Item->estatus()->detach($this->estatus_id);
//        DenunciaEstatu::where('denuncia_id',$this->id)->orderByDesc('id')->update(['ultimo'=>true]);
//        $Item->ciudadanos()->detach($this->ciudadano_id);
//        $Item->creadospor()->detach($this->creadopor_id);
//        $Item->modificadospor()->detach($this->modificadopor_id);
        return $Item;
    }

    protected function getRedirectUrl()
    {
        $url = $this->redirector->getUrlGenerator();
        if ($this->id > 0){
            return $url->route($this->redirectRoute,['Id'=>$this->id]);
        }else{
            return $url->route('newDenuncia');
        }
    }




}
