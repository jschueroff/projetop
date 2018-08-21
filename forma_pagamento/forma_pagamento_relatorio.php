<?php
require_once 'forma_pagamento_config.php';
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
                <li class="active">Forma Pagamento</li>
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
                            <div class="col-sm-6">
                                <div class="widget-box">
                                    <div class="widget-header widget-header-flat">
                                        <h4 class="widget-title smaller">
                                            Relatorios Forma Pagamento
                                        </h4>
                                    </div>

                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class='row'>
                                                        <form method="post" action="forma_pagamento_export.php"> 
                                                        <div class='col-sm-6'>    
                                                            <div class='form-group'>
                                                                <label for="user_title"></label>
                                                                <select name="modelo" class="form-control">
                                                                    <option value="0"selected="">Selecione</option>
                                                                    <option value="excel">Formas de Pagamentos Ativos em Excel</option>
                                                                    <option value="txt">Formas de Pagamentos Ativos em TXT</option>
                                                                    <option value="txt_todos">Todas Formas de Pagamentos em TXT</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class='col-sm-6'>    
                                                            <div class='form-group'>
                                                                <label for="user_title"> </label>
                                                                <input type="submit" name="export_" class="btn btn-success btn-sm form-control" value="Gerar" />
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