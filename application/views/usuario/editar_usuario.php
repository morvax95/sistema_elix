<?php

if ($this->uri->segment(2) == 'editar') {
    $usuario_id = $_POST['idusuario'];
    $ci = $_POST['ci'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telf'];
    $usuario = $_POST['usuario'];
    $cargo = $_POST['cargo'];
}

$index = 0;
$array = array();
foreach ($asignados as $fila) {
    $array[$index] = $fila->id;
    $index++;
}

$index_lista_sucursales = 0;
$array_lista_sucursales = array();
foreach ($sucursales_seleccionadas as $fila_sucursales) {
    $array_lista_sucursales[$index_lista_sucursales] = $fila_sucursales->id;
    $index_lista_sucursales++;
}

?>
<section class="content">
    <div class="row">
        <form id="frm-registrar-usuario" class="form-horizontal"
              action="<?= site_url('usuario/editar_usuario') ?>" method="post">
            <div class="col-md-6">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h2 class="box-title">GESTION DE CLIENTE</h2>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label text-right"><b>CI *</b></label>
                            <div class="col-md-7">
                                <input type="text" id="usuario-editar-id" name="usuario-editar-id"
                                       value="<?= $usuario_id ?>"
                                       hidden>
                                <input type="text" class="form-control" id="ci-editar" name="ci-editar"
                                       placeholder="Campo requerido" value="<?= $ci ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label text-right"><b>NOMBRES *</b></label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" id="nombre-editar" name="nombre-editar"
                                       placeholder="Campo requerido" value="<?= $nombre ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label text-right"><b>TELEFONO</b></label>
                            <div class="col-md-7">
                                <input type="text" id="telefono-editar" name="telefono-editar" class="form-control"
                                       placeholder="Campo no requerido" value="<?= $telefono ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label text-right"><b>CARGO</b></label>
                            <div class="col-md-7">
                                <select id="cargo-editar" name="cargo-editar" class="form-control">
                                    <?php
                                    if ($cargo == 'ADMINISTRADOR') {
                                        $priv = 'hidden';
                                        ?>
                                        <option value="ADMINISTRADOR">ADMINISTRADOR</option>
                                        <option value="OTRO">OTRO</option>
                                        <?php
                                    } else {
                                        $priv = '';
                                        ?>
                                        <option value="OTRO">OTRO</option>
                                        <option value="ADMINISTRADOR">ADMINISTRADOR</option>
                                        <?php
                                    }

                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label text-right"><b>USUARIO *</b></label>
                            <div class="col-md-7">
                                <input type="text" id="usuario-editar" name="usuario-editar" class="form-control"
                                       placeholder="Campo no requerido" value="<?= $usuario ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label text-right"><b>SUCURSALES</b></label>
                            <div class="col-lg-9">
                                <div class="checkbox">
                                    <?php
                                    foreach ($sucursales as $row) {
                                        ?>
                                        <label class="col-lg-2">
                                            <?php
                                            if (in_array($row->id, $array_lista_sucursales)) {
                                                ?>
                                                <input id="editar_seleccion_sucursal" name="editar_seleccion_sucursal[]"
                                                       type="checkbox" checked="checked"
                                                       value="<?= $row->id ?>"> <?= $row->sucursal ?>
                                                <?php
                                            } else {
                                                ?>
                                                <input id="editar_seleccion_sucursal" name="editar_seleccion_sucursal[]"
                                                       type="checkbox" value="<?= $row->id ?>"> <?= $row->sucursal ?>
                                                <?php
                                            }
                                            ?>
                                        </label>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <br>
                                <span style="color: red"><em><b>Selecciones las sucursales donde estara.</b></em></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="alert alert-info" role="alert" style="margin-bottom: 0%">
                                    <strong>Informacion:</strong> Los campos con (*) son requeridos.
                                </div>
                            </div>
                        </div>
                        <div class="box-footer text-center">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar
                                </button>
                                <a href="<?= site_url('usuario') ?>" class="btn btn-danger"><i class="fa fa-times"></i>
                                    Salir</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6" id="privilegios-editar" name="privilegios-editar" <?= $priv ?>>
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">PRIVELEGIOS DEL SISTEMA</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <div id="funciones-editar" class="col-md-12" style="margin-left: 6%">
                                <?php foreach ($funciones as $row) {
                                    ?>
                                    <div class="checkbox">
                                        <label style="padding: 0%" class="checkbox-inline">
                                            <?php
                                            if (in_array($row->id, $array)) {
                                                ?>
                                                <input type="checkbox" id="menu-editar" name="menu-editar[]"
                                                       checked="checked"
                                                       value="<?= $row->id ?>">&nbsp; <?= $row->name ?>
                                                <?php
                                            } else {
                                                ?>
                                                <input type="checkbox" id="menu-editar" name="menu-editar[]"
                                                       value="<?= $row->id ?>">&nbsp; <?= $row->name ?>
                                                <?php
                                            }
                                            ?>
                                        </label>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<script src="<?= base_url('js-sistema/jusuario.js') ?>"></script>
