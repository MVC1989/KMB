<?php
require 'header.php';
require 'menu.php';
?>
<style>
</style>

<div class="content-wrapper">
    <section class="content">
        <h2 class="text-blue ">Enriquecimiento de bases</h2>
        <form class="container-fluid" id="frmcargararchivo" name="frmcargararchivo" method="post" enctype="multipart/form-data">
            <div class="row col-xs-1 text-left"></div>
            <div class="row1 col-xs-5 text-left">
                <b class="text-bold text-left text-bold">Seleccione un archivo csv</b>
                <input class="form-control" type="file" name="excel" id="excel" />
            </div>
            <!--<div class="row1 col-xs-12 text-center"><br></div>-->
            <div class="row1 col-xs-3 text-center"> <br>
                <button class="btn btn-info" id="btnGuardar" type="submit" value="Subir">
                    <i class="fa fa-upload"></i> Subir
                </button>
            </div>
        </form>
        <br>
        <div class="row1 col-xs-12 text-center" id="mensaje">

        </div>
    </section>
</div>
<?php require 'footer.php'; ?>
<script src="scripts/enriquecimentoBases.js" type="text/javascript"></script>