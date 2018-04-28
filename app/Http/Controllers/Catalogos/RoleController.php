<?php

namespace App\Http\Controllers\Catalogos;

use Exception;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    use Authorizable;

    protected $redirectTo = '/home';
    public function __construct(){
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $cat_id     = $data['cat_id'];
        $idItem     = $data['idItem'];
        $action     = $data['action'];

        $validator = Validator::make($data, [
            'name' => 'required|string|max:25|unique:roles',
        ]);

        if ($validator->fails()) {
            return redirect('catalogos/'.$cat_id.'/'.$idItem.'/'.$action)
                ->withErrors($validator)
                ->withInput();
        }
        $role = Role::create(['name' => $data['name'],]);
        try {
            $perm = Permission::findByName('editar_registro')->first();
            $role->givePermissionTo($perm);
        } catch (Exception $e) {
            report($e);
            return false;
        }
        return redirect('index/'.$cat_id);
    }

    public function update(Request $request, Role $rol)
    {
        $data = $request->all();
        $cat_id     = $data['cat_id'];
        $idItem     = $data['idItem'];
        $action     = $data['action'];

        $validator = Validator::make($data, [
            'name' => 'required|string|max:25|unique:roles',
        ]);

        if ($validator->fails()) {
            return redirect('catalogos/'.$cat_id.'/'.$idItem.'/'.$action)
                ->withErrors($validator)
                ->withInput();
        }
        $rol->name =$data['name'];
        $rol->save();

        return redirect('index/'.$cat_id);
    }

    public function destroy($id=0,$idItem=0,$action=0)
    {
//        dd($id);
        DB::table('roles')->where('id',$id)->delete();
        return Response::json(['mensaje' => 'Registro eliminado con éxito', 'data' => 'OK', 'status' => '200'], 200);
    }

}
