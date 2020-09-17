<?php

session_start();

require '../models/ecuasistenciaEncuestaM.php';
$camp = new ecuasistenciaEncuestaM();
date_default_timezone_set("America/Lima");

$Id = isset($_POST["Id"]) ? LimpiarCadena5($_POST["Id"]) : ""; //Dato estraido de la funcion mostrar_uno js

$cedula = isset($_POST["cedula"]) ? LimpiarCadena5($_POST["cedula"]) : "";
$edad = isset($_POST["edad"]) ? LimpiarCadena5($_POST["edad"]) : "";
$sexo = isset($_POST["sexo"]) ? LimpiarCadena5($_POST["sexo"]) : "";
$estadoCivil = isset($_POST["estadoCivil"]) ? LimpiarCadena5($_POST["estadoCivil"]) : "";
$Agent = $_SESSION['usu'];
$Tmstmp = date('Y-m-d H:i:s');

$pregunta1 = isset($_POST["pregunta1"]) ? LimpiarCadena6($_POST["pregunta1"]) : "";
if (isset($_POST["chk_VEH1"]) == 'chk_VEH1') {
    $respuesta2_VEH1 = isset($_POST["respuesta2_VEH1"]) ? LimpiarCadena6($_POST["respuesta2_VEH1"]) : "";
} else {
    $respuesta2_VEH1 = "";
}
if (isset($_POST["chk_VEH2"]) == 'chk_VEH2') {
    $respuesta2_VEH2 = isset($_POST["respuesta2_VEH2"]) ? LimpiarCadena6($_POST["respuesta2_VEH2"]) : "";
} else {
    $respuesta2_VEH2 = "";
}
if (isset($_POST["chk_VEH3"]) == 'chk_VEH3') {
    $respuesta2_VEH3 = isset($_POST["respuesta2_VEH3"]) ? LimpiarCadena6($_POST["respuesta2_VEH3"]) : "";
} else {
    $respuesta2_VEH3 = "";
}
if (isset($_POST["chk_VEH4"]) == 'chk_VEH4') {
    $respuesta2_VEH4 = isset($_POST["respuesta2_VEH4"]) ? LimpiarCadena6($_POST["respuesta2_VEH4"]) : "";
} else {
    $respuesta2_VEH4 = "";
}
if (isset($_POST["chk_VEH5"]) == 'chk_VEH5') {
    $respuesta2_VEH5 = isset($_POST["respuesta2_VEH5"]) ? LimpiarCadena6($_POST["respuesta2_VEH5"]) : "";
} else {
    $respuesta2_VEH5 = "";
}
$pregunta2 = isset($_POST["pregunta2"]) ? LimpiarCadena6($_POST["pregunta2"]) : "";
$respuesta2 = isset($_POST["respuesta2"]) ? LimpiarCadena6($_POST["respuesta2"]) : "";


switch ($_GET["action"]) {
    case 'fechaInicio':
        date_default_timezone_set("America/Lima");
        echo(date('Y-m-d H:i:s'));
        break;

    case 'save':
        
        $sql = ejecutarConsulta6("INSERT INTO encuestaeasylife(Agent, StartedManagement, CEDULA, EDAD, SEXO, ESTADO_CIVIL, PREGUNTA1, PREGUNTA2, RESPUESTA1_VEH1, RESPUESTA1_VEH2, RESPUESTA1_VEH3, RESPUESTA1_VEH4, RESPUESTA1_VEH5, RESPUESTA2) values "
                . "( '$Agent','$Tmstmp', '$cedula', '$edad', '$sexo', '$estadoCivil', '$pregunta1','$pregunta2', '$respuesta2_VEH1', '$respuesta2_VEH2', '$respuesta2_VEH3', '$respuesta2_VEH4', '$respuesta2_VEH5','$respuesta2')");
       echo $sql ? "ENCUESTA ALMACENADA":"ENCUESTA NO ALMACENADA";
        break;
}
?>