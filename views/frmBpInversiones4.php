<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <label id="titulo2" class="h4 text-bold text-red">&nbsp;</label>
                        <label id="titulo" class="h4 text-bold">Campaña Banco Pichincha Incrementos</label>
                        <label id="titulo1" class="h4 text-bold text-red"></label>
                    </div>
                    <div class="panel-body table-responsive" id="listadoRegistros">
                        <table id="tblListado" class="table table-condensed table-hover table-responsive">
                            <thead>
                            <th>Num</th>
                            <th>Campaña</th>
                            <th>ImportId</th>
                            <th>Asesor</th>
                            <th>Identificación</th>
                            <th>Nombres cliente</th>
                            <th>Campo 1</th>
                            <th>Campo 2</th>
                            <th>Campo 3</th>
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
                                                </div><br>
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
                                                        <input type="text" class="form-control input-sm" id="intentos" name="intentos" readonly/>
                                                    </div>
                                                </div>
                                                <!--                                                <div class="col-xs-12" style='text-align:center;'>
                                                                                                    <button id="example"></button>
                                                
                                                                                                    <div class="zoom col-xs-1"><a href="#" title="Molesto"><p style="font-size:20px ">&#128545;</p></a></div>
                                                                                                    <div class="zoom col-xs-1"><a href="#" title="Ansioso/preocupado" style="font-size:20px ">&#128543;</a></div>
                                                                                                    <div class="zoom col-xs-1"><a href="#" title="Sereno/relajado"><p style="font-size:20px ">&#128526;</p></a></div>
                                                                                                    <div class="zoom col-xs-1"><a href="#" title="Ocupado/distraído"><p style="font-size:20px ">&#128533;</p></a></div>
                                                                                                    <div class="zoom col-xs-1"><a href="#" title="Contento/satisfecho"><p style="font-size:20px ">&#128512;</p></a></div>
                                                                                                </div>-->
                                                <!--                                                <div class="main">
                                                                                                     Reaction system start 
                                                                                                    <div class="reaction-container"> container div for reaction system 
                                                                                                        <span class="reaction-btn">  Default like button 
                                                                                                            <span class="reaction-btn-emo like-btn-default"></span>  Default like button emotion
                                                                                                            <span class="reaction-btn-text">Estado de animo del cliente</span>  Default like button text,(Like, wow, sad..) default:Like  
                                                                                                            <ul class="emojies-box">  Reaction buttons container
                                                                                                                <li class="emoji emo-like" data-reaction="Like"></li>
                                                                                                                <li class="emoji emo-love" data-reaction="Love"></li>
                                                                                                                <li class="emoji emo-haha" data-reaction="HaHa"></li>
                                                                                                                <li class="emoji emo-wow" data-reaction="Wow"></li>
                                                                                                                <li class="emoji emo-sad" data-reaction="Sad"></li>
                                                                                                                <li class="emoji emo-angry" data-reaction="Angry"></li>
                                                                                                            </ul>
                                                                                                        </span>
                                                                                                        <div class="like-stat hidden">  Like statistic container
                                                                                                            <span class="like-emo">  like emotions container 
                                                                                                                <span class="like-btn-like"></span>  given emotions like, wow, sad (default:Like) 
                                                                                                            </span>
                                                                                                            <span class="like-details">Knowband and 10k others</span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                     Reaction system end 
                                                                                                </div>-->
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
                            <div id="index">
                                <div class="col-xs-2 hidden"> <b class="text-bold text-aqua">CAMPANIA </b>
                                    <input type="text" class="form-control input-sm" id="code" name="code" readonly/>
                                    <input type="text" class="form-control input-sm" id="CAMPANIA" name="CAMPANIA" readonly/>
                                    <input type="text" class="form-control input-sm" id="IDC" name="IDC" readonly/>
                                </div>
                                <div class="col-xs-12 btn bg-gray-light">
                                    <div class="col-xs-2"> <b>IDENTIFICACION </b>
                                        <input type="text" class="form-control input-sm" id="IDENTIFICACION" name="IDENTIFICACION" readonly/>
                                    </div>
                                    <div class="col-xs-4"> <b>NOMBRE CLIENTE </b>
                                        <input type="text" class="form-control input-sm" id="NOMBRE_CLIENTE" name="NOMBRE_CLIENTE" readonly/>
                                    </div>
                                    <div class="col-xs-2"> <b>CAMPO 1 </b>
                                        <input type="text" class="form-control input-sm" id="CAMPO1" name="CAMPO1" readonly/>
                                    </div>
                                    <div class="col-xs-2"> <b>CAMPO 2 </b>
                                        <input type="text" class="form-control input-sm" id="CAMPO2" name="CAMPO2" readonly/>
                                    </div>
                                    <div class="col-xs-2"> <b>CAMPO 3 </b>
                                        <input type="text" class="form-control input-sm" id="CAMPO3" name="CAMPO3" readonly/>
                                    </div>
                                </div>
                            </div>
                            <div id="pnlEncuesta" class="col-xs-12 btn">
                                <div class="box box-widget bg-gray">
                                    <div class="box-body col-xs-12 btn">
                                        <!---------------------------------------------------------PREGUNTA 1---------------------------------------------------->
                                        <div class="col-xs-12"><textarea id="pregunta1" name="pregunta1" class="text-bold form-control" readonly>1. Cuáles serían sus metas o sueños para los que ahorraría a largo plazo (elija 2 o 3) y a qué plazo </textarea></div>
                                        <div class="col-xs-2">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input id="chk_ENC1" name="chk_ENC1" value="chk_ENC1" type="checkbox">
                                                </span>
                                                <input id="respuesta1" name="respuesta1" type="text" value="Estudios" class="form-control" readonly>
                                                <select id="respuesta2" name="respuesta2" class="form-control">
                                                    <option value=""></option>
                                                    <option >3 años</option>
                                                    <option >5 años</option>
                                                    <option >más de 5 años</option>
                                                </select>
                                            </div>
                                            <!-- /input-group -->
                                        </div>
                                        <div class="col-xs-2">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input id="chk_ENC2" name="chk_ENC2" value="chk_ENC2" type="checkbox">
                                                </span>
                                                <input id="respuesta3" name="respuesta3" type="text" value="Casa" class="form-control" readonly>
                                                <select id="respuesta4" name="respuesta4" class="form-control">
                                                    <option value=""></option>
                                                    <option >3 años</option>
                                                    <option >5 años</option>
                                                    <option >más de 5 años</option>
                                                </select>
                                            </div>
                                            <!-- /input-group -->
                                        </div>
                                        <div class="col-xs-2">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input id="chk_ENC3" name="chk_ENC3" value="chk_ENC3" type="checkbox">
                                                </span>
                                                <input id="respuesta5" name="respuesta5" type="text" value="Auto" class="form-control" readonly>
                                                <select id="respuesta6" name="respuesta6" class="form-control">
                                                    <option value=""></option>
                                                    <option >3 años</option>
                                                    <option >5 años</option>
                                                    <option >más de 5 años</option>
                                                </select>
                                            </div>
                                            <!-- /input-group -->
                                        </div>
                                        <div class="col-xs-2">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input id="chk_ENC4" name="chk_ENC4" value="chk_ENC4" type="checkbox">
                                                </span>
                                                <input id="respuesta7" name="respuesta7" type="text" value="Salud" class="form-control" readonly>
                                                <select id="respuesta8" name="respuesta8" class="form-control">
                                                    <option value=""></option>
                                                    <option >3 años</option>
                                                    <option >5 años</option>
                                                    <option >más de 5 años</option>
                                                </select>
                                            </div>
                                            <!-- /input-group -->
                                        </div>
                                        <div class="col-xs-2">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input id="chk_ENC5" name="chk_ENC5" value="chk_ENC5" type="checkbox">
                                                </span>
                                                <input id="respuesta9" name="respuesta9" type="text" value="Mi Retiro" class="form-control" readonly>
                                                <select id="respuesta10" name="respuesta10" class="form-control">
                                                    <option value=""></option>
                                                    <option >3 años</option>
                                                    <option >5 años</option>
                                                    <option >más de 5 años</option>
                                                </select>
                                            </div>
                                            <!-- /input-group -->
                                        </div>
                                        <div class="col-xs-2">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input id="chk_ENC6" name="chk_ENC6" value="chk_ENC6" type="checkbox">
                                                </span>
                                                <input id="respuesta11" name="respuesta11" type="text" value="Mi Negocio" class="form-control" readonly>
                                                <select id="respuesta12" name="respuesta12" class="form-control">
                                                    <option value=""></option>
                                                    <option >3 años</option>
                                                    <option >5 años</option>
                                                    <option >más de 5 años</option>
                                                </select>
                                            </div>
                                            <!-- /input-group -->
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 2---------------------------------------------------->
                                        <div class="col-xs-9"><textarea id="pregunta13" name="pregunta13" class="text-bold form-control" readonly>2. Le interesaría colocar un monto inicial en su meta o sueño</textarea></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta13" name="respuesta13" class="form-control">
                                                <option value=""></option>
                                                <option >Si</option>
                                                <option >No</option>
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 3---------------------------------------------------->
                                        <div class="col-xs-9"><input id="pregunta14" name="pregunta14" class="text-bold form-control" value="2.1 cual sería en monto (El cliente indica el monto y el asesor selecciona en el rango)?" readonly/></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta14" name="respuesta14" class="form-control">
                                                <option value=""></option>
                                                <option>De $500 a $1000</option >
                                                <option>De $1000 a $3000</option >
                                                <option>De $3001 en adelante</option >
                                            </select>
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 4---------------------------------------------------->
                                        <div class="col-xs-9"><input id="pregunta15" name="pregunta15" class="text-bold form-control" readonly value="3. Cuál sería el monto mensual que usted destinaria para cumplir esta meta o sueño (El cliente indica el monto y el asesor selecciona en el rango)"/></div>                                        
                                        <div class="col-xs-3">
                                            <select id="respuesta15" name="respuesta15" class="form-control">
                                                <option value=""></option>
                                                <option >De $100 a $200</option>
                                                <option >De $201 a $300</option>
                                                <option >De $301 a $500</option>
                                                <option >De $501 a $1000</option>
                                                <option >De $1001 en adelante</option>
                                            </select> 
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 5---------------------------------------------------->
                                        <div class="col-xs-9"><input id="pregunta16" name="pregunta16" class="text-bold form-control" readonly value="4. ¿Le gustaría que la cuota mensual para su meta o sueño sea debitada a su tarjeta de crédito?"/></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta16" name="respuesta16" class="form-control">
                                                <option value=""></option>
                                                <option >Si</option>
                                                <option >No</option>
                                            </select> 
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 6---------------------------------------------------->
                                        <div class="col-xs-9"><input id="pregunta17" name="pregunta17" class="text-bold form-control" readonly value="5. Si contrata el producto que beneficios adicionales le gustaría que el Banco ofreciera."/></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta17" name="respuesta17" class="form-control">
                                                <option value=""></option>
                                                <option >Premios</option>
                                                <option >Millas</option>
                                                <option >Cash Back (Devolver un porcentaje de lo que compras)</option>
												<option >Mejor tasa de interés</option>
												<option >Mayor Rentabilidad</option>
                                            </select> 
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 8---------------------------------------------------->
                                        <div class="col-xs-9"><input id="pregunta18" name="pregunta18" class="text-bold form-control" readonly value="6. A través de que canal se le facilitaría adquirir el producto."/></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta18" name="respuesta18" class="form-control">
                                                <option value=""></option>
                                                <option >Banca Móvil</option>
                                                <option >Banca Web</option>
                                                <option >Agencia</option>
                                            </select> 
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 9---------------------------------------------------->
                                        <div class="col-xs-9"><input id="pregunta19" name="pregunta19" class="text-bold form-control" readonly value="7. Tiene un producto similar en otra institución Financiera o Fondo de Inversión local o fuera del país."/></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta19" name="respuesta19" class="form-control">
                                                <option value=""></option>
                                                <option >Si</option>
                                                <option >No</option>
                                            </select> 
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 10---------------------------------------------------->
                                        <div class="col-xs-9"><input id="pregunta20" name="pregunta20" class="text-bold form-control" readonly value="7.1 Que institución Financiera o Fondo?"/></div>
                                        <div class="col-xs-3">
                                            <input id="respuesta20" name="respuesta20" type="text" class="form-control">
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 11---------------------------------------------------->
                                        <div class="col-xs-9"><input id="pregunta21" name="pregunta21" class="text-bold form-control" readonly value="8. ¿Estaría dispuesto a cambiar su ahorro programado con nosotros?"/></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta21" name="respuesta21" class="form-control">
                                                <option value=""></option>
                                                <option >Si</option>
                                                <option >No</option>
                                                <option >No sabe/ No responde </option>
                                            </select> 
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 11---------------------------------------------------->
                                        <div class="col-xs-9"><input id="pregunta22" name="pregunta22" class="text-bold form-control" readonly value="8.1 ¿Porque?"/></div>
                                        <div class="col-xs-3">
                                            <input id="respuesta22" name="respuesta22" type="text" class="form-control">
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 12---------------------------------------------------->
                                        <div class="col-xs-9"><input id="pregunta23" name="pregunta23" class="text-bold form-control" readonly value="9. ¿Le interesaría adquirir este producto a fin de cumplir sus sueños y objetivos de largo plazo? "/></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta23" name="respuesta23" class="form-control">
                                                <option value=""></option>
                                                <option >Si</option>
                                                <option >No</option>
                                                <option >No sabe/ No responde </option>
                                            </select> 
                                        </div>
                                        <!---------------------------------------------------------PREGUNTA 12---------------------------------------------------->
                                        <div class="col-xs-9"><input id="pregunta24" name="pregunta24" class="text-bold form-control" readonly value="10. ¿Qué atributos considera importantes en este tipo de producto de inversión ahorro en Banco Pichincha?"/></div>
                                        <div class="col-xs-3">
                                            <select id="respuesta24" name="respuesta24" class="form-control">
                                                <option value=""></option>
                                                <option >Seguridad y confianza</option>
                                                <option >Comodidad por el manejo de toda mi relación</option>
                                                <option >Atención y asesoría de mi Ejecutivo de negocio</option>
                                            </select> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </section>
</div>
<?php require 'footer.php'; ?>
<script src="scripts/bpInversionesIV_1.js" type="text/javascript"></script>
<script src="scripts/funcions.js" type="text/javascript"></script>