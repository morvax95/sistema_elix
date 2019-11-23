
$(document).ready(function () {


    $('#frm_registrar_venta_r').submit(function (event) {
        event.preventDefault();

        var cantidad_fila = $('#detalle_venta > tbody >tr').length;

        if (cantidad_fila === 0) {
            return swal('No tiene detalle para facturar', '', 'info');
        } else {
            var formData = $('#frm_registrar_venta_r').serialize();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formData,
                dataType: 'json',
                success: function (respuesta) {
                    if (respuesta.success == true) {
                        $('#frm_registrar_venta_r')[0].reset();
                        $('#detalle_venta tbody').empty();
                        mostrar_ventana(site_url + '/venta/imprimirFactura/' + respuesta.message, 'Impresion', '1000', '700');
                    } else {
                        swal('Error', 'Error al registrar los datos.', 'error');
                    }
                }
            });

        }

    });

    /*------------------------------
     Evento de calculadora
     ------------------------------*/
    $('#efectivo_as').keyup(function () {
        if ($('#efectivo_as').val() === "") {
            rellenarCero($('#efectivo_as'));
            rellenarCero($('#cambio_as'));
        } else {
            if ($(this).val() === '0.00') {
                $('#cambio_as').val($('#total_as').val());
            } else {
                var efectivo = $('#efectivo_as').val();
                var cambio = 0;
                cambio = parseFloat(efectivo) - parseFloat($('#total_as').val());
                $('#cambio_as').val(cambio.toFixed(2));
            }
        }
    });

    $('#detalle_venta .cantidad_actualiza').keyup(function () {
        var i = $('.cantidad_actualiza').index(this);
       alert('cantidad: '+i);
    });

    // /*--------------------------------------------
    //  Evento para envio de parametros de la venta
    //  --------------------------------------------*/
    // $('#btn_registrar_factura').click(function (event) {
    //     event.preventDefault();
    //     registrarVenta();
    // });

    function mostrar_ventana(url, title, w, h) {
        var left = 200;
        var top = 50;

        window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
    }

    function limpiarCampos() {
        $('#detalle_as').val('');
        $('#cantidad_as').val(0);
        $('#precio_as').val(0);
        $('#subtotal_as').val('0.00');
        $('#descuento_as').val('0.00');
        $('#total_as').val('0.00');
        $('#efectivo_as').val('0.00');
        $('#cambio_as').val('0.00');
        $('#nit_cliente').val('');
        $('#nombre_cliente').val('');
        $('#idCliente').val('');
        $('#detalle_as').focus();
        tabla.clear();
        tabla.draw();
    }

    /*******************************************************************************
     *  EVENTOS DE LA VISTA DEL FORMULARIO
     * *****************************************************************************/
    $('#subtotal_as').keyup(function () {
        if ($('#subtotal_as').val() === "") {
            rellenarCero($('#subtotal_as'));
            rellenarCero($('#subtotal_as'));
        } else {
            var subtotal = parseFloat($('#subtotal_as').val());
            var porcentaje_descuento = parseFloat($('#descuento_porcentaje').val());
            valor_porcentaje = parseFloat(porcentaje_descuento / 100);
            diferencia = subtotal * valor_porcentaje;
            $('#descuento_as').val(diferencia.toFixed(2))
            total = subtotal - parseFloat(diferencia);
            $('#total_as').val(total.toFixed(2));
        }
    });

    $('#descuento_porcentaje').keyup(function () {
        var subtotal = parseFloat($('#subtotal_as').val());
        var porcentaje_descuento = parseFloat($('#descuento_porcentaje').val());
        if ($('#descuento_porcentaje').val() == "") {
            rellenarCero($('#descuento_porcentaje'));
            total = 0.00;
        }else{
            valor_porcentaje = parseFloat(porcentaje_descuento / 100);
            diferencia = subtotal * valor_porcentaje;
            $('#descuento_as').val(diferencia.toFixed(2))
            total = subtotal - parseFloat(diferencia);
        }
        $('#total_as').val(total.toFixed(2));
    });

    $('#nit_cliente').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: site_url + '/cliente/getCliente',
                dataType: "json",
                data: {
                    name_startsWith: request.term,
                    type: 'ci_nit'
                },
                success: function (data) {
                    response($.map(data, function (item, nombre) {
                        return {
                            label: nombre,
                            value: nombre,
                            id: item
                        };
                    }));
                }
            });
        },
        select: function (event, ui) {
            var Date = (ui.item.id);
            var elem = Date.split('/');
            $('#nombre_cliente').val(elem[0]);
            $('#idCliente').val(elem[1]);
            $('#nit_cliente').val(ui.item.value);
        }
    });

    $('#nombre_cliente').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: site_url + '/cliente/getCliente',
                dataType: "json",
                data: {
                    name_startsWith: request.term,
                    type: 'nombre_cliente'
                },
                success: function (data) {
                    response($.map(data, function (item, nombre) {
                        return {
                            label: nombre,
                            value: nombre,
                            id: item
                        };
                    }));
                }
            });
        },
        select: function (event, ui) {
            var Date = (ui.item.id);
            var elem = Date.split('/');
            $('#nit_cliente').val(elem[0]);
            $('#idCliente').val(elem[1]);
            $('#nombre_cliente').val(ui.item.value);
        }
    });

    $('#detalle_as').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: site_url + 'item/buscar_item',
                dataType: "json",
                data: {
                    name_startsWith: request.term,
                },
                success: function (data) {
                    response($.map(data, function (item, nombre) {
                        return {
                            label: nombre,
                            value: nombre,
                            id: item
                        };
                    }));
                }
            });
        },
        select: function (event, ui) {
            var Date = (ui.item.id);
            var elem = Date.split('/');
            $('#precio_as').val(elem[0]);
        }
    });

    function rellenarCero(elemento) {
        elemento.val('0.00');
    }

    var tecla = 113;
    $(document).keyup(function (e) {
        if (e.keyCode == tecla)
            $('#efectivo_as').focus();
    });
});

function calcularTotales(sub_total_calculado) {
    $('#subtotal_as').val(sub_total_calculado);
    var total = parseFloat(sub_total_calculado) - parseFloat($('#descuento_as').val());
    $('#total_as').val(total.toFixed(2));
}

function actualizarMonto() {
    var filas = $("#grilla > tbody > tr").length;
    var sumandoMontos = 0;
    var indiceFila = 1;
    var montoProducto = "monto";

    $('input[name ="monto[]"]').each(function (indice, elemento) {
        sumandoMontos = sumandoMontos + parseFloat($(elemento).val());
    });
    $('#subTotal').val(sumandoMontos.toFixed(2));
    var descuentoT = sumandoMontos - parseFloat($('#descuentoB').val());

    $('#total').val(descuentoT.toFixed(2));

}

function calcular_montos(cantidad) {
    alert(cantidad);
}
// MEtodo para adicionar al detalle
function adicionar(id_item, id_categoria, id_usuario, id_sucursal) {
    var estilo = "border:0px; width: 100%";
    var contador_fila = $('#contador').val();
    $.post(site_url + '/venta/adicionar',
        {
            item: id_item,
            categoria: id_categoria,
            usuario: id_usuario,
            sucursal: id_sucursal,
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
var anterior_cantidad = 0;
/*Metodo para adicionar cantidad de manera directa*/
function adicionar_cantidad(id_item, id_categoria, id_usuario, id_sucursal, contador,event) {
   /*if (event.keyCode == 40) {*/
       var cantidad = $("#cantidad"+contador).val();
        //alert(cantidad);
        if ($.isNumeric($("#cantidad" + contador).val())) {
            $.post(site_url + '/venta/adicionar_cantidad',
                {
                    item: id_item,
                    categoria: id_categoria,
                    usuario: id_usuario,
                    sucursal: id_sucursal,
                    cantidad: cantidad
                },
                function (data) {
                    var datos = JSON.parse(data);
                    var total = datos.total[0]
                    $('#subtotal_as').val(total.total);
                    $('#total_as').val(total.total);
                   /* $('#contador').val(datos.contador);*/
                    console.log(data);
                    console.log(datos.agregados);
                });
        }
   /* }*/
}
/*Guarda la cantidad anterior*/
function guardar_cantidad(contador) {
    var cantidad = $("#cantidad"+contador).val();
    anterior_cantidad=cantidad;
}
// Diminuye un item seleccionado al detalle
function disminuir(id_item, id_categoria, id_usuario, id_sucursal) {
    var estilo = "border:0px; width: 100%";
    var contador_fila = $('#contador').val();
    $.post(site_url + '/venta/disminuir',
        {
            item: id_item,
            categoria: id_categoria,
            usuario: id_usuario,
            sucursal: id_sucursal,
            contador: contador_fila

        },
        function (data) {
            var datos = JSON.parse(data);
            var total = datos.total[0];
            $('#contador').val(datos.contador);
            if (total.total === null) {
                $('#subtotal_as').val('0.00');
                $('#total_as').val('0.00');
            } else {
                $('#subtotal_as').val(total.total);
                $('#total_as').val(total.total);
            }

            $('#detalle_venta tbody').empty();
            $.each(datos.agregados, function (i, elemt) {
                $('#detalle_venta tbody').append(
                    '<tr>' +
                    '<td>' +
                    '<input readonly style="' + estilo + '" type="text" id="nombre" name="mombre[]" value="' + elemt.nombre_item + '">' +
                    '</td>' +
                    '<td>' +
                    '<input style="' + estilo + ';text-align: center" class="cantidad" type="text" onclick="adicionar_cantidad(' + elemt.id + ',' + elemt.categoria_id + ',' + elemt.usuario_id + ',' + elemt.sucursal_id +','+ datos.contador+ ')" id="cantidad'+datos.contador+'" name="cantidad[]" value="' + elemt.cantidad + '">' +
                    '</td>' +
                    '<td>' +
                    '<input style="' + estilo + ';text-align: center" type="text" id="precio" name="precio[]" value="' + elemt.precio_venta + '">' +
                    '</td>' +
                    '<td class="text-center">' +
                    '<button type="button" onclick="disminuir(' + elemt.id + ',' + elemt.categoria_id + ',' + elemt.usuario_id + ',' + elemt.sucursal_id + ')" class="btn btn-danger btn-sm">-</button>' +
                    '</td>' +
                    '</tr>');
                datos.contador--;
            });
        });
}
