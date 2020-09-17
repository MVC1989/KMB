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
                                <div class="col-xs-1"> <b>EDAD </b>
                                    <input type="text" class="form-control input-sm" id="EDAD" name="EDAD" readonly/>
                                </div>
                                <div class="col-xs-3"> <b>REGION </b>
                                    <input type="text" class="form-control input-sm" id="REGION" name="REGION" readonly/>
                                </div>
                                <div class="col-xs-2"> <b>LOCALIDAD </b>
                                    <input type="text" class="form-control input-sm" id="LOCALIDAD" name="LOCALIDAD" readonly/>
                                </div>
                            </div>

                            <div id="pnlEncuesta2" class="col-xs-12 btn">
                                <div class="box box-widget bg-gray">
                                    <div class="box-body col-xs-12 btn">
                                        <!---------------------------------------------------------PREGUNTA 1---------------------------------------------------->
                                        <div class="col-xs-12"><textarea id="pregunta1" name="pregunta1" class="text-bold form-control" readonly>1. De los siguientes productos financieros de ahorro o inversión, ¿cuáles conoce Ud. que ofrece Banco Pichincha a sus clientes? </textarea></div>
                                        <div class="col-xs-3">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input id="chk_ENC1" name="chk_ENC1" value="chk_ENC1" type="checkbox">
                                                </span>
                                                <input id="respuesta1" name="respuesta1" type="text" value="Cuenta de ahorros" class="form-control" readonly>
                                            </div>
                                            <!-- /input-group -->
                                        </div>
                                        <div class="col-xs-2">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input id="chk_ENC2" name="chk_ENC2" value="chk_ENC2" type="checkbox">
                                                </span>
                                                <input id="respuesta2" name="respuesta2" type="text" value="Cuenta corriente" class="form-control" readonly>
                                            </div>
                                            <!-- /input-group -->
                                        </div>
                                        <div class="col-xs-3">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input id="chk_ENC3" name="chk_ENC3" value="chk_ENC3" type="checkbox">
                                                </span>
                                                <input id="respuesta3" name="respuesta3" type="text" value="Inversiones / Pólizas / Plazo fijo" class="form-control" readonly>
                                            </div>
                                            <!-- /input-group -->
                                        </div>
                                        <div class="col-xs-4">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input id="chk_ENC4" name="chk_ENC4" value="chk_ENC4" type="checkbox">
                                                </span>
                                                <input id="respuesta4" name="respuesta4" type="text" value="Cuenta Ahorro Programado- Ahorro Futuro" class="form-control" readonly>
                                            </div>
                                            <!-- /input-group -->
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 2---------------------------------------------------->
                                        <div class="col-xs-10"><textarea id="pregunta5" name="pregunta5" class="text-bold form-control" readonly>2. Conociendo ahora de que se trata, ¿Qué tan atractivo le resulta la propuesta del producto Cuenta de Ahorro Programado de Banco Pichincha? Utilice una escala de 1 a 5 donde 1 significa Nada Atractivo y 5 significa Muy Atractivo. Recuerde que Ud. puede utilizar valores intermedios.</textarea></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta5" name="respuesta5" class="form-control">
                                                <option value=""></option>
                                                <option >1</option>
                                                <option >2</option>
                                                <option >3</option>
                                                <option >4</option>
                                                <option >5</option>
                                            </select> 
                                        </div>

                                        <!---------------------------------------------------------PREGUNTA 3---------------------------------------------------->
                                        <div class="col-xs-6"><input id="pregunta6" name="pregunta6" class="text-bold form-control" value="2.1. ¿Por qué motivo no le resulta atractiva la propuesta de producto de Cuenta de Ahorro de Banco Pichincha?" readonly/></div>
                                        <div class="col-xs-6">
                                            <input id="respuesta6" name="respuesta6" type="text" class="form-control">
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 4---------------------------------------------------->
                                        <div class="col-xs-10"><input id="pregunta7" name="pregunta7" class="text-bold form-control" value="3. ¿Qué tiempo considera usted sea el ideal para aperturar una cuenta de ahorros?" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta7" name="respuesta7" class="form-control">
                                                <option value=""></option>
                                                <option >10 minutos</option>
                                                <option >30 minutos</option>
                                                <option >1 hora</option>
                                                <option >2 horas</option>
                                                <option >3 horas</option>
                                                <option >24 horas</option>
                                                <option >48 horas</option>
                                                <option >7 días</option>
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 5---------------------------------------------------->
                                        <div class="col-xs-12"><input id="pregunta8" name="pregunta8" class="text-bold form-control" readonly value="4. Por cuál medio quisiera obtener información sobre este producto: "/></div>
                                        <div class="col-xs-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input id="chk_ENC6" name="chk_ENC6" value="chk_ENC6" type="checkbox">
                                                </span>
                                                <input id="respuesta8" name="respuesta8" type="text" value="Ejecutivo en agencia" class="form-control" readonly>
                                            </div>
                                            <!-- /input-group -->
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input id="chk_ENC7" name="chk_ENC7" value="chk_ENC7" type="checkbox">
                                                </span>
                                                <input id="respuesta9" name="respuesta9" type="text" value="Radio, televisión y prensa" class="form-control" readonly>
                                            </div>
                                            <!-- /input-group -->
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input id="chk_ENC8" name="chk_ENC8" value="chk_ENC8" type="checkbox">
                                                </span>
                                                <input id="respuesta10" name="respuesta10" type="text" value="Redes Sociales" class="form-control" readonly>
                                            </div>
                                            <!-- /input-group -->
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input id="chk_ENC9" name="chk_ENC9" value="chk_ENC9" type="checkbox">
                                                </span>
                                                <input id="respuesta11" name="respuesta11" type="text" value="Correo Electrónico" class="form-control" readonly>
                                            </div>
                                            <!-- /input-group -->
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input id="chk_ENC10" name="chk_ENC10" value="chk_ENC10" type="checkbox">
                                                </span>
                                                <input id="respuesta12" name="respuesta12" type="text" value="Call Center" class="form-control" readonly>
                                            </div>
                                            <!-- /input-group -->
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input id="chk_ENC11" name="chk_ENC11" value="chk_ENC11" type="checkbox">
                                                </span>
                                                <input id="respuesta13" name="respuesta13" type="text" value="App" class="form-control" readonly>
                                            </div>
                                            <!-- /input-group -->
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input id="chk_ENC12" name="chk_ENC12" value="chk_ENC12" type="checkbox">
                                                </span>
                                                <input id="respuesta14" name="respuesta14" type="text" value="Ninguna" class="form-control" readonly>
                                            </div>
                                            <!-- /input-group -->
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 6---------------------------------------------------->
                                        <div class="col-xs-12"><textarea id="pregunta15" name="pregunta15" class="text-bold form-control" readonly>5. ¿Por qué canal revisa su cuenta de ahorros?</textarea></div>
                                        <div class="col-xs-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input id="chk_ENC13" name="chk_ENC13" value="chk_ENC13" type="checkbox">
                                                </span>
                                                <input id="respuesta15" name="respuesta15" type="text" value="Banca web" class="form-control" readonly>
                                            </div>
                                            <!-- /input-group -->
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input id="chk_ENC14" name="chk_ENC14" value="chk_ENC14" type="checkbox">
                                                </span>
                                                <input id="respuesta16" name="respuesta16" type="text" value="Banca móvil" class="form-control" readonly>
                                            </div>
                                            <!-- /input-group -->
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input id="chk_ENC15" name="chk_ENC15" value="chk_ENC15" type="checkbox">
                                                </span>
                                                <input id="respuesta17" name="respuesta17" type="text" value="Agencia" class="form-control" readonly>
                                            </div>
                                            <!-- /input-group -->
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input id="chk_ENC16" name="chk_ENC16" value="chk_ENC16" type="checkbox">
                                                </span>
                                                <input id="respuesta18" name="respuesta18" type="text" value="Call Center" class="form-control" readonly>
                                            </div>
                                            <!-- /input-group -->
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input id="chk_ENC17" name="chk_ENC17" value="chk_ENC17" type="checkbox">
                                                </span>
                                                <input id="respuesta19" name="respuesta19" type="text" value="ATM" class="form-control" readonly>
                                            </div>
                                            <!-- /input-group -->
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input id="chk_ENC18" name="chk_ENC18" value="chk_ENC18" type="checkbox">
                                                </span>
                                                <input id="respuesta20" name="respuesta20" type="text" value="Mi vecino" class="form-control" readonly>
                                            </div>
                                            <!-- /input-group -->
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 16---------------------------------------------------->
                                        <div class="col-xs-12"><input id="pregunta21" name="pregunta21" class="text-bold form-control" readonly value="6. ¿Con qué frecuencia revisa su cuenta de ahorros? Y ¿Por qué motivo lo hace?"/></div>
                                        <div class="col-xs-12">
                                            <input id="respuesta21" name="respuesta21" type="text" class="form-control">
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 17---------------------------------------------------->
                                        <div class="col-xs-9"><input id="pregunta22" name="pregunta22" class="text-bold form-control" readonly value="7. ¿Con que institución financiera o bancaria posee alguna Cuenta de Ahorro?"/></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta22" name="respuesta22" class="form-control">
                                                <option value=""></option>
                                                <option >Banco Guayaquil</option>
                                                <option >Banco Promérica / Produbanco</option>
                                                <option >Banco Internacional</option>
                                                <option >Banco Bolivariano</option>
                                                <option >Banco Pacífico</option>
                                                <option >Banco del Austro</option>
                                                <option >Banco Machala</option>
                                                <option >Banco General Rumiñahui</option>
                                                <option >Banco Procredit</option>
                                                <option >Banco Solidario</option>
                                                <option >Banco Cooperativa Nacional</option>
                                                <option >Banco General Rumiñahui</option>
                                                <option >Banco Pacifico</option>
                                                <option >Banco del Fomento</option>
                                                <option >Banco BanEcuador</option>
                                                <option >Banco Finca</option>
                                                <option >Banco de Loja</option>
                                                <option >Banco Diners</option>
                                                <option >Banco Cofiec</option>
                                                <option >COOPERATIVA 29 DE OCTUBRE</option>
                                                <option >COOPERATIVA ALIANZA DEL VALLE</option>
                                                <option >COOPERATIVA ANDALUCIA</option>
                                                <option >COOPERATIVA CACPECO</option>
                                                <option >COOPERATIVA CHIBULEO</option>
                                                <option >COOPERATIVA DAQUILEMA</option>
                                                <option >COOPERATIVA JEP</option>
                                                <option >COOPERATIVA MUSHUC RUNA</option>
                                                <option >COOPERATIVA OSCUS</option>
                                                <option >MUTUALISTA IMBABURA</option>
                                                <option >MUTUALISTA PICHINCHA</option>
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 16---------------------------------------------------->
                                        <div class="col-xs-12"><input id="pregunta23" name="pregunta23" class="text-bold form-control" readonly value="8. ¿Cuáles son los beneficios que le ofrecen esta u otras Cuentas de Ahorro para que Ud. haya decidido contratarlas con otra institución y no con Banco Pichincha?"/></div>
                                        <div class="col-xs-12">
                                            <input id="respuesta23" name="respuesta23" type="text" class="form-control">
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 16---------------------------------------------------->
                                        <div class="col-xs-12"><input id="pregunta24" name="pregunta24" class="text-bold form-control" readonly value="9. Para finalizar, ¿cuáles serían sus sugerencias para abrir una Cuenta de Ahorro de Banco Pichincha y se adapte a sus necesidades?"/></div>
                                        <div class="col-xs-12">
                                            <input id="respuesta24" name="respuesta24" type="text" class="form-control">
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
<script src="scripts/bpEncuestaAhorroProgramado4.js" type="text/javascript"></script>
<script src="scripts/funcions.js" type="text/javascript"></script>