var tabla;
var tablaTCA;
var id;
function init() { /* función inicial */
    mostrar_formulario(false);
    mostrar_todos();
    $("#formulario").on("submit", function (e) {
        guardar_datos(e);
    });
    //divs y paneles a ocultar
    $('#pnlProductos').hide();
    $('#pnlIncrementos').hide();
    $('#otro').attr('disabled', true);
    $('#subestatus1').attr('disabled', true);
    $('#subestatus2').attr('disabled', true);
}

function limpiar_formulario() {
    $("#titulo").text("Campaña Banco Pichincha Incrementos");
    $("#titulo1").text("");
    $("#titulo2").text("");
    $('#valorIncremento').val("");
    $('#txtCambio').val("");
    $('#fechaIncremento').val("");
    $('#valorCambioIncremento').val("");
    $('#txtCambioValor').val("");
    $("#cambioFecha").prop("checked", false);
    $("#cambioIncremento").prop("checked", false);
}

function cancelar_formulario() { /* función para cancelar la operación */
    limpiar_formulario();
    mostrar_formulario(false);
    $("#titulo").text("Campaña Banco Pichincha Incrementos");
    $("#titulo1").text("");
    $("#titulo2").text("");
}

function mostrar_formulario(flag) { /* muestra u oculta el formulario segun la validación del bool (flag) */
    limpiar_formulario();
    if (flag) {
        $("#listadoRegistros").hide();
        $("#formularioRegistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnAgregar").hide();
    } else {
        $("#listadoRegistros").show();
        $("#formularioRegistros").hide();
        $("#btnAgregar").show();
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
            url: '../ajax/bpIncrementosC.php?action=selectAllRec',
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
    $.post("../ajax/bpIncrementosC.php?action=selectById", {Id: Id}, function (datos, estado) {
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
        $("#titulo2").text(datos.NOMBRE_CLIENTE);
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
        $('#CODIGO_CAMPANIA').val(datos.CODIGO_CAMPANIA);
        $('#NOMBRE_CAMPANIA').val(datos.NOMBRE_CAMPANIA);
        $('#IDENTIFICACION').val(datos.IDENTIFICACION);
        $('#NOMBRE_CLIENTE').val(datos.NOMBRE_CLIENTE);
        $('#ZONA').val(datos.ZONA);
        $('#REGION').val(datos.REGION);
        $('#SUBSEGMENTO').val(datos.SUBSEGMENTO);
        $('#EDAD').val(datos.EDAD);
        $('#ESTADO_CIVIL').val(datos.ESTADO_CIVIL);
        $('#SEXO').val(datos.SEXO);
        $('#NOMBRE_PRODUCTO').val(datos.NOMBRE_PRODUCTO);
        $('#NUMERO_CUENTA').val(datos.NUMERO_CUENTA);
        $('#ESTADO_DE_CTA_AHORRO_FUTURO').val(datos.ESTADO_DE_CTA_AHORRO_FUTURO);
        $('#DESCRIPCION').val(datos.DESCRIPCION);
        $('#FUTURE_VALUE_SAVINGS_ARRANGEMENT').val(datos.FUTURE_VALUE_SAVINGS_ARRANGEMENT);
        $('#MONTO ').val(datos.MONTO);
        $('#VALIDADOR').val(datos.VALIDADOR);
        $('#SALDO').val(datos.SALDO);
        $('#MONTO_SUGERIDO_AH_FUT').val(datos.MONTO_SUGERIDO_AH_FUT);
        $('#ANIO_APERTURA').val(datos.ANIO_APERTURA);
        $('#PROVINCIA_DOMICILIO').val(datos.PROVINCIA_DOMICILIO);
        $('#CIUDAD_DOMICILIO').val(datos.CIUDAD_DOMICILIO);
        $('#DIRECCION_DOMICILIO').val(datos.DIRECCION_DOMICILIO);
        $('#PROVINCIA_TRABAJO').val(datos.PROVINCIA_TRABAJO);
        $('#CIUDAD_TRABAJO').val(datos.CIUDAD_TRABAJO);
        $('#DIRECCION_TRABAJO').val(datos.DIRECCION_TRABAJO);
        $('#MC').val(datos.MC);
        $('#VI').val(datos.VI);
        $('#CUENTA_DEBITO').val(datos.CUENTA_DEBITO);
        $('#ESTADO_CUENTA_TRANSACCIONAL').val(datos.ESTADO_CUENTA_TRANSACCIONAL);
        $('#DESCRIPCION1').val(datos.DESCRIPCION1);
        $('#SALDO_PROMEDIO').val(datos.SALDO_PROMEDIO);
        $('#TIENE_DEUDA_PROTEGIDA').val(datos.TIENE_DEUDA_PROTEGIDA);
        $('#EXEQUIAL').val(datos.EXEQUIAL);
        $('#VIDA_SEGURA').val(datos.VIDA_SEGURA);
        $('#PROTECCION_FRAUDE').val(datos.PROTECCION_FRAUDE);
        $('#FECHA_APERTURA_AH_FUTURO').val(datos.FECHA_APERTURA_AH_FUTURO);
        $('#DIA_DEBITO_AH_FUTURO').val(datos.DIA_DEBITO_AH_FUTURO);
        var camp = datos.CampaignId;
        if (camp != "") {
            $.ajax({
                type: "GET",
                url: '../ajax/funcionesGeneralesC.php?action=estatus',
                data: {camp: camp},
                success: function (r) {
                    $('#level1').html(r);
                    $('#level2').val("");
                    $('#level3').val("");
                    $('#subestatus1').attr('disabled', false);
                    $('#subestatus2').attr('disabled', false);
                }
            });
        }
        var idC = datos.ID;
        if (idC != "") {
            $.ajax({
                type: "GET",
                url: '../ajax/funcionesGeneralesC.php?action=telefonos',
                data: {idC: idC},
                success: function (r) {
                    $('#fonos').html(r);
                }
            });
            $.ajax({
                url: '../ajax/funcionesGeneralesC.php?action=interactionIdOld',
                method: 'GET',
                data: {idC: idC},
                success: function (r) {
                    $('#interactionIdOld').val(r);
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

$("#level1").change(function () {
    var level1 = $("#level1 option:selected").text();
    var camp = $("#CAMPANIA").val();
    if (level1 != "") {
        $.ajax({
            type: "GET",
            url: '../ajax/funcionesGeneralesC.php?action=level2',
            data: {level1: level1, camp: camp},
            success: function (r) {
                $('#level2').html(r);
            }
        });
    }
    var text = $("#level1").val().substring(0, 3);
    var text1 = $("#level1").val().substring(0, 4);
    var text2 = $("#level1").val().substring(0, 2);
    if (text == "CU4") {
        $("#agenda").attr("readonly", false);
        $("#agenda").attr("required", true);
        $("#obs").attr("required", true);
    } else {
        $("#agenda").attr("readonly", true);
        $("#agenda").attr("required", false);
        $("#obs").attr("required", false);
    }
    if (text == "CU1" || text == "CU2" || text == "CU3") {
        $("#fonos").attr('disabled', false);
        $('#estatusTel').attr('disabled', false);
    }
    if (text == "CU4" || text == "CU5" || text == "CU6" || text == "CU7" || text == "NU1" || text == "NU2") {
        $('#pnlIncrementos').hide();
        limpiar_formulario();
        $("#fonos").attr('disabled', false);
        $('#estatusTel').attr('disabled', false);
    }
    if (text1 == "CU10" || text1 == "CU11" || text1 == "CU12") {
        $('#pnlIncrementos').hide();
        limpiar_formulario();
        $("#fonos").attr('disabled', false);
        $('#estatusTel').attr('disabled', false);
    }
    if (text2 == "DB") {
        $('#pnlIncrementos').hide();
        limpiar_formulario();
        $("#fonos").attr('disabled', true);
        $('#estatusTel').attr('disabled', true);
    }

});

$("#level2").change(function () {
    var level1 = $("#level1 option:selected").text();
    var level2 = $("#level2 option:selected").text();
    var camp = $("#CAMPANIA").val();
    if (level1 !== "" && level2 !== "") {
        id = $.ajax({
            type: "GET",
            url: '../ajax/funcionesGeneralesC.php?action=code',
            data: {camp: camp, level1: level1, level2: level2},
            success: function (r) {
                $('#code').val(r);
                if (r == 1) {

                    $('#pnlIncrementos').show();
                    $('#valorIncremento').attr('required', true);
                } else {
                    $('#pnlIncrementos').hide();
                    $('#fechaIncremento').val("");
                    $('#fechaIncremento').attr('required', false);
                    $('#valorIncremento').attr('required', false);
                }
            }
        });
    }
});

$('#cambioFecha').change(function () {
    if (!$(this).is(":checked")) {
        $('#txtCambio').val("NO");
        $('#fechaIncremento').attr('readonly', true);
        $('#fechaIncremento').attr('required', false);
    } else {
        $('#txtCambio').val("SI");
        $('#fechaIncremento').val("");
        $('#fechaIncremento').attr('readonly', false);
        $('#fechaIncremento').attr('required', true);
    }
});

$('#cambioIncremento').change(function () {
    if (!$(this).is(":checked")) {
        $('#txtCambioValor').val("NO");
        $('#valorCambioIncremento').attr('readonly', true);
        $('#valorCambioIncremento').attr('required', false);
    } else {
        $('#txtCambioValor').val("SI");
        $('#valorCambioIncremento').val("");
        $('#valorCambioIncremento').attr('readonly', false);
        $('#valorCambioIncremento').attr('required', true);
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

$('#cbox2').change(function () {
    if (!$(this).is(":checked")) {
        $('#otro').attr('disabled', true);
        $('#otro').attr('required', false);
    } else {
        $('#otro').attr('disabled', false);
        $('#otro').attr('required', true);
    }
});

$('#fonos').change(function () {
    $.ajax({
        url: '../ajax/funcionesGeneralesC.php?action=horaInicio',
        method: 'POST',
        success: function (r) {
            $('#horaInicioLlamada').val(r);
        }
    });
    var idC = $("#IDC").val();
    $.ajax({
        url: '../ajax/funcionesGeneralesC.php?action=interactionIdOld',
        method: 'GET',
        data: {idC: idC},
        success: function (r) {
            $('#interactionId').val(r);
        }
    });
});

$('#btnFonos').click(function () {
    $.ajax({
        url: '../ajax/funcionesGeneralesC.php?action=interactionId',
        method: 'POST',
        success: function (r) {
            $('#interactionId').val(r);
            var phones = $("#fonos option:selected").text();
            var estatusTel = $("#estatusTel option:selected").text();
            var horaInicioLlamada = $('#horaInicioLlamada').val();
            var interactionId = r;

            if (phones != "" && estatusTel != "") {
                var IDC = $("#IDC").val();
                $.ajax({
                    url: '../ajax/funcionesGeneralesC.php?action=updatePhones',
                    method: 'POST',
                    data: {
                        IDC: IDC,
                        fonos: phones,
                        estatusTel: estatusTel,
                        horaInicioLlamada: horaInicioLlamada,
                        interactionId: interactionId
                    },
                    success: function (r) {
                        bootbox.alert(r);
                        $.ajax({
                            type: "GET",
                            url: '../ajax/funcionesGeneralesC.php?action=telefonos',
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
        }
    });
});

function guardar_datos(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    var InteractionIdOld = $("#interactionIdOld").val();
    var InteractionId = $("#interactionId").val();
    var estatus1 = $("#level1").val();
    var estatus2 = $("#level2").val();

    if (InteractionIdOld == '' && estatus1 != 'NU2 INUBICABLES' && estatus2 != 'Cliente sin telefono') { //Registro gestionado con anterioridad sin almacenado de teléfono
        bootbox.alert("Almacene un número de teléfono para continuar!");
    } else if (InteractionId == '' && estatus1 != 'DB') { //Registro gestionado con anterioridad sin almacenado de teléfono
        bootbox.alert("Almacene un número de teléfono para continuar!!");
    } else if ((InteractionIdOld == InteractionId) && estatus1 != 'DB') { //Registro gestionado con anterioridad sin almacenado de teléfono
        bootbox.alert("Almacene un número de teléfono para continuar!!!");
    } else if (InteractionIdOld == '' && estatus1 == 'NU2 INUBICABLES' && estatus2 == 'Cliente sin telefono') { //Registro que aún no tiene gestión
//        bootbox.alert("Almacene un número de teléfono para continuar! 1");
        var formData = new FormData($("#formulario")[0]);
        $.ajax({
            url: "../ajax/bpIncrementosC.php?action=save",
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
    } else if ((InteractionId == "") && estatus1 == 'DB') {//Registro gestionado con anterioridad que no debe almacenar teléfono por estar dados de baja
//        bootbox.alert("posi! 1");
        var formData = new FormData($("#formulario")[0]);
        $.ajax({
            url: "../ajax/bpIncrementosC.php?action=save",
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
    } else if ((InteractionIdOld == InteractionId) && estatus1 == 'DB') {//Registro gestionado con anterioridad que no debe almacenar teléfono por estar dados de baja
//        bootbox.alert("posi! 2");
        var formData = new FormData($("#formulario")[0]);
        $.ajax({
            url: "../ajax/bpIncrementosC.php?action=save",
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
    } else {
//        bootbox.alert("posi! 3");
        var formData = new FormData($("#formulario")[0]);
        $.ajax({
            url: "../ajax/bpIncrementosC.php?action=save",
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
    }
}

init(); /* ejecuta la función inicial */