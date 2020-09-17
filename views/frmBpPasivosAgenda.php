<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <label id="titulo2" class="h4 text-bold text-red">&nbsp;</label>
                        <label id="titulo" class="h4 text-bold">Campaña Banco Pichincha Pasivos</label>
                        <label id="titulo1" class="h4 text-bold text-red"></label>
                    </div>
                    <div class="panel-body table-responsive" id="listadoRegistros">
                        <table id="tblListado" class="table table-condensed table-hover table-responsive">
                            <thead>
                            <th>Num</th>
                            <th>Campaña</th>
                            <th>ImportId</th>
                            <th>Asesor</th>
                            <th>Código Campaña</th>
                            <th>Nombre Campaña</th>
                            <th>Identificacion</th>
                            <th>Nombres</th>
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
                            </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioRegistros">
                        <form name="formulario" id="formulario" method="POST" class="">
                            <div id="formularioRegistros">
                                <div class="col-md-12">
                                    <div class="box box-widget bg-gray-light">
                                        <div class="box-header with-border bg-gray">
                                            <div class="row col-xs-1 text-left"> <span class="text-bold">Última gestión:</span> </div>
                                            <div class="row col-xs-5 text-left">
                                                <input type="text" class="form-control input-sm" id="last" name="last" readonly/> </div>
                                            <div class="col-xs-1 text-left"> <span class="text-bold">Asesor/a:</span> </div>
                                            <div class="col-xs-2 text-left"> <span class="text-right"> <?php echo($_SESSION['name']); ?> </span> </div>
                                            <div class="col-xs-1 text-left"> <span class="text-bold">Fecha:</span> </div>
                                            <div class="col-xs-2 text-left"> <span id="mostrarHora" class="text-right"></span> </div>
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
                                                    <div class=" col-xs-3">
                                                        <select class="form-control input-sm" id="level1" name="level1" required>
                                                            <option></option>
                                                        </select>
                                                    </div>
                                                    <div class=" col-xs-3">
                                                        <select class="form-control input-sm" id="level2" name="level2" required>
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
                                                    <div class="col-xs-2">
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
                                                    <div class=" col-xs-2 text-left"> <b class="text-bold text-left text-bold">Fecha Agendamiento </b> </div>
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
                            </div>
                            <div id="pnlProductos">
                                <div class="col-md-12">
                                    <div class="box box-widget bg-gray">
                                        <div class="box-body">
                                            <div class="row1">
                                                <div class="col-xs-2">
                                                    <input type="text" class="form-control input-sm hidden" readonly/> <b class="text-bold">Desea otro producto: &nbsp; </b> </div>
                                                <div class="col-xs-1">
                                                    <select class="form-control input-sm" id="producto" name="producto">
                                                        <option></option>
                                                        <option>SI</option>
                                                        <option>NO</option>
                                                    </select>
                                                </div>
                                                <div class="col-xs-2">
                                                    <select class="form-control input-sm" id="listadoProd" name="listadoProd" disabled>
                                                        <option></option>
                                                        <option>TARJETA DE CREDITO PRINCIPAL</option>
                                                        <option>TARJETA DE CREDITO ADICIONAL</option>
                                                        <option>CREDITO PRECISO</option>
                                                        <option>CREDITO VEHICULAR</option>
                                                        <option>CREDITO MICROFINANZAS</option>
                                                        <option>CREDITO LINEA ABIERTA HIPOTECARIA</option>
                                                        <option>CREDITO HABITAR</option>
                                                        <option>CREDITO EDUCATIVO</option>
                                                        <option>ASISTENCIA</option>
                                                        <option>CUENTA DE AHORRO/CORRIENTE</option>
                                                        <option>AHORRO FUTURO</option>
                                                        <option>INVERSION POLIZA</option>
                                                        <option>TARJETA DE DEBITO</option>
                                                        <option>OTROS</option>
                                                    </select>
                                                </div>
                                                <div class="col-xs-3">
                                                    <input type="text" class="form-control input-sm" id="otroProd" name="otroProd" readonly/> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="pnlBonos1" class="col-xs-12 btn">
                                <div class="box box-widget bg-gray">
                                    <div class="box-body">
                                        <fieldset class="">
                                            <p><b>Crédito, Tarjeta de Crédito y Ahorro</b></p>
                                            <div class="col-xs-4"><br></div>
                                            <div class="col-xs-4">
                                                <b class="text-bold">Ingrese Monto Variable: </b> <br>
                                                <input type="text" onkeypress="return onlyNumbers(event)" class="form-control input-sm" id="txtMontoIncremento1" name="txtMontoIncremento1"> 
                                            </div>
<!--                                            <div class="col-xs-3">
                                                <b class="text-bold">Seleccione al bono que accede: </b> <br>
                                                <select class="form-control" id="cmbBono1" name="cmbBono1">
                                                    <option></option>
                                                </select>
                                            </div>-->
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                            <div id="pnlBonos2" class="col-xs-12 btn">
                                <div class="box box-widget bg-gray">
                                    <div class="box-body">
                                        <fieldset class="">
                                            <p><b>Ahorro Futuro Vigente</b></p>
                                            <div class="col-xs-4"><br></div>
                                            <div class="col-xs-4">
                                                <b class="text-bold">Ingrese Monto Variable Ahorro Futuro: </b> <br>
                                                <input type="text" onkeypress="return onlyNumbers(event)" class="form-control input-sm" id="txtMontoIncremento2" name="txtMontoIncremento2"> 
                                            </div>
<!--                                            <div class="col-xs-3">
                                                <b class="text-bold">Seleccione al bono que accede: </b> <br>
                                                <select class="form-control" id="cmbBono2" name="cmbBono2">
                                                    <option></option>
                                                </select>
                                            </div>-->
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                            <div id="pnlApertura" class="col-xs-12 btn">
                                <div class="box box-widget bg-gray">
                                    <div class="box-body">
                                        <div class="col-xs-3">
                                            <b class="text-bold">Ingrese teléfono: </b> <br>
                                            <input type="text" onkeypress="return onlyNumbers(event)" class="form-control input-sm" id="txtTelefono" name="txtTelefono"> 
                                        </div>
                                        <div class="col-xs-3">
                                            <b class="text-bold">Ingrese Correo: </b> <br>
                                            <input type="email" class="form-control input-sm" id="txtCorreo" name="txtCorreo"> 
                                        </div>
                                        <div class="col-xs-3">
                                            <b class="text-bold">Ingrese Monto Ahorro Futuro: </b> <br>
                                            <input type="text" onkeypress="return onlyNumbers(event)" class="form-control input-sm" id="txtMonto" name="txtMonto"> 
                                        </div>
                                        <div class="col-xs-3">
                                            <b class="text-bold">Ingrese Ciudad: </b> <br>
                                            <input type="text" class="form-control input-sm" id="txtCiudad" name="txtCiudad"> 
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="index">
                                <div class="col-xs-2 hidden"> <b class="text-bold text-aqua">CAMPANIA </b>
                                    <input type="text" class="form-control input-sm" id="code" name="code" readonly/>
                                    <input type="text" class="form-control input-sm" id="CAMPANIA" name="CAMPANIA" readonly/> </div>
                                <div class="col-xs-2 hidden"> <b class="text-bold text-aqua">ID </b>
                                    <input type="text" class="form-control input-sm" id="IDC" name="IDC" readonly/> </div>
                                <div class="col-xs-2"> <b class="text-bold text-aqua">CODIGO_CAMPANIA </b>
                                    <input type="text" class="form-control input-sm" id="CODIGO_CAMPANIA" name="CODIGO_CAMPANIA" readonly/> </div>
                                <div class="col-xs-4"> <b class="text-bold text-aqua">NOMBRE_CAMPANIA </b>
                                    <input type="text" class="form-control input-sm" id="NOMBRE_CAMPANIA" name="NOMBRE_CAMPANIA" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">IDENTIFICACION </b>
                                    <input type="text" class="form-control input-sm" id="IDENTIFICACION" name="IDENTIFICACION" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">NOMBRE </b>
                                    <input type="text" class="form-control input-sm" id="NOMBRE_CLIENTE" name="NOMBRE_CLIENTE" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">ZONA </b>
                                    <input type="text" class="form-control input-sm" id="ZONA" name="ZONA" readonly/> </div>
                                <div class="col-xs-2"> <b class="text-bold text-aqua">REGION </b>
                                    <input type="text" class="form-control input-sm" id="REGION" name="REGION" readonly/> </div>
                                <div class="col-xs-2"> <b class="text-bold text-aqua">SUBSEGMENTO </b>
                                    <input type="text" class="form-control input-sm" id="SUBSEGMENTO" name="SUBSEGMENTO" readonly/> </div>
                                <div class="col-xs-2"> <b class="text-bold text-aqua">OFERTA </b>
                                    <input type="text" class="form-control input-sm" id="OFERTA" name="OFERTA" readonly/> </div>
                                <div class="col-xs-2"> <b class="text-bold text-aqua">TIENE CTA AHO FUT </b>
                                    <input type="text" class="form-control input-sm" id="TIENE_AHORRO_FUTURO" name="TIENE_AHORRO_FUTURO" readonly/> </div>
                                <div class="col-xs-1"> <b class="text-bold text-aqua">RANGO </b>
                                    <input type="text" class="form-control input-sm" id="RANGO" name="RANGO" readonly/> </div>
                                <div class="col-xs-2"> <b class="text-bold text-aqua">GRUPO </b>
                                    <input type="text" class="form-control input-sm" id="GRUPO" name="GRUPO" readonly/> </div>
                                <div class="col-xs-3 hidden"> <b class="text-bold text-aqua">PREMIO_AL_FINAL_DEL_3ER_MES1 </b>
                                    <input type="text" class="form-control input-sm" id="PREMIO_AL_FINAL_DEL_3ER_MES1" name="PREMIO_AL_FINAL_DEL_3ER_MES1" readonly/> </div>                                
                                <div class="col-xs-1 hidden"> <b class="text-bold text-aqua">CUOTA_BP </b>
                                    <input type="text" class="form-control input-sm" id="CUOTA_BP" name="CUOTA_BP" readonly/> </div>
                                <div class="col-xs-2"> <b class="text-bold text-red">OFERTA 1 </b>
                                    <input type="text" class="form-control input-sm" id="INCREMENTAL_EN_PASIVOS" name="INCREMENTAL_EN_PASIVOS" readonly/> </div>
                                <div class="col-xs-2"> <b class="text-bold text-red">BONO 1 </b>
                                    <input type="text" class="form-control input-sm" id="PREMIO_AL_FINAL_DEL_3ER_MES2" name="PREMIO_AL_FINAL_DEL_3ER_MES2" readonly/> </div>
                                <div class="col-xs-2"> <b class="text-bold text-black">OFERTA 2 </b>
                                    <input type="text" class="form-control input-sm" id="CONDICION_APORTE_MENSUAL_AHO_FUT" name="CONDICION_APORTE_MENSUAL_AHO_FUT" readonly/> </div>
                                <div class="col-xs-2"> <b class="text-bold text-black">BONO 2 </b>
                                    <input type="text" class="form-control input-sm" id="TASA_BENEFICIO_ADICIONAL_AHO_FUT" name="TASA_BENEFICIO_ADICIONAL_AHO_FUT" readonly/> </div>
                                <div class="col-xs-2"> <b class="text-bold text-aqua">TIPO_TARJETA_MILLAS </b>
                                    <input type="text" class="form-control input-sm" id="TIPO_TARJETA_MILLAS" name="TIPO_TARJETA_MILLAS" readonly/> </div>
                                <div class="col-xs-2"> <b class="text-bold text-aqua">PRODUCTO_PREMIO </b>
                                    <input type="text" class="form-control input-sm" id="PRODUCTO_PREMIO" name="PRODUCTO_PREMIO" readonly/> </div>
                                <div class="col-xs-2"> <b class="text-bold text-aqua">AGENCIA </b>
                                    <input type="text" class="form-control input-sm" id="AGENCIA" name="AGENCIA" readonly/> </div>
                                <div class="col-xs-2"> <b class="text-bold text-aqua">PROVINCIA_DOMICILIO </b>
                                    <input type="text" class="form-control input-sm" id="PROVINCIA_DOMICILIO" name="PROVINCIA_DOMICILIO" readonly/> </div>
                                <div class="col-xs-2"> <b class="text-bold text-aqua">CIUDAD_DOMICILIO </b>
                                    <input type="text" class="form-control input-sm" id="CIUDAD_DOMICILIO" name="CIUDAD_DOMICILIO" readonly/> </div>
                                <div class="col-xs-4"> <b class="text-bold text-aqua">DIRECCION_DOMICILIO </b>
                                    <input type="text" class="form-control input-sm" id="DIRECCION_DOMICILIO" name="DIRECCION_DOMICILIO" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">PROVINCIA_TRABAJO </b>
                                    <input type="text" class="form-control input-sm" id="PROVINCIA_TRABAJO" name="PROVINCIA_TRABAJO" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">CIUDAD_TRABAJO </b>
                                    <input type="text" class="form-control input-sm" id="CIUDAD_TRABAJO" name="CIUDAD_TRABAJO" readonly/> </div>
                                <div class="col-xs-6"> <b class="text-bold text-aqua">DIRECCION_TRABAJO </b>
                                    <input type="text" class="form-control input-sm" id="DIRECCION_TRABAJO" name="DIRECCION_TRABAJO" readonly/> </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </section>
</div>
<?php require 'footer.php'; ?>
<script src="scripts/bpPasivosAgendas.js" type="text/javascript"></script>
<script src="scripts/funcions.js" type="text/javascript"></script>