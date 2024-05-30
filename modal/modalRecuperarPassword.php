<!-- Modal Recuperar Password -->
<div class="modal fade" id="modalRecuperarPassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalFormularioMedicoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h4 class="modal-title" id="tituloModalFormularioRecuperarPassword"><i class="fa-solid fa-lock"></i> Recuperar Contraseña</h4>
                <button type="button" class="btn-close text-warning btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div id="modalFormularioRecuperarPasswordCuerpo" class="modal-body">                

				<!-- FILA 1 FORMULARIO: EMAIL -->
                <div class="row">
                    <div class="col-12">
						<p id="mensajeRecuperarPassword">Introduzca el email del usuario para recuperar la contraseña. En caso de ser un dato correcto,
						se enviará un email al usuario con los pasos a seguir para poder recuperar su contraseña.
                        <div id="divInputEmailRecuperarPassword" class="form-floating mb-3">
                            <input type="text" class="form-control" id="inputEmailRecuperarPassword" placeholder="Email del usuario">
                            <label for="inputEmailRecuperarPassword">Email del usuario</label>
                        </div>
                    </div>				
                </div>
				<!-- FIN FILA 1 -->							

                <!-- Fila formulario Feedback -->
                <div class="row mt-2">
                    <div class="col-lg-3 col-md-3"></div>
                    <div class="col-lg-6 col-md-6">
                        <div class="d-flex justify-content-center">
                            <span id="feedbackFormRecuperarPassword" class="badge text-bg-danger"></span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3"></div>
                </div>

            </div>
            <div class="modal-footer bg-opacity-75 bg-warning-subtle">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button id="btnRecuperarPassword" onclick="recuperarPassword(this);" type="button" class="btn btn-success"><i class="fa-solid fa-cloud-arrow-up"></i> Recuperar Password</button>
            </div>
        </div>
    </div>
</div>
<!-- Final modal Recuperar Password -->