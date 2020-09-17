var tabla;
function init() { /* función inicial */
    mostrar_formulario(false);
    mostrar_todos();
    $("#formulario").on("submit", function (e) {
        guardar_datos(e);
    });
    //divs y paneles a ocultar
    $('#pregunta14').hide();
    $('#respuesta14').hide();
    $('#pregunta20').hide();
    $('#respuesta20').hide();
    $('#pregunta21').hide();
    $('#respuesta21').hide();
    $('#pregunta22').hide();
    $('#respuesta22').hide();
    $('#pregunta23').hide();
    $('#respuesta23').hide();
    pnlEncuesta(false, true);
    $('#otro').attr('disabled', true);
    $('#subestatus1').attr('disabled', true);
    $('#subestatus2').attr('disabled', true);
    $('#fonoAd').on("paste", function (e) {
        e.preventDefault();
    });
    $('#level3').attr('disabled', true);
}

function limpiar_formulario() {
    $("#titulo").text("Campaña BP Encuestas");
    $("#titulo1").text("");
    $("#titulo2").text("");
    pnlEncuesta(false, true);
    $('#respuesta2').attr('required', false);
    $('#respuesta2').attr('readonly', true);
    $('#respuesta4').attr('required', false);
    $('#respuesta4').attr('readonly', true);
    $('#respuesta6').attr('required', false);
    $('#respuesta6').attr('readonly', true);
    $('#respuesta8').attr('required', false);
    $('#respuesta8').attr('readonly', true);
    $('#respuesta10').attr('required', false);
    $('#respuesta10').attr('readonly', true);
    $('#respuesta12').attr('required', false);
    $('#respuesta12').attr('readonly', true);
    $('#respuesta14').attr('required', false);
    $('#respuesta14').attr('readonly', true);
    $('#respuesta20').attr('required', false);
    $('#respuesta20').attr('readonly', true);
    $('#respuesta21').attr('required', false);
    $('#respuesta21').attr('readonly', true);
    $('#respuesta22').attr('required', false);
    $('#respuesta22').attr('readonly', true);
    $('#respuesta23').attr('required', false);
    $('#respuesta23').attr('readonly', true);
    $('#respuesta2').val("");
    $('#respuesta4').val("");
    $('#respuesta6').val("");
    $('#respuesta8').val("");
    $('#respuesta10').val("");
    $('#respuesta12').val("");
    $('#respuesta13').val("");
    $('#respuesta14').val("");
    $('#respuesta15').val("");
    $('#respuesta16').val("");
    $('#respuesta17').val("");
    $('#respuesta18').val("");
    $('#respuesta19').val("");
    $('#respuesta20').val("");
    $('#respuesta21').val("");
    $('#respuesta22').val("");
    $('#respuesta23').val("");
    $('#respuesta24').val("");
    $("#chk_ENC1").prop("checked", false);
    $("#chk_ENC2").prop("checked", false);
    $("#chk_ENC3").prop("checked", false);
    $("#chk_ENC4").prop("checked", false);
    $("#chk_ENC5").prop("checked", false);
    $("#chk_ENC6").prop("checked", false);
    $('#pregunta14').hide();
    $('#respuesta14').hide();
    $('#pregunta20').hide();
    $('#respuesta20').hide();
    $('#pregunta21').hide();
    $('#respuesta21').hide();
    $('#pregunta22').hide();
    $('#respuesta22').hide();
    $('#pregunta23').hide();
    $('#respuesta23').hide();
}

function cancelar_formulario() { /* función para cancelar la operación */
    limpiar_formulario();
    mostrar_formulario(false);
    $("#titulo").text("Campaña BP Encuestas");
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
            url: '../ajax/bpEncuestaFEgasC.php?action=selectAll',
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
    $.post("../ajax/bpEncuestaFEgasC.php?action=selectById", {Id: Id}, function (datos, estado) {
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
        $('#IDENTIFICACION').val(datos.IDENTIFICACION);
        $('#NOMBRE_CLIENTE').val(datos.NOMBRE_CLIENTE);
        $('#CAMPO1').val(datos.CAMPO1);
        $('#CAMPO2').val(datos.CAMPO2);
        $('#CAMPO3').val(datos.CAMPO3);
        $('#CAMPO4').val(datos.CAMPO4);
        $('#CAMPO5').val(datos.CAMPO5);
        $('#CAMPO6').val(datos.CAMPO6);
        $('#CAMPO7').val(datos.CAMPO7);
        $('#CAMPO8').val(datos.CAMPO8);
        $('#CAMPO9').val(datos.CAMPO9);
        $('#CAMPO10').val(datos.CAMPO10);
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
        limpiar_formulario();
    }
    if (text1 == "CU10" || text1 == "CU11" || text1 == "CU12") {
        limpiar_formulario();
        $("#fonos").attr('disabled', false);
        $('#estatusTel').attr('disabled', false);
    }
    if (text2 == "DB") {
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
                    pnlEncuesta(true, false);
                } else if (r == 2) {
                    pnlEncuesta(false, false);
                    $('#respuesta2').attr('required', false);
                    $('#respuesta2').attr('readonly', true);
                    $('#respuesta4').attr('required', false);
                    $('#respuesta4').attr('readonly', true);
                    $('#respuesta6').attr('required', false);
                    $('#respuesta6').attr('readonly', true);
                    $('#respuesta8').attr('required', false);
                    $('#respuesta8').attr('readonly', true);
                    $('#respuesta10').attr('required', false);
                    $('#respuesta10').attr('readonly', true);
                    $('#respuesta12').attr('required', false);
                    $('#respuesta12').attr('readonly', true);
                } else {
                    limpiar_formulario();
                }
            }
        });
    }
});

$("#level3").change(function () {
    var level1 = $("#level1 option:selected").text();
    var level2 = $("#level2 option:selected").text();
    var level3 = $("#level3 option:selected").text();
    var camp = $("#CAMPANIA").val();
    if (level1 !== "" && level2 !== "") {
        $.ajax({
            type: "GET",
            url: '../ajax/funcionesGeneralesC.php?action=code1',
            data: {camp: camp, level1: level1, level2: level2, level3: level3},
            success: function (r) {
                $('#code').val(r);
            }
        });
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

$('#respuesta13').change(function () {
    if ($('#respuesta13').val() == 'Si') {
        $('#pregunta14').show();
        $('#respuesta14').show();
        $('#respuesta14').attr('required', true);
        $('#respuesta14').attr('readonly', false);

    } else {
        $('#pregunta14').hide();
        $('#respuesta14').hide();
        $('#respuesta14').attr('required', false);
        $('#respuesta14').attr('readonly', true);
        $('#respuesta14').val("");
    }
});

$('#respuesta19').change(function () {
    if ($('#respuesta19').val() == 'Si') {
        $('#pregunta20').show();
        $('#respuesta20').show();
        $('#pregunta21').show();
        $('#respuesta21').show();
        $('#pregunta23').hide();
        $('#respuesta23').hide();
        $('#respuesta20').attr('required', true);
        $('#respuesta20').attr('readonly', false);
        $('#respuesta21').attr('required', true);
        $('#respuesta21').attr('readonly', false);
        $('#respuesta23').attr('required', false);
        $('#respuesta23').attr('readonly', true);
        $('#respuesta23').val("");

    } else if ($('#respuesta19').val() == 'No') {
        $('#pregunta20').hide();
        $('#respuesta20').hide();
        $('#pregunta21').hide();
        $('#respuesta21').hide();
        $('#pregunta23').show();
        $('#respuesta23').show();
        $('#respuesta20').attr('required', false);
        $('#respuesta20').attr('readonly', true);
        $('#respuesta21').attr('required', false);
        $('#respuesta21').attr('readonly', true);
        $('#respuesta23').attr('required', true);
        $('#respuesta23').attr('readonly', false);
        $('#respuesta20').val("");
        $('#respuesta21').val("");
        $('#respuesta23').val("");
    }
});

$('#respuesta21').change(function () {
    if ($('#respuesta21').val() == 'Si' || $('#respuesta21').val() == 'No') {
        $('#pregunta22').show();
        $('#respuesta22').show();
        $('#respuesta22').attr('required', true);
        $('#respuesta22').attr('readonly', false);
    } else {
        $('#pregunta22').hide();
        $('#respuesta22').hide();
        $('#respuesta22').attr('required', false);
        $('#respuesta22').attr('readonly', true);
        $('#respuesta22').val("");
    }
});

$('#chk_ENC1').click(function () {
    if ($('#chk_ENC1').prop('checked') == true) {
        $('#respuesta2').attr('required', true);
    } else {
        $('#respuesta2').attr('required', false);
        $('#respuesta2').val("");
    }
});

$('#chk_ENC2').click(function () {
    if ($('#chk_ENC2').prop('checked') == true) {
        $('#respuesta4').attr('required', true);
    } else {
        $('#respuesta4').attr('required', false);
        $('#respuesta4').val("");
    }
});

$('#chk_ENC3').click(function () {
    if ($('#chk_ENC3').prop('checked') == true) {
        $('#respuesta6').attr('required', true);
    } else {
        $('#respuesta6').attr('required', false);
        $('#respuesta6').val("");
    }
});

$('#chk_ENC4').click(function () {
    if ($('#chk_ENC4').prop('checked') == true) {
        $('#respuesta8').attr('required', true);
    } else {
        $('#respuesta8').attr('required', false);
        $('#respuesta8').val("");
    }
});

$('#chk_ENC5').click(function () {
    if ($('#chk_ENC5').prop('checked') == true) {
        $('#respuesta10').attr('required', true);
    } else {
        $('#respuesta10').attr('required', false);
        $('#respuesta10').val("");
    }
});

$('#chk_ENC6').click(function () {
    if ($('#chk_ENC6').prop('checked') == true) {
        $('#respuesta12').attr('required', true);
    } else {
        $('#respuesta12').attr('required', false);
        $('#respuesta12').val("");
    }
});

function guardar_datos(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    var InteractionIdOld = $("#interactionIdOld").val();
    var InteractionId = $("#interactionId").val();
    var estatus1 = $("#level1").val();
    var estatus2 = $("#level2").val();
    var code = $("#code").val();

    if (($('#chk_ENC1').prop('checked') == false && $('#respuesta2').val() != '')
            && (code == '1' || code == '2')) {
        bootbox.alert("Seleccione la opción 1 en la pregunta 1");
    } else if (($('#chk_ENC2').prop('checked') == false && $('#respuesta4').val() != '')
            && (code == '1' || code == '2')) {
        bootbox.alert("Seleccione la opción 2 en la pregunta 1");
    } else if (($('#chk_ENC3').prop('checked') == false && $('#respuesta6').val() != '')
            && (code == '1' || code == '2')) {
        bootbox.alert("Seleccione la opción 3 en la pregunta 1");
    } else if (($('#chk_ENC4').prop('checked') == false && $('#respuesta8').val() != '')
            && (code == '1' || code == '2')) {
        bootbox.alert("Seleccione la opción 4 en la pregunta 1");
    } else if (($('#chk_ENC5').prop('checked') == false && $('#respuesta10').val() != '')
            && (code == '1' || code == '2')) {
        bootbox.alert("Seleccione la opción 5 en la pregunta 1");
    } else if (($('#chk_ENC6').prop('checked') == false && $('#respuesta12').val() != '')
            && (code == '1' || code == '2')) {
        bootbox.alert("Seleccione la opción 6 en la pregunta 1");
    } else {
        if (InteractionIdOld == '' && estatus1 != 'NU2 INUBICABLES' && estatus2 != 'Cliente sin telefono' && InteractionId == "") { //Registro gestionado con anterioridad sin almacenado de teléfono
            bootbox.alert("Almacene un número de teléfono para continuar!");
        } else if (InteractionId == '' && estatus1 != 'DB') { //Registro gestionado con anterioridad sin almacenado de teléfono
            bootbox.alert("Almacene un número de teléfono para continuar!!");
        } else if ((InteractionIdOld == InteractionId) && estatus1 != 'DB') { //Registro gestionado con anterioridad sin almacenado de teléfono
            bootbox.alert("Almacene un número de teléfono para continuar!!!");
        } else if (InteractionIdOld == '' && estatus1 == 'NU2 INUBICABLES' && estatus2 == 'Cliente sin telefono') { //Registro que aún no tiene gestión
//        bootbox.alert("Almacene un número de teléfono para continuar! 1");
            var formData = new FormData($("#formulario")[0]);
            $.ajax({
                url: "../ajax/bpEncuestaFEgasC.php?action=save",
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
                url: "../ajax/bpEncuestaFEgasC.php?action=save",
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
                url: "../ajax/bpEncuestaFEgasC.php?action=save",
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
                url: "../ajax/bpEncuestaFEgasC.php?action=save",
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
}

init(); /* ejecuta la función inicial */

function pnlEncuesta(state1, state2) {
    $('#respuesta13').attr('required', state1);
    $('#respuesta15').attr('required', state1);
    $('#respuesta16').attr('required', state1);
    $('#respuesta17').attr('required', state1);
    $('#respuesta18').attr('required', state1);
    $('#respuesta19').attr('required', state1);
    $('#respuesta24').attr('required', state1);
    $('#respuesta2').attr('readonly', state2);
    $('#respuesta4').attr('readonly', state2);
    $('#respuesta6').attr('readonly', state2);
    $('#respuesta8').attr('readonly', state2);
    $('#respuesta10').attr('readonly', state2);
    $('#respuesta12').attr('readonly', state2);
    $('#respuesta13').attr('readonly', state2);
    $('#respuesta15').attr('readonly', state2);
    $('#respuesta16').attr('readonly', state2);
    $('#respuesta17').attr('readonly', state2);
    $('#respuesta18').attr('readonly', state2);
    $('#respuesta19').attr('readonly', state2);
    $('#respuesta24').attr('readonly', state2);
}