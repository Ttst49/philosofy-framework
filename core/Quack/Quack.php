<?php

namespace Core\Quack;

class Quack
{

    static array $blocks = array();
    static string $cachePath = "../cache/";
    static string $cacheMode = "dev";
    static string $templateDirectory = "../templates/";
    static array $blockRegistry = ["content","title",""];


    static function view($file, $data = array()): void
    {
        $cacheFile = self::cache($file);
        extract($data, EXTR_SKIP);
        require_once $cacheFile;
    }


    static function cache($file): string{
        if (!file_exists(self::$cachePath.self::$cacheMode)){
            mkdir(self::$cachePath.self::$cacheMode);
        }
        self::$cachePath = self::$cachePath.self::$cacheMode."/";
        $cacheFile = self::$cachePath.$file.".html.php";
        $directoryName = strtok($file, '/');
        if (!file_exists(self::$cachePath.$directoryName)){
            mkdir(self::$cachePath.$directoryName);
        }

        if (!file_exists($cacheFile) || file_get_contents($cacheFile) != file_get_contents(self::$templateDirectory.$file.".html.php")){
            $quackContent = self::includeFile($file);
            $quackContent = self::compileContent($quackContent);
            file_put_contents($cacheFile,$quackContent);
        }

        return $cacheFile;
    }


    static function includeFile($file): array|string|null
    {
        if ($file == "base"){
            $quackContent = file_get_contents(self::$templateDirectory.$file.".html.php");
        }else{
            $quackContent = file_get_contents(self::$templateDirectory.$file.".html.quack");
        }
        preg_match_all('/{% ?(extends|include) ?\'?(.*?)\'? ?%}/i', $quackContent, $matches, PREG_SET_ORDER);
        foreach ($matches as $match){
            $quackContent = str_replace($match[0], self::includeFile($match[2]), $quackContent);
        }
        return preg_replace('/{% ?(extends|include) ?\'?(.*?)\'? ?%}/i', '', $quackContent);
    }

    static function compileContent($quackContent): array|string{
        $quackContent = self::compileBlock($quackContent);
        $quackContent = self::compileYield($quackContent);
        $quackContent = self::compileEchos($quackContent);
        $quackContent = self::compilePhp($quackContent);

        return $quackContent;
    }


    static function compileEchos($quackContent): array|string|null{
        return preg_replace('/{{\s*(.+?)\s*}}/', '<?= $1; ?>', $quackContent);
    }

    static function compilePhp($quackContent): array|string|null{
        return preg_replace('/{%\s*(.+?)\s*%}/', '<?php $1 ?>', $quackContent);
    }


    static function compileBlock($quackContent): array|string
    {

        preg_match_all('/{% ?block ?(.*?) ?%}(.*?){% ?endblock ?%}/is', $quackContent, $matches, PREG_SET_ORDER);
        foreach ($matches as $match){
            foreach ($match as $str){
                $blockName = strstr($str, "k "); //gets all text from needle on
                $blockName = strstr($blockName, " %}", true); //gets all text before needle
                $blockName = substr($blockName,1);
                $blockName = trim($blockName);


            if (!in_array($blockName,self::$blockRegistry)){
                throw new \Exception("Le block ".$blockName." n'est pas conforme");
            }

            }
        }

          $quackContent = self::compileBlockTitle($quackContent);
          $quackContent = self::compileBlockContent($quackContent);

        return $quackContent;
    }


    static function compileBlockContent($quackContent){

        preg_match('/{% ?block ?content ?%}(.*?){% ?endblock ?%}/is',$quackContent,$matches);
        $content = preg_replace('/{% ?block ?content ?%}(.*?){% ?endblock ?%}/is','',$matches);
        self::$blocks["content"] = $content[1];
        $quackContent = str_replace($content[1],'',$quackContent);
        $quackContent = preg_replace('/{% ?block ?content ?%}(.*?){% ?endblock ?%}/is','',$quackContent);
        return $quackContent;
    }


    static function compileBlockTitle($quackContent){
        preg_match('/{% ?block ?title ?%}(.*?){% ?endblock ?%}/is',$quackContent,$matches);
        if ($matches){
            $content = preg_replace('/{% ?block ?title ?%}(.*?){% ?endblock ?%}/is','',$matches);
            self::$blocks["title"] = $content[1];
            $quackContent = str_replace($content[1],'',$quackContent);
            $quackContent = preg_replace('/{% ?block ?title ?%}(.*?){% ?endblock ?%}/is','',$quackContent);
        }else{
            self::$blocks["title"] = "Quack Quack";
        }
        return $quackContent;
    }



    static function compileYield($quackContent): array|string|null
    {
        foreach(self::$blocks as $block => $value) {
            $quackContent = preg_replace('/{% ?yield ?' . $block . ' ?%}/', $value, $quackContent);
        }
        $quackContent = preg_replace('/{% ?yield ?(.*?) ?%}/i', '', $quackContent);
        return $quackContent;
    }

}