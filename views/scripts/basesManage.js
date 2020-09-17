var tabla, tablaRec, tablaRec1;

function init() { /* función inicial */
    $('#tblListado').hide();
    $('#tblListadoRec').hide();
    $('#tblListadoRec1').hide();
}
/********************************ASIGNACION Y RETIRO DE BASE*********************************************/
function limpiar_formulario() { /* limpia los datos de los formularios */
    //$("#campaign").val("");
    //$("#base").val("");
    //$("#asesor").tokenfield('setTokens', [""]);
    //$("#asesor").tokenfield('destroy');
    //$("#action").val("Seleccione opción");
    //$("#Cant").val("");
}

$("#campaign").change(function () {
    var campaign = $("#campaign").val();
    $.ajax({
        url: "../ajax/baseManagementC.php?action=bases",
        type: 'post',
        data: {
            camp: campaign
        },
        success: function (data) {
            $("#base").html(data);
        }
    });
    $("#asesor").tokenfield('setTokens', [""]);
    $("#asesor").tokenfield('destroy');
    $('#asesor').tokenfield({
        autocomplete: {
            source: function (request, response) {
                $.ajax({
                    url: "../ajax/baseManagementC.php?action=asesor",
                    type: 'post',
                    dataType: "json",
                    data: {
                        search: request.term,
                        camp: campaign
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            delay: 100
        },
        showAutocompleteOnFocus: true
    });
});

$("#btnMostrar").click(function () {
    $('#tblListado').show();
    var campaign = $("#campaign").val();
    var base = $("#base").val();
    if (campaign != "" || base != "") {
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
                url: '../ajax/baseManagementC.php?action=showAll',
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
            message: "Seleccione campaña y/o importación para continuar!",
            size: 'medium'
        });
    }
});

$("#btnMostrarAssigns").click(function () {
    $('#tblListado').show();
    var campaign = $("#campaign").val();
    var base = $("#base").val();
    if (campaign != "" || base != "") {
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
                url: '../ajax/baseManagementC.php?action=showAllAssigns',
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
            message: "Seleccione campaña y/o importación para continuar!",
            size: 'medium'
        });
    }
});

$("#btnGuardar").click(function () {
    var campaign = $("#campaign").val();
    var base = $("#base").val();
    var asesores = $("#asesor").val();
    var acciones = $("#action option:selected").val();
    var cantidad = $("#Cant").val();
    var numAsesores = asesores.split(",").length;
    if (asesores == "") {
        var totalRegAsignar = cantidad;
    } else {
        var totalRegAsignar = numAsesores * cantidad;
    }
    if (acciones == "Asignar Base") {
        if (campaign != "" && base != "" && asesores != "" && cantidad != "") {
            $.ajax({
                url: "../ajax/baseManagementC.php?action=validar",
                type: "post",
                data: {
                    campaign: campaign,
                    base: base,
                    asesores: asesores,
                    acciones: acciones,
                    cantidad: cantidad,
                    numReg: totalRegAsignar
                },
                success: function (datos) {
                    if (datos == "No seguir") {
                        bootbox.alert("Ud. ha excedido la cantidad de registros disponibles para asignar!");
                    } else if (datos == "Si seguir") {
                        $.ajax({
                            url: "../ajax/baseManagementC.php?action=administration",
                            type: "post",
                            data: {
                                campaign: campaign,
                                base: base,
                                asesores: asesores,
                                acciones: acciones,
                                cantidad: cantidad
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
                                        url: '../ajax/baseManagementC.php?action=showAllAssigns',
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
                                limpiar_formulario();
                            }
                        });
                    }
                }
            });
        } else {
            bootbox.alert({
                message: "Seleccione todos los campos para continuar!",
                size: 'medium'
            });
        }
    } else if (acciones == "Retirar Base") {
        if (campaign != "" && base != "") {
            $.ajax({
                url: "../ajax/baseManagementC.php?action=validar",
                type: "post",
                data: {
                    campaign: campaign,
                    base: base,
                    asesores: asesores,
                    acciones: acciones,
                    cantidad: cantidad,
                    numReg: totalRegAsignar
                },
                success: function (datos) {
                    if (datos == "No seguir") {
                        bootbox.alert("Ud. ha excedido la cantidad de registros disponibles para retirar!");
                    } else if (datos == "Si seguir") {
                        $.ajax({
                            url: "../ajax/baseManagementC.php?action=administration",
                            type: "post",
                            data: {
                                campaign: campaign,
                                base: base,
                                asesores: asesores,
                                acciones: acciones,
                                cantidad: cantidad
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
                                        url: '../ajax/baseManagementC.php?action=showAll',
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
                        limpiar_formulario();
                    }
                }
            });
        } else {
            bootbox.alert({
                message: "Seleccione todos los campos para continuar!",
                size: 'medium'
            });
        }
    } else if (acciones == "Seleccione opción") {
        bootbox.alert({
            message: "Seleccione una opción para continuar!",
            size: 'medium'
        });
    }
});

/***********************************RECICLADO Y RETIRO DE BASES***************************************************/
function limpiar_formularioRec() { /* limpia los datos de los formularios */
    //$("#campaignRec").val("");
    //$("#baseRec").val("");
    //$("#estatus").val("");
    //$("#asesorRec").tokenfield('setTokens', [""]);
    //$("#asesorRec").tokenfield('destroy');
    //$("#accion").val("Seleccione opción");
    //$("#CantRec").val("");
}

$("#campaignRec").change(function () {
    var campaignRec = $("#campaignRec").val();
    $.ajax({
        url: "../ajax/baseManagementC.php?action=bases",
        type: 'post',
        data: {
            camp: campaignRec
        },
        success: function (data) {
            $("#baseRec").html(data);
        }
    });

    $("#asesorRec").tokenfield('setTokens', [""]);
    $("#asesorRec").tokenfield('destroy');
    $.ajax({
        url: "../ajax/baseManagementC.php?action=RecycledType",
        type: 'post',
        data: {
            camp: campaignRec
        },
        success: function (data) {
            $("#recycledType").val(data);
        }
    });

    $('#asesorRec').tokenfield({
        autocomplete: {
            source: function (request, response) {
                $.ajax({
                    url: "../ajax/baseManagementC.php?action=asesor",
                    type: 'post',
                    dataType: "json",
                    data: {
                        search: request.term,
                        camp: campaignRec
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            delay: 100
        },
        showAutocompleteOnFocus: true
    });
});

$("#btnMostrarPorReciclar").click(function () {
    var recycledType = $("#recycledType").val();
    var campaignRec = $("#campaignRec").val();
    var baseRec = $("#baseRec").val();
    var estatus = $("#estatus").val();
    if (campaignRec != "" && baseRec != "" && estatus != "") {
        $('#tblListadoRec').show();
        if (recycledType == "1") {
            if (estatus == "Regestionables") {
                tablaRec = $('#tblListadoRec').dataTable({
                    "lengthMenu": [5, 10, 25, 75, 100], //mostramos el menú de registros a revisar
                    "aProcessing": true, /* activa el procesamiento de DataTables */
                    "aServerSide": true, /* Paginación y filtrado realizado por el servidor */
                    dom: '<Bl<f>rtip>', //Definimos los elementos del control de tablaRec
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdf'
                    ],
                    "ajax": {
                        url: '../ajax/baseManagementC.php?action=regestionablesOpc1',
                        data: {
                            campaign: campaignRec,
                            base: baseRec
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
                            "copyTitle": "tablaRec Copiada",
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
            } else if (estatus == "Rellamados") {
                tablaRec = $('#tblListadoRec').dataTable({
                    "lengthMenu": [5, 10, 25, 75, 100], //mostramos el menú de registros a revisar
                    "aProcessing": true, /* activa el procesamiento de DataTables */
                    "aServerSide": true, /* Paginación y filtrado realizado por el servidor */
                    dom: '<Bl<f>rtip>', //Definimos los elementos del control de tablaRec
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdf'
                    ],
                    "ajax": {
                        url: '../ajax/baseManagementC.php?action=rellamadosOpc1',
                        data: {
                            campaign: campaignRec,
                            base: baseRec
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
                            "copyTitle": "tablaRec Copiada",
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
        } else if (recycledType == "2") {
            if (estatus == "Regestionables") {
                tablaRec = $('#tblListadoRec').dataTable({
                    "lengthMenu": [5, 10, 25, 75, 100], //mostramos el menú de registros a revisar
                    "aProcessing": true, /* activa el procesamiento de DataTables */
                    "aServerSide": true, /* Paginación y filtrado realizado por el servidor */
                    dom: '<Bl<f>rtip>', //Definimos los elementos del control de tablaRec
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdf'
                    ],
                    "ajax": {
                        url: '../ajax/baseManagementC.php?action=regestionablesOpc2',
                        data: {
                            campaign: campaignRec,
                            base: baseRec
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
                            "copyTitle": "tablaRec Copiada",
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
            } else if (estatus == "Rellamados") {
                tablaRec = $('#tblListadoRec').dataTable({
                    "lengthMenu": [5, 10, 25, 75, 100], //mostramos el menú de registros a revisar
                    "aProcessing": true, /* activa el procesamiento de DataTables */
                    "aServerSide": true, /* Paginación y filtrado realizado por el servidor */
                    dom: '<Bl<f>rtip>', //Definimos los elementos del control de tablaRec
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdf'
                    ],
                    "ajax": {
                        url: '../ajax/baseManagementC.php?action=rellamadosOpc2',
                        data: {
                            campaign: campaignRec,
                            base: baseRec
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
                            "copyTitle": "tablaRec Copiada",
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
        }

    } else {
        bootbox.alert({
            message: "Seleccione campaña, importación y estatus para continuar!",
            size: 'medium'
        });
    }
});

$("#btnMostrarRetirados").click(function () {
    var recycledType = $("#recycledType").val();
    var campaignRec = $("#campaignRec").val();
    var baseRec = $("#baseRec").val();
    var estatus = $("#estatus").val();
    if (campaignRec != "" && baseRec != "" && estatus != "") {
        $('#tblListadoRec').show();
        if (recycledType == "1") {
            if (estatus == "Regestionables") {
                tablaRec = $('#tblListadoRec').dataTable({
                    "lengthMenu": [5, 10, 25, 75, 100], //mostramos el menú de registros a revisar
                    "aProcessing": true, /* activa el procesamiento de DataTables */
                    "aServerSide": true, /* Paginación y filtrado realizado por el servidor */
                    dom: '<Bl<f>rtip>', //Definimos los elementos del control de tablaRec
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdf'
                    ],
                    "ajax": {
                        url: '../ajax/baseManagementC.php?action=disponiblesRegestionablesOpc1',
                        data: {
                            campaign: campaignRec,
                            base: baseRec
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
                            "copyTitle": "tablaRec Copiada",
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
            } else if (estatus == "Rellamados") {
                tablaRec = $('#tblListadoRec').dataTable({
                    "lengthMenu": [5, 10, 25, 75, 100], //mostramos el menú de registros a revisar
                    "aProcessing": true, /* activa el procesamiento de DataTables */
                    "aServerSide": true, /* Paginación y filtrado realizado por el servidor */
                    dom: '<Bl<f>rtip>', //Definimos los elementos del control de tablaRec
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdf'
                    ],
                    "ajax": {
                        url: '../ajax/baseManagementC.php?action=disponiblesRellamadosOpc1',
                        data: {
                            campaign: campaignRec,
                            base: baseRec
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
                            "copyTitle": "tablaRec Copiada",
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
        } else if (recycledType == "2") {
            if (estatus == "Regestionables") {
                tablaRec = $('#tblListadoRec').dataTable({
                    "lengthMenu": [5, 10, 25, 75, 100], //mostramos el menú de registros a revisar
                    "aProcessing": true, /* activa el procesamiento de DataTables */
                    "aServerSide": true, /* Paginación y filtrado realizado por el servidor */
                    dom: '<Bl<f>rtip>', //Definimos los elementos del control de tablaRec
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdf'
                    ],
                    "ajax": {
                        url: '../ajax/baseManagementC.php?action=disponiblesRegestionablesOpc2',
                        data: {
                            campaign: campaignRec,
                            base: baseRec
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
                            "copyTitle": "tablaRec Copiada",
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
            } else if (estatus == "Rellamados") {
                tablaRec = $('#tblListadoRec').dataTable({
                    "lengthMenu": [5, 10, 25, 75, 100], //mostramos el menú de registros a revisar
                    "aProcessing": true, /* activa el procesamiento de DataTables */
                    "aServerSide": true, /* Paginación y filtrado realizado por el servidor */
                    dom: '<Bl<f>rtip>', //Definimos los elementos del control de tablaRec
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdf'
                    ],
                    "ajax": {
                        url: '../ajax/baseManagementC.php?action=disponiblesRellamadosOpc2',
                        data: {
                            campaign: campaignRec,
                            base: baseRec
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
                            "copyTitle": "tablaRec Copiada",
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
        }

    } else {
        bootbox.alert({
            message: "Seleccione campaña, importación y estatus para continuar!",
            size: 'medium'
        });
    }
});

$("#btnGuardarRec").click(function () {
    var campaignRec = $("#campaignRec").val();
    var baseRec = $("#baseRec").val();
    var recycledType = $("#recycledType").val();
    var asesorRec = $("#asesorRec").val();
    var estatus = $("#estatus").val();
    var acciones = $("#accion option:selected").val();
    var CantidadRec = $("#CantRec").val();
    var numAsesoresRec = asesorRec.split(",").length;
    var totalRegAsignar = numAsesoresRec * CantidadRec;
    console.log(campaignRec, baseRec, recycledType, asesorRec, estatus);
    if (estatus != "" && acciones != "") {
        if (acciones == "Reciclar base") {
            if (campaignRec != "" && baseRec != "" && asesorRec != "" && CantidadRec != "" && estatus != "") {
                if (recycledType == "1") {
                    if (estatus == "Regestionables") {
                        $.ajax({
                            url: "../ajax/baseManagementC.php?action=validarRec",
                            type: "post",
                            data: {
                                campaign: campaignRec,
                                base: baseRec,
                                recycledType: recycledType,
                                asesores: asesorRec,
                                estatus: estatus,
                                acciones: acciones,
                                Cantidad: CantidadRec,
                                numReg: totalRegAsignar
                            },
                            success: function (datos) {
                                if (datos == "No pasa") {
                                    bootbox.alert("Aún existen registros sin gestionar, para proceder a reciclar termine el primer barrido de la base!");
                                } else if (datos == "No seguir") {
                                    bootbox.alert("Ud. ha excedido la Cantidad de registros disponibles para reciclar!");
                                } else if (datos == "Si seguir") {
                                    $.ajax({
                                        url: "../ajax/baseManagementC.php?action=administrationRec",
                                        type: "post",
                                        data: {
                                            campaign: campaignRec,
                                            base: baseRec,
                                            recycledType: recycledType,
                                            asesores: asesorRec,
                                            estatus: estatus,
                                            acciones: acciones,
                                            Cantidad: CantidadRec,
                                            numReg: totalRegAsignar
                                        },
                                        success: function (datos) {
                                            bootbox.alert(datos);
                                            $('#tblListadoRec').show();
                                            tablaRec = $('#tblListadoRec').dataTable({
                                                "lengthMenu": [5, 10, 25, 75, 100], //mostramos el menú de registros a revisar
                                                "aProcessing": true, /* activa el procesamiento de DataTables */
                                                "aServerSide": true, /* Paginación y filtrado realizado por el servidor */
                                                dom: '<Bl<f>rtip>', //Definimos los elementos del control de tablaRec
                                                buttons: [
                                                    'copyHtml5',
                                                    'excelHtml5',
                                                    'csvHtml5',
                                                    'pdf'
                                                ],
                                                "ajax": {
                                                    url: '../ajax/baseManagementC.php?action=disponiblesRegestionablesOpc1',
                                                    data: {
                                                        campaign: campaignRec,
                                                        base: baseRec
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
                                                        "copyTitle": "tablaRec Copiada",
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
                                    limpiar_formularioRec();
                                }
                            }
                        });
                    } else if (estatus == "Rellamados") {
                        $.ajax({
                            url: "../ajax/baseManagementC.php?action=validarRec",
                            type: "post",
                            data: {
                                campaign: campaignRec,
                                base: baseRec,
                                recycledType: recycledType,
                                asesores: asesorRec,
                                estatus: estatus,
                                acciones: acciones,
                                Cantidad: CantidadRec,
                                numReg: totalRegAsignar
                            },
                            success: function (datos) {
                                if (datos == "No pasa") {
                                    bootbox.alert("Aún existen registros sin gestionar, para proceder a reciclar termine el primer barrido de la base!");
                                } else if (datos == "No seguir") {
                                    bootbox.alert("Ud. ha excedido la Cantidad de registros disponibles para retirar!");
                                } else if (datos == "Si seguir") {
                                    $.ajax({
                                        url: "../ajax/baseManagementC.php?action=administrationRec",
                                        type: "post",
                                        data: {
                                            campaign: campaignRec,
                                            base: baseRec,
                                            recycledType: recycledType,
                                            asesores: asesorRec,
                                            estatus: estatus,
                                            acciones: acciones,
                                            Cantidad: CantidadRec,
                                            numReg: totalRegAsignar
                                        },
                                        success: function (datos) {
                                            bootbox.alert(datos);
                                            $('#tblListadoRec').show();
                                            tablaRec = $('#tblListadoRec').dataTable({
                                                "lengthMenu": [5, 10, 25, 75, 100], //mostramos el menú de registros a revisar
                                                "aProcessing": true, /* activa el procesamiento de DataTables */
                                                "aServerSide": true, /* Paginación y filtrado realizado por el servidor */
                                                dom: '<Bl<f>rtip>', //Definimos los elementos del control de tablaRec
                                                buttons: [
                                                    'copyHtml5',
                                                    'excelHtml5',
                                                    'csvHtml5',
                                                    'pdf'
                                                ],
                                                "ajax": {
                                                    url: '../ajax/baseManagementC.php?action=disponiblesRellamadosOpc1',
                                                    data: {
                                                        campaign: campaignRec,
                                                        base: baseRec
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
                                                        "copyTitle": "tablaRec Copiada",
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
                                    limpiar_formularioRec();
                                }
                            }
                        });
                    }
                } else if (recycledType == "2") {
                    if (estatus == "Regestionables") {
                        $.ajax({
                            url: "../ajax/baseManagementC.php?action=validarRec",
                            type: "post",
                            data: {
                                campaign: campaignRec,
                                base: baseRec,
                                recycledType: recycledType,
                                asesores: asesorRec,
                                estatus: estatus,
                                acciones: acciones,
                                Cantidad: CantidadRec,
                                numReg: totalRegAsignar
                            },
                            success: function (datos) {
                                if (datos == "No pasa") {
                                    bootbox.alert("Aún existen registros sin gestionar, para proceder a reciclar termine el primer barrido de la base!");
                                } else if (datos == "No seguir") {
                                    bootbox.alert("Ud. ha excedido la Cantidad de registros disponibles para retirar!");
                                } else if (datos == "Si seguir") {
                                    $.ajax({
                                        url: "../ajax/baseManagementC.php?action=administrationRec",
                                        type: "post",
                                        data: {
                                            campaign: campaignRec,
                                            base: baseRec,
                                            recycledType: recycledType,
                                            asesores: asesorRec,
                                            estatus: estatus,
                                            acciones: acciones,
                                            Cantidad: CantidadRec,
                                            numReg: totalRegAsignar
                                        },
                                        success: function (datos) {
                                            bootbox.alert(datos);
                                            $('#tblListadoRec').show();
                                            tablaRec = $('#tblListadoRec').dataTable({
                                                "lengthMenu": [5, 10, 25, 75, 100], //mostramos el menú de registros a revisar
                                                "aProcessing": true, /* activa el procesamiento de DataTables */
                                                "aServerSide": true, /* Paginación y filtrado realizado por el servidor */
                                                dom: '<Bl<f>rtip>', //Definimos los elementos del control de tablaRec
                                                buttons: [
                                                    'copyHtml5',
                                                    'excelHtml5',
                                                    'csvHtml5',
                                                    'pdf'
                                                ],
                                                "ajax": {
                                                    url: '../ajax/baseManagementC.php?action=disponiblesRegestionablesOpc2',
                                                    data: {
                                                        campaign: campaignRec,
                                                        base: baseRec
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
                                                        "copyTitle": "tablaRec Copiada",
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
                                    limpiar_formularioRec();
                                }
                            }
                        });
                    } else if (estatus == "Rellamados") {
                        $.ajax({
                            url: "../ajax/baseManagementC.php?action=validarRec",
                            type: "post",
                            data: {
                                campaign: campaignRec,
                                base: baseRec,
                                recycledType: recycledType,
                                asesores: asesorRec,
                                estatus: estatus,
                                acciones: acciones,
                                Cantidad: CantidadRec,
                                numReg: totalRegAsignar
                            },
                            success: function (datos) {
                                if (datos == "No pasa") {
                                    bootbox.alert("Aún existen registros sin gestionar, para proceder a reciclar termine el primer barrido de la base!");
                                } else if (datos == "No seguir") {
                                    bootbox.alert("Ud. ha excedido la Cantidad de registros disponibles para retirar!");
                                } else if (datos == "Si seguir") {
                                    $.ajax({
                                        url: "../ajax/baseManagementC.php?action=administrationRec",
                                        type: "post",
                                        data: {
                                            campaign: campaignRec,
                                            base: baseRec,
                                            recycledType: recycledType,
                                            asesores: asesorRec,
                                            estatus: estatus,
                                            acciones: acciones,
                                            Cantidad: CantidadRec,
                                            numReg: totalRegAsignar
                                        },
                                        success: function (datos) {
                                            bootbox.alert(datos);
                                            $('#tblListadoRec').show();
                                            tablaRec = $('#tblListadoRec').dataTable({
                                                "lengthMenu": [5, 10, 25, 75, 100], //mostramos el menú de registros a revisar
                                                "aProcessing": true, /* activa el procesamiento de DataTables */
                                                "aServerSide": true, /* Paginación y filtrado realizado por el servidor */
                                                dom: '<Bl<f>rtip>', //Definimos los elementos del control de tablaRec
                                                buttons: [
                                                    'copyHtml5',
                                                    'excelHtml5',
                                                    'csvHtml5',
                                                    'pdf'
                                                ],
                                                "ajax": {
                                                    url: '../ajax/baseManagementC.php?action=disponiblesRellamadosOpc2',
                                                    data: {
                                                        campaign: campaignRec,
                                                        base: baseRec
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
                                                        "copyTitle": "tablaRec Copiada",
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
                                    limpiar_formularioRec();
                                }
                            }
                        });
                    }
                }
            } else {
                bootbox.alert({
                    message: "Seleccione todos los campos para continuar!",
                    size: 'medium'
                });
            }
        } else if (acciones == "Retirar base") {
            if (campaignRec != "" && baseRec != "" && estatus != "") {
                if (recycledType == "1") {
                    if (estatus == "Regestionables") {
                        $.ajax({
                            url: "../ajax/baseManagementC.php?action=validarRec",
                            type: "post",
                            data: {
                                campaign: campaignRec,
                                base: baseRec,
                                recycledType: recycledType,
                                asesores: asesorRec,
                                estatus: estatus,
                                acciones: acciones,
                                Cantidad: CantidadRec,
                                numReg: totalRegAsignar
                            },
                            success: function (datos) {
                                if (datos == "No pasa") {
                                    bootbox.alert("Aún existen registros sin gestionar, para proceder a reciclar termine el primer barrido de la base!");
                                } else if (datos == "No seguir") {
                                    bootbox.alert("No tiene registros para retirar!");
                                } else if (datos == "Si seguir") {
                                    $.ajax({
                                        url: "../ajax/baseManagementC.php?action=administrationRec",
                                        type: "post",
                                        data: {
                                            campaign: campaignRec,
                                            base: baseRec,
                                            recycledType: recycledType,
                                            asesores: asesorRec,
                                            estatus: estatus,
                                            acciones: acciones,
                                            Cantidad: CantidadRec,
                                            numReg: totalRegAsignar
                                        },
                                        success: function (datos) {
                                            bootbox.alert(datos);
                                            $('#tblListadoRec').show();
                                            tablaRec = $('#tblListadoRec').dataTable({
                                                "lengthMenu": [5, 10, 25, 75, 100], //mostramos el menú de registros a revisar
                                                "aProcessing": true, /* activa el procesamiento de DataTables */
                                                "aServerSide": true, /* Paginación y filtrado realizado por el servidor */
                                                dom: '<Bl<f>rtip>', //Definimos los elementos del control de tablaRec
                                                buttons: [
                                                    'copyHtml5',
                                                    'excelHtml5',
                                                    'csvHtml5',
                                                    'pdf'
                                                ],
                                                "ajax": {
                                                    url: '../ajax/baseManagementC.php?action=regestionablesOpc1',
                                                    data: {
                                                        campaign: campaignRec,
                                                        base: baseRec
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
                                                        "copyTitle": "tablaRec Copiada",
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
                                    limpiar_formularioRec();
                                }
                            }
                        });
                    } else if (estatus == "Rellamados") {
                        $.ajax({
                            url: "../ajax/baseManagementC.php?action=validarRec",
                            type: "post",
                            data: {
                                campaign: campaignRec,
                                base: baseRec,
                                recycledType: recycledType,
                                asesores: asesorRec,
                                estatus: estatus,
                                acciones: acciones,
                                Cantidad: CantidadRec,
                                numReg: totalRegAsignar
                            },
                            success: function (datos) {
                                if (datos == "No pasa") {
                                    bootbox.alert("Aún existen registros sin gestionar, para proceder a reciclar termine el primer barrido de la base!");
                                } else if (datos == "No seguir") {
                                    bootbox.alert("No tiene registros para retirar!");
                                } else if (datos == "Si seguir") {
                                    $.ajax({
                                        url: "../ajax/baseManagementC.php?action=administrationRec",
                                        type: "post",
                                        data: {
                                            campaign: campaignRec,
                                            base: baseRec,
                                            recycledType: recycledType,
                                            asesores: asesorRec,
                                            estatus: estatus,
                                            acciones: acciones,
                                            Cantidad: CantidadRec,
                                            numReg: totalRegAsignar
                                        },
                                        success: function (datos) {
                                            bootbox.alert(datos);
                                            $('#tblListadoRec').show();
                                            tablaRec = $('#tblListadoRec').dataTable({
                                                "lengthMenu": [5, 10, 25, 75, 100], //mostramos el menú de registros a revisar
                                                "aProcessing": true, /* activa el procesamiento de DataTables */
                                                "aServerSide": true, /* Paginación y filtrado realizado por el servidor */
                                                dom: '<Bl<f>rtip>', //Definimos los elementos del control de tablaRec
                                                buttons: [
                                                    'copyHtml5',
                                                    'excelHtml5',
                                                    'csvHtml5',
                                                    'pdf'
                                                ],
                                                "ajax": {
                                                    url: '../ajax/baseManagementC.php?action=rellamadosOpc1',
                                                    data: {
                                                        campaign: campaignRec,
                                                        base: baseRec
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
                                                        "copyTitle": "tablaRec Copiada",
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
                                    limpiar_formularioRec();
                                }
                            }
                        });
                    }
                } else if (recycledType == "2") {
                    if (estatus == "Regestionables") {
                        $.ajax({
                            url: "../ajax/baseManagementC.php?action=validarRec",
                            type: "post",
                            data: {
                                campaign: campaignRec,
                                base: baseRec,
                                recycledType: recycledType,
                                asesores: asesorRec,
                                estatus: estatus,
                                acciones: acciones,
                                Cantidad: CantidadRec,
                                numReg: totalRegAsignar
                            },
                            success: function (datos) {
                                if (datos == "No pasa") {
                                    bootbox.alert("Aún existen registros sin gestionar, para proceder a reciclar termine el primer barrido de la base!");
                                } else if (datos == "No seguir") {
                                    bootbox.alert("No tiene registros para retirar!");
                                } else if (datos == "Si seguir") {
                                    $.ajax({
                                        url: "../ajax/baseManagementC.php?action=administrationRec",
                                        type: "post",
                                        data: {
                                            campaign: campaignRec,
                                            base: baseRec,
                                            recycledType: recycledType,
                                            asesores: asesorRec,
                                            estatus: estatus,
                                            acciones: acciones,
                                            Cantidad: CantidadRec,
                                            numReg: totalRegAsignar
                                        },
                                        success: function (datos) {
                                            bootbox.alert(datos);
                                            $('#tblListadoRec').show();
                                            tablaRec = $('#tblListadoRec').dataTable({
                                                "lengthMenu": [5, 10, 25, 75, 100], //mostramos el menú de registros a revisar
                                                "aProcessing": true, /* activa el procesamiento de DataTables */
                                                "aServerSide": true, /* Paginación y filtrado realizado por el servidor */
                                                dom: '<Bl<f>rtip>', //Definimos los elementos del control de tablaRec
                                                buttons: [
                                                    'copyHtml5',
                                                    'excelHtml5',
                                                    'csvHtml5',
                                                    'pdf'
                                                ],
                                                "ajax": {
                                                    url: '../ajax/baseManagementC.php?action=regestionablesOpc2',
                                                    data: {
                                                        campaign: campaignRec,
                                                        base: baseRec
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
                                                        "copyTitle": "tablaRec Copiada",
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
                                    limpiar_formularioRec();
                                }
                            }
                        });
                    } else if (estatus == "Rellamados") {
                        $.ajax({
                            url: "../ajax/baseManagementC.php?action=validarRec",
                            type: "post",
                            data: {
                                campaign: campaignRec,
                                base: baseRec,
                                recycledType: recycledType,
                                asesores: asesorRec,
                                estatus: estatus,
                                acciones: acciones,
                                Cantidad: CantidadRec,
                                numReg: totalRegAsignar
                            },
                            success: function (datos) {
                                if (datos == "No pasa") {
                                    bootbox.alert("Aún existen registros sin gestionar, para proceder a reciclar termine el primer barrido de la base!");
                                } else if (datos == "No seguir") {
                                    bootbox.alert("No tiene registros para retirar!");
                                } else if (datos == "Si seguir") {
                                    $.ajax({
                                        url: "../ajax/baseManagementC.php?action=administrationRec",
                                        type: "post",
                                        data: {
                                            campaign: campaignRec,
                                            base: baseRec,
                                            recycledType: recycledType,
                                            asesores: asesorRec,
                                            estatus: estatus,
                                            acciones: acciones,
                                            Cantidad: CantidadRec,
                                            numReg: totalRegAsignar
                                        },
                                        success: function (datos) {
                                            bootbox.alert(datos);
                                            $('#tblListadoRec').show();
                                            tablaRec = $('#tblListadoRec').dataTable({
                                                "lengthMenu": [5, 10, 25, 75, 100], //mostramos el menú de registros a revisar
                                                "aProcessing": true, /* activa el procesamiento de DataTables */
                                                "aServerSide": true, /* Paginación y filtrado realizado por el servidor */
                                                dom: '<Bl<f>rtip>', //Definimos los elementos del control de tablaRec
                                                buttons: [
                                                    'copyHtml5',
                                                    'excelHtml5',
                                                    'csvHtml5',
                                                    'pdf'
                                                ],
                                                "ajax": {
                                                    url: '../ajax/baseManagementC.php?action=rellamadosOpc2',
                                                    data: {
                                                        campaign: campaignRec,
                                                        base: baseRec
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
                                                        "copyTitle": "tablaRec Copiada",
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
                                    limpiar_formularioRec();
                                }
                            }
                        });
                    }
                }
            } else {
                bootbox.alert({
                    message: "Seleccione todos los campos para continuar!",
                    size: 'medium'
                });
            }
        } else if (acciones == "Seleccione opción") {
            bootbox.alert({
                message: "Seleccione una opción para continuar!",
                size: 'medium'
            });
        }
    } else {
        bootbox.alert({
            message: "Seleccione un estatus para continuar!",
            size: 'medium'
        });
    }
});

/***********************************RECICLADO UNO A UNO Y RETIRO DE BASES***************************************************/
function mostrar_todos() {
    tablaRec1 = $('#tblListadoRec1').dataTable({
        "lengthMenu": [5, 10, 25, 75, 100], //mostramos el menú de registros a revisar
        "aProcessing": true, /* activa el procesamiento de DataTables */
        "aServerSide": true, /* Paginación y filtrado realizado por el servidor */
        dom: '<Bl<f>rtip>', //Definimos los elementos del control de tablaRec1
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        "ajax": {
            url: '../ajax/baseManagementC.php?action=selectAll',
            type: "get",
            dataType: "json",
            error: function (e) {
                console.log(e.responseText);
            }
        },
        "language": {
            "lengthMenu": "Mostrar : _MENU_ registros",
            "buttons": {
                "copyTitle": "tablaRec1 Copiada",
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

$('#btnAgregar').click(function () {
    var asesorRec1 = $("#asesorRec1").val();
    if (asesorRec1 != "") {
        var Id = [];
        $(':checkbox:checked').each(function (i) {
            Id[i] = $(this).val();
        });
        if (Id.length === 0) //tell you if the array is empty
        {
            bootbox.alert({
                message: "Usted no ha realizado ninguna selección!",
                size: 'medium'
            });
        } else
        {
            $.ajax({
                url: '../ajax/baseManagementC.php?action=asignar',
                method: 'POST',
                data: {Id: Id, asesor: asesorRec1},
                success: function (datos) {
                    bootbox.alert(datos);
                    tablaRec1.ajax.reload();
                    $("#asesorRec1").tokenfield('setTokens', [""]);
                    $("#asesorRec1").tokenfield('destroy');
                    $("#campaignRec1").val("");
                }
            });
        }
    } else {
        bootbox.alert({
            message: "Seleccione un asesor para continuar!",
            size: 'medium'
        });
    }
});

$('#btnRetirar').click(function () {
    var asesorRec1 = $("#asesorRec1").val();
    if (confirm("Desea retirar los registros seleccionados?"))
    {
        var Id = [];
        $(':checkbox:checked').each(function (i) {
            Id[i] = $(this).val();
        });
        if (Id.length === 0) //tell you if the array is empty
        {
            bootbox.alert({
                message: "Usted no ha realizado ninguna selección!",
                size: 'medium'
            });
        } else
        {
            $.ajax({
                url: '../ajax/baseManagementC.php?action=retirar',
                method: 'POST',
                data: {Id: Id, asesor: asesorRec1},
                success: function (datos) {
                    bootbox.alert(datos);
                    tablaRec1.ajax.reload();
                    $("#campaignRec1").val("");
                    $("#asesorRec1").tokenfield('setTokens', [""]);
                    $("#asesorRec1").tokenfield('destroy');
                }
            });
        }
    }
});

$("#campaignRec1").change(function () {
    $("#asesorRec1").tokenfield('setTokens', [""]);
    $("#asesorRec1").tokenfield('destroy');
    var campaignRec1 = $("#campaignRec1").val();
    $('#asesorRec1').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "../ajax/baseManagementC.php?action=asesor",
                type: 'post',
                dataType: "json",
                data: {
                    search: request.term,
                    camp: campaignRec1
                },
                success: function (data) {
                    response(data);
                }
            });
        }
    });

    $('#tblListadoRec1').show();
    if (campaignRec1 != "") {
        tablaRec1 = $('#tblListadoRec1').dataTable({
            "lengthMenu": [5, 10, 25, 75, 100], //mostramos el menú de registros a revisar
            "aProcessing": true, /* activa el procesamiento de DataTables */
            "aServerSide": true, /* Paginación y filtrado realizado por el servidor */
            dom: '<Bl<f>rtip>', //Definimos los elementos del control de tablaRec1
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdf'
            ],
            "ajax": {
                url: '../ajax/baseManagementC.php?action=selectAll',
                data: {
                    campaign: campaignRec1
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
                    "copyTitle": "tablaRec1 Copiada",
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
            message: "Seleccione campaña para proceder a mostrar información!",
            size: 'medium'
        });
    }

});

init(); /* ejecuta la función inicial */