<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>

<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border"> <!-- header -->
                        <h1 class="box-title">Detalle por asesor </h1>
                    </div> <!-- /header -->
                    <div class="panel-body table-responsive" id="listadoRegistros"> <!-- listado de registros -->
                        <p class="col-xs-2"><b>Seleccione asesor:</b></p>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" name="asesor" id="asesor" />
                        </div>
                        <div class="col-xs-3 box-tools pull-left">
                            <button class="btn btn-sm btn-success" id="btnMostrar" type="button">
                                <i class="fa fa-plus-circle"></i> Mostrar
                            </button>
                        </div>
                        <div class="col-xs-12"><label></label></div>
                        <table id="tblListado" class="table table-condensed table-hover table-responsive">
                            <thead>
                            <th>Num</th>
                            <th>Código de gestión</th>
                            <th>Resultado nivel 1</th>
                            <th>Resultado nivel 2</th>
                            <th>Resultado nivel 3</th>
                            <th>Cantidad</th>
                            <th>Asesor</th>
                            <th>Campaña</th>
                            <th>Importación</th>
                            </thead>
                            <tbody>        
                            </tbody>
                            <tfoot>
                            <th>Num</th>
                            <th>Código de gestión</th>
                            <th>Resultado nivel 1</th>
                            <th>Resultado nivel 2</th>
                            <th>Resultado nivel 3</th>
                            <th>Cantidad</th>
                            <th>Asesor</th>
                            <th>Campaña</th>
                            <th>Importación</th>
                            </tfoot>
                        </table>
                    </div> <!-- /listado de registros -->
                </div>
            </div>
    </section>
</div><!-- /.content-wrapper -->

<?php require 'footer.php'; ?>
<script src="scripts/detalleByAsesor.js" type="text/javascript"></script>