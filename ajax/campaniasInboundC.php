<?php

session_start();

require '../models/campaniasInboundM.php';
$TRX = new TRX();
date_default_timezone_set("America/Lima");

$Id = isset($_POST["Id"]) ? LimpiarCadena14($_POST["Id"]) : ""; //Dato estraido de la funcion mostrar_uno js

$Agent = $_SESSION['usu'];
if (isset($_POST["chkHoraFin"]) == 'checkeado') {
    $Tmstmp = isset($_POST["horaFin"]) ? LimpiarCadena14($_POST["horaFin"]) : "";
} else {
    $Tmstmp = date('Y-m-d H:i:s');
}
$Tmstmp1 = isset($_POST["horaFin"]) ? LimpiarCadena14($_POST["horaFin"]) : "";
$time = isset($_POST["horaInicio"]) ? LimpiarCadena14($_POST["horaInicio"]) : "";
$IdCliente = isset($_POST["txtId"]) ? LimpiarCadena14($_POST["txtId"]) : "";

$txtCooperativa = isset($_POST["txtCooperativa"]) ? LimpiarCadena14($_POST["txtCooperativa"]) : "";
$txtTipoLlamada = isset($_POST["txtTipoLlamada"]) ? LimpiarCadena14($_POST["txtTipoLlamada"]) : "";
$txtEstadoLlamada = isset($_POST["txtEstadoLlamada"]) ? LimpiarCadena2($_POST["txtEstadoLlamada"]) : "";
$txtIdentificacion = isset($_POST["txtIdentificacion"]) ? LimpiarCadena14($_POST["txtIdentificacion"]) : "";
$txtNombreCliente = isset($_POST["txtNombreCliente"]) ? LimpiarCadena14($_POST["txtNombreCliente"]) : "";
$txtCiudadCliente = isset($_POST["txtCiudadCliente"]) ? LimpiarCadena14($_POST["txtCiudadCliente"]) : "";
$txtCelular = isset($_POST["txtCelular"]) ? LimpiarCadena14($_POST["txtCelular"]) : "";
$txtConvencional = isset($_POST["txtConvencional"]) ? LimpiarCadena14($_POST["txtConvencional"]) : "";
$txtCorreo = isset($_POST["txtCorreo"]) ? LimpiarCadena14($_POST["txtCorreo"]) : "";
$txtTipoCliente = isset($_POST["txtTipoCliente"]) ? LimpiarCadena14($_POST["txtTipoCliente"]) : "";
$txtTerceraPersona = isset($_POST["txtTerceraPersona"]) ? LimpiarCadena14($_POST["txtTerceraPersona"]) : "";
$txtMotivoLlamada = isset($_POST["txtMotivoLlamada"]) ? LimpiarCadena14($_POST["txtMotivoLlamada"]) : "";
$txtSubmotivoLlamada = isset($_POST["txtSubmotivoLlamada"]) ? LimpiarCadena14($_POST["txtSubmotivoLlamada"]) : "";
$txtObservaciones = isset($_POST["txtObservaciones"]) ? LimpiarCadena14($_POST["txtObservaciones"]) : "";
$txtEstadoCliente = isset($_POST["txtEstadoCliente"]) ? LimpiarCadena14($_POST["txtEstadoCliente"]) : "";
$txtEstadoEncuesta = isset($_POST["txtEstadoEncuesta"]) ? LimpiarCadena14($_POST["txtEstadoEncuesta"]) : "";
$txtObservacionesEncuesta = isset($_POST["txtObservacionesEncuesta"]) ? LimpiarCadena14($_POST["txtObservacionesEncuesta"]) : "";
$pregunta1 = isset($_POST["pregunta1"]) ? LimpiarCadena14($_POST["pregunta1"]) : "";
$respuesta1 = isset($_POST["respuesta1"]) ? LimpiarCadena14($_POST["respuesta1"]) : "";
$pregunta2 = isset($_POST["pregunta2"]) ? LimpiarCadena14($_POST["pregunta2"]) : "";
$respuesta2 = isset($_POST["respuesta2"]) ? LimpiarCadena14($_POST["respuesta2"]) : "";
$pregunta3 = isset($_POST["pregunta3"]) ? LimpiarCadena14($_POST["pregunta3"]) : "";
$respuesta3 = isset($_POST["respuesta3"]) ? LimpiarCadena14($_POST["respuesta3"]) : "";
$pregunta4 = isset($_POST["pregunta4"]) ? LimpiarCadena14($_POST["pregunta4"]) : "";
$respuesta4 = isset($_POST["respuesta4"]) ? LimpiarCadena14($_POST["respuesta4"]) : "";
$pregunta5 = isset($_POST["pregunta5"]) ? LimpiarCadena14($_POST["pregunta5"]) : "";
$respuesta5 = isset($_POST["respuesta5"]) ? LimpiarCadena14($_POST["respuesta5"]) : "";
$pregunta6 = isset($_POST["pregunta6"]) ? LimpiarCadena14($_POST["pregunta6"]) : "";
$respuesta6 = isset($_POST["respuesta6"]) ? LimpiarCadena14($_POST["respuesta6"]) : "";
$pregunta7 = isset($_POST["pregunta7"]) ? LimpiarCadena14($_POST["pregunta7"]) : "";
$respuesta7 = isset($_POST["respuesta7"]) ? LimpiarCadena14($_POST["respuesta7"]) : "";
$pregunta8 = isset($_POST["pregunta8"]) ? LimpiarCadena14($_POST["pregunta8"]) : "";
$respuesta8 = isset($_POST["respuesta8"]) ? LimpiarCadena14($_POST["respuesta8"]) : "";
$pregunta9 = isset($_POST["pregunta9"]) ? LimpiarCadena14($_POST["pregunta9"]) : "";
$respuesta9 = isset($_POST["respuesta9"]) ? LimpiarCadena14($_POST["respuesta9"]) : "";
$pregunta10 = isset($_POST["pregunta10"]) ? LimpiarCadena14($_POST["pregunta10"]) : "";
$respuesta10 = isset($_POST["respuesta10"]) ? LimpiarCadena14($_POST["respuesta10"]) : "";

switch ($_GET["action"]) {
    case 'fechaInicio':
        date_default_timezone_set("America/Lima");
        echo(date('Y-m-d H:i:s'));
        break;

    case 'idCliente':
        $result = ejecutarConsultaSimple14("SELECT ID FROM TRX ORDER BY ID DESC LIMIT 1 ");
        if ($result["ID"] == '') {
            echo "0";
        } else {
            echo$result["ID"];
        }
        break;

    case 'selectAll':
        $txtCoop = isset($_POST["txtCoop"]) ? LimpiarCadena($_POST["txtCoop"]) : "";
        $txtFechaInicio = isset($_POST["txtFechaInicio"]) ? LimpiarCadena($_POST["txtFechaInicio"]) : "";
        $txtFechaFin = isset($_POST["txtFechaFin"]) ? LimpiarCadena($_POST["txtFechaFin"]) : "";
        $respuesta = $TRX->selectAll($txtFechaInicio, $txtFechaFin, $txtCoop, $Agent); /* llama a la función del modelo */
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            $datos[] = array(/* llena los resultados con los datos */
                "0" => $registrar->ID, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                "1" => $registrar->COOPERATIVA,
                "2" => $registrar->AGENT,
                "3" => $registrar->Fecha,
                "4" => $registrar->EstadoLlamada,
                "5" => $registrar->Identificacion,
                "6" => $registrar->NombreCliente,
                "7" => $registrar->CiudadCliente,
                "8" => $registrar->EstadoCliente,
                "9" => $registrar->MotivoLlamada,
                "10" => $registrar->SubmotivoLlamada,
                '<center><li title="Editar" class="fa fa-edit" style="color: purple;" onclick="mostrar_uno(' . $registrar->ID . ')"></i>&nbsp;&nbsp;&nbsp; '
                . '<li title="Eliminar" class="fa fa-trash" style="color: #3C8DBC;;" onclick="eliminar(' . $registrar->ID . ')"></i></center>'
            );
        }
        $resultados = array(
            "sEcho" => 1, /* informacion para la herramienta datatables */
            "iTotalRecords" => count($datos), /* envía el total de columnas a visualizar */
            "iTotalDisplayRecords" => count($datos), /* envia el total de filas a visualizar */
            "aaData" => $datos /* envía el arreglo completo que se llenó con el while */
        );
        echo json_encode($resultados);
        break;

    case 'selectById':
        $respuesta = $TRX->selectById($Id);
        echo json_encode($respuesta); /* envia los datos a mostrar mediante json */
        break;

    case 'estatus':
        $estatus = $_GET["motivo"];
        $result = ejecutarConsulta14("SELECT DISTINCT SUBMOTIVO FROM resultadosdegestion where estado='1' AND MOTIVO = '$estatus' "
                . "ORDER BY SUBMOTIVO");
        echo '<option></option>';
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            echo '<option value="' . $row["SUBMOTIVO"] . '">' . $row["SUBMOTIVO"] . '</option>';
        }
        break;

    case 'delete':
        $respuesta = $TRX->delete($Id);
        if ($respuesta) {
            ejecutarConsulta14("insert into trxhistorico select * from trx where Id = '$IdCliente'");
            echo "Registro eliminado con éxito";
        } else {
            echo "Error: registro no se pudo eliminar";
        }
        break;

    case 'save':
        if ($IdCliente == '') {
            $respuesta = $TRX->insert($Agent, $time, $Tmstmp, $txtCooperativa, $txtTipoLlamada, $txtEstadoLlamada, $txtIdentificacion, $txtNombreCliente, $txtCiudadCliente, $txtCelular, $txtConvencional, $txtCorreo, $txtTipoCliente, $txtTerceraPersona, $txtMotivoLlamada, $txtSubmotivoLlamada, $txtObservaciones, $txtEstadoCliente, $txtEstadoEncuesta, $txtObservacionesEncuesta, $pregunta1, $respuesta1, $pregunta2, $respuesta2, $pregunta3, $respuesta3, $pregunta4, $respuesta4, $pregunta5, $respuesta5, $pregunta6, $respuesta6, $pregunta7, $respuesta7, $pregunta8, $respuesta8, $pregunta9, $respuesta9, $pregunta10, $respuesta10);
            if ($respuesta) {
                ejecutarConsulta14("insert into trxhistorico select * from trx where Id = '$IdCliente'");
                echo "Registro almacenado con éxito";
            } else {
                echo "Error: registro no se pudo almacenar";
            }
        } else {
            $respuesta = $TRX->update($IdCliente, $Agent, $time, $Tmstmp1, $txtCooperativa, $txtTipoLlamada, $txtEstadoLlamada, $txtIdentificacion, $txtNombreCliente, $txtCiudadCliente, $txtCelular, $txtConvencional, $txtCorreo, $txtTipoCliente, $txtTerceraPersona, $txtMotivoLlamada, $txtSubmotivoLlamada, $txtObservaciones, $txtEstadoCliente, $txtEstadoEncuesta, $txtObservacionesEncuesta, $pregunta1, $respuesta1, $pregunta2, $respuesta2, $pregunta3, $respuesta3, $pregunta4, $respuesta4, $pregunta5, $respuesta5, $pregunta6, $respuesta6, $pregunta7, $respuesta7, $pregunta8, $respuesta8, $pregunta9, $respuesta9, $pregunta10, $respuesta10);
            if ($respuesta) {
                ejecutarConsulta14("insert into trxhistorico select * from trx where Id = '$IdCliente'");
                echo "Registro actualizado con éxito";
            } else {
                echo "Error: registro no se pudo actualizar";
            }
        }
        break;
}
?>