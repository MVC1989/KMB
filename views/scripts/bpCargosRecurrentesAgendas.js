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
    $('#pnlCargos').hide();
    $('#otro').attr('disabled', true);
    $('#subestatus1').attr('disabled', true);
    $('#subestatus2').attr('disabled', true);
}

function limpiar_formulario() {
    document.getElementById("formulario").reset();
    $("#titulo").text("Campaña Banco Pichincha Cargos Recurrentes");
    $("#titulo1").text("");
    $("#titulo2").text("");
}

function cancelar_formulario() { /* función para cancelar la operación */
    limpiar_formulario();
    mostrar_formulario(false);
    $("#titulo").text("Campaña Banco Pichincha Cargos Recurrentes");
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
            url: '../ajax/bpCargosC.php?action=selectAllRec',
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
    $.post("../ajax/bpCargosC.php?action=selectByIdRec", {Id: Id}, function (datos, estado) {
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
        $("#CODIGO_CAMPANIA").val(datos.CODIGO_CAMPANIA);
        $("#NOMBRE_CAMPANIA").val(datos.NOMBRE_CAMPANIA);
        $("#IDENTIFICACION").val(datos.IDENTIFICACION);
        $('#NOMBRE_CLIENTE').val(datos.NOMBRE_CLIENTE);
        $('#TELEFONIA_FIJA').val(datos.TELEFONIA_FIJA);
        $('#INTERNET_FIJO').val(datos.INTERNET_FIJO);
        $('#TELEVISION').val(datos.TELEVISION);
        $('#MOVIL').val(datos.MOVIL);
        $('#txtTelefonia').val(datos.TELEFONIA_FIJA);
        $('#txtInternet').val(datos.INTERNET_FIJO);
        $('#txtTelevision').val(datos.TELEVISION);
        $('#txtMovil').val(datos.MOVIL);
        $('#PLAN_RECOMPENSAS').val(datos.PLAN_RECOMPENSAS);
        $('#CUATRO_ULTIMOS_DIGITOS_TC').val(datos.CUATRO_ULTIMOS_DIGITOS_TC);
        $('#DES_ESTABLECIMIENTO').val(datos.DES_ESTABLECIMIENTO);
        $('#FAMILIA').val(datos.FAMILIA);
        $('#PRODUCTO').val(datos.PRODUCTO);
        $('#PRIMER_APELLIDO').val(datos.PRIMER_APELLIDO);
        $('#SEGUNDO_APELLIDO').val(datos.SEGUNDO_APELLIDO);
        $('#PRIMER_NOMBRE').val(datos.PRIMER_NOMBRE);
        $('#SEGUNDO_NOMBRE').val(datos.SEGUNDO_NOMBRE);
        $('#ESTADO_CIVIL').val(datos.ESTADO_CIVIL);
        $('#TIENE_TARJETA').val(datos.TIENE_TARJETA);
        $('#ZONA').val(datos.ZONA);
        $('#REGION_ANCLAJE').val(datos.REGION_ANCLAJE);
        $('#CORREO1').val(datos.CORREO1);
        $('#CORREO2').val(datos.CORREO2);
        $('#CORREO3').val(datos.CORREO3);
        var camp = datos.CampaignId;
        if (camp != "") {
            $.ajax({
                type: "GET",
                url: '../ajax/bpCargosC.php?action=estatus',
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
                url: '../ajax/bpCargosC.php?action=telefonos',
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
            url: '../ajax/bpCargosC.php?action=level2',
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
        $('#pnlCargos').hide();
        $('#telefonia').attr('required', false);
        $('#Internet').attr('required', false);
        $('#Television').attr('required', false);
        $('#Movil').attr('required', false);
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

$("#level2").change(function () {
    var level1 = $("#level1 option:selected").text();
    var level2 = $("#level2 option:selected").text();
    var camp = $("#CAMPANIA").val();
    if (level1 !== "" && level2 !== "") {
        id = $.ajax({
            type: "GET",
            url: '../ajax/bpCargosC.php?action=code',
            data: {camp: camp, level1: level1, level2: level2},
            success: function (r) {
                $('#code').val(r);
                if (r == 1) {
                    $('#pnlCargos').show();
//                    $('#telefonia').attr('required', true);
//                    $('#Internet').attr('required', true);
//                    $('#Television').attr('required', true);
//                    $('#Movil').attr('required', true);
//                    $('#Triple').attr('required', true);
                } else {
                    $('#pnlCargos').hide();
                    $('#telefonia').attr('required', false);
                    $('#Internet').attr('required', false);
                    $('#Television').attr('required', false);
                    $('#Movil').attr('required', false);
                    $('#Triple').attr('required', false);
                    $('#txtExcluirTelefonia').attr('required', false);
                    $('#txtExcluirInternet').attr('required', false);
                    $('#txtExcluirTelevision').attr('required', false);
                    $('#txtExcluirMovil').attr('required', false);
                    $('#txtExcluirTriple').attr('required', false);
                }
            }
        });
    }
});

$('#telefonia').change(function () {
    if ($('#telefonia').val() == "EXCLUIR") {
        $('#txtExcluirTelefonia').attr('readonly', false);
        $('#txtExcluirTelefonia').attr('required', true);
    } else {
        $('#txtExcluirTelefonia').val("");
        $('#txtExcluirTelefonia').attr('readonly', true);
        $('#txtExcluirTelefonia').attr('required', false);
    }
});

$('#Internet').change(function () {
    if ($('#Internet').val() == "EXCLUIR") {
        $('#txtExcluirInternet').attr('readonly', false);
        $('#txtExcluirInternet').attr('required', true);
    } else {
        $('#txtExcluirInternet').val("");
        $('#txtExcluirInternet').attr('readonly', true);
        $('#txtExcluirInternet').attr('required', false);
    }
});

$('#Television').change(function () {
    if ($('#Television').val() == "EXCLUIR") {
        $('#txtExcluirTelevision').attr('readonly', false);
        $('#txtExcluirTelevision').attr('required', true);
    } else {
        $('#txtExcluirTelevision').val("");
        $('#txtExcluirTelevision').attr('readonly', true);
        $('#txtExcluirTelevision').attr('required', false);
    }
});

$('#Movil').change(function () {
    if ($('#Movil').val() == "EXCLUIR") {
        $('#txtExcluirMovil').attr('readonly', false);
        $('#txtExcluirMovil').attr('required', true);
    } else {
        $('#txtExcluirMovil').val("");
        $('#txtExcluirMovil').attr('readonly', true);
        $('#txtExcluirMovil').attr('required', false);
    }
});

$('#Triple').change(function () {
    if ($('#Triple').val() == "ACTIVAR") {
        $('#txtExcluirTriple').attr('readonly', false);
        $('#txtExcluirTriple').attr('required', true);
    } else {
        $('#txtExcluirTriple').val("");
        $('#txtExcluirTriple').attr('readonly', true);
        $('#txtExcluirTriple').attr('required', false);
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

$('#btnFonos').click(function () {
    var phones = $("#fonos option:selected").text();
    var estatusTel = $("#estatusTel option:selected").text();
    if (phones != "" && estatusTel != "") {
        var IDC = $("#IDC").val();
        $.ajax({
            url: '../ajax/bpCargosC.php?action=updatePhones',
            method: 'POST',
            data: {IDC: IDC, fonos: phones, estatusTel: estatusTel},
            success: function (r) {
                bootbox.alert(r);
                $.ajax({
                    type: "GET",
                    url: '../ajax/bpCargosC.php?action=telefonos',
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
        url: '../ajax/bpCargosC.php?action=validePhone',
        data: {IdClient: IdClient},
        success: function (v) {
            var r = $("#code").val();
            if (v == "Almacene un número de teléfono para continuar!") {
                event.preventDefault();
                bootbox.alert(v);
            } else {

                var formData = new FormData($("#formulario")[0]);
                $.ajax({
                    url: "../ajax/bpCargosC.php?action=save",
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