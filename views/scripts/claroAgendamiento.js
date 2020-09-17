var tabla;
function init() { /* función inicial */
    mostrar_formulario(false);
    mostrar_todos();
    $("#formulario").on("submit", function (e) {
        guardar_datos(e);
    });
    //funciones
    pnlVentas(false, true);
    $('#otro').attr('disabled', true);
    $('#fonoAd').on("paste", function (e) {
        e.preventDefault();
    });
    $('#level3').attr('disabled', true);
    $('#CVV').attr('readonly', true);
}

function limpiar_formulario() {
    document.getElementById("formulario").reset();
    $("#titulo").text("Campaña Claro Ventas");
    $("#titulo1").text("");
    $("#titulo2").text("");
    pnlVentas(false, true);
}

function cancelar_formulario() { /* función para cancelar la operación */
    limpiar_formulario();
    mostrar_formulario(false);
    $("#titulo").text("Campaña Claro Ventas");
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
            url: '../ajax/claroC.php?action=selectAllRec',
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
    $.post("../ajax/claroC.php?action=selectByIdRec", {Id: Id}, function (datos, estado) {
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
        $("#titulo").text(datos.NOMBRE_CLIENTE);
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
        $('#NOMBRES').val(datos.NOMBRES);
        $('#CORREO').val(datos.CORREO);
        $('#ESTADO_CIVIL').val(datos.ESTADO_CIVIL);
        $('#REGION_PROVINCIA').val(datos.REGION_PROVINCIA);
        $('#FECHA_NACIMIENTO').val(datos.FECHA_NACIMIENTO);
        $('#TIPO_DEBITO').val(datos.TIPO_DEBITO);
        $('#NUMERO_DEBITO').val(datos.NUMERO_DEBITO);
        $('#NUMERO_REFERENCIA').val(datos.NUMERO_REFERENCIA);
        $('#CODIGO_PLAN').val(datos.CODIGO_PLAN);
        $('#DIRECCION').val(datos.DIRECCION);
        var camp = datos.CampaignId;
        if (camp != "") {
            $.ajax({
                type: "GET",
                url: '../ajax/claroC.php?action=estatus',
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
                url: '../ajax/claroC.php?action=telefonos',
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
            url: '../ajax/claroC.php?action=level2',
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
            url: '../ajax/claroC.php?action=level3',
            data: {camp: camp, level1: level1, level2: level2},
            success: function (r) {
                $('#level3').html(r);
            }
        });
        $.ajax({
            type: "GET",
            url: '../ajax/claroC.php?action=code',
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
                    pnlVentas(true, false);
                } else if (r == 18 || r == 20) {
                    $("#agenda").attr("readonly", false);
                    $("#agenda").attr("required", true);
                    $("#obs").attr("required", true);
                    pnlVentas(false, true);
                } else {
                    $("#agenda").attr("readonly", true);
                    $("#agenda").attr("required", false);
                    $("#obs").attr("required", false);
                    pnlVentas(false, true);
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
            url: '../ajax/claroC.php?action=code1',
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
            url: '../ajax/claroC.php?action=updatePhones',
            method: 'POST',
            data: {IDC: IDC, fonos: phones, estatusTel: estatusTel},
            success: function (r) {
                bootbox.alert(r);
                $.ajax({
                    type: "GET",
                    url: '../ajax/claroC.php?action=telefonos',
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

$('#TIPO_DEBITO').change(function () {
    var txt = $('#TIPO_DEBITO').val();
    if (txt == 'TARJETA DE CREDITO') {
        $('#CVV').attr('readonly', false);
        $('#CVV').attr('required', true);
    } else {
        $('#CVV').attr('readonly', true);
        $('#CVV').attr('required', false);
    }
});

function guardar_datos(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    var IdClient = $("#IDC").val();
    $.ajax({
        type: "GET",
        url: '../ajax/claroC.php?action=validePhone',
        data: {IdClient: IdClient},
        success: function (v) {
            if (v == "Almacene un número de teléfono para continuar!") {
                event.preventDefault();
                bootbox.alert(v);
            } else {
                var formData = new FormData($("#formulario")[0]);
                $.ajax({
                    url: "../ajax/claroC.php?action=save",
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

function pnlVentas(required,readonly) {
    $('#IDENTIFICACION').attr('required', required);
    $('#NOMBRES').attr('required', required);
    $('#CORREO').attr('required', required);
    $('#ESTADO_CIVIL').attr('required', required);
    $('#REGION_PROVINCIA').attr('required', required);
    $('#FECHA_NACIMIENTO').attr('required', required);
    $('#TIPO_DEBITO').attr('required', required);
    $('#NUMERO_DEBITO').attr('required', required);
    $('#OPERADORA_ACTUAL').attr('required', required);
    $('#NUMERO_REFERENCIA').attr('required', required);
    $('#CODIGO_PLAN').attr('required', required);
    $('#DIRECCION').attr('required', required);
    $('#IDENTIFICACION').attr('readonly', readonly);
    $('#NOMBRES').attr('readonly', readonly);
    $('#CORREO').attr('readonly', readonly);
    $('#ESTADO_CIVIL').attr('readonly', readonly);
    $('#REGION_PROVINCIA').attr('readonly', readonly);
    $('#FECHA_NACIMIENTO').attr('readonly', readonly);
    $('#TIPO_DEBITO').attr('readonly', readonly);
    $('#NUMERO_DEBITO').attr('readonly', readonly);
    $('#OPERADORA_ACTUAL').attr('readonly', readonly);
    $('#NUMERO_REFERENCIA').attr('readonly', readonly);
    $('#CODIGO_PLAN').attr('readonly', readonly);
    $('#DIRECCION').attr('readonly', readonly);
}