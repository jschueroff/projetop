<?php
require_once 'inf_comp_config.php';
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
                <li class="active">Informações Complementares</li>
            </ul><!-- /.breadcrumb -->
        </div>
        <div class="page-content">
            <?php
            require_once '../principal/principal_config.php';
            ?>
            <div class="row">
                <div class="col-xs-12">
                    <form method="POST" enctype="multipart/form-data">
                        <fieldset>
                            <legend>Cadastro</legend>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label  class="control-label">Desc. Resumida</label>
                                        <input name="inf_comp_descricao_resumida" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label  class="control-label">Apelido</label>
                                        <input name="inf_comp_apelido" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label  class="control-label">Interesse</label>
                                        <select name="inf_comp_interesse" class="form-control">
                                            <option value="C">Contribuinte</option>
                                            <option value="F">Fisco</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label  class="control-label">Descrição</label>
                                        <textarea name="inf_comp_descricao" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label  class="control-label">Cód Exp.</label>
                                        <input name="inf_comp_exportacao" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix form-actions">
                                <div class="col-md-offset-10 col-md-9">
                                    <button type="submit" name="btn-cadastro" class="btn btn-success btn-sm">
                                        Cadastrar
                                    </button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>

        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->

<?php
require_once '../pagina/footer.php';
?>