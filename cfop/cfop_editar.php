<?php
require_once 'cfop_config.php';

$id = $_GET['id'];
$stmt2 = $auth_user->runQuery("SELECT * FROM cfop WHERE cfop_id =:id");
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
            include_once '../principal/principal_config.php';
            ?>
            <div class="row">
                <div class="col-xs-12">
                    <form  method="post"> 
                        <fieldset>
                            <legend>Editar CFOP</legend>

                            <div class='row'>
                                <div class='col-sm-2'>    
                                    <div class='form-group'>
                                        <label for="user_title">ID</label>
                                        
                                        <input type="text" id="cfop_id"  name="cfop_id" class="form-control" value="<?php echo $lista['cfop_id']; ?>" disabled="" />                
                                        <input type="hidden" id="cfop_id"  name="cfop_id" value="<?php echo $lista['cfop_id']; ?>" />
                                    </div>
                                </div>
                                <div class='col-sm-2'>    
                                    <div class='form-group'>
                                        <label for="user_title">Cód CFOP</label>
                                        <input type="text" id="cfop_codigo"  name="cfop_codigo" class="form-control" value="<?php echo $lista['cfop_codigo']; ?>" />                
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label>Descriçao</label>
                                        <input type="text" name="cfop_descricao" id="cfop_descricao" class="form-control" value="<?php echo $lista['cfop_descricao']; ?>" />
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Aplicação</label>
                                        <textarea name="cfop_aplicacao" class="form-control"><?php echo $lista['cfop_aplicacao']; ?>
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix form-actions">
                                <div class="col-md-offset-10 col-md-9">
                                    <button type="submit" name="btn-salvar" class="btn btn-warning btn-sm">
                                        Alterar
                                    </button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>

         
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->




<?php
require_once '../pagina/footer.php';
?>