<?php

require '../config/connection.php';
session_start();
date_default_timezone_set("America/Lima");
$_SESSION['usu'];
$_SESSION['name'];
$_SESSION['state'];
$date = date('Y-m-d H:i:s');
$_SESSION['workgroup'];
$_SESSION['idSession'];
$_SESSION['vcc'];

$idstate = $_GET['estatus'];

ejecutarConsulta("INSERT INTO actorstatedetail(Actor, VirtualCC, Session, Profile, State, StartDate, "
        . "EndDate, TmStmp, Shift, UserShift) VALUES ('$_SESSION[usu]','$_SESSION[vcc]',"
        . "'$_SESSION[idSession]','$_SESSION[workgroup]','$idstate','$date','','$date','0','$_SESSION[usu]')");

ejecutarConsulta("UPDATE actorstatedetail SET EndDate='$date',TmStmp='$date', shift = '1', UserShift = '$_SESSION[usu]'
    WHERE Actor = '$_SESSION[usu]' and VirtualCC = '$_SESSION[vcc]' and session = '$_SESSION[idSession]' and "
        . "Profile = '$_SESSION[workgroup]' and State <> '$idstate' and EndDate = '0000-00-00 00:00:00' and shift = '0'");

$result = ejecutarConsulta("SELECT CampaignId FROM usercampaign where userid = '$_SESSION[usu]'");

while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
    $campaign = $row["CampaignId"];
    ejecutarConsulta("UPDATE actorcampaignstatedetail SET EndDate='$date',TmStmp='$date', shift = '1', UserShift = '$_SESSION[usu]'
    WHERE Actor = '$_SESSION[usu]' and VirtualCC = '$_SESSION[vcc]' and session = '$_SESSION[idSession]' and "
    . "Profile = '$_SESSION[workgroup]' and State <> '$idstate' and EndDate = '0000-00-00 00:00:00' and shift = '0'"
            . "and campaign = '$campaign'");

    ejecutarConsulta("INSERT INTO actorcampaignstatedetail(Actor, VirtualCC, Session, Profile, Campaign, State,"
            . " StartDate, EndDate, TmStmp, Shift, UserShift) VALUES ('$_SESSION[usu]','$_SESSION[vcc]',"
    . "'$_SESSION[idSession]','$_SESSION[workgroup]','$campaign','$idstate','$date','','$date','0','$_SESSION[usu]')");
}
?>

