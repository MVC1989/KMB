var tabla;
var i = 1;
function init() { /* función inicial */

    mostrar_formulario(false);
    mostrar_todos();

    $("#formulario").on("submit", function (e) {
        guardar_datos(e);
    });
}

function limpiar_formulario() { /* limpia los datos de los formularios */
    $("#Id").val("");
    $("#campaign").val("");
    $("#resultLevel1").val("");
    $("#resultLevel2").val("");
    $("#resultLevel3").val("");
    $("#resultCode").val("");
    $('.btn_remove').remove();
    $('.remove').remove();
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

function cancelar_formulario() { /* función para cancelar la operación */
    location.reload();
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
            url: '../ajax/resultCampaignC.php?action=selectAll',
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
    }).draw();
}

function mostrar_uno(Id) {
    $.post("../ajax/resultCampaignC.php?action=selectById", {Id: Id}, function (datos, estado) {
        datos = JSON.parse(datos);
        mostrar_formulario(true);
        $("#Id").val(datos.Id);
        $("#resultLevel1").val(datos.Level1);
        $("#resultLevel2").val(datos.Level2);
        $("#resultLevel3").val(datos.Level3);
        $("#resultCode").val(datos.Code);
        $("#campaignId").val(datos.CampaignId);
        $("#campaign").val(datos.CampaignId);
        $("#campaign").selectpicker('refresh');
    });
    $('#btnAdd').hide();
    $("#campaign").prop("disabled", true);
}

$("#campaign").change( function() {
    var txt = $("#campaign").val();
    $("#campaignId").val(txt);
});

function desactivar(Id) { /* desactivar */
    bootbox.confirm("¿Seguro quieres desactivar este usuario?", function (result) {
        if (result) {
            $.post("../ajax/resultCampaignC.php?action=desactivate", {Id: Id}, function (e) {
                mostrar_formulario(false);
                alert(e);
                tabla.ajax.reload();
            });
        }
    });
}

function activar(Id) { /* activar */
    bootbox.confirm("¿Seguro quieres activar este usuario?", function (result) {
        mostrar_formulario(false);
        if (result) {
            $.post("../ajax/resultCampaignC.php?action=activate", {Id: Id}, function (e) {
                mostrar_formulario(false);
                alert(e);
                tabla.ajax.reload();
            });
        }
    });
}

$('#btnAdd').click(function () {
    i++;
    $('#results').append('<tr class="remove" id="row' + i + '">\n\
                            <td><input type="text" class="form-control" name="level1[]" maxlength="100" placeholder="Resultado nivel 1" required/></td>\n\
                            <td><input type="text" class="form-control" name="level2[]" maxlength="100" placeholder="Resultado nivel 2"/></td>\n\
                            <td><input type="text" class="form-control" name="level3[]" maxlength="100" placeholder="Resultado nivel 3"/></td>\n\
                            <td><input type="number" class="form-control" name="code[]" placeholder="Código de gestión" required/></td>\n\
                            <td><button type="button" name="remove" id="' + i + '" class="btn btn-sm btn-danger btn_remove" title="Eliminar"><i class="fa fa-trash"></i></button></td>\n\
                          </tr>');
});

$(document).on('click', '.btn_remove', function () {
    var button_id = $(this).attr("id");
    $('#row' + button_id + '').remove();
});

$("#btnAgregar").click(function () {
    $('#btnAdd').show();
    $("#campaign").prop("disabled", false);
    $('#campaign option:selected').prop('selected', false).find('option:first').prop('selected', true);
    $("#campaign").selectpicker('refresh');
    
});

function guardar_datos(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../ajax/resultCampaignC.php?action=save",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            bootbox.alert(datos);
            mostrar_formulario(false);
            tabla.ajax.reload();
        }
    });
    limpiar_formulario();
}

init(); /* ejecuta la función inicial */