<?php
require_once __DIR__."/comprobarLogIn.php";


if (!isset($_POST['tarea'])) {
    exit;
}

global $sesion;

$respuesta['exito'] = 0;
$respuesta['mensaje'] = 'Ha ocurrido algún error';

$tarea = sanitizarString($_POST['tarea']);
switch($tarea) {
    case 'cargarListadoAmbulatorios':
		$gestorDB = new DBHandler();
		$ambulatorios = $gestorDB->getRegistros(TABLA_AMBULATORIOS,['*'],'', [], 'nombre ASC','FETCH_ASSOC');
		$respuesta['exito'] = 1;
		$respuesta['mensaje'] = 'Datos de los ambulatorios';
		$respuesta['datos'] = $ambulatorios;
        break;

	case 'cargarListadoConsultas':
		$gestorDB = new DBHandler();
		$consultas = $gestorDB->getRegistros(TABLA_CONSULTAS,['*'],'', [], 'nombre ASC','FETCH_ASSOC');
		$respuesta['exito'] = 1;
		$respuesta['mensaje'] = 'Datos de las consultas';
		$respuesta['datos'] = $consultas;
		break;
}

ob_clean();
echo json_encode($respuesta);
?>