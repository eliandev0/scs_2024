<?php
require_once __DIR__."/comprobarLogIn.php";
require_once(__DIR__.'/../class/class.Ambulatorio.php');

if (!isset($_POST['tarea'])) {
    exit;
}

$respuesta['exito'] = 0;
$respuesta['mensaje'] = 'Ha ocurrido algún error';

$tarea = sanitizarString($_POST['tarea']);
switch($tarea) {
    case 'cargarDatosAmbulatorio':
        $idAmbulatorio = sanitizarString($_POST['id']);
		$ambulatorio = new Ambulatorio($idAmbulatorio);
		if ($ambulatorio->getId() != $idAmbulatorio) {
			$respuesta['exito'] = 0;
			break;
		}
		$datos['inputNombre'] = $ambulatorio->getNombre();
		$datos['inputDireccion'] = $ambulatorio->getDireccion();
		$datos['inputTelefono'] = $ambulatorio->getTelefono();

		$respuesta['exito'] = 1;
		$respuesta['mensaje'] = '';
		$respuesta['datos'] = $datos;
		
        break;
		
	case 'guardarDatosAmbulatorio':
		$idAmbulatorio = sanitizarString($_POST['id']);
		$ambulatorio = new Ambulatorio($idAmbulatorio);
		
		$ambulatorio->setNombre(sanitizarString($_POST['nombre']));
		$ambulatorio->setDireccion(sanitizarString($_POST['direccion']));
		$ambulatorio->setTelefono(sanitizarString($_POST['telefono']));

		
		if ($ambulatorio->guardar()) {
			$respuesta['exito'] = 1;
			$respuesta['mensaje'] = 'Los datos del ambulatorio se han guardado correctamente';
		} else {
			$respuesta['exito'] = 0;
			$respuesta['mensaje'] = 'Ha ocurrido algún error al tratar de guardar los datos del ambulatorio';
		}
		break;
}

ob_clean();
echo json_encode($respuesta);
?>