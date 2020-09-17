<?php

require '../config/connection.php';

Class jardinesDelValleM {

    public function _construct() { /* Constructor */
    }

    function selectAll() { //mostrar todos los registros
        $sql = "SELECT c.ID, c.CampaignId, c.ImportId, c.IDENTIFICACION, c.NOMBRE_CLIENTE,"
                . "c.CIUDAD1, c.CIUDAD2, cc.LastAgent 'Agent'"
                . "FROM clientes c, cck.contactimportcontact cc  "
                . "where c.Id = cc.id and cc.LastAgent = '$_SESSION[usu]' "
                . "and (cc.action = 'reciclar base' or cc.action = 'asignar base') and cc.action <> 'cancelar base' ";
        return ejecutarConsulta13($sql);
    }

    function selectAllRec() { //mostrar todos los registros //or cc.action = 'Reciclar Base'
        $sql = "SELECT g.ID, g.CampaignId, g.ImportId, g.IDENTIFICACION, g.NOMBRE_CLIENTE, "
                . "g.CIUDAD1, g.CIUDAD2, g.Agent 'Agent', g.ResultLevel2, g.managementresultcode "
                . "from gestionfinal g, cck.contactimportcontact c "
                . "where g.contactid = c.id and c.LastAgent = '$_SESSION[usu]' and "
                . "( c.LastManagementResult >= '18' and c.LastManagementResult <= '23') "
                . "and (c.action <> 'cancelar base' and c.ACTION = 'gestionado')";
        return ejecutarConsulta13($sql);
    }

    function selectById($Id) { //mostrar un registro
        $sql = "SELECT * FROM clientes where id = '$Id'";
        return ejecutarConsultaSimple13($sql);
    }

    function selectByIdRec($Id) { //mostrar un registro
        $sql = "SELECT * FROM gestionfinal where id = '$Id'";
        return ejecutarConsultaSimple13($sql);
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
        return ejecutarConsulta13($sql);
    }

    function insertGestionFinal($IdCliente, $contactAddress, $Agent, $level1, $level2, $level3, $mangementCode, $time, $Tmstmp, $intentos, $FechaAgendamiento, $TelefonoAd, $Observaciones, $TIPO_DEBITO, $CELULAR, $TIENE_WHATSAPP, $NUMERO_TC, $FECHA_CADUCIDAD, $CODIGO_SEGURIDAD,$CORREO) { //mostrar todos los registros
        $sql = "INSERT INTO gestionfinal(VCC, CampaignId, ContactId, ContactName, ContactAddress, ImportId, Agent, ResultLevel1, ResultLevel2, ResultLevel3, ManagementResultCode, ManagementResultDescription, StartedManagement, TmStmp, Intentos, FechaAgendamiento, Telefono2, Observaciones, ID, IDENTIFICACION, NOMBRE_CLIENTE, CIUDAD1, CIUDAD2, TIPO_DEBITO, CELULAR, TIENE_WHATSAPP, NUMERO_TC, FECHA_CADUCIDAD, CODIGO_SEGURIDAD, CORREO) "
                . "SELECT VCC, CampaignId, '$IdCliente', ContactName, '$contactAddress',ImportId, '$Agent', '$level1', '$level2', '$level3', '$mangementCode', '', '$time', '$Tmstmp','$intentos','$FechaAgendamiento','$TelefonoAd','$Observaciones', ID, IDENTIFICACION, NOMBRE_CLIENTE, CIUDAD1, CIUDAD2, '$TIPO_DEBITO', '$CELULAR', '$TIENE_WHATSAPP', '$NUMERO_TC', '$FECHA_CADUCIDAD', '$CODIGO_SEGURIDAD', '$CORREO' "
                . "FROM clientes where Id = '$IdCliente' ";
        return ejecutarConsulta13($sql);
    }

    function updateGestionFinal($IdCliente, $contactAddress, $Agent, $level1, $level2, $level3, $mangementCode, $time, $Tmstmp, $intentos, $FechaAgendamiento, $TelefonoAd, $Observaciones, $TIPO_DEBITO, $CELULAR, $TIENE_WHATSAPP, $NUMERO_TC, $FECHA_CADUCIDAD, $CODIGO_SEGURIDAD, $CORREO) {
        $sql = "UPDATE gestionfinal SET ContactAddress = '$contactAddress', "
                . "Agent = '$Agent', ResultLevel1 = '$level1', ResultLevel2 = '$level2', ResultLevel3 = '$level3', ManagementResultDescription = '', "
                . "ManagementResultCode = '$mangementCode', StartedManagement = '$time', TmStmp = '$Tmstmp', Intentos = '$intentos', FechaAgendamiento = '$FechaAgendamiento', "
                . "Telefono2 = '$TelefonoAd', Observaciones = '$Observaciones', TIPO_DEBITO='$TIPO_DEBITO',CELULAR='$CELULAR',TIENE_WHATSAPP='$TIENE_WHATSAPP',NUMERO_TC='$NUMERO_TC',FECHA_CADUCIDAD='$FECHA_CADUCIDAD',CODIGO_SEGURIDAD='$CODIGO_SEGURIDAD', CORREO='$CORREO' "
                . "where ContactId = '$IdCliente' ";
        return ejecutarConsulta13($sql);
    }

    function insertGestionHistorica($IdCliente) { //mostrar todos los registros
        $sql = "insert into gestionhistorica select * from gestionfinal where Id = '$IdCliente' ";
        return ejecutarConsulta13($sql);
    }

}

?>