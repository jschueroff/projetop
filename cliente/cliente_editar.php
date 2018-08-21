<?php
require_once 'cliente_config.php';

$id = $_GET['id'];
$stmt2 = $auth_user->runQuery("SELECT * FROM cliente WHERE cliente_id =:id");
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
                                                Dados do Cliente
                                            </h4>
                                        </div>

                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class='row'>
                                                            <div class='col-sm-1'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">ID</label>
                                                                    <input type="text" id="cliente_id" name="cliente_id"  disabled="" value="<?php echo $lista['cliente_id']; ?>" class="form-control"/> 
                                                                    <input type="hidden" id="cliente_id" name="cliente_id"  value="<?php echo $lista['cliente_id']; ?>" class="form-control"/> 

                                                                </div>
                                                            </div>
                                                            <div class='col-sm-6'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">Nome</label>
                                                                    <input type="text" id="cliente_nome"  name="cliente_nome" class="form-control" value="<?php echo $lista['cliente_nome']; ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-5'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">Fantasia</label>
                                                                    <input type="text" name="cliente_fantasia" id="cliente_fantasia" class="form-control" value="<?php echo $lista['cliente_fantasia']; ?>"   />
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-3'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">CPF/CNPJ</label>
                                                                    <input type="text" name="cliente_cpf_cnpj" id="cliente_cpf_cnpj" class="form-control" value="<?php echo $lista['cliente_cpf_cnpj']; ?>"  />
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-3'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">Ins. Estadual</label>
                                                                    <input type="text" name="cliente_ie" id="cliente_ie" class="form-control" value="<?php echo $lista['cliente_ie']; ?>"  />
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-3'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">Tipo</label>
                                                                    <select name="cliente_tipo" class="form-control">
                                                                        <option value="1" <?= ($lista['cliente_tipo'] == '1') ? 'selected' : '' ?> >1- Contribuinte</option>
                                                                        <option value="2" <?= ($lista['cliente_tipo'] == '2') ? 'selected' : '' ?> >2- Contribuinte Isento</option>
                                                                        <option value="9" <?= ($lista['cliente_tipo'] == '9') ? 'selected' : '' ?> >9- Não Contribuinte</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-3'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">Consumidor Final</label>
                                                                    <select name="cliente_consumidor" class="form-control">
                                                                        <option value="0" <?= ($lista['cliente_consumidor'] == '0') ? 'selected' : '' ?>>Não</option>
                                                                        <option value="1" <?= ($lista['cliente_consumidor'] == '1') ? 'selected' : '' ?>>Sim</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">Status</label>
                                                                    <select name="cliente_status" class="form-control">
                                                                        <option value="0" <?= ($lista['cliente_status'] == '0') ? 'selected' : '' ?>>Inativo</option>
                                                                        <option value="1" <?= ($lista['cliente_status'] == '1') ? 'selected' : '' ?>>Ativo</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-5'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">E-mail</label>
                                                                    <input type="text" name="cliente_email" id="cliente_email" class="form-control" value="<?php echo $lista['cliente_email']; ?>" />
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-5'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">E-mail NF-e</label>
                                                                    <input type="text" name="cliente_email_nfe" id="cliente_email_nfe" class="form-control" value="<?php echo $lista['cliente_email_nfe']; ?>" />
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-3'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">Municipio</label>
                                                                    <select name="id_municipio" class="form-control">
                                                                        <?php
                                                                        while ($row_mun = $stmt_municipio->fetch(PDO::FETCH_ASSOC)) {
                                                                            if ($lista['id_municipio'] == $row_mun['municipio_id']) {
                                                                                ?>

                                                                                <option value="<?php echo $row_mun['municipio_id'] ?>" selected=""><?php echo $row_mun['municipio_nome'] . "-" . $row_mun['municipio_sigla'] ?></option>
                                                                                <?php
                                                                            } else {
                                                                                ?>

                                                                                <option value="<?php echo $row_mun['municipio_id'] ?>"><?php echo $row_mun['municipio_nome'] . "-" . $row_mun['municipio_sigla'] ?></option>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">Telefone</label>
                                                                    <input type="text" id="cliente_telefone" name="cliente_telefone" class="form-control" value="<?php echo $lista['cliente_telefone']; ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-6'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">Endereço</label>
                                                                    <input type="text" id="cliente_logradouro" name="cliente_logradouro" class="form-control" value="<?php echo $lista['cliente_logradouro']; ?>" />
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-1'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">N°</label>
                                                                    <input type="text" id="cliente_numero" name="cliente_numero" class="form-control" value="<?php echo $lista['cliente_numero']; ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">Complemento</label>
                                                                    <input type="text" id="cliente_complemento" name="cliente_complemento" class="form-control" value="<?php echo $lista['cliente_complemento']; ?>" />
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-6'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">Bairro</label>
                                                                    <input type="text" id="cliente_bairro" name="cliente_bairro" class="form-control" value="<?php echo $lista['cliente_bairro']; ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">CEP</label>
                                                                    <input type="text" id="cliente_cep" name="cliente_cep" class="form-control" value="<?php echo $lista['cliente_cep']; ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">Data Cad.</label>
                                                                    <input type="text" disabled="" class="form-control" value="<?php echo date("d/m/Y", strtotime($lista['cliente_data_cadastro'])); ?>"/>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="clearfix form-actions">
                                                    <div class="col-md-offset-10 col-md-9">
                                                        <button type="submit" name="btn-salvar" class="btn btn-warning btn-xs">
                                                            Alterar
                                                        </button>
                                                    </div>
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




        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->




<?php
require_once '../pagina/footer.php';
?>