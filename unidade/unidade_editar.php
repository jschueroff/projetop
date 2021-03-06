<?php
require_once 'unidade_config.php';

$id = $_GET['id'];
$stmt2 = $auth_user->runQuery("SELECT * FROM unidade WHERE unidade_id =:id");
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

            <div class="nav-search" id="nav-search">
                <form class="form-search">
                    <span class="input-icon">
                        <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                        <i class="ace-icon fa fa-search nav-search-icon"></i>
                    </span>
                </form>
            </div><!-- /.nav-search -->
        </div>

        <div class="page-content">
            <?php
            require_once '../principal/principal_config.php';
            ?>

            <div class="row">
                <div class="col-xs-12">
                    <form class="form-horizontal" method="post">

                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right"> ID </label>
                            <div class="col-sm-9">
                                <input type="text" id="unidade_id" name="unidade_id"  value="<?php echo $lista['unidade_id']; ?>" class="col-xs-3 col-sm-2"/>                               
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Unidade</label>

                            <div class="col-sm-3">
                                <input type="text" id="unidade_nome"  name="unidade_nome" value="<?php echo $lista['unidade_nome']; ?>"  class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Descrição</label>

                            <div class="col-sm-9">
                                <input type="text" id="unidade_descricao"  name="unidade_descricao" value="<?php echo $lista['unidade_descricao']; ?>"  class="form-control" />
                            </div>
                        </div>
                        <div class="clearfix form-actions">
                            <div class="col-md-offset-3 col-md-9">

                                <button type="submit" name="btn-salvar" class="btn btn-info">
                                    Alterar
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