<?php
require_once __DIR__ . '/../config/config.db.php';
require_once __DIR__ . '/../class/class.DBHandler.php';
require_once __DIR__ . '/../functions/funciones.globales.php';

abstract class Usuario {
    protected int $id = 0;
    protected string $nombre = "";
    protected string $apellido1 = "";
    protected string $apellido2 = "";
    protected string $email = "";
    protected string $password = "";
    protected string $rol = "";
    protected string $telefono = "";
    protected string $ipUltimoAcceso = "";
    protected string | null $fechaHoraUltimoAcceso = null;
    protected int $numeroIntentosFallidos = 0;
	protected string $tokenPasswordOlvidada = "";
    protected int $bloqueado = 0;

    public function __construct(int $id = 0, string $email = "") {
        if ($id != 0) {
            // Consultamos los datos por id en la BD
            $gestorDB = new DBHandler();
            $registros = $gestorDB->getRegistros(TABLAS_DB_SCS[static::class], ['*'], 'id = :id', [':id' => $id], '', 'FETCH_ASSOC');
            foreach ($registros as $registro) {
                foreach ($registro as $campo => $valor) {
                    $this->$campo = $valor;
                }
            }
            return true;
        } else {
            if ($email != "") {
                $email = sanitizarString($email);
                // Consultamos los datos por email en la BD
                $gestorDB = new DBHandler();
                $registros = $gestorDB->getRegistros(TABLAS_DB_SCS[static::class], ['*'], 'email = :email', [':email' => $email], '', 'FETCH_ASSOC');
                foreach ($registros as $registro) {
                    foreach ($registro as $campo => $valor) {
                        $this->$campo = $valor;
                    }
                }
                return true;
            }
        }
        return false;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getNombre(): string {
        return sanitizarString($this->nombre);
    }

    public function setNombre($nombre): void {
        $this->nombre = sanitizarString($nombre);
    }

    public function getApellido1(): string {
        return sanitizarString($this->apellido1);
    }

    public function setApellido1($apellido1): void {
        $this->apellido1 = sanitizarString($apellido1);
    }

    public function getApellido2(): string {
        return sanitizarString($this->apellido2);
    }

    public function setApellido2($apellido2): void {
        $this->apellido2 = sanitizarString($apellido2);
    }

    public function getRol(): string {
        return sanitizarString($this->rol);
    }

    public function setRol(string $rol): bool {
        if (in_array($rol, ROLES_GLOBALES)) {
            $this->rol = $rol;
            return true;
        }
        return false;
    }

    public function getIpUltimoAcceso(): string {
        return sanitizarString($this->ipUltimoAcceso);
    }

    public function setIpUltimoAcceso(string $ipUltimoAcceso): void {
        $this->ipUltimoAcceso = $ipUltimoAcceso;
    }

    public function getFechaHoraUltimoAcceso(): string | null {
        return $this->fechaHoraUltimoAcceso;
    }

    public function setFechaHoraUltimoAcceso(string | null $fechaHoraUltimoAcceso): void {
        $this->fechaHoraUltimoAcceso = $fechaHoraUltimoAcceso;
    }

    public function getNumeroIntentosFallidos(): int {
        return $this->numeroIntentosFallidos;
    }

    public function setNumeroIntentosFallidos(int $numeroIntentosFallidos): void {
        $this->numeroIntentosFallidos = $numeroIntentosFallidos;
    }
	
	public function getTokenPasswordOlvidada(): string {
        return $this->tokenPasswordOlvidada;
    }

    public function setTokenPasswordOlvidada(string $tokenPasswordOlvidada): void {
        $this->tokenPasswordOlvidada = $tokenPasswordOlvidada;
    }

    public function getBloqueado(bool $formateado = false): int | string {
		if ($formateado) {
			return $this->bloqueado == 1 ? "SÍ" : "NO";
		}
        return $this->bloqueado;
    }

    public function setBloqueado(int $bloqueado): void {
        $this->bloqueado = $bloqueado;
    }

    public function setEmail($email): bool {
        $email = sanitizarString($email);
        if (checkEmail($email)) {
            $this->email = $email;
            return true;
        }
        return false;
    }

    public function getTelefono(): string {
        return sanitizarString($this->telefono);
    }

    public function setTelefono(string $telefono): void {
        $telefono = sanitizarString($telefono);
        $this->telefono = $telefono;
    }

    public function getEmail(): string {
        return sanitizarString($this->email);
    }


    public function setPassword(string $passwordSinCifrar): void {
        $passwordSinCifrar = sanitizarStringPassword($passwordSinCifrar);
        $this->password = password_hash($passwordSinCifrar, PASSWORD_BCRYPT);
    }

    public function verificarPassword($passwordAVerificar): bool {
        if (strlen($passwordAVerificar) <= 0) {
            return false;
        }
        return password_verify($passwordAVerificar, $this->password);
    }


    public function guardar(): bool {
        $gestorDB = new DBHandler();

        if ($this->email == "" || $this->nombre == "" || $this->apellido1 == "" || $this->password == "") {			
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
        return $gestorDB->deleteRegistro(TABLAS_DB_SCS[static::class],$clavesPrimarias);
    }
}
?>
