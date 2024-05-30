/***********************************************************************************
 * Envía los datos para realizar el login del usuario y redirige
 * o muestra error según corresponda.
 ***********************************************************************************/
function enviarFormLogIn(boton) {
    var usuario = $("#inputUsuarioLogIn");
    var password = $("#inputPasswordLogIn");
    var feedBackFormLogIn = $("#feedbackFormLogIn");

    usuario.removeClass('is-invalid');
    password.removeClass('is-invalid');
    feedBackFormLogIn.hide();

    $.ajax({
        url: urlApi + "/gestionUsuariosLogIn.php",
        success:function(result){
            let respuesta = JSON.parse(result);
            if (respuesta.exito == 0) {
                usuario.addClass('is-invalid');
                password.addClass('is-invalid');
                feedBackFormLogIn.show();
                feedBackFormLogIn.html(respuesta.mensaje);
                return false;
            } else {
                $(location).attr('href',urlPrincipal+'/index_login.php');
                return false;
            }
        },
        error:function(result){
            feedBackFormLogIn.html('¡ERROR!');
            return false;
        },
        data:{
            tarea: 'verificarLogIn',
            email: usuario.val(),
            password: password.val()
        },
        type:"POST",
        async: true
    });

    return false;
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