<?php

require_once __DIR__."/../config/config.db.php";

class DBHandler {
    private const DB_HOST = 'localhost';
    private const DB_NAME = 'scs_2024';
    private const DB_USER = 'root';
    private const DB_PASSWORD = '';

    public PDO $dbh;
    public string $ultimaConsulta = "";
    public string $error = "";

    /*************************************************************************************************
     * Constructor: Crea el objeto y realiza la conexión con la DB a partir de los parámetros de la
     *  propia clase
     *************************************************************************************************/
    public function __construct() {
        try {
            $dsn = "mysql:host=".DBHandler::DB_HOST.";dbname=".DBHandler::DB_NAME;
            $this->dbh = new PDO($dsn, DBHandler::DB_USER, DBHandler::DB_PASSWORD);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dbh->exec("set names utf8");
        } catch (PDOException $e) {
            $mensajeLog = date('Y-m-d H:i:s') . ": Error Conexión: ".$e->getMessage();
            file_put_contents(FICHERO_DB_LOG, $mensajeLog.PHP_EOL.PHP_EOL, FILE_APPEND);
            $this->error = $e->getMessage();
        }
    }


    /*************************************************************************************************
     * Obtiene los registros de una única tabla pasando como parámetros:
     * $tabla => Nombre de la tabla sobre la que se va a hacer la consulta
     * $columnas => Nombre de las columnas que se necesitan en los resultados de la consulta
     * $clausulaWhere => string con la cláusula where
     * $parametrosWhere => array con los distintos parámetros del where y sus valores
     * $orden => string con el orden en que deben aparecer los datos
     * $tipoFetch => string con el tipo de arreglo para presentar los datos (FETCH_ASSOC, FETCH_OBJETC,...)
     *************************************************************************************************/
    public function getRegistros(string $tabla, array $columnas, string $clausulaWhere, array $parametrosWhere, string $orden, string $tipoFetch): array | false {
        $columnasSelect = implode(",", $columnas);
        $consultaSqlTxt = "SELECT ".$columnasSelect." FROM ".$tabla;

        if ($clausulaWhere != "") {
            $consultaSqlTxt .= ' WHERE '.$clausulaWhere;
        }

        if ($orden != "") {
            $consultaSqlTxt .= ' ORDER BY '.$orden;
        }

        $this->ultimaConsulta = $consultaSqlTxt;

        try {
            $consultaSql = $this->dbh->prepare($consultaSqlTxt);
            foreach($parametrosWhere as $parametro => $valor) {
                $consultaSql->bindValue($parametro, $valor);
            }
            $consultaSql->execute();
            return $consultaSql->fetchAll(constant('PDO::'.$tipoFetch));
        } catch (PDOException $e) {
            $mensajeLog = date('Y-m-d H:i:s').": ".$e->getMessage();
            file_put_contents(FICHERO_DB_LOG, $mensajeLog.PHP_EOL.$this->ultimaConsulta.PHP_EOL.PHP_EOL, FILE_APPEND);
            $this->error = $e->getMessage();
            return false;
        }

    }


    /***********************************************************************************************
     * addRegistro
     * Inserta un registro en la base de datos. Es, por tanto, adecuado para inserciones de pocos registros.
     * En caso de que se quieran insertar varios se debe utilizar el handler ($this->dbh) y prepara la consulta
     * para hacer múltiples inserciones.
     *
     * - String $tabla: nombre la tabla sobre la que aplicar la consulta
     * - Array $datos: campos a insertar. Ejemplo: ["nombre" => "Juan", "edad" => 27,...]
     * - Array $valoresAutonumerico: Podemos indicar los valores autonuméricos de la tabla para evitar que haya
     *                               problemas con la inserción. Ejemplo: ["id"]
     * Devuelve el id del último registro insertado en el caso de que la consulta se haya podido ejecutar
     * Devuelve false si no se pudo ejecutar la consulta y guarda el error en el log
     ***********************************************************************************************/
    public function addRegistro(string $tabla, array $datos, array $valoresAutonumerico = null): int | false {
        $arrayConsultaParametros = array();
        $arrayConsultaParametrosPDO = array();
        $arrayConsultaValores = array();

        // Cargamos en un array todos los campos a insertar
        foreach($datos as $campo => $valor) {
            if (!in_array($campo, $valoresAutonumerico)) {
                $arrayConsultaParametros[] = $campo;
                $arrayConsultaParametrosPDO[] = ':'.$campo;
                $arrayConsultaValores[$campo] = $valor;
            }
        }

        // Preparamos la consulta
        $sqlParametros = implode(",",$arrayConsultaParametros);
        $sqlParametrosPDO = implode(",",$arrayConsultaParametrosPDO);
        $consultaSql = "INSERT INTO {$tabla} ({$sqlParametros}) VALUES ({$sqlParametrosPDO})";

        $this->ultimaConsulta = $consultaSql;

        try {
            $this->dbh->prepare($consultaSql)->execute($arrayConsultaValores);
            return $this->dbh->lastInsertId();
        } catch (PDOException $e) {
            $mensajeLog = date('Y-m-d H:i:s') . ": " . $e->getMessage();
            file_put_contents(FICHERO_DB_LOG, $mensajeLog.PHP_EOL.$this->ultimaConsulta.PHP_EOL.PHP_EOL, FILE_APPEND);
            $this->error = $e->getMessage();
            return false;
        }
    }


    /***********************************************************************************************
     * updateRegistro
     * Actualiza un registro de la base de datos a partir de una clave primaria (que puede ser compuesta)
     *
     * - String $tabla: nombre la tabla sobre la que aplicar la consulta
     * - Array $datos: campos a actualizar. Ejemplo: ["nombre" => "Juan", "edad" => 27,...]
     * - Array $clavesPrimarias: Ejemplo: ["dni" => 12345678W, "email" => "pepe@gmail.com",...]
     * Devuelve true en el caso de que la consulta se haya podido ejecutar
     * Devuelve false si no se pudo ejecutar la consulta y guarda el error en el log
     ***********************************************************************************************/
    public function updateRegistro(string $tabla, array $datos, array $clavesPrimarias): bool {
        $arrayConsultaParametrosPDO = array();
        $arrayConsultaValores = array();

        // Cargamos en un array todos los campos a actualizar
        foreach($datos as $campo => $valor) {
            if (!in_array($campo, $clavesPrimarias)) {
                $arrayConsultaParametrosPDO[] = $campo.'=:'.$campo;
                $arrayConsultaValores[$campo] = $valor;
            }
        }

        // Cargamos los parámetros de la cláusula WHERE
        $arrayParametrosWhere = array();
        foreach($clavesPrimarias as $campo => $valor) {
            if (is_string($valor)) {
                $arrayParametrosWhere[] = $campo.'="'.$valor.'"';
            } else {
                $arrayParametrosWhere[] = $campo.'='.$valor;
            }
        }

        // Preparamos la consulta
        $sqlParametrosPDO = implode(",",$arrayConsultaParametrosPDO);
        $sqlParametrosWhere = implode(" AND ",$arrayParametrosWhere);
        $consultaSql = "UPDATE {$tabla} SET {$sqlParametrosPDO} WHERE {$sqlParametrosWhere}";

        $this->ultimaConsulta = $consultaSql;

        try {
            $this->dbh->prepare($consultaSql)->execute($arrayConsultaValores);
            return true;
        } catch (PDOException $e) {
            $mensajeLog = date('Y-m-d H:i:s').": ".$e->getMessage();
            file_put_contents(FICHERO_DB_LOG, $mensajeLog.PHP_EOL.$this->ultimaConsulta.PHP_EOL.PHP_EOL, FILE_APPEND);
            $this->error = $e->getMessage();
            return false;
        }
    }

    /***********************************************************************************************
     * deleteRegistro
     * Elimina un registro de una tabla especificando la clave primaria (puede ser compuesta)
     *
     * - String $tabla: nombre la tabla sobre la que aplicar la consulta
     * - Array $clavesPrimarias: Ejemplo: ["dni" => 12345678W, "email" => "pepe@gmail.com",...]
     * Devuelve true en el caso de que la consulta se haya podido ejecutar
     * Devuelve false si no se pudo ejecutar la consulta y guarda el error en el log
     ***********************************************************************************************/
    public function deleteRegistro(string $tabla, array $clavesPrimarias): bool {
        $arrayConsultaValores = array();

        // Cargamos los parámetros de la cláusula WHERE
        $arrayParametrosWhere = array();
        foreach($clavesPrimarias as $campo => $valor) {
            $arrayParametrosWhere[] = $campo . '= :'.$campo;
            $arrayConsultaValores[$campo] = $valor;
        }

        // Preparamos la consulta
        $sqlParametrosWhere = implode(" AND ",$arrayParametrosWhere);
        $consultaSql = "DELETE FROM {$tabla} WHERE {$sqlParametrosWhere}";

        $this->ultimaConsulta = $consultaSql;

        try {
            $this->dbh->prepare($consultaSql)->execute($arrayConsultaValores);
            return true;
        } catch (PDOException $e) {
            $mensajeLog = date('Y-m-d H:i:s').": ".$e->getMessage();
            file_put_contents(FICHERO_DB_LOG, $mensajeLog.PHP_EOL.$this->ultimaConsulta.PHP_EOL.PHP_EOL, FILE_APPEND);
            $this->error = $e->getMessage();
            return false;
        }
    }

}

?>