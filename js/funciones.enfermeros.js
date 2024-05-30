/***********************************************************************************
 * Abre el modal de la ficha de los datos del enfermero
 ***********************************************************************************/

function abrirModalFichaEnfermero(boton, idEnfermero) {
	let codigoHTMLActualBoton = $(boton).html();
	$(boton).html('<i class="fas fa-sync fa-spin"></i>');
	
	$("#idEnfermero").val(idEnfermero);

	$('feedbackFormCrearEditarDatosEnfermero').hide(); 

	cargarListadoAmbulatorios('selectAmbulatorio');
	cargarListadoConsultas('selectConsulta');
	
	if (idEnfermero == 0) {
		$(".form-control").val('');
		$("#modalDatosEnfermero").modal('show');
		$(boton).html(codigoHTMLActualBoton);
		return true;
	}


	$.ajax({
        url: urlApi + "/gestionEnfermeros.php",
        success:function(result){
            let respuesta = JSON.parse(result);
            if (respuesta.exito == 0) {  
				//feedBackFormLogIn.html(respuesta.mensaje);
				$(boton).html(codigoHTMLActualBoton);
                //feedBackFormLogIn.show();
                return false;
            } else {
				$.each(respuesta.datos, function(campo, valor) {
					$("#"+campo).val(valor);
				});
				$('#selectAmbulatorio').val(respuesta.datos.idConsulta);
				$("#modalDatosEnfermero").modal('show');
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
            tarea: 'cargarDatosEnfermero',
            id: idEnfermero
        },
        type:"POST",
        async: true
    });
	$(boton).html(codigoHTMLActualBoton);
}


/***********************************************************************************
 * Guarda los datos del médico
 ***********************************************************************************/
function guardarEnfermero(boton) {
	let codigoHTMLActualBoton = $(boton).html();
	$(boton).html('<i class="fas fa-sync fa-spin"></i>');
	
	let idEnfermero = $("#idEnfermero").val();	
	let numeroColegiado = $("#inputNumeroColegiado");
	let nombre = $("#inputNombre");
	let apellido1 = $("#inputApellido1");
	let apellido2 = $("#inputApellido2");
	let email = $("#inputEmail");
	let telefono = $("#inputTelefono");
	let idConsulta = $("#selectAmbulatorio");
	let feedbackFormEnfermero = $('feedbackFormCrearEditarDatosEnfermero');
	
	$.ajax({
        url: urlApi + "/gestionEnfermeros.php",
        success:function(result){
            let respuesta = JSON.parse(result);
            if (respuesta.exito == 0) {  
				feedbackFormCrearEditarDatosEnfermero.html(respuesta.mensaje);
				$(boton).html(codigoHTMLActualBoton);
				feedbackFormCrearEditarDatosEnfermero.show();
                return false;
            } else {				
				$("#tablaListadoEnfermero").bootstrapTable('refresh');
				$("#modalDatosEnfermero").modal('hide');
				$(boton).html(codigoHTMLActualBoton);
                return true;
            }
        },
        error:function(result){
            feedbackFormCrearEditarDatosEnfermero.html('¡ERROR!');
			$(boton).html(codigoHTMLActualBoton);
            return false;
        },
        data:{
            tarea: 'guardarDatosEnfermero',
            id: idEnfermero,
			numeroColegiado: numeroColegiado.val(),
			nombre: nombre.val(),
			apellido1: apellido1.val(),
			apellido2: apellido2.val(),
			email: email.val(),
			telefono: telefono.val(),
			idConsulta: idConsulta.val()
        },
        type:"POST",
        async: true
    });
	$(boton).html(codigoHTMLActualBoton);
}