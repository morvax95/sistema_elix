<?php

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistema</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/font-awesome-4.7.0/css/font-awesome.min.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/css/AdminLTE.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/sweetalert/sweetalert.css') ?>">
    <style>
        body{
            background-image: url(<?=base_url('assets/img/fondo5.JPG')?>) !important;
            background-size: 100% 100% !important;
            background-attachment: fixed !important;
            background-repeat:no-repeat !important;
            overflow:hidden !important;
        }
        .login-box-body{
            background: rgba(255,255,255,0.5);
        }
        .login-box-msg{
            color: white;
            size: 40px!important;
        }
        .enter{
            background: #6d0000;
            color: white;
   
        }
        .enter:hover{
            background: #6d0000;
            color: white;
            font-size: 16px;
        }

    </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
   
    <div class="login-box-body">
        <h3><p class="login-box-msg">INICIO DE SESIÓN</p></h3>

        <form id="frm_login_sistema" method="post" action="<?= site_url('login/verificar') ?>">
            <div class="form-group has-feedback">
                <select id="sucursal" name="sucursal" class="form-control" autofocus>
                    <?php
                    foreach ($sucursal as $row){
                        ?>
                        <option value="<?= $row->id ?>"><?= $row->sucursal ?></option>
                        <?php
                    }
                    ?>
                </select>
                <span class="fa fa-building form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Usuario" autofocus required>
                <span class="fa fa-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" id="clave" name="clave" placeholder="Contraseña" required>
                <span class="fa fa-lock form-control-feedback"></span>
                <p id="mjs1" style="color: red; font-size: 12pt; font-weight: bold" hidden >Usuario y/ contraseña incorrectos, por favor verifique.</p>
                <p id="mjs2" style="color: red; font-size: 12pt; font-weight: bold" hidden >Su usuario no cuenta con la asignacion a esta sucursal. Acceso denegado</p>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <button type="submit" class="btn btn-block btn-flat enter">Ingresar</button>
                </div>
                <div class="col-xs-12">
                    <div class="" style="text-align: center; color: #6d0000;">
                        <strong>| © 2019 Sitema Elix |</strong>
                    </div>
                 <!--   <div class="" style="text-align: center">
                        <a target="_blank" href="#" style="color: #100bf5">http://elix.net</a>
                    </div>-->
                </div>
                <!-- /.col -->
            </div>
        </form>
    </div>
</div>
<script>
    var site_login = '<?= site_url() ?>';
</script>
<!-- jQuery 2.2.3 -->
<script src="<?= base_url('assets/js/jquery-2.2.4.min.js') ?>"></script>
<script src="<?= base_url('js-sistema/jlogin.js') ?>"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/sweetalert/sweetalert.min.js') ?>"></script>
</body>
</html>

