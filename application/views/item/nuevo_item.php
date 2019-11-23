<?php

?>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <center><h2 class="box-title">REGISTRO DE ITEMS</h2></center>
                </div>
                <form id="frm_registrar_item" class="form-horizontal" action="<?= site_url('item/registrar_item') ?>"
                      method="post">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label text-right"><b>NOMBRE ITEM *</b></label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" id="nombre_item" name="nombre_item" placeholder="Campo requerido" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="direc_cliente" class="col-sm-3 control-label"> TAMAÑO </label>
                            <div class="col-sm-7">
                                <select class="form-control" id="tamaño" name="tamaño">
                                    <option value="Mediano"> Mediano</option>
                                    <option value="Grande"> Grande</option>
                                    <option value="Ninguno"> Ninguno</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label text-right"><b>PRECIO VENTA *</b></label>
                            <div class="col-md-7">
                                <input type="number" step="any" id="precio_venta" name="precio_venta" class="form-control" value="0.00" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="direc_cliente" class="col-sm-3 control-label">CATEGORÍA</label>
                            <div class="col-sm-7">
                                <select class="form-control" id="categorias" name="categorias">
                                    <option value="0">:: Seleccione una opción</option>
                                </select>
                                
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
