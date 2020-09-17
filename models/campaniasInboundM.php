<?php

require '../config/connection.php';

Class TRX {

    public function _construct() { /* Constructor */
    }

    function selectAll($txtFechaInicio,$txtFechaFin,$txtCoop,$Agent) { //mostrar todos los registros
        $sql = "SELECT ID,COOPERATIVA, AGENT,substr(tmstmp,1,10) as Fecha,
                EstadoLlamada, Identificacion, NombreCliente, CiudadCliente,
                EstadoCliente, MotivoLlamada, SubmotivoLlamada
                FROM campaniasinbound.trx
                WHERE TMSTMP BETWEEN '$txtFechaInicio 00:00:00' AND '$txtFechaFin 23:59:59'
                AND Cooperativa like '%$txtCoop%' and agent = '$Agent' ";
        return ejecutarConsulta($sql);
    }

    function insert($Agent,$time,$Tmstmp,$txtCooperativa,$txtTipoLlamada,$txtEstadoLlamada,$txtIdentificacion,$txtNombreCliente,$txtCiudadCliente,$txtCelular,$txtConvencional,$txtCorreo,$txtTipoCliente,$txtTerceraPersona,$txtMotivoLlamada,$txtSubmotivoLlamada,$txtObservaciones,$txtEstadoCliente,$txtEstadoEncuesta,$txtObservacionesEncuesta,$pregunta1,$respuesta1,$pregunta2,$respuesta2,$pregunta3,$respuesta3,$pregunta4,$respuesta4,$pregunta5,$respuesta5,$pregunta6,$respuesta6,$pregunta7,$respuesta7,$pregunta8,$respuesta8,$pregunta9,$respuesta9,$pregunta10,$respuesta10) { //inserción de datos
        $sql = "INSERT INTO trx(Agent, StartedManagement, TmStmp, Cooperativa, TipoLlamada, EstadoLlamada, Identificacion, NombreCliente, CiudadCliente, Celular, Convencional, Correo, TipoCliente, TerceraPersona, MotivoLlamada, SubmotivoLlamada, Observaciones, EstadoCliente, EstadoEncuesta,ObservacionesEncuesta, pregunta1, respuesta1, pregunta2, respuesta2, pregunta3, respuesta3, pregunta4, respuesta4, pregunta5, respuesta5, pregunta6, respuesta6, pregunta7, respuesta7, pregunta8, respuesta8, pregunta9, respuesta9, pregunta10, respuesta10) VALUES ("
                . " '$Agent','$time','$Tmstmp','$txtCooperativa','$txtTipoLlamada','$txtEstadoLlamada','$txtIdentificacion','$txtNombreCliente','$txtCiudadCliente','$txtCelular','$txtConvencional','$txtCorreo','$txtTipoCliente','$txtTerceraPersona','$txtMotivoLlamada','$txtSubmotivoLlamada','$txtObservaciones','$txtEstadoCliente','$txtEstadoEncuesta','$txtObservacionesEncuesta','$pregunta1','$respuesta1','$pregunta2','$respuesta2','$pregunta3','$respuesta3','$pregunta4','$respuesta4','$pregunta5','$respuesta5','$pregunta6','$respuesta6','$pregunta7','$respuesta7','$pregunta8','$respuesta8','$pregunta9','$respuesta9','$pregunta10','$respuesta10')";
        return ejecutarConsulta14($sql);
    }

    function update($IdCliente,$Agent,$time,$Tmstmp1,$txtCooperativa,$txtTipoLlamada,$txtEstadoLlamada,$txtIdentificacion,$txtNombreCliente,$txtCiudadCliente,$txtCelular,$txtConvencional,$txtCorreo,$txtTipoCliente,$txtTerceraPersona,$txtMotivoLlamada,$txtSubmotivoLlamada,$txtObservaciones,$txtEstadoCliente,$txtEstadoEncuesta,$txtObservacionesEncuesta,$pregunta1,$respuesta1,$pregunta2,$respuesta2,$pregunta3,$respuesta3,$pregunta4,$respuesta4,$pregunta5,$respuesta5,$pregunta6,$respuesta6,$pregunta7,$respuesta7,$pregunta8,$respuesta8,$pregunta9,$respuesta9,$pregunta10,$respuesta10) { //actualización de datos
        $sql = "UPDATE trx SET Agent='$Agent',StartedManagement='$time',TmStmp='$Tmstmp1',Cooperativa='$txtCooperativa',TipoLlamada='$txtTipoLlamada', EstadoLlamada='$txtEstadoLlamada',Identificacion='$txtIdentificacion',NombreCliente='$txtNombreCliente',CiudadCliente='$txtCiudadCliente',Celular='$txtCelular',Convencional='$txtConvencional',Correo='$txtCorreo',TipoCliente='$txtTipoCliente',TerceraPersona='$txtTerceraPersona',MotivoLlamada='$txtMotivoLlamada',SubmotivoLlamada='$txtSubmotivoLlamada',Observaciones='$txtObservaciones',EstadoCliente='$txtEstadoCliente',EstadoEncuesta='$txtEstadoEncuesta',ObservacionesEncuesta='$txtObservacionesEncuesta',pregunta1='$pregunta1',respuesta1='$respuesta1',pregunta2='$pregunta2',respuesta2='$respuesta2',pregunta3='$pregunta3',respuesta3='$respuesta3',pregunta4='$pregunta4',respuesta4='$respuesta4',pregunta5='$pregunta5',respuesta5='$respuesta5',pregunta6='$pregunta6',respuesta6='$respuesta6',pregunta7='$pregunta7',respuesta7='$respuesta7',pregunta8='$pregunta8',respuesta8='$respuesta8',pregunta9='$pregunta9',respuesta9='$respuesta9',pregunta10='$pregunta10',respuesta10='$respuesta10' "
                . "WHERE Id = '$IdCliente' ";
        return ejecutarConsulta14($sql);
    }
    
    function delete($Id) { //eliminación fisica
        $sql = "DELETE FROM TRX WHERE ID = '$Id'";
        return ejecutarConsulta14($sql);
    }

    function selectById($Id) { //mostrar un registro
        $sql = "SELECT * FROM campaniasinbound.trx where id = '$Id'";
        return ejecutarConsultaSimple($sql);
    }

}

?>