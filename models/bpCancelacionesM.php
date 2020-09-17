<?php

require '../config/connection.php';

Class cancelacionesM {

    public function _construct() { /* Constructor */
    }

    function selectAll() { //mostrar todos los registros
        $sql = "SELECT c.ID, c.CampaignId, c.ImportId, c.CODIGO_CAMPANIA, c.NOMBRE_CAMPANIA,"
                . "c.IDENTIFICACION, c.NOMBRE_CLIENTE, cc.LastAgent 'Agent', c.ResultLevel2 "
                . "FROM clientes c, cck.contactimportcontact cc  "
                . "where c.Id = cc.id and cc.LastAgent = '$_SESSION[usu]' "
                . "and (cc.action = 'reciclar base' or cc.action = 'asignar base') and cc.action <> 'cancelar base' ";
        return ejecutarConsulta7($sql);
    }

    function selectAllRec() { //mostrar todos los registros //or cc.action = 'Reciclar Base'
        $sql = "SELECT g.ID, g.CampaignId, g.ImportId, g.CODIGO_CAMPANIA, g.NOMBRE_CAMPANIA, "
                . "g.IDENTIFICACION, g.NOMBRE_CLIENTE, g.Agent 'Agent', g.ResultLevel2, g.managementresultcode "
                . "from gestionfinal g, cck.contactimportcontact c "
                . "where g.contactid = c.id and c.LastAgent = '$_SESSION[usu]' and "
                . "( c.LastManagementResult >= '60' and c.LastManagementResult <= '64'  "
                . "or c.LastManagementResult = '34' ) and (c.action <> 'cancelar base' and c.ACTION = 'gestionado')";
        return ejecutarConsulta7($sql);
    }

    function selectById($Id) { //mostrar un registro
        $sql = "SELECT * FROM clientes where id = '$Id'";
        return ejecutarConsultaSimple7($sql);
    }

    function selectByIdRec($Id) { //mostrar un registro
        $sql = "SELECT * FROM gestionfinal where id = '$Id'";
        return ejecutarConsultaSimple7($sql);
    }

    function updateTelf($IdC, $Num, $Agent, $EstadoF, $Tmstmp) { //mostrar todos los registros
        $sql = "Update contactimportphone set Agente = '$Agent', Estado = '$EstadoF', FechaHora ='$Tmstmp'"
                . "where ContactId = '$IdC' and NumeroMarcado = '$Num'";
        return ejecutarConsulta($sql);
    }

    function updateClientes($IdCliente, $Agent, $level1, $level2, $mangementCode, $Tmstmp, $intentos) { //mostrar todos los registros
        $sql = "Update clientes set lastagent = '$Agent', ResultLevel1 = '$level1', ResultLevel2 = '$level2', "
                . " ManagementResultDescription = '', ManagementResultCode = '$mangementCode', "
                . " TmStmp = '$Tmstmp', Intentos = '$intentos' where Id = '$IdCliente'";
        return ejecutarConsulta7($sql);
    }

    function insertGestionFinal($IdCliente, $Agent, $level1, $level2, $mangementCode, $Tmstmp, $time, $intentos, $contactAddress, $interactionId, $FechaAgendamiento, $TelefonoAd, $Observaciones, $pregunta1, $pregunta1_1, $pregunta2, $pregunta3, $respuesta1, $respuesta1_1, $respuesta2, $respuesta3) { //mostrar todos los registros
        $sql = "INSERT INTO gestionfinal(VCC, CampaignId, ContactId, ContactName, ContactAddress, InteractionId, ImportId, Agent, ResultLevel1, ResultLevel2, ResultLevel3, ManagementResultCode, ManagementResultDescription, StartedManagement, TmStmp, Intentos, FechaAgendamiento, Telefono2, Observaciones, ID, CODIGO_CAMPANIA, NOMBRE_CAMPANIA, IDENTIFICACION, NOMBRE_CLIENTE, TARJETA_SOCIO, ESTADO, MARCA, TIPO, FAMILIA, PRODUCTO, SUBSEGMENTO, PREGUNTA1, PREGUNTA1_1, PREGUNTA2, PREGUNTA3, RESPUESTA1, RESPUESTA1_1, RESPUESTA2, RESPUESTA3)"
                . "SELECT VCC, CampaignId, '$IdCliente', ContactName, '$contactAddress', '$interactionId', ImportId, '$Agent', '$level1', '$level2', '', '$mangementCode', '', '$time', '$Tmstmp', '$intentos','$FechaAgendamiento','$TelefonoAd','$Observaciones',                                       ID, CODIGO_CAMPANIA, NOMBRE_CAMPANIA, IDENTIFICACION, NOMBRE_CLIENTE, TARJETA_SOCIO, ESTADO, MARCA, TIPO, FAMILIA, PRODUCTO, SUBSEGMENTO, '$pregunta1', '$pregunta1_1', '$pregunta2', '$pregunta3', '$respuesta1', '$respuesta1_1', '$respuesta2', '$respuesta3'"
                . "FROM clientes where Id = '$IdCliente' ";
        return ejecutarConsulta7($sql);
    }

    function updateGestionFinal($IdCliente, $Agent, $level1, $level2, $mangementCode, $Tmstmp, $time, $intentos, $contactAddress, $interactionId, $FechaAgendamiento, $TelefonoAd, $Observaciones, $pregunta1, $pregunta1_1, $pregunta2, $pregunta3, $respuesta1, $respuesta1_1, $respuesta2, $respuesta3) {
        $sql = "UPDATE gestionfinal SET ContactAddress = '$contactAddress', InteractionId = '$interactionId', "
                . "Agent = '$Agent', ResultLevel1 = '$level1', ResultLevel2 = '$level2', ResultLevel3 = '', ManagementResultDescription = '', "
                . "ManagementResultCode = '$mangementCode', Intentos = '$intentos', FechaAgendamiento = '$FechaAgendamiento', "
                . "Telefono2 = '$TelefonoAd', Observaciones = '$Observaciones', TmStmp = '$Tmstmp', StartedManagement = '$time', "
                . "PREGUNTA1='$pregunta1',PREGUNTA1_1='$pregunta1_1',PREGUNTA2='$pregunta2',PREGUNTA3='$pregunta3',RESPUESTA1='$respuesta1',RESPUESTA1_1='$respuesta1_1',RESPUESTA2='$respuesta2',RESPUESTA3='$respuesta3' "
                . "where ContactId = '$IdCliente'";
        return ejecutarConsulta7($sql);
    }
    
    function insertGestionHistorica($IdCliente) { //mostrar todos los registros
        $sql = "insert into gestionhistorica select * from gestionfinal where Id = '$IdCliente' ";
        return ejecutarConsulta7($sql);
    }

}

?>