<?php

session_start();

require '../models/bpEncuestaFEgasM.php';
$camp = new bpEncuestaFEgasM();
date_default_timezone_set("America/Lima");

$Id = isset($_POST["Id"]) ? LimpiarCadena12($_POST["Id"]) : ""; //Dato estraido de la funcion mostrar_uno js

$IdCliente = isset($_POST["IDC"]) ? LimpiarCadena12($_POST["IDC"]) : "";
$Num = isset($_POST["fonos"]) ? LimpiarCadena12($_POST["fonos"]) : "";
$Agent = $_SESSION['usu'];
$Estado = isset($_POST["estatusTel"]) ? LimpiarCadena12($_POST["estatusTel"]) : "";
$Tmstmp = date('Y-m-d H:i:s');
$time = isset($_POST["horaInicio"]) ? LimpiarCadena12($_POST["horaInicio"]) : "";
$intentos = isset($_POST["intentos"]) ? LimpiarCadena12($_POST["intentos"]) : "";
$level1 = isset($_POST["level1"]) ? LimpiarCadena12($_POST["level1"]) : "";
$level2 = isset($_POST["level2"]) ? LimpiarCadena12($_POST["level2"]) : "";
$level3 = isset($_POST["level3"]) ? LimpiarCadena2($_POST["level3"]) : "";
$campaign = isset($_POST["CAMPANIA"]) ? LimpiarCadena12($_POST["CAMPANIA"]) : "";
$mangementCode = isset($_POST["code"]) ? LimpiarCadena12($_POST["code"]) : "";
$queryT = ejecutarConsulta("SELECT NumeroMarcado FROM contactimportphone WHERE ContactId = '$IdCliente' order by FechaHoraFin desc limit 1");
$rowT = mysqli_fetch_array($queryT, MYSQLI_BOTH);
$contactAddress = $rowT["NumeroMarcado"];
if ($level1 == 'DB' && $level2 = 'DADO DE BAJA POR NO VENTA'){
    $interactionId = isset($_POST["interactionIdOld"]) ? LimpiarCadena5($_POST["interactionIdOld"]) : "";
} else {
    $interactionId = isset($_POST["interactionId"]) ? LimpiarCadena5($_POST["interactionId"]) : "";
}
$contactname = isset($_POST["NOMBRE_CLIENTE"]) ? LimpiarCadena10($_POST["NOMBRE_CLIENTE"]) : "";
$FechaAgendamiento = isset($_POST["agenda"]) ? LimpiarCadena12($_POST["agenda"]) : "";
$TelefonoAd = isset($_POST["fonoAd"]) ? LimpiarCadena12($_POST["fonoAd"]) : "";
$Observaciones = isset($_POST["obs"]) ? LimpiarCadena12($_POST["obs"]) : "";

$pregunta1 = isset($_POST["pregunta1"]) ? LimpiarCadena12($_POST["pregunta1"]) : "";
$respuesta1 = isset($_POST["respuesta1"]) ? LimpiarCadena12($_POST["respuesta1"]) : "";
$pregunta2 = isset($_POST["pregunta2"]) ? LimpiarCadena12($_POST["pregunta2"]) : "";
//if (isset($_POST["chk_ENC2"]) == 'chk_ENC2') {
$respuesta2 = isset($_POST["respuesta2"]) ? LimpiarCadena12($_POST["respuesta2"]) : "";
//} else {
//    $respuesta2 = "";
//}
$pregunta3 = isset($_POST["pregunta3"]) ? LimpiarCadena12($_POST["pregunta3"]) : "";
//if (isset($_POST["chk_ENC3"]) == 'chk_ENC3') {
$respuesta3 = isset($_POST["respuesta3"]) ? LimpiarCadena12($_POST["respuesta3"]) : "";
//} else {
//    $respuesta3 = "";
//}
$pregunta4 = isset($_POST["pregunta4"]) ? LimpiarCadena12($_POST["pregunta4"]) : "";
//if (isset($_POST["chk_ENC4"]) == 'chk_ENC4') {
$respuesta4 = isset($_POST["respuesta4"]) ? LimpiarCadena12($_POST["respuesta4"]) : "";
//} else {
//    $respuesta4 = "";
//}
$pregunta5 = isset($_POST["pregunta5"]) ? LimpiarCadena12($_POST["pregunta5"]) : "";
//if (isset($_POST["chk_ENC5"]) == 'chk_ENC5') {
$respuesta5 = isset($_POST["respuesta5"]) ? LimpiarCadena12($_POST["respuesta5"]) : "";
//} else {
//    $respuesta5 = "";
//}
$pregunta6 = isset($_POST["pregunta6"]) ? LimpiarCadena12($_POST["pregunta6"]) : "";
//if (isset($_POST["chk_ENC6"]) == 'chk_ENC6') {
$respuesta6 = isset($_POST["respuesta6"]) ? LimpiarCadena12($_POST["respuesta6"]) : "";
//} else {
//    $respuesta6 = "";
//}
$pregunta7 = isset($_POST["pregunta7"]) ? LimpiarCadena12($_POST["pregunta7"]) : "";
$respuesta7 = isset($_POST["respuesta7"]) ? LimpiarCadena12($_POST["respuesta7"]) : "";
$pregunta8 = isset($_POST["pregunta8"]) ? LimpiarCadena12($_POST["pregunta8"]) : "";
$respuesta8 = isset($_POST["respuesta8"]) ? LimpiarCadena12($_POST["respuesta8"]) : "";
$pregunta9 = isset($_POST["pregunta9"]) ? LimpiarCadena12($_POST["pregunta9"]) : "";
$respuesta9 = isset($_POST["respuesta9"]) ? LimpiarCadena12($_POST["respuesta9"]) : "";
$pregunta10 = isset($_POST["pregunta10"]) ? LimpiarCadena12($_POST["pregunta10"]) : "";
$respuesta10 = isset($_POST["respuesta10"]) ? LimpiarCadena12($_POST["respuesta10"]) : "";
$pregunta11 = isset($_POST["pregunta11"]) ? LimpiarCadena12($_POST["pregunta11"]) : "";
$respuesta11 = isset($_POST["respuesta11"]) ? LimpiarCadena12($_POST["respuesta11"]) : "";
$pregunta12 = isset($_POST["pregunta12"]) ? LimpiarCadena12($_POST["pregunta12"]) : "";
$respuesta12 = isset($_POST["respuesta12"]) ? LimpiarCadena12($_POST["respuesta12"]) : "";
$pregunta13 = isset($_POST["pregunta13"]) ? LimpiarCadena12($_POST["pregunta13"]) : "";
$respuesta13 = isset($_POST["respuesta13"]) ? LimpiarCadena12($_POST["respuesta13"]) : "";
$pregunta14 = isset($_POST["pregunta14"]) ? LimpiarCadena12($_POST["pregunta14"]) : "";
$respuesta14 = isset($_POST["respuesta14"]) ? LimpiarCadena12($_POST["respuesta14"]) : "";
$pregunta15 = isset($_POST["pregunta15"]) ? LimpiarCadena12($_POST["pregunta15"]) : "";
$respuesta15 = isset($_POST["respuesta15"]) ? LimpiarCadena12($_POST["respuesta15"]) : "";
$pregunta16 = isset($_POST["pregunta16"]) ? LimpiarCadena12($_POST["pregunta16"]) : "";
$respuesta16 = isset($_POST["respuesta16"]) ? LimpiarCadena12($_POST["respuesta16"]) : "";
$pregunta17 = isset($_POST["pregunta17"]) ? LimpiarCadena12($_POST["pregunta17"]) : "";
$respuesta17 = isset($_POST["respuesta17"]) ? LimpiarCadena12($_POST["respuesta17"]) : "";
$pregunta18 = isset($_POST["pregunta18"]) ? LimpiarCadena12($_POST["pregunta18"]) : "";
$respuesta18 = isset($_POST["respuesta18"]) ? LimpiarCadena12($_POST["respuesta18"]) : "";
$pregunta19 = isset($_POST["pregunta19"]) ? LimpiarCadena12($_POST["pregunta19"]) : "";
$respuesta19 = isset($_POST["respuesta19"]) ? LimpiarCadena12($_POST["respuesta19"]) : "";
$pregunta20 = isset($_POST["pregunta20"]) ? LimpiarCadena12($_POST["pregunta20"]) : "";
$respuesta20 = isset($_POST["respuesta20"]) ? LimpiarCadena12($_POST["respuesta20"]) : "";
$pregunta21 = isset($_POST["pregunta21"]) ? LimpiarCadena12($_POST["pregunta21"]) : "";
$respuesta21 = isset($_POST["respuesta21"]) ? LimpiarCadena12($_POST["respuesta21"]) : "";
$pregunta22 = isset($_POST["pregunta22"]) ? LimpiarCadena12($_POST["pregunta22"]) : "";
$respuesta22 = isset($_POST["respuesta22"]) ? LimpiarCadena12($_POST["respuesta22"]) : "";
$pregunta23 = isset($_POST["pregunta23"]) ? LimpiarCadena12($_POST["pregunta23"]) : "";
$respuesta23 = isset($_POST["respuesta23"]) ? LimpiarCadena12($_POST["respuesta23"]) : "";
$pregunta24 = isset($_POST["pregunta24"]) ? LimpiarCadena12($_POST["pregunta24"]) : "";
$respuesta24 = isset($_POST["respuesta24"]) ? LimpiarCadena12($_POST["respuesta24"]) : "";
$pregunta25 = isset($_POST["pregunta25"]) ? LimpiarCadena12($_POST["pregunta25"]) : "";
$respuesta25 = isset($_POST["respuesta25"]) ? LimpiarCadena12($_POST["respuesta25"]) : "";
$pregunta26 = isset($_POST["pregunta26"]) ? LimpiarCadena12($_POST["pregunta26"]) : "";
$respuesta26 = isset($_POST["respuesta26"]) ? LimpiarCadena12($_POST["respuesta26"]) : "";
$pregunta27 = isset($_POST["pregunta27"]) ? LimpiarCadena12($_POST["pregunta27"]) : "";
$respuesta27 = isset($_POST["respuesta27"]) ? LimpiarCadena12($_POST["respuesta27"]) : "";
$pregunta28 = isset($_POST["pregunta28"]) ? LimpiarCadena12($_POST["pregunta28"]) : "";
$respuesta28 = isset($_POST["respuesta28"]) ? LimpiarCadena12($_POST["respuesta28"]) : "";
$pregunta29 = isset($_POST["pregunta29"]) ? LimpiarCadena12($_POST["pregunta29"]) : "";
$respuesta29 = isset($_POST["respuesta29"]) ? LimpiarCadena12($_POST["respuesta29"]) : "";
$pregunta30 = isset($_POST["pregunta30"]) ? LimpiarCadena12($_POST["pregunta30"]) : "";
$respuesta30 = isset($_POST["respuesta30"]) ? LimpiarCadena12($_POST["respuesta30"]) : "";

switch ($_GET["action"]) {
    case 'fechaInicio':
        date_default_timezone_set("America/Lima");
        echo(date('Y-m-d H:i:s'));
        break;

    case 'selectAll':
        $respuesta = $camp->selectAll_4(); /* llama a la función del modelo */
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            $datos[] = array(/* llena los resultados con los datos */
                "0" => $registrar->ID, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                "1" => $registrar->CampaignId,
                "2" => $registrar->ImportId,
                "3" => $registrar->Agent,
                "4" => $registrar->IDENTIFICACION,
                "5" => $registrar->NOMBRE_CLIENTE,
                "6" => $registrar->EDAD,
                "7" => $registrar->REGION,
                "8" => $registrar->LOCALIDAD,
                "9" => $registrar->ResultLevel2,
                "10" => '<a href="#" style="color: #3C8DBC;" onclick="mostrar_uno(\'' . $registrar->ID . '\')">Gestionar</a>',
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

    case 'selectAllRec':
        $respuesta = $camp->selectAllRec_4(); /* llama a la función del modelo */
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            if ($registrar->managementresultcode == 18 || $registrar->managementresultcode == 20) {
                $datos[] = array(/* llena los resultados con los datos */
                    "0" => '<p style="color: red">' . $registrar->ID . '</p>', /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                    "1" => '<p style="color: red">' . $registrar->CampaignId . '</p>',
                    "2" => '<p style="color: red">' . $registrar->ImportId . '</p>',
                    "3" => '<p style="color: red">' . $registrar->Agent . '</p>',
                    "4" => '<p style="color: red">' . $registrar->IDENTIFICACION . '</p>',
                    "5" => '<p style="color: red">' . $registrar->NOMBRE_CLIENTE . '</p>',
                    "6" => '<p style="color: red">' . $registrar->EDAD . '</p>',
                    "7" => '<p style="color: red">' . $registrar->REGION . '</p>',
                    "8" => '<p style="color: red">' . $registrar->LOCALIDAD . '</p>',
                    "9" => '<p style="color: red">' . $registrar->ResultLevel2 . '</p>',
                    "10" => '<a href="#" style="color: #3C8DBC;" onclick="mostrar_uno(\'' . $registrar->ID . '\')">Gestionar</a>',
                );
            } else {
                $datos[] = array(/* llena los resultados con los datos */
                    "0" => $registrar->ID, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                    "1" => $registrar->CampaignId,
                    "2" => $registrar->ImportId,
                    "3" => $registrar->Agent,
                    "4" => $registrar->IDENTIFICACION,
                    "5" => $registrar->NOMBRE_CLIENTE,
                    "6" => $registrar->EDAD,
                    "7" => $registrar->REGION,
                    "8" => $registrar->LOCALIDAD,
                    "9" => $registrar->ResultLevel2,
                    "10" => '<a href="#" style="color: #3C8DBC;" onclick="mostrar_uno(\'' . $registrar->ID . '\')">Gestionar</a>',
                );
            }
        }

        $resultados = array(
            "sEcho" => 1, /* informacion para la herramienta datatables */
            "iTotalRecords" => count($datos), /* envía el total de columnas a visualizar */
            "iTotalDisplayRecords" => count($datos), /* envia el total de filas a visualizar */
            "aaData" => $datos /* envía el arreglo completo que se llenó con el while */
        );
        echo json_encode($resultados);
        break;

    case 'selectById':
        $respuesta = $camp->selectById($Id);
        echo json_encode($respuesta); /* envia los datos a mostrar mediante json */
        break;

    case 'selectByIdRec':
        $respuesta = $camp->selectByIdRec($Id);
        echo json_encode($respuesta); /* envia los datos a mostrar mediante json */
        break;

    case 'estatus':
        $idcamp = $_GET['camp'];
        $result = ejecutarConsulta("SELECT distinct(level1) 'level1' "
                . "FROM campaignresultmanagement where campaignid = '$idcamp' ORDER BY Level1");
        echo '<option></option>';
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            echo '<option value="' . $row["level1"] . '">' . $row["level1"] . '</option>';
        }
        break;

    case 'level2':
        $level1 = $_GET['level1'];
        $idcamp = $_GET['camp'];
        $result = ejecutarConsulta("SELECT distinct(level2) 'level2' "
                . "FROM campaignresultmanagement where level1 = '$level1' "
                . "and campaignid = '$idcamp' ORDER BY Code");
        echo '<option></option>';
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            echo '<option value="' . $row["level2"] . '">' . $row["level2"] . '</option>';
        }
        break;

    case 'level3':
        $level2 = $_GET['level2'];
        $idcamp = $_GET['camp'];
        $result = ejecutarConsulta("SELECT distinct(level3) 'level3' "
                . "FROM campaignresultmanagement where level2 = '$level2' "
                . "and campaignid = '$idcamp' ORDER BY Code");
        echo '<option></option>';
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            echo '<option value="' . $row["level3"] . '">' . $row["level3"] . '</option>';
        }
        break;

    case 'code':
        $idcamp = $_GET['camp'];
        $level1 = $_GET["level1"];
        $level2 = $_GET["level2"];
        $findCode = ejecutarConsulta("SELECT Code FROM campaignresultmanagement where "
                . "CampaignId = '$idcamp' and Level1 = '$level1' and level2 = '$level2' "
                . "and (level3 = ''or level3 is null)");
        $row = mysqli_fetch_array($findCode, MYSQLI_BOTH);
        $Code = $row["Code"];
        echo($Code);
        break;

    case 'code1':
        $idcamp = $_GET['camp'];
        $level1 = $_GET["level1"];
        $level2 = $_GET["level2"];
        $level3 = $_GET["level3"];
        $findCode = ejecutarConsulta("SELECT Code FROM campaignresultmanagement where "
                . "CampaignId = '$idcamp' and Level1 = '$level1' and level2 = '$level2' "
                . "and level3 = '$level3'");
        $row = mysqli_fetch_array($findCode, MYSQLI_BOTH);
        $Code = $row["Code"];
        echo($Code);
        break;

    case 'telefonos':
        $idC = $_GET['idC'];
        $phonesById = ejecutarConsulta2("select contactid from gestionfinal where contactid = '$idC'");
        $valid = mysqli_fetch_array($phonesById, MYSQLI_BOTH);
        if ($valid["contactid"] == "") {
            $result = ejecutarConsulta("SELECT NumeroMarcado "
                    . "FROM contactimportphone where contactid = '$idC'");
            echo '<option></option>';
            while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                echo '<option value="' . $row["NumeroMarcado"] . '">' . $row["NumeroMarcado"] . '</option>';
            }
        } else {
            $result1 = ejecutarConsulta("SELECT NumeroMarcado "
                    . "FROM contactimportphone where contactid = '$idC'");
            echo '<option></option>';
            while ($row = mysqli_fetch_array($result1, MYSQLI_BOTH)) {
                echo '<option value="' . $row["NumeroMarcado"] . '">' . $row["NumeroMarcado"] . '</option>';
            }
        }
        break;

    case 'updatePhones':
        $IdC = isset($_POST["IDC"]) ? LimpiarCadena3($_POST["IDC"]) : "";
        $respuesta = $camp->updateTelf($IdC, $Num, $Agent, $Estado, $Tmstmp);
        echo $respuesta ? "Teléfono gestionado con éxito" : "Error: no se pudo almacenar la información!";
        break;

    case 'validePhone';
        $IdClient = $_GET["IdClient"];
        $estadoTelf = ejecutarConsulta("SELECT distinct(estado)'estado' FROM contactimportphone WHERE contactid = '$IdClient'");
        $data = mysqli_fetch_array($estadoTelf, MYSQLI_BOTH);
        $numRow = $estadoTelf->num_rows;
        if ($numRow == "1" && $data["estado"] == "SG") {
            echo "Almacene un número de teléfono para continuar!";
        } else {
            echo "Si hay telefonos";
        }
        break;

    case 'save':
        if ($IdCliente != "") {
            $saveById = ejecutarConsulta12("select contactid from gestionfinal where contactid = '$IdCliente'");
            $valid = mysqli_fetch_array($saveById, MYSQLI_BOTH);
            $numRowC = $saveById->num_rows;
            if ($numRowC == 0) {
                if ($camp->insertGestionFinal($IdCliente, $contactAddress, $interactionId, $Agent, $level1, $level2, $level3, $mangementCode, $time, $Tmstmp, $intentos, $FechaAgendamiento, $TelefonoAd, $Observaciones, $pregunta1, $pregunta2, $pregunta3, $pregunta4, $pregunta5, $pregunta6, $pregunta7, $pregunta8, $pregunta9, $pregunta10, $pregunta11, $pregunta12, $pregunta13, $pregunta14, $pregunta15, $pregunta16, $pregunta17, $pregunta18, $pregunta19, $pregunta20, $pregunta21, $pregunta22, $pregunta23, $pregunta24, $pregunta25, $pregunta26, $pregunta27, $pregunta28, $pregunta29, $pregunta30, $respuesta1, $respuesta2, $respuesta3, $respuesta4, $respuesta5, $respuesta6, $respuesta7, $respuesta8, $respuesta9, $respuesta10, $respuesta11, $respuesta12, $respuesta13, $respuesta14, $respuesta15, $respuesta16, $respuesta17, $respuesta18, $respuesta19, $respuesta20, $respuesta21, $respuesta22, $respuesta23, $respuesta24, $respuesta25, $respuesta26, $respuesta27, $respuesta28, $respuesta29, $respuesta30)) {
                    $respuesta = $camp->updateClientes($IdCliente, $Agent, $level1, $level2, $level3, $mangementCode, $Tmstmp, $intentos, $contactAddress, $interactionId);
                    ejecutarConsulta("Update contactimportcontact set LastAgent = '$Agent', LastManagementResult = '$mangementCode', Number = '$intentos', Action = 'Gestionado' where id = '$IdCliente' ");
                    $camp->insertGestionHistorica($IdCliente);
                    echo "Registro almacenado con éxito";
                } else {
                    echo "Error: registro no se pudo almacenar";
                }
            } else {
                if ($camp->updateGestionFinal($IdCliente, $contactAddress, $interactionId, $Agent, $level1, $level2, $level3, $mangementCode, $time, $Tmstmp, $intentos, $FechaAgendamiento, $TelefonoAd, $Observaciones, $pregunta1, $pregunta2, $pregunta3, $pregunta4, $pregunta5, $pregunta6, $pregunta7, $pregunta8, $pregunta9, $pregunta10, $pregunta11, $pregunta12, $pregunta13, $pregunta14, $pregunta15, $pregunta16, $pregunta17, $pregunta18, $pregunta19, $pregunta20, $pregunta21, $pregunta22, $pregunta23, $pregunta24, $pregunta25, $pregunta26, $pregunta27, $pregunta28, $pregunta29, $pregunta30, $respuesta1, $respuesta2, $respuesta3, $respuesta4, $respuesta5, $respuesta6, $respuesta7, $respuesta8, $respuesta9, $respuesta10, $respuesta11, $respuesta12, $respuesta13, $respuesta14, $respuesta15, $respuesta16, $respuesta17, $respuesta18, $respuesta19, $respuesta20, $respuesta21, $respuesta22, $respuesta23, $respuesta24, $respuesta25, $respuesta26, $respuesta27, $respuesta28, $respuesta29, $respuesta30)) {
                    $respuesta = $camp->updateClientes($IdCliente, $Agent, $level1, $level2, $level3, $mangementCode, $Tmstmp, $intentos, $contactAddress, $interactionId);
                    ejecutarConsulta("Update contactimportcontact set LastAgent = '$Agent', LastManagementResult = '$mangementCode', Number = '$intentos', Action = 'Gestionado' where id = '$IdCliente' ");
                    $camp->insertGestionHistorica($IdCliente);
                    echo "Registro actualizado con éxito";
                } else {
                    echo "Error: registro no se pudo actualizar";
                }
            }
        } else {
            echo "Error de almacenamiento";
        }
        break;
}
?>