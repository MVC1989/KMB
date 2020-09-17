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
                                    <div class="col-xs-2"> <b>TIPO </b>
                                        <input type="text" class="form-control input-sm" id="CAMPO1" name="CAMPO1" readonly/>
                                    </div>
                                    <div class="col-xs-2"> <b>TIPIFICACION </b>
                                        <input type="text" class="form-control input-sm" id="CAMPO2" name="CAMPO2" readonly/>
                                    </div>
                                    <div class="col-xs-2"> <b>MAIL </b>
                                        <input type="text" class="form-control input-sm" id="CAMPO3" name="CAMPO3" readonly/>
                                    </div>
                                    <div class="col-xs-2"> <b>TIPO_CLIENTE </b>
                                        <input type="text" class="form-control input-sm" id="CAMPO5" name="CAMPO5" readonly/>
                                    </div>
                                    <div class="col-xs-2"> <b>CAJERO/USUARIO </b>
                                        <input type="text" class="form-control input-sm" id="CAMPO6" name="CAMPO6" readonly/>
                                    </div>
                                    <div class="col-xs-4"> <b>TRAMITES</b>
                                        <input type="text" class="form-control input-sm" id="CAMPO7" name="CAMPO7" readonly/>
                                    </div>
                                    <div class="col-xs-4"> <b>SEGMENTO </b>
                                        <input type="text" class="form-control input-sm" id="CAMPO8" name="CAMPO8" readonly/>
                                    </div>
                                    <div class="col-xs-2"> <b>FECHA ATENCION </b>
                                        <input type="text" class="form-control input-sm" id="CAMPO9" name="CAMPO9" readonly/>
                                    </div>
                                    <div class="col-xs-4"> <b>TIPO 1</b>
                                        <input type="text" class="form-control input-sm" id="CAMPO10" name="CAMPO10" readonly/>
                                    </div>
                                </div>
                            </div>
                            <div id="pnlEncuesta" class="col-xs-12 btn">
                                <div class="box box-widget bg-gray">
                                    <div class="box-body">
                                        <!---------------------------------------------------------PREGUNTA 1---------------------------------------------------->
                                        <div class="col-xs-9"><input id="pregunta1" name="pregunta1" class="text-bold form-control" value="1. Como cambia la relacion con BGR la emergencia por COVID-19?" readonly/></div>
                                        <div class="col-xs-3">  
                                            <select id="respuesta1" name="respuesta1" class="form-control">
                                                <option value=""></option>
                                                <option >Empeoró</option>
                                                <option >Se mantiene</option>
                                                <option >Mejoró</option>
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 2---------------------------------------------------->
                                        <div class="col-xs-9"><input id="pregunta2" name="pregunta2" class="text-bold form-control" value="2. Que considera que BGR ha hecho efectivamente en esta emergencia?" readonly/></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta2" name="respuesta2" class="form-control">
                                                <option value=""></option>
                                                <option>Apoyo financiero</option>
                                                <option>Mantener el servicio</option>
                                                <option>Despliegue Digita</option>
                                                <option>Canales alternativos</option>
                                                <option>Responsabilidad social</option>
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 3---------------------------------------------------->
                                        <div class="col-xs-8"><input id="pregunta3" name="pregunta3" class="text-bold form-control" value="3. Cual considera que ha sido la Institución Financiera que mejor reaccionó al cambio y por que?" readonly/></div>
                                        <div class="col-xs-4">
                                            <input id="respuesta3" name="respuesta3" type="text" class="form-control">
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 4---------------------------------------------------->
                                        <div class="col-xs-9"><input id="pregunta4" name="pregunta4" class="text-bold form-control" value="4. Al comparar el servicio de BGR con esa Institución Financiera, en que nivel calificaría el servicio de BGR?" readonly/></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta4" name="respuesta4" class="form-control">
                                                <option value=""></option>
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                                <option>6</option>
                                                <option>7</option>
                                                <option>8</option>
                                                <option>9</option>
                                                <option>10</option>
                                                <option>No aplica</option>
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 5---------------------------------------------------->
                                        <div class="col-xs-9"><input id="pregunta5" name="pregunta5" class="text-bold form-control" value="5. A partir de esta situación, cual sería el Canal de preferencia para transaccionar con BGR?" readonly/></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta5" name="respuesta5" class="form-control">
                                                <option value=""></option>
                                                <option>Oficina</option>
                                                <option>Call Center</option>
                                                <option>Banca Digital</option>
                                                <option>APP Movil</option>
                                                <option>Redes Sociales</option>
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 6---------------------------------------------------->
                                        <div class="col-xs-9"><input id="pregunta6" name="pregunta6" class="text-bold form-control" value="6. Como considera el nivel de Accesibilidad a los servicios financieros por medios digitales?" readonly/></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta6" name="respuesta6" class="form-control">
                                                <option value=""></option>
                                                <option>Pésimo</option>
                                                <option>Malo</option>
                                                <option>Regular</option>
                                                <option>Bueno</option>
                                                <option>Excelente</option>
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 7---------------------------------------------------->
                                        <div class="col-xs-8"><input id="pregunta7" name="pregunta7" class="text-bold form-control" value="7. ¿Qué le gustaría que BGR realice para mejorar su experiencia?" readonly/></div>
                                        <div class="col-xs-4">
                                            <input id="respuesta7" name="respuesta7" type="text" class="form-control">
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 8---------------------------------------------------->
                                        <div class="col-xs-9"><input id="pregunta8" name="pregunta8" class="text-bold form-control" value="8. Podría contarnos regularmente cuáles son sus preferencias de consumo" readonly/></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta8" name="respuesta8" class="form-control">
                                                <option value=""></option>
                                                <option>Entretenimiento</option>
                                                <option>Actividad física</option>
                                                <option>Salud</option>
                                                <option>Educación</option>
                                                <option>Tecnología</option>
                                                <option>Alimentación</option>
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 9---------------------------------------------------->
                                        <div class="col-xs-9"><input id="pregunta9" name="pregunta9" class="text-bold form-control" value="9. A través de que medio prefiere visualizar la información de comunicación/publicitaria a partir de esta crisis" readonly/></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta9" name="respuesta9" class="form-control">
                                                <option value=""></option>
                                                <option>Medios audiovisuales (radio, televisión)</option>
                                                <option>Redes sociales</option>
                                                <option>Material impreso</option>
                                                <option>Publicidad por whatsapp</option>
                                                <option>Páginas web de empresas</option>
                                                <option>Agencias</option>
                                                <option>Cajeron automáticos</option>
                                                <option>Ejecutivos comerciales</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="box-body" id="pnlOficinas">
                                        <!---------------------------------------------------------PREGUNTA 10---------------------------------------------------->
                                        <div class="col-xs-9"><input id="pregunta10" name="pregunta10" class="text-bold form-control" value="10. ¿Qué motivó su visita a una oficina de BGR, en esta emergencia?" readonly/></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta10" name="respuesta10" class="form-control">
                                                <option value=""></option>
                                                <option>Seguridad en la transacción</option>
                                                <option>Necesidad de Efectivo</option>
                                                <option>Relación con el asesor</option>
                                                <option>Solicitar apoyo financiero</option>
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 11---------------------------------------------------->
                                        <div class="col-xs-9"><input id="pregunta11" name="pregunta11" class="text-bold form-control" value="11. ¿Conoce si el tramite realizado en oficina, puede realizarse por otro canal?" readonly/></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta11" name="respuesta11" class="form-control">
                                                <option value=""></option>
                                                <option>Si</option>
                                                <option>No</option>
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 12---------------------------------------------------->
                                        <div class="col-xs-9"><input id="pregunta12" name="pregunta12" class="text-bold form-control" value="12. Como califica las medidas sanitarias aplicadas por BGR en su visita a la Agencia" readonly/></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta12" name="respuesta12" class="form-control">
                                                <option value=""></option>
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="box-body" id="pnlCallCenter">
                                        <!---------------------------------------------------------PREGUNTA 13---------------------------------------------------->
                                        <div class="col-xs-9"><input id="pregunta13" name="pregunta13" class="text-bold form-control" value="10. ¿Su necesidad o requerimiento fue solventado a través de su llamada a Call Center?" readonly/></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta13" name="respuesta13" class="form-control">
                                                <option value=""></option>
                                                <option>Si</option>
                                                <option>No</option>
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 14---------------------------------------------------->
                                        <div class="col-xs-8"><input id="pregunta14" name="pregunta14" class="text-bold form-control" value="11. Por favor cuéntenos el por qué de su respuesta" readonly/></div>
                                        <div class="col-xs-4">
                                            <input id="respuesta14" name="respuesta14" type="text" class="form-control">
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 15---------------------------------------------------->
                                        <div class="col-xs-9"><input id="pregunta15" name="pregunta15" class="text-bold form-control" value="12. La facilidad para contactarse con el Call Center" readonly/></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta15" name="respuesta15" class="form-control">
                                                <option value=""></option>
                                                <option>Muy Fácil</option>
                                                <option>Fácil</option>
                                                <option>Medianamente fácil</option>
                                                <option>Difícil</option>
                                                <option>Muy Difícil</option>
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 16---------------------------------------------------->
                                        <div class="col-xs-8"><input id="pregunta16" name="pregunta16" class="text-bold form-control" value="13. Por favor cuéntenos el por qué de su respuesta" readonly/></div>
                                        <div class="col-xs-4">
                                            <input id="respuesta16" name="respuesta16" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="box-body" id="pnlCanales">
                                        <!---------------------------------------------------------PREGUNTA 17---------------------------------------------------->
                                        <div class="col-xs-9"><input id="pregunta17" name="pregunta17" class="text-bold form-control" value="10. La facilidad para acceder a los servicios a través de nuestra Aplicación móvil / Banca en linea" readonly/></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta17" name="respuesta17" class="form-control">
                                                <option value=""></option>
                                                <option>Muy Fácil</option>
                                                <option>Fácil</option>
                                                <option>Medianamente fácil</option>
                                                <option>Difícil</option>
                                                <option>Muy Difícil</option>
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 18---------------------------------------------------->
                                        <div class="col-xs-8"><input id="pregunta18" name="pregunta18" class="text-bold form-control" value="11. En base a su experiencia, mantendría el uso de Aplicación móvil / Banca en linea para gestionar sus requerimientos?" readonly/></div>
                                        <div class="col-xs-4">
                                            <select id="respuesta18" name="respuesta18" class="form-control">
                                                <option value=""></option>
                                                <option>Si</option>
                                                <option>No</option>
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 19---------------------------------------------------->
                                        <div class="col-xs-8"><input id="pregunta19" name="pregunta19" class="text-bold form-control" value="12. Por favor cuéntenos el por qué de su respuesta" readonly/></div>
                                        <div class="col-xs-4">
                                            <input id="respuesta19" name="respuesta19" type="text" class="form-control">
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
<script src="scripts/bancoBGREncuestaSist.js" type="text/javascript"></script>
<script src="scripts/funcions.js" type="text/javascript"></script>