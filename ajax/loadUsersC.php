<?php

require '../config/connection.php';

if (substr($_FILES['excel']['name'], -3) === "csv") {
    $fecha = date("Y-m-d");
    $carpeta = "../documents/";
    $excel = $fecha . "-" . $_FILES['excel']['name'];

    move_uploaded_file($_FILES['excel']['tmp_name'], "$carpeta$excel");

    $row = 0; //variable que permite discriminar el encabezado del archivo csv
    $fp = fopen("$carpeta$excel", "r"); //abrir archivo

    $users = $fp; //leo el archivo que contiene los datos del producto
    while (($datos = fgetcsv($users, 1000, ";")) !== FALSE) {//Leo linea por linea del archivo hasta un maximo de 1000 caracteres por linea leida usando coma(,) o (;) como delimitador
        $row++;
        if ($row > 1) {
            $linea[] = array('Id' => $datos[0], 'VCC' => $datos[1], 'Name' => $datos[2], 'Password' => $datos[3], 'State' => $datos[4], 'UserGroup' => $datos[5]); //Arreglo Bidimensional para guardar los datos de cada linea leida del archivo
        }
    }
    fclose($users); //Cierra el archivo

    $ingresado = 0; //Variable que almacenara los insert exitosos
    $error = 0; //Variable que almacenara los errores en almacenamiento
    $duplicado = 0; //Variable que almacenara los registros duplicados
    //print_r($linea);
    foreach ($linea as $indice => $value) { //Iteracion el array para extraer cada uno de los valores almacenados en cada items
        $Id = $value["Id"]; //Campos de la tabla
        $VCC = $value["VCC"]; //Campos de la tabla
        $Name = $value["Name"]; //Campos de la tabla
        $Password = $value["Password"]; //Campos de la tabla
        $State = $value["State"]; //Campos de la tabla
        $UserGroup = $value["UserGroup"]; //Campos de la tabla
        
        $sql = ejecutarConsulta("select * from user where Id='$Id'"); //Consulta a la tabla
        $num = mysqli_num_rows($sql); //Cuenta el numero de registros devueltos por la consulta
        if ($num == 0) {//Si es == 0 inserto
            if ($insert = ejecutarConsulta( "insert into user (Id, VCC, Name, Password, State, UserGroup) "
                    . "values('$Id','$VCC','$Name','$Password','$State','$UserGroup')")) {
                $msj = '<font color=green>Dato <b>' . $Id . '</b> Guardado</font><br/>';
                $ingresado += 1;
            }//fin del if que comprueba que se guarden los datos
            else {//sino ingresa el producto
                $msj = '<font color=red>Dato <b>' . $Id . ' </b> no almacenado' . mysqli_error() . '</font><br/>';
                $error += 1;
            }
        }//fin de if que comprueba que no haya en registro duplicado
        else {
            $duplicado += 1;
            echo $duplicate = '<font color=#F3D305>El dato <b>' . $Id . '</b> está duplicado<br></font>';
        }
    }
    echo "<font color=green>" . number_format($ingresado, 2) . " Datos almacenados con éxito<br/>";
    echo "<font color=#F3D305>" . number_format($duplicado, 2) . " Datos duplicados<br/>";
    echo "<font color=red>" . number_format($error, 2) . " Errores de almacenamiento<br/>";
}
?>