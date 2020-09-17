<?php
require '../config/connection.php';

Class userCampaignM {

    public function _construct() { /* Constructor */ }

    function selectAll() { //mostrar todos los registros
        $sql = "SELECT c.VCC, Id,  upper(Concat(Name1, ' ', Surname1)) 'Name',CampaignId "
                . "FROM user u left join userCampaign c on u.id = c.userid "
                . "where u.State = '1' and (u.UserGroup = '3' or u.UserGroup = '4') order by Id";
        return ejecutarConsulta($sql);
    }
}