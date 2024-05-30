<?php
require_once __DIR__."/comprobarLogIn.php";
require_once(__DIR__.'/../class/class.Medico.php');

if (!isset($_POST['tarea'])) {
    exit;
}

$respuesta['exito'] = 0;
$respuesta['mensaje'] = 'Ha ocurrido algún error';

$tarea = sanitizarString($_POST['tarea']);
switch($tarea) {
    case 'cargarDatosMedico':
        $idMedico = sanitizarString($_POST['id']);
		$medico = new Medico($idMedico);
		if ($medico->getId() != $idMedico) {
			$respuesta['exito'] = 0;
			break;
		}
		$datos['inputNumeroColegiado'] = $medico->getNumeroColegiado();
		$datos['inputNombre'] = $medico->getNombre();
		$datos['inputApellido1'] = $medico->getApellido1();
		$datos['inputApellido2'] = $medico->getApellido2();
		$datos['inputEmail'] = $medico->getEmail();
		$datos['selectEspecialidad'] = $medico->getEspecialidad();
		$datos['inputTelefono'] = $medico->getTelefono();
		$datos['idAmbulatorio'] = $medico->getIdAmbulatorio();
		$datos['idConsulta'] = $medico->getIdConsulta();

		$respuesta['exito'] = 1;
		$respuesta['mensaje'] = '';
		$respuesta['datos'] = $datos;
		
        break;
		
	case 'guardarDatosMedico':
		$idMedico = sanitizarString($_POST['id']);
		$medico = new Medico($idMedico);
		
		$medico->setNumeroColegiado(sanitizarString($_POST['numeroColegiado']));
		$medico->setNombre(sanitizarString($_POST['nombre']));
		$medico->setApellido1(sanitizarString($_POST['apellido1']));
		$medico->setApellido2(sanitizarString($_POST['apellido2']));
		$medico->setEmail(sanitizarString($_POST['email']));
		$medico->setEspecialidad(sanitizarString($_POST['especialidad']));
		$medico->setTelefono(sanitizarString($_POST['telefono']));
		$medico->setRol('MÉDICO');
		$medico->setIdAmbulatorio(intval(sanitizarString($_POST['idAmbulatorio'])));
		
		// ---->>> TODO: Generar password aleatoria y mandarla por email
		$medico->setPassword('PorDefecto1234');
		
		if ($medico->guardar()) {
			$respuesta['exito'] = 1;
			$respuesta['mensaje'] = 'Los datos del médico se han guardado correctamente';
		} else {
			$respuesta['exito'] = 0;
			$respuesta['mensaje'] = 'Ha ocurrido algún error al tratar de guardar los datos del médico';
		}
		break;
}

ob_clean();
echo json_encode($respuesta);
?>