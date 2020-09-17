var tabla;
function init() { /* función inicial */
    mostrar_formulario(false);
    mostrar_todos();
    $("#formulario").on("submit", function (e) {
        guardar_datos(e);
    });

    $('#otro').attr('disabled', true);
    $('#fonoAd').on("paste", function (e) {
        e.preventDefault();
    });
    $('#level3').attr('disabled', true);

    $('#textCell').hide();
    $('#celularTextTCP').attr('disabled', true);
    $('#celularTCP').attr('disabled', true);
    $('#TIENE_WHATSAPP').attr('readonly', true);
    $('#CORREO').attr('readonly', true);
    $('#TIPO_DEBITO').attr('readonly', true);
    $('#NUMERO_TC').attr('readonly', true);
    $('#FECHA_CADUCIDAD').attr('readonly', true);
    $('#CODIGO_SEGURIDAD').attr('readonly', true);
}

function limpiar_formulario() {
    document.getElementById("formulario").reset();
    $("#titulo").text("Campaña Jardines del Valle");
    $("#titulo1").text("");
    $("#titulo2").text("");
    $("#celularTextTCP").val("");
    $("#celularTCP").val("");
    $("#TIENE_WHATSAPP").val("");
    $("#CORREO").val("");
    $("#TIPO_DEBITO").val("");
    $("#NUMERO_TC").val("");
    $("#FECHA_CADUCIDAD").val("");
    $("#CODIGO_SEGURIDAD").val("");
    $('#celularTextTCP').attr('required', false);
    $('#celularTCP').attr('required', false);
    $('#TIENE_WHATSAPP').attr('required', false);
    $('#CORREO').attr('required', false);
    $('#TIPO_DEBITO').attr('required', false);
    $('#NUMERO_TC').attr('required', false);
    $('#FECHA_CADUCIDAD').attr('required', false);
    $('#CODIGO_SEGURIDAD').attr('required', false);
    $('#celularTextTCP').attr('disabled', true);
    $('#celularTCP').attr('disabled', true);
    $('#TIENE_WHATSAPP').attr('readonly', true);
    $('#CORREO').attr('readonly', true);
    $('#TIPO_DEBITO').attr('readonly', true);
    $('#NUMERO_TC').attr('readonly', true);
    $('#FECHA_CADUCIDAD').attr('readonly', true);
    $('#CODIGO_SEGURIDAD').attr('readonly', true);
    $("#agenda").attr("readonly", true);
    $("#agenda").attr("required", false);
    $("#obs").attr("required", false);
}

function cancelar_formulario() { /* función para cancelar la operación */
    limpiar_formulario();
    mostrar_formulario(false);
    $("#titulo").text("Campaña Jardines del Valle");
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
            url: '../ajax/jardinesDelValleC.php?action=selectAll',
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
    $.post("../ajax/jardinesDelValleC.php?action=selectById", {Id: Id}, function (datos, estado) {
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
        $('#TIPO_CONTRATO').val(datos.TIPO_CONTRATO);
        $('#IDENTIFICACION').val(datos.IDENTIFICACION);
        $('#NOMBRE_CLIENTE').val(datos.NOMBRE_CLIENTE);
        $('#CIUDAD1').val(datos.CIUDAD1);
        $('#CIUDAD2').val(datos.CIUDAD2);
        var camp = datos.CampaignId;
        if (camp != "") {
            $.ajax({
                type: "GET",
                url: '../ajax/jardinesDelValleC.php?action=estatus',
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
                url: '../ajax/jardinesDelValleC.php?action=telefonos',
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
        }
        $('#pregunta1').val("Es usted el señor " + datos.NOMBRE_CLIENTE + "?");
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
            url: '../ajax/jardinesDelValleC.php?action=level2',
            data: {level1: level1, camp: camp},
            success: function (r) {
                $('#level2').html(r);
            }
        });
    }
});

$("#level2").change(function () {
    var level1 = $("#level1 option:selected").text();
    var level2 = $("#level2 option:selected").text();
    var camp = $("#CAMPANIA").val();
    if (level1 !== "" && level2 !== "") {
        $.ajax({
            type: "GET",
            url: '../ajax/jardinesDelValleC.php?action=level3',
            data: {camp: camp, level1: level1, level2: level2},
            success: function (r) {
                $('#level3').html(r);
            }
        });
        $.ajax({
            type: "GET",
            url: '../ajax/jardinesDelValleC.php?action=code',
            data: {camp: camp, level1: level1, level2: level2},
            success: function (r) {
                $('#code').val(r);
                if (r == "") {
                    $('#level3').attr('disabled', false);
                    $('#level3').attr('required', true);
                } else {
                    $('#level3').attr('disabled', true);
                    $('#level3').attr('required', false);
                }
                if (r == 1) {
                    $('#celularTextTCP').attr('disabled', false);
                    $('#celularTCP').attr('disabled', false);
                    $('#TIENE_WHATSAPP').attr('readonly', false);
                    $('#CORREO').attr('readonly', false);
                    $('#TIPO_DEBITO').attr('readonly', false);
                    $('#NUMERO_TC').attr('readonly', false);
                    $('#TIENE_WHATSAPP').attr('required', true);
                    $('#CORREO').attr('required', true);
                    $('#TIPO_DEBITO').attr('required', true);
                    $('#NUMERO_TC').attr('required', true);

                } else if (r == 18 || r == 20) {
                    $("#agenda").attr("readonly", false);
                    $("#agenda").attr("required", true);
                    $("#obs").attr("required", true);
                    $('#celularTextTCP').attr('required', false);
                    $('#celularTCP').attr('required', false);
                    $('#TIENE_WHATSAPP').attr('required', false);
                    $('#CORREO').attr('required', false);
                    $('#TIPO_DEBITO').attr('required', false);
                    $('#NUMERO_TC').attr('required', false);
                    $('#FECHA_CADUCIDAD').attr('required', false);
                    $('#CODIGO_SEGURIDAD').attr('required', false);
                    $('#celularTextTCP').attr('disabled', true);
                    $('#celularTCP').attr('disabled', true);
                    $('#TIENE_WHATSAPP').attr('readonly', true);
                    $('#CORREO').attr('readonly', true);
                    $('#TIPO_DEBITO').attr('readonly', true);
                    $('#NUMERO_TC').attr('readonly', true);
                    $('#FECHA_CADUCIDAD').attr('readonly', true);
                    $('#CODIGO_SEGURIDAD').attr('readonly', true);
                    $("#celularTextTCP").val("");
                    $("#celularTCP").val("");
                    $("#TIENE_WHATSAPP").val("");
                    $("#CORREO").val("");
                    $("#TIPO_DEBITO").val("");
                    $("#NUMERO_TC").val("");
                    $("#FECHA_CADUCIDAD").val("");
                    $("#CODIGO_SEGURIDAD").val("");
                } else {
                    $("#agenda").attr("readonly", true);
                    $("#agenda").attr("required", false);
                    $("#obs").attr("required", false);
                    $('#celularTextTCP').attr('required', false);
                    $('#celularTCP').attr('required', false);
                    $('#TIENE_WHATSAPP').attr('required', false);
                    $('#CORREO').attr('required', false);
                    $('#TIPO_DEBITO').attr('required', false);
                    $('#NUMERO_TC').attr('required', false);
                    $('#FECHA_CADUCIDAD').attr('required', false);
                    $('#CODIGO_SEGURIDAD').attr('required', false);
                    $('#celularTextTCP').attr('disabled', true);
                    $('#celularTCP').attr('disabled', true);
                    $('#TIENE_WHATSAPP').attr('readonly', true);
                    $('#CORREO').attr('readonly', true);
                    $('#TIPO_DEBITO').attr('readonly', true);
                    $('#NUMERO_TC').attr('readonly', true);
                    $('#FECHA_CADUCIDAD').attr('readonly', true);
                    $('#CODIGO_SEGURIDAD').attr('readonly', true);
                    $("#celularTextTCP").val("");
                    $("#celularTCP").val("");
                    $("#TIENE_WHATSAPP").val("");
                    $("#CORREO").val("");
                    $("#TIPO_DEBITO").val("");
                    $("#NUMERO_TC").val("");
                    $("#FECHA_CADUCIDAD").val("");
                    $("#CODIGO_SEGURIDAD").val("");
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
            url: '../ajax/jardinesDelValleC.php?action=code1',
            data: {camp: camp, level1: level1, level2: level2, level3: level3},
            success: function (r) {
                $('#code').val(r);
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

$('#TIPO_DEBITO').change(function () {
    if ($('#TIPO_DEBITO').val() == 'CUENTA') {
        $('#NUMERO_TC').attr('required', true);
        $('#FECHA_CADUCIDAD').attr('required', false);
        $('#CODIGO_SEGURIDAD').attr('required', false);
        $('#NUMERO_TC').attr('readonly', false);
        $('#FECHA_CADUCIDAD').attr('readonly', true);
        $('#CODIGO_SEGURIDAD').attr('readonly', true);
    } else if ($('#TIPO_DEBITO').val() == 'TARJETA') {
        $('#NUMERO_TC').attr('required', true);
        $('#FECHA_CADUCIDAD').attr('required', true);
        $('#CODIGO_SEGURIDAD').attr('required', true);
        $('#NUMERO_TC').attr('readonly', false);
        $('#FECHA_CADUCIDAD').attr('readonly', false);
        $('#CODIGO_SEGURIDAD').attr('readonly', false);
    }
});

$('#btnFonos').click(function () {
    var phones = $("#fonos option:selected").text();
    var estatusTel = $("#estatusTel option:selected").text();
    if (phones != "" && estatusTel != "") {
        var IDC = $("#IDC").val();
        $.ajax({
            url: '../ajax/jardinesDelValleC.php?action=updatePhones',
            method: 'POST',
            data: {IDC: IDC, fonos: phones, estatusTel: estatusTel},
            success: function (r) {
                bootbox.alert(r);
                $.ajax({
                    type: "GET",
                    url: '../ajax/jardinesDelValleC.php?action=telefonos',
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

function guardar_datos(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    var IdClient = $("#IDC").val();
    var code = $("#code").val();
    if ($('#celularTextTCP').val() == '' && $('#celularTCP').val() == '' && code == '1') {
        bootbox.alert("Debe ingresar un teléfono para continuar!");
    } else {
        $.ajax({
            type: "GET",
            url: '../ajax/jardinesDelValleC.php?action=validePhone',
            data: {IdClient: IdClient},
            success: function (v) {
                var r = $("#code").val();
                if (v == "Almacene un número de teléfono para continuar!") {
                    event.preventDefault();
                    bootbox.alert(v);
                } else {

                    var formData = new FormData($("#formulario")[0]);
                    $.ajax({
                        url: "../ajax/jardinesDelValleC.php?action=save",
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
}

init(); /* ejecuta la función inicial */