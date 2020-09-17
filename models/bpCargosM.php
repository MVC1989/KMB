<?php

require '../config/connection.php';

Class cargosRecurrentesM {

    public function _construct() { /* Constructor */
    }

    function selectAll() { //mostrar todos los registros
        $sql = "SELECT c.ID, c.CampaignId, c.ImportId, c.CODIGO_CAMPANIA, c.NOMBRE_CAMPANIA,"
                . "c.IDENTIFICACION, c.NOMBRE_CLIENTE, cc.LastAgent 'Agent', c.ResultLevel2 "
                . "FROM clientes c, cck.contactimportcontact cc  "
                . "where c.Id = cc.id and cc.LastAgent = '$_SESSION[usu]' "
                . "and (cc.action = 'reciclar base' or cc.action = 'asignar base') and cc.action <> 'cancelar base' ";
        return ejecutarConsulta4($sql);
    }

    function selectAllRec() { //mostrar todos los registros //or cc.action = 'Reciclar Base'
        $sql = "SELECT g.ID, g.CampaignId, g.ImportId, g.CODIGO_CAMPANIA, g.NOMBRE_CAMPANIA, "
                . "g.IDENTIFICACION, g.NOMBRE_CLIENTE, g.Agent 'Agent', g.ResultLevel2, g.managementresultcode "
                . "from gestionfinal g, cck.contactimportcontact c "
                . "where g.contactid = c.id and c.LastAgent = '$_SESSION[usu]' and "
                . "( c.LastManagementResult >= '60' and c.LastManagementResult <= '64'  "
                . "or c.LastManagementResult = '34' ) and (c.action <> 'cancelar base' and c.ACTION = 'gestionado')";
        return ejecutarConsulta4($sql);
    }

    function selectById($Id) { //mostrar un registro
        $sql = "SELECT * FROM clientes where id = '$Id'";
        return ejecutarConsultaSimple4($sql);
    }

    function selectByIdRec($Id) { //mostrar un registro
        $sql = "SELECT * FROM gestionfinal where id = '$Id'";
        return ejecutarConsultaSimple4($sql);
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
        return ejecutarConsulta4($sql);
    }

    function insertGestionFinal($IdCliente, $Agent, $level1, $level2, $mangementCode, $Tmstmp, $time, $intentos, $contactAddress, $interactionId, $FechaAgendamiento, $TelefonoAd, $Observaciones, $telefonia, $txtExcluirTelefonia, $Internet, $txtExcluirInternet, $Television, $txtExcluirTelevision, $Movil, $txtExcluirMovil, $Triple, $txtExcluirTriple) { //mostrar todos los registros
        $sql = "INSERT INTO gestionfinal(VCC, CampaignId, ContactId, ContactName, ContactAddress, InteractionId, ImportId, Agent, ResultLevel1, ResultLevel2, ResultLevel3, ManagementResultCode, ManagementResultDescription, Intentos, FechaAgendamiento, Telefono2, Observaciones, TmStmp, HORA_GESTION, ID, CODIGO_CAMPANIA, NOMBRE_CAMPANIA, IDENTIFICACION, NOMBRE_CLIENTE, TELEFONIA_FIJA, INTERNET_FIJO, TELEVISION, MOVIL, PLAN_RECOMPENSAS, CUATRO_ULTIMOS_DIGITOS_TC, DES_ESTABLECIMIENTO, FAMILIA, PRODUCTO, PRIMER_APELLIDO, SEGUNDO_APELLIDO, PRIMER_NOMBRE, SEGUNDO_NOMBRE, CORREO1, CORREO2, CORREO3, ESTADO_CIVIL, TIENE_TARJETA, ZONA, REGION_ANCLAJE, OBSERVACION_TELEFONIA, OBSERVACION_INTERNET, OBSERVACION_TELEVISION, OBSERVACION_MOVIL, OBSERVACIONES_TRIPLEPACK, EXCLUIR_TELEFONIA, EXCLUIR_INTERNET, EXCLUIR_TELEVISION, EXCLUIR_MOVIL, EXCLUIR_TRIPLEPACK)"
                . "SELECT VCC, CampaignId, '$IdCliente', ContactName, '$contactAddress', '$interactionId', ImportId, '$Agent', '$level1', '$level2', '', '$mangementCode', '','$intentos','$FechaAgendamiento','$TelefonoAd','$Observaciones','$Tmstmp', '$time', ID, CODIGO_CAMPANIA, NOMBRE_CAMPANIA, IDENTIFICACION, NOMBRE_CLIENTE, TELEFONIA_FIJA, INTERNET_FIJO, TELEVISION, MOVIL, PLAN_RECOMPENSAS, CUATRO_ULTIMOS_DIGITOS_TC, DES_ESTABLECIMIENTO, FAMILIA, PRODUCTO, PRIMER_APELLIDO, SEGUNDO_APELLIDO, PRIMER_NOMBRE, SEGUNDO_NOMBRE, CORREO1, CORREO2, CORREO3, ESTADO_CIVIL, TIENE_TARJETA, ZONA, REGION_ANCLAJE, '$telefonia', '$Internet', '$Television', '$Movil', '$Triple', '$txtExcluirTelefonia', '$txtExcluirInternet', '$txtExcluirTelevision', '$txtExcluirMovil', '$txtExcluirTriple' "
                . "FROM clientes where Id = '$IdCliente' ";
        return ejecutarConsulta4($sql);
    }

    function updateGestionFinal($IdCliente, $Agent, $level1, $level2, $mangementCode, $Tmstmp, $time, $intentos, $contactAddress, $interactionId, $FechaAgendamiento, $TelefonoAd, $Observaciones, $telefonia, $txtExcluirTelefonia, $Internet, $txtExcluirInternet, $Television, $txtExcluirTelevision, $Movil, $txtExcluirMovil, $Triple, $txtExcluirTriple) {
        $sql = "UPDATE gestionfinal SET ContactAddress = '$contactAddress', InteractionId = '$interactionId', "
                . "Agent = '$Agent', ResultLevel1 = '$level1', ResultLevel2 = '$level2', ResultLevel3 = '', ManagementResultDescription = '', "
                . "ManagementResultCode = '$mangementCode', Intentos = '$intentos', FechaAgendamiento = '$FechaAgendamiento', "
                . "Telefono2 = '$TelefonoAd', Observaciones = '$Observaciones', TmStmp = '$Tmstmp', HORA_GESTION = '$time', "
                . "OBSERVACION_TELEFONIA = '$telefonia', OBSERVACION_INTERNET = '$Internet', OBSERVACION_TELEVISION = '$Television', "
                . "OBSERVACION_MOVIL = '$Movil', OBSERVACIONES_TRIPLEPACK = '$Triple', EXCLUIR_TELEFONIA = '$txtExcluirTelefonia', EXCLUIR_INTERNET = '$txtExcluirInternet', "
                . "EXCLUIR_TELEVISION = '$txtExcluirTelevision', EXCLUIR_MOVIL = '$txtExcluirMovil', EXCLUIR_TRIPLEPACK = '$txtExcluirTriple' "
                . "where ContactId = '$IdCliente'";
        return ejecutarConsulta4($sql);
    }
    
    function insertGestionHistorica($IdCliente) { //mostrar todos los registros
        $sql = "insert into gestionhistorica select * from gestionfinal where Id = '$IdCliente' ";
        return ejecutarConsulta4($sql);
    }

}

?>