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
                                        <div class="row col-xs-2 text-left"> <span class="text-bold">Última gestión:</span>
                                        </div>
                                        <div class="row col-xs-4 text-left">
                                            <input type="text" class="form-control input-sm" id="last" name="last" readonly/>
                                        </div>
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
                                <div class="col-xs-2"> <b>EDAD </b>
                                    <input type="text" class="form-control input-sm" id="CAMPO1" name="CAMPO1" readonly/>
                                </div>
                                <div class="col-xs-2"> <b>GÉNERO </b>
                                    <input type="text" class="form-control input-sm" id="CAMPO2" name="CAMPO2" readonly/>
                                </div>
                                <div class="col-xs-2"> <b>CORREO </b>
                                    <input type="text" class="form-control input-sm" id="CAMPO3" name="CAMPO3" readonly/>
                                </div>
                                <div class="col-xs-2"> <b>AGENCIA </b>
                                    <input type="text" class="form-control input-sm" id="CAMPO4" name="CAMPO4" readonly/>
                                </div>
                            </div>
                            <div id="pnlEncuesta2" class="col-xs-12 btn">
                                <div class="box box-widget bg-gray">
                                    <div class="box-body col-xs-12 btn">
                                        <div class="col-xs-9"><input id="pregunta1" name="pregunta1" class="text-bold form-control" value="1. ¿Usted ha escuchado en otra institución financiera; sobre algún producto monetario que le permita garantizar el cumplimiento de sus metas, con una tasa de rentabilidad diferenciada?" readonly/></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta1" name="respuesta1" class="form-control">
                                                <option value=""></option>
                                                <option >SI</option>
                                                <option >NO</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-9"><input id="pregunta2" name="pregunta2" class="text-bold form-control" value="1.1 ¿En qué institución financiera?" readonly/></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta2" name="respuesta2" class="form-control">
                                                <option value=""></option>
                                                <option>Banco AMAZONAS</option >
                                                <option>Banco AUSTRO</option >
                                                <option>Banco DESARROLLO DE LOS PUEBLOS S.A. CODESARROLLO</option >
                                                <option>Banco BOLIVARIANO</option >
                                                <option>Banco CAPITAL</option >
                                                <option>Banco COMERCIAL DE MANABI</option >
                                                <option>Banco COOPNACIONAL</option >
                                                <option>Banco DELBANK</option >
                                                <option>Banco DINERS</option >
                                                <option>Banco D-MIRO S.A.</option >
                                                <option>Banco FINCA S.A.</option >
                                                <option>Banco GENERAL RUMIÑAHUI</option >
                                                <option>Banco GUAYAQUIL</option >
                                                <option>Banco INTERNACIONAL</option >
                                                <option>Banco LITORAL</option >
                                                <option>Banco LOJA</option >
                                                <option>Banco MACHALA</option >
                                                <option>Banco PACIFICO</option >
                                                <option>Banco PICHINCHA</option >
                                                <option>Banco PROCREDIT</option >
                                                <option>Banco PRODUBANCO</option >
                                                <option>Banco SOLIDARIO</option >
                                                <option>Banco VISIONFUND ECUADOR S.A.</option >
                                                <option>COOPERATIVA 14 DE MARZO</option >
                                                <option>COOPERATIVA 16 DE JULIO</option >
                                                <option>COOPERATIVA 23 DE JULIO</option >
                                                <option>COOPERATIVA 23 DE OCTUBRE</option >
                                                <option>COOPERATIVA 23 DE JULIO</option >
                                                <option>COOPERATIVA 29 DE OCTUBRE</option >
                                                <option>COOPERATIVA 9 DE OCTUBRE</option >
                                                <option>COOPERATIVA ALIANZA DEL VALLE</option >
                                                <option>COOPERATIVA ANDALUCIA</option >
                                                <option>COOPERATIVA ANTORCHA</option >
                                                <option>COOPERATIVA ATUNTAQUI</option >
                                                <option>COOPERATIVA AZUAY</option >
                                                <option>COOPERATIVA AZUAYA</option >
                                                <option>COOPERATIVA CACPECO</option >
                                                <option>COOPERATIVA CACSPMEC</option >
                                                <option>COOPERATIVA CAMARA DE COMERCIO</option >
                                                <option>COOPERATIVA CASTRO ZAMORA</option >
                                                <option>COOPERATIVA CCQ</option >
                                                <option>COOPERATIVA CHIBULEO</option >
                                                <option>COOPERATIVA CHONE</option >
                                                <option>COOPERATIVA CODESARROLLO</option >
                                                <option>COOPERATIVA COOPROGRESO</option >
                                                <option>COOPERATIVA COPAUSTRO</option >
                                                <option>COOPERATIVA CORNELIO SAENZ</option >
                                                <option>COOPERATIVA CREA</option >
                                                <option>COOPERATIVA CREDIFACIL</option >
                                                <option>COOPERATIVA CULQUIGUASI</option >
                                                <option>COOPERATIVA DAQUILEMA</option >
                                                <option>COOPERATIVA DE AHORRO SAN FRANCISCO</option >
                                                <option>COOPERATIVA DE AHORRO Y CREDITO COOPAD</option >
                                                <option>COOPERATIVA DE AHORRO Y CREDITO HERRERA</option >
                                                <option>COOPERATIVA DE LOJA</option >
                                                <option>COOPERATIVA EDUCADORES DEL AZUAY</option >
                                                <option>COOPERATIVA EL SAGRARIO</option >
                                                <option>COOPERATIVA ESPE</option >
                                                <option>COOPERATIVA ESPOIR</option >
                                                <option>COOPERATIVA FACES</option >
                                                <option>COOPERATIVA GUARANDA</option >
                                                <option>COOPERATIVA HUAYNA CAPAC</option >
                                                <option>COOPERATIVA INSOTEC</option >
                                                <option>COOPERATIVA JARDIN AZUAYO</option >
                                                <option>COOPERATIVA JEP</option >
                                                <option>COOPERATIVA JUAN PIO DE MORA</option >
                                                <option>COOPERATIVA KAPEC YANCASA</option >
                                                <option>COOPERATIVA KULLKIWASI</option >
                                                <option>COOPERATIVA LA PADRE JULIAN LORENTE</option >
                                                <option>COOPERATIVA LLANO GRANDE</option >
                                                <option>COOPERATIVA MANANTIAL DE ORO</option >
                                                <option>COOPERATIVA MAQUITA CUSHUNCHIC</option >
                                                <option>COOPERATIVA MEGO</option >
                                                <option>COOPERATIVA MULTIEMPRESARIAL</option >
                                                <option>COOPERATIVA MUSHUC CAUSAY</option >
                                                <option>COOPERATIVA MUSHUC RUNA</option >
                                                <option>COOPERATIVA OSCUS</option >
                                                <option>COOPERATIVA PABLO MUÑOZ VEGA</option >
                                                <option>COOPERATIVA PADRE JULIAN LORENTE</option >
                                                <option>COOPERATIVA PALLATANGA LTDA</option >
                                                <option>COOPERATIVA PEDRO MONCAYO</option >
                                                <option>COOPERATIVA POLICÍA NACIONAL</option >
                                                <option>COOPERATIVA RIOBAMBA</option >
                                                <option>COOPERATIVA SAN FRANCISCO</option >
                                                <option>COOPERATIVA SAN GABRIEL</option >
                                                <option>COOPERATIVA SAN JOSÉ</option >
                                                <option>COOPERATIVA SANTA ANA</option >
                                                <option>COOPERATIVA SANTA ROSA</option >
                                                <option>COOPERATIVA SEÑOR DEL GIRON</option >
                                                <option>COOPERATIVA TULCAN</option >
                                                <option>COOPERATIVA VISION</option >
                                                <option>COPERATIVA CODESARROLLO</option >
                                                <option>COPERCO</option >
                                                <option>FONDOS ECUATORIANOS</option >
                                                <option>MUTUALISTA AZUAY</option >
                                                <option>MUTUALISTA IMBABURA</option >
                                                <option>MUTUALISTA PICHINCHA</option >
                                            </select>
                                        </div>
                                        <div class="col-xs-9"><input id="pregunta3" name="pregunta3" class="text-bold form-control" value="2. ¿Si usted contratara un producto de ahorro que beneficios adicionales le gustaría obtener?" readonly/></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta3" name="respuesta3" class="form-control">
                                                <option value=""></option>
                                                <option >Premios</option>
                                                <option >Bono</option>
                                                <option >Seguros</option>
                                                <option >Asistencias</option>
                                                <option >Descuentos en establecimientos</option>
                                                <option >Ninguna de las anteriores</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-9">
                                            <textarea id="pregunta4" name="pregunta4" class="text-bold form-control" readonly rows="4">3. Estaría dispuesto a contratar un producto que le permita ir ahorrando de manera programada, con una cuota mensual fija donde podrá comenzar con un monto inicial y realizar depósitos o abonos sorprendentes a lo largo del tiempo y así obtener una tasa de interés diferenciada</textarea>
                                        </div>
                                        <div class="col-xs-3">
                                            <select id="respuesta4" name="respuesta4" class="form-control">
                                                <option value=""></option>
                                                <option >SI</option>
                                                <option >NO</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-9"><input id="pregunta5" name="pregunta5" class="text-bold form-control" value="4. ¿Cuál sería el valor que estaría dispuesto a ahorrar anualmente?" readonly/></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta5" name="respuesta5" class="form-control">
                                                <option value=""></option>
                                                <option >USD 0 A USD 4999</option>
                                                <option >USD 5000 A USD 9999</option>
                                                <option >USD 10.000 a USD 49.900 </option>
                                                <option >USD 50.000 a USD 99.000</option>
                                                <option >USD 100.000 a USD 199.000</option>
                                                <option >USD 200.000 a USD 499.000</option>
                                                <option >USD 500.000 o +</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-9"><input id="pregunta6" name="pregunta6" class="text-bold form-control" value="5. ¿Qué monto mensual estaría dispuesto a ahorrar?" readonly/></div>
                                        <div class="col-xs-3">
                                            <input id="respuesta6" name="respuesta6" type="number" class="form-control">
                                        </div>
                                        <div class="col-xs-9"><input id="pregunta7" name="pregunta7" class="text-bold form-control" value="6. ¿Que tiempo establecería para cumplir su meta de ahorro?" readonly/></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta7" name="respuesta7" class="form-control">
                                                <option value=""></option>
                                                <option >1 a 2 años</option>
                                                <option >2 a 3 años</option>
                                                <option >3 a 4 años</option>
                                                <option >4 a 5 años</option>
                                                <option >5 a 6 años</option>
                                                <option >6 a 7 años</option>
                                                <option >1 a 5 años</option>
                                                <option >6 a 10 años</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-6"><input id="pregunta8" name="pregunta8" class="text-bold form-control" value="7. ¿Qué opina de la tasa diferenciada dependiendo del monto que maneje en su ahorro, a mayor monto ahorrado, recibe mayor tasa de interés?" readonly/></div>
                                        <div class="col-xs-6">
                                            <input id="respuesta8" name="respuesta8" type="text" class="form-control">
                                        </div>
                                        <div class="col-xs-9"><input id="pregunta9" name="pregunta9" class="text-bold form-control" value="8. ¿Para acceder a este producto, quisiera hacerlo a través de nuestra Web o aplicación móvil?" readonly/></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta9" name="respuesta9" class="form-control">
                                                <option value=""></option>
                                                <option >SI</option>
                                                <option >NO</option>
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
<script src="scripts/bpAhorroProgramado.js" type="text/javascript"></script>
<script src="scripts/funcions.js" type="text/javascript"></script>