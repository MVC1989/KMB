var tabla;
function init() { /* función inicial */
    mostrar_formulario(false);
    mostrar_todos();
    $("#formulario").on("submit", function (e) {
        guardar_datos(e);
    });
    //divs y paneles a ocultar
    $('#otro').attr('disabled', true);
    $('#fonoAd').on("paste", function (e) {
        e.preventDefault();
    });
    $('#level3').attr('disabled', true);
    $('#respuesta1').attr('required', false);
    $('#respuesta1').attr('readonly', true);
    $('#respuesta2').attr('required', false);
    $('#respuesta2').attr('readonly', true);
    $('#pregunta2').hide();
    $('#respuesta2').hide();
    $('#respuesta3').attr('required', false);
    $('#respuesta3').attr('readonly', true);
    $('#respuesta4').attr('required', false);
    $('#respuesta4').attr('readonly', true);
    $('#pregunta4').hide();
    $('#respuesta4').hide();
    $('#respuesta5').attr('required', false);
    $('#respuesta5').attr('readonly', true);
    $('#respuesta6').attr('required', false);
    $('#respuesta6').attr('readonly', true);
    $('#pregunta6').hide();
    $('#respuesta6').hide();
    $('#respuesta7').attr('required', false);
    $('#respuesta7').attr('readonly', true);
    $('#pregunta7').hide();
    $('#respuesta7').hide();
}

function limpiar_formulario() {
    $("#titulo").text("Campaña BP Encuestas");
    $("#titulo1").text("");
    $("#titulo2").text("");
    $('#respuesta1').attr('required', false);
    $('#respuesta1').attr('readonly', true);
    $('#respuesta2').attr('required', false);
    $('#respuesta2').attr('readonly', true);
    $('#pregunta2').hide();
    $('#respuesta2').hide();
    $('#respuesta3').attr('required', false);
    $('#respuesta3').attr('readonly', true);
    $('#respuesta4').attr('required', false);
    $('#respuesta4').attr('readonly', true);
    $('#pregunta4').hide();
    $('#respuesta4').hide();
    $('#respuesta5').attr('required', false);
    $('#respuesta5').attr('readonly', true);
    $('#respuesta6').attr('required', false);
    $('#respuesta6').attr('readonly', true);
    $('#pregunta6').hide();
    $('#respuesta6').hide();
    $('#respuesta7').attr('required', false);
    $('#respuesta7').attr('readonly', true);
    $('#pregunta7').hide();
    $('#respuesta7').hide();
    $('#respuesta1').val("");
    $('#respuesta2').val("");
    $('#respuesta3').val("");
    $('#respuesta4').val("");
    $('#respuesta5').val("");
    $('#respuesta6').val("");
    $('#respuesta7').val("");
}

function cancelar_formulario() { /* función para cancelar la operación */
    limpiar_formulario();
    mostrar_formulario(false);
    $("#titulo").text("Campaña BP Encuestas");
    $("#titulo1").text("");
    $("#titulo2").text("");
    $('#level1').val("");
    $('#level2').val("");
    $('#level3').val("");
}

function mostrar_formulario(flag) { /* muestra u oculta el formulario segun la validación del bool (flag) */
    $('#level1').val("");
    $('#level2').val("");
    $('#level3').val("");
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
            url: '../ajax/bpEncuestaGenerica.php?action=selectAll_2',
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
    $.post("../ajax/bpEncuestaGenerica.php?action=selectById", {Id: Id}, function (datos, estado) {
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
                url: '../ajax/bpEncuestaGenerica.php?action=estatus',
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
                url: '../ajax/bpEncuestaGenerica.php?action=telefonos',
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
            url: '../ajax/bpEncuestaGenerica.php?action=level2',
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
            url: '../ajax/bpEncuestaGenerica.php?action=code',
            data: {camp: camp, level1: level1, level2: level2},
            success: function (r) {
                $('#code').val(r);
                if (r == 1) {
                    $('#respuesta1').attr('required', true);
                    $('#respuesta1').attr('readonly', false);
                    $('#respuesta3').attr('required', true);
                    $('#respuesta3').attr('readonly', false);
                    $('#respuesta5').attr('required', true);
                    $('#respuesta5').attr('readonly', false);
                } else if (r == 2) {
                    $('#respuesta1').attr('required', false);
                    $('#respuesta1').attr('readonly', false);
                    $('#respuesta3').attr('required', false);
                    $('#respuesta3').attr('readonly', false);
                    $('#respuesta5').attr('required', false);
                    $('#respuesta5').attr('readonly', false);
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
            url: '../ajax/bpEncuestaGenerica.php?action=code1',
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
            url: '../ajax/bpEncuestaGenerica.php?action=updatePhones',
            method: 'POST',
            data: {IDC: IDC, fonos: phones, estatusTel: estatusTel},
            success: function (r) {
                bootbox.alert(r);
                $.ajax({
                    type: "GET",
                    url: '../ajax/bpEncuestaGenerica.php?action=telefonos',
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

$('#respuesta1').change(function () {
    if ($('#respuesta1').val() == '9' || $('#respuesta1').val() == '10') {
        $('#pregunta2').show();
        $('#respuesta2').show();
        $('#pregunta2').val("1.1. ¿Que fue lo que mas le gusto?");
        $('#respuesta2').attr('readonly', false);
        $('#respuesta2').attr('required', true);
    } else if ($('#respuesta1').val() == '1' || $('#respuesta1').val() == '2' || $('#respuesta1').val() == '3' 
            || $('#respuesta1').val() == '4' || $('#respuesta1').val() == '5' || $('#respuesta1').val() == '6'
            || $('#respuesta1').val() == '7' || $('#respuesta1').val() == '8') {
        $('#pregunta2').show();
        $('#respuesta2').show();
        $('#pregunta2').val("1.2. ¿Que cree que debemos hacer para mejorar?");
        $('#respuesta2').attr('readonly', false);
        $('#respuesta2').attr('required', true);
    }else {
        $('#pregunta2').hide();
        $('#respuesta2').hide();
        $('#respuesta2').val("");
        $('#respuesta2').attr('readonly', true);
        $('#respuesta2').attr('required', false);
    }
});

$('#respuesta3').change(function () {
    if ($('#respuesta3').val() == '9' || $('#respuesta3').val() == '10') {
        $('#pregunta4').show();
        $('#respuesta4').show();
        $('#pregunta4').val("1.1. ¿Que fue lo que mas le gusto?");
        $('#respuesta4').attr('readonly', false);
        $('#respuesta4').attr('required', true);
    } else if ($('#respuesta3').val() == '1' || $('#respuesta3').val() == '2' || $('#respuesta3').val() == '3' 
            || $('#respuesta3').val() == '4' || $('#respuesta3').val() == '5' || $('#respuesta3').val() == '6'
            || $('#respuesta3').val() == '7' || $('#respuesta3').val() == '8') {
        $('#pregunta4').show();
        $('#respuesta4').show();
        $('#pregunta4').val("1.2. ¿Que cree que debemos hacer para mejorar?");
        $('#respuesta4').attr('readonly', false);
        $('#respuesta4').attr('required', true);
    }else {
        $('#pregunta4').hide();
        $('#respuesta4').hide();
        $('#respuesta4').val("");
        $('#respuesta4').attr('readonly', true);
        $('#respuesta4').attr('required', false);
    }
});

$('#respuesta5').change(function () {
    if ($('#respuesta5').val() == '9' || $('#respuesta5').val() == '10') {
        $('#pregunta6').show();
        $('#respuesta6').show();
        $('#pregunta7').show();
        $('#respuesta7').show();
        $('#pregunta6').val("1.1. ¿Que fue lo que mas le gusto?");
        $('#respuesta6').attr('readonly', false);
        $('#respuesta6').attr('required', true);
        $('#respuesta7').attr('readonly', false);
        $('#respuesta7').attr('required', true);
    } else if ($('#respuesta5').val() == '1' || $('#respuesta5').val() == '2' || $('#respuesta5').val() == '3' 
            || $('#respuesta5').val() == '4' || $('#respuesta5').val() == '5' || $('#respuesta5').val() == '6'
            || $('#respuesta5').val() == '7' || $('#respuesta5').val() == '8') {
        $('#pregunta6').show();
        $('#respuesta6').show();
        $('#pregunta7').hide();
        $('#respuesta7').hide();
        $('#pregunta6').val("1.2. ¿Que cree que debemos hacer para mejorar?");
        $('#respuesta6').attr('readonly', false);
        $('#respuesta6').attr('required', true);
        $('#respuesta7').attr('readonly', true);
        $('#respuesta7').attr('required', false);
    }else {
        $('#pregunta6').hide();
        $('#respuesta6').hide();
        $('#pregunta7').hide();
        $('#respuesta7').hide();
        $('#respuesta6').val("");
        $('#respuesta7').val("");
        $('#respuesta6').attr('readonly', true);
        $('#respuesta6').attr('required', false);
        $('#respuesta7').attr('readonly', true);
        $('#respuesta7').attr('required', false);
    }
});

function guardar_datos(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    var IdClient = $("#IDC").val();
    $.ajax({
        type: "GET",
        url: '../ajax/bpEncuestaGenerica.php?action=validePhone',
        data: {IdClient: IdClient},
        success: function (v) {
            var r = $("#code").val();
            if (v == "Almacene un número de teléfono para continuar!") {
                event.preventDefault();
                bootbox.alert(v);
            } else {
                var formData = new FormData($("#formulario")[0]);
                $.ajax({
                    url: "../ajax/bpEncuestaGenerica.php?action=save",
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
