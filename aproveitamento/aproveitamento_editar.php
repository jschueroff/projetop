<?php
require_once 'aproveitamento_config.php';

$id = $_GET['id'];
$stmt2 = $auth_user->runQuery("SELECT * FROM aproveitamento WHERE aproveitamento_id =:id");
$stmt2->execute(array(":id" => $id));
$lista = $stmt2->fetch(PDO::FETCH_ASSOC);

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
                <li class="active">Editar</li>
            </ul><!-- /.breadcrumb -->

        </div>

        <div class="page-content">
            <?php
            require '../principal/principal_config.php';
            ?>
            <div class="row">
                <div class="col-xs-12">
                    <form  method="post"> 
                        <fieldset>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="widget-box">
                                        <div class="widget-header widget-header-flat">
                                            <h4 class="widget-title smaller">
                                                Editar Aprov. ICMS
                                            </h4>
                                        </div>
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class='row'>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label>ID</label>

                                                                    <input type="text" disabled="" id="forma_pagamento_id" name="aproveitamento_id"  value="<?php echo $lista['aproveitamento_id']; ?>" class="form-control"/> 
                                                                    <input type="hidden" id="forma_pagamento_id" name="aproveitamento_id"  value="<?php echo $lista['aproveitamento_id']; ?>" class="form-control"/> 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-6'>    
                                                                <div class='form-group'>
                                                                    <label>Aliquota</label>
                                                                    <input type="text" id="aproveitamento_aliquota"  name="aproveitamento_aliquota" value="<?php echo $lista['aproveitamento_aliquota']; ?>"  class="form-control" />
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-4'>    
                                                                <div class='form-group'>
                                                                    <label>Mes</label>
                                                                    <input type="text" id="aproveitamento_mes"  name="aproveitamento_mes" value="<?php echo $lista['aproveitamento_mes']; ?>"  class="form-control" />
                                                                </div>
                                                            </div>
                                                           
                                                             <div class='col-sm-4'>    
                                                                <div class='form-group'>
                                                                    <label>Ano</label>
                                                                    <input type="text"  name="aproveitamento_ano" value="<?php echo $lista['aproveitamento_ano']; ?>"  class="form-control" />
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <div class="clearfix form-actions">
                            <div class="col-md-offset-10 col-md-9">

                                <button type="submit" name="btn-salvar" class="btn btn-warning btn-sm">
                                    Alterar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->




<?php
require_once '../pagina/footer.php';
?>