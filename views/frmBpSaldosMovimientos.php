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
                                    <div class="col-xs-2"> <b>FECHA IVR </b>
                                        <input type="text" class="form-control input-sm" id="CAMPO1" name="CAMPO1" readonly/>
                                    </div>
                                    <div class="col-xs-2"> <b>CORREO 1 </b>
                                        <input type="text" class="form-control input-sm" id="CAMPO2" name="CAMPO2" readonly/>
                                    </div>
                                    <div class="col-xs-2"> <b>CORREO 2 </b>
                                        <input type="text" class="form-control input-sm" id="CAMPO3" name="CAMPO3" readonly/>
                                    </div>
                                    <div class="col-xs-2"> <b>CORREO 3 </b>
                                        <input type="text" class="form-control input-sm" id="CAMPO5" name="CAMPO5" readonly/>
                                    </div>
                                    <div class="col-xs-2"> <b>MOTIVO LLAMADA </b>
                                        <input type="text" class="form-control input-sm" id="CAMPO6" name="CAMPO6" readonly/>
                                    </div>
                                    <div class="col-xs-4"> <b>CAMPO7</b>
                                        <input type="text" class="form-control input-sm" id="CAMPO7" name="CAMPO7" readonly/>
                                    </div>
                                    <div class="col-xs-4"> <b>CAMPO8 </b>
                                        <input type="text" class="form-control input-sm" id="CAMPO8" name="CAMPO8" readonly/>
                                    </div>
                                    <div class="col-xs-2"> <b>CAMPO9 </b>
                                        <input type="text" class="form-control input-sm" id="CAMPO9" name="CAMPO9" readonly/>
                                    </div>
                                    <div class="col-xs-4"> <b>CAMPO10</b>
                                        <input type="text" class="form-control input-sm" id="CAMPO10" name="CAMPO10" readonly/>
                                    </div>
                                </div>
                            </div>
                            <div id="pnlEncuesta" class="col-xs-12 btn">
                                <div id="pnlSaldo" class="box box-widget bg-gray">
                                    <!---------------------------------------------------------PREGUNTA 1---------------------------------------------------->
                                    <div class="col-xs-9"><textarea rows="3" id="pregunta1" name="pregunta1" class="text-bold form-control" readonly>1. Basado en la experiencia de su llamada al call center, ¿Cuál es su nivel de satisfacción en la interacción que usted tuvo con el asesor que atendió su llamada?  Siendo 1 lo mas bajo y 10 lo mas alto</textarea></div>
                                    <div class="col-xs-3">  
                                        <select id="respuesta1" name="respuesta1" class="form-control">
                                            <option value=""></option>
                                            <option >1</option>
                                            <option >2</option>
                                            <option >3</option>
                                            <option >4</option>
                                            <option >5</option>
                                            <option >6</option>
                                            <option >7</option>
                                            <option >8</option>
                                            <option >9</option>
                                            <option >10</option>
                                        </select>
                                    </div>
                                    <!---------------------------------------------------------PREGUNTA 2---------------------------------------------------->
                                    <div class="col-xs-9"><input id="pregunta2" name="pregunta2" class="text-bold form-control" readonly/></div>
                                    <div class="col-xs-3">
                                        <select id="respuesta2" name="respuesta2" class="form-control">
                                            <option value=""></option>
                                            <option >Amabilidad y cordialidad del agente telefónico</option>
                                            <option >Claridad en el direccionamiento al sistema automático</option>
                                            <option >Asesoramiento adecuado por parte del agente telefónico</option>
                                        </select>
                                    </div>
                                    <!---------------------------------------------------------PREGUNTA 3---------------------------------------------------->
                                    <div class="col-xs-9"><textarea rows="2" id="pregunta3" name="pregunta3" class="text-bold form-control" readonly>2. ¿Cuál es su nivel de satisfacción cuando su llamada fue transferida a las opciones automáticas en el teléfono? Siendo 1 lo mas bajo y 10 lo mas alto</textarea></div>
                                    <div class="col-xs-3">
                                        <select id="respuesta3" name="respuesta3" class="form-control">
                                            <option value=""></option>
                                            <option >1</option>
                                            <option >2</option>
                                            <option >3</option>
                                            <option >4</option>
                                            <option >5</option>
                                            <option >6</option>
                                            <option >7</option>
                                            <option >8</option>
                                            <option >9</option>
                                            <option >10</option>
                                        </select>
                                    </div>
                                    <!---------------------------------------------------------PREGUNTA 4---------------------------------------------------->
                                    <div class="col-xs-9"><input id="pregunta4" name="pregunta4" class="text-bold form-control" readonly/></div>
                                    <div class="col-xs-3">
                                        <select id="respuesta4" name="respuesta4" class="form-control">
                                        </select>
                                    </div>
                                    <!---------------------------------------------------------PREGUNTA 5---------------------------------------------------->
                                    <div class="col-xs-9"><textarea rows="2" id="pregunta5" name="pregunta5" class="text-bold form-control" readonly>3.  ¿Cuál es su nivel de satisfacción con la información enviada a su correo electrónico? Siendo 1 lo mas bajo y 10 lo mas alto</textarea></div>
                                    <div class="col-xs-3">
                                        <select id="respuesta5" name="respuesta5" class="form-control">
                                            <option value=""></option>
                                            <option >1</option>
                                            <option >2</option>
                                            <option >3</option>
                                            <option >4</option>
                                            <option >5</option>
                                            <option >6</option>
                                            <option >7</option>
                                            <option >8</option>
                                            <option >9</option>
                                            <option >10</option>
                                        </select>
                                    </div>
                                    <!---------------------------------------------------------PREGUNTA 6---------------------------------------------------->
                                    <div class="col-xs-9"><input id="pregunta6" name="pregunta6" class="text-bold form-control" readonly/></div>
                                    <div class="col-xs-3">
                                        <select id="respuesta6" name="respuesta6" class="form-control">
                                        </select>
                                    </div>
                                    <!---------------------------------------------------------PREGUNTA 7---------------------------------------------------->
                                    <div class="col-xs-9"><textarea id="pregunta7" name="pregunta7" class="text-bold form-control" readonly>4. ¿Qué tan dispuesto esta a recomendar este servicio de respuestas automaticas a un amigo o familiar ?  Siendo 0 para nada dispuesto a recomendar y 10 muy dispuesto a recomendar</textarea></div>
                                    <div class="col-xs-3">
                                        <select id="respuesta7" name="respuesta7" class="form-control">
                                            <option value=""></option>
                                            <option >0</option>
                                            <option >1</option>
                                            <option >2</option>
                                            <option >3</option>
                                            <option >4</option>
                                            <option >5</option>
                                            <option >6</option>
                                            <option >7</option>
                                            <option >8</option>
                                            <option >9</option>
                                            <option >10</option>
                                        </select>
                                    </div>
                                    <!---------------------------------------------------------PREGUNTA 8---------------------------------------------------->
                                    <div class="col-xs-6"><input id="pregunta8" name="pregunta8" class="text-bold form-control" value="5.  ¿Tiene alguna sugerencia o recomendación adicional?" readonly/></div>
                                    <div class="col-xs-6">
                                        <input id="respuesta8" name="respuesta8" type="text" class="form-control">
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
<script src="scripts/bpSaldosMovimientos.js" type="text/javascript"></script>
<script src="scripts/funcions.js" type="text/javascript"></script>