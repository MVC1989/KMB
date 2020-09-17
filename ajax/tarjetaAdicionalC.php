<?php

session_start();

require '../models/tarjetaAdicionalM.php';
$camp = new tarjetaAdicionalM();
date_default_timezone_set("America/Lima");

$IdCliente = isset($_POST["IdTCA"]) ? LimpiarCadena1($_POST["IdTCA"]) : "";
$Agent = $_SESSION['usu'];
$Tmstmp = date('Y-m-d H:i:s');
$queryT = ejecutarConsulta("SELECT NumeroMarcado FROM `contactimportphone` WHERE `ContactId` = '$IdCliente' order by FechaHora desc limit 1");
$rowT = mysqli_fetch_array($queryT, MYSQLI_BOTH);
$contactAddress = $rowT["NumeroMarcado"];

$cedulaTitularTCA = isset($_POST["cedulaTitularTCA"]) ? LimpiarCadena1($_POST["cedulaTitularTCA"]) : "";
$nombresTitularTCA = isset($_POST["nombresTitularTCA"]) ? LimpiarCadena1($_POST["nombresTitularTCA"]) : "";
$ESTADO_CIVILTCA = isset($_POST["ESTADO_CIVILTCA"]) ? LimpiarCadena1($_POST["ESTADO_CIVILTCA"]) : "";
$generoTCA = isset($_POST["generoTCA"]) ? LimpiarCadena1($_POST["generoTCA"]) : "";
$LUGARNACTCA = isset($_POST["LUGARNACTCA"]) ? LimpiarCadena1($_POST["LUGARNACTCA"]) : "";
$FECHA_NACIMIENTOTCA = isset($_POST["FECHA_NACIMIENTOTCA"]) ? LimpiarCadena1($_POST["FECHA_NACIMIENTOTCA"]) : "";
$ACTECOTCA = isset($_POST["ACTECOTCA"]) ? LimpiarCadena1($_POST["ACTECOTCA"]) : "";
$CORREOTCA = isset($_POST["CORREOTCA"]) ? LimpiarCadena1($_POST["CORREOTCA"]) : "";
$celularTextTCA = isset($_POST["celularTextTCA"]) ? LimpiarCadena1($_POST["celularTextTCA"]) : "";
$celularTCA = isset($_POST["celularTCA"]) ? LimpiarCadena1($_POST["celularTCA"]) : "";
if ($celularTextTCA == "") {
    $celTCP = $celularTCA;
} else if ($celularTCA == "") {
    $celTCP = $celularTextTCA;
}
$provinciaTrabTCA = isset($_POST["provinciaTrabTCA"]) ? LimpiarCadena1($_POST["provinciaTrabTCA"]) : "";
$ciudadTrabTCA = isset($_POST["ciudadTrabTCA"]) ? LimpiarCadena1($_POST["ciudadTrabTCA"]) : "";
$principalTrabTCA = isset($_POST["principalTrabTCA"]) ? LimpiarCadena1($_POST["principalTrabTCA"]) : "";
$secundariaTrabTCA = isset($_POST["secundariaTrabTCA"]) ? LimpiarCadena1($_POST["secundariaTrabTCA"]) : "";
$numTrabTCA = isset($_POST["numTrabTCA"]) ? LimpiarCadena1($_POST["numTrabTCA"]) : "";
$sectorTrabTCA = isset($_POST["sectorTrabTCA"]) ? LimpiarCadena1($_POST["sectorTrabTCA"]) : "";
$refTrabTCA = isset($_POST["refTrabTCA"]) ? LimpiarCadena1($_POST["refTrabTCA"]) : "";
$tipoLugarTCA = isset($_POST["tipoLugarTCA"]) ? LimpiarCadena1($_POST["tipoLugarTCA"]) : "";
$dirConcTrabTCA = isset($_POST["dirConcTrabTCA"]) ? LimpiarCadena1($_POST["dirConcTrabTCA"]) : "";
$telfTextTrabTCA = isset($_POST["telfTextTrabTCA"]) ? LimpiarCadena1($_POST["telfTextTrabTCA"]) : "";
$selectTrabTextTelfTCA = isset($_POST["selectTrabTextTelfTCA"]) ? LimpiarCadena1($_POST["selectTrabTextTelfTCA"]) : "";
if ($telfTextTrabTCA == "") {
    $telfTrab = $selectTrabTextTelfTCA;
} else if ($selectTrabTextTelfTCA == "") {
    $telfTrab = $telfTextTrabTCA;
}
$provinciaDomTCA = isset($_POST["provinciaDomTCA"]) ? LimpiarCadena1($_POST["provinciaDomTCA"]) : "";
$ciudadDomTCA = isset($_POST["ciudadDomTCA"]) ? LimpiarCadena1($_POST["ciudadDomTCA"]) : "";
$principalDomTCA = isset($_POST["principalDomTCA"]) ? LimpiarCadena1($_POST["principalDomTCA"]) : "";
$secundariaDomTCA = isset($_POST["secundariaDomTCA"]) ? LimpiarCadena1($_POST["secundariaDomTCA"]) : "";
$numDomTCA = isset($_POST["numDomTCA"]) ? LimpiarCadena1($_POST["numDomTCA"]) : "";
$sectorDomTCA = isset($_POST["sectorDomTCA"]) ? LimpiarCadena1($_POST["sectorDomTCA"]) : "";
$refDomTCA = isset($_POST["refDomTCA"]) ? LimpiarCadena1($_POST["refDomTCA"]) : "";
$tipoLugarDOMTCA = isset($_POST["tipoLugarDOMTCA"]) ? LimpiarCadena1($_POST["tipoLugarDOMTCA"]) : "";
$dirConcDomTCA = isset($_POST["dirConcDomTCA"]) ? LimpiarCadena1($_POST["dirConcDomTCA"]) : "";
$telfTextTCA = isset($_POST["telfTextTCA"]) ? LimpiarCadena1($_POST["telfTextTCA"]) : "";
$telfTCA = isset($_POST["telfTCA"]) ? LimpiarCadena1($_POST["telfTCA"]) : "";
if ($telfTextTCA == "") {
    $telfDom = $telfTCA;
} else if ($telfTCA == "") {
    $telfDom = $telfTextTCA;
}
$tipoIdentificacionTCA = isset($_POST["tipoIdentificacionTCA"]) ? LimpiarCadena1($_POST["tipoIdentificacionTCA"]) : "";
$nacionalidadTCA = isset($_POST["nacionalidadTCA"]) ? LimpiarCadena1($_POST["nacionalidadTCA"]) : "";
$IDENTIFICACIONTCA = isset($_POST["IDENTIFICACIONTCA"]) ? LimpiarCadena1($_POST["IDENTIFICACIONTCA"]) : "";
$NOMBRE1TCA = isset($_POST["NOMBRE1TCA"]) ? LimpiarCadena1($_POST["NOMBRE1TCA"]) : "";
$NOMBRE2TCA = isset($_POST["NOMBRE2TCA"]) ? LimpiarCadena1($_POST["NOMBRE2TCA"]) : "";
$APELLIDO1TCA = isset($_POST["APELLIDO1TCA"]) ? LimpiarCadena1($_POST["APELLIDO1TCA"]) : "";
$APELLIDO2TCA = isset($_POST["APELLIDO2TCA"]) ? LimpiarCadena1($_POST["APELLIDO2TCA"]) : "";
$nombreTarjetaTCA = isset($_POST["nombreTarjetaTCA"]) ? LimpiarCadena1($_POST["nombreTarjetaTCA"]) : "";
$FECHA_NACIMIENTOADITCA = isset($_POST["FECHA_NACIMIENTOADITCA"]) ? LimpiarCadena1($_POST["FECHA_NACIMIENTOADITCA"]) : "";
$cupoTCA = isset($_POST["cupoTCA"]) ? LimpiarCadena1($_POST["cupoTCA"]) : "";
$tarjetaTitularTCA = isset($_POST["tarjetaTitularTCA"]) ? LimpiarCadena1($_POST["tarjetaTitularTCA"]) : "";
$generoPerTCA = isset($_POST["generoPerTCA"]) ? LimpiarCadena1($_POST["generoPerTCA"]) : "";
$estadoCivilPerTCA = isset($_POST["estadoCivilPerTCA"]) ? LimpiarCadena1($_POST["estadoCivilPerTCA"]) : "";
$parentezcoTCA = isset($_POST["parentezcoTCA"]) ? LimpiarCadena1($_POST["parentezcoTCA"]) : "";
$lugarEntTCA = isset($_POST["lugarEntTCA"]) ? LimpiarCadena1($_POST["lugarEntTCA"]) : "";
$ranVisTCA = isset($_POST["ranVisTCA"]) ? LimpiarCadena1($_POST["ranVisTCA"]) : "";
$estadoctaTCA = isset($_POST["estadoctaTCA"]) ? LimpiarCadena1($_POST["estadoctaTCA"]) : "";
$pdpTCA = isset($_POST["pdpTCA"]) ? LimpiarCadena1($_POST["pdpTCA"]) : "";
$personaContactoTCA = isset($_POST["personaContactoTCA"]) ? LimpiarCadena1($_POST["personaContactoTCA"]) : "";
$subestatus1TCA = isset($_POST["subestatus1TCA"]) ? LimpiarCadena1($_POST["subestatus1TCA"]) : "";
$subestatus2TCA = isset($_POST["subestatus2TCA"]) ? LimpiarCadena1($_POST["subestatus2TCA"]) : "";

switch ($_GET["action"]) {
    case 'provinciaTrab':
        $provincia = $_GET["provinciaTrabTCA"];
        $findProvincia = ejecutarConsulta1("SELECT id,Provincia FROM cat_provincias where provincia = '$provincia'");
        $row = mysqli_fetch_array($findProvincia, MYSQLI_BOTH);
        $provinciaCat = $row["Provincia"];
        echo '<option value="' . $row["id"] . ' selected">' . $row["Provincia"] . '</option>';
        $result = ejecutarConsulta1("SELECT id, Provincia FROM cat_provincias order by provincia");
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            if ($provinciaCat != $row["Provincia"]) {
                echo '<option value="' . $row["id"] . '">' . $row["Provincia"] . '</option>';
            }
        }
        break;

    case 'cuidadTrab':
        $provinciasTCA = $_GET["provinciaTrabTCA"];
        $ciudad = $_GET["ciudadTrabTCA"];
        $findCiudad = ejecutarConsulta1("SELECT distinct(ciudad)'ciudad' FROM cat_ciudades where ciudad = '$ciudad'");
        $row = mysqli_fetch_array($findCiudad, MYSQLI_BOTH);
        $ciudadCat = $row["ciudad"];
        echo '<option value="' . $row["ciudad"] . ' selected">' . $row["ciudad"] . '</option>';
        $res = ejecutarConsulta1("select distinct(id) 'id' from cat_provincias where provincia = '$provinciasTCA'");
        echo("select distinct(id) 'id' from cat_provincias where provincia = '$provinciasTCA'");
        $data = mysqli_fetch_array($res, MYSQLI_BOTH);
        $idProv = $data["id"];
        $result = ejecutarConsulta1("SELECT distinct(ciudad) 'ciudad' FROM cat_ciudades"
                . " where provincia = '$idProv' ORDER BY ciudad");
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            if ($ciudadCat != $row["ciudad"]) {
                echo '<option value="' . $row["ciudad"] . '">' . $row["ciudad"] . '</option>';
            }
        }
        break;

    case 'cuidades':
        $provinciasTCA = $_GET["provinciasTCA"];
        $result = ejecutarConsulta1("SELECT distinct(ciudad) 'ciudad' FROM cat_ciudades"
                . " where provincia = '$provinciasTCA' ORDER BY ciudad");
        echo '<option></option>';
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            echo '<option value="' . $row["ciudad"] . '">' . $row["ciudad"] . '</option>';
        }
        break;

    case 'provinciaDom':
        $provincia = $_GET["provinciaDomTCA"];
        $findProvincia = ejecutarConsulta1("SELECT id,Provincia FROM cat_provincias where provincia = '$provincia'");
        $row = mysqli_fetch_array($findProvincia, MYSQLI_BOTH);
        $provinciaCat = $row["Provincia"];
        echo '<option value="' . $row["id"] . ' selected">' . $row["Provincia"] . '</option>';
        $result = ejecutarConsulta1("SELECT id, Provincia FROM cat_provincias order by provincia");
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            if ($provinciaCat != $row["Provincia"]) {
                echo '<option value="' . $row["id"] . '">' . $row["Provincia"] . '</option>';
            }
        }
        break;

    case 'cuidadDom':
        $provinciasTCA = $_GET["provinciaDomTCA"];
        $ciudad = $_GET["ciudadDomTCA"];
        $findCiudad = ejecutarConsulta1("SELECT distinct(ciudad)'ciudad' FROM cat_ciudades where ciudad = '$ciudad'");
        $row = mysqli_fetch_array($findCiudad, MYSQLI_BOTH);
        $ciudadCat = $row["ciudad"];
        echo '<option value="' . $row["ciudad"] . ' selected">' . $row["ciudad"] . '</option>';
        $res = ejecutarConsulta1("select distinct(id) 'id' from cat_provincias where provincia = '$provinciasTCA'");
        echo("select distinct(id) 'id' from cat_provincias where provincia = '$provinciasTCA'");
        $data = mysqli_fetch_array($res, MYSQLI_BOTH);
        $idProv = $data["id"];
        $result = ejecutarConsulta1("SELECT distinct(ciudad) 'ciudad' FROM cat_ciudades"
                . " where provincia = '$idProv' ORDER BY ciudad");
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            if ($ciudadCat != $row["ciudad"]) {
                echo '<option value="' . $row["ciudad"] . '">' . $row["ciudad"] . '</option>';
            }
        }
        break;

    case 'save':
        $sql = ejecutarConsulta1("SELECT CONTACTID FROM TCA WHERE CONTACTID = '$IdCliente' AND Identificacion = '$IDENTIFICACIONTCA' ");
        $valid = mysqli_fetch_array($sql, MYSQLI_BOTH);
        $numRowC = $sql->num_rows;
        if ($numRowC == 0) {
            $respuesta = $camp->insertTCA($IdCliente, $contactAddress, $Agent, $Tmstmp, $cedulaTitularTCA, $nombresTitularTCA, $ESTADO_CIVILTCA, $generoTCA, $LUGARNACTCA, $FECHA_NACIMIENTOTCA, $ACTECOTCA, $provinciaTrabTCA, $ciudadTrabTCA, $principalTrabTCA, $numTrabTCA, $secundariaTrabTCA, $sectorTrabTCA, $tipoLugarTCA, $refTrabTCA, $dirConcTrabTCA, $provinciaDomTCA, $ciudadDomTCA, $principalDomTCA, $numDomTCA, $secundariaDomTCA, $sectorDomTCA, $tipoLugarDOMTCA, $refDomTCA, $dirConcDomTCA, $tipoIdentificacionTCA, $IDENTIFICACIONTCA, $nacionalidadTCA, $APELLIDO1TCA, $APELLIDO2TCA, $NOMBRE1TCA, $NOMBRE2TCA, $nombreTarjetaTCA, $FECHA_NACIMIENTOADITCA, $generoPerTCA, $estadoCivilPerTCA, $parentezcoTCA, $tarjetaTitularTCA, $cupoTCA, $lugarEntTCA, $ranVisTCA, $CORREOTCA, $personaContactoTCA, $celTCP, $telfTextTrabTCA, $telfDom, $estadoctaTCA, $pdpTCA, $subestatus1TCA, $subestatus2TCA);
            echo $respuesta ? "Tarjeta Adicional registrada" : "Error: Tarjeta Adicional no se pudo registrar";
        } else {
            $respuesta = $camp->updateTCA($IdCliente, $contactAddress, $Agent, $Tmstmp, $cedulaTitularTCA, $nombresTitularTCA, $ESTADO_CIVILTCA, $generoTCA, $LUGARNACTCA, $FECHA_NACIMIENTOTCA, $ACTECOTCA, $provinciaTrabTCA, $ciudadTrabTCA, $principalTrabTCA, $numTrabTCA, $secundariaTrabTCA, $sectorTrabTCA, $tipoLugarTCA, $refTrabTCA, $dirConcTrabTCA, $provinciaDomTCA, $ciudadDomTCA, $principalDomTCA, $numDomTCA, $secundariaDomTCA, $sectorDomTCA, $tipoLugarDOMTCA, $refDomTCA, $dirConcDomTCA, $tipoIdentificacionTCA, $IDENTIFICACIONTCA, $nacionalidadTCA, $APELLIDO1TCA, $APELLIDO2TCA, $NOMBRE1TCA, $NOMBRE2TCA, $nombreTarjetaTCA, $FECHA_NACIMIENTOADITCA, $generoPerTCA, $estadoCivilPerTCA, $parentezcoTCA, $tarjetaTitularTCA, $cupoTCA, $lugarEntTCA, $ranVisTCA, $CORREOTCA, $personaContactoTCA, $celTCP, $telfTextTrabTCA, $telfDom, $estadoctaTCA, $pdpTCA, $subestatus1TCA, $subestatus2TCA);
            echo $respuesta ? "Tarjeta Adicional actualizada" : "Error: Tarjeta Adicional no se pudo actualizar";
        }
        break;
    
    case 'selectAll':
        $Id = $_GET["idTitular"];
        $result = $camp->selectAll($Id); /* llama a la función del modelo */
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = mysqli_fetch_array($result, MYSQLI_BOTH)) { /* recorre el array */
            //var_dump($registrar);
            $datos[] = array(/* llena los resultados con los datos */
                "0" => $registrar["ContactId"],
                "1" => $registrar["Identificacion"],
                "2" => $registrar["PrimerNombre"],
                "3" => $registrar["PrimerApellido"],
                "4" => $registrar["NombreTarjeta"],
                "5" => $registrar["Cupo"],
                "6" => '<a href="#" style="color: #3C8DBC;" onclick="editar(\'' . $registrar["ContactId"] . '\')"></a>',
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
        
    case 'validaTCA':
        $idC = $_GET["IdClient"];
        $sql = ejecutarConsulta1("SELECT CONTACTID FROM TCA WHERE CONTACTID = '$idC'");
        $valid = mysqli_fetch_array($sql, MYSQLI_BOTH);
        $numRowC = $sql->num_rows;
        if ($numRowC == 0) {
            echo "No hay datos";
        } else {
            echo "Si hay datos";
        }
        break;
}
?>