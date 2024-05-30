<?php
require_once __DIR__ . '/../config/config.global.php';
require_once __DIR__ . '/../class/class.DBHandler.php';
require_once __DIR__ . '/../functions/funciones.globales.php';
require_once __DIR__ . '/../class/class.Usuario.php';

class Medico extends Usuario {
    protected string $especialidad = "";
    protected int $numeroColegiado = 0;
    protected int $idAmbulatorio = 0;
    protected int $idConsulta = 0;

    public function __construct($id = 0, $email = "") {
        parent::__construct($id,$email);
    }

    public function getEspecialidad(): string {
        return sanitizarString($this->especialidad);
    }

    public function setEspecialidad(string $especialidad): void {
        $this->especialidad = sanitizarString($especialidad);
    }

    public function getNumeroColegiado(): int {
        return $this->numeroColegiado;
    }

    public function setNumeroColegiado(int $numeroColegiado): void {
        $this->numeroColegiado = $numeroColegiado;
    }

    public function getIdConsulta(): int {
        return $this->idConsulta;
    }

    public function setIdConsulta(int $idConsulta): void {
        $this->idConsulta = $idConsulta;
    }

    public function getIdAmbulatorio(): int {
        return $this->idAmbulatorio;
    }

    public function setIdAmbulatorio(int $idAmbulatorio): void {
        $this->idAmbulatorio = $idAmbulatorio;
    }

    public function guardar() : bool{
        if ($this->especialidad == "" || $this->numeroColegiado == 0) {
            return false;
        }
        return parent::guardar();
    }
}
/*
$usuario = new Medico();
echo ($usuario->getIdAmbulatorio());
*/
/*
$nombres = array("Pedro", "Juan", "Ricardo", "José", "Julián", "Jaime", "Rosa", "Marta", "Ana", "Laura");
$apellidos = array("Cruz", "García", "Rodríguez", "Armas", "Álvarez", "Hernández", "Gutiérrez", "Herrera", "Vargas", "Zurita");
$especialidad = array('MEDICINA FAMILIAR', 'PEDIATRÍA', 'UROLOGÍA');


for ($i = 0; $i < 30; $i++) {
	$usuario = new Medico();
	$usuario->setNombre($nombres[random_int(0, 9)]);
	$usuario->setApellido1($apellidos[random_int(0, 9)]);
	$usuario->setApellido2($apellidos[random_int(0, 9)]);
	$usuario->setEmail('medico_'.$i.'@sanidad.com');
	$usuario->setPassword('Probando1234%');
	$usuario->setRol('MÉDICO');
	$usuario->setTelefono('+346001010'.$i);
	$usuario->setEspecialidad($especialidad[random_int(0, 2)]);
	$usuario->setNumeroColegiado('381234'.$i);
	$usuario->guardar();
}
*/
?>
