/***********************************************************************************
 * Abre el modal de la ficha de los datos del médico
 ***********************************************************************************/

function abrirModalFichaMedico(boton, idMedico) {
	let codigoHTMLActualBoton = $(boton).html();
	$(boton).html('<i class="fas fa-sync fa-spin"></i>');
	
	$("#idMedico").val(idMedico);

	$('feedbackFormCrearEditarDatosMedico').hide(); 

	cargarListadoAmbulatorios('selectAmbulatorio');
	cargarListadoConsultas('selectConsulta');
	
	if (idMedico == 0) {
		$(".form-control").val('');
		$("#modalDatosMedico").modal('show');
		$(boton).html(codigoHTMLActualBoton);
		return true;
	}


	$.ajax({
        url: urlApi + "/gestionMedicos.php",
		success: function(result) {
			let respuesta = JSON.parse(result);
			if (respuesta.exito == 0) {
			  feedbackFormCrearEditarDatosMedico.html(respuesta.mensaje); // Use the correct element here
			  feedbackFormCrearEditarDatosMedico.show();
			} else {
				$.each(respuesta.datos, function(campo, valor) {
					$("#"+campo).val(valor);
				});
				$('#selectAmbulatorio').val(respuesta.datos.idConsulta);
				$("#modalDatosMedico").modal('show');
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
            tarea: 'cargarDatosMedico',
            id: idMedico
        },
        type:"POST",
        async: true
    });
	$(boton).html(codigoHTMLActualBoton);
}


/***********************************************************************************
 * Guarda los datos del médico
 ***********************************************************************************/
function guardarMedico(boton) {
	let codigoHTMLActualBoton = $(boton).html();
	$(boton).html('<i class="fas fa-sync fa-spin"></i>');
	
	let idMedico = $("#idMedico").val();	
	let numeroColegiado = $("#inputNumeroColegiado");
	let nombre = $("#inputNombre");
	let apellido1 = $("#inputApellido1");
	let apellido2 = $("#inputApellido2");
	let email = $("#inputEmail");
	let telefono = $("#inputTelefono");
	let especialidad = $("#selectEspecialidad");
	let idConsulta = $("#selectAmbulatorio");
	let feedbackFormCrearEditarDatosMedico = $('feedbackFormCrearEditarDatosMedico');
	
	$.ajax({
        url: urlApi + "/gestionMedicos.php",
        success:function(result){
            let respuesta = JSON.parse(result);
            if (respuesta.exito == 0) {  
				feedbackFormCrearEditarDatosMedico.html(respuesta.mensaje);
				$(boton).html(codigoHTMLActualBoton);
				feedbackFormCrearEditarDatosMedico.show();
                return false;
            } else {				
				$("#tablaListadoMedicos").bootstrapTable('refresh');
				$("#modalDatosMedico").modal('hide');
				$(boton).html(codigoHTMLActualBoton);
                return true;
            }
        },
        error:function(result){
            feedbackFormCrearEditarDatosMedico.html('¡ERROR!');
			$(boton).html(codigoHTMLActualBoton);
            return false;
        },
        data:{
            tarea: 'guardarDatosMedico',
            id: idMedico,
			numeroColegiado: numeroColegiado.val(),
			nombre: nombre.val(),
			apellido1: apellido1.val(),
			apellido2: apellido2.val(),
			email: email.val(),
			telefono: telefono.val(),
			especialidad: especialidad.val(),
			idConsulta: idConsulta.val()
        },
        type:"POST",
        async: true
    });
	$(boton).html(codigoHTMLActualBoton);
}