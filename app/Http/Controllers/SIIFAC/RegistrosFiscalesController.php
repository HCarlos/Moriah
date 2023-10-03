<?php

namespace App\Http\Controllers\SIIFAC;

use App\Classes\GeneralFunctions;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\SIIFAC\Almacen;
use App\Models\SIIFAC\Compra;
use App\Models\SIIFAC\Empresa;
use App\Models\SIIFAC\Movimiento;
use App\Models\SIIFAC\Proveedor;
use App\Models\SIIFAC\RegimenesFiscales;
use App\Models\SIIFAC\Rfc;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use LogicException;

class RegistrosFiscalesController extends Controller{

    protected $tableName = 'registros_fiscales';
    protected $redirectTo = '/home';
    protected $F;
    protected $Empresa_Id = 0;
    public function __construct(){
        $this->middleware('auth');
        $this->F = (new FuncionesController);
        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            redirect('openEmpresa');
        }
    }

    public function index()
    {
        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        $user = Auth::User();
        $items = Rfc::all()
            ->sortByDesc('id');
//        ->where('empresa_id',$this->Empresa_Id)

        return view ('catalogos.operaciones.registros_fiscales.rfcs',
            [
                'tableName' => 'registrosFiscalesTable',
                'rfcs' => $items,
                'user' => $user,
            ]
        );
    }

    public function nuevo_rfc_ajax(){

        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        $views       = 'rfc_nuevo_ajax';
        $user        = Auth::User();
        $regimenfis  = RegimenesFiscales::query()->get()->sortBy('clave_regimen_fiscal');
        $oView       = 'catalogos.operaciones.registros_fiscales.';
        return view ($oView.$views,
            [
                'user'               => $user,
                'regimenes_fiscales' => $regimenfis,
                'empresa_id'         => $this->Empresa_Id,
                'Url'                => '/store_rfc_nuevo_ajax',
            ]
        );
    }

    public function store_rfc_nuevo_ajax(Request $request){

        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        $data = $request->all();

//        dd($data);

        $data["rfc"]                  = $data["rfc"]                  ===  null ? '' : trim(strtoupper($data["rfc"]));
        $data["razon_social"]         = $data["razon_social"]         ===  null ? '' : trim(strtoupper($data["razon_social"]));
        $data["razon_social_cfdi_40"] = $data["razon_social_cfdi_40"] ===  null ? '' : trim(strtoupper($data["razon_social_cfdi_40"]));
        $data["calle"]                = $data["calle"]                ===  null ? '' : trim(strtoupper($data["calle"]));
        $data["num_ext"]              = $data["num_ext"]              ===  null ? '' : trim(strtoupper($data["num_ext"]));
        $data["num_int"]              = $data["num_int"]              ===  null ? '' : trim(strtoupper($data["num_int"]));
        $data["colonia"]              = $data["colonia"]              ===  null ? '' : trim(strtoupper($data["colonia"]));
        $data["localidad"]            = $data["localidad"]            ===  null ? '' : trim(strtoupper($data["localidad"]));
        $data["municipio"]            = $data["municipio"]            ===  null ? '' : trim(strtoupper($data["municipio"]));
        $data["estado"]               = $data["estado"]               ===  null ? '' : trim(strtoupper($data["estado"]));
        $data["pais"]                 = $data["pais"]                 ===  null ? '' : trim(strtoupper($data["pais"]));
        $data["cp"]                   = $data["cp"]                   ===  null ? '' : trim(strtoupper($data["cp"]));
        $data["emails"]               = $data["emails"]               ===  null ? '' : trim($data["emails"]);
        $data["regimen_fiscal_id"]    = $data["regimen_fiscal_id"] ?? 1;
        $data['observaciones']        = "";
        $data['idemp']      = $this->Empresa_Id;
        $data['empresa_id'] = $this->Empresa_Id;

//        dd($data);

        try {
            $mensaje = "OK";
            Rfc::create($data);
        }
        catch(QueryException $e){
            $mensaje = "Error: ".$e->getMessage();
        }
        return Response::json(['mensaje' => $mensaje, 'data' => 'OK', 'status' => '200'], 200);
    }

    public function editar_rfc_ajax($id){
        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        $views       = 'rfc_editar_ajax';
        $user        = Auth::User();
        $regimenfis  = RegimenesFiscales::query()->get()->sortBy('clave_regimen_fiscal');
        $oView       = 'catalogos.operaciones.registros_fiscales.';
        $rfc      = Rfc::find($id);
        return view ($oView.$views,
            [
                'rfc'                => $rfc,
                'user'               => $user,
                'regimenes_fiscales' => $regimenfis,
                'empresa_id'         => $this->Empresa_Id,
                'Url'                => '/store_rfc_editado_ajax',
            ]
        );
    }

    public function store_rfc_editado_ajax(Request $request)
    {
        $data = $request->all();

        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        try {

            $mensaje                  = "OK";
            $rfc                     = Rfc::findOrFail($data['id']);

            $rfc->rfc                  = $data["rfc"]                  ===  null ? '' : trim(strtoupper($data["rfc"]));
            $rfc->razon_social         = $data["razon_social"]         ===  null ? '' : trim(strtoupper($data["razon_social"]));
            $rfc->razon_social_cfdi_40 = $data["razon_social_cfdi_40"] ===  null ? '' : trim(strtoupper($data["razon_social_cfdi_40"]));
            $rfc->calle                = $data["calle"]                ===  null ? '' : trim(strtoupper($data["calle"]));
            $rfc->num_ext              = $data["num_ext"]              ===  null ? '' : trim(strtoupper($data["num_ext"]));
            $rfc->num_int              = $data["num_int"]              ===  null ? '' : trim(strtoupper($data["num_int"]));
            $rfc->colonia              = $data["colonia"]              ===  null ? '' : trim(strtoupper($data["colonia"]));
            $rfc->localidad            = $data["localidad"]            ===  null ? '' : trim(strtoupper($data["localidad"]));
            $rfc->municipio            = $data["municipio"]            ===  null ? '' : trim(strtoupper($data["municipio"]));
            $rfc->estado               = $data["estado"]               ===  null ? '' : trim(strtoupper($data["estado"]));
            $rfc->pais                 = $data["pais"]                 ===  null ? '' : trim(strtoupper($data["pais"]));
            $rfc->cp                   = $data["cp"]                   ===  null ? '' : trim(strtoupper($data["cp"]));
            $rfc->emails               = $data["emails"]               ===  null ? '' : trim($data["emails"]);
            $rfc->regimen_fiscal_id    = $data["regimen_fiscal_id"] ?? 1;

            $rfc->save();

        }
        catch(LogicException $e){
            $mensaje = "Error: ".$e->getMessage();
        }
        return Response::json(['mensaje' => $mensaje, 'data' => 'OK', 'status' => '200'], 200);
    }

    public function destroy($id){

        $rfc = Rfc::findOrFail($id);

//        dd($rfc);

//        $Mov  = Movimiento::where('compra_id', $id);
//        $rfc->forceDelete();
        $rfc->forceDelete();

        return Response::json(['mensaje' => 'Registro eliminado con éxito', 'data' => 'OK', 'status' => '200'], 200);

    }


}
