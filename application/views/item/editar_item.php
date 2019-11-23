<?php


$item_id = $_POST['id'];
$nombre = $_POST['nombre'];
$precio = $_POST['precio'];
$tamaño = $_POST['tamaño'];
$categoria = $_POST['categoria'];
?>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h2 class="box-title">Editar el item seleccionado</h2>
                </div>
                <form id="frm_registrar_item" class="form-horizontal" action="<?= site_url('item/modificar_item') ?>"
                      method="post">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label text-right"><b>Nombre item *</b></label>
                            <div class="col-md-7">
                                <input type="text" id="id_item" name="id_item" value="<?= $item_id ?>" hidden/>
                                <input type="text" class="form-control" id="editar_nombre_item" name="editar_nombre_item" value="<?= $nombre ?>" placeholder="Campo requerido" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="direc_cliente" class="col-sm-3 control-label"> Tamaño </label>
                            <div class="col-sm-7">
                                <select class="form-control" id="editar_tamaño" name="editar_tamaño" value="<?= $tamaño ?>">
                                    <option value="Mediano"> Mediano</option>
                                    <option value="Grande"> Grande</option>
                                    <!--                                    <option value="Ambos"> Ambos</option>-->
                                    <option value="Ninguno"> Ninguno</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label text-right"><b>Precio venta *</b></label>
                            <div class="col-md-7">
                                <input type="number" step="any" id="editar_precio_venta" name="editar_precio_venta" class="form-control" value="<?= $precio ?>" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="direc_cliente" class="col-sm-3 control-label">Categoria</label>
                            <div class="col-sm-7">
                                <select class="form-control" id="editar_categorias" name="editar_categorias">
                                    <option value="0">:: Seleccione una opcion</option>
                                </select>
                                <div id="msj_categoria" hidden>
                                    <span
                                        style="font-weight: bold; color: red;">No existe categorias registradas.</span>
                                    <a class="btn bg-olive btn-xs" href="<?= site_url() ?>item"><i class="fa fa-plus-circle"></i> Click aqui</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer text-center">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                        <a href="<?= site_url() ?>item" class="btn btn-danger" ><i
                                class="fa fa-times"></i> Cerrar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.row -->
</section>
<script src="<?= base_url('js-sistema/jitem.js') ?>"></script>
<script src="<?= base_url('js-sistema/jcategoria.js') ?>"></script>
