<?php
require_once(__DIR__."/../class/class.ManejoSesion.php");
require_once(__DIR__."/../config/config.global.php");
require_once(__DIR__."/../functions/funciones.globales.php");
require_once(__DIR__."/../class/class.Administrador.php");

global $CONFIG_GLOBAL;

// Inciamos el proceso de comprobación de la sesión
$sesion = new ManejoSesion();
$sesion->start(NOMBRE_SESION_SCS);


// Tratamos de leer la propiedad "nombre" y la "id_usuario" de la sesión. Además, comprobamos que la IP siga siendo la misma.
if ($sesion->read('nombre') === false || $sesion->read('id_usuario') === false || $sesion->read('ip_usuario') != obtenerIpUsuario()) {
    // Si no ocurre, destuimos la sesión
    $sesion->destroySession();
    if (isset($_POST['tarea'])) {
        $respuesta['exito'] = 0;
        $respuesta['mensaje'] = 'Su sesión ha caducado. Debe volver a hacer login.';
        echo json_encode($respuesta);
        exit;
    } else {
        header('Location: '.$CONFIG_GLOBAL['rutaURLBase'].'/index.php');
        exit;
    }
} else {
    // Si las propiedades se leen bien, cargamos el usuario para comprobar que no esté bloqueado
    $usuario = new Administrador($sesion->read('id_usuario'));
    if ($usuario->getBloqueado() == 1) {
        $sesion->destroySession();
        header('Location: '.$CONFIG_GLOBAL['rutaURLBase'].'/index.php');
        exit;
    }
}

?>