<?php
require_once __DIR__.'/../config/config.global.php';
require_once __DIR__.'/class.DBHandler.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__.'/../librerias/phpmailer/vendor/autoload.php';

const CORREO_HOST = 'smtp.gmail.com';
const CORREO_USERNAME = 'dws.cipformacion@gmail.com';
const CORREO_PASSWORD = PASSWORD_EMAIL;
const CORREO_PORT = 465;
const CORREO_REMITENTE_EMAIL = 'dws.cipformacion@gmail.com';
const CORREO_REMITENTE_NOMBRE = 'CIP - Pruebas Aplicación PHP';
const CORREO_RESPONDER_A_EMAIL = 'dws.cipformacion@gmail.com';
const CORREO_RESPONDER_A_NOMBRE = 'CIP - Pruebas Aplicación PHP';

class Email {
    protected int $id = 0;
    protected int $idUsuario = 0;
    protected string|null $fechaCreacion = NULL;

    protected int $enviarYa = 0;
    protected int $enviado = 0;
    protected string|null $fechaEnvio = NULL;
    protected int $erroresEnvio = 0;
    protected string $textoErroresEnvio = "";

    protected string $responderA = "";
    protected string $asuntoMensaje = "";
    protected string $textoMensaje = "";

    protected string $emailDestinatarios = "";


    public function __construct($id = 0, $codigo = null) {
        if ($id != 0) {
            // Consultamos los datos por id en la BD
            $gestorDB = new DBHandler();
            $registros = $gestorDB->getRegistros(TABLA_MENSAJES,['*'],'id = :id', [':id' => $id],NULL,'FETCH_ASSOC');
            foreach ($registros as $registro) {
                foreach ($registro as $campo => $valor) {
                    $this->$campo = $valor;
                }
            }
        }
        return true;
    }

    public function getId(): int {
        return $this->id;
    }


    public function getIdUsuario(): int {
        return $this->idUsuario;
    }

    public function setIdUsuario(int $idUsuario): void {
        $this->idUsuario = $idUsuario;
    }

    public function getFechaCreacion(bool $formateada = false, bool $sinHora = false): string {
        if ($formateada) {
            if ($sinHora) {
                return date('d/m/Y', strtotime($this->fechaCreacion));
            }
            return date('d/m/Y H:i:s', strtotime($this->fechaCreacion));
        }
        return sanitizarString($this->fechaCreacion);
    }

    public function setFechaCreacion(string $fecha): bool {
        $fecha = sanitizarString($fecha);
        if (DateTime::createFromFormat('Y-m-d H:i:s', $fecha) !== false) {
            $this->fechaCreacion = $fecha;
            return true;
        }
        return false;
    }

    public function getFechaEnvio(bool $formateada = false, bool $sinHora = false): string | null {
        if ($formateada) {
            if ($sinHora) {
                return date('d/m/Y', strtotime($this->fechaEnvio));
            }
            return date('d/m/Y H:i:s', strtotime($this->fechaEnvio));
        }
        return sanitizarString($this->fechaEnvio);
    }

    public function setFechaEnvio(string | null $fecha): bool {
        $fecha = sanitizarString($fecha);
        if (DateTime::createFromFormat('Y-m-d H:i:s', $fecha) !== false) {
            $this->fechaCreacion = $fecha;
            return true;
        }
        return false;
    }


    public function getEnviarYa(): int {
        return $this->enviarYa;
    }

    public function setEnviarYa(int $enviarYa) : void {
        $this->enviarYa = $enviarYa;
    }

    public function getEnviado(): int {
        return $this->enviado;
    }

    public function setEnviado(int $enviado) : void {
        $this->enviado = $enviado;
    }

    public function getErroresEnvio(): int {
        return $this->erroresEnvio;
    }

    public function setErroresEnvio(int $erroresEnvio) : void {
        $this->erroresEnvio = $erroresEnvio;
    }

    public function getTextoErroresEnvio(): string {
        return $this->textoErroresEnvio;
    }

    public function setTextoErroresEnvio(string $texto): void {
        $this->textoErroresEnvio = $texto;
    }

    public function getResponderA(): string {
        return $this->responderA;
    }

    public function setResponderA(string $responderA): void {
        $this->responderA = $responderA;
    }

    public function getAsuntoMensaje(): string {
        return $this->asuntoMensaje;
    }

    public function setAsuntoMensaje(string $asuntoMensaje): void {
        $this->asuntoMensaje = $asuntoMensaje;
    }

    public function getTextoMensaje(): string {
        return $this->textoMensaje;
    }

    public function setTextoMensaje(string $textoMensaje): void {
        $this->textoMensaje = $textoMensaje;
    }

    public function getEmailDestinatarios(): array {
        return json_decode($this->emailDestinatarios, true) ?? [];
    }

    public function setEmailDestinatarios(array $emailDestinatarios): void {
        $this->emailDestinatarios = json_encode($emailDestinatarios);
    }


    public function guardar(): bool {
        $gestorDB = new DBHandler();

        if ($this->id != 0) {
            // Hay que hacer un UPDATE
            $clavesPrimarias = array('id' => $this->id);
            $resultado = $gestorDB->updateRegistro(TABLA_MENSAJES,get_object_vars($this),$clavesPrimarias);
            if ($resultado) {
                return true;
            } else {
                return false;
            }
        } else {
            // Hay que hacer un INSERT
            $resultado = $gestorDB->addRegistro(TABLA_MENSAJES,get_object_vars($this),['id']);
            if (!$resultado) {
                return false;
            } else {
                $this->id = $resultado;
                return true;
            }
        }
    }

    public function eliminar(): bool {
        $gestorDB = new DBHandler();
        $clavesPrimarias = array('id' => $this->id);
        return $gestorDB->deleteRegistro(TABLA_MENSAJES,$clavesPrimarias);
    }


    public function getAtributos(): array {
        return get_object_vars($this);
    }

    public function enviar($forzarEnvio = false): bool {
        if ($forzarEnvio === false) {
            if ($this->getEnviado()) {
                return false;
            }
        }

        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';

        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = CORREO_HOST;                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = CORREO_USERNAME;                     //SMTP username
            $mail->Password   = CORREO_PASSWORD;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = CORREO_PORT;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            // Remitente
            $mail->setFrom(CORREO_REMITENTE_EMAIL, CORREO_REMITENTE_NOMBRE);
            // Responder a...
            $mail->addReplyTo(CORREO_RESPONDER_A_EMAIL, CORREO_RESPONDER_A_NOMBRE);

            // Destinatarios CCO
            foreach($this->getEmailDestinatarios() as $destinatarioCCO) {
                $mail->addBCC($destinatarioCCO);     //Add a recipient
            }

            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            // Contenido
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $this->asuntoMensaje;
            $mail->Body    = $this->textoMensaje.'<br><br>--<br>'.CORREO_RESPONDER_A_NOMBRE.'<br>'.CORREO_RESPONDER_A_EMAIL;
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();

            $this->enviado = 1;
            $this->erroresEnvio = 0;
            $this->textoErroresEnvio = "";
            $this->fechaEnvio = date('Y-m-d H:i:s');

            $this->guardar();

            return true;
        } catch (Exception $e) {
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            $this->enviado = 0;
            $this->erroresEnvio = 1;
            $this->textoErroresEnvio = $mail->ErrorInfo;
            $this->fechaEnvio = date('Y-m-d H:i:s');

            $this->guardar();
            return false;
        }
    }
}

/*
$mensaje = new Email();
$mensaje->setAsuntoMensaje('Probando');
$mensaje->setTextoMensaje('Esto es una prueba');
$mensaje->setEmailDestinatarios(['dws.cipformacion@gmail.com']);
$mensaje->guardar();
*/
?>