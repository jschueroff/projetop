<?php
require_once 'pedido_config.php';
require_once '../pagina/menu.php';
?>
<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs" id="breadcrumbs">
            <script type="text/javascript">
                try {
                    ace.settings.check('breadcrumbs', 'fixed')
                } catch (e) {
                }
            </script>

            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="../principal/index.php">Home</a>
                </li>
                <li class="active">Relatórios</li>
            </ul><!-- /.breadcrumb -->


        </div>

        <div class="page-content">
            <?php
            require_once '../principal/principal_config.php';
            ?>
            <div class="row">
                <div class="col-xs-12">

                    <fieldset>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="widget-box">
                                    <div class="widget-header widget-header-flat">
                                        <h4 class="widget-title smaller">
                                            Relatorios dos Pedidos
                                        </h4>
                                    </div>

                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class='row'>
                                                        <form method="post" action="pedido_export.php"> 
                                                            <div class='col-sm-3'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title"></label>
                                                                    <select name="modelo" class="form-control">
                                                                        <option value="0"selected="">Selecione</option>
                                                                        <!--                                                                        <option value="excel">Clientes Ativos em Excel</option>-->
                                                                        <!--                                                                        <option value="txt">Clientes Ativos em TXT</option>-->
                                                                        <option value="txt_todos">Todos Pedidos</option>
                                                                        <option value="txt_qtd_cli">QTD Pedido/Cliente</option>
                                                                        <!--                                                                        <option value="ordenados_estado">Clientes UF em TXT</option>-->

                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-1'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title"> </label>
                                                                    <input type="submit" name="export_" class="btn btn-success btn-sm form-control" value="Gerar" />
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <!--                                                        AQUI PODE SE VISUALIZAR OS RELATORIOS-->
                                                        <form method="post" action="cliente_export.php"> 
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title"></label>
                                                                    <select name="visualizar_dados" class="form-control">

                                                                        <option value="cli_estado">Clientes/Estado</option>


                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title"> </label>
                                                                    <input type="submit" name="visualizar" class="btn btn-success btn-sm form-control" value="Visualizar" />
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <!--                                                        AQUI GERA OS PDF DOS RELATORIOS RELATORIOS-->
                                                        <form method="post" action="cliente_export.php"> 
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title"></label>
                                                                    <select name="gera_pdf_cli_estado" class="form-control">

                                                                        <option value="cli_estado">Clientes/Estado</option>


                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title"> </label>
                                                                    <input type="submit" name="visualizar_pdf_cli_estado"  target="_blank" class="btn btn-success btn-sm form-control" value="Gerar PDF" />
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="widget-box">
                                    <div class="widget-header widget-header-flat">
                                        <h4 class="widget-title smaller">
                                            Relatórios por Data
                                        </h4>
                                    </div>
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class='row'>
                                                        <form method="post" action="pedido_export.php"> 
                                                            <div class='col-sm-3'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">Dt Inicial</label>
                                                                    <input type="text" name="pedido_data_inicial" class="form-control input-mask-data" placeholder="00/00/0000">
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-3'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">Dt Final</label>
                                                                    <input type="text" name="pedido_data_final" class="form-control input-mask-data" placeholder="00/00/0000">

                                                                </div>
                                                                <div class='col-sm-11'>
                                                                    <div class='form-group'>
                                                                        <input type="submit" name="export_data" class="btn btn-success btn-sm form-control" value="Gerar" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </div><!-- /.main-content -->
</div>

<?php
require_once '../pagina/footer.php';
?>