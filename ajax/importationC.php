<?php

session_start();
require '../config/connection.php';
date_default_timezone_set("America/Lima");
$dateNow = date('Y-m-d H:i:s');
$date = date('Y-m-d H:i:s');
$vcc = $_SESSION['vcc'];

switch ($_GET["action"]) {
    case 'listCampaigns':
        $campaign = isset($_POST['search']) ? LimpiarCadena($_POST["search"]) : "";
        $result = ejecutarConsulta("SELECT DISTINCT CampaignId 'Id' FROM campaignresultmanagement where CampaignId like '%$campaign%' order by CampaignId");
        while ($row = mysqli_fetch_array($result)) {
            $response[] = array("value" => $row['Id'], "label" => $row['Id']);
        }
        echo json_encode($response);
        break;

    case 'bases':
        $campaign = isset($_POST['camp']) ? LimpiarCadena($_POST["camp"]) : "";
        $result = ejecutarConsulta("SELECT distinct(LastUpdate) 'LastUpdate' FROM contactimportcontact where campaign = '$campaign' order by LastUpdate");
        echo '<option></option>';
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            echo '<option value="' . $row["LastUpdate"] . '">' . $row["LastUpdate"] . '</option>';
        }
        break;

    case 'showAll':
        $campaign = isset($_POST['campaign']) ? LimpiarCadena($_POST["campaign"]) : "";
        $base = isset($_POST['base']) ? LimpiarCadena($_POST["base"]) : "";
        $respuesta = ejecutarConsulta("SELECT ID, Name, Identification, Campaign, LastManagementResult, LastUpdate, LastAgent, TmStmpShift, UserShift, Action "
                . "FROM contactimportcontact WHERE campaign = '$campaign' and LastUpdate = '$base' ");
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            $datos[] = array(/* llena los resultados con los datos */
                "0" => $registrar->ID, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                "1" => $registrar->Name,
                "2" => $registrar->Identification,
                "3" => $registrar->Campaign,
                "4" => $registrar->LastManagementResult,
                "5" => $registrar->LastUpdate,
                "6" => $registrar->LastAgent,
                "7" => $registrar->TmStmpShift,
                "8" => $registrar->UserShift,
                "9" => $registrar->Action,
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

    case 'administration':
        $import = isset($_POST["base"]) ? LimpiarCadena($_POST["base"]) : "";
        $campaign = isset($_POST["campaign"]) ? LimpiarCadena($_POST["campaign"]) : "";
        $actions = isset($_POST["acciones"]) ? LimpiarCadena($_POST["acciones"]) : "";
        if ($actions == "") { //es vacio porque el value trae ese dato y es ese el que se debe almacenar
            $activeBase = ejecutarConsulta("update contactimportcontact set Action = '$actions', UserShift = '$_SESSION[usu]', TmStmpShift = '$date' "
                    . "where LastUpdate = '$import' and Campaign = '$campaign'");
            echo $activeBase ? "Se ha asignado base exitosamente!" : "No se ha asignado la base!";
        } else if ($actions == "Cancelar base") {
            $cancelBase = ejecutarConsulta("update contactimportcontact set Action = '$actions', UserShift = '$_SESSION[usu]', TmStmpShift = '$date' "
                    . "where LastUpdate = '$import' and Campaign = '$campaign'");
            echo $cancelBase ? "Se ha cancelado base exitosamente!" : "No se ha retirado la base!";
        }
        break;

    case 'ecuasistencia':
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

            $sql = ejecutarConsulta("select Id from campaign where Id = '$campaignId'");
            $vCamp = mysqli_fetch_array($sql, MYSQLI_BOTH);
            $sql1 = ejecutarConsulta("SELECT DISTINCT lastupdate FROM contactimportcontact "
                    . "WHERE EXISTS (SELECT DISTINCT lastupdate FROM contactimportcontact c "
                    . "WHERE c.lastupdate = '$nameExcel')");
            $vImport = mysqli_fetch_array($sql1, MYSQLI_BOTH);
            if ($vCamp["Id"] == "") {
                echo("No exite la campaña seleccionada");
                //} else if ($vImport != "") {
                // echo("Nombre de importación duplicado");
            } else {
                while (($datos = fgetcsv($users, 100000, ";")) !== FALSE) {//Leo linea por linea del archivo hasta un maximo de 1000 caracteres por linea leida usando coma(,) o (;) como delimitador
                    $row++;
                    if ($row > 1) {
                        $linea[] = array(//Arreglo Bidimensional para guardar los datos de cada linea leida del archivo
                            'IDENTIFICACION' => $datos[0],
                            'NOMBRE' => $datos[1],
                            'REGION' => $datos[2],
                            'PROVINCIA' => $datos[3],
                            'CIUDAD' => $datos[4],
                            'GENERO' => $datos[5],
                            'EMAIL' => $datos[6],
                            'CUENTA' => $datos[7],
                            'TARJETA' => $datos[8],
                            'TIPOPLAN' => $datos[9],
                            'TELEFONO_01' => $datos[10],
                            'TELEFONO_02' => $datos[11],
                            'TELEFONO_03' => $datos[12],
                            'TELEFONO_04' => $datos[13],
                            'TELEFONO_05' => $datos[14],
                            'TELEFONO_06' => $datos[15],
                            'TELEFONO_07' => $datos[16],
                            'TELEFONO_08' => $datos[17],
                            'TELEFONO_09' => $datos[18],
                            'TELEFONO_10' => $datos[19],
                        );
                    }
                }
                fclose($users); //Cierra el archivo
                $ingresado = 0; //Variable que almacenara los insert exitosos
                $error = 0; //Variable que almacenara los errores en almacenamiento
                $duplicado = 0; //Variable que almacenara los registros duplicados
                foreach ($linea as $indice => $value) { //Iteracion el array para extraer cada uno de los valores almacenados en cada items
                    $count = ejecutarConsultaSimple("select UUID() 'id'");
                    $idG = $count['id'];
                    //Almacenamos info en contactimportcontact. Datos traidos del array para almacenar en la base
                    $ID = $idG;
                    $Name = $value["NOMBRE"];
                    $Identification = $value["IDENTIFICACION"];
                    $Campaign = $campaignId;
                    $LastManagementResult = "";
                    $LastUpdate = $nameExcel;
                    $REGION = $value['REGION'];
                    $PROVINCIA = $value['PROVINCIA'];
                    $CIUDAD = $value['CIUDAD'];
                    $GENERO = $value['GENERO'];
                    $EMAIL = $value['EMAIL'];
                    $CUENTA = $value['CUENTA'];
                    $TARJETA = $value['TARJETA'];
                    $TIPOPLAN = $value['TIPOPLAN'];
                    $TELEFONO_01 = $value['TELEFONO_01'];
                    $TELEFONO_02 = $value['TELEFONO_02'];
                    $TELEFONO_03 = $value['TELEFONO_03'];
                    $TELEFONO_04 = $value['TELEFONO_04'];
                    $TELEFONO_05 = $value['TELEFONO_05'];
                    $TELEFONO_06 = $value['TELEFONO_06'];
                    $TELEFONO_07 = $value['TELEFONO_07'];
                    $TELEFONO_08 = $value['TELEFONO_08'];
                    $TELEFONO_09 = $value['TELEFONO_09'];
                    $TELEFONO_10 = $value['TELEFONO_10'];

                    $sql = ejecutarConsulta("select * from contactimportcontact where Id='$ID'"); //Consulta a la tabla
                    $num = mysqli_num_rows($sql); //Cuenta el numero de registros devueltos por la consulta
                    if ($num == 0) {//Si es == 0 inserto
                        if ($insert = ejecutarConsulta("insert into contactimportcontact (VCC, ID, Name, Identification, Campaign, LastManagementResult, LastUpdate) "
                                . "values('$vcc','$ID','$Name','$Identification','$Campaign','$LastManagementResult','$LastUpdate')")) {

                            ejecutarConsulta2("INSERT INTO clientes(VCC, CampaignId, ContactId, ContactName, ContactAddress, "
                                    . "LastInteractionId,ImportId, LastAgent, ResultLevel1, ResultLevel2, ResultLevel3, ManagementResultCode, "
                                    . "ManagementResultDescription, TmsTmp, Observaciones, Intentos, "
                                    . "Identificacion, Nombres, Telefono1, Telefono2, Telefono3, Telefono4, "
                                    . "Telefono5, Telefono6, region, provincia, Ciudad, Genero, Email, Cuenta, Tarjeta, TipoPlan) "
                                    . "VALUES ('$vcc','$Campaign','$ID','$Name','','','$nameExcel','Pendiente','Pendiente','Pendiente',"
                                    . "'Pendiente','0','Pendiente', '','','','$Identification','$Name','$TELEFONO_01','$TELEFONO_02',"
                                    . "'$TELEFONO_03','$TELEFONO_04','$TELEFONO_05','$TELEFONO_06','$REGION','$PROVINCIA','$CIUDAD',"
                                    . "'$GENERO','$EMAIL','$CUENTA','$TARJETA','$TIPOPLAN')");

                            $msj = '<font color=green>Dato <b>' . $Name . '</b> Guardado</font><br/>';
                            $ingresado += 1;
                        }//fin del if que comprueba que se guarden los $datos
                        else {//sino ingresa el producto
                            echo $msj = '<font color=red>Dato <b>' . $Name . ' </b> no almacenado' . mysqli_error() . '</font><br/>';
                            $error += 1;
                        }

                        if ($TELEFONO_01 != '') {
                            $vTelefono1 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_01','','SG','$dateNow','$dateNow','TELEFONO_01','$Identification')");
                        }
                        if ($TELEFONO_02 != '') {
                            $vTelefono2 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_02','','SG','$dateNow','$dateNow','TELEFONO_02','$Identification')");
                        }
                        if ($TELEFONO_03 != '') {
                            $vTelefono3 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_03','','SG','$dateNow','$dateNow','TELEFONO_03','$Identification')");
                        }
                        if ($TELEFONO_04 != '') {
                            $vTelefono4 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_04','','SG','$dateNow','$dateNow','TELEFONO_04','$Identification')");
                        }
                        if ($TELEFONO_05 != '') {
                            $vTelefono5 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_05','','SG','$dateNow','$dateNow','TELEFONO_05','$Identification')");
                        }
                        if ($TELEFONO_06 != '') {
                            $vTelefono6 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_06','','SG','$dateNow','$dateNow','TELEFONO_06','$Identification')");
                        }
                        if ($TELEFONO_07 != '') {
                            $vTELEFONO_07 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_07','','SG','$dateNow','$dateNow','TELEFONO_07','$Identification')");
                        }
                        if ($TELEFONO_08 != '') {
                            $vTELEFONO_08 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_08','','SG','$dateNow','$dateNow','TELEFONO_08','$Identification')");
                        }
                        if ($TELEFONO_09 != '') {
                            $vTELEFONO_09 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_09','','SG','$dateNow','$dateNow','TELEFONO_09','$Identification')");
                        }
                        if ($TELEFONO_10 != '') {
                            $vTELEFONO_10 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_10','','SG','$dateNow','$dateNow','TELEFONO_10','$Identification')");
                        }
                    }//fin de if que comprueba que no haya en registro duplicado
                    else {
                        $duplicado += 1;
                        echo $duplicate = '<font color=#F3D305>El dato <b>' . $Name . '</b> está duplicado<br></font>';
                    }
                }
                echo "<b>La importación $nameExcel tiene el siguiente detalle:</b><br/>";
                echo "<font color=green>" . number_format($ingresado, 2) . " Datos almacenados con éxito<br/>";
                echo "<font color=#F3D305>" . number_format($duplicado, 2) . " Datos duplicados<br/>";
                echo "<font color=red>" . number_format($error, 2) . " Errores de almacenamiento<br/>";

                $vContactDetails = ejecutarConsulta("INSERT INTO contactimportdetail(VCC, ImportId, UpdateNum, "
                        . "Date, ImportUser, ValidContacts, NewContacts, UpdatedContacts, "
                        . "InvalidContacts, DuplicatesContacts) "
                        . "VALUES ('$vcc','$LastUpdate','1','$dateNow','$_SESSION[usu]','$ingresado','$ingresado',"
                        . "'0','$error','$duplicado')");

                $vContactImport = ejecutarConsulta("INSERT INTO contactimport(VCC, ID, DBProvider,"
                        . "Updates, Status, ServiceId) "
                        . "VALUES ('$vcc','$LastUpdate','$LastUpdate','1',"
                        . "case when $error = 0  then 'COMPLETE' else 'INCOMPLETE' end,'NULL')");
            }
        } else {
            echo 'El archivo no es CSV';
        }
        break;

    case 'ecuasistenciaEncuesta':
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

            $sql = ejecutarConsulta("select Id from campaign where Id = '$campaignId'");
            $vCamp = mysqli_fetch_array($sql, MYSQLI_BOTH);
            $sql1 = ejecutarConsulta("SELECT DISTINCT lastupdate FROM contactimportcontact "
                    . "WHERE EXISTS (SELECT DISTINCT lastupdate FROM contactimportcontact c "
                    . "WHERE c.lastupdate = '$nameExcel')");
            $vImport = mysqli_fetch_array($sql1, MYSQLI_BOTH);
            if ($vCamp["Id"] == "") {
                echo("No exite la campaña seleccionada");
                //} else if ($vImport != "") {
                // echo("Nombre de importación duplicado");
            } else {
                while (($datos = fgetcsv($users, 100000, ";")) !== FALSE) {//Leo linea por linea del archivo hasta un maximo de 1000 caracteres por linea leida usando coma(,) o (;) como delimitador
                    $row++;
                    if ($row > 1) {
                        $linea[] = array(//Arreglo Bidimensional para guardar los datos de cada linea leida del archivo
                            'TIPO_CONTRATO' => $datos[0],
                            'CONTRATO' => $datos[1],
                            'ASISTENCIA' => $datos[2],
                            'FECHA_ALTA' => $datos[3],
                            'TITULAR' => $datos[4],
                            'BENEFICIARIO' => $datos[5],
                            'PROVINCIA' => $datos[6],
                            'LOCALIDAD' => $datos[7],
                            'LUGAR_DE_ASISTENCIA' => $datos[8],
                            'PLACA' => $datos[9],
                            'BASTIDOR' => $datos[10],
                            'MARCA' => $datos[11],
                            'COLOR' => $datos[12],
                            'MODELO' => $datos[13],
                            'SERVICIO' => $datos[14],
                            'CAUSA' => $datos[15],
                            'AVERIA' => $datos[16],
                            'EN_CARTERA' => $datos[17],
                            'FECHA_COORDINACION' => $datos[18],
                            'OPERADOR_COORDINACION' => $datos[19],
                            'MOVIMIENTO_ECONOMICO' => $datos[20],
                            'IMPORTE' => $datos[21],
                            'TIPO_MOV' => $datos[22],
                            'ESTADO_MOV' => $datos[23],
                            'CANCELADO' => $datos[24],
                            'TIPO' => $datos[25],
                            'TELEFONO_01' => $datos[26],
                            'TELEFONO_02' => $datos[27],
                            'TELEFONO_03' => $datos[28],
                            'TELEFONO_04' => $datos[29],
                            'TELEFONO_05' => $datos[30],
                            'TELEFONO_06' => $datos[32],
                            'TELEFONO_07' => $datos[33],
                            'TELEFONO_08' => $datos[34],
                            'TELEFONO_09' => $datos[35],
                            'TELEFONO_10' => $datos[36],
                        );
                    }
                }
                fclose($users); //Cierra el archivo
                $ingresado = 0; //Variable que almacenara los insert exitosos
                $error = 0; //Variable que almacenara los errores en almacenamiento
                $duplicado = 0; //Variable que almacenara los registros duplicados
                foreach ($linea as $indice => $value) { //Iteracion el array para extraer cada uno de los valores almacenados en cada items
                    $count = ejecutarConsultaSimple("select UUID() 'id'");
                    $idG = $count['id'];
                    //Almacenamos info en contactimportcontact. Datos traidos del array para almacenar en la base
                    $ID = $idG;
                    $Name = $value["TITULAR"];
                    $Identification = "";
                    $Campaign = $campaignId;
                    $LastManagementResult = "";
                    $LastUpdate = $nameExcel;
                    $TIPO_CONTRATO = $value['TIPO_CONTRATO'];
                    $CONTRATO = $value['CONTRATO'];
                    $ASISTENCIA = $value['ASISTENCIA'];
                    $FECHA_ALTA = $value['FECHA_ALTA'];
                    $BENEFICIARIO = $value['BENEFICIARIO'];
                    $PROVINCIA = $value['PROVINCIA'];
                    $LOCALIDAD = $value['LOCALIDAD'];
                    $LUGAR_DE_ASISTENCIA = $value['LUGAR_DE_ASISTENCIA'];
                    $PLACA = $value['PLACA'];
                    $BASTIDOR = $value['BASTIDOR'];
                    $MARCA = $value['MARCA'];
                    $COLOR = $value['COLOR'];
                    $MODELO = $value['MODELO'];
                    $SERVICIO = $value['SERVICIO'];
                    $CAUSA = $value['CAUSA'];
                    $AVERIA = $value['AVERIA'];
                    $EN_CARTERA = $value['EN_CARTERA'];
                    $FECHA_COORDINACION = $value['FECHA_COORDINACION'];
                    $OPERADOR_COORDINACION = $value['OPERADOR_COORDINACION'];
                    $MOVIMIENTO_ECONOMICO = $value['MOVIMIENTO_ECONOMICO'];
                    $IMPORTE = $value['IMPORTE'];
                    $TIPO_MOV = $value['TIPO_MOV'];
                    $ESTADO_MOV = $value['ESTADO_MOV'];
                    $CANCELADO = $value['CANCELADO'];
                    $TIPO = $value['TIPO'];
                    $TELEFONO_01 = $value['TELEFONO_01'];
                    $TELEFONO_02 = $value['TELEFONO_02'];
                    $TELEFONO_03 = $value['TELEFONO_03'];
                    $TELEFONO_04 = $value['TELEFONO_04'];
                    $TELEFONO_05 = $value['TELEFONO_05'];
                    $TELEFONO_06 = $value['TELEFONO_06'];
                    $TELEFONO_07 = $value['TELEFONO_07'];
                    $TELEFONO_08 = $value['TELEFONO_08'];
                    $TELEFONO_09 = $value['TELEFONO_09'];
                    $TELEFONO_10 = $value['TELEFONO_10'];

                    $sql = ejecutarConsulta("select * from contactimportcontact where Id='$ID'"); //Consulta a la tabla
                    $num = mysqli_num_rows($sql); //Cuenta el numero de registros devueltos por la consulta
                    if ($num == 0) {//Si es == 0 inserto
                        if (ejecutarConsulta6("INSERT INTO clientes(VCC, CampaignId, ContactId, ContactName, ImportId, LastAgent, ResultLevel1, ResultLevel2, ResultLevel3, ManagementResultCode, ManagementResultDescription, ID, TIPO_CONTRATO, CONTRATO, ASISTENCIA, FECHA_ALTA, TITULAR, BENEFICIARIO, PROVINCIA, LOCALIDAD, LUGAR_DE_ASISTENCIA, PLACA, BASTIDOR, MARCA, COLOR, MODELO, SERVICIO, CAUSA, AVERIA, EN_CARTERA, FECHA_COORDINACION, OPERADOR_COORDINACION, MOVIMIENTO_ECONOMICO, IMPORTE, TIPO_MOV, ESTADO_MOV, CANCELADO, TIPO) "
                                        . "VALUES ('$vcc','$Campaign','$ID','$Name','$nameExcel','Pendiente','Pendiente','Pendiente','Pendiente','0','Pendiente','$ID','$TIPO_CONTRATO','$CONTRATO','$ASISTENCIA','$FECHA_ALTA','$Name','$BENEFICIARIO','$PROVINCIA','$LOCALIDAD','$LUGAR_DE_ASISTENCIA','$PLACA','$BASTIDOR','$MARCA','$COLOR','$MODELO','$SERVICIO','$CAUSA','$AVERIA','$EN_CARTERA','$FECHA_COORDINACION','$OPERADOR_COORDINACION','$MOVIMIENTO_ECONOMICO','$IMPORTE','$TIPO_MOV','$ESTADO_MOV','$CANCELADO','$TIPO')")) {
                            $insert = ejecutarConsulta("insert into contactimportcontact (VCC, ID, Name, Identification, Campaign, LastManagementResult, LastUpdate) values('$vcc','$ID','$Name','$Identification','$Campaign','$LastManagementResult','$LastUpdate')");
                            /*                             * CONSULTA PARA REVISAR SI LA INFORMACIÓN YA EXISTE, EN CASO DE QUE NO SE INSERTA* */
                            $tipoContrato = ejecutarConsulta6("SELECT tipo FROM contratos WHERE descripcion = '$CONTRATO' and tipo = '$TIPO_CONTRATO'");
                            $rowC = $tipoContrato->num_rows;
                            if ($rowC == 0 || $rowC == '') {
                                ejecutarConsulta6("INSERT INTO contratos(descripcion, tipo) VALUES ('$CONTRATO','$TIPO_CONTRATO')");
                            }
                            $ingresado += 1;
                        }//fin del if que comprueba que se guarden los $datos
                        else {//sino ingresa el producto
                            echo $msj = '<font color=red>Dato <b>' . $Name . ' </b> no almacenado' . mysqli_error() . '</font><br/>';
                            $error += 1;
                        }

                        if ($TELEFONO_01 != '') {
                            $vTelefono1 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_01','','SG','$dateNow','$dateNow','TELEFONO_01','$Identification')");
                        }
                        if ($TELEFONO_02 != '') {
                            $vTelefono2 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_02','','SG','$dateNow','$dateNow','TELEFONO_02','$Identification')");
                        }
                        if ($TELEFONO_03 != '') {
                            $vTelefono3 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_03','','SG','$dateNow','$dateNow','TELEFONO_03','$Identification')");
                        }
                        if ($TELEFONO_04 != '') {
                            $vTelefono4 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_04','','SG','$dateNow','$dateNow','TELEFONO_04','$Identification')");
                        }
                        if ($TELEFONO_05 != '') {
                            $vTelefono5 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_05','','SG','$dateNow','$dateNow','TELEFONO_05','$Identification')");
                        }
                        if ($TELEFONO_06 != '') {
                            $vTelefono6 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_06','','SG','$dateNow','$dateNow','TELEFONO_06','$Identification')");
                        }
                        if ($TELEFONO_07 != '') {
                            $vTELEFONO_07 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_07','','SG','$dateNow','$dateNow','TELEFONO_07','$Identification')");
                        }
                        if ($TELEFONO_08 != '') {
                            $vTELEFONO_08 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_08','','SG','$dateNow','$dateNow','TELEFONO_08','$Identification')");
                        }
                        if ($TELEFONO_09 != '') {
                            $vTELEFONO_09 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_09','','SG','$dateNow','$dateNow','TELEFONO_09','$Identification')");
                        }
                        if ($TELEFONO_10 != '') {
                            $vTELEFONO_10 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_10','','SG','$dateNow','$dateNow','TELEFONO_10','$Identification')");
                        }
                    }//fin de if que comprueba que no haya en registro duplicado
                    else {
                        $duplicado += 1;
                        echo $duplicate = '<font color=#F3D305>El dato <b>' . $Name . '</b> está duplicado<br></font>';
                    }
                }
                echo "<b>La importación $nameExcel tiene el siguiente detalle:</b><br/>";
                echo "<font color=green>" . $ingresado . " Datos almacenados con éxito<br/>";
                echo "<font color=#F3D305>" . $duplicado . " Datos duplicados<br/>";
                echo "<font color=red>" . $error . " Errores de almacenamiento<br/>";

                $vContactDetails = ejecutarConsulta("INSERT INTO contactimportdetail(VCC, ImportId, UpdateNum, "
                        . "Date, ImportUser, ValidContacts, NewContacts, UpdatedContacts, "
                        . "InvalidContacts, DuplicatesContacts) "
                        . "VALUES ('$vcc','$LastUpdate','1','$dateNow','$_SESSION[usu]','$ingresado','$ingresado',"
                        . "'0','$error','$duplicado')");

                $vContactImport = ejecutarConsulta("INSERT INTO contactimport(VCC, ID, DBProvider,"
                        . "Updates, Status, ServiceId) "
                        . "VALUES ('$vcc','$LastUpdate','$LastUpdate','1',"
                        . "case when $error = 0  then 'COMPLETE' else 'INCOMPLETE' end,'NULL')");
            }
        } else {
            echo 'El archivo no es CSV';
        }
        break;

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

            $sql = ejecutarConsulta("select Id from campaign where Id = '$campaignId'");
            $vCamp = mysqli_fetch_array($sql, MYSQLI_BOTH);
            $sql1 = ejecutarConsulta("SELECT DISTINCT lastupdate FROM contactimportcontact "
                    . "WHERE EXISTS (SELECT DISTINCT lastupdate FROM contactimportcontact c "
                    . "WHERE c.lastupdate = '$nameExcel')");
            $vImport = mysqli_fetch_array($sql1, MYSQLI_BOTH);
            if ($vCamp["Id"] == "") {
                echo("No exite la campaña seleccionada");
                //} else if ($vImport != "") {
                // echo("Nombre de importación duplicado");
            } else {
                while (($datos = fgetcsv($users, 100000, ";")) !== FALSE) {//Leo linea por linea del archivo hasta un maximo de 1000 caracteres por linea leida usando coma(,) o (;) como delimitador
                    $row++;
                    if ($row > 1) {
                        $linea[] = array(//Arreglo Bidimensional para guardar los datos de cada linea leida del archivo
                            'ID' => "",
                            'CODIGO_CAMPANIA' => $datos[1],
                            'NOMBRE_CAMPANIA' => $datos[2],
                            'NUPS' => $datos[3],
                            'IDENTIFICACION' => $datos[4],
                            'NOMBRE' => $datos[5],
                            'PERFILRIESGOENDEUDAMIENTO' => $datos[6],
                            'SUBSEGMENTO' => $datos[7],
                            'EDAD' => $datos[8],
                            'CREDITO_CONSUMO_ESCENARIO_1' => $datos[9],
                            'CUOTA_CONSUMO_ESCENARIO_1' => $datos[10],
                            'PLAZO_CONSUMO_ESCENARIO_1' => $datos[11],
                            'GARANTE_CONSUMO_ESCENARIO_1' => $datos[12],
                            'TARJETA_ESCENARIO_1' => $datos[13],
                            'PLASTICO_1_TARJETA_ESCENARIO_1' => $datos[14],
                            'MARCA_ESCENARIO_1' => $datos[15],
                            'PRODUCTO_ESCENARIO_1' => $datos[16],
                            'CREDITO_CONSUMO_EXCLUSIVO' => $datos[17],
                            'CUOTA_CONSUMO_EXCLUSIVO' => $datos[18],
                            'PLAZO_CONSUMO_EXCLUSIVO' => $datos[19],
                            'GARANTE_CONSUMO_EXCLUSIVO' => $datos[20],
                            'CREDITO_CONSUMO_ROL' => $datos[21],
                            'CUOTA_CONSUMO_ROL' => $datos[22],
                            'GARANTE_CONSUMO_ROL' => $datos[23],
                            'TARJETA_EXCLUSIVA' => $datos[24],
                            'PLASTICO_1_TARJETA_EXCLUSIVA' => $datos[25],
                            'MARCA_TARJETA_EXCLUSIVA' => $datos[26],
                            'PRODUCTO_TARJETA_EXCLUSIVA' => $datos[27],
                            'MAXIMO_CONSUMO' => $datos[28],
                            'MAXIMA_TARJETA' => $datos[29],
                            'BANCA' => $datos[30],
                            'SEGMENTO' => $datos[31],
                            'SEGMENTO_N_2' => $datos[32],
                            'SUBSEGMENTO1' => $datos[33],
                            'REGION' => $datos[34],
                            'ZONA' => $datos[35],
                            'AGENCIA' => $datos[36],
                            'FECHA_NACIMIENTO' => $datos[37],
                            'SEXO' => $datos[38],
                            'ESTADO_CIVIL' => $datos[39],
                            'PAIS_DOM_CAL_DAT' => $datos[40],
                            'PROV_DOM_CAL_DAT' => $datos[41],
                            'CIUDAD_DOM_CAL_DAT' => $datos[42],
                            'DIR_DOM_CAL_DAT' => $datos[43],
                            'PAIS_TRAB_1_CAL_DAT' => $datos[44],
                            'PROV_TRAB_1_CAL_DAT' => $datos[45],
                            'CIUDAD_TRAB_1_CAL_DAT' => $datos[46],
                            'DIR_TRAB_1_CAL_DAT' => $datos[47],
                            'IDENTIFICACION_PARENTEZCO' => $datos[48],
                            'CALIFICACION_BURO' => $datos[49],
                            'NOMBRES' => $datos[50],
                            'DES_SEXO' => $datos[51],
                            'FECH_NAC' => $datos[52],
                            'NUMERO_CARGAS_FAMILIARES' => $datos[53],
                            'TIENE_DEUDA_PROTEGIDA' => $datos[54],
                            'TIENE_TDC' => $datos[55],
                            'COD_MARCA' => $datos[56],
                            'PLAN_RECOMPENSAS' => $datos[57],
                            'FECHA_INGRESO_SOCIO' => $datos[58],
                            'NUMERO_CUENTA1' => $datos[59],
                            'PRODUCTO_CTA1' => $datos[60],
                            'DESCRIPCION1' => $datos[61],
                            'CANAL' => $datos[62],
                            'DIFERENCIA_CUPOS' => $datos[63],
                            'CATEGORIZACION' => $datos[64],
                            'TIPO_BASE' => $datos[65],
                            'REGION_ANCLAJE' => $datos[66],
                            'PLAZO_CONSUMO_ROL' => $datos[67],
                            'TELEFONO_01' => $datos[68],
                            'TELEFONO_02' => $datos[69],
                            'TELEFONO_03' => $datos[70],
                            'TELEFONO_04' => $datos[71],
                            'TELEFONO_05' => $datos[72],
                            'TELEFONO_06' => $datos[73],
                            'TELEFONO_07' => $datos[74],
                            'TELEFONO_08' => $datos[75],
                            'TELEFONO_09' => $datos[76],
                            'TELEFONO_10' => $datos[77],
                            'VERTELEF5' => $datos[78],
                            'VERTELEF6' => $datos[79],
                            'CORREO1' => $datos[80],
                            'CORREO2' => $datos[81],
                            'CORREO3' => $datos[82],
                            'CORREO4' => $datos[83],
                            'CORREO5' => $datos[84],
                            'CORREO6' => $datos[85],
                            'DES_NACIONALID' => $datos[86],
                            'CANT_NAC' => $datos[87],
                            'ACTIVIDAD_ECONOMICA' => $datos[88],
                            'DES_CANAL' => $datos[89],
                            'CUENTA' => $datos[90],
                            'NUMERO_TARJETA' => $datos[91],
                            'PRODUCTO' => $datos[92],
                            'TIPOTC' => $datos[93],
                            'FAMILIA' => $datos[94],
                            'CUPO' => $datos[95],
                            'CUPO_DISPONIBLE' => $datos[96],
                            'HIJOS_MAS_18' => $datos[97],
                            'HIJOS_MENOS_18' => $datos[98],
                            'HERMANOS_MENOS_18' => $datos[99],
                            'HERMANOS_MAS_18' => $datos[100],
                            'MAMA' => $datos[101],
                            'PAPA' => $datos[102],
                            'CONYUG' => $datos[103],
                            'MARCA_CUPO' => $datos[104],
                            'NRO_TDC_COMPETENCIA' => $datos[105],
                            'CUPO_MAX_COMP' => $datos[106],
                            'CONSUMO_PROMEDIO' => $datos[107],
                            'PRIORIDAD_GESTION' => $datos[108],
                            'PRIMER_NOMBRE' => $datos[109],
                            'SEGUNDO_NOMBRE' => $datos[110],
                            'PRIMER_APELLIDO' => $datos[111],
                            'SEGUNDO_APELLIDO' => $datos[112],
                        );
                    }
                }
                fclose($users); //Cierra el archivo
                $ingresado = 0; //Variable que almacenara los insert exitosos
                $error = 0; //Variable que almacenara los errores en almacenamiento
                $duplicado = 0; //Variable que almacenara los registros duplicados
                foreach ($linea as $indice => $value) { //Iteracion el array para extraer cada uno de los valores almacenados en cada items
                    $count = ejecutarConsultaSimple("select UUID() 'id'");
                    $idG = $count['id'];
                    //Almacenamos info en contactimportcontact. Datos traidos del array para almacenar en la base
                    $ID = $idG;
                    $Name = $value["NOMBRE"];
                    $Identification = $value["IDENTIFICACION"];
                    $Campaign = $campaignId;
                    $LastManagementResult = "";
                    $LastUpdate = $nameExcel;
                    $CODIGO_CAMPANIA = $value['CODIGO_CAMPANIA'];
                    $NOMBRE_CAMPANIA = $value['NOMBRE_CAMPANIA'];
                    $NUPS = $value['NUPS'];
                    $PERFILRIESGOENDEUDAMIENTO = $value['PERFILRIESGOENDEUDAMIENTO'];
                    $SUBSEGMENTO = $value['SUBSEGMENTO'];
                    $EDAD = $value['EDAD'];
                    $CREDITO_CONSUMO_ESCENARIO_1 = $value['CREDITO_CONSUMO_ESCENARIO_1'];
                    $CUOTA_CONSUMO_ESCENARIO_1 = $value['CUOTA_CONSUMO_ESCENARIO_1'];
                    $PLAZO_CONSUMO_ESCENARIO_1 = $value['PLAZO_CONSUMO_ESCENARIO_1'];
                    $GARANTE_CONSUMO_ESCENARIO_1 = $value['GARANTE_CONSUMO_ESCENARIO_1'];
                    $TARJETA_ESCENARIO_1 = $value['TARJETA_ESCENARIO_1'];
                    $PLASTICO_1_TARJETA_ESCENARIO_1 = $value['PLASTICO_1_TARJETA_ESCENARIO_1'];
                    $MARCA_ESCENARIO_1 = $value['MARCA_ESCENARIO_1'];
                    $PRODUCTO_ESCENARIO_1 = $value['PRODUCTO_ESCENARIO_1'];
                    $CREDITO_CONSUMO_EXCLUSIVO = $value['CREDITO_CONSUMO_EXCLUSIVO'];
                    $CUOTA_CONSUMO_EXCLUSIVO = $value['CUOTA_CONSUMO_EXCLUSIVO'];
                    $PLAZO_CONSUMO_EXCLUSIVO = $value['PLAZO_CONSUMO_EXCLUSIVO'];
                    $GARANTE_CONSUMO_EXCLUSIVO = $value['GARANTE_CONSUMO_EXCLUSIVO'];
                    $CREDITO_CONSUMO_ROL = $value['CREDITO_CONSUMO_ROL'];
                    $CUOTA_CONSUMO_ROL = $value['CUOTA_CONSUMO_ROL'];
                    $GARANTE_CONSUMO_ROL = $value['GARANTE_CONSUMO_ROL'];
                    $TARJETA_EXCLUSIVA = $value['TARJETA_EXCLUSIVA'];
                    $PLASTICO_1_TARJETA_EXCLUSIVA = $value['PLASTICO_1_TARJETA_EXCLUSIVA'];
                    $MARCA_TARJETA_EXCLUSIVA = $value['MARCA_TARJETA_EXCLUSIVA'];
                    $PRODUCTO_TARJETA_EXCLUSIVA = $value['PRODUCTO_TARJETA_EXCLUSIVA'];
                    $MAXIMO_CONSUMO = $value['MAXIMO_CONSUMO'];
                    $MAXIMA_TARJETA = $value['MAXIMA_TARJETA'];
                    $BANCA = $value['BANCA'];
                    $SEGMENTO = $value['SEGMENTO'];
                    $SEGMENTO_N_2 = $value['SEGMENTO_N_2'];
                    $SUBSEGMENTO1 = $value['SUBSEGMENTO1'];
                    $REGION = $value['REGION'];
                    $ZONA = $value['ZONA'];
                    $AGENCIA = $value['AGENCIA'];
                    $FECHA_NACIMIENTO = $value['FECHA_NACIMIENTO'];
                    $SEXO = $value['SEXO'];
                    $ESTADO_CIVIL = $value['ESTADO_CIVIL'];
                    $PAIS_DOM_CAL_DAT = $value['PAIS_DOM_CAL_DAT'];
                    $PROV_DOM_CAL_DAT = $value['PROV_DOM_CAL_DAT'];
                    $CIUDAD_DOM_CAL_DAT = $value['CIUDAD_DOM_CAL_DAT'];
                    $DIR_DOM_CAL_DAT = $value['DIR_DOM_CAL_DAT'];
                    $PAIS_TRAB_1_CAL_DAT = $value['PAIS_TRAB_1_CAL_DAT'];
                    $PROV_TRAB_1_CAL_DAT = $value['PROV_TRAB_1_CAL_DAT'];
                    $CIUDAD_TRAB_1_CAL_DAT = $value['CIUDAD_TRAB_1_CAL_DAT'];
                    $DIR_TRAB_1_CAL_DAT = $value['DIR_TRAB_1_CAL_DAT'];
                    $IDENTIFICACION_PARENTEZCO = $value['IDENTIFICACION_PARENTEZCO'];
                    $CALIFICACION_BURO = $value['CALIFICACION_BURO'];
                    $NOMBRES = $value['NOMBRES'];
                    $DES_SEXO = $value['DES_SEXO'];
                    $FECH_NAC = $value['FECH_NAC'];
                    $NUMERO_CARGAS_FAMILIARES = $value['NUMERO_CARGAS_FAMILIARES'];
                    $TIENE_DEUDA_PROTEGIDA = $value['TIENE_DEUDA_PROTEGIDA'];
                    $TIENE_TDC = $value['TIENE_TDC'];
                    $COD_MARCA = $value['COD_MARCA'];
                    $PLAN_RECOMPENSAS = $value['PLAN_RECOMPENSAS'];
                    $FECHA_INGRESO_SOCIO = $value['FECHA_INGRESO_SOCIO'];
                    $NUMERO_CUENTA1 = $value['NUMERO_CUENTA1'];
                    $PRODUCTO_CTA1 = $value['PRODUCTO_CTA1'];
                    $DESCRIPCION1 = $value['DESCRIPCION1'];
                    $CANAL = $value['CANAL'];
                    $DIFERENCIA_CUPOS = $value['DIFERENCIA_CUPOS'];
                    $CATEGORIZACION = $value['CATEGORIZACION'];
                    $TIPO_BASE = $value['TIPO_BASE'];
                    $REGION_ANCLAJE = $value['REGION_ANCLAJE'];
                    $PLAZO_CONSUMO_ROL = $value['PLAZO_CONSUMO_ROL'];
                    $TELEFONO_01 = $value['TELEFONO_01'];
                    $TELEFONO_02 = $value['TELEFONO_02'];
                    $TELEFONO_03 = $value['TELEFONO_03'];
                    $TELEFONO_04 = $value['TELEFONO_04'];
                    $TELEFONO_05 = $value['TELEFONO_05'];
                    $TELEFONO_06 = $value['TELEFONO_06'];
                    $TELEFONO_07 = $value['TELEFONO_07'];
                    $TELEFONO_08 = $value['TELEFONO_08'];
                    $TELEFONO_09 = $value['TELEFONO_09'];
                    $TELEFONO_10 = $value['TELEFONO_10'];
                    $VERTELEF5 = $value['VERTELEF5'];
                    $VERTELEF6 = $value['VERTELEF6'];
                    $CORREO1 = $value['CORREO1'];
                    $CORREO2 = $value['CORREO2'];
                    $CORREO3 = $value['CORREO3'];
                    $CORREO4 = $value['CORREO4'];
                    $CORREO5 = $value['CORREO5'];
                    $CORREO6 = $value['CORREO6'];
                    $DES_NACIONALID = $value['DES_NACIONALID'];
                    $CANT_NAC = $value['CANT_NAC'];
                    $ACTIVIDAD_ECONOMICA = $value['ACTIVIDAD_ECONOMICA'];
                    $DES_CANAL = $value['DES_CANAL'];
                    $CUENTA = $value['CUENTA'];
                    $NUMERO_TARJETA = $value['NUMERO_TARJETA'];
                    $PRODUCTO = $value['PRODUCTO'];
                    $TIPOTC = $value['TIPOTC'];
                    $FAMILIA = $value['FAMILIA'];
                    $CUPO = $value['CUPO'];
                    $CUPO_DISPONIBLE = $value['CUPO_DISPONIBLE'];
                    $HIJOS_MAS_18 = $value['HIJOS_MAS_18'];
                    $HIJOS_MENOS_18 = $value['HIJOS_MENOS_18'];
                    $HERMANOS_MENOS_18 = $value['HERMANOS_MENOS_18'];
                    $HERMANOS_MAS_18 = $value['HERMANOS_MAS_18'];
                    $MAMA = $value['MAMA'];
                    $PAPA = $value['PAPA'];
                    $CONYUG = $value['CONYUG'];
                    $MARCA_CUPO = $value['MARCA_CUPO'];
                    $NRO_TDC_COMPETENCIA = $value['NRO_TDC_COMPETENCIA'];
                    $CUPO_MAX_COMP = $value['CUPO_MAX_COMP'];
                    $CONSUMO_PROMEDIO = $value['CONSUMO_PROMEDIO'];
                    $PRIORIDAD_GESTION = $value['PRIORIDAD_GESTION'];
                    $PRIMER_NOMBRE = $value['PRIMER_NOMBRE'];
                    $SEGUNDO_NOMBRE = $value['SEGUNDO_NOMBRE'];
                    $PRIMER_APELLIDO = $value['PRIMER_APELLIDO'];
                    $SEGUNDO_APELLIDO = $value['SEGUNDO_APELLIDO'];

                    $sql = ejecutarConsulta("select * from contactimportcontact where Id='$ID'"); //Consulta a la tabla
                    $num = mysqli_num_rows($sql); //Cuenta el numero de registros devueltos por la consulta
                    if ($num == 0) {//Si es == 0 inserto
                        if ($insert = ejecutarConsulta("insert into contactimportcontact (VCC, ID, Name, Identification, Campaign, LastManagementResult, LastUpdate) "
                                . "values('$vcc','$ID','$Name','$Identification','$Campaign','$LastManagementResult','$LastUpdate')")) {

                            $vClients = ejecutarConsulta1("INSERT INTO clientes(VCC,CampaignId, InteractionId, ImportId, LastAgent, ResultLevel1, ResultLevel2, ResultLevel3, ManagementResultCode, "
                                    . "ManagementResultDescription, TmStmp, ID, CODIGO_CAMPANIA, NOMBRE_CAMPANIA, NUPS, IDENTIFICACION, NOMBRE, "
                                    . "PERFILRIESGOENDEUDAMIENTO, SUBSEGMENTO, EDAD,CREDITO_CONSUMO_ESCENARIO_1, CUOTA_CONSUMO_ESCENARIO_1, "
                                    . "PLAZO_CONSUMO_ESCENARIO_1, GARANTE_CONSUMO_ESCENARIO_1, TARJETA_ESCENARIO_1, PLASTICO_1_TARJETA_ESCENARIO_1, "
                                    . "MARCA_ESCENARIO_1, PRODUCTO_ESCENARIO_1, CREDITO_CONSUMO_EXCLUSIVO, "
                                    . "CUOTA_CONSUMO_EXCLUSIVO, PLAZO_CONSUMO_EXCLUSIVO, GARANTE_CONSUMO_EXCLUSIVO, "
                                    . "CREDITO_CONSUMO_ROL, CUOTA_CONSUMO_ROL, GARANTE_CONSUMO_ROL, TARJETA_EXCLUSIVA, "
                                    . "PLASTICO_1_TARJETA_EXCLUSIVA, MARCA_TARJETA_EXCLUSIVA, PRODUCTO_TARJETA_EXCLUSIVA, "
                                    . "MAXIMO_CONSUMO, MAXIMA_TARJETA, BANCA, SEGMENTO, SEGMENTO_N_2, SUBSEGMENTO1, "
                                    . "REGION, ZONA, AGENCIA, FECHA_NACIMIENTO, SEXO, ESTADO_CIVIL, PAIS_DOM_CAL_DAT, "
                                    . "PROV_DOM_CAL_DAT, CIUDAD_DOM_CAL_DAT, DIR_DOM_CAL_DAT, PAIS_TRAB_1_CAL_DAT, "
                                    . "PROV_TRAB_1_CAL_DAT, CIUDAD_TRAB_1_CAL_DAT, DIR_TRAB_1_CAL_DAT, IDENTIFICACION_PARENTEZCO, "
                                    . "CALIFICACION_BURO, NOMBRES, DES_SEXO, FECH_NAC, NUMERO_CARGAS_FAMILIARES, "
                                    . "TIENE_DEUDA_PROTEGIDA, TIENE_TDC, COD_MARCA, PLAN_RECOMPENSAS, FECHA_INGRESO_SOCIO, "
                                    . "NUMERO_CUENTA1, PRODUCTO_CTA1, DESCRIPCION1, CANAL, DIFERENCIA_CUPOS, CATEGORIZACION, "
                                    . "TIPO_BASE, REGION_ANCLAJE, PLAZO_CONSUMO_ROL, CORREO1, CORREO2, CORREO3, CORREO4, "
                                    . "CORREO5, CORREO6, DES_NACIONALID, CANT_NAC, ACTIVIDAD_ECONOMICA, DES_CANAL, CUENTA, "
                                    . "NUMERO_TARJETA, PRODUCTO, TIPOTC, FAMILIA, CUPO, CUPO_DISPONIBLE, HIJOS_MAS_18, "
                                    . "HIJOS_MENOS_18, HERMANOS_MENOS_18, HERMANOS_MAS_18, MAMA, PAPA, CONYUG, MARCA_CUPO, "
                                    . "NRO_TDC_COMPETENCIA, CUPO_MAX_COMP, CONSUMO_PROMEDIO, PRIORIDAD_GESTION, NOMBRE1, NOMBRE2, "
                                    . "APELLIDO1, APELLIDO2) VALUES ('$vcc','$Campaign','NULL','$LastUpdate','Pendiente','Pendiente','Pendiente','Pendiente','0',"
                                    . "'Pendiente', '','$ID','$CODIGO_CAMPANIA','$NOMBRE_CAMPANIA','$NUPS','$Identification','$Name',"
                                    . "'$PERFILRIESGOENDEUDAMIENTO','$SUBSEGMENTO','$EDAD','$CREDITO_CONSUMO_ESCENARIO_1','$CUOTA_CONSUMO_ESCENARIO_1',"
                                    . "'$PLAZO_CONSUMO_ESCENARIO_1','$GARANTE_CONSUMO_ESCENARIO_1','$TARJETA_ESCENARIO_1','$PLASTICO_1_TARJETA_ESCENARIO_1',"
                                    . "'$MARCA_ESCENARIO_1','$PRODUCTO_ESCENARIO_1','$CREDITO_CONSUMO_EXCLUSIVO',"
                                    . "'$CUOTA_CONSUMO_EXCLUSIVO','$PLAZO_CONSUMO_EXCLUSIVO','$GARANTE_CONSUMO_EXCLUSIVO','$CREDITO_CONSUMO_ROL',"
                                    . "'$CUOTA_CONSUMO_ROL','$GARANTE_CONSUMO_ROL','$TARJETA_EXCLUSIVA','$PLASTICO_1_TARJETA_EXCLUSIVA','$MARCA_TARJETA_EXCLUSIVA',"
                                    . "'$PRODUCTO_TARJETA_EXCLUSIVA','$MAXIMO_CONSUMO','$MAXIMA_TARJETA','$BANCA','$SEGMENTO','$SEGMENTO_N_2','$SUBSEGMENTO1',"
                                    . "'$REGION','$ZONA','$AGENCIA','$FECHA_NACIMIENTO','$SEXO','$ESTADO_CIVIL','$PAIS_DOM_CAL_DAT','$PROV_DOM_CAL_DAT',"
                                    . "'$CIUDAD_DOM_CAL_DAT','$DIR_DOM_CAL_DAT','$PAIS_TRAB_1_CAL_DAT','$PROV_TRAB_1_CAL_DAT','$CIUDAD_TRAB_1_CAL_DAT',"
                                    . "'$DIR_TRAB_1_CAL_DAT','$IDENTIFICACION_PARENTEZCO','$CALIFICACION_BURO','$NOMBRES','$DES_SEXO','$FECH_NAC',"
                                    . "'$NUMERO_CARGAS_FAMILIARES','$TIENE_DEUDA_PROTEGIDA','$TIENE_TDC','$COD_MARCA','$PLAN_RECOMPENSAS','$FECHA_INGRESO_SOCIO',"
                                    . "'$NUMERO_CUENTA1','$PRODUCTO_CTA1','$DESCRIPCION1','$CANAL','$DIFERENCIA_CUPOS','$CATEGORIZACION','$TIPO_BASE',"
                                    . "'$REGION_ANCLAJE','$PLAZO_CONSUMO_ROL','$CORREO1','$CORREO2','$CORREO3','$CORREO4','$CORREO5',"
                                    . "'$CORREO6','$DES_NACIONALID','$CANT_NAC','$ACTIVIDAD_ECONOMICA','$DES_CANAL','$CUENTA','$NUMERO_TARJETA','$PRODUCTO',"
                                    . "'$TIPOTC','$FAMILIA','$CUPO','$CUPO_DISPONIBLE','$HIJOS_MAS_18','$HIJOS_MENOS_18','$HERMANOS_MENOS_18','$HERMANOS_MAS_18',"
                                    . "'$MAMA','$PAPA','$CONYUG','$MARCA_CUPO','$NRO_TDC_COMPETENCIA','$CUPO_MAX_COMP','$CONSUMO_PROMEDIO','$PRIORIDAD_GESTION',"
                                    . "'$PRIMER_NOMBRE','$SEGUNDO_NOMBRE','$PRIMER_APELLIDO','$SEGUNDO_APELLIDO')");

                            $msj = '<font color=green>Dato <b>' . $Name . '</b> Guardado</font><br/>';
                            $ingresado += 1;
                        }//fin del if que comprueba que se guarden los $datos
                        else {//sino ingresa el producto
                            echo $msj = '<font color=red>Dato <b>' . $Name . ' </b> no almacenado' . mysqli_error() . '</font><br/>';
                            $error += 1;
                        }

                        if ($TELEFONO_01 != '') {
                            $vTelefono1 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_01','','SG','$dateNow','$dateNow','TELEFONO_01','$Identification')");
                        }
                        if ($TELEFONO_02 != '') {
                            $vTelefono2 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_02','','SG','$dateNow','$dateNow','TELEFONO_02','$Identification')");
                        }
                        if ($TELEFONO_03 != '') {
                            $vTelefono3 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_03','','SG','$dateNow','$dateNow','TELEFONO_03','$Identification')");
                        }
                        if ($TELEFONO_04 != '') {
                            $vTelefono4 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_04','','SG','$dateNow','$dateNow','TELEFONO_04','$Identification')");
                        }
                        if ($TELEFONO_05 != '') {
                            $vTelefono5 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_05','','SG','$dateNow','$dateNow','TELEFONO_05','$Identification')");
                        }
                        if ($TELEFONO_06 != '') {
                            $vTelefono6 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_06','','SG','$dateNow','$dateNow','TELEFONO_06','$Identification')");
                        }
                        if ($TELEFONO_07 != '') {
                            $vTELEFONO_07 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_07','','SG','$dateNow','$dateNow','TELEFONO_07','$Identification')");
                        }
                        if ($TELEFONO_08 != '') {
                            $vTELEFONO_08 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_08','','SG','$dateNow','$dateNow','TELEFONO_08','$Identification')");
                        }
                        if ($TELEFONO_09 != '') {
                            $vTELEFONO_09 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_09','','SG','$dateNow','$dateNow','TELEFONO_09','$Identification')");
                        }
                        if ($TELEFONO_10 != '') {
                            $vTELEFONO_10 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_10','','SG','$dateNow','$dateNow','TELEFONO_10','$Identification')");
                        }
                    }//fin de if que comprueba que no haya en registro duplicado
                    else {
                        $duplicado += 1;
                        echo $duplicate = '<font color=#F3D305>El dato <b>' . $Name . '</b> está duplicado<br></font>';
                    }
                }
                echo "<b>La importación $nameExcel tiene el siguiente detalle:</b><br/>";
                echo "<font color=green>" . $ingresado . " Datos almacenados con éxito<br/>";
                echo "<font color=#F3D305>" . $duplicado . " Datos duplicados<br/>";
                echo "<font color=red>" . $error . " Errores de almacenamiento<br/>";

                $vContactDetails = ejecutarConsulta("INSERT INTO contactimportdetail(VCC, ImportId, UpdateNum, "
                        . "Date, ImportUser, ValidContacts, NewContacts, UpdatedContacts, "
                        . "InvalidContacts, DuplicatesContacts) "
                        . "VALUES ('$vcc','$LastUpdate','1','$dateNow','$_SESSION[usu]','$ingresado','$ingresado',"
                        . "'0','$error','$duplicado')");

                $vContactImport = ejecutarConsulta("INSERT INTO contactimport(VCC, ID, DBProvider,"
                        . "Updates, Status, ServiceId) "
                        . "VALUES ('$vcc','$LastUpdate','$LastUpdate','1',"
                        . "case when $error = 0  then 'COMPLETE' else 'INCOMPLETE' end,'NULL')");
            }
        }
        break;

    case 'bancoPichinchaEncuestas':
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

            $sql = ejecutarConsulta("SELECT DISTINCT CampaignId 'Id' FROM campaignresultmanagement where CampaignId = '$campaignId'");
            $vCamp = mysqli_fetch_array($sql, MYSQLI_BOTH);
            $sql1 = ejecutarConsulta("SELECT DISTINCT lastupdate FROM contactimportcontact "
                    . "WHERE EXISTS (SELECT DISTINCT lastupdate FROM contactimportcontact c "
                    . "WHERE c.lastupdate = '$nameExcel')");
            $vImport = mysqli_fetch_array($sql1, MYSQLI_BOTH);
            if ($vCamp["Id"] == "") {
                echo("No exite la campaña seleccionada");
                //} else if ($vImport != "") {
                // echo("Nombre de importación duplicado");
            } else {
                while (($datos = fgetcsv($users, 100000, ";")) !== FALSE) {//Leo linea por linea del archivo hasta un maximo de 1000 caracteres por linea leida usando coma(,) o (;) como delimitador
                    $row++;
                    if ($row > 1) {
                        $linea[] = array(//Arreglo Bidimensional para guardar los datos de cada linea leida del archivo
                            'CODIGOCAMPANA' => $datos[0],
                            'NOMBRE_CAMPANA' => $datos[1],
                            'IDENTIFICACION' => $datos[2],
                            'NOMBRE_CLIENTE' => $datos[3],
                            'CODIGO_AGENCIA' => $datos[4],
                            'AGENCIA' => $datos[5],
                            'ZONA' => $datos[6],
                            'REGION' => $datos[7],
                            'SUBSEGMENTO' => $datos[8],
                            'VAR_TOTAL_AHORROS_AGO30' => $datos[9],
                            'VAR_TOTAL_AHORROS_SEP20' => $datos[10],
                            'PRIORIDAD' => $datos[11],
                            'FAMILIA' => $datos[12],
                            'PRODUCTO' => $datos[13],
                            'PLAN_RECOMPENSAS' => $datos[14],
                            'COD_MARCA' => $datos[15],
                            'TELEFONO_01' => $datos[16],
                            'TELEFONO_02' => $datos[17],
                            'TELEFONO_03' => $datos[18],
                            'TELEFONO_04' => $datos[19],
                            'TELEFONO_05' => $datos[20],
                            'TELEFONO_06' => $datos[21],
                            'TELEFONO_07' => $datos[22],
                            'TELEFONO_08' => $datos[23],
                            'TELEFONO_09' => $datos[24],
                            'TELEFONO_10' => $datos[25],
                            'CORREO_TRX' => $datos[26],
                            'CORREO' => $datos[27],
                        );
                    }
                }
                fclose($users); //Cierra el archivo
                $ingresado = 0; //Variable que almacenara los insert exitosos
                $error = 0; //Variable que almacenara los errores en almacenamiento
                $duplicado = 0; //Variable que almacenara los registros duplicados
                foreach ($linea as $indice => $value) { //Iteracion el array para extraer cada uno de los valores almacenados en cada items
                    $count = ejecutarConsultaSimple("select UUID() 'id'");
                    $idG = $count['id'];
                    //Almacenamos info en contactimportcontact. Datos traidos del array para almacenar en la base
                    $ID = $idG;
                    $Name = $value["NOMBRE_CLIENTE"];
                    $Identification = $value["IDENTIFICACION"];
                    $Campaign = $campaignId;
                    $LastManagementResult = "";
                    $LastUpdate = $nameExcel;
                    $CODIGOCAMPANA = $value['CODIGOCAMPANA'];
                    $NOMBRE_CAMPANA = $value['NOMBRE_CAMPANA'];
                    $IDENTIFICACION = $value['IDENTIFICACION'];
                    $NOMBRE_CLIENTE = $value['NOMBRE_CLIENTE'];
                    $CODIGO_AGENCIA = $value['CODIGO_AGENCIA'];
                    $AGENCIA = $value['AGENCIA'];
                    $ZONA = $value['ZONA'];
                    $REGION = $value['REGION'];
                    $SUBSEGMENTO = $value['SUBSEGMENTO'];
                    $VAR_TOTAL_AHORROS_AGO30 = $value['VAR_TOTAL_AHORROS_AGO30'];
                    $VAR_TOTAL_AHORROS_SEP20 = $value['VAR_TOTAL_AHORROS_SEP20'];
                    $PRIORIDAD = $value['PRIORIDAD'];
                    $FAMILIA = $value['FAMILIA'];
                    $PRODUCTO = $value['PRODUCTO'];
                    $PLAN_RECOMPENSAS = $value['PLAN_RECOMPENSAS'];
                    $COD_MARCA = $value['COD_MARCA'];
                    $TELEFONO_01 = $value['TELEFONO_01'];
                    $TELEFONO_02 = $value['TELEFONO_02'];
                    $TELEFONO_03 = $value['TELEFONO_03'];
                    $TELEFONO_04 = $value['TELEFONO_04'];
                    $TELEFONO_05 = $value['TELEFONO_05'];
                    $TELEFONO_06 = $value['TELEFONO_06'];
                    $TELEFONO_07 = $value['TELEFONO_07'];
                    $TELEFONO_08 = $value['TELEFONO_08'];
                    $TELEFONO_09 = $value['TELEFONO_09'];
                    $TELEFONO_10 = $value['TELEFONO_10'];
                    $CORREO_TRX = $value['CORREO_TRX'];
                    $CORREO = $value['CORREO'];

                    $sql = ejecutarConsulta("select * from contactimportcontact where Id='$ID'"); //Consulta a la tabla
                    $num = mysqli_num_rows($sql); //Cuenta el numero de registros devueltos por la consulta
                    if ($num == 0) {//Si es == 0 inserto
                        if ($insert = ejecutarConsulta("insert into contactimportcontact (VCC, ID, Name, Identification, Campaign, LastManagementResult, LastUpdate) "
                                . "values('$vcc','$ID','$Name','$Identification','$Campaign','$LastManagementResult','$LastUpdate')")) {
                            $msj = '<font color=green>Dato <b>' . $Name . '</b> Guardado</font><br/>';
                            $ingresado += 1;
                        }//fin del if que comprueba que se guarden los $datos
                        else {//sino ingresa el producto
                            echo $msj = '<font color=red>Dato <b>' . $Name . ' </b> no almacenado' . mysqli_error() . '</font><br/>';
                            $error += 1;
                        }
                        ejecutarConsulta3("INSERT INTO clientes(VCC, CampaignId, ContactId, ContactName, InteractionId, "
                                . "ImportId, LastAgent, ResultLevel1, ResultLevel2, ResultLevel3, ManagementResultCode, "
                                . "ManagementResultDescription, TmStmp, "
                                . "ID, CODIGOCAMPANA, NOMBRE_CAMPANA, IDENTIFICACION, NOMBRE_CLIENTE, CODIGO_AGENCIA, AGENCIA, "
                                . "ZONA, REGION, SUBSEGMENTO, VAR_TOTAL_AHORROS_AGO30, VAR_TOTAL_AHORROS_SEP20, PRIORIDAD, "
                                . "FAMILIA, PRODUCTO, PLAN_RECOMPENSAS, COD_MARCA, CORREO_TRX, CORREO) VALUES "
                                . "('$vcc','$Campaign','$ID', '$NOMBRE_CLIENTE', '', '$LastUpdate','Pendiente','Pendiente','Pendiente','Pendiente','0',"
                                . "'Pendiente', '','$ID','$CODIGOCAMPANA','$NOMBRE_CAMPANA','$IDENTIFICACION','$NOMBRE_CLIENTE',"
                                . "'$CODIGO_AGENCIA','$AGENCIA','$ZONA','$REGION','$SUBSEGMENTO',"
                                . "'$VAR_TOTAL_AHORROS_AGO30','$VAR_TOTAL_AHORROS_SEP20','$PRIORIDAD','$FAMILIA',"
                                . "'$PRODUCTO','$PLAN_RECOMPENSAS','$COD_MARCA', '$CORREO_TRX','$CORREO')");

                        if ($TELEFONO_01 != '') {
                            $vTelefono1 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_01','','SG','$dateNow','$dateNow','TELEFONO_01','$Identification')");
                        }
                        if ($TELEFONO_02 != '') {
                            $vTelefono2 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_02','','SG','$dateNow','$dateNow','TELEFONO_02','$Identification')");
                        }
                        if ($TELEFONO_03 != '') {
                            $vTelefono3 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_03','','SG','$dateNow','$dateNow','TELEFONO_03','$Identification')");
                        }
                        if ($TELEFONO_04 != '') {
                            $vTelefono4 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_04','','SG','$dateNow','$dateNow','TELEFONO_04','$Identification')");
                        }
                        if ($TELEFONO_05 != '') {
                            $vTelefono5 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_05','','SG','$dateNow','$dateNow','TELEFONO_05','$Identification')");
                        }
                        if ($TELEFONO_06 != '') {
                            $vTelefono6 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_06','','SG','$dateNow','$dateNow','TELEFONO_06','$Identification')");
                        }
                        if ($TELEFONO_07 != '') {
                            $vTELEFONO_07 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_07','','SG','$dateNow','$dateNow','TELEFONO_07','$Identification')");
                        }
                        if ($TELEFONO_08 != '') {
                            $vTELEFONO_08 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_08','','SG','$dateNow','$dateNow','TELEFONO_08','$Identification')");
                        }
                        if ($TELEFONO_09 != '') {
                            $vTELEFONO_09 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_09','','SG','$dateNow','$dateNow','TELEFONO_09','$Identification')");
                        }
                        if ($TELEFONO_10 != '') {
                            $vTELEFONO_10 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_10','','SG','$dateNow','$dateNow','TELEFONO_10','$Identification')");
                        }
                    }//fin de if que comprueba que no haya en registro duplicado
                    else {
                        $duplicado += 1;
                        echo $duplicate = '<font color=#F3D305>El dato <b>' . $Name . '</b> está duplicado<br></font>';
                    }
                }
                echo "<b>La importación $nameExcel  tiene el siguiente detalle:</b><br/>";
                echo "<font color=green>" . $ingresado . " Datos almacenados con éxito<br/>";
                echo "<font color=#F3D305>" . $duplicado . " Datos duplicados<br/>";
                echo "<font color=red>" . $error . " Errores de almacenamiento<br/>";
                $vContactDetails = ejecutarConsulta("INSERT INTO contactimportdetail(VCC, ImportId, UpdateNum, "
                        . "Date, ImportUser, ValidContacts, NewContacts, UpdatedContacts, "
                        . "InvalidContacts, DuplicatesContacts) "
                        . "VALUES ('$vcc','$LastUpdate','1','$dateNow','$_SESSION[usu]','$ingresado','$ingresado',"
                        . "'0','$error','$duplicado')");

                $vContactImport = ejecutarConsulta("INSERT INTO contactimport(VCC, ID, DBProvider,"
                        . "Updates, Status, ServiceId) "
                        . "VALUES ('$vcc','$LastUpdate','$LastUpdate','1',"
                        . "case when $error = 0  then 'COMPLETE' else 'INCOMPLETE' end,'NULL')");
            }
        }
        break;

    case 'bancoPichinchaCargosRecurrentes':
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

            $sql = ejecutarConsulta("SELECT DISTINCT CampaignId 'Id' FROM campaignresultmanagement where CampaignId = '$campaignId'");
            $vCamp = mysqli_fetch_array($sql, MYSQLI_BOTH);
            $sql1 = ejecutarConsulta("SELECT DISTINCT lastupdate FROM contactimportcontact "
                    . "WHERE EXISTS (SELECT DISTINCT lastupdate FROM contactimportcontact c "
                    . "WHERE c.lastupdate = '$nameExcel')");
            $vImport = mysqli_fetch_array($sql1, MYSQLI_BOTH);
            if ($vCamp["Id"] == "") {
                echo("No exite la campaña seleccionada");
                //} else if ($vImport != "") {
                // echo("Nombre de importación duplicado");
            } else {
                while (($datos = fgetcsv($users, 100000, ";")) !== FALSE) {//Leo linea por linea del archivo hasta un maximo de 1000 caracteres por linea leida usando coma(,) o (;) como delimitador
                    $row++;
                    if ($row > 1) {
                        $linea[] = array(//Arreglo Bidimensional para guardar los datos de cada linea leida del archivo
                            'CODIGO_CAMPANIA' => $datos[0],
                            'NOMBRE_CAMPANIA' => $datos[1],
                            'IDENTIFICACION' => $datos[2],
                            'NOMBRE_CLIENTE' => $datos[3],
                            'TELEFONIA_FIJA' => $datos[4],
                            'INTERNET_FIJO ' => $datos[5],
                            'TELEVISION ' => $datos[6],
                            'MOVIL ' => $datos[7],
                            'PLAN_RECOMPENSAS' => $datos[8],
                            'CUATRO_ULTIMOS_DIGITOS_TC' => $datos[9],
                            'DES_ESTABLECIMIENTO' => $datos[10],
                            'FAMILIA' => $datos[11],
                            'PRODUCTO' => $datos[12],
                            'PRIMER_APELLIDO' => $datos[13],
                            'SEGUNDO_APELLIDO' => $datos[14],
                            'PRIMER_NOMBRE' => $datos[15],
                            'SEGUNDO_NOMBRE' => $datos[16],
                            'ESTADO_CIVIL' => $datos[17],
                            'TIENE_TARJETA' => $datos[18],
                            'ZONA' => $datos[19],
                            'REGION_ANCLAJE' => $datos[20],
                            'CORREO1' => $datos[21],
                            'CORREO2' => $datos[22],
                            'CORREO3' => $datos[23],
                            'TELEFONO_01' => $datos[24],
                            'TELEFONO_02' => $datos[25],
                            'TELEFONO_03' => $datos[26],
                            'TELEFONO_04' => $datos[27],
                            'TELEFONO_05' => $datos[28],
                            'TELEFONO_06' => $datos[29],
                            'TELEFONO_07' => $datos[30],
                            'TELEFONO_08' => $datos[31],
                            'TELEFONO_09' => $datos[32],
                            'TELEFONO_10' => $datos[33],
                        );
                    }
                }
                fclose($users); //Cierra el archivo
                $ingresado = 0; //Variable que almacenara los insert exitosos
                $error = 0; //Variable que almacenara los errores en almacenamiento
                $duplicado = 0; //Variable que almacenara los registros duplicados
                foreach ($linea as $indice => $value) { //Iteracion el array para extraer cada uno de los valores almacenados en cada items
                    $count = ejecutarConsultaSimple("select UUID() 'id'");
                    $idG = $count['id'];
                    //Almacenamos info en contactimportcontact. Datos traidos del array para almacenar en la base
                    $ID = $idG;
                    $Name = $value["NOMBRE_CLIENTE"];
                    $Identification = $value["IDENTIFICACION"];
                    $Campaign = $campaignId;
                    $LastManagementResult = "";
                    $LastUpdate = $nameExcel;
                    $CODIGO_CAMPANIA = $value['CODIGO_CAMPANIA'];
                    $NOMBRE_CAMPANIA = $value['NOMBRE_CAMPANIA'];
                    $IDENTIFICACION = $value['IDENTIFICACION'];
                    $NOMBRE_CLIENTE = $value['NOMBRE_CLIENTE'];
                    $TELEFONIA_FIJA = $value['TELEFONIA_FIJA'];
                    $INTERNET_FIJO = $value['INTERNET_FIJO '];
                    $TELEVISION = $value['TELEVISION '];
                    $MOVIL = $value['MOVIL '];
                    $PLAN_RECOMPENSAS = $value['PLAN_RECOMPENSAS'];
                    $CUATRO_ULTIMOS_DIGITOS_TC = $value['CUATRO_ULTIMOS_DIGITOS_TC'];
                    $DES_ESTABLECIMIENTO = $value['DES_ESTABLECIMIENTO'];
                    $FAMILIA = $value['FAMILIA'];
                    $PRODUCTO = $value['PRODUCTO'];
                    $PRIMER_APELLIDO = $value['PRIMER_APELLIDO'];
                    $SEGUNDO_APELLIDO = $value['SEGUNDO_APELLIDO'];
                    $PRIMER_NOMBRE = $value['PRIMER_NOMBRE'];
                    $SEGUNDO_NOMBRE = $value['SEGUNDO_NOMBRE'];
                    $ESTADO_CIVIL = $value['ESTADO_CIVIL'];
                    $TIENE_TARJETA = $value['TIENE_TARJETA'];
                    $ZONA = $value['ZONA'];
                    $REGION_ANCLAJE = $value['REGION_ANCLAJE'];
                    $CORREO1 = $value['CORREO1'];
                    $CORREO2 = $value['CORREO2'];
                    $CORREO3 = $value['CORREO3'];
                    $TELEFONO_01 = $value['TELEFONO_01'];
                    $TELEFONO_02 = $value['TELEFONO_02'];
                    $TELEFONO_03 = $value['TELEFONO_03'];
                    $TELEFONO_04 = $value['TELEFONO_04'];
                    $TELEFONO_05 = $value['TELEFONO_05'];
                    $TELEFONO_06 = $value['TELEFONO_06'];
                    $TELEFONO_07 = $value['TELEFONO_07'];
                    $TELEFONO_08 = $value['TELEFONO_08'];
                    $TELEFONO_09 = $value['TELEFONO_09'];
                    $TELEFONO_10 = $value['TELEFONO_10'];

                    $sql = ejecutarConsulta("select * from contactimportcontact where Id='$ID'"); //Consulta a la tabla
                    $num = mysqli_num_rows($sql); //Cuenta el numero de registros devueltos por la consulta
                    if ($num == 0) {//Si es == 0 inserto
                        if ($insert = ejecutarConsulta("insert into contactimportcontact (VCC, ID, Name, Identification, Campaign, LastManagementResult, LastUpdate) "
                                . "values('$vcc','$ID','$Name','$Identification','$Campaign','$LastManagementResult','$LastUpdate')")) {
                            $msj = '<font color=green>Dato <b>' . $Name . '</b> Guardado</font><br/>';
                            $ingresado += 1;
                        }//fin del if que comprueba que se guarden los $datos
                        else {//sino ingresa el producto
                            echo $msj = '<font color=red>Dato <b>' . $Name . ' </b> no almacenado' . mysqli_error() . '</font><br/>';
                            $error += 1;
                        }
                        ejecutarConsulta4("INSERT INTO clientes(VCC, CampaignId, ContactId, ContactName, InteractionId, ImportId, LastAgent, ResultLevel1, ResultLevel2, ResultLevel3, ManagementResultCode, ManagementResultDescription, ID, CODIGO_CAMPANIA, NOMBRE_CAMPANIA, IDENTIFICACION, NOMBRE_CLIENTE, TELEFONIA_FIJA, INTERNET_FIJO, TELEVISION, MOVIL, PLAN_RECOMPENSAS, CUATRO_ULTIMOS_DIGITOS_TC, DES_ESTABLECIMIENTO, FAMILIA, PRODUCTO, PRIMER_APELLIDO, SEGUNDO_APELLIDO, PRIMER_NOMBRE, SEGUNDO_NOMBRE, CORREO1, CORREO2, CORREO3, ESTADO_CIVIL, TIENE_TARJETA, ZONA, REGION_ANCLAJE) VALUES "
                                . "('$vcc','$Campaign','$ID', '$NOMBRE_CLIENTE', '', '$LastUpdate','Pendiente','Pendiente','Pendiente','Pendiente','0','Pendiente','$ID','$CODIGO_CAMPANIA','$NOMBRE_CAMPANIA','$IDENTIFICACION','$NOMBRE_CLIENTE','$TELEFONIA_FIJA','$INTERNET_FIJO','$TELEVISION','$MOVIL','$PLAN_RECOMPENSAS','$CUATRO_ULTIMOS_DIGITOS_TC','$DES_ESTABLECIMIENTO','$FAMILIA','$PRODUCTO','$PRIMER_APELLIDO','$SEGUNDO_APELLIDO','$PRIMER_NOMBRE','$SEGUNDO_NOMBRE','$CORREO1','$CORREO2','$CORREO3','$ESTADO_CIVIL','$TIENE_TARJETA','$ZONA','$REGION_ANCLAJE')");

                        if ($TELEFONO_01 != '') {
                            $vTelefono1 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_01','','SG','$dateNow','$dateNow','TELEFONO_01','$Identification')");
                        }
                        if ($TELEFONO_02 != '') {
                            $vTelefono2 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_02','','SG','$dateNow','$dateNow','TELEFONO_02','$Identification')");
                        }
                        if ($TELEFONO_03 != '') {
                            $vTelefono3 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_03','','SG','$dateNow','$dateNow','TELEFONO_03','$Identification')");
                        }
                        if ($TELEFONO_04 != '') {
                            $vTelefono4 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_04','','SG','$dateNow','$dateNow','TELEFONO_04','$Identification')");
                        }
                        if ($TELEFONO_05 != '') {
                            $vTelefono5 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_05','','SG','$dateNow','$dateNow','TELEFONO_05','$Identification')");
                        }
                        if ($TELEFONO_06 != '') {
                            $vTelefono6 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_06','','SG','$dateNow','$dateNow','TELEFONO_06','$Identification')");
                        }
                        if ($TELEFONO_07 != '') {
                            $vTELEFONO_07 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_07','','SG','$dateNow','$dateNow','TELEFONO_07','$Identification')");
                        }
                        if ($TELEFONO_08 != '') {
                            $vTELEFONO_08 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_08','','SG','$dateNow','$dateNow','TELEFONO_08','$Identification')");
                        }
                        if ($TELEFONO_09 != '') {
                            $vTELEFONO_09 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_09','','SG','$dateNow','$dateNow','TELEFONO_09','$Identification')");
                        }
                        if ($TELEFONO_10 != '') {
                            $vTELEFONO_10 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_10','','SG','$dateNow','$dateNow','TELEFONO_10','$Identification')");
                        }
                    }//fin de if que comprueba que no haya en registro duplicado
                    else {
                        $duplicado += 1;
                        echo $duplicate = '<font color=#F3D305>El dato <b>' . $Name . '</b> está duplicado<br></font>';
                    }
                }
                echo "<b>La importación $nameExcel  tiene el siguiente detalle:</b><br/>";
                echo "<font color=green>" . $ingresado . " Datos almacenados con éxito<br/>";
                echo "<font color=#F3D305>" . $duplicado . " Datos duplicados<br/>";
                echo "<font color=red>" . $error . " Errores de almacenamiento<br/>";
                $vContactDetails = ejecutarConsulta("INSERT INTO contactimportdetail(VCC, ImportId, UpdateNum, "
                        . "Date, ImportUser, ValidContacts, NewContacts, UpdatedContacts, "
                        . "InvalidContacts, DuplicatesContacts) "
                        . "VALUES ('$vcc','$LastUpdate','1','$dateNow','$_SESSION[usu]','$ingresado','$ingresado',"
                        . "'0','$error','$duplicado')");

                $vContactImport = ejecutarConsulta("INSERT INTO contactimport(VCC, ID, DBProvider,"
                        . "Updates, Status, ServiceId) "
                        . "VALUES ('$vcc','$LastUpdate','$LastUpdate','1',"
                        . "case when $error = 0  then 'COMPLETE' else 'INCOMPLETE' end,'NULL')");
            }
        }
        break;

    case 'bancoPichinchaCancelaciones':
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

            $sql = ejecutarConsulta("SELECT DISTINCT CampaignId 'Id' FROM campaignresultmanagement where CampaignId = '$campaignId'");
            $vCamp = mysqli_fetch_array($sql, MYSQLI_BOTH);
            $sql1 = ejecutarConsulta("SELECT DISTINCT lastupdate FROM contactimportcontact "
                    . "WHERE EXISTS (SELECT DISTINCT lastupdate FROM contactimportcontact c "
                    . "WHERE c.lastupdate = '$nameExcel')");
            $vImport = mysqli_fetch_array($sql1, MYSQLI_BOTH);
            if ($vCamp["Id"] == "") {
                echo("No exite la campaña seleccionada");
                //} else if ($vImport != "") {
                // echo("Nombre de importación duplicado");
            } else {
                while (($datos = fgetcsv($users, 100000, ";")) !== FALSE) {//Leo linea por linea del archivo hasta un maximo de 1000 caracteres por linea leida usando coma(,) o (;) como delimitador
                    $row++;
                    if ($row > 1) {
                        $linea[] = array(//Arreglo Bidimensional para guardar los datos de cada linea leida del archivo
                            'CODIGO_CAMPANIA' => $datos[0],
                            'NOMBRE_CAMPANIA' => $datos[1],
                            'IDENTIFICACION' => $datos[2],
                            'NOMBRE_CLIENTE' => $datos[3],
                            'TARJETA_SOCIO' => $datos[4],
                            'ESTADO' => $datos[5],
                            'MARCA' => $datos[6],
                            'TIPO' => $datos[7],
                            'FAMILIA' => $datos[8],
                            'PRODUCTO' => $datos[9],
                            'SUBSEGMENTO' => $datos[10],
                            'TELEFONO_01' => $datos[11],
                            'TELEFONO_02' => $datos[12],
                            'TELEFONO_03' => $datos[13],
                            'TELEFONO_04' => $datos[14],
                            'TELEFONO_05' => $datos[15],
                            'TELEFONO_06' => $datos[16],
                            'TELEFONO_07' => $datos[17],
                            'TELEFONO_08' => $datos[18],
                            'TELEFONO_09' => $datos[19],
                            'TELEFONO_10' => $datos[20],
                        );
                    }
                }
                fclose($users); //Cierra el archivo
                $ingresado = 0; //Variable que almacenara los insert exitosos
                $error = 0; //Variable que almacenara los errores en almacenamiento
                $duplicado = 0; //Variable que almacenara los registros duplicados
                foreach ($linea as $indice => $value) { //Iteracion el array para extraer cada uno de los valores almacenados en cada items
                    $count = ejecutarConsultaSimple("select UUID() 'id'");
                    $idG = $count['id'];
                    //Almacenamos info en contactimportcontact. Datos traidos del array para almacenar en la base
                    $ID = $idG;
                    $Name = $value["NOMBRE_CLIENTE"];
                    $Identification = $value["IDENTIFICACION"];
                    $Campaign = $campaignId;
                    $LastManagementResult = "";
                    $LastUpdate = $nameExcel;
                    $CODIGO_CAMPANIA = $value['CODIGO_CAMPANIA'];
                    $NOMBRE_CAMPANIA = $value['NOMBRE_CAMPANIA'];
                    $IDENTIFICACION = $value['IDENTIFICACION'];
                    $NOMBRE_CLIENTE = $value['NOMBRE_CLIENTE'];
                    $CODIGO_CAMPANIA = $value['CODIGO_CAMPANIA'];
                    $NOMBRE_CAMPANIA = $value['NOMBRE_CAMPANIA'];
                    $IDENTIFICACION = $value['IDENTIFICACION'];
                    $NOMBRE_CLIENTE = $value['NOMBRE_CLIENTE'];
                    $TARJETA_SOCIO = $value['TARJETA_SOCIO'];
                    $ESTADO = $value['ESTADO'];
                    $MARCA = $value['MARCA'];
                    $TIPO = $value['TIPO'];
                    $FAMILIA = $value['FAMILIA'];
                    $PRODUCTO = $value['PRODUCTO'];
                    $SUBSEGMENTO = $value['SUBSEGMENTO'];
                    $TELEFONO_01 = $value['TELEFONO_01'];
                    $TELEFONO_02 = $value['TELEFONO_02'];
                    $TELEFONO_03 = $value['TELEFONO_03'];
                    $TELEFONO_04 = $value['TELEFONO_04'];
                    $TELEFONO_05 = $value['TELEFONO_05'];
                    $TELEFONO_06 = $value['TELEFONO_06'];
                    $TELEFONO_07 = $value['TELEFONO_07'];
                    $TELEFONO_08 = $value['TELEFONO_08'];
                    $TELEFONO_09 = $value['TELEFONO_09'];
                    $TELEFONO_10 = $value['TELEFONO_10'];

                    $sql = ejecutarConsulta("select * from contactimportcontact where Id='$ID'"); //Consulta a la tabla
                    $num = mysqli_num_rows($sql); //Cuenta el numero de registros devueltos por la consulta
                    if ($num == 0) {//Si es == 0 inserto
                        if ($insert = ejecutarConsulta("insert into contactimportcontact (VCC, ID, Name, Identification, Campaign, LastManagementResult, LastUpdate) "
                                . "values('$vcc','$ID','$Name','$Identification','$Campaign','$LastManagementResult','$LastUpdate')")) {
                            $msj = '<font color=green>Dato <b>' . $Name . '</b> Guardado</font><br/>';
                            $ingresado += 1;
                            /*                             * *********************************INSERTAMOS LA INFROMACION EN LA TABLA CLIENTES*********************************** */
                            ejecutarConsulta7("INSERT INTO clientes(VCC, CampaignId, ContactId, ContactName, InteractionId, ImportId, LastAgent, ResultLevel1, ResultLevel2, ResultLevel3, ManagementResultCode, ManagementResultDescription, ID, CODIGO_CAMPANIA, NOMBRE_CAMPANIA, IDENTIFICACION, NOMBRE_CLIENTE, TARJETA_SOCIO, ESTADO, MARCA, TIPO, FAMILIA, PRODUCTO, SUBSEGMENTO) VALUES "
                                    . "('$vcc','$Campaign','$ID', '$NOMBRE_CLIENTE', '', '$LastUpdate','Pendiente','Pendiente','Pendiente','Pendiente','0','Pendiente', '$ID','$CODIGO_CAMPANIA','$NOMBRE_CAMPANIA','$IDENTIFICACION','$NOMBRE_CLIENTE','$TARJETA_SOCIO','$ESTADO','$MARCA','$TIPO','$FAMILIA','$PRODUCTO','$SUBSEGMENTO')");
                            if ($TELEFONO_01 != '') {
                                $vTelefono1 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_01','','SG','$dateNow','$dateNow','TELEFONO_01','$Identification')");
                            }
                            if ($TELEFONO_02 != '') {
                                $vTelefono2 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_02','','SG','$dateNow','$dateNow','TELEFONO_02','$Identification')");
                            }
                            if ($TELEFONO_03 != '') {
                                $vTelefono3 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_03','','SG','$dateNow','$dateNow','TELEFONO_03','$Identification')");
                            }
                            if ($TELEFONO_04 != '') {
                                $vTelefono4 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_04','','SG','$dateNow','$dateNow','TELEFONO_04','$Identification')");
                            }
                            if ($TELEFONO_05 != '') {
                                $vTelefono5 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_05','','SG','$dateNow','$dateNow','TELEFONO_05','$Identification')");
                            }
                            if ($TELEFONO_06 != '') {
                                $vTelefono6 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_06','','SG','$dateNow','$dateNow','TELEFONO_06','$Identification')");
                            }
                            if ($TELEFONO_07 != '') {
                                $vTELEFONO_07 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_07','','SG','$dateNow','$dateNow','TELEFONO_07','$Identification')");
                            }
                            if ($TELEFONO_08 != '') {
                                $vTELEFONO_08 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_08','','SG','$dateNow','$dateNow','TELEFONO_08','$Identification')");
                            }
                            if ($TELEFONO_09 != '') {
                                $vTELEFONO_09 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_09','','SG','$dateNow','$dateNow','TELEFONO_09','$Identification')");
                            }
                            if ($TELEFONO_10 != '') {
                                $vTELEFONO_10 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_10','','SG','$dateNow','$dateNow','TELEFONO_10','$Identification')");
                            }
                        }//fin del if que comprueba que se guarden los $datos
                        else {//sino ingresa el producto
                            echo $msj = '<font color=red>Dato <b>' . $Name . ' </b> no almacenado' . mysqli_error() . '</font><br/>';
                            $error += 1;
                        }
                    }//fin de if que comprueba que no haya en registro duplicado
                    else {
                        $duplicado += 1;
                        echo $duplicate = '<font color=#F3D305>El dato <b>' . $Name . '</b> está duplicado<br></font>';
                    }
                }
                echo "<b>La importación $nameExcel  tiene el siguiente detalle:</b><br/>";
                echo "<font color=green>" . $ingresado . " Datos almacenados con éxito<br/>";
                echo "<font color=#F3D305>" . $duplicado . " Datos duplicados<br/>";
                echo "<font color=red>" . $error . " Errores de almacenamiento<br/>";
                $vContactDetails = ejecutarConsulta("INSERT INTO contactimportdetail(VCC, ImportId, UpdateNum, "
                        . "Date, ImportUser, ValidContacts, NewContacts, UpdatedContacts, "
                        . "InvalidContacts, DuplicatesContacts) "
                        . "VALUES ('$vcc','$LastUpdate','1','$dateNow','$_SESSION[usu]','$ingresado','$ingresado',"
                        . "'0','$error','$duplicado')");

                $vContactImport = ejecutarConsulta("INSERT INTO contactimport(VCC, ID, DBProvider,"
                        . "Updates, Status, ServiceId) "
                        . "VALUES ('$vcc','$LastUpdate','$LastUpdate','1',"
                        . "case when $error = 0  then 'COMPLETE' else 'INCOMPLETE' end,'NULL')");
            }
        }
        break;

    case 'bancoPichinchaIncrementos':
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

            $sql = ejecutarConsulta("SELECT DISTINCT CampaignId 'Id' FROM campaignresultmanagement where CampaignId = '$campaignId'");
            $vCamp = mysqli_fetch_array($sql, MYSQLI_BOTH);
            $sql1 = ejecutarConsulta("SELECT DISTINCT lastupdate FROM contactimportcontact "
                    . "WHERE EXISTS (SELECT DISTINCT lastupdate FROM contactimportcontact c "
                    . "WHERE c.lastupdate = '$nameExcel')");
            $vImport = mysqli_fetch_array($sql1, MYSQLI_BOTH);
            if ($vCamp["Id"] == "") {
                echo("No exite la campaña seleccionada");
                //} else if ($vImport != "") {
                // echo("Nombre de importación duplicado");
            } else {
                while (($datos = fgetcsv($users, 100000, ";")) !== FALSE) {//Leo linea por linea del archivo hasta un maximo de 1000 caracteres por linea leida usando coma(,) o (;) como delimitador
                    $row++;
                    if ($row > 1) {
                        $linea[] = array(//Arreglo Bidimensional para guardar los datos de cada linea leida del archivo
                            'CODIGO_CAMPANIA' => $datos[0],
                            'NOMBRE_CAMPANIA' => $datos[1],
                            'IDENTIFICACION' => $datos[2],
                            'NOMBRE_CLIENTE' => $datos[3],
                            'ZONA' => $datos[4],
                            'REGION' => $datos[5],
                            'SUBSEGMENTO' => $datos[6],
                            'EDAD' => $datos[7],
                            'ESTADO_CIVIL' => $datos[8],
                            'SEXO' => $datos[9],
                            'NOMBRE_PRODUCTO' => $datos[10],
                            'NUMERO_CUENTA' => $datos[11],
                            'ESTADO_DE_CTA_AHORRO_FUTURO' => $datos[12],
                            'DESCRIPCION' => $datos[13],
                            'FUTURE_VALUE_SAVINGS_ARRANGEMENT' => $datos[14],
                            'MONTO ' => $datos[15],
                            'VALIDADOR' => $datos[16],
                            'SALDO' => $datos[17],
                            'MONTO_SUGERIDO_AH_FUT' => $datos[18],
                            'ANIO_APERTURA' => $datos[19],
                            'PROVINCIA_DOMICILIO' => $datos[20],
                            'CIUDAD_DOMICILIO' => $datos[21],
                            'DIRECCION_DOMICILIO' => $datos[22],
                            'PROVINCIA_TRABAJO' => $datos[23],
                            'CIUDAD_TRABAJO' => $datos[24],
                            'DIRECCION_TRABAJO' => $datos[25],
                            'MC' => $datos[26],
                            'VI' => $datos[27],
                            'CUENTA_DEBITO' => $datos[28],
                            'ESTADO_CUENTA_TRANSACCIONAL' => $datos[29],
                            'DESCRIPCION1' => $datos[30],
                            'SALDO_PROMEDIO' => $datos[31],
                            'TIENE_DEUDA_PROTEGIDA' => $datos[32],
                            'EXEQUIAL' => $datos[33],
                            'VIDA_SEGURA' => $datos[34],
                            'PROTECCION_FRAUDE' => $datos[35],
                            'FECHA_APERTURA_AH_FUTURO' => $datos[36],
                            'DIA_DEBITO_AH_FUTURO' => $datos[37],
                            'TELEFONO_01' => $datos[38],
                            'TELEFONO_02' => $datos[39],
                            'TELEFONO_03' => $datos[40],
                            'TELEFONO_04' => $datos[41],
                            'TELEFONO_05' => $datos[42],
                            'TELEFONO_06' => $datos[43],
                            'TELEFONO_07' => $datos[44],
                            'TELEFONO_08' => $datos[45],
                            'TELEFONO_09' => $datos[46],
                            'TELEFONO_10' => $datos[47],
                        );
                    }
                }
                fclose($users); //Cierra el archivo
                $ingresado = 0; //Variable que almacenara los insert exitosos
                $error = 0; //Variable que almacenara los errores en almacenamiento
                $duplicado = 0; //Variable que almacenara los registros duplicados
                foreach ($linea as $indice => $value) { //Iteracion el array para extraer cada uno de los valores almacenados en cada items
                    $count = ejecutarConsultaSimple("select UUID() 'id'");
                    $idG = $count['id'];
                    //Almacenamos info en contactimportcontact. Datos traidos del array para almacenar en la base
                    $ID = $idG;
                    $Name = $value["NOMBRE_CLIENTE"];
                    $Identification = $value["IDENTIFICACION"];
                    $Campaign = $campaignId;
                    $LastManagementResult = "";
                    $LastUpdate = $nameExcel;
                    $CODIGO_CAMPANIA = $value['CODIGO_CAMPANIA'];
                    $NOMBRE_CAMPANIA = $value['NOMBRE_CAMPANIA'];
                    $IDENTIFICACION = $value['IDENTIFICACION'];
                    $NOMBRE_CLIENTE = $value['NOMBRE_CLIENTE'];
                    $ZONA = $value['ZONA'];
                    $REGION = $value['REGION'];
                    $SUBSEGMENTO = $value['SUBSEGMENTO'];
                    $EDAD = $value['EDAD'];
                    $ESTADO_CIVIL = $value['ESTADO_CIVIL'];
                    $SEXO = $value['SEXO'];
                    $NOMBRE_PRODUCTO = $value['NOMBRE_PRODUCTO'];
                    $NUMERO_CUENTA = $value['NUMERO_CUENTA'];
                    $ESTADO_DE_CTA_AHORRO_FUTURO = $value['ESTADO_DE_CTA_AHORRO_FUTURO'];
                    $DESCRIPCION = $value['DESCRIPCION'];
                    $FUTURE_VALUE_SAVINGS_ARRANGEMENT = $value['FUTURE_VALUE_SAVINGS_ARRANGEMENT'];
                    $MONTO = $value['MONTO '];
                    $VALIDADOR = $value['VALIDADOR'];
                    $SALDO = $value['SALDO'];
                    $MONTO_SUGERIDO_AH_FUT = $value['MONTO_SUGERIDO_AH_FUT'];
                    $ANIO_APERTURA = $value['ANIO_APERTURA'];
                    $PROVINCIA_DOMICILIO = $value['PROVINCIA_DOMICILIO'];
                    $CIUDAD_DOMICILIO = $value['CIUDAD_DOMICILIO'];
                    $DIRECCION_DOMICILIO = $value['DIRECCION_DOMICILIO'];
                    $PROVINCIA_TRABAJO = $value['PROVINCIA_TRABAJO'];
                    $CIUDAD_TRABAJO = $value['CIUDAD_TRABAJO'];
                    $DIRECCION_TRABAJO = $value['DIRECCION_TRABAJO'];
                    $MC = $value['MC'];
                    $VI = $value['VI'];
                    $CUENTA_DEBITO = $value['CUENTA_DEBITO'];
                    $ESTADO_CUENTA_TRANSACCIONAL = $value['ESTADO_CUENTA_TRANSACCIONAL'];
                    $DESCRIPCION1 = $value['DESCRIPCION1'];
                    $SALDO_PROMEDIO = $value['SALDO_PROMEDIO'];
                    $TIENE_DEUDA_PROTEGIDA = $value['TIENE_DEUDA_PROTEGIDA'];
                    $EXEQUIAL = $value['EXEQUIAL'];
                    $VIDA_SEGURA = $value['VIDA_SEGURA'];
                    $PROTECCION_FRAUDE = $value['PROTECCION_FRAUDE'];
                    $FECHA_APERTURA_AH_FUTURO = $value['FECHA_APERTURA_AH_FUTURO'];
                    $DIA_DEBITO_AH_FUTURO = $value['DIA_DEBITO_AH_FUTURO'];
                    $TELEFONO_01 = $value['TELEFONO_01'];
                    $TELEFONO_02 = $value['TELEFONO_02'];
                    $TELEFONO_03 = $value['TELEFONO_03'];
                    $TELEFONO_04 = $value['TELEFONO_04'];
                    $TELEFONO_05 = $value['TELEFONO_05'];
                    $TELEFONO_06 = $value['TELEFONO_06'];
                    $TELEFONO_07 = $value['TELEFONO_07'];
                    $TELEFONO_08 = $value['TELEFONO_08'];
                    $TELEFONO_09 = $value['TELEFONO_09'];
                    $TELEFONO_10 = $value['TELEFONO_10'];

                    $sql = ejecutarConsulta("select * from contactimportcontact where Id='$ID'"); //Consulta a la tabla
                    $num = mysqli_num_rows($sql); //Cuenta el numero de registros devueltos por la consulta
                    if ($num == 0) {//Si es == 0 inserto
                        if ($insert = ejecutarConsulta("insert into contactimportcontact (VCC, ID, Name, Identification, Campaign, LastManagementResult, LastUpdate) "
                                . "values('$vcc','$ID','$Name','$Identification','$Campaign','$LastManagementResult','$LastUpdate')")) {
                            $msj = '<font color=green>Dato <b>' . $Name . '</b> Guardado</font><br/>';
                            $ingresado += 1;
                            /*                             * *********************************INSERTAMOS LA INFROMACION EN LA TABLA CLIENTES*********************************** */
                            ejecutarConsulta5("INSERT INTO clientes(VCC, CampaignId, ContactId, ContactName, InteractionId, ImportId, LastAgent, ResultLevel1, ResultLevel2, ResultLevel3, ManagementResultCode, ManagementResultDescription, ID, CODIGO_CAMPANIA, NOMBRE_CAMPANIA, IDENTIFICACION, NOMBRE_CLIENTE, ZONA, REGION, SUBSEGMENTO, EDAD, ESTADO_CIVIL, SEXO, NOMBRE_PRODUCTO, NUMERO_CUENTA, ESTADO_DE_CTA_AHORRO_FUTURO, DESCRIPCION, FUTURE_VALUE_SAVINGS_ARRANGEMENT, MONTO, VALIDADOR, SALDO, MONTO_SUGERIDO_AH_FUT, ANIO_APERTURA, PROVINCIA_DOMICILIO, CIUDAD_DOMICILIO, DIRECCION_DOMICILIO, PROVINCIA_TRABAJO, CIUDAD_TRABAJO, DIRECCION_TRABAJO, TIENE_MC, TIENE_VI, CUENTA_DEBITO, ESTADO_CUENTA_TRANSACCIONAL, DESCRIPCION1, SALDO_PROMEDIO, TIENE_DEUDA_PROTEGIDA, EXEQUIAL, VIDA_SEGURA, PROTECCION_FRAUDE, FECHA_APERTURA_AH_FUTURO, DIA_DEBITO_AH_FUTURO) VALUES "
                                    . "('$vcc','$Campaign','$ID', '$NOMBRE_CLIENTE', '', '$LastUpdate','Pendiente','Pendiente','Pendiente','Pendiente','0','Pendiente', '$ID','$CODIGO_CAMPANIA','$NOMBRE_CAMPANIA','$IDENTIFICACION','$NOMBRE_CLIENTE','$ZONA','$REGION','$SUBSEGMENTO','$EDAD','$ESTADO_CIVIL','$SEXO','$NOMBRE_PRODUCTO','$NUMERO_CUENTA','$ESTADO_DE_CTA_AHORRO_FUTURO','$DESCRIPCION','$FUTURE_VALUE_SAVINGS_ARRANGEMENT','$MONTO','$VALIDADOR','$SALDO','$MONTO_SUGERIDO_AH_FUT','$ANIO_APERTURA','$PROVINCIA_DOMICILIO','$CIUDAD_DOMICILIO','$DIRECCION_DOMICILIO','$PROVINCIA_TRABAJO','$CIUDAD_TRABAJO','$DIRECCION_TRABAJO','$MC','$VI','$CUENTA_DEBITO','$ESTADO_CUENTA_TRANSACCIONAL','$DESCRIPCION1','$SALDO_PROMEDIO','$TIENE_DEUDA_PROTEGIDA','$EXEQUIAL','$VIDA_SEGURA','$PROTECCION_FRAUDE','$FECHA_APERTURA_AH_FUTURO','$DIA_DEBITO_AH_FUTURO')");

                            if ($TELEFONO_01 != '') {
                                $vTelefono1 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_01','','SG','$dateNow','$dateNow','TELEFONO_01','$Identification')");
                            }
                            if ($TELEFONO_02 != '') {
                                $vTelefono2 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_02','','SG','$dateNow','$dateNow','TELEFONO_02','$Identification')");
                            }
                            if ($TELEFONO_03 != '') {
                                $vTelefono3 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_03','','SG','$dateNow','$dateNow','TELEFONO_03','$Identification')");
                            }
                            if ($TELEFONO_04 != '') {
                                $vTelefono4 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_04','','SG','$dateNow','$dateNow','TELEFONO_04','$Identification')");
                            }
                            if ($TELEFONO_05 != '') {
                                $vTelefono5 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_05','','SG','$dateNow','$dateNow','TELEFONO_05','$Identification')");
                            }
                            if ($TELEFONO_06 != '') {
                                $vTelefono6 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_06','','SG','$dateNow','$dateNow','TELEFONO_06','$Identification')");
                            }
                            if ($TELEFONO_07 != '') {
                                $vTELEFONO_07 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_07','','SG','$dateNow','$dateNow','TELEFONO_07','$Identification')");
                            }
                            if ($TELEFONO_08 != '') {
                                $vTELEFONO_08 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_08','','SG','$dateNow','$dateNow','TELEFONO_08','$Identification')");
                            }
                            if ($TELEFONO_09 != '') {
                                $vTELEFONO_09 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_09','','SG','$dateNow','$dateNow','TELEFONO_09','$Identification')");
                            }
                            if ($TELEFONO_10 != '') {
                                $vTELEFONO_10 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_10','','SG','$dateNow','$dateNow','TELEFONO_10','$Identification')");
                            }
                        }//fin del if que comprueba que se guarden los $datos
                        else {//sino ingresa el producto
                            echo $msj = '<font color=red>Dato <b>' . $Name . ' </b> no almacenado' . mysqli_error() . '</font><br/>';
                            $error += 1;
                        }
                    }//fin de if que comprueba que no haya en registro duplicado
                    else {
                        $duplicado += 1;
                        echo $duplicate = '<font color=#F3D305>El dato <b>' . $Name . '</b> está duplicado<br></font>';
                    }
                }
                echo "<b>La importación $nameExcel  tiene el siguiente detalle:</b><br/>";
                echo "<font color=green>" . $ingresado . " Datos almacenados con éxito<br/>";
                echo "<font color=#F3D305>" . $duplicado . " Datos duplicados<br/>";
                echo "<font color=red>" . $error . " Errores de almacenamiento<br/>";
                $vContactDetails = ejecutarConsulta("INSERT INTO contactimportdetail(VCC, ImportId, UpdateNum, "
                        . "Date, ImportUser, ValidContacts, NewContacts, UpdatedContacts, "
                        . "InvalidContacts, DuplicatesContacts) "
                        . "VALUES ('$vcc','$LastUpdate','1','$dateNow','$_SESSION[usu]','$ingresado','$ingresado',"
                        . "'0','$error','$duplicado')");

                $vContactImport = ejecutarConsulta("INSERT INTO contactimport(VCC, ID, DBProvider,"
                        . "Updates, Status, ServiceId) "
                        . "VALUES ('$vcc','$LastUpdate','$LastUpdate','1',"
                        . "case when $error = 0  then 'COMPLETE' else 'INCOMPLETE' end,'NULL')");
            }
        }
        break;

    case 'bancoPichinchaPasivos':
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

            $sql = ejecutarConsulta("SELECT DISTINCT CampaignId 'Id' FROM campaignresultmanagement where CampaignId = '$campaignId'");
            $vCamp = mysqli_fetch_array($sql, MYSQLI_BOTH);
            $sql1 = ejecutarConsulta("SELECT DISTINCT lastupdate FROM contactimportcontact "
                    . "WHERE EXISTS (SELECT DISTINCT lastupdate FROM contactimportcontact c "
                    . "WHERE c.lastupdate = '$nameExcel')");
            $vImport = mysqli_fetch_array($sql1, MYSQLI_BOTH);
            if ($vCamp["Id"] == "") {
                echo("No exite la campaña seleccionada");
                //} else if ($vImport != "") {
                // echo("Nombre de importación duplicado");
            } else {
                while (($datos = fgetcsv($users, 100000, ";")) !== FALSE) {//Leo linea por linea del archivo hasta un maximo de 1000 caracteres por linea leida usando coma(,) o (;) como delimitador
                    $row++;
                    if ($row > 1) {
                        $linea[] = array(//Arreglo Bidimensional para guardar los datos de cada linea leida del archivo
                            'CODIGO_CAMPANIA' => $datos[0],
                            'NOMBRE_CAMPANIA' => $datos[1],
                            'IDENTIFICACION' => $datos[2],
                            'NOMBRE_CLIENTE' => $datos[3],
                            'ZONA' => $datos[4],
                            'REGION' => $datos[5],
                            'SUBSEGMENTO' => $datos[6],
                            'OFERTA' => $datos[7],
                            'TIENE_AHORRO_FUTURO' => $datos[8],
                            'RANGO' => $datos[9],
                            'PREMIO_AL_FINAL_DEL_3ER_MES1' => $datos[10],
                            'PREMIO_AL_FINAL_DEL_3ER_MES2' => $datos[11],
                            'CUOTA_BP' => $datos[12],
                            'PRODUCTO_PREMIO' => $datos[13],
                            'GRUPO' => $datos[14],
                            'INCREMENTAL_EN_PASIVOS' => $datos[15],
                            'TIPO_TARJETA_MILLAS' => $datos[16],
                            'TASA_BENEFICIO_ADICIONAL_AHO_FUT' => $datos[17],
                            'CONDICION_APORTE_MENSUAL_AHO_FUT' => $datos[18],
                            'AGENCIA' => $datos[19],
                            'PROVINCIA_DOMICILIO' => $datos[20],
                            'CIUDAD_DOMICILIO' => $datos[21],
                            'DIRECCION_DOMICILIO' => $datos[22],
                            'PROVINCIA_TRABAJO' => $datos[23],
                            'CIUDAD_TRABAJO' => $datos[24],
                            'DIRECCION_TRABAJO' => $datos[25],
                            'CORREO1' => $datos[26],
                            'CORREOBAN' => $datos[27],
                            'TELEFONO_01' => $datos[28],
                            'TELEFONO_02' => $datos[29],
                            'TELEFONO_03' => $datos[30],
                            'TELEFONO_04' => $datos[31],
                            'TELEFONO_05' => $datos[32],
                            'TELEFONO_06' => $datos[33],
                            'TELEFONO_07' => $datos[34],
                            'TELEFONO_08' => $datos[35],
                            'TELEFONO_09' => $datos[36],
                            'TELEFONO_10' => $datos[37],
                        );
                    }
                }
                fclose($users); //Cierra el archivo
                $ingresado = 0; //Variable que almacenara los insert exitosos
                $error = 0; //Variable que almacenara los errores en almacenamiento
                $duplicado = 0; //Variable que almacenara los registros duplicados
                foreach ($linea as $indice => $value) { //Iteracion el array para extraer cada uno de los valores almacenados en cada items
                    $count = ejecutarConsultaSimple("select UUID() 'id'");
                    $idG = $count['id'];
                    //Almacenamos info en contactimportcontact. Datos traidos del array para almacenar en la base
                    $ID = $idG;
                    $Name = $value["NOMBRE_CLIENTE"];
                    $Identification = $value["IDENTIFICACION"];
                    $Campaign = $campaignId;
                    $LastManagementResult = "";
                    $LastUpdate = $nameExcel;
                    $CODIGO_CAMPANIA = $value['CODIGO_CAMPANIA'];
                    $NOMBRE_CAMPANIA = $value['NOMBRE_CAMPANIA'];
                    $IDENTIFICACION = $value['IDENTIFICACION'];
                    $NOMBRE_CLIENTE = $value['NOMBRE_CLIENTE'];
                    $ZONA = $value['ZONA'];
                    $REGION = $value['REGION'];
                    $SUBSEGMENTO = $value['SUBSEGMENTO'];
                    $OFERTA = $value['OFERTA'];
                    $TIENE_AHORRO_FUTURO = $value['TIENE_AHORRO_FUTURO'];
                    $RANGO = $value['RANGO'];
                    $PREMIO_AL_FINAL_DEL_3ER_MES1 = $value['PREMIO_AL_FINAL_DEL_3ER_MES1'];
                    $PREMIO_AL_FINAL_DEL_3ER_MES2 = $value['PREMIO_AL_FINAL_DEL_3ER_MES2'];
                    $CUOTA_BP = $value['CUOTA_BP'];
                    $PRODUCTO_PREMIO = $value['PRODUCTO_PREMIO'];
                    $GRUPO = $value['GRUPO'];
                    $INCREMENTAL_EN_PASIVOS = $value['INCREMENTAL_EN_PASIVOS'];
                    $TIPO_TARJETA_MILLAS = $value['TIPO_TARJETA_MILLAS'];
                    $TASA_BENEFICIO_ADICIONAL_AHO_FUT = $value['TASA_BENEFICIO_ADICIONAL_AHO_FUT'];
                    $CONDICION_APORTE_MENSUAL_AHO_FUT = $value['CONDICION_APORTE_MENSUAL_AHO_FUT'];
                    $AGENCIA = $value['AGENCIA'];
                    $PROVINCIA_DOMICILIO = $value['PROVINCIA_DOMICILIO'];
                    $CIUDAD_DOMICILIO = $value['CIUDAD_DOMICILIO'];
                    $DIRECCION_DOMICILIO = $value['DIRECCION_DOMICILIO'];
                    $PROVINCIA_TRABAJO = $value['PROVINCIA_TRABAJO'];
                    $CIUDAD_TRABAJO = $value['CIUDAD_TRABAJO'];
                    $DIRECCION_TRABAJO = $value['DIRECCION_TRABAJO'];
                    $CORREO1 = $value['CORREO1'];
                    $CORREOBAN = $value['CORREOBAN'];
                    $TELEFONO_01 = $value['TELEFONO_01'];
                    $TELEFONO_02 = $value['TELEFONO_02'];
                    $TELEFONO_03 = $value['TELEFONO_03'];
                    $TELEFONO_04 = $value['TELEFONO_04'];
                    $TELEFONO_05 = $value['TELEFONO_05'];
                    $TELEFONO_06 = $value['TELEFONO_06'];
                    $TELEFONO_07 = $value['TELEFONO_07'];
                    $TELEFONO_08 = $value['TELEFONO_08'];
                    $TELEFONO_09 = $value['TELEFONO_09'];
                    $TELEFONO_10 = $value['TELEFONO_10'];

                    $sql = ejecutarConsulta("select * from contactimportcontact where Id='$ID'"); //Consulta a la tabla
                    $num = mysqli_num_rows($sql); //Cuenta el numero de registros devueltos por la consulta
                    if ($num == 0) {//Si es == 0 inserto
                        if ($insert = ejecutarConsulta("insert into contactimportcontact (VCC, ID, Name, Identification, Campaign, LastManagementResult, LastUpdate) "
                                . "values('$vcc','$ID','$Name','$Identification','$Campaign','$LastManagementResult','$LastUpdate')")) {
                            $msj = '<font color=green>Dato <b>' . $Name . '</b> Guardado</font><br/>';
                            $ingresado += 1;
                            /*                             * *********************************INSERTAMOS LA INFROMACION EN LA TABLA CLIENTES*********************************** */
                            ejecutarConsulta9("INSERT INTO clientes(VCC, CampaignId, ContactId, ContactName, InteractionId, ImportId, LastAgent, ResultLevel1, ResultLevel2, ResultLevel3, ManagementResultCode, ManagementResultDescription, ID, CODIGO_CAMPANIA, NOMBRE_CAMPANIA, IDENTIFICACION, NOMBRE_CLIENTE, ZONA, REGION, SUBSEGMENTO, OFERTA, TIENE_AHORRO_FUTURO, RANGO, PREMIO_AL_FINAL_DEL_3ER_MES1, PREMIO_AL_FINAL_DEL_3ER_MES2, CUOTA_BP, PRODUCTO_PREMIO, GRUPO, INCREMENTAL_EN_PASIVOS, TIPO_TARJETA_MILLAS, TASA_BENEFICIO_ADICIONAL_AHO_FUT, CONDICION_APORTE_MENSUAL_AHO_FUT, AGENCIA, PROVINCIA_DOMICILIO, CIUDAD_DOMICILIO, DIRECCION_DOMICILIO, PROVINCIA_TRABAJO, CIUDAD_TRABAJO, DIRECCION_TRABAJO, CORREO1, CORREOBAN) VALUES "
                                    . "('$vcc', '$Campaign', '$ID', '$NOMBRE_CLIENTE', '', '$LastUpdate','Pendiente','Pendiente','Pendiente','Pendiente','0','Pendiente', '$ID','$CODIGO_CAMPANIA','$NOMBRE_CAMPANIA','$IDENTIFICACION','$NOMBRE_CLIENTE','$ZONA','$REGION','$SUBSEGMENTO','$OFERTA','$TIENE_AHORRO_FUTURO','$RANGO','$PREMIO_AL_FINAL_DEL_3ER_MES1','$PREMIO_AL_FINAL_DEL_3ER_MES2','$CUOTA_BP','$PRODUCTO_PREMIO','$GRUPO','$INCREMENTAL_EN_PASIVOS','$TIPO_TARJETA_MILLAS','$TASA_BENEFICIO_ADICIONAL_AHO_FUT','$CONDICION_APORTE_MENSUAL_AHO_FUT','$AGENCIA','$PROVINCIA_DOMICILIO','$CIUDAD_DOMICILIO','$DIRECCION_DOMICILIO','$PROVINCIA_TRABAJO','$CIUDAD_TRABAJO','$DIRECCION_TRABAJO','$CORREO1','$CORREOBAN')");

                            if ($TELEFONO_01 != '') {
                                $vTelefono1 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_01','','SG','$dateNow','$dateNow','TELEFONO_01','$Identification')");
                            }
                            if ($TELEFONO_02 != '') {
                                $vTelefono2 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_02','','SG','$dateNow','$dateNow','TELEFONO_02','$Identification')");
                            }
                            if ($TELEFONO_03 != '') {
                                $vTelefono3 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_03','','SG','$dateNow','$dateNow','TELEFONO_03','$Identification')");
                            }
                            if ($TELEFONO_04 != '') {
                                $vTelefono4 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_04','','SG','$dateNow','$dateNow','TELEFONO_04','$Identification')");
                            }
                            if ($TELEFONO_05 != '') {
                                $vTelefono5 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_05','','SG','$dateNow','$dateNow','TELEFONO_05','$Identification')");
                            }
                            if ($TELEFONO_06 != '') {
                                $vTelefono6 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_06','','SG','$dateNow','$dateNow','TELEFONO_06','$Identification')");
                            }
                            if ($TELEFONO_07 != '') {
                                $vTELEFONO_07 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_07','','SG','$dateNow','$dateNow','TELEFONO_07','$Identification')");
                            }
                            if ($TELEFONO_08 != '') {
                                $vTELEFONO_08 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_08','','SG','$dateNow','$dateNow','TELEFONO_08','$Identification')");
                            }
                            if ($TELEFONO_09 != '') {
                                $vTELEFONO_09 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_09','','SG','$dateNow','$dateNow','TELEFONO_09','$Identification')");
                            }
                            if ($TELEFONO_10 != '') {
                                $vTELEFONO_10 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_10','','SG','$dateNow','$dateNow','TELEFONO_10','$Identification')");
                            }
                        }//fin del if que comprueba que se guarden los $datos
                        else {//sino ingresa el producto
                            echo $msj = '<font color=red>Dato <b>' . $Name . ' </b> no almacenado' . mysqli_error() . '</font><br/>';
                            $error += 1;
                        }
                    }//fin de if que comprueba que no haya en registro duplicado
                    else {
                        $duplicado += 1;
                        echo $duplicate = '<font color=#F3D305>El dato <b>' . $Name . '</b> está duplicado<br></font>';
                    }
                }
                echo "<b>La importación $nameExcel  tiene el siguiente detalle:</b><br/>";
                echo "<font color=green>" . $ingresado . " Datos almacenados con éxito<br/>";
                echo "<font color=#F3D305>" . $duplicado . " Datos duplicados<br/>";
                echo "<font color=red>" . $error . " Errores de almacenamiento<br/>";
                $vContactDetails = ejecutarConsulta("INSERT INTO contactimportdetail(VCC, ImportId, UpdateNum, "
                        . "Date, ImportUser, ValidContacts, NewContacts, UpdatedContacts, "
                        . "InvalidContacts, DuplicatesContacts) "
                        . "VALUES ('$vcc','$LastUpdate','1','$dateNow','$_SESSION[usu]','$ingresado','$ingresado',"
                        . "'0','$error','$duplicado')");

                $vContactImport = ejecutarConsulta("INSERT INTO contactimport(VCC, ID, DBProvider,"
                        . "Updates, Status, ServiceId) "
                        . "VALUES ('$vcc','$LastUpdate','$LastUpdate','1',"
                        . "case when $error = 0  then 'COMPLETE' else 'INCOMPLETE' end,'NULL')");
            }
        }
        break;

    case 'claroVentas':
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

            $sql = ejecutarConsulta("SELECT DISTINCT CampaignId 'Id' FROM campaignresultmanagement where CampaignId = '$campaignId'");
            $vCamp = mysqli_fetch_array($sql, MYSQLI_BOTH);
            $sql1 = ejecutarConsulta("SELECT DISTINCT lastupdate FROM contactimportcontact "
                    . "WHERE EXISTS (SELECT DISTINCT lastupdate FROM contactimportcontact c "
                    . "WHERE c.lastupdate = '$nameExcel')");
            $vImport = mysqli_fetch_array($sql1, MYSQLI_BOTH);
            if ($vCamp["Id"] == "") {
                echo("No exite la campaña seleccionada");
                //} else if ($vImport != "") {
                // echo("Nombre de importación duplicado");
            } else {
                while (($datos = fgetcsv($users, 100000, ";")) !== FALSE) {//Leo linea por linea del archivo hasta un maximo de 1000 caracteres por linea leida usando coma(,) o (;) como delimitador
                    $row++;
                    if ($row > 1) {
                        $linea[] = array(//Arreglo Bidimensional para guardar los datos de cada linea leida del archivo
                            'IDENTIFICACION' => $datos[0],
                            'NOMBRES' => $datos[1],
                            'CORREO' => $datos[2],
                            'ESTADO_CIVIL' => $datos[3],
                            'REGION_PROVINCIA' => $datos[4],
                            'TELEFONO_01' => $datos[5],
                            'TELEFONO_02' => $datos[6],
                            'TELEFONO_03' => $datos[7],
                            'TELEFONO_04' => $datos[8],
                            'TELEFONO_05' => $datos[9],
                            'TELEFONO_06' => $datos[10],
                            'TELEFONO_07' => $datos[11],
                            'TELEFONO_08' => $datos[12],
                            'TELEFONO_09' => $datos[13],
                            'TELEFONO_10' => $datos[14],
                        );
                    }
                }
                fclose($users); //Cierra el archivo
                $ingresado = 0; //Variable que almacenara los insert exitosos
                $error = 0; //Variable que almacenara los errores en almacenamiento
                $duplicado = 0; //Variable que almacenara los registros duplicados
                foreach ($linea as $indice => $value) { //Iteracion el array para extraer cada uno de los valores almacenados en cada items
                    $count = ejecutarConsultaSimple("select UUID() 'id'");
                    $idG = $count['id'];
                    //Almacenamos info en contactimportcontact. Datos traidos del array para almacenar en la base
                    $ID = $idG;
                    $Name = $value["NOMBRES"];
                    $Identification = $value["IDENTIFICACION"];
                    $Campaign = $campaignId;
                    $LastManagementResult = "";
                    $LastUpdate = $nameExcel;
                    $CORREO = $value['CORREO'];
                    $ESTADO_CIVIL = $value['ESTADO_CIVIL'];
                    $REGION_PROVINCIA = $value['REGION_PROVINCIA'];
                    $TELEFONO_01 = $value['TELEFONO_01'];
                    $TELEFONO_02 = $value['TELEFONO_02'];
                    $TELEFONO_03 = $value['TELEFONO_03'];
                    $TELEFONO_04 = $value['TELEFONO_04'];
                    $TELEFONO_05 = $value['TELEFONO_05'];
                    $TELEFONO_06 = $value['TELEFONO_06'];
                    $TELEFONO_07 = $value['TELEFONO_07'];
                    $TELEFONO_08 = $value['TELEFONO_08'];
                    $TELEFONO_09 = $value['TELEFONO_09'];
                    $TELEFONO_10 = $value['TELEFONO_10'];

                    $sql = ejecutarConsulta("select * from contactimportcontact where Id='$ID'"); //Consulta a la tabla
                    $num = mysqli_num_rows($sql); //Cuenta el numero de registros devueltos por la consulta
                    if ($num == 0) {//Si es == 0 inserto
                        if ($insert = ejecutarConsulta("insert into contactimportcontact (VCC, ID, Name, Identification, Campaign, LastManagementResult, LastUpdate) "
                                . "values('$vcc','$ID','$Name','$Identification','$Campaign','$LastManagementResult','$LastUpdate')")) {
                            $msj = '<font color=green>Dato <b>' . $Name . '</b> Guardado</font><br/>';
                            $ingresado += 1;
                            /*                             * *********************************INSERTAMOS LA INFROMACION EN LA TABLA CLIENTES*********************************** */
                            ejecutarConsulta10("INSERT INTO clientes(VCC, CampaignId, ContactId, ContactName, InteractionId, ImportId, LastAgent, ResultLevel1, ResultLevel2, ResultLevel3, ManagementResultCode, ManagementResultDescription, ID, IDENTIFICACION, NOMBRES, CORREO, ESTADO_CIVIL, REGION_PROVINCIA) VALUES "
                                    . "('$vcc', '$Campaign', '$ID', '$Name', '', '$LastUpdate','Pendiente','Pendiente','Pendiente','Pendiente','0','Pendiente', '$ID','$Identification','$Name','$CORREO','$ESTADO_CIVIL','$REGION_PROVINCIA')");

                            if ($TELEFONO_01 != '') {
                                $vTelefono1 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_01','','SG','$dateNow','$dateNow','TELEFONO_01','$Identification')");
                            }
                            if ($TELEFONO_02 != '') {
                                $vTelefono2 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_02','','SG','$dateNow','$dateNow','TELEFONO_02','$Identification')");
                            }
                            if ($TELEFONO_03 != '') {
                                $vTelefono3 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_03','','SG','$dateNow','$dateNow','TELEFONO_03','$Identification')");
                            }
                            if ($TELEFONO_04 != '') {
                                $vTelefono4 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_04','','SG','$dateNow','$dateNow','TELEFONO_04','$Identification')");
                            }
                            if ($TELEFONO_05 != '') {
                                $vTelefono5 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_05','','SG','$dateNow','$dateNow','TELEFONO_05','$Identification')");
                            }
                            if ($TELEFONO_06 != '') {
                                $vTelefono6 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_06','','SG','$dateNow','$dateNow','TELEFONO_06','$Identification')");
                            }
                            if ($TELEFONO_07 != '') {
                                $vTELEFONO_07 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_07','','SG','$dateNow','$dateNow','TELEFONO_07','$Identification')");
                            }
                            if ($TELEFONO_08 != '') {
                                $vTELEFONO_08 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_08','','SG','$dateNow','$dateNow','TELEFONO_08','$Identification')");
                            }
                            if ($TELEFONO_09 != '') {
                                $vTELEFONO_09 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_09','','SG','$dateNow','$dateNow','TELEFONO_09','$Identification')");
                            }
                            if ($TELEFONO_10 != '') {
                                $vTELEFONO_10 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_10','','SG','$dateNow','$dateNow','TELEFONO_10','$Identification')");
                            }
                        }//fin del if que comprueba que se guarden los $datos
                        else {//sino ingresa el producto
                            echo $msj = '<font color=red>Dato <b>' . $Name . ' </b> no almacenado' . mysqli_error() . '</font><br/>';
                            $error += 1;
                        }
                    }//fin de if que comprueba que no haya en registro duplicado
                    else {
                        $duplicado += 1;
                        echo $duplicate = '<font color=#F3D305>El dato <b>' . $Name . '</b> está duplicado<br></font>';
                    }
                }
                echo "<b>La importación $nameExcel  tiene el siguiente detalle:</b><br/>";
                echo "<font color=green>" . $ingresado . " Datos almacenados con éxito<br/>";
                echo "<font color=#F3D305>" . $duplicado . " Datos duplicados<br/>";
                echo "<font color=red>" . $error . " Errores de almacenamiento<br/>";
                $vContactDetails = ejecutarConsulta("INSERT INTO contactimportdetail(VCC, ImportId, UpdateNum, "
                        . "Date, ImportUser, ValidContacts, NewContacts, UpdatedContacts, "
                        . "InvalidContacts, DuplicatesContacts) "
                        . "VALUES ('$vcc','$LastUpdate','1','$dateNow','$_SESSION[usu]','$ingresado','$ingresado',"
                        . "'0','$error','$duplicado')");

                $vContactImport = ejecutarConsulta("INSERT INTO contactimport(VCC, ID, DBProvider,"
                        . "Updates, Status, ServiceId) "
                        . "VALUES ('$vcc','$LastUpdate','$LastUpdate','1',"
                        . "case when $error = 0  then 'COMPLETE' else 'INCOMPLETE' end,'NULL')");
            }
        }
        break;

    case 'bancoBGREncuestas':
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

            $sql = ejecutarConsulta("SELECT DISTINCT CampaignId 'Id' FROM campaignresultmanagement where CampaignId = '$campaignId'");
            $vCamp = mysqli_fetch_array($sql, MYSQLI_BOTH);
            $sql1 = ejecutarConsulta("SELECT DISTINCT lastupdate FROM contactimportcontact "
                    . "WHERE EXISTS (SELECT DISTINCT lastupdate FROM contactimportcontact c "
                    . "WHERE c.lastupdate = '$nameExcel')");
            $vImport = mysqli_fetch_array($sql1, MYSQLI_BOTH);
            if ($vCamp["Id"] == "") {
                echo("No exite la campaña seleccionada");
                //} else if ($vImport != "") {
                // echo("Nombre de importación duplicado");
            } else {
                while (($datos = fgetcsv($users, 100000, ";")) !== FALSE) {//Leo linea por linea del archivo hasta un maximo de 1000 caracteres por linea leida usando coma(,) o (;) como delimitador
                    $row++;
                    if ($row > 1) {
                        $linea[] = array(//Arreglo Bidimensional para guardar los datos de cada linea leida del archivo
                            'IDENTIFICACION' => $datos[0],
                            'NOMBRE_CLIENTE' => $datos[1],
                            'TIPO_CLIENTE' => $datos[2],
                            'SEGMENTO' => $datos[3],
                            'CODIGO_AGENCIA' => $datos[4],
                            'AGENCIA' => $datos[5],
                            'REGION' => $datos[6],
                            'SECCION' => $datos[7],
                            'AREA' => $datos[8],
                            'USUARIO' => $datos[9],
                            'CAJERO' => $datos[10],
                            'TRAMITES' => $datos[11],
                            'TIPO_TRANSACCION' => $datos[12],
                            'TITULAR_TERCERO' => $datos[13],
                            'CUENTA' => $datos[14],
                            'FECHA_ATENCION' => $datos[15],
                            'HORA_ATENCION' => $datos[16],
                            'TELEFONO_01' => $datos[17],
                            'TELEFONO_02' => $datos[18],
                            'TELEFONO_03' => $datos[19],
                            'TELEFONO_04' => $datos[20],
                            'TELEFONO_05' => $datos[21],
                            'TELEFONO_06' => $datos[22],
                            'TELEFONO_07' => $datos[23],
                            'TELEFONO_08' => $datos[24],
                            'TELEFONO_09' => $datos[25],
                            'TELEFONO_10' => $datos[26],
                        );
                    }
                }
                fclose($users); //Cierra el archivo
                $ingresado = 0; //Variable que almacenara los insert exitosos
                $error = 0; //Variable que almacenara los errores en almacenamiento
                $duplicado = 0; //Variable que almacenara los registros duplicados
                foreach ($linea as $indice => $value) { //Iteracion el array para extraer cada uno de los valores almacenados en cada items
                    $count = ejecutarConsultaSimple("select UUID() 'id'");
                    $idG = $count['id'];
                    //Almacenamos info en contactimportcontact. Datos traidos del array para almacenar en la base
                    $ID = $idG;
                    $Name = $value["NOMBRE_CLIENTE"];
                    $Identification = $value["IDENTIFICACION"];
                    $Campaign = $campaignId;
                    $LastManagementResult = "";
                    $LastUpdate = $nameExcel;
                    $IDENTIFICACION = $value['IDENTIFICACION'];
                    $NOMBRE_CLIENTE = $value['NOMBRE_CLIENTE'];
                    $TIPO_CLIENTE = $value['TIPO_CLIENTE'];
                    $SEGMENTO = $value['SEGMENTO'];
                    $CODIGO_AGENCIA = $value['CODIGO_AGENCIA'];
                    $AGENCIA = $value['AGENCIA'];
                    $REGION = $value['REGION'];
                    $SECCION = $value['SECCION'];
                    $AREA = $value['AREA'];
                    $USUARIO = $value['USUARIO'];
                    $CAJERO = $value['CAJERO'];
                    $TRAMITES = $value['TRAMITES'];
                    $TIPO_TRANSACCION = $value['TIPO_TRANSACCION'];
                    $TITULAR_TERCERO = $value['TITULAR_TERCERO'];
                    $CUENTA = $value['CUENTA'];
                    $FECHA_ATENCION = $value['FECHA_ATENCION'];
                    $HORA_ATENCION = $value['HORA_ATENCION'];
                    $TELEFONO_01 = $value['TELEFONO_01'];
                    $TELEFONO_02 = $value['TELEFONO_02'];
                    $TELEFONO_03 = $value['TELEFONO_03'];
                    $TELEFONO_04 = $value['TELEFONO_04'];
                    $TELEFONO_05 = $value['TELEFONO_05'];
                    $TELEFONO_06 = $value['TELEFONO_06'];
                    $TELEFONO_07 = $value['TELEFONO_07'];
                    $TELEFONO_08 = $value['TELEFONO_08'];
                    $TELEFONO_09 = $value['TELEFONO_09'];
                    $TELEFONO_10 = $value['TELEFONO_10'];

                    $sql = ejecutarConsulta("select * from contactimportcontact where Id='$ID'"); //Consulta a la tabla
                    $num = mysqli_num_rows($sql); //Cuenta el numero de registros devueltos por la consulta
                    if ($num == 0) {//Si es == 0 inserto
                        if ($insert = ejecutarConsulta("insert into contactimportcontact (VCC, ID, Name, Identification, Campaign, LastManagementResult, LastUpdate) "
                                . "values('$vcc','$ID','$Name','$Identification','$Campaign','$LastManagementResult','$LastUpdate')")) {
                            $msj = '<font color=green>Dato <b>' . $Name . '</b> Guardado</font><br/>';
                            $ingresado += 1;
                            /*                             * *********************************INSERTAMOS LA INFROMACION EN LA TABLA CLIENTES*********************************** */
                            ejecutarConsulta11("INSERT INTO clientes(VCC, CampaignId, ContactId, ContactName, InteractionId, ImportId, LastAgent, ResultLevel1, ResultLevel2, ResultLevel3, ManagementResultCode, ManagementResultDescription, ID, IDENTIFICACION, NOMBRE_CLIENTE, TIPO_CLIENTE, SEGMENTO, CODIGO_AGENCIA, AGENCIA, SECCION, REGION, AREA, USUARIO, CAJERO, TRAMITES, TIPO_TRANSACCION, TITULAR_TERCERO, CUENTA, FECHA_ATENCION, HORA_ATENCION) VALUES "
                                    . "('$vcc', '$Campaign', '$ID', '$Name', '', '$LastUpdate','Pendiente','Pendiente','Pendiente','Pendiente','0','Pendiente', '$ID','$IDENTIFICACION','$NOMBRE_CLIENTE','$TIPO_CLIENTE','$SEGMENTO','$CODIGO_AGENCIA','$AGENCIA','$SECCION','$REGION','$AREA','$USUARIO','$CAJERO','$TRAMITES','$TIPO_TRANSACCION','$TITULAR_TERCERO','$CUENTA','$FECHA_ATENCION','$HORA_ATENCION')");

                            if ($TELEFONO_01 != '') {
                                $vTelefono1 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_01','','SG','$dateNow','$dateNow','TELEFONO_01','$Identification')");
                            }
                            if ($TELEFONO_02 != '') {
                                $vTelefono2 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_02','','SG','$dateNow','$dateNow','TELEFONO_02','$Identification')");
                            }
                            if ($TELEFONO_03 != '') {
                                $vTelefono3 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_03','','SG','$dateNow','$dateNow','TELEFONO_03','$Identification')");
                            }
                            if ($TELEFONO_04 != '') {
                                $vTelefono4 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_04','','SG','$dateNow','$dateNow','TELEFONO_04','$Identification')");
                            }
                            if ($TELEFONO_05 != '') {
                                $vTelefono5 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_05','','SG','$dateNow','$dateNow','TELEFONO_05','$Identification')");
                            }
                            if ($TELEFONO_06 != '') {
                                $vTelefono6 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_06','','SG','$dateNow','$dateNow','TELEFONO_06','$Identification')");
                            }
                            if ($TELEFONO_07 != '') {
                                $vTELEFONO_07 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_07','','SG','$dateNow','$dateNow','TELEFONO_07','$Identification')");
                            }
                            if ($TELEFONO_08 != '') {
                                $vTELEFONO_08 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_08','','SG','$dateNow','$dateNow','TELEFONO_08','$Identification')");
                            }
                            if ($TELEFONO_09 != '') {
                                $vTELEFONO_09 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_09','','SG','$dateNow','$dateNow','TELEFONO_09','$Identification')");
                            }
                            if ($TELEFONO_10 != '') {
                                $vTELEFONO_10 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_10','','SG','$dateNow','$dateNow','TELEFONO_10','$Identification')");
                            }
                        }//fin del if que comprueba que se guarden los $datos
                        else {//sino ingresa el producto
                            echo $msj = '<font color=red>Dato <b>' . $Name . ' </b> no almacenado' . mysqli_error() . '</font><br/>';
                            $error += 1;
                        }
                    }//fin de if que comprueba que no haya en registro duplicado
                    else {
                        $duplicado += 1;
                        echo $duplicate = '<font color=#F3D305>El dato <b>' . $Name . '</b> está duplicado<br></font>';
                    }
                }
                echo "<b>La importación $nameExcel  tiene el siguiente detalle:</b><br/>";
                echo "<font color=green>" . $ingresado . " Datos almacenados con éxito<br/>";
                echo "<font color=#F3D305>" . $duplicado . " Datos duplicados<br/>";
                echo "<font color=red>" . $error . " Errores de almacenamiento<br/>";
                $vContactDetails = ejecutarConsulta("INSERT INTO contactimportdetail(VCC, ImportId, UpdateNum, "
                        . "Date, ImportUser, ValidContacts, NewContacts, UpdatedContacts, "
                        . "InvalidContacts, DuplicatesContacts) "
                        . "VALUES ('$vcc','$LastUpdate','1','$dateNow','$_SESSION[usu]','$ingresado','$ingresado',"
                        . "'0','$error','$duplicado')");

                $vContactImport = ejecutarConsulta("INSERT INTO contactimport(VCC, ID, DBProvider,"
                        . "Updates, Status, ServiceId) "
                        . "VALUES ('$vcc','$LastUpdate','$LastUpdate','1',"
                        . "case when $error = 0  then 'COMPLETE' else 'INCOMPLETE' end,'NULL')");
            }
        }
        break;

    case 'bancoPichinchaEncuestaEgas':
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

            $sql = ejecutarConsulta("SELECT DISTINCT CampaignId 'Id' FROM campaignresultmanagement where CampaignId = '$campaignId'");
            $vCamp = mysqli_fetch_array($sql, MYSQLI_BOTH);
            $sql1 = ejecutarConsulta("SELECT DISTINCT lastupdate FROM contactimportcontact "
                    . "WHERE EXISTS (SELECT DISTINCT lastupdate FROM contactimportcontact c "
                    . "WHERE c.lastupdate = '$nameExcel')");
            $vImport = mysqli_fetch_array($sql1, MYSQLI_BOTH);
            if ($vCamp["Id"] == "") {
                echo("No exite la campaña seleccionada");
                //} else if ($vImport != "") {
                // echo("Nombre de importación duplicado");
            } else {
                while (($datos = fgetcsv($users, 100000, ";")) !== FALSE) {//Leo linea por linea del archivo hasta un maximo de 1000 caracteres por linea leida usando coma(,) o (;) como delimitador
                    $row++;
                    if ($row > 1) {
                        $linea[] = array(//Arreglo Bidimensional para guardar los datos de cada linea leida del archivo
                            'IDENTIFICACION' => $datos[0],
                            'NOMBRE_CLIENTE' => $datos[1],
                            'EDAD' => $datos[2],
                            'REGION' => $datos[3],
                            'LOCALIDAD' => $datos[4],
                            'TELEFONO_01' => $datos[5],
                            'TELEFONO_02' => $datos[6],
                            'TELEFONO_03' => $datos[7],
                            'TELEFONO_04' => $datos[8],
                            'TELEFONO_05' => $datos[9],
                            'TELEFONO_06' => $datos[10],
                            'TELEFONO_07' => $datos[11],
                            'TELEFONO_08' => $datos[12],
                            'TELEFONO_09' => $datos[13],
                            'TELEFONO_10' => $datos[14],
                        );
                    }
                }
                fclose($users); //Cierra el archivo
                $ingresado = 0; //Variable que almacenara los insert exitosos
                $error = 0; //Variable que almacenara los errores en almacenamiento
                $duplicado = 0; //Variable que almacenara los registros duplicados
                foreach ($linea as $indice => $value) { //Iteracion el array para extraer cada uno de los valores almacenados en cada items
                    $count = ejecutarConsultaSimple("select UUID() 'id'");
                    $idG = $count['id'];
                    //Almacenamos info en contactimportcontact. Datos traidos del array para almacenar en la base
                    $ID = $idG;
                    $Name = $value["NOMBRE_CLIENTE"];
                    $Identification = $value["IDENTIFICACION"];
                    $Campaign = $campaignId;
                    $LastManagementResult = "";
                    $LastUpdate = $nameExcel;
                    $IDENTIFICACION = $value['IDENTIFICACION'];
                    $NOMBRE_CLIENTE = $value['NOMBRE_CLIENTE'];
                    $EDAD = $value['EDAD'];
                    $REGION = $value['REGION'];
                    $LOCALIDAD = $value['LOCALIDAD'];
                    $TELEFONO_01 = $value['TELEFONO_01'];
                    $TELEFONO_02 = $value['TELEFONO_02'];
                    $TELEFONO_03 = $value['TELEFONO_03'];
                    $TELEFONO_04 = $value['TELEFONO_04'];
                    $TELEFONO_05 = $value['TELEFONO_05'];
                    $TELEFONO_06 = $value['TELEFONO_06'];
                    $TELEFONO_07 = $value['TELEFONO_07'];
                    $TELEFONO_08 = $value['TELEFONO_08'];
                    $TELEFONO_09 = $value['TELEFONO_09'];
                    $TELEFONO_10 = $value['TELEFONO_10'];

                    $sql = ejecutarConsulta("select * from contactimportcontact where Id='$ID'"); //Consulta a la tabla
                    $num = mysqli_num_rows($sql); //Cuenta el numero de registros devueltos por la consulta
                    if ($num == 0) {//Si es == 0 inserto
                        if ($insert = ejecutarConsulta("insert into contactimportcontact (VCC, ID, Name, Identification, Campaign, LastManagementResult, LastUpdate) "
                                . "values('$vcc','$ID','$Name','$Identification','$Campaign','$LastManagementResult','$LastUpdate')")) {
                            $msj = '<font color=green>Dato <b>' . $Name . '</b> Guardado</font><br/>';
                            $ingresado += 1;
                            /*                             * *********************************INSERTAMOS LA INFROMACION EN LA TABLA CLIENTES*********************************** */
                            ejecutarConsulta12("INSERT INTO clientes(VCC, CampaignId, ContactId, ContactName, InteractionId, ImportId, LastAgent, ResultLevel1, ResultLevel2, ResultLevel3, ManagementResultCode, ManagementResultDescription, ID, IDENTIFICACION, NOMBRE_CLIENTE, EDAD, REGION, LOCALIDAD) VALUES "
                                    . "('$vcc', '$Campaign', '$ID', '$Name', '', '$LastUpdate','Pendiente','Pendiente','Pendiente','Pendiente','0','Pendiente', '$ID','$IDENTIFICACION','$NOMBRE_CLIENTE','$EDAD','$REGION','$LOCALIDAD')");

                            if ($TELEFONO_01 != '') {
                                $vTelefono1 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_01','','SG','$dateNow','$dateNow','TELEFONO_01','$Identification')");
                            }
                            if ($TELEFONO_02 != '') {
                                $vTelefono2 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_02','','SG','$dateNow','$dateNow','TELEFONO_02','$Identification')");
                            }
                            if ($TELEFONO_03 != '') {
                                $vTelefono3 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_03','','SG','$dateNow','$dateNow','TELEFONO_03','$Identification')");
                            }
                            if ($TELEFONO_04 != '') {
                                $vTelefono4 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_04','','SG','$dateNow','$dateNow','TELEFONO_04','$Identification')");
                            }
                            if ($TELEFONO_05 != '') {
                                $vTelefono5 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_05','','SG','$dateNow','$dateNow','TELEFONO_05','$Identification')");
                            }
                            if ($TELEFONO_06 != '') {
                                $vTelefono6 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_06','','SG','$dateNow','$dateNow','TELEFONO_06','$Identification')");
                            }
                            if ($TELEFONO_07 != '') {
                                $vTELEFONO_07 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_07','','SG','$dateNow','$dateNow','TELEFONO_07','$Identification')");
                            }
                            if ($TELEFONO_08 != '') {
                                $vTELEFONO_08 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_08','','SG','$dateNow','$dateNow','TELEFONO_08','$Identification')");
                            }
                            if ($TELEFONO_09 != '') {
                                $vTELEFONO_09 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_09','','SG','$dateNow','$dateNow','TELEFONO_09','$Identification')");
                            }
                            if ($TELEFONO_10 != '') {
                                $vTELEFONO_10 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_10','','SG','$dateNow','$dateNow','TELEFONO_10','$Identification')");
                            }
                        }//fin del if que comprueba que se guarden los $datos
                        else {//sino ingresa el producto
                            echo $msj = '<font color=red>Dato <b>' . $Name . ' </b> no almacenado' . mysqli_error() . '</font><br/>';
                            $error += 1;
                        }
                    }//fin de if que comprueba que no haya en registro duplicado
                    else {
                        $duplicado += 1;
                        echo $duplicate = '<font color=#F3D305>El dato <b>' . $Name . '</b> está duplicado<br></font>';
                    }
                }
                echo "<b>La importación $nameExcel  tiene el siguiente detalle:</b><br/>";
                echo "<font color=green>" . $ingresado . " Datos almacenados con éxito<br/>";
                echo "<font color=#F3D305>" . $duplicado . " Datos duplicados<br/>";
                echo "<font color=red>" . $error . " Errores de almacenamiento<br/>";
                $vContactDetails = ejecutarConsulta("INSERT INTO contactimportdetail(VCC, ImportId, UpdateNum, "
                        . "Date, ImportUser, ValidContacts, NewContacts, UpdatedContacts, "
                        . "InvalidContacts, DuplicatesContacts) "
                        . "VALUES ('$vcc','$LastUpdate','1','$dateNow','$_SESSION[usu]','$ingresado','$ingresado',"
                        . "'0','$error','$duplicado')");

                $vContactImport = ejecutarConsulta("INSERT INTO contactimport(VCC, ID, DBProvider,"
                        . "Updates, Status, ServiceId) "
                        . "VALUES ('$vcc','$LastUpdate','$LastUpdate','1',"
                        . "case when $error = 0  then 'COMPLETE' else 'INCOMPLETE' end,'NULL')");
            }
        }
        break;

    case 'bancoPichinchaEncuestasGenericas':
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

            $sql = ejecutarConsulta("SELECT DISTINCT CampaignId 'Id' FROM campaignresultmanagement where CampaignId = '$campaignId'");
            $vCamp = mysqli_fetch_array($sql, MYSQLI_BOTH);
            $sql1 = ejecutarConsulta("SELECT DISTINCT lastupdate FROM contactimportcontact "
                    . "WHERE EXISTS (SELECT DISTINCT lastupdate FROM contactimportcontact c "
                    . "WHERE c.lastupdate = '$nameExcel')");
            $vImport = mysqli_fetch_array($sql1, MYSQLI_BOTH);
            if ($vCamp["Id"] == "") {
                echo("No exite la campaña seleccionada");
                //} else if ($vImport != "") {
                // echo("Nombre de importación duplicado");
            } else {
                while (($datos = fgetcsv($users, 100000, ";")) !== FALSE) {//Leo linea por linea del archivo hasta un maximo de 1000 caracteres por linea leida usando coma(,) o (;) como delimitador
                    $row++;
                    if ($row > 1) {
                        $linea[] = array(//Arreglo Bidimensional para guardar los datos de cada linea leida del archivo
                            'CODIGO_CAMPANIA' => $datos[0],
                            'NOMBRE_CAMPANIA' => $datos[1],
                            'IDENTIFICACION' => $datos[2],
                            'NOMBRE_CLIENTE' => $datos[3],
                            'CAMPO1' => $datos[4],
                            'CAMPO2' => $datos[5],
                            'CAMPO3' => $datos[6],
                            'CAMPO4' => $datos[7],
                            'CAMPO5' => $datos[8],
                            'CAMPO6' => $datos[9],
                            'CAMPO7' => $datos[10],
                            'CAMPO8' => $datos[11],
                            'CAMPO9' => $datos[12],
                            'CAMPO10' => $datos[13],
                            'TELEFONO_01' => $datos[14],
                            'TELEFONO_02' => $datos[15],
                            'TELEFONO_03' => $datos[16],
                            'TELEFONO_04' => $datos[17],
                            'TELEFONO_05' => $datos[18],
                            'TELEFONO_06' => $datos[19],
                            'TELEFONO_07' => $datos[20],
                            'TELEFONO_08' => $datos[21],
                            'TELEFONO_09' => $datos[22],
                            'TELEFONO_10' => $datos[23],
                        );
                    }
                }
                fclose($users); //Cierra el archivo
                $ingresado = 0; //Variable que almacenara los insert exitosos
                $error = 0; //Variable que almacenara los errores en almacenamiento
                $duplicado = 0; //Variable que almacenara los registros duplicados
                foreach ($linea as $indice => $value) { //Iteracion el array para extraer cada uno de los valores almacenados en cada items
                    $count = ejecutarConsultaSimple("select UUID() 'id'");
                    $idG = $count['id'];
                    //Almacenamos info en contactimportcontact. Datos traidos del array para almacenar en la base
                    $ID = $idG;
                    $Name = $value["NOMBRE_CLIENTE"];
                    $Identification = $value["IDENTIFICACION"];
                    $Campaign = $campaignId;
                    $LastManagementResult = "";
                    $LastUpdate = $nameExcel;
                    $CODIGO_CAMPANIA = $value['CODIGO_CAMPANIA'];
                    $NOMBRE_CAMPANIA = $value['NOMBRE_CAMPANIA'];
                    $IDENTIFICACION = $value['IDENTIFICACION'];
                    $NOMBRE_CLIENTE = $value['NOMBRE_CLIENTE'];
                    $CAMPO1 = $value['CAMPO1'];
                    $CAMPO2 = $value['CAMPO2'];
                    $CAMPO3 = $value['CAMPO3'];
                    $CAMPO4 = $value['CAMPO4'];
                    $CAMPO5 = $value['CAMPO5'];
                    $CAMPO6 = $value['CAMPO6'];
                    $CAMPO7 = $value['CAMPO7'];
                    $CAMPO8 = $value['CAMPO8'];
                    $CAMPO9 = $value['CAMPO9'];
                    $CAMPO10 = $value['CAMPO10'];
                    $TELEFONO_01 = $value['TELEFONO_01'];
                    $TELEFONO_02 = $value['TELEFONO_02'];
                    $TELEFONO_03 = $value['TELEFONO_03'];
                    $TELEFONO_04 = $value['TELEFONO_04'];
                    $TELEFONO_05 = $value['TELEFONO_05'];
                    $TELEFONO_06 = $value['TELEFONO_06'];
                    $TELEFONO_07 = $value['TELEFONO_07'];
                    $TELEFONO_08 = $value['TELEFONO_08'];
                    $TELEFONO_09 = $value['TELEFONO_09'];
                    $TELEFONO_10 = $value['TELEFONO_10'];

                    $sql = ejecutarConsulta("select * from contactimportcontact where Id='$ID'"); //Consulta a la tabla
                    $num = mysqli_num_rows($sql); //Cuenta el numero de registros devueltos por la consulta
                    if ($num == 0) {//Si es == 0 inserto
                        if ($insert = ejecutarConsulta("insert into contactimportcontact (VCC, ID, Name, Identification, Campaign, LastManagementResult, LastUpdate) "
                                . "values('$vcc','$ID','$Name','$Identification','$Campaign','$LastManagementResult','$LastUpdate')")) {
                            $msj = '<font color=green>Dato <b>' . $Name . '</b> Guardado</font><br/>';
                            $ingresado += 1;
                        }//fin del if que comprueba que se guarden los $datos
                        else {//sino ingresa el producto
                            echo $msj = '<font color=red>Dato <b>' . $Name . ' </b> no almacenado' . mysqli_error() . '</font><br/>';
                            $error += 1;
                        }
                        ejecutarConsulta12("INSERT INTO clientes(VCC, CampaignId, ContactId, ContactName, InteractionId, "
                                . "ImportId, LastAgent, ResultLevel1, ResultLevel2, ResultLevel3, ManagementResultCode, "
                                . "ManagementResultDescription, TmStmp, "
                                . "ID, CODIGO_CAMPANIA, NOMBRE_CAMPANIA, IDENTIFICACION, NOMBRE_CLIENTE, CAMPO1, CAMPO2, CAMPO3, CAMPO4, CAMPO5, CAMPO6, CAMPO7, CAMPO8, CAMPO9, CAMPO10) VALUES "
                                . "('$vcc','$Campaign','$ID', '$NOMBRE_CLIENTE', '', '$LastUpdate','Pendiente','Pendiente','Pendiente','Pendiente','0','Pendiente', '',"
                                . "'$ID','$CODIGO_CAMPANIA','$NOMBRE_CAMPANIA','$IDENTIFICACION','$NOMBRE_CLIENTE','$CAMPO1','$CAMPO2','$CAMPO3','$CAMPO4','$CAMPO5','$CAMPO6','$CAMPO7','$CAMPO8','$CAMPO9','$CAMPO10')");

                        if ($TELEFONO_01 != '') {
                            $vTelefono1 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_01','','SG','$dateNow','$dateNow','TELEFONO_01','$Identification')");
                        }
                        if ($TELEFONO_02 != '') {
                            $vTelefono2 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_02','','SG','$dateNow','$dateNow','TELEFONO_02','$Identification')");
                        }
                        if ($TELEFONO_03 != '') {
                            $vTelefono3 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_03','','SG','$dateNow','$dateNow','TELEFONO_03','$Identification')");
                        }
                        if ($TELEFONO_04 != '') {
                            $vTelefono4 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_04','','SG','$dateNow','$dateNow','TELEFONO_04','$Identification')");
                        }
                        if ($TELEFONO_05 != '') {
                            $vTelefono5 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_05','','SG','$dateNow','$dateNow','TELEFONO_05','$Identification')");
                        }
                        if ($TELEFONO_06 != '') {
                            $vTelefono6 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_06','','SG','$dateNow','$dateNow','TELEFONO_06','$Identification')");
                        }
                        if ($TELEFONO_07 != '') {
                            $vTELEFONO_07 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_07','','SG','$dateNow','$dateNow','TELEFONO_07','$Identification')");
                        }
                        if ($TELEFONO_08 != '') {
                            $vTELEFONO_08 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_08','','SG','$dateNow','$dateNow','TELEFONO_08','$Identification')");
                        }
                        if ($TELEFONO_09 != '') {
                            $vTELEFONO_09 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_09','','SG','$dateNow','$dateNow','TELEFONO_09','$Identification')");
                        }
                        if ($TELEFONO_10 != '') {
                            $vTELEFONO_10 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                    . "VALUES ('$ID','','$TELEFONO_10','','SG','$dateNow','$dateNow','TELEFONO_10','$Identification')");
                        }
                    }//fin de if que comprueba que no haya en registro duplicado
                    else {
                        $duplicado += 1;
                        echo $duplicate = '<font color=#F3D305>El dato <b>' . $Name . '</b> está duplicado<br></font>';
                    }
                }
                echo "<b>La importación $nameExcel  tiene el siguiente detalle:</b><br/>";
                echo "<font color=green>" . $ingresado . " Datos almacenados con éxito<br/>";
                echo "<font color=#F3D305>" . $duplicado . " Datos duplicados<br/>";
                echo "<font color=red>" . $error . " Errores de almacenamiento<br/>";
                $vContactDetails = ejecutarConsulta("INSERT INTO contactimportdetail(VCC, ImportId, UpdateNum, "
                        . "Date, ImportUser, ValidContacts, NewContacts, UpdatedContacts, "
                        . "InvalidContacts, DuplicatesContacts) "
                        . "VALUES ('$vcc','$LastUpdate','1','$dateNow','$_SESSION[usu]','$ingresado','$ingresado',"
                        . "'0','$error','$duplicado')");

                $vContactImport = ejecutarConsulta("INSERT INTO contactimport(VCC, ID, DBProvider,"
                        . "Updates, Status, ServiceId) "
                        . "VALUES ('$vcc','$LastUpdate','$LastUpdate','1',"
                        . "case when $error = 0  then 'COMPLETE' else 'INCOMPLETE' end,'NULL')");
            }
        }
        break;

    case 'jardinesDelValle':
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

            $sql = ejecutarConsulta("SELECT DISTINCT CampaignId 'Id' FROM campaignresultmanagement where CampaignId = '$campaignId'");
            $vCamp = mysqli_fetch_array($sql, MYSQLI_BOTH);
            $sql1 = ejecutarConsulta("SELECT DISTINCT lastupdate FROM contactimportcontact "
                    . "WHERE EXISTS (SELECT DISTINCT lastupdate FROM contactimportcontact c "
                    . "WHERE c.lastupdate = '$nameExcel')");
            $vImport = mysqli_fetch_array($sql1, MYSQLI_BOTH);
            if ($vCamp["Id"] == "") {
                echo("No exite la campaña seleccionada");
                //} else if ($vImport != "") {
                // echo("Nombre de importación duplicado");
            } else {
                while (($datos = fgetcsv($users, 100000, ";")) !== FALSE) {//Leo linea por linea del archivo hasta un maximo de 1000 caracteres por linea leida usando coma(,) o (;) como delimitador
                    $row++;
                    if ($row > 1) {
                        $linea[] = array(//Arreglo Bidimensional para guardar los datos de cada linea leida del archivo
                            'IDENTIFICACION' => $datos[0],
                            'NOMBRE_CLIENTE' => $datos[1],
                            'CIUDAD1' => $datos[2],
                            'CIUDAD2' => $datos[3],
                            'TELEFONO_01' => $datos[4],
                            'TELEFONO_02' => $datos[5],
                            'TELEFONO_03' => $datos[6],
                            'TELEFONO_04' => $datos[7],
                            'TELEFONO_05' => $datos[8],
                            'TELEFONO_06' => $datos[9],
                            'TELEFONO_07' => $datos[10],
                            'TELEFONO_08' => $datos[11],
                            'TELEFONO_09' => $datos[12],
                            'TELEFONO_10' => $datos[13],
                        );
                    }
                }
                fclose($users); //Cierra el archivo
                $ingresado = 0; //Variable que almacenara los insert exitosos
                $error = 0; //Variable que almacenara los errores en almacenamiento
                $duplicado = 0; //Variable que almacenara los registros duplicados
                foreach ($linea as $indice => $value) { //Iteracion el array para extraer cada uno de los valores almacenados en cada items
                    $count = ejecutarConsultaSimple("select UUID() 'id'");
                    $idG = $count['id'];
                    //Almacenamos info en contactimportcontact. Datos traidos del array para almacenar en la base
                    $ID = $idG;
                    $Name = $value["NOMBRE_CLIENTE"];
                    $Identification = $value["IDENTIFICACION"];
                    $Campaign = $campaignId;
                    $LastManagementResult = "";
                    $LastUpdate = $nameExcel;
                    $IDENTIFICACION = $value['IDENTIFICACION'];
                    $NOMBRE_CLIENTE = $value['NOMBRE_CLIENTE'];
                    $CIUDAD1 = $value['CIUDAD1'];
                    $CIUDAD2 = $value['CIUDAD2'];
                    $TELEFONO_01 = $value['TELEFONO_01'];
                    $TELEFONO_02 = $value['TELEFONO_02'];
                    $TELEFONO_03 = $value['TELEFONO_03'];
                    $TELEFONO_04 = $value['TELEFONO_04'];
                    $TELEFONO_05 = $value['TELEFONO_05'];
                    $TELEFONO_06 = $value['TELEFONO_06'];
                    $TELEFONO_07 = $value['TELEFONO_07'];
                    $TELEFONO_08 = $value['TELEFONO_08'];
                    $TELEFONO_09 = $value['TELEFONO_09'];
                    $TELEFONO_10 = $value['TELEFONO_10'];

                    $sql = ejecutarConsulta("select * from contactimportcontact where Id='$ID'"); //Consulta a la tabla
                    $num = mysqli_num_rows($sql); //Cuenta el numero de registros devueltos por la consulta
                    if ($num == 0) {//Si es == 0 inserto
                        if ($insert = ejecutarConsulta("insert into contactimportcontact (VCC, ID, Name, Identification, Campaign, LastManagementResult, LastUpdate) "
                                . "values('$vcc','$ID','$Name','$Identification','$Campaign','$LastManagementResult','$LastUpdate')")) {
                            $msj = '<font color=green>Dato <b>' . $Name . '</b> Guardado</font><br/>';
                            $ingresado += 1;
                            /*                             * *********************************INSERTAMOS LA INFROMACION EN LA TABLA CLIENTES*********************************** */
                            ejecutarConsulta13("INSERT INTO clientes(VCC, CampaignId, ContactId, ContactName, InteractionId, ImportId, LastAgent, ResultLevel1, ResultLevel2, ResultLevel3, ManagementResultCode, ManagementResultDescription, ID, IDENTIFICACION, NOMBRE_CLIENTE, CIUDAD1, CIUDAD2) VALUES "
                                    . "('$vcc', '$Campaign', '$ID', '$Name', '', '$LastUpdate','Pendiente','Pendiente','Pendiente','Pendiente','0','Pendiente', '$ID','$IDENTIFICACION','$NOMBRE_CLIENTE','$CIUDAD1','$CIUDAD2')");

                            if ($TELEFONO_01 != '') {
                                $vTelefono1 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_01','','SG','$dateNow','$dateNow','TELEFONO_01','$Identification')");
                            }
                            if ($TELEFONO_02 != '') {
                                $vTelefono2 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_02','','SG','$dateNow','$dateNow','TELEFONO_02','$Identification')");
                            }
                            if ($TELEFONO_03 != '') {
                                $vTelefono3 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_03','','SG','$dateNow','$dateNow','TELEFONO_03','$Identification')");
                            }
                            if ($TELEFONO_04 != '') {
                                $vTelefono4 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_04','','SG','$dateNow','$dateNow','TELEFONO_04','$Identification')");
                            }
                            if ($TELEFONO_05 != '') {
                                $vTelefono5 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_05','','SG','$dateNow','$dateNow','TELEFONO_05','$Identification')");
                            }
                            if ($TELEFONO_06 != '') {
                                $vTelefono6 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_06','','SG','$dateNow','$dateNow','TELEFONO_06','$Identification')");
                            }
                            if ($TELEFONO_07 != '') {
                                $vTELEFONO_07 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_07','','SG','$dateNow','$dateNow','TELEFONO_07','$Identification')");
                            }
                            if ($TELEFONO_08 != '') {
                                $vTELEFONO_08 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_08','','SG','$dateNow','$dateNow','TELEFONO_08','$Identification')");
                            }
                            if ($TELEFONO_09 != '') {
                                $vTELEFONO_09 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_09','','SG','$dateNow','$dateNow','TELEFONO_09','$Identification')");
                            }
                            if ($TELEFONO_10 != '') {
                                $vTELEFONO_10 = ejecutarConsulta("INSERT INTO contactimportphone(ContactId, InteractionId, NumeroMarcado, Agente, Estado, FechaHora, FechaHoraFin, DescripcionTelefono, IdentificacionCliente) "
                                        . "VALUES ('$ID','','$TELEFONO_10','','SG','$dateNow','$dateNow','TELEFONO_10','$Identification')");
                            }
                        }//fin del if que comprueba que se guarden los $datos
                        else {//sino ingresa el producto
                            echo $msj = '<font color=red>Dato <b>' . $Name . ' </b> no almacenado' . mysqli_error() . '</font><br/>';
                            $error += 1;
                        }
                    }//fin de if que comprueba que no haya en registro duplicado
                    else {
                        $duplicado += 1;
                        echo $duplicate = '<font color=#F3D305>El dato <b>' . $Name . '</b> está duplicado<br></font>';
                    }
                }
                echo "<b>La importación $nameExcel  tiene el siguiente detalle:</b><br/>";
                echo "<font color=green>" . $ingresado . " Datos almacenados con éxito<br/>";
                echo "<font color=#F3D305>" . $duplicado . " Datos duplicados<br/>";
                echo "<font color=red>" . $error . " Errores de almacenamiento<br/>";
                $vContactDetails = ejecutarConsulta("INSERT INTO contactimportdetail(VCC, ImportId, UpdateNum, "
                        . "Date, ImportUser, ValidContacts, NewContacts, UpdatedContacts, "
                        . "InvalidContacts, DuplicatesContacts) "
                        . "VALUES ('$vcc','$LastUpdate','1','$dateNow','$_SESSION[usu]','$ingresado','$ingresado',"
                        . "'0','$error','$duplicado')");

                $vContactImport = ejecutarConsulta("INSERT INTO contactimport(VCC, ID, DBProvider,"
                        . "Updates, Status, ServiceId) "
                        . "VALUES ('$vcc','$LastUpdate','$LastUpdate','1',"
                        . "case when $error = 0  then 'COMPLETE' else 'INCOMPLETE' end,'NULL')");
            }
        }
        break;

    case 'bancoPichinchaBroadcast':
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

            $sql = ejecutarConsulta("SELECT DISTINCT CampaignId 'Id' FROM campaignresultmanagement where CampaignId = '$campaignId'");
            $vCamp = mysqli_fetch_array($sql, MYSQLI_BOTH);
            $sql1 = ejecutarConsulta("SELECT DISTINCT lastupdate FROM contactimportcontact "
                    . "WHERE EXISTS (SELECT DISTINCT lastupdate FROM contactimportcontact c "
                    . "WHERE c.lastupdate = '$nameExcel')");
            $vImport = mysqli_fetch_array($sql1, MYSQLI_BOTH);
            if ($vCamp["Id"] == "") {
                echo("No exite la campaña seleccionada");
                //} else if ($vImport != "") {
                // echo("Nombre de importación duplicado");
            } else {
                while (($datos = fgetcsv($users, 100000, ";")) !== FALSE) {//Leo linea por linea del archivo hasta un maximo de 1000 caracteres por linea leida usando coma(,) o (;) como delimitador
                    $row++;
                    if ($row > 1) {
                        $linea[] = array(//Arreglo Bidimensional para guardar los datos de cada linea leida del archivo
                            'ContactAddress' => $datos[0],
                            'ResultLevel1' => $datos[1],
                            'ResultLevel2' => $datos[2],
                            'CODIGO_CAMPANIA' => $datos[3],
                            'NOMBRE_CAMPANIA' => $datos[4],
                            'AGENTE' => $datos[5],
                            'IDENTIFICACION' => $datos[6],
                            'NOMBRE_CLIENTE' => $datos[7],
                            'FECHA_GESTION' => $datos[8],
                            'HORA_INICIO' => $datos[9],
                            'HORA_FIN' => $datos[10],
                        );
                    }
                }
                fclose($users); //Cierra el archivo
                $ingresado = 0; //Variable que almacenara los insert exitosos
                $error = 0; //Variable que almacenara los errores en almacenamiento
                $duplicado = 0; //Variable que almacenara los registros duplicados
                foreach ($linea as $indice => $value) { //Iteracion el array para extraer cada uno de los valores almacenados en cada items
                    $count = ejecutarConsultaSimple("select UUID() 'id'");
                    $idG = $count['id'];
                    //Almacenamos info en contactimportcontact. Datos traidos del array para almacenar en la base
                    $ID = $idG;
                    $Name = $value["NOMBRE_CLIENTE"];
                    $Identification = $value["IDENTIFICACION"];
                    $Campaign = $campaignId;
                    $LastManagementResult = "";
                    $LastUpdate = $nameExcel;
                    $ContactAddress = $value['ContactAddress'];
                    $ResultLevel1 = $value['ResultLevel1'];
                    $ResultLevel2 = $value['ResultLevel2'];
                    $CODIGO_CAMPANIA = $value['CODIGO_CAMPANIA'];
                    $NOMBRE_CAMPANIA = $value['NOMBRE_CAMPANIA'];
                    $AGENTE = $value['AGENTE'];
                    $IDENTIFICACION = $value['IDENTIFICACION'];
                    $NOMBRE_CLIENTE = $value['NOMBRE_CLIENTE'];
                    $FECHA_GESTION = $value['FECHA_GESTION'];
                    $HORA_INICIO = $value['HORA_INICIO'];
                    $HORA_FIN = $value['HORA_FIN'];

                    $sql = ejecutarConsulta("select * from contactimportcontact where Id='$ID'"); //Consulta a la tabla
                    $num = mysqli_num_rows($sql); //Cuenta el numero de registros devueltos por la consulta
                    if ($num == 0) {//Si es == 0 inserto
                        if ($insert = ejecutarConsulta1("INSERT INTO broadcast(ContactId, ContactAddress, ImportId, CampaignId, ResultLevel1, ResultLevel2, CODIGO_CAMPANIA, NOMBRE_CAMPANIA, AGENTE, IDENTIFICACION, NOMBRE_CLIENTE, FECHA_GESTION, HORA_INICIO, HORA_FIN) VALUES "
                                . "('$ID', '$ContactAddress', '$LastUpdate', '$Campaign', '$ResultLevel1', '$ResultLevel2', '$CODIGO_CAMPANIA', '$NOMBRE_CAMPANIA', '$AGENTE', '$IDENTIFICACION','$NOMBRE_CLIENTE','$FECHA_GESTION','$HORA_INICIO', '$HORA_FIN')")) {
                            $msj = '<font color=green>Dato <b>' . $Name . '</b> Guardado</font><br/>';
                            $ingresado += 1;
                        }//fin del if que comprueba que se guarden los $datos
                        else {//sino ingresa el producto
                            echo $msj = '<font color=red>Dato <b>' . $Name . ' </b> no almacenado' . mysqli_error() . '</font><br/>';
                            $error += 1;
                        }
                    }//fin de if que comprueba que no haya en registro duplicado
                    else {
                        $duplicado += 1;
                        echo $duplicate = '<font color=#F3D305>El dato <b>' . $Name . '</b> está duplicado<br></font>';
                    }
                }
                echo "<b>La importación $nameExcel  tiene el siguiente detalle:</b><br/>";
                echo "<font color=green>" . $ingresado . " Datos almacenados con éxito<br/>";
                echo "<font color=#F3D305>" . $duplicado . " Datos duplicados<br/>";
                echo "<font color=red>" . $error . " Errores de almacenamiento<br/>";
                $vContactDetails = ejecutarConsulta("INSERT INTO contactimportdetail(VCC, ImportId, UpdateNum, "
                        . "Date, ImportUser, ValidContacts, NewContacts, UpdatedContacts, "
                        . "InvalidContacts, DuplicatesContacts) "
                        . "VALUES ('$vcc','$LastUpdate','1','$dateNow','$_SESSION[usu]','$ingresado','$ingresado',"
                        . "'0','$error','$duplicado')");

                $vContactImport = ejecutarConsulta("INSERT INTO contactimport(VCC, ID, DBProvider,"
                        . "Updates, Status, ServiceId) "
                        . "VALUES ('$vcc','$LastUpdate','$LastUpdate','1',"
                        . "case when $error = 0  then 'COMPLETE' else 'INCOMPLETE' end,'NULL')");
            }
        }
        break;

    case 'MonitoreoCalidad':
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

            $sql = ejecutarConsulta("SELECT DISTINCT CampaignId 'Id' FROM campaignresultmanagement where CampaignId = '$campaignId'");
            $vCamp = mysqli_fetch_array($sql, MYSQLI_BOTH);

                while (($datos = fgetcsv($users, 100000, ";")) !== FALSE) {//Leo linea por linea del archivo hasta un maximo de 1000 caracteres por linea leida usando coma(,) o (;) como delimitador
                    $row++;
                    if ($row > 1) {
                        $linea[] = array(//Arreglo Bidimensional para guardar los datos de cada linea leida del archivo
                            'FECHA_ATENCION' => $datos[0],
                            'ESTATUS' => $datos[1],
                            'REGION' => $datos[2],
                            'AGENCIA' => $datos[3],
                            'AREA' => $datos[4],
                            'SECCION' => $datos[5],
                            'TRANSACCION' => $datos[6],
                            'USUARIO' => $datos[7],
                            'IDENTIFICACION' => $datos[8],
                            'PRODUCTO' => $datos[9],
                            'CAMPANIA' => $datos[10],
                            'EVALUADOR' => $datos[11],
                            'FECHA_CALIFICACION' => $datos[12],
                            'ESTADO_MONITOREO' => $datos[13],
                            'CRITERIO' => $datos[14],
                            'TMA ' => $datos[15],
                            'SALUDO_1' => $datos[16],
                            'SALUDO_2' => $datos[17],
                            'SALUDO_3' => $datos[18],
                            'PRESENTACION_1' => $datos[19],
                            'PRESENTACION_2' => $datos[20],
                            'PRESENTACION_3' => $datos[21],
                            'CIERRE_1' => $datos[22],
                            'CIERRE_2' => $datos[23],
                            'CIERRE_3' => $datos[24],
                            'COMUNICACION_1' => $datos[25],
                            'COMUNICACION_2' => $datos[26],
                            'COMUNICACION_3' => $datos[27],
                            'COMUNICACION_4' => $datos[28],
                            'COMUNICACION_5' => $datos[29],
                            'ERRORES_CRITICOS_1' => $datos[30],
                            'ERRORES_CRITICOS_2' => $datos[31],
                            'ERRORES_CRITICOS_3' => $datos[32],
                            'ERRORES_CRITICOS_4' => $datos[33],
                            'ERRORES_CRITICOS_5' => $datos[34],
                            'ERRORES_CRITICOS_CUMPLIMIENTO_1' => $datos[35],
                            'ERRORES_CRITICOS_CUMPLIMIENTO_2' => $datos[36],
                            'ERRORES_CRITICOS_CUMPLIMIENTO_3' => $datos[37],
                            'ERRORES_CRITICOS_CUMPLIMIENTO_4' => $datos[38],
                            'ERRORES_CRITICOS_CUMPLIMIENTO_5' => $datos[39],
                            'MANEJO_GESTION' => $datos[40],
                            'MEJORAS' => $datos[41],
                            'Nota_ECUF' => $datos[42],
                            'Nota_ECN' => $datos[43],
                            'Nota_ENC' => $datos[44],
                            'TOTAL' => $datos[45],
                        );
                    }
                }
                fclose($users); //Cierra el archivo
                $ingresado = 0; //Variable que almacenara los insert exitosos
                $error = 0; //Variable que almacenara los errores en almacenamiento
                $duplicado = 0; //Variable que almacenara los registros duplicados
                foreach ($linea as $indice => $value) { //Iteracion el array para extraer cada uno de los valores almacenados en cada items
                    $LastUpdate = $nameExcel;
                    $FECHA_ATENCION = $value['FECHA_ATENCION'];
                    $ESTATUS = $value['ESTATUS'];
                    $REGION = $value['REGION'];
                    $AGENCIA = $value['AGENCIA'];
                    $AREA = $value['AREA'];
                    $SECCION = $value['SECCION'];
                    $TRANSACCION = $value['TRANSACCION'];
                    $USUARIO = $value['USUARIO'];
                    $IDENTIFICACION = $value['IDENTIFICACION'];
                    $PRODUCTO = $value['PRODUCTO'];
                    $CAMPANIA = $value['CAMPANIA'];
                    $EVALUADOR = $value['EVALUADOR'];
                    $FECHA_CALIFICACION = $value['FECHA_CALIFICACION'];
                    $ESTADO_MONITOREO = $value['ESTADO_MONITOREO'];
                    $CRITERIO = $value['CRITERIO'];
                    $TMA = $value['TMA '];
                    $SALUDO_1 = $value['SALUDO_1'];
                    $SALUDO_2 = $value['SALUDO_2'];
                    $SALUDO_3 = $value['SALUDO_3'];
                    $PRESENTACION_1 = $value['PRESENTACION_1'];
                    $PRESENTACION_2 = $value['PRESENTACION_2'];
                    $PRESENTACION_3 = $value['PRESENTACION_3'];
                    $CIERRE_1 = $value['CIERRE_1'];
                    $CIERRE_2 = $value['CIERRE_2'];
                    $CIERRE_3 = $value['CIERRE_3'];
                    $COMUNICACION_1 = $value['COMUNICACION_1'];
                    $COMUNICACION_2 = $value['COMUNICACION_2'];
                    $COMUNICACION_3 = $value['COMUNICACION_3'];
                    $COMUNICACION_4 = $value['COMUNICACION_4'];
                    $COMUNICACION_5 = $value['COMUNICACION_5'];
                    $ERRORES_CRITICOS_1 = $value['ERRORES_CRITICOS_1'];
                    $ERRORES_CRITICOS_2 = $value['ERRORES_CRITICOS_2'];
                    $ERRORES_CRITICOS_3 = $value['ERRORES_CRITICOS_3'];
                    $ERRORES_CRITICOS_4 = $value['ERRORES_CRITICOS_4'];
                    $ERRORES_CRITICOS_5 = $value['ERRORES_CRITICOS_5'];
                    $ERRORES_CRITICOS_CUMPLIMIENTO_1 = $value['ERRORES_CRITICOS_CUMPLIMIENTO_1'];
                    $ERRORES_CRITICOS_CUMPLIMIENTO_2 = $value['ERRORES_CRITICOS_CUMPLIMIENTO_2'];
                    $ERRORES_CRITICOS_CUMPLIMIENTO_3 = $value['ERRORES_CRITICOS_CUMPLIMIENTO_3'];
                    $ERRORES_CRITICOS_CUMPLIMIENTO_4 = $value['ERRORES_CRITICOS_CUMPLIMIENTO_4'];
                    $ERRORES_CRITICOS_CUMPLIMIENTO_5 = $value['ERRORES_CRITICOS_CUMPLIMIENTO_5'];
                    $MANEJO_GESTION = $value['MANEJO_GESTION'];
                    $MEJORAS = $value['MEJORAS'];
                    $Nota_ECUF = $value['Nota_ECUF'];
                    $Nota_ECN = $value['Nota_ECN'];
                    $Nota_ENC = $value['Nota_ENC'];
                    $TOTAL = $value['TOTAL'];
                    $num = 0;
                    
                    if ($num == 0) {//Si es == 0 inserto
                        if ($insert = ejecutarConsulta1("INSERT INTO MONITOREO.calificaciones(ImportId, Agent, FechaAtencion, Status, Identificacion, Producto, Campania, Region, Agencia, Area, Seccion, Transaccion, Evaluador, TmStmp, EstadoMonitoreo, Criterio, TMA, Saludo1, Saludo2, Saludo3, Presentacion1, Presentacion2, Presentacion3, Cierre1, Cierre2, Cierre3, Comunicacion1, Comunicacion2, Comunicacion3, Comunicacion4, Comunicacion5, ErroresCriticos1, ErroresCriticos2, ErroresCriticos3, ErroresCriticos4, ErroresCriticos5, ErroresCriticosCumplimiento1, ErroresCriticosCumplimiento2, ErroresCriticosCumplimiento3, ErroresCriticosCumplimiento4, ErroresCriticosCumplimiento5, ManejoGestion, Mejoras, Nota_ECUF, Nota_ECN, Nota_ENC, Total) VALUES  "
                                . "                             ('$LastUpdate', '$USUARIO', '$FECHA_ATENCION','$ESTATUS', '$IDENTIFICACION', '$PRODUCTO', '$CAMPANIA', '$REGION', '$AGENCIA', '$AREA', '$SECCION', '$TRANSACCION','$EVALUADOR','$FECHA_CALIFICACION','$ESTADO_MONITOREO','$CRITERIO','$TMA','$SALUDO_1','$SALUDO_2','$SALUDO_3','$PRESENTACION_1','$PRESENTACION_2','$PRESENTACION_3','$CIERRE_1','$CIERRE_2','$CIERRE_3','$COMUNICACION_1','$COMUNICACION_2','$COMUNICACION_3','$COMUNICACION_4','$COMUNICACION_5','$ERRORES_CRITICOS_1','$ERRORES_CRITICOS_2','$ERRORES_CRITICOS_3','$ERRORES_CRITICOS_4','$ERRORES_CRITICOS_5','$ERRORES_CRITICOS_CUMPLIMIENTO_1','$ERRORES_CRITICOS_CUMPLIMIENTO_2','$ERRORES_CRITICOS_CUMPLIMIENTO_3','$ERRORES_CRITICOS_CUMPLIMIENTO_4','$ERRORES_CRITICOS_CUMPLIMIENTO_5','$MANEJO_GESTION','$MEJORAS','$Nota_ECUF','$Nota_ECN','$Nota_ENC','$TOTAL')")) {
                            $msj = '<font color=green>Dato <b>' . $IDENTIFICACION . '</b> Guardado</font><br/>';
                            $ingresado += 1;
                        }//fin del if que comprueba que se guarden los $datos
                        else {//sino ingresa el producto
                            echo $msj = '<font color=red>Dato <b>' . $IDENTIFICACION . ' </b> no almacenado' . mysqli_error() . '</font><br/>';
                            $error += 1;
                        }
                    }//fin de if que comprueba que no haya en registro duplicado
                    else {
                        $duplicado += 1;
                        echo $duplicate = '<font color=#F3D305>El dato <b>' . $IDENTIFICACION . '</b> está duplicado<br></font>';
                    }
                }
                echo "<b>La importación $nameExcel  tiene el siguiente detalle:</b><br/>";
                echo "<font color=green>" . $ingresado . " Datos almacenados con éxito<br/>";
                echo "<font color=#F3D305>" . $duplicado . " Datos duplicados<br/>";
                echo "<font color=red>" . $error . " Errores de almacenamiento<br/>";
                
                $vContactDetails = ejecutarConsulta("INSERT INTO contactimportdetail(VCC, ImportId, UpdateNum, "
                        . "Date, ImportUser, ValidContacts, NewContacts, UpdatedContacts, "
                        . "InvalidContacts, DuplicatesContacts) "
                        . "VALUES ('$vcc','$LastUpdate','1','$dateNow','$_SESSION[usu]','$ingresado','$ingresado',"
                        . "'0','$error','$duplicado')");

                $vContactImport = ejecutarConsulta("INSERT INTO contactimport(VCC, ID, DBProvider,"
                        . "Updates, Status, ServiceId) "
                        . "VALUES ('$vcc','$LastUpdate','$LastUpdate','1',"
                        . "case when $error = 0  then 'COMPLETE' else 'INCOMPLETE' end,'NULL')");
            }
        break;
}
?>