<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="panel-body" id="formularioRegistros">
                <form name="formulario" id="formulario" method="POST" class="">
                    <div class="box box-widget bg-gray-light">
                        <div class="box-header with-border bg-gray">
                            <div class="col-xs-3 text-left"> <span class="text-bold">Campañas Inbound</span> </div>
                            <div class="col-xs-1 text-left"> <span class="text-bold">Asesor/a:</span> </div>
                            <div class="col-xs-2 text-left"> <span class="text-right"> <?php echo($_SESSION['name']); ?> </span> </div>
                            <div class="col-xs-1 text-left"> <span class="text-bold">Fecha:</span> </div>
                            <div class="col-xs-2 text-left"> <span id="mostrarHora" class="text-right"></span></div>
                            <div class="box-tools">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <input type="text" class="form-control input-sm hidden" id="IDC" name="IDC" readonly/>
                            <!---------------------------------------------------------BLOQUE A---------------------------------------------------->
                            <div class="col-xs-12 text-center box box-widget bg-gray-light"><b class="text-center">BLOQUE A - Datos del tipo de llamada </b></div>
                            <div class="text-center">

                            </div>
                            <div class="divTable">
                                <div class="divTableBody">
                                    <div class="col-xs-3 col-md-3">
                                        <div class="divTableCell"><label class="text-light-blue">Nombre Cooperativa</label></div>
                                        <div class="divTableCell">
                                            <select id="txtCooperativa" name="txtCooperativa" class="form-control" required>
                                                <option></option>
                                                <?php
                                                require '../config/connection.php';
                                                $result = ejecutarConsulta14("SELECT Descripcion FROM institucionesfinancieras where estado='1' ORDER BY Descripcion");
                                                while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                                                    echo '<option value="' . $row["Descripcion"] . '">' . $row["Descripcion"] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-2 col-md-2">
                                        <div class="divTableCell"><label class="text-light-blue">Tipo de llamada</label></div>
                                        <div class="divTableCell">
                                            <select id="txtTipoLlamada" name="txtTipoLlamada" class="form-control" required>
                                                <option value=""></option>
                                                <option>Inbound</option>
                                                <option>Outbound</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-2 col-md-2">
                                        <div class="divTableCell"><label class="text-light-blue">Estado de llamada</label></div>
                                        <div class="divTableCell">
                                            <select id="txtEstadoLlamada" name="txtEstadoLlamada" class="form-control" required>
                                                <option value=""></option>
                                                <option>Atendida</option>
                                                <option>Abandonada</option>
                                                <option>Fantasma</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-2 col-md-2">
                                        <label class="text-light-blue">Hora inicio de llamada</label>
                                        <input type="text" class="form-control" id="horaInicio" name="horaInicio" required/>
                                    </div>
                                    <div class="col-xs-3 col-md-3">
                                        <label class="text-light-blue">Editar hora fin de la llamada</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <input type="checkbox" id="chkHoraFin" name="chkHoraFin" value="checkeado">
                                            </span>
                                            <input type="text" class="form-control" id="horaFin" name="horaFin"/>
                                        </div>
                                        <!-- /input-group -->
                                    </div>
                                </div>
                            </div>

                            <!---------------------------------------------------------BLOQUE B-C---------------------------------------------------->
                            <div class="col-xs-12 text-center box box-widget bg-gray-light"><br><b class="text-center">BLOQUE B-C - Información del cliente</b></div>
                            <div class="divTable">
                                <div class="divTableBody">
                                    <div class="col-xs-3 col-md-3">
                                        <label class="text-light-blue">Identificación del cliente</label>
                                        <input onkeypress="return onlyNumbers(event)" type="text" class="form-control input-sm" id="txtIdentificacion" name="txtIdentificacion"  maxlength="10" required/>
                                    </div>
                                    <div class="col-xs-6 col-md-6">
                                        <label class="text-light-blue">Nombre del cliente</label>
                                        <input type="text" class="form-control input-sm" id="txtNombreCliente" name="txtNombreCliente" required/>
                                    </div>
                                    <div class="col-xs-3 col-md-3">
                                        <label class="text-light-blue">Ciudad del cliente</label>
                                        <input type="text" class="form-control input-sm" id="txtCiudadCliente" name="txtCiudadCliente" required/>
                                    </div>
                                    <div class="col-xs-3 col-md-3">
                                        <label class="text-light-blue">Celular del cliente</label>
                                        <input pattern="^09(\d{8})$" onkeypress="return onlyNumbers(event)" type="text" class="form-control input-sm" id="txtCelular" name="txtCelular" maxlength="10" required/>
                                    </div>
                                    <div class="col-xs-3 col-md-3">
                                        <label class="text-light-blue">Teléfono convencional del cliente</label>
                                        <input pattern="^(0[2-7])(\d{7})$" onkeypress="return onlyNumbers(event)" type="text" class="form-control input-sm" id="txtConvencional" name="txtConvencional" maxlength="9"/>
                                    </div>
                                    <div class="col-xs-6 col-md-6">
                                        <label class="text-light-blue">Correo del cliente</label>
                                        <input pattern="[a-zA-Z0-9_-]+([.][a-zA-Z0-9_-]+)*@[a-zA-Z0-9_-]+([.][a-zA-Z0-9_-]+)*[.][a-zA-Z]{1,5}" id="txtCorreo" name="txtCorreo" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <!---------------------------------------------------------BLOQUE D---------------------------------------------------->
                            <div class="col-xs-12 text-center box box-widget bg-gray-light"><br><b class="text-center">BLOQUE D - Registro de la llamada</b></div>
                            <div class="divTable">
                                <div class="divTableBody">
                                    <div class="col-xs-3 col-md-3">
                                        <label class="text-light-blue">Tipo de cliente</label>
                                        <select id="txtTipoCliente" name="txtTipoCliente" class="form-control" required>
                                            <option value=""></option>
                                            <option>Titular</option>
                                            <option>Tercera Persona</option>
                                            <option>No Aplica</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-9 col-md-9">
                                        <div class="divTableCell"><label class="text-light-blue">Datos de la tercera persona</label></div>
                                        <div class="divTableCell">
                                            <input type="text" class="form-control input-sm" id="txtTerceraPersona" name="txtTerceraPersona" maxlength="150"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-12"></div>
                            <div class="divTable">
                                <div class="divTableBody">
                                    <div class="col-xs-3 col-md-3">
                                        <div class="divTableCell"><label class="text-light-blue">Motivo de la llamada</label></div>
                                        <div class="divTableCell">
                                            <select id="txtMotivoLlamada" name="txtMotivoLlamada" class="form-control" required>
                                                <option></option>
                                                <?php
                                                require '../config/connection.php';
                                                $result = ejecutarConsulta14("SELECT DISTINCT MOTIVO FROM resultadosdegestion where estado='1' ORDER BY MOTIVO");
                                                while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                                                    echo '<option value="' . $row["MOTIVO"] . '">' . $row["MOTIVO"] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-md-4">
                                        <label class="text-light-blue">Submotivo de la llamada</label>
                                        <select id="txtSubmotivoLlamada" name="txtSubmotivoLlamada" class="form-control" required>
                                            <option></option>
                                        </select>
                                    </div>
                                    <div class="col-xs-5 col-md-5">
                                        <div class="divTableCell"><label class="text-light-blue">Observaciones de la llamada</label></div>
                                        <div class="divTableCell">
                                            <textarea class="form-control input-sm" id="txtObservaciones" name="txtObservaciones" rows="2" maxlength="500"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!---------------------------------------------------------BLOQUE E---------------------------------------------------->
                            <div class="col-xs-12 text-center box box-widget bg-gray-light"><br><b class="text-center">BLOQUE E - Estado del cliente</b></div>
                            <div class="divTable text-center">
                                <div class="divTableBody">
                                    <div class="col-xs-3 col-md-3"></div>
                                    <div class="col-xs-2 col-md-2"><label class="text-light-blue">Estado del cliente</label></div>
                                    <div class="col-xs-4 col-md-4">
                                        <select id="txtEstadoCliente" name="txtEstadoCliente" class="form-control" required>
                                            <option value=""></option>
                                            <option>Positivo</option>
                                            <option>Negativo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="encuestaOscus" class="">
                                <div class="col-xs-12 text-center box box-widget bg-gray-light"><br><b class="text-center">Medición Oscus</b></div>
                                <div class="divTableBody">
                                    <div class="col-xs-2 col-md-2"><label class="text-light-blue">Estado de la encuesta</label></div>
                                    <div class="col-xs-3 col-md-3">
                                        <select id="txtEstadoEncuesta" name="txtEstadoEncuesta" class="form-control" required>
                                            <option value=""></option>
                                            <option>Realizada Exitosamente</option>
                                            <option>No aplica</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-2 col-md-2"><label class="text-light-blue">Observaciones</label></div>
                                    <div class="col-xs-5 col-md-5">
                                        <input type="text" class="form-control input-sm" id="txtObservacionesEncuesta" name="txtObservacionesEncuesta" maxlength="500"/>
                                    </div>
                                </div>
                            </div>
                            <div id="pnlEncuestaOscus">
                                <!---------------------------------------------------------Medición Oscus---------------------------------------------------->
                                <div class="col-xs-12 text-center box box-widget bg-gray-light"><br><b class="text-center">Indicadores de experiencia</b></div>
                                <div class=" col-xs-12 col-md-12 text-center"><label class="text-light-blue">En la escala de 1 a 5 donde, donde 1 es “Muy Insatisfecho” y 5 “Muy Satisfecho”, por favor califique</label></div>
                                <div class="divTable">                                            
                                    <div class="divTableBody">
                                        <div class="col-xs-9"><input id="pregunta1" name="pregunta1" class="text-bold form-control text-light-blue" value="1. ¿Qué tan satisfecho se encuentra con el servicio brindado en el Contact Center de OSCUS?" readonly/></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta1" name="respuesta1" class="form-control">
                                                <option value=""></option>
                                                <option >1</option>
                                                <option >2</option>
                                                <option >3</option>
                                                <option >4</option>
                                                <option >5</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-6 col-md-6"><input id="pregunta2" name="pregunta2" class="text-bold form-control text-light-blue" value="¿Por qué seleccionó esa alternativa?" readonly/></div>
                                        <div class="col-xs-6 col-md-6">
                                            <div class="divTableCell">
                                                <input type="text" class="form-control input-sm" id="respuesta2" name="respuesta2"/>
                                            </div>
                                        </div>
                                        <div class="col-xs-9 col-md-9"><textarea id="pregunta3" name="pregunta3" class="text-bold form-control text-light-blue" readonly>2. En escala de 0 a 5 ¿en qué grado recomendaría OSCUS a un familiar, amigo o colega de trabajo?, siendo 0 definitivamente no recomendaría y 5 definitivamente sí lo recomendaría.</textarea></div>
                                        <div class="col-xs-3 col-md-3">
                                            <select id="respuesta3" name="respuesta3" class="form-control" required>
                                                <option value=""></option>
                                                <option>0</option>
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-6 col-md-6"><input id="pregunta4" name="pregunta4" class="text-bold form-control text-light-blue" readonly/></div>
                                        <div class="col-xs-6 col-md-6">
                                            <input type="text" class="form-control input-sm" id="respuesta4" name="respuesta4"/>
                                        </div>
                                        <div class="col-xs-9 col-md-9"><textarea id="pregunta5" name="pregunta5" class="text-bold form-control text-light-blue" readonly>3. En una escala de 1 a 5 en donde 1 es más fácil y 5 el más difícil, califique: su nivel de dificultad o facilidad de contacto con el Call Center de OSCUS.</textarea></div>
                                        <div class="col-xs-3 col-md-3">
                                            <select id="respuesta5" name="respuesta5" class="form-control" required>
                                                <option value=""></option>
                                                <option>Muy Fácil</option>
                                                <option>Fácil</option>
                                                <option>Poco fácil</option>
                                                <option>Difícil</option>
                                                <option>Muy difícil</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-6 col-md-6"><input id="pregunta6" name="pregunta6" class="text-bold form-control text-light-blue" value="¿Por qué seleccionó esa alternativa?" readonly/></div>
                                        <div class="col-xs-6 col-md-6">
                                            <div class="divTableCell">
                                                <input type="text" class="form-control input-sm" id="respuesta6" name="respuesta6"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 text-center box box-widget bg-gray-light"><br><b class="text-center">Indicadores CHURN INDICATOR</b></div>
                                <div class="divTable">                                            
                                    <div class="divTableBody">
                                        <div class="col-xs-9 col-md-9"><textarea id="pregunta7" name="pregunta7" class="text-bold form-control text-light-blue" readonly>4. Si su experiencia con OSCUS se mantiene igual a la que ha tenido hasta ahora, consideraría seguir con nosotros, por cuánto tiempo más</textarea></div>
                                        <div class="col-xs-3 col-md-3">
                                            <select id="respuesta7" name="respuesta7" class="form-control" required>
                                                <option value=""></option>
                                                <option>De 3 a 5 años</option>
                                                <option>De 1 a 3 años</option>
                                                <option>Hasta 1 año</option>
                                                <option>No quiero seguir</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-6 col-md-6"><input id="pregunta8" name="pregunta8" class="text-bold form-control text-light-blue" value="¿Por qué seleccionó esa alternativa?" readonly/></div>
                                        <div class="col-xs-6 col-md-6">
                                            <input type="text" class="form-control input-sm" id="respuesta8" name="respuesta8"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 text-center">
                        <button class="btn btn-info" id="btnNuevaGestion" type="button" value="Nueva Gestión" onclick="nuevaGestion()"><i class="fa fa-rotate-left"></i> Nueva Gestión</button>
                        <button class="btn btn-success btn-sm" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar Gestión</button>
                        <button class="btn btn-danger btn-sm" onclick="cancelar_formulario()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar Gestión</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<?php require 'footer.php'; ?>
<script src="scripts/campanasInbound.js" type="text/javascript"></script>
<script src="scripts/funcions.js" type="text/javascript"></script>