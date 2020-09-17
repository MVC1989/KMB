<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<style></style>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h4 class="text-bold">Campaña Ecuasistencia</h4> </div>
                    <div class="panel-body table-responsive" id="listadoRegistros">
                        <table id="tblListado" class="table table-condensed table-hover table-responsive">
                            <thead>
                            <th>Num</th>
                            <th>Campaña</th>
                            <th>ImportId</th>
                            <th>Asesor</th>
                            <th>Identificación</th>
                            <th>Nombres cliente</th>
                            <th>Cuenta</th>
                            <th>Tarjeta</th>
                            <th>Tipo Plan</th>
                            <th></th>
                            </thead>
                            <tbody> </tbody>
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
                    <div class="panel-body" id="formularioRegistros">
                        <form name="formulario" id="formulario" method="POST" class="">
                            <div class="col-md-12">
                                <div class="box box-widget bg-gray-light">
                                    <div class="box-header with-border bg-gray">
                                        <div class="row col-xs-2 text-left"> <span class="text-bold">Última gestión:</span> </div>
                                        <div class="row col-xs-4 text-left">
                                            <input type="text" class="form-control input-sm" id="last" name="last" readonly/> </div>
                                        <div class="col-xs-1 text-left"> <span class="text-bold">Asesor/a:</span> </div>
                                        <div class="col-xs-2 text-left"> <span class="text-right"> <?php echo($_SESSION['name']); ?> </span> </div>
                                        <div class="col-xs-1 text-left"> <span class="text-bold">Fecha:</span> </div>
                                        <div class="col-xs-2 text-left"> <span id="mostrarHora" class="text-right"></span> </div>
                                        <div class="box-tools">
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <div class="hidden">
                                            <input type="text" class="form-control input-sm" id="horaInicio" name="horaInicio" readonly/>
                                        </div>
                                        <div id="formularioRegistros">
                                            <div class="row1">
                                                <div class="col-xs-12 input-group"> <span class="input-group-addon bg-blue-active">Resultados de gestión:</span>
                                                    <select style="width:280px" class="form-control input-sm" id="level1" name="level1" required>
                                                        <option></option>
                                                    </select> <span class="input-group-addon bg-gray"></span>
                                                    <select style="width:280px" class="form-control input-sm" id="level2" name="level2" required>
                                                        <option></option>
                                                    </select> <span id="spnLevel3" class="input-group-addon bg-gray"></span>
                                                    <select style="width:240px" class="form-control input-sm" id="level3" name="level3">
                                                        <option></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    <div class="input-group"> <span class="input-group-addon bg-blue-active">Fecha Agenda:</span>
                                                        <input type="date" class="form-control input-sm" id="agendaF" name="agendaF" readonly/> </div>
                                                    <br>
                                                    <div class="input-group"> <span class="input-group-addon bg-blue-active">&nbsp; Hora Agenda:</span>
                                                        <input type="time" class="form-control input-sm" id="agendaH" name="agendaH" readonly/> </div>
                                                </div>
                                                <div class="col-xs-3">
                                                    <div class="input-group"> <span class="input-group-addon bg-blue-active">Teléfono adicional:</span>
                                                        <input type="tel" class="form-control input-sm" id="fonoAd" name="fonoAd" /> </div>
                                                    <br>
                                                    <div class="input-group"> <span class="input-group-addon bg-blue-active"><input type="checkbox" class="" id="cbox2" value=""/></span> <span class="input-group-addon bg-blue-active">Otro asesor &nbsp;</span>
                                                        <select class="form-control input-sm" id="otro" name="otro">
                                                            <option></option>
                                                            <?php
                                                            require '../config/connection.php';
                                                            $result = ejecutarConsulta("SELECT Id FROM user where usergroup='3' and state='1' ORDER BY id");
                                                            while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                                                                echo '<option value="' . $row["Id"] . '">' . $row["Id"] . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xs-3">
                                                    <div class="input-group"> <span class="input-group-addon bg-blue-active">Teléfonos:</span>
                                                        <select class="form-control input-sm" id="fonos" name="fonos" onchange="copyToClipboard('#fonos option:selected')">
                                                            <option></option>
                                                        </select>
                                                        <select class="form-control input-sm" id="estatusTel" name="estatusTel">
                                                            <option></option>
                                                            <option value="Contactado">Contactado</option>
                                                            <option value="Grabadora">Grabadora</option>
                                                            <option value="Equivocado">Equivocado</option>
                                                            <option value="Averiado">Averiado</option>
                                                            <option value="No contesta">No contesta</option>
                                                        </select>
                                                        <button type="button" class="btn btn-info btn-sm" id="btnFonos" name="btnFonos"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp; Guardar Teléfono&nbsp;&nbsp;&nbsp;&nbsp;</button>
                                                    </div>
                                                </div>
                                                <div class="col-xs-2">
                                                    <div class="input-group"> <span class="input-group-addon bg-blue-active ">Intentos:</span>
                                                        <input type="text" class="form-control input-sm" id="intentos" name="intentos" readonly/> </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 hidden">
                                                <div class="col-xs-3">
                                                    <input type="text" class="form-control input-sm" id="horaInicioLlamada" name="horaInicioLlamada" readonly/>
                                                </div>
                                                <div class="col-xs-3">
                                                    <input type="text" class="form-control input-sm" id="interactionIdOld" name="interactionIdOld" readonly/>
                                                </div>
                                                <div class="col-xs-3">
                                                    <input type="text" class="form-control input-sm" id="interactionId" name="interactionId" readonly/>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="input-group"> <span class="input-group-addon bg-blue-active">Observaciones:</span>
                                                        <input type="text" class="form-control input-sm" id="obs" name="obs" /> </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    <br>
                                                </div>
                                                <div class="col-xs-2">
                                                    <button class="btn btn-success btn-sm" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar Gestión</button>
                                                </div>
                                                <div class="col-xs-2">
                                                    <button class="btn btn-danger btn-sm" onclick="cancelar_formulario()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar Gestión</button>
                                                </div>
                                                <div class="col-xs-4">
                                                    <br>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 btn bg-gray-light">
                                <div class="col-xs-2 hidden">
                                    <input type="text" class="form-control input-sm" id="code" name="code" readonly/>
                                    <input type="text" class="form-control input-sm" id="IDC" name="IDC" readonly/>
                                </div>
                                <div class="col-xs-3"> <b>Email </b>
                                    <input type="text" class="form-control input-sm" id="EMAIL" name="EMAIL" /> </div>
                                <div class="col-xs-2"> <b>Plan a seleccionar </b>
                                    <select class="form-control input-sm" id="PLAN" name="PLAN">
                                        <option></option>
                                        <option>Plan A (Titular)</option>
                                        <option>Plan B (Familiar)</option>
                                    </select>
                                </div>
                                <div class="col-xs-2"> <b>Campaña </b>
                                    <input type="text" class="form-control input-sm" id="CAMPANIA" name="CAMPANIA" readonly/> </div>
                                <div class="col-xs-3"> <b>Nombres </b>
                                    <input type="text" class="form-control input-sm" id="NOMBRES" name="NOMBRES" readonly/> </div>
                                <div class="col-xs-2"> <b>Identificación </b>
                                    <input type="text" class="form-control input-sm" id="IDENTIFICACION" name="IDENTIFICACION" readonly/> </div>
                                <div class="col-xs-2"> <b>Región </b>
                                    <input type="text" class="form-control input-sm" id="REGION" name="REGION" readonly/> </div>
                                <div class="col-xs-3"> <b>Ciudad </b>
                                    <input type="text" class="form-control input-sm" id="CIUDAD" name="CIUDAD" readonly/> </div>
                                <div class="col-xs-2"> <b>Género </b>
                                    <input type="text" class="form-control input-sm" id="GENERO" name="GENERO" readonly/> </div>
                                <div class="col-xs-2"> <b>Cuenta </b>
                                    <input type="text" class="form-control input-sm" id="CUENTA" name="CUENTA" readonly/> </div>
                                <div class="col-xs-2"> <b>Tarjeta </b>
                                    <input type="text" class="form-control input-sm" id="TARJETA" name="TARJETA" readonly/> </div>
                                <div class="col-xs-3"> <b>Tipo plan </b>
                                    <input type="text" class="form-control input-sm" id="TIPOPLAN" name="TIPOPLAN" readonly/> </div>
                                <div class="col-xs-2"> <b>Teléfono 1</b>
                                    <input type="text" class="form-control input-sm" id="TELEFONO1" name="TELEFONO1" readonly/> </div>
                                <div class="col-xs-2"> <b>Teléfono 2 </b>
                                    <input type="text" class="form-control input-sm" id="TELEFONO2" name="TELEFONO2" readonly/> </div>
                                <div class="col-xs-2"> <b>Teléfono 3 </b>
                                    <input type="text" class="form-control input-sm" id="TELEFONO3" name="TELEFONO3" readonly/> </div>
                                <div class="row1 col-xs-2"> <b>Teléfono 4 </b>
                                    <input type="text" class="form-control input-sm" id="TELEFONO4" name="TELEFONO4" readonly/> </div>
                                <div class="col-xs-2"> <b>Teléfono 5 </b>
                                    <input type="text" class="form-control input-sm" id="TELEFONO5" name="TELEFONO5" readonly/> </div>
                                <div class="col-md-2"> <b>Teléfono 6 </b>
                                    <input type="text" class="form-control input-sm" id="TELEFONO6" name="TELEFONO6" readonly/> </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php require 'footer.php'; ?>
<script src="scripts/ecuasistenciaCamp.js" type="text/javascript"></script>
<script src="scripts/funcions.js" type="text/javascript"></script>