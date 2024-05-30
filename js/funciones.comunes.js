/***********************************************************************************
 * Cargar ambulatorios
 ***********************************************************************************/
function cargarListadoAmbulatorios(idSelect) {
    selectAmbulatorios = $("#"+idSelect);
	// Eliminamos todas las opciones actuales del select
	selectAmbulatorios.empty();
	
    $.ajax({
        url: urlApi + "/gestionComunes.php",
        success:function(result){
            let respuesta = JSON.parse(result);
            if (respuesta.exito == 0) {
                selectAmbulatorios.append('<option value="0">Error al cargar los datos</option>');                
            } else {
                $.each(respuesta.datos, function( num, ambulatorio){				
					selectAmbulatorios.append('<option value="'+ambulatorio.id+'">'+ambulatorio.nombre+'</option>');
				});
            }
        },
        error:function(result){            
            return false;
        },
        data:{
            tarea: 'cargarListadoAmbulatorios'            
        },
        type:"POST",
        async: false
    });

    return false;
}

function cargarListadoConsultas(idSelectConsultas) {
    let boton = "#botonCargar"; // Selector del botón que activa la llamada AJAX
    let codigoHTMLActualBoton = $(boton).html(); // Guarda el contenido HTML del botón para restaurarlo después

    $.ajax({
        url: urlApi + "/gestionComunes.php",
        success: function(result) {
            let respuesta = JSON.parse(result);
            if (respuesta.exito == 0) {  
                // Manejo del error
                //feedBackFormLogIn.html(respuesta.mensaje);
                $(boton).html(codigoHTMLActualBoton);
                //feedBackFormLogIn.show();
                return false;
            } else {
				let ambulatorioSeleccionado = +$("#selectAmbulatorio").val()
                // Llenar el select con las consultas
                let selectConsultas = $("#"+idSelectConsultas);
                selectConsultas.empty(); // Vaciar el select antes de llenarlo
                $.each(respuesta.datos, function(index, consulta) {
					if (consulta.idAmbulatorio == ambulatorioSeleccionado) {
						selectConsultas.append(
							$('<option>', { 
								value: consulta.id, 
								text: consulta.nombre 
							})
						);
					}
                });
                $(boton).html(codigoHTMLActualBoton);
                return true;
            }
        },
        error: function(result) {
            // Manejo del error
            //feedBackFormLogIn.html('¡ERROR!');
            $(boton).html(codigoHTMLActualBoton);
            return false;
        },
        data: {
            tarea: 'cargarListadoConsultas'
        },
        type: "POST",
        async: true
    });
    $(boton).html(codigoHTMLActualBoton);
}


/***********************************************************************************
 * Genera un token y lo envía al usuario para que pueda recuperar su contraseña
 ***********************************************************************************/
 function recuperarPassword(boton) {
	let codigoHTMLActualBoton = $(boton).html();
    $(boton).html('<i class="fas fa-sync fa-spin"></i>');
	
	$.ajax({
		url: urlApi + "/gestionUsuariosLogIn.php",
		success:function(result){
			let respuesta = JSON.parse(result);
			if (respuesta.exito == 1) {
				$("#divInputEmailRecuperarPassword").hide();
				$("#mensajeRecuperarPassword").html(respuesta.mensaje);				
			}
			$(boton).html(codigoHTMLActualBoton);
		},
		error:function(result){
			feedBackFormLogIn.html('¡ERROR!');
			$(boton).html(codigoHTMLActualBoton);
			return false;
		},
		data:{
			tarea: 'generarPasswordOlvidada',
			email: $("#inputEmailRecuperarPassword").val()
		},
		type:"POST",
		async: true
	});
 }
 
 
 /***********************************************************************************
 * Modificar contraseña a partir del token
 ***********************************************************************************/
 function enviarRecuperarPassword(boton) {
	let codigoHTMLActualBoton = $(boton).html();
    $(boton).html('<i class="fas fa-sync fa-spin"></i>');
	
	let token = $("#inputToken").val();
	let feedBackFormRecuperarPassword = $("#feedbackCambioPassword");
	
	$.ajax({
		url: urlApi + "/gestionUsuariosLogIn.php",
		success:function(result){
			let respuesta = JSON.parse(result);			
			feedBackFormRecuperarPassword.html(respuesta.mensaje);
			$(boton).html(codigoHTMLActualBoton);
		},
		error:function(result){
			feedBackFormRecuperarPassword.html('¡ERROR!');
			$(boton).html(codigoHTMLActualBoton);
			return false;
		},
		data:{
			tarea: 'cambiarPasswordConToken',
			token: token,
			email: $("#emailUsuario").val(),
			password1: $("#passwordNueva1").val(),
			password2: $("#passwordNueva2").val(),
		},
		type:"POST",
		async: true
	});
 }