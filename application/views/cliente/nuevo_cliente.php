<?php

?>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <center><h2 class="box-title">GESTIÓN DE CLIENTE</h2></center>
                </div>
                <form id="frm_registrar_cliente" action="<?= site_url('cliente/registrar_cliente') ?>" method="post"
                      class="form-horizontal" role="form">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="ci_nit" class="col-sm-3 control-label">CI / NIT *</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="ci_nit" name="ci_nit"
                                       placeholder="Escriba en nro de carnet o NIT">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nombre_cliente" class="col-sm-3 control-label">NOMBRE COMPLETO *</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente"
                                       placeholder="Escriba el nombre completo">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="telefono_cliente" class="col-sm-3 control-label">TELÉFONO *</label>

                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="telefono_cliente" name="telefono_cliente"
                                       placeholder="Escriba el nro de telefono o celular">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="direc_cliente" class="col-sm-3 control-label">DIRECCIÓN</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="direc_cliente" name="direc_cliente"
                                       placeholder="Escriba la direccion">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="direc_cliente" class="col-sm-3 control-label">EMAIL</label>

                            <div class="col-sm-8">
                                <input type="email" class="form-control" id="email_cliente" name="email_cliente"
                                       placeholder="ejemplo@ejemplo.com">
                            </div>
                        </div>
                        <div class="col-lg-offset-1 col-lg-10">
                            <div class="alert alert-success alert-dismissible">
                                <h4><i class="icon fa fa-info"></i> Aviso!</h4>
                                Los campos con (*) son requidos.
                            </div>
                        </div>
                    </div>
                    <div class="box-footer text-center">
                        <button onclick="registrar_cliente()" class="btn btn-primary"><i class="fa fa-save"></i> Guardar
                        </button>
                        <a href="<?= site_url('cliente/index') ?>" class="btn btn-danger"><i class="fa fa-times"></i>
                            Salir</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.row -->
</section>
<script src="<?= base_url('js-sistema/jcliente.js') ?>"></script>

