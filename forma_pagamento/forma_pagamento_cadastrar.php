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
                <li class="active">Cadastro</li>
            </ul><!-- /.breadcrumb -->
        </div>
        <div class="page-content">
            <?php
            require_once '../principal/principal_config.php';
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
                                                Cadastro Forma de Pagamento
                                            </h4>
                                        </div>
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class='row'>

                                                            <div class='col-sm-6'>    
                                                                <div class='form-group'>
                                                                    <label>Nome</label>
                                                                    <input type="text" id="forma_pagamento_nome"  name="forma_pagamento_nome"   class="form-control" />
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label>Vezes</label>
                                                                    <input type="text" id="forma_pagamento_vezes"  name="forma_pagamento_vezes"   class="form-control" />
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label>Tipo</label>
                                                                    <select class="form-control" name="forma_pagamento_tipo">
                                                                        <option value="0" >À VISTA</option>
                                                                        <option value="1" >A PRAZO</option>
                                                                        <option value="2" >OUTROS</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label>Prazo</label>
                                                                    <input type="text" name="forma_pagamento_prazo_pag"   class="form-control" placeholder="Ex: 30/60/90"/>
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label>Percentual</label>
                                                                    <input type="text" name="forma_pagamento_percentual"   class="form-control" placeholder="Ex: 33/33/34 "/>
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

                                <button type="submit" name="btn-cadastro" class="btn btn-success btn-sm">
                                    Cadastrar
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