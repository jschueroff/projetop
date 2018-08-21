
<?php
require_once 'backup_config.php';
require_once '../pagina/menu.php';

$resultado = 0;
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
                <li class="active">Backup do Banco de Dados</li>
            </ul><!-- /.breadcrumb -->

        </div>

        <div class="page-content">

            <?php
            include '../principal/principal_config.php';
            ?>



            <div class="row">
                <div class="col-xs-12">
                    <div id="error">
                        <?php
                        if ($resultado) {
                            ?>
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">
                                    <i class="ace-icon fa fa-times"></i>
                                </button>
                                <strong>Backup Efetuado com Sucesso !</strong>
                                
                                <br />
                            </div>
                            <?php
                        }
                        ?>
                    </div>

                    <fieldset>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="widget-box">
                                    <div class="widget-header widget-header-flat">
                                        <h4 class="widget-title smaller">
                                            Local Backup
                                        </h4>
                                    </div>

                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <div class="row">
                                                <div id="error">

                                                </div>
                                                <div class="col-xs-12">
                                                    <div class='row'>
                                                        <!--                                                        <form  method="post">-->
                                                        <label class="form-control">**Colocar o Caminho para Salvar o Arquivo Backup do Banco. Colocar o (/) no final conforme abaixo. Verificar o tamanho do Arquivo Salvo**</label>

                                                        <form enctype="multipart/form-data" method="POST">
                                                            <div class='col-sm-8'>    
                                                                <div class='form-group'>
                                                                    <input type="text" name="caminho" class="form-control" placeholder="Exemplo ==> C:/Users/Usuario/Desktop/"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <div class="form-group">

                                                                    <button class="btn btn-primary btn-sm" name="submit_caminho" type="submit">
                                                                        <i class="ace-icon fa fa-database bigger-100 white"></i>
                                                                        Salvar Backup
                                                                    </button>
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
    </div>
</div>
<?php
require_once '../pagina/footer.php';
?>