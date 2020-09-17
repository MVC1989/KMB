var tabla;
function init() { /* función inicial */
    mostrar_formulario(false);
    mostrar_todos();

    $("#formulario").on("submit", function (e) {
        guardar_datos(e);
    });
}

function limpiar_formulario() { /* limpia los datos de los formularios */
    $("#Id").val("");
    $("#validar").val("");
    $("#mensaje").val("");
    $("#identificacion").val("");
    $("#Name1").val("");
    $("#Name2").val("");
    $("#Surname1").val("");
    $("#Surname2").val("");
    $("#fecha").val("");
    $("#adress").val("");
    $("#celular").val("");
    $("#telefono").val("");
    $("#correo").val("");
    $("#Password").val("");
    $("#Password2").val("");
    $("#UserGroup").val("");
    $("#country").val("");
    $("#city").val("");
    $("#gender").val("");
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
    limpiar_formulario();
    mostrar_formulario(false);
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
            url: '../ajax/userC.php?action=selectAll',
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
        "order": [[3, "asc"]]
    }).DataTable();
    tabla.on('order.dt search.dt', function () {
        tabla.column(2, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
}

function mostrar_uno(Id) {
    $.post("../ajax/userC.php?action=selectById", {Id: Id}, function (datos, estado) {
        datos = JSON.parse(datos);
        mostrar_formulario(true);
        var usu = datos.Id;
        if (usu != "") {
            $("#Id").attr('readonly', true);
        } else {
            $("#Id").attr('readonly', false);
        }
        $("#Id").val(datos.Id);
        $("#validar").val(datos.Id);
        $("#identificacion").val(datos.Identification);
        $("#Name1").val(datos.Name1);
        $("#Name2").val(datos.Name2);
        $("#Surname1").val(datos.Surname1);
        $("#Surname2").val(datos.Surname2);
        $("#fecha").val(datos.dateBirth);
        $("#adress").val(datos.Address);
        $("#celular").val(datos.ContacAddress);
        $("#telefono").val(datos.ContacAddress1);
        $("#correo").val(datos.Email);
        var pass = datos.Password;
        $.ajax({
            type: "POST",
            url: '../ajax/userC.php?action=desencriptar',
            data: {pass: pass},
            success: function (r) {
                $("#Password").val(r);
                $("#Password2").val(r);
            }
        });
        $("#UserGroup").val(datos.UserGroup);
        $("#UserGroup").selectpicker('refresh');
        $("#country").val(datos.Country);
        $("#city").val(datos.City);
        $("#gender").val(datos.Gender);
    });
}

function desactivar(Id) { /* desactivar */
    bootbox.confirm("¿Seguro quieres desactivar este usuario?", function (result) {
        if (result) {
            $.post("../ajax/userC.php?action=desactivate", {Id: Id}, function (e) {
                bootbox.alert(e);
                location.reload();
                mostrar_formulario(false);
            });
        }
    });
}

function activar(Id) { /* activar */
    bootbox.confirm("¿Seguro quieres activar este usuario?", function (result) {
        mostrar_formulario(false);
        if (result) {
            $.post("../ajax/userC.php?action=activate", {Id: Id}, function (e) {
                bootbox.alert(e);
                location.reload();
                mostrar_formulario(false);
            });
        }
    });
}

$("#btnAgregar").click(function () {
    limpiar_formulario();
    $("#Id").attr('readonly', false);
});

$("#Name1").blur(function () {
    var apellido = $("#Surname1").val();
    if ($("#validar").val() == "") {
        var txt = $("#Name1").val().substring(0, 1) + apellido + Math.round(Math.random() * 10);
        $("#Id").val(txt);
        $("#Password").val(txt);
        $("#Password2").val(txt);
        var IdUser = $("#Id").val();
        $.ajax({
            type: "POST",
            url: '../ajax/userC.php?action=validarUsuario',
            data: {IdUser: IdUser},
            success: function (r) {
                $("#mensaje").val(r);
            }
        });
    }
});

$("#Surname1").blur(function () {
    var apellido = $("#Surname1").val();
    if ($("#validar").val() == "") {
        var txt = $("#Name1").val().substring(0, 1) + apellido + Math.round(Math.random() * 10);
        $("#Id").val(txt);
        $("#Password").val(txt);
        $("#Password2").val(txt);
        var IdUser = $("#Id").val();
        $.ajax({
            type: "POST",
            url: '../ajax/userC.php?action=validarUsuario',
            data: {IdUser: IdUser},
            success: function (r) {
                $("#mensaje").val(r);
            }
        });
    }
});

$("#Id").blur(function () {
    var IdUser = $("#Id").val();
    $.ajax({
        type: "POST",
        url: '../ajax/userC.php?action=validarUsuario',
        data: {IdUser: IdUser},
        success: function (r) {
            $("#mensaje").val(r);
        }
    });
});

function guardar_datos(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    if ($("#validar").val() == "") {
        if ($("#Password").val() != $("#Password2").val()) {
            bootbox.alert("Las contraseñas no coinciden!");
        } else {
            var respuesta = $("#mensaje").val();
            if (respuesta != "SIN INFO") {
                alert("El usuario ya existe!");
            } else {
                var formData = new FormData($("#formulario")[0]);
                $.ajax({
                    url: "../ajax/userC.php?action=save",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (datos) {
                        bootbox.alert(datos);
                        mostrar_formulario(false);
                        tabla.ajax.reload();
                        limpiar_formulario();
                    }
                });
            }
        }
    } else if ($("#Password").val() != $("#Password2").val()) {
        bootbox.alert("Las contraseñas no coinciden!");
    } else {
        var formData = new FormData($("#formulario")[0]);
        $.ajax({
            url: "../ajax/userC.php?action=save",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (datos) {
                bootbox.alert(datos);
                mostrar_formulario(false);
                tabla.ajax.reload();
                limpiar_formulario();
            }
        });
    }
}

init(); /* ejecuta la función inicial */