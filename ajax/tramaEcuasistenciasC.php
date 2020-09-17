<?php

session_start();
require '../models/tramaEcuasistenciasM.php';
$report = new tramaEcuasistenciasM();
date_default_timezone_set("America/Lima");
$date = date('Y-m-d H:i:s');

switch ($_GET["action"]) {
    case 'selectAll':
        $StartDate = $_GET["StartDate"] . " 00:00:00";
        $EndDate = $_GET["EndDate"] . " 23:59:59";
        $result = $report->selectAll($StartDate, $EndDate); /* llama a la función del modelo */
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = mysqli_fetch_array($result, MYSQLI_BOTH)) { /* recorre el array */
            //var_dump($registrar);
            $datos[] = array(/* llena los resultados con los datos */
                "0" => $registrar["TipoPlan"],
                "1" => $registrar["Identificacion"],
                "2" => $registrar["Nombres"],
                "3" => $registrar["Telefono1"],
                "4" => $registrar["Telefono2"],
                "5" => $registrar["Telefono3"],
                "6" => $registrar["Telefono4"],
                "7" => $registrar["Telefono5"],
                "8" => $registrar["Telefono6"],
                "9" => $registrar["Ciudad"],
                "10" => $registrar["Genero"],
                "11" => $registrar["Email"],
                "12" => $registrar["Cuenta"],
                "13" => $registrar["Tarjeta"],
                "14" => $registrar["ContactAddress"],
                "15" => $registrar["Name"],
                "16" => $registrar["FECHA"],
                "17" => $registrar["HORA"],
                "18" => $registrar["HORARIO"],
                "19" => $registrar["TURNO"],
                "20" => $registrar["ResultLevel1"],
                "21" => $registrar["ResultLevel2"],
                "22" => $registrar["ResultLevel3"],
                "23" => $registrar["MOTIVOTELEFONO"],
                "24" => $registrar["Intentos"]
            );
        }

        $resultados = array(
            "sEcho" => 1, /* informacion para la herramienta datatables */
            "iTotalRecords" => count($datos), /* envía el total de columnas a visualizar */
            "iTotalDisplayRecords" => count($datos), /* envia el total de filas a visualizar */
            "aaData" => $datos /* envía el arreglo completo que se llenó con el while */
        );
        echo json_encode($resultados);
        break;
}
?>

