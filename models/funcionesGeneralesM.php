<?php

require '../config/connection.php';

Class funciones {

    public function _construct() { /* Constructor */
    }
    
    function updateTelf($IdC, $Num, $Agent, $Estado, $fechaInicio, $Tmstmp, $InteractionId) { //mostrar todos los registros
        $sql = "Update contactimportphone set Agente = '$Agent', Estado = '$Estado', FechaHoraFin ='$Tmstmp', "
                . "FechaHora ='$fechaInicio', InteractionId = '$InteractionId' "
                . "where ContactId = '$IdC' and NumeroMarcado = '$Num'";
        return ejecutarConsulta($sql);
    }

}

?>