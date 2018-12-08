<?php

require_once './plantilla.php';
require_once("./DB.php");
require_once("./Cesta.php");
require_once './libs/ajax.php';
session_start();
$db = new DB();
$plantilla = iniplantilla();
$ajax = ajax();
switch ($_POST['accion']) {
    case "Añadir":
        $ajax->click("submit", $ajax->form("./libs/ajax.php?/RecargaCesta/cargaCesta"));
        agregarCesta($_POST['cod_producto'], null);
        break;
    case "pagar":
        header("Location:pagar.php");
        exit;
        break;
    case "vaciar":
        $cesta = $_SESSION['cesta'];
        $cesta->vaciar();
        $_SESSION['cesta'] = $cesta;
        agregarCesta(null, null);
        break;
    case "Seguir comprando" || "Regresar a lista":
        agregarCesta(null, null);
        break;
    default:
        $productos = $db->obtenerProductos();
        $ordena = $db->obtenerOrdena();
        if (isset($_POST['quitar'])) {
            $codigo = $_POST['codQuitar'];
            agregarCesta(null, $codigo);
        } else {
            $cesta = new Cesta();
            $_SESSION['cesta'] = $cesta;
            agregarCesta(null, null);
        }
        break;
}

function cargarProductos($plantilla, $unidades, $coste, $productosCesta, $productos, $nombre, $ordena, $msj) {
    $ajax = ajax();
    $plantilla->assign("unidades", $unidades);
    $plantilla->assign("coste", $coste);
    $plantilla->assign("productosCesta", $productosCesta);
    $plantilla->assign("productos", $productos);
    $plantilla->assign("nombre", $nombre);
    $plantilla->assign("familia", "ORDENA");
    $plantilla->assign("vacio", $msj);
    $linkAjax = $ajax->init();
    $plantilla->assign("linkAjax", $linkAjax);
    $plantilla->display("productos.tpl");
}

function agregarCesta($pro, $cod) {
    $db = new DB();
    $plantilla = iniplantilla();
    $cesta = $_SESSION['cesta'];
    if ($cod != null) {
        $cesta->borrar($cod);
    }
    if ($pro != null) {
        $producto = $db->obtenerProducto($pro);
        $cesta->nuevoArticulo($producto);
    }
    $n = sizeof($cesta->getProductos());
    if ($n == 0) {
        $msj = "La cesta esta vacia";
    }

    $productoCesta = $cesta->getProductos();
    $productos = $db->obtenerProductos();
    $unidades = $cesta->getUnidades();
    $precio = $cesta->getCoste();
    $ordena = $db->obtenerOrdena();
    $_SESSION['cesta'] = $cesta;
    cargarProductos($plantilla, $unidades, $precio, $productoCesta, $productos, $_SESSION['usuario']['nombre'], $ordena, $msj);
}
