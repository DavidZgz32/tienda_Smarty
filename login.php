
<?php

require_once("./plantilla.php");
require_once("./DB.php");
$plantilla = iniplantilla();

session_start();
session_destroy();
session_start();


$db = new DB();

if (isset($_POST['acceso'])) {
    $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : null;
    $pass = isset($_POST['password']) ? $_POST['password'] : null;
    $valida = $db->verificarCliente($usuario, $pass);
    if ($valida) {
        $plantilla->assign("usuario", $usuario);
        $_SESSION['usuario']['nombre'] = $usuario;
        $_SESSION['usuario']['contraseña'] = $pass;
        //$plantilla->display("productos.tpl");
        header("Location:productos.php");
    } else {
        $msj = "Error al ingresar la contraseña o el nombre de usuario";
        $plantilla->assign("msj", $msj);
        $plantilla->display("login.tpl");
    }
} else {
    $plantilla->display("login.tpl");
}
?>
