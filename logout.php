<?php
require_once(__DIR__."/class/class.ManejoSesion.php");
require_once(__DIR__."/config/config.global.php");

global $CONFIG_GLOBAL;

$sesion = new ManejoSesion();
$sesion->start(NOMBRE_SESION_SCS);
$sesion->destroySession();
header('Location: '.$CONFIG_GLOBAL['rutaURLBase'].'/index.php');
exit;
?>