<?php

session_start();

require '../models/resultCampaignM.php';
$result = new resultCampaignM();
date_default_timezone_set("America/Lima");
$date = date('Y-m-d H:i:s');
$user = $_SESSION['usu'];

$Id = isset($_POST["Id"]) ? LimpiarCadena($_POST["Id"]) : "";
$state = '1';

switch ($_GET["action"]) {
    case 'selectAll':
        $respuesta = $result->selectAll(); /* llama a la función del modelo */
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            $datos[] = array(/* llena los resultados con los datos */
                "0" => $registrar->Id, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                "1" => $registrar->CampaignId,
                "2" => $registrar->Code,
                "3" => $registrar->Level1,
                "4" => $registrar->Level2,
                "5" => $registrar->Level3,
                "6" => $registrar->State,
                "7" => ($registrar->State == 'ACTIVO') ?
                '<center><li title="Editar" class="fa fa-edit" style="color: purple;" onclick="mostrar_uno(\'' . $registrar->Id . '\')"></i>&nbsp;&nbsp;&nbsp; <li title="Eliminar" class="fa fa-trash" style="color: #3C8DBC;" onclick="desactivar(\'' . $registrar->Id . '\')"></li></center>' :
                '<center><li title="Editar" class="fa fa-edit" style="color: purple;" onclick="mostrar_uno(\'' . $registrar->Id . '\')"></i>&nbsp;&nbsp;&nbsp; <li title="Restaurar" class="fa fa-refresh" style="color: green;" onclick="activar(\'' . $registrar->Id . '\')" ></li></center>'
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
        $respuesta = $result->selectById($Id);
        echo json_encode($respuesta); /* envia los datos a mostrar mediante json */
        break;

    case 'desactivate':
        $respuesta = $result->desactivate($Id);
        echo $respuesta ? "Resultado eliminado" : "Error: resultado no se pudo eliminar";
        break;

    case 'activate':
        $respuesta = $result->active($Id);
        echo $respuesta ? "Resultado restaurado" : "Error: resultado no se pudo restaurar";
        break;

    case 'insert':
        $respuesta = $result->insert($Id, $name, $password, $state, $resultGroup);
        echo $respuesta ? "Resultado registrado" : "Error: resultado no se pudo registrar";
        break;

    case 'update':
        $respuesta = $result->update($Id, $name, $password, $state, $resultGroup);
        echo $respuesta ? "Resultado actualizado" : "Error: resultado no se pudo actualizar";
        break;

    case 'save':
        $number = count($_POST["level1"]);
//        echo $number;
        if ($number >= 1) {
            for ($i = 0; $i < $number; $i++) {
                if (trim($_POST["level1"][$i] != '') && trim($_POST["code"][$i] != '')) {
                    $campaign = isset($_POST["campaignId"]) ? LimpiarCadena($_POST["campaignId"]) : "";
                    $level1 = str_replace('"', '', json_encode($_POST["level1"][$i]));
                    $level2 = str_replace('"', '', json_encode($_POST["level2"][$i]));
                    $level3 = str_replace('"', '', json_encode($_POST["level3"][$i]));
                    $code = str_replace('"', '', json_encode($_POST["code"][$i]));
                    $validate = ejecutarConsulta("SELECT level1, level2, level3, Code FROM `campaignresultmanagement` WHERE Id = '$Id' ");
                    $numRowC = $validate->num_rows;
                    if ($numRowC == 0 || $numRowC == '') {
                        $respuesta = $result->insert($campaign, $level1, $level2, $level3, $code, $state, $user, $date);
                        echo $respuesta ? "Resultado registrado" : "Error: resultado no se pudo registrar";
                    } else {
                        $validation = ejecutarConsulta("SELECT level1, level2, level3, Code FROM `campaignresultmanagement` WHERE CampaignId = '$campaign' and Level1 = '$level1' and Level2 = '$level2' and Level3 = '$level3'and Code = '$code'");
                        $numRowC = $validation->num_rows;
                         if ($numRowC == 0 || $numRowC == '') {
                            $respuesta = $result->update($Id, $level1, $level2, $level3, $code, $state, $user, $date);
                            echo $respuesta ? "Resultado actualizado" : "Error: resultado no se pudo actualizar";
                        } else {
                            echo 'El resultado: ' . $level1 . '/' . $level2 . '/' . $level3 . ' ya se encuentra registrado';
                        }
                    }
                }
                else{
                    echo 'Resultado nivel 1 y/o código de campaña faltan de llenar!';
                }
            }
        }
        break;
}
?>

