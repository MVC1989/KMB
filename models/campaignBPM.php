<?php

require '../config/connection.php';
require "../ajax/Exception.php";
require "../ajax/PHPMailer.php";
require "../ajax/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

Class campaingBPM {

    public function _construct() { /* Constructor */
    }

    function selectAll() { //mostrar todos los registros
        $sql = "SELECT c.ID, c.CampaignId, c.ImportId, c.CODIGO_CAMPANIA, c.NOMBRE_CAMPANIA,"
                . "c.IDENTIFICACION, c.NOMBRE, cc.LastAgent 'Agent', c.ResultLevel2 FROM clientes c, cck.contactimportcontact cc  "
                . "where c.Id = cc.id and cc.LastAgent = '$_SESSION[usu]' "
                . "and (cc.action = 'reciclar base' or cc.action = 'asignar base') and cc.action <> 'cancelar base' ";
        return ejecutarConsulta1($sql);
    }

    function selectAllRec() { //mostrar todos los registros //or cc.action = 'Reciclar Base'
        $sql = "SELECT g.ID, g.CampaignId, g.ImportId, g.CODIGO_CAMPANIA, g.NOMBRE_CAMPANIA, "
                . "g.IDENTIFICACION, g.NOMBRE, g.Agent 'Agent', g.ResultLevel2, g.managementresultcode "
                . "from gestionfinal g, cck.contactimportcontact c "
                . "where g.contactid = c.id and c.LastAgent = '$_SESSION[usu]' and "
                . "( c.LastManagementResult >= '60' and c.LastManagementResult <= '64'  "
                . "or c.LastManagementResult = '34' ) and (c.action <> 'cancelar base' and c.ACTION = 'gestionado')";
        return ejecutarConsulta1($sql);
    }

    function selectById($Id) { //mostrar un registro
        $sql = "SELECT * FROM clientes where id = '$Id'";
        return ejecutarConsultaSimple1($sql);
    }

    function selectByIdRec($Id) { //mostrar un registro
        $sql = "SELECT * FROM clientes where id = '$Id'";
        return ejecutarConsultaSimple1($sql);
    }

    function updateTelf($IdC, $Num, $Agent, $EstadoF, $Tmstmp) { //mostrar todos los registros
        $sql = "Update contactimportphone set Agente = '$Agent', Estado = '$EstadoF', FechaHora ='$Tmstmp'"
                . "where ContactId = '$IdC' and NumeroMarcado = '$Num'";
        return ejecutarConsulta($sql);
    }

    function updateClientes($IdCliente, $Agent, $level1, $level2, $mangementCode, $Tmstmp, $intentos) { //mostrar todos los registros
        $sql = "Update clientes set lastagent = '$Agent', ResultLevel1 = '$level1', ResultLevel2 = '$level2', "
                . " ManagementResultDescription = '', ManagementResultCode = '$mangementCode', "
                . " TmStmp = '$Tmstmp', Intentos = '$intentos' where Id = '$IdCliente' and vcc = '$_SESSION[vcc]'";
        return ejecutarConsulta1($sql);
    }

    function deleteClientes($IdCliente) {
        $sql = "Delete from clientes where id = '$IdCliente'";
        return ejecutarConsulta1($sql);
    }

    function insertGestionFinal($IdCliente, $Agent, $level1, $level2, $mangementCode, $Tmstmp, $intentos, $contactname, $contactAddress, $InteractionId, $FechaAgendamiento, $TelefonoAd, $Observaciones, $time, $tipoOferta, $fechaV, $horaV, $tipoC, $regionC, $ciudadC, $agenciaC, $tlfC, $tipoOfC, $horarioC, $direccionC, $acepta, $subestatus1, $subestatus2, $tipoCredito, $telfFvt, $dirFvt, $producto, $listadoProd, $otroProd, $montoMail) { //mostrar todos los registros
        $sql = "INSERT INTO gestionfinal(VCC, CampaignId, ContactId, ContactName, ContactAddress, InteractionId, ImportId, Agent, ResultLevel1,ResultLevel2, ResultLevel3, ManagementResultCode, ManagementResultDescription, Intentos, FechaAgendamiento, Telefono2, Observaciones, TmStmp, ID, CODIGO_CAMPANIA, NOMBRE_CAMPANIA, NUPS, IDENTIFICACION, NOMBRE, PERFILRIESGOENDEUDAMIENTO, SUBSEGMENTO, EDAD, CREDITO_CONSUMO_ESCENARIO_1, CUOTA_CONSUMO_ESCENARIO_1, PLAZO_CONSUMO_ESCENARIO_1, GARANTE_CONSUMO_ESCENARIO_1, TARJETA_ESCENARIO_1, PLASTICO_1_TARJETA_ESCENARIO_1, MARCA_ESCENARIO_1, PRODUCTO_ESCENARIO_1, CREDITO_CONSUMO_EXCLUSIVO, CUOTA_CONSUMO_EXCLUSIVO, PLAZO_CONSUMO_EXCLUSIVO, GARANTE_CONSUMO_EXCLUSIVO, CREDITO_CONSUMO_ROL, CUOTA_CONSUMO_ROL, GARANTE_CONSUMO_ROL, TARJETA_EXCLUSIVA, PLASTICO_1_TARJETA_EXCLUSIVA, MARCA_TARJETA_EXCLUSIVA, PRODUCTO_TARJETA_EXCLUSIVA, MAXIMO_CONSUMO, MAXIMA_TARJETA, BANCA, SEGMENTO, SEGMENTO_N_2, SUBSEGMENTO1, REGION, ZONA, AGENCIA, FECHA_NACIMIENTO, SEXO, ESTADO_CIVIL, PAIS_DOM_CAL_DAT, PROV_DOM_CAL_DAT, CIUDAD_DOM_CAL_DAT, DIR_DOM_CAL_DAT, PAIS_TRAB_1_CAL_DAT, PROV_TRAB_1_CAL_DAT, CIUDAD_TRAB_1_CAL_DAT, DIR_TRAB_1_CAL_DAT, IDENTIFICACION_PARENTEZCO, CALIFICACION_BURO, NOMBRES, DES_SEXO, FECH_NAC, NUMERO_CARGAS_FAMILIARES, TIENE_DEUDA_PROTEGIDA, TIENE_TDC, COD_MARCA, PLAN_RECOMPENSAS, FECHA_INGRESO_SOCIO, NUMERO_CUENTA1, PRODUCTO_CTA1, DESCRIPCION1, CANAL, DIFERENCIA_CUPOS, CATEGORIZACION, TIPO_BASE, REGION_ANCLAJE, PLAZO_CONSUMO_ROL, CORREO1, CORREO2, CORREO3, CORREO4, CORREO5, CORREO6, DES_NACIONALID, CANT_NAC, ACTIVIDAD_ECONOMICA, DES_CANAL, CUENTA, NUMERO_TARJETA, PRODUCTO, TIPOTC, FAMILIA, CUPO, CUPO_DISPONIBLE, HIJOS_MAS_18, HIJOS_MENOS_18, HERMANOS_MENOS_18, HERMANOS_MAS_18, MAMA, PAPA, CONYUG, MARCA_CUPO, NRO_TDC_COMPETENCIA, CUPO_MAX_COMP, CONSUMO_PROMEDIO, PRIORIDAD_GESTION, NOMBRE1, NOMBRE2, APELLIDO1, APELLIDO2, HORA_GESTION, CRDFECHAVISITA, CRDHORAVISITA, CRDTIPOCLIENTE, CRDREGION, CRDCIUDAD, CRDTELEFONO, CRDTIPOOFICINA, CRDAGENCIA, CRDHORARIO, CRDDIRECCION, OFERTASELECCIONADA, ACEPTAASISTENCIA, SUBESTATUS1, SUBESTATUS2, CRDTIPO, CRDFVTTELF, CRDFVTDIR, DESEAPRODUCTO, TIPOPRODUCTO, OTROPRODUCTO, CRD_MONTO) "
                . "SELECT VCC, CampaignId, '$IdCliente','$contactname','$contactAddress', '$InteractionId', ImportId, '$Agent', '$level1', '$level2', '', '$mangementCode', '','$intentos','$FechaAgendamiento','$TelefonoAd','$Observaciones','$Tmstmp', ID, CODIGO_CAMPANIA, NOMBRE_CAMPANIA, NUPS, IDENTIFICACION, NOMBRE, PERFILRIESGOENDEUDAMIENTO, SUBSEGMENTO, EDAD, CREDITO_CONSUMO_ESCENARIO_1, CUOTA_CONSUMO_ESCENARIO_1, PLAZO_CONSUMO_ESCENARIO_1, GARANTE_CONSUMO_ESCENARIO_1, TARJETA_ESCENARIO_1, PLASTICO_1_TARJETA_ESCENARIO_1, MARCA_ESCENARIO_1, PRODUCTO_ESCENARIO_1, CREDITO_CONSUMO_EXCLUSIVO, CUOTA_CONSUMO_EXCLUSIVO, PLAZO_CONSUMO_EXCLUSIVO, GARANTE_CONSUMO_EXCLUSIVO, CREDITO_CONSUMO_ROL, CUOTA_CONSUMO_ROL, GARANTE_CONSUMO_ROL, TARJETA_EXCLUSIVA, PLASTICO_1_TARJETA_EXCLUSIVA, MARCA_TARJETA_EXCLUSIVA, PRODUCTO_TARJETA_EXCLUSIVA, MAXIMO_CONSUMO, MAXIMA_TARJETA, BANCA, SEGMENTO, SEGMENTO_N_2, SUBSEGMENTO1, REGION, ZONA, AGENCIA, FECHA_NACIMIENTO, SEXO, ESTADO_CIVIL, PAIS_DOM_CAL_DAT, PROV_DOM_CAL_DAT, CIUDAD_DOM_CAL_DAT, DIR_DOM_CAL_DAT, PAIS_TRAB_1_CAL_DAT, PROV_TRAB_1_CAL_DAT, CIUDAD_TRAB_1_CAL_DAT, DIR_TRAB_1_CAL_DAT, IDENTIFICACION_PARENTEZCO, CALIFICACION_BURO, NOMBRES, DES_SEXO, FECH_NAC, NUMERO_CARGAS_FAMILIARES, TIENE_DEUDA_PROTEGIDA, TIENE_TDC, COD_MARCA, PLAN_RECOMPENSAS, FECHA_INGRESO_SOCIO, NUMERO_CUENTA1, PRODUCTO_CTA1, DESCRIPCION1, CANAL, DIFERENCIA_CUPOS, CATEGORIZACION, TIPO_BASE, REGION_ANCLAJE, PLAZO_CONSUMO_ROL, CORREO1, CORREO2, CORREO3, CORREO4, CORREO5, CORREO6, DES_NACIONALID, CANT_NAC, ACTIVIDAD_ECONOMICA, DES_CANAL, CUENTA, NUMERO_TARJETA, PRODUCTO, TIPOTC, FAMILIA, CUPO, CUPO_DISPONIBLE, HIJOS_MAS_18, HIJOS_MENOS_18, HERMANOS_MENOS_18, HERMANOS_MAS_18, MAMA, PAPA, CONYUG, MARCA_CUPO, NRO_TDC_COMPETENCIA, CUPO_MAX_COMP, CONSUMO_PROMEDIO, PRIORIDAD_GESTION, NOMBRE1, NOMBRE2, APELLIDO1, APELLIDO2, '$time', '$fechaV', '$horaV', '$tipoC', '$regionC', '$ciudadC', '$tlfC', '$tipoOfC', '$agenciaC',  '$horarioC', '$direccionC', '$tipoOferta', '$acepta', '$subestatus1', '$subestatus2', '$tipoCredito', '$telfFvt', '$dirFvt', '$producto', '$listadoProd', '$otroProd', '$montoMail' "
                . "FROM clientes where Id = '$IdCliente'";
        return ejecutarConsulta1($sql);
    }

    function updateGestionFinal($IdCliente, $Agent, $level1, $level2, $mangementCode, $Tmstmp, $intentos, $contactname, $contactAddress, $InteractionId, $FechaAgendamiento, $TelefonoAd, $Observaciones, $time, $tipoOferta, $fechaV, $horaV, $tipoC, $regionC, $ciudadC, $agenciaC, $tlfC, $tipoOfC, $horarioC, $direccionC, $acepta, $subestatus1, $subestatus2, $tipoCredito, $telfFvt, $dirFvt, $producto, $listadoProd, $otroProd, $montoMail) {
        $sql = "UPDATE gestionfinal SET ContactName = '$contactname', ContactAddress = '$contactAddress', InteractionId = '$InteractionId',"
                . "Agent = '$Agent', ResultLevel1 = '$level1', ResultLevel2 = '$level2', ResultLevel3 = '', ManagementResultDescription = '', "
                . "ManagementResultCode = '$mangementCode', Intentos = '$intentos', FechaAgendamiento = '$FechaAgendamiento', "
                . "Telefono2 = '$TelefonoAd', Observaciones = '$Observaciones', TmStmp = '$Tmstmp', HORA_GESTION = '$time', "
                . "CRDFECHAVISITA = '$fechaV', CRDHORAVISITA = '$horaV', CRDTIPOCLIENTE = '$tipoC', "
                . "CRDREGION = '$regionC', CRDCIUDAD = '$ciudadC', CRDTELEFONO = '$tlfC', CRDTIPOOFICINA = '$tipoOfC', "
                . "CRDAGENCIA = '$agenciaC', CRDHORARIO = '$horarioC', CRDDIRECCION = '$direccionC', "
                . "OFERTASELECCIONADA = '$tipoOferta', ACEPTAASISTENCIA = '$acepta', SUBESTATUS1 = '$subestatus1',"
                . "SUBESTATUS2 = '$subestatus2', CRDTIPO = '$tipoCredito', CRDFVTTELF = '$telfFvt', CRDFVTDIR = '$dirFvt' "
                . ",DESEAPRODUCTO= '$producto',TIPOPRODUCTO= '$listadoProd',OTROPRODUCTO='$otroProd',CRD_MONTO='$montoMail' "
                . "where contactId = '$IdCliente'";
        return ejecutarConsulta1($sql);
    }

    function envioCorreos($IdCliente, $Agent, $Tmstmp, $contactname, $cedulaMail, $productoMail, $montoMail, $garanteMail, $telefonoMail, $celularMail, $Observaciones, $regionC, $ciudadC, $tipoC, $agenciaC, $nup, $correoCliente, $principalMail, $copiaMail, $CC1, $CC2, $CC3, $CC4) {
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
        $oMail->addAddress("$principalMail");
        $oMail->addAddress("$copiaMail");
        $oMail->addAddress("$CC3");
        $oMail->addCC("$CC1");
        $oMail->addCC("$CC2");
        $oMail->addCC("$CC4");
        $oMail->Subject = "CLIENTE $contactname CI $cedulaMail DESEA ACERCARSE A LA AGENCIA POR EL CREDITO";
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
                . "						<td width='100%'>$contactname</td>"
                . "						<td></td>"
                . "					</tr>"
                . "					<tr>"
                . "						<td width='30%'><b>C&#233;dula:</b>"
                . "						<td width='100%'>$cedulaMail</td>"
                . "					</tr>"
                . "					<tr>"
                . "						<td width='30%'><b>Producto:</b></td>"
                . "						<td width='100%'>$productoMail</td>"
                . "					</tr>"
                . "					<tr>"
                . "						<td width='30%'><b>Monto:</b></td>"
                . "						<td width='100%'>$montoMail</td>"
                . "					</tr>"
                . "					<tr>"
                . "						<td width='30%'><b>Garante:</b></td>"
                . "						<td width='100%'>$garanteMail</td>"
                . "					</tr>"
                . "					<tr>"
                . "						<td width='30%'><b>Tel&#233;fonos:</b></td>"
                . "						<td width='100%'>$telefonoMail</td>"
                . "					</tr>"
                . "					<tr>"
                . "						<td width='30%'><b>Celular:</b></td>"
                . "						<td width='100%'>$celularMail</td>"
                . "					</tr>"
                . "					<tr>"
                . "						<td width='30%'><b>NUP:</b></td>"
                . "						<td width='100%'>$nup</td>"
                . "					</tr>"
                . "					<tr>"
                . "						<td width='30%'><b>EMAIL:</b></td>"
                . "						<td width='100%'>$correoCliente</td>"
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
            $sql = "INSERT INTO enviomail(ContactId, InteractionId, Agent, Tmstmp, Nombres, Cedula, Producto, Monto, Garante, Telefonos, Celular, Observaciones, Region, Ciudad, TipoOficina, Agencia, NUP, Correo, EnviadoD1, EnviadoD2, EnviadoCC1, EnviadoCC2, EnviadoCC3, EnviadoCC4, EstadoEnvio) "
                    . "VALUES ('$IdCliente','','$Agent','$Tmstmp','$contactname','$cedulaMail','$productoMail','$montoMail','$garanteMail','$telefonoMail','$celularMail','$Observaciones','$regionC','$ciudadC','$tipoC','$agenciaC','$nup','$correoCliente','$principalMail','$copiaMail','$CC1','$CC2','$CC3','$CC4','ENVIADO')";
            return ejecutarConsulta1($sql);
        } else {
            echo $oMail->ErrorInfo;
            $sql = "INSERT INTO enviomail(ContactId, InteractionId, Agent, Tmstmp, Nombres, Cedula, Producto, Monto, Garante, Telefonos, Celular, Observaciones, Region, Ciudad, TipoOficina, Agencia, NUP, Correo, EnviadoD1, EnviadoD2, EnviadoCC1, EnviadoCC2, EnviadoCC3, EnviadoCC4, EstadoEnvio) "
                    . "VALUES ('$IdCliente','','$Agent','$Tmstmp','$contactname','$cedulaMail','$productoMail','$montoMail','$garanteMail','$telefonoMail','$celularMail','$Observaciones','$regionC','$ciudadC','$tipoC','$agenciaC','$nup','$correoCliente','$principalMail','$copiaMail','$CC1','$CC2','$CC3','$CC4','NO ENVIADO')";
            return ejecutarConsulta1($sql);
        }
    }

}

?>