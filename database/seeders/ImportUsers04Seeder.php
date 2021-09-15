<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ImportUsers04Seeder extends Seeder{



    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){




        @ini_set( 'upload_max_size' , '32768M' );
        @ini_set( 'post_max_size', '32768M');
        @ini_set( 'max_execution_time', '256000000' );

        $creado_por_id = User::find(1)->id;
        $empresa_id = 1;

        //INE::query()->truncate();

        $file = 'public/users4.txt';

        $json_data = file_get_contents($file);

        $json_data = preg_split( "/\n/", $json_data );
        for ($x = 0; $x < count($json_data); $x++){

            try{

                $dupla = preg_split("/\t/", $json_data[$x], -1, PREG_SPLIT_NO_EMPTY);

                if ( $dupla ) {

                    $arr = str_getcsv($dupla[0], '|');

                    // dd($arr);

                    $dataAdress = [
                        'calle' => $arr[12],
                        'num_ext' => $arr[13],
                        'num_int' => $arr[14],
                        'colonia' => $arr[15],
                        'localidad' => $arr[16],
                        'municipio' => $arr[18],
                        'estado' => $arr[19],
                        'cp' => $arr[17],
                    ];
                    $dataExtend = [
                        'ocupacion' => $arr[20],
                        'lugar_nacimiento' => $arr[21],
                    ];

                    //dd($dataAdress);

                    User::agregarConSeeder($arr[0], $arr[1], $arr[2], $arr[3], $arr[4], $arr[5], $arr[6], $arr[7], $arr[8], $arr[9], $empresa_id, $creado_por_id, $arr[10], $arr[11], $dataAdress, $dataExtend);
                }
            }catch (QueryException $e){
                Log::alert($e->getMessage() ." => ". $arr);
                continue;
            }catch (\Whoops\Exception\ErrorException $e){
                Log::alert($e->getMessage() ." => ". $arr);
                continue;
            }
        }




    }





}
