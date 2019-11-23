

$(document).ready(function () {
    obtenerListaFacturas();
    reimpresion_facturas();
});

function obtenerListaFacturas() {
    $('#lista_facturas').DataTable({
        'paging': true,
        'info': true,
        'filter': true,
        'stateSave': true,
        'responsive': true,
        'processing': true,
        'serverSide': true,

        'ajax': {
            "url": site_url + "/consultar_venta/obtener_lista_factura_server_side",
            "type": "post",
            dataSrc: ''
        },

        'columns': [
            {data: 'id'},
            {data: 'nro_factura', class: 'text-center'},
            {data: 'autorizacion', class: 'text-center'},
            {data: 'fecha_transaccion', class: 'text-center'},
            {data: 'nombre_cliente'},
            {data: 'monto_total',class: 'text-center'},
            {data: 'imprimir', class: 'text-center'},
            {data: 'anular', class: 'text-center'},
        ],
        "columnDefs": [
            {
                targets: 0,
                visible: false,
                searchable: false,
            },
            {
                targets: 6,

                render: function (data, type, row) {
                    if (row.nombre_cliente != 'ANULADO') {
                        return '<a role="button"  onclick="reimprimirFacturaCopia1(this)"  ><img width="30" height="30" src="'+site_url+'assets/img/imprimir.png" title="Buscar"></a>&nbsp;&nbsp;';

                    }
                    return '';
                }
            },
            {
                targets: 7,
                render: function (data, type, row) {
                    if (row.nombre_cliente != 'ANULADO') {
                        return '<a  role="button"  onclick="anularFactura(this)" ><img width="30" height="30" src="'+site_url+'assets/img/anular.png" title="Anular"></a>&nbsp;&nbsp;';

                    }
                    return '';
                }
            }
        ],
        "order": [[0, "asc"]],
    });

}


function reimpresion_facturas() {
    $('#lista_reimpresion_facturas').DataTable({
        'paging': true,
        'info': true,
        'filter': true,
        'stateSave': true,
        'responsive': true,
        'processing': true,
        'serverSide': true,

        'ajax': {
            "url": site_url + "/consultar_venta/obtener_lista_factura_server_side",
            "type": "post",
            dataSrc: ''
        },

        'columns': [
            {data: 'id'},
            {data: 'nro_factura', class: 'text-center'},
            {data: 'autorizacion', class: 'text-center'},
            {data: 'fecha_transaccion', class: 'text-center'},
            {data: 'nombre_cliente'},
            {data: 'monto_total',class: 'text-center'},
            {data: 'imprimir', class: 'text-center'},
        ],
        "columnDefs": [
            {
                targets: 0,
                visible: false,
                searchable: false,
            },
            {
                targets: 6,

                render: function (data, type, row) {
                    if (row.nombre_cliente != 'ANULADO') {
                        return '<a role="button"  onclick="reimprimirFacturaCopia(this)"  ><img width="30" height="30" src="'+site_url+'assets/img/imprimir.png" title="Buscar"></a>&nbsp;&nbsp;';

                    }
                    return '';
                }
            }
        ],
        "order": [[0, "asc"]],
    });

}


function anularFactura(seleccionado) {
    var table = $('#lista_facturas').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['id']
    swal({
            title: "ANULAR FACTURA " + rowData['nro_factura'],
            text: "Esta seguro de anular esta factura?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, anular!",
            cancelButtonText: "No deseo anular",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: site_url + 'consultar_venta/anularFactura',
                    data: 'id_venta=' + id,
                    type: 'post',
                    success: function (registro) {
                        if (registro == 'error') {
                            swal("Error", "Problemas al anular", "error");
                        } else {
                            swal("Anulada!", "Factura anulada", "success");
                            actualizarDataTable($('#lista_facturas'));
                        }
                    }
                });
            } else {
                swal("Cancelado", "Accion cancelada.", "error");
            }
        });
}

function reimprimirFacturaCopia(seleccionado) {
    var table = $('#lista_reimpresion_facturas').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['id']
    mostrar_ventana_consulta(site_url + '/consultar_venta/imprimirCopiaFactura/' + id, 'Copia factura','1000', '700');
}

function reimprimirFacturaCopia1(seleccionado) {
    var table = $('#lista_facturas').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['id']
    mostrar_ventana_consulta(site_url + '/consultar_venta/imprimirCopiaFactura/' + id, 'Copia factura','1000', '700');
}


function mostrar_ventana_consulta(url, title, w, h) {
    var left = 200;
    var top = 50;

    window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}