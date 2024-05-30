<?php
require_once __DIR__."/comprobarLogIn.php";
require_once(__DIR__.'/../class/class.Consulta.php');

if (!isset($_POST['tarea'])) {
    exit;
}

$respuesta['exito'] = 0;
$respuesta['mensaje'] = 'Ha ocurrido algún error';

$tarea = sanitizarString($_POST['tarea']);
switch($tarea) {
    case 'cargarDatosConsulta':
		$consulta = new Consulta();

		$datos['inputNombre'] = $consulta->getNombre();
		$datos['inputIdAmbulatorio'] = $consulta->getIdAmbulatorio();
	

		$respuesta['exito'] = 1;
		$respuesta['mensaje'] = '';
		$respuesta['datos'] = $datos;
		
        break;
		
	case 'guardarDatosConsulta':
		$idConsulta = sanitizarString($_POST['id']);
		$consulta = new Consulta($idAmbulatorio);
		
		$consulta->setNombre(sanitizarString($_POST['nombre']));
		$consulta->setIdAmbulatorio(sanitizarString($_POST['idAmbulatorio']));

		
		if ($consulta->guardar()) {
			$respuesta['exito'] = 1;
			$respuesta['mensaje'] = 'Los datos de la consulta se han guardado correctamente';
		} else {
			$respuesta['exito'] = 0;
			$respuesta['mensaje'] = 'Ha ocurrido algún error al tratar de guardar los datos de la consulta';
		}
		break;
}

ob_clean();
echo json_encode($respuesta);
?>