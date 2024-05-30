<?php

require_once __DIR__."/../api/comprobarLogIn.php";

require_once __DIR__ . "/../class/class.DBHandler.php";
//require_once __DIR__ . "/../class/class.Enfermeros.php";

require_once __DIR__ . "/GetJSONTablaEnfermeros_Funciones.php";

/**************************************************************************
/* DEVUELVE EL JSON CON EL LISTADO DE REFLEXIONES PARA UTILIZAR EN LA TABLA
/**************************************************************************/

$textoBusqueda = "";
$limit = 0;
$offset = 0;
$sortby = 0;
$order = 0;

if (isset($_GET['search'])) {
    $textoBusqueda = $_GET['search'];
}

if (isset($_GET['limit'])) {
    $limit = $_GET['limit'];
}

if (isset($_GET['offset'])) {
    $offset = $_GET['offset'];
}

if (isset($_GET['sort'])) {
    $sortby = $_GET['sort'];
}

if (isset($_GET['order'])) {
    $order = $_GET['order'];
}

echo json_encode(listadoTablaEnfermeros($textoBusqueda,$limit,$offset,$sortby,$order));

?>