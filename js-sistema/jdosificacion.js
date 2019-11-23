
$(document).ready(function () {
    obtenerDosificaciones();

    $('#frm_registrar_dosificacion').submit(function (event) {
        event.preventDefault();

        if (($('#impresora').val() === '0') || ($('#actividad').val() === '0')) {
            swal('Advertencia', 'Seleccione una impresora y una actividad para esta dosificacion.', 'warning');
            return true;
        }
        var formData = $('#frm_registrar_dosificacion').serialize();
        $.ajax({
            url: $(this).attr('action'),
            type: 'post',
            data: formData,
            dataType: 'json',
            success: function (respuesta) {
                if (respuesta.success == true) {
                    swal('Datos modificados correctamente','', 'success');
                    $('#frm_registrar_dosificacion')[0].reset();
                } else {
                    $('.error').remove();
                    if (respuesta.messages != null) {
                        $.each(respuesta.messages, function (key, value) {
                            var element = $('#' + key);
                            element.closest('input .form-control').find('.error').remove();
                            element.after(value);
                        });
                    } else {
                        swal('Error', 'Error al registrar los datos.', 'error');
                    }
                }
            }
        });
    });
});


function obtenerDosificaciones(){
    $('#lista_dosificaciones').DataTable({
        'paging' : true,
        'info'   : true,
        'filter' : true,
        'stateSave': true,

        'ajax':{
            "url": site_url + "/dosificacion/obtenerDosificaciones",
            "type": "post",
            dataSrc: ''
        },

        'columns': [
            {data: 'id'},
            {data: 'autorizacion'},
            {data: 'nombre_actividad'},
            {data: 'sucursal'},
            {data: 'impresora'},
            {data: 'fecha_limite', class: 'text-center'},
            {data: 'estado', class: 'text-center'},
            {data: 'opciones', class: 'text-center'},
        ],
        "columnDefs":[
            {
                targets: 0,
                visible: false,
                searchable: false,
            },
            {
                targets: 6,
                visible: true,
                searchable: false,
                data: 'estado',
                "render": function (data, type, row) {
                    switch (row.estado){
                        case 'INACTIVO':
                            return "<span style='font-size: 9pt' class='label label-warning'><i class='fa fa-times'></i> &nbsp;"+row.estado+"</span>"
                            break;
                        case 'ACTIVO':
                            return "<span style='font-size: 9pt' class='label label-success'><i class='fa fa-check-circle-o'></i> &nbsp;"+row.estado+"</span>"
                            break;
                        case 'CADUCADO':
                            return "<span style='font-size: 9pt' class='label label-danger'><i class='fa fa-arrow-down'></i> &nbsp;"+row.estado+"</span>"
                            break
                    }
                }
            },
            {
                targets: 7,
                render: function(data, type, row) {
                    switch(row.estado){
                        case 'INACTIVO':
                            //return '<a data-toggle="modal" role="button" href="#modal-editar-actividad" onclick="editarDosificacion(this)" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Editar</a>&nbsp;&nbsp;'+
                                return '<a onclick="activarDosificacion(this)" class="btn btn-success btn-xs"><i class="fa fa-arrow-up"></i> Activar</a>&nbsp;&nbsp;';
                            break;
                        case 'ACTIVO':
                            return '';
                            break;
                        case 'CADUCADO':
                            return '';
                            break;
                    }
                }
            }
        ]
    });
}

function activarDosificacion(seleccionado){
    var table = $('#lista_dosificaciones').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['id'];

    swal({
            title: "ACTIVIAR DOSIFICACION",
            text: "Esta a punto de activvar su dosificacion para realizar facturas.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, activar dosificacion",
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: site_url + '/dosificacion/activar',
                    data: 'id_dosificacion=' + id,
                    type: 'post',
                    success: function (registro) {
                        if (registro == 'error') {
                            swal("Error", "Problemas al activar", "error");
                        } else {
                            swal("Activado", "La dosificacion esta habilitada", "success");
                            actualizarDataTable($('#lista_dosificaciones'));
                        }
                    }
                });
            } else {
                swal("Cancelado", "Accion cancelada.", "error");
            }
        });
}