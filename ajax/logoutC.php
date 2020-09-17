<?php

require '../config/connection.php';
session_start();
date_default_timezone_set("America/Lima");
$_SESSION['usu'];
$_SESSION['name'];
$_SESSION['state'];
$enddate = date('Y-m-d H:i:s');
$_SESSION['workgroup'];
$_SESSION['idSession'];

$deleteSession = ejecutarConsulta("DELETE FROM session WHERE "
//        . "SessionId = '$_SESSION[idSession]' and "
        . "Agent = '$_SESSION[usu]' ");

$vInsertState = ejecutarConsulta("INSERT INTO actorstatedetail(Actor, VirtualCC, Session, Profile, State, StartDate, "
        . "EndDate, TmStmp, Shift, UserShift) VALUES ('$_SESSION[usu]','$_SESSION[vcc]',"
        . "'$_SESSION[idSession]','$_SESSION[workgroup]','logout','$enddate','','$enddate','0','$_SESSION[usu]')");
//echo ($vInsertState);

$updateActorDetail = ejecutarConsulta("UPDATE actorstatedetail SET EndDate='$enddate',TmStmp='$enddate', "
        . "shift = '1', UserShift = '$_SESSION[usu]'WHERE Actor = '$_SESSION[usu]' and VirtualCC = '$_SESSION[vcc]'"
        . " and session = '$_SESSION[idSession]' and "
        . "Profile = '$_SESSION[workgroup]' and EndDate = '0000-00-00 00:00:00' and shift = '0'");

$result = ejecutarConsulta("SELECT CampaignId FROM usercampaign where userid = '$_SESSION[usu]'");

while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
    $campaign = $row["CampaignId"];
    ejecutarConsulta("UPDATE actorcampaignstatedetail SET EndDate='$enddate',TmStmp='$enddate', shift = '1', UserShift = '$_SESSION[usu]'
    WHERE Actor = '$_SESSION[usu]' and VirtualCC = '$_SESSION[vcc]' and session = '$_SESSION[idSession]' and "
    . "Profile = '$_SESSION[workgroup]' and EndDate = '0000-00-00 00:00:00' and shift = '0'"
            . "and campaign = '$campaign'");

    ejecutarConsulta("INSERT INTO actorcampaignstatedetail(Actor, VirtualCC, Session, Profile, Campaign, State,"
            . " StartDate, EndDate, TmStmp, Shift, UserShift) VALUES ('$_SESSION[usu]','$_SESSION[vcc]',"
    . "'$_SESSION[idSession]','$_SESSION[workgroup]','$campaign','logout','$enddate','$enddate','$enddate','0','$_SESSION[usu]')");
}
// -- eliminamos la sesión del usuario
if (isset($_SESSION['usu'])) {
    unset($_SESSION['usu']);
    unset($_SESSION['name']);
    unset($_SESSION['state']);
    unset($_SESSION['workgroup']);
    unset($_SESSION['idSession']);
}
if(isset($_SESSION['usu']) == false){
    session_regenerate_id();
}
session_destroy();
header('location: ../views/login.php');
exit();
?>
