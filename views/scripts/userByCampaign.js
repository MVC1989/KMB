var tabla;
function init() { /* función inicial */
    mostrar_todos();
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
            url: '../ajax/userCampaignC.php?action=selectAll',
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
}
$('#btnAgregar').click(function () {
    var campaign = $("#campaign option:selected").text();
    if ($("#campaign option:selected").text() != "") {
            var Id = [];
            $(':checkbox:checked').each(function (i) {
                Id[i] = $(this).val();
            });

            if (Id.length === 0) //tell you if the array is empty
            {
                alert("Usted no ha realizado ninguna selección");
            } else
            {
                $.ajax({
                    url: '../ajax/userCampaignC.php?action=insert',
                    method: 'POST',
                    data: {Id: Id, campaign: campaign},
                    success: function (datos) {
//                        alert("Datos almacenados con éxito");
                        bootbox.alert(datos);
                        tabla.ajax.reload();
                    }
                });
            }
            console.log(Id);
    } else {
        alert("Seleccione una campaña para continuar!");
    }
});

$('#btnRetirar').click(function () {
    var campaign = $("#campaign option:selected").text();
    if ($("#campaign option:selected").text() != "") {
        if (confirm("Desea retirar los usuarios seleccionados de la campaña?"))
        {
            var Id = [];
            $(':checkbox:checked').each(function (i) {
                Id[i] = $(this).val();
            });

            if (Id.length === 0) //tell you if the array is empty
            {
                alert("Usted no ha realizado ninguna selección");
            } else
            {
                $.ajax({
                    url: '../ajax/userCampaignC.php?action=delete',
                    method: 'POST',
                    data: {Id: Id, campaign: campaign},
                    success: function (datos) {
                        bootbox.alert(datos);
                        tabla.ajax.reload();
                    }
                });
            }
            console.log(Id);
        } else
        {
            return false;
        }
    } else {
        alert("Seleccione una campaña para continuar!");
    }
});

init(); /* ejecuta la función inicial */