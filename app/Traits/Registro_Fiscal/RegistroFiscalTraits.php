<?php


namespace App\Traits\Registro_Fiscal;


trait RegistroFiscalTraits{

    protected $disk1 = 'rfc';

    public static function isRFC($rfc): bool{

        return count(self::findByRFC($rfc) ) ? true : false;

    }

    public static function findByRFC($rfc){

        return self::query()->where('rfc',strtoupper(trim($rfc)))->get();

    }

    public static function findFirstByRFC($rfc){

        return self::query()->where('rfc',strtoupper(trim($rfc)))->first();

    }

    public static function findById($Id){

        return self::all()->where('id',$Id);

    }


}
