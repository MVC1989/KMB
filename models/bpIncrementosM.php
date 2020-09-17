<?php

require '../config/connection.php';

Class incrementosM {

    public function _construct() { /* Constructor */
    }

    function selectAll() { //mostrar todos los registros
        $sql = "SELECT c.ID, c.CampaignId, c.ImportId, c.CODIGO_CAMPANIA, c.NOMBRE_CAMPANIA,"
                . "c.IDENTIFICACION, c.NOMBRE_CLIENTE, cc.LastAgent 'Agent', c.ResultLevel2 "
                . "FROM clientes c, cck.contactimportcontact cc  "
                . "where c.Id = cc.id and cc.LastAgent = '$_SESSION[usu]' "
                . "and (cc.action = 'reciclar base' or cc.action = 'asignar base') and cc.action <> 'cancelar base' ";
        return ejecutarConsulta5($sql);
    }

    function selectAllRec() { //mostrar todos los registros //or cc.action = 'Reciclar Base'
        $sql = "SELECT g.ID, g.CampaignId, g.ImportId, g.CODIGO_CAMPANIA, g.NOMBRE_CAMPANIA, "
                . "g.IDENTIFICACION, g.NOMBRE_CLIENTE, g.Agent 'Agent', g.ResultLevel2, g.managementresultcode "
                . "from gestionfinal g, cck.contactimportcontact c "
                . "where g.contactid = c.id and c.LastAgent = '$_SESSION[usu]' and "
                . "( c.LastManagementResult >= '60' and c.LastManagementResult <= '64'  "
                . "or c.LastManagementResult = '34' ) and (c.action <> 'cancelar base' and c.ACTION = 'gestionado')";
        return ejecutarConsulta5($sql);
    }

    function selectById($Id) { //mostrar un registro
        $sql = "SELECT * FROM clientes where id = '$Id'";
        return ejecutarConsultaSimple5($sql);
    }

    function selectByIdRec($Id) { //mostrar un registro
        $sql = "SELECT * FROM gestionfinal where id = '$Id'";
        return ejecutarConsultaSimple5($sql);
    }

    function updateTelf($IdC, $Num, $Agent, $Estado, $Tmstmp) { //mostrar todos los registros
        $sql = "Update contactimportphone set Agente = '$Agent', Estado = '$Estado', FechaHora ='$Tmstmp'"
                . "where ContactId = '$IdC' and NumeroMarcado = '$Num'";
        return ejecutarConsulta($sql);
    }

    function updateClientes($IdCliente, $Agent, $level1, $level2, $mangementCode, $Tmstmp, $intentos, $interactionId) { //mostrar todos los registros
        $sql = "Update clientes set lastagent = '$Agent', ResultLevel1 = '$level1', ResultLevel2 = '$level2', "
                . " ManagementResultDescription = '', ManagementResultCode = '$mangementCode', interactionId = '$interactionId', "
                . " TmStmp = '$Tmstmp', Intentos = '$intentos' where Id = '$IdCliente'";
        return ejecutarConsulta5($sql);
    }

    function insertGestionFinal($IdCliente, $Agent, $level1, $level2, $mangementCode, $Tmstmp, $time, $intentos, $contactAddress, $interactionId, $FechaAgendamiento, $TelefonoAd, $Observaciones, $valorIncremento, $fechaIncremento, $txtCambio, $valorCambioIncremento) { //mostrar todos los registros
        $sql = "INSERT INTO gestionfinal(VCC, CampaignId, ContactId, ContactName, ContactAddress, InteractionId, ImportId, Agent, ResultLevel1, ResultLevel2, ResultLevel3, ManagementResultCode, ManagementResultDescription, Intentos, FechaAgendamiento, Telefono2, Observaciones, TmStmp, HORA_GESTION, ID, CODIGO_CAMPANIA, NOMBRE_CAMPANIA, IDENTIFICACION, NOMBRE_CLIENTE, ZONA, REGION, SUBSEGMENTO, EDAD, ESTADO_CIVIL, SEXO, NOMBRE_PRODUCTO, NUMERO_CUENTA, ESTADO_DE_CTA_AHORRO_FUTURO, DESCRIPCION, FUTURE_VALUE_SAVINGS_ARRANGEMENT, MONTO, VALIDADOR, SALDO, MONTO_SUGERIDO_AH_FUT, ANIO_APERTURA, PROVINCIA_DOMICILIO, CIUDAD_DOMICILIO, DIRECCION_DOMICILIO, PROVINCIA_TRABAJO, CIUDAD_TRABAJO, DIRECCION_TRABAJO, TIENE_MC, TIENE_VI, CUENTA_DEBITO, ESTADO_CUENTA_TRANSACCIONAL, DESCRIPCION1, SALDO_PROMEDIO, TIENE_DEUDA_PROTEGIDA, EXEQUIAL, VIDA_SEGURA, PROTECCION_FRAUDE, FECHA_APERTURA_AH_FUTURO, DIA_DEBITO_AH_FUTURO, VALOR_INCREMENTO, CAMBIO_AHORRO, CAMBIO_FECHA, ACTUALIZAR_AHORRO)"
                . "SELECT VCC, CampaignId, '$IdCliente', ContactName, '$contactAddress', '$interactionId', ImportId, '$Agent', '$level1', '$level2', '', '$mangementCode', '','$intentos','$FechaAgendamiento','$TelefonoAd','$Observaciones','$Tmstmp', '$time', ID, CODIGO_CAMPANIA, NOMBRE_CAMPANIA, IDENTIFICACION, NOMBRE_CLIENTE, ZONA, REGION, SUBSEGMENTO, EDAD, ESTADO_CIVIL, SEXO, NOMBRE_PRODUCTO, NUMERO_CUENTA, ESTADO_DE_CTA_AHORRO_FUTURO, DESCRIPCION, FUTURE_VALUE_SAVINGS_ARRANGEMENT, MONTO, VALIDADOR, SALDO, MONTO_SUGERIDO_AH_FUT, ANIO_APERTURA, PROVINCIA_DOMICILIO, CIUDAD_DOMICILIO, DIRECCION_DOMICILIO, PROVINCIA_TRABAJO, CIUDAD_TRABAJO, DIRECCION_TRABAJO, TIENE_MC, TIENE_VI, CUENTA_DEBITO, ESTADO_CUENTA_TRANSACCIONAL, DESCRIPCION1, SALDO_PROMEDIO, TIENE_DEUDA_PROTEGIDA, EXEQUIAL, VIDA_SEGURA, PROTECCION_FRAUDE, FECHA_APERTURA_AH_FUTURO, DIA_DEBITO_AH_FUTURO, '$valorIncremento', '$txtCambio', '$fechaIncremento', '$valorCambioIncremento' "
                . "FROM clientes where Id = '$IdCliente' ";
        return ejecutarConsulta5($sql);
    }

    function updateGestionFinal($IdCliente, $Agent, $level1, $level2, $mangementCode, $Tmstmp, $time, $intentos, $contactAddress, $interactionId, $FechaAgendamiento, $TelefonoAd, $Observaciones, $valorIncremento, $fechaIncremento, $txtCambio, $valorCambioIncremento) {
        $sql = "UPDATE gestionfinal SET ContactAddress = '$contactAddress', interactionId = '$interactionId', "
                . "Agent = '$Agent', ResultLevel1 = '$level1', ResultLevel2 = '$level2', ResultLevel3 = '', ManagementResultDescription = '', "
                . "ManagementResultCode = '$mangementCode', Intentos = '$intentos', FechaAgendamiento = '$FechaAgendamiento', "
                . "Telefono2 = '$TelefonoAd', Observaciones = '$Observaciones', TmStmp = '$Tmstmp', HORA_GESTION = '$time', "
                . "VALOR_INCREMENTO = '$valorIncremento', CAMBIO_AHORRO = '$txtCambio', CAMBIO_FECHA = '$fechaIncremento', ACTUALIZAR_AHORRO = '$valorCambioIncremento' "
                . "where ContactId = '$IdCliente'";
        return ejecutarConsulta5($sql);
    }
    
    function insertGestionHistorica($IdCliente) { //mostrar todos los registros
        $sql = "insert into gestionhistorica select * from gestionfinal where Id = '$IdCliente' ";
        return ejecutarConsulta5($sql);
    }

}

?>