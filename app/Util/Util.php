<?php
namespace App\Util;
use Laravel\Lumen\Routing\Controller as BaseController;

class Util extends BaseController
{
    public  static function response ($message, $status){
        return response()->json(['message' => $message], $status);
    }
}


?>
