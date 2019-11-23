<?php

?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-address-book-o fa-2x"></i> <b>GESTIÓN DE CLIENTE</b></h3>
                    <div style="float:right">
                        <a href="<?= site_url('cliente/nuevo') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Nuevo cliente</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="alert alert-success alert-dismissible" style="font-size: 12pt">
                        <h4><i class="icon fa fa-info"></i> Aviso!</h4>
                        Puede realizar búsquedas de un cliente mediante su nombre o nit.
                    </div>
                    <table id="lista_cliente" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th class="text-center" >CI / NIT</th>
                            <th class="text-center">NOMBRE COMPLETO</th>
                            <th class="text-center">TELÉFONO</th>
                            <th class="text-center">DIRECCIÓN</th>
                            <th class="text-center">EMAIL</th>
                            <th class="text-center">ESTADO</th>
                            <th class="text-center">OPCIONES</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
</section>

<!-- Modal de edicion de datos del cliente -->
<div id="modal_editar_cliente" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
               <center> <h5 class="modal-title" style="color: black" ><b>EDITA LOS DATOS DEL CLIENTE</b></h5></center>
            </div>
            <form id="frm_editar_cliente" class="form-horizontal" action="<?= site_url('cliente/editarCliente') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label text-right"><b>CI /NIT</b></label>
                        <div class="col-md-7">
                            <input id="cliente_id" name="cliente_id" hidden/>
                            <input type="text" class="form-control" id="editar_ci" name="editar_ci" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label text-right"><b>CLIENTE</b></label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="editar_nombre" name="editar_nombre" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label text-right"><b>TELÉFONO</b></label>
                        <div class="col-md-7">
                            <input type="number" id="editar_telefono" name="editar_telefono" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label text-right"><b>DIRECCIÓN</b></label>
                        <div class="col-md-7">
                            <input type="text" id="editar_direccion" name="editar_direccion" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="direc_cliente" class="col-sm-3 control-label">EMAIL</label>

                        <div class="col-md-7">
                            <input type="email" class="form-control" id="editar_email" name="editar_email"
                                   placeholder="ejemplo@ejemplo.com">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                    <a id="btn_cerrar_modal_editar" class="btn btn-danger" data-dismiss="modal"><i
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

<div id="modal_ver_cliente" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <center><h5 class="modal-title" style="color: black" ><b>DATOS DEL CLIENTE</b></h5></center>
            </div>
            <form id="frm_ver_cliente" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label text-right"><b>CI /NIT</b></label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="ver_ci" name="ver_ci" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label text-right"><b> CLIENTE</b></label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="ver_nombre" name="ver_nombre" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label text-right"><b>TELÉFONO</b></label>
                        <div class="col-md-7">
                            <input type="number" id="ver_telefono" name="ver_telefono" class="form-control" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label text-right"><b>DIRECCIÓN</b></label>
                        <div class="col-md-7">
                            <input type="text" id="ver_direccion" name="ver_direccion" class="form-control" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="direc_cliente" class="col-sm-3 control-label">EMAIL</label>

                        <div class="col-md-7">
                            <input type="email" class="form-control" id="ver_email" name="ver_email"
                                   placeholder="ejemplo@ejemplo.com"readonly />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a id="btn_cerrar-_modal_ver" class="btn btn-danger" data-dismiss="modal"><i
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
<script src="<?= base_url('js-sistema/jcliente.js') ?>"></script>
