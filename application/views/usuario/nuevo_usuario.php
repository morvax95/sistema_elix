<?php

?>
<section class="content">
    <div class="row">
        <form id="frm-registrar-usuario" class="form-horizontal"
              action="<?= site_url('usuario/registrar_usuario') ?>" method="post">
            <div class="col-md-6">
                <div class="box box-success">
                    <div class="box-header with-border">
                       <center> <h2 class="box-title">GESTIÓN DE USUARIO</h2></center>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label text-right"><b>CI *</b></label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" id="ci" name="ci"
                                       placeholder="Campo requerido"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label text-right"><b>NOMBRES *</b></label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" id="nombre" name="nombre"
                                       placeholder="Campo requerido"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label text-right"><b>TELÉFONO</b></label>
                            <div class="col-md-7">
                                <input type="text" id="telefono" name="telefono" class="form-control"
                                       placeholder="Campo no requerido"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label text-right"><b>CARGO</b></label>
                            <div class="col-md-7">
                                <select id="cargo" name="cargo" class="form-control">
                                    <option value="0">::Elija una opción</option>
                                    <option value="ADMINISTRADOR">ADMINISTRADOR</option>
                                    <option value="VENDEDOR">VENDEDOR</option>
                                    <option value="OTRO">OTRO</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label text-right"><b>SUCURSALES</b></label>
                            <div class="col-lg-9">
                                <div class="checkbox">
                                    <?php
                                    foreach ($sucursal as $row) {
                                        ?>
                                        <label class="col-lg-2">
                                            <input id="seleccion_sucursal" name="seleccion_sucursal[]" type="checkbox" value="<?= $row->id ?>"> <?= $row->sucursal ?>
                                        </label>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <br>
                                <span style="color: red"><em><b>Selecciones las sucursales donde estará.</b></em></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label text-right"><b>USUARIO *</b></label>
                            <div class="col-md-7">
                                <input type="text" id="usuario" name="usuario" class="form-control"
                                       placeholder="Campo no requerido"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label text-right"><b>CLAVE</b></label>
                            <div class="col-md-7">
                                <input type="password" id="clave" name="clave" class="form-control"
                                       placeholder="Campo no requerido"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="alert alert-info" role="alert" style="margin-bottom: 0%">
                                    <strong>Información:</strong> Los campos con (*) son requeridos.
                                </div>
                            </div>
                        </div>
                        <div class="box-footer text-center">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar
                                </button>
                                <a href="<?= site_url('usuario') ?>" class="btn btn-danger"><i class="fa fa-times"></i> Salir</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="privilegios" class="col-md-6">
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <center><h3 class="box-title">PRIVILEGIOS DEL SISTEMA</h3></center>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <p style="margin-left: 5%">Para los administradores no es necesaria la selección de funciones.</p>
                            <div id="funciones" class="col-md-12" style="margin-left: 6%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<script src="<?= base_url('js-sistema/jusuario.js') ?>"></script>
