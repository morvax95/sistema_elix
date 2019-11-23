<?php

?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-address-book-o fa-2x"></i> <b>REPORTE DE CLIENTES</b></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="panel panel-default">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel-body">
                                    <div class="form-group">
                                    
                                        <label class="col-md-1"><b>SUCURSAL</b></label>
                                        <div class="col-md-2">
                                            <select class="form-control" id="sucursal_lcv" name="sucursal_lcv" value="<?= date('Y') ?>">
                                                <?php
                                                foreach ($sucursal as $row){
                                                    ?>
                                                    <option value="<?= $row->id ?>"><?= $row->sucursal ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-1">
                                            <button class="btn btn-danger" onclick="buscar_clientes();"><i class="fa fa-search"></i> Buscar</button>
                                        </div>
                                      <!--  <div class="col-md-2" style="text-align: center"><a class="btn bg-blue-gradient" onclick="exportar_txt_lcv()"><i class="fa fa-file-text-o fa-2x"></i><br>Excel</a></div>-->
                                      <div class="col-md-1">
                                            <button class="btn btn-danger" onclick="exportar_excel_clientes();"><i class="fa fa-search"></i> Excel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <table class="table table-bordered" id="lista_clientes">
                                <thead>
                                <th class="text-center" style="width: 10%">NRO.</th>
                                <th class="text-center" style="width: 15%">CÉDULA DE IDENTIDAD</th>
                                <th class="text-center" style="width: 25%">NOMBRE COMPLETO</th>
                                <th class="text-center" style="width: 12%">TELÉFONO</th>
                                <th class="text-center" style="width: 25%">DIRECCIÓN</th>
                                <th class="text-center" style="width: 13%">EMAIL</th>
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
