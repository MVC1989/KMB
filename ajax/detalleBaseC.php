<?php

session_start();

require '../models/detalleBaseM.php';
$detalle = new detalleBaseM();
date_default_timezone_set("America/Lima");

switch ($_GET["action"]) {
    case 'selectAll':
        $base = isset($_POST['base']) ? LimpiarCadena($_POST["base"]) : "";
        $respuesta = $detalle->selectAll($base); /* llama a la función del modelo */
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            $datos[] = array(/* llena los resultados con los datos */
                "0" => $registrar->Cantidad, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                "1" => $registrar->Codigo,
                "2" => $registrar->level1,
                "3" => $registrar->level2,
                "4" => $registrar->level3,
                "5" => $registrar->Cantidad,
                "6" => $registrar->Import,
                "7" => $registrar->Campaign
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

    case 'selectAllAsesor':
        $asesor = isset($_POST['asesor']) ? LimpiarCadena($_POST["asesor"]) : "";
        $respuesta = $detalle->selectAllAsesor($asesor); /* llama a la función del modelo */
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            $datos[] = array(/* llena los resultados con los datos */
                "0" => $registrar->Cantidad, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                "1" => $registrar->Codigo,
                "2" => $registrar->level1,
                "3" => $registrar->level2,
                "4" => $registrar->level3,
                "5" => $registrar->Cantidad,
                "6" => $registrar->lastagent,
                "7" => $registrar->campaign,
                "8" => $registrar->lastupdate
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

    case 'listBases':
        $base = isset($_POST['search']) ? LimpiarCadena($_POST["search"]) : "";
        $result = ejecutarConsulta("select distinct(lastupdate) 'lastupdate' from contactimportcontact where lastupdate like '%$base%'");
        while ($row = mysqli_fetch_array($result)) {
            $response[] = array("value" => $row['lastupdate'], "label" => $row['lastupdate']);
        }
        echo json_encode($response);
        break;

    case 'asesor':
        $asesor = isset($_POST['asesor']) ? LimpiarCadena($_POST["asesor"]) : "";
        $result = ejecutarConsulta("select Id from user where Id like '%$asesor%' and usergroup >= 3");
        while ($row = mysqli_fetch_array($result)) {
            $response[] = array("value" => $row['Id'], "label" => $row['Id']);
        }
        echo json_encode($response);
        break;
}
?>