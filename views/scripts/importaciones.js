var tabla;
function init() { /* función inicial */
    $("#contenedor").hide();
    $("#frmcargararchivo").on("submit", function (e) {
        guardar_datos(e);
    });
    $("#btnNuevaImp").prop("disabled", true);
    $('#tblListado').hide();
}

function limpiar_formulario() {
    document.getElementById("frmcargararchivo").reset();
    $("#import").val("");
    $("#mapeo option:selected").prop('selected', false).find('option:first').prop('selected', true);
    $("#campaign").val("");
    $("#excel").val("");
    $("#btnGuardar").prop("disabled", false);
    $("#contenedor").hide();
    $("#btnNuevaImp").prop("disabled", true);
    $("#mensaje").html("");
}

function limpiarPnlCancel() {
    $("#campaignId").val("");
    $("#importation").val("");
    $("#acciones").val("");
    $('#tblListado').hide();
    tabla.destroy(); // esta línea permite limpiar un datatable almacenada en una variable
}

$("#btnMostrar").click(function () {
    $('#tblListado').show();
    var campaign = $("#campaignId").val();
    var base = $("#importation").val();
    if (campaign != "" && base != "") {
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
                url: '../ajax/importationC.php?action=showAll',
                data: {
                    campaign: campaign,
                    base: base
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
            "order": [[0, "asc"]]
        }).DataTable();
    } else {
        bootbox.alert({
            message: "Seleccione campaña e importación para continuar!",
            size: 'medium'
        });
    }
});

$("#campaignId").change(function () {
    var campaign = $("#campaignId").val();
    $.ajax({
        url: "../ajax/importationC.php?action=bases",
        type: 'post',
        data: {
            camp: campaign
        },
        success: function (data) {
            $("#importation").html(data);
        }
    });
});

$("#btnEnviar").click(function () {
    var campaign = $("#campaignId").val();
    var base = $("#importation").val();
    var imports = $("#acciones option:selected").text();
    var acciones = $("#acciones option:selected").val();
    if (campaign != "" && base != "" && imports != "") {
        if (imports == "Activar base") {
            $.ajax({
                url: "../ajax/importationC.php?action=administration",
                type: "post",
                data: {
                    campaign: campaign,
                    base: base,
                    acciones: acciones
                },
                success: function (datos) {
                    bootbox.alert(datos);
                    $('#tblListado').show();
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
                            url: '../ajax/importationC.php?action=showAll',
                            data: {
                                campaign: campaign,
                                base: base
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
                        "order": [[0, "asc"]]
                    }).DataTable();
                }
            });
        } else if (imports == "Cancelar base") {
            $.ajax({
                url: "../ajax/importationC.php?action=administration",
                type: "post",
                data: {
                    campaign: campaign,
                    base: base,
                    acciones: acciones
                },
                success: function (datos) {
                    alert(datos);
                    $('#tblListado').show();
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
                            url: '../ajax/importationC.php?action=showAll',
                            data: {
                                campaign: campaign,
                                base: base
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
                        "order": [[0, "asc"]]
                    }).DataTable();
                }
            });
        } else if (imports == "Seleccione opción") {
            bootbox.alert({
                message: "Seleccione una opción para continuar!",
                size: 'medium'
            });
        }
    } else {
        bootbox.alert({
            message: "Seleccione todos los campos para continuar!",
            size: 'medium'
        });
    }
});

function guardar_datos(e) {
    $("#btnGuardar").prop("disabled", true);
    $("#contenedor").show();
    e.preventDefault(); //No se activará la acción predeterminada del evento
    console.log($("#mapeo").val());
    if (document.frmcargararchivo.excel.value == "")
    {
        bootbox.alert("Seleccione un archivo");
        document.frmcargararchivo.excel.focus();
        return false;
    } else if ($("#mapeo").val() == "Banco Pichincha Cancelaciones") {
        var formData = new FormData($("#frmcargararchivo")[0]);
        $.ajax({
            url: "../ajax/importationC.php?action=bancoPichinchaCancelaciones",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (datos) {
                $("#contenedor").hide();
                $("#mensaje").html(datos);
                $("#btnNuevaImp").prop("disabled", false);
            }
        });
    } else if ($("#mapeo").val() == "Banco Pichincha Cargos Recurrentes") {
        var formData = new FormData($("#frmcargararchivo")[0]);
        $.ajax({
            url: "../ajax/importationC.php?action=bancoPichinchaCargosRecurrentes",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (datos) {
                $("#contenedor").hide();
                $("#mensaje").html(datos);
                $("#btnNuevaImp").prop("disabled", false);
            }
        });
    } else if ($("#mapeo").val() == "Banco Pichincha Incrementos") {
        var formData = new FormData($("#frmcargararchivo")[0]);
        $.ajax({
            url: "../ajax/importationC.php?action=bancoPichinchaIncrementos",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (datos) {
                $("#contenedor").hide();
                $("#mensaje").html(datos);
                $("#btnNuevaImp").prop("disabled", false);
            }
        });
    } else if ($("#mapeo").val() == "Banco Pichincha Multioferta") {
        var formData = new FormData($("#frmcargararchivo")[0]);
        $.ajax({
            url: "../ajax/importationC.php?action=bancoPichinchaMO",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (datos) {
                //bootbox.alert(datos);
                $("#contenedor").hide();
                $("#mensaje").html(datos);
                $("#btnNuevaImp").prop("disabled", false);
            }
        });
    } else if ($("#mapeo").val() == "Banco Pichincha Pasivos") {
        var formData = new FormData($("#frmcargararchivo")[0]);
        $.ajax({
            url: "../ajax/importationC.php?action=bancoPichinchaPasivos",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (datos) {
                $("#contenedor").hide();
                $("#mensaje").html(datos);
                $("#btnNuevaImp").prop("disabled", false);
            }
        });
    } else if ($("#mapeo").val() == "Banco Pichincha Variaciones") {
        var formData = new FormData($("#frmcargararchivo")[0]);
        $.ajax({
            url: "../ajax/importationC.php?action=bancoPichinchaEncuestas",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (datos) {
                //bootbox.alert(datos);
                $("#contenedor").hide();
                $("#mensaje").html(datos);
                $("#btnNuevaImp").prop("disabled", false);
            }
        });
    } else if ($("#mapeo").val() == "Banco BGR Encuestas") {
        var formData = new FormData($("#frmcargararchivo")[0]);
        $.ajax({
            url: "../ajax/importationC.php?action=bancoBGREncuestas",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (datos) {
                //bootbox.alert(datos);
                $("#contenedor").hide();
                $("#mensaje").html(datos);
                $("#btnNuevaImp").prop("disabled", false);
            }
        });
    } else if ($("#mapeo").val() == "Claro Ventas") {
        var formData = new FormData($("#frmcargararchivo")[0]);
        $.ajax({
            url: "../ajax/importationC.php?action=claroVentas",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (datos) {
                $("#contenedor").hide();
                $("#mensaje").html(datos);
                $("#btnNuevaImp").prop("disabled", false);
            }
        });
    } else if ($("#mapeo").val() == "Ecuasistencia") {
        var formData = new FormData($("#frmcargararchivo")[0]);
        $.ajax({
            url: "../ajax/importationC.php?action=ecuasistencia",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (datos) {
                //bootbox.alert(datos);
                $("#contenedor").hide();
                $("#mensaje").html(datos);
                $("#btnNuevaImp").prop("disabled", false);
            }
        });
    } else if ($("#mapeo").val() == "Ecuasistencia Encuesta") {
        var formData = new FormData($("#frmcargararchivo")[0]);
        $.ajax({
            url: "../ajax/importationC.php?action=ecuasistenciaEncuesta",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (datos) {
                //bootbox.alert(datos);
                $("#contenedor").hide();
                $("#mensaje").html(datos);
                $("#btnNuevaImp").prop("disabled", false);
            }
        });
    } else if ($("#mapeo").val() == "Banco Pichincha Encuesta") {
        var formData = new FormData($("#frmcargararchivo")[0]);
        $.ajax({
            url: "../ajax/importationC.php?action=bancoPichinchaEncuestaEgas",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (datos) {
                //bootbox.alert(datos);
                $("#contenedor").hide();
                $("#mensaje").html(datos);
                $("#btnNuevaImp").prop("disabled", false);
            }
        });
    } else if ($("#mapeo").val() == "Banco Pichincha Encuestas") {
        var formData = new FormData($("#frmcargararchivo")[0]);
        $.ajax({
            url: "../ajax/importationC.php?action=bancoPichinchaEncuestasGenericas",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (datos) {
                //bootbox.alert(datos);
                $("#contenedor").hide();
                $("#mensaje").html(datos);
                $("#btnNuevaImp").prop("disabled", false);
            }
        });
    } else if ($("#mapeo").val() == "Jardines del Valle") {
        var formData = new FormData($("#frmcargararchivo")[0]);
        $.ajax({
            url: "../ajax/importationC.php?action=jardinesDelValle",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (datos) {
                //bootbox.alert(datos);
                $("#contenedor").hide();
                $("#mensaje").html(datos);
                $("#btnNuevaImp").prop("disabled", false);
            }
        });
    } else if ($("#mapeo").val() == "Banco Pichincha Broadcast") {
        var formData = new FormData($("#frmcargararchivo")[0]);
        $.ajax({
            url: "../ajax/importationC.php?action=bancoPichinchaBroadcast",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (datos) {
                //bootbox.alert(datos);
                $("#contenedor").hide();
                $("#mensaje").html(datos);
                $("#btnNuevaImp").prop("disabled", false);
            }
        });
    } else if ($("#mapeo").val() == "Monitoreo Calidad") {
        var formData = new FormData($("#frmcargararchivo")[0]);
        $.ajax({
            url: "../ajax/importationC.php?action=MonitoreoCalidad",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (datos) {
                //bootbox.alert(datos);
                $("#contenedor").hide();
                $("#mensaje").html(datos);
                $("#btnNuevaImp").prop("disabled", false);
            }
        });
    }
}

$("#campaign").autocomplete({
    source: function (request, response) {
        $.ajax({
            url: "../ajax/importationC.php?action=listCampaigns",
            type: 'post',
            dataType: "json",
            data: {
                search: request.term
            },
            success: function (data) {
                response(data);
            }
        });
    },
    select: function (event, ui) {
        $('#campaign').val(ui.item.label); // display the selected text
//                $('#selectuser_id').val(ui.item.value); // save selected id to input
        return false;
    }
});

init(); /* ejecuta la función inicial */
