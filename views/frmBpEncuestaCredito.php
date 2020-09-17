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
                                        <div class="col-xs-10"><textarea id="pregunta1" name="pregunta1" class="text-bold form-control" readonly>1.	¿Usted accedió a un crédito de compra de vivienda en el año 2019? </textarea></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta1" name="respuesta1" class="form-control">
                                                <option value=""></option>
                                                <option >SI</option>
                                                <option >NO</option>
                                                <!--<option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>-->
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 2---------------------------------------------------->
                                        <div class="col-xs-10"><textarea id="pregunta2" name="pregunta2" class="text-bold form-control" readonly>¿Con qué institución?</textarea></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta2" name="respuesta2" class="form-control">
                                                <option value=""></option>
                                                <option >BANCO PICHINCHA</option>
                                                <option >OTRA INSTITUCION FINANCIERA</option>
                                                <!--<option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>-->
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 3---------------------------------------------------->
                                        <div class="col-xs-4"><input id="pregunta3" name="pregunta3" class="text-bold form-control" value="Cuál?" readonly/></div>
                                        <div class="col-xs-8">
                                            <input id="respuesta3" name="respuesta3" type="text" class="form-control">
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 4---------------------------------------------------->
                                        <div class="col-xs-7"><input id="pregunta4" name="pregunta4" class="text-bold form-control" value="¿Por qué no accedió a su crédito?" readonly/></div>
                                        <div class="col-xs-5">
                                            <select id="respuesta4" name="respuesta4" class="form-control">
                                                <option value=""></option>
                                                <option >FALTA DE DOCUMENTACIÓN</option>
                                                <option >NO FUE APROBADO EL CRÉDITO</option>
                                                <option >MONTO DEL CRÉDITO</option>
                                                <option >REQUISITOS</option>
                                                <option >TASA</option>
                                                <option >PLAZO</option>
                                                <option >AGILIDAD EN EL TRÁMITE</option>
                                                <option >MESES DE GRACIA</option>
                                                <option >PRESTIGIO DE LA INSTITUCIÓN FINANCIERA</option>
                                                <option >NO REQUIERE EL PRODUCTO</option>
                                            </select> 
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 5---------------------------------------------------->
                                        <div class="col-xs-8"><input id="pregunta5" name="pregunta5" class="text-bold form-control" readonly value="2.	¿Cuál fue el motivo de mayor importancia al momento de seleccionar la institución financiera para acceder al crédito?"/></div>
                                        <div class="col-xs-4">
                                            <select id="respuesta5" name="respuesta5" class="form-control">
                                                <option value=""></option>
                                                <option >MONTO DEL CRÉDITO</option>
                                                <option >REQUISITOS</option>
                                                <option >TASA</option>
                                                <option >PLAZO</option>
                                                <option >AGILIDAD EN EL TRÁMITE</option>
                                                <option >MESES DE GRACIA</option>
                                                <option >PRESTIGIO DE LA INSTITUCIÓN FINANCIERA</option>
                                            </select> 
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 6---------------------------------------------------->
                                        <div class="col-xs-5"><input id="pregunta6" name="pregunta6" class="text-bold form-control" value="3.	¿Por qué medio usted accedió a información sobre su crédito de vivienda?" readonly/></div>
                                        <div class="col-xs-7">
                                            <select id="respuesta6" name="respuesta6" class="form-control">
                                                <option value=""></option>
                                                <option >MEDIOS DIGITALES</option>
                                                <option >VISITA A LA CONSTRUCTORA</option>
                                                <option >MEDIOS IMPRESOS</option>
                                                <option >RADIO O TELEVISIÓN</option>
                                                <option >AGENCIAS</option>
                                                <option >POR RECOMENDACIÓN</option>
                                            </select> 
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 7---------------------------------------------------->
                                        <div class="col-xs-12"><textarea id="pregunta1" name="pregunta1" class="text-bold form-control" readonly>4.	En este momento vamos a evaluar los servicios que BANCO PICHINCHA le brindó para la aprobación de su crédito de vivienda. En una escala de 1 a 5 donde 1 es Pésimo y 5 es Excelente, por favor califique los servicios que vamos a evaluar.</textarea></div>
                                        <!---------------------------------------------------------PREGUNTA 8---------------------------------------------------->
                                        <div class="col-xs-10"><input id="pregunta8" name="pregunta8" class="text-bold form-control" value="Facilidad de requisitos solicitados para la obtención de Financiamiento de vivienda" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta8" name="respuesta8" class="form-control">
                                                <option value=""></option>
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                                <!--<option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>-->
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 9---------------------------------------------------->
                                        <div class="col-xs-10"><input id="pregunta9" name="pregunta9" class="text-bold form-control" value="Agilidad en el proceso de obtención del Financiamiento de vivienda" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta9" name="respuesta9" class="form-control">
                                                <option value=""></option>
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                                <!--<option value="NO PROPORCIONA INFORMACION">NO PROPORCIONA INFORMACION</option>-->
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 10---------------------------------------------------->
                                        <div class="col-xs-10"><input id="pregunta10" name="pregunta10" class="text-bold form-control" value="Tasa de interés del Financiamiento de vivienda" readonly/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta10" name="respuesta10" class="form-control">
                                                <option></option>
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 11---------------------------------------------------->
                                        <div class="col-xs-10"><input id="pregunta11" name="pregunta11" class="text-bold form-control" readonly value="Plazo de pagos del Financiamiento de vivienda"/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta11" name="respuesta11" class="form-control">
                                                <option></option>
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 12---------------------------------------------------->
                                        <div class="col-xs-10"><input id="pregunta12" name="pregunta12" class="text-bold form-control" readonly value="Meses de gracia para empezar a pagar el crédito"/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta12" name="respuesta12" class="form-control">
                                                <option></option>
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 13---------------------------------------------------->
                                        <div class="col-xs-10"><input id="pregunta13" name="pregunta13" class="text-bold form-control" readonly value="El monto del FINANCIAMIENTO de vivienda otorgado fue el deseado"/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta13" name="respuesta13" class="form-control">
                                                <option></option>
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 14---------------------------------------------------->
                                        <div class="col-xs-12"><input id="pregunta14" name="pregunta14" class="text-bold form-control" readonly value="5.	¿A nivel general que recomendación daría usted a Banco Pichincha para mejorar el proceso y producto de crédito de vivienda a sus clientes?"/></div>
                                        <div class="col-xs-12">
                                            <input id="respuesta14" name="respuesta14" type="text" class="form-control">
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 15---------------------------------------------------->
                                        <div class="col-xs-10"><input id="pregunta15" name="pregunta15" class="text-bold form-control" readonly value="6.	¿Cuál fue el motivo de mayor importancia al momento de seleccionar la institución financiera para acceder al crédito?"/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta15" name="respuesta15" class="form-control">
                                                <option value=""></option>
                                                <option >MONTO DEL CRÉDITO</option>
                                                <option >REQUISITOS</option>
                                                <option >TASA</option>
                                                <option >PLAZO</option>
                                                <option >AGILIDAD EN EL TRÁMITE</option>
                                                <option >MESES DE GRACIA</option>
                                                <option >PRESTIGIO DE LA INSTITUCIÓN FINANCIERA</option>
                                            </select> 
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 16---------------------------------------------------->
                                        <div class="col-xs-12"><input id="pregunta16" name="pregunta16" class="text-bold form-control" readonly value="7.	¿A nivel general que recomendación daría usted a Banco Pichincha para mejorar el proceso y producto de crédito de vivienda a sus clientes? "/></div>
                                        <div class="col-xs-12">
                                            <input id="respuesta16" name="respuesta16" type="text" class="form-control">
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 17---------------------------------------------------->
                                        <div class="col-xs-10"><input id="pregunta17" name="pregunta17" class="text-bold form-control" readonly value="8.	¿Cuál es el motivo de mayor importancia al momento de seleccionar la institución financiera para que usted decida acceder al crédito inmobiliario? "/></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta17" name="respuesta17" class="form-control">
                                                <option value=""></option>
                                                <option >MONTO DEL CRÉDITO</option>
                                                <option >REQUISITOS</option>
                                                <option >TASA</option>
                                                <option >PLAZO</option>
                                                <option >AGILIDAD EN EL TRÁMITE</option>
                                                <option >MESES DE GRACIA</option>
                                                <option >PRESTIGIO DE LA INSTITUCIÓN FINANCIERA</option>
                                            </select> 
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 18---------------------------------------------------->
                                        <div class="col-xs-12"><input id="pregunta18" name="pregunta18" class="text-bold form-control" readonly value="9.	¿Seleccione las características de su preferencia para que usted decida acceder a un crédito de vivienda?"/></div>
                                        <!---------------------------------------------------------PREGUNTA 19---------------------------------------------------->
                                        <div class="col-xs-8"><input id="pregunta19" name="pregunta19" class="text-bold form-control" readonly value="Monto del crédito "/></div>
                                        <div class="col-xs-4">
                                            <select id="respuesta19" name="respuesta19" class="form-control">
                                                <option value=""></option>
                                                <option>De USD 25.000 a USD 50.000</option>
                                                <option>De USD 50.000 a USD 75.000</option>
                                                <option>De USD 75.000 a USD 100.000</option>
                                                <option>De USD 100.000 a USD 150.000</option>
                                                <option>Mayor a USD 150.000</option>
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 20---------------------------------------------------->
                                        <div class="col-xs-8"><input id="pregunta20" name="pregunta20" class="text-bold form-control" readonly value="Tasa"/></div>
                                        <div class="col-xs-4">
                                            <select id="respuesta20" name="respuesta20" class="form-control">
                                                <option value=""></option>
                                                <option>10.78%</option>
                                                <option>9.78%</option>
                                                <option>8.95%</option>
                                                <option>8.50%</option>
                                                <option>8%</option>		 
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 21---------------------------------------------------->
                                        <div class="col-xs-8"><input id="pregunta21" name="pregunta21" class="text-bold form-control" readonly value="Plazo"/></div>
                                        <div class="col-xs-4">
                                            <select id="respuesta21" name="respuesta21" class="form-control">
                                                <option value=""></option>
                                                <option>7 años</option>
                                                <option>10 años</option>
                                                <option>15 años</option>
                                                <option>20 años</option>
                                                <option>25 años</option>		 
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 22---------------------------------------------------->
                                        <div class="col-xs-8"><input id="pregunta22" name="pregunta22" class="text-bold form-control" readonly value="Meses de gracia"/></div>
                                        <div class="col-xs-4">
                                            <select id="respuesta22" name="respuesta22" class="form-control">
                                                <option value=""></option>
                                                <option>1 mes</option>
                                                <option>3 meses</option>
                                                <option>6 meses</option>
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 16---------------------------------------------------->
                                        <div class="col-xs-12"><input id="pregunta23" name="pregunta23" class="text-bold form-control" readonly value="10.	¿A nivel general que recomendación daría usted a Banco Pichincha para que pueda acceder al crédito de vivienda?"/></div>
                                        <div class="col-xs-12">
                                            <input id="respuesta23" name="respuesta23" type="text" class="form-control">
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
<script src="scripts/bpEncuestaCreditoH.js" type="text/javascript"></script>
<script src="scripts/funcions.js" type="text/javascript"></script>