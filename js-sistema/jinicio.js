
$(document).ready(function(){

    $('#frm-cambiar-clave').submit(function(event){
       event.preventDefault();

       $.ajax({
           url: site_url+'/inicio/confirmar_cambio',
           type: 'post',
           data: $('#frm-cambiar-clave').serialize(),
           success: function (respuesta) {
               console.log(respuesta);
               if(respuesta === 'error'){
                   swal('Las contraseña no coinciden');
               }else{
                   swal('Contraseña actualizada, cerrando sesion espere por favor.');
                   setTimeout(location.href = site_url+'login/cerrar_sesion',3000);
               }
           }
       });
    });

    $('#verificar').click(function () {
        var usuario = $('#usuario-id').val();
        var clave = $('#actual').val();
        $.ajax({
            url: site_url+'/inicio/verificar',
            data: 'clave='+clave,
            type: 'post',
            success: function(data){
                console.log(data)
                if(data === 'error'){
                    $('#aviso').show();
                }else{
                    $('#aviso').hide();
                    $('#verificar').attr('disabled',true);
                    $('#actual').attr('readonly', true);
                    $('#nuevo').show();
                }
            }
        })
    });
    //$('#frm-cambiar-gestion').submit(function(event){
    //    event.preventDefault();
    //    var frm = $('#frm-cambiar-gestion').serialize();
    //    $.ajax({
    //        url: baseurl+'gestion/confirmarCambio',
    //        type: 'post',
    //        data: frm,
    //        success: function (respuesta) {
    //            if(respuesta){
    //                swal('la gestion ha sido cambiada correctamente.');
    //                location.href = baseurl+'inicio';
    //            }
    //        }
    //    });
    //});

});