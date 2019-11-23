<?php

?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-address-book-o fa-2x"></i> <b>Registro de items y categorias.</b></h3>
                    <div style="float:right">
                        <a href="<?= site_url('item/nuevo') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Nuevo item</a>
                        <a href="#modal_registro_categoria" data-toggle="modal" class="btn bg-navy"><i class="fa fa-plus"></i> Nueva categoria</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab">Items</a></li>
                            <li ><a href="#tab_2" data-toggle="tab"> Categorias </a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1" style="padding: 1%">
                                <table id="lista_item" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th style="width: 20%" class="text-center">NOMBRE ITEMT</th>
                                        <th style="width: 15%" class="text-center">PRECIO VENTA</th>
                                        <th style="width: 10%" class="text-center">TAMAÑO</th>
                                        <th style="width: 5%" class="text-center">CATEGORIA_ID</th>
                                        <th style="width: 10%" class="text-center">CATEGORIA</th>
                                        <th style="width: 15%" class="text-center">ESTADO</th>
                                        <th style="width: 25%" class="text-center">OPCIONES</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="tab_2" style="padding: 1%">
                                <table width="100%" id="lista_categorias" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th style="width: 15%" class="text-center">CODIGO </th>
                                        <th style="width: 40%" class="text-center">NOMBRE CATEGORIA</th>
                                        <th style="width: 15%" class="text-center">ESTADO</th>
                                        <th style="width: 20%" class="text-center">OPCIONES</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
</section>

<!-- Modal de edicion de los datos de items -->
<div id="modal_editar_item" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="color: black"><b>EDITAR EL ITEM SELECCIONADO </b>
                </h5>
            </div>
            <form id="frm_editar_item" class="form-horizontal" action="<?= site_url('item/editar_item') ?>"
                  method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label text-right"><b>Nombre item *</b></label>
                        <div class="col-md-7">
                            <input type="text" id="id_item" name="id_item" hidden/>
                            <input type="text" class="form-control" id="editar_nombre_item" name="editar_nombre_item" value="" placeholder="Campo requerido" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="direc_cliente" class="col-sm-3 control-label"> Tamaño </label>
                        <div class="col-sm-7">
                            <select class="form-control" id="editar_tamaño" name="editar_tamaño" >
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
                            <input type="number" step="any" id="editar_precio_venta" name="editar_precio_venta" class="form-control" value="" required/>
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
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                    <a id="btn_cerrar_modal_editar_item" class="btn btn-danger" data-dismiss="modal"><i
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

<!-- Modal el registro de las categorias -->
<div id="modal_registro_categoria" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
               <center> <h5 class="modal-title" style="color: black"><b>REGISTRO DE CATEGORÍAS</b></center>
                </h5>
            </div>
            <form id="frm_registrar_categoria" class="form-horizontal" action="<?= site_url('categoria/registrar_categoria') ?>"
                  method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label text-right"><b>CÓDIGO</b></label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="codigo_categoria" name="codigo_categoria" placeholder="Ingrese codigo deseado"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label text-right"><b> CATEGORIA *</b></label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="nombre_categoria" name="nombre_categoria" placeholder="Ingrese nombre de la categoria" required/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                    <a id="btn_cerrar_modal_registrar_categoria" class="btn btn-danger" data-dismiss="modal"><i
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

<!-- Modal la edicion de las categorias -->
<div id="modal_editar_categoria" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="color: black"><b>Edita la categoria seleccionada.</b>
                </h5>
            </div>
            <form id="frm_editar_categoria" class="form-horizontal" action="<?= site_url('categoria/editar_categoria') ?>"
                  method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label text-right"><b>CODIGO</b></label>
                        <div class="col-md-7">
                            <input type="text" id="id_categoria" name="id_categoria" hidden>
                            <input type="text" class="form-control" id="editar_codigo_categoria" name="editar_codigo_categoria" placeholder="Ingrese codigo deseado"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label text-right"><b>NOMBRE CATEGORIA *</b></label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="editar_nombre_categoria" name="editar_nombre_categoria" placeholder="Ingrese nombre de la categoria" required/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                    <a id="btn_cerrar_modal_editar_categoria" class="btn btn-danger" data-dismiss="modal"><i
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
<script src="<?= base_url('js-sistema/jitem.js') ?>"></script>
<script src="<?= base_url('js-sistema/jcategoria.js') ?>"></script>