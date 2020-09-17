var tabla;
var tablaTCA;
var id;
function init() { /* función inicial */
    $("#btnGuardar").prop("disabled", true);
    mostrar_formulario(false);
    mostrar_todos();
    $('#formTCP').hide();
    $("#formulario").on("submit", function (e) {
        guardar_datos(e);
    });
    $("#formTCP").on("submit", function (e) {
        guardar_TCP(e);
    });
    //divs y paneles a ocultar
    $('#pnlProductos').hide();
    $('#infoAgencia').hide();
    $('#tipoCredito').hide();
    $('#pnlFvt').hide();
    $('#Creditos').hide();
    $('#tcPrincipal').hide();
    $('#tcAdicional').hide();
    $('#pnlAsistencia').hide();
    $('#textCell').hide();
    $('#textTelf').hide();
    $('#textTelfTrab').hide();
    $('#textCellTCA').hide();
    $('#textTelfTCA').hide();
    $('#textTelfTrabTCA').hide();
    $('#dependiente').hide();
    $('#independiente').hide();
    $('#otro').attr('disabled', true);
    $('#subestatus1').attr('disabled', true);
    $('#subestatus2').attr('disabled', true);
    $('#subestatus1TCP').attr('disabled', true);
    $('#subestatus2TCP').attr('disabled', true);
    $('#subestatus1TCA').attr('disabled', true);
    $('#subestatus2TCA').attr('disabled', true);
    $('#fonoAd').on("paste", function (e) {
        e.preventDefault();
    });
    $('#tlfC').on("paste", function (e) {
        e.preventDefault();
    });
    $('#dirdomTCP').on("copy", function (e) {
        e.preventDefault();
    });
    $('#dirTrabTCP').on("copy", function (e) {
        e.preventDefault();
    });
    $('#dirdomTCA').on("copy", function (e) {
        e.preventDefault();
    });
    $('#dirTrabTCA').on("copy", function (e) {
        e.preventDefault();
    });
    //$('#tblListadoTCA').hide();
    // deshabilitamos todoslos radios
//    var inputs = document.querySelectorAll("input[type=radio]");
//    for (var i = 0; i < inputs.length; i++)
//    {
//        inputs[i].disabled = true;
//    }
}

function limpiar_formulario() {
    document.getElementById("formulario").reset();
    $("#titulo").text("Campañas Banco Pichincha");
    $("#titulo1").text("");
    $("#titulo2").text("");
}

function cancelar_TCA() { /* función para cancelar la operación */
    $('#tcAdicional').hide();
}

function cancelar_formulario() { /* función para cancelar la operación */
    limpiar_formulario();
    mostrar_formulario(false);
    $("#titulo").text("Campañas Banco Pichincha");
    $("#titulo1").text("");
    $("#titulo2").text("");
}

function mostrar_formulario(flag) { /* muestra u oculta el formulario segun la validación del bool (flag) */
    limpiar_formulario();
    if (flag) {
        $("#listadoRegistros").hide();
        $("#formularioRegistros").show();
    } else {
        $("#listadoRegistros").show();
        $("#formularioRegistros").hide();
    }
}

function mostrar_todos() {
    tabla = $('#tblListado').dataTable({
        "lengthMenu": [5, 10, 25, 75, 100], //mostramos el menú de registros a revisar
        "aProcessing": true, /* activa el procesamiento de DataTables */
        "aServerSide": true, /* Paginación y filtrado realizado por el servidor */
        dom: '<Bl<f>rtip>', //Definimos los elementos del control de tabla
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        "ajax": {
            url: '../ajax/campaignBPC.php?action=selectAll',
            type: "get",
            dataType: "json",
            error: function (e) {
                console.log(e.responseText);
            }
        },
        "language": {
            "lengthMenu": "Mostrar : _MENU_ registros",
            "buttons": {
                "copyTitle": "Tabla Copiada",
                "copySuccess": {
                    _: '%d líneas copiadas',
                    1: '1 línea copiada'
                }
            }
        },
        "bDestroy": true,
        "iDisplayLength": 10, /* paginación */
        "order": [[0, "asc"]]
    }).DataTable();
    tabla.on('order.dt search.dt', function () {
        tabla.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }
    ).draw();
}

function mostrar_uno(Id) {
    $.post("../ajax/campaignBPC.php?action=selectById", {Id: Id}, function (datos, estado) {
        datos = JSON.parse(datos);
        mostrar_formulario(true);
        $.ajax({
            type: "GET",
            url: '../ajax/funcionesGeneralesC.php?action=horaInicio',
            data: {camp: camp},
            success: function (r) {
                $('#horaInicio').val(r);
                $('#mostrarHora').html(r);
            }
        });
        $("#titulo").text(datos.NOMBRE_CAMPANIA);
        $("#titulo1").text(datos.TIENE_DEUDA_PROTEGIDA);
        $("#titulo2").text(datos.NOMBRE);
        if (datos.Intentos == 0) {
            $("#intentos").val(1);
        } else {
            var int = parseInt(datos.Intentos) + 1;
            $("#intentos").val(int);
        }
        var result = datos.ResultLevel1 + ' - ' + datos.ResultLevel2;
        if (result == "Pendiente - Pendiente") {
            $("#last").val("Registro sin gestión");
        } else {
            $("#last").val(datos.ResultLevel1 + ' - ' + datos.ResultLevel2);
        }
        $("#obs").val(datos.Observaciones);
        $("#agenda").val(datos.FechaAgendamiento);
        $("#IDC").val(datos.ID);
        $("#CAMPANIA").val(datos.CampaignId);
        $("#CODIGO_CAMPANIA").val(datos.CODIGO_CAMPANIA);
        $("#NOMBRE_CAMPANIA").val(datos.NOMBRE_CAMPANIA);
        $("#NUPS").val(datos.NUPS);
        $("#IDENTIFICACION").val(datos.IDENTIFICACION);
        var nombres = datos.NOMBRE;
        var txt = nombres.replace('?','Ñ');
        $("#NOMBRE").val(txt.replace('?','Ñ'));
        $("#PERFILRIESGOENDEUDAMIENTO").val(datos.PERFILRIESGOENDEUDAMIENTO);
        $("#SUBSEGMENTO").val(datos.SUBSEGMENTO);
        $("#EDAD").val(datos.EDAD);
        $("#CREDITO_CONSUMO_ESCENARIO_1").val(datos.CREDITO_CONSUMO_ESCENARIO_1);
        if(datos.CREDITO_CONSUMO_ESCENARIO_1 == '' || datos.CREDITO_CONSUMO_ESCENARIO_1 == '0'){
            $("#oferta1").attr('disabled', true);
        }else{
            $("#oferta1").attr('disabled', false);
        }
        $("#CUOTA_CONSUMO_ESCENARIO_1").val(datos.CUOTA_CONSUMO_ESCENARIO_1);
        $("#PLAZO_CONSUMO_ESCENARIO_1").val(datos.PLAZO_CONSUMO_ESCENARIO_1);
        $("#GARANTE_CONSUMO_ESCENARIO_1").val(datos.GARANTE_CONSUMO_ESCENARIO_1);
        $("#TARJETA_ESCENARIO_1").val(datos.TARJETA_ESCENARIO_1);
        if(datos.TARJETA_ESCENARIO_1 == '' || datos.TARJETA_ESCENARIO_1 == '0'){
            $("#oferta2").attr('disabled', true);
        }else{
            $("#oferta2").attr('disabled', false);
        }
        $("#PLASTICO_1_TARJETA_ESCENARIO_1").val(datos.PLASTICO_1_TARJETA_ESCENARIO_1);
        $("#MARCA_ESCENARIO_1").val(datos.MARCA_ESCENARIO_1);
        $("#PRODUCTO_ESCENARIO_1").val(datos.PRODUCTO_ESCENARIO_1);
        $("#CREDITO_CONSUMO_EXCLUSIVO").val(datos.CREDITO_CONSUMO_EXCLUSIVO);
        if(datos.CREDITO_CONSUMO_EXCLUSIVO == '' || datos.CREDITO_CONSUMO_EXCLUSIVO == '0'){
            $("#oferta3").attr('disabled', true);
        }else{
            $("#oferta3").attr('disabled', false);
        }
        $("#CUOTA_CONSUMO_EXCLUSIVO").val(datos.CUOTA_CONSUMO_EXCLUSIVO);
        $("#PLAZO_CONSUMO_EXCLUSIVO").val(datos.PLAZO_CONSUMO_EXCLUSIVO);
        $("#GARANTE_CONSUMO_EXCLUSIVO").val(datos.GARANTE_CONSUMO_EXCLUSIVO);
        $("#CREDITO_CONSUMO_ROL").val(datos.CREDITO_CONSUMO_ROL);
        if(datos.CREDITO_CONSUMO_ROL == '' || datos.CREDITO_CONSUMO_ROL == '0'){
            $("#oferta5").attr('disabled', true);
        }else{
            $("#oferta5").attr('disabled', false);
        }
        $("#CUOTA_CONSUMO_ROL").val(datos.CUOTA_CONSUMO_ROL);
        $("#GARANTE_CONSUMO_ROL").val(datos.GARANTE_CONSUMO_ROL);
        $("#TARJETA_EXCLUSIVA").val(datos.TARJETA_EXCLUSIVA);
        if(datos.TARJETA_EXCLUSIVA == '' || datos.TARJETA_EXCLUSIVA == '0'){
            $("#oferta4").attr('disabled', true);
        }else{
            $("#oferta4").attr('disabled', false);
        }
        $("#PLASTICO_1_TARJETA_EXCLUSIVA").val(datos.PLASTICO_1_TARJETA_EXCLUSIVA);
        $("#MARCA_TARJETA_EXCLUSIVA").val(datos.MARCA_TARJETA_EXCLUSIVA);
        $("#PRODUCTO_TARJETA_EXCLUSIVA").val(datos.PRODUCTO_TARJETA_EXCLUSIVA);
        $("#MAXIMO_CONSUMO").val(datos.MAXIMO_CONSUMO);
        $("#MAXIMA_TARJETA").val(datos.MAXIMA_TARJETA);
        $("#BANCA").val(datos.BANCA);
        $("#SEGMENTO").val(datos.SEGMENTO);
        $("#SEGMENTO_N_2").val(datos.SEGMENTO_N_2);
        $("#SUBSEGMENTO1").val(datos.SUBSEGMENTO1);
        $("#REGION").val(datos.REGION);
        $("#ZONA").val(datos.ZONA);
        $("#AGENCIA").val(datos.AGENCIA);
        $("#FECHA_NACIMIENTO").val(datos.FECHA_NACIMIENTO);
        $("#SEXO").val(datos.SEXO);
        $("#ESTADO_CIVIL").val(datos.ESTADO_CIVIL);
        $("#PAIS_DOM_CAL_DAT").val(datos.PAIS_DOM_CAL_DAT);
        $("#PROV_DOM_CAL_DAT").val(datos.PROV_DOM_CAL_DAT);
        $("#CIUDAD_DOM_CAL_DAT").val(datos.CIUDAD_DOM_CAL_DAT);
        $("#DIR_DOM_CAL_DAT").val(datos.DIR_DOM_CAL_DAT);
        $("#PAIS_TRAB_1_CAL_DAT").val(datos.PAIS_TRAB_1_CAL_DAT);
        $("#PROV_TRAB_1_CAL_DAT").val(datos.PROV_TRAB_1_CAL_DAT);
        $("#CIUDAD_TRAB_1_CAL_DAT").val(datos.CIUDAD_TRAB_1_CAL_DAT);
        $("#DIR_TRAB_1_CAL_DAT").val(datos.DIR_TRAB_1_CAL_DAT);
        $("#IDENTIFICACION_PARENTEZCO").val(datos.IDENTIFICACION_PARENTEZCO);
        $("#CALIFICACION_BURO").val(datos.CALIFICACION_BURO);
        $("#NOMBRES").val(datos.NOMBRES);
        $("#DES_SEXO").val(datos.DES_SEXO);
        $("#FECH_NAC").val(datos.FECH_NAC);
        $("#NUMERO_CARGAS_FAMILIARES").val(datos.NUMERO_CARGAS_FAMILIARES);
        $("#TIENE_DEUDA_PROTEGIDA").val(datos.TIENE_DEUDA_PROTEGIDA);
        $("#TIENE_TDC").val(datos.TIENE_TDC);
        $("#COD_MARCA").val(datos.COD_MARCA);
        $("#PLAN_RECOMPENSAS").val(datos.PLAN_RECOMPENSAS);
        $("#FECHA_INGRESO_SOCIO").val(datos.FECHA_INGRESO_SOCIO);
        $("#NUMERO_CUENTA1").val(datos.NUMERO_CUENTA1);
        $("#PRODUCTO_CTA1").val(datos.PRODUCTO_CTA1);
        $("#DESCRIPCION1").val(datos.DESCRIPCION1);
        $("#CANAL").val(datos.CANAL);
        $("#DIFERENCIA_CUPOS").val(datos.DIFERENCIA_CUPOS);
        $("#CATEGORIZACION").val(datos.CATEGORIZACION);
        $("#TIPO_BASE").val(datos.TIPO_BASE);
        $("#REGION_ANCLAJE").val(datos.REGION_ANCLAJE);
        $("#PLAZO_CONSUMO_ROL").val(datos.PLAZO_CONSUMO_ROL);
        $("#CORREO1").val(datos.CORREO1);
        $("#CORREO2").val(datos.CORREO2);
        $("#CORREO3").val(datos.CORREO3);
        $("#CORREO4").val(datos.CORREO4);
        $("#CORREO5").val(datos.CORREO5);
        $("#CORREO6").val(datos.CORREO6);
        $("#DES_NACIONALID").val(datos.DES_NACIONALID);
        $("#CANT_NAC").val(datos.CANT_NAC);
        $("#ACTIVIDAD_ECONOMICA").val(datos.ACTIVIDAD_ECONOMICA);
        $("#DES_CANAL").val(datos.DES_CANAL);
        $("#CUENTA").val(datos.CUENTA);
        $("#NUMERO_TARJETA").val(datos.NUMERO_TARJETA);
        $("#PRODUCTO").val(datos.PRODUCTO);
        $("#TIPOTC").val(datos.TIPOTC);
        $("#FAMILIA").val(datos.FAMILIA);
        $("#CUPO").val(datos.CUPO);
        $("#CUPO_DISPONIBLE").val(datos.CUPO_DISPONIBLE);
        $("#HIJOS_MAS_18").val(datos.HIJOS_MAS_18);
        $("#HIJOS_MENOS_18").val(datos.HIJOS_MENOS_18);
        $("#HERMANOS_MENOS_18").val(datos.HERMANOS_MENOS_18);
        $("#HERMANOS_MAS_18").val(datos.HERMANOS_MAS_18);
        $("#MAMA").val(datos.MAMA);
        $("#PAPA").val(datos.PAPA);
        $("#CONYUG").val(datos.CONYUG);
        $("#MARCA_CUPO").val(datos.MARCA_CUPO);
        $("#NRO_TDC_COMPETENCIA").val(datos.NRO_TDC_COMPETENCIA);
        $("#CUPO_MAX_COMP").val(datos.CUPO_MAX_COMP);
        $("#CONSUMO_PROMEDIO").val(datos.CONSUMO_PROMEDIO);
        $("#PRIORIDAD_GESTION").val(datos.PRIORIDAD_GESTION);
        //****************INFORMACION DE TCP***************************************//
        $("#IdTCP").val(datos.ID);
        $("#NOMBRE1TCP").val(datos.NOMBRE1);
        $("#NOMBRE2TCP").val(datos.NOMBRE2);
        $("#APELLIDO1TCP").val(datos.APELLIDO1);
        $("#APELLIDO2TCP").val(datos.APELLIDO2);
        $("#generoTCP").val(datos.SEXO);
        $("#estadoCivilTCP").val(datos.ESTADO_CIVIL);
        $("#IDENTIFICACIONTCP").val(datos.IDENTIFICACION);
        $("#fecNacTCP").val(datos.FECHA_NACIMIENTO);
        $("#emailTCP").val(datos.CORREO1);
        $("#edadTCP").val(calculateAge(datos.FECHA_NACIMIENTO));
        $("#CUPOTCP").val(datos.CUPO);
        $("#dirdomTCP").val(datos.DIR_DOM_CAL_DAT);
        $("#dirTrabTCP").val(datos.DIR_TRAB_1_CAL_DAT);
        $("#PROD_ESCENARIO_1").val(datos.PRODUCTO_ESCENARIO_1);
        $("#PROD_TARJETA_EXCLUSIVA").val(datos.PRODUCTO_TARJETA_EXCLUSIVA);
        //****************INFORMACION DE TCA***************************************//
        $("#IdTCA").val(datos.ID);
        var idTitular = datos.ID;
        $('#tblListadoTCA').show();
        // $("#cuerpo").html(r);
        tablaTCA = $('#tblListadoTCA').dataTable({
            "lengthMenu": [5, 10, 25, 75, 100], //mostramos el menú de registros a revisar
            "aProcessing": true, /* activa el procesamiento de DataTables */
            "aServerSide": true, /* Paginación y filtrado realizado por el servidor */
            dom: '<Bl<f>rtip>', //Definimos los elementos del control de tabla
            buttons: [
            ],
            "ajax": {
                url: '../ajax/tarjetaAdicionalC.php?action=selectAll',
                data: {idTitular: idTitular},
                type: "get",
                dataType: "json",
                error: function (e) {
                    console.log(e.responseText);
                }
            },
            "language": {
                "lengthMenu": "Mostrar : _MENU_ registros",
                "buttons": {
                    "copyTitle": "Tabla Copiada",
                    "copySuccess": {
                        _: '%d líneas copiadas',
                        1: '1 línea copiada'
                    }
                }
            },
            "bDestroy": true,
            "iDisplayLength": 10, /* paginación */
            "order": [[0, "asc"]]
        }).DataTable();
        tablaTCA.on('order.dt search.dt', function () {
            tablaTCA.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }
        ).draw();
        $("#cedulaTitularTCA").val(datos.IDENTIFICACION);
        $("#nombresTitularTCA").val(datos.NOMBRE);
        $("#edadTCA").val(calculateAge(datos.FECHA_NACIMIENTO));
        $("#generoTCA").val(datos.SEXO);
        $("#ESTADO_CIVILTCA").val(datos.ESTADO_CIVIL);
        $("#FECHA_NACIMIENTOTCA").val(datos.FECHA_NACIMIENTO);
        $("#CORREOTCA").val(datos.CORREO1);
        $("#dirTrabTCA").val(datos.DIR_TRAB_1_CAL_DAT);
        $("#ACTECOTCA").val(datos.ACTIVIDAD_ECONOMICA);
        $("#LUGARNACTCA").val(datos.CANT_NAC);
        $("#cupoMaxTCA").val(datos.CUPO);
        var provinciaTrabTCA = datos.PROV_TRAB_1_CAL_DAT;
        $.ajax({
            type: "GET",
            url: '../ajax/tarjetaAdicionalC.php?action=provinciaTrab',
            data: {provinciaTrabTCA: provinciaTrabTCA},
            success: function (r) {
                $('#provinciaTrabTCA').html(r);
            }
        });
        var ciudadTrabTCA = datos.CIUDAD_TRAB_1_CAL_DAT;
        $.ajax({
            type: "GET",
            url: '../ajax/tarjetaAdicionalC.php?action=cuidadTrab',
            data: {provinciaTrabTCA: provinciaTrabTCA, ciudadTrabTCA: ciudadTrabTCA},
            success: function (r) {
                $('#ciudadTrabTCA').html(r);
            }
        });
        $("#dirdomTCA").val(datos.DIR_DOM_CAL_DAT);
        var provinciaDomTCA = datos.PROV_DOM_CAL_DAT;
        $.ajax({
            type: "GET",
            url: '../ajax/tarjetaAdicionalC.php?action=provinciaDom',
            data: {provinciaDomTCA: provinciaDomTCA},
            success: function (r) {
                $('#provinciaDomTCA').html(r);
            }
        });
        var ciudadDomTCA = datos.CIUDAD_DOM_CAL_DAT;
        $.ajax({
            type: "GET",
            url: '../ajax/tarjetaAdicionalC.php?action=cuidadDom',
            data: {provinciaDomTCA: provinciaDomTCA, ciudadDomTCA: ciudadDomTCA},
            success: function (r) {
                $('#ciudadDomTCA').html(r);
            }
        });
        $("#tarjetaTitularTCA").val(datos.PRODUCTO);
        //$("#generoTCA").selectpicker('refresh');
        var camp = datos.CampaignId;
        if (camp != "") {
            $.ajax({
                type: "GET",
                url: '../ajax/campaignBPC.php?action=estatus',
                data: {camp: camp},
                success: function (r) {
                    $('#level1').html(r);
                }
            });
        }
        var idC = datos.ID;
        if (idC != "") {
            $.ajax({
                type: "GET",
                url: '../ajax/campaignBPC.php?action=telefonos',
                data: {idC: idC},
                success: function (r) {
                    $('#fonos').html(r);
                }
            });
            $.ajax({
                type: "GET",
                url: '../ajax/tarjetaPrincipalC.php?action=onlyCel',
                data: {idC: idC},
                success: function (r) {
                    $('#celularTextTCP').html(r);
                    $('#celularTextTCA').html(r);
                }
            });
            $.ajax({
                type: "GET",
                url: '../ajax/tarjetaPrincipalC.php?action=onlyConv',
                data: {idC: idC},
                success: function (r) {
                    $('#telfTextTCP').html(r);
                    $('#telfTextTrabTCP').html(r);
                    $('#telfTextTCA').html(r);
                    $('#telfTextTrabTCA').html(r);
                }
            });
        }
    });
}
function copyToClipboard(elemento) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(elemento).text()).select();
    document.execCommand("copy");
    $temp.remove();
}

$("#subestatus1").change(function () {
    var level1 = $("#subestatus1 option:selected").text();
    var camp = $("#CAMPANIA").val();
    if (level1 != "") {
        $.ajax({
            type: "GET",
            url: '../ajax/campaignBPC.php?action=level2',
            data: {level1: level1, camp: camp},
            success: function (r) {
                $('#subestatus2').html(r);
            }
        });
    }
});

$("#subestatus1TCP").change(function () {
    var level1 = $("#subestatus1TCP option:selected").text();
    var camp = $("#CAMPANIA").val();
    if (level1 != "") {
        $.ajax({
            type: "GET",
            url: '../ajax/campaignBPC.php?action=level2',
            data: {level1: level1, camp: camp},
            success: function (r) {
                $('#subestatus2TCP').html(r);
            }
        });
    }
});

$("#subestatus1TCA").change(function () {
    var level1 = $("#subestatus1TCA option:selected").text();
    var camp = $("#CAMPANIA").val();
    if (level1 != "") {
        $.ajax({
            type: "GET",
            url: '../ajax/campaignBPC.php?action=level2',
            data: {level1: level1, camp: camp},
            success: function (r) {
                $('#subestatus2TCA').html(r);
            }
        });
    }
});

$("#level1").change(function () {
    var level1 = $("#level1 option:selected").text();
    var camp = $("#CAMPANIA").val();
    if (level1 != "") {
        $.ajax({
            type: "GET",
            url: '../ajax/campaignBPC.php?action=level2',
            data: {level1: level1, camp: camp},
            success: function (r) {
                $('#level2').html(r);
            }
        });
    }
    var text = $("#level1").val().substring(0, 3);
    if (text == "CU4") {
        $("#agenda").attr("readonly", false);
        $("#agenda").attr("required", true);
        $("#obs").attr("required", true);
    } else {
        $("#agenda").attr("readonly", true);
        $("#agenda").attr("required", false);
        $("#obs").attr("required", false);
    }
    if (text == "CU4" || text == "CU5" || text == "CU6" || text == "CU7" || text == "NU1" || text == "NU2") {
        $('#verOfertas').hide();
        $('#tipoCredito').hide();
        $('#Creditos').hide();
        $('#pnlFvt').hide();
        $('#tcPrincipal').hide();
        $('#oferta1').prop('required', false);
        $('#oferta2').prop('required', false);
        $('#oferta3').prop('required', false);
        $('#oferta4').prop('required', false);
        $('#oferta5').prop('required', false);
        $('#vAgencia').prop('required', false);
        $('#fvt').prop('required', false);
        $('#asistencia').prop('required', false);
        $('#subestatus1').prop('required', false);
        $('#subestatus2').prop('required', false);
        $('#subestatus1TCP').prop('required', false);
        $('#subestatus2TCP').prop('required', false);
        $('#txtMonto').prop('required', false);
        $('#fechaV').prop('required', false);
        $('#horaV').prop('required', false);
        $('#tipoC').prop('required', false);
        $('#regionC').prop('required', false);
        $('#ciudadC').prop('required', false);
        $('#vAgencia').prop('required', false);
        $('#tlfFvt').prop('required', false);
        dataRequiredTCP(false);
        $('#celularTCP').attr("required", false);
        $('#celularTextTCP').attr("required", false);
        $('#telfTCP').attr("required", false);
        $('#telfTextTCP').attr("required", false);
        $('#selectTrabTextTelf').attr("required", false);
        $('#telfTextTrabTCP').attr("required", false);
        $('#empresaTCP').prop('required', false);
        $('#contratoTCP').prop('required', false);
        $('#fechaIniTCP').prop('required', false);
        $('#cargoTCP').prop('required', false);
        $('#sueldoTCP').prop('required', false);
        $('#gastosTCP').prop('required', false);
        $('#negocioTCP').prop('required', false);
        $('#ventasTCP').prop('required', false);
        $('#costoTCP').prop('required', false);
        $('#actEcoTCP').prop('required', false);
        $('#gastosOpeTCP').prop('required', false);
        $('#fechaIniNegTCP').prop('required', false);
        $('#tcAdicional').hide();
        $('#celularTCA').attr("required", false);
        $('#celularTextTCA').attr("required", false);
        $('#telfTCA').attr("required", false);
        $('#telfTextTCA').attr("required", false);
        $('#selectTrabTextTelfTCA').attr("required", false);
        $('#telfTextTrabTCA').attr("required", false);
    }
    if (text == "CU5") {
        $('#pnlProductos').show();
        $('#producto').attr("required", true);
    } else {
        $('#pnlProductos').hide();
        $('#producto').attr("required", false);
        $('#listadoProd').attr('disabled', true);
        $('#listadoProd').attr('required', false);
        $('#otroProd').attr('required', false);
        $('#otroProd').attr('readonly', true);
        $('#otroProd').attr('required', false);
    }
});

$('#producto').change(function () {
    if ($('#producto').val() == "SI") {
        $('#listadoProd').attr('disabled', false);
        $('#listadoProd').attr('required', true);
    } else {
        $('#listadoProd').attr('disabled', true);
        $('#listadoProd').attr('required', false);
    }
});

$('#listadoProd').change(function () {
    if ($('#listadoProd').val() == "OTROS") {
        $('#otroProd').attr('readonly', false);
        $('#otroProd').attr('required', true);
    } else {
        $('#otroProd').attr('readonly', true);
        $('#otroProd').attr('required', false);
    }
});

$("#level2").change(function () {
    $("#btnGuardar").prop("disabled", false);
    var level1 = $("#level1 option:selected").text();
    var level2 = $("#level2 option:selected").text();
    var camp = $("#CAMPANIA").val();
    if (level1 !== "" && level2 !== "") {
        id = $.ajax({
            type: "GET",
            url: '../ajax/campaignBPC.php?action=code',
            data: {camp: camp, level1: level1, level2: level2},
            success: function (r) {
                $('#code').val(r);
                if (r == 1) {
                    $('#tcAdicional').show();
                    dataRequiredTCP(false);
                    $('#pnlAsistencia').hide();
                    $('#verOfertas').hide();
                    $('#espOfertas').hide();
                    $('#tipoCredito').hide();
                    $('#Creditos').hide();
                    //$('#tcPrincipal').html($('#formTCP').hide());
                    $('#tcPrincipal').hide();
                    $('#oferta1').prop('required', false);
                    $('#oferta2').prop('required', false);
                    $('#oferta3').prop('required', false);
                    $('#oferta4').prop('required', false);
                    $('#oferta5').prop('required', false);
                    $('#vAgencia').prop('required', false);
                    $('#fvt').prop('required', false);
                    $('#asistencia').prop('required', false);
                    $('#subestatus1').prop('required', false);
                    $('#subestatus2').prop('required', false);
                    $('#subestatus1TCP').prop('required', false);
                    $('#subestatus2TCP').prop('required', false);
                    $('#txtMonto').prop('required', false);
                    $('#fechaV').prop('required', false);
                    $('#horaV').prop('required', false);
                    $('#tipoC').prop('required', false);
                    $('#regionC').prop('required', false);
                    $('#ciudadC').prop('required', false);
                    $('#vAgencia').prop('required', false);
                    $('#tlfFvt').prop('required', false);
                    $('#celularTCP').attr("required", false);
                    $('#celularTextTCP').attr("required", false);
                    $('#telfTCP').attr("required", false);
                    $('#telfTextTCP').attr("required", false);
                    $('#selectTrabTextTelf').attr("required", false);
                    $('#telfTextTrabTCP').attr("required", false);
                    $('#empresaTCP').prop('required', false);
                    $('#contratoTCP').prop('required', false);
                    $('#fechaIniTCP').prop('required', false);
                    $('#cargoTCP').prop('required', false);
                    $('#sueldoTCP').prop('required', false);
                    $('#gastosTCP').prop('required', false);
                    $('#negocioTCP').prop('required', false);
                    $('#ventasTCP').prop('required', false);
                    $('#costoTCP').prop('required', false);
                    $('#actEcoTCP').prop('required', false);
                    $('#gastosOpeTCP').prop('required', false);
                    $('#fechaIniNegTCP').prop('required', false);
                }
                if (r == 2) {
                    //$('#tcPrincipal').html($('#formTCP').hide());
                    $('#tcAdicional').hide();
                    dataRequiredTCP(false);
                    $('#verOfertas').show();
                    $('#tcPrincipal').hide();
                    $('#tipoCredito').show();
                    $('#Creditos').show();
                    $('#pnlAsistencia').show();
                    if ($("#of").val() == "") {
                        bootbox.alert("Seleccione una oferta");
                        $('#oferta1').prop('required', true);
                        $('#oferta2').prop('required', true);
                        $('#oferta3').prop('required', true);
                        $('#oferta4').prop('required', true);
                        $('#oferta5').prop('required', true);
                        $('#asistencia').prop('required', true);
                        $('#subestatus1').prop('required', true);
                        $('#subestatus2').prop('required', true);
                    }
                    $('#vAgencia').prop('required', true);
                    $('#fvt').prop('required', true);
                }
                if (r == 3) {
                    //$('#tcPrincipal').html($('#formTCP').show());
                    $('#tcAdicional').hide();
                    dataRequiredTCP(true);
                    $('#verOfertas').show();
                    $('#tcPrincipal').show();
                    $('#tipoCredito').hide();
                    $('#Creditos').hide();
                    $('#pnlAsistencia').hide();
                    if ($("#of").val() == "") {
                        
//                        $('#oferta1').prop('required', true);
//                        $('#oferta2').prop('required', true);
//                        $('#oferta3').prop('required', true);
//                        $('#oferta4').prop('required', true);
//                        $('#oferta5').prop('required', true);
                    }
                    $('#vAgencia').prop('required', false);
                    $('#fvt').prop('required', false);
                }
                if (r == 11 || r == 12) {
                    $('#tcAdicional').show();
                }
                if (r == 13 || r == 14 || r == 17 || r == 19) {
                    //$('#tcPrincipal').html($('#formTCP').show());
                    $('#tcAdicional').hide();
                    dataRequiredTCP(true);
                    $('#verOfertas').show();
                    $('#tcPrincipal').show();
                    $('#tipoCredito').show();
                    $('#Creditos').show();
                    $('#pnlAsistencia').show();
                    if ($("#of").val() == "") {
                        //bootbox.alert("Seleccione una oferta");
                        $('#oferta1').prop('required', true);
                        $('#oferta2').prop('required', true);
                        $('#oferta3').prop('required', true);
                        $('#oferta4').prop('required', true);
                        $('#oferta5').prop('required', true);
                    }
                    $('#vAgencia').prop('required', true);
                    $('#fvt').prop('required', true);
                }
                if (r == 15 || r == 16) {
                    //$('#tcPrincipal').html($('#formTCP').hide());
                    $('#tcAdicional').hide();
                    $('#verOfertas').show();
                    dataRequiredTCP(false);
                    $('#tcPrincipal').hide();
                    $('#tipoCredito').show();
                    $('#Creditos').show();
                    $('#pnlAsistencia').show();
                    if ($("#of").val() == "") {
                        $('#oferta1').prop('required', true);
                        $('#oferta2').prop('required', true);
                        $('#oferta3').prop('required', true);
                        $('#oferta4').prop('required', true);
                        $('#oferta5').prop('required', true);
                        $('#asistencia').prop('required', true);
                        $('#subestatus1').prop('required', true);
                        $('#subestatus2').prop('required', true);
                    }
                }
                if (r == 18 || r == 20 || r == 21 || r == 22 || r == 23) {
                    //$('#tcPrincipal').html($('#formTCP').show());
                    if (r == 20 || r == 21 || r == 22 || r == 23) {
                        $('#tcAdicional').show();
                    } else {
                        $('#tcAdicional').hide();
                    }
                    $('#verOfertas').show();
                    $('#tcPrincipal').show();
                    dataRequiredTCP(true);
                    $('#tipoCredito').hide();
                    $('#Creditos').hide();
                    $('#pnlAsistencia').hide();
                    if ($("#of").val() == "") {
                        $('#oferta1').prop('required', true);
                        $('#oferta2').prop('required', true);
                        $('#oferta3').prop('required', true);
                        $('#oferta4').prop('required', true);
                        $('#oferta5').prop('required', true);
                    }
                }
                if ((r >= 4 && r <= 12) || (r >= 24 && r <= 33) || r > 34) {
                    if (r == 12 || r == 11) {
                        $('#tcAdicional').show();
                    } else {
                        $('#tcAdicional').hide();
                    }
                    dataRequiredTCP(false);
                    $('#pnlAsistencia').hide();
                    $('#verOfertas').hide();
                    $('#espOfertas').hide();
                    $('#tipoCredito').hide();
                    $('#Creditos').hide();
                    //$('#tcPrincipal').html($('#formTCP').hide());
                    $('#tcPrincipal').hide();
                    $('#oferta1').prop('required', false);
                    $('#oferta2').prop('required', false);
                    $('#oferta3').prop('required', false);
                    $('#oferta4').prop('required', false);
                    $('#oferta5').prop('required', false);
                    $('#vAgencia').prop('required', false);
                    $('#fvt').prop('required', false);
                    $('#asistencia').prop('required', false);
                    $('#subestatus1').prop('required', false);
                    $('#subestatus2').prop('required', false);
                    $('#subestatus1TCP').prop('required', false);
                    $('#subestatus2TCP').prop('required', false);
                    $('#txtMonto').prop('required', false);
                    $('#fechaV').prop('required', false);
                    $('#horaV').prop('required', false);
                    $('#tipoC').prop('required', false);
                    $('#regionC').prop('required', false);
                    $('#ciudadC').prop('required', false);
                    $('#vAgencia').prop('required', false);
                    $('#tlfFvt').prop('required', false);
                    $('#celularTCP').attr("required", false);
                    $('#celularTextTCP').attr("required", false);
                    $('#telfTCP').attr("required", false);
                    $('#telfTextTCP').attr("required", false);
                    $('#selectTrabTextTelf').attr("required", false);
                    $('#telfTextTrabTCP').attr("required", false);
                    $('#empresaTCP').prop('required', false);
                    $('#contratoTCP').prop('required', false);
                    $('#fechaIniTCP').prop('required', false);
                    $('#cargoTCP').prop('required', false);
                    $('#sueldoTCP').prop('required', false);
                    $('#gastosTCP').prop('required', false);
                    $('#negocioTCP').prop('required', false);
                    $('#ventasTCP').prop('required', false);
                    $('#costoTCP').prop('required', false);
                    $('#actEcoTCP').prop('required', false);
                    $('#gastosOpeTCP').prop('required', false);
                    $('#fechaIniNegTCP').prop('required', false);
                    $('#celularTCA').attr("required", false);
                    $('#celularTextTCA').attr("required", false);
                    $('#telfTCA').attr("required", false);
                    $('#telfTextTCA').attr("required", false);
                    $('#selectTrabTextTelfTCA').attr("required", false);
                    $('#telfTextTrabTCA').attr("required", false);
                }
                if ((r >= 17 && r <= 23) || r == 3 || r == 13 || r == 14) {
                    if ($('#otroCell').is(":checked")) {
                        $('#textCell').show();
                        $('#celularTCP').attr("required", true);
                        $('#celularTextTCP').attr("required", false);
                        $('#selectCell').hide();
                        $('#celularTextTCP option:selected').prop('selected', false).find('option:first').prop('selected', true);
                    } else {
                        $('#selectCell').show();
                        $('#celularTextTCP').attr("required", true);
                        $('#celularTCP').attr("required", false);
                        $('#textCell').hide();
                        $('#celularTCP').val('');
                    }
                    if ($('#otroTelf').is(":checked")) {
                        $('#textTelf').show();
                        $('#telfTCP').attr("required", true);
                        $('#telfTextTCP').attr("required", false);
                        $('#selectTelf').hide();
                        $('#telfTextTCP option:selected').prop('selected', false).find('option:first').prop('selected', true);
                    } else {
                        $('#selectTelf').show();
                        $('#telfTextTCP').attr("required", true);
                        $('#telfTCP').attr("required", false);
                        $('#textTelf').hide();
                        $('#telfTCP').val('');
                    }
                    if ($('#otroTrabTelf').is(":checked")) {
                        $('#textTelfTrab').show();
                        $('#selectTrabTextTelf').attr("required", true);
                        $('#telfTextTrabTCP').attr("required", false);
                        $('#selectTelfTrab').hide();
                        $('#telfTextTrabTCP option:selected').prop('selected', false).find('option:first').prop('selected', true);
                    } else {
                        $('#selectTelfTrab').show();
                        $('#telfTextTrabTCP').attr("required", true);
                        $('#selectTrabTextTelf').attr("required", false);
                        $('#textTelfTrab').hide();
                        $('#selectTrabTextTelf').val('');
                    }
                }
            }
        });
    }
});

$('#asistencia').change(function () {
    if ($('#asistencia option:selected').text() == "SI") {
        $('#acepta').val("SI");
        $('#asistencia').prop('required', false);
        $('#subestatus1').prop('required', false);
        $('#subestatus2').prop('required', false);
        $('#subestatus1').attr('disabled', true);
        $('#subestatus2').attr('disabled', true);
    } else if ($('#asistencia option:selected').text() == "NO") {
        $('#acepta').val("NO");
        $('#asistencia').prop('required', true);
        $('#subestatus1').prop('required', true);
        $('#subestatus2').prop('required', true);
        $('#subestatus1').attr('disabled', false);
        $('#subestatus2').attr('disabled', false);
    }
});

$('#pdpTCP').change(function () {
    if ($('#pdpTCP option:selected').val() == "SI") {
        $('#subestatus1TCP').attr('disabled', true);
        $('#subestatus2TCP').attr('disabled', true);
    } else if ($('#pdpTCP option:selected').text() == "NO") {
        $('#subestatus1TCP').attr('disabled', false);
        $('#subestatus2TCP').attr('disabled', false);
    }
});

$('#pdpTCA').change(function () {
    if ($('#pdpTCA option:selected').val() == "SI") {
        $('#subestatus1TCA').attr('disabled', true);
        $('#subestatus2TCA').attr('disabled', true);
    } else if ($('#pdpTCA option:selected').text() == "NO") {
        $('#subestatus1TCA').attr('disabled', false);
        $('#subestatus2TCA').attr('disabled', false);
    }
});

$('#cbox1').change(function () {
    if ($(this).is(":checked")) {
        $('#verOfertas').show();
        $('#espOfertas').show();
    } else {
        $('#verOfertas').hide();
        $('#espOfertas').hide();
    }
});

$('#cbox2').change(function () {
    if ($(this).is(":checked")) {
        $('#otro').attr('disabled', true);
        $('#otro').attr('required', false);
    } else {
        $('#otro').attr('disabled', false);
        $('#otro').attr('required', true);
    }
});

$('#oferta1').change(function () {
    $("#of").val("OFERTA 1");
    $("#ofertaTDC").val("OFERTA 1");
    $('#oferta1').prop('required', false);
    $('#oferta2').prop('required', false);
    $('#oferta3').prop('required', false);
    $('#oferta4').prop('required', false);
    $('#oferta5').prop('required', false);
});

$('#oferta2').change(function () {
    $("#of").val("OFERTA 1");
    $("#ofertaTDC").val("OFERTA 1");
    $('#oferta1').prop('required', false);
    $('#oferta2').prop('required', false);
    $('#oferta3').prop('required', false);
    $('#oferta4').prop('required', false);
    $('#oferta5').prop('required', false);
});

$('#oferta3').change(function () {
    $("#of").val("OFERTA 2");
    $("#ofertaTDC").val("OFERTA 2");
    $('#oferta1').prop('required', false);
    $('#oferta2').prop('required', false);
    $('#oferta3').prop('required', false);
    $('#oferta4').prop('required', false);
    $('#oferta5').prop('required', false);
});

$('#oferta4').change(function () {
    $("#of").val("OFERTA 4");
    $("#ofertaTDC").val("OFERTA 4");
    $('#oferta1').prop('required', false);
    $('#oferta2').prop('required', false);
    $('#oferta3').prop('required', false);
    $('#oferta4').prop('required', false);
    $('#oferta5').prop('required', false);
});

$('#oferta5').change(function () {
    $("#of").val("OFERTA 3");
    $("#ofertaTDC").val("OFERTA 3");
    $('#oferta1').prop('required', false);
    $('#oferta2').prop('required', false);
    $('#oferta3').prop('required', false);
    $('#oferta4').prop('required', false);
    $('#oferta5').prop('required', false);
});

$('#btnFonos').click(function () {
    var phones = $("#fonos option:selected").text();
    var estatusTel = $("#estatusTel option:selected").text();
    if (phones != "" && estatusTel != "") {
        var IDC = $("#IDC").val();
        $.ajax({
            url: '../ajax/campaignBPC.php?action=updatePhones',
            method: 'POST',
            data: {IDC: IDC, fonos: phones, estatusTel: estatusTel},
            success: function (r) {
                bootbox.alert(r);
                $.ajax({
                    type: "GET",
                    url: '../ajax/campaignBPC.php?action=telefonos',
                    data: {idC: IDC},
                    success: function (r) {
                        $('#fonos').html(r);
                    }
                });
                $('#estatusTel option:selected').prop('selected', false).find('option:first').prop('selected', true);
            }
        });
    } else {
        bootbox.alert({
            message: "Seleccione un número y estado para continuar!",
            size: 'medium'

        });
    }
});

$('#vAgencia').change(function () {
    if ($(this).is(":checked")) {
        $("#tip").val("AGENCIA");
        $('#infoAgencia').show();
        $('#txtMonto').prop('required', true);
        $('#fechaV').prop('required', true);
        $('#horaV').prop('required', true);
        $('#tipoC').prop('required', true);
        $('#regionC').prop('required', true);
        $('#ciudadC').prop('required', true);
        $('#telf1').hide();
        $('#horario1').hide();
        $('#dir1').hide();
        $('#vAgencia').prop('required', false);
        $('#fvt').prop('required', false);
        $('#pnlFvt').hide();
        $('#tlfFvt').prop('required', false);
    }
});

$('#fvt').change(function () {
    if ($(this).is(":checked")) {
        $("#tip").val("FVT");
        $('#infoAgencia').hide();
        $('#txtMonto').prop('required', false);
        $('#fechaV').prop('required', false);
        $('#horaV').prop('required', false);
        $('#tipoC').prop('required', false);
        $('#regionC').prop('required', false);
        $('#ciudadC').prop('required', false);
        $('#vAgencia').prop('required', false);
        $('#fvt').prop('required', false);
        $('#pnlFvt').show();
        $('#tlfFvt').prop('required', true);
    }
});

$("#regionC").change(function () {
    var regionC = $("#regionC option:selected").text();
    if (regionC != "") {
        $.ajax({
            type: "GET",
            url: '../ajax/campaignBPC.php?action=cuidadAgencia',
            data: {regionC: regionC},
            success: function (r) {
                $('#ciudadC').html(r);
            }
        });
    }
});

$("#tipoOfC").change(function () {
    var regionC = $("#regionC option:selected").text();
    var ciudadC = $("#ciudadC option:selected").text();
    var tipoOfC = $("#tipoOfC option:selected").text();
    if (regionC != "" && ciudadC != "" && tipoOfC != "") {
        $.ajax({
            type: "GET",
            url: '../ajax/campaignBPC.php?action=agencia',
            data: {ciudadC: ciudadC, regionC: regionC, tipoOfC: tipoOfC},
            success: function (r) {
                $('#agenciaC').html(r);
            }
        });
    }
});

$("#agenciaC").change(function () {
    var regionC = $("#regionC option:selected").text();
    var ciudadC = $("#ciudadC option:selected").text();
    var tipoOfC = $("#tipoOfC option:selected").text();
    var agenciaC = $("#agenciaC option:selected").text();
    if (regionC != "" && ciudadC != "" && tipoOfC != "") {
        $.ajax({
            type: "GET",
            url: '../ajax/campaignBPC.php?action=dirAgencia',
            data: {agenciaC: agenciaC, ciudadC: ciudadC, regionC: regionC, tipoOfC: tipoOfC},
            success: function (r) {
                $('#dir2').hide();
                $('#dir1').show();
                $('#dir1').html(r);
            }
        });
        $.ajax({
            type: "GET",
            url: '../ajax/campaignBPC.php?action=horAgencia',
            data: {agenciaC: agenciaC, ciudadC: ciudadC, regionC: regionC, tipoOfC: tipoOfC},
            success: function (r) {
                $('#horario2').hide();
                $('#horario1').show();
                $('#horario1').html(r);
            }
        });
        $.ajax({
            type: "GET",
            url: '../ajax/campaignBPC.php?action=telAgencia',
            data: {agenciaC: agenciaC, ciudadC: ciudadC, regionC: regionC, tipoOfC: tipoOfC},
            success: function (r) {
                $('#telf2').hide();
                $('#telf1').show();
                $('#telf1').html(r);
            }
        });
    }
});

/**************************************TARJETA PRINCIPAL******************************************************/

$("#provinciaNacTCP").change(function () {
    var provinciasTCP = $("#provinciaNacTCP option:selected").val();
    if (provinciasTCP != "") {
        $.ajax({
            type: "GET",
            url: '../ajax/tarjetaPrincipalC.php?action=cuidades',
            data: {provinciasTCP: provinciasTCP},
            success: function (r) {
                $('#ciudadNacTCP').html(r);
            }
        });
    }
});

$('#otroCell').change(function () {
    if ($(this).is(":checked")) {
        $('#textCell').show();
        $('#celularTCP').attr("required", true);
        $('#celularTextTCP').attr("required", false);
        $('#selectCell').hide();
        $('#celularTextTCP option:selected').prop('selected', false).find('option:first').prop('selected', true);
    } else {
        $('#selectCell').show();
        $('#celularTextTCP').attr("required", true);
        $('#celularTCP').attr("required", false);
        $('#textCell').hide();
        $('#celularTCP').val('');
    }
});

$('#otroTelf').change(function () {
    if ($(this).is(":checked")) {
        $('#textTelf').show();
        $('#telfTCP').attr("required", true);

        validatePhoneConvencional($('#telfTCP').val());

        $('#telfTextTCP').attr("required", false);
        $('#selectTelf').hide();
        $('#telfTextTCP option:selected').prop('selected', false).find('option:first').prop('selected', true);
    } else {
        $('#selectTelf').show();
        $('#telfTextTCP').attr("required", true);
        $('#telfTCP').attr("required", false);
        $('#textTelf').hide();
        $('#telfTCP').val('');
    }
});

$("#provinciaDomTCP").change(function () {
    var provinciasTCP = $("#provinciaDomTCP option:selected").val();
    if (provinciasTCP != "") {
        $.ajax({
            type: "GET",
            url: '../ajax/tarjetaPrincipalC.php?action=cuidades',
            data: {provinciasTCP: provinciasTCP},
            success: function (r) {
                $('#ciudadDomTCP').html(r);
            }
        });
    }
});

$("#provinciaTrabTCP").change(function () {
    var provinciasTCP = $("#provinciaTrabTCP option:selected").val();
    if (provinciasTCP != "") {
        $.ajax({
            type: "GET",
            url: '../ajax/tarjetaPrincipalC.php?action=cuidades',
            data: {provinciasTCP: provinciasTCP},
            success: function (r) {
                $('#ciudadTrabTCP').html(r);
            }
        });
    }
});

$('#otroTrabTelf').change(function () {
    if ($(this).is(":checked")) {
        $('#textTelfTrab').show();
        $('#selectTrabTextTelf').attr("required", true);
        $('#telfTextTrabTCP').attr("required", false);
        $('#selectTelfTrab').hide();
        $('#telfTextTrabTCP option:selected').prop('selected', false).find('option:first').prop('selected', true);
    } else {
        $('#selectTelfTrab').show();
        $('#telfTextTrabTCP').attr("required", true);
        $('#selectTrabTextTelf').attr("required", false);
        $('#textTelfTrab').hide();
        $('#selectTrabTextTelf').val('');
    }
});

$('#situaLabTCP').change(function () {
    var situaLabTCP = $("#situaLabTCP option:selected").text();
    if (situaLabTCP == "DEPENDIENTE") {
        $('#dependiente').show();
        $('#independiente').hide();
        $('#empresaTCP').prop('required', true);
        $('#contratoTCP').prop('required', true);
        $('#fechaIniTCP').prop('required', true);
        $('#cargoTCP').prop('required', true);
        $('#sueldoTCP').prop('required', true);
        $('#gastosTCP').prop('required', true);
        $('#negocioTCP').prop('required', false);
        $('#ventasTCP').prop('required', false);
        $('#costoTCP').prop('required', false);
        $('#actEcoTCP').prop('required', false);
        $('#gastosOpeTCP').prop('required', false);
        $('#fechaIniNegTCP').prop('required', false);
    } else if (situaLabTCP == "INDEPENDIENTE") {
        $('#dependiente').hide();
        $('#independiente').show();
        $('#empresaTCP').prop('required', false);
        $('#contratoTCP').prop('required', false);
        $('#fechaIniTCP').prop('required', false);
        $('#cargoTCP').prop('required', false);
        $('#sueldoTCP').prop('required', false);
        $('#gastosTCP').prop('required', false);
        $('#negocioTCP').prop('required', true);
        $('#ventasTCP').prop('required', true);
        $('#costoTCP').prop('required', true);
        $('#actEcoTCP').prop('required', true);
        $('#gastosOpeTCP').prop('required', true);
        $('#fechaIniNegTCP').prop('required', true);
    } else {
        $('#dependiente').hide();
        $('#independiente').hide();
        $('#empresaTCP').prop('required', false);
        $('#contratoTCP').prop('required', false);
        $('#fechaIniTCP').prop('required', false);
        $('#cargoTCP').prop('required', false);
        $('#sueldoTCP').prop('required', false);
        $('#gastosTCP').prop('required', false);
        $('#negocioTCP').prop('required', false);
        $('#ventasTCP').prop('required', false);
        $('#costoTCP').prop('required', false);
        $('#actEcoTCP').prop('required', false);
        $('#gastosOpeTCP').prop('required', false);
        $('#fechaIniNegTCP').prop('required', false);
    }
});

$("#provinciaRefTCP").change(function () {
    var provinciasTCP = $("#provinciaRefTCP option:selected").val();
    if (provinciasTCP != "") {
        $.ajax({
            type: "GET",
            url: '../ajax/tarjetaPrincipalC.php?action=cuidades',
            data: {provinciasTCP: provinciasTCP},
            success: function (r) {
                $('#ciudadRefTCP').html(r);
            }
        });
    }
});

$("#lugarEntTCP").change(function () {
    var lugarEntregaTCP = $("#lugarEntTCP option:selected").val();
    if (lugarEntregaTCP == "DOMICILIO") {
        var lugar = $('#provinciaDomTCP option:selected').text()
                + ' ' + $('#ciudadDomTCP option:selected').text()
                + ' ' + $('#parroquiaDomTCP').val()
                + ' ' + $('#principalDomTCP').val()
                + ' ' + $('#numDomTCP').val()
                + ' ' + $('#secundariaDomTCP').val()
                + ' ' + $('#sectorDomTCP').val()
                + ' ' + $('#refDomTCP').val();

        $('#dirEntTCP').val(lugar);
    } else if (lugarEntregaTCP == "TRABAJO") {
        var lugar = $('#provinciaTrabTCP option:selected').text()
                + ' ' + $('#ciudadTrabTCP option:selected').text()
                + ' ' + $('#parroquiaTrabTCP').val()
                + ' ' + $('#principalTrabTCP').val()
                + ' ' + $('#numTrabTCP').val()
                + ' ' + $('#secundariaTrabTCP').val()
                + ' ' + $('#sectorTrabTCP').val()
                + ' ' + $('#refTrabTCP').val();
        $('#dirEntTCP').val(lugar);
    } else {
        $('#dirEntTCP').val("");
    }
});

/**************************************TARJETA ADICIONAL******************************************************/
$("#provinciaDomTCA").change(function () {
    var provinciasTCA = $("#provinciaDomTCA option:selected").val();
    if (provinciasTCA != "") {
        $.ajax({
            type: "GET",
            url: '../ajax/tarjetaAdicionalC.php?action=cuidades',
            data: {provinciasTCA: provinciasTCA},
            success: function (r) {
                $('#ciudadDomTCA').html(r);
            }
        });
    }
});

$("#provinciaTrabTCA").change(function () {
    var provinciasTCA = $("#provinciaTrabTCA option:selected").val();
    if (provinciasTCA != "") {
        $.ajax({
            type: "GET",
            url: '../ajax/tarjetaAdicionalC.php?action=cuidades',
            data: {provinciasTCA: provinciasTCA},
            success: function (r) {
                $('#ciudadTrabTCA').html(r);
            }
        });
    }
});

$('#otroTrabTelfTCA').change(function () {
    if ($(this).is(":checked")) {
        $('#textTelfTrabTCA').show();
        $('#selectTrabTextTelfTCA').attr("required", true);
        $('#telfTextTrabTCA').attr("required", false);
        $('#selectTelfTrabTCA').hide();
        $('#telfTextTrabTCA option:selected').prop('selected', false).find('option:first').prop('selected', true);
    } else {
        $('#selectTelfTrabTCA').show();
        $('#telfTextTrabTCA').attr("required", true);
        $('#selectTrabTextTelfTCA').attr("required", false);
        $('#textTelfTrabTCA').hide();
        $('#selectTrabTextTelfTCA').val('');
    }
});

$('#otroCellTCA').change(function () {
    if ($(this).is(":checked")) {
        $('#textCellTCA').show();
        $('#celularTCA').attr("required", true);
        $('#celularTextTCA').attr("required", false);
        $('#selectCellTCA').hide();
        $('#celularTextTCA option:selected').prop('selected', false).find('option:first').prop('selected', true);
    } else {
        $('#selectCellTCA').show();
        $('#celularTextTCA').attr("required", true);
        $('#celularTCA').attr("required", false);
        $('#textCellTCA').hide();
        $('#celularTCA').val('');
    }
});

$('#otroTelfTCA').change(function () {
    if ($(this).is(":checked")) {
        $('#textTelfTCA').show();
        $('#telfTCA').attr("required", true);
        $('#telfTextTCA').attr("required", false);
        $('#selectTelfTCA').hide();
        $('#telfTextTCA option:selected').prop('selected', false).find('option:first').prop('selected', true);
    } else {
        $('#selectTelfTCA').show();
        $('#telfTextTCA').attr("required", true);
        $('#telfTCA').attr("required", false);
        $('#textTelfTCA').hide();
        $('#telfTCA').val('');
    }
});

$('#IDENTIFICACIONTCA').blur(function () {
    var text = $('#IDENTIFICACIONTCA').val();
    if (validarcedula(text) == false) {
        bootbox.alert("Cédula incorrecta");
    }
});

$('#FECHA_NACIMIENTOTCA').blur(function () {
    var text = $('#FECHA_NACIMIENTOTCA').val();
    $('#edadTCA').val(calculateAge(text));
});

$('#FECHA_NACIMIENTOADITCA').blur(function () {
    var text = $('#FECHA_NACIMIENTOADITCA').val();
    if (calculateAge(text) < 15) {
        $("#btnGuardarTCA").attr('disabled', true);
        bootbox.alert("No aplica, debe ser mayor o igual a 15 años!");
    } else {
        $("#btnGuardarTCA").attr('disabled', false);
    }
});

$('#NOMBRE1TCA').blur(function () {
    var text = $('#NOMBRE1TCA').val();
    var text1 = $('#APELLIDO1TCA').val();
    $('#nombreTarjetaTCA').val(text + ' ' + text1);
});

$('#APELLIDO1TCA').blur(function () {
    var text = $('#NOMBRE1TCA').val();
    var text1 = $('#APELLIDO1TCA').val();
    $('#nombreTarjetaTCA').val(text + ' ' + text1);
});

/**************************************FUNCIONES A UTILIZAR******************************************************/
function guardar_datos(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    var IdClient = $("#IDC").val();
    $.ajax({
        type: "GET",
        url: '../ajax/campaignBPC.php?action=validePhone',
        data: {IdClient: IdClient},
        success: function (v) {
            var r = $("#code").val();
            if (v == "Almacene un número de teléfono para continuar!") {
                event.preventDefault();
                bootbox.alert(v);
            } else if (r == 1 || r == 11 || r == 12 || r == 20 || r == 21 || r == 22 || r == 23) {
                $.ajax({
                    type: "GET",
                    url: '../ajax/tarjetaAdicionalC.php?action=validaTCA',
                    data: {IdClient: IdClient},
                    success: function (r) {
                        if (r == "No hay datos") {
                            event.preventDefault();
                            bootbox.alert("Debe almacenar una tarjeta de crédito adicional para continuar!");
                        } else if (r == "Si hay datos") {
                            var formData = new FormData($("#formulario")[0]);
                            $.ajax({
                                url: "../ajax/campaignBPC.php?action=save",
                                type: "POST",
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function (datos) {
                                    if (datos == 'Error: registro no se pudo almacenar' || datos == "Error: registro no se pudo actualizar" || datos == "Error de almacenamiento") {
                                            e.preventDefault();
                                            bootbox.alert("Por favor, intente almacenar nuevamente!");
                                    } else {
                                            bootbox.alert(datos);
                                            mostrar_formulario(false);
                                            tabla.ajax.reload();
                                            $("#btnGuardar").prop("disabled", true);
                                    }
                                }
                            });
                            if ((r >= 17 && r <= 23) || r == 3 || r == 13 || r == 14) {
                                $.ajax({
                                    url: "../ajax/tarjetaPrincipalC.php?action=save",
                                    type: "POST",
                                    data: formData,
                                    contentType: false,
                                    processData: false,
                                    success: function (datos) {
                                        //bootbox.alert(datos);
                                    }
                                });
                            }
                            if ((r >= 13 && r <= 17) || r == 2 || r == 19) {
                                var visitaAgencia = $("#tip").val();
                                if (visitaAgencia == "AGENCIA") {
                                    $.ajax({
                                        url: "../ajax/campaignBPC.php?action=envioMail",
                                        type: "POST",
                                        data: formData,
                                        contentType: false,
                                        processData: false,
                                        success: function (datos) {
                                            //bootbox.alert(datos);
                                        }
                                    });
                                }
                            }
                        }
                    }
                });
            } else {
                var formData = new FormData($("#formulario")[0]);
                $.ajax({
                    url: "../ajax/campaignBPC.php?action=save",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (datos) {
                            if (datos == 'Error: registro no se pudo almacenar' || datos == "Error: registro no se pudo actualizar" || datos == "Error de almacenamiento") {
                                    e.preventDefault();
                                    bootbox.alert("Por favor, intente almacenar nuevamente!");
                            } else {
                                    bootbox.alert(datos);
                                    mostrar_formulario(false);
                                    tabla.ajax.reload();
                                    $("#btnGuardar").prop("disabled", true);
                            }
                    }
                });
                if ((r >= 17 && r <= 23) || r == 3 || r == 13 || r == 14) {
                    $.ajax({
                        url: "../ajax/tarjetaPrincipalC.php?action=save",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (datos) {
                            //bootbox.alert(datos);
                        }
                    });
                }
                if ((r >= 13 && r <= 17) || r == 2 || r == 19) {
                    var visitaAgencia = $("#tip").val();
                    if (visitaAgencia == "AGENCIA") {
                        $.ajax({
                            url: "../ajax/campaignBPC.php?action=envioMail",
                            type: "POST",
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function (datos) {
                                //bootbox.alert(datos);
                            }
                        });
                    }
                }
            }
        }
    });
}

function calculateAge(birthday) {
    var birthday_arr = birthday.split("/");
    var birthday_date = new Date(birthday_arr[2], birthday_arr[1] - 1, birthday_arr[0]);
    var ageDifMs = Date.now() - birthday_date.getTime();
    var ageDate = new Date(ageDifMs);
    return Math.abs(ageDate.getUTCFullYear() - 1970);
}

function obtenerHora() {
    var d = new Date();
    var h = d.getHours();
    var m = d.getMinutes();
    var s = d.getSeconds();
    var horaString = h + ":" + m + ":" + s;
    horaString = horaString.toString();
    return horaString;
}

function validarcedula(cedula) {
    var i;
    var acumulado;
    var instancia;
    acumulado = 0;
    for (i = 1; i <= 9; i++) {
        if (i % 2 != 0) {
            instancia = cedula.substring(i - 1, i) * 2;
            if (instancia > 9)
                instancia -= 9;
        } else
            instancia = cedula.substring(i - 1, i);
        acumulado += parseInt(instancia);
    }
    while (acumulado > 0)
        acumulado -= 10;
    if (cedula.substring(9, 10) != (acumulado * -1)) {
        return false
    } else {
        return true
    }
    console.log("Cedula: " + cedula)
    console.log("Digito Verificador: " + acumulado * -1)
    console.log("--------------------------------------------------")
}

function dataRequiredTCP(state) {
    $('#IDENTIFICACIONTCP').prop('required', state);
    $('#NOMBRE1TCP').prop('required', state);
    $('#APELLIDO1TCP').prop('required', state);
//    $('#provinciaNacTCP').prop('required', state);
//    $('#ciudadNacTCP').prop('required', state);
    $('#estadoCivilTCP').prop('required', state);
    $('#generoTCP').prop('required', state);
    $('#fecNacTCP').prop('required', state);
    $('#emailTCP').prop('required', state);
    $('#pdpTCP').prop('required', state);
    $('#estadoctaTCP').prop('required', state);
    $('#provinciaDomTCP').prop('required', state);
    $('#ciudadDomTCP').prop('required', state);
    $('#tipoVivTCP').prop('required', state);
    $('#cantonDomTCP').prop('required', state);
    $('#parroquiaDomTCP').prop('required', state);
    $('#principalDomTCP').prop('required', state);
    $('#secundariaDomTCP').prop('required', state);
    $('#numDomTCP').prop('required', state);
    $('#sectorDomTCP').prop('required', state);
    $('#refDomTCP').prop('required', state);
    $('#provinciaTrabTCP').prop('required', state);
    $('#ciudadTrabTCP').prop('required', state);
    $('#cantonTrabTCP').prop('required', state);
    $('#parroquiaTrabTCP').prop('required', state);
    $('#principalTrabTCP').prop('required', state);
    $('#secundariaTrabTCP').prop('required', state);
    $('#numTrabTCP').prop('required', state);
    $('#sectorTrabTCP').prop('required', state);
    $('#refTrabTCP').prop('required', state);
    $('#situaLabTCP').prop('required', state);
    $('#perRefTCP').prop('required', state);
    $('#provinciaRefTCP').prop('required', state);
    $('#ciudadRefTCP').prop('required', state);
    $('#telfRefTCP').prop('required', state);
    $('#relacionCliTCP').prop('required', state);
    $('#lugarEntTCP').prop('required', state);
    $('#perContTCP').prop('required', state);
    $('#telfContTCP').prop('required', state);
    $('#horEntTCP').prop('required', state);
}

$('#btnGuardarTCA').click(function () {
    var code = $("#code").val();
    var lugarDom = $('#principalDomTCA').val()
            + ' ' + $('#numDomTCA').val()
            + ' ' + $('#secundariaDomTCA').val()
            + ' ' + $('#sectorDomTCA').val()
            + ' ' + $('#tipoLugarDOMTCA').val()
            + ' ' + $('#refDomTCA').val();
    console.log(lugarDom);

    var lugarTrab = $('#principalTrabTCA').val()
            + ' ' + $('#numTrabTCA').val()
            + ' ' + $('#secundariaTrabTCA').val()
            + ' ' + $('#sectorTrabTCA').val()
            + ' ' + $('#tipoLugarTCA').val()
            + ' ' + $('#refTrabTCA').val();
    console.log(lugarTrab);
    if ($("#ESTADO_CIVILTCA option:selected").val() == "" ||
            $("#generoTCA option:selected").val() == "" ||
            $("#LUGARNACTCA").val() == "" ||
            $("#FECHA_NACIMIENTOTCA").val() == "" ||
            $("#ACTECOTCA").val() == "" ||
            $("#CORREOTCA").val() == "" ||
            $("#provinciaTrabTCA option:selected").text() == "" ||
            $("#ciudadTrabTCA option:selected").val() == "" ||
            $("#principalTrabTCA").val() == "" ||
            $("#secundariaTrabTCA").val() == "" ||
            $("#sectorTrabTCA").val() == "" ||
            $("#refTrabTCA").val() == "" ||
            $("#tipoLugarTCA").val() == "" ||
            //lugarTrab == "" ||
            $("#provinciaDomTCA option:selected").text() == "" ||
            $("#ciudadDomTCA option:selected").val() == "" ||
            $("#principalDomTCA").val() == "" ||
            $("#secundariaDomTCA").val() == "" ||
            $("#sectorDomTCA").val() == "" ||
            $("#refDomTCA").val() == "" ||
            $("#tipoLugarDOMTCA").val() == "" ||
            //lugarDom == "" ||
            $("#tipoIdentificacionTCA").val() == "" ||
            $("#nacionalidadTCA").val() == "" ||
            $("#IDENTIFICACIONTCA").val() == "" ||
            $("#NOMBRE1TCA").val() == "" ||
            $("#APELLIDO1TCA").val() == "" ||
            $("#nombreTarjetaTCA").val() == "" ||
            $("#FECHA_NACIMIENTOADITCA").val() == "" ||
            $("#cupoTCA").val() == "" ||
            $("#tarjetaTitularTCA").val() == "" ||
            $("#generoPerTCA option:selected").val() == "" ||
            $("#estadoCivilPerTCA option:selected").val() == "" ||
            $("#parentezcoTCA option:selected").val() == "" ||
            $("#lugarEntTCA option:selected").val() == "" ||
            $("#ranVisTCA option:selected").val() == "" ||
            $("#estadoctaTCA option:selected").val() == "" ||
            $("#personaContactoTCA").val() == "") {
        bootbox.alert("Llene todos los datos para continuar!");
    } else if ($("#celularTextTCA option:selected").val() == "" && $("#celularTCA").val() == "") {
        bootbox.alert("Llene el campo de celular para continuar!");
    } else if ($("#telfTextTrabTCA").val() == "" && $("#selectTrabTextTelfTCA").val() == "") {
        bootbox.alert("Llene el campo de teléfono de trabajo para continuar!");
    } else if ($("#telfTextTCA option:selected").val() == "" && $("#telfTCA").val() == "") {
        bootbox.alert("Llene el campo de teléfono de domicilio para continuar!");
    } else if ($("#pdpTCA option:selected").val() == "NO" && ($("#subestatus1TCA option:selected").val() == '' && $("#subestatus2TCA option:selected").val() == '')) {
        bootbox.alert("Llene el estatus de la asistencia para continuar!");
    } else if ($("#pdpTCA option:selected").val() == "NO" && ($("#subestatus1TCA option:selected").val() == '' || $("#subestatus2TCA option:selected").val() == '')) {
        bootbox.alert("Llene el estatus de la asistencia para continuar!");
    } else {
        $.ajax({
            type: "POST",
            url: '../ajax/tarjetaAdicionalC.php?action=save',
            data: {
                IdTCA: $("#IdTCA").val(),
                cedulaTitularTCA: $("#cedulaTitularTCA").val(),
                nombresTitularTCA: $("#nombresTitularTCA").val(),
                ESTADO_CIVILTCA: $("#ESTADO_CIVILTCA option:selected").val(),
                generoTCA: $("#generoTCA option:selected").val(),
                LUGARNACTCA: $("#LUGARNACTCA").val(),
                FECHA_NACIMIENTOTCA: $("#FECHA_NACIMIENTOTCA").val(),
                ACTECOTCA: $("#ACTECOTCA").val(),
                CORREOTCA: $("#CORREOTCA").val(),
                celularTextTCA: $("#celularTextTCA option:selected").val(),
                celularTCA: $("#celularTCA").val(),
                provinciaTrabTCA: $("#provinciaTrabTCA option:selected").text(),
                ciudadTrabTCA: $("#ciudadTrabTCA option:selected").text(),
                principalTrabTCA: $("#principalTrabTCA").val(),
                secundariaTrabTCA: $("#secundariaTrabTCA").val(),
                numTrabTCA: $("#numTrabTCA").val(),
                sectorTrabTCA: $("#sectorTrabTCA").val(),
                refTrabTCA: $("#refTrabTCA").val(),
                tipoLugarTCA: $("#tipoLugarTCA").val(),
                dirConcTrabTCA: lugarTrab,
                telfTextTrabTCA: $("#telfTextTrabTCA").val(),
                selectTrabTextTelfTCA: $("#selectTrabTextTelfTCA").val(),
                provinciaDomTCA: $("#provinciaDomTCA option:selected").text(),
                ciudadDomTCA: $("#ciudadDomTCA option:selected").text(),
                principalDomTCA: $("#principalDomTCA").val(),
                secundariaDomTCA: $("#secundariaDomTCA").val(),
                numDomTCA: $("#numDomTCA").val(),
                sectorDomTCA: $("#sectorDomTCA").val(),
                refDomTCA: $("#refDomTCA").val(),
                tipoLugarDOMTCA: $("#tipoLugarDOMTCA").val(),
                dirConcDomTCA: lugarDom,
                telfTextTCA: $("#telfTextTCA option:selected").val(),
                telfTCA: $("#telfTCA").val(),
                tipoIdentificacionTCA: $("#tipoIdentificacionTCA").val(),
                nacionalidadTCA: $("#nacionalidadTCA").val(),
                IDENTIFICACIONTCA: $("#IDENTIFICACIONTCA").val(),
                NOMBRE1TCA: $("#NOMBRE1TCA").val(),
                NOMBRE2TCA: $("#NOMBRE2TCA").val(),
                APELLIDO1TCA: $("#APELLIDO1TCA").val(),
                APELLIDO2TCA: $("#APELLIDO2TCA").val(),
                nombreTarjetaTCA: $("#nombreTarjetaTCA").val(),
                FECHA_NACIMIENTOADITCA: $("#FECHA_NACIMIENTOADITCA").val(),
                cupoTCA: $("#cupoTCA").val(),
                tarjetaTitularTCA: $("#tarjetaTitularTCA").val(),
                generoPerTCA: $("#generoPerTCA option:selected").val(),
                estadoCivilPerTCA: $("#estadoCivilPerTCA option:selected").val(),
                parentezcoTCA: $("#parentezcoTCA option:selected").val(),
                lugarEntTCA: $("#lugarEntTCA option:selected").val(),
                ranVisTCA: $("#ranVisTCA option:selected").val(),
                estadoctaTCA: $("#estadoctaTCA option:selected").val(),
                pdpTCA: $("#pdpTCA option:selected").val(),
                personaContactoTCA: $("#personaContactoTCA").val(),
                subestatus1TCA: $("#subestatus1TCA").val(),
                subestatus2TCA: $("#subestatus2TCA").val()
            },
            success: function (r) {
                bootbox.alert(r);
                if (r == "Tarjeta Adicional registrada" || r == "Tarjeta Adicional actualizada") {
                    var idTitular = $("#IdTCA").val();
                    $('#tblListadoTCA').show();
                    // $("#cuerpo").html(r);
                    tablaTCA = $('#tblListadoTCA').dataTable({
                        "lengthMenu": [5, 10, 25, 75, 100], //mostramos el menú de registros a revisar
                        "aProcessing": true, /* activa el procesamiento de DataTables */
                        "aServerSide": true, /* Paginación y filtrado realizado por el servidor */
                        dom: '<Bl<f>rtip>', //Definimos los elementos del control de tabla
                        buttons: [
                        ],
                        "ajax": {
                            url: '../ajax/tarjetaAdicionalC.php?action=selectAll',
                            data: {idTitular: idTitular},
                            type: "get",
                            dataType: "json",
                            error: function (e) {
                                console.log(e.responseText);
                            }
                        },
                        "language": {
                            "lengthMenu": "Mostrar : _MENU_ registros",
                            "buttons": {
                                "copyTitle": "Tabla Copiada",
                                "copySuccess": {
                                    _: '%d líneas copiadas',
                                    1: '1 línea copiada'
                                }
                            }
                        },
                        "bDestroy": true,
                        "iDisplayLength": 10, /* paginación */
                        "order": [[0, "asc"]]
                    }).DataTable();
                    tablaTCA.on('order.dt search.dt', function () {
                        tablaTCA.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                            cell.innerHTML = i + 1;
                        });
                    }
                    ).draw();
                    $("#IDENTIFICACIONTCA").val("");
                    $("#NOMBRE1TCA").val("");
                    $("#NOMBRE2TCA").val("");
                    $("#APELLIDO1TCA").val("");
                    $("#APELLIDO2TCA").val("");
                    $("#nombreTarjetaTCA").val("");
                    $("#FECHA_NACIMIENTOADITCA").val("");
                    $("#cupoTCA").val("");
                    $("#generoPerTCA option:selected").val("");
                    $("#estadoCivilPerTCA option:selected").val("");
                    $("#parentezcoTCA option:selected").val("");
                    $("#lugarEntTCA option:selected").val("");
                    $("#ranVisTCA option:selected").val("");
                    $("#estadoctaTCA option:selected").val("");
                    $("#pdpTCA option:selected").val("");
                    $("#personaContactoTCA").val("");
                    tablaTCA.ajax.reload();
                }
            }
        });
    }
});

init(); /* ejecuta la función inicial */