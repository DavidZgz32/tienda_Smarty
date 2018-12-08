<?php
require_once './plantilla.php';
require_once './DB.php';
$plantilla= iniplantilla();
$cod=$_GET['cod'];
$db=new DB();
$producto=$db->obtenerProducto($cod);
$ordena=$db->obtenerOrdena($cod);
$plantilla->assign("ordena",$ordena);
$plantilla->assign("producto",$producto);
$plantilla->display("descripcion.tpl");

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

