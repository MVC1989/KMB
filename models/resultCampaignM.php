<?php

require '../config/connection.php';

Class resultCampaignM {

    public function _construct() { /* Constructor */
    }

    function selectAll() { //mostrar todos los registros
        $sql = "SELECT Id, VCC, CampaignId, Code, Level1, Level2, Level3, case when State = 1 then 'ACTIVO' else 'INACTIVO' end 'State' FROM campaignresultmanagement";
        return ejecutarConsulta($sql);
    }

    function selectById($Id) { //mostrar un registro
        $sql = "SELECT Id, VCC, CampaignId, Code, Description, Isgoal, Level1, Level2, Level3, ManagementResultDescription FROM campaignresultmanagement where Id = '$Id' ";
        return ejecutarConsultaSimple($sql);
    }

    function desactivate($Id) { //eliminación lógica
        $sql = "UPDATE campaignresultmanagement SET State= '0', WHERE Id = '$Id'";
        return ejecutarConsulta($sql);
    }

    function active($Id) { //activación lógica
        $sql = "UPDATE campaignresultmanagement SET State= '1' WHERE Id = '$Id'";
        return ejecutarConsulta($sql);
    }

    function insert($campaign, $level1, $level2, $level3, $code, $state, $user, $date) { //inserción de datos
        $sql = "INSERT INTO campaignresultmanagement(VCC,CampaignId, Level1, level2, level3, code, state, TmStmp, UserCreates) VALUES('1',$campaign','$level1','$level2','$level3','$code','$state', '$date', '$user')";
        return ejecutarConsulta($sql);
    }

    function update($Id, $level1, $level2, $level3, $code, $state, $user, $date) { //actualización de datos
        $sql = "UPDATE campaignresultmanagement SET VCC = '1', Level1='$level1', Level2='$level2', Level3='$level3', code='$code', State='$state', TmStmp = '$date', UserEdits = '$user' WHERE Id = '$Id'";
        return ejecutarConsulta($sql);
    }

}

?>