
function valores() {
    var estatus = $("#estatus option:selected").val();
//    console.log(estatus);

    if (estatus != "Cambiar Estado") {
        $.ajax({
            type: "GET",
            url: '../ajax/userStateC.php',
            data: {'estatus': estatus},
        });
    }
}
