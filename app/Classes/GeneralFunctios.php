<?php


namespace App\Classes;


use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use Intervention\Image\Facades\Image;




class GeneralFunctios extends App {


    public function __construct(){ }
    //
    public function toMayus($str=""){
        return strtr(strtoupper($str), "áéíóúñ", "ÁÉÍÓÚÑ");
    }

    public function removeAcent($str=""){
        $str = str_replace("á","a",$str);
        $str = str_replace("é","e",$str);
        $str = str_replace("í","i",$str);
        $str = str_replace("ó","o",$str);
        $str = str_replace("ú","u",$str);
        $str = str_replace("ñ","n",$str);

        $str = str_replace("Á","A",$str);
        $str = str_replace("É","E",$str);
        $str = str_replace("Í","I",$str);
        $str = str_replace("Ó","O",$str);
        $str = str_replace("Ú","U",$str);
        $str = str_replace("Ñ","N",$str);

        $str = str_replace("(","",$str);
        $str = str_replace(")","",$str);

        return $str;

    }

    public function showFile($root="/archivos/",$archivo=""){
        $public_path = public_path();
        $url = $public_path."/storage/".$root.$archivo;
        if (Storage::exists($archivo))
        {
            return response()->download($url);
        }
        abort(404);
    }

    public function string_to_tsQuery( $string,  $type){
        $string = $this->removeAcent($string);
        $str = explode(" ",$string);
        $string = '';
        $i = 1;
        foreach ($str as $value){
            if ( strlen($value) >= 4 ){
                $vector = '';
                if ($string!=''){
                    $vector = $type;
                }
                $string = $string.$vector.$value;
            }
            ++$i;
        }
        return $string;
    }

    // get IP, Host or Mac Address
    public static function getIHM($type=0){
        switch ($type){
            case 0:
                return 1;
                break;
            case 1:
                return Request()->ip(); //$_SERVER['REMOTE_ADDR'];
                break;
            case 2:
                return gethostbyaddr($_SERVER['REMOTE_ADDR']);
                break;
            case 3:
                $ip = Request::ip();
                return shell_exec("arp -a ".escapeshellarg($ip)." | grep -o -E '([[:xdigit:]]{1,2}:){5}[[:xdigit:]]{1,2}'");
                break;
            case 5:
                $ip = explode('.',Request::ip());
                return intval($ip[0]);
                break;
            case 6:
                $ip = explode('.', Request()->ip() );
                return intval($ip[0]);
                break;
        }
    }

    public static function getIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
    }

    public function setDateTo6Digit($fecha){
        if(is_null($fecha)){
            $fecha = Carbon::today()->toDateString();
        }
        $fecha = str_replace('20','',$fecha);
        $fecha = str_replace('-','',$fecha);
        return $fecha;
    }

    public function getFechaFromNumeric($number){
        return
            '20'.substr($number,0,2).'-'.
            substr($number,2,2).'-'.
            substr($number,4,2)
            ;
    }

    public function fechaEspanol($f){
        $f = explode('-',substr($f,0,10));
        return $f[2].'-'.$f[1].'-'.$f[0];
    }

    public function fechaEspanolComplete($f,$type=false){
        $f = explode('-',substr($f,0,10));
        $f =  $f[2].'-'.$f[1].'-'.$f[0];
        return !$type ? $f.' 00:00:00' : $f.' 23:59:59';
    }

    public function fechaDateTimeFormat($f,$type=false){
        $f = explode('-',substr($f,0,10));
        $f = $f[0].'-'.$f[1].'-'.$f[2];
        return !$type ? $f.' 00:00:00' : $f.' 23:59:59';
    }

    public function getFechaFromDiagonalFormatoEspanol($f){
        $f = trim($f);
        $separ = str_contains($f,'/') ? '/' : '-';
        $f = explode($separ,substr($f,0,10));
        if ( count($f) == 3 && $f != "0000-00-00" && $f != "0000/00/00" ){
            $f[1] = intval($f[1]) >= 1 && intval($f[1]) <= 12 ? intval($f[1]) : intval($f[0]);
            $f[0] = intval($f[0]) >= 1 && intval($f[0]) <= 31 ? intval($f[0]) : intval($f[1]);
            $f = str_pad($f[2],4,"0",STR_PAD_LEFT).
                '-'.
                str_pad($f[1],2,"0",STR_PAD_LEFT).
                '-'.
                str_pad($f[0],2,"0",STR_PAD_LEFT);
        }else{
            $f = now();
        }
        return $f;
    }

    public function validImage($model, $storage, $root, $type=1){
        $ext = config('ibt.images_type_extension');
        for ($i=0;$i<count($ext);$i++){
            $p1 = $model->id.'.'.$ext[$i];
            $p2 = '_'.$model->id.'.png';
            $p3 = '_thumb_'.$model->id.'.png';
            $e1 = Storage::disk($storage)->exists($p1);
            if ($e1) {
                switch ($type) {
                    case 1:
                        $model->update([
                            'root'              =>  $root,
                            'filename'          =>  $p1,
                            'filename_png'      =>  $p2,
                            'filename_thumb'    =>  $p3
                        ]);
                        break;
                }
            }
        }
    }

    public function deleteImages($model,$storage){
        $ext = ['jpg','jpeg','gif','png','JPG','JPEG','GIF','PNG','xls','xlsx','doc','docx','ppt','pptx','txt','mp4','pages','key','numbers'];
        for ($i=0;$i<4;$i++){
            $p1 = $model->id.'.'.$ext[$i];
            $e1 = Storage::disk($storage)->exists($p1);
            if ($e1) {
                Storage::disk($storage)->delete($p1);
            }
        }
    }

    public function fitImage($imagePath,$filename,$W,$H,$IsRounded,$disk,$profile_root)
    {
        try{
            $image = Image::make($imagePath)
                ->fit($W,$H);
            if ($IsRounded){
                $image->encode('png');
                $width = $image->getWidth();
                $height = $image->getHeight();
                $mask = Image::canvas($width, $height);
                $mask->circle($width, $width/2, $height/2, function ($draw) {
                    $draw->background('#fff');
                });
                $image->mask($mask, false);
                $filePath = public_path(env($profile_root)).'/'.$filename;
                $image->save($filePath);
                Storage::disk($disk)->put($filename, $image);
            }else{
                Storage::disk($disk)->put($filename, $image);
            }
        }catch (NotWritableException $e){
            return "Error ";
        }
        return $image;
    }

    public function deleteImageDropZone($image,$storage){
        $e1 = Storage::disk($storage)->exists($image);
        if ($e1) {
            Storage::disk($storage)->delete($image);
        }
    }

    public function IsPersonaMoral($rfc){
        $num  = substr($rfc,3,1);
        if ( $rfc != ""){
            if ( $num=='0' || $num=='1' || $num=='2' || $num=='3' || $num=='4' || $num=='5' || $num=='6' || $num=='7' || $num=='8' || $num=='9' ){  // Persona Moral
                return true;
            }else{  // Persona Física
                return false;
            }
        }else{
            return false;
        }

    }

    public function clearRegistroIMSS($registro_patronal_imss){
        $pass0 = str_replace(' ','',strtoupper(trim($registro_patronal_imss)));
        $pass0 = str_replace('-','',$pass0);
        return $pass0;
    }


}
