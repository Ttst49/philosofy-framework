<?php

namespace Core\Quack;

class Quack
{

    static array $blocks = array();
    static string $cachePath = "../cache/";
    static string $cacheMode = "dev";
    static string $templateDirectory = "../templates/";
    static array $blockNameRegistry = ["content","title", "carotte"];


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
            $content = self::includeFile($file);
            $content = self::compileContent($content);
            file_put_contents($cacheFile,$content);
        }

        return $cacheFile;
    }


    static function includeFile($file): array|string|null
    {
        if ($file == "base"){
            $content = file_get_contents(self::$templateDirectory.$file.".html.php");
        }else{
            $content = file_get_contents(self::$templateDirectory.$file.".html.quack");
        }
        preg_match_all('/{% ?(extends|include) ?\'?(.*?)\'? ?%}/i', $content, $matches, PREG_SET_ORDER);
        foreach ($matches as $match){
            $content = str_replace($match[0], self::includeFile($match[2]), $content);
        }
        return preg_replace('/{% ?(extends|include) ?\'?(.*?)\'? ?%}/i', '', $content);
    }

    static function compileContent($content): array|string{
        $content = self::compileBlock($content);
        $content = self::compileYield($content);
        $content = self::compileEchos($content);
        $content = self::compilePhp($content);

        return $content;
    }


    static function compileEchos($content): array|string|null{
        return preg_replace('/{{\s*(.+?)\s*}}/', '<?= $1; ?>', $content);
    }

    static function compilePhp($content): array|string|null{
        return preg_replace('/{%\s*(.+?)\s*%}/', '<?php $1 ?>', $content);
    }

    static function compileBlock($content): array|string
    {

          preg_match_all('/{% ?block ?(.*?) ?%}(.*?){% ?endblock ?%}/is', $content, $matches, PREG_SET_ORDER);

         foreach ($matches as $value) {
         if (!array_key_exists($value[1], self::$blocks)) self::$blocks[$value[1]] = '';
         if (!str_contains($value[2], '@parent')) {
         self::$blocks[$value[1]] = $value[2];
         } else {
         self::$blocks[$value[1]] = str_replace('@parent', self::$blocks[$value[1]], $value[2]);
         }
         $content = str_replace($value[0], '', $content);
         }



          //self::compileBlockContent($content);
          //self::compileBlockTitle($content);

        return $content;
    }

    /**
     * function compileBlockContent($content){
     * preg_match_all('/{% ?block content ?%}(.*?){% ?endblock ?%}/is', $content, $matches, PREG_SET_ORDER);
     *
     * foreach ($matches as $value) {
     * if (!array_key_exists($value[1], self::$blocks)) self::$blocks[$value[1]] = '';
     * if (!str_contains($value[2], '@parent')) {
     * self::$blocks[$value[1]] = $value[2];
     * } else {
     * self::$blocks[$value[1]] = str_replace('@parent', self::$blocks[$value[1]], $value[2]);
     * }
     * $content = str_replace($value[0], '', $content);
     * }
     * return $content;
     * }
     *
     * //registre des noms de blocks autorisés
     *
     * static function compileBlockTitle($content){
     * preg_match_all('/{% ?block title ?%}(.*?){% ?endblock ?%}/is', $content, $matches, PREG_SET_ORDER);
     *
     * foreach ($matches as $value) {
     * if (!array_key_exists($value[1], self::$blocks)) self::$blocks[$value[1]] = '';
     * if (!str_contains($value[2], '@parent')) {
     * self::$blocks[$value[1]] = $value[2];
     * } else {
     * self::$blocks[$value[1]] = str_replace('@parent', self::$blocks[$value[1]], $value[2]);
     * }
     * $content = str_replace($value[0], '', $content);
     * }
     * return $content; preg_match_all('/{% ?block title ?%}(.*?){% ?endblock ?%}/is', $content, $matches, PREG_SET_ORDER);
     * foreach ($matches as $value) {
     * if (!array_key_exists($value[1], self::$blocks)) self::$blocks[$value[1]] = '';
     * if (!str_contains($value[2], '@parent')) {
     * self::$blocks[$value[1]] = $value[2];
     * } else {
     * self::$blocks[$value[1]] = str_replace('@parent', self::$blocks[$value[1]], $value[2]);
     * }
     * $content = str_replace($value[0], '', $content);
     * }
     * return $content;
     * }
     */

    static function compileYield($content): array|string|null
    {
        foreach(self::$blocks as $block => $value) {
            $content = preg_replace('/{% ?yield ?' . $block . ' ?%}/', $value, $content);
        }
        $content = preg_replace('/{% ?yield ?(.*?) ?%}/i', '', $content);
        return $content;
    }

}