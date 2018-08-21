<?php
require_once("../class/session.php");
require_once '../class/conexao.class.php';

require_once("../class/class.user.php");
$empresa = new USER();


$empres = $empresa->runQuery("SELECT * FROM empresa WHERE empresa_id = 1");
$empres->execute();
$dad = $empres->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>

<html lang="pt">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>Sistema</title>

        <meta name="description" content="overview &amp; stats" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="../assets/font-awesome/4.2.0/css/font-awesome.min.css" />

        <!-- page specific plugin styles -->

        <!-- text fonts -->
        <link rel="stylesheet" href="../assets/fonts/fonts.googleapis.com.css" />

        <!-- ace styles -->
        <link rel="stylesheet" href="../assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />


        <!--[if lte IE 9]>
                <link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
        <![endif]-->

        <!--[if lte IE 9]>
          <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
        <![endif]-->

        <!-- inline styles related to this page -->

        <!-- ace settings handler -->
        <script src="../assets/js/ace-extra.min.js"></script>


        <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

        <!--[if lte IE 8]>
        <script src="assets/js/html5shiv.min.js"></script>
        <script src="assets/js/respond.min.js"></script>
        <![endif]-->


        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
    </head>

    <body class="no-skin">
        <div id="navbar" class="navbar navbar-default">
            <script type="text/javascript">
                try {
                    ace.settings.check('navbar', 'fixed')
                } catch (e) {
                }
            </script>

            <div class="navbar-container " id="navbar-container">
                <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
                    <span class="sr-only">Toggle sidebar</span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>
                </button>

                <div class="navbar-header pull-left">
                    <a href="../index.php" class="navbar-brand ">
                        <small class="smaller-60">
                            <i class="fa fa-asterisk"></i>
                            <?php
                            echo $dad['empresa_nome'];
                            ?>
                        </small>
                    </a>
                </div>

                <div class="navbar-buttons navbar-header pull-right" role="navigation">
                    <ul class="nav ace-nav">
                        <li class="grey">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <i class="ace-icon fa fa-tasks"></i>
                                <span class="badge badge-grey">4</span>
                            </a>

                            <ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
                                <li class="dropdown-header">
                                    <i class="ace-icon fa fa-check"></i>
                                    4 Tasks to complete
                                </li>

                                <li class="dropdown-content">
                                    <ul class="dropdown-menu dropdown-navbar">
                                        <li>
                                            <a href="#">
                                                <div class="clearfix">
                                                    <span class="pull-left">Software Update</span>
                                                    <span class="pull-right">65%</span>
                                                </div>

                                                <div class="progress progress-mini">
                                                    <div style="width:65%" class="progress-bar"></div>
                                                </div>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#">
                                                <div class="clearfix">
                                                    <span class="pull-left">Hardware Upgrade</span>
                                                    <span class="pull-right">35%</span>
                                                </div>

                                                <div class="progress progress-mini">
                                                    <div style="width:35%" class="progress-bar progress-bar-danger"></div>
                                                </div>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#">
                                                <div class="clearfix">
                                                    <span class="pull-left">Unit Testing</span>
                                                    <span class="pull-right">15%</span>
                                                </div>

                                                <div class="progress progress-mini">
                                                    <div style="width:15%" class="progress-bar progress-bar-warning"></div>
                                                </div>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#">
                                                <div class="clearfix">
                                                    <span class="pull-left">Bug Fixes</span>
                                                    <span class="pull-right">90%</span>
                                                </div>

                                                <div class="progress progress-mini progress-striped active">
                                                    <div style="width:90%" class="progress-bar progress-bar-success"></div>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="dropdown-footer">
                                    <a href="#">
                                        See tasks with details
                                        <i class="ace-icon fa fa-arrow-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="purple">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <i class="ace-icon fa fa-bell icon-animated-bell"></i>
                                <span class="badge badge-important">8</span>
                            </a>

                            <ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
                                <li class="dropdown-header">
                                    <i class="ace-icon fa fa-exclamation-triangle"></i>
                                    8 Notifications
                                </li>

                                <li class="dropdown-content">
                                    <ul class="dropdown-menu dropdown-navbar navbar-pink">
                                        <li>
                                            <a href="#">
                                                <div class="clearfix">
                                                    <span class="pull-left">
                                                        <i class="btn btn-xs no-hover btn-pink fa fa-comment"></i>
                                                        New Comments
                                                    </span>
                                                    <span class="pull-right badge badge-info">+12</span>
                                                </div>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#">
                                                <i class="btn btn-xs btn-primary fa fa-user"></i>
                                                Bob just signed up as an editor ...
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#">
                                                <div class="clearfix">
                                                    <span class="pull-left">
                                                        <i class="btn btn-xs no-hover btn-success fa fa-shopping-cart"></i>
                                                        New Orders
                                                    </span>
                                                    <span class="pull-right badge badge-success">+8</span>
                                                </div>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#">
                                                <div class="clearfix">
                                                    <span class="pull-left">
                                                        <i class="btn btn-xs no-hover btn-info fa fa-twitter"></i>
                                                        Followers
                                                    </span>
                                                    <span class="pull-right badge badge-info">+11</span>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="dropdown-footer">
                                    <a href="#">
                                        See all notifications
                                        <i class="ace-icon fa fa-arrow-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="green">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <i class="ace-icon fa fa-envelope icon-animated-vertical"></i>
                                <span class="badge badge-success">5</span>
                            </a>

                            <ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
                                <li class="dropdown-header">
                                    <i class="ace-icon fa fa-envelope-o"></i>
                                    5 Messages
                                </li>

                                <li class="dropdown-content">
                                    <ul class="dropdown-menu dropdown-navbar">
                                        <li>
                                            <a href="#" class="clearfix">
                                                <img src="../assets/avatars/avatar.png" class="msg-photo" alt="Alex's Avatar" />
                                                <span class="msg-body">
                                                    <span class="msg-title">
                                                        <span class="blue">Alex:</span>
                                                        Ciao sociis natoque penatibus et auctor ...
                                                    </span>

                                                    <span class="msg-time">
                                                        <i class="ace-icon fa fa-clock-o"></i>
                                                        <span>a moment ago</span>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#" class="clearfix">
                                                <img src="../assets/avatars/avatar3.png" class="msg-photo" alt="Susan's Avatar" />
                                                <span class="msg-body">
                                                    <span class="msg-title">
                                                        <span class="blue">Susan:</span>
                                                        Vestibulum id ligula porta felis euismod ...
                                                    </span>

                                                    <span class="msg-time">
                                                        <i class="ace-icon fa fa-clock-o"></i>
                                                        <span>20 minutes ago</span>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#" class="clearfix">
                                                <img src="../assets/avatars/avatar4.png" class="msg-photo" alt="Bob's Avatar" />
                                                <span class="msg-body">
                                                    <span class="msg-title">
                                                        <span class="blue">Bob:</span>
                                                        Nullam quis risus eget urna mollis ornare ...
                                                    </span>

                                                    <span class="msg-time">
                                                        <i class="ace-icon fa fa-clock-o"></i>
                                                        <span>3:15 pm</span>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#" class="clearfix">
                                                <img src="../assets/avatars/avatar2.png" class="msg-photo" alt="Kate's Avatar" />
                                                <span class="msg-body">
                                                    <span class="msg-title">
                                                        <span class="blue">Kate:</span>
                                                        Ciao sociis natoque eget urna mollis ornare ...
                                                    </span>

                                                    <span class="msg-time">
                                                        <i class="ace-icon fa fa-clock-o"></i>
                                                        <span>1:33 pm</span>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#" class="clearfix">
                                                <img src="../assets/avatars/avatar5.png" class="msg-photo" alt="Fred's Avatar" />
                                                <span class="msg-body">
                                                    <span class="msg-title">
                                                        <span class="blue">Fred:</span>
                                                        Vestibulum id penatibus et auctor  ...
                                                    </span>

                                                    <span class="msg-time">
                                                        <i class="ace-icon fa fa-clock-o"></i>
                                                        <span>10:09 am</span>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="dropdown-footer">
                                    <a href="inbox.html">
                                        See all messages
                                        <i class="ace-icon fa fa-arrow-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="light-blue">
                            <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                                <img class="nav-user-photo" src="../assets/avatars/user.jpg" alt="Jason's Photo" />
                                <span class="user-info">
                                    <small>Olá,</small>
                                    <?php print($userRow['funcionario_nome']); ?>
                                </span>

                                <i class="ace-icon fa fa-caret-down"></i>
                            </a>

                            <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                                <li>
                                    <a href="#">
                                        <i class="ace-icon fa fa-cog"></i>
                                        Configurações
                                    </a>
                                </li>

                                <li>
                                    <a href="profile.html">
                                        <i class="ace-icon fa fa-user"></i>
                                        Alterar Senha
                                    </a>
                                </li>

                                <li class="divider"></li>

                                <li>
                                    <a href="../class/logout.php?logout=true">
                                        <i class="ace-icon fa fa-power-off"></i>
                                        Sair
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div><!-- /.navbar-container -->
        </div>

        <div class="main-container" id="main-container">
            <script type="text/javascript">
                try {
                    ace.settings.check('main-container', 'fixed')
                } catch (e) {
                }
            </script>

            <div id="sidebar" class="sidebar                  responsive">
                <script type="text/javascript">
                    try {
                        ace.settings.check('sidebar', 'fixed')
                    } catch (e) {
                    }
                </script>

                <div class="sidebar-shortcuts" id="sidebar-shortcuts">
                    <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
<!--                        <button class="btn btn-success">
                            <i class="ace-icon fa fa-signal"></i>
                        </button>

                        <button class="btn btn-info">
                            <i class="ace-icon fa fa-pencil"></i>
                        </button>-->

                        
<!--                            <i class="ace-icon fa fa-users"> -->
                        <a href="../cliente/index.php" class="ace-icon fa fa-users btn btn-success"></a>
                        
                        <a href="../pedido/index.php" class="ace-icon fa fa-pencil btn btn-info"></a>
                        
                        <a href="../notas/index.php" class="ace-icon fa fa-ticket btn btn-default"></a>
                        
                        <a href="../produto/index.php" class="ace-icon fa fa-barcode btn btn-primary"></a>
                            <!--</i>-->
                        
<!--                        <button class="btn btn-danger">
                            <i class="ace-icon fa fa-cogs"></i>
                        </button>-->
                    </div>

                    <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
                        <span class="btn btn-success"></span>

                        <span class="btn btn-info"></span>

                        <span class="btn btn-default"></span>

                        <span class="btn btn-primary"></span>
                    </div>
                </div><!-- /.sidebar-shortcuts -->

                <ul class="nav nav-list">




                    <li class="">
                        <a href="#" class="dropdown-toggle">

                            <i class="menu-icon fa fa-tasks"></i>
                            <span class="menu-text">Cadastros </span>

                            <b class="arrow fa fa-angle-down"></b>
                        </a>

                        <b class="arrow"></b>

                        <ul class="submenu">
                            <li class="">
                                <a href="../cliente/index.php">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Cliente
                                </a>

                                <b class="arrow"></b>
                            </li>
                            <li class="">
                                <a href="../empresa/index.php">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Empresa
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <li class="">
                                <a href="../funcionarios/index.php">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Funcionarios
                                </a>

                                <b class="arrow"></b>
                            </li>                          
                            <li class="">
                                <a href="../produto/index.php">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Produtos
                                </a>

                                <b class="arrow"></b>
                            </li>
                            <li class="">
                                <a href="../municipios/index.php">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Municipio
                                </a>
                                <b class="arrow"></b>
                            </li> 
                            <li class="">
                                <a href="../ncm/index.php">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    NCM
                                </a>

                                <b class="arrow"></b>
                            </li>  
                            <li class="">
                                <a href="../fornecedor/index.php">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Fornecedor
                                </a>

                                <b class="arrow"></b>
                            </li>
                            <li class="">
                                <a href="../transportador/index.php">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Transportador
                                </a>

                                <b class="arrow"></b>
                            </li>
                            <li class="">
                                <a href="../unidade/index.php">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Unidade Medida
                                </a>
                                <b class="arrow"></b>
                            </li> 
                            <li class="">
                                <a href="../grupo/index.php">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Grupo/Sub-Grupo
                                </a>
                                <b class="arrow"></b>
                            </li> 
                            <li class="">
                                <a href="../forma_pagamento/index.php">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Formas de Pagamento
                                </a>
                                <b class="arrow"></b>
                            </li> 
                        </ul>
                    </li>

                    <li class="">
                        <a href="#" class="dropdown-toggle">
                            <i class="menu-icon fa fa-pencil-square-o"></i>
                            <span class="menu-text"> Pedidos </span>

                            <b class="arrow fa fa-angle-down"></b>
                        </a>

                        <b class="arrow"></b>

                        <ul class="submenu">
                            <li class="">
                                <a href="../pedido/pedido_cadastrar.php">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Novo Pedido
                                </a>

                                <b class="arrow"></b>
                            </li>
                            <li class="">
                                <a href="../pedido/index.php">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Listar Pedidos
                                </a>
                                <b class="arrow"></b>
                            </li>                           
                            <li class="">
                                <a href="../pedido/pedido_relatorio.php">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Relatórios Pedidos
                                </a>
                                <b class="arrow"></b>
                            </li>                           
                        </ul>
                    </li>
                    
                    <li class="">
                        <a href="#" class="dropdown-toggle">
                            <i class="menu-icon fa fa-download"></i>
                            <span class="menu-text"> Entradas </span>

                            <b class="arrow fa fa-angle-down"></b>
                        </a>

                        <b class="arrow"></b>

                        <ul class="submenu">
                            <li class="">
                                <a href="../entradas/entrada_status.php">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Verificar Status
                                </a>

                                <b class="arrow"></b>
                                
                            </li>  
                            <li class="">
                                <a href="../down/importar_xml.php">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Importar XML
                                </a>

                                <b class="arrow"></b>
                            </li>
                            <li class="">
                                <a href="../entradas/index.php">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Entradas
                                </a>

                                <b class="arrow"></b>
                            </li>
                        </ul>
                        
                      
                    </li>

                    <li class="">
                        <a href="#" class="dropdown-toggle">
                            <i class="menu-icon fa fa-list-alt"></i>
                            <span class="menu-text"> Faturamento </span>

                            <b class="arrow fa fa-angle-down"></b>
                        </a>

                        <b class="arrow"></b>

                        <ul class="submenu">
                            <li class="">
                                <a href="../notas/notas_nova.php">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Gerar NF-e
                                </a>

                                <b class="arrow"></b>
                            </li>  
                            <li class="">
                                <a href="../notas/index.php">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Emitir/Listar NF-e
                                </a>

                                <b class="arrow"></b>
                            </li>
                            <li class="">
                                <a href="../notas/notas_cancela.php">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Cancelar NF-e
                                </a>

                                <b class="arrow"></b>
                            </li>
                            <li class="">
                                <a href="../notas/notas_cartacorrecao.php">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Carta de Correção
                                </a>

                                <b class="arrow"></b>
                            </li>
                            <li class="">
                                <a href="../notas/notas_inutilizar.php">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Inutilizar Série
                                </a>

                                <b class="arrow"></b>
                            </li>
                            <li class="">
                                <a href="../notas/notas_status.php">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Status NF-e
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <li class="">
                                <a href="../notas/notas_relatorios.php">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Relatorios
                                </a>
                                <b class="arrow"></b>
                            </li>

<!--                            <li class="">
                                <a href="../notas/notas_validade_cert.php">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Validade Certificado
                                </a>
                                <b class="arrow"></b>
                            </li>-->

                        </ul>
                    </li>

                    <li class="">
                        <a href="#" class="dropdown-toggle">
                            <i class="menu-icon fa fa-list"></i>
                            <span class="menu-text">Tributos</span>

                            <b class="arrow fa fa-angle-down"></b>
                        </a>

                        <b class="arrow"></b>

                        <ul class="submenu">

                            <li class="">
                                <a href="../st/index.php">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Situação Tributária
                                </a>

                                <b class="arrow"></b>
                            </li> 
                            <li class="">
                                <a href="../st/st_cadastrar.php">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Nova Sit. Tributária
                                </a>

                                <b class="arrow"></b>
                            </li> 

                    </li> 
                    <li class="">
                        <a href="../tes/index.php">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Tipo E/S
                        </a>

                        <b class="arrow"></b>
                    </li> 
                    
                    <li class="">
                        <a href="../cfop/index.php">
                            <i class="menu-icon fa fa-caret-right"></i>
                            CFOP
                        </a>

                        <b class="arrow"></b>
                    </li> 
                    <li class="">
                        <a href="../aproveitamento/index.php">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Aprov. ICMS
                        </a>

                        <b class="arrow"></b>
                    </li> 

                </ul>
                </li>
                <li class="">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-money"></i>
                        <span class="menu-text"> Financeiro </span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        <li class="">
                            <a href="../contas_receber/index.php">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Contas a Receber
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="">
                            <a href="#">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Contas a Pagar
                            </a>

                            <b class="arrow"></b>
                        </li>
                        <li class="">
                            <a href="#">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Caixa/Bancos
                            </a>

                            <b class="arrow"></b>
                        </li>
                        <li class="">
                            <a href="../contas_receber/contas_receber_boleto.php">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Boletos
                            </a>
                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>
                  <li class="">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-table"></i>
                        <span class="menu-text"> Tabela </span>
                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        <li class="">
                            <a href="../inf_comp/index.php">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Inf. Comp.
                            </a>

                            <b class="arrow"></b>
                        </li>
                       
                    </ul>
                </li>
                <li class="">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-cogs"></i>
                        <span class="menu-text"> Configurações </span>
                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        <li class="">
                            <a href="../configura/index.php">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Empresa
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="">
                            <a href="#">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Interface
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="">
                            <a href="../backup/index.php">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Backup Dados
                            </a>
                            <b class="arrow"></b>
                        </li>
                       
                    </ul>
                </li>

                </ul><!-- /.nav-list -->

                <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
                    <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
                </div>

                <script type="text/javascript">
                    try {
                        ace.settings.check('sidebar', 'collapsed')
                    } catch (e) {
                    }
                </script>
            </div>

