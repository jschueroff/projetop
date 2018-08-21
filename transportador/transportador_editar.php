<?php
require_once 'transportador_config.php';

$id = $_GET['id'];
$stmt2 = $auth_user->runQuery("SELECT * FROM transportador WHERE transportador_id =:id");
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
                                                Editar Transportador
                                            </h4>
                                        </div>

                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class='row'>
                                                            <div class='col-sm-1'>    
                                                                <div class='form-group'>
                                                                    <!--                                                                    <label for="user_title">Nome</label>
                                                                                                                                        <input type="text" name="cliente_nome" id="cliente_nome" class="form-control" placeholder="Nome/Fantasia/CNPJ/CPF" autocomplete="off" required=""/>                                 -->
                                                                    <label class = "control-label"> ID </label>
                                                                    <input type="text" disabled="" id="transportador_id" class="form-control" name="transportador_id"  value="<?php echo $lista['transportador_id']; ?>"/>   
                                                                    <input type="hidden" id="transportador_id" class="form-control" name="transportador_id"  value="<?php echo $lista['transportador_id']; ?>"/>                               

                                                                </div>
                                                            </div>
                                                            <div class='col-sm-6'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">Nome</label>
                                                                    <input type="text" id="trasnportador_nome"  name="transportador_nome" value="<?php echo $lista['transportador_nome']; ?>"  class="form-control" />
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-5'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">Fantasia</label>
                                                                    <input type="text" name="transportador_fantasia" id="transportador_fantasia " class="form-control" value="<?php echo $lista['transportador_fantasia']; ?>"  />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <label>CNPJ/CPF</label>
                                                                    <input type="text" name="transportador_cnpj" id="transportador_cnpj " class="form-control" value="<?php echo $lista['transportador_cnpj']; ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <label>Ins. Estadual</label>
                                                                    <input type="text" name="transportador_ie" id="transportador_ie" class="form-control" value="<?php echo $lista['transportador_ie']; ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>E-mail</label>
                                                                    <input type="text" name="transportador_email" id="transportador_email" class="form-control" value="<?php echo $lista['transportador_email']; ?>"  />
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>E-mail NF-e</label>
                                                                    <input type="text" name="transportador_email_nfe" id="transportador_email_nfe" class="form-control" value="<?php echo $lista['transportador_email_nfe']; ?>" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <label>Telefone</label>
                                                                    <input type="text" name="transportador_telefone" id="transportador_telefone" class="form-control" value="<?php echo $lista['transportador_telefone']; ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <label>Status</label>
                                                                    <select name="transportador_status" class="form-control">
                                                                        <option value="0" <?= ($lista['transportador_status'] == '0') ? 'selected' : '' ?>>Inativo</option>
                                                                        <option value="1" <?= ($lista['transportador_status'] == '1') ? 'selected' : '' ?>>Ativo</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>Endereço</label>
                                                                    <input type="text" name="transportador_logradouro" id="transportador_logradouro" class="form-control" value="<?php echo $lista['transportador_logradouro']; ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <label>Numero</label>
                                                                    <input type="text" name="transportador_numero" id="transportador_numero" class="form-control" value="<?php echo $lista['transportador_numero']; ?>" />
                                                                </div>
                                                            </div>
                                                             <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <label>Complemento</label>
                                                                    <input type="text" name="transportador_complemento" id="transportador_complemento" class="form-control" value="<?php echo $lista['transportador_complemento']; ?>" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                           
                                                            <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <label>CEP</label>
                                                                    <input type="text" name="transportador_cep" id="transportador_cep" class="form-control" value="<?php echo $lista['transportador_cep']; ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>Bairro</label>
                                                                    <input type="text" name="transportador_bairro" id="transportador_bairro" class="form-control" value="<?php echo $lista['transportador_bairro']; ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>Municipio</label>
                                                                    <input type="text" name="transportador_municipio" id="transportador_municipio" class="form-control" value="<?php echo $lista['transportador_municipio']; ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <label>UF</label>
                                                                    <input type="text" name="transportador_uf" id="transportador_municipio" class="form-control" value="<?php echo $lista['transportador_uf']; ?>" />
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix form-actions">
                                            <div class="col-md-offset-10 col-md-9">

                                                <button type="submit" name="btn-salvar" class="btn btn-info btn-xs">
                                                    Alterar
                                                </button>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!--            <div class="row">
                <div class="col-xs-12">
                    <form class="form-horizontal" method="post">

                       
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-tags">Bairro</label>
                            <div class="col-sm-9">
                                <input type="text" name="transportador_bairro" id="transportador_bairro" class="form-control" value="<?php echo $lista['transportador_bairro']; ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-tags">CEP</label>
                            <div class="col-sm-9">
                                <input type="text" name="transportador_cep" id="transportador_cep" class="form-control" value="<?php echo $lista['transportador_cep']; ?>" />
                            </div>
                        </div>



                        <div class="clearfix form-actions">
                            <div class="col-md-offset-3 col-md-9">

                                <button type="submit" name="btn-salvar" class="btn btn-info btn-xs">
                                    Alterar
                                </button>


                            </div>
                        </div>



                    </form>
                </div> /.col 
            </div> /.row -->



<?php
require_once '../pagina/footer.php';
?>