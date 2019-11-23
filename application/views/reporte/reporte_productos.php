<?php

?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-address-book-o fa-2x"></i> <b>REPORTE DE PRODUCTOS</b></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="panel panel-default">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel-body">
                                    <div class="form-group">
                                    
                                        <label class="col-md-1"><b>CATEGORÍA</b></label>
                                        <div class="col-md-2">
                                            <select class="form-control" id="categoria_id" name="categoria_id" value="<?= date('Y') ?>">
                                                <?php
                                                foreach ($sucursal as $row){
                                                    ?>
                                                    <option value="<?= $row->id ?>"><?= $row->nombre_categoria ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-1">
                                            <button class="btn btn-danger" onclick="buscar_productos();"><i class="fa fa-search"></i> Buscar</button>
                                        </div>
                                      <div class="col-md-1">
                                            <button class="btn btn-danger" onclick="exportar_excel_productos();"><i class="fa fa-search"></i> Excel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <table class="table table-bordered" id="lista_productos">
                                <thead>
                                <th class="text-center" style="width: 10%">NRO.</th>
                                <th class="text-center" style="width: 35%">PRODUCTO</th>
                                <th class="text-center" style="width: 20%">PRECIO</th>
                                <th class="text-center" style="width: 17%">ESTADO</th>
                                <th class="text-center" style="width: 13%">CATEGORÍA</th>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="<?= base_url('js-sistema/jreporte.js') ?>"></script>
