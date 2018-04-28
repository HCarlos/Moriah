<?php

namespace App\Http\Controllers\Catalogos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{


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
            'name' => 'required|string|max:25|unique:permissions',
        ]);

        if ($validator->fails()) {
            return redirect('catalogos/'.$cat_id.'/'.$idItem.'/'.$action)
                ->withErrors($validator)
                ->withInput();
        }

        Permission::create(['name' => $data['name'],]);

        return redirect('index/'.$cat_id);
    }

    public function update(Request $request, Permission $perm)
    {
        $data = $request->all();
        $cat_id     = $data['cat_id'];
        $idItem     = $data['idItem'];
        $action     = $data['action'];

        $validator = Validator::make($data, [
            'name' => 'required|string|max:25|unique:permissions',
        ]);

        if ($validator->fails()) {
            return redirect('catalogos/'.$cat_id.'/'.$idItem.'/'.$action)
                ->withErrors($validator)
                ->withInput();
        }
        $perm->name =$data['name'];
        $perm->save();

        return redirect('index/'.$cat_id);
    }

    public function destroy($id=0,$idItem=0,$action=0)
    {
//        dd($id);
        DB::table('permissions')->where('id',$id)->delete();
        return Response::json(['mensaje' => 'Registro eliminado con éxito', 'data' => 'OK', 'status' => '200'], 200);
    }

}
