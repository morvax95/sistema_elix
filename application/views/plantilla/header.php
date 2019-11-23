<?php

$nombre = ucwords(strtolower($dato_sesion['nombre']));
$cargo = ucwords(strtolower($dato_sesion['cargo']));
$impresora = $dato_sesion['marca'];
$idSucursal = $dato_sesion['idSucursal'];
$nombre_sucursal = $dato_sesion['nombre_sucursal'];
$sesion = $dato_sesion['idSesion'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>BIENVENIDOS</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <!-- DataTables -->
    <link href="<?= base_url('assets/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet"  media="screen">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/css/AdminLTE.min.css') ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/font-awesome-4.7.0/css/font-awesome.min.css') ?>">
    <!-- Sweet alert -->
    <link rel="stylesheet" href="<?= base_url('assets/sweetalert/sweetalert.css') ?>">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?= base_url('assets/css/_all-skins.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/js/jquery-ui.css') ?>">

    <!-- jQuery 2.2.3 -->
    <script src="<?= base_url('assets/js/jquery-2.2.4.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/jquery-ui-1.10.3.min.js') ?>"></script>
    <style>
        .error {
            color: red;
            font-weight: bold;
            font-style: italic;
            font-size: 10pt;
        }

        .skin-red-light .sidebar-menu>li:hover>a, .skin-red-light .sidebar-menu>li.active>a {
            color: #110914;
            background: #f9fafc;
            border-left-color: #dd4b39;
        }

        /*.skin-red-light .sidebar-menu>li>a {
            border-left: 3px solid #1c5be200;
        }*/
        .skin-red-light .sidebar-menu>li>a:hover {
            border-left: 3px solid red;

        }

    </style>

</head>
<!--oncontextmenu="return false" onkeydown="return false"-->
<body  class="hold-transition skin-red-light  -light sidebar-mini">
<div class="wrapper">
    <header class="main-header">
        <!-- Logo -->
        <a href="<?= site_url('inicio') ?>" class="logo" style="padding-left: 8px">
            <!-- Aqui va el mini logo de 50x50 pixels -->
            <span class="logo-mini"><b>E</b>X</span>
            <!-- <img style="width: 215px; height: 45px;"  src="<?= base_url('assets/img/logo.png') ?>">-->
            <span class="logo-lg"><b>SISTEMA ELIX</b></span>
        </a>
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-user"></i>
                            <span class="hidden-xs"><?= $nombre ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <br>
                                <p>
                                    <?= $nombre ?> - <?= $cargo ?> - <?= $impresora ?><br>
                                    Sucursal: <?= $nombre_sucursal ?> - <?= $sesion ?>
                                    <small style="font-size: 10pt">C.I.: <?= $dato_sesion['ci'] ?> <br> Telf.: <?= $dato_sesion['telf'] ?></small>
                                </p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-left">
                                    <!--<a href="<?= site_url('inicio/cambio') ?>" class="btn btn-default btn-flat">Cambiar contraseña</a>-->
                                    <a href="<?= site_url('inicio/cambio') ?>" style="width: 100%"
                                       class="btn form-control btn-primary btn-flat ">CAMBIAR
                                        CONTRASEÑA</a>
                                    <a href="<?= site_url('login/cerrar_sesion') ?>" style="width: 100%"
                                       class="btn form-control btn-primary btn-flat ">SALIR
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

        </nav>
    </header>
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <ul class="sidebar-menu">
                <li class="header">MENU DEL SISTEMA</li>
                <li class="treeview">
                    <a href="<?= site_url('inicio') ?>">
                        <i class="fa fa-home"></i> <span>INICIO</span>
                    </a>
                </li>
                <?= $this->multi_menu->render(); ?>
                <li class="treeview">
                    <a href="<?= site_url('login/cerrar_sesion') ?>">
                        <i class="fa fa-sign-out"></i> <span>SALIR</span>

                    </a>
                </li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
    <div class="content-wrapper">
