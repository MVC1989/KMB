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
            url: "../ajax/correosMasivosC.php?action=bancoPichinchaMO",
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
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


