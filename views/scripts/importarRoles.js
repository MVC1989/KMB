var tabla;
function init() { /* función inicial */
    $("#contenedor").hide();
    $("#frmcargararchivo").on("submit", function (e) {
        guardar_datos(e);
    });
    $("#btnNuevaImp").prop("disabled", true);
    mostrar_todos();
    mostrar_formulario(false);
}

function limpiar_formularioMapeo() {
    document.getElementById("frmcargararchivo").reset();
    $("#import").val("");
    $("#mapeo option:selected").prop('selected', false).find('option:first').prop('selected', true);
    $("#excel").val("");
    $("#btnGuardar").prop("disabled", false);
    $("#contenedor").hide();
    $("#btnNuevaImp").prop("disabled", true);
    $("#mensaje").html("");
}

function limpiarPnlCancel() {
    $("#importation").val("");
    $("#acciones").val("");
    $('#tblListado').hide();
    tabla.destroy(); // esta línea permite limpiar un datatable almacenada en una variable
}

function limpiar_formulario() {
    $("#IDC").val("");
    $('#NOMBRE_EMPLEADO').text("");
    $('#FECHA_INGRESO').text("");
    $('#CEDULA').text("");
    $('#DIAS').text("");
    $('#SUELDO').text("");
    $('#SUELDO_GANADO').text("");
    $('#HORAS_EXTRAS').text("");
    $('#SUBTOTAL_INGRESOS').text("");
    $('#FONDO_RESERVA').text("");
    $('#OTROS_INGRESOS').text("");
    $('#TOTAL_INGRESOS').text("");
    $('#APORTE_PERSONAL').text("");
    $('#PRESTAMOS_Q_IESS').text("");
    $('#PRESTAMOS_H_IESS').text("");
    $('#PRESTAMO_OFICINA').text("");
    $('#ATRASOS').text("");
    $('#FALTAS').text("");
    $('#TOTAL_EGRESOS').text("");
    $('#TOTAL_A_PAGAR').text("");
    $('#DECIMO_TERCER').text("");
    $('#DECIMO_CUARTO').text("");
    $('#APORTE_PATRONAL').text("");
    $('#IMPUESTO_RENTA').text("");
    $('#COMISION').text("");
    $('#TIPO_EMPLEADO').text("");
    $('#MES').text("");
}

function cancelar_formulario() { /* función para cancelar la operación */
    limpiar_formulario();
    mostrar_formulario(false);
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
            url: '../ajax/importRolesC.php?action=showAll',
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
    tabla.on('order.dt search.dt', function () {
        tabla.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }
    ).draw();
}

function mostrar_uno(Id) {
    $.post("../ajax/importRolesC.php?action=selectById", {Id: Id}, function (datos, estado) {
        datos = JSON.parse(datos);
        mostrar_formulario(true);
        $.ajax({
            type: "GET",
            url: '../ajax/funcionesGeneralesC.php?action=horaInicio',
            success: function (r) {
                $('#horaInicio').val(r);
            }
        });
        $("#IDC").val(datos.Id);
        $('#NOMBRE_EMPLEADO').text(datos.NOMBRE_EMPLEADO);
        $('#FECHA_INGRESO').text(datos.FECHA_INGRESO);
        $('#CEDULA').text(datos.CEDULA);
        $('#DIAS').text(datos.DIAS);
        $('#SUELDO').text(datos.SUELDO);
        $('#SUELDO_GANADO').text(datos.SUELDO);
        $('#HORAS_EXTRAS').text(datos.HORAS_EXTRAS);
        $('#SUBTOTAL_INGRESOS').text(datos.SUBTOTAL_INGRESOS);
        $('#FONDO_RESERVA').text(datos.FONDOS_RESERVA);
        $('#OTROS_INGRESOS').text(datos.OTROS_INGRESOS);
        $('#TOTAL_INGRESOS').text(datos.TOTAL_INGRESOS);
        $('#APORTE_PERSONAL').text(datos.APORTE_PERSONAL);
        $('#PRESTAMOS_Q_IESS').text(datos.PRESTAMOS_Q_IESS);
        $('#PRESTAMOS_H_IESS').text(datos.PRESTAMOS_H_IESS);
        $('#PRESTAMO_OFICINA').text(datos.PRESTAMO_OFICINA);
        $('#ATRASOS').text(datos.ATRASOS);
        $('#FALTAS').text(datos.FALTAS);
        $('#TOTAL_EGRESOS').text(datos.TOTAL_EGRESOS);
        $('#TOTAL_A_PAGAR').text(datos.TOTAL_A_PAGAR);
        $('#DECIMO_TERCER').text(datos.DECIMO_TERCER_SUELDO);
        $('#DECIMO_CUARTO').text(datos.DECIMO_CUARTO_SUELDO);
        $('#APORTE_PATRONAL').text(datos.APORTE_PATRONAL);
        $('#IMPUESTO_RENTA').text(datos.IMPUESTO_RENTA);
        $('#COMISION').text(datos.COMISION);
        $('#TIPO_EMPLEADO').text(datos.TIPO_EMPLEADO);
        $('#MES').text(datos.MES + ' ' + datos.ANIO);
        if(datos.ACEPTA_ROL == 'SI'){
            $("#acepta").attr("checked", true);
        }else{
            $("#acepta").attr("checked", false);
        }     
    });
}

$("#btnEnviar").click(function () {
    var base = $("#importation").val();
    var imports = $("#acciones option:selected").text();
    var acciones = $("#acciones option:selected").val();
    if (base != "" && imports != "") {
        if (imports == "Activa") {
            $.ajax({
                url: "../ajax/importRolesC.php?action=administration",
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
                            url: '../ajax/importRolesC.php?action=showAll',
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
        } else if (imports == "Cancelada") {
            $.ajax({
                url: "../ajax/importRolesC.php?action=administration",
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
                            url: '../ajax/importRolesC.php?action=showAll',
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
        $("#btnGuardar").prop("disabled", false);
        $("#contenedor").hide();
        return false;
    } else if ($("#mapeo").val() == "Roles de pago") {
        var formData = new FormData($("#frmcargararchivo")[0]);
        $.ajax({
            url: "../ajax/importRolesC.php?action=cargarRoles",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (datos) {
                //bootbox.alert(datos);
                $("#contenedor").hide();
                $("#mensaje").html(datos);
                $("#btnNuevaImp").prop("disabled", false);
                tabla.ajax.reload();
            }
        });
    }
}

init(); /* ejecuta la función inicial */