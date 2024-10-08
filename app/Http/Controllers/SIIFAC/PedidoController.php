<?php

namespace App\Http\Controllers\SIIFAC;

use App\Classes\GeneralFunctions;
use App\Models\SIIFAC\Paquete;
use App\Models\SIIFAC\PedidoDetalle;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SIIFAC\Empresa;
use App\Models\SIIFAC\Movimiento;
use App\Models\SIIFAC\Pedido;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class PedidoController extends Controller
{
    protected $tableName = 'pedidos';
    protected $itemPorPagina = 50;
    protected $otrosDatos;
    protected $Predeterminado = false;
    protected $redirectTo = '/home';
    protected $Empresa_Id = 0;
    protected $UrlBase = 'https://moriah.mx/print_pedido/';

    public function __construct(){
        $this->middleware('auth');
        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

    }

    public function index(){

        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        $this->tableName = 'pedidos';
        $items = Pedido::query()
            ->where('empresa_id',$this->Empresa_Id)
            ->where('isactivo',true)
            ->orderByDesc('id')
            ->paginate(250);
        foreach($items as $item){
                $item->url_pedido = $this->UrlBase.$item->id;
        }
        $items->appends(request(['search']))->fragment('table');
        $items->links();

        $user = Auth::User();
        return view ('catalogos.listados.pedidos_list',
            [
                'items' => $items,
                'titulo_catalogo' => "Catálogo de ".ucwords($this->tableName),
                'user' => $user,
                'tableName'=>$this->tableName,
            ]
        );

    }

    public function new($idItem=0){

        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        $views    = 'pedido_new';
        $user     = Auth::User();
        $oView    = 'catalogos.';
        $Paquetes = Paquete::query()
                    ->where('empresa_id',$this->Empresa_Id)
                    ->orderBy('FullDescription')
                    ->pluck('FullDescription', 'id');

        $Usuarios = User::query()
                    ->orderBy('FullName' )
                    ->pluck('FullName', 'id');

        $timex    = Carbon::now()->format('ymdHisu');
        $timex    = substr($timex,0,16);

        return view ($oView.$views,
            [
                'idItem'     => $idItem,
                'titulo'     => 'pedidos',
                'user'       => $user,
                'Empresa_Id' => $this->Empresa_Id,
                'Paquetes'   => $Paquetes,
                'Usuarios'   => $Usuarios,
                'codigo'     => $timex,
            ]
        );

    }

    public function store(Request $request)
    {
        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        $data          = $request->all();
        $idItem        = $data['idItem'];

        $paquete_id    = $data['paquete_id'];
        $user_id       = $data['user_id'];
        $empresa_id    = $this->Empresa_Id;
        $referencia    = $data['referencia'];
        $observaciones = $data['observaciones'];

        Pedido::findOrCreatePedido($user_id,$paquete_id,$empresa_id,$referencia,$observaciones);

        return redirect('/new_pedido/'.$idItem);
    }


    public function actualizar_precio_pedidos(){
        $Peds = Pedido::select('id')->get();
        foreach ($Peds as $Pd){
            // $pds = PedidoDetalle::query()->where('pedido_id', $Pd->id)->get();
            Pedido::UpdateImporteFromPedidoDetalle($Pd->id);        
        }
        return Response::json(['mensaje' => 'Precios de pedidos actualizado con éxito.', 'data' => 'OK', 'status' => '200'], 200);
    }




    public function destroy($id=0){

        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

//        $mov = Movimiento::all()->where('pedido_id',$id)->first();
//        if ( !$mov ){
            $paq = Pedido::findOrFail($id);
            $paq->forceDelete();
            $pd = PedidoDetalle::where('pedido_id',$id);
            $pd->forceDelete();
            return Response::json(['mensaje' => 'Registro eliminado con éxito', 'data' => 'OK', 'status' => '200'], 200);
//        }else{
//            return Response::json(['mensaje' => 'No se puede eliminar el registro ['.$mov->id.']', 'data' => 'Error', 'status' => '200'], 200);
//        }

    }

}
