<?php

namespace Core\View;

use Core\Quack\Quack;

class View
{

      public static function oldRender($nomDeTemplate, $donnees): void
      {

      ob_start();
      extract($donnees);

      require_once "../templates/$nomDeTemplate.html.php";

      $content = ob_get_clean();

      if(!isset($pageTitle)){ $pageTitle = "Pas de titre"; }

      ob_start();
      require_once "../templates/base.html.php";
      echo ob_get_clean();

      }


     public static function render($viewName,$data): void
     {
         /**
         $viewPath = "../templates/";
         $cachePath = "../cache/";
         extract($data);
         $content = file_get_contents($viewPath . $viewName . ".html.quack");
         $content = preg_replace('/{{\s*(.+?)\s*}}/', '<?= $1; ?>', $content);
         $content = preg_replace('/{%\s*(.+?)\s*%}/', '<?php $1 ?>', $content);
         $cacheFile = $cachePath.$viewName.".html.php";
         $directoryName = strtok($viewName, '/');
         mkdir($cachePath.$directoryName);
         file_put_contents($cacheFile,$content);
         //require_once "../templates/base.html.php";
         require $cacheFile;

          **/
         Quack::view($viewName,$data);
     }


    public static function renderError($nomDeTemplate){


        ob_start();
        require_once "../templates/error/$nomDeTemplate.html.php";
        echo ob_get_clean();

    }

}
