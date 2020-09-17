<?php
require 'header.php';
require 'menu.php';
?>
<style>
    #contenedor {
        width:10px;
        height:300px;
    }
    .loader:before,
    .loader:after,
    .loader {
        border-radius: 50%;
        width: 2.5em;
        height: 2.5em;
        -webkit-animation-fill-mode: both;
        animation-fill-mode: both;
        -webkit-animation: load7 1.8s infinite ease-in-out;
        animation: load7 1.8s infinite ease-in-out;
    }
    .loader {
        margin: 8em auto;
        font-size: 10px;
        position: relative;
        text-indent: -9999em;
        -webkit-animation-delay: 0.16s;
        animation-delay: 0.16s;
    }
    .loader:before {
        left: -3.5em;
    }
    .loader:after {
        left: 3.5em;
        -webkit-animation-delay: 0.32s;
        animation-delay: 0.32s;
    }
    .loader:before,
    .loader:after {
        content: '';
        position: absolute;
        top: 0;
    }
    @-webkit-keyframes load7 {
        0%,
        80%,
        100% {
            box-shadow: 0 2.5em 0 -1.3em black;
        }
        40% {
            box-shadow: 0 2.5em 0 0 #95969E;
        }
    }
    @keyframes load7 {
        0%,
        80%,
        100% {
            box-shadow: 0 2.5em 0 -1.3em black;
        }
        40% {
            box-shadow: 0 2.5em 0 0 #95969E;
        }
    }

</style>

<div class="content-wrapper">
    <section class="content">
        <div class="container">
            <!-- Encabezado de los paneles -->
            <ul class="nav nav-tabs col-xs-11" role="tablist">
                <li class="nav-item active">
                    <a class="nav-link" data-toggle="pill" href="#home">Importaciones</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#menu1">Activar / Cancelar base</a>
                </li>
            </ul>
            <!-- contenido de los paneles -->
            <div class="tab-content col-xs-11">
                <div id="home" class="container tab-pane active"><br>
                    <form class="container-fluid" id="frmcargararchivo" name="frmcargararchivo" method="post" enctype="multipart/form-data">
                        <div class="col-xs-3 text-left">
                            <b class="text-bold text-left text-bold">Nombre importación: </b>
                            <input class="form-control" type="text" name="import" id="import" required />
                        </div>
                        <div class="col-xs-2 text-left">
                            <b class="text-bold text-left text-bold">Mapeo: </b>
                            <select class="form-control" name="mapeo" id="mapeo" required>
                                <option></option>
                                <option>Banco Pichincha Broadcast</option>
                                <option>Banco Pichincha Cancelaciones</option>
                                <option>Banco Pichincha Cargos Recurrentes</option>
                                <option>Banco Pichincha Encuestas</option>
                                <!--<option>Banco Pichincha Encuesta Credito</option>-->
                                <option>Banco Pichincha Incrementos</option>
                                <option>Banco Pichincha Multioferta</option>
                                <option>Banco Pichincha Pasivos</option>
                                <option>Banco Pichincha Variaciones</option>
                                <option>Banco BGR Encuestas</option>
                                <option>Claro Ventas</option>
                                <option value="Ecuasistencia">Ecuasistencia Ventas</option>
                                <option>Ecuasistencia Encuesta</option>
                                <option>Jardines del Valle</option>
                                <option>Monitoreo Calidad</option>
                            </select>
                        </div>
                        <div class="row col-xs-3 text-left">
                            <b class="text-bold text-left text-bold">Campaña: </b>
                            <input class="form-control" type="text" name="campaign" id="campaign" required />
                        </div>
                        <div class="col-xs-3 text-left">
                            <b class="text-bold text-left text-bold">Seleccione un archivo csv</b>
                            <input class="form-control" type="file" name="excel" id="excel" />
                        </div>
                        <div class="col-xs-12 text-center"><br></div>
                        <div class="col-xs-10 text-center">
                            <button class="btn btn-info" id="btnGuardar" type="submit" value="Subir">
                                <i class="fa fa-upload"></i> Subir
                            </button>
                            <button class="btn btn-info" id="btnNuevaImp" type="button" value="Nueva" onclick="limpiar_formulario()">
                                <i class="fa fa-rotate-left"></i> Nueva importación
                            </button>
                        </div>
                        <div class="col-xs-10">
                            <div id="contenedor" class="center-block">
                                <div class="loader" id="loader">Loading...</div>
                            </div>
                        </div>
                        <div class="col-xs-10 text-center" id="mensaje">
                        </div>
                        <div class="col-xs-12"><br></div>
                    </form>
                </div>

                <div id="menu1" class="container tab-pane fade"><br>
                    <div class="col-xs-3">
                        <b>Seleccione campaña:</b>
                        <select name="campaignId" id="campaignId" class="form-control">
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
                    <div class="col-xs-4">
                        <b>Seleccione importación:</b>
                        <select name="importation" id="importation" class="form-control">
                        </select>
                    </div>
                    <div class="col-xs-2">
                        <b>Seleccione opción:</b>
                        <select name="acciones" id="acciones" class="form-control">
                            <option></option>
                            <option value="">Activar base</option>
                            <option value="Cancelar base">Cancelar base</option>
                        </select>
                    </div>
                    <div class="col-xs-12 text-center"><br></div>
                    <div class="col-xs-10 text-center">
                        <button class="btn btn-primary btn-file" type="button" id="btnMostrar"><i class="fa fa-eye-slash"></i> Mostrar Registros</button>
                        <button class="btn btn-info" id="btnEnviar" type="button">
                            <i class="fa fa-send"></i> Enviar
                        </button>
                        <button class="btn btn-bitbucket" title="Actualizar" onclick="limpiarPnlCancel()" type="button">
                            <i class="fa fa-repeat"></i>
                        </button>
                    </div>
                    <div class="col-xs-11 text-center"><br>
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
                </div>
            </div>
        </div>
    </section>
</div>
<?php require 'footer.php'; ?>
<script src="scripts/importaciones.js" type="text/javascript"></script>