<?php

namespace App\Http\Controllers\SIIFAC;

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

    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {

        $this->tableName = 'pedidos';
        $items = Pedido::select('id','codigo','descripcion_pedido','importe','empresa_id','filename')
            ->orderBy('id','desc')
            ->paginate();

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

    public function new($idItem=0)
    {
        $views    = 'pedido_new';
        $user     = Auth::User();
        $oView    = 'catalogos.';
        $Empresas = Empresa::all()->sortBy('rs')->pluck('rs', 'id');
        $Paquetes = Paquete::all()->sortBy('FullDescription')->pluck('FullDescription', 'id');
        $Usuarios = User::all()->sortBy('FullName' )->pluck('FullName', 'id');

        $timex    = Carbon::now()->format('ymdHisu');
        $timex    = substr($timex,0,16);

        return view ($oView.$views,
            [
                'idItem'   => $idItem,
                'titulo'   => 'pedidos',
                'user'     => $user,
                'Empresas' => $Empresas,
                'Paquetes' => $Paquetes,
                'Usuarios' => $Usuarios,
                'codigo'   => $timex,
            ]
        );

    }

    public function store(Request $request)
    {

        $data = $request->all();
        $idItem     = $data['idItem'];

        $paquete_id = $data['paquete_id'];
        $user_id    = $data['user_id'];
        $empresa_id    = $data['empresa_id'];

        Pedido::findOrCreatePedido($user_id,$paquete_id,$empresa_id);

        return redirect('/new_pedido/'.$idItem);
    }

    public function destroy($id=0){
        $mov = Movimiento::all()->where('pedido_id',$id)->first();

        if ( !$mov ){
            $paq = Pedido::findOrFail($id);
            $paq->forceDelete();
            $pd = PedidoDetalle::where('pedido_id',$id);
            $pd->forceDelete();
            return Response::json(['mensaje' => 'Registro eliminado con éxito', 'data' => 'OK', 'status' => '200'], 200);
        }else{
            return Response::json(['mensaje' => 'No se puede eliminar el registro ['.$mov->id.']', 'data' => 'Error', 'status' => '200'], 200);
        }

    }

}
