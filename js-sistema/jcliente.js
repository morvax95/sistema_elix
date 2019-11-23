
$(document).ready(function () {
    //obtener_bancos();
    obtener_clientes();


    $('#frm_registrar_cliente').submit(function (event) {
        event.preventDefault();

        var formData = $(this).serialize();
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: formData,
            dataType: 'json',
            success: function (respuesta) {
                if (respuesta.success == true) {
                    swal('Datos guardados','', 'success');
                    $(this)[0].reset();
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

    $('#frm_editar_cliente').submit(function (event) {
        event.preventDefault();

        var formData = $(this).serialize();
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: formData,
            dataType: 'json',
            success: function (respuesta) {
                if (respuesta.success == true) {
                    swal('Datos actualizados','', 'success');
                    $('#frm_editar_cliente')[0].reset();
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

function editar_cliente() {
    datos_formulario($('#frm_editar_cliente'));
    $('#btn_cerrar_modal_editar').click();
    actualizarDataTable($('#lista_cliente'));
}

function obtener_clientes() {
    // $('#lista_cliente').DataTable().destroy();
    $('#lista_cliente').DataTable({
        'lengthMenu': [[20,60,150,250,300],[20,60,150,250,300]],
        'paging': true,
        'info': true,
        'filter': true,
        'stateSave': true,
        'processing': true,
        'serverSide': true,

        'ajax': {
            "url": site_url + "/cliente/listar_clientes_server_side",
            "type": "post",
            dataSrc: ''
        },
        'columns': [
            {data: 'id'},
            {data: 'ci_nit', 'class': 'dt-body-center'},
            {data: 'nombre_cliente'},
            {data: 'telefono'},
            {data: 'direccion'},
            {data: 'email'},
            {data: 'estado', class: 'text-center'},
            {data: 'opciones', class: 'text-center'}
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
                render: function (data, type, row) {
                    if (data == 0) {
                        return "<span class='label label-danger'><i class='fa fa-times'></i> Deshabilitado</span>"
                    } else if (data == 3) {
                        return "<span class='label label-success'><i class='fa fa-check'></i> Habilitado</span>"
                    }else{
                        return "<span class='label label-success'><i class='fa fa-check'></i> Habilitado</span>"
                    }
                }
            },
            {
                targets: 7,
                render: function (data, type, row) {
                  
                        if (row.estado === '1') {
                            return '<a data-toggle="modal" role="button" href="#modal_ver_cliente" onclick="verCliente(this);" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i> Ver</a>&nbsp;&nbsp;' +
                                '<a href="#modal_editar_cliente" data-toggle="modal" onclick="editarCliente(this);" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i> Editar</a>&nbsp;&nbsp;' +
                                '<a onclick="desactivarCliente(this);" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> Eliminar</a>&nbsp;&nbsp;';
                        } else {
                            return '<a onclick="habilitarCliente(this);" class="btn btn-default btn-xs text-black"><i class="fa fa-arrow-up"></i> Habilitar</a>';
                        }
                    
                }
            },
            {
                targets: 2,
                data: "nombre_cliente",
                render: function (data, type, row) {
                    return "<spam style='color:#0d6aad; font-weight: bold;'> " + data + "</spam>"
                }
            },
            {
                targets: 3,
                data: "telefono_cliente",
                render: function (data, type, row) {
                    return "<spam style='font-size: 12pt;'><i class='fa fa-phone'></i> &nbsp;" + data + "</spam>"
                }
            }


        ],


        "order": [[ 1, "asc" ]],
    });
}

function editarCliente(seleccionado) {
    var table = $('#lista_cliente').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['id'];
    var nombre = rowData['nombre_cliente'];
    var nit = rowData['ci_nit'];
    var telefono = rowData['telefono'];
    var direccion = rowData['direccion'];
    var email = rowData['email'];

    $('#cliente_id').val(id);
    $('#editar_ci').val(nit);
    $('#editar_telefono').val(telefono);
    $('#editar_nombre').val(nombre);
    $('#editar_direccion').val(direccion);
    $('#editar_email').val(email);
}
//
function desactivarCliente(seleccionado) {
    var table = $('#lista_cliente').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['id'];
    swal({
            title: "DESACTIVAR CLIENTE",
            text: "Esta seguro de desactivar a este cliente? No podra ser usado para generar facturas",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, eliminar cliente!",
            cancelButtonText: "No deseo eliminar al cliente",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: site_url + '/cliente/eliminar',
                    data: 'id_cliente=' + id,
                    type: 'post',
                    success: function (registro) {
                        if (registro == 'error') {
                            swal("Error", "Problemas al eliminar", "error");
                        } else {
                            swal("Eliminado!", "El cliente ha sido eliminado.", "success");
                            actualizarDataTable($('#lista_cliente'));
                        }
                    }
                });
            } else {
                swal("Cancelado", "Accion cancelada.", "error");
            }
        });
}

/*------------- Funcion para visualizar los datos del cliente  --------------------*/
function verCliente(seleccionado) {
    var table = $('#lista_cliente').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['id'];
    var nombre = rowData['nombre_cliente'];
    var nit = rowData['ci_nit'];
    var telefono = rowData['telefono'];
    var direccion = rowData['direccion'];
    var email = rowData['email'];

    $('#ver_ci').val(nit);
    $('#ver_telefono').val(telefono);
    $('#ver_nombre').val(nombre);
    $('#ver_direccion').val(direccion);
    $('#ver_email').val(email);
}

function habilitarCliente(seleccionado) {
    var table = $('#lista_cliente').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['id'];

    swal({
            title: "HABILITAR CLIENTE",
            text: "Este cliente sera reactivado, esta seguro?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, activar cliente!",
            cancelButtonText: "No deseo activar al cliente",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: site_url + '/cliente/habilitar',
                    data: 'id_cliente=' + id,
                    type: 'post',
                    success: function (registro) {
                        if (registro == 'error') {
                            swal("Error", "Problemas al habilitar", "error");
                        } else {
                            swal("Habilitado!", "El cliente ha sido habilitado.", "success");
                            actualizarDataTable($('#lista_cliente'));
                        }
                    }
                });
            } else {
                swal("Cancelado", "Accion cancelada.", "error");
            }
        });
}
