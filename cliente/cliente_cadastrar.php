<?php
require_once 'cliente_config.php';
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
            <form  method="post"> 
                <div class="row">
                    <div class="col-xs-12">
                        <legend>Cadastro de Cliente</legend>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nome</label>
                                <input type="text" id="cliente_nome"  name="cliente_nome" class="form-control"  required="" placeholder="Nome Empresa/Cliente"/>
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fantasia</label>
                                <input type="text" name="cliente_fantasia" id="cliente_fantasia" class="form-control" placeholder="Fantasia"  />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>CNPJ</label>
                                <input type="text" name="cliente_cpf_cnpj" id="cliente_cpf_cnpj" class="form-control" placeholder="CNPJ Empresa"/>
                            </div> 
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>CPF</label>
                                <input type="text" name="cliente_cpf" id="cliente_cpf" class="form-control" placeholder="CPF Pessoa"/>
                            </div> 
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>I.E</label>
                                <input type="text" name="cliente_ie" id="cliente_ie" class="form-control"  placeholder="Inscricao Estadual" />
                            </div> 
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tipo</label>

                                <select name="cliente_tipo" class="form-control">
                                    <option value="1">1 - Contribuinte</option>
                                    <option value="2">2 - Contribuinte Isento</option>
                                    <option value="9">9 - Não Contribuinte</option>
                                </select>

                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Cons. Final</label>
                                <select name="cliente_consumidor" class="form-control">
                                    <option value="0">Não</option>
                                    <option value="1">Sim</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="cliente_status"class="form-control">
                                    <option value="1">Ativo</option>
                                   
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Telefone</label>
                                <input type="text" id="cliente_telefone" name="cliente_telefone"   class="form-control" placeholder="Telefone" />
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>E-mail</label>
                                <input type="text" name="cliente_email" id="cliente_email" class="form-control" placeholder="E-mail principal"  />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>E-mail NF-e</label>
                                <input type="text" name="cliente_email_nfe" id="cliente_email_nfe" class="form-control" placeholder="E-mail NF-e" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Logradouro</label>
                                <input type="text" id="cliente_logradouro" name="cliente_logradouro" class="form-control" required=""/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Municipio</label>
                                <select name="id_municipio" class="form-control">
                                    <?php
                                    while ($row_mun = $stmt_municipio->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                        }
                                        <option value="<?php echo $row_mun['municipio_id'] ?>"><?php echo $row_mun['municipio_nome'] . "-" . $row_mun['municipio_sigla'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
<!--                        <div class="col-md-9">
                            <div class="form-group">
                                <label>Logradouro</label>
                                <input type="text" id="cliente_logradouro" name="cliente_logradouro" class="form-control" required=""/>
                            </div>
                        </div>-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>N°</label>
                                <input type="text" id="cliente_numero" name="cliente_numero" class="form-control" required=""/>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Compl.</label>
                                <input type="text" id="cliente_complemento" name="cliente_complemento" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Bairro</label>
                                <input type="text" id="cliente_bairro" name="cliente_bairro" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>CEP</label>
                                <input type="text" id="cliente_cep" name="cliente_cep" class="form-control" required=""/>
                            </div>
                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
                <div class="clearfix form-actions">
                    <div class="col-md-offset-10 col-md-9">
                        <button type="submit" name="btn-cadastro" class="btn btn-success btn-xs">
                            Cadastrar
                        </button>
                    </div>
                </div>
            </form>
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->
<?php
require_once '../pagina/footer.php';
?>