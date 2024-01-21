<?php

namespace Core\View;

class View
{

      public static function render($nomDeTemplate, $donnees): void
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


     public static function renderQuack($viewName,$data = []): void
     {
         $viewPath = "../templates/";
         $cachePath = "../cache/";
         extract($data);
         $content = file_get_contents($viewPath . $viewName . ".html.quack");
         $content = preg_replace('/{{\s*(.+?)\s*}}/', '<?php echo $1; ?>', $content);
         $cacheFile = $cachePath.$viewName.".html.quack";
         $directoryName = strtok($viewName, '/');
         mkdir($cachePath.$directoryName);
         file_put_contents($cacheFile,$content);
         $cacheFile = ob_get_clean();
         require_once "../templates/base.html.php";
         echo ob_get_clean();
     }

}
//idées retenues:flop, weed,🤡,dwayneJohnson, quack, noot
