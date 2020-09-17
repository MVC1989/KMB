<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<div class="content-wrapper">
    <section class="content">
        <h1>Subir listado de asesores</h1>
        <form name="frmcargararchivo" method="post" enctype="multipart/form-data">
            <p>Seleccione un archivo csv para realizar la importación de datos</p> 
            <p><input type="file" name="excel" id="excel" /></p>
            <p><input type="button" value="subir" onclick="cargarHojaExcel();" /></p>
        </form>
    </section>
</div>
<?php require 'footer.php'; ?>
<?php require 'scripts.php'; ?>
<script type="text/javascript">
    function cargarHojaExcel()
    {
        if (document.frmcargararchivo.excel.value == "")
        {
            alert("Seleccione un archivo");
            document.frmcargararchivo.excel.focus();
            return false;
        }

        document.frmcargararchivo.action = "../ajax/loadUsersC.php";
        document.frmcargararchivo.submit();
    }

</script>