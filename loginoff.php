<?php

if ($_POST['desconectar']) {
    session_start();
    session_destroy();
    header("Location:login.php");
}
