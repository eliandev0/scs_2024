<?php
require_once __DIR__ . '/../config/config.global.php';
require_once __DIR__ . '/../class/class.DBHandler.php';
require_once __DIR__ . '/../functions/funciones.globales.php';

class Consulta {
    protected int $id = 0;
    protected string $nombre = "";
    protected int $idAmbulatorio = 0;

    
    public function __construct($id = 0) {
        if ($id != 0) {
            // Consultamos los datos por id en la BD
            $gestorDB = new DBHandler();
            $registros = $gestorDB->getRegistros(TABLAS_DB_SCS[static::class], ['*'], 'id = :id', [':id' => $id], null, 'FETCH_ASSOC');
            foreach ($registros as $registro) {
                foreach ($registro as $campo => $valor) {
                    $this->$campo = $valor;
                }
            }
            return true;
        }
        return false;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getNombre() {
        return sanitizarString($this->nombre);
    }
    
    public function setNombre($nombre): void {
        $this->nombre = sanitizarString($nombre);
    }
    
    public function getIdAmbulatorio() {
        return ($this->idAmbulatorio);
    }
    
    public function setIdAmbulatorio($idAmbulatorio): void {
        $this->idAmbulatorio = ($idAmbulatorio);
    }
  
    
    public function guardar() {
        $gestorDB = new DBHandler();
        
        if ($this->nombre == "" || $this->idAmbulatorio == 0) {
            return false;
        }
        
        if ($this->id != 0) {
            // Hay que hacer un UPDATE
            $clavesPrimarias = array('id' => $this->id);
            $resultado = $gestorDB->updateRegistro(TABLAS_DB_SCS[static::class],get_object_vars($this),$clavesPrimarias);
            return $resultado;
        } else {
            // Hay que hacer un INSERT
            $resultado = $gestorDB->addRegistro(TABLAS_DB_SCS[static::class],get_object_vars($this),['id']);
            if ($resultado == false) {
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
        $resultado = $gestorDB->deleteRegistro(TABLAS_DB_SCS[static::class],$clavesPrimarias);
        return $resultado;
    }
}
/*
$ambulatorio = new Ambulatorio();
$ambulatorio->setNombre('Canalejas');
$ambulatorio->setDireccion('Luis Doreste Silva');
$ambulatorio->setTelefono('+34662545439');
$ambulatorio->guardar();
*/
?>