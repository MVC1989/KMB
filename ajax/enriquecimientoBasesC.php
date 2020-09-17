<?php

session_start();
require '../config/connection.php';
date_default_timezone_set("America/Lima");
$dateNow = date('Y-m-d H:i:s');

switch ($_GET["action"]) {

    case 'enriquecimientoNumeros':
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
                        'CAMPANIA' => $datos[0],
                        'NOMBRE_IMPORTACION' => $datos[1],
                        'IDENTIFICACION' => $datos[2],
                        'NOMBRE' => $datos[3],
                        'TELEFONO1' => $datos[4],
                        'TELEFONO2' => $datos[5],
                        'TELEFONO3' => $datos[6],
                        'TELEFONO4' => $datos[7],
                        'TELEFONO5' => $datos[8],
                        'TELEFONO6' => $datos[9],
                        'TELEFONO7' => $datos[10],
                        'TELEFONO8' => $datos[11],
                        'TELEFONO9' => $datos[12],
                        'TELEFONO10' => $datos[13],
                        'TELEFONO11' => $datos[14],
                        'TELEFONO12' => $datos[15],
                        'TELEFONO13' => $datos[16],
                        'TELEFONO14' => $datos[17],
                        'TELEFONO15' => $datos[18],
                    );
                }
            }
            fclose($users); //Cierra el archivo
            $ingresado = 0; //Variable que almacenara los insert exitosos
            $error = 0; //Variable que almacenara los errores en almacenamiento
            $duplicado = 0; //Variable que almacenara los registros duplicados
            foreach ($linea as $indice => $value) { //Iteracion el array para extraer cada uno de los valores almacenados en cada items
                //Almacenamos info en contactimportcontact. Datos traidos del array para almacenar en la base
                $CAMPANIA = $value['CAMPANIA'];
                $NOMBRE_IMPORTACION = $value['NOMBRE_IMPORTACION'];
                $IDENTIFICACION = $value['IDENTIFICACION'];
                $NOMBRE = $value['NOMBRE'];
                $TELEFONO1 = $value['TELEFONO1'];
                $TELEFONO2 = $value['TELEFONO2'];
                $TELEFONO3 = $value['TELEFONO3'];
                $TELEFONO4 = $value['TELEFONO4'];
                $TELEFONO5 = $value['TELEFONO5'];
                $TELEFONO6 = $value['TELEFONO6'];
                $TELEFONO7 = $value['TELEFONO7'];
                $TELEFONO8 = $value['TELEFONO8'];
                $TELEFONO9 = $value['TELEFONO9'];
                $TELEFONO10 = $value['TELEFONO10'];
                $TELEFONO11 = $value['TELEFONO11'];
                $TELEFONO12 = $value['TELEFONO12'];
                $TELEFONO13 = $value['TELEFONO13'];
                $TELEFONO14 = $value['TELEFONO14'];
                $TELEFONO15 = $value['TELEFONO15'];

                $result = ejecutarConsulta("SELECT Id FROM `contactimportcontact` WHERE Campaign = '$CAMPANIA' and LastUpdate like '%$NOMBRE_IMPORTACION%' and Identification = '$IDENTIFICACION' and Action <> 'cancelar base'");
                $numRow = $result->num_rows;
                if ($numRow == 0) {
                    echo $msj = '<font color=purple>Dato <b>'.' Identificación: ' . $IDENTIFICACION . ' Campaña: ' . $CAMPANIA . ' Importación: ' . $NOMBRE_IMPORTACION . ' </b> no encontrado </font><br/>';
                } else {
                    while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                        $ID = $row['Id'];
                        if ($TELEFONO1 != '') {
                            $vTelefono1 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora) "
                                    . "VALUES ('$ID','','$TELEFONO1','','SG','$dateNow')");
                            if ($vTelefono1 == true) {
                                $ingresado += 1;
                            } else if ($vTelefono1 == false || $vTelefono1 == "") {
                                echo $msj = '<font color=red>Dato <b> ID: ' . $ID . ' Identificación: ' . $IDENTIFICACION . ' Importación: ' . $NOMBRE_IMPORTACION . ' </b> no almacenado </font><br/>';
                                $error += 1;
                            }
                        }
                    if ($TELEFONO2 != '') {
                        $vTelefono2 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora) "
                                . "VALUES ('$ID','','$TELEFONO2','','SG','$dateNow')");
                        if ($vTelefono2 == true) {
                            $ingresado += 1;
                        } else {
                            echo $msj = '<font color=red>Dato <b> ID: ' . $ID . ' Identificación: ' . $IDENTIFICACION . ' Importación: ' . $NOMBRE_IMPORTACION . ' </b> no almacenado </font><br/>';
                            $error += 1;
                        }
                    }
                    if ($TELEFONO3 != '') {
                        $vTelefono3 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora) "
                                . "VALUES ('$ID','','$TELEFONO3','','SG','$dateNow')");
                        if ($vTelefono3 == true) {
                            $ingresado += 1;
                        } else {
                            echo $msj = '<font color=red>Dato <b> ID: ' . $ID . ' Identificación: ' . $IDENTIFICACION . ' Importación: ' . $NOMBRE_IMPORTACION . ' </b> no almacenado </font><br/>';
                            $error += 1;
                        }
                    }
                    if ($TELEFONO4 != '') {
                        $vTelefono4 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora) "
                                . "VALUES ('$ID','','$TELEFONO4','','SG','$dateNow')");
                        if ($vTelefono4 == true) {
                            $ingresado += 1;
                        } else {
                            echo $msj = '<font color=red>Dato <b> ID: ' . $ID . ' Identificación: ' . $IDENTIFICACION . ' Importación: ' . $NOMBRE_IMPORTACION . ' </b> no almacenado </font><br/>';
                            $error += 1;
                        }
                    }
                    if ($TELEFONO5 != '') {
                        $vTelefono5 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora) "
                                . "VALUES ('$ID','','$TELEFONO5','','SG','$dateNow')");
                        if ($vTelefono5 == true) {
                            $ingresado += 1;
                        } else {
                            echo $msj = '<font color=red>Dato <b> ID: ' . $ID . ' Identificación: ' . $IDENTIFICACION . ' Importación: ' . $NOMBRE_IMPORTACION . ' </b> no almacenado </font><br/>';
                            $error += 1;
                        }
                    }
                    if ($TELEFONO6 != '') {
                        $vTelefono6 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora) "
                                . "VALUES ('$ID','','$TELEFONO6','','SG','$dateNow')");
                        if ($vTelefono6 == true) {
                            $ingresado += 1;
                        } else {
                            echo $msj = '<font color=red>Dato <b> ID: ' . $ID . ' Identificación: ' . $IDENTIFICACION . ' Importación: ' . $NOMBRE_IMPORTACION . ' </b> no almacenado </font><br/>';
                            $error += 1;
                        }
                    }
                    if ($TELEFONO7 != '') {
                        $vTelefono7 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora) "
                                . "VALUES ('$ID','','$TELEFONO7','','SG','$dateNow')");
                        if ($vTelefono7 == true) {
                            $ingresado += 1;
                        } else {
                            echo $msj = '<font color=red>Dato <b> ID: ' . $ID . ' Identificación: ' . $IDENTIFICACION . ' Importación: ' . $NOMBRE_IMPORTACION . ' </b> no almacenado </font><br/>';
                            $error += 1;
                        }
                    }
                    if ($TELEFONO8 != '') {
                        $vTelefono8 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora) "
                                . "VALUES ('$ID','','$TELEFONO8','','SG','$dateNow')");
                        if ($vTelefono8 == true) {
                            $ingresado += 1;
                        } else {
                            echo $msj = '<font color=red>Dato <b> ID: ' . $ID . ' Identificación: ' . $IDENTIFICACION . ' Importación: ' . $NOMBRE_IMPORTACION . ' </b> no almacenado </font><br/>';
                            $error += 1;
                        }
                    }
                    if ($TELEFONO9 != '') {
                        $vTelefono9 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora) "
                                . "VALUES ('$ID','','$TELEFONO9','','SG','$dateNow')");
                        if ($vTelefono9 == true) {
                            $ingresado += 1;
                        } else {
                            echo $msj = '<font color=red>Dato <b> ID: ' . $ID . ' Identificación: ' . $IDENTIFICACION . ' Importación: ' . $NOMBRE_IMPORTACION . ' </b> no almacenado </font><br/>';
                            $error += 1;
                        }
                    }
                    if ($TELEFONO10 != '') {
                        $vTelefono10 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora) "
                                . "VALUES ('$ID','','$TELEFONO10','','SG','$dateNow')");
                        if ($vTelefono10 == true) {
                            $ingresado += 1;
                        } else {
                            echo $msj = '<font color=red>Dato <b> ID: ' . $ID . ' Identificación: ' . $IDENTIFICACION . ' Importación: ' . $NOMBRE_IMPORTACION . ' </b> no almacenado </font><br/>';
                            $error += 1;
                        }
                    }
                    if ($TELEFONO11 != '') {
                        $vTelefono11 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora) "
                                . "VALUES ('$ID','','$TELEFONO11','','SG','$dateNow')");
                        if ($vTelefono11 == true) {
                            $ingresado += 1;
                        } else {
                            echo $msj = '<font color=red>Dato <b> ID: ' . $ID . ' Identificación: ' . $IDENTIFICACION . ' Importación: ' . $NOMBRE_IMPORTACION . ' </b> no almacenado </font><br/>';
                            $error += 1;
                        }
                    }
                    if ($TELEFONO12 != '') {
                        $vTelefono12 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora) "
                                . "VALUES ('$ID','','$TELEFONO12','','SG','$dateNow')");
                        if ($vTelefono12 == true) {
                            $ingresado += 1;
                        } else {
                            echo $msj = '<font color=red>Dato <b> ID: ' . $ID . ' Identificación: ' . $IDENTIFICACION . ' Importación: ' . $NOMBRE_IMPORTACION . ' </b> no almacenado </font><br/>';
                            $error += 1;
                        }
                    }
                    if ($TELEFONO13 != '') {
                        $vTelefono13 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora) "
                                . "VALUES ('$ID','','$TELEFONO13','','SG','$dateNow')");
                        if ($vTelefono13 == true) {
                            $ingresado += 1;
                        } else {
                            echo $msj = '<font color=red>Dato <b> ID: ' . $ID . ' Identificación: ' . $IDENTIFICACION . ' Importación: ' . $NOMBRE_IMPORTACION . ' </b> no almacenado </font><br/>';
                            $error += 1;
                        }
                    }
                    if ($TELEFONO14 != '') {
                        $vTelefono14 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora) "
                                . "VALUES ('$ID','','$TELEFONO14','','SG','$dateNow')");
                        if ($vTelefono14 == true) {
                            $ingresado += 1;
                        } else {
                            echo $msj = '<font color=red>Dato <b> ID: ' . $ID . ' Identificación: ' . $IDENTIFICACION . ' Importación: ' . $NOMBRE_IMPORTACION . ' </b> no almacenado </font><br/>';
                            $error += 1;
                        }
                    }
                    if ($TELEFONO15 != '') {
                        $vTelefono15 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora) "
                                . "VALUES ('$ID','','$TELEFONO15','','SG','$dateNow')");
                        if ($vTelefono15 == true) {
                            $ingresado += 1;
                        } else {
                            echo $msj = '<font color=red>Dato <b> ID: ' . $ID . ' Identificación: ' . $IDENTIFICACION . ' Importación: ' . $NOMBRE_IMPORTACION . ' </b> no almacenado </font><br/>';
                            $error += 1;
                        }
                    }
                    }
                }
            }
            echo "<b>El enriquecimiento de base $nameExcel tiene el siguiente detalle:</b><br/>";
            echo "<font color=green>" . $ingresado . " Datos almacenados con éxito<br/>";
            echo "<font color=red>" . $error . " Errores de almacenamiento o no encontrados<br/>";
        }
        break;
}
?>