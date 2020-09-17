<?php

require '../config/connection.php';

Class ecuasistenciasM {

    public function _construct() { /* Constructor */
    }

    function selectAll() { //mostrar todos los registros
        $sql = "SELECT c.ContactId, c.CampaignId, c.ImportId, c.Identificacion, c.Nombres, c.Cuenta, c.Tarjeta, c.TipoPlan, "
                . "c.ContactId, cc.LastAgent 'Agent' FROM clientes c JOIN cck.contactimportcontact cc on c.ContactId = cc.id "
                . "where cc.LastAgent = '$_SESSION[usu]' and (cc.action = 'reciclar base' or cc.action = 'asignar base') and cc.action <> 'cancelar base'";
        return ejecutarConsulta2($sql);
    }

    function selectAllRec() { //mostrar todos los registros //or cc.action = 'Reciclar Base'
        $sql = "SELECT c.ContactId, c.CampaignId, c.ImportId, c.Identificacion, c.Nombres, c.Cuenta, "
                . "c.Tarjeta, c.TipoPlan, c.ContactId, c.managementresultcode, c.Agent 'Agent' "
                . "from gestionfinal c, cck.contactimportcontact i "
                . "where c.ContactId = i.id and i.LastAgent = '$_SESSION[usu]' and (i.LastManagementResult >= 18 "
                . "and i.LastManagementResult <= 23 ) and (i.action <> 'cancelar base' and i.ACTION = 'gestionado') ";
        return ejecutarConsulta2($sql);
    }

    function selectById($Id) { //mostrar un registro
        $sql = "SELECT * FROM clientes where contactid = '$Id'";
        return ejecutarConsultaSimple2($sql);
    }

    function selectByIdRec($Id) { //mostrar un registro
        $sql = "SELECT * FROM gestionfinal where contactid = '$Id'";
        return ejecutarConsultaSimple2($sql);
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
                . " where ContactId = '$IdCliente' and vcc = '$_SESSION[vcc]'";
        return ejecutarConsulta2($sql);
    }

    function insertGestionFinal($IdCliente, $Agent, $level1, $level2, $level3, $mangementCode, $time, $Tmstmp, $intentos, $contactname, $contactAddress, $FechaAgenda, $HoraAgenda, $TelefonoAd, $Observaciones, $planAceptado) { //mostrar todos los registros
        $sql = "INSERT INTO gestionfinal(VCC, CampaignId, ContactId, ContactName, ContactAddress, ImportId, Agent, ResultLevel1, ResultLevel2, ResultLevel3, ManagementResultCode, ManagementResultDescription, StartedManagement, TmsTmp, Observaciones, Intentos, FechaAgenda, HoraAgenda, TelefonoAgenda, Identificacion, Nombres, Telefono1, Telefono2, Telefono3, Telefono4, Telefono5, Telefono6, region, provincia, Ciudad, Genero, Email, Cuenta, Tarjeta, TipoPlan, TelefonoRetroalimentado, EstadoTelefono) "
                . "SELECT VCC, CampaignId, '$IdCliente','$contactname','$contactAddress',ImportId, '$Agent', '$level1', '$level2', '$level3', '$mangementCode', '', '$time','$Tmstmp','$Observaciones','$intentos','$FechaAgenda','$HoraAgenda','$TelefonoAd',Identificacion, Nombres, Telefono1, Telefono2, Telefono3, Telefono4, Telefono5, Telefono6, region, provincia, Ciudad, Genero, Email, Cuenta, Tarjeta, TipoPlan, '$planAceptado', EstadoTelefono "
                . "FROM clientes where ContactId = '$IdCliente'";
        return ejecutarConsulta2($sql);
    }

    function updateGestionFinal($IdCliente, $Agent, $level1, $level2, $level3, $mangementCode, $time, $Tmstmp, $intentos, $contactname, $contactAddress, $FechaAgenda, $HoraAgenda, $TelefonoAd, $Observaciones, $planAceptado) {
        $sql = "UPDATE gestionfinal SET ContactName = '$contactname', ContactAddress = '$contactAddress', "
                . "Agent = '$Agent', ResultLevel1 = '$level1', ResultLevel2 = '$level2', ResultLevel3 = '$level3', "
                . "ManagementResultCode = '$mangementCode', ManagementResultDescription = '', "
                . "Intentos = '$intentos', FechaAgenda = '$FechaAgenda', StartedManagement = '$time', "
                . "HoraAgenda = '$HoraAgenda', TelefonoAgenda = '$TelefonoAd', Observaciones = '$Observaciones', "
                . "TelefonoRetroalimentado = '$planAceptado', TmStmp = '$Tmstmp' where ContactId = '$IdCliente'";
        return ejecutarConsulta2($sql);
    }

}

?>