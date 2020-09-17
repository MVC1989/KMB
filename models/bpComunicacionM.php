<?php

require '../config/connection.php';

Class bpComunicacionM {

    public function _construct() { /* Constructor */
    }
    
    function selectAll() { //mostrar todos los registros
        $sql = "SELECT c.ID, c.CampaignId, c.ImportId, c.IDENTIFICACION, c.NOMBRE_CLIENTE, "
                . "c.EDAD, c.REGION, c.LOCALIDAD, cc.LastAgent 'Agent', c.ResultLevel2 "
                . "FROM clientes c, cck.contactimportcontact cc  "
                . "where c.Id = cc.id and cc.LastAgent = '$_SESSION[usu]' and c.CampaignId = 'BP_COMUNICACION' "
                . "and (cc.action = 'reciclar base' or cc.action = 'asignar base') and cc.action <> 'cancelar base' ";
        return ejecutarConsulta12($sql);
    }

    function selectAllRec() { //mostrar todos los registros //or cc.action = 'Reciclar Base'
        $sql = "SELECT g.ID, g.CampaignId, g.ImportId, g.IDENTIFICACION, g.NOMBRE_CLIENTE, "
                . "g.EDAD, g.REGION, g.LOCALIDAD, g.Agent 'Agent', g.ResultLevel2, g.managementresultcode "
                . "from gestionfinal g, cck.contactimportcontact c "
                . "where g.contactid = c.id and c.LastAgent = '$_SESSION[usu]' and  "
                . "( c.LastManagementResult >= '18' and c.LastManagementResult <= '23') "
                . "and (c.action <> 'cancelar base' and c.ACTION = 'gestionado')";
        return ejecutarConsulta12($sql);
    }
	
	function selectById($Id) { //mostrar un registro
        $sql = "SELECT * FROM clientes where id = '$Id'";
        return ejecutarConsultaSimple12($sql);
    }
    
    function selectByIdRec($Id) { //mostrar un registro
        $sql = "SELECT * FROM gestionfinal where id = '$Id'";
        return ejecutarConsultaSimple12($sql);
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
        return ejecutarConsulta12($sql);
    }

    function insertGestionFinal($IdCliente, $contactAddress, $interactionId, $Agent, $level1, $level2, $level3, $mangementCode, $time, $Tmstmp, $intentos, $FechaAgendamiento, $TelefonoAd, $Observaciones, $pregunta1, $pregunta2, $pregunta3, $pregunta4, $pregunta5, $pregunta6, $pregunta7, $pregunta8, $pregunta9, $pregunta10, $pregunta11, $pregunta12, $pregunta13, $pregunta14, $pregunta15, $pregunta16, $pregunta17, $pregunta18, $pregunta19, $pregunta20, $pregunta21, $pregunta22, $pregunta23, $pregunta24, $pregunta25, $pregunta26, $pregunta27, $pregunta28, $pregunta29, $pregunta30, $respuesta1, $respuesta2, $respuesta3, $respuesta4, $respuesta5, $respuesta6, $respuesta7, $respuesta8, $respuesta9, $respuesta10, $respuesta11, $respuesta12, $respuesta13, $respuesta14, $respuesta15, $respuesta16, $respuesta17, $respuesta18, $respuesta19, $respuesta20, $respuesta21, $respuesta22, $respuesta23, $respuesta24, $respuesta25, $respuesta26, $respuesta27, $respuesta28, $respuesta29, $respuesta30) { //mostrar todos los registros
        $sql = "INSERT INTO gestionfinal(VCC, CampaignId, ContactId, ContactName, ContactAddress, InteractionId, ImportId, Agent, ResultLevel1, ResultLevel2, ResultLevel3, ManagementResultCode, ManagementResultDescription, StartedManagement, TmStmp, Intentos, FechaAgendamiento, Telefono2, Observaciones, ID, CODIGO_CAMPANIA, IDENTIFICACION, NOMBRE_CLIENTE, CAMPO1, CAMPO2, CAMPO3, CAMPO4, CAMPO5, CAMPO6, CAMPO7, CAMPO8, CAMPO9, CAMPO10, PREGUNTA_1, PREGUNTA_2, PREGUNTA_3, PREGUNTA_4, PREGUNTA_5, PREGUNTA_6, PREGUNTA_7, PREGUNTA_8, PREGUNTA_9, PREGUNTA_10, PREGUNTA_11, PREGUNTA_12, PREGUNTA_13, PREGUNTA_14, PREGUNTA_15, PREGUNTA_16, PREGUNTA_17, PREGUNTA_18, PREGUNTA_19, PREGUNTA_20, PREGUNTA_21, PREGUNTA_22, PREGUNTA_23, PREGUNTA_24, PREGUNTA_25, PREGUNTA_26, PREGUNTA_27, PREGUNTA_28, PREGUNTA_29, PREGUNTA_30, RESPUESTA_1, RESPUESTA_2, RESPUESTA_3, RESPUESTA_4, RESPUESTA_5, RESPUESTA_6, RESPUESTA_7, RESPUESTA_8, RESPUESTA_9, RESPUESTA_10, RESPUESTA_11, RESPUESTA_12, RESPUESTA_13, RESPUESTA_14, RESPUESTA_15, RESPUESTA_16, RESPUESTA_17, RESPUESTA_18, RESPUESTA_19, RESPUESTA_20, RESPUESTA_21, RESPUESTA_22, RESPUESTA_23, RESPUESTA_24, RESPUESTA_25, RESPUESTA_26, RESPUESTA_27, RESPUESTA_28, RESPUESTA_29, RESPUESTA_30) "
                . "SELECT VCC, CampaignId, '$IdCliente', ContactName, '$contactAddress', '$interactionId', ImportId, '$Agent', '$level1', '$level2', '$level3', '$mangementCode', '', '$time', '$Tmstmp','$intentos','$FechaAgendamiento','$TelefonoAd','$Observaciones', ID, CODIGO_CAMPANIA, IDENTIFICACION, NOMBRE_CLIENTE, CAMPO1, CAMPO2, CAMPO3, CAMPO4, CAMPO5, CAMPO6, CAMPO7, CAMPO8, CAMPO9, CAMPO10, '$pregunta1', '$pregunta2', '$pregunta3', '$pregunta4', '$pregunta5', '$pregunta6', '$pregunta7', '$pregunta8', '$pregunta9', '$pregunta10', '$pregunta11', '$pregunta12', '$pregunta13', '$pregunta14', '$pregunta15', '$pregunta16', '$pregunta17', '$pregunta18', '$pregunta19', '$pregunta20', '$pregunta21', '$pregunta22', '$pregunta23', '$pregunta24', '$pregunta25', '$pregunta26', '$pregunta27', '$pregunta28', '$pregunta29', '$pregunta30', '$respuesta1', '$respuesta2', '$respuesta3', '$respuesta4', '$respuesta5', '$respuesta6', '$respuesta7', '$respuesta8', '$respuesta9', '$respuesta10', '$respuesta11', '$respuesta12', '$respuesta13', '$respuesta14', '$respuesta15', '$respuesta16', '$respuesta17', '$respuesta18', '$respuesta19', '$respuesta20', '$respuesta21', '$respuesta22', '$respuesta23', '$respuesta24', '$respuesta25', '$respuesta26', '$respuesta27', '$respuesta28', '$respuesta29', '$respuesta30' "
                . "FROM clientes where Id = '$IdCliente' ";
        return ejecutarConsulta12($sql);
    }

    function updateGestionFinal($IdCliente, $contactAddress, $interactionId, $Agent, $level1, $level2, $level3, $mangementCode, $time, $Tmstmp, $intentos, $FechaAgendamiento, $TelefonoAd, $Observaciones, $pregunta1, $pregunta2, $pregunta3, $pregunta4, $pregunta5, $pregunta6, $pregunta7, $pregunta8, $pregunta9, $pregunta10, $pregunta11, $pregunta12, $pregunta13, $pregunta14, $pregunta15, $pregunta16, $pregunta17, $pregunta18, $pregunta19, $pregunta20, $pregunta21, $pregunta22, $pregunta23, $pregunta24, $pregunta25, $pregunta26, $pregunta27, $pregunta28, $pregunta29, $pregunta30, $respuesta1, $respuesta2, $respuesta3, $respuesta4, $respuesta5, $respuesta6, $respuesta7, $respuesta8, $respuesta9, $respuesta10, $respuesta11, $respuesta12, $respuesta13, $respuesta14, $respuesta15, $respuesta16, $respuesta17, $respuesta18, $respuesta19, $respuesta20, $respuesta21, $respuesta22, $respuesta23, $respuesta24, $respuesta25, $respuesta26, $respuesta27, $respuesta28, $respuesta29, $respuesta30) {
        $sql = "UPDATE gestionfinal SET ContactAddress = '$contactAddress', InteractionId = '$interactionId', "
                . "Agent = '$Agent', ResultLevel1 = '$level1', ResultLevel2 = '$level2', ResultLevel3 = '$level3', ManagementResultDescription = '', "
                . "ManagementResultCode = '$mangementCode', StartedManagement = '$time', TmStmp = '$Tmstmp', Intentos = '$intentos', FechaAgendamiento = '$FechaAgendamiento', "
                . "Telefono2 = '$TelefonoAd', Observaciones = '$Observaciones', PREGUNTA_1='$pregunta1',PREGUNTA_2='$pregunta2',PREGUNTA_3='$pregunta3',PREGUNTA_4='$pregunta4',PREGUNTA_5='$pregunta5',PREGUNTA_6='$pregunta6',PREGUNTA_7='$pregunta7',PREGUNTA_8='$pregunta8',PREGUNTA_9='$pregunta9',PREGUNTA_10='$pregunta10',PREGUNTA_11='$pregunta11',PREGUNTA_12='$pregunta12',PREGUNTA_13='$pregunta13',PREGUNTA_14='$pregunta14',PREGUNTA_15='$pregunta15',PREGUNTA_16='$pregunta16',PREGUNTA_17='$pregunta17',PREGUNTA_18='$pregunta18',PREGUNTA_19='$pregunta19',PREGUNTA_20='$pregunta20',PREGUNTA_21='$pregunta21',PREGUNTA_22='$pregunta22',PREGUNTA_23='$pregunta23',PREGUNTA_24='$pregunta24',PREGUNTA_25='$pregunta25',PREGUNTA_26='$pregunta26',PREGUNTA_27='$pregunta27',PREGUNTA_28='$pregunta28',PREGUNTA_29='$pregunta29',PREGUNTA_30='$pregunta30',RESPUESTA_1='$respuesta1',RESPUESTA_2='$respuesta2',RESPUESTA_3='$respuesta3',RESPUESTA_4='$respuesta4',RESPUESTA_5='$respuesta5',RESPUESTA_6='$respuesta6',RESPUESTA_7='$respuesta7',RESPUESTA_8='$respuesta8',RESPUESTA_9='$respuesta9',RESPUESTA_10='$respuesta10',RESPUESTA_11='$respuesta11',RESPUESTA_12='$respuesta12',RESPUESTA_13='$respuesta13',RESPUESTA_14='$respuesta14',RESPUESTA_15='$respuesta15',RESPUESTA_16='$respuesta16',RESPUESTA_17='$respuesta17',RESPUESTA_18='$respuesta18',RESPUESTA_19='$respuesta19',RESPUESTA_20='$respuesta20',RESPUESTA_21='$respuesta21',RESPUESTA_22='$respuesta22',RESPUESTA_23='$respuesta23',RESPUESTA_24='$respuesta24',RESPUESTA_25='$respuesta25',RESPUESTA_26='$respuesta26',RESPUESTA_27='$respuesta27',RESPUESTA_28='$respuesta28',RESPUESTA_29='$respuesta29',RESPUESTA_30='$respuesta30' "
                . "where ContactId = '$IdCliente' ";
        return ejecutarConsulta12($sql);
    }

    function insertGestionHistorica($IdCliente) { //mostrar todos los registros
        $sql = "insert into gestionhistorica select * from gestionfinal where Id = '$IdCliente' ";
        return ejecutarConsulta12($sql);
    }
}

?>