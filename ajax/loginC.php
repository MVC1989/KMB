<?php

require '../config/connection.php';

// data sent from form login.php
$Id = isset($_POST["txtUsuario"]) ? LimpiarCadena($_POST["txtUsuario"]) : "";
$password = isset($_POST["txtPass"]) ? LimpiarCadena($_POST["txtPass"]) : "";

function desencriptar($texto) {
    $key = '';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
    list($encrypted_data, $iv) = explode('::', base64_decode($texto), 2);
	return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
}

$result = ejecutarConsultaSimple("SELECT u.Id, u.VCC, u.Name1, u.Name2, u.Surname1, u.Surname2, u.dateBirth, u.Password, u.State, u.UserGroup, u.Identification FROM user u WHERE u.Id = '$Id'");

// Variable $pass almacena la password del usuario
$pass = desencriptar($result['Password']);
/*
  verificamos que la clave ingresada es igual a la de la DB
 */
if ($_POST["txtPass"] == $pass) {
    if ($result['State'] == '1') {
        session_start();
        $idSession = session_id();
//    $session = ejecutarConsultaSimple("SELECT SessionId, VirtualCC, Agent, Estado, TmStmp FROM session WHERE Agent = '$Id'");
//    if ($session == "") { //validamos que no tenga sesión abierta en otro navegador
        date_default_timezone_set("America/Lima");
        $_SESSION['loggedin'] = true;
        $_SESSION['usu'] = $result['Id'];
        $_SESSION['name'] = $result['Name1'] . ' ' . $result['Surname1'];
        $_SESSION['start'] = date('Y-m-d H:i:s');
        $_SESSION['state'] = 'login';
        $_SESSION['workgroup'] = $result['UserGroup'];
        $_SESSION['idSession'] = $idSession;
        $_SESSION['vcc'] = $result['VCC'];
        $_SESSION['Identification'] = $result['Identification'];
        //$_SESSION['expire'] = $_SESSION['start'] + (1 * 60);
        echo "<script>location.href='../views/blank.php' </script>";
        ejecutarConsulta("INSERT INTO session(SessionId, VirtualCC, Agent, Estado, TmStmp) VALUES ('$_SESSION[idSession]','1','$_SESSION[usu]','$_SESSION[state]','$_SESSION[start]')");
        ejecutarConsulta("INSERT INTO actorstatedetail(Actor, VirtualCC, Session, Profile, State, StartDate, EndDate, TmStmp, Shift) VALUES ('$_SESSION[usu]','$_SESSION[vcc]','$_SESSION[idSession]','$_SESSION[workgroup]','$_SESSION[state]','$_SESSION[start]','NULL','$_SESSION[start]','0')");

        $UserGroup = ejecutarConsultaSimple("SELECT UserGroup from user where Id = '$_SESSION[usu]' ");
        if ($UserGroup == '3' || $UserGroup == '4') {
            $result = ejecutarConsultaSimple("SELECT CampaignId FROM usercampaign where userid = '$_SESSION[usu]'");
            if ($result['CampaignId'] != "") {
                while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                    $campaign = $row["CampaignId"];
                    ejecutarConsulta("INSERT INTO actorcampaignstatedetail(Actor, VirtualCC, Session, Profile, Campaign, State,"
                            . " StartDate, EndDate, TmStmp, Shift, UserShift) VALUES ('$_SESSION[usu]','$_SESSION[vcc]',"
                            . "'$_SESSION[idSession]','$_SESSION[workgroup]','$campaign','$_SESSION[state]','$_SESSION[start]','','$_SESSION[start]','0','$_SESSION[usu]')");
                }
            }
        }
//    } else {
//        echo "<script> alert('Usted ya se encuentra logueado en otro navegador!');
//                location.href='../views/login.php' 
//                </script>";
//    }
    } else {
        echo "<script> alert('Usuario inactivo, comuníquese con el administrador!');
            location.href='../views/login.php' 
            </script>";
    }
} else {
    echo "<script> alert('Usuario o contraseña son incorrectas!');
            location.href='../views/login.php' 
            </script>";
}
?>