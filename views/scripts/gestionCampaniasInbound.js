var tabla;
function init() { /* función inicial */
    mostrar_formulario(false);
    $('#listadoRegistros').hide();

    $("#formulario").on("submit", function (e) {
        guardar_datos(e);
    });

    pnlEncuestaOscus(true, false);
    $('#txtConvencional').attr('readonly', true);
    $('#txtCorreo').attr('readonly', true);
    $('#txtTerceraPersona').attr('readonly', true);
    $("#btnGuardar").prop("disabled", true);
}

function limpiar_formulario() { /* limpia los datos de los formularios */
    pnlTRX(false, true);
    pnlEncuestaOscus(false, true);
//    $("#pnlEncuestaOscus").hide();
//    $('#encuestaOscus').hide();
    $('#respuesta2').attr('required', false);
    $('#respuesta2').attr('readonly', true);
    $('#respuesta4').attr('required', false);
    $('#respuesta4').attr('readonly', true);
    $('#respuesta6').attr('required', false);
    $('#respuesta6').attr('readonly', true);
    $('#respuesta8').attr('required', false);
    $('#respuesta8').attr('readonly', true);
    $('#txtTerceraPersona').attr('required', false);
    $('#txtTerceraPersona').attr('readonly', true);
    $('#txtConvencional').attr('readonly', true);
    $('#txtCorreo').attr('readonly', true);
}

function mostrar_formulario(flag) { /* muestra u oculta el formulario segun la validación del bool (flag) */
    limpiar_formulario();
    if (flag) {
        $("#listadoRegistros").hide();
        $("#formularioRegistros").show();
        $("#btnNuevaGestion").prop("disabled", false);
        $("#btnGuardar").prop("disabled", true);
        $("#btnBuscar").prop("disabled", true);
    } else {
        $("#listadoRegistros").show();
        $("#formularioRegistros").hide();
        $("#btnNuevaGestion").prop("disabled", true);
        $("#btnGuardar").prop("disabled", false);
        $("#btnBuscar").prop("disabled", false);
    }
}

function cancelar_formulario() { /* función para cancelar la operación */
    limpiar_formulario();
    mostrar_formulario(false);
}

$("#btnBuscar").click(function () {
    var txtCoop = $("#txtCoop").val();
    var txtFechaInicio = obtenerFecha2($("#txtFechaInicio").val());
    var txtFechaFin = obtenerFecha2($("#txtFechaFin").val());
    if ($("#txtFechaInicio").val() == "" || $("#txtFechaFin").val() == "") {
        bootbox.alert("Seleccione todos los campos!");
    } else {
        $('#listadoRegistros').show();
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
                url: '../ajax/campaniasInboundC.php?action=selectAll',
                data: {
                    txtCoop: txtCoop,
                    txtFechaInicio: txtFechaInicio,
                    txtFechaFin: txtFechaFin
                },
                type: "post",
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
            "order": [[1, "asc"]]
        }).DataTable();
    }
});

function mostrar_uno(Id) {
    $.post("../ajax/campaniasInboundC.php?action=selectById", {Id: Id}, function (datos, estado) {
        datos = JSON.parse(datos);
        mostrar_formulario(true);        
        $("#txtId").val(datos.ID);
        $("#txtCooperativa").val(datos.Cooperativa);
        $("#txtTipoLlamada").val(datos.TipoLlamada);
        $("#txtEstadoLlamada").val(datos.EstadoLlamada);
        $("#horaInicio").val(datos.StartedManagement);
        $("#horaFin").val(datos.TmStmp);
        $("#txtIdentificacion").val(datos.Identificacion);
        $("#txtNombreCliente").val(datos.NombreCliente);
        $("#txtCiudadCliente").val(datos.CiudadCliente);
        $("#txtCelular").val(datos.Celular);
        $("#txtConvencional").val(datos.Convencional);
        $("#txtCorreo").val(datos.Correo);
        $("#txtTipoCliente").val(datos.TipoCliente);
        $("#txtTerceraPersona").val(datos.TerceraPersona);
        $("#txtMotivoLlamada").val(datos.MotivoLlamada);
        $("#txtSubmotivoLlamada").empty();
        $("#txtSubmotivoLlamada").append('<option>' + datos.SubmotivoLlamada + '</option>');
        $("#txtObservaciones").val(datos.Observaciones);
        $("#txtEstadoCliente").val(datos.EstadoCliente);
        $("#txtEstadoEncuesta").val(datos.EstadoEncuesta);
        $("#txtObservacionesEncuesta").val(datos.ObservacionesEncuesta);
        $("#respuesta1").val(datos.respuesta1);
        $("#respuesta2").val(datos.respuesta2);
        $("#respuesta3").val(datos.respuesta3);
        $("#respuesta4").val(datos.respuesta4);
        $("#respuesta5").val(datos.respuesta5);
        $("#respuesta6").val(datos.respuesta6);
        $("#respuesta7").val(datos.respuesta7);
        $("#respuesta8").val(datos.respuesta8);
    });
}

$('#txtMotivoLlamada').change(function () {
    var motivo = $('#txtMotivoLlamada').val();
    $.ajax({
        type: "GET",
        url: '../ajax/campaniasInboundC.php?action=estatus',
        data: {motivo: motivo},
        success: function (r) {
            $("#txtSubmotivoLlamada").html(r);
        }
    });
});

$('#txtIdentificacion').blur(function () {
    var identificacion = $('#txtIdentificacion').val();
    if (identificacion == '9999999999') {
        $('#txtNombreCliente').val("Sin Nombres");
    }
});

$('#txtTipoCliente').change(function () {
    var tipoCliente = $('#txtTipoCliente').val();
    if (tipoCliente == 'Tercera Persona') {
        $('#txtTerceraPersona').attr('required', true);
        $('#txtTerceraPersona').attr('readonly', false);
    } else {
        $('#txtTerceraPersona').attr('required', false);
        $('#txtTerceraPersona').attr('readonly', true);
    }
});

$('#txtCooperativa').change(function () {
    if ($('#txtCooperativa').val() != '') {
        pnlEncuestaOscus(true, false);
        $('#respuesta2').attr('required', false);
        $('#respuesta2').attr('readonly', true);
        $('#respuesta4').attr('required', false);
        $('#respuesta4').attr('readonly', true);
        $('#respuesta6').attr('required', false);
        $('#respuesta6').attr('readonly', true);
        $('#respuesta8').attr('required', false);
        $('#respuesta8').attr('readonly', true);

    } else {
        pnlEncuestaOscus(false, true);
        $('#respuesta2').attr('required', false);
        $('#respuesta2').attr('readonly', true);
        $('#respuesta4').attr('required', false);
        $('#respuesta4').attr('readonly', true);
        $('#respuesta6').attr('required', false);
        $('#respuesta6').attr('readonly', true);
        $('#respuesta8').attr('required', false);
        $('#respuesta8').attr('readonly', true);
    }
});

$('#respuesta1').change(function () {
    if ($('#respuesta1').val() == '1' || $('#respuesta1').val() == '2' || $('#respuesta1').val() == '3') {
        $('#respuesta2').attr('required', true);
        $('#respuesta2').attr('readonly', false);

    } else {
        $('#respuesta2').val("");
        $('#respuesta2').attr('required', false);
        $('#respuesta2').attr('readonly', true);
    }
});

$('#respuesta3').change(function () {
    if ($('#respuesta3').val() == '0' || $('#respuesta3').val() == '1' || $('#respuesta3').val() == '2') {
        $('#pregunta4').val("¿Por qué seleccionó ese grado de recomendación?");
        $('#respuesta4').attr('required', true);
        $('#respuesta4').attr('readonly', false);
    } else if ($('#respuesta3').val() == '3') {
        $('#pregunta4').val("¿Me puede indicar qué hizo falta para llegar al 5 y que nos recomiende? ");
        $('#respuesta4').attr('required', true);
        $('#respuesta4').attr('readonly', false);
    } else {
        $('#respuesta4').val("");
        $('#respuesta4').attr('required', false);
        $('#respuesta4').attr('readonly', true);
    }
});

$('#respuesta5').change(function () {
    if ($('#respuesta5').val() == 'Poco fácil' || $('#respuesta5').val() == 'Difícil' || $('#respuesta5').val() == 'Muy difícil') {
        $('#respuesta6').attr('required', true);
        $('#respuesta6').attr('readonly', false);

    } else {
        $('#respuesta6').val("");
        $('#respuesta6').attr('required', false);
        $('#respuesta6').attr('readonly', true);
    }
});

$('#respuesta7').change(function () {
    if ($('#respuesta7').val() == 'Hasta 1 año' || $('#respuesta7').val() == 'No quiero seguir') {
        $('#respuesta8').attr('required', true);
        $('#respuesta8').attr('readonly', false);

    } else {
        $('#respuesta8').val("");
        $('#respuesta8').attr('required', false);
        $('#respuesta8').attr('readonly', true);
    }
});

$('#txtEstadoEncuesta').change(function () {
    if ($('#txtEstadoEncuesta').val() != 'No aplica') {
        pnlEncuestaOscus(true, false);
    } else {
        pnlEncuestaOscus(false, true);
        $('#respuesta2').attr('required', false);
        $('#respuesta2').attr('readonly', true);
        $('#respuesta4').attr('required', false);
        $('#respuesta4').attr('readonly', true);
        $('#respuesta6').attr('required', false);
        $('#respuesta6').attr('readonly', true);
        $('#respuesta8').attr('required', false);
        $('#respuesta8').attr('readonly', true);
        $('#respuesta1').val("");
        $('#respuesta2').val("");
        $('#respuesta3').val("");
        $('#respuesta4').val("");
        $('#respuesta5').val("");
        $('#respuesta6').val("");
        $('#respuesta7').val("");
        $('#respuesta8').val("");
        $('#respuesta8').val("");
        $('#respuesta10').val("");
    }
});

function nuevaGestion() {
    $("#btnGuardar").prop("disabled", false);
    $("#btnNuevaGestion").prop("disabled", true);
    pnlEncuestaOscus(false, false);
    pnlTRX(true, false);
    $('#respuesta2').attr('required', false);
    $('#respuesta2').attr('readonly', true);
    $('#respuesta4').attr('required', false);
    $('#respuesta4').attr('readonly', true);
    $('#respuesta6').attr('required', false);
    $('#respuesta6').attr('readonly', true);
    $('#respuesta8').attr('required', false);
    $('#respuesta8').attr('readonly', true);
    $('#txtTerceraPersona').attr('required', false);
    $('#txtTerceraPersona').attr('readonly', true);
    $('#txtConvencional').attr('readonly', false);
    $('#txtCorreo').attr('readonly', false);
    $.ajax({
        type: "GET",
        url: '../ajax/campaniasInboundC.php?action=idCliente',
        success: function (r) {
            var id = parseInt(r) + 1;
            $("#IDC").val(id);
        }
    });
}

function eliminar(Id) { /* desactivar */
    bootbox.confirm("¿Seguro quieres eliminar este usuario?", function (result) {
        if (result) {
            $.post("../ajax/campaniasInboundC.php?action=delete", {Id: Id}, function (e) {
                bootbox.alert(e);
                //location.reload();
                $("#btnBuscar").trigger("click");
                mostrar_formulario(false);
            });
        }
    });
}

function guardar_datos(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../ajax/campaniasInboundC.php?action=save",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            if (datos == 'Error: registro no se pudo almacenar' || datos == "Error: registro no se pudo actualizar" || datos == "Error de almacenamiento") {
                bootbox.alert("Por favor, intente almacenar nuevamente!");
                $("#btnGuardar").prop("disabled", false);
            } else {
                mostrar_formulario(false);
                bootbox.alert(datos);
                $("#btnNuevaGestion").prop("disabled", false);
                $("#btnGuardar").prop("disabled", true);
                limpiar_formulario();
            }
        }
    });
}

init(); /* ejecuta la función inicial */

function obtenerFecha2(text) {
    var today = new Date(text);
    var dd = today.getDate();
    var mm = today.getMonth() + 1;
    var yyyy = today.getFullYear();

    if (dd < 10) {
        dd = '0' + dd
    }
    if (mm < 10) {
        mm = '0' + mm
    }

    today = yyyy + '-' + mm + '-' + dd
    return today;
}

//state1 = required, state2 = readonly
function pnlTRX(state1, state2) {
    $('#horaInicio').attr('required', state1);
    $('#horaInicio').attr('readonly', state2);
    $('#horaFin').attr('required', state1);
    $('#horaFin').attr('readonly', state2);
    $('#txtCooperativa').attr('required', state1);
    $('#txtCooperativa').attr('readonly', state2);
    $('#txtTipoLlamada').attr('required', state1);
    $('#txtTipoLlamada').attr('readonly', state2);
    $('#txtEstadoLlamada').attr('required', state1);
    $('#txtEstadoLlamada').attr('readonly', state2);
    $('#txtIdentificacion').attr('required', state1);
    $('#txtIdentificacion').attr('readonly', state2);
    $('#txtNombreCliente').attr('required', state1);
    $('#txtNombreCliente').attr('readonly', state2);
    $('#txtCiudadCliente').attr('required', state1);
    $('#txtCiudadCliente').attr('readonly', state2);
    $('#txtCelular').attr('required', state1);
    $('#txtCelular').attr('readonly', state2);
    $('#txtTipoCliente').attr('required', state1);
    $('#txtTipoCliente').attr('readonly', state2);
    $('#txtMotivoLlamada').attr('required', state1);
    $('#txtMotivoLlamada').attr('readonly', state2);
    $('#txtSubmotivoLlamada').attr('required', state1);
    $('#txtSubmotivoLlamada').attr('readonly', state2);
    $('#txtObservaciones').attr('required', state1);
    $('#txtObservaciones').attr('readonly', state2);
    $('#txtEstadoCliente').attr('required', state1);
    $('#txtEstadoCliente').attr('readonly', state2);
}

function pnlEncuestaOscus(state1, state2) {
    $('#txtEstadoEncuesta').attr('required', state1);
    $('#txtEstadoEncuesta').attr('readonly', state2);
    $('#txtObservacionesEncuesta').attr('required', state1);
    $('#txtObservacionesEncuesta').attr('readonly', state2);
    $('#respuesta1').attr('required', state1);
    $('#respuesta1').attr('readonly', state2);
    $('#respuesta3').attr('required', state1);
    $('#respuesta3').attr('readonly', state2);
    $('#respuesta5').attr('required', state1);
    $('#respuesta5').attr('readonly', state2);
    $('#respuesta7').attr('required', state1);
    $('#respuesta7').attr('readonly', state2);
}