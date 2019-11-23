<?php


$contenido_categorias = $categorias;
$sesion = $this->session->userdata('usuario_sesion');
?>
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-7">
                <div class="box box-primary">
                    <div class="form-horizontal">
                        <div class="box-body">
                            <div class="col-lg-12 col-md-9 col-sm-12 col-xs-12">
                                <div class="row" style="display: flex; flex-wrap: wrap">
                                    <div class="col-xs-12 col-md-2">
                                        <ul class="nav nav-pills nav-pills-info nav-stacked">
                                            <?php
                                            $panel = 'active';
                                            foreach ($categorias as $row) {
                                                ?>
                                                <li class="<?= $panel ?>"><a href="#<?= $row->id ?>"
                                                                             data-toggle="tab"><?= $row->nombre_categoria ?></a>
                                                </li>
                                                <?php
                                                $panel = '';
                                            }
                                            ?>
                                        </ul>
                                    </div>

                                    <div class="col-lg-10 col-md-9 col-xs-12">
                                        <div class="tab-content">
                                            <input type="text" id="contador" name="contador" value="0" hidden>
                                            <?php
                                            $panel = 'active';
                                            foreach ($contenido_categorias as $row2) {
                                                $categoria_id = $row2->id;
                                                ?>
                                                <div id="<?= $categoria_id ?>" class="tab-pane <?= $panel ?> ">
                                                    <p>
                                                        <?php
                                                        foreach ($items[$row2->id] as $row3) {
                                                            $id_item = $row3->id;
                                                            $nombre = $row3->nombre_item;
                                                            $tamaño = $row3->tamaño;
                                                            $precio = $row3->precio_venta;
                                                            if ($tamaño != "Ninguno") {
                                                                ?>
                                                                <a onclick="adicionar(<?= $id_item ?>, <?= $categoria_id ?>, <?= $sesion['idUsuario'] ?>, <?= $sesion['idSucursal'] ?>)"
                                                                   class="btn btn-app">
                                                                    <?= $nombre ?> <br>
                                                                    <?= $tamaño ?> <br> <?= $precio ?>
                                                                </a>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <a onclick="adicionar(<?= $id_item ?>, <?= $categoria_id ?>, <?= $sesion['idUsuario'] ?>, <?= $sesion['idSucursal'] ?>)"
                                                                   style="padding: 18px 5px" class="btn btn-app">
                                                                    <?= $nombre ?> <br>
                                                                    <?= $precio ?>
                                                                </a>
                                                                <?php
                                                            }
                                                            ?>
                                                            <?php
                                                        }
                                                        ?>
                                                    </p>
                                                </div>
                                                <?php
                                                $panel = '';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form class="form-horizontal" id="frm_registrar_venta_r" action="<?= site_url('venta/registrar_venta') ?>" method="post">
            <div class="col-lg-3">
                <div class="box bolx-success">
                    <div class="box-body">
                        <div class="col-lg-12 col-md-12 col-ms-12 col-xs-12">
                            <div class="form-group">
                                <label class="col-lg-1 control-label"><b>NIT</b></label>
                                <div class="col-lg-12" style="padding: 0%;">
                                    <input style="font-size: 13pt; font-weight: bold" type="number" id="nit_cliente"
                                           name="nit_cliente" class="form-control" value=""
                                           placeholder="Escriba nit" autofocus/>
                                    <input type="tex" id="idCliente" name="idCliente" hidden/>
                                </div>
                                <label class="col-lg-1 control-label"><b>NOMBRE</b></label>
                                <div class="col-lg-12" style="padding: 0%;">
                                    <input style="font-size: 13pt; font-weight: bold" type="text"
                                           id="nombre_cliente"
                                           name="nombre_cliente" class="form-control"
                                           value="" placeholder="Escriba nit"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <table id="detalle_venta" class="table table-striped">
                                    <thead>
                                    <th style="width: 45%" class="text-center"><b>Detalle</b></th>
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
                </div>
            </div>
            <div class="col-lg-2" style=" padding: 0%">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" style="font-size: 12pt"><b>SUBTOTAL Bs.</b></label>
                                <input style="font-size: 14pt;" type="number" step="any" id="subtotal_as"
                                       name="subtotal_as"
                                       class="form-control" value="0.00" readonly/>
                            </div>
                            <div class="form-group">
                                <label class="control-label" style="font-size: 12pt"><b>DESCUENTO %</b></label>
                                <input style="font-size: 14pt;" type="number" step="any" id="descuento_porcentaje"
                                       name="descuento_porcentaje"
                                       class="form-control" value="0.00"/>
                            </div>
                            <div class="form-group">
                                <label class="control-label" style="font-size: 12pt"><b>DESCUENTO Bs.</b></label>
                                <input style="font-size: 14pt;" type="number" step="any" id="descuento_as"
                                       name="descuento_as"
                                       class="form-control" value="0.00" readonly/>
                            </div>
                            <div class="form-group">
                                <div class="info-box">
                                    <span style="width: 38%; margin-right: 0%" class="info-box-icon bg-green"><i class="fa fa-dollar"></i></span>
                                    <div class="info-box-content" style="padding-left: 0%; width: 150%">
                                        <span class="info-box-text" style="font-size: 12pt"><b>TOTAL</b></span>
                                        <span class="info-box-number">
                                            <input readonly
                                                   style="border:0px; font-size: 14pt; background-color: transparent"
                                                   type="number"
                                                   step="any" id="total_as" name="total_as"
                                                   class="form-control" value="0.00"/>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" style="font-size: 12pt"><b>PAGO CON Bs.:</b></label>
                                <input type="number" step="any" id="efectivo_as" name="efectivo_as" value="0.00"
                                       class="form-control"/>
                                <label class="control-label" style="font-size: 12pt"><b>CAMBIO Bs.:</b></label>
                                <input type="number" step="any" id="cambio_as" name="cambio_as" value="0.00"
                                       class="form-control"/>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-qrcode"></i>
                                    Facturar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
</section>
<script type="text/javascript" src="<?= base_url('js-sistema/jventa.js') ?>"></script>

