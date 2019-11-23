
$(document).ready(function () {


});

function buscar() {
    var mes = $('#mes').val();
    var anio = $('#anio').val();
    var suc = $('#sucursal_lcv').val();

    var frm = 'mes='+mes+'&anio='+anio+'&sucursal='+suc;
    $.ajax({
        url: site_url + '/reporte/getFacturasLCV',
        data: frm,
        type: 'post',
        success: function (registro) {

            $('#lista_lcv tbody').empty();
            var datos = JSON.parse(registro);
            if(jQuery.isEmptyObject(datos)){
                $('#lista_lcv tbody').append(
                    '<tr>' +
                    '<td colspan="7">Datos no entontrados</td>' +
                    '</tr>'
                );
            }else{$('#lista_lcv tbody').empty();
                $.each(datos, function(i, item){
                    $('#lista_lcv tbody').append(
                        '<tr>' +
                        '<td class="text-center">'+item.nro_factura+'</td>' +
                        '<td class="text-center">'+item.autorizacion+'</td>' +
                        '<td class="text-center">'+item.fecha+'</td>' +
                        '<td class="text-center">'+item.ci_nit+'</td>' +
                        '<td >'+item.nombre_cliente+'</td>' +
                        '<td class="text-right">'+item.monto_total+'</td>' +
                        '<td class="text-center">'+item.sucursal+'</td>' +
                        '</tr>' +
                        '</table>'
                    );
                });
            }
        }
    });
}
function buscar_clientes() {
    var mes = $('#mes').val();
    var anio = $('#anio').val();
    var suc = $('#sucursal_lcv').val();

    var frm = 'mes='+mes+'&anio='+anio+'&sucursal='+suc;
    $.ajax({
        url: site_url + '/reporte/getClientes',
        data: frm,
        type: 'post',
        success: function (registro) {
            var datos = JSON.parse(registro);
            console.log(datos)
            
            $('#lista_clientes tbody').empty();
            var datos = JSON.parse(registro);
            if(jQuery.isEmptyObject(datos)){
                $('#lista_clientes tbody').append(
                    '<tr>' +
                    '<td colspan="7">Datos no entontrados</td>' +
                    '</tr>'
                );
            }else{$('#lista_clientes tbody').empty();
                $.each(datos, function(i, item){
                    $('#lista_clientes tbody').append(
                        '<tr>' +
                        '<td class="text-center">' + parseFloat(i + 1) + '</td>'  +
                        '<td class="text-center">'+item.ci_nit+'</td>' +
                        '<td class="text-center">'+item.nombre_cliente+'</td>' +
                        '<td class="text-center">'+item.telefono+'</td>' +
                        '<td >'+item.direccion+'</td>' +
                        '<td class="text-right">'+item.email+'</td>' +
                        '</tr>' +
                        '</table>'
                    );
                });
            }
        }
    });
}
function buscar_productos() {
  
    var suc = $('#categoria_id').val();

    var frm = 'categoria='+suc;
    $.ajax({
        url: site_url + '/reporte/getProductos',
        data: frm,
        type: 'post',
        success: function (registro) {
            var datos = JSON.parse(registro);
            console.log(datos)
            
            $('#lista_productos tbody').empty();
            var datos = JSON.parse(registro);
            if(jQuery.isEmptyObject(datos)){
                $('#lista_productos tbody').append(
                    '<tr>' +
                    '<td colspan="7">Datos no entontrados</td>' +
                    '</tr>'
                );
            }else{$('#lista_productos tbody').empty();
                $.each(datos, function(i, item){
                    $('#lista_productos tbody').append(
                        '<tr>' +
                        '<td class="text-center">' + parseFloat(i + 1) + '</td>'  +         
                        '<td class="text-center">'+item.producto+'</td>' +
                        '<td class="text-center">'+item.precio+'</td>' +
                        '<td class="text-center >'+item.estado+'</td>' +
                        '<td class="text-center">'+item.estado+'</td>' +
                        '<td class="text-center">'+item.categoria+'</td>' +
                        '</tr>' +
                        '</table>'
                    );
                });
            }
        }
    });
}
function buscarVentas() {
    var inicio = $('#fecha_inicio').val();
    var fin = $('#fecha_fin').val();
    var frm = 'fi='+inicio+'&ff='+fin;
    $.ajax({
        url: site_url + '/reporte/getVentas',
        data: frm,
        type: 'post',
        success: function (registro) {
            var datos = JSON.parse(registro);
            if(jQuery.isEmptyObject(datos)){
                $('#lista_venta_cliente tbody').append(
                    '<tr>' +
                    '<td colspan="7">Datos no entontrados</td>' +
                    '</tr>'
                );
            }else{
                $('#lista_venta_cliente tbody').empty();
                $.each(datos, function(i, item){
                    $('#lista_venta_cliente tbody').append(
                        '<tr>' +
                        '<td class="text-center">'+ parseFloat(i+1) +'</td>' +
                        '<td class="text-center">'+item.fecha+'</td>' +
                        '<td class="text-center">'+item.ci_nit+'</td>' +
                        '<td >'+item.nombre_cliente+'</td>' +
                        '<td class="text-center">'+item.cantidad+'</td>'+
                        '</tr>' +
                        '</table>'
                    );
                });
            }
        }
    });
}

function exportar_txt_lcv() {
    var mes = $('#mes').val();
    var anio = $('#anio').val();
    var sucursal = $('#sucursal_lcv').val();
    location.href= site_url+ '/reporte/getTxt'+'/'+mes+'/'+anio+'/'+sucursal;
}

function exportar_excel_lcv() {
    var mes = $('#mes').val();
    var anio = $('#anio').val();
    var sucursal = $('#sucursal_lcv').val();
    location.href= site_url+ '/reporte/getExcel'+'/'+mes+'/'+anio+'/'+sucursal;
}

function exportar_excel_clientes() {
  
    location.href= site_url+ 'reporte/getExcelClientes';
}
function exportar_excel_productos() {
   
    var categoria = $('#categoria_id').val();
    location.href= site_url+ '/reporte/getExcelProducto' +'/'+categoria ;
}
