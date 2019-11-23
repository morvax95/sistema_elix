<?php

$user_data = $this->session->userdata('usuario_sesion');
$usuario_sesion = $this->session->userdata('usuario_sesion');
$cargo = $usuario_sesion['cargo'];
?>
<style>
    .sombra2 {
        text-shadow: 2px 4px 3px rgba(0, 0, 0, 0.3);
        font-size: 35px;
        font-weight: bold;
        font-family: 'Arial Black';
        text-align: center;
    }
</style>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="sombra2">BIENVENIDO</h3>
                    <center><h3>Panel de Control</h3></center>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <!--Contenido-->
                            <div class="card">

                                <div class="row clearfix">
                                    <!--<center><h4>Tomar en cuenta los mensajes del sistema</h4></center>-->
                                </div>

                            </div>
                            <!--para que sea responsiva la imagen-->
                            <style>
                                img {
                                    width: 20%;
                                    height: auto;
                                }
                            </style>
                            <?php

                            if ($cargo != 'ADMINISTRADOR') {
                                ?>
                                <div class="row clearfix" align="center">
                                    <div class="image">
                                        <img src="<?= base_url('assets/img/logo.png') ?>" width="500" height="435"/>
                                    </div>
                                </div>
                                <?PHP
                            }
                            ?>


                            <!--Fin Contenido-->
                        </div>

                    </div>
                    <?php

                    if ($cargo === 'ADMINISTRADOR') {
                        ?>
                        <div class="col-lg-6 col-md-6 col-xs-6">
                            <?php
                            foreach ($dosificacion as $row) {
                                ?>
                                <div class="small-box <?= $row['color'] ?>">
                                    <div class="inner">
                                        <h4> <?= $row['dias'] ?> <?= $row['autorizacion'] ?></h4>

                                        <p><?= $row['mensaje'] ?></p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-bar-chart"></i>
                                    </div>
                                    <a href="<?= site_url() ?>dosificacion" class="small-box-footer">
                                        <marquee>Ver dosificaciones <i class="fa fa-arrow-circle-right"></i></marquee>
                                    </a>
                                </div>
                                <?php
                            }

                            ?>
                        </div>
                        <?php
                    }
                    ?>
                 
                    <!--INICIO-->
                    <?php if ($user_data['cargo'] === 'ADMINISTRADOR') { ?>
                        <?php
                        $pagos = 4;
                        if (isset($pagos)) {
                            $cantidad = count($pagos);
                            ?>
                            <div class="col-lg-6 col-md-6 col-xs-6">
                                <!--   <div class="small-box  box-success box-solid">-->
                                <div class="small-box  box-success bg-yellow">
                                    <div class="inner">
                                        <h4> <?= $cantidad ?> <?= 'VENTA(S) DEL DÍA' ?></h4>

                                        <p><?= 'Tecnología e innovación' ?></p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-dollar"></i>
                                    </div>
                                    <a href="<?= site_url() ?>#" class="small-box-footer">
                                        <marquee>Ver cantidad d ventas del día <i class="fa fa-arrow-circle-right"></i>
                                        </marquee>
                                    </a>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <?php
                    }
                    ?>
                    <!--FIN-->
                  


                </div>
            </div>
        </div>
    </div>



