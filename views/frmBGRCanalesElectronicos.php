<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<style></style>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h4 class="text-bold">Campaña BGR Encuestas</h4> </div>
                    <div class="panel-body table-responsive" id="listadoRegistros">
                        <table id="tblListado" class="table table-condensed table-hover table-responsive">
                            <thead>
                            <th>Num</th>
                            <th>Campaña</th>
                            <th>ImportId</th>
                            <th>Asesor</th>
                            <th>Identificación</th>
                            <th>Nombres cliente</th>
                            <th>Agencia</th>
                            <th>Sección</th>
                            <th>Fecha atención</th>
                            <th>Resultado de gestión</th>
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
                                                    <input type="checkbox" class="" id="cbox2"  />
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

                            <div class="box-body">
                                <div class="btn bg-gray-light">
                                    <div class="col-xs-3 hidden">
                                        <input type="text" class="form-control input-sm" id="code" name="code" readonly/>
                                        <input type="text" class="form-control input-sm" id="IDC" name="IDC" readonly/>
                                        <input type="text" class="form-control input-sm" id="CAMPANIA" name="CAMPANIA" readonly/>
                                    </div>
                                    <div class="col-xs-2"> <b>IDENTIFICACION </b>
                                        <input type="text" class="form-control input-sm" id="IDENTIFICACION" name="IDENTIFICACION" readonly/>
                                    </div>
                                    <div class="col-xs-4"> <b>NOMBRE CLIENTE </b>
                                        <input type="text" class="form-control input-sm" id="NOMBRE_CLIENTE" name="NOMBRE_CLIENTE" readonly/>
                                    </div>
                                    <div class="col-xs-2"> <b>TIPO CLIENTE </b>
                                        <input type="text" class="form-control input-sm" id="TIPO_CLIENTE" name="TIPO_CLIENTE" readonly/>
                                    </div>
                                    <div class="col-xs-2"> <b>SEGMENTO </b>
                                        <input type="text" class="form-control input-sm" id="SEGMENTO" name="SEGMENTO" readonly/>
                                    </div>
                                    <div class="col-xs-2 hidden"> <b>CODIGO_AGENCIA </b>
                                        <input type="text" class="form-control input-sm" id="CODIGO_AGENCIA" name="CODIGO_AGENCIA" readonly/>
                                    </div>
                                    <div class="col-xs-2"> <b>AGENCIA </b>
                                        <input type="text" class="form-control input-sm" id="AGENCIA" name="AGENCIA" readonly/>
                                    </div>
                                    <div class="col-xs-2"> <b>SECCION </b>
                                        <input type="text" class="form-control input-sm" id="SECCION" name="SECCION" readonly/>
                                    </div>
                                    <div class="col-xs-2"> <b>AREA </b>
                                        <input type="text" class="form-control input-sm" id="AREA" name="AREA" readonly/>
                                    </div>
                                    <div class="col-xs-2"> <b>USUARIO </b>
                                        <input type="text" class="form-control input-sm" id="USUARIO" name="USUARIO" readonly/>
                                    </div>
                                    <div class="col-xs-2"> <b>CAJERO </b>
                                        <input type="text" class="form-control input-sm" id="CAJERO" name="CAJERO" readonly/>
                                    </div>
                                    <div class="col-xs-4"> <b>TRAMITES</b>
                                        <input type="text" class="form-control input-sm" id="TRAMITES" name="TRAMITES" readonly/>
                                    </div>
                                    <div class="col-xs-4"> <b>TIPO TRANSACCION </b>
                                        <input type="text" class="form-control input-sm" id="TIPO_TRANSACCION" name="TIPO_TRANSACCION" readonly/>
                                    </div>
                                    <div class="col-xs-2"> <b>TITULAR/TERCERO </b>
                                        <input type="text" class="form-control input-sm" id="TITULAR_TERCERO" name="TITULAR_TERCERO" readonly/>
                                    </div>
                                    <div class="col-xs-2"> <b>CUENTA </b>
                                        <input type="text" class="form-control input-sm" id="CUENTA" name="CUENTA" readonly/>
                                    </div>
                                    <div class="col-xs-2"> <b>FECHA ATENCION </b>
                                        <input type="text" class="form-control input-sm" id="FECHA_ATENCION" name="FECHA_ATENCION" readonly/>
                                    </div>
                                    <div class="col-xs-2"> <b>HORA ATENCION </b>
                                        <input type="text" class="form-control input-sm" id="HORA_ATENCION" name="HORA_ATENCION" readonly/>
                                    </div>
                                </div>
                            </div>
                            <div id="pnlEncuesta" class="col-xs-12 btn">
                                <div class="box box-widget bg-gray">
                                    <div class="box-body">
                                        <!---------------------------------------------------------PREGUNTA 1---------------------------------------------------->
                                        <div class="col-xs-12"><label id="pilar1">PILAR - COMUNICACIÓN / ATRIBUTO - Asesoría</label></div>
                                        <div class="col-xs-10"><input id="pregunta1" name="pregunta1" class="text-bold form-control" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta1" name="respuesta1" class="form-control">
                                                <option ></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-4">
                                            <input id="pregunta1_1" name="pregunta1_1" class="text-bold form-control" readonly value="¿Cuál es el motivo de su calificación?" />
                                        </div>
                                        <div class="col-xs-8">
                                            <input id="respuesta1_1" name="respuesta1_1" type="text" class="form-control" maxlength="500">
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 2---------------------------------------------------->
                                        <div class="col-xs-12"><label id="pilar2">PILAR - COMUNICACIÓN / ATRIBUTO - Claridad de la Información</label></div>
                                        <div class="col-xs-10"><input id="pregunta2" name="pregunta2" class="text-bold form-control" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta2" name="respuesta2" class="form-control">
                                                <option ></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-4">
                                            <input id="pregunta2_1" name="pregunta2_1" class="text-bold form-control" readonly value="¿Cuál es el motivo de su calificación?" />
                                        </div>
                                        <div class="col-xs-8">
                                            <input id="respuesta2_1" name="respuesta2_1" type="text" class="form-control" maxlength="500">
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 3---------------------------------------------------->
                                        <div class="col-xs-12"><label id="pilar3">PILAR - COMUNICACIÓN / ATRIBUTO - Oportunidad en la Información</label></div>
                                        <div class="col-xs-10"><input id="pregunta3" name="pregunta3" class="text-bold form-control" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta3" name="respuesta3" class="form-control">
                                                <option ></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-4">
                                            <input id="pregunta3_1" name="pregunta3_1" class="text-bold form-control" readonly value="¿Cuál es el motivo de su calificación?" />
                                        </div>
                                        <div class="col-xs-8">
                                            <input id="respuesta3_1" name="respuesta3_1" type="text" class="form-control" maxlength="500">
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 4---------------------------------------------------->
                                        <div class="col-xs-12"><label id="pilar4">PILAR - SERVICIO / ATRIBUTO - Actitud</label></div>
                                        <div class="col-xs-10"><input id="pregunta4" name="pregunta4" class="text-bold form-control" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta4" name="respuesta4" class="form-control">
                                                <option ></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-4">
                                            <input id="pregunta4_1" name="pregunta4_1" class="text-bold form-control" readonly value="¿Cuál es el motivo de su calificación?" />
                                        </div>
                                        <div class="col-xs-8">
                                            <input id="respuesta4_1" name="respuesta4_1" type="text" class="form-control" maxlength="500">
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 5---------------------------------------------------->
                                        <div class="col-xs-12"><label id="pilar5">PILAR - SERVICIO / ATRIBUTO - Empatía</label></div>
                                        <div class="col-xs-10"><input id="pregunta5" name="pregunta5" class="text-bold form-control" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta5" name="respuesta5" class="form-control">
                                                <option ></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-4">
                                            <input id="pregunta5_1" name="pregunta5_1" class="text-bold form-control" readonly value="¿Cuál es el motivo de su calificación?" />
                                        </div>
                                        <div class="col-xs-8">
                                            <input id="respuesta5_1" name="respuesta5_1" type="text" class="form-control" maxlength="500">
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 6---------------------------------------------------->
                                        <div class="col-xs-12"><label id="pilar6">PILAR - SERVICIO / ATRIBUTO - Efectividad </label></div>
                                        <div class="col-xs-10"><input id="pregunta6" name="pregunta6" class="text-bold form-control" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta6" name="respuesta6" class="form-control">
                                                <option ></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-4">
                                            <input id="pregunta6_1" name="pregunta6_1" class="text-bold form-control" readonly value="¿Cuál es el motivo de su calificación?" />
                                        </div>
                                        <div class="col-xs-8">
                                            <input id="respuesta6_1" name="respuesta6_1" type="text" class="form-control" maxlength="500">
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 7---------------------------------------------------->
                                        <div class="col-xs-12"><label id="pilar7">PILAR - PERSONALIZACIÓN / ATRIBUTO - Solución</label></div>
                                        <div class="col-xs-10"><input id="pregunta7" name="pregunta7" class="text-bold form-control" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta7" name="respuesta7" class="form-control">
                                                <option ></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-4">
                                            <input id="pregunta7_1" name="pregunta7_1" class="text-bold form-control" readonly value="¿Cuál es el motivo de su calificación?" />
                                        </div>
                                        <div class="col-xs-8">
                                            <input id="respuesta7_1" name="respuesta7_1" type="text" class="form-control" maxlength="500">
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 8---------------------------------------------------->
                                        <div class="col-xs-12"><label id="pilar8">PILAR - PERSONALIZACIÓN / ATRIBUTO - Proactividad</label></div>
                                        <div class="col-xs-10"><input id="pregunta8" name="pregunta8" class="text-bold form-control" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta8" name="respuesta8" class="form-control">
                                                <option ></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-4">
                                            <input id="pregunta8_1" name="pregunta8_1" class="text-bold form-control" readonly value="¿Cuál es el motivo de su calificación?" />
                                        </div>
                                        <div class="col-xs-8">
                                            <input id="respuesta8_1" name="respuesta8_1" type="text" class="form-control" maxlength="500">
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 9---------------------------------------------------->
                                        <div class="col-xs-12"><label id="pilar9">PILAR - PROCESOS / ATRIBUTO - Agilidad</label></div>
                                        <div class="col-xs-10"><input id="pregunta9" name="pregunta9" class="text-bold form-control" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta9" name="respuesta9" class="form-control">
                                                <option ></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-4">
                                            <input id="pregunta9_1" name="pregunta9_1" class="text-bold form-control" readonly value="¿Cuál es el motivo de su calificación?" />
                                        </div>
                                        <div class="col-xs-8">
                                            <input id="respuesta9_1" name="respuesta9_1" type="text" class="form-control" maxlength="500">
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 10---------------------------------------------------->
                                        <div class="col-xs-12"><label id="pilar10">PILAR - PROCESOS / ATRIBUTO - Flexibilidad</label></div>
                                        <div class="col-xs-10"><input id="pregunta10" name="pregunta10" class="text-bold form-control" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta10" name="respuesta10" class="form-control">
                                                <option ></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-4">
                                            <input id="pregunta10_1" name="pregunta10_1" class="text-bold form-control" readonly value="¿Cuál es el motivo de su calificación?" />
                                        </div>
                                        <div class="col-xs-8">
                                            <input id="respuesta10_1" name="respuesta10_1" type="text" class="form-control" maxlength="500">
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 11---------------------------------------------------->
                                        <div class="col-xs-12"><label id="pilar11">PILAR - DIGITAL / ATRIBUTO - Accesibilidad (Empoderamiento al cliente)</label></div>
                                        <div class="col-xs-10"><input id="pregunta11" name="pregunta11" class="text-bold form-control" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta11" name="respuesta11" class="form-control">
                                                <option ></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-4">
                                            <input id="pregunta11_1" name="pregunta11_1" class="text-bold form-control" readonly value="¿Cuál es el motivo de su calificación?" />
                                        </div>
                                        <div class="col-xs-8">
                                            <input id="respuesta11_1" name="respuesta11_1" type="text" class="form-control" maxlength="500">
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 12---------------------------------------------------->
                                        <div class="col-xs-12"><label id="pilar12">PILAR - DIGITAL / ATRIBUTO - Innovación</label></div>
                                        <div class="col-xs-10"><input id="pregunta12" name="pregunta12" class="text-bold form-control" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta12" name="respuesta12" class="form-control">
                                                <option ></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-4">
                                            <input id="pregunta12_1" name="pregunta12_1" class="text-bold form-control" readonly value="¿Cuál es el motivo de su calificación?" />
                                        </div>
                                        <div class="col-xs-8">
                                            <input id="respuesta12_1" name="respuesta12_1" type="text" class="form-control" maxlength="500">
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 13---------------------------------------------------->
                                        <div class="col-xs-12"><label>PILAR - LEALTAD / ATRIBUTO - SATISFACCIÓN</label></div>
                                        <div class="col-xs-10"><input id="pregunta13" name="pregunta13" class="text-bold form-control" value="Califique del 1 al 10 siendo 1 poco satisfecho y 10 muy satisfecho: Su grado de satisfacción con el servicio recibido en BGR" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta13" name="respuesta13" class="form-control">
                                                <option ></option>
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
                                            </select>
                                        </div>
                                        <div class="col-xs-4">
                                            <input id="pregunta13_1" name="pregunta13_1" class="text-bold form-control" readonly />
                                        </div>
                                        <div class="col-xs-8">
                                            <input id="respuesta13_1" name="respuesta13_1" type="text" class="form-control" maxlength="500">
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 14---------------------------------------------------->
                                        <div class="col-xs-12"><label>PILAR - LEALTAD / ATRIBUTO - ESFUERZO</label></div>
                                        <div class="col-xs-10"><input id="pregunta14" name="pregunta14" class="text-bold form-control" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta14" name="respuesta14" class="form-control">
                                                <option ></option>
                                                <option value="MUY FACIL">MUY FACIL</option>
                                                <option value="FACIL">FACIL</option>
                                                <option value="POCO FACIL">POCO FACIL</option>
                                                <option value="DIFICIL">DIFICIL</option>
                                                <option value="MUY DIFICIL">MUY DIFICIL</option>
                                                <!--<option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>-->
                                            </select>
                                        </div>
                                        <div class="col-xs-4">
                                            <input id="pregunta14_1" name="pregunta14_1" class="text-bold form-control" readonly />
                                        </div>
                                        <div class="col-xs-8">
                                            <input id="respuesta14_1" name="respuesta14_1" type="text" class="form-control" maxlength="500">
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 15---------------------------------------------------->
                                        <div class="col-xs-12"><label>PILAR - LEALTAD / ATRIBUTO - RECOMENDACIÓN</label></div>
                                        <div class="col-xs-10"><textarea id="pregunta15" name="pregunta15" class="text-bold form-control" readonly>En escala de 0 a 10 siendo 0 no lo recomendaría y 10 si lo recomendaría ¿en qué grado recomendaría BGR a un familiar, amigo o colega de trabajo?, siendo 0 definitivamente no recomendaría y 10 definitivamente sí lo recomendaría</textarea></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta15" name="respuesta15" class="form-control">
                                                <option ></option>
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
                                            </select>
                                        </div>
                                        <div class="col-xs-4">
                                            <input id="pregunta15_1" name="pregunta15_1" class="text-bold form-control" readonly value="¿Cuál es el motivo de su calificación?" />
                                        </div>
                                        <div class="col-xs-8">
                                            <input id="respuesta15_1" name="respuesta15_1" type="text" class="form-control" maxlength="500">
                                        </div>
                                    </div>
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
<script src="scripts/bancoBGRCanalesElectronicos.js" type="text/javascript"></script>
<script src="scripts/funcions.js" type="text/javascript"></script>