var tabla;
function init() { /* función inicial */
    mostrar_todos();
}

function mostrar_todos() {
    var base = $("#base").val();
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
                url: '../ajax/detalleBaseC.php?action=selectAll',
                data: {base: base},
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


$('#btnMostrar').click(function () {
    var base = $("#base").val();
    if (base != "") {
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
                url: '../ajax/detalleBaseC.php?action=selectAll',
                data: {base: base},
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
            message: "Seleccione una base/importación para continuar!",
            size: 'medium'
        });
    }
});

$("#base").autocomplete({
    source: function (request, response) {
        $.ajax({
            url: "../ajax/detalleBaseC.php?action=listBases",
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
        $('#base').val(ui.item.label); // display the selected text
//                $('#selectuser_id').val(ui.item.value); // save selected id to input
        return false;
    }
});

init(); /* ejecuta la función inicial */
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */