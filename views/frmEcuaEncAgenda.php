<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<style></style>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h4 class="text-bold">Campaña Ecuasistencia Encuesta</h4> </div>
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
                            <div class="col-xs-12">
                                <div class="box box-widget bg-gray-light">
                                    <div class="box-header with-border bg-gray">
                                        <div class="row col-xs-2 text-left"> <span class="text-bold">Última gestión:</span> </div>
                                        <div class="row col-xs-4 text-left">
                                            <input type="text" class="form-control input-sm" id="last" name="last" readonly/> </div>
                                        <div class="col-xs-1 text-left"> <span class="text-bold">Asesor/a:</span> </div>
                                        <div class="col-xs-2 text-left"> <span class="text-right"> <?php echo($_SESSION['name']); ?> </span> </div>
                                        <div class="col-xs-1 text-left"> <span class="text-bold">Fecha:</span> </div>
                                        <div class="col-xs-2 text-left"> <span id="mostrarHora" class="text-right"></span></div>
                                        <div class="box-tools">
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <input type="text" class="form-control input-sm hidden" id="horaInicio" name="horaInicio" readonly/>
                                        <div class="row">
                                            <div class="row1">
                                                <div class=" col-xs-6"> <b class="text-bold text-left text-bold">Resultados de gestión </b> </div>
                                                <div class="col-xs-6 text-left"> <b class="text-bold text-left text-bold">Teléfonos por marcar </b> </div>
                                            </div>
                                            <div class="row1">
                                                <div class=" col-xs-2">
                                                    <select class="form-control input-sm" id="level1" name="level1" required>
                                                        <option></option>
                                                    </select>
                                                </div>
                                                <div class=" col-xs-2">
                                                    <select class="form-control input-sm" id="level2" name="level2" required>
                                                        <option></option>
                                                    </select>
                                                </div>
                                                <div class=" col-xs-2">
                                                    <select class="form-control input-sm" id="level3" name="level3">
                                                        <option></option>
                                                    </select>
                                                </div>
                                                <div class="col-xs-2">
                                                    <select class="form-control input-sm" id="fonos" name="fonos" onchange="copyToClipboard('#fonos option:selected')">
                                                        <option></option>
                                                    </select>
                                                </div>
                                                <div class="col-xs-2">
                                                    <select class="form-control input-sm" id="estatusTel" name="estatusTel">
                                                        <option></option>
                                                        <option value="Contactado">Contactado</option>
                                                        <option value="Grabadora">Grabadora</option>
                                                        <option value="Equivocado">Equivocado</option>
                                                        <option value="Averiado">Averiado</option>
                                                        <option value="No contesta">No contesta</option>
                                                        <option value="Tono Ocupado">Tono Ocupado</option>
                                                    </select>
                                                </div>
                                                <div class="col-xs-1">
                                                    <button type="button" class="btn btn-info btn-sm" id="btnFonos" name="btnFonos"><i class="fa fa-save"></i> Guardar Teléfono</button>
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
                                            <div class="col-xs-12">
                                                <br>
                                            </div>
                                            <div class="row1">
                                                <div class=" col-xs-2 text-left">
                                                    <input type="checkbox" class="" id="cbox2" value="" />
                                                    <label for="cbox2">&nbsp; Otro asesor</label>
                                                    <select class="form-control input-sm" id="otro" name="otro">
                                                        <option></option>
                                                        <?php
                                                        require '../config/connection.php';
                                                        $result = ejecutarConsulta("SELECT Id FROM user where usergroup >='3' and state='1' ORDER BY id");
                                                        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                                                            echo '<option value="' . $row["Id"] . '">' . $row["Id"] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-xs-2 text-left"> <b class="text-bold text-left text-bold">Fecha Agendamiento </b> </div>
                                                <div class="col-xs-2 text-left"> <b class="text-bold text-left text-bold">Teléfono adicional </b> </div>
                                                <div class="col-xs-5 text-left"> <b class="text-bold text-left text-bold ">Observaciones </b> </div>
                                                <div class="col-xs-1 text-left"> <b class="text-bold text-left text-bold">Intentos </b> </div>
                                            </div>
                                            <div class="row1">
                                                <div class=" col-xs-2">
                                                    <input placeholder="aaaa/mm/dd hh:mm:ss" class="form-control input-sm" id="agenda" name="agenda" readonly/> </div>
                                                <div class=" col-xs-2">
                                                    <input pattern="^0[2-9](\d{7,8})$" onkeypress="return onlyNumbers(event)" type="text" class="form-control input-sm" id="fonoAd" name="fonoAd" /> </div>
                                                <div class="col-xs-2"> </div>
                                                <div class="col-xs-5">
                                                    <input type="text" class="form-control input-sm" id="obs" name="obs" /> </div>
                                                <div class="col-xs-1">
                                                    <input type="text" class="form-control input-sm" id="intentos" name="intentos" readonly/> </div>
                                            </div>
                                            <div class="col-xs-12">
                                                <br>
                                            </div>
                                            <div class="row1">
                                                <div class="col-xs-6 text-right">
                                                    <button class="btn btn-success btn-sm" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar Gestión</button>
                                                </div>
                                                <div class="col-xs-6 text-left">
                                                    <button class="btn btn-danger btn-sm" onclick="cancelar_formulario()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar Gestión</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="pnlEncuesta" class="col-xs-12 btn">
                                <div class="box box-widget bg-gray">
                                    <div class="box-body">
                                        <div class="col-xs-10"><textarea id="pregunta1" name="pregunta1" class="text-bold form-control" readonly>1. Por favor califique su nivel de esfuerzo o facilidad para contactarse y solicitar el servicio de asistencia en escala de 1 a 5, tomando en cuenta que 1 es muy difícil y 5 muy fácil.</textarea></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta1" name="respuesta1" class="form-control">
                                                <option value=""></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-12"><textarea id="pregunta1_1" name="pregunta1_1" class="text-bold form-control" readonly>1.1 ¿Me puede indicar cuál fue el motivo para que usted considere la dificultad en solicitar el servicio? (Solo para calificaciones menores o igual a 3)</textarea></div>
                                        <div class="col-xs-12"><input id="respuesta1_1" name="respuesta1_1" type="text" class="form-control" readonly></div>
                                        <div class="col-xs-10"><textarea id="pregunta2" name="pregunta2" class="text-bold form-control" readonly>2. En escala del 1 al 10 tomando en cuenta que 1 es malo y 10 excelente, ¿cómo calificaría su experiencia  en cuanto al servicio de asistencia recibido?</textarea></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta2" name="respuesta2" class="form-control">
                                                <option value=""></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-12"><textarea id="pregunta2_1" name="pregunta2_1" class="text-bold form-control" readonly>2.1 ¿Me puede comentar por cuál de las siguientes razones otorgo esta calificación? (Solo para calificaciones menores o igual a 7)</textarea></div>
                                        <div id="vehicular" class="col-xs-12">
                                            <div class="col-xs-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input id="chk_VEH1" name="chk_VEH1" value="chk_VEH1" type="checkbox">
                                                    </span>
                                                    <input id="respuesta2_VEH1" name="respuesta2_VEH1" type="text" value="Atención Telefónica del operador de asistencia" class="form-control" readonly>
                                                </div>
                                                <!-- /input-group -->
                                            </div>

                                            <div class="col-xs-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input id="chk_VEH2" name="chk_VEH2" value="chk_VEH2" type="checkbox">
                                                    </span>
                                                    <input id="respuesta2_VEH2" name="respuesta2_VEH2" type="text" value="Acompañamiento Telefónico" class="form-control" readonly>
                                                </div>
                                                <!-- /input-group -->
                                            </div>

                                            <div class="col-xs-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input id="chk_VEH3" name="chk_VEH3" value="chk_VEH3" type="checkbox">
                                                    </span>
                                                    <input id="respuesta2_VEH3" name="respuesta2_VEH3" type="text" value="Demora del servicio" class="form-control" readonly>
                                                </div>
                                                <!-- /input-group -->
                                            </div>

                                            <div class="col-xs-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input id="chk_VEH4" name="chk_VEH4" value="chk_VEH4" type="checkbox">
                                                    </span>
                                                    <input id="respuesta2_VEH4" name="respuesta2_VEH4" type="text" value="Atención del prestador del servicio" class="form-control" readonly>
                                                </div>
                                                <!-- /input-group -->
                                            </div>

                                            <div class="col-xs-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input id="chk_VEH5" name="chk_VEH5" value="chk_VEH5" type="checkbox">
                                                    </span>
                                                    <input id="respuesta2_VEH5" name="respuesta2_VEH5" type="text" value="Estado de la unidad del prestador del servicio" class="form-control" readonly>
                                                </div>
                                                <!-- /input-group -->
                                            </div>

                                            <div class="col-xs-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input id="chk_VEH6" name="chk_VEH6" value="chk_VEH6" type="checkbox">
                                                    </span>
                                                    <input id="respuesta2_VEH6" name="respuesta2_VEH6" type="text" value="Daños al Vehiculo" class="form-control" readonly>
                                                </div>
                                                <!-- /input-group -->
                                            </div>
                                        </div>

                                        <div id="hogar" class="col-xs-12">
                                            <div class="col-xs-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input id="chk_HOG1" name="chk_HOG1" value="chk_HOG1" type="checkbox">
                                                    </span>
                                                    <input id="respuesta2_HOG1" name="respuesta2_HOG1" type="text" value="Atención Telefónica del operador de asistencia" class="form-control" readonly>
                                                </div>
                                                <!-- /input-group -->
                                            </div>

                                            <div class="col-xs-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input id="chk_HOG2" name="chk_HOG2" value="chk_HOG2" type="checkbox">
                                                    </span>
                                                    <input id="respuesta2_HOG2" name="respuesta2_HOG2" type="text" value="Acompañamiento Telefónico" class="form-control" readonly>
                                                </div>
                                                <!-- /input-group -->
                                            </div>

                                            <div class="col-xs-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input id="chk_HOG3" name="chk_HOG3" value="chk_HOG3" type="checkbox">
                                                    </span>
                                                    <input id="respuesta2_HOG3" name="respuesta2_HOG3" type="text" value="Demora del servicio" class="form-control" readonly>
                                                </div>
                                                <!-- /input-group -->
                                            </div>

                                            <div class="col-xs-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input id="chk_HOG4" name="chk_HOG4" value="chk_HOG4" type="checkbox">
                                                    </span>
                                                    <input id="respuesta2_HOG4" name="respuesta2_HOG4" type="text" value="Atención del prestador del servicio" class="form-control" readonly>
                                                </div>
                                                <!-- /input-group -->
                                            </div>

                                            <div class="col-xs-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input id="chk_HOG5" name="chk_HOG5" value="chk_HOG5" type="checkbox">
                                                    </span>
                                                    <input id="respuesta2_HOG5" name="respuesta2_HOG5" type="text" value="Causo daños al bien mueble" class="form-control" readonly>
                                                </div>
                                                <!-- /input-group -->
                                            </div>
                                        </div>

                                        <div id="personas" class="col-xs-12">
                                            <div class="col-xs-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input id="chk_PER1" name="chk_PER1" value="chk_PER1" type="checkbox">
                                                    </span>
                                                    <input id="respuesta2_PER1" name="respuesta2_PER1" type="text" value="Atención Telefónica del operador de asistencia" class="form-control" readonly>
                                                </div>
                                                <!-- /input-group -->
                                            </div>

                                            <div class="col-xs-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input id="chk_PER2" name="chk_PER2" value="chk_PER2" type="checkbox">
                                                    </span>
                                                    <input id="respuesta2_PER2" name="respuesta2_PER2" type="text" value="Acompañamiento Telefónico" class="form-control" readonly>
                                                </div>
                                                <!-- /input-group -->
                                            </div>

                                            <div class="col-xs-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input id="chk_PER3" name="chk_PER3" value="chk_PER3" type="checkbox">
                                                    </span>
                                                    <input id="respuesta2_PER3" name="respuesta2_PER3" type="text" value="Demora del servicio" class="form-control" readonly>
                                                </div>
                                                <!-- /input-group -->
                                            </div>

                                            <div class="col-xs-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input id="chk_PER4" name="chk_PER4" value="chk_PER4" type="checkbox">
                                                    </span>
                                                    <input id="respuesta2_PER4" name="respuesta2_PER4" type="text" value="Atención del prestador del servicio" class="form-control" readonly>
                                                </div>
                                                <!-- /input-group -->
                                            </div>

                                            <div class="col-xs-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input id="chk_PER5" name="chk_PER5" value="chk_PER5" type="checkbox">
                                                    </span>
                                                    <input id="respuesta2_PER5" name="respuesta2_PER5" type="text" value="Estado de la unidad del prestador del servicio" class="form-control" readonly>
                                                </div>
                                                <!-- /input-group -->
                                            </div>
                                        </div>

                                        <div id="legal" class="col-xs-12">
                                            <div class="col-xs-8">
                                                <div class="col-xs-2 hidden">
                                                    <input id="rad_txt" name="rad_txt" type="text" class="form-control">
                                                </div>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input id="rad_LEG1" name="radio" value="rad_LEG1" type="radio">
                                                    </span>
                                                    <input id="respuesta2_LEG1" name="respuesta2_LEG1" type="text" value="El tiempo de espera para recibir la asistencia legal telefonica e In Situ." class="form-control" readonly>
                                                </div>
                                                <!-- /input-group -->
                                            </div>

                                            <div class="col-xs-8">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input id="rad_LEG2" name="radio" value="rad_LEG2" type="radio">
                                                    </span>
                                                    <input id="respuesta2_LEG2" name="respuesta2_LEG2" type="text" value="La asesoria legal telefonica por parte de nuestro asesor legal" class="form-control" readonly>
                                                </div>
                                                <!-- /input-group -->
                                            </div>

                                            <div class="col-xs-8">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input id="rad_LEG3" name="radio" value="rad_LEG3" type="radio">
                                                    </span>
                                                    <input id="respuesta2_LEG3" name="respuesta2_LEG3" type="text" value="La gestión y atención por parte de nuestro abogado en el lugar de asistencia" class="form-control" readonly>
                                                </div>
                                                <!-- /input-group -->
                                            </div>
                                        </div>
                                        <div class="col-xs-10"><textarea id="pregunta3" name="pregunta3" class="text-bold form-control" readonly>3. En escala de 0 a 10 ¿en qué grado recomendaría (Nombre del Seguro) a un familiar, amigo o colega de trabajo?, siendo 1 definitivamente no recomendaría y 10 definitivamente sí lo recomendaría.</textarea></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta3" name="respuesta3" class="form-control">
                                                <option value=""></option>
                                                <option value="0">0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-6">
                                            <input id="pregunta3_2" name="pregunta3_2" class="text-bold form-control" readonly value="3.1 ¿Me puede comentar porque NO nos recomendaría?" />
                                            <input id="pregunta3_1" name="pregunta3_1" class="text-bold form-control" readonly value="3.1 ¿Me puede comentar porque nos recomendaría?" />
                                        </div>
                                        <div class="col-xs-6"><input id="respuesta3_1" name="respuesta3_1" type="text" class="form-control"></div>
                                        <div class="col-xs-12">
                                            <input id="pregunta4_VEH" name="pregunta4_VEH" class="text-bold form-control" readonly value="4. (Nombre del Seguro) como podría superar sus expectativas al momento de solicitar una asistencia vehicular." />
                                            <input id="pregunta4_HOG" name="pregunta4_HOG" class="text-bold form-control" readonly value="4. (Nombre del Seguro) como podría superar sus expectativas al momento de solicitar una asistencia para su domicilio." />
                                            <input id="pregunta4_PER" name="pregunta4_PER" class="text-bold form-control" readonly value="4. (Nombre del Seguro) como podría superar sus expectativas al momento de solicitar una asistencia." />
                                            <input id="pregunta4_LEG" name="pregunta4_LEG" class="text-bold form-control" readonly value="4. (Nombre del Seguro) como podría superar sus expectativas al momento de solicitar una asistencia legal." />
                                        </div>
                                        <div class="col-xs-12"><input id="respuesta4" name="respuesta4" type="text" class="form-control"></div>

                                    </div>
                                </div>
                            </div>

                            <div id="pnlEncuestaAntiguaLegal" class="col-xs-12 btn">
                                <div class="box box-widget bg-gray">
                                    <div class="box-body">
                                        <div class="col-xs-12"><label>Califique en la escala del 1 al 7, donde 1 es "Malo" y 7 es "Excelente" los siguientes enunciados:</label></div>
                                        <div class="col-xs-10"><input id="pregunta1_LEGAL" name="pregunta1_LEGAL" class="text-bold form-control" value="1. La facilidad para comunicarse con la asistencia legal" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta1_LEGAL" name="respuesta1_LEGAL" class="form-control">
                                                <option value=""></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-10"><input id="pregunta2_LEGAL" name="pregunta2_LEGAL" class="text-bold form-control" value="2. La agilidad del asesor legal para atender el trámite" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta2_LEGAL" name="respuesta2_LEGAL" class="form-control">
                                                <option value=""></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-10"><input id="pregunta3_LEGAL" name="pregunta3_LEGAL" class="text-bold form-control" value="3. La cordialidad recibida por parte del asesor legal" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta3_LEGAL" name="respuesta3_LEGAL" class="form-control">
                                                <option value=""></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-10"><input id="pregunta4_LEGAL" name="pregunta4_LEGAL" class="text-bold form-control" value="4. El asesoramiento recibido, frente a sus inquitudes legales" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta4_LEGAL" name="respuesta4_LEGAL" class="form-control">
                                                <option value=""></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-10"><textarea id="pregunta5_LEGAL" name="pregunta5_LEGAL" class="text-bold form-control" readonly>5. En la escala de 1 a 10 donde, donde 1 es “Muy Insatisfecho” y 10 “Muy Satisfecho”, por favor califique: Su grado de satisfacción con el proceso de Asistencia Legal? </textarea></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta5_LEGAL" name="respuesta5_LEGAL" class="form-control">
                                                <option value=""></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-10"><textarea id="pregunta6_LEGAL" name="pregunta6_LEGAL" class="text-bold form-control" readonly>6. En la escala de 1 a 10 donde, donde 1 es “Muy Insatisfecho” y 10 “Muy Satisfecho”, por favor califique:  en base al servicio recibido Su grado de satisfacción con Seguros Equinoccial es? </textarea></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta6_LEGAL" name="respuesta6_LEGAL" class="form-control">
                                                <option value=""></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-10"><textarea id="pregunta7_LEGAL" name="pregunta7_LEGAL" class="text-bold form-control" readonly>7. En una escala de 1 a 5 en donde 1 es muy fácil y 5 muy difícil, califique: su nivel de dificultad o facilidad en el proceso de Asistencia Legal con Seguros Equinoccial?</textarea></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta7_LEGAL" name="respuesta7_LEGAL" class="form-control">
                                                <option value=""></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-10"><textarea id="pregunta8_LEGAL" name="pregunta8_LEGAL" class="text-bold form-control" readonly>8. Si su experiencia con Seguros Equinoccial se mantiene igual a la que ha tenido hasta ahora, consideraría seguir con nosotros, por cuánto tiempo más?</textarea></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta8_LEGAL" name="respuesta8_LEGAL" class="form-control">
                                                <option value=""></option>
                                                <option value="De 3 a 5 años">De 3 a 5 años</option>
                                                <option value="De 1 a 3 años">De 1 a 3 años</option>
                                                <option value="Hasta 1 año">Hasta 1 año</option>
                                                <option value="NO QUIERO SEGUIR">NO QUIERO SEGUIR</option>
                                                <option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-10"><textarea id="pregunta9_LEGAL" name="pregunta9_LEGAL" class="text-bold form-control" readonly>9. En escala de 0 a 10 ¿en qué grado recomendaría Seguros Equinoccial a un familiar, amigo o colega de trabajo?, siendo 0 definitivamente no recomendaría y 10 definitivamente sí lo recomendaría? </textarea></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta9_LEGAL" name="respuesta9_LEGAL" class="form-control">
                                                <option value=""></option>
                                                <option value="0">0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-12"><input id="pregunta10_LEGAL" name="pregunta10_LEGAL" class="text-bold form-control" value="10. Seguros Equinoccial cómo podría superar sus expectativas en el proceso de Asistencia Legal?" readonly/></div>
                                        <div class="col-xs-12"><input id="respuesta10_LEGAL" name="respuesta10_LEGAL" class="text-bold form-control" /></div>
                                    </div>
                                </div>
                            </div>

                            <div id="pnlEncuestaAntiguaVIP" class="col-xs-12 btn">
                                <div class="box box-widget bg-gray">
                                    <div class="box-body">
                                        <div class="col-xs-12"><label>ATRIBUTO - Califique en la escala del 1 al 7, donde 1 es "Malo" y 7 es "Excelente" los siguientes enunciados:</label></div>
                                        <div class="col-xs-10"><input id="pregunta1_VIP" name="pregunta1_VIP" class="text-bold form-control" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta1_VIP" name="respuesta1_VIP" class="form-control">
                                                <option value=""></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>
                                                <option value="SOLICITO SU BROADCAST">SOLICITO SU BROADCAST</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-10"><input id="pregunta2_VIP" name="pregunta2_VIP" class="text-bold form-control" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta2_VIP" name="respuesta2_VIP" class="form-control">
                                                <option value=""></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>
                                                <option value="SOLICITO SU BROADCAST">SOLICITO SU BROADCAST</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-10"><input id="pregunta3_VIP" name="pregunta3_VIP" class="text-bold form-control" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta3_VIP" name="respuesta3_VIP" class="form-control">
                                                <option value=""></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>
                                                <option value="SOLICITO SU BROADCAST">SOLICITO SU BROADCAST</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-10"><input id="pregunta4_VIP" name="pregunta4_VIP" class="text-bold form-control" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta4_VIP" name="respuesta4_VIP" class="form-control">
                                                <option value=""></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>
                                                <option value="SOLICITO SU BROADCAST">SOLICITO SU BROADCAST</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-10"><input id="pregunta5_VIP" name="pregunta5_VIP" class="text-bold form-control" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta5_VIP" name="respuesta5_VIP" class="form-control">
                                                <option value=""></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>
                                                <option value="SOLICITO SU BROADCAST">SOLICITO SU BROADCAST</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-12"><label>LEALTAD - En la escala de 1 a 10, donde 1 es “Muy Insatisfecho” y 10 “Muy Satisfecho”, por favor califique:</label></div>
                                        <div class="col-xs-10"><input id="pregunta6_VIP" name="pregunta6_VIP" class="text-bold form-control" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta6_VIP" name="respuesta6_VIP" class="form-control">
                                                <option value=""></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>
                                                <option value="SOLICITO SU BROADCAST">SOLICITO SU BROADCAST</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-8"><input id="pregunta6_1_VIP" name="pregunta6_1_VIP" class="text-bold form-control" value="Me puede comentar en qué podríamos mejorar para cumplir sus expectativas de servicio" readonly/></div>
                                        <div class="col-xs-4"><input id="respuesta6_1_VIP" name="respuesta6_1_VIP" class="text-bold form-control" /></div>
                                        <div class="col-xs-10"><input id="pregunta7_VIP" name="pregunta7_VIP" class="text-bold form-control" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta7_VIP" name="respuesta7_VIP" class="form-control">
                                                <option value=""></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>
                                                <option value="SOLICITO SU BROADCAST">SOLICITO SU BROADCAST</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-8"><input id="pregunta7_1_VIP" name="pregunta7_1_VIP" class="text-bold form-control" value="Me puede comentar en qué podríamos mejorar para cumplir sus expectativas de servicio" readonly/></div>
                                        <div class="col-xs-4"><input id="respuesta7_1_VIP" name="respuesta7_1_VIP" class="text-bold form-control" /></div>
                                        <div class="col-xs-12"><label class="text-right">Siendo 0 definitivamente no recomendaría y 10 definitivamente si lo recomendaría.</label></div>
                                        <div class="col-xs-10"><textarea id="pregunta8_VIP" name="pregunta8_VIP" class="text-bold form-control" readonly></textarea></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta8_VIP" name="respuesta8_VIP" class="form-control">
                                                <option value=""></option>
                                                <option value="0">0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>
                                                <option value="SOLICITO SU BROADCAST">SOLICITO SU BROADCAST</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-5">
                                            <input id="pregunta8_2_VIP" name="pregunta8_2_VIP" class="text-bold form-control" readonly value="¿Me puede comentar porque NO nos recomendaría?" />
                                            <input id="pregunta8_1_VIP" name="pregunta8_1_VIP" class="text-bold form-control" readonly value="¿Me puede comentar porque nos recomendaría?" />
                                        </div>
                                        <div class="col-xs-7"><input id="respuesta8_1_VIP" name="respuesta8_1_VIP" type="text" class="form-control"></div>
                                        <div class="col-xs-10"><textarea id="pregunta9_VIP" name="pregunta9_VIP" class="text-bold form-control" readonly></textarea></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta9_VIP" name="respuesta9_VIP" class="form-control">
                                                <option value=""></option>
                                                <option value="MUY FACIL">MUY FACIL</option>
                                                <option value="FACIL">FACIL</option>
                                                <option value="POCO FACIL">POCO FACIL</option>
                                                <option value="DIFICIL">DIFICIL</option>
                                                <option value="MUY DIFICIL">MUY DIFICIL</option>
                                                <option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>
                                                <option value="SOLICITO SU BROADCAST">SOLICITO SU BROADCAST</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-8">
                                            <input id="pregunta9_1_VIP" name="pregunta9_1_VIP" class="text-bold form-control" readonly value="Indiquenos cuál fue el motivo para que usted considere la dificultad en solicitar el servicio" />
                                        </div>
                                        <div class="col-xs-4"><input id="respuesta9_1_VIP" name="respuesta9_1_VIP" type="text" class="form-control"></div>
                                        <div class="col-xs-12"><label class="text-right">ECONOMICS</label></div>
                                        <div class="col-xs-10"><input id="pregunta10_VIP" name="pregunta10_VIP" class="text-bold form-control" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta10_VIP" name="respuesta10_VIP" class="form-control">
                                                <option value=""></option>
                                                <option value="5 años o más">5 años o más</option>
                                                <option value="De 3 a 4 años">De 3 a 4 años</option>
                                                <option value="De 2 a 3 años">De 2 a 3 años</option>
                                                <option value="De 1 a 2 años">De 1 a 2 años</option>
                                                <option value="De 6 meses a 1 año">De 6 meses a 1 año</option>
                                                <option value="Menos de 6 meses">Menos de 6 meses</option>
                                                <option value="NO QUIERO SEGUIR">NO QUIERO SEGUIR</option>
                                                <option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-12"><label class="text-right">VOC</label></div>
                                        <div class="col-xs-12"><textarea id="pregunta11_VIP" name="pregunta11_VIP" class="text-bold form-control" readonly></textarea></div>
                                        <div class="col-xs-12"><input id="respuesta11_VIP" name="respuesta11_VIP" class="text-bold form-control" /></div>
                                    </div>
                                </div>
                            </div>

                            <div id="pnlEncuestaVehicularEq" class="col-xs-12 btn">
                                <div class="box box-widget bg-gray">
                                    <div class="box-body">
                                        <div class="col-xs-12"><label>ATRIBUTO - Califique en la escala del 1 al 7, donde 1 es "Malo" y 7 es "Excelente" los siguientes enunciados:</label></div>
                                        <div class="col-xs-10"><input id="pregunta1_VEH_EQ" name="pregunta1_VEH_EQ" class="text-bold form-control" value="1. La gestión telefónica del asesor de asistencia." readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta1_VEH_EQ" name="respuesta1_VEH_EQ" class="form-control">
                                                <option value=""></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>
                                                <option value="SOLICITO SU BROADCAST">SOLICITO SU BROADCAST</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-10"><input id="pregunta2_VEH_EQ" name="pregunta2_VEH_EQ" class="text-bold form-control" value="2. El acompañamiento por parte del asesor telefónico hasta la llegada de la asistencia vehicular." readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta2_VEH_EQ" name="respuesta2_VEH_EQ" class="form-control">
                                                <option value=""></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>
                                                <option value="SOLICITO SU BROADCAST">SOLICITO SU BROADCAST</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-10"><input id="pregunta3_VEH_EQ" name="pregunta3_VEH_EQ" class="text-bold form-control" value="3. El tiempo de espera para recibir la asistencia vehicular." readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta3_VEH_EQ" name="respuesta3_VEH_EQ" class="form-control">
                                                <option value=""></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>
                                                <option value="SOLICITO SU BROADCAST">SOLICITO SU BROADCAST</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-10"><input id="pregunta4_VEH_EQ" name="pregunta4_VEH_EQ" class="text-bold form-control" value="4. El estado de la unidad que le otorgó el servicio de asistencia vehicular (grúa, wincha, moto)." readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta4_VEH_EQ" name="respuesta4_VEH_EQ" class="form-control">
                                                <option value=""></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>
                                                <option value="SOLICITO SU BROADCAST">SOLICITO SU BROADCAST</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-12"><label>BLOQUE DE LEALTAD En la escala de 1 a 10, donde 1 es “Muy Insatisfecho” y 10 “Muy Satisfecho”, por favor califique:</label></div>
                                        <div class="col-xs-10"><input id="pregunta5_VEH_EQ" name="pregunta5_VEH_EQ" class="text-bold form-control" value="5. Su grado de satisfacción con el proceso de Asistencia vehicular" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta5_VEH_EQ" name="respuesta5_VEH_EQ" class="form-control">
                                                <option value=""></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>
                                                <option value="SOLICITO SU BROADCAST">SOLICITO SU BROADCAST</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-8"><input id="pregunta5_1_VEH_EQ" name="pregunta5_1_VEH_EQ" class="text-bold form-control" value="5.1 ¿Por favor coméntenos el motivo de su calificación?" readonly/></div>
                                        <div class="col-xs-4"><input id="respuesta5_1_VEH_EQ" name="respuesta5_1_VEH_EQ" class="text-bold form-control" /></div>
                                        <div class="col-xs-10"><input id="pregunta6_VEH_EQ" name="pregunta6_VEH_EQ" class="text-bold form-control" value="6. Su grado de satisfacción general con Seguros Equinoccial es:" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta6_VEH_EQ" name="respuesta6_VEH_EQ" class="form-control">
                                                <option value=""></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>
                                                <option value="SOLICITO SU BROADCAST">SOLICITO SU BROADCAST</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-8"><input id="pregunta6_1_VEH_EQ" name="pregunta6_1_VEH_EQ" class="text-bold form-control" value="6.1 ¿Por favor coméntenos el motivo de su calificación?" readonly/></div>
                                        <div class="col-xs-4"><input id="respuesta6_1_VEH_EQ" name="respuesta6_1_VEH_EQ" class="text-bold form-control" /></div>
                                        <div class="col-xs-12"><label class="text-right">Siendo 0 definitivamente no recomendaría y 10 definitivamente si lo recomendaría.</label></div>
                                        <div class="col-xs-10"><input id="pregunta7_VEH_EQ" name="pregunta7_VEH_EQ" class="text-bold form-control" value="7. En escala de 0 a 10 ¿en qué grado recomendaría Seguros Equinoccial a un familiar, amigo o colega de trabajo?" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta7_VEH_EQ" name="respuesta7_VEH_EQ" class="form-control">
                                                <option value=""></option>
                                                <option value="0">0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>
                                                <option value="SOLICITO SU BROADCAST">SOLICITO SU BROADCAST</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-8"><input id="pregunta7_1_VEH_EQ" name="pregunta7_1_VEH_EQ" class="text-bold form-control" value="7.1 ¿Por favor coméntenos el motivo de su calificación?" readonly/></div>
                                        <div class="col-xs-4"><input id="respuesta7_1_VEH_EQ" name="respuesta7_1_VEH_EQ" class="text-bold form-control" /></div>
                                        <div class="col-xs-10"><input id="pregunta8_VEH_EQ" name="pregunta8_VEH_EQ" class="text-bold form-control" value="8. En una escala de 1 a 5 califique: qué tan fácil o difícil fue solicitar el servicio de asistencia vehicular" readonly /></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta8_VEH_EQ" name="respuesta8_VEH_EQ" class="form-control">
                                                <option value=""></option>
                                                <option value="MUY FACIL">MUY FACIL</option>
                                                <option value="FACIL">FACIL</option>
                                                <option value="POCO FACIL">POCO FACIL</option>
                                                <option value="DIFICIL">DIFICIL</option>
                                                <option value="MUY DIFICIL">MUY DIFICIL</option>
                                                <option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>
                                                <option value="SOLICITO SU BROADCAST">SOLICITO SU BROADCAST</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-5">
                                            <input id="pregunta8_1_VEH_EQ" name="pregunta8_1_VEH_EQ" class="text-bold form-control" readonly value="8.1 ¿Por favor coméntenos el motivo de su calificación?" />
                                        </div>
                                        <div class="col-xs-7"><input id="respuesta8_1_VEH_EQ" name="respuesta8_1_VEH_EQ" type="text" class="form-control"></div>
                                        <div class="col-xs-12"><label class="text-right">ECONOMICS</label></div>
                                        <div class="col-xs-10"><textarea id="pregunta9_VEH_EQ" name="pregunta9_VEH_EQ" class="text-bold form-control" readonly>9. Si su experiencia con Seguros Equinoccial se mantiene igual a la que ha tenido hasta ahora, consideraría seguir con nosotros, por cuánto tiempo más:</textarea></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta9_VEH_EQ" name="respuesta9_VEH_EQ" class="form-control">
                                                <option value=""></option>
                                                <option value="5 años o más">5 años o más</option>
                                                <option value="De 3 a 4 años">De 3 a 4 años</option>
                                                <option value="De 2 a 3 años">De 2 a 3 años</option>
                                                <option value="De 1 a 2 años">De 1 a 2 años</option>
                                                <option value="De 6 meses a 1 año">De 6 meses a 1 año</option>
                                                <option value="Menos de 6 meses">Menos de 6 meses</option>
                                                <option value="NO QUIERO SEGUIR">NO QUIERO SEGUIR</option>
                                                <option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-12"><label class="text-right">VOC</label></div>
                                        <div class="col-xs-12"><input id="pregunta10_VEH_EQ" name="pregunta10_VEH_EQ" class="text-bold form-control" value="10. ¿Seguros Equinoccial como podría superar sus expectativas al momento de solicitar una asistencia vehicular?" readonly/></div>
                                        <div class="col-xs-12"><input id="respuesta10_VEH_EQ" name="respuesta10_VEH_EQ" class="text-bold form-control" /></div>
                                    </div>
                                </div>
                            </div>

                            <div class="box-body">
                                <div class="btn bg-gray-light">
                                    <div class="col-xs-3 hidden">
                                        <input type="text" class="form-control input-sm" id="code" name="code" readonly/>
                                        <input type="text" class="form-control input-sm" id="IDC" name="IDC" readonly/>
                                        <input type="text" class="form-control input-sm" id="CAMPANIA" name="CAMPANIA" readonly/>
                                    </div>
                                    <div class="col-xs-2"> <b>TIPO_CONTRATO </b>
                                        <input type="text" class="form-control input-sm" id="TIPO_CONTRATO" name="TIPO_CONTRATO" readonly/> </div>
                                    <div class="col-xs-6"> <b>CONTRATO </b>
                                        <input type="text" class="form-control input-sm" id="CONTRATO" name="CONTRATO" readonly/> </div>
                                    <div class="col-xs-2"> <b>ASISTENCIA </b>
                                        <input type="text" class="form-control input-sm" id="ASISTENCIA" name="ASISTENCIA" readonly/> </div>
                                    <div class="col-xs-2"> <b>FECHA_ALTA </b>
                                        <input type="text" class="form-control input-sm" id="FECHA_ALTA" name="FECHA_ALTA" readonly/> </div>
                                    <div class="col-xs-4"> <b>TITULAR </b>
                                        <input type="text" class="form-control input-sm" id="TITULAR" name="TITULAR" readonly/> </div>
                                    <div class="col-xs-4"> <b>BENEFICIARIO </b>
                                        <input type="text" class="form-control input-sm" id="BENEFICIARIO" name="BENEFICIARIO" readonly/> </div>
                                    <div class="col-xs-2"> <b>PROVINCIA </b>
                                        <input type="text" class="form-control input-sm" id="PROVINCIA" name="PROVINCIA" readonly/> </div>
                                    <div class="col-xs-2"> <b>LOCALIDAD </b>
                                        <input type="text" class="form-control input-sm" id="LOCALIDAD" name="LOCALIDAD" readonly/> </div>
                                    <div class="col-xs-10"> <b>LUGAR_DE_ASISTENCIA </b>
                                        <input type="text" class="form-control input-sm" id="LUGAR_DE_ASISTENCIA" name="LUGAR_DE_ASISTENCIA" readonly/> </div>
                                    <div class="col-xs-2"> <b>PLACA </b>
                                        <input type="text" class="form-control input-sm" id="PLACA" name="PLACA" readonly/> </div>
                                    <div class="col-xs-2"> <b>BASTIDOR</b>
                                        <input type="text" class="form-control input-sm" id="BASTIDOR" name="BASTIDOR" readonly/> </div>
                                    <div class="col-xs-3"> <b>MARCA </b>
                                        <input type="text" class="form-control input-sm" id="MARCA" name="MARCA" readonly/> </div>
                                    <div class="col-xs-2"> <b>COLOR </b>
                                        <input type="text" class="form-control input-sm" id="COLOR" name="COLOR" readonly/> </div>
                                    <div class="col-xs-1"> <b>MODELO </b>
                                        <input type="text" class="form-control input-sm" id="MODELO" name="MODELO" readonly/> </div>
                                    <div class="col-xs-2"> <b>SERVICIO </b>
                                        <input type="text" class="form-control input-sm" id="SERVICIO" name="SERVICIO" readonly/> </div>
                                    <div class="col-xs-2"> <b>CAUSA </b>
                                        <input type="text" class="form-control input-sm" id="CAUSA" name="CAUSA" readonly/> </div>
                                    <div class="row1 col-xs-2"> <b>AVERIA </b>
                                        <input type="text" class="form-control input-sm" id="AVERIA" name="AVERIA" readonly/> </div>
                                    <div class="row1 col-xs-1"> <b>EN_CARTERA </b>
                                        <input type="text" class="form-control input-sm" id="EN_CARTERA" name="EN_CARTERA" readonly/> </div>
                                    <div class="row1 col-xs-2"> <b>FECHA_COORDINACION </b>
                                        <input type="text" class="form-control input-sm" id="FECHA_COORDINACION" name="FECHA_COORDINACION" readonly/> </div>
                                    <div class="row1 col-xs-2"> <b>OPERADOR_COORD. </b>
                                        <input type="text" class="form-control input-sm" id="OPERADOR_COORDINACION" name="OPERADOR_COORDINACION" readonly/> </div>
                                    <div class="row1 col-xs-2"> <b>MOVIMIENTO_ECONOMICO </b>
                                        <input type="text" class="form-control input-sm" id="MOVIMIENTO_ECONOMICO" name="MOVIMIENTO_ECONOMICO" readonly/> </div>
                                    <div class="row1 col-xs-2"> <b>IMPORTE </b>
                                        <input type="text" class="form-control input-sm" id="IMPORTE" name="IMPORTE" readonly/> </div>
                                    <div class="row1 col-xs-1"> <b>TIPO_MOV </b>
                                        <input type="text" class="form-control input-sm" id="TIPO_MOV" name="TIPO_MOV" readonly/> </div>
                                    <div class="row1 col-xs-1"> <b>ESTADO_MOV </b>
                                        <input type="text" class="form-control input-sm" id="ESTADO_MOV" name="ESTADO_MOV" readonly/> </div>
                                    <div class="row1 col-xs-1"> <b>CANCELADO </b>
                                        <input type="text" class="form-control input-sm" id="CANCELADO" name="CANCELADO" readonly/> </div>
                                    <div class="row1 col-xs-1"> <b>TIPO </b>
                                        <input type="text" class="form-control input-sm" id="TIPO" name="TIPO" readonly/> </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php require 'footer.php'; ?>
<script src="scripts/ecuasistenciaEncuestaAgenda.js" type="text/javascript"></script>
<script src="scripts/funcions.js" type="text/javascript"></script>