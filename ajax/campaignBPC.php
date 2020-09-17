<?php

session_start();

require '../models/campaignBPM.php';
$camp = new campaingBPM();
date_default_timezone_set("America/Lima");

$Id = isset($_POST["Id"]) ? LimpiarCadena1($_POST["Id"]) : ""; //Dato estraido de la funcion mostrar_uno js

$IdCliente = isset($_POST["IDC"]) ? LimpiarCadena1($_POST["IDC"]) : "";
$Num = isset($_POST["fonos"]) ? LimpiarCadena1($_POST["fonos"]) : "";
$Agent = $_SESSION['usu'];
$Estado = isset($_POST["estatusTel"]) ? LimpiarCadena1($_POST["estatusTel"]) : "";
$Tmstmp = date('Y-m-d H:i:s');
$time = isset($_POST["horaInicio"]) ? LimpiarCadena1($_POST["horaInicio"]) : "";
$intentos = isset($_POST["intentos"]) ? LimpiarCadena1($_POST["intentos"]) : "";
$level1 = isset($_POST["level1"]) ? LimpiarCadena1($_POST["level1"]) : "";
$level2 = isset($_POST["level2"]) ? LimpiarCadena1($_POST["level2"]) : "";
$campaign = isset($_POST["CAMPANIA"]) ? LimpiarCadena1($_POST["CAMPANIA"]) : "";
$mangementCode = isset($_POST["code"]) ? LimpiarCadena1($_POST["code"]) : "";
$queryT = ejecutarConsulta("SELECT NumeroMarcado FROM `contactimportphone` WHERE `ContactId` = '$IdCliente' order by FechaHora desc limit 1");
$rowT = mysqli_fetch_array($queryT, MYSQLI_BOTH);
$contactAddress = $rowT["NumeroMarcado"];
$count = ejecutarConsultaSimple("select UUID() 'id'");
$InteractionId = $count['id'];
$contactname = isset($_POST["NOMBRE"]) ? LimpiarCadena1($_POST["NOMBRE"]) : "";
$FechaAgendamiento = isset($_POST["agenda"]) ? LimpiarCadena1($_POST["agenda"]) : "";
$TelefonoAd = isset($_POST["fonoAd"]) ? LimpiarCadena1($_POST["fonoAd"]) : "";
$Observaciones = isset($_POST["obs"]) ? LimpiarCadena1($_POST["obs"]) : "";
$tipoOferta = isset($_POST["of"]) ? LimpiarCadena1($_POST["of"]) : "";
$fechaV = isset($_POST["fechaV"]) ? LimpiarCadena1($_POST["fechaV"]) : "";
$horaV = isset($_POST["horaV"]) ? LimpiarCadena1($_POST["horaV"]) : "";
$tipoC = isset($_POST["tipoC"]) ? LimpiarCadena1($_POST["tipoC"]) : "";
$regionC = isset($_POST["regionC"]) ? LimpiarCadena1($_POST["regionC"]) : "";
$ciudadC = isset($_POST["ciudadC"]) ? LimpiarCadena1($_POST["ciudadC"]) : "";
$tipoOfC = isset($_POST["tipoOfC"]) ? LimpiarCadena1($_POST["tipoOfC"]) : "";
$agenciaC = isset($_POST["agenciaC"]) ? LimpiarCadena1($_POST["agenciaC"]) : "";
$tlfC = isset($_POST["tlfC"]) ? LimpiarCadena1($_POST["tlfC"]) : "";
$horarioC = isset($_POST["horarioC"]) ? LimpiarCadena1($_POST["horarioC"]) : "";
$direccionC = isset($_POST["direccionC"]) ? LimpiarCadena1($_POST["direccionC"]) : "";
$acepta = isset($_POST["acepta"]) ? LimpiarCadena1($_POST["acepta"]) : "";
$subestatus1 = isset($_POST["subestatus1"]) ? LimpiarCadena1($_POST["subestatus1"]) : "";
$subestatus2 = isset($_POST["subestatus2"]) ? LimpiarCadena1($_POST["subestatus2"]) : "";
$tipoCredito = isset($_POST["tip"]) ? LimpiarCadena1($_POST["tip"]) : "";
$telfFvt = isset($_POST["tlfFvt"]) ? LimpiarCadena1($_POST["tlfFvt"]) : "";
$dirFvt = isset($_POST["direccionFvt"]) ? LimpiarCadena1($_POST["direccionFvt"]) : "";
$nup = isset($_POST["NUPS"]) ? LimpiarCadena1($_POST["NUPS"]) : "";
$correoCliente = isset($_POST["CORREO1"]) ? LimpiarCadena1($_POST["CORREO1"]) : "";
$montoMail = isset($_POST["txtMonto"]) ? LimpiarCadena1($_POST["txtMonto"]) : "";

$producto = isset($_POST["producto"]) ? LimpiarCadena1($_POST["producto"]) : "";
$listadoProd = isset($_POST["listadoProd"]) ? LimpiarCadena1($_POST["listadoProd"]) : "";
$otroProd = isset($_POST["otroProd"]) ? LimpiarCadena1($_POST["otroProd"]) : "";

/* * ********************************************ENVIO DE MAILS******************************************** */
$cedulaMail = isset($_POST["IDENTIFICACION"]) ? LimpiarCadena1($_POST["IDENTIFICACION"]) : "";
if ($tipoOferta == 'OFERTA 1') {
    $productoMail = "CREDITO PRECISO"; //"Consumo";
    $montoMail = isset($_POST["txtMonto"]) ? LimpiarCadena1($_POST["txtMonto"]) : "";
//    $montoMail = isset($_POST["CREDITO_CONSUMO_ESCENARIO_1"]) ? LimpiarCadena1($_POST["CREDITO_CONSUMO_ESCENARIO_1"]) : "";
    $garanteMail = isset($_POST["GARANTE_CONSUMO_ESCENARIO_1"]) ? LimpiarCadena1($_POST["GARANTE_CONSUMO_ESCENARIO_1"]) : "";
} else if ($tipoOferta == 'OFERTA 2') {
    $productoMail = "CREDITO PRECISO"; //"Exclusivo";
    $montoMail = isset($_POST["txtMonto"]) ? LimpiarCadena1($_POST["txtMonto"]) : "";
//    $montoMail = isset($_POST["CREDITO_CONSUMO_EXCLUSIVO"]) ? LimpiarCadena1($_POST["CREDITO_CONSUMO_EXCLUSIVO"]) : "";
    $garanteMail = isset($_POST["GARANTE_CONSUMO_EXCLUSIVO"]) ? LimpiarCadena1($_POST["GARANTE_CONSUMO_EXCLUSIVO"]) : "";
} else if ($tipoOferta == 'OFERTA 4') {
    $productoMail = "CREDITO PRECISO"; //"Consumo Rol";
    $montoMail = isset($_POST["txtMonto"]) ? LimpiarCadena1($_POST["txtMonto"]) : "";
//    $montoMail = isset($_POST["CREDITO_CONSUMO_ROL"]) ? LimpiarCadena1($_POST["CREDITO_CONSUMO_ROL"]) : "";
    $garanteMail = isset($_POST["GARANTE_CONSUMO_ROL"]) ? LimpiarCadena1($_POST["GARANTE_CONSUMO_ROL"]) : "";
}
$onlyCell = ejecutarConsulta("SELECT NumeroMarcado FROM contactimportphone where contactid = '$IdCliente'"
        . "and (NumeroMarcado like '09%' or NumeroMarcado like '9%') limit 1");
$rowO = mysqli_fetch_array($onlyCell, MYSQLI_BOTH);
$celularMail = $rowO["NumeroMarcado"];
$onlyTelf = ejecutarConsulta("SELECT NumeroMarcado "
        . "FROM contactimportphone where contactid = '$IdCliente'"
        . "and (NumeroMarcado not like '09%' and NumeroMarcado not like '9%') limit 1");
$rowOT = mysqli_fetch_array($onlyTelf, MYSQLI_BOTH);
$telefonoMail = $rowOT["NumeroMarcado"];

switch ($_GET["action"]) {
    case 'selectAll':
        $respuesta = $camp->selectAll(); /* llama a la función del modelo */
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            $datos[] = array(/* llena los resultados con los datos */
                "0" => $registrar->ID, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                "1" => $registrar->CampaignId,
                "2" => $registrar->ImportId,
                "3" => $registrar->Agent,
                "4" => $registrar->CODIGO_CAMPANIA,
                "5" => $registrar->NOMBRE_CAMPANIA,
                "6" => $registrar->IDENTIFICACION,
                "7" => $registrar->NOMBRE,
                "8" => $registrar->ResultLevel2,
                "9" => '<a href="#" style="color: #3C8DBC;" onclick="mostrar_uno(\'' . $registrar->ID . '\')">Gestionar</a>',
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
            if ($registrar->managementresultcode == 34) {
                $datos[] = array(/* llena los resultados con los datos */
                    "0" => '<p style="color: red">' . $registrar->ID . '</p>', /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                    "1" => '<p style="color: red">' . $registrar->CampaignId . '</p>',
                    "2" => '<p style="color: red">' . $registrar->ImportId . '</p>',
                    "3" => '<p style="color: red">' . $registrar->Agent . '</p>',
                    "4" => '<p style="color: red">' . $registrar->CODIGO_CAMPANIA . '</p>',
                    "5" => '<p style="color: red">' . $registrar->NOMBRE_CAMPANIA . '</p>',
                    "6" => '<p style="color: red">' . $registrar->IDENTIFICACION . '</p>',
                    "7" => '<p style="color: red">' . $registrar->NOMBRE . '</p>',
                    "8" => '<p style="color: red">' . $registrar->ResultLevel2 . '</p>',
                    "9" => '<a href="#" style="color: #3C8DBC;" onclick="mostrar_uno(\'' . $registrar->ID . '\')">Gestionar</a>',
                );
            } else {
                $datos[] = array(/* llena los resultados con los datos */
                    "0" => $registrar->ID, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                    "1" => $registrar->CampaignId,
                    "2" => $registrar->ImportId,
                    "3" => $registrar->Agent,
                    "4" => $registrar->CODIGO_CAMPANIA,
                    "5" => $registrar->NOMBRE_CAMPANIA,
                    "6" => $registrar->IDENTIFICACION,
                    "7" => $registrar->NOMBRE,
                    "8" => $registrar->ResultLevel2,
                    "9" => '<a href="#" style="color: #3C8DBC;" onclick="mostrar_uno(\'' . $registrar->ID . '\')">Gestionar</a>',
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

    case 'insert':
        $respuesta = $camp->insert($Id, $name, $password, $state, $campGroup);
        echo $respuesta ? "Usuario registrado" : "Error: usuario no se pudo registrar";
        break;

    case 'update':
        $respuesta = $camp->update($Id, $name, $password, $state, $campGroup);
        echo $respuesta ? "Usuario actualizado" : "Error: usuario no se pudo actualizar";
        break;

    case 'estatus':
        $idcamp = $_GET['camp'];
        $result = ejecutarConsulta("SELECT distinct(level1) 'level1' "
                . "FROM campaignresultmanagement where campaignid = '$idcamp' ORDER BY Level1");
        echo '<option></option>';
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            echo"ingresa";
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
        $IdC = isset($_POST["IDC"]) ? LimpiarCadena1($_POST["IDC"]) : "";
        $respuesta = $camp->updateTelf($IdC, $Num, $Agent, $Estado, $Tmstmp);
        echo $respuesta ? "Teléfono gestionado con éxito" : "Error: no se pudo almacenar la información!";
        break;

    case 'validePhone';
        $IdClient = $_GET["IdClient"];
        $estadoTelf = ejecutarConsulta("SELECT distinct(estado)'estado' FROM `contactimportphone` WHERE contactid = '$IdClient'");
        $data = mysqli_fetch_array($estadoTelf, MYSQLI_BOTH);
        $numRow = $estadoTelf->num_rows;
        if ($numRow == "1" && $data["estado"] == "SG") {
            echo "Almacene un número de teléfono para continuar!";
        } else {
            echo "Si hay telefonos";
        }
        break;

    case 'cuidadAgencia':
        $regionC = $_GET["regionC"];
        $result = ejecutarConsulta1("SELECT distinct(ciudad) 'ciudad' FROM cat_agencias"
                . " where regional = '$regionC' ORDER BY ciudad");
        echo '<option></option>';
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            echo '<option value="' . $row["ciudad"] . '">' . $row["ciudad"] . '</option>';
        }
        break;

    case 'agencia':
        $regionC = $_GET["regionC"];
        $ciudadC = $_GET["ciudadC"];
        $tipoOfC = $_GET["tipoOfC"];
        $result = ejecutarConsulta1("SELECT distinct(agencia) 'agencia' FROM cat_agencias"
                . " where regional = '$regionC' and ciudad = '$ciudadC'"
                . " and tipooficina = '$tipoOfC' ORDER BY agencia");
        echo '<option></option>';
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            echo '<option value="' . $row["agencia"] . '">' . $row["agencia"] . '</option>';
        }
        break;

    case 'dirAgencia':
        $regionC = $_GET["regionC"];
        $ciudadC = $_GET["ciudadC"];
        $tipoOfC = $_GET["tipoOfC"];
        $agenciaC = $_GET["agenciaC"];
        $result = ejecutarConsulta1("SELECT direccion, horario, telefono FROM cat_agencias"
                . " where regional = '$regionC' and ciudad = '$ciudadC'"
                . " and tipooficina = '$tipoOfC' and agencia = '$agenciaC' ORDER BY agencia");
        $row = mysqli_fetch_array($result, MYSQLI_BOTH);
        echo '<b class="text-bold">Dirección</b>';
        echo '<input type="text" value ="' . $row["direccion"] . '" id="direccionC1" name="direccionC1" class="form-control" readonly/>';
        break;

    case 'horAgencia':
        $regionC = $_GET["regionC"];
        $ciudadC = $_GET["ciudadC"];
        $tipoOfC = $_GET["tipoOfC"];
        $agenciaC = $_GET["agenciaC"];
        $result = ejecutarConsulta1("SELECT direccion, horario, telefono FROM cat_agencias"
                . " where regional = '$regionC' and ciudad = '$ciudadC'"
                . " and tipooficina = '$tipoOfC' and agencia = '$agenciaC' ORDER BY agencia");
        $row = mysqli_fetch_array($result, MYSQLI_BOTH);
        echo '<b class="text-bold">Horario</b>';
        echo '<input type="text" value ="' . $row["horario"] . '" id="direccionC1" name="direccionC1" class="form-control" readonly/>';
        break;

    case 'telAgencia':
        $regionC = $_GET["regionC"];
        $ciudadC = $_GET["ciudadC"];
        $tipoOfC = $_GET["tipoOfC"];
        $agenciaC = $_GET["agenciaC"];
        $result = ejecutarConsulta1("SELECT direccion, horario, telefono FROM cat_agencias"
                . " where regional = '$regionC' and ciudad = '$ciudadC'"
                . " and tipooficina = '$tipoOfC' and agencia = '$agenciaC' ORDER BY agencia");
        $row = mysqli_fetch_array($result, MYSQLI_BOTH);
        echo '<b class="text-bold">Teléfono</b>';
        echo '<input type="text" value ="' . $row["telefono"] . '" id="direccionC1" name="direccionC1" class="form-control" readonly/>';
        break;

    case 'save':
        if ($IdCliente != "") {
            $saveById = ejecutarConsulta1("select contactid from gestionfinal where contactid = '$IdCliente'");
            $valid = mysqli_fetch_array($saveById, MYSQLI_BOTH);
            $numRowC = $saveById->num_rows;
            if ($numRowC == 0) {
                $camp->insertGestionFinal($IdCliente, $Agent, $level1, $level2, $mangementCode, $Tmstmp, $intentos, $contactname, $contactAddress, $InteractionId, $FechaAgendamiento, $TelefonoAd, $Observaciones, $time, $tipoOferta, $fechaV, $horaV, $tipoC, $regionC, $ciudadC, $agenciaC, $tlfC, $tipoOfC, $horarioC, $direccionC, $acepta, $subestatus1, $subestatus2, $tipoCredito, $telfFvt, $dirFvt, $producto, $listadoProd, $otroProd, $montoMail);
                $validarId = ejecutarConsultaSimple1("select contactid from gestionfinal where contactid = '$IdCliente'");
                if ($validarId["contactid"] != "") {
                    $camp->updateClientes($IdCliente, $Agent, $level1, $level2, $mangementCode, $Tmstmp, $intentos, $contactname, $contactAddress);
                    ejecutarConsulta("Update contactimportcontact set LastAgent = '$Agent', LastManagementResult = '$mangementCode', Number = '$intentos', Action = 'Gestionado' where id = '$IdCliente' ");
                    echo "Registro almacenado con éxito";
                } else {
                    echo "Error: registro no se pudo almacenar";
                }
                //$respuesta = $camp->deleteClientes($IdCliente);
                //$mail = $camp->envioCorreos($principalMail, $copiaMail, $contactname, $cedulaMail, $agenciaC, $productoMail, $montoMail, $garanteMail, $telefonoMail, $celularMail, $Observaciones);
            } else {
                $camp->updateGestionFinal($IdCliente, $Agent, $level1, $level2, $mangementCode, $Tmstmp, $intentos, $contactname, $contactAddress, $InteractionId, $FechaAgendamiento, $TelefonoAd, $Observaciones, $time, $tipoOferta, $fechaV, $horaV, $tipoC, $regionC, $ciudadC, $agenciaC, $tlfC, $tipoOfC, $horarioC, $direccionC, $acepta, $subestatus1, $subestatus2, $tipoCredito, $telfFvt, $dirFvt, $producto, $listadoProd, $otroProd, $montoMail);
                $validarId = ejecutarConsultaSimple1("select contactid from gestionfinal where contactid = '$IdCliente'");
                if ($validarId["contactid"] != "") {
                    $camp->updateClientes($IdCliente, $Agent, $level1, $level2, $mangementCode, $Tmstmp, $intentos, $contactname, $contactAddress);
                    ejecutarConsulta("Update contactimportcontact set LastAgent = '$Agent', LastManagementResult = '$mangementCode', Number = '$intentos', Action = 'Gestionado' where id = '$IdCliente' ");
                    echo "Registro actualizado con éxito";
                } else {
                    echo "Error: registro no se pudo actualizar";
                }
            }
        } else {
            echo "Error de almacenamiento";
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

    case 'provincias':
        $provincia = $_GET["provinciaTrabTCA"];
        $findProvincia = ejecutarConsulta1("SELECT Provincia FROM cat_provincias where provincia = '$provincia'");
        $row = mysqli_fetch_array($findProvincia, MYSQLI_BOTH);
        $provinciaCat = $row["Provincia"];

        $result = ejecutarConsulta1("SELECT id, Provincia FROM cat_provincias order by provincia");
        echo '<option value="' . $row["id"] . ' selected">' . $row["Provincia"] . '</option>';
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            if ($provinciaCat != $row["Provincia"]) {
                echo '<option value="' . $row["id"] . '">' . $row["Provincia"] . '</option>';
            }
        }
        break;

    case 'envioMail':
        $correos = ejecutarConsulta1("SELECT Mail FROM `cat_agencias` WHERE Agencia = '$agenciaC'");
        $json = [];
        while ($row = $correos->fetch_assoc()) {
            $json[] = $row['Mail'];
        }
        $principalMail = $json[0];
        $copiaMail = $json[1];
        $CC1 = ""; //"lrvelasp@pichincha.com";
        $CC2 = "supervisorcck@kimobill.com";
        $CC3 = "supervisorcci@kimobill.com";
        $CC4 = "fvt@kimobill.com";
        $envioMail = $camp->envioCorreos($IdCliente, $Agent, $Tmstmp, $contactname, $cedulaMail, $productoMail, $montoMail, $garanteMail, $telefonoMail, $celularMail, $Observaciones, $regionC, $ciudadC, $tipoC, $agenciaC, $nup, $correoCliente, $principalMail, $copiaMail, $CC1, $CC2, $CC3, $CC4);
        echo($envioMail);
        break;
}
?>