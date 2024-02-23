<?php

namespace Core\Quack;

use Core\Route\Route;
use Core\Route\Router;

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

        if (!file_exists($cacheFile) || file_get_contents($cacheFile) != file_get_contents(self::$templateDirectory.$file.".html.quack")){
            $quackContent = self::includeFile($file);
            $quackContent = self::parseContent($quackContent);
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

    static function parseContent($quackContent): array|string{
        $quackContent = self::parsePath($quackContent);
        $quackContent = self::parseBlock($quackContent);
        $quackContent = self::parseYield($quackContent);
        $quackContent = self::parseEchos($quackContent);
        $quackContent = self::parseLoop($quackContent);
        $quackContent = self::parseEnd($quackContent);
        $quackContent = self::parsePhp($quackContent);


        return $quackContent;
    }

    /**
     * get routes in class route
     * foreach inside associe name avec uri
     */

    static function parsePath($quackContent){
        preg_match_all('/{{\s* path(.+?) \s*}}/',$quackContent,$matches);



        for ($i=0;$i<count($matches);$i++){
            $matches[1][$i] = substr($matches[1][$i],2);
            $matches[1][$i] = strstr($matches[1][$i],'"',true);

            // traitement variable



            $route = new Router();
            $route = $route->findByName($matches[1][$i]);
              if ($route){
                $quackContent = preg_replace('/{{\s* path(.+?) \s*}}/','"'.$route->getUri().'"',$quackContent,1);
              }
        }

        return $quackContent;
    }



    static function parseEchos($quackContent): array|string|null{
        return preg_replace('/{{\s*(.+?)\s*}}/', '<?= $$1; ?>', $quackContent);
    }

    static function parseLoop($quackContent): array|string|null{
        return preg_replace('/{%\s*for (.+?) in (.+?)\s*%}/', '<?php foreach ($$2 as $$1): ?>', $quackContent);
    }

    static function parseEnd($quackContent): array|string|null{
        return preg_replace('/{%\s* endfor *%}/', '<?php endforeach ?>', $quackContent);
    }

    static function parsePhp($quackContent): array|string|null{
        return preg_replace('/{%\s*(.+?)\s*%}/', '<?php $1 ?>', $quackContent);
    }



    static function parseBlock($quackContent): array|string
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

          $quackContent = self::parseBlockTitle($quackContent);
          $quackContent = self::parseBlockContent($quackContent);

        return $quackContent;
    }


    static function parseBlockContent($quackContent){

        preg_match('/{% ?block ?content ?%}(.*?){% ?endblock ?%}/is',$quackContent,$matches);
        $content = preg_replace('/{% ?block ?content ?%}(.*?){% ?endblock ?%}/is','',$matches);
        self::$blocks["content"] = $content[1];
        $quackContent = str_replace($content[1],'',$quackContent);
        $quackContent = preg_replace('/{% ?block ?content ?%}(.*?){% ?endblock ?%}/is','',$quackContent);
        return $quackContent;
    }


    static function parseBlockTitle($quackContent){
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



    static function parseYield($quackContent): array|string|null
    {
        foreach(self::$blocks as $block => $value) {
            $quackContent = preg_replace('/{% ?yield ?' . $block . ' ?%}/', $value, $quackContent);
        }
        $quackContent = preg_replace('/{% ?yield ?(.*?) ?%}/i', '', $quackContent);
        return $quackContent;
    }

}