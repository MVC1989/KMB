<?php

session_start();

require '../models/bancoBGRCanalesElectronicosM.php';
$camp = new bancoBGRCanalesElectronicosM();
date_default_timezone_set("America/Lima");

$Id = isset($_POST["Id"]) ? LimpiarCadena10($_POST["Id"]) : ""; //Dato estraido de la funcion mostrar_uno js

$IdCliente = isset($_POST["IDC"]) ? LimpiarCadena10($_POST["IDC"]) : "";
$Num = isset($_POST["fonos"]) ? LimpiarCadena10($_POST["fonos"]) : "";
$Agent = $_SESSION['usu'];
$Estado = isset($_POST["estatusTel"]) ? LimpiarCadena10($_POST["estatusTel"]) : "";
$Tmstmp = date('Y-m-d H:i:s');
$time = isset($_POST["horaInicio"]) ? LimpiarCadena10($_POST["horaInicio"]) : "";
$intentos = isset($_POST["intentos"]) ? LimpiarCadena10($_POST["intentos"]) : "";
$level1 = isset($_POST["level1"]) ? LimpiarCadena10($_POST["level1"]) : "";
$level2 = isset($_POST["level2"]) ? LimpiarCadena10($_POST["level2"]) : "";
$level3 = isset($_POST["level3"]) ? LimpiarCadena2($_POST["level3"]) : "";
$campaign = isset($_POST["CAMPANIA"]) ? LimpiarCadena10($_POST["CAMPANIA"]) : "";
$mangementCode = isset($_POST["code"]) ? LimpiarCadena10($_POST["code"]) : "";
$queryT = ejecutarConsulta("SELECT NumeroMarcado FROM contactimportphone WHERE ContactId = '$IdCliente' order by FechaHora desc limit 1");
$rowT = mysqli_fetch_array($queryT, MYSQLI_BOTH);
$contactAddress = $rowT["NumeroMarcado"];
$contactname = isset($_POST["ASISTENCIA"]) ? LimpiarCadena10($_POST["ASISTENCIA"]) : "";
$FechaAgendamiento = isset($_POST["agenda"]) ? LimpiarCadena10($_POST["agenda"]) : "";
$TelefonoAd = isset($_POST["fonoAd"]) ? LimpiarCadena10($_POST["fonoAd"]) : "";
$Observaciones = isset($_POST["obs"]) ? LimpiarCadena10($_POST["obs"]) : "";

$pregunta1 = isset($_POST["pregunta1"]) ? LimpiarCadena10($_POST["pregunta1"]) : "";
$respuesta1 = isset($_POST["respuesta1"]) ? LimpiarCadena10($_POST["respuesta1"]) : "";
$pregunta1_1 = isset($_POST["pregunta1_1"]) ? LimpiarCadena10($_POST["pregunta1_1"]) : "";
$respuesta1_1 = isset($_POST["respuesta1_1"]) ? LimpiarCadena10($_POST["respuesta1_1"]) : "";
$pregunta2 = isset($_POST["pregunta2"]) ? LimpiarCadena10($_POST["pregunta2"]) : "";
$respuesta2 = isset($_POST["respuesta2"]) ? LimpiarCadena10($_POST["respuesta2"]) : "";
$pregunta2_1 = isset($_POST["pregunta2_1"]) ? LimpiarCadena10($_POST["pregunta2_1"]) : "";
$respuesta2_1 = isset($_POST["respuesta2_1"]) ? LimpiarCadena10($_POST["respuesta2_1"]) : "";
$pregunta3 = isset($_POST["pregunta3"]) ? LimpiarCadena10($_POST["pregunta3"]) : "";
$respuesta3 = isset($_POST["respuesta3"]) ? LimpiarCadena10($_POST["respuesta3"]) : "";
$pregunta3_1 = isset($_POST["pregunta3_1"]) ? LimpiarCadena10($_POST["pregunta3_1"]) : "";
$respuesta3_1 = isset($_POST["respuesta3_1"]) ? LimpiarCadena10($_POST["respuesta3_1"]) : "";
$pregunta4 = isset($_POST["pregunta4"]) ? LimpiarCadena10($_POST["pregunta4"]) : "";
$respuesta4 = isset($_POST["respuesta4"]) ? LimpiarCadena10($_POST["respuesta4"]) : "";
$pregunta4_1 = isset($_POST["pregunta4_1"]) ? LimpiarCadena10($_POST["pregunta4_1"]) : "";
$respuesta4_1 = isset($_POST["respuesta4_1"]) ? LimpiarCadena10($_POST["respuesta4_1"]) : "";
$pregunta5 = isset($_POST["pregunta5"]) ? LimpiarCadena10($_POST["pregunta5"]) : "";
$respuesta5 = isset($_POST["respuesta5"]) ? LimpiarCadena10($_POST["respuesta5"]) : "";
$pregunta5_1 = isset($_POST["pregunta5_1"]) ? LimpiarCadena10($_POST["pregunta5_1"]) : "";
$respuesta5_1 = isset($_POST["respuesta5_1"]) ? LimpiarCadena10($_POST["respuesta5_1"]) : "";
$pregunta6 = isset($_POST["pregunta6"]) ? LimpiarCadena10($_POST["pregunta6"]) : "";
$respuesta6 = isset($_POST["respuesta6"]) ? LimpiarCadena10($_POST["respuesta6"]) : "";
$pregunta6_1 = isset($_POST["pregunta6_1"]) ? LimpiarCadena10($_POST["pregunta6_1"]) : "";
$respuesta6_1 = isset($_POST["respuesta6_1"]) ? LimpiarCadena10($_POST["respuesta6_1"]) : "";
$pregunta7 = isset($_POST["pregunta7"]) ? LimpiarCadena10($_POST["pregunta7"]) : "";
$respuesta7 = isset($_POST["respuesta7"]) ? LimpiarCadena10($_POST["respuesta7"]) : "";
$pregunta7_1 = isset($_POST["pregunta7_1"]) ? LimpiarCadena10($_POST["pregunta7_1"]) : "";
$respuesta7_1 = isset($_POST["respuesta7_1"]) ? LimpiarCadena10($_POST["respuesta7_1"]) : "";
$pregunta8 = isset($_POST["pregunta8"]) ? LimpiarCadena10($_POST["pregunta8"]) : "";
$respuesta8 = isset($_POST["respuesta8"]) ? LimpiarCadena10($_POST["respuesta8"]) : "";
$pregunta8_1 = isset($_POST["pregunta8_1"]) ? LimpiarCadena10($_POST["pregunta8_1"]) : "";
$respuesta8_1 = isset($_POST["respuesta8_1"]) ? LimpiarCadena10($_POST["respuesta8_1"]) : "";
$pregunta9 = isset($_POST["pregunta9"]) ? LimpiarCadena10($_POST["pregunta9"]) : "";
$respuesta9 = isset($_POST["respuesta9"]) ? LimpiarCadena10($_POST["respuesta9"]) : "";
$pregunta9_1 = isset($_POST["pregunta9_1"]) ? LimpiarCadena10($_POST["pregunta9_1"]) : "";
$respuesta9_1 = isset($_POST["respuesta9_1"]) ? LimpiarCadena10($_POST["respuesta9_1"]) : "";
$pregunta10 = isset($_POST["pregunta10"]) ? LimpiarCadena10($_POST["pregunta10"]) : "";
$respuesta10 = isset($_POST["respuesta10"]) ? LimpiarCadena10($_POST["respuesta10"]) : "";
$pregunta10_1 = isset($_POST["pregunta10_1"]) ? LimpiarCadena10($_POST["pregunta10_1"]) : "";
$respuesta10_1 = isset($_POST["respuesta10_1"]) ? LimpiarCadena10($_POST["respuesta10_1"]) : "";
$pregunta11 = isset($_POST["pregunta11"]) ? LimpiarCadena10($_POST["pregunta11"]) : "";
$respuesta11 = isset($_POST["respuesta11"]) ? LimpiarCadena10($_POST["respuesta11"]) : "";
$pregunta11_1 = isset($_POST["pregunta11_1"]) ? LimpiarCadena10($_POST["pregunta11_1"]) : "";
$respuesta11_1 = isset($_POST["respuesta11_1"]) ? LimpiarCadena10($_POST["respuesta11_1"]) : "";
$pregunta12 = isset($_POST["pregunta12"]) ? LimpiarCadena10($_POST["pregunta12"]) : "";
$respuesta12 = isset($_POST["respuesta12"]) ? LimpiarCadena10($_POST["respuesta12"]) : "";
$pregunta12_1 = isset($_POST["pregunta12_1"]) ? LimpiarCadena10($_POST["pregunta12_1"]) : "";
$respuesta12_1 = isset($_POST["respuesta12_1"]) ? LimpiarCadena10($_POST["respuesta12_1"]) : "";
$pregunta13 = isset($_POST["pregunta13"]) ? LimpiarCadena10($_POST["pregunta13"]) : "";
$respuesta13 = isset($_POST["respuesta13"]) ? LimpiarCadena10($_POST["respuesta13"]) : "";
$pregunta13_1 = isset($_POST["pregunta13_1"]) ? LimpiarCadena10($_POST["pregunta13_1"]) : "";
$respuesta13_1 = isset($_POST["respuesta13_1"]) ? LimpiarCadena10($_POST["respuesta13_1"]) : "";
$pregunta14 = isset($_POST["pregunta14"]) ? LimpiarCadena10($_POST["pregunta14"]) : "";
$respuesta14 = isset($_POST["respuesta14"]) ? LimpiarCadena10($_POST["respuesta14"]) : "";
$pregunta14_1 = isset($_POST["pregunta14_1"]) ? LimpiarCadena10($_POST["pregunta14_1"]) : "";
$respuesta14_1 = isset($_POST["respuesta14_1"]) ? LimpiarCadena10($_POST["respuesta14_1"]) : "";
$pregunta15 = isset($_POST["pregunta15"]) ? LimpiarCadena10($_POST["pregunta15"]) : "";
$respuesta15 = isset($_POST["respuesta15"]) ? LimpiarCadena10($_POST["respuesta15"]) : "";
$pregunta15_1 = isset($_POST["pregunta15_1"]) ? LimpiarCadena10($_POST["pregunta15_1"]) : "";
$respuesta15_1 = isset($_POST["respuesta15_1"]) ? LimpiarCadena10($_POST["respuesta15_1"]) : "";

switch ($_GET["action"]) {
    case 'fechaInicio':
        date_default_timezone_set("America/Lima");
        echo(date('Y-m-d H:i:s'));
        break;

    case 'preguntas':
        $transaccion = $_GET['txt'];
        $result = ejecutarConsultaSimple11("SELECT pregunta FROM preguntastramites where tramite = '$transaccion' and pilar = 'digital' ");
        echo $result["pregunta"];
        break;

    case 'selectAll':
        $respuesta = $camp->selectAll(); /* llama a la función del modelo */
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            $datos[] = array(/* llena los resultados con los datos */
                "0" => $registrar->ID, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                "1" => $registrar->CampaignId,
                "2" => $registrar->ImportId,
                "3" => $registrar->Agent,
                "4" => $registrar->IDENTIFICACION,
                "5" => $registrar->NOMBRE_CLIENTE,
                "6" => $registrar->AGENCIA,
                "7" => $registrar->SECCION,
                "8" => $registrar->FECHA_ATENCION,
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
        $respuesta = $camp->selectAllRec(); /* llama a la función del modelo */
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
                    "6" => '<p style="color: red">' . $registrar->AGENCIA . '</p>',
                    "7" => '<p style="color: red">' . $registrar->SECCION . '</p>',
                    "8" => '<p style="color: red">' . $registrar->FECHA_ATENCION . '</p>',
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
                    "6" => $registrar->AGENCIA,
                    "7" => $registrar->SECCION,
                    "8" => $registrar->FECHA_ATENCION,
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
                . "and level3 = ''");
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
        $phonesById = ejecutarConsulta2("select contactid from gestionfinalcanales where contactid = '$idC'");
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
            $saveById = ejecutarConsulta11("select contactid from gestionfinalcanales where contactid = '$IdCliente'");
            $valid = mysqli_fetch_array($saveById, MYSQLI_BOTH);
            $numRowC = $saveById->num_rows;
            $respuesta = $camp->updateClientes($IdCliente, $Agent, $level1, $level2, $level3, $mangementCode, $Tmstmp, $intentos, $contactAddress);
            if ($numRowC == 0) {
                if ($camp->insertGestionFinal($IdCliente, $contactAddress, $Agent, $level1, $level2, $level3, $mangementCode, $time, $Tmstmp, $intentos, $FechaAgendamiento, $TelefonoAd, $Observaciones, $pregunta1, $pregunta1_1, $pregunta2, $pregunta2_1, $pregunta3, $pregunta3_1, $pregunta4, $pregunta4_1, $pregunta5, $pregunta5_1, $pregunta6, $pregunta6_1, $pregunta7, $pregunta7_1, $pregunta8, $pregunta8_1, $pregunta9, $pregunta9_1, $pregunta10, $pregunta10_1, $pregunta11, $pregunta11_1, $pregunta12, $pregunta12_1, $pregunta13, $pregunta13_1, $pregunta14, $pregunta14_1, $pregunta15, $pregunta15_1, $respuesta1, $respuesta1_1, $respuesta2, $respuesta2_1, $respuesta3, $respuesta3_1, $respuesta4, $respuesta4_1, $respuesta5, $respuesta5_1, $respuesta6, $respuesta6_1, $respuesta7, $respuesta7_1, $respuesta8, $respuesta8_1, $respuesta9, $respuesta9_1, $respuesta10, $respuesta10_1, $respuesta11, $respuesta11_1, $respuesta12, $respuesta12_1, $respuesta13, $respuesta13_1, $respuesta14, $respuesta14_1, $respuesta15, $respuesta15_1)) {
                    ejecutarConsulta("Update contactimportcontact set LastAgent = '$Agent', LastManagementResult = '$mangementCode', Number = '$intentos', Action = 'Gestionado' where id = '$IdCliente' ");
                    $camp->insertGestionHistorica($IdCliente);
                    echo "Registro almacenado con éxito";
                } else {
                    echo "Error: registro no se pudo almacenar";
                }
            } else {
                if ($camp->updateGestionFinal($IdCliente, $contactAddress, $Agent, $level1, $level2, $level3, $mangementCode, $time, $Tmstmp, $intentos, $FechaAgendamiento, $TelefonoAd, $Observaciones, $pregunta1, $pregunta1_1, $pregunta2, $pregunta2_1, $pregunta3, $pregunta3_1, $pregunta4, $pregunta4_1, $pregunta5, $pregunta5_1, $pregunta6, $pregunta6_1, $pregunta7, $pregunta7_1, $pregunta8, $pregunta8_1, $pregunta9, $pregunta9_1, $pregunta10, $pregunta10_1, $pregunta11, $pregunta11_1, $pregunta12, $pregunta12_1, $pregunta13, $pregunta13_1, $pregunta14, $pregunta14_1, $pregunta15, $pregunta15_1, $respuesta1, $respuesta1_1, $respuesta2, $respuesta2_1, $respuesta3, $respuesta3_1, $respuesta4, $respuesta4_1, $respuesta5, $respuesta5_1, $respuesta6, $respuesta6_1, $respuesta7, $respuesta7_1, $respuesta8, $respuesta8_1, $respuesta9, $respuesta9_1, $respuesta10, $respuesta10_1, $respuesta11, $respuesta11_1, $respuesta12, $respuesta12_1, $respuesta13, $respuesta13_1, $respuesta14, $respuesta14_1, $respuesta15, $respuesta15_1)) {
                    $respuesta = $camp->updateClientes($IdCliente, $Agent, $level1, $level2, $level3, $mangementCode, $Tmstmp, $intentos, $contactAddress);
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