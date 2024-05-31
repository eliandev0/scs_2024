<?php
require_once __DIR__."/../api/comprobarLogIn.php";
require_once __DIR__."/../config/config.global.php";
//require_once __DIR__."/../class/class.Administrador.php";

global $CONFIG_GLOBAL, $sesion;

if ($sesion->read('rol_usuario') != 'ADMINISTRADOR') {
    echo "No puede acceder a esta página";
    exit;
}


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Servicio Canario de Salud - Gobierno de Canarias</title>
    <?php include(__DIR__.'/../librerias/cabecera.php'); ?>
    <link rel="stylesheet" href="<?=$CONFIG_GLOBAL['rutaURLBaseLibrerias']?>/bootstraptable/dist/bootstrap-table.min.css"/>
    <link rel="stylesheet" href="<?=$CONFIG_GLOBAL['rutaURLBaseLibrerias']?>/bootstraptable/dist/bootstrap-icons.css"/>
	
	<script src="../js/globales.js"></script>
	<script src="../js/funciones.medicos.js"></script>
	<script src="../js/funciones.comunes.js"></script>
</head>
<body>

<?php
include(__DIR__.'/../menu/menu.php');
?>
<script>$("#menuMedicos").addClass('active')</script>

<?php include(__DIR__.'/../modal/modalDatosMedico.php'); ?>

<input id="idMedico" type="hidden" value="0">

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
			<div class="row">
				<div class="col-12 text-left">
					<button onclick="abrirModalFichaMedico(this, 0)" class="btn btn-success"><i class="fa-solid fa-user-plus"></i> Añadir Médico</button>
				</div>
			</div>
            <!-- Tabla listado médicos -->			
            <div class="row">
                <div class="col-12">
                    <table class="tablaListado table-striped" id="tablaListadoMedicos" data-toggle="table"
                           data-url="<?php echo $CONFIG_GLOBAL['rutaURLBase']."/medicos/GetJSONTablaMedicos.php"; ?>"
                           data-unique-id="id"
                           data-search="true"
                           data-show-refresh="true"
                           data-show-toggle="false"
                           data-show-columns="true"
                           data-pagination="true"
                           data-side-pagination="server"
                           data-page-size="10"
                           data-striped="true"
                           data-classes="table table-hover table-condensed"
                           data-page-list="[5, 10, 20, 50, 100, 200]"
                    >
                        <thead>
                        <tr>
                            <th data-width="6" data-field="id">Código</th>
                            <th data-width="50" data-field="apellidos">Apellidos</th>
                            <th data-width="50" data-field="nombre">Nombre</th>
                            <th data-width="20" data-field="telefono">Teléfono</th>
                            <th data-width="20" data-field="email">Email</th>
                            <th data-width="20" data-field="especialidad" data-sortable="true">Especialidad</th>
                            <th data-width="53" data-field="acciones">Acciones</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- Fin Tabla listado médicos -->
        </div>
    </div>
</div>

<?php include(__DIR__.'/../librerias/footer.php'); ?>
<script src="<?=$CONFIG_GLOBAL['rutaURLBaseLibrerias']?>/bootstraptable/dist/bootstrap-table.min.js"></script>
<script src="<?=$CONFIG_GLOBAL['rutaURLBaseLibrerias']?>/bootstraptable/dist/locale/bootstrap-table-es-ES.min.js"></script>
</body>
</html>
