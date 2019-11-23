<?php

?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-files-o fa-2x"></i> <b>REPORTE VENTAS POR CLIENTE </b></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="panel panel-default">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-md-2" style="width: 10%"><b>FECHA INICIO</b></label>
                                        <div class="col-md-2">
                                            <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?= date('Y-m') ?>-01" class="form-control">
                                        </div>
                                        <label class="col-md-1"><b>FECHA FIN</b></label>
                                        <div class="col-md-2">
                                            <input type="date" id="fecha_fin" name="fecha_fin" value="<?= date('Y-m-d')?>" class="form-control">
                                        </div>
                                        <div class="col-md-1">
                                            <button class="btn btn-danger" onclick="buscarVentas();"><i class="fa fa-search"></i> Buscar</button>
                                        </div>
                                        <div class="col-md-2" style="text-align: center"><a class="btn bg-green" onclick="exportar_excel_ventas_clientes()"><i class="fa fa-file-excel-o fa-3x"></i><br>EXPORTAR EXCEL</a class="btn"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <table class="table table-bordered" id="lista_venta_cliente">
                                <thead>
                                <th class="text-center" style="width: 10%">NRO.</th>
                                <th class="text-center" style="width: 15%">FECHA</th>
                                <th class="text-center" style="width: 20%">NIT</th>
                                <th class="text-center" style="width: 30%">CLIENTE</th>
                                <th class="text-center" style="width: 15%">CANTIDAD</th>
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

