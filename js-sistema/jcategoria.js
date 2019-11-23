
$(document).ready(function () {
    listar_categorias();
    existe_categorias();

    $('#frm_registrar_categoria').submit(function (event) {
        event.preventDefault();

        var formData = $(this).serialize();
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: formData,
            dataType: 'json',
            success: function (respuesta) {
                if (respuesta.success == true) {
                    swal('Datos guardados', '', 'success');
                    $('#frm_registrar_categoria')[0].reset;
                    $('#btn_cerrar_modal_registrar_categoria').click();
                    actualizarDataTable($('#lista_categorias'));
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

    $('#frm_editar_categoria').submit(function (event) {
        event.preventDefault();

        var formData = $(this).serialize();
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: formData,
            dataType: 'json',
            success: function (respuesta) {
                if (respuesta.success == true) {
                    swal('Datos actualizados', '', 'success');
                    $(this)[0].reset;
                    $('#btn_cerrar_modal_editar_categoria').click();
                    actualizarDataTable($('#lista_categorias'));
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

function listar_categorias() {
    $('#lista_categorias').DataTable({
        'paging': true,
        'info': true,
        'filter': true,
        'stateSave': true,

        'ajax': {
            "url": site_url + '/categoria/get_categorias',
            "type": 'posts',
            dataSrc: ''
        },
        'columns': [
            {data: 'id'},
            {data: 'codigo', 'class': 'text-center'},
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
                targets: 3,
                visible: true,
                searchable: false,
                data: 'estado',
                render: function (data, type, row) {
                    return "<span class='label label-success'><i class='fa fa-check'></i> " + row.estado + "</span>";
                }
            },
            {
                targets: 4,
                render: function (data, type, row) {
                    return '<a href="#modal_editar_categoria" data-toggle="modal" onclick="editar_categoria(this);" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i> Editar</a>&nbsp;&nbsp;' +
                        '<a onclick="dar_baja_categoria(this);" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> Eliminar</a>&nbsp;&nbsp;';
                }
            }
        ],

        "order": [[0, "asc"]],
    });
}

function editar_categoria(seleccionado) {
    var table = $('#lista_categorias').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['id'];
    $('#id_categoria').val(id);
    $('#editar_codigo_categoria').val(rowData['codigo']);
    $('#editar_nombre_categoria').val(rowData['nombre_categoria']);
}

function dar_baja_categoria(seleccionado) {
    var table = $('#lista_categorias').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['id'];

    swal({
            title: "Baja de categoria",
            text: "Esta seguro que desea dar de baja esta categoria?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, dar de baja",
            cancelButtonText: "No deseo dar de baja",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: site_url + '/categoria/eliminar_categoria',
                    data: 'id_categoria=' + id,
                    type: 'post',
                    success: function (registro) {
                        if (registro == 'error') {
                            swal("Error", "Problemas al dar baja", "error");
                        } else {
                            swal("Eliminado!", "Baja de categoria correcta", "success");
                            actualizarDataTable($('#lista_categorias'));
                        }
                    }
                });
            } else {
                swal("Cancelado", "Accion cancelada.", "error");
            }
        });
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
function categoria_combo() {
    $.post(site_url + "/categoria/get_categorias",
        function (data) {
            var datos = JSON.parse(data);
            $.each(datos, function (i, item) {
                $('#categorias').append('<option value="' + item.id + '">' + item.nombre_categoria + '</option>');
                $('#editar_categorias').append('<option value="' + item.id + '">' + item.nombre_categoria + '</option>');
                $('#editar_categorias_producto').append('<option value="' + item.id + '">' + item.nombre_categoria + '</option>');
            });
        });
    $('#msj_categoria').hide();
}