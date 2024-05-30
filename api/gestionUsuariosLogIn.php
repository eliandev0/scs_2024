<?php
require_once(__DIR__.'/../config/config.global.php');
require_once(__DIR__.'/../functions/funciones.globales.php');
require_once(__DIR__.'/../class/class.ManejoSesion.php');
require_once(__DIR__.'/../class/class.Administrador.php');

global $CONFIG_GLOBAL;

if (!isset($_POST['tarea'])) {
    exit;
}

$respuesta['exito'] = 0;
$respuesta['mensaje'] = 'Ha ocurrido algún error';

$tarea = sanitizarString($_POST['tarea']);
switch($tarea) {
    case 'verificarLogIn':
        $email = sanitizarString($_POST['email']);
        if (!checkEmail(($email))) {
            $respuesta['exito'] = 0;
            $respuesta['mensaje'] = 'Usuario/Contraseña incorrectos';
            break;
        }
        $password = sanitizarString($_POST['password']);
        $usuario = new Administrador(0,$email);

        if ($usuario->getEmail() != $email) {
            $respuesta['exito'] = 0;
            $respuesta['mensaje'] = 'Usuario/Contraseña incorrectos';
            break;
        }

        if ($usuario->getBloqueado() == 1) {
            $respuesta['exito'] = 0;
            $respuesta['mensaje'] = 'Su usuario está bloqueado';
            break;
        }

        if ($usuario->verificarPassword($password)) {
            // Usuario identificado correctamente
            // Creamos la sesión y cargamos los datos
            $sesion = new ManejoSesion();
            $sesion->start(NOMBRE_SESION_SCS);
            $sesion->write('id_usuario', $usuario->getId());
            $sesion->write('nombre', $usuario->getNombre());
            $sesion->write('apellido1', $usuario->getApellido1());
            $sesion->write('apellido2', $usuario->getApellido2());
            $sesion->write('email', $usuario->getEmail());
            $sesion->write('ip_usuario', obtenerIpUsuario());
            $sesion->write('rol_usuario', $usuario->getRol());

            $usuario->setNumeroIntentosFallidos(0);
            $usuario->setIpUltimoAcceso(obtenerIpUsuario());
            $usuario->setFechaHoraUltimoAcceso(date('Y-m-d H:i:s'));
            $usuario->guardar();

            $respuesta['exito'] = 1;
        } else {
            // Login fallido
            $usuario->setNumeroIntentosFallidos($usuario->getNumeroIntentosFallidos() + 1);
            if ($usuario->getNumeroIntentosFallidos() >= MAXIMO_NUMERO_INTENTOS_FALLIDOS) {
                $usuario->setBloqueado(1);
            }
            $usuario->guardar();
            $respuesta['exito'] = 0;
            $respuesta['mensaje'] = 'Usuario/Contraseña incorrectos';
        }
        break;
		
	case 'generarPasswordOlvidada':
		# El rol lo conoceré bien por la página diferenciada de acceso (una página para enfermeros, otra para médicos...)
		# O bien porque utilizo un desplegable donde el usuario selecciona el rol de usuario que es		
		$emailUsuario = $_POST['email'];
		$usuario = new Administrador(0,$emailUsuario);
		if ($usuario->getEmail() == $emailUsuario) {
			$usuario->setTokenPasswordOlvidada(generalToken(30));
			$usuario->guardar();
			
			require_once __DIR__.'/../class/function.email.php';
			$destinatario = ['email' => $usuario->getEmail(), 'nombre' => $usuario->getNombre().' '.$usuario->getApellido1()];
			$asunto = 'RECUPERAR SU CONTRASEÑA';
			$cuerpo = 'Estimado usuario,<br/>
					A raíz de su solicitud para recuperar la contraseña, le adjuntamos un enlace en el que podrá escribir
					una contraseña nueva:
					'.$CONFIG_GLOBAL['rutaURLBase'].'/recuperarPassword.php?token='.$usuario->getTokenPasswordOlvidada().'
					Un saludo,        
					';
			enviarEmail($destinatario,$asunto,$cuerpo);
		}
		$respuesta['exito'] = 1;
		$respuesta['mensaje'] = 'Si ha proporcionado unos datos correctos, deberá recibir en breve un email con los pasos
		a seguir para modificar su contraseña. Revise su carpeta SPAM.';
		break;
		
	case 'cambiarPasswordConToken':
		#Habrá que cargar la clase según el rol del usuario
		$usuario = new Administrador(0, $_POST['email']);
		if ($usuario->getEmail() == $_POST['email']) {
			if ($usuario->getTokenPasswordOlvidada() == $_POST['token']) {
				#Cambiamos la contraseña. Obviamos ahora mismo todos los checks de seguridad como
				#tamaño, que incluya letras, números etc.
				$usuario->setPassword($_POST['password1']);
				if ($usuario->guardar()) {
					$respuesta['exito'] = 1;
					$respuesta['mensaje'] = 'Su contraseña ha sido modificada. Ya puede acceder.';
				} else {
					$respuesta['exito'] = 0;
					$respuesta['mensaje'] = 'Ha ocurrido algún error al intentar modificar la contraseña';
				}
			} else {
				$respuesta['exito'] = 0;
				$respuesta['mensaje'] = 'Ha ocurrido algún error.';
			}
		} else {
			$respuesta['exito'] = 0;
			$respuesta['mensaje'] = 'Ha ocurrido algún error.';
		}
		break;
}

ob_clean();
echo json_encode($respuesta);
?>