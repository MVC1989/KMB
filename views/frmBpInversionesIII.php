<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<style></style>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h4 class="text-bold">Campaña BP Encuestas</h4> </div>
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
                            <div class="col-xs-12 btn bg-gray-light">
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
                            </div>

                            <div id="pnlEncuesta" class="col-xs-12 btn">
                                <div class="box box-widget bg-gray">
                                    <div class="box-body col-xs-12 btn">
                                        <!---------------------------------------------------------PREGUNTA 1---------------------------------------------------->
                                        <div class="col-xs-6"><textarea id="pregunta1" name="pregunta1" class="text-bold form-control" readonly>1. Si usted contrataría este producto de inversión cuál de estos beneficios adicionales le gustaría que el Banco ofreciera </textarea></div>
                                        <div class="col-xs-6">
                                            <select id="respuesta1" name="respuesta1" class="form-control">
                                                <option value=""></option>
                                                <option >Seguro de muerte accidental cubierto 100% por el Banco</option>
                                                <option >Seguro de muerte accidental más gastos médicos por accidente cubierto por el Banco el 80% y el cliente el 20%</option>
                                                <option >Seguro de muerte por cualquier causa más servicio exequial cubierto por el Banco el 15% y el cliente el 85%</option>
                                                <option >Ninguna de las anteriores</option>
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 2---------------------------------------------------->
                                        <div class="col-xs-9"><textarea id="pregunta2" name="pregunta2" class="text-bold form-control" readonly>2. El Banco está ofertando un producto de ahorro a largo plazo para viajes, estudios, jubilación, etc. Nos gustaría que nos comente si estaría interesado en este producto" </textarea></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta2" name="respuesta2" class="form-control">
                                                <option value=""></option>
                                                <option >Si</option>
                                                <option >No</option>
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 3---------------------------------------------------->
                                        <div class="col-xs-9"><input id="pregunta3" name="pregunta3" class="text-bold form-control" value="3. Para que les gustaría realizar un ahorro a largo plazo?" readonly/></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta3" name="respuesta3" class="form-control">
                                                <option value=""></option>
                                                <option>Viaje</option >
                                                <option>Estudios</option >
                                                <option>Casa</option >
                                                <option>Auto</option >
                                                <option>Jubilación</option >
                                                <option>Negocio</option >
                                                <option>Estudio para familiares</option >
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 4---------------------------------------------------->
                                        <div class="col-xs-9"><input id="pregunta4" name="pregunta4" class="text-bold form-control" readonly value="4.	¿Cuál sería el monto mensual que le gustaría aportar a este ahorro?"/></div>                                        
                                        <div class="col-xs-3">
                                            <select id="respuesta4" name="respuesta4" class="form-control">
                                                <option value=""></option>
                                                <option >De $150 a $250</option>
                                                <option >De $251 a $500</option>
                                                <option >De $501 en adelante</option>
                                            </select> 
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 5---------------------------------------------------->
                                        <div class="col-xs-9"><input id="pregunta5" name="pregunta5" class="text-bold form-control" readonly value="5. Le interesaría colocar un monto inicial en su ahorro"/></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta5" name="respuesta5" class="form-control">
                                                <option value=""></option>
                                                <option >Si</option>
                                                <option >No</option>
                                            </select> 
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 6---------------------------------------------------->
                                        <div class="col-xs-9"><input id="pregunta6" name="pregunta6" class="text-bold form-control" readonly value="5.5. ¿Cuál sería en monto?"/></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta6" name="respuesta6" class="form-control">
                                                <option value=""></option>
                                                <option >Monto inicial menor a $1000</option>
                                                <option >Monto inicial mayor a $1000</option>
                                            </select> 
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 8---------------------------------------------------->
                                        <div class="col-xs-9"><input id="pregunta7" name="pregunta7" class="text-bold form-control" readonly value="6.	¿Le gustaría que la cuota mensual de ahorro sea carga a su tarjeta de crédito?"/></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta7" name="respuesta7" class="form-control">
                                                <option value=""></option>
                                                <option >Si</option>
                                                <option >No</option>
                                            </select> 
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 9---------------------------------------------------->
<!--                                        <div class="col-xs-9"><input id="pregunta9" name="pregunta9" class="text-bold form-control" readonly value="8.	Que le parece 2 años de tasa fija"/></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta9" name="respuesta9" class="form-control">
                                                <option value=""></option>
                                                <option >Excelente</option>
                                                <option >Bueno</option>
                                                <option >No le interesa</option>
                                            </select> 
                                        </div>-->
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
<script src="scripts/bpInversionesIII.js" type="text/javascript"></script>
<script src="scripts/funcions.js" type="text/javascript"></script>