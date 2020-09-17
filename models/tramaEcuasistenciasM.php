<?php
require '../config/connection.php';

Class tramaEcuasistenciasM {

    public function _construct() { /* Constructor */ }

    function selectAll($StartDate,$EndDate) { //mostrar todos los registros
        $sql = "SELECT TipoPlan,Identificacion,Nombres,Telefono1, Telefono2, Telefono3, "
                . "Telefono4, Telefono5, Telefono6, Ciudad, Genero, G.Email,Cuenta,"
                . "Tarjeta, ContactAddress, u.Name 'Name', CONVERT(TmsTmp, DATE) 'FECHA', "
                . "CONVERT(TmsTmp, TIME) 'HORA', '' as 'HORARIO', '' as 'TURNO', "
                . "ResultLevel1, ResultLevel2, ResultLevel3,(SELECT estado FROM CCK.CONTACTIMPORTPHONE c "
                . "where c.contactid = g.ContactId and c.numeromarcado = g.ContactAddress )'MOTIVOTELEFONO', "
                . "Intentos FROM gestionfinal "
                . "g join cck.user u on g.Agent = u.Id where tmstmp BETWEEN '$StartDate' and '$EndDate'";
        return ejecutarConsulta2($sql);
    }
}