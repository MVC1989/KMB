<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<style>
    div {
        padding: 2px;
    }
</style>

<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border"> <!-- header -->
                        <h1 class="box-title" id="titulo">Resultados de campaña </h1>
                        <div class="box-tools pull-right">
                            <button class="btn btn-sm btn-success" id="btnAgregar" onclick="mostrar_formulario(true)">
                                <i class="fa fa-plus-circle"></i> Agregar
                            </button>
                        </div>
                    </div> <!-- /header -->
                    <div class="panel-body table-responsive" id="listadoRegistros"> <!-- listado de registros -->
                        <table id="tblListado" class="table table-condensed table-hover table-responsive">
                            <thead>
                            <th>Num</th>
                            <th>Campaña</th>
                            <th>Código gestión</th>
                            <th>Resultado nivel 1</th>
                            <th>Resultado nivel 2</th>
                            <th>Resultado nivel 3</th>
                            <th>Estado</th>
                            <th>Acciones</th><!--espacio para botones-->
                            </thead>
                            <tbody>        
                            </tbody>
                            <tfoot>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th><!--espacio para botones-->
                            </tfoot>
                        </table>
                    </div> <!-- /listado de registros -->
                    <div class="panel-body" id="formularioRegistros"> <!-- formulario de registros -->
                        <form name="formulario" id="formulario" method="POST">
                            <div class="col-xs-3 hidden"><label>Id</label></div>
                            <div class="col-xs-9 hidden">
                                <input type="text" class="form-control" id="Id" name="Id"/>
                            </div>
                            <div class="col-xs-12">
                                <div class="col-xs-1"><label>Campaña</label></div>
                                <div class="col-xs-2">
                                    <input type="hidden" class="form-control" id="campaignId" name="campaignId" />
                                    <select class="form-control" id="campaign" name="campaign" required>
                                        <?php
                                        require '../config/connection.php';
                                        echo '<option></option>';
                                        $result = ejecutarConsulta("select distinct Id 'Id' from campaign");
                                        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                                            echo '<option value="' . $row["Id"] . '">' . $row["Id"] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-xs-9">
                                    <table class="table table-hover" id="results">
                                        <tr>
                                            <td><input type="text" class="form-control" id="resultLevel1" name="level1[]" maxlength="100" placeholder="Resultado nivel 1" required/></td>
                                            <td><input type="text" class="form-control" id="resultLevel2" name="level2[]" maxlength="100" placeholder="Resultado nivel 2"/></td>
                                            <td><input type="text" class="form-control" id="resultLevel3" name="level3[]" maxlength="100" placeholder="Resultado nivel 3"/></td>
                                            <td><input type="number" class="form-control" id="resultCode" name="code[]" placeholder="Código de gestión" required/></td>
                                            <td><button type="button" name="btnAdd" id="btnAdd" class="btn btn-bitbucket btn-sm" title="Agregar"><i class="fa fa-plus-square"></i></button></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-xs-12 text-center"><br/>
                                    <button class="btn btn-primary btn-sm" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                                    <button class="btn btn-danger btn-sm" onclick="cancelar_formulario()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                                </div>
                            </div>
                        </form>
                    </div> <!-- /formulario de registros -->
                </div>
            </div>
    </section>
</div><!-- /.content-wrapper -->

<?php require 'footer.php'; ?>
<script src="scripts/campaignResults.js" type="text/javascript"></script>