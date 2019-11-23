
$(document).ready(function(){
    obtenerUsuarios();


    /****** verificamos si el cargo que se esta eligiendo es el administrador *****/
    $('#cargo').change(function () {
        var valor = $('#cargo').val();
        if (valor == 'ADMINISTRADOR') {
            $('#funciones').hide();
        } else {
            $('#funciones').show();
            cargarFunciones();
        }
    });

    $('#cargo-editar').change(function () {
        var valor = $('#cargo-editar').val();
        if (valor == 'ADMINISTRADOR') {
            $('#privilegios-editar').hide();
        } else {
            $('#privilegios-editar').show();
        }
    });

    $('#frm-registrar-usuario').submit(function (event) {
        event.preventDefault();

        var formData = $('#frm-registrar-usuario').serialize();
        $.ajax({
            url: $(this).attr('action'),
            type: 'post',
            data: formData,
            dataType: 'json',
            success: function (respuesta) {
                if (respuesta.success == true) {
                    $('#frm-registrar-usuario')[0].reset();
                    $('#funciones').empty();
                    swal('Datos registrados correctamente','', 'success');
                } else {
                    $('.error').remove();
                    if (respuesta.messages != null) {
                        $.each(respuesta.messages, function (key, value) {
                            // Usá la versión 2.x de jquery
                            var element = $('#' + key);
                            element.closest('input .form-control').find('.error').remove();
                            element.after(value);
                        });
                    } else {
                        swal('Error', 'Eror al registrar los datos.', 'error');
                    }
                }
            }
        });
    });

    $('#frm-editar-usuario').submit(function (event) {
        event.preventDefault();

        var formData = $('#frm-editar-usuario').serialize();
        $.ajax({
            url: $(this).attr('action'),
            type: 'post',
            data: formData,
            dataType: 'json',
            success: function (respuesta) {
                if (respuesta.success == true) {
                    swal('Datos registrados correctamente','', 'success');
                    setTimeout(location.href = site_url+'/usuario',3000);
                } else {
                    $('.error').remove();
                    if (respuesta.messages != null) {
                        $.each(respuesta.messages, function (key, value) {
                            // Usá la versión 2.x de jquery
                            var element = $('#' + key);
                            element.closest('input .form-control').find('.error').remove();
                            element.after(value);
                        });
                    } else {
                        swal('Error', 'Eror al registrar los datos.', 'error');
                    }
                }
            }
        });
    });
});

function obtenerUsuarios(){
    $('#lista-usuario').DataTable({
        'paging': true,
        'info': true,
        'filter': true,
        'stateSave': true,

        'ajax': {
            "url": site_url + "/usuario/obtener_usuarios",
            "type": "post",
            dataSrc: ''
        },
        'columns': [
            {data: 'id'},
            {data: 'ci', class: 'text-center'},
            {data: 'nombre_usuario'},
            {data: 'cargo', class: 'text-center'},
            {data: 'telefono', class: 'text-center'},
            {data: 'usuario', class: 'text-center'},
            {data: 'estado', class: 'text-center'},
            {data: 'opciones', class: 'text-center'},
        ],
        "columnDefs": [
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
                    if (data == 0) {
                        return "<span class='label label-danger'><i class='fa fa-times'></i> Inactivo</span>"
                    } else if (data == 1) {
                        return "<span class='label label-success'><i class='fa fa-check'></i> Habilitado</span>"
                    }
                }
            },
            {
                targets:7,
                render: function (data, type, row) {
                    if (row.estado != 0) {

                        return '<a onclick="editar(this);" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Editar</a>&nbsp;&nbsp;' +
                            '<a onclick="eliminar(this);" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Eliminar</a>&nbsp;&nbsp;';
                    } else {
                        return '<a onclick="reactivar(this);" class="btn btn-primary btn-xs"><i class="fa fa-upload"></i> Reactivar usuario</a>&nbsp;&nbsp;';
                    }
                }
            }
        ],


        "order": [[0, "asc"]],
    });
}

function eliminar(seleccionado) {
    var table = $('#lista-usuario').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['id'];
    swal({
            title: "Esta seguro que desea eliminar a este usuario?",
            text: "El estado del usuario cambiara, los datos seguiran mostrandose.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, eliminar usuario!",
            cancelButtonText: "No deseo eliminar al usuario",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: site_url + '/usuario/eliminar',
                    data: 'id_usuario=' + id,
                    type: 'post',
                    success: function (registro) {
                        if (registro == 'error') {
                            swal("Error", "Problemas al eliminar", "error");
                        } else {
                            swal("Eliminado!", "El usuario ha sido eliminado.", "success");
                            actualizarDataTable($('#lista-usuario'));
                        }
                    }
                });
            } else {
                swal("Cancelado", "Accion cancelada.", "error");
            }
        });
}

function reactivar(seleccionado){
    var table = $('#lista-usuario').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['id'];
    swal({
            title: "Esta seguro que desea volver a activar a este usuario?",
            text: "Se cambiara el estado de usuario a activo.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, activar usuario!",
            cancelButtonText: "No deseo activar al usuario",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: site_url + '/usuario/reactivar',
                    data: 'id_usuario=' + id,
                    type: 'post',
                    success: function (registro) {
                        if (registro == 'error') {
                            swal("Error", "Problemas al activar, comuniquese con el administrador del sistema", "error");
                        } else {
                            swal("Activado!", "El usuario ha sido activado.", "success");
                            actualizarDataTable($('#lista-usuario'));
                        }
                    }
                });
            } else {
                swal("Cancelado", "Accion cancelada.", "error");
            }
        });
}

function cargarFunciones(){
    $.post(site_url + "/usuario/obtener_privilegios",
        function (data) {
            var datos = JSON.parse(data);
            $('#funciones').empty();
            $.each(datos, function (i, item) {
                $('#funciones').append(
                    '<div class="checkbox">' +
                    '<label style="padding: 0%" >' +
                    '<input type="checkbox" id="menu" name="menu[]" value="'+item.id+'">&nbsp;' + item.name +'' +
                    '</label>' +
                    '</div>');
            });
        });
}

function editar(seleccionado){
    var table = $('#lista-usuario').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['id'];
    var ci = rowData['ci'];
    var nombre = rowData['nombre_usuario'];
    var telefono = rowData['telefono'];
    var usuario = rowData['usuario'];
    var cargo = rowData['cargo'];

    $.redirect(site_url + '/usuario/editar', {
        idusuario: id,
        ci: ci,
        nombre: nombre,
        telf: telefono,
        usuario: usuario,
        cargo: cargo
    });
}