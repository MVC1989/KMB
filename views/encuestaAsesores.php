<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<style></style>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h4 class="text-bold">Encuesta Easy Life</h4> </div>
                    <div class="panel-body" id="formularioRegistros">
                        <form name="formulario" id="formulario" method="POST" class="">
                            <div class="col-xs-12">
                                <div class="box box-widget bg-gray-light">
                                    <div class="box-header with-border bg-gray">
                                        <div class="col-xs-1 text-left"> <span class="text-bold">Asesor/a:</span> </div>
                                        <div class="col-xs-2 text-left"> <span class="text-right"> <?php echo($_SESSION['name']); ?> </span> </div>
                                        <div class="col-xs-1 text-left"> <span class="text-bold">Fecha:</span> </div>
                                        <div class="col-xs-2 text-left"> <span id="mostrarHora" class="text-right">
                                                <?php
                                                date_default_timezone_set("America/Lima");
                                                echo(date('Y-m-d H:i:s'));
                                                ?>
                                            </span></div>
                                        <div class="box-tools">
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="pnlEncuesta1" class="col-xs-12 btn">
                                <div class="box box-widget bg-gray">
                                    <div class="box-body">
                                        <div class="col-xs-3">
                                            <p>Ingrese Cédula:</p>
                                        </div>
                                        <div class="col-xs-9">
                                            <input type="text" id="cedula" name="cedula" class="text-bold form-control" />
                                        </div>
                                        <div class="col-xs-3">
                                            <p>Ingrese Edad:</p>
                                        </div>
                                        <div class="col-xs-9">
                                            <input type="number" id="edad" name="edad" class="text-bold form-control" />
                                        </div>
                                        <div class="col-xs-3">
                                            <p>Ingrese Sexo:</p>
                                        </div>
                                        <div class="col-xs-9">
                                            <select class="form-control input-sm" id="sexo" name="sexo">
                                                <option></option>
                                                <option>FEMENINO</option>
                                                <option>MASCULINO</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-3">
                                            <p>Ingrese Estado Civil:</p>
                                        </div>
                                        <div class="col-xs-9">
                                            <select class="form-control input-sm" id="estadoCivil" name="estadoCivil">
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
                                        <div class="col-xs-12"><textarea id="pregunta1" name="pregunta1" class="text-bold form-control" readonly>¿Qué servicio utilizarías?</textarea></div>
                                        <div id="vehicular" class="col-xs-12">
                                            <div class="col-xs-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input id="chk_VEH1" name="chk_VEH1" value="chk_VEH1" type="checkbox">
                                                    </span>
                                                    <input id="respuesta2_VEH1" name="respuesta2_VEH1" type="text" value="SPA AUTOS" class="form-control" readonly>
                                                </div>
                                                <!-- /input-group -->
                                            </div>

                                            <div class="col-xs-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input id="chk_VEH2" name="chk_VEH2" value="chk_VEH2" type="checkbox">
                                                    </span>
                                                    <input id="respuesta2_VEH2" name="respuesta2_VEH2" type="text" value="SPA MUEBLES" class="form-control" readonly>
                                                </div>
                                                <!-- /input-group -->
                                            </div>

                                            <div class="col-xs-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input id="chk_VEH3" name="chk_VEH3" value="chk_VEH3" type="checkbox">
                                                    </span>
                                                    <input id="respuesta2_VEH3" name="respuesta2_VEH3" type="text" value="SERVICIO MANICURE + PEDICURE" class="form-control" readonly>
                                                </div>
                                                <!-- /input-group -->
                                            </div>

                                            <div class="col-xs-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input id="chk_VEH4" name="chk_VEH4" value="chk_VEH4" type="checkbox">
                                                    </span>
                                                    <input id="respuesta2_VEH4" name="respuesta2_VEH4" type="text" value="CHEF A DOMICILIO" class="form-control" readonly>
                                                </div>
                                                <!-- /input-group -->
                                            </div>

                                            <div class="col-xs-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input id="chk_VEH5" name="chk_VEH5" value="chk_VEH5" type="checkbox">
                                                    </span>
                                                    <input id="respuesta2_VEH5" name="respuesta2_VEH5" type="text" value="LIMPIEZA DE CASA" class="form-control" readonly>
                                                </div>
                                                <!-- /input-group -->
                                            </div>
                                        </div>
                                        <div class="col-xs-10"><textarea id="pregunta2" name="pregunta2" class="text-bold form-control" readonly>¿Cómo realizarías tu forma de pago?</textarea></div>
                                        <div class="col-xs-2">
                                            <select id="respuesta2" name="respuesta2" class="form-control">
                                                <option value=""></option>
                                                <option>FISICAMENTE</option>
                                                <option>PAGO ELECTRONICO</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-12 text-center"><br/>
                                            <button class="btn btn-primary btn-sm" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
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
<script src="scripts/encuestaEasyLife.js" type="text/javascript"></script>
<script src="scripts/funcions.js" type="text/javascript"></script>