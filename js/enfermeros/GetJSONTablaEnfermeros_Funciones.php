<?php
require_once __DIR__."/../api/comprobarLogIn.php";

require_once __DIR__ . "/../config/config.global.php";
require_once __DIR__ . "/../class/class.DBHandler.php";

global $sesion;

/*****************************************************************************
/* Genera la consulta para generar el JSON con el listado de enfermeros
/*****************************************************************************/
function generarConsultaListadoTablaEnfermeros($textoBusqueda = "", $limit = 0, $offset = 0, $sortby = 0, $order = 0) {

    $gestorDB = new DBHandler();

    $consultaSqlSelect  = "SELECT DISTINCT ".TABLA_ENFERMEROS.".id FROM ".TABLA_ENFERMEROS;
    $consultaSqlWhere = " WHERE ";

    // Comprobamos los criterios para la consulta
    $criteriosConsultaSql = "";


    // ¿Se pide un parámetro de búsqueda dentro del texto?
    if ($textoBusqueda != "") {
        if ($criteriosConsultaSql != "") {
            $criteriosConsultaSql .= " AND (".TABLA_ENFERMEROS.".apellido1 LIKE '%".$textoBusqueda."%'";
        } else {
            $criteriosConsultaSql .= " (".TABLA_ENFERMEROS.".apellido1 LIKE '%".$textoBusqueda."%'";
        }
        $criteriosConsultaSql .= " OR ".TABLA_ENFERMEROS.".apellido2 LIKE '%".$textoBusqueda."%'";
        $criteriosConsultaSql .= " OR ".TABLA_ENFERMEROS.".nombre LIKE '%".$textoBusqueda."%'";
        $criteriosConsultaSql .= " OR ".TABLA_ENFERMEROS.".numeroColegiado LIKE '%".$textoBusqueda."%'";
        $criteriosConsultaSql .= " OR ".TABLA_ENFERMEROS.".email LIKE '%".$textoBusqueda."%'";
        $criteriosConsultaSql .= ")";
    }

    // Si no hay parámetros, sobra el WHERE
    if ($criteriosConsultaSql == "") {
        $consultaSqlWhere = "";
    }

    // HACEMOS LA CONSULTA SIN EL LIMIT Y OFFSET, PARA CONOCER EL TOTAL
    $consultaSql = $consultaSqlSelect.$consultaSqlWhere.$criteriosConsultaSql;

    $resultado = false;
    $resultados = array();

    try {
        $consultaSql = $gestorDB->dbh->prepare($consultaSql);
        $consultaSql->execute();
    } catch (PDOException $e) {
        //echo $e->getMessage();
        $resultado = $e;
    }

    $totalFilas = $consultaSql->rowCount();


    // HACEMOS LA CONSULTA CON EL LIMIT Y EL OFFSET, ADEMÁS DE ORDENAR LOS RESULTADOS
    // ORDEN DEL LISTADO DE RESULTADOS
    if ($sortby === 0) {
        $consultaSqlOrder = " ORDER BY ".TABLA_ENFERMEROS.".apellido1 ASC, apellido2 ASC, nombre ASC";
    } else {
        $consultaSqlOrder = " ORDER BY ".TABLA_ENFERMEROS.".".$sortby." ".$order;
    }

    // ¿HAY LÍMITE U OFFSET?
    $consultaSqlLimit = "";
    if ($limit != 0) {
        $consultaSqlLimit = " LIMIT ".$limit." OFFSET ".$offset;
    }

    $consultaSql = "SELECT * FROM ".TABLA_ENFERMEROS." WHERE id IN (".$consultaSql->queryString.") ".$consultaSqlOrder.$consultaSqlLimit;
    //echo $consultaSql;

    try {
        $consultaSql = $gestorDB->dbh->prepare($consultaSql);
        $consultaSql->execute();
        $resultados = $consultaSql->fetchAll(constant('PDO::FETCH_ASSOC'));
    } catch (PDOException $e) {
        //echo $e->getMessage();
        return false;
    }

    $resultado = array();
    $resultado['datos'] = $resultados;
    $resultado['totalFilas'] = $totalFilas;

    return $resultado;
}

/*****************************************************************************
/* Devuelve el JSON con el listado de enfermeros según parámetros
/*****************************************************************************/
function listadoTablaEnfermeros($textoBusqueda = "", $limit = 0, $offset = 0, $sortby = 0, $order = 0) {
    global $CONFIG_GLOBAL;

    $resultadoConsulta = generarConsultaListadoTablaEnfermeros($textoBusqueda, $limit, $offset, $sortby, $order);
    $filasDatos = $resultadoConsulta['datos'];

    if ($resultadoConsulta) {

        $jsonDatos = Array();
        $i = 0;

        foreach($filasDatos as $fila) {
            $jsonDatos[$i]['id'] = $fila['id'];
            $jsonDatos[$i]['apellido1'] = $fila['apellido1'];
            $jsonDatos[$i]['apellido2'] = $fila['apellido2'];
            $jsonDatos[$i]['apellidos'] = $fila['apellido1']." ".$fila['apellido2'];
            $jsonDatos[$i]['nombre'] = $fila['nombre'];
            $jsonDatos[$i]['email'] = $fila['email'];
            $jsonDatos[$i]['telefono'] = $fila['telefono'];

            // ACCIONES - EDITAR, ELIMINAR...
            $acciones  = ' <a href="'.$CONFIG_GLOBAL['rutaURLBase'].'/modal/modalDatoseEnfermero.php?id='.$fila['id'].'" target="" id="btnVerFichaEnfermero" class="btn btn-sm btn-warning text-dark"><i class="fa-solid fa-circle-arrow-right"></i></a>';
            $acciones .= ' <button onclick="abrirModalFichaEnfermero(this,'.$fila['id'].')" class="btn btn-sm bg-primary-subtle"><i class="fa-solid fa-user-pen"></i></button>';
            // ------------------------------

            $jsonDatos[$i]['acciones'] = $acciones;

            $i++;
        }

        $datosCompleto['total'] = $resultadoConsulta['totalFilas'];
        $datosCompleto['rows'] = $jsonDatos;

        return $datosCompleto;
    }

    return false;
}

?>