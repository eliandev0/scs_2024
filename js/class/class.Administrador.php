<?php

require_once __DIR__ . '/../config/config.global.php';
require_once __DIR__ . '/../class/class.DBHandler.php';
require_once __DIR__ . '/../functions/funciones.globales.php';
require_once __DIR__ . '/../class/class.Usuario.php';

class Administrador extends Usuario {
    protected string $areaTrabajo = "";

    public function __construct($id = 0, $email = "") {
        parent::__construct($id,$email);
    }

    public function getAreaTrabajo(): string {
        return sanitizarString($this->areaTrabajo);
    }

    public function setAreaTrabajo(string $areaTrabajo): void {
        $this->areaTrabajo = sanitizarString($areaTrabajo);
    }
}

/*
$usuario = new Administrador();
$usuario->setNombre('JUAN');
$usuario->setApellido1('GARCÍA');
$usuario->setApellido2('VELÁZQUEZ');
$usuario->setEmail('jgarcia@scs.es');
$usuario->setPassword('Probando1234%');
$usuario->setRol('ADMINISTRADOR');
$usuario->setTelefono('+34600202020');
$usuario->setAreaTrabajo('Administración de Sistemas');
$usuario->guardar();
*/
?>
