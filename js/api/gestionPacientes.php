<?php
require_once __DIR__."/comprobarLogIn.php";
require_once(__DIR__.'/../class/class.Paciente.php');

if (!isset($_POST['tarea'])) {
    exit;
}

$respuesta['exito'] = 0;
$respuesta['mensaje'] = 'Ha ocurrido algún error';

$tarea = sanitizarString($_POST['tarea']);
switch($tarea) {
    case 'cargarDatosPaciente':
        $idPaciente = sanitizarString($_POST['id']);
		$paciente = new Paciente($idPaciente);
		if ($paciente->getId() != $idPaciente) {
			$respuesta['exito'] = 0;
			break;
		}
		$datos['inputNombre'] = $paciente->getNombre();
		$datos['inputApellido1'] = $paciente->getApellido1();
		$datos['inputApellido2'] = $paciente->getApellido2();
		$datos['inputEmail'] = $paciente->getEmail();
		$datos['inputTelefono'] = $paciente->getTelefono();
		$datos['idAmbulatorio'] = $paciente->getIdAmbulatorio();
		$datos['idConsulta'] = $paciente->getIdConsulta();

		$respuesta['exito'] = 1;
		$respuesta['mensaje'] = '';
		$respuesta['datos'] = $datos;
		
        break;
		
	case 'guardarDatosPaciente':
		$idPaciente = sanitizarString($_POST['id']);
		$paciente = new Paciente($idPaciente);
		
		$paciente->setNombre(sanitizarString($_POST['nombre']));
		$paciente->setApellido1(sanitizarString($_POST['apellido1']));
		$paciente->setApellido2(sanitizarString($_POST['apellido2']));
		$paciente->setEmail(sanitizarString($_POST['email']));
		$paciente->setTelefono(sanitizarString($_POST['telefono']));
		$paciente->setRol('PACIENTE');
		$paciente->setIdAmbulatorio(intval(sanitizarString($_POST['idAmbulatorio'])));
		
		// ---->>> TODO: Generar password aleatoria y mandarla por email
		$paciente->setPassword('PorDefecto1234');
		
		if ($paciente->guardar()) {
			$respuesta['exito'] = 1;
			$respuesta['mensaje'] = 'Los datos del paciente se han guardado correctamente';
		} else {
			$respuesta['exito'] = 0;
			$respuesta['mensaje'] = 'Ha ocurrido algún error al tratar de guardar los datos del paciente';
		}
		break;
}

ob_clean();
echo json_encode($respuesta);
?>