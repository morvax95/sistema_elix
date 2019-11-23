$(document).ready(function(){
    listarActividad();
    /*------------------------      FORMMULARIOS PARA REGISTRAR Y MODIFICAR UNA IMPRESORA      -----------------------*/
    $('#frm-registrar-actividad').submit(function (event) {
        event.preventDefault();

            if ($('#actividad-sucursal').val() != 0) {
                var formData = $('#frm-registrar-actividad').serialize();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'post',
                    data: formData,
                    dataType: 'json',
                    success: function (respuesta) {

                        if (respuesta.success == true) {
                            $('#frm-registrar-actividad')[0].reset();
                            swal('Datos modificados correctamente','', 'success');
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
            } else {
                swal('Alerta !!!', 'Debe seleccionar por lo menos una sucursal.', 'warning');
            }
    });

    $('#frm-editar-actividad').submit(function (event) {
        event.preventDefault();

        if ($('#sucursal-actividad').val() != 0) {
            var formData = $('#frm-editar-actividad').serialize();
            $.ajax({
                url: $(this).attr('action'),
                type: 'post',
                data: formData,
                dataType: 'json',
                success: function (respuesta) {

                    if (respuesta.success == true) {
                        $('#frm-editar-actividad')[0].reset();
                        recargarTablaActividad();
                        swal('Datos modificados correctamente','', 'success');
                        $('#btn-cerrar-modal-editar-actividad').click();
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
                            swal('Error', 'Error al modificar los datos.', 'error');
                        }
                    }
                }
            });
        } else {
            swal('Alerta !!!', 'Debe seleccionar por lo menos una sucursal.', 'warning');
        }
    });
});

/*------------------------------------      FUNCION PARA LISTAR LAS ACTIVIDADES      ---------------------------------*/
function listarActividad(){
    $('#lista-actividad').DataTable({
        'paging' : true,
        'info'   : true,
        'filter' : true,
        'stateSave': true,

        'ajax':{
            "url": site_url + "/actividad/listarActividad",
            "type": "post",
            dataSrc: ''
        },

        'columns': [
            {data: 'id'},
            {data: 'nombre_actividad'},
            {data: 'direccion'},
            {data: 'telefono'},
            {data: 'email'},
            {data: 'ciudad', class: 'text-center'},
            {data: 'sucursal', class: 'text-center'},
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
                targets: 7,
                visible: true,
                searchable: false,
                data: 'estado',
                "render": function (data, type, row) {
                    if(data == 0){
                        return "<span class='label label-danger'><i class='fa fa-times'></i> Desactivado</span>"
                    }else if(data == 1){
                        return "<span class='label label-success'><i class='fa fa-check'></i> Habilitado</span>"
                    }
                }
            },
            {
                targets: 8,
                render: function(data, type, row) {
                    if(row.estado != 0){
                        return '<a data-toggle="modal" role="button" href="#modal-editar-actividad" onclick="obtenerActividad(this)" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Editar.</a>&nbsp;&nbsp;' +
                            '<a onclick="eliminarActividad(this)" class="btn btn-danger btn-xs"><i class="fa fa-times-circle"></i> Desactivar.</a>&nbsp;&nbsp;';
                    }else{
                        return '<a onclick="habilitarActividad(this);" class="btn btn-default btn-xs text-black"><i class="fa fa-arrow-up"></i> Habilitar</a>';
                    }
                }
            }
        ],
        "order":[[0, "asc"]],
    });
}

/*--------------------------------      FUNCION PARA SELECCIONAR UNA ACTIVIDAD      ----------------------------------*/
function obtenerActividad(seleccionado){
    var table = $('#lista-actividad').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['id'];
    var nombre = rowData['nombre_actividad'];
    var direccion = rowData['direccion'];
    var telefono = rowData['telefono'];
    var email = rowData['email'];
    var celular = rowData['celular'];
    var ciudad = rowData['ciudad'];


    $('#id-actividad').val(id);
    $('#nombre-actividad').val(nombre);
    $('#direccion-actividad').val(direccion);
    $('#telefono-actividad').val(telefono);
    $('#email-actividad').val(email);
    $('#celular-actividad').val(celular);
    $('#ciudad-actividad').val(ciudad);
}

/*-----------------------------------------------------
    Funcion para desactivar la actividad
 ------------------------------------------------------
 */
function eliminarActividad(seleccionado){
    var table = $('#lista-actividad').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['id'];
    swal({
            title: "DESACTIVAR ACTIVIDAD",
            text: "Esta seguro de desactivar esta actividad?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, desactivar actividad!",
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: site_url + '/actividad/eliminar',
                    data: 'id_actividad=' + id,
                    type: 'post',
                    success: function (registro) {
                        if (registro == 'error') {
                            swal("Error", "Problemas al desactivar", "error");
                        } else {
                            swal("Desactivado!", "La actividad ha sido desactivada.", "success");
                            actualizarDataTable($('#lista-actividad'));
                        }
                    }
                });
            } else {
                swal("Cancelado", "Accion cancelada.", "error");
            }
        });
}

function habilitarActividad(seleccionado){
    var table = $('#lista-actividad').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['id'];

    swal({
            title: "HABILITAR ACTIVIDAD",
            text: "Esta seguro de habilitar nuevamente la actividad?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, activar!",
            cancelButtonText: "No deseo activar",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: site_url + '/actividad/habilitar',
                    data: 'id_actividad=' + id,
                    type: 'post',
                    success: function (registro) {
                        if (registro == 'error') {
                            swal("Error", "Problemas al habilitar", "error");
                        } else {
                            swal("Habilitado!", "La actividad ha sido habilitada.", "success");
                            actualizarDataTable($('#lista-actividad'));
                        }
                    }
                });
            } else {
                swal("Cancelado", "Accion cancelada.", "error");
            }
        });
}
/*-------------------------------      FUNCION PARA REACTIVAR UNA IMPRESORA       ------------------------------------*/
function reactivarImpresora(seleccionado) {
    var table = $('#lista-impresora').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['imID'];
    swal({
            title: "Esta seguro que desea reactivar la impresora seleccionada?",
            text: "El estado de la impresora",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, reactivar la impresora!"        ,
            cancelButtonText: "No deseo reactivar la impresora",
            closeOnConfirm: false,
            closeOnCancel: false },
        function(isConfirm){
            if (isConfirm) {
                $.ajax({
                    url: site_url+'/impresora/reactivarImpresora',
                    data: 'id='+id,
                    type: 'post',
                    success: function(registro){
                        if (registro == 'error'){
                            swal("Error", "Problemas al reactivar", "error");
                        }else{
                            swal("Reactivado!", "La impresora ha sido reactivada.", "success");
                            $('#cerrar-impresora').click();
                            recargarTablaImpresora();
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
    var table = $('#lista-impresora').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['imID'];
    swal({
            title: "Esta seguro que desea eliminar la impresora seleccionada?",
            text: "El estado de la impresora",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, eliminar la impresora!"        ,
            cancelButtonText: "No deseo eliminar la impresora",
            closeOnConfirm: false,
            closeOnCancel: false },
        function(isConfirm){
            if (isConfirm) {
                $.ajax({
                    url: site_url+'/impresora/eliminarImpresora',
                    data: 'id='+id,
                    type: 'post',
                    success: function(registro){
                        if (registro == 'error'){
                            swal("Error", "Problemas al eliminar", "error");
                        }else{
                            swal("Eliminado!", "La impresora ha sido eliminada.", "success");
                            $('#cerrar-impresora').click();
                            recargarTablaImpresora();
                        }
                    }
                });
            } else {
                swal("Cancelado", "Accion cancelada.", "error");
            }
        });
}

/*----------------------------------       FUNCION PARA RECARGAR LA TABLA DEL ALMACEN       --------------------------*/
function recargarTablaActividad() {
    var tabla = $('#lista-actividad').DataTable();
    tabla.ajax.reload();
}
