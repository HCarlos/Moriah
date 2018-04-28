<?php

namespace App\Http\Controllers\Multimedia;

use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\Fichafile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Ficha;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Constraint\IsEmpty;
use Illuminate\Support\Facades\Input;



class BusquedaMultimediaController extends Controller
{
    protected $redirectTo = '/home_alumno';
    protected $itemPorPagina = 5;

    /**
     * @param Request $request
     */
    public function busquedaMultimedia(Request $request){
        $F           = new FuncionesController();
        $data        =  $request->all();
        $npage       = $data['npage'];
        $tpaginas    = $data['tpaginas'];
        $searchWords = $data['searchWords'];
        $tsString    = $F->string_to_tsQuery( strtoupper($searchWords),' & ');
        $libros      = Ficha::select('isbn')->search($tsString)->get()->forPage($npage,$this->itemPorPagina);
        $tpaginator  = Ficha::search($tsString)->paginate($this->itemPorPagina,['*'],'p');
        //dd($libros);

        foreach ($libros as $lib){
            $ff  = Ficha::hasIsbnWithImages($lib->isbn);
            //dd($ff);
            if ( $ff->count() > 0 ) {
                $ficha = Ficha::findOrFail($ff[0]->ficha_id);
            }else {
                $ficha = Ficha::whereIsbn($lib->isbn)->first();
            }
            $lib->id =  $ficha->id;
            $lib->editorial =  $ficha->getEditorial();
            $eti = explode('|', $ficha->etiqueta_marc);
            $lib->titulo = $ficha->titulo;
            $lib->autor = $ficha->autor;
            $lib->apartado = $ficha->isApartado();
            $lib->prestado = $ficha->isPrestado();
            $lib->imagenes = $ff;
            $lib->etiquetas = $eti;
            $lib->tipo_material = $ficha->tipo_material == 1 ? 'LIBRO' : 'REVISTA';
            $lib->clasificacion = $ficha->clasificacion;
            $lib->existencia = $ficha->getExistencia();
        }

        $tpaginas = $tpaginas == 0 ? $tpaginator->lastPage() : $tpaginas;
        $user = Auth::User();
        $tpaginator->withPath("/bM/$npage/$tpaginas/$searchWords");
        //dd($libros);
        return view ('multimedia.busqueda_multimedia_alumno',
            [
                'items' => $libros,
                'user' => $user,
                'stringBusqueda' => $searchWords,
                'tsString' => $tsString,
                'npage'=> $npage,
                'tpaginas' => $tpaginas,
                'searchWords' => $searchWords,
            ]
        )->with("paginator" , $tpaginator);


    }

    public function bMultimedia($npage = 1, $tpaginas = 0, $searchWords=''){
        $F        = new FuncionesController();
        $npage = Input::get('p');
        $tsString = $F->string_to_tsQuery( strtoupper($searchWords),' & ');
        $libros = Ficha::select('isbn')->search($tsString)->get()->forPage($npage,$this->itemPorPagina);
        $tpaginator = Ficha::search($tsString)->paginate($this->itemPorPagina,['*'],'p');

        foreach ($libros as $lib){
            $ff  = Ficha::hasIsbnWithImages($lib->isbn);
            //dd($ff);
            if ( $ff->count() > 0 ) {
                $ficha = Ficha::findOrFail($ff[0]->ficha_id);
            }else {
                $ficha = Ficha::whereIsbn($lib->isbn)->first();
            }
            $lib->id =  $ficha->id;
            $lib->editorial =  $ficha->getEditorial();
            $eti = explode('|', $ficha->etiqueta_marc);
            $lib->titulo = $ficha->titulo;
            $lib->autor = $ficha->autor;
            $lib->apartado = $ficha->isApartado();
            $lib->prestado = $ficha->isPrestado();
            $lib->imagenes = $ff;
            $lib->etiquetas = $eti;
            $lib->tipo_material = $ficha->tipo_material == 1 ? 'LIBRO' : 'REVISTA';
            $lib->clasificacion = $ficha->clasificacion;
            $lib->existencia = $ficha->getExistencia();
        }

        $user = Auth::User();
        $tpaginator->withPath("/bM/$npage/$tpaginas/$searchWords");
        return view ('multimedia.busqueda_multimedia_alumno',
            [
                'items' => $libros,
                'user' => $user,
                'stringBusqueda' => $searchWords,
                'tsString' => $tsString,
                'npage'=> $npage,
                'tpaginas' => $tpaginas,
                'searchWords' => $searchWords,
            ]
        )->with("paginator" , $tpaginator);

    }

}
