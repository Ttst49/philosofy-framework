<?php

namespace Core\Debugging;

class Debugger
{

    private $error;
    private $exception;

    public function errorHandler($severity, $message, $file, $line): void
    {
        $this->error = [$severity,$message,$file,$line];
        echo "coucou y'a une erreur";
        echo $this->error["message"];
    }

    public function exceptionHandler(\Throwable $exception): void
    {
        $this->exception = $exception;
        echo "y'a une exception";
        echo $this->exception->getMessage();
    }

    public static function run()
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        set_error_handler([Debugger::class,"errorHandler"]);
        set_exception_handler([Debugger::class,"exceptionHandler"]);
    }



}
