<?php

require '../config/connection.php';
require "../ajax/Exception.php";
require "../ajax/PHPMailer.php";
require "../ajax/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

Class correoMasivoBPM {

    public function _construct() { /* Constructor */
    }

    function envioCorreos($ContactId, $InteractionId, $Agent, $Tmstmp, $Nombres, $Cedula, $Producto, $Monto, $Garante, $Telefonos, $Celular, $Observaciones, $Region, $Ciudad, $TipoOficina, $Agencia, $NUP, $Correo, $EnviadoD1, $EnviadoD2, $EnviadoD3, $EnviadoD4, $EnviadoCC1, $EnviadoCC2, $EnviadoCC3, $EnviadoCC4) {
        $oMail = new PHPMailer();
        $oMail->isSMTP();
        $oMail->Host = "mail.kimobill.com";
//        $oMail->Host = "a2plcpnl0258.prod.iad2.secureserver.net";
        $oMail->Port = 465;
        $oMail->SMTPSecure = "ssl";
        //$oMail->SMTPDebug = 2;
        $oMail->SMTPAuth = true;
        $oMail->Username = "fvt@kimobill.com";
        $oMail->Password = "fvt.2k2020"; //"fvt.2k2020";
        $oMail->setFrom("fvt@kimobill.com", "FVT KIMOBILL");
        $oMail->addAddress("$EnviadoD1");
        $oMail->addAddress("$EnviadoD2");
        $oMail->addCC("$EnviadoCC1");
        $oMail->addCC("$EnviadoCC2");
        $oMail->addCC("$EnviadoCC3");
        $oMail->addCC("$EnviadoCC4");
        $oMail->Subject = "CLIENTE $Nombres CI $Cedula DESEA ACERCARSE A LA AGENCIA POR EL CREDITO";
        $oMail->msgHTML("<!DOCTYPE html>  "
                . "<html>  "
                . "	<style>"
                . "		table td{		"
                . "			font-size: 15px;"
                . "			font-family: Segoe UI;"
                . "		}"
                . "		#caja{"
                . "			width: 550px;"
                . "			height: 530px;"
                . "			border-radius: 30px;"
                . "			padding: 10px;"
                . "			text-align: justify-all;"
                . "			font-family: Segoe UI;"
                . "			font-size: 15px;"
                . "		}"
                . "		#table2{"
                . "			font-family: Segoe UI;"
                . "		}"
                . "	</style>"
                . "	<head> "
                . "		<title>Sentinel</title>"
                . "	</head>"
                . "	<body>"
                . "		<div id ='caja'>"
                . "			<tbody>"
                . "				<br>"
                . "					<b>Estimado(a) Colaborador(a), </b>"
                . "				</br>"
                . "				<p style='text-align: justify;'>"
                . "					Favor su atenci&#243;n, cliente interesado en desembolsar el cr&#233;dito:"
                . "				</p>"
                . "				<table class='table table-responsive'>"
                . "					<tr>"
                . "						<td width='30%'><strong>Nombres:</strong></td>"
                . "						<td width='100%'>$Nombres</td>"
                . "						<td></td>"
                . "					</tr>"
                . "					<tr>"
                . "						<td width='30%'><b>C&#233;dula:</b>"
                . "						<td width='100%'>$Cedula</td>"
                . "					</tr>"
                . "					<tr>"
                . "						<td width='30%'><b>Producto:</b></td>"
                . "						<td width='100%'>$Producto</td>"
                . "					</tr>"
                . "					<tr>"
                . "						<td width='30%'><b>Monto:</b></td>"
                . "						<td width='100%'>$Monto</td>"
                . "					</tr>"
                . "					<tr>"
                . "						<td width='30%'><b>Garante:</b></td>"
                . "						<td width='100%'>$Garante</td>"
                . "					</tr>"
                . "					<tr>"
                . "						<td width='30%'><b>Tel&#233;fonos:</b></td>"
                . "						<td width='100%'>$Telefonos</td>"
                . "					</tr>"
                . "					<tr>"
                . "						<td width='30%'><b>Celular:</b></td>"
                . "						<td width='100%'>$Celular</td>"
                . "					</tr>"
                . "					<tr>"
                . "						<td width='30%'><b>NUP:</b></td>"
                . "						<td width='100%'>$NUP</td>"
                . "					</tr>"
                . "					<tr>"
                . "						<td width='30%'><b>EMAIL:</b></td>"
                . "						<td width='100%'>$Correo</td>"
                . "					</tr>"
                . "					<tr>"
                . "						<td width='30%'><b>Observaciones:</b></td>"
                . "						<td width='100%'>$Observaciones</td>"
                . "					</tr>"
                . "				</table>"
                . "				<p>"
                . "					<br>Recuerda contactar al cliente dentro de las 24 horas de recibida esta notificaci&#243;n, confirma hora y fecha de visita en la agencia.</br>"
                . "				</p>"
                . "				<p>"
                . "					<br>Cualquier duda o inquietud favor responder a este correo, nos comunicaremos con usted de forma inmediata.</br>"
                . "				</p>"
                . "				<table id ='table2' class='table-responsive'>"
                . "					<tr>"
                . "						<td style='font-size: 14px'><b>Asesor Comercial Call Center</b></td>"
                . "					</tr>"
                . "				</table>"
                . "				</tr>"
                . "			</tbody>  "
                . "		</div>"
                . "	</body>  "
                . "</html>");

        if ($oMail->send()) {
            echo("Mail enviado");
            $sql = "INSERT INTO enviomail(ContactId, InteractionId, Agent, Tmstmp, Nombres, Cedula, Producto, Monto, Garante, Telefonos, Celular, Observaciones, Region, Ciudad, TipoOficina, Agencia, NUP, Correo, EnviadoD1, EnviadoD2, EnviadoD3, EnviadoD4, EnviadoCC1, EnviadoCC2, EnviadoCC3, EnviadoCC4, EstadoEnvio) "
                    . "VALUES ('$ContactId','','$Agent','$Tmstmp','$Nombres','$Cedula','$Producto','$Monto','$Garante','$Telefonos','$Celular','$Observaciones','$Region','$Ciudad','$TipoOficina','$Agencia','$NUP','$Correo','$EnviadoD1','$EnviadoD2','$EnviadoD3','$EnviadoD4','$EnviadoCC1','$EnviadoCC2','$EnviadoCC3','$EnviadoCC4','ENVIADO')";
            return ejecutarConsulta1($sql);
        } else {
            echo $oMail->ErrorInfo;
            $sql = "INSERT INTO enviomail(ContactId, InteractionId, Agent, Tmstmp, Nombres, Cedula, Producto, Monto, Garante, Telefonos, Celular, Observaciones, Region, Ciudad, TipoOficina, Agencia, NUP, Correo, EnviadoD1, EnviadoD2, EnviadoD3, EnviadoD4, EnviadoCC1, EnviadoCC2, EnviadoCC3, EnviadoCC4, EstadoEnvio) "
                    . "VALUES ('$ContactId','','$Agent','$Tmstmp','$Nombres','$Cedula','$Producto','$Monto','$Garante','$Telefonos','$Celular','$Observaciones','$Region','$Ciudad','$TipoOficina','$Agencia','$NUP','$Correo','$EnviadoD1','$EnviadoD2','$EnviadoD3','$EnviadoD4','$EnviadoCC1','$EnviadoCC2','$EnviadoCC3','$EnviadoCC4','NO ENVIADO')";
            return ejecutarConsulta1($sql);
        }
    }
}

?>