
$(document).ready(function () {

    $('input[type=text]').focus(function(){
        $(this).select();
    });

    $('#frm_login_sistema').submit(function (event) {
        event.preventDefault();
        $('#mjs').hide();
        var formData = $('#frm_login_sistema').serialize();
        $.ajax({
            url: $(this).attr('action'),
            type: 'post',
            data: formData,
            dataType: 'json',
            success: function (respuesta) {
                if (respuesta == true) {
                    location.href = site_login+'/login/set_impresora';
                } else {
                    if(respuesta ==='error1'){ // Datos incorrectos
                        $('#mjs1').show();
                        $('#usuario').focus();
                    }else{
                        if (respuesta === 'error2'){
                            swal('Error', 'Usuario no habilitado.', 'danger');
                        }else{
                            if (respuesta === 'error3'){
                                $('#mjs2').show();
                                $('#usuario').focus()
                            }else{
                                location.href = site_login+'/inicio';
                            }
                        }
                    }
                }
            }
        });
    });

    $('#frm_set_impresora').submit(function (event) {
        event.preventDefault();

        var marca = $('#impresora_sel option:selected').html();
        var formData = $('#frm_set_impresora').serialize();
        var frm = formData+'&marca='+marca;
        $.ajax({
            url: site_login +'/login/guardarSesion',
            type: 'post',
            data: frm,
            dataType: 'json',
            success: function (respuesta) {
                if (respuesta == true) {
                    swal('Sesion guardada.', '','success');
                    setTimeout(function(){ location.href = site_login+'/inicio' }, 2000);
                } else {
                    swal('Error', 'Eror al registrar la sesion.', 'error');
                }
            }
        });
    });

});