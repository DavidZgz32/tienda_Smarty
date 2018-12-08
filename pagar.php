<?php

require_once './plantilla.php';
require_once("./Cesta.php");
require_once("./DB.php");
require_once './Producto.php';
session_start();
if ($_SESSION ['cesta']) {
    $db = new DB();
    $cesta = $_SESSION['cesta'];
    $plantilla = iniplantilla();
    $productoCesta = $cesta->getProductos();
    $unidades = $cesta->getUnidades();
    $cantidad = $cesta->cantidad();
    $coste = $cesta->getCoste();
    $costeIVA = round(($coste * 0.21), 2);
    $total = round(($coste + $costeIVA), 2);

    $_SESSION['cesta'] = $cesta;
    $plantilla->assign("productos", $productoCesta);
    $plantilla->assign("unidades", $unidades);
    $plantilla->assign("cantidad", $cantidad);
    $plantilla->assign("coste", $coste);
    $plantilla->assign("costeIVA", $costeIVA);
    $plantilla->assign("total", $total);
    $plantilla->display("pagar.tpl");
}

