<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-files-o fa-2x"></i> <b>REGISTRO DE ACTIVIDAD ECONÓMICA</b></h3>
                    <div style="float:right">
                        <a href="<?= site_url('actividad/nuevo') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Nueva actividad</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered table-striped" id="lista-actividad">
                        <thead>
                        <tr>
                            <th class="">ID</th>
                            <th class="">DETALLE</th>
                            <th class="">DIRECCION</th>
                            <th class="">TELEFONO</th>
                            <th class="">EMAIL</th>
                            <th class="">CIUDAD</th>
                            <th class="">SUCURSAL</th>
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

<!---------------------------------        MODALS PARA EDITAR UNA ACTIVIDAD        ------------------------------------>
<div id="modal-editar-actividad" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="color: black" ><b>Ingresoso datos de la actividada:</b></h5>
            </div>
            <form id="frm-editar-actividad" class="form-horizontal"
                  action="<?= site_url('actividad/modificarActividad') ?>" method="post">
                <div class="modal-body">

                    <input id="id-actividad" name="id-actividad" value=""  hidden>
                    <div class="form-group">
                        <label class="control-label col-md-3"><b>ACTIVIDAD *:</b></label>
                        <div class="col-md-8">
                            <input type="text" id="nombre-actividad" name="nombre-actividad"
                                   class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3"><b>DIRECCION *:</b></label>
                        <div class="col-md-8">
                            <input type="text" id="direccion-actividad" name="direccion-actividad"
                                   class="form-control"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3"><b>TELEFONO:</b></label>
                        <div class="col-md-8">
                            <input type="text" id="telefono-actividad" name="telefono-actividad"
                                   class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3"><b>EMAIL*:</b></label>
                        <div class="col-md-8">
                            <input type="text" id="email-actividad" name="email-actividad"
                                   class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3"><b>CELULAR *:</b></label>
                        <div class="col-md-8">
                            <input type="text" id="celular-actividad" name="celular-actividad"
                                   class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3"><b>CIUDAD *:</b></label>
                        <div class="col-md-8">
                            <input type="text" id="ciudad-actividad" name="ciudad-actividad"
                                   class="form-control"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Guardar</button>
                    <a id="btn-cerrar-modal-editar-actividad" class="btn btn-warning" data-dismiss="modal">
                        <i class="fa fa-times"></i> Cerrar
                    </a>
                </div>
            </form>
        </div>
    </div>
    <style>
        label{
            color: black;
        }
    </style>
</div>
<script type="text/javascript" src="<?= base_url('js-sistema/jactividad.js') ?>"></script>