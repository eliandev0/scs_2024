<!-- Modal Crear/Editar Médico -->
<div class="modal fade" id="modalDatosMedico" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="modalFormularioMedicoLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h4 class="modal-title" id="tituloModalFormularioDatosMedico"><i class="fa-solid fa-user-doctor"></i>
                    Crear/Editar Datos Médico</h4>
                <button type="button" class="btn-close text-warning btn-close-white" data-bs-dismiss="modal"
                    aria-label="Cerrar"></button>
            </div>
            <div id="modalFormularioDatosMedicoCuerpo" class="modal-body">

                <!-- FILA 1 FORMULARIO: NOMBRE, APELLIDOS, NÚMERO DE COLEGIADO -->
                <div class="row">
                    <div class="col-2">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="inputNumeroColegiado"
                                placeholder="Número de Colegiado">
                            <label for="inputNumeroColegiado">Nº Colegiado</label>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="inputNombre" placeholder="Nombre">
                            <label for="inputNombre">Nombre</label>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="inputApellido1" placeholder="Apellido 1">
                            <label for="inputApellido1">Apellido 1</label>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="inputApellido2" placeholder="Apellido 2">
                            <label for="inputApellido2">Apellido 2</label>
                        </div>
                    </div>
                </div>
                <!-- FIN FILA 1 -->

                <!-- FILA 2 FORMULARIO: EMAIL, ROL, ESPECIALIDAD Y TELÉFONO -->
                <div class="row">
                    <div class="col-5">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                            <label for="inputEmail">Email</label>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-floating">
                            <select class="form-select" id="selectEspecialidad" aria-label="Especialidad Médica">
                                <option value="MEDICINA FAMILIAR">MEDICINA FAMILIAR</option>
                                <option value="PEDIATRÍA">PEDIATRÍA</option>
                                <option value="PEDIATRÍA">GINECOLOGÍA</option>
                                <option value="PEDIATRÍA">TRAUMATOLOGÍA</option>                                
                                <option value="UROLOGÍA">UROLOGÍA</option>
                            </select>
                            <label for="selectEspecialidad">Especialidad</label>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="inputTelefono" placeholder="Teléfono">
                            <label for="inputTelefono">Teléfono</label>
                        </div>
                    </div>
                </div>
                <!-- FIN FILA 2 -->

                <!-- FILA 3 FORMULARIO: AMBULATORIO y CONSULTA -->
                <div class="row">
                    <div class="col-5">
                        <div class="form-floating">
                            <select class="form-select" id="selectAmbulatorio" aria-label="Ambulatorio del médico" onchange="cargarListadoConsultas('selectConsulta')">
                            </select>
                            <label for="floatingSelect">Ambulatorio</label>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-floating">
                            <select class="form-select" id="selectConsulta" aria-label="Consulta médica">
                            </select>
                            <label for="floatingSelect">Consulta</label>
                        </div>
                    </div>
                </div>
                <!-- FIN FILA 3 -->

                <!-- Fila formulario Feedback -->
                <div class="row mt-2">
                    <div class="col-lg-3 col-md-3"></div>
                    <div class="col-lg-6 col-md-6">
                        <div class="d-flex justify-content-center">
                            <span id="feedbackFormCrearEditarDatosMedico" class="badge text-bg-danger"></span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3"></div>
                </div>

            </div>
            <div class="modal-footer bg-opacity-75 bg-warning-subtle">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button id="btnGuardarMedico" onclick="guardarMedico(this);" type="button" class="btn btn-success"><i
                        class="fa-solid fa-cloud-arrow-up"></i> Guardar Médico</button>
            </div>
        </div>
    </div>
</div>