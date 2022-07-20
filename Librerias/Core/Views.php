<?php
    class Views{
        //funcion que permite el llamado a una vista desde un controlador recibido por parametro
        function getView($controlller,$view,$data=""){
            $controlller = get_class($controlller);
            if($controlller == "Home"){
                $view = "Views/".$view.".php";
            }else{
                $view = "Views/".$controlller."/".$view.".php";
            }
            require_once ($view);

        }

    }
?>