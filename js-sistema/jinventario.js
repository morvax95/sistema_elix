
$(document).ready(function () {
    listar_productos();

    $('#frm_registrar_producto').submit(function (event) {
        event.preventDefault();
        var nombre = $('#nombre_producto').val();

        var formData = $(this).serialize();
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: formData,
            dataType: 'json',
            success: function (respuesta) {
                if (respuesta.success == true) {
                    swal('Datos guardados', '', 'success');
                    $('#frm_registrar_producto')[0].reset;
                    $('#btn_cerrar_modal_registrar_producto').click();
                    actualizarDataTable($('#lista_producto'));
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

    $('#frm_editar_producto').submit(function (event) {
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
                    $('#btn_cerrar_modal_editar_producto').click();
                    actualizarDataTable($('#lista_producto'));
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

/*FUNCIONES PARA PRODUCTO*/
function listar_productos() {
    $('#lista_producto').DataTable({
        'paging': true,
        'info': true,
        'filter': true,
        'stateSave': true,

        'ajax': {
            "url": site_url + '/inventario/get_productos',
            "type": 'posts',
            dataSrc: ''
        },
        'columns': [
            {data: 'id'},
            {data: 'categoria_id'},
            {data: 'nombre_producto'},
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
                targets: 1,
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
                    return '<a href="#modal_editar_producto" data-toggle="modal" onclick="editar_producto(this);" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i> Editar</a>&nbsp;&nbsp;' +
                        '<a onclick="dar_baja_producto(this);" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> Eliminar</a>&nbsp;&nbsp;';
                }
            }
        ],

        "order": [[0, "asc"]],
    });
}

function dar_baja_producto(seleccionado) {
    var table = $('#lista_producto').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['id'];

    swal({
            title: "Baja de producto",
            text: "Esta seguro que desea dar de baja este producto?",
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
                    url: site_url + '/inventario/eliminar_producto',
                    data: 'id_producto=' + id,
                    type: 'post',
                    success: function (registro) {
                        if (registro == 'error') {
                            swal("Error", "Problemas al dar baja", "error");
                        } else {
                            swal("Eliminado!", "Baja de producto correcta", "success");
                            actualizarDataTable($('#lista_producto'));
                        }
                    }
                });
            } else {
                swal("Cancelado", "Accion cancelada.", "error");
            }
        });
}

function editar_producto(seleccionado) {
    var table = $('#lista_producto').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['id'];
    $('#id_producto').val(id);
    $('#editar_nombre_producto').val(rowData['nombre_producto']);
    $('#editar_categorias_producto').val(rowData['categoria_id']);
}

/*FUCIONES PARA INVENTARIO*/

function adicionar(id_producto, precio_compra, cantidad) {
    var estilo = "border:0px; width: 100%";
    var contador_fila = $('#contador').val();
    $.post(site_url + '/inventario/adicionar',
        {
            producto: id_producto,
            precio: precio_compra,
            cantidad: cantidad,
            contador: contador_fila
        },
        function (data) {
            var datos = JSON.parse(data);
            var total = datos.total[0]
            $('#subtotal_as').val(total.total);
            $('#total_as').val(total.total);
            $('#contador').val(datos.contador);
            $('#detalle_venta tbody').empty();
            $.each(datos.agregados, function (i, elemt) {
                $('#detalle_venta tbody').append(
                    '<tr>' +
                    '<td>' +
                    '<input hidden type="text" id="id_item" name="id_item[]" value="' + elemt.id + '">' + elemt.nombre_item +
                    '</td>' +
                    '<td>' +
                    '<input type="text" onclick="guardar_cantidad('+datos.contador+')" onkeyup="adicionar_cantidad(' + elemt.id + ',' + elemt.categoria_id + ',' + elemt.usuario_id + ',' + elemt.sucursal_id +','+ datos.contador+','+'event)" class="cantidad_actualiza" style="' + estilo + ';text-align: center" id="cantidad'+datos.contador+'" name="cantidad[]" value="' + elemt.cantidad + '">' +
                    '</td>' +
                    '<td>' +
                    '<input type="text" class="prod" style="' + estilo + ';text-align: center" id="precio" name="precio[]" value="' + elemt.precio_venta + '" readonly>' +
                    '</td>' +
                    '<td class="text-center">' +
                    '<button type="button" onclick="disminuir(' + elemt.id + ',' + elemt.categoria_id + ',' + elemt.usuario_id + ',' + elemt.sucursal_id + ')" class="btn btn-danger btn-xs">-</button>' +
                    '</td>' +
                    '</tr>');
                datos.contador--;
            });
        });
}
