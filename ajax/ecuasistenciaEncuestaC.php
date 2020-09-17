<?php

session_start();

require '../models/ecuasistenciaEncuestaM.php';
$camp = new ecuasistenciaEncuestaM();
date_default_timezone_set("America/Lima");

$Id = isset($_POST["Id"]) ? LimpiarCadena5($_POST["Id"]) : ""; //Dato estraido de la funcion mostrar_uno js

$IdCliente = isset($_POST["IDC"]) ? LimpiarCadena5($_POST["IDC"]) : "";
$Num = isset($_POST["fonos"]) ? LimpiarCadena5($_POST["fonos"]) : "";
$Agent = $_SESSION['usu'];
$Estado = isset($_POST["estatusTel"]) ? LimpiarCadena5($_POST["estatusTel"]) : "";
$Tmstmp = date('Y-m-d H:i:s');
$time = isset($_POST["horaInicio"]) ? LimpiarCadena5($_POST["horaInicio"]) : "";
$intentos = isset($_POST["intentos"]) ? LimpiarCadena5($_POST["intentos"]) : "";
$level1 = isset($_POST["level1"]) ? LimpiarCadena5($_POST["level1"]) : "";
$level2 = isset($_POST["level2"]) ? LimpiarCadena5($_POST["level2"]) : "";
$level3 = isset($_POST["level3"]) ? LimpiarCadena2($_POST["level3"]) : "";
$campaign = isset($_POST["CAMPANIA"]) ? LimpiarCadena5($_POST["CAMPANIA"]) : "";
$mangementCode = isset($_POST["code"]) ? LimpiarCadena12($_POST["code"]) : "";
$queryT = ejecutarConsulta("SELECT NumeroMarcado FROM contactimportphone WHERE ContactId = '$IdCliente' order by FechaHoraFin desc limit 1");
$rowT = mysqli_fetch_array($queryT, MYSQLI_BOTH);
$contactAddress = $rowT["NumeroMarcado"];
if ($level1 == 'DB' && $level2 = 'DADO DE BAJA POR NO VENTA'){
    $interactionId = isset($_POST["interactionIdOld"]) ? LimpiarCadena5($_POST["interactionIdOld"]) : "";
} else {
    $interactionId = isset($_POST["interactionId"]) ? LimpiarCadena5($_POST["interactionId"]) : "";
}
$contactname = isset($_POST["ASISTENCIA"]) ? LimpiarCadena5($_POST["ASISTENCIA"]) : "";
$FechaAgendamiento = isset($_POST["agenda"]) ? LimpiarCadena5($_POST["agenda"]) : "";
$TelefonoAd = isset($_POST["fonoAd"]) ? LimpiarCadena5($_POST["fonoAd"]) : "";
$Observaciones = isset($_POST["obs"]) ? LimpiarCadena6($_POST["obs"]) : "";
$TIPO_CONTRATO = isset($_POST["TIPO_CONTRATO"]) ? LimpiarCadena6($_POST["TIPO_CONTRATO"]) : "";
$pregunta1 = isset($_POST["pregunta1"]) ? LimpiarCadena6($_POST["pregunta1"]) : "";
$respuesta1 = isset($_POST["respuesta1"]) ? LimpiarCadena6($_POST["respuesta1"]) : "";
$pregunta1_1 = isset($_POST["pregunta1_1"]) ? LimpiarCadena6($_POST["pregunta1_1"]) : "";
$respuesta1_1 = isset($_POST["respuesta1_1"]) ? LimpiarCadena6($_POST["respuesta1_1"]) : "";
$pregunta2 = isset($_POST["pregunta2"]) ? LimpiarCadena6($_POST["pregunta2"]) : "";
$respuesta2 = isset($_POST["respuesta2"]) ? LimpiarCadena6($_POST["respuesta2"]) : "";
$pregunta2_1 = isset($_POST["pregunta2_1"]) ? LimpiarCadena6($_POST["pregunta2_1"]) : "";
$pregunta1_ANT = "";
$respuesta1_ANT = "";
$pregunta2_ANT = "";
$respuesta2_ANT = "";
$pregunta3_ANT = "";
$respuesta3_ANT = "";
$pregunta4_ANT = "";
$respuesta4_ANT = "";
$pregunta5_ANT = "";
$respuesta5_ANT = "";
$pregunta6_ANT = "";
$respuesta6_ANT = "";
$pregunta6_1_ANT = "";
$respuesta6_1_ANT = "";
$pregunta7_ANT = "";
$respuesta7_ANT = "";
$pregunta7_1_ANT = "";
$respuesta7_1_ANT = "";
$pregunta8_ANT = "";
$respuesta8_ANT = "";
$pregunta8_1_ANT = "";
$respuesta8_1_ANT = "";
$pregunta9_ANT = "";
$respuesta9_ANT = "";
$pregunta9_1_ANT = "";
$respuesta9_1_ANT = "";
$pregunta10_ANT = "";
$respuesta10_ANT = "";
$pregunta11_ANT = "";
$respuesta11_ANT = "";
$pregunta1_VEH_EQ = "";
$respuesta1_VEH_EQ = "";
$pregunta2_VEH_EQ = "";
$respuesta2_VEH_EQ = "";
$pregunta3_VEH_EQ = "";
$respuesta3_VEH_EQ = "";
$pregunta4_VEH_EQ = "";
$respuesta4_VEH_EQ = "";
$pregunta5_VEH_EQ = "";
$respuesta5_VEH_EQ = "";
$pregunta5_1_VEH_EQ = "";
$respuesta5_1_VEH_EQ = "";
$pregunta6_VEH_EQ = "";
$respuesta6_VEH_EQ = "";
$pregunta6_1_VEH_EQ = "";
$respuesta6_1_VEH_EQ = "";
$pregunta7_VEH_EQ = "";
$respuesta7_VEH_EQ = "";
$pregunta7_1_VEH_EQ = "";
$respuesta7_1_VEH_EQ = "";
$pregunta8_VEH_EQ = "";
$respuesta8_VEH_EQ = "";
$respuesta8_1_VEH_EQ = "";
$pregunta8_1_VEH_EQ = "";
$pregunta9_VEH_EQ = "";
$respuesta9_VEH_EQ = "";
$pregunta10_VEH_EQ = "";
$respuesta10_VEH_EQ = "";
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
if (isset($_POST["chk_VEH6"]) == 'chk_VEH6') {
    $respuesta2_VEH6 = isset($_POST["respuesta2_VEH6"]) ? LimpiarCadena6($_POST["respuesta2_VEH6"]) : "";
} else {
    $respuesta2_VEH6 = "";
}
if (isset($_POST["chk_HOG1"]) == 'chk_HOG1') {
    $respuesta2_HOG1 = isset($_POST["respuesta2_HOG1"]) ? LimpiarCadena6($_POST["respuesta2_HOG1"]) : "";
} else {
    $respuesta2_HOG1 = "";
}
if (isset($_POST["chk_HOG2"]) == 'chk_HOG2') {
    $respuesta2_HOG2 = isset($_POST["respuesta2_HOG2"]) ? LimpiarCadena6($_POST["respuesta2_HOG2"]) : "";
} else {
    $respuesta2_HOG2 = "";
}
if (isset($_POST["chk_HOG3"]) == 'chk_HOG3') {
    $respuesta2_HOG3 = isset($_POST["respuesta2_HOG3"]) ? LimpiarCadena6($_POST["respuesta2_HOG3"]) : "";
} else {
    $respuesta2_HOG3 = "";
}
if (isset($_POST["chk_HOG4"]) == 'chk_HOG4') {
    $respuesta2_HOG4 = isset($_POST["respuesta2_HOG4"]) ? LimpiarCadena6($_POST["respuesta2_HOG4"]) : "";
} else {
    $respuesta2_HOG4 = "";
}
if (isset($_POST["chk_HOG5"]) == 'chk_HOG5') {
    $respuesta2_HOG5 = isset($_POST["respuesta2_HOG5"]) ? LimpiarCadena6($_POST["respuesta2_HOG5"]) : "";
} else {
    $respuesta2_HOG5 = "";
}
if (isset($_POST["chk_PER1"]) == 'chk_PER1') {
    $respuesta2_PER1 = isset($_POST["respuesta2_PER1"]) ? LimpiarCadena6($_POST["respuesta2_PER1"]) : "";
} else {
    $respuesta2_PER1 = "";
}
if (isset($_POST["chk_PER2"]) == 'chk_PER2') {
    $respuesta2_PER2 = isset($_POST["respuesta2_PER2"]) ? LimpiarCadena6($_POST["respuesta2_PER2"]) : "";
} else {
    $respuesta2_PER2 = "";
}
if (isset($_POST["chk_PER3"]) == 'chk_PER3') {
    $respuesta2_PER3 = isset($_POST["respuesta2_PER3"]) ? LimpiarCadena6($_POST["respuesta2_PER3"]) : "";
} else {
    $respuesta2_PER3 = "";
}
if (isset($_POST["chk_PER4"]) == 'chk_PER4') {
    $respuesta2_PER4 = isset($_POST["respuesta2_PER4"]) ? LimpiarCadena6($_POST["respuesta2_PER4"]) : "";
} else {
    $respuesta2_PER4 = "";
}
if (isset($_POST["chk_PER5"]) == 'chk_PER5') {
    $respuesta2_PER5 = isset($_POST["respuesta2_PER5"]) ? LimpiarCadena6($_POST["respuesta2_PER5"]) : "";
} else {
    $respuesta2_PER5 = "";
}
$rad_txt = isset($_POST["rad_txt"]) ? LimpiarCadena6($_POST["rad_txt"]) : "";
if ($rad_txt == 'rad_LEG1') {
    $respuesta2_LEG1 = isset($_POST["respuesta2_LEG1"]) ? LimpiarCadena6($_POST["respuesta2_LEG1"]) : "";
    $respuesta2_LEG2 = "";
    $respuesta2_LEG3 = "";
} else if ($rad_txt == 'rad_LEG2') {
    $respuesta2_LEG1 = "";
    $respuesta2_LEG2 = isset($_POST["respuesta2_LEG2"]) ? LimpiarCadena6($_POST["respuesta2_LEG2"]) : "";
    $respuesta2_LEG3 = "";
} else if ($rad_txt == 'rad_LEG3') {
    $respuesta2_LEG1 = "";
    $respuesta2_LEG2 = "";
    $respuesta2_LEG3 = isset($_POST["respuesta2_LEG3"]) ? LimpiarCadena6($_POST["respuesta2_LEG3"]) : "";
} else {
    $respuesta2_LEG1 = "";
    $respuesta2_LEG2 = "";
    $respuesta2_LEG3 = "";
}
$pregunta3 = isset($_POST["pregunta3"]) ? LimpiarCadena6($_POST["pregunta3"]) : "";
$respuesta3 = isset($_POST["respuesta3"]) ? LimpiarCadena6($_POST["respuesta3"]) : "";
if ($respuesta3 >= 0 and $respuesta3 <= 7) {
    $pregunta3_1 = isset($_POST["pregunta3_2"]) ? LimpiarCadena6($_POST["pregunta3_2"]) : "";
} else {
    $pregunta3_1 = isset($_POST["pregunta3_1"]) ? LimpiarCadena6($_POST["pregunta3_1"]) : "";
}
$respuesta3_1 = isset($_POST["respuesta3_1"]) ? LimpiarCadena6($_POST["respuesta3_1"]) : "";
if ($TIPO_CONTRATO == "VEHICULAR") {
    $pregunta4 = isset($_POST["pregunta4_VEH"]) ? LimpiarCadena6($_POST["pregunta4_VEH"]) : "";
} else if ($TIPO_CONTRATO == "HOGAR") {
    $pregunta4 = isset($_POST["pregunta4_HOG"]) ? LimpiarCadena6($_POST["pregunta4_HOG"]) : "";
} else if ($TIPO_CONTRATO == "PERSONAS") {
    $pregunta4 = isset($_POST["pregunta4_PER"]) ? LimpiarCadena6($_POST["pregunta4_PER"]) : "";
} else if ($TIPO_CONTRATO == "LEGAL") {
    $pregunta4 = isset($_POST["pregunta4_LEG"]) ? LimpiarCadena6($_POST["pregunta4_LEG"]) : "";
} else {
    $pregunta4 = "";
}
$respuesta4 = isset($_POST["respuesta4"]) ? LimpiarCadena6($_POST["respuesta4"]) : "";

/* * *********************PANEL ENCUESTA ANTIGUA LEGAL EQUINOCCIAL********************************* */
if ($TIPO_CONTRATO == "LEGAL_EQ") {
    $pregunta1_ANT = isset($_POST["pregunta1_LEGAL"]) ? LimpiarCadena6($_POST["pregunta1_LEGAL"]) : "";
    $respuesta1_ANT = isset($_POST["respuesta1_LEGAL"]) ? LimpiarCadena6($_POST["respuesta1_LEGAL"]) : "";
    $pregunta2_ANT = isset($_POST["pregunta2_LEGAL"]) ? LimpiarCadena6($_POST["pregunta2_LEGAL"]) : "";
    $respuesta2_ANT = isset($_POST["respuesta2_LEGAL"]) ? LimpiarCadena6($_POST["respuesta2_LEGAL"]) : "";
    $pregunta3_ANT = isset($_POST["pregunta3_LEGAL"]) ? LimpiarCadena6($_POST["pregunta3_LEGAL"]) : "";
    $respuesta3_ANT = isset($_POST["respuesta3_LEGAL"]) ? LimpiarCadena6($_POST["respuesta3_LEGAL"]) : "";
    $pregunta4_ANT = isset($_POST["pregunta4_LEGAL"]) ? LimpiarCadena6($_POST["pregunta4_LEGAL"]) : "";
    $respuesta4_ANT = isset($_POST["respuesta4_LEGAL"]) ? LimpiarCadena6($_POST["respuesta4_LEGAL"]) : "";
    $pregunta5_ANT = isset($_POST["pregunta5_LEGAL"]) ? LimpiarCadena6($_POST["pregunta5_LEGAL"]) : "";
    $respuesta5_ANT = isset($_POST["respuesta5_LEGAL"]) ? LimpiarCadena6($_POST["respuesta5_LEGAL"]) : "";
    $pregunta6_ANT = isset($_POST["pregunta6_LEGAL"]) ? LimpiarCadena6($_POST["pregunta6_LEGAL"]) : "";
    $respuesta6_ANT = isset($_POST["respuesta6_LEGAL"]) ? LimpiarCadena6($_POST["respuesta6_LEGAL"]) : "";
    $pregunta6_1_ANT = "";
    $respuesta6_1_ANT = "";
    $pregunta7_ANT = isset($_POST["pregunta7_LEGAL"]) ? LimpiarCadena6($_POST["pregunta7_LEGAL"]) : "";
    $respuesta7_ANT = isset($_POST["respuesta7_LEGAL"]) ? LimpiarCadena6($_POST["respuesta7_LEGAL"]) : "";
    $pregunta7_1_ANT = "";
    $respuesta7_1_ANT = "";
    $pregunta8_ANT = isset($_POST["pregunta8_LEGAL"]) ? LimpiarCadena6($_POST["pregunta8_LEGAL"]) : "";
    $respuesta8_ANT = isset($_POST["respuesta8_LEGAL"]) ? LimpiarCadena6($_POST["respuesta8_LEGAL"]) : "";
    $pregunta8_1_ANT = "";
    $respuesta8_1_ANT = "";
    $pregunta9_ANT = isset($_POST["pregunta9_LEGAL"]) ? LimpiarCadena6($_POST["pregunta9_LEGAL"]) : "";
    $respuesta9_ANT = isset($_POST["respuesta9_LEGAL"]) ? LimpiarCadena6($_POST["respuesta9_LEGAL"]) : "";
    $pregunta9_1_ANT = "";
    $respuesta9_1_ANT = "";
    $pregunta10_ANT = isset($_POST["pregunta10_LEGAL"]) ? LimpiarCadena6($_POST["pregunta10_LEGAL"]) : "";
    $respuesta10_ANT = isset($_POST["respuesta10_LEGAL"]) ? LimpiarCadena6($_POST["respuesta10_LEGAL"]) : "";
    $pregunta11_ANT = "";
    $respuesta11_ANT = "";
} else if ($TIPO_CONTRATO == "VIP_EQ") {
    $pregunta1_ANT = isset($_POST["pregunta1_VIP"]) ? LimpiarCadena6($_POST["pregunta1_VIP"]) : "";
    $respuesta1_ANT = isset($_POST["respuesta1_VIP"]) ? LimpiarCadena6($_POST["respuesta1_VIP"]) : "";
    $pregunta2_ANT = isset($_POST["pregunta2_VIP"]) ? LimpiarCadena6($_POST["pregunta2_VIP"]) : "";
    $respuesta2_ANT = isset($_POST["respuesta2_VIP"]) ? LimpiarCadena6($_POST["respuesta2_VIP"]) : "";
    $pregunta3_ANT = isset($_POST["pregunta3_VIP"]) ? LimpiarCadena6($_POST["pregunta3_VIP"]) : "";
    $respuesta3_ANT = isset($_POST["respuesta3_VIP"]) ? LimpiarCadena6($_POST["respuesta3_VIP"]) : "";
    $pregunta4_ANT = isset($_POST["pregunta4_VIP"]) ? LimpiarCadena6($_POST["pregunta4_VIP"]) : "";
    $respuesta4_ANT = isset($_POST["respuesta4_VIP"]) ? LimpiarCadena6($_POST["respuesta4_VIP"]) : "";
    $pregunta5_ANT = isset($_POST["pregunta5_VIP"]) ? LimpiarCadena6($_POST["pregunta5_VIP"]) : "";
    $respuesta5_ANT = isset($_POST["respuesta5_VIP"]) ? LimpiarCadena6($_POST["respuesta5_VIP"]) : "";
    $pregunta6_ANT = isset($_POST["pregunta6_VIP"]) ? LimpiarCadena6($_POST["pregunta6_VIP"]) : "";
    $respuesta6_ANT = isset($_POST["respuesta6_VIP"]) ? LimpiarCadena6($_POST["respuesta6_VIP"]) : "";
    $pregunta6_1_ANT = isset($_POST["pregunta6_1_VIP"]) ? LimpiarCadena6($_POST["pregunta6_1_VIP"]) : "";
    $respuesta6_1_ANT = isset($_POST["respuesta6_1_VIP"]) ? LimpiarCadena6($_POST["respuesta6_1_VIP"]) : "";
    $pregunta7_ANT = isset($_POST["pregunta7_VIP"]) ? LimpiarCadena6($_POST["pregunta7_VIP"]) : "";
    $respuesta7_ANT = isset($_POST["respuesta7_VIP"]) ? LimpiarCadena6($_POST["respuesta7_VIP"]) : "";
    $pregunta7_1_ANT = isset($_POST["pregunta7_1_VIP"]) ? LimpiarCadena6($_POST["pregunta7_1_VIP"]) : "";
    $respuesta7_1_ANT = isset($_POST["respuesta7_1_VIP"]) ? LimpiarCadena6($_POST["respuesta7_1_VIP"]) : "";
    $pregunta8_ANT = isset($_POST["pregunta8_VIP"]) ? LimpiarCadena6($_POST["pregunta8_VIP"]) : "";
    $respuesta8_ANT = isset($_POST["respuesta8_VIP"]) ? LimpiarCadena6($_POST["respuesta8_VIP"]) : "";
    $respuesta8_1_ANT = isset($_POST["respuesta8_1_VIP"]) ? LimpiarCadena6($_POST["respuesta8_1_VIP"]) : "";
    if ($respuesta8_1_ANT >= 0 and $respuesta8_1_ANT <= 7) {
        $pregunta8_1_ANT = isset($_POST["pregunta8_2_VIP"]) ? LimpiarCadena6($_POST["pregunta8_2_VIP"]) : "";
    } else {
        $pregunta8_1_ANT = isset($_POST["pregunta8_1_VIP"]) ? LimpiarCadena6($_POST["pregunta8_1_VIP"]) : "";
    }
    $pregunta9_ANT = isset($_POST["pregunta9_VIP"]) ? LimpiarCadena6($_POST["pregunta9_VIP"]) : "";
    $respuesta9_ANT = isset($_POST["respuesta9_VIP"]) ? LimpiarCadena6($_POST["respuesta9_VIP"]) : "";
    $pregunta9_1_ANT = isset($_POST["pregunta9_1_VIP"]) ? LimpiarCadena6($_POST["pregunta9_1_VIP"]) : "";
    $respuesta9_1_ANT = isset($_POST["respuesta9_1_VIP"]) ? LimpiarCadena6($_POST["respuesta9_1_VIP"]) : "";
    $pregunta10_ANT = isset($_POST["pregunta10_VIP"]) ? LimpiarCadena6($_POST["pregunta10_VIP"]) : "";
    $respuesta10_ANT = isset($_POST["respuesta10_VIP"]) ? LimpiarCadena6($_POST["respuesta10_VIP"]) : "";
    $pregunta11_ANT = isset($_POST["pregunta11_VIP"]) ? LimpiarCadena6($_POST["pregunta11_VIP"]) : "";
    $respuesta11_ANT = isset($_POST["respuesta11_VIP"]) ? LimpiarCadena6($_POST["respuesta11_VIP"]) : "";
}

/* * *********************PANEL ENCUESTA NUEVA VEHICULAR EQUINOCCIAL********************************* */
if ($TIPO_CONTRATO == "VEHICULAR_EQ") {
    $pregunta1_VEH_EQ = isset($_POST["pregunta1_VEH_EQ"]) ? LimpiarCadena6($_POST["pregunta1_VEH_EQ"]) : "";
    $respuesta1_VEH_EQ = isset($_POST["respuesta1_VEH_EQ"]) ? LimpiarCadena6($_POST["respuesta1_VEH_EQ"]) : "";
    $pregunta2_VEH_EQ = isset($_POST["pregunta2_VEH_EQ"]) ? LimpiarCadena6($_POST["pregunta2_VEH_EQ"]) : "";
    $respuesta2_VEH_EQ = isset($_POST["respuesta2_VEH_EQ"]) ? LimpiarCadena6($_POST["respuesta2_VEH_EQ"]) : "";
    $pregunta3_VEH_EQ = isset($_POST["pregunta3_VEH_EQ"]) ? LimpiarCadena6($_POST["pregunta3_VEH_EQ"]) : "";
    $respuesta3_VEH_EQ = isset($_POST["respuesta3_VEH_EQ"]) ? LimpiarCadena6($_POST["respuesta3_VEH_EQ"]) : "";
    $pregunta4_VEH_EQ = isset($_POST["pregunta4_VEH_EQ"]) ? LimpiarCadena6($_POST["pregunta4_VEH_EQ"]) : "";
    $respuesta4_VEH_EQ = isset($_POST["respuesta4_VEH_EQ"]) ? LimpiarCadena6($_POST["respuesta4_VEH_EQ"]) : "";
    $pregunta5_VEH_EQ = isset($_POST["pregunta5_VEH_EQ"]) ? LimpiarCadena6($_POST["pregunta5_VEH_EQ"]) : "";
    $respuesta5_VEH_EQ = isset($_POST["respuesta5_VEH_EQ"]) ? LimpiarCadena6($_POST["respuesta5_VEH_EQ"]) : "";
    $pregunta5_1_VEH_EQ = isset($_POST["pregunta5_1_VEH_EQ"]) ? LimpiarCadena6($_POST["pregunta5_1_VEH_EQ"]) : "";
    $respuesta5_1_VEH_EQ = isset($_POST["respuesta5_1_VEH_EQ"]) ? LimpiarCadena6($_POST["respuesta5_1_VEH_EQ"]) : "";
    $pregunta6_VEH_EQ = isset($_POST["pregunta6_VEH_EQ"]) ? LimpiarCadena6($_POST["pregunta6_VEH_EQ"]) : "";
    $respuesta6_VEH_EQ = isset($_POST["respuesta6_VEH_EQ"]) ? LimpiarCadena6($_POST["respuesta6_VEH_EQ"]) : "";
    $pregunta6_1_VEH_EQ = isset($_POST["pregunta6_1_VEH_EQ"]) ? LimpiarCadena6($_POST["pregunta6_1_VEH_EQ"]) : "";
    $respuesta6_1_VEH_EQ = isset($_POST["respuesta6_1_VEH_EQ"]) ? LimpiarCadena6($_POST["respuesta6_1_VEH_EQ"]) : "";
    $pregunta7_VEH_EQ = isset($_POST["pregunta7_VEH_EQ"]) ? LimpiarCadena6($_POST["pregunta7_VEH_EQ"]) : "";
    $respuesta7_VEH_EQ = isset($_POST["respuesta7_VEH_EQ"]) ? LimpiarCadena6($_POST["respuesta7_VEH_EQ"]) : "";
    $pregunta7_1_VEH_EQ = isset($_POST["pregunta7_1_VEH_EQ"]) ? LimpiarCadena6($_POST["pregunta7_1_VEH_EQ"]) : "";
    $respuesta7_1_VEH_EQ = isset($_POST["respuesta7_1_VEH_EQ"]) ? LimpiarCadena6($_POST["respuesta7_1_VEH_EQ"]) : "";
    $pregunta8_VEH_EQ = isset($_POST["pregunta8_VEH_EQ"]) ? LimpiarCadena6($_POST["pregunta8_VEH_EQ"]) : "";
    $respuesta8_VEH_EQ = isset($_POST["respuesta8_VEH_EQ"]) ? LimpiarCadena6($_POST["respuesta8_VEH_EQ"]) : "";
    $respuesta8_1_VEH_EQ = isset($_POST["respuesta8_1_VEH_EQ"]) ? LimpiarCadena6($_POST["respuesta8_1_VEH_EQ"]) : "";
    $pregunta8_1_VEH_EQ = isset($_POST["pregunta8_1_VEH_EQ"]) ? LimpiarCadena6($_POST["pregunta8_1_VEH_EQ"]) : "";
    $pregunta9_VEH_EQ = isset($_POST["pregunta9_VEH_EQ"]) ? LimpiarCadena6($_POST["pregunta9_VEH_EQ"]) : "";
    $respuesta9_VEH_EQ = isset($_POST["respuesta9_VEH_EQ"]) ? LimpiarCadena6($_POST["respuesta9_VEH_EQ"]) : "";
    $pregunta10_VEH_EQ = isset($_POST["pregunta10_VEH_EQ"]) ? LimpiarCadena6($_POST["pregunta10_VEH_EQ"]) : "";
    $respuesta10_VEH_EQ = isset($_POST["respuesta10_VEH_EQ"]) ? LimpiarCadena6($_POST["respuesta10_VEH_EQ"]) : "";
}

switch ($_GET["action"]) {
    case 'fechaInicio':
        date_default_timezone_set("America/Lima");
        echo(date('Y-m-d H:i:s'));
        break;

    case 'selectAll':
        $respuesta = $camp->selectAll(); /* llama a la función del modelo */
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            $datos[] = array(/* llena los resultados con los datos */
                "0" => $registrar->ID, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                "1" => $registrar->CampaignId,
                "2" => $registrar->ImportId,
                "3" => $registrar->Agent,
                "4" => $registrar->TITULAR,
                "5" => $registrar->BENEFICIARIO,
                "6" => $registrar->CONTRATO,
                "7" => $registrar->ASISTENCIA,
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
            if ($registrar->managementresultcode == 18 || $registrar->managementresultcode == 20) {
                $datos[] = array(/* llena los resultados con los datos */
                    "0" => '<p style="color: red">' . $registrar->ID . '</p>', /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                    "1" => '<p style="color: red">' . $registrar->CampaignId . '</p>',
                    "2" => '<p style="color: red">' . $registrar->ImportId . '</p>',
                    "3" => '<p style="color: red">' . $registrar->Agent . '</p>',
                    "4" => '<p style="color: red">' . $registrar->TITULAR . '</p>',
                    "5" => '<p style="color: red">' . $registrar->BENEFICIARIO . '</p>',
                    "6" => '<p style="color: red">' . $registrar->CONTRATO . '</p>',
                    "7" => '<p style="color: red">' . $registrar->ASISTENCIA . '</p>',
                    "8" => '<p style="color: red">' . $registrar->ResultLevel2 . '</p>',
                    "9" => '<a href="#" style="color: #3C8DBC;" onclick="mostrar_uno(\'' . $registrar->ID . '\')">Gestionar</a>',
                );
            } else {
                $datos[] = array(/* llena los resultados con los datos */
                    "0" => $registrar->ID, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                    "1" => $registrar->CampaignId,
                    "2" => $registrar->ImportId,
                    "3" => $registrar->Agent,
                    "4" => $registrar->TITULAR,
                    "5" => $registrar->BENEFICIARIO,
                    "6" => $registrar->CONTRATO,
                    "7" => $registrar->ASISTENCIA,
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

    case 'level3':
        $level2 = $_GET['level2'];
        $idcamp = $_GET['camp'];
        $result = ejecutarConsulta("SELECT distinct(level3) 'level3' "
                . "FROM campaignresultmanagement where level2 = '$level2' "
                . "and campaignid = '$idcamp' ORDER BY Code");
        echo '<option></option>';
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            echo '<option value="' . $row["level3"] . '">' . $row["level3"] . '</option>';
        }
        break;

    case 'code':
        $idcamp = $_GET['camp'];
        $level1 = $_GET["level1"];
        $level2 = $_GET["level2"];
        $findCode = ejecutarConsulta("SELECT Code FROM campaignresultmanagement where "
                . "CampaignId = '$idcamp' and Level1 = '$level1' and level2 = '$level2' "
                . "and level3 = ''");
        $row = mysqli_fetch_array($findCode, MYSQLI_BOTH);
        $Code = $row["Code"];
        echo($Code);
        break;

    case 'code1':
        $idcamp = $_GET['camp'];
        $level1 = $_GET["level1"];
        $level2 = $_GET["level2"];
        $level3 = $_GET["level3"];
        $findCode = ejecutarConsulta("SELECT Code FROM campaignresultmanagement where "
                . "CampaignId = '$idcamp' and Level1 = '$level1' and level2 = '$level2' "
                . "and level3 = '$level3'");
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

    case 'updatePhones':
        $IdC = isset($_POST["IDC"]) ? LimpiarCadena3($_POST["IDC"]) : "";
        $respuesta = $camp->updateTelf($IdC, $Num, $Agent, $Estado, $Tmstmp);
        echo $respuesta ? "Teléfono gestionado con éxito" : "Error: no se pudo almacenar la información!";
        break;

    case 'validePhone';
        $IdClient = $_GET["IdClient"];
        $estadoTelf = ejecutarConsulta("SELECT distinct(estado)'estado' FROM contactimportphone WHERE contactid = '$IdClient'");
        $data = mysqli_fetch_array($estadoTelf, MYSQLI_BOTH);
        $numRow = $estadoTelf->num_rows;
        if ($numRow == "1" && $data["estado"] == "SG") {
            echo "Almacene un número de teléfono para continuar!";
        } else {
            echo "Si hay telefonos";
        }
        break;

    case 'save':
		if ($IdCliente != "") {
			$saveById = ejecutarConsulta6("select contactid from gestionfinal where contactid = '$IdCliente'");
			$valid = mysqli_fetch_array($saveById, MYSQLI_BOTH);
			$numRowC = $saveById->num_rows;
			if ($numRowC == 0) {
				if ($camp->insertGestionFinal($IdCliente, $contactAddress, $Agent, $level1, $level2, $level3, $mangementCode, $time, $Tmstmp, $intentos, $FechaAgendamiento, $TelefonoAd, $Observaciones, $pregunta1, $pregunta1_1, $pregunta2, $pregunta2_1, $pregunta3, $pregunta3_1, $pregunta4, $respuesta1, $respuesta1_1, $respuesta2, $respuesta2_VEH1, $respuesta2_VEH2, $respuesta2_VEH3, $respuesta2_VEH4, $respuesta2_VEH5, $respuesta2_VEH6, $respuesta2_HOG1, $respuesta2_HOG2, $respuesta2_HOG3, $respuesta2_HOG4, $respuesta2_HOG5, $respuesta2_PER1, $respuesta2_PER2, $respuesta2_PER3, $respuesta2_PER4, $respuesta2_PER5, $respuesta2_LEG1, $respuesta2_LEG2, $respuesta2_LEG3, $respuesta3, $respuesta3_1, $respuesta4, $pregunta1_ANT, $pregunta2_ANT, $pregunta3_ANT, $pregunta4_ANT, $pregunta5_ANT, $pregunta6_ANT, $pregunta6_1_ANT, $pregunta7_ANT, $pregunta7_1_ANT, $pregunta8_ANT, $pregunta8_1_ANT, $pregunta9_ANT, $pregunta9_1_ANT, $pregunta10_ANT, $pregunta11_ANT, $respuesta1_ANT, $respuesta2_ANT, $respuesta3_ANT, $respuesta4_ANT, $respuesta5_ANT, $respuesta6_ANT, $respuesta6_1_ANT, $respuesta7_ANT, $respuesta7_1_ANT, $respuesta8_ANT, $respuesta8_1_ANT, $respuesta9_ANT, $respuesta9_1_ANT, $respuesta10_ANT, $respuesta11_ANT,$pregunta1_VEH_EQ, $respuesta1_VEH_EQ,$pregunta2_VEH_EQ,$respuesta2_VEH_EQ,$pregunta3_VEH_EQ,$respuesta3_VEH_EQ,$pregunta4_VEH_EQ,$respuesta4_VEH_EQ,$pregunta5_VEH_EQ,$respuesta5_VEH_EQ,$pregunta5_1_VEH_EQ,$respuesta5_1_VEH_EQ,$pregunta6_VEH_EQ,$respuesta6_VEH_EQ,$pregunta6_1_VEH_EQ,$respuesta6_1_VEH_EQ,$pregunta7_VEH_EQ,$respuesta7_VEH_EQ,$pregunta7_1_VEH_EQ,$respuesta7_1_VEH_EQ,$pregunta8_VEH_EQ,$respuesta8_VEH_EQ,$respuesta8_1_VEH_EQ,$pregunta8_1_VEH_EQ,$pregunta9_VEH_EQ,$respuesta9_VEH_EQ,$pregunta10_VEH_EQ,$respuesta10_VEH_EQ)) {
					$respuesta = $camp->updateClientes($IdCliente, $Agent, $level1, $level2, $level3, $mangementCode, $Tmstmp, $intentos, $contactAddress);
					ejecutarConsulta("Update contactimportcontact set LastAgent = '$Agent', LastManagementResult = '$mangementCode', Number = '$intentos', Action = 'Gestionado' where id = '$IdCliente' ");
					$camp->insertGestionHistorica($IdCliente);
					echo "Registro almacenado con éxito";
				} else {
					echo "Error: registro no se pudo almacenar";
				}
			} else {
				if ($camp->updateGestionFinal($IdCliente, $contactAddress, $Agent, $level1, $level2, $level3, $mangementCode, $time, $Tmstmp, $intentos, $FechaAgendamiento, $TelefonoAd, $Observaciones, $pregunta1, $pregunta1_1, $pregunta2, $pregunta2_1, $pregunta3, $pregunta3_1, $pregunta4, $respuesta1, $respuesta1_1, $respuesta2, $respuesta2_VEH1, $respuesta2_VEH2, $respuesta2_VEH3, $respuesta2_VEH4, $respuesta2_VEH5, $respuesta2_VEH6, $respuesta2_HOG1, $respuesta2_HOG2, $respuesta2_HOG3, $respuesta2_HOG4, $respuesta2_HOG5, $respuesta2_PER1, $respuesta2_PER2, $respuesta2_PER3, $respuesta2_PER4, $respuesta2_PER5, $respuesta2_LEG1, $respuesta2_LEG2, $respuesta2_LEG3, $respuesta3, $respuesta3_1, $respuesta4, $pregunta1_ANT, $pregunta2_ANT, $pregunta3_ANT, $pregunta4_ANT, $pregunta5_ANT, $pregunta6_ANT, $pregunta6_1_ANT, $pregunta7_ANT, $pregunta7_1_ANT, $pregunta8_ANT, $pregunta8_1_ANT, $pregunta9_ANT, $pregunta9_1_ANT, $pregunta10_ANT, $pregunta11_ANT, $respuesta1_ANT, $respuesta2_ANT, $respuesta3_ANT, $respuesta4_ANT, $respuesta5_ANT, $respuesta6_ANT, $respuesta6_1_ANT, $respuesta7_ANT, $respuesta7_1_ANT, $respuesta8_ANT, $respuesta8_1_ANT, $respuesta9_ANT, $respuesta9_1_ANT, $respuesta10_ANT, $respuesta11_ANT,$pregunta1_VEH_EQ, $respuesta1_VEH_EQ,$pregunta2_VEH_EQ,$respuesta2_VEH_EQ,$pregunta3_VEH_EQ,$respuesta3_VEH_EQ,$pregunta4_VEH_EQ,$respuesta4_VEH_EQ,$pregunta5_VEH_EQ,$respuesta5_VEH_EQ,$pregunta5_1_VEH_EQ,$respuesta5_1_VEH_EQ,$pregunta6_VEH_EQ,$respuesta6_VEH_EQ,$pregunta6_1_VEH_EQ,$respuesta6_1_VEH_EQ,$pregunta7_VEH_EQ,$respuesta7_VEH_EQ,$pregunta7_1_VEH_EQ,$respuesta7_1_VEH_EQ,$pregunta8_VEH_EQ,$respuesta8_VEH_EQ,$respuesta8_1_VEH_EQ,$pregunta8_1_VEH_EQ,$pregunta9_VEH_EQ,$respuesta9_VEH_EQ,$pregunta10_VEH_EQ,$respuesta10_VEH_EQ)) {
					$respuesta = $camp->updateClientes($IdCliente, $Agent, $level1, $level2, $level3, $mangementCode, $Tmstmp, $intentos, $contactAddress);
					ejecutarConsulta("Update contactimportcontact set LastAgent = '$Agent', LastManagementResult = '$mangementCode', Number = '$intentos', Action = 'Gestionado' where id = '$IdCliente' ");
					$camp->insertGestionHistorica($IdCliente);
					echo "Registro actualizado con éxito";
				} else {
					echo "Error: registro no se pudo actualizar";
				}
			}
		} else {
            echo "Error de almacenamiento";
        }
        break;
}
?>