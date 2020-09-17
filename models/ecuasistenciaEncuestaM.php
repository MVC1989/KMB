<?php

require '../config/connection.php';

Class ecuasistenciaEncuestaM {

    public function _construct() { /* Constructor */
    }

    function selectAll() { //mostrar todos los registros
        $sql = "SELECT c.ID, c.CampaignId, c.ImportId, c.TITULAR, c.BENEFICIARIO,"
                . "c.CONTRATO, c.ASISTENCIA, cc.LastAgent 'Agent', c.ResultLevel2 "
                . "FROM clientes c, cck.contactimportcontact cc  "
                . "where c.Id = cc.id and cc.LastAgent = '$_SESSION[usu]' "
                . "and (cc.action = 'reciclar base' or cc.action = 'asignar base') and cc.action <> 'cancelar base' ";
        return ejecutarConsulta6($sql);
    }

    function selectAllRec() { //mostrar todos los registros //or cc.action = 'Reciclar Base'
        $sql = "SELECT g.ID, g.CampaignId, g.ImportId, g.TITULAR, g.BENEFICIARIO, "
                . "g.CONTRATO, g.ASISTENCIA, g.Agent 'Agent', g.ResultLevel2, g.managementresultcode "
                . "from gestionfinal g, cck.contactimportcontact c "
                . "where g.contactid = c.id and c.LastAgent = '$_SESSION[usu]' and "
                . "( c.LastManagementResult >= '18' and c.LastManagementResult <= '23') "
                . "and (c.action <> 'cancelar base' and c.ACTION = 'gestionado')";
        return ejecutarConsulta6($sql);
    }

    function selectById($Id) { //mostrar un registro
        $sql = "SELECT * FROM clientes where id = '$Id'";
        return ejecutarConsultaSimple6($sql);
    }

    function selectByIdRec($Id) { //mostrar un registro
        $sql = "SELECT * FROM gestionfinal where id = '$Id'";
        return ejecutarConsultaSimple6($sql);
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
        return ejecutarConsulta6($sql);
    }

    function insertGestionFinal($IdCliente, $contactAddress, $Agent, $level1, $level2, $level3, $mangementCode, $time, $Tmstmp, $intentos, $FechaAgendamiento, $TelefonoAd, $Observaciones, $pregunta1, $pregunta1_1, $pregunta2, $pregunta2_1, $pregunta3, $pregunta3_1, $pregunta4, $respuesta1, $respuesta1_1, $respuesta2, $respuesta2_VEH1, $respuesta2_VEH2, $respuesta2_VEH3, $respuesta2_VEH4, $respuesta2_VEH5, $respuesta2_VEH6, $respuesta2_HOG1, $respuesta2_HOG2, $respuesta2_HOG3, $respuesta2_HOG4, $respuesta2_HOG5, $respuesta2_PER1, $respuesta2_PER2, $respuesta2_PER3, $respuesta2_PER4, $respuesta2_PER5, $respuesta2_LEG1, $respuesta2_LEG2, $respuesta2_LEG3, $respuesta3, $respuesta3_1, $respuesta4, $pregunta1_ANT, $pregunta2_ANT, $pregunta3_ANT, $pregunta4_ANT, $pregunta5_ANT, $pregunta6_ANT, $pregunta6_1_ANT, $pregunta7_ANT, $pregunta7_1_ANT, $pregunta8_ANT, $pregunta8_1_ANT, $pregunta9_ANT, $pregunta9_1_ANT, $pregunta10_ANT, $pregunta11_ANT, $respuesta1_ANT, $respuesta2_ANT, $respuesta3_ANT, $respuesta4_ANT, $respuesta5_ANT, $respuesta6_ANT, $respuesta6_1_ANT, $respuesta7_ANT, $respuesta7_1_ANT, $respuesta8_ANT, $respuesta8_1_ANT, $respuesta9_ANT, $respuesta9_1_ANT, $respuesta10_ANT, $respuesta11_ANT, $pregunta1_VEH_EQ, $respuesta1_VEH_EQ, $pregunta2_VEH_EQ, $respuesta2_VEH_EQ, $pregunta3_VEH_EQ, $respuesta3_VEH_EQ, $pregunta4_VEH_EQ, $respuesta4_VEH_EQ, $pregunta5_VEH_EQ, $respuesta5_VEH_EQ, $pregunta5_1_VEH_EQ, $respuesta5_1_VEH_EQ, $pregunta6_VEH_EQ, $respuesta6_VEH_EQ, $pregunta6_1_VEH_EQ, $respuesta6_1_VEH_EQ, $pregunta7_VEH_EQ, $respuesta7_VEH_EQ, $pregunta7_1_VEH_EQ, $respuesta7_1_VEH_EQ, $pregunta8_VEH_EQ, $respuesta8_VEH_EQ, $respuesta8_1_VEH_EQ, $pregunta8_1_VEH_EQ, $pregunta9_VEH_EQ, $respuesta9_VEH_EQ, $pregunta10_VEH_EQ, $respuesta10_VEH_EQ) { //mostrar todos los registros
        $sql = "INSERT INTO gestionfinal(VCC, CampaignId, ContactId, ContactName, ContactAddress, ImportId, Agent, ResultLevel1, ResultLevel2, ResultLevel3, ManagementResultCode, ManagementResultDescription, StartedManagement, TmStmp, Intentos, FechaAgendamiento, Telefono2, Observaciones, ID, TIPO_CONTRATO, CONTRATO, ASISTENCIA, FECHA_ALTA, TITULAR, BENEFICIARIO, PROVINCIA, LOCALIDAD, LUGAR_DE_ASISTENCIA, PLACA, BASTIDOR, MARCA, COLOR, MODELO, SERVICIO, CAUSA, AVERIA, EN_CARTERA, FECHA_COORDINACION, OPERADOR_COORDINACION, MOVIMIENTO_ECONOMICO, IMPORTE, TIPO_MOV, ESTADO_MOV, CANCELADO, TIPO, PREGUNTA1, PREGUNTA1_1, PREGUNTA2, PREGUNTA2_1, PREGUNTA3, PREGUNTA3_1, PREGUNTA4, RESPUESTA1, RESPUESTA1_1, RESPUESTA2, RESPUESTA2_1_VEH1, RESPUESTA2_1_VEH2, RESPUESTA2_1_VEH3, RESPUESTA2_1_VEH4, RESPUESTA2_1_VEH5, RESPUESTA2_1_VEH6, RESPUESTA2_1_HOG1, RESPUESTA2_1_HOG2, RESPUESTA2_1_HOG3, RESPUESTA2_1_HOG4, RESPUESTA2_1_HOG5, RESPUESTA2_1_PER1, RESPUESTA2_1_PER2, RESPUESTA2_1_PER3, RESPUESTA2_1_PER4, RESPUESTA2_1_PER5, RESPUESTA2_1_LEG1, RESPUESTA2_1_LEG2, RESPUESTA2_1_LEG3, RESPUESTA3, RESPUESTA3_1, RESPUESTA4, PREGUNTA1_ANT, PREGUNTA2_ANT, PREGUNTA3_ANT, PREGUNTA4_ANT, PREGUNTA5_ANT, PREGUNTA6_ANT, PREGUNTA6_1_ANT, PREGUNTA7_ANT, PREGUNTA7_1_ANT, PREGUNTA8_ANT, PREGUNTA8_1_ANT, PREGUNTA9_ANT, PREGUNTA9_1_ANT, PREGUNTA10_ANT, PREGUNTA11_ANT, RESPUESTA1_ANT, RESPUESTA2_ANT, RESPUESTA3_ANT, RESPUESTA4_ANT, RESPUESTA5_ANT, RESPUESTA6_ANT, RESPUESTA6_1_ANT, RESPUESTA7_ANT, RESPUESTA7_1_ANT, RESPUESTA8_ANT, RESPUESTA8_1_ANT, RESPUESTA9_ANT, RESPUESTA9_1_ANT, RESPUESTA10_ANT, RESPUESTA11_ANT, PREGUNTA1_VEH_EQ, PREGUNTA2_VEH_EQ, PREGUNTA3_VEH_EQ, PREGUNTA4_VEH_EQ, PREGUNTA5_VEH_EQ, PREGUNTA5_1_VEH_EQ, PREGUNTA6_VEH_EQ, PREGUNTA6_1_VEH_EQ, PREGUNTA7_VEH_EQ, PREGUNTA7_1_VEH_EQ, PREGUNTA8_VEH_EQ, PREGUNTA8_1_VEH_EQ, PREGUNTA9_VEH_EQ, PREGUNTA10_VEH_EQ, RESPUESTA1_VEH_EQ, RESPUESTA2_VEH_EQ, RESPUESTA3_VEH_EQ, RESPUESTA4_VEH_EQ, RESPUESTA5_VEH_EQ, RESPUESTA5_1_VEH_EQ, RESPUESTA6_VEH_EQ, RESPUESTA6_1_VEH_EQ, RESPUESTA7_VEH_EQ, RESPUESTA7_1_VEH_EQ, RESPUESTA8_VEH_EQ, RESPUESTA8_1_VEH_EQ, RESPUESTA9_VEH_EQ, RESPUESTA10_VEH_EQ) "
                . "SELECT VCC, CampaignId, '$IdCliente', ContactName, '$contactAddress',ImportId, '$Agent', '$level1', '$level2', '$level3', '$mangementCode', '', '$time', '$Tmstmp','$intentos','$FechaAgendamiento','$TelefonoAd','$Observaciones', ID, TIPO_CONTRATO, CONTRATO, ASISTENCIA, FECHA_ALTA, TITULAR, BENEFICIARIO, PROVINCIA, LOCALIDAD, LUGAR_DE_ASISTENCIA, PLACA, BASTIDOR, MARCA, COLOR, MODELO, SERVICIO, CAUSA, AVERIA, EN_CARTERA, FECHA_COORDINACION, OPERADOR_COORDINACION, MOVIMIENTO_ECONOMICO, IMPORTE, TIPO_MOV, ESTADO_MOV, CANCELADO, TIPO, '$pregunta1', '$pregunta1_1', '$pregunta2', '$pregunta2_1', '$pregunta3', '$pregunta3_1', '$pregunta4', '$respuesta1', '$respuesta1_1', '$respuesta2', '$respuesta2_VEH1', '$respuesta2_VEH2', '$respuesta2_VEH3', '$respuesta2_VEH4', '$respuesta2_VEH5', '$respuesta2_VEH6', '$respuesta2_HOG1', '$respuesta2_HOG2', '$respuesta2_HOG3', '$respuesta2_HOG4', '$respuesta2_HOG5', '$respuesta2_PER1', '$respuesta2_PER2', '$respuesta2_PER3', '$respuesta2_PER4', '$respuesta2_PER5', '$respuesta2_LEG1', '$respuesta2_LEG2', '$respuesta2_LEG3', '$respuesta3', '$respuesta3_1', '$respuesta4','$pregunta1_ANT','$pregunta2_ANT','$pregunta3_ANT','$pregunta4_ANT','$pregunta5_ANT','$pregunta6_ANT','$pregunta6_1_ANT','$pregunta7_ANT','$pregunta7_1_ANT','$pregunta8_ANT','$pregunta8_1_ANT','$pregunta9_ANT','$pregunta9_1_ANT','$pregunta10_ANT','$pregunta11_ANT', '$respuesta1_ANT','$respuesta2_ANT','$respuesta3_ANT','$respuesta4_ANT','$respuesta5_ANT','$respuesta6_ANT','$respuesta6_1_ANT','$respuesta7_ANT','$respuesta7_1_ANT','$respuesta8_ANT','$respuesta8_1_ANT','$respuesta9_ANT','$respuesta9_1_ANT','$respuesta10_ANT','$respuesta11_ANT','$pregunta1_VEH_EQ','$pregunta2_VEH_EQ','$pregunta3_VEH_EQ','$pregunta4_VEH_EQ','$pregunta5_VEH_EQ','$pregunta5_1_VEH_EQ','$pregunta6_VEH_EQ','$pregunta6_1_VEH_EQ','$pregunta7_VEH_EQ','$pregunta7_1_VEH_EQ','$pregunta8_VEH_EQ','$pregunta8_1_VEH_EQ','$pregunta9_VEH_EQ','$pregunta10_VEH_EQ','$respuesta1_VEH_EQ','$respuesta2_VEH_EQ','$respuesta3_VEH_EQ','$respuesta4_VEH_EQ','$respuesta5_VEH_EQ','$respuesta5_1_VEH_EQ','$respuesta6_VEH_EQ','$respuesta6_1_VEH_EQ','$respuesta7_VEH_EQ','$respuesta7_1_VEH_EQ','$respuesta8_VEH_EQ','$respuesta8_1_VEH_EQ','$respuesta9_VEH_EQ','$respuesta10_VEH_EQ' "
                . "FROM clientes where Id = '$IdCliente' ";
        return ejecutarConsulta6($sql);
    }

    function updateGestionFinal($IdCliente, $contactAddress, $Agent, $level1, $level2, $level3, $mangementCode, $time, $Tmstmp, $intentos, $FechaAgendamiento, $TelefonoAd, $Observaciones, $pregunta1, $pregunta1_1, $pregunta2, $pregunta2_1, $pregunta3, $pregunta3_1, $pregunta4, $respuesta1, $respuesta1_1, $respuesta2, $respuesta2_VEH1, $respuesta2_VEH2, $respuesta2_VEH3, $respuesta2_VEH4, $respuesta2_VEH5, $respuesta2_VEH6, $respuesta2_HOG1, $respuesta2_HOG2, $respuesta2_HOG3, $respuesta2_HOG4, $respuesta2_HOG5, $respuesta2_PER1, $respuesta2_PER2, $respuesta2_PER3, $respuesta2_PER4, $respuesta2_PER5, $respuesta2_LEG1, $respuesta2_LEG2, $respuesta2_LEG3, $respuesta3, $respuesta3_1, $respuesta4, $pregunta1_ANT, $pregunta2_ANT, $pregunta3_ANT, $pregunta4_ANT, $pregunta5_ANT, $pregunta6_ANT, $pregunta6_1_ANT, $pregunta7_ANT, $pregunta7_1_ANT, $pregunta8_ANT, $pregunta8_1_ANT, $pregunta9_ANT, $pregunta9_1_ANT, $pregunta10_ANT, $pregunta11_ANT, $respuesta1_ANT, $respuesta2_ANT, $respuesta3_ANT, $respuesta4_ANT, $respuesta5_ANT, $respuesta6_ANT, $respuesta6_1_ANT, $respuesta7_ANT, $respuesta7_1_ANT, $respuesta8_ANT, $respuesta8_1_ANT, $respuesta9_ANT, $respuesta9_1_ANT, $respuesta10_ANT, $respuesta11_ANT, $pregunta1_VEH_EQ, $respuesta1_VEH_EQ, $pregunta2_VEH_EQ, $respuesta2_VEH_EQ, $pregunta3_VEH_EQ, $respuesta3_VEH_EQ, $pregunta4_VEH_EQ, $respuesta4_VEH_EQ, $pregunta5_VEH_EQ, $respuesta5_VEH_EQ, $pregunta5_1_VEH_EQ, $respuesta5_1_VEH_EQ, $pregunta6_VEH_EQ, $respuesta6_VEH_EQ, $pregunta6_1_VEH_EQ, $respuesta6_1_VEH_EQ, $pregunta7_VEH_EQ, $respuesta7_VEH_EQ, $pregunta7_1_VEH_EQ, $respuesta7_1_VEH_EQ, $pregunta8_VEH_EQ, $respuesta8_VEH_EQ, $respuesta8_1_VEH_EQ, $pregunta8_1_VEH_EQ, $pregunta9_VEH_EQ, $respuesta9_VEH_EQ, $pregunta10_VEH_EQ, $respuesta10_VEH_EQ) {
        $sql = "UPDATE gestionfinal SET ContactAddress = '$contactAddress', "
                . "Agent = '$Agent', ResultLevel1 = '$level1', ResultLevel2 = '$level2', ResultLevel3 = '$level3', ManagementResultDescription = '', "
                . "ManagementResultCode = '$mangementCode', StartedManagement = '$time', TmStmp = '$Tmstmp', Intentos = '$intentos', FechaAgendamiento = '$FechaAgendamiento', "
                . "Telefono2 = '$TelefonoAd', Observaciones = '$Observaciones', PREGUNTA1='$pregunta1',PREGUNTA1_1='$pregunta1_1',PREGUNTA2='$pregunta2',PREGUNTA2_1='$pregunta2_1',PREGUNTA3='$pregunta3',PREGUNTA3_1='$pregunta3_1',PREGUNTA4='$pregunta4',RESPUESTA1='$respuesta1',RESPUESTA1_1='$respuesta1_1',RESPUESTA2='$respuesta2',RESPUESTA2_1_VEH1='$respuesta2_VEH1',RESPUESTA2_1_VEH2='$respuesta2_VEH2',RESPUESTA2_1_VEH3='$respuesta2_VEH3',RESPUESTA2_1_VEH4='$respuesta2_VEH4',RESPUESTA2_1_VEH5='$respuesta2_VEH5',RESPUESTA2_1_VEH6='$respuesta2_VEH6',RESPUESTA2_1_HOG1='$respuesta2_HOG1',RESPUESTA2_1_HOG2='$respuesta2_HOG2',RESPUESTA2_1_HOG3='$respuesta2_HOG3',RESPUESTA2_1_HOG4='$respuesta2_HOG4',RESPUESTA2_1_HOG5='$respuesta2_HOG5',RESPUESTA2_1_PER1='$respuesta2_PER1',RESPUESTA2_1_PER2='$respuesta2_PER2',RESPUESTA2_1_PER3='$respuesta2_PER3',RESPUESTA2_1_PER4='$respuesta2_PER4',RESPUESTA2_1_PER5='$respuesta2_PER5',RESPUESTA2_1_LEG1='$respuesta2_LEG1',RESPUESTA2_1_LEG2='$respuesta2_LEG2',RESPUESTA2_1_LEG3='$respuesta2_LEG3',RESPUESTA3='$respuesta3',RESPUESTA3_1='$respuesta3_1',RESPUESTA4='$respuesta4',PREGUNTA1_ANT='$pregunta1_ANT',PREGUNTA2_ANT='$pregunta2_ANT',PREGUNTA3_ANT='$pregunta3_ANT',PREGUNTA4_ANT='$pregunta4_ANT',PREGUNTA5_ANT='$pregunta5_ANT',PREGUNTA6_ANT='$pregunta6_ANT',PREGUNTA6_1_ANT='$pregunta6_1_ANT',PREGUNTA7_ANT='$pregunta7_ANT',PREGUNTA7_1_ANT='$pregunta7_1_ANT',PREGUNTA8_ANT='$pregunta8_ANT',PREGUNTA8_1_ANT='$pregunta8_1_ANT',PREGUNTA9_ANT='$pregunta9_ANT',PREGUNTA9_1_ANT='$pregunta9_1_ANT',PREGUNTA10_ANT='$pregunta10_ANT',PREGUNTA11_ANT='$pregunta11_ANT',RESPUESTA1_ANT='$respuesta1_ANT',RESPUESTA2_ANT='$respuesta2_ANT',RESPUESTA3_ANT='$respuesta3_ANT',RESPUESTA4_ANT='$respuesta4_ANT',RESPUESTA5_ANT='$respuesta5_ANT',RESPUESTA6_ANT='$respuesta6_ANT',RESPUESTA6_1_ANT='$respuesta6_1_ANT',RESPUESTA7_ANT='$respuesta7_ANT',RESPUESTA7_1_ANT='$respuesta7_1_ANT',RESPUESTA8_ANT='$respuesta8_ANT',RESPUESTA8_1_ANT='$respuesta8_1_ANT',RESPUESTA9_ANT='$respuesta9_ANT',RESPUESTA9_1_ANT='$respuesta9_1_ANT',RESPUESTA10_ANT='$respuesta10_ANT',RESPUESTA11_ANT='$respuesta11_ANT',PREGUNTA1_VEH_EQ='$pregunta1_VEH_EQ',PREGUNTA2_VEH_EQ='$pregunta2_VEH_EQ',PREGUNTA3_VEH_EQ='$pregunta3_VEH_EQ',PREGUNTA4_VEH_EQ='$pregunta4_VEH_EQ',PREGUNTA5_VEH_EQ='$pregunta5_VEH_EQ',PREGUNTA5_1_VEH_EQ='$pregunta5_1_VEH_EQ',PREGUNTA6_VEH_EQ='$pregunta6_VEH_EQ',PREGUNTA6_1_VEH_EQ='$pregunta6_1_VEH_EQ',PREGUNTA7_VEH_EQ='$pregunta7_VEH_EQ',PREGUNTA7_1_VEH_EQ='$pregunta7_1_VEH_EQ',PREGUNTA8_VEH_EQ='$pregunta8_VEH_EQ',PREGUNTA8_1_VEH_EQ='$pregunta8_1_VEH_EQ',PREGUNTA9_VEH_EQ='$pregunta9_VEH_EQ',PREGUNTA10_VEH_EQ='$pregunta10_VEH_EQ',RESPUESTA1_VEH_EQ='$respuesta1_VEH_EQ',RESPUESTA2_VEH_EQ='$respuesta2_VEH_EQ',RESPUESTA3_VEH_EQ='$respuesta3_VEH_EQ',RESPUESTA4_VEH_EQ='$respuesta4_VEH_EQ',RESPUESTA5_VEH_EQ='$respuesta5_VEH_EQ',RESPUESTA5_1_VEH_EQ='$respuesta5_1_VEH_EQ',RESPUESTA6_VEH_EQ='$respuesta6_VEH_EQ',RESPUESTA6_1_VEH_EQ='$respuesta6_1_VEH_EQ',RESPUESTA7_VEH_EQ='$respuesta7_VEH_EQ',RESPUESTA7_1_VEH_EQ='$respuesta7_1_VEH_EQ',RESPUESTA8_VEH_EQ='$respuesta8_VEH_EQ',RESPUESTA8_1_VEH_EQ='$respuesta8_1_VEH_EQ',RESPUESTA9_VEH_EQ='$respuesta9_VEH_EQ',RESPUESTA10_VEH_EQ='$respuesta10_VEH_EQ' "
                . "where ContactId = '$IdCliente' ";
        return ejecutarConsulta6($sql);
    }

    function insertGestionHistorica($IdCliente) { //mostrar todos los registros
        $sql = "insert into gestionhistorica select * from gestionfinal where Id = '$IdCliente' ";
        return ejecutarConsulta6($sql);
    }

}

?>