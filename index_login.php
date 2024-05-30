<?php
require_once __DIR__."/api/comprobarLogIn.php";
require_once __DIR__."/config/config.global.php";
require_once __DIR__."/class/class.Administrador.php";

global $sesion;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Servicio Canario de Salud - Gobierno de Canarias</title>
    <?php include('./librerias/cabecera.php'); ?>
</head>
<body>

<?php
include(__DIR__.'/menu/menu.php');
?>
<script>$("#menuInicio").addClass('active')</script>

<div class="container mt-2">
    <div class="row">
        <div class="col-12">
            <h3>Bienvenido/a <?php echo $sesion->read('nombre'); ?></h3>
        </div>
    </div>
</div>

<?php include('./librerias/footer.php'); ?>
</body>
</html>
