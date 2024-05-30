<?php
require_once __DIR__."/comprobarLogIn.php";
require_once(__DIR__.'/../class/class.Enfermero.php');

if (!isset($_POST['tarea'])) {
    exit;
}

$respuesta['exito'] = 0;
$respuesta['mensaje'] = 'Ha ocurrido algún error';

$tarea = sanitizarString($_POST['tarea']);
switch($tarea) {
    case 'cargarDatosEnfermero':
        $idEnfermero = sanitizarString($_POST['id']);
		$enfermero = new Enfermero($idEnfermero);
		if ($enfermero->getId() != $idEnfermero) {
			$respuesta['exito'] = 0;
			break;
		}
		$datos['inputNumeroColegiado'] = $enfermero->getNumeroColegiado();
		$datos['inputNombre'] = $enfermero->getNombre();
		$datos['inputApellido1'] = $enfermero->getApellido1();
		$datos['inputApellido2'] = $enfermero->getApellido2();
		$datos['inputEmail'] = $enfermero->getEmail();
		$datos['inputTelefono'] = $enfermero->getTelefono();
		$datos['idAmbulatorio'] = $enfermero->getIdAmbulatorio();
		$datos['idConsulta'] = $enfermero->getIdConsulta();

		$respuesta['exito'] = 1;
		$respuesta['mensaje'] = '';
		$respuesta['datos'] = $datos;
		
        break;
		
	case 'guardarDatosEnfermero':
		$idEnfermero = sanitizarString($_POST['id']);
		$enfermero = new Enfermero($idEnfermero);
		
		$enfermero->setNumeroColegiado(sanitizarString($_POST['numeroColegiado']));
		$enfermero->setNombre(sanitizarString($_POST['nombre']));
		$enfermero->setApellido1(sanitizarString($_POST['apellido1']));
		$enfermero->setApellido2(sanitizarString($_POST['apellido2']));
		$enfermero->setEmail(sanitizarString($_POST['email']));
		$enfermero->setTelefono(sanitizarString($_POST['telefono']));
		$enfermero->setRol('ENFERMERO');
		$enfermero->setIdAmbulatorio(intval(sanitizarString($_POST['idAmbulatorio'])));
		// ---->>> TODO: Generar password aleatoria y mandarla por email
		$enfermero->setPassword('PorDefecto1234');
		
		if ($enfermero->guardar()) {
			$respuesta['exito'] = 1;
			$respuesta['mensaje'] = 'Los datos del enfermero se han guardado correctamente';
		} else {
			$respuesta['exito'] = 0;
			$respuesta['mensaje'] = 'Ha ocurrido algún error al tratar de guardar los datos del enfermero';
		}
		break;
}

ob_clean();
echo json_encode($respuesta);
?>