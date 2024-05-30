<?php
require_once __DIR__."/comprobarLogIn.php";
//require_once(__DIR__.'/../class/class.Administrador.php');

if (!isset($_POST['tarea'])) {
    exit;
}

global $sesion;

$respuesta['exito'] = 0;
$respuesta['mensaje'] = 'Ha ocurrido algún error';

$tarea = depurarString($_POST['tarea']);
switch($tarea) {
    case 'cambioPasswordUsuario':
        $rolUsuario = $sesion->read('rol_usuario');
        switch($rolUsuario) {
            case 'ADMINISTRADOR':
                require_once(__DIR__.'/../class/class.Administrador.php');
                $usuario = new Administrador($sesion->read('id_usuario'));
                break;
            case 'MÉDICO':
                require_once(__DIR__.'/../class/class.Medico.php');
                $usuario = new Medico($sesion->read('id_usuario'));
                break;
            case 'ENFERMERO':
                require_once(__DIR__.'/../class/class.Enfermero.php');
                $usuario = new Enfermero($sesion->read('id_usuario'));
                break;
            case 'PACIENTE':
                require_once(__DIR__.'/../class/class.Paciente.php');
                $usuario = new Paciente($sesion->read('id_usuario'));
                break;
            default:
                $usuario = false;
                break;
        }

        if ($usuario === false || $usuario->getRol() != $rolUsuario) {
            $respuesta['exito'] = 0;
            $respuesta['mensaje'] = 'Error con la integridad de los datos';
            break;
        }

        if (!$usuario->verificarPassword(depurarStringPassword($_POST['passwordActual']))) {
            $respuesta['exito'] = 0;
            $respuesta['mensaje'] = 'Contraseña incorrecta';
            # Habría que aumentar el número de intentos fallidos
            break;
        }

        if (depurarStringPassword($_POST['passwordNueva1']) != depurarStringPassword($_POST['passwordNueva2'])) {
            $respuesta['exito'] = 0;
            $respuesta['mensaje'] = 'Las contraseñas no coinciden';
            break;
        }

        # Faltaría comprobar que la contraseña es robusta (mayúscula, minúscula, número)
        # Faltaría comprobar máximo de caracteres y mínimo de caracteres

        $usuario->setPassword(depurarStringPassword($_POST['passwordNueva1']));

        if ($usuario->guardar()) {
            $respuesta['exito'] = 1;
            $respuesta['mensaje'] = 'La contraseña fue modificada';

            require_once __DIR__.'/../class/function.email.php';
            $destinatario = ['email' => $sesion->read('email'), 'nombre' => $sesion->read('nombre').' '.$sesion->read('apellido1')];
            $asunto = 'SU CONTRASEÑA HA SIDO MODIFICADA';
            $cuerpo = 'Estimado usuario,<br/>
                    Queremos comunicarle que su contraseña ha sido modificada correctamente. Si ha sido usted quien ha realizado el cambio, puede ignorar este correo. En caso contrario,
                    deberá ponerse en contacto con nosotros lo antes posible.<br/>
                    Un saludo,        
                    ';
            enviarEmail($destinatario,$asunto,$cuerpo);
            # Aunque no es objeto de las asignaturas de Programación ni Lenguajes de Marcas, habría que gestionar los posibles errores en el envío
        } else {
            $respuesta['exito'] = 0;
            $respuesta['mensaje'] = 'Error al modificar la contraseña';
        }

        break;
}

ob_clean();
echo json_encode($respuesta);
?>