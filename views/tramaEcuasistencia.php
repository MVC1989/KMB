<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>

<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border"> <!-- header -->
                        <h1 class="box-title">Trama Ecuasistencias </h1>
                    </div> <!-- /header -->
                    <div class="panel-body table-responsive" id="listadoRegistros"> <!-- listado de registros -->
                        <div class="btn bg-blue-active col-xs-12">
                            <p class="row col-xs-2"><b>Fecha Inicio:</b></p>
                            <div class="row col-xs-2">
                                <input type="date" class="form-control" id="StartDate" name="StartDate"/>
                            </div>
                            <p class="row col-xs-2"><b>Fecha Fin:</b></p>
                            <div class="row col-xs-2">
                                <input type="date" class="form-control" id="EndDate" name="Enddate"/>
                            </div>
                            <div class="row col-xs-4">
                                <button class="btn btn-sm btn-github" id="btnMostrar" onclick="">
                                    <i class="fa fa-plus-square"></i> Mostrar
                                </button>
                            </div>
                        </div>

                        <div class="col-xs-12"><label></label></div>
                        <table id="tblListado" class="table table-condensed table-hover table-responsive">
                            <thead>
                            <th>TIPO PLAN</th>
                            <th>CEDULA IDENTIDAD</th>
                            <th>NOMBRES</th>
                            <th>TELEFONO 1</th>
                            <th>TELEFONO 2</th>
                            <th>TELEFONO 3</th>
                            <th>TELEFONO 4</th>
                            <th>TELEFONO 5</th>
                            <th>TELEFONO 6</th>
                            <th>CIUDAD</th>
                            <th>GENERO</th>
                            <th>EMAIL</th>
                            <th>CUENTA</th>
                            <th>TARJETA</th>
                            <th>TELEFONO CONTACTADO</th>
                            <th>OPERADOR</th>
                            <th>FECHA</th>
                            <th>HORA</th>
                            <th>HORARIO</th>
                            <th>TURNO</th>
                            <th>ESTADO</th>
                            <th>MOTIVO REGISTRO</th>
                            <th>MOTIVO NO DESEA</th>
                            <th>MOTIVO TELEFONO</th>
                            <th>NUMERO INTENTOS</th>
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
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            </tfoot>
                        </table>
                    </div> <!-- /listado de registros -->
                </div>
            </div>
    </section>
</div><!-- /.content-wrapper -->

<?php require 'footer.php'; ?>
<script src="scripts/tramaEcuasistencias.js" type="text/javascript"></script>