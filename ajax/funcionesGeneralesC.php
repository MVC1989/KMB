<?php

session_start();

require '../models/funcionesGeneralesM.php';
$funciones = new funciones();
date_default_timezone_set("America/Lima");
$date = date('Y-m-d H:i:s');

switch ($_GET["action"]) {
    case 'horaInicio':
        echo(date('Y-m-d H:i:s'));
        break;

    case 'interactionIdOld':
        $IdC = $_GET['idC'];
        $interactionId = ejecutarConsulta("SELECT interactionid FROM contactimportphone WHERE ContactId = '$IdC' order by FechaHoraFin desc limit 1");
        $data = mysqli_fetch_array($interactionId, MYSQLI_BOTH);
        echo ($data["interactionid"]);
        break;

    case 'interactionId':
        $interactionId = ejecutarConsulta("SELECT CONCAT(substr(UUID(),1,30),'-', substr(RAND()*10000000000,1,8),'-', substr(RAND()*10000000000,1,8)) AS ID;");
        $data = mysqli_fetch_array($interactionId, MYSQLI_BOTH);
        echo ($data["ID"]);
        break;

    case 'desencriptar':
        $texto = isset($_POST["pass"]) ? LimpiarCadena1($_POST["pass"]) : "";
        $respuesta = $user->desencriptar($texto);
        echo $respuesta;
        break;

    case 'updatePhones':
        $IdC = isset($_POST["IDC"]) ? LimpiarCadena($_POST["IDC"]) : "";
        $Num = isset($_POST["fonos"]) ? LimpiarCadena($_POST["fonos"]) : "";
        $Agent = $_SESSION['usu'];
        $Estado = isset($_POST["estatusTel"]) ? LimpiarCadena($_POST["estatusTel"]) : "";
        $fechaInicio = isset($_POST["horaInicioLlamada"]) ? LimpiarCadena($_POST["horaInicioLlamada"]) : "";
        $InteractionId = isset($_POST["interactionId"]) ? LimpiarCadena($_POST["interactionId"]) : "";
        $Tmstmp = date('Y-m-d H:i:s');
        $respuesta = $funciones->updateTelf($IdC, $Num, $Agent, $Estado, $fechaInicio, $Tmstmp, $InteractionId);
        echo $respuesta ? "Teléfono gestionado con éxito" : "Error: no se pudo almacenar la información!";
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
                . "and campaignid = '$idcamp' ORDER BY level2");
        echo '<option></option>';
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            echo '<option value="' . $row["level2"] . '">' . $row["level2"] . '</option>';
        }
        break;
        
    case 'code':
        $c = $_GET["camp"];
        $level1 = $_GET["level1"];
        $level2 = $_GET["level2"];
        $findCode = ejecutarConsulta("SELECT Code FROM campaignresultmanagement where "
                . "CampaignId = '$c' and Level1 = '$level1' and Level2 = '$level2'");
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

    case 'ventasDiarias':
        $asesor = isset($_POST["asesor"]) ? LimpiarCadena1($_POST["asesor"]) : "";
        $fecha = isset($_POST["asesor"]) ? LimpiarCadena1($_POST["asesor"]) : "";
        $sql = "CREATE TEMPORARY TABLE cck.tmp AS (
                        select contactid, agent, TmStmp, importid, identificacion from bancopichinchacancelaciones.gestionfinal
                        where agent = '$asesor' and tmstmp like '%$fecha%' and resultlevel1 like '%cu1 a%'
                );
                INSERT INTO cck.tmp(select contactid, agent, TmStmp, importid, identificacion from bancopichinchacargosrec.gestionfinal
                        where agent = '$asesor' and tmstmp like '%$fecha%' and resultlevel1 like '%cu1 a%'
                );
                INSERT INTO cck.tmp(select contactid, agent, TmStmp, importid, identificacion from bancopichinchaencuesta.gestionfinal
                        where agent = '$asesor' and tmstmp like '%$fecha%' and resultlevel1 like '%cu1 a%'
                );
                INSERT INTO cck.tmp(select contactid, agent, TmStmp, importid, identificacion from bancopichinchaincrementos.gestionfinal
                        where agent = '$asesor' and tmstmp like '%$fecha%' and resultlevel1 like '%cu1 a%'
                );
                INSERT INTO cck.tmp(select contactid, agent, TmStmp, importid, identificacion from bancopichinchamo.gestionfinal
                        where agent = '$asesor' and tmstmp like '%$fecha%' and resultlevel1 like '%cu1 a%'
                );
                INSERT INTO cck.tmp(select contactid, agent, TmStmp, importid, identificacion from bancopichinchapasivos.gestionfinal
                        where agent = '$asesor' and tmstmp like '%$fecha%' and resultlevel1 like '%cu1 a%'
                );
                INSERT INTO cck.tmp(select contactid, agent, TmStmp, importid, identificacion from bancopichinchavariaciones.gestionfinal
                        where agent = '$asesor' and tmstmp like '%$fecha%' and resultlevel1 like '%cu1 a%'
                );
                INSERT INTO cck.tmp(select contactid, agent, TmStmp, importid, identificacion from bgr.gestionfinal
                        where agent = '$asesor' and tmstmp like '%$fecha%' and resultlevel1 like '%cu1 a%'
                );
                INSERT INTO cck.tmp(select contactid, agent, TmStmp, importid, identificacion from claro.gestionfinal
                        where agent = '$asesor' and tmstmp like '%$fecha%' and ResultLevel1 = 'UBICADOS EXITOSOS' and ResultLevel2 = 'Ubicado/Exitoso/Cumplió con el Objetivo'
                );
                INSERT INTO cck.tmp(select contactid, agent, TmStmp, importid, identificacion from ecuasistencia.gestionfinal
                        where agent = '$asesor' and tmstmp like '%$fecha%' and ResultLevel1 = 'UBICADOS EXITOSOS' and ResultLevel2 = 'Ubicado/Exitoso/Cumplió con el Objetivo'
                );
                INSERT INTO cck.tmp(select contactid, agent, TmStmp, importid, '' from ecuasistenciaencuestas.gestionfinal
                        where agent = '$asesor' and tmstmp like '%$fecha%' and ResultLevel1 = 'UBICADOS EXITOSOS' and ResultLevel2 = 'Ubicado/Exitoso/Cumplió con el Objetivo'
                );
                INSERT INTO cck.tmp(select contactid, agent, TmStmp, importid, identificacion from jardinesdelvalle.gestionfinal
                        where agent = '$asesor' and tmstmp like '%$fecha%' and ResultLevel1 = 'UBICADOS EXITOSOS' and ResultLevel2 = 'Ubicado/Exitoso/Cumplió con el Objetivo'
                );

                select * from cck.tmp;

                drop table cck.tmp;";
        $respuesta = ejecutarConsulta($sql); /* llama a la función del modelo */
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            $datos[] = array(/* llena los resultados con los datos */
                "0" => $registrar->contactid, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                "1" => $registrar->agent,
                "2" => $registrar->TmStmp,
                "3" => $registrar->Agent,
                "4" => $registrar->importid,
                "5" => $registrar->identificacion
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

