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
                            <div id="pnlEncuesta1" class="col-xs-12 btn">
                                <div class="box box-widget bg-gray">
                                    <div class="box-body col-xs-12 btn">
                                        <!---------------------------------------------------------PREGUNTA 1---------------------------------------------------->
                                        <div class="col-xs-10"><textarea id="pregunta1" name="pregunta1" class="text-bold form-control" readonly>¿Usted es cliente de Banco Pichincha, es decir tiene contratado algún producto o servicio con el banco, por ejemplo: cta. de ahorros, corriente, tarjeta de crédito, etc.? </textarea></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta1" name="respuesta1" class="form-control">
                                                <option value=""></option>
                                                <option >SI</option>
                                                <option >NO</option>
                                                <!--<option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>-->
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 2---------------------------------------------------->
                                        <div class="col-xs-10"><textarea id="pregunta2" name="pregunta2" class="text-bold form-control" readonly>¿Usted es cliente de algún otro banco o cooperativa, es decir tiene contratado algún producto o servicio; por ejemplo: cta. de ahorros, corriente, tarjeta de crédito, etc.?</textarea></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta2" name="respuesta2" class="form-control">
                                                <option value=""></option>
                                                <option >SI</option>
                                                <option >NO</option>
                                                <!--<option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>-->
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 3---------------------------------------------------->
                                        <div class="col-xs-12"><input id="pregunta3" name="pregunta3" class="text-bold form-control" value="Cuál?" readonly/></div>
                                        <div class="col-xs-12">
                                            <input id="respuesta3" name="respuesta3" type="text" class="form-control">
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 4---------------------------------------------------->
                                        <div class="col-xs-12"><input id="pregunta4" name="pregunta4" class="text-bold form-control" value="¿Cuál es la institución financiera de su preferencia en la cual realiza todas sus transacciones?" readonly/></div>
                                        <div class="col-xs-12">
                                            <input id="respuesta4" name="respuesta4" type="text" class="form-control">
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 5---------------------------------------------------->
                                        <div class="col-xs-12"><input id="pregunta5" name="pregunta5" class="text-bold form-control" readonly value="¿Cuáles son las razones para preferir…MENCIONE RESPUESTA ANTERIOR?"/></div>
                                        <div class="col-xs-12">
                                            <input id="respuesta5" name="respuesta5" type="text" class="form-control">
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 6---------------------------------------------------->
                                        <div class="col-xs-5"><input id="pregunta6" name="pregunta6" class="text-bold form-control" value="¿Qué actividad/es realiza normalmente en agencias de Banco Pichincha?" readonly/></div>
                                        <div class="col-xs-7">
                                            <input id="respuesta6" name="respuesta6" type="text" class="form-control">
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 7---------------------------------------------------->
                                        <div class="col-xs-10"><input id="pregunta7" name="pregunta7" class="text-bold form-control" value="Aparte de las agencias, ¿qué otros lugares/canales del banco usted utiliza…INSERTE RESPUESTA ANTERIOR" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta7" name="respuesta7" class="form-control">
                                                <option value=""></option>
                                                <option>Cajeros automáticos</option>
                                                <option>Mi Vecino</option>
                                                <option>A través de mi computador</option>
                                                <option>A través de mi celular</option>
                                                <option>Ninguna</option>
                                                <option>Todas</option>
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 8---------------------------------------------------->
                                        <div class="col-xs-10"><input id="pregunta8" name="pregunta8" class="text-bold form-control" value="Aun cuando conoce que existen canales alternativos para realizar sus transacciones, ¿Por qué razones usted utiliza los servicios de la agencia bancaria?" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta8" name="respuesta8" class="form-control">
                                                <option value=""></option>
                                                <option>No sabe utilizar los canales alternativos</option>
                                                <option>No tiene acceso a teléfono fijo / móvil</option>
                                                <option>No tiene corresponsales bancarios cerca</option>
                                                <option>No posee servicio de internet</option>
                                                <option>Siento más confianza en realizar la transacción en ventanilla</option>
                                                <option>El banco lo tengo muy cerca</option>
                                                <option>No todas las transacciones se pueden hacer en los canales alternativos</option>
                                                <option>El servicio de la ventanilla es rápido, no pierdo tiempo</option>
                                                <option>Requiero realizar un retiro de la cuenta “Ahorro Futuro”</option>
                                                <option>No se acerca a la agencia</option>
                                                <!--<option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>-->
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 9---------------------------------------------------->
                                        <div class="col-xs-8"><input id="pregunta9" name="pregunta9" class="text-bold form-control" value="¿Qué día de la semana y en qué horario visita una agencia bancaria?" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta9" name="respuesta9" class="form-control">
                                                <option value=""></option>
                                                <option>Lunes</option>
                                                <option>Martes</option>
                                                <option>Miércoles</option>
                                                <option>Jueves</option>
                                                <option>Viernes</option>
                                                <option>Sábado</option>
                                                <option>Domingo</option>
                                                <option>No especifica</option>
                                                <!--<option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>-->
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 10---------------------------------------------------->
                                        <!--<div class="col-xs-10"><input id="pregunta10" name="pregunta10" class="text-bold form-control" value="¿Cuál es el horario en el que usted visita la agencia bancaria?" readonly/></div>-->
                                        <div class="col-xs-2">
                                            <select id="respuesta10" name="respuesta10" class="form-control">
                                                <option></option>
                                                <option>De 09:00 a 10:00</option>
                                                <option>De 10:01 a 11:00</option>
                                                <option>De 11:01 a 12:00</option>
                                                <option>De 12:01 a 13:00</option>
                                                <option>De 13:01 a 14:00</option>
                                                <option>De 14:01 a 15:00</option>
                                                <option>De 15:01 a 16:00</option>
                                                <option>De 16:01 a 17:00</option>
                                                <option>De 17:01 a 18:00</option>
                                                <option>De 18:01 a 19:00</option>
                                                <option>De 19:01 a 20:00</option>
                                                <option>No especifica</option>
                                                <!--<option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>-->
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 11---------------------------------------------------->
                                        <div class="col-xs-10"><input id="pregunta11" name="pregunta11" class="text-bold form-control" readonly value="¿Cuáles son las razones por las que usted visita el horario de…MENCIONE RESPUESTA ANTERIOR para utilizar los servicios en una agencia bancaria?"/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta11" name="respuesta11" class="form-control">
                                                <option value=""></option>
                                                <option>Es el horario cuando puede hacer ese tipo de gestiones</option>
                                                <option>En ese horario existen mayor número de personas atendiendo</option>
                                                <option>Me gusta desocuparme rápido y temprano</option>
                                                <option>En ese horario no existen muchas personas esperando atención</option>
                                                <option>Es el horario que acostumbra a hacerlo</option>
                                                <option>Es el horario que me han recomendado ir al banco</option>
                                                <!--<option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>-->
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 12---------------------------------------------------->
                                        <div class="col-xs-10"><input id="pregunta12" name="pregunta12" class="text-bold form-control" readonly value="¿Con qué frecuencia suele utilizar los servicios en una agencia bancaria?"/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta12" name="respuesta12" class="form-control">
                                                <option value=""></option>
                                                <option>Todos los días (7 días)</option>
                                                <option>De 2 a 3 veces por semana</option>
                                                <option>1 vez a la semana</option>
                                                <option>Cada 10 días</option>
                                                <option>Cada 15 días</option>
                                                <option>Cada 3 semanas</option>
                                                <option>1 vez al mes</option>
                                                <option>Menos de 1 vez por mes</option>
                                                <!--<option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>-->
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 13---------------------------------------------------->
                                        <div class="col-xs-10"><input id="pregunta13" name="pregunta13" class="text-bold form-control" readonly value="¿Considera los horarios de atención de las agencias de Banco Pichincha son adecuados?"/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta13" name="respuesta13" class="form-control">
                                                <option value=""></option>
                                                <option>SI</option>
                                                <option>NO</option>
                                                <!--<option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>-->
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 14---------------------------------------------------->
                                        <div class="col-xs-10"><input id="pregunta14" name="pregunta14" class="text-bold form-control" readonly value="Si pudiera escoger el horario de apertura y cierra de atención de una agencia de Banco Pichincha de lunes a viernes, ¿cuál sería? (DESDE/HASTA)"/></div>
                                        <div class="col-xs-2">
                                            <input id="respuesta14" name="respuesta14" type="text" class="form-control">
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 15---------------------------------------------------->
                                        <div class="col-xs-10"><input id="pregunta15" name="pregunta15" class="text-bold form-control" readonly value="Si pudiera escoger el horario de apertura y cierra de atención de una agencia de Banco Pichincha el día sábado, ¿cuál sería? (DESDE/HASTA)"/></div>
                                        <div class="col-xs-2">
                                            <input id="respuesta15" name="respuesta15" type="text" class="form-control">
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 16---------------------------------------------------->
                                        <div class="col-xs-10"><input id="pregunta16" name="pregunta16" class="text-bold form-control" readonly value="Si pudiera escoger el horario de apertura y cierra de atención de una agencia de Banco Pichincha el día domingo, ¿cuál sería? (DESDE/HASTA)"/></div>
                                        <div class="col-xs-2">
                                            <input id="respuesta16" name="respuesta16" type="text" class="form-control">
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 17---------------------------------------------------->
                                        <div class="col-xs-10"><input id="pregunta17" name="pregunta17" class="text-bold form-control" readonly value="Usted visita el Banco Pichincha el día sábado para?"/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta17" name="respuesta17" class="form-control">
                                                <option value=""></option>
                                                <option>Hacer transacciones en ventanillas </option>
                                                <option>Hacer inversiones</option>
                                                <option>Abrir cuenta </option>
                                                <option>Solicitar un crédito</option>
                                                <option>No se acerca a la agencia</option>
                                                <option>Servicio al cliente</option>
                                                <!--<option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>-->
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 18---------------------------------------------------->
                                        <div class="col-xs-10"><input id="pregunta18" name="pregunta18" class="text-bold form-control" readonly value="Usted visitaría el Banco Pichincha el día domingo para?"/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta18" name="respuesta18" class="form-control">
                                                <option value=""></option>
                                                <option>Hacer transacciones en ventanillas </option>
                                                <option>Hacer inversiones</option>
                                                <option>Abrir cuenta </option>
                                                <option>Solicitar un crédito</option>
                                                <option>No se acerca a la agencia</option>
                                                <option>Servicio al cliente</option>
                                                <!--<option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>-->
                                            </select>
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
<script src="scripts/bpEncuestasPreferenciales.js" type="text/javascript"></script>
<script src="scripts/funcions.js" type="text/javascript"></script>