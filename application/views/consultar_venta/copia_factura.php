<?php

?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/estilos_factura/stilo.css') ?>" media="screen">
    <!--<link rel="stylesheet" type="text/css" href="../css/print/print.css" media="print">-->
    <link href="<?= base_url('assets/estilos_factura/printListaTransac.css') ?>" rel="stylesheet" type="text/css" media="print"/>
    <link href="<?= base_url('assets/estilos_factura/estiloReportes.css') ?>" rel="stylesheet" type="text/css"/>
    <style type="text/css" media="print">
        @page{
            width: 100%;
            margin-left: 0.3cm;
            margin-right: 0.3cm;
            padding: 0;
        }
        table tr td {
            font-size: 10pt;
        }
    </style>
    <script src="<?= base_url('assets/js/jquery-2.2.4.min.js') ?>"></script>
</head>
<body>
<script language="JavaScript">
    $(document).ready(function ()
    {
        doPrint();
    });

    function doPrint()
    {
        //document.all.item("mostrarUser").style.visibility='visible';
        window.print()();
        //document.    {
//        all.item("mostrarUser").style.visibility='hidden';
    }
    function Salir(dato)
    {
        window.close();
    }
</script>
<div id="noprint">
    <table>
        <tr>
            <td>
                <button type="button" name="volver" id="volver" onclick="Salir()">Salir</button>
            </td>
            <td>&nbsp;&nbsp;</td>
            <td>
                <button type="button" onclick="doPrint()">Imprimir</button>
            </td>
        </tr>
    </table>
</div>
<div id="hoja" style="height: auto; width: auto">
    <table align="center">
        <tr>
            <td align="center"><strong> <?= $datos_factura->nombre_empresa ?></strong> </td>
        </tr>
        <tr>
            <td align="center"><strong> <?= $datos_factura->sucursal ?></strong> </td>
        </tr>
        <tr>
            <td align="center"><?= $datos_factura->direccion ?> </td>
        </tr>
        <tr>
            <td align="center"> Santa Cruz - Bolivia </td>
        </tr>
        <tr>
            <td><div align="center"><b>F A C T U R A<br>C O P I A</b></div></td>
        </tr>
        <tr>
            <td>- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - </td>
        </tr>
        <tr>
            <td align="center">NIT: <?= $datos_factura->nit ?></td>
        </tr>
        <tr>
            <td align="center">Factura No. 0000000<?= $datos_factura->nro_factura ?></td>
        </tr>
        <tr>
            <td align="center">Autorizacion No. <?= $datos_factura->autorizacion ?></td>
        </tr>
        <tr>
            <td>- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - </td>
        </tr>
        <tr>
            <td align="center"><?= $datos_factura->nombre_actividad ?></td>
        </tr>
        <tr>
            <td><b>Fecha:</b> <?= date('d/m/Y', strtotime($datos_factura->fecha)) ?></td>
        </tr>
        <tr>
            <td style="text-align: left"><b>Nit:</b> <?= $datos_factura->ci_nit ?></td>
        </tr>
        <tr>
            <td style="text-align: left"><b>Nombre:</b> <?= ucwords(strtolower($datos_factura->nombre_cliente)) ?></td>
        </tr>
        <tr>
            <td>---------------------------------------------------------</td>
        </tr>
    </table>
    <table cellspacing="1" cellpadding="1" width="100%" >
        <tr>
            <td style="text-align: left"><b>Detalle</b></td>
            <td style="text-align: center"><b>Cant.</b></td>
            <td style="text-align: center"><b>P.Uni.</b></td>
            <td style="text-align: center"><b>Monto</b></td>
        </tr>
        <tr>
            <td colspan="13">
                ----------------------------------------------------------
            </td>
        </tr>
        <?php
        $contador = 0;
        foreach ($datos_venta_detalle as $row) {
            $contador = $contador+1;
            $cantidad = $row->cantidad;
            $descripcion = $row->nombre_item;
            $precio = $row->precio_venta;
            $subtotal = $cantidad * $precio;
            $categoria = $row->nombre_categoria;
            if($row->tamaño === 'Ninguno'){
                $tamaño = '';
            }else{
                $tamaño = $row->tamaño;
            }
            ?>
            <tr>
                <td style="text-align: left"><?= $descripcion. ' '. $tamaño ?></td>
                <td style="text-align: center"><?= $cantidad ?></td>
                <td style="text-align: center"><?= $precio ?></td>
                <td style="text-align: right"><?php echo number_format($subtotal, 2); ?></td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td style="text-align: right"><b>Sub Total Bs.:</b></td>
            <td colspan="2"></td>
            <td style="text-align: right"><b><?= number_format($datos_factura->subtotal, 2) ?> </b></td>
        </tr>
        <tr>
            <td style="text-align: right"><b>Descuento Bs.:</b></td>
            <td colspan="2"></td>
            <td style="text-align: right"><b><?= number_format($datos_factura->descuento, 2) ?> </b></td>
        </tr>
        <tr>
            <td style="text-align: right"><b>Total Bs.:</b></td>
            <td colspan="2"></td>
            <td style="text-align: right"><b><?= number_format($datos_factura->monto_total, 2) ?> </b></td>
        </tr>
    </table>
    <br>
    <table align="center">
        <tr>
            <td>
                Son: <?php
                include APPPATH.'/libraries/convertidor.php';
                $v = new EnLetras();
                $valor = $v->ValorEnLetras($datos_factura->monto_total, " ");
                echo $valor . " Bolivianos";
                ?>
                <br>
            </td>
        </tr>
        <tr>
            <td style="text-align: left">
                Cajero(a): <?= $this->session->userdata('usuario_sesion')['nombre']; ?>
                <br>
            </td>
        </tr>
        <tr>
            <td style="text-align: left">
                Hora: <?= date('H:i:s') ?>
                <br>
            </td>
        </tr>
        <tr>
            <td style="text-align: left">
                Codigo De Control: <?= $datos_factura->codigo_control ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: left">
                <span style="font-size: 11pt">Fecha Limite De Emision:</span> <?= date('d/m/Y', strtotime($datos_factura->fecha_limite)) ?>
            </td>
        </tr>
    </table>
    <table style="width: 100%" align="center">
        <tr>
            <td align="center"><?php echo '<img width="80" heigth="80" src="' . base_url(). $qr_image . '" /><br>'; ?></td>
        </tr>
        <tr>
            <td style="width:100%; font-size: 8pt; text-align: center">
                <b>"ESTA FACTURA CONTRIBUYE AL DESARROLLO DEL PAÍS. EL USO ILÍCITO DE ÉSTA SERÁ SANCIONADO DE ACUERDO A LEY"</b>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-size: 8pt;">
                <?= $datos_factura->leyenda ?>
            </td>
    </table>
</div>
</body>
</html>