<?php

?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-file-archive-o fa-2x"></i> <b>REGISTRO DE DOSIFICACIONES</b></h3>
                    <div style="float:right">
                        <a href="<?= site_url('dosificacion/nuevo') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Nueva dosificación</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="alert alert-danger alert-dismissible">
                        <h4><i class="icon fa fa-info"></i> Aviso!</h4>
                        Verifique que los datos de la dosificación sean correctos, una ves activada una dosificación esta no podrá ser desactivada hasta que resten 5 dias de la fecha limite de dosificación.
                    </div>
                    <table class="table table-bordered table-striped" id="lista_dosificaciones">
                        <thead>
                        <tr>
                            <th class="">ID</th>
                            <th class="">Nro. AUTORIZACION</th>
                            <th class="">ACTIVIDAD</th>
                            <th class="">SUCURSAL</th>
                            <th class="">IMPRESORA</th>
                            <th class="">FECHA LIMITE</th>
                            <th class="">ESTADO</th>
                            <th class="">OPCIONES</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="<?= base_url('js-sistema/jdosificacion.js') ?>"></script>
