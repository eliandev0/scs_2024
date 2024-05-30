function enviarCambioPassword(boton) {
    let codigoHTMLActualBoton = $(boton).html();
    $(boton).html('<i class="fas fa-sync fa-spin"></i>');

    let feedbackCambioPassword = $("#feedbackCambioPassword");
    feedbackCambioPassword.html('');

    $.ajax({
        url: urlApi + "/gestionUsuarios.php",
        success:function(result){
            let respuesta = JSON.parse(result);
            if (respuesta.exito == 0) {
                feedbackCambioPassword.html(respuesta.mensaje);
                $(boton).html(codigoHTMLActualBoton);
                return false;
            } else {
                feedbackCambioPassword.html(respuesta.mensaje);
                $(boton).html(codigoHTMLActualBoton);
                return true;
            }
        },
        error:function(result){
            feedbackCambioPassword.html('¡ERROR!');
            $(boton).html(codigoHTMLActualBoton);
            return false;
        },
        data:{
            tarea: 'cambioPasswordUsuario',
            passwordActual: $("#passwordActual").val(),
            passwordNueva1: $("#passwordNueva1").val(),
            passwordNueva2: $("#passwordNueva2").val()
        },
        type:"POST",
        async: true
    });
}