<?php

?>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <center><h2 class="box-title">NUEVA ACTIVIDAD</h2></center>
                </div>
                <div class="box-body">
                    <form id="frm-registrar-actividad" class="form-horizontal" role="form" method="post"
                          action="<?= site_url('actividad/registrarActividad') ?>">
                        <div class="form-group">
                            <label class="col-md-2 control-label text-right"><b>SUCURSAL *</b></label>
                            <div class="col-md-9">
                                <select class="form-control" id="actividad_sucursal" name="actividad_sucursal">
                                    <?php
                                    foreach ($sucursal as $row) {
                                        ?>
                                        <option value="<?= $row->id ?>"><?= $row->sucursal ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <span style="color: red"><em><b>Seleccione la sucursal donde estara esta actividad.</b></em></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label text-right"><b>NOMBRE ACTIVIDAD *</b></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="actividad_nombre" name="actividad_nombre"
                                       placeholder="Ingrese el nombre de la actividad"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label text-right"><b>TELÉFONO</b></label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="actividad_telefono"
                                       name="actividad_telefono"
                                       placeholder="Ingrese el telefono de la actividad"/>
                            </div>
                            <label class="col-md-1 control-label text-right"><b>DIRECCIÓN *</b></label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="actividad_direccion"
                                       name="actividad_direccion"
                                       placeholder="Ingrese la direccion de la actividad"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label text-right"><b>EMAIL</b></label>
                            <div class="col-md-4">
                                <input type="email" id="actividad_email" name="actividad_email" class="form-control"
                                       placeholder="ejmplo@ejemplo.com"/>
                            </div>
                            <label class="col-md-1 control-label text-right"><b>CELULAR *</b></label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="actividad_celular" name="actividad_celular"
                                       placeholder="Ingrese el celular de la actividad"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label text-right"><b>CIUDAD *</b></label>
                            <div class="col-md-4">
                                <input type="text" id="actividad_ciudad" name="actividad_ciudad" class="form-control"
                                       placeholder="Ingrese la ciudad donde se encuentra la actividad"/>
                            </div>
                            <label class="col-md-1 control-label text-right"><b>IMPRESIÓN *</b></label>
                            <div class="col-md-4">
                                <select id="tipo_impresion" name="tipo_impresion" class="form-control">
                                    <option value="ROLLO">ROLLO</option>
                                    <option value="CARTA">CARTA</option>
                                    <option value="OFICIO">OFICIO</option>
                                    <option value="MEDIA CARTA">MEDIA CARTA</option>
                                </select>
                            </div>
                        </div>
                        <div class="text-center">
                            <button id="guardar" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
                            <a href="<?= site_url('actividad') ?>" class="btn btn-danger"><i class="fa fa-times"></i>
                                Volver</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="<?= base_url('js-sistema/jactividad.js') ?>"></script>