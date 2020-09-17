<?php

session_start();

require '../models/baseManagementM.php';
$reciclar = new baseManagement();
date_default_timezone_set("America/Lima");
$date = date('Y-m-d H:i:s');
$vUser = $_SESSION['usu'];

switch ($_GET["action"]) {
    case 'RecycledType':
        $campaign = isset($_POST['camp']) ? LimpiarCadena($_POST["camp"]) : "";
        $result = ejecutarConsultaSimple("SELECT RecycledType FROM campaign WHERE State = '1' and Id = '$campaign' ");
        echo $result['RecycledType'];
        break;

    case 'bases':
        $campaign = isset($_POST['camp']) ? LimpiarCadena($_POST["camp"]) : "";
        $result = ejecutarConsulta("SELECT distinct(LastUpdate) 'LastUpdate' FROM contactimportcontact where campaign = '$campaign' and  Action <> 'cancelar base' order by LastUpdate ");
        echo '<option></option>';
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            echo '<option value="' . $row["LastUpdate"] . '">' . $row["LastUpdate"] . '</option>';
        }
        break;

    case 'asesor':
        $asesor = isset($_POST['search']) ? LimpiarCadena($_POST["search"]) : "";
        $campaign = isset($_POST['camp']) ? LimpiarCadena($_POST["camp"]) : "";
        $result = ejecutarConsulta("select distinct UserId 'UserId' from usercampaign where campaignId = '$campaign' and UserId like '%$asesor%' order by UserId ");
        $json = [];
        while ($row = $result->fetch_assoc()) {
            $json[] = $row['UserId'];
        }
        echo json_encode($json);
        break;

    /*     * ************************ASIGNACION Y RETIRO BASES*************************************************************** */

    case 'showAll':
        $campaign = isset($_POST['campaign']) ? LimpiarCadena($_POST["campaign"]) : "";
        $base = isset($_POST['base']) ? LimpiarCadena($_POST["base"]) : "";
        $respuesta = ejecutarConsulta("SELECT `ID`, `Name`, `Identification`, `Campaign`, `LastManagementResult`, `LastUpdate`, `LastAgent`, `TmStmpShift`, `UserShift`, `Action` "
                . "FROM `contactimportcontact` WHERE LastAgent = '' "
                . "and LastUpdate = '$base' and campaign = '$campaign' and LastManagementResult = '' and  Action <> 'cancelar base' ");
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            $datos[] = array(/* llena los resultados con los datos */
                "0" => $registrar->ID, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                "1" => $registrar->Name,
                "2" => $registrar->Identification,
                "3" => $registrar->Campaign,
                "4" => $registrar->LastManagementResult,
                "5" => $registrar->LastUpdate,
                "6" => $registrar->LastAgent,
                "7" => $registrar->TmStmpShift,
                "8" => $registrar->UserShift,
                "9" => $registrar->Action,
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

    case 'showAllAssigns':
        $campaign = isset($_POST['campaign']) ? LimpiarCadena($_POST["campaign"]) : "";
        $base = isset($_POST['base']) ? LimpiarCadena($_POST["base"]) : "";
        $respuesta = ejecutarConsulta("SELECT `ID`, `Name`, `Identification`, `Campaign`, `LastManagementResult`, `LastUpdate`, `LastAgent`, `TmStmpShift`, `UserShift`, `Action` "
                . "FROM `contactimportcontact` WHERE LastAgent <> '' "
                . "and LastUpdate = '$base' and campaign = '$campaign' and LastManagementResult = '' and  Action <> 'cancelar base' ");
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            $datos[] = array(/* llena los resultados con los datos */
                "0" => $registrar->ID, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                "1" => $registrar->Name,
                "2" => $registrar->Identification,
                "3" => $registrar->Campaign,
                "4" => $registrar->LastManagementResult,
                "5" => $registrar->LastUpdate,
                "6" => $registrar->LastAgent,
                "7" => $registrar->TmStmpShift,
                "8" => $registrar->UserShift,
                "9" => $registrar->Action,
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

    case 'validar':
        $totalReg = isset($_POST["numReg"]) ? LimpiarCadena($_POST["numReg"]) : "";
        $import = isset($_POST["base"]) ? LimpiarCadena($_POST["base"]) : "";
        $campaign = isset($_POST["campaign"]) ? LimpiarCadena($_POST["campaign"]) : "";
        $actions = isset($_POST["acciones"]) ? LimpiarCadena($_POST["acciones"]) : "";
        if ($actions == "Asignar Base") {
            $noAssings = ejecutarConsulta("SELECT COUNT(`ID`) 'ID' "
                    . "FROM `contactimportcontact` WHERE LastAgent = '' and LastManagementResult = '' "
                    . "and LastUpdate = '$import' and campaign = '$campaign'  and  Action <> 'cancelar base' ");
            $row = mysqli_fetch_array($noAssings);
            if ($totalReg > $row['ID']) {
                echo("No seguir");
            } else {
                echo("Si seguir");
            }
        } else if ($actions == "Retirar Base") {
            $assigns = ejecutarConsulta("SELECT count(`ID`) 'ID' "
                    . "FROM `contactimportcontact` WHERE LastAgent <> '' and LastManagementResult = '' "
                    . "and LastUpdate = '$import' and campaign = '$campaign'  and  Action <> 'cancelar base' ");
            $row = mysqli_fetch_array($assigns);
            echo("Si seguir");
        }
        break;

    case 'administration':
        $import = isset($_POST["base"]) ? LimpiarCadena($_POST["base"]) : "";
        $campaign = isset($_POST["campaign"]) ? LimpiarCadena($_POST["campaign"]) : "";
        $asesor = isset($_POST["asesores"]) ? LimpiarCadena($_POST["asesores"]) : "";
        $cantidad = isset($_POST["cantidad"]) ? LimpiarCadena($_POST["cantidad"]) : "";
        $actions = isset($_POST["acciones"]) ? LimpiarCadena($_POST["acciones"]) : "";
        $valor_array = explode(',', $asesor); //explode convierte string a array e implode convierte array a string
        $longitud = count($valor_array);
        if ($actions == "Asignar Base") {
            for ($i = 0; $i < $longitud; $i++) {
                $vAsesor = trim($valor_array[$i]);
                $insertBase = ejecutarConsulta("update contactimportcontact set LastAgent = '$vAsesor', UserShift = '$vUser',"
                        . "TmStmpShift = '$date', Action = '$actions'"
                        . "where LastUpdate = '$import' and LastAgent = '' and LastManagementResult = '' and action <> 'Cancelar base'"
                        . "and Campaign = '$campaign'"
                        . "order by id LIMIT $cantidad");
            }
            echo $insertBase ? "Se ha asignado base exitosamente!" : "No se ha asignado la base!";
        } else if ($actions == "Retirar Base") {
            for ($i = 0; $i < $longitud; $i++) {
                $vAsesor = trim($valor_array[$i]);
                $updateBase = ejecutarConsulta("update contactimportcontact set LastAgent = '', UserShift = '$vUser', "
                        . "TmStmpShift = '$date', Action = '$actions' "
                        . "where LastUpdate = '$import' and LastAgent like '%$vAsesor%' "
                        . "and LastManagementResult = '' "
                        . "and Campaign = '$campaign' ");
            }
            echo $updateBase ? "Se ha retirado base exitosamente!" : "No se ha retirado la base!";
        }
        break;

    /*     * *******************************RECICLADO Y RETIRO DE BASES*************************************** */
    case 'regestionablesOpc1':
        $campaign = isset($_POST['campaign']) ? LimpiarCadena($_POST["campaign"]) : "";
        $import = isset($_POST['base']) ? LimpiarCadena($_POST["base"]) : "";
        $respuesta = $reciclar->regestionablesOpc1($campaign, $import); /* llama a la función del modelo */
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            $datos[] = array(/* llena los resultados con los datos */
                "0" => $registrar->ID, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                "1" => $registrar->Name,
                "2" => $registrar->Identification,
                "3" => $registrar->Campaign,
                "4" => $registrar->LastManagementResult,
                "5" => $registrar->LastUpdate,
                "6" => $registrar->LastAgent,
                "7" => $registrar->TmStmpShift,
                "8" => $registrar->UserShift,
                "9" => $registrar->Action,
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

    case 'rellamadosOpc1':
        $campaign = isset($_POST['campaign']) ? LimpiarCadena($_POST["campaign"]) : "";
        $import = isset($_POST['base']) ? LimpiarCadena($_POST["base"]) : "";
        $respuesta = $reciclar->rellamadosOpc1($campaign, $import); /* llama a la función del modelo */
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            $datos[] = array(/* llena los resultados con los datos */
                "0" => $registrar->ID, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                "1" => $registrar->Name,
                "2" => $registrar->Identification,
                "3" => $registrar->Campaign,
                "4" => $registrar->LastManagementResult,
                "5" => $registrar->LastUpdate,
                "6" => $registrar->LastAgent,
                "7" => $registrar->TmStmpShift,
                "8" => $registrar->UserShift,
                "9" => $registrar->Action,
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

    case 'regestionablesOpc2':
        $campaign = isset($_POST['campaign']) ? LimpiarCadena($_POST["campaign"]) : "";
        $import = isset($_POST['base']) ? LimpiarCadena($_POST["base"]) : "";
        $respuesta = $reciclar->regestionablesOpc2($campaign, $import); /* llama a la función del modelo */
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            $datos[] = array(/* llena los resultados con los datos */
                "0" => $registrar->ID, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                "1" => $registrar->Name,
                "2" => $registrar->Identification,
                "3" => $registrar->Campaign,
                "4" => $registrar->LastManagementResult,
                "5" => $registrar->LastUpdate,
                "6" => $registrar->LastAgent,
                "7" => $registrar->TmStmpShift,
                "8" => $registrar->UserShift,
                "9" => $registrar->Action,
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

    case 'rellamadosOpc2':
        $campaign = isset($_POST['campaign']) ? LimpiarCadena($_POST["campaign"]) : "";
        $import = isset($_POST['base']) ? LimpiarCadena($_POST["base"]) : "";
        $respuesta = $reciclar->rellamadosOpc2($campaign, $import); /* llama a la función del modelo */
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            $datos[] = array(/* llena los resultados con los datos */
                "0" => $registrar->ID, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                "1" => $registrar->Name,
                "2" => $registrar->Identification,
                "3" => $registrar->Campaign,
                "4" => $registrar->LastManagementResult,
                "5" => $registrar->LastUpdate,
                "6" => $registrar->LastAgent,
                "7" => $registrar->TmStmpShift,
                "8" => $registrar->UserShift,
                "9" => $registrar->Action,
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

    case 'disponiblesRegestionablesOpc1':
        $campaign = isset($_POST['campaign']) ? LimpiarCadena($_POST["campaign"]) : "";
        $import = isset($_POST['base']) ? LimpiarCadena($_POST["base"]) : "";
        $respuesta = $reciclar->recicladosRegestionablesOpc1($campaign, $import); /* llama a la función del modelo */
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            $datos[] = array(/* llena los resultados con los datos */
                "0" => $registrar->ID, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                "1" => $registrar->Name,
                "2" => $registrar->Identification,
                "3" => $registrar->Campaign,
                "4" => $registrar->LastManagementResult,
                "5" => $registrar->LastUpdate,
                "6" => $registrar->LastAgent,
                "7" => $registrar->TmStmpShift,
                "8" => $registrar->UserShift,
                "9" => $registrar->Action,
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

    case 'disponiblesRellamadosOpc1':
        $campaign = isset($_POST['campaign']) ? LimpiarCadena($_POST["campaign"]) : "";
        $import = isset($_POST['base']) ? LimpiarCadena($_POST["base"]) : "";
        $respuesta = $reciclar->recicladosRellamadosOpc1($campaign, $import); /* llama a la función del modelo */
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            $datos[] = array(/* llena los resultados con los datos */
                "0" => $registrar->ID, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                "1" => $registrar->Name,
                "2" => $registrar->Identification,
                "3" => $registrar->Campaign,
                "4" => $registrar->LastManagementResult,
                "5" => $registrar->LastUpdate,
                "6" => $registrar->LastAgent,
                "7" => $registrar->TmStmpShift,
                "8" => $registrar->UserShift,
                "9" => $registrar->Action,
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

    case 'disponiblesRegestionablesOpc2':
        $campaign = isset($_POST['campaign']) ? LimpiarCadena($_POST["campaign"]) : "";
        $import = isset($_POST['base']) ? LimpiarCadena($_POST["base"]) : "";
        $respuesta = $reciclar->recicladosRegestionablesOpc2($campaign, $import); /* llama a la función del modelo */
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            $datos[] = array(/* llena los resultados con los datos */
                "0" => $registrar->ID, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                "1" => $registrar->Name,
                "2" => $registrar->Identification,
                "3" => $registrar->Campaign,
                "4" => $registrar->LastManagementResult,
                "5" => $registrar->LastUpdate,
                "6" => $registrar->LastAgent,
                "7" => $registrar->TmStmpShift,
                "8" => $registrar->UserShift,
                "9" => $registrar->Action,
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

    case 'disponiblesRellamadosOpc2':
        $campaign = isset($_POST['campaign']) ? LimpiarCadena($_POST["campaign"]) : "";
        $import = isset($_POST['base']) ? LimpiarCadena($_POST["base"]) : "";
        $respuesta = $reciclar->recicladosRellamadosOpc2($campaign, $import); /* llama a la función del modelo */
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            $datos[] = array(/* llena los resultados con los datos */
                "0" => $registrar->ID, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                "1" => $registrar->Name,
                "2" => $registrar->Identification,
                "3" => $registrar->Campaign,
                "4" => $registrar->LastManagementResult,
                "5" => $registrar->LastUpdate,
                "6" => $registrar->LastAgent,
                "7" => $registrar->TmStmpShift,
                "8" => $registrar->UserShift,
                "9" => $registrar->Action,
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

    case 'validarRec':
        $totalReg = isset($_POST["numReg"]) ? LimpiarCadena($_POST["numReg"]) : "";
        $import = isset($_POST["base"]) ? LimpiarCadena($_POST["base"]) : "";
        $campaign = isset($_POST["campaign"]) ? LimpiarCadena($_POST["campaign"]) : "";
        $actions = isset($_POST["acciones"]) ? LimpiarCadena($_POST["acciones"]) : "";
        $estatus = isset($_POST["estatus"]) ? LimpiarCadena($_POST["estatus"]) : "";
        $recycledType = isset($_POST["recycledType"]) ? LimpiarCadena($_POST["recycledType"]) : "";

        //$barrido = ejecutarConsulta("SELECT Id from contactimportcontact WHERE campaign = '$campaign' and "
        //        . "LastUpdate = '$import' and number = 0");
        //$rowB = $barrido->num_rows;
        //if ($rowB == "" || $rowB == 0) {
        if ($actions == "Reciclar base") {
            if ($recycledType == "1") {
                if ($estatus == "Regestionables") {
                    $count = ejecutarConsulta("SELECT COUNT(`ID`) 'ID' "
                            . "FROM `contactimportcontact` WHERE (Action = 'Retirar base' or Action = 'Gestionado') and (LastManagementResult >= '60' and "
                            . "LastManagementResult <= '64') and number > 0 "
                            . "and LastUpdate = '$import' and campaign = '$campaign'  and  Action <> 'cancelar base' ");
                    $row = mysqli_fetch_array($count);
                    if ($totalReg > $row['ID']) {
                        echo("No seguir");
                    } else {
                        echo("Si seguir");
                    }
                } else if ($estatus == "Rellamados") {
                    $count = ejecutarConsulta("SELECT COUNT(`ID`) 'ID' "
                            . "FROM `contactimportcontact` WHERE (Action = 'Retirar base' or Action = 'Gestionado') and LastManagementResult = '34' and number > 0 "
                            . "and LastUpdate = '$import' and campaign = '$campaign'  and  Action <> 'cancelar base' ");
                    $row = mysqli_fetch_array($count);
                    if ($totalReg > $row['ID']) {
                        echo("No seguir");
                    } else {
                        echo("Si seguir");
                    }
                }
            } else if ($recycledType == "2") {
                if ($estatus == "Regestionables") {
                    $count = ejecutarConsulta("SELECT COUNT(`ID`) 'ID' "
                            . "FROM `contactimportcontact` WHERE (Action = 'Retirar base' or Action = 'Gestionado') and (LastManagementResult = '19' or LastManagementResult = '21' or "
                            . " LastManagementResult = '22' or LastManagementResult = '23') and number > 0 "
                            . "and LastUpdate = '$import' and campaign = '$campaign'  and  Action <> 'cancelar base' ");
                    $row = mysqli_fetch_array($count);
                    if ($totalReg > $row['ID']) {
                        echo("No seguir");
                    } else {
                        echo("Si seguir");
                    }
                } else if ($estatus == "Rellamados") {
                    $count = ejecutarConsulta("SELECT COUNT(`ID`) 'ID' "
                            . "FROM `contactimportcontact` WHERE (Action = 'Retirar base' or Action = 'Gestionado') and "
                            . "(LastManagementResult = '18' or LastManagementResult = '20') and number > 0 "
                            . "and LastUpdate = '$import' and campaign = '$campaign'  and  Action <> 'cancelar base' ");
                    $row = mysqli_fetch_array($count);
                    if ($totalReg > $row['ID']) {
                        echo("No seguir");
                    } else {
                        echo("Si seguir");
                    }
                }
            }
        } else if ($actions == "Retirar base") {
            if ($recycledType == "1") {
                if ($estatus == "Regestionables") {
                    $count = ejecutarConsulta("SELECT COUNT(`ID`) 'ID' "
                            . "FROM `contactimportcontact` WHERE (Action = 'Reciclar base' or Action = 'Gestionado') "
                            . "and (LastManagementResult >= '60' and LastManagementResult <= '64') and number > 0 "
                            . "and LastUpdate = '$import' and campaign = '$campaign'  and  Action <> 'cancelar base' ");
                    $row = mysqli_fetch_array($count);
                    if ($row['ID'] > 0) {
                        echo("Si seguir");
                    } else {
                        echo("No seguir");
                    }
                } else if ($estatus == "Rellamados") {
                    $count = ejecutarConsulta("SELECT COUNT(`ID`) 'ID' "
                            . "FROM `contactimportcontact` WHERE (Action = 'Reciclar base' or Action = 'Gestionado') "
                            . "and LastManagementResult = '34' and number > 0 "
                            . "and LastUpdate = '$import' and campaign = '$campaign'  and  Action <> 'cancelar base' ");
                    $row = mysqli_fetch_array($count);
                    if ($row['ID'] > 0) {
                        echo("Si seguir");
                    } else {
                        echo("No seguir");
                    }
                }
            } else if ($recycledType == "2") {
                if ($estatus == "Regestionables") {
                    $count = ejecutarConsulta("SELECT COUNT(`ID`) 'ID' "
                            . "FROM `contactimportcontact` WHERE (Action = 'Reciclar base' or Action = 'Gestionado') "
                            . "and (LastManagementResult = '19' or LastManagementResult = '21' or "
                            . "LastManagementResult = '22' or LastManagementResult = '23') and number > 0 "
                            . "and LastUpdate = '$import' and campaign = '$campaign'  and  Action <> 'cancelar base' ");
                    $row = mysqli_fetch_array($count);
                    if ($row['ID'] > 0) {
                        echo("Si seguir");
                    } else {
                        echo("No seguir");
                    }
                } else if ($estatus == "Rellamados") {
                    $count = ejecutarConsulta("SELECT COUNT(`ID`) 'ID' "
                            . "FROM `contactimportcontact` WHERE (Action = 'Reciclar base' or Action = 'Gestionado') and "
                            . "(LastManagementResult = '18' or LastManagementResult = '20') and number > 0 "
                            . "and LastUpdate = '$import' and campaign = '$campaign'  and  Action <> 'cancelar base' ");
                    $row = mysqli_fetch_array($count);
                    if ($row['ID'] > 0) {
                        echo("Si seguir");
                    } else {
                        echo("No seguir");
                    }
                }
            }
        }
        //} else {
        //    echo 'No pasa';
        //}
        break;

    case 'administrationRec':
        $campaign = isset($_POST["campaign"]) ? LimpiarCadena($_POST["campaign"]) : "";
        $import = isset($_POST["base"]) ? LimpiarCadena($_POST["base"]) : "";
        $recycledType = isset($_POST["recycledType"]) ? LimpiarCadena($_POST["recycledType"]) : "";
        $asesor = isset($_POST["asesores"]) ? LimpiarCadena($_POST["asesores"]) : "";
        $estatus = isset($_POST["estatus"]) ? LimpiarCadena($_POST["estatus"]) : "";
        $cantidad = isset($_POST["Cantidad"]) ? LimpiarCadena($_POST["Cantidad"]) : "";
        $actions = isset($_POST["acciones"]) ? LimpiarCadena($_POST["acciones"]) : "";
        $valor_array = explode(',', $asesor); //explode convierte string a array e implode convierte array a string
        $longitud = count($valor_array);
        if ($actions == "Reciclar base") {
            for ($i = 0; $i < $longitud; $i++) {
                $vAsesor = trim($valor_array[$i]);
                if ($recycledType == "1") {
                    if ($estatus == "Regestionables") {
                        $recycle = ejecutarConsulta("update contactimportcontact set LastAgent = '$vAsesor', "
                                . "UserShift = '$vUser',TmStmpShift = '$date', Action = '$actions'"
                                . "where LastUpdate = '$import' and (LastManagementResult >= '60' and  LastManagementResult <= '64')"
                                . "and Campaign = '$campaign' and (Action = 'Retirar base' or Action = 'Gestionado') and number > 0 "
                                . "order by id LIMIT $cantidad");
                        echo $recycle ? "Se recicló base para el asesor/a <b>" . $vAsesor . "</b> con éxito <br>" : "No se pudo realizar el reciclado de base <br>";
                    } else if ($estatus == "Rellamados") {
                        $recycle = ejecutarConsulta("update contactimportcontact set LastAgent = '$vAsesor', "
                                . "UserShift = '$vUser',TmStmpShift = '$date', Action = '$actions'"
                                . "where LastUpdate = '$import' and LastManagementResult = '34' "
                                . "and Campaign = '$campaign' and (Action = 'Retirar base' or Action = 'Gestionado') and number > 0 "
                                . "order by id LIMIT $cantidad");
                        echo $recycle ? "Se recicló base para el asesor/a <b>" . $vAsesor . "</b> con éxito <br>" : "No se pudo realizar el reciclado de base <br>";
                    }
                } else if ($recycledType == "2") {
                    if ($estatus == "Regestionables") {
                        $recycle = ejecutarConsulta("update contactimportcontact set LastAgent = '$vAsesor', "
                        . "UserShift = '$vUser',TmStmpShift = '$date', Action = '$actions'"
                        . "where LastUpdate = '$import' and (LastManagementResult = '19' or LastManagementResult = '21' or "
                        . " LastManagementResult = '22' or LastManagementResult = '23') "
                        . "and Campaign = '$campaign' and (Action = 'Retirar base' or Action = 'Gestionado') and number > 0 "
                        . "order by id LIMIT $cantidad");
                        echo $recycle ? "Se recicló base para el asesor/a <b>" . $vAsesor . "</b> con éxito <br>" : "No se pudo realizar el reciclado de base <br>";
                    } else if ($estatus == "Rellamados") {
                        $recycle = ejecutarConsulta("update contactimportcontact set LastAgent = '$vAsesor', "
                                . "UserShift = '$vUser',TmStmpShift = '$date', Action = '$actions'"
                                . "where LastUpdate = '$import' and (LastManagementResult = '18' or LastManagementResult = '20') "
                                . "and Campaign = '$campaign' and (Action = 'Retirar base' or Action = 'Gestionado') and number > 0 "
                                . "order by id LIMIT $cantidad");
                        echo $recycle ? "Se recicló base para el asesor/a <b>" . $vAsesor . "</b> con éxito <br>" : "No se pudo realizar el reciclado de base <br>";
                    }
                }
            }
        } else if ($actions == "Retirar base") {
            for ($i = 0; $i < $longitud; $i++) {
                $vAsesor = trim($valor_array[$i]);
                if ($recycledType == "1") {
                    if ($estatus == "Regestionables") {
                        $recycle = ejecutarConsulta("update contactimportcontact set LastAgent = '', UserShift = '$vUser', "
                                . "TmStmpShift = '$date', Action = '$actions' "
                                . "where LastUpdate = '$import' and LastAgent like '%$vAsesor%' "
                                . "and (LastManagementResult >= '60' and  LastManagementResult <= '64') and number > 0 "
                                . "and (Action = 'Reciclar base' or Action = 'Gestionado') and Campaign = '$campaign' ");
                        if ($vAsesor != "") {
                            echo $recycle ? "Se retiró base para el asesor/a <b>" . $vAsesor . "</b> con éxito <br>" : "No se pudo realizar el reciclado de base <br>";
                        } else {
                            echo $recycle ? "Se retiró base con éxito" : "No se pudo retirar la base";
                        }
                    } else if ($estatus == "Rellamados") {
                        $recycle = ejecutarConsulta("update contactimportcontact set LastAgent = '', UserShift = '$vUser', "
                                . "TmStmpShift = '$date', Action = '$actions' "
                                . "where LastUpdate = '$import' and LastAgent like '%$vAsesor%' "
                                . "and LastManagementResult = '34' and number > 0 "
                                . "and (Action = 'Reciclar base' or Action = 'Gestionado') and Campaign = '$campaign' ");
                        if ($vAsesor != "") {
                            echo $recycle ? "Se retiró base para el asesor/a <b>" . $vAsesor . "</b> con éxito" : "No se pudo retirar la base <br>";
                        } else {
                            echo $recycle ? "Se retiró base con éxito" : "No se pudo retirar la base";
                        }
                    }
                } else if ($recycledType == "2") {
                    if ($estatus == "Regestionables") {
                        $recycle = ejecutarConsulta("update contactimportcontact set LastAgent = '', UserShift = '$vUser', "
                                . "TmStmpShift = '$date', Action = '$actions' "
                                . "where LastUpdate = '$import' and LastAgent like '%$vAsesor%' "
                                . "and (LastManagementResult = '19' or LastManagementResult = '21' or "
                                . "LastManagementResult = '22' or LastManagementResult = '23') and number > 0 "
                                . "and (Action = 'Reciclar base' or Action = 'Gestionado') and Campaign = '$campaign' ");
                        if ($vAsesor != "") {
                            echo $recycle ? "Se retiró base para el asesor/a <b>" . $vAsesor . "</b> con éxito" : "No se pudo retirar la base <br>";
                        } else {
                            echo $recycle ? "Se retiró base con éxito" : "No se pudo retirar la base";
                        }
                    } else if ($estatus == "Rellamados") {
                        $recycle = ejecutarConsulta("update contactimportcontact set LastAgent = '', UserShift = '$vUser', "
                                . "TmStmpShift = '$date', Action = '$actions' "
                                . "where LastUpdate = '$import' and LastAgent like '%$vAsesor%' "
                                . "and (LastManagementResult = '18' or LastManagementResult = '20') and number > 0 "
                                . "and (Action = 'Reciclar base' or Action = 'Gestionado') and Campaign = '$campaign' ");
                        if ($vAsesor != "") {
                            echo $recycle ? "Se retiró base para el asesor/a <b>" . $vAsesor . "</b> con éxito" : "No se pudo retirar la base <br>";
                        } else {
                            echo $recycle ? "Se retiró base con éxito" : "No se pudo retirar la base";
                        }
                    }
                }
            }
        }
        break;

    /*     * **********************************RECICLADO UNO A UNO******************************************************** */
    case 'selectAll':
        $campaign = isset($_POST['campaign']) ? LimpiarCadena($_POST["campaign"]) : "";
        $respuesta = $reciclar->selectAll($campaign); /* llama a la función del modelo */
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            $datos[] = array(/* llena los resultados con los datos */
                '<input type="checkbox" name="Id[\'' . $registrar->ID . '\']" id="Id[\'' . $registrar->ID . '\']" value="' . $registrar->ID . '" />',
//                "0" => $registrar->ID,
                "1" => $registrar->Name,
                "2" => $registrar->Identification,
                "3" => $registrar->Campaign,
                "4" => $registrar->LastManagementResult,
                "5" => $registrar->LastUpdate,
                "6" => $registrar->LastAgent,
                "7" => $registrar->Action
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

    case 'asignar':
        $asesor = isset($_POST['asesor']) ? LimpiarCadena($_POST["asesor"]) : "";
        foreach ($_POST["Id"] as $Id) {
            $result = ejecutarConsulta("SELECT LastManagementResult FROM `contactimportcontact` WHERE id = '$Id' ");
            $data = mysqli_fetch_array($result, MYSQLI_BOTH);
            if ($data['LastManagementResult'] == '') {
                $sql = ejecutarConsulta("UPDATE `contactimportcontact` SET `LastAgent`='$asesor',`TmStmpShift`='$date',`UserShift`='$vUser',`Action`='Asignar Base' WHERE ID = '$Id'");
            } else {
                $sql = ejecutarConsulta("UPDATE `contactimportcontact` SET `LastAgent`='$asesor',`TmStmpShift`='$date',`UserShift`='$vUser',`Action`='Reciclar Base' WHERE ID = '$Id'");
            }
        }
        echo $sql ? "Se recicló con éxito los registros" : "No se recicló";
        break;

    case 'retirar':
        foreach ($_POST["Id"] as $Id) {
            $sql = ejecutarConsulta("UPDATE `contactimportcontact` SET `LastAgent`= '',`TmStmpShift`='$date',`UserShift`='$vUser',`Action`='Retirar Base' WHERE ID = '$Id' ");
        }
        echo $sql ? "Se retiró con éxito los registros" : "No se retiró los registros";
        break;
}
?>