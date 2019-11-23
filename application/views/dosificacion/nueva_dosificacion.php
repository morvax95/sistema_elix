<?php

?>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <center><h2 class="box-title">REGISTRO DE DOSIFICACIÓN</h2></center>
                </div>
                <form id="frm_registrar_dosificacion" class="form-horizontal" role="form" method="post"
                      action="<?= site_url('dosificacion/registrarDosificacion') ?>">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label text-right"><b> AUTORIZACIÓN </b></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="autorizacion"
                                       name="autorizacion"
                                       placeholder="Ingrese la autorizacion para la dosificación"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label text-right"><b>NRO. INICIAL</b></label>
                            <div class="col-md-8">
                                <input type="number" class="form-control" id="incial"
                                       name="inicial" value="1" readonly/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label text-right"><b>FECHA LIMITE</b></label>
                            <div class="col-md-8">
                                <input type="date" class="form-control" id="fecha_limite"
                                       name="fecha_limite"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label text-right"><b>LLAVE</b></label>
                            <div class="col-md-8">
                                <textarea id="llave" name="llave" rows="2" class="form-control"
                                          placeholder="Ingrese la llave de la dosificación"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label text-right"><b>LEYENDA</b></label>
                            <div class="col-md-8">
                                <textarea class="form-control" id="leyenda" name="leyenda"
                                          placeholder="Escriba la leyenda asignada."></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label text-right"><b>IMPRESORA</b></label>
                            <div class="col-md-8">
                                <select name="impresora" id="impresora" class="form-control">
                                    <option value="0">::SELECCIONE UNA OPCIÓN:</option>
                                </select>
                                <div id="msj_impresora" hidden>
                                    <span
                                        style="font-weight: bold; color: red;">No existe impresoras registradas.</span>
                                    <a class="btn bg-olive btn-xs" href="#modal_registrar_impresora"
                                       data-toggle="modal"><i class="fa fa-plus-circle"></i> Click aqui</a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label text-right"><b>ACTIVIDAD</b></label>
                            <div class="col-md-8">
                                <select name="actividad" id="actividad" class="form-control">
                                    <option value="0">::SELECCIONE UNA OPCIÓN:</option>
                                </select>
                                <div id="msj_actividad" hidden>
                                    <span
                                        style="font-weight: bold; color: red;">No existe actividad(es) registrada(s).</span>
                                    <a class="btn bg-olive btn-xs" href="<?= site_url('actividad/nuevo') ?>"><i
                                            class="fa fa-plus-circle"></i> Click aqui</a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" hidden>
                            <label class="col-md-3 control-label text-right"><b>SUCURSAL</b></label>
                            <div class="col-md-8">
                                <select name="sucursal" id="sucursal" class="form-control">
                                    <option value="0">::SELECCIONE UNA OPCIÓN:</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="box-footer text-center">
                        <button id="guardar" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                        <a href="<?= site_url('dosificacion') ?>" class="btn btn-danger"><i class="fa fa-times"></i>
                            Salir</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Modal de registro de la impresora -->
<div id="modal_registrar_impresora" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="color: black"><b>REGISTRA LOS DATOS DE TU IMPRESORA</b></h5>
            </div>
            <form id="frm_registro_impresora" class="form-horizontal"
                  action="<?= site_url('impresora/registrarImpresora') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label text-right"><b>MARCA</b></label>
                        <div class="col-md-7">
                            <input id="sw" name="sw" value="1" hidden/>
                            <input type="text" class="form-control" id="marca" name="marca"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label text-right"><b>SERIE</b></label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="serial" name="serial"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                    <a id="btn_cerrar_modal_registrar_impresora" class="btn btn-danger" data-dismiss="modal"><i
                            class="fa fa-times"></i> Cerrar
                    </a>
                </div>
            </form>
        </div>
    </div>
    <style>
        label {
            color: black;
        }
    </style>
</div>

<script type="text/javascript" src="<?= base_url('js-sistema/jdosificacion.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('js-sistema/jimpresora.js') ?>"></script>
<script>
    $(document).ready(function () {
        existesImpresoras();
        existenActividades();
    });

    function existesImpresoras() {
        $.ajax({
            url: site_url + 'impresora/existenDatos',
            success: function (data) {
                if (data === '0') {
                    $('#msj_impresora').show();
                } else {
                    cargarImpresoras();
                }
            }
        })
    }

    function existenActividades() {
        $.ajax({
            url: site_url + 'actividad/existenDatos',
            success: function (data) {
                console.log(data)
                if (data === '0') {
                    $('#msj_actividad').show();
                } else {
                    cargarActividades();
                }
            }
        })
    }

    function cargarImpresoras() {
        $.post(site_url + "impresora/obtenerImpresoras",
            function (data) {
                var datos = JSON.parse(data);
                $.each(datos, function (i, item) {
                    $('#impresora').append('<option value="' + item.id + '">' + item.marca + ' | Suc. '+ item.sucursal+ '</option>');
                });
            });
        $('#msj_impresora').hide();
    }

    function cargarActividades() {
        $.post(site_url + "actividad/listarActividad",
            function (data) {
                var datos = JSON.parse(data);
                console.log(datos);
                $.each(datos, function (i, item) {
                    $('#actividad').append('<option value="' + item.id + '">' + item.nombre_actividad + ' | Suc. '+ item.sucursal+ '</option>');
                });
            });
        $('#msj_actividad').hide();
    }
</script>