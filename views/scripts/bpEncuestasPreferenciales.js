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
    $('#level3').attr('disabled', true);
}

function limpiar_formulario() {
    document.getElementById("formulario").reset();
    $("#titulo").text("Campaña BP Encuestas");
    $("#titulo1").text("");
    $("#titulo2").text("");
    $('#pnlEncuesta').hide();
    pnlEncuesta(false);
    $('#respuesta1').val("");
    $('#respuesta2').val("");
    $('#respuesta3').val("");
    $('#respuesta4').val("");
    $("#respuesta5").val("");
    $('#respuesta6').val("");
    $('#respuesta7').val("");
    $('#respuesta8').val("");
    $('#respuesta9').val("");
    $('#respuesta10').val("");
    $('#respuesta11').val("");
    $('#respuesta12').val("");
    $('#respuesta13').val("");
    $('#respuesta14').val("");
    $('#respuesta15').val("");
    $('#respuesta16').val("");
    $('#respuesta17').val("");
    $('#respuesta18').val("");
    $("#respuesta3").tokenfield('destroy');
    $("#respuesta4").tokenfield('destroy');
    $("#respuesta5").tokenfield('destroy');
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
        $('#EDAD').val(datos.EDAD);
        $('#REGION').val(datos.REGION);
        $('#LOCALIDAD').val(datos.LOCALIDAD);
        var camp = datos.CampaignId;
        if (camp != "") {
            $.ajax({
                type: "GET",
                url: '../ajax/bpEncuestaFEgasC.php?action=estatus',
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
                url: '../ajax/bpEncuestaFEgasC.php?action=telefonos',
                data: {idC: idC},
                success: function (r) {
                    $('#fonos').html(r);
                }
            });
        }
        $('#respuesta5').tokenfield({
            autocomplete: {
                source: ['Su servicio y atención es ágil', 'Es el Banco del cual soy cliente desde hace mucho tiempo', 'Sus agencias son cercanas', 'Tiene canales alternativos', 'Tiene productos adecuados', 'Facilidad para obtener un crédito', 'Cuotas convenientes de mi crédito', 'Brinda confianza y seguridad', 'Sus tasas de interés son adecuadas', 'Recibo mi sueldo en esta institución', 'Buena atención al cliente', 'Tiempo de respuesta adecuado', 'Horarios de atención de lunes a viernes más amplios', 'Horarios de atención sábados más amplios', 'Horarios de atención domingos más amplios', 'Mi familia tiene cuenta ahí', 'Intereses que paga por mis ahorros'],
                delay: 100
            },
            showAutocompleteOnFocus: true
        });

        $('#respuesta3').tokenfield({
            autocomplete: {
                source: [
                    'Banco AMAZONAS',
                    'Banco AUSTRO',
                    'Banco BANCO  DESARROLLO DE LOS PUEBLOS  S.A., CODESARROLLO',
                    'Banco BOLIVARIANO',
                    'Banco CAPITAL',
                    'Banco COMERCIAL DE MANABI',
                    'Banco COOPNACIONAL',
                    'Banco DELBANK',
                    'Banco DINERS',
                    'Banco D-MIRO S.A.',
                    'Banco FINCA S.A.',
                    'Banco GENERAL RUMIÑAHUI',
                    'Banco GUAYAQUIL',
                    'Banco INTERNACIONAL',
                    'Banco LITORAL',
                    'Banco LOJA',
                    'Banco MACHALA',
                    'Banco PACIFICO',
                    'Banco PICHINCHA',
                    'Banco PROCREDIT',
                    'Banco PRODUBANCO',
                    'Banco SOLIDARIO',
                    'Banco VISIONFUND ECUADOR S.A.',
                    'Cooperativa Oscus',
                    'Cooperativa Jep',
                    'Cooperativa 29 de octubre',
                    'Cooperativa Policía Nacional',
                    'Cooperativa Alianza del Valle',
                    'Cooperativa Jardín Azuayo'
                ],
                delay: 100
            },
            showAutocompleteOnFocus: true
        });

        $('#respuesta4').tokenfield({
            autocomplete: {
                source: [
                    'Banco AMAZONAS',
                    'Banco AUSTRO',
                    'Banco BANCO  DESARROLLO DE LOS PUEBLOS  S.A., CODESARROLLO',
                    'Banco BOLIVARIANO',
                    'Banco CAPITAL',
                    'Banco COMERCIAL DE MANABI',
                    'Banco COOPNACIONAL',
                    'Banco DELBANK',
                    'Banco DINERS',
                    'Banco D-MIRO S.A.',
                    'Banco FINCA S.A.',
                    'Banco GENERAL RUMIÑAHUI',
                    'Banco GUAYAQUIL',
                    'Banco INTERNACIONAL',
                    'Banco LITORAL',
                    'Banco LOJA',
                    'Banco MACHALA',
                    'Banco PACIFICO',
                    'Banco PICHINCHA',
                    'Banco PROCREDIT',
                    'Banco PRODUBANCO',
                    'Banco SOLIDARIO',
                    'Banco VISIONFUND ECUADOR S.A.',
                    'Cooperativa Oscus',
                    'Cooperativa Jep',
                    'Cooperativa 29 de octubre',
                    'Cooperativa Policía Nacional',
                    'Cooperativa Alianza del Valle',
                    'Cooperativa Jardín Azuayo'
                ],
                delay: 100
            },
            showAutocompleteOnFocus: true
        });
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
            url: '../ajax/bpEncuestaFEgasC.php?action=level2',
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
        $('#pnlEncuesta').hide();
        pnlEncuesta(false);
    }
});

$("#level2").change(function () {
    var level1 = $("#level1 option:selected").text();
    var level2 = $("#level2 option:selected").text();
    var camp = $("#CAMPANIA").val();
    if (level1 !== "" && level2 !== "") {
        id = $.ajax({
            type: "GET",
            url: '../ajax/bpEncuestaFEgasC.php?action=code',
            data: {camp: camp, level1: level1, level2: level2},
            success: function (r) {
                $('#code').val(r);
                if (r == 1) {
                    $('#pnlEncuesta').show();
                    pnlEncuesta(true);
                } else {
                    $('#pnlEncuesta').hide();
                    pnlEncuesta(false);
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
            url: '../ajax/bpEncuestaFEgasC.php?action=code1',
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
            url: '../ajax/bpEncuestaFEgasC.php?action=updatePhones',
            method: 'POST',
            data: {IDC: IDC, fonos: phones, estatusTel: estatusTel},
            success: function (r) {
                bootbox.alert(r);
                $.ajax({
                    type: "GET",
                    url: '../ajax/bpEncuestaFEgasC.php?action=telefonos',
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
    $.ajax({
        type: "GET",
        url: '../ajax/bpEncuestaFEgasC.php?action=validePhone',
        data: {IdClient: IdClient},
        success: function (v) {
            var r = $("#code").val();
            if (v == "Almacene un número de teléfono para continuar!") {
                event.preventDefault();
                bootbox.alert(v);
            } else {
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
                limpiar_formulario();
            }
        }
    });
}

init(); /* ejecuta la función inicial */

function pnlEncuesta(state) {
    $('#respuesta1').attr('required', state);
    $('#respuesta2').attr('required', state);
    $('#respuesta3').attr('required', state);
    $('#respuesta4').attr('required', state);
    $('#respuesta5').attr('required', state);
    $('#respuesta6').attr('required', state);
    $('#respuesta7').attr('required', state);
    $('#respuesta8').attr('required', state);
    $('#respuesta9').attr('required', state);
    $('#respuesta10').attr('required', state);
    $('#respuesta11').attr('required', state);
    $('#respuesta12').attr('required', state);
    $('#respuesta13').attr('required', state);
    $('#respuesta14').attr('required', state);
    $('#respuesta15').attr('required', state);
    $('#respuesta16').attr('required', state);
    $('#respuesta17').attr('required', state);
    $('#respuesta18').attr('required', state);
}