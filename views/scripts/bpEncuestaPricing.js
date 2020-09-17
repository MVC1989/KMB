var tabla;
function init() { /* función inicial */
    mostrar_formulario(false);
    mostrar_todos();
    $("#formulario").on("submit", function (e) {
        guardar_datos(e);
    });
    //divs y paneles a ocultar
    $('#pnlEncuesta').hide();
    pnlEncuesta(false);
    $('#otro').attr('disabled', true);
    $('#fonoAd').on("paste", function (e) {
        e.preventDefault();
    });
//    $('#divPregunta8').hide();
//    $('#divRespuesta8').hide();
    $('#level3').attr('disabled', true);
    $('#respuesta1').attr('required', false);
    $('#respuesta1').attr('readonly', true);
    $('#respuesta2').attr('required', false);
    $('#respuesta2').attr('readonly', true);
    $('#respuesta3').attr('required', false);
    $('#respuesta3').attr('readonly', true);
    $('#respuesta4').attr('required', false);
    $('#respuesta4').attr('readonly', true);
}

function limpiar_formulario() {
    $("#titulo").text("Campaña BP Encuestas");
    $("#titulo1").text("");
    $("#titulo2").text("");
    $('#pnlEncuesta').hide();
    $('#respuesta1').attr('required', false);
    $('#respuesta1').attr('readonly', true);
    $('#respuesta2').attr('required', false);
    $('#respuesta2').attr('readonly', true);
    $('#respuesta3').attr('required', false);
    $('#respuesta3').attr('readonly', true);
    $('#respuesta4').attr('required', false);
    $('#respuesta4').attr('readonly', true);
    //$('#respuesta9').attr('required', false);
    //$('#respuesta9').attr('readonly', true);
    //$('#respuesta10').attr('required', false);
    //$('#respuesta10').attr('readonly', true);
//    $('#respuesta12').attr('required', false);
//    $('#respuesta12').attr('readonly', true);
//    $('#respuesta13').attr('required', false);
//    $('#respuesta13').attr('readonly', true);
//    $('#respuesta21').attr('required', false);
//    $('#respuesta21').attr('readonly', true);
//    $('#respuesta22').attr('required', false);
//    $('#respuesta22').attr('readonly', true);
//    $('#respuesta23').attr('required', false);
//    $('#respuesta23').attr('readonly', true);
//    $('#respuesta24').attr('required', false);
//    $('#respuesta24').attr('readonly', true);
//    $('#respuesta1').val("");
//    $('#respuesta6').val("");
    $('#respuesta1').val("");
    $('#respuesta2').val("");
    $('#respuesta3').val("");
    $('#respuesta4').val("");
//    $("#chk_ENC7").prop("checked", false);
//    $("#chk_ENC8").prop("checked", false);
//    $("#chk_ENC9").prop("checked", false);
//    $("#chk_ENC10").prop("checked", false);
//    $("#chk_ENC11").prop("checked", false);
//    $("#chk_ENC12").prop("checked", false);
//    $("#chk_ENC13").prop("checked", false);
//    $("#chk_ENC14").prop("checked", false);
//    $("#chk_ENC15").prop("checked", false);
//    $("#chk_ENC16").prop("checked", false);
//    $("#chk_ENC17").prop("checked", false);
//    $("#chk_ENC18").prop("checked", false);
    
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
            url: '../ajax/bpEncuestaPricing.php?action=selectAll',
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
    $.post("../ajax/bpEncuestaPricing.php?action=selectById", {Id: Id}, function (datos, estado) {
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
        //if(datos.CAMPO3 == '1'){
        //    $('#pregunta9').val('5. Actualmente el precio para realizar una referencia bancaria en ventanilla es de USD 2,52. ¿Estaría dispuesto(a) a realizar la referencia Bancaria a través de la WEB si el precio fuese de USD 0.25?');
        //}
        //else if(datos.CAMPO3 == '2'){
        //    $('#pregunta9').val('5. Actualmente el precio para realizar una referencia bancaria en ventanilla es de USD 2,52. ¿Estaría dispuesto(a) a realizar la referencia Bancaria a través de la WEB si el precio fuese de USD 1.50?');
        //}
        //else if(datos.CAMPO3 == '3'){
        //    $('#pregunta9').val('5. Actualmente el precio para realizar una referencia bancaria en ventanilla es de USD 2,52. ¿Estaría dispuesto(a) a realizar la referencia Bancaria a través de la WEB si el precio fuese de USD 2.00?');
        //}
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
                url: '../ajax/bpEncuestaPricing.php?action=estatus',
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
                url: '../ajax/bpEncuestaPricing.php?action=telefonos',
                data: {idC: idC},
                success: function (r) {
                    $('#fonos').html(r);
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
            url: '../ajax/bpEncuestaPricing.php?action=level2',
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
        limpiar_formulario();
    }
});

$("#level2").change(function () {
    var level1 = $("#level1 option:selected").text();
    var level2 = $("#level2 option:selected").text();
    var camp = $("#CAMPANIA").val();
    if (level1 !== "" && level2 !== "") {
        id = $.ajax({
            type: "GET",
            url: '../ajax/bpEncuestaPricing.php?action=code',
            data: {camp: camp, level1: level1, level2: level2},
            success: function (r) {
                $('#code').val(r);
                if (r == 1) {
                    $('#respuesta1').attr('required', true);
					$('#respuesta1').attr('readonly', false);
					$('#respuesta2').attr('required', true);
					$('#respuesta2').attr('readonly', false);
					$('#respuesta3').attr('required', true);
					$('#respuesta3').attr('readonly', false);
					$('#respuesta4').attr('required', true);
					$('#respuesta4').attr('readonly', false);
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
            url: '../ajax/bpEncuestaPricing.php?action=code1',
            data: {camp: camp, level1: level1, level2: level2, level3: level3},
            success: function (r) {
                $('#code').val(r);
            }
        });
    }
});

$('#btnFonos').click(function () {
    var phones = $("#fonos option:selected").text();
    var estatusTel = $("#estatusTel option:selected").text();
    if (phones != "" && estatusTel != "") {
        var IDC = $("#IDC").val();
        $.ajax({
            url: '../ajax/bpEncuestaPricing.php?action=updatePhones',
            method: 'POST',
            data: {IDC: IDC, fonos: phones, estatusTel: estatusTel},
            success: function (r) {
                bootbox.alert(r);
                $.ajax({
                    type: "GET",
                    url: '../ajax/bpEncuestaPricing.php?action=telefonos',
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

$('#cbox2').change(function () {
    if (!$(this).is(":checked")) {
        $('#otro').attr('disabled', true);
        $('#otro').attr('required', false);
    } else {
        $('#otro').attr('disabled', false);
        $('#otro').attr('required', true);
    }
});

$('#respuesta7').change(function () {
    if ($('#respuesta7').val() == 'Ventanilla' || $('#respuesta7').val() == 'Agencia' || $('#respuesta7').val() == 'Ventanilla y agencia') {
        $('#pregunta8').val("4. ¿Cuál es la razón por la que realiza sus operaciones a través de Ventanilla?");
        $('#respuesta8').attr('required', true);
        $('#respuesta8').attr('readonly', false);

    } else if ($('#respuesta7').val() == 'Web' || $('#respuesta7').val() == 'Web y agencia'){
        $('#pregunta8').val("4.1. ¿Por qué razón sigue utilizando ventanilla?");
        $('#respuesta8').attr('required', true);
        $('#respuesta8').attr('readonly', false);
    } else if ($('#respuesta7').val() == 'Balcón de servicios' || $('#respuesta7').val() == 'Call center'){
        $('#pregunta8').val("4.2. ¿Por qué utiliza este medio?");
        $('#respuesta8').attr('required', true);
        $('#respuesta8').attr('readonly', false);
    }
    else{
        $('#respuesta8').attr('required', false);
        $('#respuesta8').attr('readonly', true);
        $('#respuesta8').val("");
    }
});

function guardar_datos(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    var IdClient = $("#IDC").val();
    $.ajax({
        type: "GET",
        url: '../ajax/bpEncuestaPricing.php?action=validePhone',
        data: {IdClient: IdClient},
        success: function (v) {
            var r = $("#code").val();
            if (v == "Almacene un número de teléfono para continuar!") {
                event.preventDefault();
                bootbox.alert(v);
            } else {
                var formData = new FormData($("#formulario")[0]);
                $.ajax({
                    url: "../ajax/bpEncuestaPricing.php?action=save",
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
    });

}

init(); /* ejecuta la función inicial */