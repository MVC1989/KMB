<?php

session_start();

require '../models/tarjetaPrincipalM.php';
$camp = new tarjetaPrincipalM();
date_default_timezone_set("America/Lima");

$IdCliente = isset($_POST["IdTCP"]) ? LimpiarCadena1($_POST["IdTCP"]) : "";
$Agent = $_SESSION['usu'];
$Tmstmp = date('Y-m-d H:i:s');
$IDENTIFICACIONTCP = isset($_POST["IDENTIFICACIONTCP"]) ? LimpiarCadena1($_POST["IDENTIFICACIONTCP"]) : "";
$NOMBRE1TCP = isset($_POST["NOMBRE1TCP"]) ? LimpiarCadena1($_POST["NOMBRE1TCP"]) : "";
$NOMBRE2TCP = isset($_POST["NOMBRE2TCP"]) ? LimpiarCadena1($_POST["NOMBRE2TCP"]) : "";
$APELLIDO1TCP = isset($_POST["APELLIDO1TCP"]) ? LimpiarCadena1($_POST["APELLIDO1TCP"]) : "";
$APELLIDO2TCP = isset($_POST["APELLIDO2TCP"]) ? LimpiarCadena1($_POST["APELLIDO2TCP"]) : "";
$provinciaNacTCP = isset($_POST["provinciaNacTCP"]) ? LimpiarCadena1($_POST["provinciaNacTCP"]) : "";
$ciudadNacTCP = isset($_POST["ciudadNacTCP"]) ? LimpiarCadena1($_POST["ciudadNacTCP"]) : "";
$estadoCivilTCP = isset($_POST["estadoCivilTCP"]) ? LimpiarCadena1($_POST["estadoCivilTCP"]) : "";
$generoTCP = isset($_POST["generoTCP"]) ? LimpiarCadena1($_POST["generoTCP"]) : "";
$fecNacTCP = isset($_POST["fecNacTCP"]) ? LimpiarCadena1($_POST["fecNacTCP"]) : "";
$edadTCP = isset($_POST["edadTCP"]) ? LimpiarCadena1($_POST["edadTCP"]) : "";
$emailTCP = isset($_POST["emailTCP"]) ? LimpiarCadena1($_POST["emailTCP"]) : "";
$celularTextTCP = isset($_POST["celularTextTCP"]) ? LimpiarCadena1($_POST["celularTextTCP"]) : "";
$celularTCP = isset($_POST["celularTCP"]) ? LimpiarCadena1($_POST["celularTCP"]) : "";
$celularTextTCP = isset($_POST["celularTextTCP"]) ? LimpiarCadena1($_POST["celularTextTCP"]) : "";
$celularTCP = isset($_POST["celularTCP"]) ? LimpiarCadena1($_POST["celularTCP"]) : "";
if ($celularTextTCP == "") {
    $celTCP = $celularTCP;
} else if ($celularTCP == "") {
    $celTCP = $celularTextTCP;
}
$telfTextTCP = isset($_POST["telfTextTCP"]) ? LimpiarCadena1($_POST["telfTextTCP"]) : "";
$telfTCP = isset($_POST["telfTCP"]) ? LimpiarCadena1($_POST["telfTCP"]) : "";
if ($telfTextTCP == "") {
    $telfDom = $telfTCP;
} else if ($telfTCP == "") {
    $telfDom = $telfTextTCP;
}
$CUPOTCP = isset($_POST["CUPOTCP"]) ? LimpiarCadena1($_POST["CUPOTCP"]) : "";
$pdpTCP = isset($_POST["pdpTCP"]) ? LimpiarCadena1($_POST["pdpTCP"]) : "";
$estadoctaTCP = isset($_POST["estadoctaTCP"]) ? LimpiarCadena1($_POST["estadoctaTCP"]) : "";
$nacionalidadTCP = isset($_POST["nacionalidadTCP"]) ? LimpiarCadena1($_POST["nacionalidadTCP"]) : "";
$paisTCP = isset($_POST["paisTCP"]) ? LimpiarCadena1($_POST["paisTCP"]) : "";
$contTCP = isset($_POST["contTCP"]) ? LimpiarCadena1($_POST["contTCP"]) : "";
$dirdomTCP = isset($_POST["dirdomTCP"]) ? LimpiarCadena1($_POST["dirdomTCP"]) : "";
$provinciaDomTCP = isset($_POST["provinciaDomTCP"]) ? LimpiarCadena1($_POST["provinciaDomTCP"]) : "";
$ciudadDomTCP = isset($_POST["ciudadDomTCP"]) ? LimpiarCadena1($_POST["ciudadDomTCP"]) : "";
$tipoVivTCP = isset($_POST["tipoVivTCP"]) ? LimpiarCadena1($_POST["tipoVivTCP"]) : "";
$cantonDomTCP = isset($_POST["cantonDomTCP"]) ? LimpiarCadena1($_POST["cantonDomTCP"]) : "";
$parroquiaDomTCP = isset($_POST["parroquiaDomTCP"]) ? LimpiarCadena1($_POST["parroquiaDomTCP"]) : "";
$principalDomTCP = isset($_POST["principalDomTCP"]) ? LimpiarCadena1($_POST["principalDomTCP"]) : "";
$secundariaDomTCP = isset($_POST["secundariaDomTCP"]) ? LimpiarCadena1($_POST["secundariaDomTCP"]) : "";
$numDomTCP = isset($_POST["numDomTCP"]) ? LimpiarCadena1($_POST["numDomTCP"]) : "";
$sectorDomTCP = isset($_POST["sectorDomTCP"]) ? LimpiarCadena1($_POST["sectorDomTCP"]) : "";
$refDomTCP = isset($_POST["refDomTCP"]) ? LimpiarCadena1($_POST["refDomTCP"]) : "";
$dirTrabTCP = isset($_POST["dirTrabTCP"]) ? LimpiarCadena1($_POST["dirTrabTCP"]) : "";
$provinciaTrabTCP = isset($_POST["provinciaTrabTCP"]) ? LimpiarCadena1($_POST["provinciaTrabTCP"]) : "";
$ciudadTrabTCP = isset($_POST["ciudadTrabTCP"]) ? LimpiarCadena1($_POST["ciudadTrabTCP"]) : "";
$cantonTrabTCP = isset($_POST["cantonTrabTCP"]) ? LimpiarCadena1($_POST["cantonTrabTCP"]) : "";
$parroquiaTrabTCP = isset($_POST["parroquiaTrabTCP"]) ? LimpiarCadena1($_POST["parroquiaTrabTCP"]) : "";
$principalTrabTCP = isset($_POST["principalTrabTCP"]) ? LimpiarCadena1($_POST["principalTrabTCP"]) : "";
$secundariaTrabTCP = isset($_POST["secundariaTrabTCP"]) ? LimpiarCadena1($_POST["secundariaTrabTCP"]) : "";
$numTrabTCP = isset($_POST["numTrabTCP"]) ? LimpiarCadena1($_POST["numTrabTCP"]) : "";
$sectorTrabTCP = isset($_POST["sectorTrabTCP"]) ? LimpiarCadena1($_POST["sectorTrabTCP"]) : "";
$refTrabTCP = isset($_POST["refTrabTCP"]) ? LimpiarCadena1($_POST["refTrabTCP"]) : "";
$telfTextTrabTCP = isset($_POST["telfTextTrabTCP"]) ? LimpiarCadena1($_POST["telfTextTrabTCP"]) : "";
$selectTrabTelf = isset($_POST["selectTrabTextTelf"]) ? LimpiarCadena1($_POST["selectTrabTextTelf"]) : "";
if ($telfTextTrabTCP == "") {
    $telfTrab = $selectTrabTelf;
} else if ($selectTrabTelf == "") {
    $telfTrab = $telfTextTrabTCP;
}
$situaLabTCP = isset($_POST["situaLabTCP"]) ? LimpiarCadena1($_POST["situaLabTCP"]) : "";
$empresaTCP = isset($_POST["empresaTCP"]) ? LimpiarCadena1($_POST["empresaTCP"]) : "";
$contratoTCP = isset($_POST["contratoTCP"]) ? LimpiarCadena1($_POST["contratoTCP"]) : "";
$fechaIniTCP = isset($_POST["fechaIniTCP"]) ? LimpiarCadena1($_POST["fechaIniTCP"]) : "";
$cargoTCP = isset($_POST["cargoTCP"]) ? LimpiarCadena1($_POST["cargoTCP"]) : "";
$sueldoTCP = isset($_POST["sueldoTCP"]) ? LimpiarCadena1($_POST["sueldoTCP"]) : "";
$gastosTCP = isset($_POST["gastosTCP"]) ? LimpiarCadena1($_POST["gastosTCP"]) : "";
$negocioTCP = isset($_POST["negocioTCP"]) ? LimpiarCadena1($_POST["negocioTCP"]) : "";
$ventasTCP = isset($_POST["ventasTCP"]) ? LimpiarCadena1($_POST["ventasTCP"]) : "";
$costoTCP = isset($_POST["costoTCP"]) ? LimpiarCadena1($_POST["costoTCP"]) : "";
$actEcoTCP = isset($_POST["actEcoTCP"]) ? LimpiarCadena1($_POST["actEcoTCP"]) : "";
$gastosOpeTCP = isset($_POST["gastosOpeTCP"]) ? LimpiarCadena1($_POST["gastosOpeTCP"]) : "";
$fechaIniNegTCP = isset($_POST["fechaIniNegTCP"]) ? LimpiarCadena1($_POST["fechaIniNegTCP"]) : "";
$perRefTCP = isset($_POST["perRefTCP"]) ? LimpiarCadena1($_POST["perRefTCP"]) : "";
$provinciaRefTCP = isset($_POST["provinciaRefTCP"]) ? LimpiarCadena1($_POST["provinciaRefTCP"]) : "";
$ciudadRefTCP = isset($_POST["ciudadRefTCP"]) ? LimpiarCadena1($_POST["ciudadRefTCP"]) : "";
$telfRefTCP = isset($_POST["telfRefTCP"]) ? LimpiarCadena1($_POST["telfRefTCP"]) : "";
$relacionCliTCP = isset($_POST["relacionCliTCP"]) ? LimpiarCadena1($_POST["relacionCliTCP"]) : "";
$lugarEntTCP = isset($_POST["lugarEntTCP"]) ? LimpiarCadena1($_POST["lugarEntTCP"]) : "";
$dirEntTCP = isset($_POST["dirEntTCP"]) ? LimpiarCadena1($_POST["dirEntTCP"]) : "";
$perContTCP = isset($_POST["perContTCP"]) ? LimpiarCadena1($_POST["perContTCP"]) : "";
$telfContTCP = isset($_POST["telfContTCP"]) ? LimpiarCadena1($_POST["telfContTCP"]) : "";
$horEntTCP = isset($_POST["horEntTCP"]) ? LimpiarCadena1($_POST["horEntTCP"]) : "";
$equipFutTCP = isset($_POST["equipFutTCP"]) ? LimpiarCadena1($_POST["equipFutTCP"]) : "";
$tipoOferta = isset($_POST["ofertaTDC"]) ? LimpiarCadena1($_POST["ofertaTDC"]) : "";
$CODIGO_CAMPANIA = isset($_POST["CODIGO_CAMPANIA"]) ? LimpiarCadena1($_POST["CODIGO_CAMPANIA"]) : "";
$cambioProdTCP = isset($_POST["cambioProdTCP"]) ? LimpiarCadena1($_POST["cambioProdTCP"]) : "";
if ($tipoOferta == "OFERTA 1") {
    $TipoTarjeta = isset($_POST["PROD_ESCENARIO_1"]) ? LimpiarCadena1($_POST["PROD_ESCENARIO_1"]) : "";
} else if ($tipoOferta == "OFERTA 3") {
    $TipoTarjeta = isset($_POST["PROD_TARJETA_EXCLUSIVA"]) ? LimpiarCadena1($_POST["PROD_TARJETA_EXCLUSIVA"]) : "";
}
$queryT = ejecutarConsulta("SELECT NumeroMarcado FROM `contactimportphone` WHERE `ContactId` = '$IdCliente' order by FechaHora desc limit 1");
$rowT = mysqli_fetch_array($queryT, MYSQLI_BOTH);
$contactAddress = $rowT["NumeroMarcado"];
$subestatus1TCP = isset($_POST["subestatus1TCP"]) ? LimpiarCadena1($_POST["subestatus1TCP"]) : "";
$subestatus2TCP = isset($_POST["subestatus2TCP"]) ? LimpiarCadena1($_POST["subestatus2TCP"]) : "";

switch ($_GET["action"]) {
    case 'cuidades':
        $provinciasTCP = $_GET["provinciasTCP"];
        $result = ejecutarConsulta1("SELECT distinct(ciudad) 'ciudad' FROM cat_ciudades"
                . " where provincia = '$provinciasTCP' ORDER BY ciudad");
        echo '<option></option>';
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            echo '<option value="' . $row["ciudad"] . '">' . $row["ciudad"] . '</option>';
        }
        break;
    case 'onlyCel':
        $idC = $_GET['idC'];
        $result = ejecutarConsulta("SELECT NumeroMarcado "
                . "FROM contactimportphone where contactid = '$idC'"
                . "and (NumeroMarcado like '09%' or NumeroMarcado like '9%')");

        echo '<option></option>';
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            echo '<option value="' . $row["NumeroMarcado"] . '">' . $row["NumeroMarcado"] . '</option>';
        }

        break;
    case 'onlyConv':
        $idC = $_GET['idC'];
        $result = ejecutarConsulta("SELECT NumeroMarcado "
                . "FROM contactimportphone where contactid = '$idC'"
                . "and (NumeroMarcado not like '09%' and NumeroMarcado not like '9%')");
        echo '<option></option>';
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            echo '<option value="' . $row["NumeroMarcado"] . '">' . $row["NumeroMarcado"] . '</option>';
        }

        break;
    case 'save':
        $sql = ejecutarConsulta1("SELECT CONTACTID FROM TCP WHERE CONTACTID = '$IdCliente' ");
        $valid = mysqli_fetch_array($sql, MYSQLI_BOTH);
        $numRowC = $sql->num_rows;
        if ($numRowC == 0) {
            $respuesta = $camp->insertTCP($IdCliente, $contactAddress, $Agent, $Tmstmp, $IDENTIFICACIONTCP, $NOMBRE1TCP, $NOMBRE2TCP, $APELLIDO1TCP, $APELLIDO2TCP, $provinciaNacTCP, $ciudadNacTCP, $estadoCivilTCP, $generoTCP, $fecNacTCP, $emailTCP, $celTCP, $telfDom, $CUPOTCP, $pdpTCP, $estadoctaTCP, $nacionalidadTCP, $paisTCP, $contTCP, $provinciaDomTCP, $ciudadDomTCP, $tipoVivTCP, $cantonDomTCP, $parroquiaDomTCP, $principalDomTCP, $secundariaDomTCP, $numDomTCP, $sectorDomTCP, $refDomTCP, $provinciaTrabTCP, $ciudadTrabTCP, $cantonTrabTCP, $parroquiaTrabTCP, $principalTrabTCP, $secundariaTrabTCP, $numTrabTCP, $sectorTrabTCP, $refTrabTCP, $telfTrab, $situaLabTCP, $empresaTCP, $contratoTCP, $fechaIniTCP, $cargoTCP, $sueldoTCP, $gastosTCP, $negocioTCP, $ventasTCP, $costoTCP, $actEcoTCP, $gastosOpeTCP, $fechaIniNegTCP, $perRefTCP, $provinciaRefTCP, $ciudadRefTCP, $telfRefTCP, $relacionCliTCP, $lugarEntTCP, $dirEntTCP, $perContTCP, $telfContTCP, $horEntTCP, $equipFutTCP, $TipoTarjeta, $tipoOferta, $CODIGO_CAMPANIA, $cambioProdTCP, $subestatus1TCP, $subestatus2TCP);
            echo $respuesta ? "Tarjeta Principal registrada" : "Error: Tarjeta Principal no se pudo registrar";
        }
        else{
            $respuesta = $camp->updateTCP($IdCliente, $contactAddress, $Agent, $Tmstmp, $IDENTIFICACIONTCP, $NOMBRE1TCP, $NOMBRE2TCP, $APELLIDO1TCP, $APELLIDO2TCP, $provinciaNacTCP, $ciudadNacTCP, $estadoCivilTCP, $generoTCP, $fecNacTCP, $emailTCP, $celTCP, $telfDom, $CUPOTCP, $pdpTCP, $estadoctaTCP, $nacionalidadTCP, $paisTCP, $contTCP, $provinciaDomTCP, $ciudadDomTCP, $tipoVivTCP, $cantonDomTCP, $parroquiaDomTCP, $principalDomTCP, $secundariaDomTCP, $numDomTCP, $sectorDomTCP, $refDomTCP, $provinciaTrabTCP, $ciudadTrabTCP, $cantonTrabTCP, $parroquiaTrabTCP, $principalTrabTCP, $secundariaTrabTCP, $numTrabTCP, $sectorTrabTCP, $refTrabTCP, $telfTrab, $situaLabTCP, $empresaTCP, $contratoTCP, $fechaIniTCP, $cargoTCP, $sueldoTCP, $gastosTCP, $negocioTCP, $ventasTCP, $costoTCP, $actEcoTCP, $gastosOpeTCP, $fechaIniNegTCP, $perRefTCP, $provinciaRefTCP, $ciudadRefTCP, $telfRefTCP, $relacionCliTCP, $lugarEntTCP, $dirEntTCP, $perContTCP, $telfContTCP, $horEntTCP, $equipFutTCP, $TipoTarjeta, $tipoOferta, $CODIGO_CAMPANIA, $cambioProdTCP, $subestatus1TCP, $subestatus2TCP);
            echo $respuesta ? "Tarjeta Principal actualizada" : "Error: Tarjeta Principal no se pudo actualizar";
        }
        break;
}
?>