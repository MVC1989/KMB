<?php

session_start();

require '../models/userM.php';
$user = new User();
date_default_timezone_set("America/Lima");
$date = date('Y-m-d H:i:s');
$userId = $_SESSION['usu'];

$Id = isset($_POST["Id"]) ? LimpiarCadena($_POST["Id"]) : "";
$identificacion = isset($_POST["identificacion"]) ? LimpiarCadena($_POST["identificacion"]) : "";
$Name1 = isset($_POST["Name1"]) ? LimpiarCadena($_POST["Name1"]) : "";
$Name2 = isset($_POST["Name2"]) ? LimpiarCadena($_POST["Name2"]) : "";
$Surname1 = isset($_POST["Surname1"]) ? LimpiarCadena($_POST["Surname1"]) : "";
$Surname2 = isset($_POST["Surname2"]) ? LimpiarCadena($_POST["Surname2"]) : "";
$country = isset($_POST["country"]) ? LimpiarCadena($_POST["country"]) : "";
$city = isset($_POST["city"]) ? LimpiarCadena($_POST["city"]) : "";
$gender = isset($_POST["gender"]) ? LimpiarCadena($_POST["gender"]) : "";
$fecha = isset($_POST["fecha"]) ? LimpiarCadena($_POST["fecha"]) : "";
$adress = isset($_POST["adress"]) ? LimpiarCadena($_POST["adress"]) : "";
$celular = isset($_POST["celular"]) ? LimpiarCadena($_POST["celular"]) : "";
$telefono = isset($_POST["telefono"]) ? LimpiarCadena($_POST["telefono"]) : "";
$email = isset($_POST["correo"]) ? LimpiarCadena($_POST["correo"]) : "";
$password = isset($_POST["Password"]) ? LimpiarCadena($_POST["Password"]) : "";
$userGroup = isset($_POST["UserGroup"]) ? LimpiarCadena($_POST["UserGroup"]) : "";
$state = '1';

switch ($_GET["action"]) {
    case 'selectAll':
        $respuesta = $user->selectAll(); /* llama a la función del modelo */
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            $datos[] = array(/* llena los resultados con los datos */
                "0" => $registrar->Id, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
				"1" => ($registrar->State == 'ACTIVO') ?
                '<center><li title="Editar" class="fa fa-edit" style="color: purple;" onclick="mostrar_uno(\'' . $registrar->Id . '\')"></i>&nbsp;&nbsp;&nbsp; <li title="Eliminar" class="fa fa-trash" style="color: #3C8DBC;" onclick="desactivar(\'' . $registrar->Id . '\')"></li></center>' :
                '<center><li title="Editar" class="fa fa-edit" style="color: purple;" onclick="mostrar_uno(\'' . $registrar->Id . '\')"></i>&nbsp;&nbsp;&nbsp; <li title="Restaurar" class="fa fa-refresh" style="color: green;" onclick="activar(\'' . $registrar->Id . '\')" ></li></center>',
                "2" => $registrar->Id,
                "3" => $registrar->Identification,
                "4" => $registrar->Name1,
                "5" => $registrar->Name2,
                "6" => $registrar->Surname1,
                "7" => $registrar->Surname2,
                "8" => $registrar->dateBirth,
                "9" => $registrar->Address,
                "10" => $registrar->ContacAddress,
                "11" => $registrar->ContacAddress1,
                "12" => $registrar->Email,
                "13" => $registrar->UserGroup,
                "14" => $registrar->State         
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
        $respuesta = $user->selectById($Id);
        echo json_encode($respuesta); /* envia los datos a mostrar mediante json */
        break;

    case 'desactivate':
        $respuesta = $user->desactivate($Id);
        echo $respuesta ? "Usuario eliminado" : "Error: usuario no se pudo eliminar";
        break;

    case 'activate':
        $respuesta = $user->active($Id);
        echo $respuesta ? "Usuario restaurado" : "Error: usuario no se pudo restaurar";
        break;

    case 'insert':
        $respuesta = $user->insert($Id, $name, $password, $state, $userGroup);
        echo $respuesta ? "Usuario registrado" : "Error: usuario no se pudo registrar";
        break;

    case 'update':
        $respuesta = $user->update($Id, $name, $password, $state, $userGroup);
        echo $respuesta ? "Usuario actualizado" : "Error: usuario no se pudo actualizar";
        break;

    case 'desencriptar':
        $texto = isset($_POST["pass"]) ? LimpiarCadena1($_POST["pass"]) : "";
        $respuesta = $user->desencriptar($texto);
        echo $respuesta;
        break;

    case 'validarUsuario':
        $user = isset($_POST["IdUser"]) ? LimpiarCadena1($_POST["IdUser"]) : "";
        $result = ejecutarConsultaSimple("select Id from user where Id = '$user'");
        $row = $result['Id'];
        if ($row == '') {
            echo 'SIN INFO';
        } else {
            echo $row;
        }
        break;

    case 'save':
        $texto = $password;
        $Password = $user->encriptar($texto);
        $validate = ejecutarConsulta("select Id from user where Id = '$Id'");
        $valid = mysqli_fetch_array($validate, MYSQLI_BOTH);
        $numRowC = $validate->num_rows;
        if ($numRowC == 0 || $numRowC == '') {
            $respuesta = $user->insert($Id, $identificacion, $Name1, $Name2, $Surname1, $Surname2, $country, $city, $gender, $fecha, $Password, $adress, $celular, $telefono, $email, $state, $userId, $date, $userGroup);
            echo $respuesta ? "Usuario registrado" : "Error: usuario no se pudo registrar";
        } else {
            $respuesta = $user->update($Id, $identificacion, $Name1, $Name2, $Surname1, $Surname2, $country, $city, $gender, $fecha, $Password, $adress, $celular, $telefono, $email, $state, $userId, $date, $userGroup);
            echo $respuesta ? "Usuario actualizado" : "Error: usuario no se pudo actualizar";
        }
        break;
}
?>

