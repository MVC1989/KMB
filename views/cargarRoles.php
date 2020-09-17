<?php
require 'header.php';
require 'menu.php';
?>
<style>
    #contenedor {
        width:10px;
        height:300px;
    }
    .loader:before,
    .loader:after,
    .loader {
        border-radius: 50%;
        width: 2.5em;
        height: 2.5em;
        -webkit-animation-fill-mode: both;
        animation-fill-mode: both;
        -webkit-animation: load7 1.8s infinite ease-in-out;
        animation: load7 1.8s infinite ease-in-out;
    }
    .loader {
        margin: 8em auto;
        font-size: 10px;
        position: relative;
        text-indent: -9999em;
        -webkit-animation-delay: 0.16s;
        animation-delay: 0.16s;
    }
    .loader:before {
        left: -3.5em;
    }
    .loader:after {
        left: 3.5em;
        -webkit-animation-delay: 0.32s;
        animation-delay: 0.32s;
    }
    .loader:before,
    .loader:after {
        content: '';
        position: absolute;
        top: 0;
    }
    @-webkit-keyframes load7 {
        0%,
        80%,
        100% {
            box-shadow: 0 2.5em 0 -1.3em black;
        }
        40% {
            box-shadow: 0 2.5em 0 0 #95969E;
        }
    }
    @keyframes load7 {
        0%,
        80%,
        100% {
            box-shadow: 0 2.5em 0 -1.3em black;
        }
        40% {
            box-shadow: 0 2.5em 0 0 #95969E;
        }
    }

</style>

<div class="content-wrapper">
    <section class="content">
        <div class="container">
            <!-- Encabezado de los paneles -->
            <ul class="nav nav-tabs col-xs-10" role="tablist">
                <li class="nav-item active">
                    <a class="nav-link" data-toggle="pill" href="#home">Roles de Pago</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#menu1">Importar Roles de Pago</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#menu2">Activar/Cancelar importaciones</a>
                </li>
            </ul>
            <!-- contenido de los paneles -->
            <div class="tab-content col-xs-10">
                <div id="home" class="container tab-pane active"><br>
                    <div class="col-xs-10 text-center" id="listadoRegistros"><br>
                        <table id="tblListado" class="table table-condensed table-hover table-responsive">
                            <thead>
                            <th>Num</th>
                            <th>Mes</th>
                            <th>Nombres del empleado</th>
                            <th>Fecha ingreso</th>
                            <th>Identificación</th>
                            <th>Días laborados</th>
                            <th>Sueldo</th>
                            <th>Total ingresos</th>
                            <th>Total egresos</th>
                            <th>Total a pagar</th>
                            <th>Tipo empleado</th>
                            <th>Acciones</th>
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
                            <th></th>
                            </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioRegistros" > <!-- formulario de registros -->
                        <div class="box">
                            <div class="box-header with-border"> <!-- header -->
                                <h1 class="box-title"><b>KIMOBILL OMNICONTACT SOCIEDAD ANONIMA</b></h1><br>
                                <p>RUC: 1792915805001</p>
                            </div> <!-- /header -->
                            <center>
                                <div class="box-tools">
                                    <!--<img src="../public/admin/images/logo.jpg" alt="" class="user-image" style="height: 130px; width: 200px"/>-->
                                    <p><b>ROL DE PAGOS</b></p><br>
                                </div>
                            </center>
                            <div class="panel-body" style="border: solid">
                                <form name="formulario" id="formulario" method="POST" >
                                    <div class="col-xs-12">
                                        <input type="hidden" class="form-control" id="IDC" name="IDC"/>
                                    </div>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td style="width:30px"><label>NOMBRES:</label></td>
                                                <td style="width:300px"><label id="NOMBRE_EMPLEADO" class="text-blue"></label></td>
                                                <td style="width:30px"><label>IDENTIFICACION:&nbsp;&nbsp;</label></td>
                                                <td style="width:100px"><label id="CEDULA" class="text-blue"></label></td>
                                                <td style="width:30px"><label>SUELDO:&nbsp;&nbsp;</label></td>
                                                <td style="width:80px"><label id="SUELDO" class="text-blue"></label></td>
                                                <td style="width:140px"><label>DIAS LABORADOS:&nbsp;&nbsp;</label></td>
                                                <td style="width:80px"><label id="DIAS" class="text-blue"></label></td>
                                                <td style="width:80px"><label>PERIODO: &nbsp;&nbsp;</label></td>
                                                <td style="width:180px"><label id="MES" class="text-blue"></label></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="col-xs-12"><br></div>
                                    <table>
                                        <tbody>
                                            <tr style="border-top: solid">
                                                <td colspan="2" style="width:400px"><label>INGRESOS</label></td>
                                                <td style="width:150px"><label>VALOR</label></td>
                                                <td style="width:30px">&nbsp;</td>
                                                <td style="width:30px; border-left: solid">&nbsp;</td>
                                                <td colspan="2" style="width:400px"><label>EGRESOS</label></td>
                                                <td style="width:150px"><label>VALOR</label></td>
                                            </tr>
                                            <tr style="border-top: solid">
                                                <td style="width:350px"><label>SUELDO GANADO</label></td>
                                                <td style="width:50px">$</td>
                                                <td style="width:150px" class="text-right"><label id="SUELDO_GANADO" class="text-blue"></label></td>
                                                <td style="width:30px">&nbsp;</td>
                                                <td style="width:30px; border-left: solid">&nbsp;</td>
                                                <td style="width:350px"><label>APORTE IESS 9.45%</label></td>
                                                <td style="width:50px">$</td>
                                                <td style="width:150px" class="text-right"><label id="APORTE_PERSONAL" class="text-blue"></label></td>
                                            </tr>
                                            <tr>
                                                <td style="width:350px"><label>HORAS EXTRAS</label></td>
                                                <td style="width:50px">$</td>
                                                <td style="width:150px" class="text-right"><label id="HORAS_EXTRAS" class="text-blue"></label></td>
                                                <td style="width:30px">&nbsp;</td>
                                                <td style="width:30px; border-left: solid">&nbsp;</td>
                                                <td style="width:350px"><label>IMPUESTO A LA RENTA</label></td>
                                                <td style="width:50px">$</td>
                                                <td style="width:150px" class="text-right"><label id="IMPUESTO_RENTA" class="text-blue"></label></td>
                                            </tr>
                                            <tr>
                                                <td style="width:350px"><label>COMISIONES</label></td>
                                                <td style="width:50px">$</td>
                                                <td style="width:150px" class="text-right"><label id="COMISION" class="text-blue"></label></td>
                                                <td style="width:30px">&nbsp;</td>
                                                <td style="width:30px; border-left: solid">&nbsp;</td>
                                                <td style="width:350px"><label>PRESTAMOS QUIROGRAFARIOS</label></td>
                                                <td style="width:50px">$</td>
                                                <td style="width:150px" class="text-right"><label id="PRESTAMOS_Q_IESS" class="text-blue"></label></td>
                                            </tr>
                                            <tr>
                                                <td style="width:350px"><label>TOTAL INGRESOS IMPUTABLES</label></td>
                                                <td style="width:50px">$</td>
                                                <td style="width:150px" class="text-right"><label id="TOTAL_INGRESOS1" class="text-blue"></label></td>
                                                <td style="width:30px">&nbsp;</td>
                                                <td style="width:30px; border-left: solid">&nbsp;</td>
                                                <td style="width:350px"><label>PRESTAMOS HIPOTECARIOS</label></td>
                                                <td style="width:50px">$</td>
                                                <td style="width:150px" class="text-right"><label id="PRESTAMOS_H_IESS" class="text-blue"></label></td>
                                            </tr>
                                            <tr>
                                                <td style="width:350px"><label>FONDOS DE RESERVA</label></td>
                                                <td style="width:50px">$</td>
                                                <td style="width:150px" class="text-right"><label id="FONDO_RESERVA" class="text-blue"></label></td>
                                                <td style="width:30px">&nbsp;</td>
                                                <td style="width:30px; border-left: solid">&nbsp;</td>
                                                <td style="width:350px"><label>PRESTAMOS OFICINA</label></td>
                                                <td style="width:50px">$</td>
                                                <td style="width:150px" class="text-right"><label id="PRESTAMO_OFICINA" class="text-blue"></label></td>
                                            </tr>
                                            <tr>
                                                <td style="width:350px"><label></label></td>
                                                <td style="width:50px"></td>
                                                <td style="width:150px" class="text-right"><label class="text-blue"></label></td>
                                                <td style="width:30px">&nbsp;</td>
                                                <td style="width:30px; border-left: solid">&nbsp;</td>
                                                <td style="width:350px"><label>ATRASOS</label></td>
                                                <td style="width:50px">$</td>
                                                <td style="width:150px" class="text-right"><label id="ATRASOS" class="text-blue"></label></td>
                                            </tr>
                                            <tr>
                                                <td style="width:350px"><label></label></td>
                                                <td style="width:50px"></td>
                                                <td style="width:150px" class="text-right"><label class="text-blue"></label></td>
                                                <td style="width:30px">&nbsp;</td>
                                                <td style="width:30px; border-left: solid">&nbsp;</td>
                                                <td style="width:350px"><label>FALTAS</label></td>
                                                <td style="width:50px">$</td>
                                                <td style="width:150px" class="text-right"><label id="FALTAS" class="text-blue"></label></td>
                                            </tr>
                                            <tr>
                                                <td style="width:350px"><label></label></td>
                                                <td style="width:50px"></td>
                                                <td style="width:150px" class="text-right"><label id="" class="text-blue"></label></td>
                                                <td style="width:30px">&nbsp;</td>
                                                <td style="width:30px; border-left: solid">&nbsp;</td>
                                                <td style="width:350px"><label>OTROS DESCUENTOS</label></td>
                                                <td style="width:50px">$</td>
                                                <td style="width:150px" class="text-right"><label id="OTROS_DESCUENTOS" class="text-blue"></label></td>
                                            </tr>
                                            <tr>
                                                <td style="width:350px"><label>OTROS INGRESOS IMPUTABLES</label></td>
                                                <td style="width:50px">$</td>
                                                <td style="width:150px" class="text-right"><label id="OTROS_INGRESOS" class="text-blue"></label></td>
                                                <td style="width:30px">&nbsp;</td>
                                                <td style="width:30px; border-left: solid">&nbsp;</td>
                                                <td style="width:350px"><label>TOTAL EGRESOS</label></td>
                                                <td style="width:50px">$</td>
                                                <td style="width:150px" class="text-right"><label id="TOTAL_EGRESOS" class="text-blue"></label></td>
                                            </tr>
                                            <tr>
                                                <td style="width:350px; border-bottom-style: solid;"><label>TOTAL INGRESOS</label></td>
                                                <td style="width:50px; border-bottom-style: solid;">$</td>
                                                <td style="width:150px; border-bottom-style: solid;" class="text-right"><label id="TOTAL_INGRESOS" class="text-blue"></label></td>
                                                <td style="width:30px; border-bottom-style: solid;">&nbsp;</td>
                                                <td style="width:30px; border-left: solid; border-bottom-style: solid;">&nbsp;</td>
                                                <td style="width:350px; border-bottom-style: solid;"><label>TOTAL A RECIBIR</label></td>
                                                <td style="width:50px; border-bottom-style: solid;">$</td>
                                                <td style="width:150px; border-bottom-style: solid;" class="text-right"><label id="TOTAL_A_PAGAR" class="text-blue"></label></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="col-xs-12"><br></div>
                                    <div class="col-xs-2"><br></div>
                                    <div class="form-check col-xs-9">
                                        <label class="form-check-label ">
                                            <input type="checkbox" disabled class="form-check-input" value=""> He leído y acepto el detalle completo de valores generados por mis actividades laboradas mediante el rol expuesto
                                        </label>
                                    </div>
                                    <center>
                                        <div class="col-xs-12"><br></div>
                                        <div class="col-xs-12">________________________________</div>
                                        <div class="col-xs-12"><P>Firma</P></div>
                                    </center>
                                </form>
                            </div>
                            <div class="col-xs-12"><br></div>
                            <div class="col-xs-12 text-center"><br/>
                                <button class="btn btn-primary btn-sm" type="submit" id="btn" disabled><i class="fa fa-save"></i> Guardar</button>
                                <button class="btn btn-danger btn-sm" onclick="cancelar_formulario()" type="button"><i class="fa fa-arrow-circle-left"></i> Regresar</button>
                            </div>
                        </div>
                    </div> <!-- /formulario de registros -->
                </div>

                <div id="menu1" class="container tab-pane fade"><br>
                    <form class="container-fluid" id="frmcargararchivo" name="frmcargararchivo" method="post" enctype="multipart/form-data">
                        <div class="col-xs-3 text-left">
                            <b class="text-bold text-left text-bold">Nombre importación: </b>
                            <input class="form-control" type="text" name="import" id="import" required />
                        </div>
                        <div class="col-xs-3 text-left">
                            <b class="text-bold text-left text-bold">Mapeo: </b>
                            <select class="form-control" name="mapeo" id="mapeo" required>
                                <option></option>
                                <option>Roles de pago</option>
                            </select>
                        </div>
                        <div class="col-xs-4 text-left">
                            <b class="text-bold text-left text-bold">Seleccione un archivo csv</b>
                            <input class="form-control" type="file" name="excel" id="excel" />
                        </div>
                        <div class="col-xs-12 text-center"><br></div>
                        <div class="col-xs-10 text-center">
                            <button class="btn btn-info" id="btnGuardar" type="submit" value="Subir">
                                <i class="fa fa-upload"></i> Subir
                            </button>
                            <button class="btn btn-info" id="btnNuevaImp" type="button" value="Nueva" onclick="limpiar_formularioMapeo()">
                                <i class="fa fa-rotate-left"></i> Nueva importación
                            </button>
                        </div>
                        <div class="col-xs-10">
                            <div id="contenedor" class="center-block">
                                <div class="loader" id="loader">Loading...</div>
                            </div>
                        </div>
                        <div class="col-xs-10 text-center" id="mensaje">
                        </div>
                        <div class="col-xs-12"><br></div>
                    </form>
                </div>

                <div id="menu1" class="container tab-pane fade"><br>
                    <div class="col-xs-4">
                        <b>Seleccione importación:</b>
                        <select name="importation" id="importation" class="form-control">
                        </select>
                    </div>
                    <div class="col-xs-2">
                        <b>Seleccione opción:</b>
                        <select name="acciones" id="acciones" class="form-control">
                            <option></option>
                            <option value="Activa">Activar importación</option>
                            <option value="Cancelada">Cancelar importación</option>
                        </select>
                    </div>
                    <div class="col-xs-12 text-center"><br></div>
                    <div class="col-xs-10 text-center">
                        <button class="btn btn-primary btn-file" type="button" id="btnMostrar"><i class="fa fa-eye-slash"></i> Mostrar Registros</button>
                        <button class="btn btn-info" id="btnEnviar" type="button">
                            <i class="fa fa-send"></i> Enviar
                        </button>
                        <button class="btn btn-bitbucket" title="Actualizar" onclick="limpiarPnlCancel()" type="button">
                            <i class="fa fa-repeat"></i>
                        </button>
                    </div>
                    <div class="col-xs-11 text-center"><br>
                        <table id="tblListado" class="table table-condensed table-hover table-responsive">
                            <thead>
                            <th>Num</th>
                            <th>Nombres</th>
                            <th>Identificación</th>
                            <th>Campaña</th>
                            <th>Resultado de gestión</th>
                            <th>Importación</th>
                            <th>Agente</th>
                            <th>Fecha cambio</th>
                            <th>Usuario cambio</th>
                            <th>Acción</th>
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
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php require 'footer.php'; ?>
<script src="scripts/manageRol.js" type="text/javascript"></script>