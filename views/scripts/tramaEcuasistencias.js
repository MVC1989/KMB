var tabla;
function init() { /* función inicial */
    $('#tblListado').hide();
}

function mostrar_todos() {

}

$('#btnMostrar').click(function () {
    //mostrar_todos();
    var StartDate = $('#StartDate').val();
    var EndDate = $('#EndDate').val();
    $('#tblListado').show();

    // $("#cuerpo").html(r);
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
            url: '../ajax/tramaEcuasistenciasC.php?action=selectAll',
            data: {StartDate: StartDate, EndDate: EndDate},
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

});

init(); /* ejecuta la función inicial */