<?php

require '../config/connection.php';

Class bancoBGRCanalesElectronicosM {

    public function _construct() { /* Constructor */
    }

    function selectAll() { //mostrar todos los registros
        $sql = "SELECT c.ID, c.CampaignId, c.ImportId, c.IDENTIFICACION, c.NOMBRE_CLIENTE, "
                . "c.AGENCIA, c.SECCION, c.FECHA_ATENCION, cc.LastAgent 'Agent', c.ResultLevel2 "
                . "FROM clientes c, cck.contactimportcontact cc  "
                . "where c.Id = cc.id and cc.LastAgent = '$_SESSION[usu]' and c.CampaignId = 'BGR_CANALES' "
                . "and (cc.action = 'reciclar base' or cc.action = 'asignar base') and cc.action <> 'cancelar base' ";
        return ejecutarConsulta11($sql);
    }

    function selectAllRec() { //mostrar todos los registros //or cc.action = 'Reciclar Base'
        $sql = "SELECT g.ID, g.CampaignId, g.ImportId, g.IDENTIFICACION, g.NOMBRE_CLIENTE, "
                . "g.AGENCIA, g.SECCION, g.FECHA_ATENCION, g.Agent 'Agent', g.ResultLevel2, g.managementresultcode "
                . "from gestionfinalcanales g, cck.contactimportcontact c "
                . "where g.contactid = c.id and c.LastAgent = '$_SESSION[usu]' and "
                . "( c.LastManagementResult >= '18' and c.LastManagementResult <= '23') "
                . "and (c.action <> 'cancelar base' and c.ACTION = 'gestionado')";
        return ejecutarConsulta11($sql);
    }

    function selectById($Id) { //mostrar un registro
        $sql = "SELECT * FROM clientes where id = '$Id'";
        return ejecutarConsultaSimple11($sql);
    }

    function selectByIdRec($Id) { //mostrar un registro
        $sql = "SELECT * FROM gestionfinalcanales where id = '$Id'";
        return ejecutarConsultaSimple11($sql);
    }

    function updateTelf($IdC, $Num, $Agent, $EstadoF, $Tmstmp) { //mostrar todos los registros
        $sql = "Update contactimportphone set Agente = '$Agent', Estado = '$EstadoF', FechaHora ='$Tmstmp'"
                . "where ContactId = '$IdC' and NumeroMarcado = '$Num'";
        return ejecutarConsulta($sql);
    }

    function updateClientes($IdCliente, $Agent, $level1, $level2, $level3, $mangementCode, $Tmstmp, $intentos, $contactAddress) { //mostrar todos los registros
        $sql = "Update clientes set lastagent = '$Agent', ResultLevel1 = '$level1', "
                . " ResultLevel2 = '$level2', ResultLevel3 = '$level3', ManagementResultCode = '$mangementCode', "
                . " TmStmp = '$Tmstmp', Intentos = '$intentos', ContactAddress = '$contactAddress' "
                . " where ContactId = '$IdCliente'";
        return ejecutarConsulta11($sql);
    }

    function insertGestionFinal($IdCliente, $contactAddress, $Agent, $level1, $level2, $level3, $mangementCode, $time, $Tmstmp, $intentos, $FechaAgendamiento, $TelefonoAd, $Observaciones, $pregunta1, $pregunta1_1, $pregunta2, $pregunta2_1, $pregunta3, $pregunta3_1, $pregunta4, $pregunta4_1, $pregunta5, $pregunta5_1, $pregunta6, $pregunta6_1, $pregunta7, $pregunta7_1, $pregunta8, $pregunta8_1, $pregunta9, $pregunta9_1, $pregunta10, $pregunta10_1, $pregunta11, $pregunta11_1, $pregunta12, $pregunta12_1, $pregunta13, $pregunta13_1, $pregunta14, $pregunta14_1, $pregunta15, $pregunta15_1, $respuesta1, $respuesta1_1, $respuesta2, $respuesta2_1, $respuesta3, $respuesta3_1, $respuesta4, $respuesta4_1, $respuesta5, $respuesta5_1, $respuesta6, $respuesta6_1, $respuesta7, $respuesta7_1, $respuesta8, $respuesta8_1, $respuesta9, $respuesta9_1, $respuesta10, $respuesta10_1, $respuesta11, $respuesta11_1, $respuesta12, $respuesta12_1, $respuesta13, $respuesta13_1, $respuesta14, $respuesta14_1, $respuesta15, $respuesta15_1) { //mostrar todos los registros
        $sql = "INSERT INTO gestionfinalcanales(VCC, CampaignId, ContactId, ContactName, ContactAddress, ImportId, Agent, ResultLevel1, ResultLevel2, ResultLevel3, ManagementResultCode, ManagementResultDescription, StartedManagement, TmStmp, Intentos, FechaAgendamiento, Telefono2, Observaciones, ID, IDENTIFICACION, NOMBRE_CLIENTE, TIPO_CLIENTE, SEGMENTO, REGION, CODIGO_AGENCIA, AGENCIA, SECCION, AREA, USUARIO, CAJERO, TRAMITES, TIPO_TRANSACCION, TITULAR_TERCERO, CUENTA, FECHA_ATENCION, HORA_ATENCION, PREGUNTA_1, PREGUNTA_1_1, PREGUNTA_2, PREGUNTA_2_1, PREGUNTA_3, PREGUNTA_3_1, PREGUNTA_4, PREGUNTA_4_1, PREGUNTA_5, PREGUNTA_5_1, PREGUNTA_6, PREGUNTA_6_1, PREGUNTA_7, PREGUNTA_7_1, PREGUNTA_8, PREGUNTA_8_1, PREGUNTA_9, PREGUNTA_9_1, PREGUNTA_10, PREGUNTA_10_1, PREGUNTA_11, PREGUNTA_11_1, PREGUNTA_12, PREGUNTA_12_1, PREGUNTA_13, PREGUNTA_13_1, PREGUNTA_14, PREGUNTA_14_1, PREGUNTA_15, PREGUNTA_15_1, RESPUESTA_1, RESPUESTA_1_1, RESPUESTA_2, RESPUESTA_2_1, RESPUESTA_3, RESPUESTA_3_1, RESPUESTA_4, RESPUESTA_4_1, RESPUESTA_5, RESPUESTA_5_1, RESPUESTA_6, RESPUESTA_6_1, RESPUESTA_7, RESPUESTA_7_1, RESPUESTA_8, RESPUESTA_8_1, RESPUESTA_9, RESPUESTA_9_1, RESPUESTA_10, RESPUESTA_10_1, RESPUESTA_11, RESPUESTA_11_1, RESPUESTA_12, RESPUESTA_12_1, RESPUESTA_13, RESPUESTA_13_1, RESPUESTA_14, RESPUESTA_14_1, RESPUESTA_15, RESPUESTA_15_1) "
                . "SELECT VCC, CampaignId, '$IdCliente', ContactName, '$contactAddress',ImportId, '$Agent', '$level1', '$level2', '$level3', '$mangementCode', '', '$time', '$Tmstmp','$intentos','$FechaAgendamiento','$TelefonoAd','$Observaciones', ID, IDENTIFICACION, NOMBRE_CLIENTE, TIPO_CLIENTE, SEGMENTO, REGION, CODIGO_AGENCIA, AGENCIA, SECCION, AREA, USUARIO, CAJERO, TRAMITES, TIPO_TRANSACCION, TITULAR_TERCERO, CUENTA, FECHA_ATENCION, HORA_ATENCION, '$pregunta1', '$pregunta1_1', '$pregunta2', '$pregunta2_1', '$pregunta3', '$pregunta3_1', '$pregunta4', '$pregunta4_1', '$pregunta5', '$pregunta5_1', '$pregunta6', '$pregunta6_1', '$pregunta7', '$pregunta7_1', '$pregunta8', '$pregunta8_1', '$pregunta9', '$pregunta9_1', '$pregunta10', '$pregunta10_1', '$pregunta11', '$pregunta11_1', '$pregunta12', '$pregunta12_1', '$pregunta13', '$pregunta13_1', '$pregunta14', '$pregunta14_1', '$pregunta15', '$pregunta15_1', '$respuesta1', '$respuesta1_1', '$respuesta2', '$respuesta2_1', '$respuesta3', '$respuesta3_1', '$respuesta4', '$respuesta4_1', '$respuesta5', '$respuesta5_1', '$respuesta6', '$respuesta6_1', '$respuesta7', '$respuesta7_1', '$respuesta8', '$respuesta8_1', '$respuesta9', '$respuesta9_1', '$respuesta10', '$respuesta10_1', '$respuesta11', '$respuesta11_1', '$respuesta12', '$respuesta12_1', '$respuesta13', '$respuesta13_1', '$respuesta14', '$respuesta14_1', '$respuesta15', '$respuesta15_1' "
                . "FROM clientes where Id = '$IdCliente' ";
        return ejecutarConsulta11($sql);
    }

    function updateGestionFinal($IdCliente, $contactAddress, $Agent, $level1, $level2, $level3, $mangementCode, $time, $Tmstmp, $intentos, $FechaAgendamiento, $TelefonoAd, $Observaciones, $pregunta1, $pregunta1_1, $pregunta2, $pregunta2_1, $pregunta3, $pregunta3_1, $pregunta4, $pregunta4_1, $pregunta5, $pregunta5_1, $pregunta6, $pregunta6_1, $pregunta7, $pregunta7_1, $pregunta8, $pregunta8_1, $pregunta9, $pregunta9_1, $pregunta10, $pregunta10_1, $pregunta11, $pregunta11_1, $pregunta12, $pregunta12_1, $pregunta13, $pregunta13_1, $pregunta14, $pregunta14_1, $pregunta15, $pregunta15_1, $respuesta1, $respuesta1_1, $respuesta2, $respuesta2_1, $respuesta3, $respuesta3_1, $respuesta4, $respuesta4_1, $respuesta5, $respuesta5_1, $respuesta6, $respuesta6_1, $respuesta7, $respuesta7_1, $respuesta8, $respuesta8_1, $respuesta9, $respuesta9_1, $respuesta10, $respuesta10_1, $respuesta11, $respuesta11_1, $respuesta12, $respuesta12_1, $respuesta13, $respuesta13_1, $respuesta14, $respuesta14_1, $respuesta15, $respuesta15_1) {
        $sql = "UPDATE gestionfinalcanales SET ContactAddress = '$contactAddress', "
                . "Agent = '$Agent', ResultLevel1 = '$level1', ResultLevel2 = '$level2', ResultLevel3 = '$level3', ManagementResultDescription = '', "
                . "ManagementResultCode = '$mangementCode', StartedManagement = '$time', TmStmp = '$Tmstmp', Intentos = '$intentos', FechaAgendamiento = '$FechaAgendamiento', "
                . "Telefono2 = '$TelefonoAd', Observaciones = '$Observaciones', PREGUNTA_1='$pregunta1',PREGUNTA_1_1='$pregunta1_1',PREGUNTA_2='$pregunta2',PREGUNTA_2_1='$pregunta2_1',PREGUNTA_3='$pregunta3',PREGUNTA_3_1='$pregunta3_1',PREGUNTA_4='$pregunta4',PREGUNTA_4_1='$pregunta4_1',PREGUNTA_5='$pregunta5',PREGUNTA_5_1='$pregunta5_1',PREGUNTA_6='$pregunta6',PREGUNTA_6_1='$pregunta6_1',PREGUNTA_7='$pregunta7',PREGUNTA_7_1='$pregunta7_1',PREGUNTA_8='$pregunta8',PREGUNTA_8_1='$pregunta8_1',PREGUNTA_9='$pregunta9',PREGUNTA_9_1='$pregunta9_1',PREGUNTA_10='$pregunta10',PREGUNTA_10_1='$pregunta10_1',PREGUNTA_11='$pregunta11',PREGUNTA_11_1='$pregunta11_1',PREGUNTA_12='$pregunta12',PREGUNTA_12_1='$pregunta12_1',PREGUNTA_13='$pregunta13',PREGUNTA_13_1='$pregunta13_1',PREGUNTA_14='$pregunta14',PREGUNTA_14_1='$pregunta14_1',PREGUNTA_15='$pregunta15',PREGUNTA_15_1='$pregunta15_1',RESPUESTA_1='$respuesta1',RESPUESTA_1_1='$respuesta1_1',RESPUESTA_2='$respuesta2',RESPUESTA_2_1='$respuesta2_1',RESPUESTA_3='$respuesta3',RESPUESTA_3_1='$respuesta3_1',RESPUESTA_4='$respuesta4',RESPUESTA_4_1='$respuesta4_1',RESPUESTA_5='$respuesta5',RESPUESTA_5_1='$respuesta5_1',RESPUESTA_6='$respuesta6',RESPUESTA_6_1='$respuesta6_1',RESPUESTA_7='$respuesta7',RESPUESTA_7_1='$respuesta7_1',RESPUESTA_8='$respuesta8',RESPUESTA_8_1='$respuesta8_1',RESPUESTA_9='$respuesta9',RESPUESTA_9_1='$respuesta9_1',RESPUESTA_10='$respuesta10',RESPUESTA_10_1='$respuesta10_1',RESPUESTA_11='$respuesta11',RESPUESTA_11_1='$respuesta11_1',RESPUESTA_12='$respuesta12',RESPUESTA_12_1='$respuesta12_1',RESPUESTA_13='$respuesta13',RESPUESTA_13_1='$respuesta13_1',RESPUESTA_14='$respuesta14',RESPUESTA_14_1='$respuesta14_1',RESPUESTA_15='$respuesta15',RESPUESTA_15_1='$respuesta15_1' "
                . "where ContactId = '$IdCliente' ";
        return ejecutarConsulta11($sql);
    }

    function insertGestionHistorica($IdCliente) { //mostrar todos los registros
        $sql = "insert into gestionhistoricacanales select * from gestionfinalcanales where Id = '$IdCliente' ";
        return ejecutarConsulta11($sql);
    }

}

?>