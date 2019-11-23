<?php

?>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h2 class="box-title">Registro de compra</h2>
                </div>
                <form id="frm_registrar_item" class="form-horizontal" action="<?= site_url('inventario/registrar_inventario') ?>"
                      method="post">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label text-right"><b>Nombre item *</b></label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" id="nombre_item" name="producto" placeholder="Campo requerido" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="direc_cliente" class="col-sm-3 control-label"> Tamaño </label>
                            <div class="col-sm-7">
                                <select class="form-control" id="tamaño" name="tamaño">
                                    <option value="Mediano"> Mediano</option>
                                    <option value="Grande"> Grande</option>
                                    <option value="Ninguno"> Ninguno</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label text-right"><b>Precio venta *</b></label>
                            <div class="col-md-7">
                                <input type="number" step="any" id="precio_venta" name="precio_venta" class="form-control" value="0.00" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="direc_cliente" class="col-sm-3 control-label">Categoria</label>
                            <div class="col-sm-7">
                                <select class="form-control" id="categorias" name="categorias">
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
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Agregar </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h2 class="box-title">Detalle de compra</h2>
                </div>
                <form id="frm_registrar_item" class="form-horizontal" action="<?= site_url('inventario/registrar_inventario') ?>"
                      method="post">
                    <div class="box-body">
                        <div class="col-lg-11 col-md-11 col-xs-11">
                            <div class="form-group">
                                <table id="detalle_venta" class="table table-striped">
                                    <thead>
                                    <th style="width: 45%" class="text-center"><b>Producto</b></th>
                                    <th style="width: 25%" class="text-center"><b>Cant.</b></th>
                                    <th style="width: 25%" class="text-center"><b>$$$</b></th>
                                    <th style="width: 5%" class="text-center"><b>Quitar</b></th>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
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
