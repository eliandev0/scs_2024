<?php

# Parámetros generales
$CONFIG_GLOBAL = array();
$CONFIG_GLOBAL['rutaURLBase'] = 'http://localhost/scs_2024';
$CONFIG_GLOBAL['rutaURLBaseLibrerias'] = 'http://localhost/scs_2024/librerias';
$CONFIG_GLOBAL['tituloWeb'] = 'SCS';


# SESIONES
const NOMBRE_SESION_SCS = 'SCS_2024';
const NOMBRE_SESSION_SCS_DOMINIO = 'localhost';

# Gestión de usuarios
const MAXIMO_NUMERO_INTENTOS_FALLIDOS = 5;
const ROLES_GLOBALES = ['ADMINISTRADOR','MÉDICO','ENFERMERO','PACIENTE'];
?>