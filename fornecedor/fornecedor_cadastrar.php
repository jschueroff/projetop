<?php
require_once 'fornecedor_config.php';

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
                <li class="active">Cadastro Fornecedor</li>
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
                                                Cadastro Fornecedor
                                            </h4>
                                        </div>

                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class='row'>
                                                            <div class='col-sm-7'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">Nome</label>
                                                                    <input type="text"  name="fornecedor_nome"  class="form-control" />
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-5'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">Fantasia</label>
                                                                    <input type="text" name="fornecedor_fantasia"  class="form-control" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <label>CNPJ/CPF</label>
                                                                    <input type="text" name="fornecedor_cnpj" class="form-control"  />
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <label>Ins. Estadual</label>
                                                                    <input type="text" name="fornecedor_ie" class="form-control"  />
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>E-mail</label>
                                                                    <input type="text" name="fornecedor_email"  class="form-control"   />
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>E-mail NF-e</label>
                                                                    <input type="text" name="fornecedor_email_nfe" class="form-control"  />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <label>Telefone</label>
                                                                    <input type="text" name="fornecedor_telefone" class="form-control"  />
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <label>Status</label>
                                                                    <select name="fornecedor_status" class="form-control">
                                                                        <option value="0" disabled="">Inativo</option>
                                                                        <option value="1" selected="">Ativo</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>Endereço</label>
                                                                    <input type="text" name="fornecedor_logradouro"  class="form-control"  />
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <label>Numero</label>
                                                                    <input type="text" name="fornecedor_numero" class="form-control"  />
                                                                </div>
                                                            </div>
                                                             <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <label>Complemento</label>
                                                                    <input type="text" name="fornecedor_complemento" class="form-control"  />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                           
                                                            <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <label>CEP</label>
                                                                    <input type="text" name="fornecedor_cep"  class="form-control"  />
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>Bairro</label>
                                                                    <input type="text" name="fornecedor_bairro" class="form-control"  />
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>Municipio</label>
                                                                    <input type="text" name="fornecedor_nome_municipio"  class="form-control"  />
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <label>UF</label>
                                                                    <input type="text" name="fornecedor_uf" class="form-control"  />
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix form-actions">
                                            <div class="col-md-offset-10 col-md-9">

                                                <button type="submit" name="btn-cadastro" class="btn btn-success btn-xs">
                                                    Cadastrar
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