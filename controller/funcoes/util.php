<?php
    class util
    {
        static function obterTwig()
        {
            require_once $_SERVER['DOCUMENT_ROOT']."/doparty/controller/library/vendor/autoload.php";

            $pastaTemplates = $_SERVER['DOCUMENT_ROOT']."/doparty/templates";
            $loader         = new Twig_loader_Filesystem($pastaTemplates);
            $twig           = new Twig_Environment($loader);
            
            return $twig;
        }
    }
?>