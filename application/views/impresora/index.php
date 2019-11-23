<?php

?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-print fa-2x"></i> <b>REGISTRO DE IMPRESORA</b></h3>
                    <div style="float:right">
                        <a data-toggle="modal" href="#modal_registrar_impresora" class="btn btn-success"><i class="fa fa-plus"></i> Nueva impresora</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="lista_impresora" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>MARCA</th>
                            <th>SERIAL</th>
                            <th>ESTADO</th>
                            <th>OPCIONES</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Modal de registro de la impresora -->
<div id="modal_registrar_impresora" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <center>  <h5 class="modal-title" style="color: black" ><b>REGISTRA LOS DATOS DE TU IMPRESORA</b></h5></center>
            </div>
            <form id="frm_registro_impresora" class="form-horizontal" action="<?= site_url('impresora/registrarImpresora') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label text-right"><b>MARCA</b></label>
                        <div class="col-md-7">
                            <input id="sw" name="sw" value="0" hidden/>
                            <input type="text" class="form-control" id="marca" name="marca" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label text-right"><b>SERIE</b></label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="serial" name="serial" />
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
        label{
            color: black;
        }
    </style>
</div>

<!-- Modal de editar de la impresora -->
<div id="modal_editar_impresora" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="color: black" ><b>EDITA LOS DATOS DE TU IMPRESORA</b></h5>
            </div>
            <form id="frm_editar_impresora" class="form-horizontal" action="<?= site_url('impresora/editarImpresora') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label text-right"><b>MARCA</b></label>
                        <div class="col-md-7">
                            <input id="id_impresora" name="id_impresora" value="" hidden/>
                            <input type="text" class="form-control" id="edita_marca" name="edita_marca" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label text-right"><b>SERIE</b></label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="edita_serial" name="edita_serial" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                    <a id="btn_cerrar_modal_editar_impresora" class="btn btn-danger" data-dismiss="modal"><i
                            class="fa fa-times"></i> Cerrar
                    </a>
                </div>
            </form>
        </div>
    </div>
    <style>
        label{
            color: black;
        }
    </style>
</div>
<script src="<?= base_url('js-sistema/jimpresora.js') ?>"></script>

