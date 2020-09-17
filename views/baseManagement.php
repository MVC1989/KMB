<?php
require 'header.php';
require 'menu.php';
?>
<div class="content-wrapper">
    <section class="content">
        <div class="container">
            <div class=""> <!-- header -->
                <h3 class="">Administración de bases </h3>
            </div> <!-- /header -->
            <!-- Encabezado de los paneles -->
            <ul class="nav nav-tabs col-xs-11" role="tablist">
                <li class="nav-item active">
                    <a class="nav-link" data-toggle="pill" href="#asignar">Asignar / Retirar base</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#reciclar">Reciclar / Retirar base</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#reciclarUnoaUno">Reciclar base uno a uno</a>
                </li>
            </ul>
            <!-- contenido de los paneles -->
            <div class="tab-content col-xs-11">
                <div id="asignar" class="container tab-pane active col-xs-12"><br>
                    <div class="col-xs-2">
                        <p class="text-bold text-aqua">Listado de campañas </p>
                        <!--<input class="form-control" type="text" name="campaign" id="campaign" placeholder="Seleccione campaña" required />-->
                        <select name="campaign" id="campaign" class="form-control">
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
                    <div class="col-xs-3">
                        <p class="text-bold text-aqua">Listado de bases </p>
                        <!--<input class="form-control" type="text" name="base" id="base" placeholder="Seleccione importación" required />-->
                        <select name="base" id="base" class="form-control">
                        </select>
                    </div>
                    <div class="col-xs-3">
                        <p class="text-bold text-aqua">Listado de asesores </p>
                        <input class="form-control" type="text" name="asesor" id="asesor" placeholder="Seleccione asesores" required/>
                    </div>
                    <div class="col-xs-2">
                        <p class="text-bold text-aqua">Acciones </p>
                        <select  class="form-control" id="action" name="action" required>
                            <option>Seleccione opción</option>
                            <option value="Asignar Base">Asignar Base</option>
                            <option value="Retirar Base">Retirar Base</option>
                        </select>
                    </div>
                    <div class="col-xs-2">
                        <p class="text-bold text-aqua">Número registros</p>
                        <input type="text" onkeypress="return onlyNumbers(event)" class="form-control" id="Cant" name="Cant" placeholder="Cantidad" />
                    </div>
                    <div class="col-xs-12 center-block"><br></div>
                    <div class="col-xs-2 center-block"><br></div>
                    <div class="col-xs-3 center-block">
                        <br>
                        <button class="btn btn-primary btn-file" id="btnMostrar"><i class="fa fa-eye-slash"></i> Mostrar Registros No Asignados</button>
                    </div>
                    <div class="col-xs-3 center-block">
                        <br>
                        <button class="btn btn-primary btn-file" id="btnMostrarAssigns"><i class="fa fa-eye"></i> Mostrar Registros Asignados</button>
                    </div>
                    <div class="col-xs-1 center-block">
                        <br>
                        <button type="submit" class="btn btn-primary btn-github" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                    </div>
                    <div class="col-xs-12"><label></label></div>
                    <table id="tblListado" class="table table-condensed table-hover table-responsive">
                        <thead>
                        <th>Id</th>
                        <th>Nombres</th>
                        <th>Identificación</th>
                        <th>Campaña</th>
                        <th>Resultado de gestión</th>
                        <th>Importación</th>
                        <th>Agente</th>
                        <th>Fecha cambio</th>
                        <th>Usuario cambio</th>
                        <th>Acción</th>
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
                        </tfoot>
                    </table>
                </div>

                <div id="reciclar" class="container tab-pane fade col-xs-12"><br>
                    <div class="col-xs-2">
                        <p class="text-bold text-aqua">Seleccione campaña </p>
                        <input class="form-control" type="hidden" name="recycledType" id="recycledType" />
                        <select name="campaignRec" id="campaignRec" class="form-control">
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
                    <div class="col-xs-2">
                        <p class="text-bold text-aqua">Seleccione una base </p>
                        <!--<input class="form-control" type="text" name="base" id="base" placeholder="Seleccione importación" required />-->
                        <select name="baseRec" id="baseRec" class="form-control">

                        </select>
                    </div>
                    <div class="col-xs-2">
                        <p class="text-bold text-aqua">Estatus a reciclar </p>
                        <!--<input type="text" onkeypress="return onlyNumbers(event)" class="form-control" id="last" name="last" placeholder="Número del resultado de gestión" required />-->
                        <select name="estatus" id="estatus" class="form-control">
                            <option></option>
                            <option value="Regestionables">Regestionables</option>
                            <option value="Rellamados">Rellamados</option>
                        </select>
                    </div>
                    <div class="col-xs-2">
                        <p class="text-bold text-aqua">Listado de asesores </p>
                        <input class="form-control" type="text" id="asesorRec" name="asesorRec" placeholder="Seleccione asesores" required/>
                    </div>
                    <div class="col-xs-2">
                        <p class="text-bold text-aqua">Acciones </p>
                        <select  class="form-control" id="accion" name="accion" required>
                            <option></option>
                            <option>Reciclar base</option>
                            <option>Retirar base</option>
                        </select>
                    </div>
                    <div class="col-xs-2">
                        <p class="text-bold text-aqua">Cantidad de registros </p>
                        <input type="text" onkeypress="return onlyNumbers(event)" class="form-control" id="CantRec" name="CantRec" maxlength="120" placeholder="Cantidad" required />
                    </div>
                    <div class="col-xs-12 center-block"><br></div>
                    <div class="col-xs-2 center-block"><br></div>
                    <div class="col-xs-3 center-block">
                        <br>
                        <button class="btn btn-primary btn-file" id="btnMostrarPorReciclar"><i class="fa fa-eye"></i> Mostrar registros por reciclar</button>
                    </div>
                    <div class="col-xs-3 center-block">
                        <br>
                        <button class="btn btn-primary btn-file" id="btnMostrarRetirados"><i class="fa fa-bullseye"></i> Mostrar registros reciclados</button>
                    </div>
                    <div class="col-xs-1 center-block">
                        <br>
                        <button class="btn btn-primary btn-github" id="btnGuardarRec"><i class="fa fa-save"></i> Guardar</button>
                    </div>
                    <div class="col-xs-12"><label></label></div>
                    <table id="tblListadoRec" class="table table-condensed table-hover table-responsive">
                        <thead>
                        <th>Id</th>
                        <th>Nombres</th>
                        <th>Identificación</th>
                        <th>Campaña</th>
                        <th>Resultado de gestión</th>
                        <th>Importación</th>
                        <th>Agente</th>
                        <th>Fecha cambio</th>
                        <th>Usuario cambio</th>
                        <th>Acción</th>
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
                        </tfoot>
                    </table>
                </div>

                <div id="reciclarUnoaUno" class="container tab-pane fade col-xs-12"><br>
                    <p class="col-xs-1"><b>Seleccione campaña:</b></p>
                    <div class="col-xs-3">
                        <select name="campaignRec1" id="campaignRec1" class="form-control" required>
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
                    <p class="col-xs-1"><b>Seleccione asesor:</b></p>
                    <div class="col-xs-3">
                        <input class="form-control" type="text" id="asesorRec1" name="asesorRec1" placeholder="Asesor">
                    </div>
                    <div class="col-xs-2 box-tools pull-left">
                        <button class="btn btn-sm btn-success" id="btnAgregar">
                            <i class="fa fa-plus-circle"></i> Reciclar
                        </button>
                    </div>
                    <div class="col-xs-2 box-tools pull-right">
                        <button class="btn btn-sm btn-github" id="btnRetirar">
                            <i class="fa fa-plus-circle"></i> Retirar
                        </button>
                    </div>
                    <div class="col-xs-12"><label></label></div>
                    <table id="tblListadoRec1" class="table table-condensed table-hover table-responsive">
                        <thead>
                        <th>Seleccione</th>
                        <th>Nombres</th>
                        <th>Identificación</th>
                        <th>Campaña</th>
                        <th>Resultado de gestión</th>
                        <th>Importación</th>
                        <th>Agente</th>
                        <th>Estado</th>
                        </thead>
                        <tbody>        
                        </tbody>
                        <tfoot>
                        <th>Seleccione</th>
                        <th>Nombres</th>
                        <th>Identificación</th>
                        <th>Campaña</th>
                        <th>Resultado de gestión</th>
                        <th>Importación</th>
                        <th>Agente</th>
                        <th>Estado</th>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
<?php require 'footer.php'; ?>
<script src="scripts/basesManage.js" type="text/javascript"></script>
<script src="scripts/funcions.js" type="text/javascript"></script>