<?php

namespace App\Traits\User;

use Illuminate\Support\Facades\DB;
//use App\Http\Controllers\Funciones\FuncionesController;
use DateTime;

trait UserImport
{

    public static function findOrCreateUserWithRole(
        string $username, string $nombre, string $ap_paterno, string $ap_materno, string $email, string $password,
        string $calle='', string $num_ext='', string $num_int='', string $colonia='', string $localidad='',
        string $cp='', string $curp='', string $lugar_nacimiento='', string $fecha_nacimiento='', int $genero=0,
        string $emails='', string $celulares='', string $telefonos='', int $empresa_id=1, string $ocupacion='',
        string $roles=''
    ){
        $result = false;

        //        $user = static::where('username', $username)->where('email', $email)->first();

        $user = static::where('username', $username)->first();
        if (!$user) {
            if ($email == ''){
                $email = $username.'@example.com';
            }
            if ($password == ''){
                $password = $username;
            }
            //dd($fecha_nacimiento);
            if ( trim($fecha_nacimiento) !== ""){
                $fecha_nacimiento =  DateTime::createFromFormat('d/m/Y', $fecha_nacimiento)->format('Y-m-d');
            }else{
                $fecha_nacimiento = null;
            }
            DB::transaction(function ()
            use
            (
                $username, $nombre, $ap_paterno, $ap_materno, $email, $password, $curp,
                $calle, $num_ext, $num_int, $colonia, $localidad, $cp,
                $lugar_nacimiento, $fecha_nacimiento, $genero, $emails, $celulares, $telefonos,
                $empresa_id, $ocupacion, $roles
            )
            {
                $user = static::create([
                    'username'=>$username,
                    'nombre'=>$nombre,
                    'ap_paterno'=>$ap_paterno,
                    'ap_materno'=>$ap_materno,
                    'email'=>$email,
                    'password' => bcrypt($password),
                    'curp' => $curp,
                    'fecha_nacimiento' => $fecha_nacimiento,
                    'genero' => $genero,
                    'emails' => $emails,
                    'celulares' => $celulares,
                    'telefonos' => $telefonos,
                    'empresa_id' => $empresa_id,
                ]);
                $user->user_adress()->create([
                    'calle' => $calle,
                    'num_ext' => $num_ext,
                    'num_int' => $num_int,
                    'colonia' => $colonia,
                    'localidad' => $localidad,
                    'cp' => $cp,
                ]);
                $user->user_data_extend()->create([
                    'ocupacion'=> $ocupacion,
                    'lugar_nacimiento' => $lugar_nacimiento,
                ]);

                static::asignaRoleInterno($user,$roles);

                $user->permissions()->attach(7);

                if ($user->hasRole('ALUMNO')){
                    $user->user_becas()->create();
                }

                $F = new FuncionesController();
                $F->validImage($user,'profile','profile/');

            });

        }else{
            static::asignaRoleInterno($user,$roles);
        }

        return $result;

    }

    public static function asignaRoleInterno($user,$roles){
        $roless = explode('|',$roles);
        foreach ($roless as $role){
            if (intval($role) > 0){
                $rolex = DB::table('role_user')->select('id')->where('role_id',$role)->where('user_id',$user->id)->first();
                if (!$rolex)
                    $user->roles()->attach($role);
            }
        }
        return $user;

    }

}
