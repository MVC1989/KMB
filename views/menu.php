<?php
session_start();
if ($_SESSION['usu'] == "") {
    session_unset($_SESSION['usu']);
    session_unset($_SESSION['name']);
    header('location: ../views/login.php');
}
?>
<body class="hold-transition skin-blue sidebar-mini sidebar">
    <div class="wrapper">
        <header class="main-header">
            <!-- Logo -->
            <a href="../views/blank.php" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>CC</b>K</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>CC Kimobill</b></span>
            </a>

            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <div class="navbar-custom-menu">
                    <?php if ($_SESSION['workgroup'] >= "3") { ?>
                        <ul class="nav navbar-nav">
                            <li class="well-sm">
                                <select onchange="valores()" name="estatus" id="estatus" class="show-menu-arrow form-control btn-primary" >
                                    <option>Cambiar Estado</option>
                                    <?php
                                    require '../config/connection.php';
                                    $result = ejecutarConsulta("SELECT idState, Description FROM userstates ORDER BY idstate");
                                    while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                                        echo '<option value="' . $row["idState"] . '">' . $row["Description"] . '</option>';
                                    }
                                    ?>
                                </select>
                                <!--</div>-->
                            </li>
                        </ul>
                    <?php } ?>
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="../public/admin/images/logo.jpg" class="user-image" alt="User Image"/>
                                <span class="hidden-xs">
                                    <?php echo $_SESSION['name']; ?>
                                </span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <p>
                                        <small></small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" onclick="" class="btn btn-default btn-flat">Perfil</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="../ajax/logoutC.php" class="btn btn-default btn-flat">Cerrar sesión</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>

                </div>
            </nav>
        </header>

        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <ul class="sidebar-menu" data-widget="tree">
                    <?php if ($_SESSION['workgroup'] >= "3") { ?>
                        <li><a href="../views/rolesDePago.php"><i class="fa fa-user"></i> <span>Roles de pago</span></a></li>    
                            <!--<li><a href="../views/encuestaAsesores.php"><i class="fa fa-user"></i> <span>Encuesta Easy Life</span></a></li>-->
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-microphone"></i> <span>Campañas Inbound</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="../views/frmCampaniasInbound.php"><i class="fa fa-users"></i> Nueva Gestión Inbound </a></li>
                                <li><a href="../views/frmGestionInbound.php"><i class="fa fa-users"></i> Gestiones Inbound </a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-object-group"></i> <span>Campañas Banco Pichincha</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-microphone"></i> <span>Cancelaciones</span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="../views/frmBpCancelacionesCampania.php"><i class="fa fa-users"></i> Nuevos Clientes </a></li>
                                        <li><a href="../views/frmBpCancelacionesAgenda.php"><i class="fa fa-headphones"></i> Agendamiento </a></li>
                                    </ul>
                                </li>
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-microphone"></i> <span>Cargos Recurrentes</span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="../views/frmBpCargosCampania.php"><i class="fa fa-users"></i> Nuevos Clientes </a></li>
                                        <li><a href="../views/frmBpCargosAgenda.php"><i class="fa fa-headphones"></i> Agendamiento </a></li>
                                    </ul>
                                </li>
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-microphone"></i> <span>Campañas de Comunicación</span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="../views/frmBpComunicacion.php"><i class="fa fa-users"></i> Incremento de Cupo</a></li>
                                        <li><a href="../views/frmBpAfiliacion.php"><i class="fa fa-users"></i> Afiliación Banca/Billetera</a></li>
                                    </ul>
                                </li>
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-microphone"></i> <span>Diferidos TC</span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="../views/frmBpDiferidos.php"><i class="fa fa-users"></i> Nuevos Clientes</a></li>
                                    </ul>
                                </li>
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-microphone"></i> <span>Encuesta</span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <!--<li><a href="../views/frmBpSoporteWeb.php"><i class="fa fa-users"></i> Clientes Soporte Web</a></li>-->
                                        <!--<li><a href="../views/frmBpSaldosMovimientos.php"><i class="fa fa-users"></i> Clientes Saldos y Mov.</a></li>-->
                                        <!--<li><a href="../views/frmBpNormalizacion.php"><i class="fa fa-users"></i> Clientes Normalización</a></li>-->
                                        <!--<li><a href="../views/frmBpExtraCupo.php"><i class="fa fa-users"></i> Extra Cupo</a></li>-->
                                        <!--<li><a href="../views/frmBpAfiliacionNuevaApp.php"><i class="fa fa-users"></i> Afiliación Nueva App</a></li>-->
                                        <li><a href="../views/frmBpClientesExtInt.php"><i class="fa fa-users"></i> Clientes Internos y Ext.</a></li>
                                        <li><a href="../views/frmBpInversiones4.php"><i class="fa fa-users"></i> Inversiones</a></li>
                                        <!--<li><a href="../views/frmBancaWebOcasional.php"><i class="fa fa-users"></i> Usuarios Banca Web</a></li>-->
                                        <li><a href="../views/frmBpContencion.php"><i class="fa fa-users"></i> Contención</a></li>
                                        <li><a href="../views/frmBpProbabilidad.php"><i class="fa fa-users"></i> Probabilidad de deserción</a></li>
                                        <!--<li><a href="../views/frmBpAhorroProgramado.php"><i class="fa fa-users"></i> Clientes Ahorro Prog.</a></li>-->
                                        <!--<li><a href="../views/frmBpInversionesIII.php"><i class="fa fa-users"></i> Clientes Inversiones</a></li>-->
<!--                                        <li><a href="../views/frmBpEncuestaPricing.php"><i class="fa fa-users"></i> Estados de Cta.</a></li>
                                        <li><a href="../views/frmBpEstadosDeCuenta.php"><i class="fa fa-users"></i> Clientes Cta C.</a></li>
                                        <li><a href="../views/frmClientesEnMora90Dias.php"><i class="fa fa-users"></i> Clientes en mora > 90 dias</a></li>
                                        <li><a href="../views/frmBpInversiones.php"><i class="fa fa-users"></i> Clientes Inversiones</a></li>
                                        <li><a href="../views/frmBpEncuestaAhorroCredito.php"><i class="fa fa-users"></i> Ahorro + Crédito</a></li>
                                        <li><a href="../views/frmBpPymes.php"><i class="fa fa-users"></i> Clientes MENTORIA BOX</a></li>
                                        <li><a href="../views/frmBpEncuestaAhorroProgramado2.php"><i class="fa fa-users"></i> Nuevos Clientes Enc_3</a></li>
                                        <li><a href="../views/frmBpEncuestaAhorroProgramado3.php"><i class="fa fa-users"></i> Nuevos Clientes Enc_4</a></li>
                                        <li><a href="../views/frmBpIncrementosAgenda.php"><i class="fa fa-headphones"></i> Agendamiento </a></li>-->
                                    </ul>
                                </li>
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-microphone"></i> <span>Incrementos</span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="../views/frmBpIncrementosCamp.php"><i class="fa fa-users"></i> Nuevos Clientes </a></li>
                                        <li><a href="../views/frmBpIncrementosAgenda.php"><i class="fa fa-headphones"></i> Agendamiento </a></li>
                                    </ul>
                                </li>
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-microphone"></i> <span>Multioferta</span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="../views/campaignBP.php"><i class="fa fa-users"></i> Nuevos Clientes </a></li>
                                        <li><a href="../views/frmBPAgenda.php"><i class="fa fa-headphones"></i> Agendamiento </a></li>
                                    </ul>
                                </li>
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-microphone"></i> <span>Pasivos</span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="../views/frmBpPasivos.php"><i class="fa fa-users"></i> Nuevos Clientes </a></li>
                                        <li><a href="../views/frmBpPasivosAgenda.php"><i class="fa fa-headphones"></i> Agendamiento </a></li>
                                    </ul>
                                </li>
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-microphone"></i> <span>Variaciones</span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="../views/frmEncuesta.php"><i class="fa fa-users"></i> Nuevos Clientes </a></li>
                                        <li><a href="../views/frmEncuestaAgenda.php"><i class="fa fa-headphones"></i> Agendamiento </a></li>
                                    </ul>
                                </li>

                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-object-group"></i> <span>Campañas BGR</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-microphone"></i> <span>Encuesta</span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="../views/frmBGRCampania_V2.php"><i class="fa fa-users"></i>Encuesta de calidad</a></li>
                                        <li><a href="../views/frmBGRCanalesElectronicos.php"><i class="fa fa-headphones"></i>Canales Electrónicos</a></li>
                                        <li><a href="../views/frmBGRCancelaciones.php"><i class="fa fa-headphones"></i>Citas Canceladas</a></li>
                                        <li><a href="../views/frmBGRCitasEfectivas.php"><i class="fa fa-headphones"></i>Citas Efectivas</a></li>
                                        <li><a href="../views/frmBGRCitasPendientes.php"><i class="fa fa-headphones"></i>Citas Pendientes</a></li>
                                        <li><a href="../views/frmBGRReclamos.php"><i class="fa fa-headphones"></i>Reclamos</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-object-group"></i> <span>Campañas Claro</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-microphone"></i> <span>Ventas</span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="../views/frmClaroCampania.php"><i class="fa fa-users"></i> Nuevos Clientes </a></li>
                                        <li><a href="../views/frmClaroAgenda.php"><i class="fa fa-headphones"></i> Agendamiento </a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-object-group"></i> <span>Campañas Ecuasistencia</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-microphone"></i> <span>Ventas</span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="../views/frmEcuasistencias.php"><i class="fa fa-users"></i> Nuevos Clientes </a></li>
                                        <li><a href="../views/frmAgendaEc.php"><i class="fa fa-headphones"></i> Agendamiento </a></li>
                                    </ul>
                                </li>
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-microphone"></i> <span>Encuesta de calidad</span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="../views/frmEcuaEncCampania.php"><i class="fa fa-users"></i> Nuevos Clientes </a></li>
                                        <li><a href="../views/frmEcuaEncAgenda.php"><i class="fa fa-headphones"></i> Agendamiento </a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-object-group"></i> <span>Campañas Jardines del Valle</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-microphone"></i> <span>Ventas</span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="../views/frmJardinesDelValleCampania.php"><i class="fa fa-users"></i> Nuevos Clientes </a></li>
                                        <li><a href="../views/frmJardinesDelValleAgenda.php"><i class="fa fa-headphones"></i> Agendamiento </a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    <?php } else { ?>
                        <?php if ($_SESSION['workgroup'] == "1") { ?>
                            <li><a href="../views/cargarRoles.php"><i class="fa fa-street-view"></i> <span>Administrar roles de Pago</span></a></li>
                        <?php } ?>
                        <?php if ($_SESSION['workgroup'] == "2") { ?>
                            <li><a href="../views/rolesDePago.php"><i class="fa fa-street-view"></i> <span>Roles de Pago</span></a></li>
                        <?php } ?>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-sort"></i> <span>Administración General</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <!--<li><a href="../views/loadUsers.php"><i class="fa fa-users"></i> Carga masiva de asesores </a></li>-->
                                <li><a href="../views/users.php"><i class="fa fa-user"></i> <span>Usuarios</span></a></li>
                                <li><a href="../views/userByCampaign.php"><i class="fa fa-headphones"></i> Usuarios y Campañas </a></li>
                                <li><a href="../views/resultCampaign.php"><i class="fa fa-area-chart"></i> Resultados de Campaña </a></li>
                                <li><a href="../views/correosMasivosBP.php"><i class="fa fa-mail-reply"></i> Envío de correos BP </a></li>
                            </ul>
                        </li>
                        <li><a href="../views/baseManagement.php"><i class="fa  fa-cog"></i> <span>Administración de bases</span></a></li>
                        <!--<li><a href="../views/asignBase.php"><i class="fa  fa-cog"></i> <span>Administración de bases</span></a></li>-->
    <!--                        <li><a href="../views/recicladoByOne.php"><i class="fa fa-tag"></i> Reciclar base (1 a 1)</a></li>
                        <li><a href="../views/reciclado.php"><i class="fa fa-tags"></i> Reciclar base </a></li>-->
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-sort"></i> <span>Detalles de bases</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="../views/detalleBase.php"><i class="fa fa-tag"></i> Detalle por bases</a></li>
                                <li><a href="../views/detalleAsesor.php"><i class="fa fa-tag"></i> Detalle por asesor</a></li>
                            </ul>
                        </li>
                        <li><a href="../views/enriquecimientoBases.php"><i class="fa fa-bank"></i> <span>Enriquecimiento de bases</span></a></li>
                        <li><a href="../views/importation.php"><i class="fa fa-book"></i> <span>Importaciones</span></a></li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-sort"></i> <span>Archivos planos</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="../views/tramaEcuasistencia.php"><i class="fa fa-user"></i> <span>Trama Ecuasistencias</span></a></li>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>

            </section>
            <!-- /.sidebar -->
        </aside>

        <script src="scripts/userStates.js" type="text/javascript"></script>