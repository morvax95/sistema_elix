<?php

?>
</div>
<footer class="main-footer">

    <strong>Copyright &copy; 2019 <a href="#"> Sistema Elix</a>.</strong> Derechos reservados.
</footer>
</div>
<!-- Bootstrap 3.3.6 -->
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/datatables/jquery.dataTables.min.js') ?>" rel="stylesheet"></script>
<script src="<?= base_url('assets/datatables/dataTables.bootstrap.min.js') ?>" rel="stylesheet"></script>
<script src="<?= base_url('assets/js/app.min.js') ?>"></script>
<script src="<?= base_url('assets/js/select2.full.min.js') ?>"></script>
<script src="<?= base_url('assets/js/icheck.min.js') ?>"></script>
<script src="<?= base_url('assets/sweetalert/sweetalert.min.js') ?>"></script>
<script src="<?= base_url('assets/jquery.redirect/jquery.redirect.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery.hotkeys.js') ?>"></script>
<script>
    var base_url = '<?= base_url() ?>';
    var site_url = '<?= site_url() ?>';
    var recargar = 0;
    $(document).ready(function(){

        $('input[type=text]').focus(function(){
            $(this).select();
        });

        $('input[type=number]').focus(function(){
            $(this).select();
        });

    });
    /** funcion para actualizar el objeto datatable ***/
    function actualizarDataTable(tabla) {
        var tabla = tabla.DataTable();
        tabla.ajax.reload();
    }

</script>
</body>
</html>

