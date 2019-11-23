
$(document).ready(function () {
    listar_items();
    existe_categorias();

    /** Eventos **/
    $('#tipo_item').change(function () {
        if ($(this).val() === 'SERVICIO') {
            $('#ingreso_stock').hide();
        } else {
            $('#ingreso_stock').show();
        }
    });

    $('#frm_registrar_item').submit(function (event) {
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
                    $('#frm_registrar_item')[0].reset();
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

    $('#frm_editar_item').submit(function (event) {
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
                    $('#btn_cerrar_modal_editar_item').click();
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

function listar_items() {
    $('#lista_item').DataTable({
        'paging': true,
        'info': true,
        'filter': true,
        'stateSave': true,

        'ajax': {
            "url": site_url + '/item/get_lista_item',
            "type": 'posts',
            dataSrc: ''
        },
        'columns': [
            {data: 'id'},
            {data: 'nombre_item'},
            {data: 'precio_venta'},
            {data: 'tamaño'},
            {data: 'categoria_id'},
            {data: 'nombre_categoria'},
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
                targets: 4,
                visible: false,
                searchable: false,
            },
            {
                targets: 6,
                visible: true,
                searchable: false,
                data: 'estado',
                render: function (data, type, row) {
                    if (row.estado == 'INACTIVO') {
                        return "<span class='label label-danger'><i class='fa fa-times'></i> "+row.estado+"</span>"
                    } else if (row.estado == 'ACTIVO') {
                        return "<span class='label label-success'><i class='fa fa-check'></i>"+row.estado+"</span>"
                    }
                }
            },
            {
                targets: 7,
                render: function (data, type, row) {
                    if (row.estado != 'INACTIVO') {

                        return '<a href="#modal_editar_item" data-toggle="modal" onclick="pasar_datos(this);" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i> Editar</a>&nbsp;&nbsp;' +
                            '<a onclick="dar_baja_item(this);" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> Eliminar</a>&nbsp;&nbsp;';
                    } else {
                        return '';
                    }
                }
            }
        ],

        "order": [[0, "asc"]],
    });
}

function pasar_datos(seleccionado) {
    var table = $('#lista_item').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['id'];
    $('#id_item').val(id);
    // $('#edita_codigo_barras').val(rowData['codigo_barra']);
    // $('#edita_codigo_alterno').val(rowData['codigo_alterno']);
    $('#editar_nombre_item').val(rowData['nombre_item']);
    $('#editar_precio_venta').val(rowData['precio_venta']);
    $('#editar_tamaño').val(rowData['tamaño']);
    $('#editar_categorias').val(rowData['categoria_id']);
}

function dar_baja_item(seleccionado) {
    var table = $('#lista_item').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['id'];
    swal({
            title: "Baja de item",
            text: "Esta seguro que desea dar de baja este item?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, dar de baja",
            cancelButtonText: "No, cancelar",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: site_url + '/item/eliminar',
                    data: 'id_item=' + id,
                    type: 'post',
                    success: function (registro) {
                        if (registro == 'error') {
                            swal("Error", "Problemas al dar baja", "error");
                        } else {
                            swal("Eliminado!", "Baja de item correcta", "success");
                            actualizarDataTable($('#lista_item'));
                        }
                    }
                });
            } else {
                swal("Cancelado", "Accion cancelada.", "error");
            }
        });
}

function mostrar_formulario_categoria() {
    // $('#frm_registrar_categoria')[0].reset;
    $('#modal_registro_categoria').modal({
        show: true,
        backdrop: 'static'
    });
}

function categoria_combo() {
    $.post(site_url + "/categoria/get_categorias",
        function (data) {
            var datos = JSON.parse(data);
            $.each(datos, function (i, item) {
                $('#categorias').append('<option value="' + item.id + '">' + item.nombre_categoria + '</option>');
                $('#editar_categorias').append('<option value="' + item.id + '">' + item.nombre_categoria + '</option>');
            });
        });
    $('#msj_categoria').hide();
}

function existe_categorias() {
    $.ajax({
        url: site_url + '/categoria/existe_categoria',
        success: function (data) {
            if (data === '0') {
                $('#msj_categoria').show();
            } else {
                categoria_combo();
            }
        }
    })
}



