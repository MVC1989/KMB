<?php

require '../config/connection.php';

Class detalleBaseM {

    public function _construct() { /* Constructor */
    }

    function selectAll($base) { //mostrar todos los registros
        $sql = "SELECT COUNT(c.LastManagementResult) 'Cantidad', c.LastManagementResult 'Codigo', "
                . "CASE WHEN c.LastManagementResult = '' THEN ''  ELSE cp.level1 END 'level1', "
                . "CASE WHEN c.LastManagementResult = '' THEN ''  ELSE cp.level2 END 'level2', "
                . "CASE WHEN c.LastManagementResult = '' THEN ''  ELSE cp.level3 END 'level3', "
                . "c.lastupdate 'Import', c.campaign 'Campaign' FROM `contactimportcontact` c "
                . "LEFT JOIN campaignresultmanagement cp on c.lastmanagementresult = cp.code AND "
                . "c.campaign = cp.CampaignId where c.lastupdate like '%$base%' and Action <> 'cancelar base' "
                . "group by c.LastManagementResult, c.campaign, c.lastupdate "
                . "ORDER BY `c`.`lastupdate`, c.LastManagementResult";
        return ejecutarConsulta($sql);
    }
    
    function selectAllAsesor($asesor) { //mostrar todos los registros
        $sql = "SELECT COUNT(c.LastManagementResult) 'Cantidad', c.LastManagementResult 'Codigo', "
                . "CASE WHEN c.LastManagementResult = '' THEN ''  ELSE cp.level1 END 'level1', "
                . "CASE WHEN c.LastManagementResult = '' THEN ''  ELSE cp.level2 END 'level2', "
                . "CASE WHEN c.LastManagementResult = '' THEN ''  ELSE cp.level3 END 'level3', "
                . "c.lastagent, c.campaign, c.lastupdate FROM `contactimportcontact` c "
                . "LEFT JOIN campaignresultmanagement cp on c.lastmanagementresult = cp.code AND "
                . "c.campaign = cp.CampaignId "
                . "where c.lastAgent like '%$asesor%' and  Action <> 'cancelar base' "
                . "group by c.LastManagementResult, c.campaign, c.lastagent, c.lastupdate "
                . "ORDER BY c.lastupdate, `c`.`lastagent`, c.LastManagementResult ASC";
        return ejecutarConsulta($sql);
    }

}

?>