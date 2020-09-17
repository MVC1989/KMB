<?php

session_start();
require '../models/correoMasivoBPM.php';
$camp = new correoMasivoBPM();
date_default_timezone_set("America/Lima");
$dateNow = date('Y-m-d H:i:s');

switch ($_GET["action"]) {

    case 'bancoPichinchaMO':
        if (substr($_FILES['excel']['name'], -3) === "csv") {
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', 0);
            set_time_limit(0);
            $fecha = date('Y-m-d');
            $hora = time();
            $carpeta = "../documents/";
            $excel = $fecha . "_" . $hora . "_" . $_FILES['excel']['name'];
            move_uploaded_file($_FILES['excel']['tmp_name'], "$carpeta$excel");
            $row = 0; //variable que permite discriminar el encabezado del archivo csv
            $fp = fopen("$carpeta$excel", "r"); //abrir archivo
            $users = $fp; //leo el archivo que contiene los datos del producto
            $nameExcel = isset($_POST["import"]) ? LimpiarCadena($_POST["import"]) : "";
            $campaignId = isset($_POST["campaign"]) ? LimpiarCadena($_POST["campaign"]) : "";
            while (($datos = fgetcsv($users, 100000, ";")) !== FALSE) {//Leo linea por linea del archivo hasta un maximo de 1000 caracteres por linea leida usando coma(,) o (;) como delimitador
                $row++;
                if ($row > 1) {
                    $linea[] = array(//Arreglo Bidimensional para guardar los datos de cada linea leida del archivo
                        'ContactId' => $datos[0],
                        'InteractionId' => $datos[1],
                        'Agent' => $datos[2],
                        'Tmstmp' => $datos[3],
                        'Nombres' => $datos[4],
                        'Cedula' => $datos[5],
                        'Producto' => $datos[6],
                        'Monto' => $datos[7],
                        'Garante' => $datos[8],
                        'Telefonos' => $datos[9],
                        'Celular' => $datos[10],
                        'Observaciones' => $datos[11],
                        'Region' => $datos[12],
                        'Ciudad' => $datos[13],
                        'TipoOficina' => $datos[14],
                        'Agencia' => $datos[15],
                        'NUP' => $datos[16],
                        'Correo' => $datos[17],
                        'EnviadoD1' => $datos[18],
                        'EnviadoD2' => $datos[19],
                        'EnviadoD3' => $datos[20],
                        'EnviadoD4' => $datos[21],
                        'EnviadoCC1' => $datos[22],
                        'EnviadoCC2' => $datos[23],
                        'EnviadoCC3' => $datos[24],
                        'EnviadoCC4' => $datos[25],
                        'EstadoEnvio' => $datos[26],
                    );
                }
            }
            fclose($users); //Cierra el archivo
            $ingresado = 0; //Variable que almacenara los insert exitosos
            $error = 0; //Variable que almacenara los errores en almacenamiento
            $duplicado = 0; //Variable que almacenara los registros duplicados
            foreach ($linea as $indice => $value) { //Iteracion el array para extraer cada uno de los valores almacenados en cada items
                //Almacenamos info en contactimportcontact. Datos traidos del array para almacenar en la base
                $ContactId = $value['ContactId'];
                $InteractionId = $value['InteractionId'];
                $Agent = $value['Agent'];
                $Tmstmp = $value['Tmstmp'];
                $Nombres = $value['Nombres'];
                $Cedula = $value['Cedula'];
                $Producto = $value['Producto'];
                $Monto = $value['Monto'];
                $Garante = $value['Garante'];
                $Telefonos = $value['Telefonos'];
                $Celular = $value['Celular'];
                $Observaciones = $value['Observaciones'];
                $Region = $value['Region'];
                $Ciudad = $value['Ciudad'];
                $TipoOficina = $value['TipoOficina'];
                $Agencia = $value['Agencia'];
                $NUP = $value['NUP'];
                $Correo = $value['Correo'];
                $EnviadoD1 = $value['EnviadoD1'];
                $EnviadoD2 = $value['EnviadoD2'];
                $EnviadoD3 = $value['EnviadoD3'];
                $EnviadoD4 = $value['EnviadoD4'];
                $EnviadoCC1 = $value['EnviadoCC1'];
                $EnviadoCC2 = $value['EnviadoCC2'];
                $EnviadoCC3 = $value['EnviadoCC3'];
                $EnviadoCC4 = $value['EnviadoCC4'];
                $EstadoEnvio = $value['EstadoEnvio'];

                if ($envioMail = $camp->envioCorreos($ContactId, $InteractionId, $Agent, $Tmstmp, $Nombres, $Cedula, $Producto, $Monto, $Garante, $Telefonos, $Celular, $Observaciones, $Region, $Ciudad, $TipoOficina, $Agencia, $NUP, $Correo, $EnviadoD1, $EnviadoD2, $EnviadoD3, $EnviadoD4, $EnviadoCC1, $EnviadoCC2, $EnviadoCC3, $EnviadoCC4)) {
                    $msj = '<font color=green>Dato <b>' . $ContactId . '</b> Guardado</font><br/>';
                    $ingresado += 1;
                }//fin del if que comprueba que se guarden los $datos
                else {//sino ingresa el producto
                    echo $msj = '<font color=red>Dato <b>' . $ContactId . ' </b> no almacenado' . mysqli_error() . '</font><br/>';
                    $error += 1;
                }
            }
            echo "<b>La importación $nameExcel tiene el siguiente detalle:</b><br/>";
            echo "<font color=green>" . $ingresado . " Datos almacenados con éxito<br/>";
            echo "<font color=red>" . $error . " Errores de almacenamiento<br/>";
        }
        break;
}
?>