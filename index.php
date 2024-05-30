<?php
require_once(__DIR__ . "/config/config.global.php");
require_once(__DIR__ . "/functions/funciones.globales.php");
require_once(__DIR__ . "/class/class.ManejoSesion.php");

global $CONFIG_GLOBAL;

/*
$sesion = new ManejoSesion();
$sesion->start(NOMBRE_SESION_SCS);
if ($sesion->read('nombre') !== false && $sesion->read('ip_usuario') == obtenerIpUsuario()) {
    header('Location: ' . $CONFIG_GLOBAL['rutaURLBase'] . '/index_login.php');
}
*/
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <style>
        body {
            width: 100%;
            height: 100%;
        }

        .container-div {
            background: url("./images/fondo_login.png");
            position: fixed;
            display: flex;
            min-width: 100%;
            min-height: 100%;
            background-size: cover;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- ************* HEADER CON LOS CSS Y SCRIPTS ***************** -->
    <?php require_once(__DIR__ . "/librerias/cabecera.php"); ?>
    <title>
        <?php echo $CONFIG_GLOBAL['tituloWeb']; ?> - Inicio
    </title>

    <style>
        .input-login {
            background-color: rgba(114, 114, 114, 0.4) !important;
            color: #ffffff !important;
        }

        .input-login::placeholder {
            color: white !important;
            opacity: 0.8 !important;
        }
    </style>

    <script src="./js/globales.js"></script>
    <script src="./js/funciones.login.js"></script>

</head>

<body>
    <?php //include(__DIR__ . '/modal/modalRecuperarPassword.php'); ?>

    <div class="container-div img-fluid">
        <div class="container-fluid" style="margin-top: 10%">
            <div class="row">
                <div class="col-1 col-xs-1 col-sm-1 col-md-1 col-lg-2 col-xl-2 col-xxl-2"></div>
                <div class="col-10 col-xs-10 col-sm-10 col-md-10 col-lg-8 col-xl-8 col-xxl-8">
                    <!-- Fila logotipo -->
                    <div class="row text-center mb-4">
                        <div class="col-12">
                            <img style="max-height: 175px" src="./images/logoSCS.png" class="img-fluid">
                        </div>
                    </div>

                    <!-- Fila título -->
                    <div class="row text-center">
                        <div class="col-12">
                            <h2 class="text-dark" style="letter-spacing: 5px;"> SERVICIO CANARIO DE LA SALUD</h2>
                            <h5 class="text-success fw-bold" style="letter-spacing: 9px;">SISTEMA DE GESTIÓN</h5>
                        </div>
                    </div>

                    <!-- Fila formulario Usuario -->
                    <form id="formIndexLogIn" onsubmit="return enviarFormLogIn(this);">
                        <div class="row mt-4">
                            <div class="col-lg-2 col-xl-2 col-xxl-3"></div>
                            <div class="col-12 col-lg-8 col-xl-8 col-xxl-6">
                                <div class="d-flex justify-content-center">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="logo-input-usuario"><i
                                                class="fa-solid fa-user"></i></span>
                                        <input id="inputUsuarioLogIn" type="email" class="form-control input-login" value="devalois.e@scs.es"
                                            placeholder="Usuario" aria-label="Usuario"
                                            aria-describedby="logo-input-usuario">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xl-2 col-xxl-3"></div>
                        </div>

                        <!-- Fila formulario Contraseña -->
                        <div class="row">
                            <div class="col-lg-2 col-xl-2 col-xxl-3"></div>
                            <div class="col-12 col-lg-8 col-xl-8 col-xxl-6">
                                <div class="d-flex justify-content-center">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="logo-input-password"><i
                                                class="fa-solid fa-lock"></i></span>
                                        <input id="inputPasswordLogIn" type="password" class="form-control input-login"
                                            placeholder="Contraseña" aria-label="Contraseña" value="Probando1234%"
                                            aria-describedby="logo-input-password">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xl-2 col-xxl-3"></div>
                        </div>


                        <!-- Fila formulario Feedback -->
                        <div class="row">
                            <div class="col-lg-2 col-xl-2 col-xxl-3"></div>
                            <div class="col-12 col-lg-8 col-xl-8 col-xxl-6">
                                <div class="d-flex justify-content-center">
                                    <span id="feedbackFormLogIn" class="badge text-bg-danger"></span>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xl-2 col-xxl-3"></div>
                        </div>
                        <!-- FORMULARIO SELECT -->
                        <div class="row">
                            <div class="col-lg-2 col-xl-2 col-xxl-3"></div>
                            <div class="col-12 col-lg-8 col-xl-8 col-xxl-6">
                                <div class="d-flex justify-content-center">
                                    <select style=" background-color: rgba(150, 150, 150, 0.5);color: white"class="form-select" id="selectRol"
                                        aria-label="Rol">
                                        <option selected disabled>ESCOJA EL ROL CON EL QUE DESEA ENTRAR</option>
                                        <option value="ADMINISTRADOR">ADMINISTRADOR</option>
                                        <option value="MÉDICO">MÉDICO</option>
                                        <option value="ENFERMERO">ENFERMERO</option>
                                        <option value="PACIENTE">PACIENTE</option>
                                    </select>
                                    <label for="selectRol"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-xl-2 col-xxl-3"></div>

                <!-- Fila formulario Botón -->
                <div class="row mt-1">
                    <div class="col-lg-2 col-xl-2 col-xxl-3">
                    </div>
                    <div class="col-12 col-lg-8 col-xl-8 col-xxl-6">
                        <div class="d-flex justify-content-end flex-row">
                            <div class="p-2">
                                <button data-bs-toggle="modal" data-bs-target="#modalRecuperarPassword"
                                    onclick="return false;" class="btn btn-info btn-lg"><i class="fa-solid fa-lock"></i>
                                    ¿Has olvidado tu contraseña?</button>
                            </div>
                            <div class="p-2">
                                <button type="submit" class="btn btn-warning btn-lg"><i
                                        class="fa-solid fa-right-to-bracket"></i> Entrar</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-xl-2 col-xxl-3"></div>
                </div>
                </form>

                <div class="col-1 col-xs-1 col-sm-1 col-md-1 col-lg-2 col-xl-2 col-xxl-2"></div>
            </div>
        </div>
    </div>
    <?php require_once __DIR__ . "/librerias/footer.php"; ?>
    <script>
        $("#inputUsuarioLogIn").focus();
    </script>
</body>
<!-- ************* FOOTER CON LOS CSS Y SCRIPTS ***************** -->

</html>