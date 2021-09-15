<?php


namespace App\Classes;
use Illuminate\Database\QueryException;

class MessageAlertClass
{
    protected $Msg;
    public function __construct(){
        $this->Msg  = "";
    }


    public function Message(QueryException $e):string {
        $this->Msg = trim($e->errorInfo[2]);

//        Verificar duplicados
        if (
            strpos( $this->Msg, 'duplicate key value' ) ||
            strpos( $this->Msg, 'llave duplicada' )
        ){
            $this->Msg = "Valor Duplicado";
        }

        return $this->Msg;

    }

}
