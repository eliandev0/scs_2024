<?php include(__DIR__.'/../modal/modalRecuperarPassword.php'); ?>

<nav class="navbar navbar-white navbar-expand-lg" style="border-bottom: 3px solid #070052; background-color: #c0cce0">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo $CONFIG_GLOBAL['rutaURLBase'];?>/index_login.php"><img height="70em" src="<?php echo $CONFIG_GLOBAL['rutaURLBase'];?>/images/logoSCS.png"/></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <h4><a id="menuInicio" class="nav-link" aria-current="page" href="<?php echo $CONFIG_GLOBAL['rutaURLBase'];?>/index_login.php"><i class="fa-solid fa-house"></i> Inicio</a></h4>
                </li>
                <li class="nav-item h4">
                    <a id="menuMedicos" class="nav-link" href="<?php echo $CONFIG_GLOBAL['rutaURLBase'];?>/medicos/index.php" aria-current="page">
                        <i class="fa-solid fa-user-doctor"></i> Médicos
                    </a>
                </li>
                <li class="nav-item">
                    <h4><a id="menuEnfermeros" class="nav-link" aria-current="page" href="<?php echo $CONFIG_GLOBAL['rutaURLBase'];?>/enfermeros/index.php">
                            <i class="fa-solid fa-user-nurse"></i> Enfermeros
                        </a>
                    </h4>
                </li>
                <li class="nav-item">
                    <h4><a id="menuPacientes" class="nav-link" aria-current="page" href="<?php echo $CONFIG_GLOBAL['rutaURLBase'];?>/pacientes/index.php">
                            <i class="fa-solid fa-hospital-user"></i> Pacientes
                        </a>
                    </h4>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto mb-2 mb-lg-0 justify-content-end">
                <li class="nav-item">
                    <h4><a id="menuCambiarPassword" class="nav-link" aria-current="page" onclick="$('#modalRecuperarPassword').modal('show');"><i class="fa-solid fa-key"></i> Cambiar Contraseña</a></h4>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto mb-2 mb-lg-0 justify-content-end">
                <li class="nav-item">
                    <h4><a class="nav-link active" aria-current="page" href="<?php echo $CONFIG_GLOBAL['rutaURLBase'];?>/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Salir</a></h4>
                </li>
            </ul>
        </div>
    </div>
</nav>