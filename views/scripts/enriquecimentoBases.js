var tabla;
function init() { /* función inicial */

    $("#frmcargararchivo").on("submit", function (e) {
        guardar_datos(e);
    });
}

function guardar_datos(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    if (document.frmcargararchivo.excel.value == "")
    {
        bootbox.alert("Seleccione un archivo");
        document.frmcargararchivo.excel.focus();
        return false;
    } else {
        var formData = new FormData($("#frmcargararchivo")[0]);
        $.ajax({
            url: "../ajax/enriquecimientoBasesC.php?action=enriquecimientoNumeros",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (datos) {
                //bootbox.alert(datos);
                $("#mensaje").html(datos);
            }
        });
    }
}

init(); /* ejecuta la función inicial */