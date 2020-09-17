<?php

require '../config/connection.php';

Class claroM {

    public function _construct() { /* Constructor */
    }

    function selectAll() { //mostrar todos los registros
        $sql = "SELECT c.ID, c.CampaignId, c.ImportId, c.IDENTIFICACION, c.NOMBRES,"
                . "cc.LastAgent 'Agent', c.ResultLevel2 "
                . "FROM clientes c, cck.contactimportcontact cc  "
                . "where c.Id = cc.id and cc.LastAgent = '$_SESSION[usu]' "
                . "and (cc.action = 'reciclar base' or cc.action = 'asignar base') and cc.action <> 'cancelar base' ";
        return ejecutarConsulta10($sql);
    }

    function selectAllRec() { //mostrar todos los registros //or cc.action = 'Reciclar Base'
        $sql = "SELECT g.ID, g.CampaignId, g.ImportId, g.IDENTIFICACION, g.NOMBRES, "
                . "g.Agent 'Agent', g.ResultLevel2, g.managementresultcode "
                . "from gestionfinal g, cck.contactimportcontact c "
                . "where g.contactid = c.id and c.LastAgent = '$_SESSION[usu]' and "
                . "( c.LastManagementResult >= '18' and c.LastManagementResult <= '23') "
                . "and (c.action <> 'cancelar base' and c.ACTION = 'gestionado')";
        return ejecutarConsulta10($sql);
    }

    function selectById($Id) { //mostrar un registro
        $sql = "SELECT * FROM clientes where id = '$Id'";
        return ejecutarConsultaSimple10($sql);
    }

    function selectByIdRec($Id) { //mostrar un registro
        $sql = "SELECT * FROM gestionfinal where id = '$Id'";
        return ejecutarConsultaSimple10($sql);
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
        return ejecutarConsulta10($sql);
    }

    function insertGestionFinal($IdCliente, $contactAddress, $Agent, $level1, $level2, $level3, $mangementCode, $time, $Tmstmp, $intentos, $FechaAgendamiento, $TelefonoAd, $Observaciones, $IDENTIFICACION, $NOMBRES,$CORREO, $ESTADO_CIVIL, $REGION_PROVINCIA, $FECHA_NACIMIENTO, $TIPO_DEBITO, $NUMERO_DEBITO, $CVV, $OPERADORA_ACTUAL, $NUMERO_REFERENCIA, $CODIGO_PLAN, $DIRECCION) { //mostrar todos los registros
        $sql = "INSERT INTO gestionfinal(VCC, CampaignId, ContactId, ContactName, ContactAddress, ImportId, Agent, ResultLevel1, ResultLevel2, ResultLevel3, ManagementResultCode, ManagementResultDescription, StartedManagement, TmStmp, Intentos, FechaAgendamiento, Telefono2, Observaciones, ID, IDENTIFICACION, NOMBRES, CORREO, ESTADO_CIVIL, REGION_PROVINCIA, FECHA_NACIMIENTO, TIPO_DEBITO, NUMERO_DEBITO, CODIGO_SEGURIDAD, OPERADORA_ACTUAL, DIRECCION, NUMERO_REFERENCIA, CODIGO_PLAN) "
                . "SELECT VCC, CampaignId, '$IdCliente', ContactName, '$contactAddress',ImportId, '$Agent', '$level1', '$level2', '$level3', '$mangementCode', '', '$time', '$Tmstmp','$intentos','$FechaAgendamiento','$TelefonoAd','$Observaciones', ID, '$IDENTIFICACION', '$NOMBRES','$CORREO','$ESTADO_CIVIL','$REGION_PROVINCIA','$FECHA_NACIMIENTO','$TIPO_DEBITO','$NUMERO_DEBITO','$CVV','$OPERADORA_ACTUAL','$DIRECCION','$NUMERO_REFERENCIA','$CODIGO_PLAN' "
                . "FROM clientes where Id = '$IdCliente' ";
        return ejecutarConsulta10($sql);
    }

    function updateGestionFinal($IdCliente, $contactAddress, $Agent, $level1, $level2, $level3, $mangementCode, $time, $Tmstmp, $intentos, $FechaAgendamiento, $TelefonoAd, $Observaciones, $IDENTIFICACION, $NOMBRES,$CORREO, $ESTADO_CIVIL, $REGION_PROVINCIA, $FECHA_NACIMIENTO, $TIPO_DEBITO, $NUMERO_DEBITO, $CVV, $OPERADORA_ACTUAL, $NUMERO_REFERENCIA, $CODIGO_PLAN, $DIRECCION) {
        $sql = "UPDATE gestionfinal SET ContactAddress = '$contactAddress', "
                . "Agent = '$Agent', ResultLevel1 = '$level1', ResultLevel2 = '$level2', ResultLevel3 = '$level3', ManagementResultDescription = '', "
                . "ManagementResultCode = '$mangementCode', StartedManagement = '$time', TmStmp = '$Tmstmp', Intentos = '$intentos', FechaAgendamiento = '$FechaAgendamiento', "
                . "Telefono2 = '$TelefonoAd', Observaciones = '$Observaciones', IDENTIFICACION='$IDENTIFICACION',NOMBRES='$NOMBRES',CORREO='$CORREO',ESTADO_CIVIL='$ESTADO_CIVIL',REGION_PROVINCIA='$REGION_PROVINCIA',FECHA_NACIMIENTO='$FECHA_NACIMIENTO',TIPO_DEBITO='$TIPO_DEBITO',NUMERO_DEBITO='$NUMERO_DEBITO', CODIGO_SEGURIDAD='$CVV',OPERADORA_ACTUAL='$OPERADORA_ACTUAL', DIRECCION='$DIRECCION',NUMERO_REFERENCIA='$NUMERO_REFERENCIA',CODIGO_PLAN='$CODIGO_PLAN' "
                . "where ContactId = '$IdCliente' ";
        return ejecutarConsulta10($sql);
    }

    function insertGestionHistorica($IdCliente) { //mostrar todos los registros
        $sql = "insert into gestionhistorica select * from gestionfinal where Id = '$IdCliente' ";
        return ejecutarConsulta10($sql);
    }

}

?>