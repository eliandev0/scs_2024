/***********************************************************************************
 * Abre el modal de la ficha de los datos del pacientes
 ***********************************************************************************/

function abrirModalFichaPaciente(boton, idPaciente) {
	let codigoHTMLActualBoton = $(boton).html();
	$(boton).html('<i class="fas fa-sync fa-spin"></i>');
	
	$("#idPaciente").val(idPaciente);

	$('feedbackFormCrearEditarDatosPaciente').hide(); 

	cargarListadoAmbulatorios('selectAmbulatorio');
	cargarListadoConsultas('selectConsulta');
	
	if (idPaciente == 0) {
		$(".form-control").val('');
		$("#modalDatosPaciente").modal('show');
		$(boton).html(codigoHTMLActualBoton);
		return true;
	}


	$.ajax({
        url: urlApi + "/gestionPaciente.php",
		success: function(result) {
			let respuesta = JSON.parse(result);
			if (respuesta.exito == 0) {
			  feedbackFormCrearEditarDatosPaciente.html(respuesta.mensaje); // Use the correct element here
			  feedbackFormCrearEditarDatosPaciente.show();
			} else {
				$.each(respuesta.datos, function(campo, valor) {
					$("#"+campo).val(valor);
				});
				$('#selectAmbulatorio').val(respuesta.datos.idConsulta);
				$("#modalDatosPaciente").modal('show');
				$(boton).html(codigoHTMLActualBoton);
                return true;
            }
        },
        error:function(result){
            //feedBackFormLogIn.html('¡ERROR!');
			$(boton).html(codigoHTMLActualBoton);
            return false;
        },
        data:{
            tarea: 'cargarDatosPaciente',
            id: idPaciente
        },
        type:"POST",
        async: true
    });
	$(boton).html(codigoHTMLActualBoton);
}



/***********************************************************************************
 * Guarda los datos del paciente
 ***********************************************************************************/
function guardarPaciente(boton) {
	let codigoHTMLActualBoton = $(boton).html();
	$(boton).html('<i class="fas fa-sync fa-spin"></i>');
	
	let idPaciente = $("#idPaciente").val();	
	let nombre = $("#inputNombre");
	let apellido1 = $("#inputApellido1");
	let apellido2 = $("#inputApellido2");
	let email = $("#inputEmail");
	let telefono = $("#inputTelefono");
	let feedbackFormCrearEditarDatosPaciente = $('feedbackFormCrearEditarDatosPaciente');
	
	$.ajax({
        url: urlApi + "/gestionPacientes.php",
        success:function(result){
            let respuesta = JSON.parse(result);
            if (respuesta.exito == 0) {  
				feedbackFormCrearEditarDatosPaciente.html(respuesta.mensaje);
				$(boton).html(codigoHTMLActualBoton);
				feedbackFormCrearEditarDatosPaciente.show();
                return false;
            } else {				
				$("#tablaListadoPacientes").bootstrapTable('refresh');
				$("#modalDatosPaciente").modal('hide');
				$(boton).html(codigoHTMLActualBoton);
                return true;
            }
        },
        error:function(result){
            feedbackFormCrearEditarDatosPaciente.html('¡ERROR!');
			$(boton).html(codigoHTMLActualBoton);
            return false;
        },
        data:{
            tarea: 'guardarDatosPaciente',
            id: idPaciente,
			nombre: nombre.val(),
			apellido1: apellido1.val(),
			apellido2: apellido2.val(),
			email: email.val(),
			telefono: telefono.val(),
        },
        type:"POST",
        async: true
    });
	$(boton).html(codigoHTMLActualBoton);
}