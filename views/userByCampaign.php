<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>

<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border"> <!-- header -->
                        <h1 class="box-title">Administración de usuarios por campaña </h1>
                    </div> <!-- /header -->
                    <div class="panel-body table-responsive" id="listadoRegistros"> <!-- listado de registros -->
                        <p class="col-xs-2"><b>Seleccione campaña a asignar:</b></p>
                        <div class="col-xs-3">
                            <select name="campaign" id="campaign" class="form-control" required>
                                <?php
                                require '../config/connection.php';
                                echo '<option></option>';
                                $result = ejecutarConsulta("SELECT Id FROM campaign WHERE State = '1' ORDER BY Id");
                                while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                                    echo '<option value="' . $row["Id"] . '">' . $row["Id"] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-xs-3 box-tools pull-left">
                            <button class="btn btn-sm btn-success" id="btnAgregar" onclick="">
                                <i class="fa fa-plus-circle"></i> Agregar
                            </button>
                        </div>
                        <div class="col-xs-4 box-tools pull-right">
                            <button class="btn btn-sm btn-github" id="btnRetirar" onclick="">
                                <i class="fa fa-plus-circle"></i> Retirar
                            </button>
                        </div>
                        <div class="col-xs-12"><label></label></div>
                        <table id="tblListado" class="table table-condensed table-hover table-responsive">
                            <thead>
                            <th>Seleccione</th>
                            <th>Usuario</th>
                            <th>Nombres</th>
                            <th>Campaña</th>
                            </thead>
                            <tbody>        
                            </tbody>
                            <tfoot>
                            <th>Seleccione</th>
                            <th>Usuario</th>
                            <th>Nombres</th>
                            <th>Campaña</th>
                            </tfoot>
                        </table>
                    </div> <!-- /listado de registros -->
                </div>
            </div>
    </section>
</div><!-- /.content-wrapper -->

<?php require 'footer.php'; ?>
<script src="scripts/userByCampaign.js" type="text/javascript"></script>