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
    $('#pnlEncuesta').hide();
    $('#otro').attr('disabled', true);
    $('#subestatus1').attr('disabled', true);
    $('#subestatus2').attr('disabled', true);
}

function limpiar_formulario() {
    document.getElementById("formulario").reset();
    $("#titulo").text("Campañas Banco Pichincha Encuesta");
    $("#titulo1").text("");
    $("#titulo2").text("");
}

function cancelar_formulario() { /* función para cancelar la operación */
    limpiar_formulario();
    mostrar_formulario(false);
    $("#titulo").text("Campañas Banco Pichincha Encuesta");
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
            url: '../ajax/encuestaC.php?action=selectAll',
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
    $.post("../ajax/encuestaC.php?action=selectById", {Id: Id}, function (datos, estado) {
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
        $("#titulo").text(datos.NOMBRE_CAMPANA);
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
        $("#CODIGO_CAMPANIA").val(datos.CODIGOCAMPANA);
        $("#NOMBRE_CAMPANIA").val(datos.NOMBRE_CAMPANA);
        $("#IDENTIFICACION").val(datos.IDENTIFICACION);
        $("#NOMBRE").val(datos.NOMBRE_CLIENTE);
        $("#CODIGO_AGENCIA").val(datos.CODIGO_AGENCIA);
        $("#AGENCIA").val(datos.AGENCIA);
        $("#ZONA").val(datos.ZONA);
        $("#REGION").val(datos.REGION);
        $("#SUBSEGMENTO").val(datos.SUBSEGMENTO);
        $("#VAR_TOTAL_AHORROS_AGO30").val(datos.VAR_TOTAL_AHORROS_AGO30);
        $("#VAR_TOTAL_AHORROS_SEP20").val(datos.VAR_TOTAL_AHORROS_SEP20);
        $("#PRIORIDAD").val(datos.PRIORIDAD);
        $("#FAMILIA").val(datos.FAMILIA);
        $("#PRODUCTO").val(datos.PRODUCTO);
        $("#PLAN_RECOMPENSAS").val(datos.PLAN_RECOMPENSAS);
        $("#COD_MARCA").val(datos.COD_MARCA);
        $("#CORREO_TRX").val(datos.CORREO_TRX);
        $("#CORREO").val(datos.CORREO);
        var camp = datos.CampaignId;
        if (camp != "") {
            $.ajax({
                type: "GET",
                url: '../ajax/ecuasistenciasC.php?action=estatus',
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
                url: '../ajax/encuestaC.php?action=telefonos',
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
            url: '../ajax/encuestaC.php?action=level2',
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
        $('#motivos').attr('required', false);
        $('#depositos').attr('required', false);
    }
//    if (text == "CU5") {
//        $('#pnlProductos').show();
//        $('#producto').attr("required", true);
//    } else {
//        $('#pnlProductos').hide();
//        $('#producto').attr("required", false);
//        $('#listadoProd').attr('disabled', true);
//        $('#listadoProd').attr('required', false);
//        $('#otroProd').attr('required', false);
//        $('#otroProd').attr('readonly', true);
//        $('#otroProd').attr('required', false);
//    }
});

$('#motivos').change(function () {
    if ($('#motivos').val() == "Traslado a otra entidad") {
        $('#especificar').attr('readonly', false);
        $('#especificar').attr('required', true);
    } else if ($('#motivos').val() == "Otros") {
        $('#especificar').attr('readonly', false);
        $('#especificar').attr('required', true);
    } else if ($('#motivos').val() == "Pagos") {
        $('#especificar').attr('readonly', false);
        $('#especificar').attr('required', true);
    } else {
        $('#especificar').attr('readonly', true);
        $('#especificar').attr('required', false);
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
    var level1 = $("#level1 option:selected").text();
    var level2 = $("#level2 option:selected").text();
    var camp = $("#CAMPANIA").val();
    if (level1 !== "" && level2 !== "") {
        id = $.ajax({
            type: "GET",
            url: '../ajax/encuestaC.php?action=code',
            data: {camp: camp, level1: level1, level2: level2},
            success: function (r) {
                $('#code').val(r);
                if (r == 1) {
                    $('#pnlEncuesta').show();
                    $('#motivos').attr('required', true);
                    $('#depositos').attr('required', true);
                } else {
                    $('#pnlEncuesta').hide();
                    $('#motivos').attr('required', false);
                    $('#depositos').attr('required', false);
                }
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

$('#btnFonos').click(function () {
    var phones = $("#fonos option:selected").text();
    var estatusTel = $("#estatusTel option:selected").text();
    if (phones != "" && estatusTel != "") {
        var IDC = $("#IDC").val();
        $.ajax({
            url: '../ajax/encuestaC.php?action=updatePhones',
            method: 'POST',
            data: {IDC: IDC, fonos: phones, estatusTel: estatusTel},
            success: function (r) {
                bootbox.alert(r);
                $.ajax({
                    type: "GET",
                    url: '../ajax/encuestaC.php?action=telefonos',
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

function guardar_datos(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    var IdClient = $("#IDC").val();
    $.ajax({
        type: "GET",
        url: '../ajax/encuestaC.php?action=validePhone',
        data: {IdClient: IdClient},
        success: function (v) {
            var r = $("#code").val();
            if (v == "Almacene un número de teléfono para continuar!") {
                event.preventDefault();
                bootbox.alert(v);
            } else {

                var formData = new FormData($("#formulario")[0]);
                $.ajax({
                    url: "../ajax/encuestaC.php?action=save",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (datos) {
                        bootbox.alert(datos);
                        mostrar_formulario(false);
                        tabla.ajax.reload();
                        $("#btnGuardar").prop("disabled", true);
                    }
                });
            }
        }
    });
}

init(); /* ejecuta la función inicial */