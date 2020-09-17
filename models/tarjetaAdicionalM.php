<?php

require '../config/connection.php';

Class tarjetaAdicionalM {

    public function _construct() { /* Constructor */
    }
    
    function insertTCA($IdCliente,$contactAddress,$Agent,$Tmstmp,$cedulaTitularTCA,$nombresTitularTCA,$ESTADO_CIVILTCA,$generoTCA,$LUGARNACTCA,$FECHA_NACIMIENTOTCA,$ACTECOTCA,$provinciaTrabTCA,$ciudadTrabTCA,$principalTrabTCA,$numTrabTCA,$secundariaTrabTCA,$sectorTrabTCA,$tipoLugarTCA,$refTrabTCA,$dirConcTrabTCA,$provinciaDomTCA,$ciudadDomTCA,$principalDomTCA,$numDomTCA,$secundariaDomTCA,$sectorDomTCA,$tipoLugarDOMTCA,$refDomTCA,$dirConcDomTCA,$tipoIdentificacionTCA,$IDENTIFICACIONTCA,$nacionalidadTCA,$APELLIDO1TCA,$APELLIDO2TCA,$NOMBRE1TCA,$NOMBRE2TCA,$nombreTarjetaTCA,$FECHA_NACIMIENTOADITCA,$generoPerTCA,$estadoCivilPerTCA,$parentezcoTCA,$tarjetaTitularTCA,$cupoTCA,$lugarEntTCA,$ranVisTCA,$CORREOTCA,$personaContactoTCA,$celTCP,$telfTextTrabTCA,$telfDom,$estadoctaTCA,$pdpTCA, $subestatus1TCA, $subestatus2TCA) { //inserción de datos
        $sql = "INSERT INTO `tca`(`ContactId`, `ContactAddress`, `InteractionId`, `Agente`, `Tmstmp`, `CedulaTitular`, `NombresTitular`, `EstadoCivilTitular`, `GeneroTitular`, `LugarNacimientoTitular`, `FechaNacimientoTitular`, `ActividadEconomicaTitular`, `ProvinciaTrabajo`, `CiudadTrabajo`, `CallePTrabajo`, `NumeracionTrabajo`, `CalleSTrabajo`, `SectorBarrioTrabajo`, `EdificioCasaTrabajo`, `ReferenciaTrabajo`, `ConcatenadaTrabajo`, `ProvinciaDomicilio`, `CiudadDomicilio`, `CallePDomicilio`, `NumeracionDomicilio`, `CalleSDomicilio`, `SectorBarrioDomicilio`, `EdificioCasaDomicilio`, `ReferenciaDomicilio`, `ConcatenadaDomicilio`, `TipoIdentificacion`, `Identificacion`, `Nacionalidad`, `PrimerApellido`, `SegunApellido`, `PrimerNombre`, `SegundoNombre`, `NombreTarjeta`, `FechaNacimiento`, `Genero`, `EstadoCivil`, `Parentesco`, `TarjetaTitular`, `Cupo`, `DireccionEntrega`, `RangoVisita`, `Email`, `PersonaContacto`, `Celular`, `TelefonoTrabajo`, `TelefonoDomicilio`, `EmisionEstadoCuenta`, `SeguroDesgravamen`, `estatus1`, `estatus2`)
                          VALUES ('$IdCliente','$contactAddress','','$Agent','$Tmstmp','$cedulaTitularTCA','$nombresTitularTCA','$ESTADO_CIVILTCA','$generoTCA','$LUGARNACTCA','$FECHA_NACIMIENTOTCA','$ACTECOTCA','$provinciaTrabTCA','$ciudadTrabTCA','$principalTrabTCA','$numTrabTCA','$secundariaTrabTCA','$sectorTrabTCA','$tipoLugarTCA','$refTrabTCA','$dirConcTrabTCA','$provinciaDomTCA','$ciudadDomTCA','$principalDomTCA','$numDomTCA','$secundariaDomTCA','$sectorDomTCA','$tipoLugarDOMTCA','$refDomTCA','$dirConcDomTCA','$tipoIdentificacionTCA','$IDENTIFICACIONTCA','$nacionalidadTCA','$APELLIDO1TCA','$APELLIDO2TCA','$NOMBRE1TCA','$NOMBRE2TCA','$nombreTarjetaTCA','$FECHA_NACIMIENTOADITCA','$generoPerTCA','$estadoCivilPerTCA','$parentezcoTCA','$tarjetaTitularTCA','$cupoTCA','$lugarEntTCA','$ranVisTCA','$CORREOTCA','$personaContactoTCA','$celTCP','$telfTextTrabTCA','$telfDom','$estadoctaTCA','$pdpTCA','$subestatus1TCA','$subestatus2TCA')";
        return ejecutarConsulta1($sql);
    }
    
    function updateTCA($IdCliente,$contactAddress,$Agent,$Tmstmp,$cedulaTitularTCA,$nombresTitularTCA,$ESTADO_CIVILTCA,$generoTCA,$LUGARNACTCA,$FECHA_NACIMIENTOTCA,$ACTECOTCA,$provinciaTrabTCA,$ciudadTrabTCA,$principalTrabTCA,$numTrabTCA,$secundariaTrabTCA,$sectorTrabTCA,$tipoLugarTCA,$refTrabTCA,$dirConcTrabTCA,$provinciaDomTCA,$ciudadDomTCA,$principalDomTCA,$numDomTCA,$secundariaDomTCA,$sectorDomTCA,$tipoLugarDOMTCA,$refDomTCA,$dirConcDomTCA,$tipoIdentificacionTCA,$IDENTIFICACIONTCA,$nacionalidadTCA,$APELLIDO1TCA,$APELLIDO2TCA,$NOMBRE1TCA,$NOMBRE2TCA,$nombreTarjetaTCA,$FECHA_NACIMIENTOADITCA,$generoPerTCA,$estadoCivilPerTCA,$parentezcoTCA,$tarjetaTitularTCA,$cupoTCA,$lugarEntTCA,$ranVisTCA,$CORREOTCA,$personaContactoTCA,$celTCP,$telfTextTrabTCA,$telfDom,$estadoctaTCA,$pdpTCA, $subestatus1TCA, $subestatus2TCA) { //inserción de datos
        $sql = "UPDATE `tca` SET `ContactId`='$IdCliente',`ContactAddress`='$contactAddress',`InteractionId`='',`Agente`='$Agent',`Tmstmp`='$Tmstmp',`CedulaTitular`='$cedulaTitularTCA',`NombresTitular`='$nombresTitularTCA',`EstadoCivilTitular`='$ESTADO_CIVILTCA',`GeneroTitular`='$generoTCA',`LugarNacimientoTitular`='$LUGARNACTCA',`FechaNacimientoTitular`='$FECHA_NACIMIENTOTCA',`ActividadEconomicaTitular`='$ACTECOTCA',`ProvinciaTrabajo`='$provinciaTrabTCA',`CiudadTrabajo`='$ciudadTrabTCA',`CallePTrabajo`='$principalTrabTCA',`NumeracionTrabajo`='$numTrabTCA',`CalleSTrabajo`='$secundariaTrabTCA',`SectorBarrioTrabajo`='$sectorTrabTCA',`EdificioCasaTrabajo`='$tipoLugarTCA',`ReferenciaTrabajo`='$refTrabTCA',`ConcatenadaTrabajo`='$dirConcTrabTCA',`ProvinciaDomicilio`='$provinciaDomTCA',`CiudadDomicilio`='$ciudadDomTCA',`CallePDomicilio`='$principalDomTCA',`NumeracionDomicilio`='$numDomTCA',`CalleSDomicilio`='$secundariaDomTCA',`SectorBarrioDomicilio`='$sectorDomTCA',`EdificioCasaDomicilio`='$tipoLugarDOMTCA',`ReferenciaDomicilio`='$refDomTCA',`ConcatenadaDomicilio`='$dirConcDomTCA',`TipoIdentificacion`='$tipoIdentificacionTCA',`Identificacion`='$IDENTIFICACIONTCA',`Nacionalidad`='$nacionalidadTCA',`PrimerApellido`='$APELLIDO1TCA',`SegunApellido`='$APELLIDO2TCA',`PrimerNombre`='$NOMBRE1TCA',`SegundoNombre`='$NOMBRE2TCA',`NombreTarjeta`='$nombreTarjetaTCA',`FechaNacimiento`='$FECHA_NACIMIENTOADITCA',`Genero`='$generoPerTCA',`EstadoCivil`='$estadoCivilPerTCA',`Parentesco`='$parentezcoTCA',`TarjetaTitular`='$tarjetaTitularTCA',`Cupo`='$cupoTCA',`DireccionEntrega`='$lugarEntTCA',`RangoVisita`='$ranVisTCA',`Email`='$CORREOTCA',`PersonaContacto`='$personaContactoTCA',`Celular`='$celTCP',`TelefonoTrabajo`='$telfTextTrabTCA',`TelefonoDomicilio`='$telfDom',`EmisionEstadoCuenta`='$estadoctaTCA',`SeguroDesgravamen`='$pdpTCA',`estatus1`= '$subestatus1TCA',`estatus2`= '$subestatus2TCA' WHERE contactid = '$IdCliente' and Identificacion = '$IDENTIFICACIONTCA'";
        return ejecutarConsulta1($sql);
    }
    
    function selectAll($Id) { //mostrar todos los registros
        $sql = "SELECT * FROM tca where contactid  = '$Id' ";
        return ejecutarConsulta1($sql);
    }
}

?>