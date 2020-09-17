<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <label id="titulo2" class="h4 text-bold text-red">&nbsp;</label>
                        <label id="titulo" class="h4 text-bold">Campañas Banco Pichincha</label>
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
                                                <input type="text" class="form-control input-sm" id="last1" name="last1" readonly/> </div>
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
                                                        </select>
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <button type="button" class="btn btn-info btn-sm" id="btnFonos" name="btnFonos"><i class="fa fa-save"></i> Guardar Teléfono</button>
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
                                                    <div class="col-xs-1 hidden">
                                                        <input type="text" class="form-control input-sm" id="intentos" name="intentos" readonly/> </div>
                                                </div>
                                                <div class="col-xs-12">
                                                    <br>
                                                </div>
                                                <!-- <div class="col-xs-2"> <br><input type="checkbox" id="cbox1" name="cbox1" value=""> <label for="cbox1">&nbsp; Ver/Ocultar Ofertas</label> </div>-->
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
                            <div id="verOfertas" class="btn col-xs-12">
                                <div class="box box-widget bg-gray">
                                    <div class="box-header with-border">
                                        <div class="col-xs-1"></div>
                                        <div class="col-xs-2">
                                            <input name="ofertaBp" id="oferta1" type="radio" /> </div>
                                        <div class="col-xs-2">
                                            <input name="ofertaBp" id="oferta2" type="radio" /> </div>
                                        <div class="col-xs-2">
                                            <input name="ofertaBp" id="oferta3" type="radio" /> </div>
                                        <div class="col-xs-2">
                                            <input name="ofertaBp" id="oferta4" type="radio" /> </div>
                                        <div class="col-xs-2">
                                            <input name="ofertaBp" id="oferta5" type="radio" /> </div>
                                        <div class="col-xs-1"></div>
                                        <div class="box-tools">
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <input id="of" name="of" class="form-control input-sm hidden" />
                                        <input id="tip" name="tip" class="form-control input-sm hidden" />
                                        <div class="col-xs-12">
                                            <div class="col-xs-1"></div>
                                            <div class="col-xs-2"> <b>CREDITO_CONSUMO </b>
                                                <input type="text" class="form-control input-sm" id="CREDITO_CONSUMO_ESCENARIO_1" name="CREDITO_CONSUMO_ESCENARIO_1" readonly/> </div>
                                            <div class="col-xs-2"> <b>TARJETA </b>
                                                <input type="text" class="form-control input-sm" id="TARJETA_ESCENARIO_1" name="TARJETA_ESCENARIO_1" readonly/> </div>
                                            <div class="col-xs-2"> <b>CONSUMO EXCLUSIVO </b>
                                                <input type="text" class="form-control input-sm" id="CREDITO_CONSUMO_EXCLUSIVO" name="CREDITO_CONSUMO_EXCLUSIVO" readonly/> </div>
                                            <div class="col-xs-2"> <b>TARJETA EXCLUSIVA </b>
                                                <input type="text" class="form-control input-sm" id="TARJETA_EXCLUSIVA" name="TARJETA_EXCLUSIVA" readonly/> </div>
                                            <div class="col-xs-2"> <b>CONSUMO ROL </b>
                                                <input type="text" class="form-control input-sm" id="CREDITO_CONSUMO_ROL" name="CREDITO_CONSUMO_ROL" readonly/> </div>
                                            <div class="col-xs-1"></div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="col-xs-1"></div>
                                            <div class="col-xs-2"> <b>CUOTA CONSUMO </b>
                                                <input type="text" class="form-control input-sm" id="CUOTA_CONSUMO_ESCENARIO_1" name="CUOTA_CONSUMO_ESCENARIO_1" readonly/> </div>
                                            <div class="col-xs-2"> <b>PLASTICO TARJETA </b>
                                                <input type="text" class="form-control input-sm" id="PLASTICO_1_TARJETA_ESCENARIO_1" name="PLASTICO_1_TARJETA_ESCENARIO_1" readonly/> </div>
                                            <div class="col-xs-2"> <b>CUOTA EXCLUSIVO </b>
                                                <input type="text" class="form-control input-sm" id="CUOTA_CONSUMO_EXCLUSIVO" name="CUOTA_CONSUMO_EXCLUSIVO" readonly/> </div>
                                            <div class="col-xs-2"> <b>PLASTICO EXCLUSIVA </b>
                                                <input type="text" class="form-control input-sm" id="PLASTICO_1_TARJETA_EXCLUSIVA" name="PLASTICO_1_TARJETA_EXCLUSIVA" readonly/> </div>
                                            <div class="col-xs-2"> <b>CUOTA CONSUMO ROL </b>
                                                <input type="text" class="form-control input-sm" id="CUOTA_CONSUMO_ROL" name="CUOTA_CONSUMO_ROL" readonly/> </div>
                                            <div class="col-xs-1"></div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="col-xs-1"></div>
                                            <div class="col-xs-2"> <b>PLAZO CONSUMO </b>
                                                <input type="text" class="form-control input-sm" id="PLAZO_CONSUMO_ESCENARIO_1" name="PLAZO_CONSUMO_ESCENARIO_1" readonly/> </div>
                                            <div class="col-xs-2"> <b>MARCA </b>
                                                <input type="text" class="form-control input-sm" id="MARCA_ESCENARIO_1" name="MARCA_ESCENARIO_1" readonly/> </div>
                                            <div class="col-xs-2"> <b>PLAZO EXCLUSIVO </b>
                                                <input type="text" class="form-control input-sm" id="PLAZO_CONSUMO_EXCLUSIVO" name="PLAZO_CONSUMO_EXCLUSIVO" readonly/> </div>
                                            <div class="col-xs-2"> <b>MARCA EXCLUSIVA </b>
                                                <input type="text" class="form-control input-sm" id="MARCA_TARJETA_EXCLUSIVA" name="MARCA_TARJETA_EXCLUSIVA" readonly/> </div>
                                            <div class="col-xs-2"> <b>PLAZO CONSUMO ROL </b>
                                                <input type="text" class="form-control input-sm" id="PLAZO_CONSUMO_ROL" name="PLAZO_CONSUMO_EXCLUSIVO" readonly/> </div>
                                            <div class="col-xs-1"></div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="col-xs-1"></div>
                                            <div class="col-xs-2"> <b>GARANTE CONSUMO </b>
                                                <input type="text" class="form-control input-sm" id="GARANTE_CONSUMO_ESCENARIO_1" name="GARANTE_CONSUMO_ESCENARIO_1" readonly/> </div>
                                            <div class="col-xs-2"> <b>PRODUCTO </b>
                                                <input type="text" class="form-control input-sm" id="PRODUCTO_ESCENARIO_1" name="PRODUCTO_ESCENARIO_1" readonly/> </div>
                                            <div class="col-xs-2"> <b>GARANTE EXCLUSIVO </b>
                                                <input type="text" class="form-control input-sm" id="GARANTE_CONSUMO_EXCLUSIVO" name="GARANTE_CONSUMO_EXCLUSIVO" readonly/> </div>
                                            <div class="col-xs-2"> <b>PRODUCTO EXCLUSIVA </b>
                                                <input type="text" class="form-control input-sm" id="PRODUCTO_TARJETA_EXCLUSIVA" name="PRODUCTO_TARJETA_EXCLUSIVA" readonly/> </div>
                                            <div class="col-xs-2"> <b>GARANTE CONS ROL </b>
                                                <input type="text" class="form-control input-sm" id="GARANTE_CONSUMO_ROL" name="GARANTE_CONSUMO_ROL" readonly/> </div>
                                            <div class="col-xs-1"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="Creditos" class="col-xs-12 btn">
                                <div class="box box-widget bg-gray">
                                    <div class="box-header with-border">
                                        <div id="tipoCredito" class="col-xs-12">
                                            <div class="col-xs-6">
                                                <input name="opccredito" id="vAgencia" type="radio" />
                                                <label class="text-bold">&nbsp; Visita Agencia </label>
                                            </div>
                                            <div class="col-xs-6">
                                                <input name="opccredito" id="fvt" type="radio" />
                                                <label class="text-bold">&nbsp; FTV </label>
                                            </div>
                                        </div>
                                        <div class="box-tools">
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <div id="pnlFvt" class="row">
                                            <div class="col-xs-1"> <b class="text-bold">Teléfono </b> </div>
                                            <div class="col-xs-2" id="telfFvt">
                                                <input pattern="^0[2-9](\d{7,8})$" type="text" onkeypress="return onlyNumbers(event)" id="tlfFvt" name="tlfFvt" class="form-control input-sm" /> </div>
                                            <div class="col-xs-1"> <b class="text-bold">Dirección </b> </div>
                                            <div class="col-xs-8" id="dirFvt">
                                                <input type="text" id="direccionFvt" name="direccionFvt" class="form-control input-sm" /> </div>
                                        </div>
                                        <div class="row" id="infoAgencia">
                                            <div class="col-xs-2">
                                                <b class="text-bold">Monto del cliente</b> 
                                                <input type="number" class="form-control input-sm" id="txtMonto" name="txtMonto" /> </div>
                                            <div class="col-xs-2">
                                                <b class="text-bold">Fecha Visita </b>
                                                <input type="date" class="form-control input-sm" id="fechaV" name="fechaV" /> </div>
                                            <div class="col-xs-2">
                                                <b class="text-bold">Hora Visita </b>
                                                <input type="time" class="form-control input-sm" id="horaV" name="horaV" /> </div>
                                            <div class="col-xs-2">
                                                <b class="text-bold">Tipo cliente </b>
                                                <select class="form-control input-sm" id="tipoC" name="tipoC">
                                                    <option></option>
                                                    <option>Dependiente</option>
                                                    <option>Independiente</option>
                                                </select>
                                            </div>
                                            <div class="col-xs-2">
                                                <b class="text-bold">Region </b>
                                                <select class="form-control input-sm" id="regionC" name="regionC">
                                                    <option></option>
                                                    <?php
                                                    require '../config/connection.php';
                                                    $result = ejecutarConsulta1("SELECT distinct(regional) 'regional' FROM cat_agencias ORDER BY regional");
                                                    while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                                                        echo '<option value="' . $row["regional"] . '">' . $row["regional"] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-xs-2">
                                                <b class="text-bold">Ciudad </b>
                                                <select class="form-control input-sm" id="ciudadC" name="ciudadC">
                                                    <option></option>
                                                </select>
                                            </div>
                                            <div class="col-xs-12">
                                                <br>
                                            </div>
                                            <div class="col-xs-2">
                                                <b class="text-bold">Tipo Oficina </b> 
                                                <select class="form-control input-sm" id="tipoOfC" name="tipoOfC">
                                                    <option></option>
                                                    <?php
                                                    require '../config/connection.php';
                                                    $result = ejecutarConsulta1("SELECT distinct(tipooficina) 'tipooficina' FROM cat_agencias ORDER BY tipooficina");
                                                    while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                                                        echo '<option value="' . $row["tipooficina"] . '">' . $row["tipooficina"] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-xs-2">
                                                <b class="text-bold">Agencia </b>
                                                <select class="form-control input-sm" id="agenciaC" name="agenciaC">
                                                    <option></option>
                                                </select>
                                            </div>
                                            <div class="col-xs-2" id="telf1"> </div>
                                            <div class="col-xs-2" id="telf2">
                                                <b class="text-bold">Teléfono </b> 
                                                <input type="text" onkeypress="return onlyNumbers(event)" id="tlfC" name="tlfC" class="form-control input-sm" readonly/>
                                            </div>
                                            <div class="col-xs-2" id="horario1"></div>
                                            <div class="col-xs-2" id="horario2">
                                                <b class="text-bold">Horario </b>
                                                <input type="text" id="horarioC" name="horarioC" class="form-control input-sm" readonly/>
                                            </div>
                                            <div class="col-xs-4" id="dir1"></div>
                                            <div class="col-xs-4" id="dir2">
                                                <b class="text-bold">Dirección </b>
                                                <input type="text" id="direccionC" name="direccionC" class="form-control input-sm" readonly/>
                                            </div>
                                        </div>
                                        <div id="espAsistencia" class="col-xs-12">
                                            <br>
                                        </div>
                                        <div id="pnlAsistencia" class="col-xs-12">
                                            <div class="col-xs-2">
                                                <input type="text" id="acepta" name="acepta" class="form-control input-sm hidden" readonly/> <b class="text-bold">Desea asistencia: &nbsp; </b> </div>
                                            <div class="col-xs-1">
                                                <select class="form-control input-sm" id="asistencia" name="asistencia">
                                                    <option></option>
                                                    <option>SI</option>
                                                    <option>NO</option>
                                                </select>
                                            </div>
                                            <div class="col-xs-4"> <b class="text-bold">Seleccione el motivo por el cual no desea la oferta: &nbsp; </b> </div>
                                            <div class="col-xs-2">
                                                <select class="form-control input-sm" id="subestatus1" name="subestatus1">
                                                    <option></option>
                                                    <option>CU5 NO DESEA PRODUCTO</option>
                                                    <option>CU6 NO CUMPLE REQUISITOS</option>
                                                    <option>CU7 YA TOMO EL PRODUCTO</option>
                                                </select>
                                            </div>
                                            <div class="col-xs-3">
                                                <select class="form-control input-sm" id="subestatus2" name="subestatus2">
                                                    <option></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="tcPrincipal" class="btn col-xs-12">
                                <div class="box box-widget bg-gray">
                                    <div class="box-header with-border"> <b class="text-uppercase">Tarjeta de Crédito Principal - Datos del cliente</b>
                                        <div class="box-tools">
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <div class="col-xs-3 hidden"> <b>oferta </b>
                                            <input type="text" class="form-control input-sm" id="ofertaTDC" name="ofertaTDC" readonly/> </div>
                                        <div class="col-xs-3 hidden"> <b>ContactId </b>
                                            <input type="text" class="form-control input-sm" id="IdTCP" name="IdTCP" readonly/> </div>
                                        <div class="col-xs-3 hidden"> <b>PROD_ESCENARIO_1 </b>
                                            <input type="text" class="form-control input-sm" id="PROD_ESCENARIO_1" name="PROD_ESCENARIO_1" readonly/> </div>
                                        <div class="col-xs-3 hidden"> <b>PROD_TARJETA_EXCLUSIVA </b>
                                            <input type="text" class="form-control input-sm" id="PROD_TARJETA_EXCLUSIVA" name="PROD_TARJETA_EXCLUSIVA" readonly/> </div>
                                        <div class="col-xs-2"> <b>Identificación </b>
                                            <input type="text" class="form-control input-sm" id="IDENTIFICACIONTCP" name="IDENTIFICACIONTCP" readonly/> </div>
                                        <div class="col-xs-2"> <b>Primer Nombre </b>
                                            <input onkeypress="this.value = this.value.toUpperCase(); return onlyLetters(event)" type="text" class="form-control input-sm" id="NOMBRE1TCP" name="NOMBRE1TCP" /> </div>
                                        <div class="col-xs-2"> <b>Segundo Nombre </b>
                                            <input onkeypress="this.value = this.value.toUpperCase(); return onlyLetters(event)" type="text" class="form-control input-sm" id="NOMBRE2TCP" name="NOMBRE2TCP" /> </div>
                                        <div class="col-xs-2"> <b>Primer Apellido </b>
                                            <input onkeypress="this.value = this.value.toUpperCase(); return onlyLetters(event)" type="text" class="form-control input-sm" id="APELLIDO1TCP" name="APELLIDO1TCP" /> </div>
                                        <div class="col-xs-2"> <b>Segundo Apellido </b>
                                            <input onkeypress="this.value = this.value.toUpperCase(); return onlyLetters(event)" type="text" class="form-control input-sm" id="APELLIDO2TCP" name="APELLIDO2TCP" /> </div>
                                        <div class="col-xs-2"> <b>Provincia Nacimiento </b>
                                            <select class="form-control input-sm" id="provinciaNacTCP" name="provinciaNacTCP">
                                                <option></option>
                                                <?php
                                                require '../config/connection.php';
                                                $result = ejecutarConsulta1("SELECT id, Provincia FROM cat_provincias ORDER BY Provincia");
                                                while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                                                    echo '<option value="' . $row["id"] . '">' . $row["Provincia"] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-xs-2"> <b>Ciudad Nacimiento </b>
                                            <select class="form-control input-sm" id="ciudadNacTCP" name="ciudadNacTCP">
                                                <option></option>
                                            </select>
                                        </div>
                                        <div class="col-xs-2"> <b>Estado Civil </b>
                                            <select class="form-control input-sm" id="estadoCivilTCP" name="estadoCivilTCP">
                                                <option></option>
                                                <option>SOLTERO</option>
                                                <option>CASADO</option>
                                                <option>VIUDO</option>
                                                <option>DIVORCIADO</option>
                                                <option>UNION DE HECHO</option>
                                                <option>UNION LEGALIZADA</option>
                                                <option>UNION LIBRE</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-2"> <b>Género </b>
                                            <select class="form-control input-sm" id="generoTCP" name="generoTCP">
                                                <option></option>
                                                <option>FEMENINO</option>
                                                <option>MASCULINO</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-2"> <b>Fecha Nacimiento </b>
                                            <input type="text" class="form-control input-sm" id="fecNacTCP" name="fecNacTCP" /> </div>
                                        <div class="col-xs-1"> <b>Edad </b>
                                            <input type="text" class="form-control input-sm" id="edadTCP" name="edadTCP" readonly/> </div>
                                        <div class="col-xs-3"> <b>Email Personal </b>
                                            <input type="text" class="form-control input-sm" id="emailTCP" name="emailTCP" /> </div>
                                        <div class="col-xs-2"> <b class="text-bold">Plan deuda protegida </b>
                                            <select class="form-control input-sm" id="pdpTCP" name="pdpTCP">
                                                <option></option>
                                                <option>SI</option>
                                                <option>NO</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-2"> <b class="text-bold">Seleccione el motivo por el cual no desea el pdp </b>
                                            <select class="form-control input-sm" id="subestatus1TCP" name="subestatus1TCP">
                                                <option></option>
                                                <option>CU5 NO DESEA EL PRODUCTO</option>
                                                <option>CU6 NO CUMPLE PERFIL</option>
                                                <option>CU7 YA TOMO EL PRODUCTO</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-2">
                                            <br>
                                            <select class="form-control input-sm" id="subestatus2TCP" name="subestatus2TCP">
                                                <option></option>
                                            </select>
                                        </div>
                                        <div class="col-xs-3">
                                            <div class="col-xs-12"> <b>Celular </b> </div>
                                            <div class="col-xs-3">
                                                <input name="otroCell" id="otroCell" type="checkbox" />
                                                <label class="text-bold">&nbsp; otro </label>
                                            </div>
                                            <div id="selectCell" class="col-xs-9">
                                                <select class="form-control input-sm" id="celularTextTCP" name="celularTextTCP">
                                                    <option></option>
                                                </select>
                                            </div>
                                            <div id="textCell" class="col-xs-9">
                                                <input pattern="^09(\d{8})$" onkeypress="return onlyNumbers(event)" type="text" class="form-control input-sm" id="celularTCP" name="celularTCP" /> </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <div class="col-xs-12"> <b>Teléfono </b> </div>
                                            <div class="col-xs-3">
                                                <input name="otroTelf" id="otroTelf" type="checkbox" />
                                                <label class="text-bold">&nbsp; otro </label>
                                            </div>
                                            <div id="selectTelf" class="col-xs-9">
                                                <select class="form-control input-sm" id="telfTextTCP" name="telfTextTCP">
                                                    <option></option>
                                                </select>
                                            </div>
                                            <div id="textTelf" class="col-xs-9">
                                                <input pattern="^(0[2-7])(\d{7})$" onkeypress="return onlyNumbers(event)" type="text" class="form-control input-sm" id="telfTCP" name="telfTCP" /> </div>
                                        </div>
                                        <div class="col-xs-1"> <b class="text-bold">Cupo </b>
                                            <input type="text" class="form-control input-sm" id="CUPOTCP" name="CUPOTCP" readonly/> </div>
                                        <div class="col-xs-2"> <b class="text-bold">Emisión estado cuenta </b>
                                            <select class="form-control input-sm" id="estadoctaTCP" name="estadoctaTCP">
                                                <option></option>
                                                <option>SI</option>
                                                <option>NO</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-3 hidden"> <b>Nacionalidad </b>
                                            <input value="ECUATORIANA" type="text" class="form-control input-sm" id="nacionalidadTCP" name="nacionalidadTCP" /> </div>
                                        <div class="col-xs-3" hidden> <b>País </b>
                                            <input value="ECUADOR" type="text" class="form-control input-sm" id="paisTCP" name="paisTCP" /> </div>
                                        <div class="col-xs-3" hidden> <b>Contabilidad </b>
                                            <input value="NO" type="text" class="form-control input-sm" id="contTCP" name="contTCP" /> </div>
                                        <div class="col-xs-12">
                                            <br>
                                        </div>
                                        <div class="col-xs-12"><b class="text-uppercase">Tarjeta de Crédito Principal - Datos del domicilio </b>
                                            <hr/>
                                        </div>
                                        <div class="col-xs-12">
                                            <input type="text" class="form-control input-sm" id="dirdomTCP" name="dirdomTCP" readonly/> </div>
                                        <div class="col-xs-2"> <b>Provincia domicilio </b>
                                            <select class="form-control input-sm" id="provinciaDomTCP" name="provinciaDomTCP">
                                                <option></option>
                                                <?php
                                                require '../config/connection.php';
                                                $result = ejecutarConsulta1("SELECT id,Provincia FROM cat_provincias ORDER BY Provincia");
                                                while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                                                    echo '<option value="' . $row["id"] . '">' . $row["Provincia"] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-xs-3"> <b>Ciudad domicilio </b>
                                            <select class="form-control input-sm" id="ciudadDomTCP" name="ciudadDomTCP">
                                                <option></option>
                                            </select>
                                        </div>
                                        <div class="col-xs-2"> <b>Tipo vivienda </b>
                                            <select class="form-control input-sm" id="tipoVivTCP" name="tipoVivTCP">
                                                <option></option>
                                                <option>ALQUILER</option>
                                                <option>PROPIA HIPOTECADA</option>
                                                <option>PROPIA NO HIPOTECADA</option>
                                                <option>VIVE CON FAMILIARES</option>
                                                <option>ANTICRESIS</option>
                                                <option>PRESTADA</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-2"> <b>Canton </b>
                                            <input onkeypress="this.value = this.value.replace(/[^A-Za-z0-9\s]/g, '').toUpperCase();" type="text" class="form-control input-sm" id="cantonDomTCP" name="cantonDomTCP" /> </div>
                                        <div class="col-xs-3"> <b>Parroquia </b>
                                            <input onkeypress="this.value = this.value.replace(/[^A-Za-z0-9\s]/g, '').toUpperCase();" type="text" class="form-control input-sm" id="parroquiaDomTCP" name="parroquiaDomTCP" /> </div>
                                        <div class="col-xs-3"> <b>Calle principal </b>
                                            <input onkeypress="this.value = this.value.replace(/[^A-Za-z0-9-\s]/g, '').toUpperCase();" type="text" class="form-control input-sm" id="principalDomTCP" name="principalDomTCP" /> </div>
                                        <div class="col-xs-3"> <b>Calle secundaria </b>
                                            <input onkeypress="this.value = this.value.replace(/[^A-Za-z0-9-\s]/g, '').toUpperCase();" type="text" class="form-control input-sm" id="secundariaDomTCP" name="secundariaDomTCP" /> </div>
                                        <div class="col-xs-1"> <b>Numeración </b>
                                            <input onkeypress="this.value = this.value.replace(/[^A-Za-z0-9\s]/g, '').toUpperCase();" type="text" class="form-control input-sm" id="numDomTCP" name="numDomTCP" /> </div>
                                        <div class="col-xs-2"> <b>Sector / Barrio </b>
                                            <input onkeypress="this.value = this.value.replace(/[^A-Za-z0-9-\s]/g, '').toUpperCase();" type="text" class="form-control input-sm" id="sectorDomTCP" name="sectorDomTCP" /> </div>
                                        <div class="col-xs-3"> <b>Referencia </b>
                                            <input onkeypress="this.value = this.value.replace(/[^A-Za-z0-9-\s]/g, '').toUpperCase();" type="text" class="form-control input-sm" id="refDomTCP" name="refDomTCP" /> </div>
                                        <div class="col-xs-12">
                                            <br>
                                        </div>
                                        <div class="col-xs-12"><b class="text-uppercase">Tarjeta de Crédito Principal - Datos del trabajo </b>
                                            <hr/>
                                        </div>
                                        <div class="col-xs-12">
                                            <input type="text" class="form-control input-sm" id="dirTrabTCP" name="dirTrabTCP" readonly/> </div>
                                        <div class="col-xs-3"> <b>Provincia trabajo </b>
                                            <select class="form-control input-sm" id="provinciaTrabTCP" name="provinciaTrabTCP">
                                                <option></option>
                                                <?php
                                                require '../config/connection.php';
                                                $result = ejecutarConsulta1("SELECT id, Provincia FROM cat_provincias ORDER BY Provincia");
                                                while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                                                    echo '<option value="' . $row["id"] . '">' . $row["Provincia"] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-xs-3"> <b>Ciudad trabajo </b>
                                            <select class="form-control input-sm" id="ciudadTrabTCP" name="ciudadTrabTCP">
                                                <option></option>
                                            </select>
                                        </div>
                                        <div class="col-xs-3"> <b>Canton </b>
                                            <input onkeypress="this.value = this.value.replace(/[^A-Za-z\s]/g, '').toUpperCase();" type="text" class="form-control input-sm" id="cantonTrabTCP" name="cantonTrabTCP" /> </div>
                                        <div class="col-xs-3"> <b>Parroquia </b>
                                            <input onkeypress="this.value = this.value.replace(/[^A-Za-z\s]/g, '').toUpperCase();" type="text" class="form-control input-sm" id="parroquiaTrabTCP" name="parroquiaTrabTCP" /> </div>
                                        <div class="col-xs-3"> <b>Calle principal </b>
                                            <input onkeypress="this.value = this.value.replace(/[^A-Za-z0-9-\s]/g, '').toUpperCase();" type="text" class="form-control input-sm" id="principalTrabTCP" name="principalTrabTCP" /> </div>
                                        <div class="col-xs-3"> <b>Calle secundaria </b>
                                            <input onkeypress="this.value = this.value.replace(/[^A-Za-z0-9-\s]/g, '').toUpperCase();" type="text" class="form-control input-sm" id="secundariaTrabTCP" name="secundariaTrabTCP" /> </div>
                                        <div class="col-xs-1"> <b>Numeración </b>
                                            <input onkeypress="this.value = this.value.replace(/[^A-Za-z0-9\s]/g, '').toUpperCase();" type="text" class="form-control input-sm" id="numTrabTCP" name="numTrabTCP" /> </div>
                                        <div class="col-xs-2"> <b>Sector / Barrio </b>
                                            <input onkeypress="this.value = this.value.replace(/[^A-Za-z0-9\s]/g, '').toUpperCase();" type="text" class="form-control input-sm" id="sectorTrabTCP" name="sectorTrabTCP" /> </div>
                                        <div class="col-xs-3"> <b>Referencia </b>
                                            <input type="text" class="form-control input-sm" id="refTrabTCP" name="refTrabTCP" /> </div>
                                        <div class="col-xs-3">
                                            <div class="col-xs-12"> <b>Teléfono </b> </div>
                                            <div class="col-xs-3">
                                                <input pattern="^(0[2-7])(\d{7})$" name="otroTrabTelf" id="otroTrabTelf" type="checkbox" />
                                                <label class="text-bold">&nbsp; otro </label>
                                            </div>
                                            <div id="selectTelfTrab" class="col-xs-9">
                                                <select class="form-control input-sm" id="telfTextTrabTCP" name="telfTextTrabTCP">
                                                    <option></option>
                                                </select>
                                            </div>
                                            <div id="textTelfTrab" class="col-xs-9">
                                                <input type="text" onkeypress="return onlyNumbers(event)" class="form-control input-sm" id="selectTrabTextTelf" name="selectTrabTextTelf" /> </div>
                                        </div>
                                        <!--                                        <div class="col-xs-3"> <b>Situación laboral </b>
                                                                                    <select class="form-control input-sm" id="situaLabTCP" name="situaLabTCP">
                                                                                        <option></option>
                                                                                        <option>DEPENDIENTE</option>
                                                                                        <option>INDEPENDIENTE</option>
                                                                                    </select>
                                                                                </div>-->
                                        <div id="dependiente" class="col-xs-12 input-group">
                                            <div class="col-xs-2"> <b>Nombre empresa </b>
                                                <input type="text" onkeypress="this.value = this.value.replace(/[^A-Za-z\s]/g, '').toUpperCase();" class="form-control input-sm" id="empresaTCP" name="empresaTCP" /> </div>
                                            <div class="col-xs-2"> <b>Contrato </b>
                                                <select class="form-control input-sm" id="contratoTCP" name="contratoTCP">
                                                    <option></option>
                                                    <option>FIJO</option>
                                                    <option>POR HORAS</option>
                                                    <option>POR HORAS</option>
                                                    <option>A DESTAJO CARGO</option>
                                                </select>
                                            </div>
                                            <div class="col-xs-2"> <b>Fecha inicio actividades </b>
                                                <input type="date" class="form-control input-sm" id="fechaIniTCP" name="fechaIniTCP" /> </div>
                                            <div class="col-xs-2"> <b>Cargo </b>
                                                <input type="text" onkeypress="this.value = this.value.replace(/[^A-Za-z0-9\s]/g, '').toUpperCase();" class="form-control input-sm" id="cargoTCP" name="cargoTCP" /> </div>
                                            <div class="col-xs-2"> <b>Sueldo </b>
                                                <input type="number" class="form-control input-sm" id="sueldoTCP" name="sueldoTCP" /> </div>
                                            <div class="col-xs-2"> <b>Gastos </b>
                                                <input type="number" class="form-control input-sm" id="gastosTCP" name="gastosTCP" /> </div>
                                        </div>
                                        <div id="independiente" class="col-xs-12 input-group">
                                            <div class="col-xs-2"> <b>Nombre negocio </b>
                                                <input type="text" onkeypress="this.value = this.value.replace(/[^A-Za-z0-9\s]/g, '').toUpperCase();" class="form-control input-sm" id="negocioTCP" name="negocioTCP" /> </div>
                                            <div class="col-xs-2"> <b>Venta/Honorarios Mensual </b>
                                                <input type="number" class="form-control input-sm" id="ventasTCP" name="ventasTCP" /> </div>
                                            <div class="col-xs-2"> <b>Costo Venta/Gasto Adm. </b>
                                                <input type="number" class="form-control input-sm" id="costoTCP" name="costoTCP" /> </div>
                                            <div class="col-xs-2"> <b>Actividad económica </b>
                                                <input type="text" onkeypress="this.value = this.value.replace(/[^A-Za-z0-9\s]/g, '').toUpperCase();" class="form-control input-sm" id="actEcoTCP" name="actEcoTCP" /> </div>
                                            <div class="col-xs-2"> <b>Gastos operativos </b>
                                                <input type="number" class="form-control input-sm" id="gastosOpeTCP" name="gastosOpeTCP" /> </div>
                                            <div class="col-xs-2"> <b>Fecha inicio negocio </b>
                                                <input type="date" class="form-control input-sm" id="fechaIniNegTCP" name="fechaIniNegTCP" /> </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <br>
                                        </div>
                                        <div class="col-xs-12"><b class="text-uppercase">Tarjeta de Crédito Principal - Datos de referencia </b>
                                            <hr/>
                                        </div>
                                        <div class="col-xs-2"> <b>Persona Referencia </b>
                                            <input onkeypress="this.value = this.value.replace(/[^A-Za-z\s]/g, '').toUpperCase();" type="text" class="form-control input-sm" id="perRefTCP" name="perRefTCP" /> </div>
                                        <div class="col-xs-3"> <b>Provincia </b>
                                            <select class="form-control input-sm" id="provinciaRefTCP" name="provinciaRefTCP">
                                                <option></option>
                                                <?php
                                                require '../config/connection.php';
                                                $result = ejecutarConsulta1("SELECT id,Provincia FROM cat_provincias ORDER BY Provincia");
                                                while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                                                    echo '<option value="' . $row["id"] . '">' . $row["Provincia"] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-xs-3"> <b>Ciudad </b>
                                            <select class="form-control input-sm" id="ciudadRefTCP" name="ciudadRefTCP">
                                                <option></option>
                                            </select>
                                        </div>
                                        <div class="col-xs-2"> <b>Teléfono </b>
                                            <input pattern="^0[2-9](\d{7,8})$" onkeypress="return onlyNumbers(event)" type="text" class="form-control input-sm" id="telfRefTCP" name="telfRefTCP" /> </div>
                                        <div class="col-xs-2"> <b>Relación con el cliente </b>
                                            <select class="form-control input-sm" id="relacionCliTCP" name="relacionCliTCP">
                                                <option></option>
                                                <option>MADRE</option>
                                                <option>PADRE</option>
                                                <option>HIJO/A</option>
                                                <option>CONYUGUE</option>
                                                <option>HERMANO/A</option>
                                                <option>SUEGRO/A</option>
                                                <option>TIO/A</option>
                                                <option>SOBRINO/A</option>
                                                <option>CUÑADO/A</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-12">
                                            <br>
                                        </div>
                                        <div class="col-xs-12"><b class="text-uppercase">Tarjeta de Crédito Principal - Datos de entrega </b>
                                            <hr/>
                                        </div>
                                        <div class="col-xs-2"> <b>Lugar de entrega </b>
                                            <select class="form-control input-sm" id="lugarEntTCP" name="lugarEntTCP">
                                                <option></option>
                                                <option>DOMICILIO</option>
                                                <option>TRABAJO</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-6">
                                            <br>
                                            <input type="text" class="form-control input-sm" id="dirEntTCP" name="dirEntTCP" readonly/> </div>
                                        <div class="col-xs-2"> <b>Persona de contacto</b>
                                            <input onkeypress="this.value = this.value.replace(/[^A-Za-z\s]/g, '').toUpperCase();" type="text" class="form-control input-sm" id="perContTCP" name="perContTCP" /> </div>
                                        <div class="col-xs-2"> <b>Teléfono de contacto</b>
                                            <input pattern="^0[2-9](\d{7,8})$" onkeypress="return onlyNumbers(event)" type="text" class="form-control input-sm" id="telfContTCP" name="telfContTCP" /> </div>
                                        <div class="col-xs-2"> <b>Horario de entrega </b>
                                            <select class="form-control input-sm" id="horEntTCP" name="horEntTCP">
                                                <option></option>
                                                <option>MAÑANA</option>
                                                <option>TARDE</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-3"> <b>Número de TC adicionales </b>
                                            <input type="number" class="form-control input-sm" id="equipFutTCP" name="equipFutTCP" /> </div>
                                        <div class="col-xs-3"> <b>Desea cambio de producto </b>
                                            <select class="form-control input-sm" id="cambioProdTCP" name="cambioProdTCP">
                                                <option></option>
                                                <option>SI</option>
                                                <option>NO</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="tcAdicional" class="btn col-xs-12">
                                <div class="box box-widget bg-gray">
                                    <div class="box-header with-border"> <b class="text-uppercase">Tarjeta de Crédito Adicional - Información del titular</b>
                                        <div class="box-tools">
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <div class="col-xs-3 hidden"> <b>ContactId </b>
                                            <input type="text" class="form-control input-sm" id="IdTCA" name="IdTCA" readonly/> </div>
                                        <div class="col-xs-2"> <b>Cédula del Titular </b>
                                            <input type="text" class="form-control input-sm" id="cedulaTitularTCA" name="cedulaTitularTCA" readonly/> </div>
                                        <div class="col-xs-4"> <b>Nombre del Titular </b>
                                            <input type="text" class="form-control input-sm" id="nombresTitularTCA" name="nombresTitularTCA" readonly/> </div>
                                        <div class="col-xs-2"> <b class="text-bold">Estado Civil </b>
                                            <select class="form-control input-sm" id="ESTADO_CIVILTCA" name="ESTADO_CIVILTCA">
                                                <option></option>
                                                <option>SOLTERO</option>
                                                <option>CASADO</option>
                                                <option>VIUDO</option>
                                                <option>DIVORCIADO</option>
                                                <option>UNION DE HECHO</option>
                                                <option>UNION LEGALIZADA</option>
                                                <option>UNION LIBRE</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-2"> <b class="text-bold">Género </b>
                                            <select class="form-control input-sm" id="generoTCA" name="generoTCA">
                                                <option></option>
                                                <option>FEMENINO</option>
                                                <option>MASCULINO</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-2"> <b class="text-bold">Lugar Nacimiento </b>
                                            <input type="text" class="form-control input-sm" id="LUGARNACTCA" name="LUGARNACTCA" /> </div>
                                        <div class="col-xs-2"> <b class="text-bold">Fecha Nacimiento </b>
                                            <input type="text" placeholder="dd/mm/aaaa" class="form-control input-sm" id="FECHA_NACIMIENTOTCA" name="FECHA_NACIMIENTOTCA" maxlength="10" /> </div>
                                        <div class="col-xs-1"> <b>Edad </b>
                                            <input type="text" class="form-control input-sm" id="edadTCA" name="edadTCA" readonly/> </div>
                                        <div class="col-xs-3"> <b class="text-bold">Actividad Económica </b>
                                            <input type="text" class="form-control input-sm" id="ACTECOTCA" name="ACTECOTCA" /> </div>
                                        <div class="col-xs-3"> <b class="text-bold">Correo </b>
                                            <input type="text" class="form-control input-sm" id="CORREOTCA" name="CORREOTCA" /> </div>
                                        <div class="col-xs-3">
                                            <div class="col-xs-12"> <b>Celular </b> </div>
                                            <div class="col-xs-3">
                                                <input name="otroCellTCA" id="otroCellTCA" type="checkbox" />
                                                <label class="text-bold">&nbsp; otro </label>
                                            </div>
                                            <div id="selectCellTCA" class="col-xs-9">
                                                <select class="form-control input-sm" id="celularTextTCA" name="celularTextTCA">
                                                    <option></option>
                                                </select>
                                            </div>
                                            <div id="textCellTCA" class="col-xs-9">
                                                <input pattern="^09(\d{8})$" onkeypress="return onlyNumbers(event)" type="text" class="form-control input-sm" id="celularTCA" name="celularTCA" /> </div>
                                        </div>
                                        <div class="col-xs-2"> <b class="text-bold">Plan deuda protegida </b>
                                            <select class="form-control input-sm" id="pdpTCA" name="pdpTCA">
                                                <option></option>
                                                <option>SI</option>
                                                <option>NO</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-2"> <b class="text-bold">Seleccione el motivo por el cual no desea el pdp </b>
                                            <select class="form-control input-sm" id="subestatus1TCA" name="subestatus1TCA">
                                                <option></option>
                                                <option>CU5 NO DESEA EL PRODUCTO</option>
                                                <option>CU6 NO CUMPLE PERFIL</option>
                                                <option>CU7 YA TOMO EL PRODUCTO</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-2">
                                            <br>
                                            <select class="form-control input-sm" id="subestatus2TCA" name="subestatus2TCA">
                                                <option></option>
                                            </select>
                                        </div>
                                        <div class="col-xs-12">
                                            <br>
                                        </div>
                                        <div class="col-xs-12"><b class="text-uppercase">Tarjeta de Crédito Adicional - Datos del trabajo del titular</b>
                                            <hr/>
                                        </div>
                                        <div class="col-xs-12">
                                            <input type="text" class="form-control input-sm" id="dirTrabTCA" name="dirTrabTCA" readonly/> </div>
                                        <div class="col-xs-3"> <b>Provincia trabajo </b>
                                            <select class="form-control input-sm" id="provinciaTrabTCA" name="provinciaTrabTCA"> </select>
                                        </div>
                                        <div class="col-xs-3"> <b>Ciudad trabajo </b>
                                            <select class="form-control input-sm" id="ciudadTrabTCA" name="ciudadTrabTCA"> </select>
                                        </div>
                                        <div class="col-xs-3"> <b>Calle principal </b>
                                            <input onkeypress="this.value = this.value.replace(/[^A-Za-z0-9-\s]/g, '').toUpperCase();" type="text" class="form-control input-sm" id="principalTrabTCA" name="principalTrabTCA" /> </div>
                                        <div class="col-xs-3"> <b>Calle secundaria </b>
                                            <input onkeypress="this.value = this.value.replace(/[^A-Za-z0-9-\s]/g, '').toUpperCase();" type="text" class="form-control input-sm" id="secundariaTrabTCA" name="secundariaTrabTCA" /> </div>
                                        <div class="col-xs-1"> <b>Numeración </b>
                                            <input onkeypress="this.value = this.value.replace(/[^A-Za-z0-9\s]/g, '').toUpperCase();" type="text" class="form-control input-sm" id="numTrabTCA" name="numTrabTCA" /> </div>
                                        <div class="col-xs-2"> <b>Sector / Barrio </b>
                                            <input onkeypress="this.value = this.value.replace(/[^A-Za-z0-9\s]/g, '').toUpperCase();" type="text" class="form-control input-sm" id="sectorTrabTCA" name="sectorTrabTCA" /> </div>
                                        <div class="col-xs-3"> <b>Referencia </b>
                                            <input type="text" class="form-control input-sm" id="refTrabTCA" name="refTrabTCA" /> </div>
                                        <div class="col-xs-3"> <b>Edificio/Casa/Departamento/Conjunto </b>
                                            <input type="text" class="form-control input-sm" id="tipoLugarTCA" name="tipoLugarTCA" /> </div>
                                        <div class="col-xs-3">
                                            <div class="col-xs-12"> <b>Teléfono </b> </div>
                                            <div class="col-xs-3">
                                                <input name="otroTrabTelfTCA" id="otroTrabTelfTCA" type="checkbox" />
                                                <label class="text-bold">&nbsp; otro </label>
                                            </div>
                                            <div id="selectTelfTrabTCA" class="col-xs-9">
                                                <select class="form-control input-sm" id="telfTextTrabTCA" name="telfTextTrabTCA">
                                                    <option></option>
                                                </select>
                                            </div>
                                            <div id="textTelfTrabTCA" class="col-xs-9">
                                                <input pattern="^(0[2-7])(\d{7})$" type="text" onkeypress="return onlyNumbers(event)" class="form-control input-sm" id="selectTrabTextTelfTCA" name="selectTrabTextTelfTCA" /> </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <br>
                                        </div>
                                        <div class="col-xs-12"><b class="text-uppercase">Tarjeta de Crédito Adicional - Datos del Domicilio del titular </b>
                                            <hr/>
                                        </div>
                                        <div class="col-xs-12">
                                            <input type="text" class="form-control input-sm" id="dirdomTCA" name="dirdomTCA" readonly/> </div>
                                        <div class="col-xs-3"> <b>Provincia domicilio </b>
                                            <select class="form-control input-sm" id="provinciaDomTCA" name="provinciaDomTCA"> </select>
                                        </div>
                                        <div class="col-xs-3"> <b>Ciudad domicilio </b>
                                            <select class="form-control input-sm" id="ciudadDomTCA" name="ciudadDomTCA"> </select>
                                        </div>
                                        <div class="col-xs-3"> <b>Calle principal </b>
                                            <input onkeypress="this.value = this.value.replace(/[^A-Za-z0-9-\s]/g, '').toUpperCase();" type="text" class="form-control input-sm" id="principalDomTCA" name="principalDomTCA" /> </div>
                                        <div class="col-xs-3"> <b>Calle secundaria </b>
                                            <input onkeypress="this.value = this.value.replace(/[^A-Za-z0-9-\s]/g, '').toUpperCase();" type="text" class="form-control input-sm" id="secundariaDomTCA" name="secundariaDomTCA" /> </div>
                                        <div class="col-xs-1"> <b>Numeración </b>
                                            <input onkeypress="this.value = this.value.replace(/[^A-Za-z0-9\s]/g, '').toUpperCase();" type="text" class="form-control input-sm" id="numDomTCA" name="numDomTCA" /> </div>
                                        <div class="col-xs-2"> <b>Sector / Barrio </b>
                                            <input onkeypress="this.value = this.value.replace(/[^A-Za-z0-9-\s]/g, '').toUpperCase();" type="text" class="form-control input-sm" id="sectorDomTCA" name="sectorDomTCA" /> </div>
                                        <div class="col-xs-3"> <b>Referencia </b>
                                            <input onkeypress="this.value = this.value.replace(/[^A-Za-z0-9-\s]/g, '').toUpperCase();" type="text" class="form-control input-sm" id="refDomTCA" name="refDomTCA" /> </div>
                                        <div class="col-xs-3"> <b>Edificio/Casa/Departamento/Conjunto </b>
                                            <input type="text" class="form-control input-sm" id="tipoLugarDOMTCA" name="tipoLugarDOMTCA" /> </div>
                                        <div class="col-xs-3">
                                            <div class="col-xs-12"> <b>Teléfono Domicilio</b> </div>
                                            <div class="col-xs-3">
                                                <input name="otroTelfTCA" id="otroTelfTCA" type="checkbox" />
                                                <label class="text-bold">&nbsp; otro </label>
                                            </div>
                                            <div id="selectTelfTCA" class="col-xs-9">
                                                <select class="form-control input-sm" id="telfTextTCA" name="telfTextTCA">
                                                    <option></option>
                                                </select>
                                            </div>
                                            <div id="textTelfTCA" class="col-xs-9">
                                                <input pattern="^(0[2-7])(\d{7})$" onkeypress="return onlyNumbers(event)" type="text" class="form-control input-sm" id="telfTCA" name="telfTCA" /> </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <br>
                                        </div>
                                        <div class="col-xs-12"><b class="text-uppercase">Tarjeta de Crédito Adicional - Datos de la tarjeta </b>
                                            <hr/>
                                        </div>
                                        <div class="col-xs-3 hidden"> <b>Tipo identificación </b>
                                            <input value="CEDULA" type="text" class="form-control input-sm" id="tipoIdentificacionTCA" name="tipoIdentificacionTCA" /> </div>
                                        <div class="col-xs-3" hidden> <b>Nacionalidad </b>
                                            <input value="ECUATORIANA" type="text" class="form-control input-sm" id="nacionalidadTCA" name="nacionalidadTCA" /> </div>
                                        <div class="col-xs-2"> <b>Identificación </b>
                                            <input onkeypress="return onlyNumbers(event)" type="text" class="form-control input-sm" id="IDENTIFICACIONTCA" name="IDENTIFICACIONTCA" maxlength="10" /> </div>
                                        <div class="col-xs-2"> <b>Primer Nombre </b>
                                            <input onkeypress="this.value = this.value.toUpperCase();
                                                    return onlyLetters(event)" type="text" class="form-control input-sm" id="NOMBRE1TCA" name="NOMBRE1TCA" onblur="this.value = this.value.toUpperCase();
                                                            return onlyLetters(event)" /> </div>
                                        <div class="col-xs-2"> <b>Segundo Nombre </b>
                                            <input onkeypress="this.value = this.value.toUpperCase();
                                                    return onlyLetters(event)" type="text" class="form-control input-sm" id="NOMBRE2TCA" name="NOMBRE2TCA" onblur="this.value = this.value.toUpperCase(); return onlyLetters(event)" /> </div>
                                        <div class="col-xs-2"> <b>Primer Apellido </b>
                                            <input onkeypress="this.value = this.value.toUpperCase(); return onlyLetters(event)" type="text" class="form-control input-sm" id="APELLIDO1TCA" name="APELLIDO1TCA" onblur="this.value = this.value.toUpperCase(); return onlyLetters(event)" /> </div>
                                        <div class="col-xs-2"> <b>Segundo Apellido </b>
                                            <input onkeypress="this.value = this.value.toUpperCase(); return onlyLetters(event)" type="text" class="form-control input-sm" id="APELLIDO2TCA" name="APELLIDO2TCA" onblur="this.value = this.value.toUpperCase(); return onlyLetters(event)" /> </div>
                                        <div class="col-xs-2"> <b>Nombre tarjeta </b>
                                            <input type="text" class="form-control input-sm" id="nombreTarjetaTCA" name="nombreTarjetaTCA" /> </div>
                                        <div class="col-xs-2"> <b class="text-bold">Fecha Nacimiento </b>
                                            <input type="text" placeholder="dd/mm/aaaa" class="form-control input-sm" id="FECHA_NACIMIENTOADITCA" name="FECHA_NACIMIENTOADITCA" maxlength="10" /> </div>
                                        <div class="col-xs-1"> <b>Cupo Máximo </b>
                                            <input type="text" class="form-control input-sm" id="cupoMaxTCA" name="cupoMaxTCA" readonly/> </div>
                                        <div class="col-xs-1"> <b>Cupo </b>
                                            <input type="text" class="form-control input-sm" id="cupoTCA" name="cupoTCA" /> </div>
                                        <div class="col-xs-4"> <b>Tajeta titular </b>
                                            <input type="text" class="form-control input-sm" id="tarjetaTitularTCA" name="tarjetaTitularTCA" readonly/> </div>
                                        <div class="col-xs-2"> <b class="text-bold">Género </b>
                                            <select class="form-control input-sm" id="generoPerTCA" name="generoPerTCA">
                                                <option></option>
                                                <option>FEMENINO</option>
                                                <option>MASCULINO</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-2"> <b class="text-bold">Estado Civil </b>
                                            <select class="form-control input-sm" id="estadoCivilPerTCA" name="estadoCivilPerTCA">
                                                <option></option>
                                                <option>SOLTERO</option>
                                                <option>CASADO</option>
                                                <option>VIUDO</option>
                                                <option>DIVORCIADO</option>
                                                <option>UNION DE HECHO</option>
                                                <option>UNION LEGALIZADA</option>
                                                <option>UNION LIBRE</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-2"> <b class="text-bold">Parentezco </b>
                                            <select class="form-control input-sm" id="parentezcoTCA" name="parentezcoTCA">
                                                <option></option>
                                                <option>MADRE</option>
                                                <option>PADRE</option>
                                                <option>HIJO/A</option>
                                                <option>CONYUGUE</option>
                                                <option>HERMANO/A</option>
                                                <option>SUEGRO/A</option>
                                                <option>TIO/A</option>
                                                <option>SOBRINO/A</option>
                                                <option>CUÑADO/A</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-2"> <b>Lugar de entrega </b>
                                            <select class="form-control input-sm" id="lugarEntTCA" name="lugarEntTCA">
                                                <option></option>
                                                <option>DOMICILIO</option>
                                                <option>TRABAJO</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-2"> <b>Rango Visita </b>
                                            <select class="form-control input-sm" id="ranVisTCA" name="ranVisTCA">
                                                <option></option>
                                                <option>MAÑANA</option>
                                                <option>TARDE</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-2"> <b class="text-bold">Emisión estado cuenta </b>
                                            <select class="form-control input-sm" id="estadoctaTCA" name="estadoctaTCA">
                                                <option></option>
                                                <option>SI</option>
                                                <option>NO</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-2"> <b>Persona Contacto </b>
                                            <input type="text" class="form-control input-sm" id="personaContactoTCA" name="personaContactoTCA" /> </div>
                                        <div class="col-xs-12">
                                            <br>
                                        </div>
                                        <div class="row1">
                                            <div class="col-xs-6 text-right">
                                                <button class="btn btn-bitbucket btn-sm" type="button" id="btnGuardarTCA"><i class="fa fa-save"></i> Guardar Tarjeta Adicional</button>
                                            </div>
                                            <div class="col-xs-6 text-left">
                                                <button class="btn btn-danger btn-sm" onclick="cancelar_TCA()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar Tarjeta Adicional</button>
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <br>
                                        </div>
                                        <table id="tblListadoTCA" class="table table-condensed table-hover table-responsive">
                                            <thead>
                                            <th>NUM</th>
                                            <th>IDENTIFICACION</th>
                                            <th>NOMBRE</th>
                                            <th>APELLIDO</th>
                                            <th>NOMBRE TARJETA</th>
                                            <th>CUPO</th>
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
                                            </tfoot>
                                        </table>
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
                                <div class="col-xs-1"> <b class="text-bold text-aqua">EDAD </b>
                                    <input type="text" class="form-control input-sm" id="EDAD" name="EDAD" readonly/> </div>
                                <div class="col-xs-2"> <b class="text-bold text-aqua">FECHA_NACIMIENTO </b>
                                    <input type="text" class="form-control input-sm" id="FECHA_NACIMIENTO" name="FECHA_NACIMIENTO" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">IDENTIFICACION </b>
                                    <input type="text" class="form-control input-sm" id="IDENTIFICACION" name="IDENTIFICACION" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">NOMBRE </b>
                                    <input type="text" class="form-control input-sm" id="NOMBRE" name="NOMBRE" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">CORREO1 </b>
                                    <input type="text" class="form-control input-sm" id="CORREO1" name="CORREO1" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">SEXO </b>
                                    <input type="text" class="form-control input-sm" id="SEXO" name="SEXO" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">ESTADO_CIVIL </b>
                                    <input type="text" class="form-control input-sm" id="ESTADO_CIVIL" name="ESTADO_CIVIL" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">PAIS_DOM_CAL_DAT </b>
                                    <input type="text" class="form-control input-sm" id="PAIS_DOM_CAL_DAT" name="PAIS_DOM_CAL_DAT" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">PROV_DOM_CAL_DAT </b>
                                    <input type="text" class="form-control input-sm" id="PROV_DOM_CAL_DAT" name="PROV_DOM_CAL_DAT" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">CIUDAD_DOM_CAL_DAT </b>
                                    <input type="text" class="form-control input-sm" id="CIUDAD_DOM_CAL_DAT" name="CIUDAD_DOM_CAL_DAT" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">DIR_DOM_CAL_DAT </b>
                                    <input type="text" class="form-control input-sm" id="DIR_DOM_CAL_DAT" name="DIR_DOM_CAL_DAT" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">PAIS_TRAB_1_CAL_DAT </b>
                                    <input type="text" class="form-control input-sm" id="PAIS_TRAB_1_CAL_DAT" name="PAIS_TRAB_1_CAL_DAT" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">PROV_TRAB_1_CAL_DAT </b>
                                    <input type="text" class="form-control input-sm" id="PROV_TRAB_1_CAL_DAT" name="PROV_TRAB_1_CAL_DAT" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">CIUDAD_TRAB_1_CAL_DAT </b>
                                    <input type="text" class="form-control input-sm" id="CIUDAD_TRAB_1_CAL_DAT" name="CIUDAD_TRAB_1_CAL_DAT" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">DIR_TRAB_1_CAL_DAT </b>
                                    <input type="text" class="form-control input-sm" id="DIR_TRAB_1_CAL_DAT" name="DIR_TRAB_1_CAL_DAT" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">TIENE_DEUDA_PROTEGIDA </b>
                                    <input type="text" class="form-control input-sm" id="TIENE_DEUDA_PROTEGIDA" name="TIENE_DEUDA_PROTEGIDA" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">NUMERO_TARJETA </b>
                                    <input type="text" class="form-control input-sm" id="NUMERO_TARJETA" name="NUMERO_TARJETA" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">PRODUCTO </b>
                                    <input type="text" class="form-control input-sm" id="PRODUCTO" name="PRODUCTO" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">TIPOTC </b>
                                    <input type="text" class="form-control input-sm" id="TIPOTC" name="TIPOTC" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">FAMILIA </b>
                                    <input type="text" class="form-control input-sm" id="FAMILIA" name="FAMILIA" readonly/> </div>
                                <div class="col-xs-2"> <b class="text-bold text-aqua">CUPO </b>
                                    <input type="text" class="form-control input-sm" id="CUPO" name="CUPO" readonly/> </div>
                                <div class="col-xs-2"> <b class="text-bold text-aqua">CUPO_DISPONIBLE </b>
                                    <input type="text" class="form-control input-sm" id="CUPO_DISPONIBLE" name="CUPO_DISPONIBLE" readonly/> </div>
                                <div class="col-xs-2"> <b class="text-bold text-aqua">MAXIMO_CONSUMO </b>
                                    <input type="text" class="form-control input-sm" id="MAXIMO_CONSUMO" name="MAXIMO_CONSUMO" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">MAXIMA_TARJETA </b>
                                    <input type="text" class="form-control input-sm" id="MAXIMA_TARJETA" name="MAXIMA_TARJETA" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">TIENE_TDC </b>
                                    <input type="text" class="form-control input-sm" id="TIENE_TDC" name="TIENE_TDC" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">NUPS </b>
                                    <input type="text" class="form-control input-sm" id="NUPS" name="NUPS" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">PERFILRIESGOENDEUDAMIENTO </b>
                                    <input type="text" class="form-control input-sm" id="PERFILRIESGOENDEUDAMIENTO" name="PERFILRIESGOENDEUDAMIENTO" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">SUBSEGMENTO </b>
                                    <input type="text" class="form-control input-sm" id="SUBSEGMENTO" name="SUBSEGMENTO" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">BANCA </b>
                                    <input type="text" class="form-control input-sm" id="BANCA" name="BANCA" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">SEGMENTO </b>
                                    <input type="text" class="form-control input-sm" id="SEGMENTO" name="SEGMENTO" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">SEGMENTO_N_2 </b>
                                    <input type="text" class="form-control input-sm" id="SEGMENTO_N_2" name="SEGMENTO_N_2" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">SUBSEGMENTO1 </b>
                                    <input type="text" class="form-control input-sm" id="SUBSEGMENTO1" name="SUBSEGMENTO1" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">REGION </b>
                                    <input type="text" class="form-control input-sm" id="REGION" name="REGION" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">ZONA </b>
                                    <input type="text" class="form-control input-sm" id="ZONA" name="ZONA" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">AGENCIA </b>
                                    <input type="text" class="form-control input-sm" id="AGENCIA" name="AGENCIA" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">CALIFICACION_BURO </b>
                                    <input type="text" class="form-control input-sm" id="CALIFICACION_BURO" name="CALIFICACION_BURO" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">COD_MARCA </b>
                                    <input type="text" class="form-control input-sm" id="COD_MARCA" name="COD_MARCA" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">PLAN_RECOMPENSAS </b>
                                    <input type="text" class="form-control input-sm" id="PLAN_RECOMPENSAS" name="PLAN_RECOMPENSAS" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">FECHA_INGRESO_SOCIO </b>
                                    <input type="text" class="form-control input-sm" id="FECHA_INGRESO_SOCIO" name="FECHA_INGRESO_SOCIO" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">NUMERO_CUENTA1 </b>
                                    <input type="text" class="form-control input-sm" id="NUMERO_CUENTA1" name="NUMERO_CUENTA1" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">PRODUCTO_CTA1 </b>
                                    <input type="text" class="form-control input-sm" id="PRODUCTO_CTA1" name="PRODUCTO_CTA1" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">DESCRIPCION1 </b>
                                    <input type="text" class="form-control input-sm" id="DESCRIPCION1" name="DESCRIPCION1" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">CANAL </b>
                                    <input type="text" class="form-control input-sm" id="CANAL" name="CANAL" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">DIFERENCIA_CUPOS </b>
                                    <input type="text" class="form-control input-sm" id="DIFERENCIA_CUPOS" name="DIFERENCIA_CUPOS" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">CATEGORIZACION </b>
                                    <input type="text" class="form-control input-sm" id="CATEGORIZACION" name="CATEGORIZACION" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">TIPO_BASE </b>
                                    <input type="text" class="form-control input-sm" id="TIPO_BASE" name="TIPO_BASE" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">REGION_ANCLAJE </b>
                                    <input type="text" class="form-control input-sm" id="REGION_ANCLAJE" name="REGION_ANCLAJE" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">DES_NACIONALID </b>
                                    <input type="text" class="form-control input-sm" id="DES_NACIONALID" name="DES_NACIONALID" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">CANT_NAC </b>
                                    <input type="text" class="form-control input-sm" id="CANT_NAC" name="CANT_NAC" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">ACTIVIDAD_ECONOMICA </b>
                                    <input type="text" class="form-control input-sm" id="ACTIVIDAD_ECONOMICA" name="ACTIVIDAD_ECONOMICA" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">DES_CANAL </b>
                                    <input type="text" class="form-control input-sm" id="DES_CANAL" name="DES_CANAL" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">CUENTA </b>
                                    <input type="text" class="form-control input-sm" id="CUENTA" name="CUENTA" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">MARCA_CUPO </b>
                                    <input type="text" class="form-control input-sm" id="MARCA_CUPO" name="MARCA_CUPO" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">NRO_TDC_COMPETENCIA </b>
                                    <input type="text" class="form-control input-sm" id="NRO_TDC_COMPETENCIA" name="NRO_TDC_COMPETENCIA" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">CUPO_MAX_COMP </b>
                                    <input type="text" class="form-control input-sm" id="CUPO_MAX_COMP" name="CUPO_MAX_COMP" readonly/> </div>
                                <div class="col-xs-3"> <b class="text-bold text-aqua">CONSUMO_PROMEDIO </b>
                                    <input type="text" class="form-control input-sm" id="CONSUMO_PROMEDIO" name="CONSUMO_PROMEDIO" readonly/> </div>
                                <div id="ocultos" class="hidden">
                                    <div class="col-xs-3"> <b class="text-bold text-aqua">CORREO2 </b>
                                        <input type="text" class="form-control input-sm" id="CORREO2" name="CORREO2" readonly/> </div>
                                    <div class="col-xs-3"> <b class="text-bold text-aqua">CORREO3 </b>
                                        <input type="text" class="form-control input-sm" id="CORREO3" name="CORREO3" readonly/> </div>
                                    <div class="col-xs-3"> <b class="text-bold text-aqua">CORREO4 </b>
                                        <input type="text" class="form-control input-sm" id="CORREO4" name="CORREO4" readonly/> </div>
                                    <div class="col-xs-3"> <b class="text-bold text-aqua">CORREO5 </b>
                                        <input type="text" class="form-control input-sm" id="CORREO5" name="CORREO5" readonly/> </div>
                                    <div class="col-xs-3"> <b class="text-bold text-aqua">CORREO6 </b>
                                        <input type="text" class="form-control input-sm" id="CORREO6" name="CORREO6" readonly/> </div>
                                    <div class="col-xs-3"> <b class="text-bold text-aqua">HIJOS_MAS_18 </b>
                                        <input type="text" class="form-control input-sm" id="HIJOS_MAS_18" name="HIJOS_MAS_18" readonly/> </div>
                                    <div class="col-xs-3"> <b class="text-bold text-aqua">HIJOS_MENOS_18 </b>
                                        <input type="text" class="form-control input-sm" id="HIJOS_MENOS_18" name="HIJOS_MENOS_18" readonly/> </div>
                                    <div class="col-xs-3"> <b class="text-bold text-aqua">HERMANOS_MENOS_18 </b>
                                        <input type="text" class="form-control input-sm" id="HERMANOS_MENOS_18" name="HERMANOS_MENOS_18" readonly/> </div>
                                    <div class="col-xs-3"> <b class="text-bold text-aqua">HERMANOS_MAS_18 </b>
                                        <input type="text" class="form-control input-sm" id="HERMANOS_MAS_18" name="HERMANOS_MAS_18" readonly/> </div>
                                    <div class="col-xs-3"> <b class="text-bold text-aqua">MAMA </b>
                                        <input type="text" class="form-control input-sm" id="MAMA" name="MAMA" readonly/> </div>
                                    <div class="col-xs-3"> <b class="text-bold text-aqua">PAPA </b>
                                        <input type="text" class="form-control input-sm" id="PAPA" name="PAPA" readonly/> </div>
                                    <div class="col-xs-3"> <b class="text-bold text-aqua">NOMBRES </b>
                                        <input type="text" class="form-control input-sm" id="NOMBRES" name="NOMBRES" readonly/> </div>
                                    <div class="col-xs-3"> <b class="text-bold text-aqua">DES_SEXO </b>
                                        <input type="text" class="form-control input-sm" id="DES_SEXO" name="DES_SEXO" readonly/> </div>
                                    <div class="col-xs-3"> <b class="text-bold text-aqua">FECH_NAC </b>
                                        <input type="text" class="form-control input-sm" id="FECH_NAC" name="FECH_NAC" readonly/> </div>
                                    <div class="col-xs-3"> <b class="text-bold text-aqua">NUMERO_CARGAS_FAMILIARES </b>
                                        <input type="text" class="form-control input-sm" id="NUMERO_CARGAS_FAMILIARES" name="NUMERO_CARGAS_FAMILIARES" readonly/> </div>
                                    <div class="col-xs-3"> <b class="text-bold text-aqua">IDENTIFICACION_PARENTEZCO </b>
                                        <input type="text" class="form-control input-sm" id="IDENTIFICACION_PARENTEZCO" name="IDENTIFICACION_PARENTEZCO" readonly/> </div>
                                    <div class="col-xs-3"> <b class="text-bold text-aqua">PRIORIDAD_GESTION </b>
                                        <input type="text" class="form-control input-sm" id="PRIORIDAD_GESTION" name="PRIORIDAD_GESTION" readonly/> </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </section>
</div>
<?php require 'footer.php'; ?>
<script src="scripts/bpMoCampanias.js" type="text/javascript"></script>
<script src="scripts/funcions.js" type="text/javascript"></script>