<!DOCTYPE html>
<html>
    <head>
        <meta charset="windows-1252">
        <title></title>
    </head>
    <body>

        <?php
        require 'config/connection.php';
		
//		function encriptar($texto) {
//			$key = '';
//			$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
//			$encrypted = openssl_encrypt($texto, 'aes-256-cbc', $key, 0, $iv);
//			return base64_encode($encrypted . '::' . $iv);
//		}
//
//		function desencriptar($texto) {
//			$key = '';
//			list($encrypted_data, $iv) = explode('::', base64_decode($texto), 2);
//			return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
//		}
//		
//        
//        $result = ejecutarConsulta("SELECT Id, Password FROM user");
//        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
//            $pass = encriptar($row["Password"]);
//            $user = $row["Id"];
//            ejecutarConsulta("UPDATE USER SET password = '$pass' where id = '$user' ");
//            echo $user . ' '. desencriptar($pass). '<br>';
//        }

        
//        phpinfo();
        header("Location: views/login.php");
        
//        require "ajax/Exception.php";
//        require "ajax/PHPMailer.php";
//        require "ajax/SMTP.php";
//
//        use PHPMailer\PHPMailer\PHPMailer;
//        use PHPMailer\PHPMailer\Exception;
//
//        $oMail = new PHPMailer();
//        $oMail->isSMTP();
//        $oMail->Host = "smtp.gmail.com";
//        $oMail->Port = 587;
//        $oMail->SMTPSecure = "tls";
//        $oMail->SMTPAuth = true;
//        $oMail->Username = "monica.viera.c@gmail.com";
//        $oMail->Password = "MonicaViera1989";
//        $oMail->setFrom("monica.viera.c@gmail.com", "FVT");
//        $oMail->addAddress("monisteb@hotmail.com", "principal");
//        $oMail->addCC("monica.viera.c@outlook.com");
////        $oMail->addCC("veronica.ochoa@kimobill.com");
////        $oMail->addCC("supervisorcck@kimobill.com");
////        $oMail->addCC("fvt@kimobill.com");
//        $oMail->Subject = "CLIENTE NIETO AGUILAR LUIS ALBERTO CI 1708598931 DESEA ACERCARSE A LA AGENCIA POR EL CREDITO";
//        $oMail->msgHTML("<!DOCTYPE html>  "
//                . "<html>  "
//                . "	<style>"
//                . "		table td{		"
//                . "			font-size: 15px;"
//                . "			font-family: Segoe UI;"
//                . "		}"
//                . "		#caja{"
//                . "			width: 550px;"
//                . "			height: 530px;"
//                . "			background: silver;"
//                . "			border-radius: 50px;"
//                . "			padding: 10px;"
//                . "			text-align: justify-all;"
//                . "			font-family: Segoe UI;"
//                . "			font-size: 15px;"
//                . "		}"
//                . "		#table2{"
//                . "			font-family: Segoe UI;"
//                . "		}"
//                . "	</style>"
//                . "	<head> "
//                . "		<title>Sentinel</title>"
//                . "	</head>"
//                . "	<body>"
//                . "		<div id ='caja'>"
//                . "			<tbody>"
//                . "				<br>"
//                . "					<b>Estimada Agencia </b>{arg0}:"
//                . "				</br>"
//                . "				<p style='text-align: justify;'>"
//                . "					El Cliente indicado a continuaci&#243;n ha sido contactado por nuestros call center"
//                . "					y est&#225; interesado en desembolsar el Cr&#233;dito Preciso Pre aprobado en VCM, es"
//                . "					muy importante su gentil atenci&#243;n a fin de cerrar la negociaci&#243;n:"
//                . "				</p>"
//                . "				<table class='table table-responsive'>"
//                . "					<tr>"
//                . "						<td width='30%'><strong>Nombre:</strong></td>"
//                . "						<td width='100%'>{arg1}</td>"
//                . "						<td></td>"
//                . "					</tr>"
//                . "					<tr>"
//                . "						<td width='30%'><b>C&#233;dula:</b>"
//                . "						<td width='100%'>{arg2}</td>"
//                . "					</tr>"
//                . "					<tr>"
//                . "						<td width='30%'><b>Producto:</b></td>"
//                . "						<td width='100%'>{arg3}</td>"
//                . "					</tr>"
//                . "					<tr>"
//                . "						<td width='30%'><b>Monto:</b></td>"
//                . "						<td width='100%'>{arg4}</td>"
//                . "					</tr>"
//                . "					<tr>"
//                . "						<td width='30%'><b>Garante:</b></td>"
//                . "						<td width='100%'>{arg5}</td>"
//                . "					</tr>"
//                . "					<tr>"
//                . "						<td width='30%'><b>Tel&#233;fonos:</b></td>"
//                . "						<td width='100%'>{arg6}</td>"
//                . "					</tr>"
//                . "					<tr>"
//                . "						<td width='30%'><b>Celular:</b></td>"
//                . "						<td width='100%'>{arg7}</td>"
//                . "					</tr>"
//                . "					<tr>"
//                . "						<td width='30%'><b>Observaciones:</b></td>"
//                . "						<td width='100%'>{arg8}</td>"
//                . "					</tr>"
//                . "				</table>"
//                . "				<p>"
//                . "					<br>*Requisitos comunicados al cliente: &#250;nicamente la c&#233;dula para deudor, y para el garante los requisitos normales</br>"
//                . "				</p>"
//                . "				<p>"
//                . "					<br><b>Telemercadeo apoyando siempre la gesti&#243;n de ventas!!!</b></br>"
//                . "				</p>"
//                . "				<table id ='table2' class='table-responsive'>"
//                . "					<tr>"
//                . "						<td style='font-size: 15px'><b>Atentamente,</b></td>"
//                . "					</tr>"
//                . "					<tr>"
//                . "						<td style='font-size: 10px'><b>Asesor Telemercadeo</b></td>"
//                . "					</tr>"
//                . "					<tr>"
//                . "						<td style='font-size: 10px'>Nota: Este es un mail autom&#225;tico, por favor no responda este mensaje.</td>"
//                . "					</tr>"
//                . "				</table>"
//                . "				</tr>"
//                . "			</tbody>  "
//                . "		</div>"
//                . "	</body>  "
//                . "</html>");
//
//        if (!$oMail->send())
//            echo $oMail->ErrorInfo;
//        
        ?>
    </body>
</html>
