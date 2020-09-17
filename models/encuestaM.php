<?php

require '../config/connection.php';

Class encuestaM {

    public function _construct() { /* Constructor */
    }

    function selectAll() { //mostrar todos los registros
        $sql = "SELECT c.ID, c.CampaignId, c.ImportId, c.CODIGOCAMPANA, c.NOMBRE_CAMPANA,"
                . "c.IDENTIFICACION, c.NOMBRE_CLIENTE, cc.LastAgent 'Agent', c.ResultLevel2 FROM clientes c, cck.contactimportcontact cc  "
                . "where c.Id = cc.id and cc.LastAgent = '$_SESSION[usu]' "
                . "and (cc.action = 'reciclar base' or cc.action = 'asignar base') and cc.action <> 'cancelar base' ";
        return ejecutarConsulta3($sql);
    }

    function selectAllRec() { //mostrar todos los registros //or cc.action = 'Reciclar Base'
        $sql = "SELECT g.ID, g.CampaignId, g.ImportId, g.CODIGOCAMPANA, g.NOMBRE_CAMPANA, "
                . "g.IDENTIFICACION, g.NOMBRE_CLIENTE, g.Agent 'Agent', g.ResultLevel2, g.managementresultcode "
                . "from gestionfinal g, cck.contactimportcontact c "
                . "where g.contactid = c.id and c.LastAgent = '$_SESSION[usu]' and "
                . "( c.LastManagementResult >= '60' and c.LastManagementResult <= '64'  "
                . "or c.LastManagementResult = '34' ) and (c.action <> 'cancelar base' and c.ACTION = 'gestionado')";
        return ejecutarConsulta3($sql);
    }

    function selectById($Id) { //mostrar un registro
        $sql = "SELECT * FROM clientes where id = '$Id'";
        return ejecutarConsultaSimple3($sql);
    }

    function selectByIdRec($Id) { //mostrar un registro
        $sql = "SELECT * FROM gestionfinal where id = '$Id'";
        return ejecutarConsultaSimple3($sql);
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
        return ejecutarConsulta3($sql);
    }

    function insertGestionFinal($IdCliente, $Agent, $level1, $level2, $mangementCode, $Tmstmp, $time, $intentos, $contactname, $contactAddress, $FechaAgendamiento, $TelefonoAd, $Observaciones, $motivos, $entidad, $otros, $pagos, $depositos, $fechaV) { //mostrar todos los registros
        $sql = "INSERT INTO gestionfinal(VCC, CampaignId, ContactId, ContactName, ContactAddress, ImportId, Agent, ResultLevel1,ResultLevel2, ResultLevel3, ManagementResultCode, ManagementResultDescription, Intentos, FechaAgendamiento, Telefono2, Observaciones, TmStmp, `HORA_GESTION`, `ID`, `CODIGOCAMPANA`, `NOMBRE_CAMPANA`, `IDENTIFICACION`, `NOMBRE_CLIENTE`, `CODIGO_AGENCIA`, `AGENCIA`, `ZONA`, `REGION`, `SUBSEGMENTO`, `VAR_TOTAL_AHORROS_AGO30`, `VAR_TOTAL_AHORROS_SEP20`, `PRIORIDAD`, `FAMILIA`, `PRODUCTO`, `PLAN_RECOMPENSAS`, `COD_MARCA`, `CORREO_TRX`, `CORREO`, `PRODUCTO_1`, `CLIENTE_CONTACTADO`, `MOTIVO_VARIACION`, `ESPECIFIQUE_OTROS`, `ESPECIFIQUE_ENTIDAD_FINANCIERA`, `ESPECIFIQUE_PAGOS`, `RETORNO_VARIACION`, `FECHA_RETORNO_VARIACION`) "
                . "SELECT VCC, CampaignId, '$IdCliente', ContactName, '$contactAddress',ImportId, '$Agent', '$level1', '$level2', '', '$mangementCode', '','$intentos','$FechaAgendamiento','$TelefonoAd','$Observaciones','$Tmstmp', '$time', `ID`, `CODIGOCAMPANA`, `NOMBRE_CAMPANA`, `IDENTIFICACION`, `NOMBRE_CLIENTE`, `CODIGO_AGENCIA`, `AGENCIA`, `ZONA`, `REGION`, `SUBSEGMENTO`, `VAR_TOTAL_AHORROS_AGO30`, `VAR_TOTAL_AHORROS_SEP20`, `PRIORIDAD`, `FAMILIA`, `PRODUCTO`, `PLAN_RECOMPENSAS`, `COD_MARCA`, `CORREO_TRX`, `CORREO`, '', '', '$motivos', '$otros', '$entidad', '$pagos', '$depositos', '$fechaV' "
                . "FROM clientes where Id = '$IdCliente' and vcc = '$_SESSION[vcc]'";
        return ejecutarConsulta3($sql);
    }

    function updateGestionFinal($IdCliente, $Agent, $level1, $level2, $mangementCode, $Tmstmp, $time, $intentos, $contactname, $contactAddress, $FechaAgendamiento, $TelefonoAd, $Observaciones, $motivos, $entidad, $otros, $pagos, $depositos, $fechaV) {
        $sql = "UPDATE gestionfinal SET ContactAddress = '$contactAddress', "
                . "Agent = '$Agent', ResultLevel1 = '$level1', ResultLevel2 = '$level2', ResultLevel3 = '', ManagementResultDescription = '', "
                . "ManagementResultCode = '$mangementCode', Intentos = '$intentos', FechaAgendamiento = '$FechaAgendamiento', "
                . "Telefono2 = '$TelefonoAd', Observaciones = '$Observaciones', TmStmp = '$Tmstmp', HORA_GESTION = '$time', "
                . "MOTIVO_VARIACION = '$motivos', ESPECIFIQUE_OTROS = '$otros', ESPECIFIQUE_ENTIDAD_FINANCIERA = '$entidad', "
                . "ESPECIFIQUE_PAGOS = '$pagos', RETORNO_VARIACION = '$depositos', FECHA_RETORNO_VARIACION = '$fechaV' "
                . "where Id = '$IdCliente'";
        return ejecutarConsulta3($sql);
    }

}

?>