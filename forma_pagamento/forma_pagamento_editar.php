<?php
require_once 'forma_pagamento_config.php';

$id = $_GET['id'];
$stmt2 = $auth_user->runQuery("SELECT * FROM forma_pagamento WHERE forma_pagamento_id =:id");
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
                                                Editar Forma de Pagamento
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

                                                                    <input type="text" disabled="" id="forma_pagamento_id" name="forma_pagamento_id"  value="<?php echo $lista['forma_pagamento_id']; ?>" class="form-control"/> 
                                                                    <input type="hidden" id="forma_pagamento_id" name="forma_pagamento_id"  value="<?php echo $lista['forma_pagamento_id']; ?>" class="form-control"/> 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-6'>    
                                                                <div class='form-group'>
                                                                    <label>Nome</label>
                                                                    <input type="text" id="forma_pagamento_nome"  name="forma_pagamento_nome" value="<?php echo $lista['forma_pagamento_nome']; ?>"  class="form-control" />
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-4'>    
                                                                <div class='form-group'>
                                                                    <label>Vezes</label>
                                                                    <input type="text" id="forma_pagamento_vezes"  name="forma_pagamento_vezes" value="<?php echo $lista['forma_pagamento_vezes']; ?>"  class="form-control" />
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-4'>    
                                                                <div class='form-group'>
                                                                    <label>Tipo</label>
<!--                                                                    <input type="text" id="forma_pagamento_tipo"  name="forma_pagamento_tipo" value="<?php echo $lista['forma_pagamento_tipo']; ?>"  class="form-control" />-->
                                                                    <select class="form-control" name="forma_pagamento_tipo">
                                                                        <option value="0" <?= ($lista['forma_pagamento_tipo'] == '0') ? 'selected' : '' ?>>À VISTA</option>
                                                                        <option value="1" <?= ($lista['forma_pagamento_tipo'] == '1') ? 'selected' : '' ?>>A PRAZO</option>
                                                                        <option value="2" <?= ($lista['forma_pagamento_tipo'] == '2') ? 'selected' : '' ?>>OUTROS</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                             <div class='col-sm-4'>    
                                                                <div class='form-group'>
                                                                    <label>Prazo</label>
                                                                    <input type="text"  name="forma_pagamento_prazo_pag" value="<?php echo $lista['forma_pagamento_prazo_pag']; ?>"  class="form-control" />
                                                                </div>
                                                            </div>
                                                             <div class='col-sm-4'>    
                                                                <div class='form-group'>
                                                                    <label>Percentual</label>
                                                                    <input type="text"  name="forma_pagamento_percentual" value="<?php echo $lista['forma_pagamento_percentual']; ?>"  class="form-control" />
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-4'>    
                                                                <div class='form-group'>
                                                                    <label>Status</label>
<!--                                                                    <input type="text" id="forma_pagamento_tipo"  name="forma_pagamento_tipo" value="<?php echo $lista['forma_pagamento_tipo']; ?>"  class="form-control" />-->
                                                                    <select class="form-control" name="forma_pagamento_status">
                                                                        <option value="0" <?= ($lista['forma_pagamento_status'] == '0') ? 'selected' : '' ?>>INATIVO</option>
                                                                        <option value="1" <?= ($lista['forma_pagamento_status'] == '1') ? 'selected' : '' ?>>ATIVO</option>
                                                                    </select>
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