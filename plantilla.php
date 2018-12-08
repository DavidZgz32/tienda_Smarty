<?php

require_once("Smarty.class.php");

function iniplantilla() {


    $plantilla = new Smarty();
    $plantilla->template_dir = "./vista/template";
    $plantilla->compile_dir = "./vista/template_c";
    $plantilla->cache_dir = "./vista/cache";
    $plantilla->config_dir = "./vista/config";

    return $plantilla;
}
