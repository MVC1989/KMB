<?php

require '../config/connection.php';

Class reportesM {

    public function _construct() { /* Constructor */
    }

    function selectAll($txtCampania, $txtFechaInicio) { //mostrar todos los registros
        ejecutarConsulta1("CREATE TEMPORARY TABLE bancopichinchaincrementos.TMP AS (
                            SELECT C.CAMPAIGN, C.GOALS,CODIGO_CAMPANIA, substr(TMSTMP,1,10) AS TMSTMP, ResultLevel1, ResultLevel2, AGENT
                            FROM bancopichinchaincrementos.GESTIONFINAL G, CCK.GOALSBYCAMPAIGN C
                            WHERE C.CampaignCode = G.CODIGO_CAMPANIA AND TmStmp LIKE '%$txtFechaInicio%');");
        
        $sql = " SELECT B.AGENT, B.CAMPAIGN, B.GOALS,
                IFNULL((SELECT COUNT(RESULTLEVEL1) FROM bancopichinchaincrementos.TMP
                                WHERE CODIGO_CAMPANIA = B.CODIGO_CAMPANIA AND Agent = B.AGENT 
                                AND ResultLevel1 LIKE '%CU1 A%' AND TmStmp = B.TMSTMP GROUP BY AGENT),0) AS EXITOSOS,
                IFNULL((SELECT COUNT(RESULTLEVEL1) FROM bancopichinchaincrementos.TMP
                                WHERE CODIGO_CAMPANIA = B.CODIGO_CAMPANIA AND Agent = B.AGENT 
                                AND ResultLevel1 LIKE '%%' AND TmStmp = B.TMSTMP GROUP BY AGENT),0) AS GESTIONADOS,
                IFNULL((SELECT COUNT(RESULTLEVEL1) FROM bancopichinchaincrementos.TMP
                                WHERE CODIGO_CAMPANIA = B.CODIGO_CAMPANIA AND Agent = B.AGENT 
                                AND ResultLevel1 LIKE '%CU%' AND TmStmp = B.TMSTMP GROUP BY AGENT),0) AS CONTACTADOS,
                ROUND(IFNULL(((SELECT COUNT(RESULTLEVEL1) FROM bancopichinchaincrementos.TMP
                                WHERE CODIGO_CAMPANIA = B.CODIGO_CAMPANIA AND Agent = B.AGENT 
                                AND ResultLevel1 LIKE '%CU%' AND TmStmp = B.TMSTMP GROUP BY AGENT)*100/
                                (SELECT COUNT(RESULTLEVEL1) FROM bancopichinchaincrementos.TMP
                                WHERE CODIGO_CAMPANIA = B.CODIGO_CAMPANIA AND Agent = B.AGENT 
                                AND ResultLevel1 LIKE '%%' AND TmStmp = B.TMSTMP GROUP BY AGENT)),0),2) AS CONTACTABILIDAD,
                ROUND(IFNULL(((SELECT COUNT(RESULTLEVEL1) FROM bancopichinchaincrementos.TMP
                                WHERE CODIGO_CAMPANIA = B.CODIGO_CAMPANIA AND Agent = B.AGENT 
                                AND ResultLevel1 LIKE '%CU1 A%' AND TmStmp = B.TMSTMP GROUP BY AGENT)*100/
                                (SELECT COUNT(RESULTLEVEL1) FROM bancopichinchaincrementos.TMP
                                WHERE CODIGO_CAMPANIA = B.CODIGO_CAMPANIA AND Agent = B.AGENT 
                                AND ResultLevel1 LIKE '%%' AND TmStmp = B.TMSTMP GROUP BY AGENT)),0),2) AS EFECTIVIDAD
                FROM bancopichinchaincrementos.TMP B
                WHERE B.CODIGO_CAMPANIA = '$txtCampania'
                GROUP BY B.AGENT
                UNION ALL
                SELECT 'TOTAL', B.CAMPAIGN, B.GOALS,
                IFNULL((SELECT COUNT(RESULTLEVEL1) FROM bancopichinchaincrementos.TMP
                                WHERE CODIGO_CAMPANIA = B.CODIGO_CAMPANIA 
                                AND ResultLevel1 LIKE '%CU1 A%' AND TmStmp = B.TMSTMP),0) AS EXITOSOS,
                IFNULL((SELECT COUNT(RESULTLEVEL1) FROM bancopichinchaincrementos.TMP
                                WHERE CODIGO_CAMPANIA = B.CODIGO_CAMPANIA
                                AND ResultLevel1 LIKE '%%' AND TmStmp = B.TMSTMP),0) AS GESTIONADOS,
                IFNULL((SELECT COUNT(RESULTLEVEL1) FROM bancopichinchaincrementos.TMP
                                WHERE CODIGO_CAMPANIA = B.CODIGO_CAMPANIA
                                AND ResultLevel1 LIKE '%CU%' AND TmStmp = B.TMSTMP),0) AS CONTACTADOS,
                ROUND(IFNULL(((SELECT COUNT(RESULTLEVEL1) FROM bancopichinchaincrementos.TMP
                                WHERE CODIGO_CAMPANIA = B.CODIGO_CAMPANIA
                                AND ResultLevel1 LIKE '%CU%' AND TmStmp = B.TMSTMP)*100/
                                (SELECT COUNT(RESULTLEVEL1) FROM bancopichinchaincrementos.TMP
                                WHERE CODIGO_CAMPANIA = B.CODIGO_CAMPANIA
                                AND ResultLevel1 LIKE '%%' AND TmStmp = B.TMSTMP)),0),2) AS CONTACTABILIDAD,
                ROUND(IFNULL(((SELECT COUNT(RESULTLEVEL1) FROM bancopichinchaincrementos.TMP
                                WHERE CODIGO_CAMPANIA = B.CODIGO_CAMPANIA
                                AND ResultLevel1 LIKE '%CU1 A%' AND TmStmp = B.TMSTMP)*100/
                                (SELECT COUNT(RESULTLEVEL1) FROM bancopichinchaincrementos.TMP
                                WHERE CODIGO_CAMPANIA = B.CODIGO_CAMPANIA
                                AND ResultLevel1 LIKE '%%' AND TmStmp = B.TMSTMP)),0),2) AS EFECTIVIDAD
                FROM CCK.GOALSBYCAMPAIGN C, bancopichinchaincrementos.TMP B
                WHERE B.CODIGO_CAMPANIA = '$txtCampania'
                GROUP BY Campaign, GOALS;
                ";
        
        
        return ejecutarConsulta1($sql);
        ejecutarConsulta1("DROP TABLE bancopichinchaincrementos.TMP;");
    }
}

?>