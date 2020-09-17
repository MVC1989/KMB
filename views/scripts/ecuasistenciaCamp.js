var tabla;
var id;
function init() { /* función inicial */
    mostrar_formulario(false);
    mostrar_todos();
    $("#formulario").on("submit", function (e) {
        guardar_datos(e);
    });
//    $('#level3').hide();
//    $('#spnLevel3').hide();
    $('#otro').attr('disabled', true);
    $('#fonoAd').on("paste", function (e) {
        e.preventDefault();
    });
    $('#level3').attr('disabled', true);
    $('#EMAIL').attr('readonly', true);
}

function limpiar_formulario() {
    $('#EMAIL').attr('required', false);
    $('#EMAIL').attr('readonly', true);
    $('#PLAN').attr('required', false);
    $('#PLAN').attr('readonly', true);
    $('#PLAN').val("");
}

function cancelar_formulario() { /* función para cancelar la operación */
    limpiar_formulario();
    mostrar_formulario(false);
    $("#titulo").text("Campañas Ecuasistencias");
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
            url: '../ajax/ecuasistenciasC.php?action=selectAll',
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
    $.post("../ajax/ecuasistenciasC.php?action=selectById", {Id: Id}, function (datos, estado) {
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
        $("#titulo").text(datos.Nombres);
        $("#titulo1").text(datos.Tarjeta);
        $("#titulo2").text(datos.Cuenta);
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
        $("#agendaF").val(datos.FechaAgenda);
        $("#agendaH").val(datos.HoraAgenda);
        $("#obs").val(datos.Observaciones);
        $("#IDC").val(datos.ContactId);
        $("#CAMPANIA").val(datos.CampaignId);
        $("#NOMBRES").val(datos.Nombres);
        $("#IDENTIFICACION").val(datos.Identificacion);
        $("#REGION").val(datos.region);
        $("#PROVINCIA").val(datos.provincia);
        $("#CIUDAD").val(datos.Ciudad);
        $("#GENERO").val(datos.Genero);
        $("#EMAIL").val(datos.Email);
        $("#CUENTA").val(datos.Cuenta);
        $("#TARJETA").val(datos.Tarjeta);
        $("#TIPOPLAN").val(datos.TipoPlan);
        $("#TELEFONO1").val(datos.Telefono1);
        $("#TELEFONO2").val(datos.Telefono2);
        $("#TELEFONO3").val(datos.Telefono3);
        $("#TELEFONO4").val(datos.Telefono4);
        $("#TELEFONO5").val(datos.Telefono5);
        $("#TELEFONO6").val(datos.Telefono6);
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
        var idC = datos.ContactId;
        if (idC != "") {
            $.ajax({
                type: "GET",
                url: '../ajax/ecuasistenciasC.php?action=telefonos',
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
            url: '../ajax/ecuasistenciasC.php?action=level2',
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
            url: '../ajax/ecuasistenciasC.php?action=level3',
            data: {camp: camp, level1: level1, level2: level2},
            success: function (r) {
                $('#level3').html(r);
            }
        });
        $.ajax({
            type: "GET",
            url: '../ajax/ecuasistenciasC.php?action=code',
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
                    $('#agendaF').attr('readonly', true);
                    $('#agendaH').attr('readonly', true);
                    $('#agendaF').attr('required', false);
                    $('#agendaH').attr('required', false);
                    $('#EMAIL').attr('required', true);
                    $('#EMAIL').attr('readonly', false);
                    $('#PLAN').attr('required', true);
                    $('#PLAN').attr('readonly', false);
                } else if (r == 18 || r == 20) {
                    $('#agendaF').attr('readonly', false);
                    $('#agendaH').attr('readonly', false);
                    $('#agendaF').attr('required', true);
                    $('#agendaH').attr('required', true);
                    $('#EMAIL').attr('required', false);
                    $('#EMAIL').attr('readonly', true);
                    $('#PLAN').attr('required', false);
                    $('#PLAN').attr('readonly', true);
                } else {
                    $('#agendaF').attr('readonly', true);
                    $('#agendaH').attr('readonly', true);
                    $('#agendaF').attr('required', false);
                    $('#agendaH').attr('required', false);
                    $('#EMAIL').attr('required', false);
                    $('#EMAIL').attr('readonly', true);
                    $('#PLAN').attr('required', false);
                    $('#PLAN').attr('readonly', true);

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
            url: '../ajax/ecuasistenciasC.php?action=code1',
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

$('#btnFonos').click(function () {
    var phones = $("#fonos option:selected").text();
    var estatusTel = $("#estatusTel option:selected").text();
    if (phones != "" && estatusTel != "") {
        var IDC = $("#IDC").val();
        $.ajax({
            url: '../ajax/ecuasistenciasC.php?action=updatePhones',
            method: 'POST',
            data: {IDC: IDC, fonos: phones, estatusTel: estatusTel},
            success: function (r) {
                bootbox.alert(r);
                /*$.ajax({
                 type: "GET",
                 url: '../ajax/ecuasistenciasC.php?action=telefonos',
                 data: {idC: IDC},
                 success: function (r) {
                 $('#fonos').html(r);
                 }
                 });*/
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
        url: '../ajax/ecuasistenciasC.php?action=validePhone',
        data: {IdClient: IdClient},
        success: function (r) {
            if (r == "No ha almacenado números de teléfonos") {
                event.preventDefault();
                bootbox.alert(r);
            } else {
                var formData = new FormData($("#formulario")[0]);
                $.ajax({
                    url: "../ajax/ecuasistenciasC.php?action=save",
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

function validatePhoneCelular(phone) {
    var re = /^(\0)?[ -]*(09)[ -]*([0-9][ -]*){8}$/;
    return re.test(phone);
}

function validatePhoneConvencional(phone) {
    var re = /^(\0)?[ -]*(0[2-7])[ -]*([0-9][ -]*){7}$/;
    return re.test(phone);
}

init(); /* ejecuta la función inicial */