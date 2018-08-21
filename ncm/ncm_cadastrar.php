<?php
require_once 'ncm_config.php';
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
                    <form class="form-horizontal" method="post">                        
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">NCM</label>
                            <div class="col-sm-9">
                                <div class="inline">
                                    <input type="text" id="ncm_codigo"  name="ncm_codigo" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-tags">Descriçao</label>
                            <div class="col-sm-9">
                                <input type="text" name="ncm_nome" id="ncm_nome" class="form-control"  />
                            </div>
                        </div>
                        <div class="clearfix form-actions">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" name="btn-cadastro" class="btn btn-info">
                                    Cadastrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->
<?php
require_once '../pagina/footer.php';
?>