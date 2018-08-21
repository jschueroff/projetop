<?php
require_once 'configura_config.php';
require_once '../pagina/menu.php';

$stmt_confi = $auth_user->runQuery("SELECT * FROM configura");
$stmt_confi->execute();
$conf = $stmt_confi->fetch(PDO::FETCH_ASSOC);


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
                <li class="active">Configurações</li>
            </ul><!-- /.breadcrumb -->

        </div>

        <div class="page-content">
            <?php
            include_once '../principal/principal_config.php';
            ?>

            <div class="row">
                <div class="col-xs-12">
                    <form  method="post"> 
                        <fieldset>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="widget-box">
                                        <div class="widget-header widget-header-flat">
                                            <h4 class="widget-title smaller">
                                                Sistema
                                            </h4>
                                        </div>
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class='row'>
                                                            <div class='col-sm-3'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">Calc. Peso</label>
                                                                    <select name="configura_calculo_peso" class="form-control">
                                                                        <option value="0" <?= ( $conf['configura_calculo_peso'] == '0') ? 'selected' : '' ?>>Não</option>
                                                                        <option value="1" <?= ( $conf['configura_calculo_peso'] == '1') ? 'selected' : '' ?>>Sim</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-3'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">Calc. Vol.</label>
                                                                    <select name="configura_calculo_volume" class="form-control">
                                                                        <option value="0" <?= ( $conf['configura_calculo_volume'] == '0') ? 'selected' : '' ?>>Não</option>
                                                                        <option value="1" <?= ( $conf['configura_calculo_volume'] == '1') ? 'selected' : '' ?>>Sim</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="widget-box">
                                        <div class="widget-header widget-header-flat">
                                            <h4 class="widget-title smaller">
                                                Empresa
                                            </h4>
                                        </div>

                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="row">
                                                    <div class="col-xs-12">

                                                        <div class='row'>


                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">Calc. Peso</label>
                                                                    <input type="checkbox" name="configura_calculo_peso"  class="form-control"  />
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">Calc. Vol.</label>
                                                                    <input type="checkbox" name="configura_calculo_volume"  class="form-control"  />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <div class="clearfix form-actions">
                            <div class="col-md-offset-10 col-md-10">
                                <button type="submit" name="btn-cadastro_config" class="btn btn-xs btn-success">
                                    Salvar
                                </button>
                            </div>
                        </div>
                    </form>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
    </div><!-- /.main-content -->

    <?php
    require_once '../pagina/footer.php';
    ?>