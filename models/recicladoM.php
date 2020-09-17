<?php

require '../config/connection.php';

Class recicladoM {

    public function _construct() { /* Constructor */
    }

    function selectAll($campaign) { //mostrar todos los registros
        $sql = "SELECT ID, Name, Identification, Campaign, LastManagementResult, LastUpdate, LastAgent, TmStmpShift, UserShift, Action"
                . " FROM contactimportcontact WHERE Action <> 'Cancelar Base' and Action <> '' and Action <> 'Asignar base'"
                . "and Campaign = '$campaign'";
        return ejecutarConsulta($sql);
    }

    function regestionablesOpc1($campaign, $import) { //mostrar todos los registros
        $sql = "SELECT ID, Name, Identification, Campaign, LastManagementResult, LastUpdate, LastAgent, TmStmpShift, UserShift, Action"
                . " FROM contactimportcontact WHERE Action = 'Gestionado' and number > 0 and Campaign = '$campaign' "
                . "and lastupdate = '$import' and (LastManagementResult >= '60' and LastManagementResult <= '64' )";
        return ejecutarConsulta($sql);
    }

    function rellamadosOpc1($campaign, $import) { //mostrar todos los registros
        $sql = "SELECT ID, Name, Identification, Campaign, LastManagementResult, LastUpdate, LastAgent, TmStmpShift, UserShift, Action"
                . " FROM contactimportcontact WHERE Action = 'Gestionado' and number > 0 and Campaign = '$campaign' "
                . "and lastupdate = '$import' and LastManagementResult = '34' ";
        return ejecutarConsulta($sql);
    }

    function regestionablesOpc2($campaign, $import) { //mostrar todos los registros
        $sql = "SELECT ID, Name, Identification, Campaign, LastManagementResult, LastUpdate, LastAgent, TmStmpShift, UserShift, Action"
                . " FROM contactimportcontact WHERE Action = 'Gestionado' and number > 0 and Campaign = '$campaign' "
                . " and lastupdate = '$import' and (LastManagementResult = '19' or LastManagementResult = '21' or "
                . " LastManagementResult = '22' or LastManagementResult = '23' )";
        return ejecutarConsulta($sql);
    }

    function rellamadosOpc2($campaign, $import) { //mostrar todos los registros
        $sql = "SELECT ID, Name, Identification, Campaign, LastManagementResult, LastUpdate, LastAgent, Action"
                . " FROM contactimportcontact WHERE Action = 'Gestionado' and number > 0 and Campaign = '$campaign' "
                . "and lastupdate = '$import' and (LastManagementResult = '18' or LastManagementResult = '20' )";
        return ejecutarConsulta($sql);
    }
    
    function registrosDisponibles($campaign, $import) { //mostrar todos los registros
        $sql = "SELECT ID, Name, Identification, Campaign, LastManagementResult, LastUpdate, LastAgent, Action"
                . " FROM contactimportcontact WHERE Action = 'Retirar base' and number > 0 and Campaign = '$campaign' "
                . " and lastupdate = '$import' ";
        return ejecutarConsulta($sql);
    }
}

?>