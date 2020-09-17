<?php

session_start();
require '../models/userCampaignM.php';
$userCamp = new userCampaignM();
date_default_timezone_set("America/Lima");
$date = date('Y-m-d H:i:s');

switch ($_GET["action"]) {
    case 'selectAll':
        $respuesta = $userCamp->selectAll(); /* llama a la función del modelo */
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            $datos[] = array(/* llena los resultados con los datos */
                '<input type="checkbox" name="Id[\'' . $registrar->Id . '\']" id="Id[\'' . $registrar->Id . '\']" value="' . $registrar->Id . '" />',
                "1" => $registrar->Id,
                "2" => $registrar->Name,
                "3" => $registrar->CampaignId
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

    case 'insert':
        $camp = $_POST["campaign"];
        if (isset($_POST["Id"])) {
            foreach ($_POST["Id"] as $Id) {
                $validateUser = ejecutarConsultaSimple("SELECT UserId,CampaignId FROM usercampaign WHERE UserId = '$Id' AND CampaignId = '$camp'");
                if ($validateUser['UserId'] == '') {
                    if (ejecutarConsulta("INSERT INTO usercampaign(UserId, VCC, CampaignId, TmStmp, UserShift) VALUES ('$Id',$_SESSION[vcc],'$camp','$date','$_SESSION[usu]')")) {
                        echo 'Asesor/a <b>' . strtoupper($Id) . '</b> se asignó exitosamente a la campaña <b>' . strtoupper($camp) . '</b><br>';
                        $query = ejecutarConsultaSimple("select userid from usercampaign where userid = '$Id' and campaignid = '$camp' ");
                        if ($query['userid'] != "") {
                            ejecutarConsulta("INSERT INTO actorcampaignstatedetail(Actor, VirtualCC, Session, Profile, "
                                    . "Campaign, State, StartDate, EndDate, TmStmp, Shift) VALUES ('$_SESSION[usu]','$_SESSION[vcc]',"
                                    . "'$_SESSION[idSession]','$_SESSION[workgroup]','$camp','$_SESSION[state]',"
                                    . "'$_SESSION[start]','NULL','$_SESSION[start]','0')");
                        }
                    } else {
                        echo 'Error: no se pudo asignar el usuario <b>' . strtoupper($Id) . ' a la campaña <b>' . strtoupper($camp) . '<br>';
                    }
                } else {
                    echo '<b>' . strtoupper($Id) . '</b> ya se encuentra asignado en la campaña <b>' . strtoupper($camp) . '</b><br>';
                }
            }
        }
        break;

    case 'delete':
        $camp = $_POST["campaign"];
        if (isset($_POST["Id"])) {
            foreach ($_POST["Id"] as $Id) {
                $validate = ejecutarConsulta("SELECT ID FROM contactimportcontact WHERE LastManagementResult = '' AND Action = 'Asignar Base' and LastAgent = '$Id' and campaign = '$camp' ");
                $numRowC = $validate->num_rows;
                if ($numRowC == 0) {
                    if (ejecutarConsulta("delete from usercampaign where userid = '$Id' and campaignid = '$camp' and vcc = '$_SESSION[vcc]'")) {
                        ejecutarConsulta("UPDATE actorcampaignstatedetail SET EndDate='$date',TmStmp='$date', shift = '1', "
                                . "UserShift = '$_SESSION[usu]' WHERE Actor = '$_SESSION[usu]' and VirtualCC = '$_SESSION[vcc]' "
                                . "and session = '$_SESSION[idSession]' and Profile = '$_SESSION[workgroup]' "
                                . " and campaign = '$camp' and EndDate = '0000-00-00 00:00:00' and shift = '0'");
                        //and State <> '$idstate'
                        echo 'Usuario <b>' . strtoupper($Id) . '</b> se retiró exitosamente a la campaña <b>' . strtoupper($camp) . '</b><br>';
                    }
                } else {
                    echo 'Para retirar al usuario <b>' . strtoupper($Id) . '</b> de la campaña <b>' . strtoupper($camp) . '</b>, retire la base aún asignada (' . $numRowC . ' registros)<br>';
                }
            }
        }
        break;
}
?>

