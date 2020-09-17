var tabla;
function init() { /* función inicial */
    $("#formulario").on("submit", function (e) {
        guardar_datos(e);
    });
    pnlTRX(false, true);
    pnlEncuestaOscus(false, true);
    $("#pnlEncuestaOscus").hide();
    $('#encuestaOscus').hide();
    $('#pregunta2').hide();
    $('#respuesta2').hide();
    $('#pregunta4').hide();
    $('#respuesta4').hide();
    $('#pregunta6').hide();
    $('#respuesta6').hide();
    $('#pregunta8').hide();
    $('#respuesta8').hide();
    $('#txtConvencional').attr('readonly', true);
    $('#txtCorreo').attr('readonly', true);
    $('#txtTerceraPersona').attr('readonly', true);
    $("#btnGuardar").prop("disabled", true);
    $('#horaFin').attr('required', false);
    $('#horaFin').attr('readonly', true);
    $("#chkHoraFin").prop("checked", false);
}

function limpiar_formulario() {
    document.getElementById("formulario").reset();
    pnlTRX(false, true);
    pnlEncuestaOscus(false, true);
    $("#pnlEncuestaOscus").hide();
    $('#encuestaOscus').hide();
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
    $("#chkHoraFin").prop("checked", false);
    $('#horaFin').attr('required', false);
    $('#horaFin').attr('readonly', true);
}

function cancelar_formulario() {
    $("#btnNuevaGestion").prop("disabled", false);
    $("#btnGuardar").prop("disabled", true);
    limpiar_formulario();
}

function nuevaGestion() {
    $("#btnGuardar").prop("disabled", false);
    $("#btnNuevaGestion").prop("disabled", true);
    document.getElementById("formulario").reset();
    pnlTRX(true, false);
    pnlEncuestaOscus(false, true);
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
        url: '../ajax/campaniasInboundC.php?action=fechaInicio',
        success: function (r) {
            $("#horaInicio").val(r);
            $("#mostrarHora").html(r);
        }
    });
    $.ajax({
        type: "GET",
        url: '../ajax/campaniasInboundC.php?action=idCliente',
        success: function (r) {
            var id = parseInt(r) + 1;
            $("#IDC").val(id);
        }
    });
}

$('#chkHoraFin').change(function () {
    if (!$(this).is(":checked")) {
        $('#horaFin').attr('readonly', true);
        $('#horaFin').attr('required', false);
    } else {
        $('#horaFin').attr('readonly', false);
        $('#horaFin').attr('required', true);
    }
});

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
        $('#encuestaOscus').show();
        $('#pnlEncuestaOscus').show();
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
        $('#encuestaOscus').hide();
        $('#pnlEncuestaOscus').hide();
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
        $('#pregunta2').show();
        $('#respuesta2').show();
        $('#respuesta2').attr('required', true);
        $('#respuesta2').attr('readonly', false);

    } else {
        $('#pregunta2').hide();
        $('#respuesta2').hide();
        $('#respuesta2').attr('required', false);
        $('#respuesta2').attr('readonly', true);
    }
});

$('#respuesta3').change(function () {
    if ($('#respuesta3').val() == '0' || $('#respuesta3').val() == '1' || $('#respuesta3').val() == '2') {
        $('#pregunta4').val("¿Por qué seleccionó ese grado de recomendación?");
        $('#pregunta4').show();
        $('#respuesta4').show();
        $('#respuesta4').attr('required', true);
        $('#respuesta4').attr('readonly', false);
    } else if ($('#respuesta3').val() == '3') {
        $('#pregunta4').val("¿Me puede indicar qué hizo falta para llegar al 5 y que nos recomiende? ");
        $('#pregunta4').show();
        $('#respuesta4').show();
        $('#respuesta4').attr('required', true);
        $('#respuesta4').attr('readonly', false);
    } else {
        $('#pregunta4').val("");
        $('#pregunta4').hide();
        $('#respuesta4').hide();
        $('#respuesta4').attr('required', false);
        $('#respuesta4').attr('readonly', true);
    }
});

$('#respuesta5').change(function () {
    if ($('#respuesta5').val() == 'Poco fácil' || $('#respuesta5').val() == 'Difícil' || $('#respuesta5').val() == 'Muy difícil') {
        $('#pregunta6').show();
        $('#respuesta6').show();
        $('#respuesta6').attr('required', true);
        $('#respuesta6').attr('readonly', false);

    } else {
        $('#pregunta6').hide();
        $('#respuesta6').hide();
        $('#respuesta6').attr('required', false);
        $('#respuesta6').attr('readonly', true);
    }
});

$('#respuesta7').change(function () {
    if ($('#respuesta7').val() == 'Hasta 1 año' || $('#respuesta7').val() == 'No quiero seguir') {
        $('#pregunta8').show();
        $('#respuesta8').show();
        $('#respuesta8').attr('required', true);
        $('#respuesta8').attr('readonly', false);

    } else {
        $('#pregunta8').hide();
        $('#respuesta8').hide();
        $('#respuesta8').attr('required', false);
        $('#respuesta8').attr('readonly', true);
    }
});

$('#txtEstadoEncuesta').change(function () {
    if ($('#txtEstadoEncuesta').val() != 'No aplica') {
        $('#pnlEncuestaOscus').show();
        pnlEncuestaOscus(true, false);

    } else {
        $('#pnlEncuestaOscus').hide();
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
                bootbox.alert(datos);
                $("#btnNuevaGestion").prop("disabled", false);
                $("#btnGuardar").prop("disabled", true);
                limpiar_formulario();
            }
        }
    });
}

init(); /* ejecuta la función inicial */

//state1 = required, state2 = readonly
function pnlTRX(state1, state2) {
    $('#chkHoraFin').attr('disabled', state2);
    $('#horaInicio').attr('required', state1);
    $('#horaInicio').attr('readonly', state2);
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
    $('#respuesta1').attr('required', state1);
    $('#respuesta1').attr('readonly', state2);
    $('#pregunta2').hide();
    $('#respuesta2').hide();
    $('#respuesta3').attr('required', state1);
    $('#respuesta3').attr('readonly', state2);
    $('#pregunta4').hide();
    $('#respuesta4').hide();
    $('#respuesta5').attr('required', state1);
    $('#respuesta5').attr('readonly', state2);
    $('#pregunta6').hide();
    $('#respuesta6').hide();
    $('#respuesta7').attr('required', state1);
    $('#respuesta7').attr('readonly', state2);
    $('#pregunta8').hide();
    $('#respuesta8').hide();
}