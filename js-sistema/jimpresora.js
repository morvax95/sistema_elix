$(document).ready(function () {
    listarImpresora();

    /*------------------------      FORMMULARIOS PARA REGISTRAR Y MODIFICAR UNA IMPRESORA      -----------------------*/
    $('#frm_registro_impresora').submit(function (event) {
        event.preventDefault();

        var formData = $('#frm_registro_impresora').serialize();
        $.ajax({
            url: $(this).attr('action'),
            type: 'post',
            data: formData,
            dataType: 'json',
            success: function (respuesta) {
                if (respuesta.success == true) {
                    $('#frm_registro_impresora')[0].reset();
                    swal('Datos modificados correctamente','', 'success');
                    $('#btn_cerrar_modal_registrar_impresora').click();
                    actualizarDataTable($('#lista_impresora'));
                    var sw = $('#sw').val();
                    if (sw=='1'){
                        cargarImpresoras();
                    }
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
                        swal('Error', 'Error al registrar los datos.', 'error');
                    }
                }
            }
        });
    });

    $('#frm_editar_impresora').submit(function (event) {
        event.preventDefault();

        var formData = $('#frm_editar_impresora').serialize();
        $.ajax({
            url: $(this).attr('action'),
            type: 'post',
            data: formData,
            dataType: 'json',
            success: function (respuesta) {
                if (respuesta.success == true) {
                    $('#frm_editar_impresora')[0].reset();
                    swal('Datos modificados correctamente','', 'success');
                    $('#btn_cerrar_modal_editar_impresora').click();
                    actualizarDataTable($('#lista_impresora'));
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
                        swal('Error', 'Error al modificados los datos.', 'error');
                    }
                }
            }
        });

    });
})
;


/*-----------------------------------      FUNCION PARA LISTAR LOS TIPOS DE ALMACENES     ----------------------------*/
function listarImpresora() {
    $('#lista_impresora').DataTable({
        'paging': true,
        'info': true,
        'filter': true,
        'stateSave': true,

        'ajax': {
            "url": site_url + "/impresora/obtenerImpresoras",
            "type": "post",
            dataSrc: ''
        },

        'columns': [
            {data: 'id'},
            {data: 'marca', 'class': 'dt-body-center'},
            {data: 'serial', 'class': 'dt-body-center'},
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
                targets: 3,
                visible: true,
                searchable: false,
                data: 'estado',
                "render": function (data, type, row) {
                    if (data == 0) {
                        return "<span class='label label-danger'><i class='fa fa-times'></i> Deshabilitado</span>"
                    } else if (data == 1) {
                        return "<span class='label label-success'><i class='fa fa-check'></i> Habilitado</span>"
                    }
                }
            },

            {
                targets: 4,
                render: function (data, type, row) {
                    if (row.estado != 0) {

                        return '<a data-toggle="modal" role="button" href="#modal_editar_impresora" onclick="obtenerImpresora(this)" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i> Editar.</a>&nbsp;&nbsp;' +
                            '<a class="btn btn-danger btn-xs" onclick="eliminarImpresora(this)"><i class="fa fa-times-circle-o"></i> Eliminar</a>&nbsp;&nbsp;';
                    } else {
                        return '<a data-toggle="modal" role="button" onclick="reactivarImpresora(this)" class="btn btn-success btn-xs"><i class="fa fa-arrow-up"></i> Reactivar</a>';
                    }
                }
            }
        ],
        "order": [[0, "asc"]],
    });
}

/*--------------------------------      FUNCION PARA SELECCIONAR UNA IMPRESORA      ----------------------------------*/
function obtenerImpresora(seleccionado) {
    var table = $('#lista_impresora').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['id'];
    var marca = rowData['marca'];
    var serie = rowData['serial'];

    $('#id_impresora').val(id);
    $('#edita_marca').val(marca);
    $('#edita_serial').val(serie);
}

/*-------------------------------      FUNCION PARA REACTIVAR UNA IMPRESORA       ------------------------------------*/
function reactivarImpresora(seleccionado) {
    var table = $('#lista_impresora').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['id'];
    swal({
            title: "HABILITAR IMPRESORA",
            text: "Esta seguro que desea habilitar la impresora seleccionada?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, habilitar",
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: site_url + '/impresora/habilitar',
                    data: 'id_impresora=' + id,
                    type: 'post',
                    success: function (registro) {
                        if (registro == 'error') {
                            swal("Error", "Problemas al habilitar", "error");
                        } else {
                            swal("Reactivado!", "La impresora ha sido habilitada.", "success");
                            actualizarDataTable($('#lista_impresora'));
                        }
                    }
                });
            } else {
                swal("Cancelado", "Accion cancelada.", "error");
            }
        });
}
/*----------------------------------       FUNCION PARA ELIMINAR UNA IMPRESORA      ----------------------------------*/
function eliminarImpresora(seleccionado) {
    var table = $('#lista_impresora').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['id'];
    swal({
            title: "DEHABILITAR IMPRESORA",
            text: "Esta seguro que desea desactivar los datos de la impresora seleccionada?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, desactivar",
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: site_url + '/impresora/darBaja',
                    data: 'id_impresora=' + id,
                    type: 'post',
                    success: function (registro) {
                        if (registro == 'error') {
                            swal("Error", "Problemas al deactivar", "error");
                        } else {
                            swal("Eliminado!", "La impresora ha sido desactivada.", "success");
                            actualizarDataTable($('#lista_impresora'));
                        }
                    }
                });
            } else {
                swal("Cancelado", "Accion cancelada.", "error");
            }
        });
}
