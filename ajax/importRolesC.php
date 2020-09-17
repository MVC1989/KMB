<?php

session_start();
require '../config/connection.php';
date_default_timezone_set("America/Lima");
$date = date('Y-m-d H:i:s');
$userId = $_SESSION['usu'];
$Id = isset($_POST["Id"]) ? LimpiarCadena8($_POST["Id"]) : ""; //Dato estraido de la funcion mostrar_uno js
$Identificacion = $_SESSION['Identification'];

$IDC = isset($_POST["IDC"]) ? LimpiarCadena8($_POST["IDC"]) : "";
$leyenda = isset($_POST["leyenda"]) ? LimpiarCadena8($_POST["leyenda"]) : "";
$acepta = isset($_POST["acepta"]) ? LimpiarCadena8($_POST["acepta"]) : "";

switch ($_GET["action"]) {
    case 'showAll':
        $campaign = isset($_POST['campaign']) ? LimpiarCadena($_POST["campaign"]) : "";
        $base = isset($_POST['base']) ? LimpiarCadena($_POST["base"]) : "";
        $respuesta = ejecutarConsulta8("SELECT Id, MES, NOMBRE_EMPLEADO, FECHA_INGRESO, CEDULA, DIAS, TOTAL_INGRESOS,"
                . " SUELDO, TOTAL_EGRESOS, TOTAL_A_PAGAR, TIPO_EMPLEADO, CONCAT(MES,' ',ANIO) AS PERIODO FROM roles ");
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            $datos[] = array(/* llena los resultados con los datos */
                "0" => $registrar->Id, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                "1" => $registrar->PERIODO,
                "2" => $registrar->NOMBRE_EMPLEADO,
                "3" => $registrar->FECHA_INGRESO,
                "4" => $registrar->CEDULA,
                "5" => $registrar->DIAS,
                "6" => $registrar->SUELDO,
                "7" => $registrar->TOTAL_INGRESOS,
                "8" => $registrar->TOTAL_EGRESOS,
                "9" => $registrar->TOTAL_A_PAGAR,
                "10" => $registrar->TIPO_EMPLEADO,
                '<center><li title="Ver" class="fa fa-eye" style="color: purple;" onclick="mostrar_uno(' . $registrar->Id . ')"></i></center>',
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

    case 'selectAll':
        $campaign = isset($_POST['campaign']) ? LimpiarCadena($_POST["campaign"]) : "";
        $base = isset($_POST['base']) ? LimpiarCadena($_POST["base"]) : "";
        $respuesta = ejecutarConsulta8("SELECT Id, MES, NOMBRE_EMPLEADO, FECHA_INGRESO, CEDULA, DIAS, TOTAL_INGRESOS,"
                . " SUELDO, TOTAL_EGRESOS, TOTAL_A_PAGAR, TIPO_EMPLEADO, CONCAT(MES,' ',ANIO) AS PERIODO FROM roles"
                . " where CEDULA = '$Identificacion' ");
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            $datos[] = array(/* llena los resultados con los datos */
                "0" => $registrar->Id, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                "1" => $registrar->PERIODO,
                "2" => $registrar->NOMBRE_EMPLEADO,
                "3" => $registrar->FECHA_INGRESO,
                "4" => $registrar->CEDULA,
                "5" => $registrar->DIAS,
                "6" => $registrar->SUELDO,
                "7" => $registrar->TOTAL_INGRESOS,
                "8" => $registrar->TOTAL_EGRESOS,
                "9" => $registrar->TOTAL_A_PAGAR,
                "10" => $registrar->TIPO_EMPLEADO,
                '<center><li title="Ver" class="fa fa-eye" style="color: purple;" onclick="mostrar_uno(' . $registrar->Id . ')"></i></center>',
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
        $sql = ejecutarConsultaSimple8("SELECT * FROM roles where id = '$Id'");
        echo json_encode($sql); /* envia los datos a mostrar mediante json */
        break;

    case 'administration':
        $import = isset($_POST["base"]) ? LimpiarCadena($_POST["base"]) : "";
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

    case 'cargarRoles':
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

            while (($datos = fgetcsv($users, 100000, ";")) !== FALSE) {//Leo linea por linea del archivo hasta un maximo de 1000 caracteres por linea leida usando coma(,) o (;) como delimitador
                $row++;
                if ($row > 1) {
                    $linea[] = array(//Arreglo Bidimensional para guardar los datos de cada linea leida del archivo
                        'NOMBRE_EMPLEADO' => $datos[0],
                        'FECHA_INGRESO' => $datos[1],
                        'CEDULA' => $datos[2],
                        'DIAS' => $datos[3],
                        'SUELDO' => $datos[4],
                        'HORAS_EXTRAS' => $datos[5],
                        'SUBTOTAL_INGRESOS' => $datos[6],
                        'FONDOS_RESERVA' => $datos[7],
                        'OTROS_INGRESOS' => $datos[8],
                        'TOTAL_INGRESOS' => $datos[9],
                        'APORTE_PERSONAL' => $datos[10],
                        'PRESTAMOS_Q_IESS' => $datos[11],
                        'PRESTAMOS_H_IESS' => $datos[12],
                        'PRESTAMO_OFICINA' => $datos[13],
                        'ATRASOS' => $datos[14],
                        'FALTAS' => $datos[15],
                        'TOTAL_EGRESOS' => $datos[16],
                        'TOTAL_A_PAGAR' => $datos[17],
                        'DECIMO_TERCER' => $datos[18],
                        'DECIMO_CUARTO' => $datos[19],
                        'APORTE_PATRONAL' => $datos[20],
                        'IMPUESTO_RENTA' => $datos[21],
                        'COMISION' => $datos[22],
                        'TIPO_EMPLEADO' => $datos[23],
                        'CUENTA' => $datos[24],
                        'FORMA_PAGO' => $datos[25],
                        'OTROS_DESCUENTOS' => $datos[26],
                        'MES' => $datos[27],
                        'ANIO' => $datos[28],
                        'CARGO' => $datos[29],
                    );
                }
            }
            fclose($users); //Cierra el archivo
            $ingresado = 0; //Variable que almacenara los insert exitosos
            $error = 0; //Variable que almacenara los errores en almacenamiento
            $duplicado = 0; //Variable que almacenara los registros duplicados
            foreach ($linea as $indice => $value) { //Iteracion el array para extraer cada uno de los valores almacenados en cada items
                $LastUpdate = $nameExcel;
                $NOMBRE_EMPLEADO = $value['NOMBRE_EMPLEADO'];
                $FECHA_INGRESO = $value['FECHA_INGRESO'];
                $CEDULA = $value['CEDULA'];
                $DIAS = $value['DIAS'];
                $SUELDO = $value['SUELDO'];
                $HORAS_EXTRAS = $value['HORAS_EXTRAS'];
                $SUBTOTAL_INGRESOS = $value['SUBTOTAL_INGRESOS'];
                $FONDOS_RESERVA = $value['FONDOS_RESERVA'];
                $OTROS_INGRESOS = $value['OTROS_INGRESOS'];
                $TOTAL_INGRESOS = $value['TOTAL_INGRESOS'];
                $APORTE_PERSONAL = $value['APORTE_PERSONAL'];
                $PRESTAMOS_Q_IESS = $value['PRESTAMOS_Q_IESS'];
                $PRESTAMOS_H_IESS = $value['PRESTAMOS_H_IESS'];
                $PRESTAMO_OFICINA = $value['PRESTAMO_OFICINA'];
                $ATRASOS = $value['ATRASOS'];
                $FALTAS = $value['FALTAS'];
                $TOTAL_EGRESOS = $value['TOTAL_EGRESOS'];
                $TOTAL_A_PAGAR = $value['TOTAL_A_PAGAR'];
                $DECIMO_TERCER = $value['DECIMO_TERCER'];
                $DECIMO_CUARTO = $value['DECIMO_CUARTO'];
                $APORTE_PATRONAL = $value['APORTE_PATRONAL'];
                $IMPUESTO_RENTA = $value['IMPUESTO_RENTA'];
                $COMISION = $value['COMISION'];
                $TIPO_EMPLEADO = $value['TIPO_EMPLEADO'];
                $CUENTA = $value['CUENTA'];
                $FORMA_PAGO = $value['FORMA_PAGO'];
                $OTROS_DESCUENTOS = $value['OTROS_DESCUENTOS'];
                $MES = $value['MES'];
                $ANIO = $value['ANIO'];
                $CARGO = $value['CARGO'];
                
                if ($insert = ejecutarConsulta8("INSERT INTO roles(NOMBRE_IMPORTACION, USUARIO_IMPORTACION, FECHA_IMPORTACION, NOMBRE_EMPLEADO, FECHA_INGRESO, CEDULA, DIAS, SUELDO, HORAS_EXTRAS, SUBTOTAL_INGRESOS, FONDOS_RESERVA, OTROS_INGRESOS, TOTAL_INGRESOS, APORTE_PERSONAL, PRESTAMOS_Q_IESS, PRESTAMOS_H_IESS,PRESTAMO_OFICINA, ATRASOS, FALTAS, TOTAL_EGRESOS, TOTAL_A_PAGAR, DECIMO_TERCER_SUELDO, DECIMO_CUARTO_SUELDO, APORTE_PATRONAL, IMPUESTO_RENTA, COMISION, TIPO_EMPLEADO, CUENTA, FORMA_PAGO, OTROS_DESCUENTOS, MES, ANIO, CARGO) "
                        . " VALUES ('$LastUpdate','$userId','$date','$NOMBRE_EMPLEADO','$FECHA_INGRESO','$CEDULA','$DIAS','$SUELDO','$HORAS_EXTRAS','$SUBTOTAL_INGRESOS','$FONDOS_RESERVA', '$OTROS_INGRESOS', '$TOTAL_INGRESOS','$APORTE_PERSONAL','$PRESTAMOS_Q_IESS','$PRESTAMOS_H_IESS','$PRESTAMO_OFICINA','$ATRASOS','$FALTAS','$TOTAL_EGRESOS','$TOTAL_A_PAGAR','$DECIMO_TERCER','$DECIMO_CUARTO','$APORTE_PATRONAL','$IMPUESTO_RENTA','$COMISION','$TIPO_EMPLEADO','$CUENTA','$FORMA_PAGO','$OTROS_DESCUENTOS','$MES','$ANIO','$CARGO')")) {
                    $msj = '<font color=green>Dato <b>' . $NOMBRE_EMPLEADO . '</b> Guardado</font><br/>';
                    $ingresado += 1;
                }//fin del if que comprueba que se guarden los $datos
                else {//sino ingresa el REGISTRO
                    echo $msj = '<font color=red>Dato <b>' . $NOMBRE_EMPLEADO . ' </b> no almacenado' . mysqli_error() . '</font><br/>';
                    $error += 1;
                }
            }//fin de if que comprueba que no haya en registro duplicado
            echo "<b>La importación $nameExcel  tiene el siguiente detalle:</b><br/>";
            echo "<font color=green>" . $ingresado . " Datos almacenados con éxito<br/>";
            echo "<font color=#F3D305>" . $duplicado . " Datos duplicados<br/>";
            echo "<font color=red>" . $error . " Errores de almacenamiento<br/>";
        }
        break;

    case 'save':
        $validate = ejecutarConsulta8("select Id from roles where id = '$IDC'");
        $valid = mysqli_fetch_array($validate, MYSQLI_BOTH);
        $numRowC = $validate->num_rows;
        echo $numRowC;
        if ($numRowC != 0 || $numRowC != '') {
            $respuesta = ejecutarConsulta8("UPDATE ROLES SET ACEPTA_ROL = '$acepta', FECHA_ACEPTACION = '$date', LEYENDA = '$leyenda' where id = '$IDC'");
            echo $respuesta ? "Rol almacenado" : "Error: no se pudo almacenar";
        } else {
            echo "Error: usuario no se pudo actualizar";
        }
        break;
}
?>