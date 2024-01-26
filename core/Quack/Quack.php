<?php

namespace Core\Quack;

class Quack
{

    static $cachePath = "../cache/";
    static $cacheMode = "prod";



    static function cache($file){
        if (!file_exists(self::$cachePath.self::$cacheMode)){
            mkdir(self::$cachePath.self::$cacheMode);
        }
        $cacheFile = self::$cachePath.$file.".html.php";
        if (!file_exists($cacheFile)){

        }
    }
}