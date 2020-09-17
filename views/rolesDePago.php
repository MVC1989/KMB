<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box-header with-border" id="titulo">
                    <label class="h4 text-bold">Roles de pago</label>
                </div>
                <div class="col-xs-12 text-center" id="listadoRegistros"><br>
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
                                <img src="../public/admin/images/logo.jpg" alt="" class="user-image" style="height: 130px; width: 200px"/>
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
                                            <td style="width:60px"></td>
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
                                <center>
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
                                                <td style="width:350px"><label>SUBTOTAL INGRESOS</label></td>
                                                <td style="width:50px">$</td>
                                                <td style="width:150px" class="text-right"><label id="SUBTOTAL_INGRESOS" class="text-blue"></label></td>
                                                <td style="width:30px">&nbsp;</td>
                                                <td style="width:30px; border-left: solid">&nbsp;</td>
                                                <td style="width:350px"><label>PRESTAMOS QUIROGRAFARIOS</label></td>
                                                <td style="width:50px">$</td>
                                                <td style="width:150px" class="text-right"><label id="PRESTAMOS_Q_IESS" class="text-blue"></label></td>
                                            </tr>
                                            <tr>
                                                <td style="width:350px"><label>COMISIONES</label></td>
                                                <td style="width:50px">$</td>
                                                <td style="width:150px" class="text-right"><label id="COMISION" class="text-blue"></label></td>
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
                                                <td style="width:50px">$</td>
                                                <td style="width:150px" class="text-right"><label id="" class="text-blue"></label></td>
                                                <td style="width:30px">&nbsp;</td>
                                                <td style="width:30px; border-left: solid">&nbsp;</td>
                                                <td style="width:350px"><label>ATRASOS</label></td>
                                                <td style="width:50px">$</td>
                                                <td style="width:150px" class="text-right"><label id="ATRASOS" class="text-blue"></label></td>
                                            </tr>
                                            <tr>
                                                <td style="width:350px"><label></label></td>
                                                <td style="width:50px">$</td>
                                                <td style="width:150px" class="text-right"><label id="" class="text-blue"></label></td>
                                                <td style="width:30px">&nbsp;</td>
                                                <td style="width:30px; border-left: solid">&nbsp;</td>
                                                <td style="width:350px"><label>FALTAS</label></td>
                                                <td style="width:50px">$</td>
                                                <td style="width:150px" class="text-right"><label id="FALTAS" class="text-blue"></label></td>
                                            </tr>
                                            <tr>
                                                <td style="width:350px"><label>OTROS INGRESOS</label></td>
                                                <td style="width:50px">$</td>
                                                <td style="width:150px" class="text-right"><label id="OTROS_INGRESOS" class="text-blue"></label></td>
                                                <td style="width:30px">&nbsp;</td>
                                                <td style="width:30px; border-left: solid">&nbsp;</td>
                                                <td style="width:350px"><label>OTROS EGRESOS</label></td>
                                                <td style="width:50px">$</td>
                                                <td style="width:150px" class="text-right"><label id="OTROS_EGRESOS" class="text-blue"></label></td>
                                            </tr>
                                            <tr>
                                                <td style="width:350px; border-bottom-style: solid;"><label>TOTAL INGRESOS</label></td>
                                                <td style="width:50px; border-bottom-style: solid;">$</td>
                                                <td style="width:150px; border-bottom-style: solid;" class="text-right"><label id="TOTAL_INGRESOS" class="text-blue"></label></td>
                                                <td style="width:30px; border-bottom-style: solid;">&nbsp;</td>
                                                <td style="width:30px; border-left: solid; border-bottom-style: solid;">&nbsp;</td>
                                                <td style="width:350px; border-bottom-style: solid;"><label>TOTAL EGRESOS</label></td>
                                                <td style="width:50px; border-bottom-style: solid;">$</td>
                                                <td style="width:150px; border-bottom-style: solid;" class="text-right"><label id="TOTAL_EGRESOS" class="text-blue"></label></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="border-bottom-style: solid;" class="text-right"><label>TOTAL A RECIBIR</label></td>
                                                <td colspan="2" style="border-bottom-style: solid;" class="text-center">$</td>
                                                <td colspan="3" style="border-bottom-style: solid;" class="text-left"><label id="TOTAL_A_PAGAR" class="text-blue"></label></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </center>
                                <div class="col-xs-12"><br></div>
                                <div class="col-xs-2"><br></div>
                                <div class="form-check col-xs-9">
                                    <label class="form-check-label ">
                                        <input id="acepta" name="acepta" type="checkbox" checked class="form-check-input" value="SI" required> <input style="width : 720px;" id="leyenda" name="leyenda" value="He leído y acepto el detalle completo de valores generados por mis actividades laboradas mediante el rol expuesto" disabled/>
                                    </label>
                                </div>
                                <div class="col-xs-12 text-center"><br/>
                                    <button class="btn btn-primary btn-sm" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                                    <button class="btn btn-danger btn-sm" onclick="cancelar_formulario()" type="button"><i class="fa fa-arrow-circle-left"></i> Regresar</button>
                                </div>
                            </form>
                        </div>                        
                    </div>
                </div> <!-- /formulario de registros -->
            </div>
    </section>
</div>
<?php require 'footer.php'; ?>
<script src="scripts/rolesDePagos.js" type="text/javascript"></script>