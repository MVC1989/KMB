<?php
    require_once 'global.php';
    
    $conexion = new mysqli(DB_HOST, USER_DB, PASSWORD_DB, DB_NAME);
    mysqli_query( $conexion, 'SET NAMES "'.DB_ENCODE.'"');
    
    $conexion2 = new mysqli(DB_HOST1, DB_USER1, DB_PASS1, DB_NAME1);
    mysqli_query( $conexion2, 'SET NAMES "'.DB_ENCODE1.'"');
    
    $conexion3 = new mysqli(DB_HOST2, DB_USER2, DB_PASS2, DB_NAME2);
    mysqli_query( $conexion3, 'SET NAMES "'.DB_ENCODE2.'"');
    
    $conexion4 = new mysqli(DB_HOST3, DB_USER3, DB_PASS3, DB_NAME3);
    mysqli_query( $conexion4, 'SET NAMES "'.DB_ENCODE3.'"');
    
    $conexion5 = new mysqli(DB_HOST4, DB_USER4, DB_PASS4, DB_NAME4);
    mysqli_query( $conexion5, 'SET NAMES "'.DB_ENCODE4.'"');
    
    $conexion6 = new mysqli(DB_HOST5, DB_USER5, DB_PASS5, DB_NAME5);
    mysqli_query( $conexion6, 'SET NAMES "'.DB_ENCODE5.'"');
    
    $conexion7 = new mysqli(DB_HOST6, DB_USER6, DB_PASS6, DB_NAME6);
    mysqli_query( $conexion7, 'SET NAMES "'.DB_ENCODE6.'"');
    
    $conexion8 = new mysqli(DB_HOST7, DB_USER7, DB_PASS7, DB_NAME7);
    mysqli_query( $conexion8, 'SET NAMES "'.DB_ENCODE7.'"');
    
    $conexion9 = new mysqli(DB_HOST8, DB_USER8, DB_PASS8, DB_NAME8);
    mysqli_query( $conexion9, 'SET NAMES "'.DB_ENCODE8.'"');
    
    $conexion10 = new mysqli(DB_HOST9, DB_USER9, DB_PASS9, DB_NAME9);
    mysqli_query( $conexion10, 'SET NAMES "'.DB_ENCODE9.'"');
    
    $conexion11 = new mysqli(DB_HOST10, DB_USER10, DB_PASS10, DB_NAME10);
    mysqli_query( $conexion11, 'SET NAMES "'.DB_ENCODE10.'"');
    
    $conexion12 = new mysqli(DB_HOST11, DB_USER11, DB_PASS11, DB_NAME11);
    mysqli_query( $conexion12, 'SET NAMES "'.DB_ENCODE11.'"');
    
    $conexion13 = new mysqli(DB_HOST12, DB_USER12, DB_PASS12, DB_NAME12);
    mysqli_query( $conexion13, 'SET NAMES "'.DB_ENCODE12.'"');
    
    $conexion14 = new mysqli(DB_HOST13, DB_USER13, DB_PASS13, DB_NAME13);
    mysqli_query( $conexion14, 'SET NAMES "'.DB_ENCODE13.'"');
    
    $conexion15 = new mysqli(DB_HOST14, DB_USER14, DB_PASS14, DB_NAME14);
    mysqli_query( $conexion15, 'SET NAMES "'.DB_ENCODE14.'"');
  
    if (mysqli_connect_errno()) {
        printf("Error de conexión: ", mysqli_connect_error());
        exit();
    }
    
    if (!function_exists('ejecutarConsulta')) { /* admin */
        function ejecutarConsulta($sql) {
            global $conexion;
            $query = $conexion->query($sql);
            return $query;
        }

        /*
            Metodo que puede regresar un arreglo de objetos JSON
        */
        function ejecutarJson($sql){
            global $conexion;
            mysqli_set_charset($conexion,"utf8");
            $res_query = mysqli_query($conexion, $sql);   
            $resultado = array();
            while ($producto = $res_query->fetch_assoc()) {
                $resultado[]=$producto;
            }
            if(!empty($resultado))
                return json_encode($resultado,JSON_UNESCAPED_UNICODE);
            else{
                $resultado[]="500";
                return json_encode($resultado,JSON_UNESCAPED_UNICODE);
                
            }
        }

        function ejecutarConsultaSimple($sql) {
            global $conexion;
            $query = $conexion->query($sql);
            $row = $query->fetch_assoc();
            return $row;
        }
        
        function ejecutarConsultaRetornarID($sql) {
            global $conexion;
            $query = $conexion->query($sql);
            return $conexion->insert_id;
        }
        
        function LimpiarCadena($str) {
            global $conexion;
            $str = mysqli_real_escape_string($conexion,trim($str));
            return htmlspecialchars($str);
        }
    }
    
    if (!function_exists('ejecutarConsulta1')) { /* admin */
        function ejecutarConsulta1($sql) {
            global $conexion2;
            $query = $conexion2->query($sql);
            return $query;
        }

        /*
            Metodo que puede regresar un arreglo de objetos JSON
        */
        function ejecutarJson1($sql){
            global $conexion2;
            mysqli_set_charset($conexion2,"utf8");
            $res_query = mysqli_query($conexion2, $sql);   
            $resultado = array();
            while ($producto = $res_query->fetch_assoc()) {
                $resultado[]=$producto;
            }
            if(!empty($resultado))
                return json_encode($resultado,JSON_UNESCAPED_UNICODE);
            else{
                $resultado[]="500";
                return json_encode($resultado,JSON_UNESCAPED_UNICODE);
                
            }
        }

        function ejecutarConsultaSimple1($sql) {
            global $conexion2;
            $query = $conexion2->query($sql);
            $row = $query->fetch_assoc();
            return $row;
        }
        
        function ejecutarConsultaRetornarID1($sql) {
            global $conexion2;
            $query = $conexion2->query($sql);
            return $conexion2->insert_id;
        }
        
        function LimpiarCadena1($str) {
            global $conexion2;
            $str = mysqli_real_escape_string($conexion2,trim($str));
            return htmlspecialchars($str);
        }
    }
    
    if (!function_exists('ejecutarConsulta2')) { /* admin */
        function ejecutarConsulta2($sql) {
            global $conexion3;
            $query = $conexion3->query($sql);
            return $query;
        }

        /*
            Metodo que puede regresar un arreglo de objetos JSON
        */
        function ejecutarJson2($sql){
            global $conexion3;
            mysqli_set_charset($conexion3,"utf8");
            $res_query = mysqli_query($conexion3, $sql);   
            $resultado = array();
            while ($producto = $res_query->fetch_assoc()) {
                $resultado[]=$producto;
            }
            if(!empty($resultado))
                return json_encode($resultado,JSON_UNESCAPED_UNICODE);
            else{
                $resultado[]="500";
                return json_encode($resultado,JSON_UNESCAPED_UNICODE);
                
            }
        }

        function ejecutarConsultaSimple2($sql) {
            global $conexion3;
            $query = $conexion3->query($sql);
            $row = $query->fetch_assoc();
            return $row;
        }
        
        function ejecutarConsultaRetornarID2($sql) {
            global $conexion3;
            $query = $conexion3->query($sql);
            return $conexion3->insert_id;
        }
        
        function LimpiarCadena2($str) {
            global $conexion3;
            $str = mysqli_real_escape_string($conexion3,trim($str));
            return htmlspecialchars($str);
        }
    }
    
    if (!function_exists('ejecutarConsulta3')) { /* admin */
        function ejecutarConsulta3($sql) {
            global $conexion4;
            $query = $conexion4->query($sql);
            return $query;
        }

        /*
            Metodo que puede regresar un arreglo de objetos JSON
        */
        function ejecutarJson3($sql){
            global $conexion4;
            mysqli_set_charset($conexion4,"utf8");
            $res_query = mysqli_query($conexion4, $sql);   
            $resultado = array();
            while ($producto = $res_query->fetch_assoc()) {
                $resultado[]=$producto;
            }
            if(!empty($resultado))
                return json_encode($resultado,JSON_UNESCAPED_UNICODE);
            else{
                $resultado[]="500";
                return json_encode($resultado,JSON_UNESCAPED_UNICODE);
                
            }
        }

        function ejecutarConsultaSimple3($sql) {
            global $conexion4;
            $query = $conexion4->query($sql);
            $row = $query->fetch_assoc();
            return $row;
        }
        
        function ejecutarConsultaRetornarID3($sql) {
            global $conexion4;
            $query = $conexion4->query($sql);
            return $conexion4->insert_id;
        }
        
        function LimpiarCadena3($str) {
            global $conexion4;
            $str = mysqli_real_escape_string($conexion4,trim($str));
            return htmlspecialchars($str);
        }
    }
    
    if (!function_exists('ejecutarConsulta4')) { /* admin */
        function ejecutarConsulta4($sql) {
            global $conexion5;
            $query = $conexion5->query($sql);
            return $query;
        }

        /*
            Metodo que puede regresar un arreglo de objetos JSON
        */
        function ejecutarJson4($sql){
            global $conexion5;
            mysqli_set_charset($conexion5,"utf8");
            $res_query = mysqli_query($conexion5, $sql);   
            $resultado = array();
            while ($producto = $res_query->fetch_assoc()) {
                $resultado[]=$producto;
            }
            if(!empty($resultado))
                return json_encode($resultado,JSON_UNESCAPED_UNICODE);
            else{
                $resultado[]="500";
                return json_encode($resultado,JSON_UNESCAPED_UNICODE);
                
            }
        }
        
        function ejecutarConsultaSimple4($sql) {
            global $conexion5;
            $query = $conexion5->query($sql);
            $row = $query->fetch_assoc();
            return $row;
        }
        
        function ejecutarConsultaRetornarID4($sql) {
            global $conexion5;
            $query = $conexion5->query($sql);
            return $conexion5->insert_id;
        }
        
        function LimpiarCadena4($str) {
            global $conexion5;
            $str = mysqli_real_escape_string($conexion5,trim($str));
            return htmlspecialchars($str);
        }
    }
    
    if (!function_exists('ejecutarConsulta5')) { /* admin */
        function ejecutarConsulta5($sql) {
            global $conexion6;
            $query = $conexion6->query($sql);
            return $query;
        }

        /*
            Metodo que puede regresar un arreglo de objetos JSON
        */
        function ejecutarJson5($sql){
            global $conexion6;
            mysqli_set_charset($conexion6,"utf8");
            $res_query = mysqli_query($conexion6, $sql);   
            $resultado = array();
            while ($producto = $res_query->fetch_assoc()) {
                $resultado[]=$producto;
            }
            if(!empty($resultado))
                return json_encode($resultado,JSON_UNESCAPED_UNICODE);
            else{
                $resultado[]="500";
                return json_encode($resultado,JSON_UNESCAPED_UNICODE);
                
            }
        }

        function ejecutarConsultaSimple5($sql) {
            global $conexion6;
            $query = $conexion6->query($sql);
            $row = $query->fetch_assoc();
            return $row;
        }
        
        function ejecutarConsultaRetornarID5($sql) {
            global $conexion6;
            $query = $conexion6->query($sql);
            return $conexion6->insert_id;
        }
        
        function LimpiarCadena5($str) {
            global $conexion6;
            $str = mysqli_real_escape_string($conexion6,trim($str));
            return htmlspecialchars($str);
        }
    }
    
    if (!function_exists('ejecutarConsulta6')) { /* admin */
        function ejecutarConsulta6($sql) {
            global $conexion7;
            $query = $conexion7->query($sql);
            return $query;
        }

        /*
            Metodo que puede regresar un arreglo de objetos JSON
        */
        function ejecutarJson6($sql){
            global $conexion7;
            mysqli_set_charset($conexion7,"utf8");
            $res_query = mysqli_query($conexion7, $sql);   
            $resultado = array();
            while ($producto = $res_query->fetch_assoc()) {
                $resultado[]=$producto;
            }
            if(!empty($resultado))
                return json_encode($resultado,JSON_UNESCAPED_UNICODE);
            else{
                $resultado[]="500";
                return json_encode($resultado,JSON_UNESCAPED_UNICODE);
                
            }
        }

        function ejecutarConsultaSimple6($sql) {
            global $conexion7;
            $query = $conexion7->query($sql);
            $row = $query->fetch_assoc();
            return $row;
        }
        
        function ejecutarConsultaRetornarID6($sql) {
            global $conexion7;
            $query = $conexion7->query($sql);
            return $conexion7->insert_id;
        }
        
        function LimpiarCadena6($str) {
            global $conexion7;
            $str = mysqli_real_escape_string($conexion7,trim($str));
            return htmlspecialchars($str);
        }
    }
    
    if (!function_exists('ejecutarConsulta7')) { /* admin */
        function ejecutarConsulta7($sql) {
            global $conexion8;
            $query = $conexion8->query($sql);
            return $query;
        }

        /*
            Metodo que puede regresar un arreglo de objetos JSON
        */
        function ejecutarJson7($sql){
            global $conexion8;
            mysqli_set_charset($conexion8,"utf8");
            $res_query = mysqli_query($conexion8, $sql);   
            $resultado = array();
            while ($producto = $res_query->fetch_assoc()) {
                $resultado[]=$producto;
            }
            if(!empty($resultado))
                return json_encode($resultado,JSON_UNESCAPED_UNICODE);
            else{
                $resultado[]="500";
                return json_encode($resultado,JSON_UNESCAPED_UNICODE);
                
            }
        }

        function ejecutarConsultaSimple7($sql) {
            global $conexion8;
            $query = $conexion8->query($sql);
            $row = $query->fetch_assoc();
            return $row;
        }
        
        function ejecutarConsultaRetornarID7($sql) {
            global $conexion8;
            $query = $conexion8->query($sql);
            return $conexion8->insert_id;
        }
        
        function LimpiarCadena7($str) {
            global $conexion8;
            $str = mysqli_real_escape_string($conexion8,trim($str));
            return htmlspecialchars($str);
        }
    }
    
    if (!function_exists('ejecutarConsulta8')) { /* admin */
        function ejecutarConsulta8($sql) {
            global $conexion9;
            $query = $conexion9->query($sql);
            return $query;
        }

        /*
            Metodo que puede regresar un arreglo de objetos JSON
        */
        function ejecutarJson8($sql){
            global $conexion9;
            mysqli_set_charset($conexion9,"utf8");
            $res_query = mysqli_query($conexion9, $sql);   
            $resultado = array();
            while ($producto = $res_query->fetch_assoc()) {
                $resultado[]=$producto;
            }
            if(!empty($resultado))
                return json_encode($resultado,JSON_UNESCAPED_UNICODE);
            else{
                $resultado[]="500";
                return json_encode($resultado,JSON_UNESCAPED_UNICODE);
                
            }
        }

        function ejecutarConsultaSimple8($sql) {
            global $conexion9;
            $query = $conexion9->query($sql);
            $row = $query->fetch_assoc();
            return $row;
        }
        
        function ejecutarConsultaRetornarID8($sql) {
            global $conexion9;
            $query = $conexion9->query($sql);
            return $conexion9->insert_id;
        }
        
        function LimpiarCadena8($str) {
            global $conexion9;
            $str = mysqli_real_escape_string($conexion9,trim($str));
            return htmlspecialchars($str);
        }
    }
    
    if (!function_exists('ejecutarConsulta9')) { /* admin */
        function ejecutarConsulta9($sql) {
            global $conexion10;
            $query = $conexion10->query($sql);
            return $query;
        }

        /*
            Metodo que puede regresar un arreglo de objetos JSON
        */
        function ejecutarJson9($sql){
            global $conexion10;
            mysqli_set_charset($conexion10,"utf8");
            $res_query = mysqli_query($conexion10, $sql);   
            $resultado = array();
            while ($producto = $res_query->fetch_assoc()) {
                $resultado[]=$producto;
            }
            if(!empty($resultado))
                return json_encode($resultado,JSON_UNESCAPED_UNICODE);
            else{
                $resultado[]="500";
                return json_encode($resultado,JSON_UNESCAPED_UNICODE);
                
            }
        }

        function ejecutarConsultaSimple9($sql) {
            global $conexion10;
            $query = $conexion10->query($sql);
            $row = $query->fetch_assoc();
            return $row;
        }
        
        function ejecutarConsultaRetornarID9($sql) {
            global $conexion10;
            $query = $conexion10->query($sql);
            return $conexion10->insert_id;
        }
        
        function LimpiarCadena9($str) {
            global $conexion10;
            $str = mysqli_real_escape_string($conexion10,trim($str));
            return htmlspecialchars($str);
        }
    }
    
    if (!function_exists('ejecutarConsulta10')) { /* admin */
        function ejecutarConsulta10($sql) {
            global $conexion11;
            $query = $conexion11->query($sql);
            return $query;
        }

        /*
            Metodo que puede regresar un arreglo de objetos JSON
        */
        function ejecutarJson10($sql){
            global $conexion11;
            mysqli_set_charset($conexion11,"utf8");
            $res_query = mysqli_query($conexion11, $sql);   
            $resultado = array();
            while ($producto = $res_query->fetch_assoc()) {
                $resultado[]=$producto;
            }
            if(!empty($resultado))
                return json_encode($resultado,JSON_UNESCAPED_UNICODE);
            else{
                $resultado[]="500";
                return json_encode($resultado,JSON_UNESCAPED_UNICODE);
                
            }
        }

        function ejecutarConsultaSimple10($sql) {
            global $conexion11;
            $query = $conexion11->query($sql);
            $row = $query->fetch_assoc();
            return $row;
        }
        
        function ejecutarConsultaRetornarID10($sql) {
            global $conexion11;
            $query = $conexion11->query($sql);
            return $conexion11->insert_id;
        }
        
        function LimpiarCadena10($str) {
            global $conexion11;
            $str = mysqli_real_escape_string($conexion11,trim($str));
            return htmlspecialchars($str);
        }
    }
    
    if (!function_exists('ejecutarConsulta11')) { /* admin */
        function ejecutarConsulta11($sql) {
            global $conexion12;
            $query = $conexion12->query($sql);
            return $query;
        }

        /*
            Metodo que puede regresar un arreglo de objetos JSON
        */
        function ejecutarJson11($sql){
            global $conexion12;
            mysqli_set_charset($conexion12,"utf8");
            $res_query = mysqli_query($conexion12, $sql);   
            $resultado = array();
            while ($producto = $res_query->fetch_assoc()) {
                $resultado[]=$producto;
            }
            if(!empty($resultado))
                return json_encode($resultado,JSON_UNESCAPED_UNICODE);
            else{
                $resultado[]="500";
                return json_encode($resultado,JSON_UNESCAPED_UNICODE);
                
            }
        }

        function ejecutarConsultaSimple11($sql) {
            global $conexion12;
            $query = $conexion12->query($sql);
            $row = $query->fetch_assoc();
            return $row;
        }
        
        function ejecutarConsultaRetornarID11($sql) {
            global $conexion12;
            $query = $conexion12->query($sql);
            return $conexion12->insert_id;
        }
        
        function LimpiarCadena11($str) {
            global $conexion12;
            $str = mysqli_real_escape_string($conexion12,trim($str));
            return htmlspecialchars($str);
        }
    }
    
    if (!function_exists('ejecutarConsulta12')) { /* admin */
        function ejecutarConsulta12($sql) {
            global $conexion13;
            $query = $conexion13->query($sql);
            return $query;
        }

        /*
            Metodo que puede regresar un arreglo de objetos JSON
        */
        function ejecutarJson12($sql){
            global $conexion13;
            mysqli_set_charset($conexion13,"utf8");
            $res_query = mysqli_query($conexion13, $sql);   
            $resultado = array();
            while ($producto = $res_query->fetch_assoc()) {
                $resultado[]=$producto;
            }
            if(!empty($resultado))
                return json_encode($resultado,JSON_UNESCAPED_UNICODE);
            else{
                $resultado[]="500";
                return json_encode($resultado,JSON_UNESCAPED_UNICODE);
                
            }
        }

        function ejecutarConsultaSimple12($sql) {
            global $conexion13;
            $query = $conexion13->query($sql);
            $row = $query->fetch_assoc();
            return $row;
        }
        
        function ejecutarConsultaRetornarID12($sql) {
            global $conexion13;
            $query = $conexion13->query($sql);
            return $conexion13->insert_id;
        }
        
        function LimpiarCadena12($str) {
            global $conexion13;
            $str = mysqli_real_escape_string($conexion13,trim($str));
            return htmlspecialchars($str);
        }
    }
    
    if (!function_exists('ejecutarConsulta13')) { /* admin */
        function ejecutarConsulta13($sql) {
            global $conexion14;
            $query = $conexion14->query($sql);
            return $query;
        }

        /*
            Metodo que puede regresar un arreglo de objetos JSON
        */
        function ejecutarJson13($sql){
            global $conexion14;
            mysqli_set_charset($conexion14,"utf8");
            $res_query = mysqli_query($conexion14, $sql);   
            $resultado = array();
            while ($producto = $res_query->fetch_assoc()) {
                $resultado[]=$producto;
            }
            if(!empty($resultado))
                return json_encode($resultado,JSON_UNESCAPED_UNICODE);
            else{
                $resultado[]="500";
                return json_encode($resultado,JSON_UNESCAPED_UNICODE);
                
            }
        }

        function ejecutarConsultaSimple13($sql) {
            global $conexion14;
            $query = $conexion14->query($sql);
            $row = $query->fetch_assoc();
            return $row;
        }
        
        function ejecutarConsultaRetornarID13($sql) {
            global $conexion14;
            $query = $conexion14->query($sql);
            return $conexion14->insert_id;
        }
        
        function LimpiarCadena13($str) {
            global $conexion14;
            $str = mysqli_real_escape_string($conexion14,trim($str));
            return htmlspecialchars($str);
        }
    }
    
    if (!function_exists('ejecutarConsulta14')) { /* admin */
        function ejecutarConsulta14($sql) {
            global $conexion15;
            $query = $conexion15->query($sql);
            return $query;
        }

        /*
            Metodo que puede regresar un arreglo de objetos JSON
        */
        function ejecutarJson14($sql){
            global $conexion15;
            mysqli_set_charset($conexion15,"utf8");
            $res_query = mysqli_query($conexion15, $sql);   
            $resultado = array();
            while ($producto = $res_query->fetch_assoc()) {
                $resultado[]=$producto;
            }
            if(!empty($resultado))
                return json_encode($resultado,JSON_UNESCAPED_UNICODE);
            else{
                $resultado[]="500";
                return json_encode($resultado,JSON_UNESCAPED_UNICODE);
                
            }
        }

        function ejecutarConsultaSimple14($sql) {
            global $conexion15;
            $query = $conexion15->query($sql);
            $row = $query->fetch_assoc();
            return $row;
        }
        
        function ejecutarConsultaRetornarID14($sql) {
            global $conexion15;
            $query = $conexion15->query($sql);
            return $conexion15->insert_id;
        }
        
        function LimpiarCadena14($str) {
            global $conexion15;
            $str = mysqli_real_escape_string($conexion15,trim($str));
            return htmlspecialchars($str);
        }
    }
?>