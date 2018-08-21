<?php
require_once 'produto_config.php';

$id = $_GET['id'];

$stmt2 = $auth_user->runQuery("SELECT * FROM produto WHERE produto_id =:id");
$stmt2->execute(array(":id" => $id));
$lista = $stmt2->fetch(PDO::FETCH_ASSOC);

$stm = $auth_user->runQuery("SELECT * FROM ncm");
$stm->execute();

$st = $auth_user->runQuery("SELECT * FROM unidade");
$st->execute();

$stmt_st = $auth_user->runQuery("SELECT * FROM st WHERE st_status = 1");
$stmt_st->execute();

$stm_grupo = $auth_user->runQuery("SELECT * FROM grupo");
$stm_grupo->execute();

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
                            <legend>Editar Produto</legend>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>ID Produto</label>
                                        <input type="text" id="produto_id" name="produto_id"  value="<?php echo $lista['produto_id']; ?>" class="form-control"/>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Código Interno</label>
                                        <input type="text" id="produto_codigo"  name="produto_codigo" value="<?php echo $lista['produto_codigo']; ?>"  class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Nome</label>
                                        <input type="text" id="produto_nome"  name="produto_nome" value="<?php echo $lista['produto_nome']; ?>"  class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Descrição Resumida</label>
                                        <input type="text" id="produto_descricao"  name="produto_descricao" value="<?php echo $lista['produto_descricao']; ?>"  class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Preço</label>
                                        <input type="text" name="produto_preco" id="produto_preco" value="<?php echo $lista['produto_preco'] ?>" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label >EAN/Cód Barras</label>
                                        <input type="text" name="produto_ean" id="produto_ean" value="<?php echo $lista['produto_ean'] ?>" class="form-control"/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Unidade</label>
                                        <select class="form-control" id="id_unidade" name="id_unidade">
                                            <?php
                                            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                                                if ($row['unidade_id'] == $lista['id_unidade']) {
                                                    ?>
                                                    <option selected="" value="<?php echo $row['unidade_id']; ?>"><?php echo $row['unidade_nome'] . ' ==> ' . $row['unidade_descricao']; ?></option>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <option value="<?php echo $row['unidade_id']; ?>"><?php echo $row['unidade_nome'] . ' ==> ' . $row['unidade_descricao']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>NCM</label>
                                        <select class="form-control" id="id_ncm" name="id_ncm">
                                            <?php
                                            while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {

                                                if ($row['ncm_id'] == $lista['id_ncm']) {
                                                    ?>
                                                    <option selected="" value="<?php echo $row['ncm_id']; ?>"><?php echo $row['ncm_codigo'] . ' ==> ' . $row['ncm_nome']; ?></option>

                                                    <?php
                                                } else {
                                                    ?>
                                                    <option value="<?php echo $row['ncm_id']; ?>"><?php echo $row['ncm_codigo'] . ' ==> ' . $row['ncm_nome']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Data Cadastro</label>
                                        <input type="text" name="produto_data_cadastro" disabled="" id="produto_data_cadastro" value="<?php echo date("d/m/Y H:m", strtotime($lista['produto_data_cadastro'])); ?>" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Grupo/Sub-Grupo</label>
                                        <select class="form-control" id="id_grupo" name="id_grupo">
                                            <?php
                                            while ($row = $stm_grupo->fetch(PDO::FETCH_ASSOC)) {
                                                if ($row['grupo_id'] == $lista['id_grupo']) {
                                                    ?>
                                                    <option selected="" value="<?php echo $row['grupo_id']; ?>"><?php echo $row['grupo_nome'] . ' ==> ' . $row['grupo_descricao']; ?></option>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <option value="<?php echo $row['grupo_id']; ?>"><?php echo $row['grupo_nome'] . ' ==> ' . $row['grupo_descricao']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Categoria</label>
                                        <select id="produto_categoria" name="produto_categoria" class="form-control">
                                            <option value="1" <?= ($lista['produto_categoria'] == '1') ? 'selected' : '' ?>>Revenda</option>
                                            <option value="2" <?= ($lista['produto_categoria'] == '2') ? 'selected' : '' ?>>Produto Acabado</option>
                                            <option value="3" <?= ($lista['produto_categoria'] == '3') ? 'selected' : '' ?>>Produto Intermediário</option>
                                            <option value="4" <?= ($lista['produto_categoria'] == '4') ? 'selected' : '' ?>>Insumos de Produção</option>
                                            <option value="5" <?= ($lista['produto_categoria'] == '5') ? 'selected' : '' ?>>Consumo</option>
                                            <option value="6" <?= ($lista['produto_categoria'] == '6') ? 'selected' : '' ?>>Serviços</option>
                                            <option value="7" <?= ($lista['produto_categoria'] == '7') ? 'selected' : '' ?>>Embalagens</option>
                                            <option value="8" <?= ($lista['produto_categoria'] == '8') ? 'selected' : '' ?>>Outros</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Peso Liquido</label>
                                        <input type="text" name="produto_peso_liquido" id="produto_peso_liquido" value="<?php echo $lista['produto_peso_liquido'] ?>" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Peso Bruto</label>
                                        <input type="text" name="produto_peso_bruto" id="produto_peso_bruto" value="<?php echo $lista['produto_peso_bruto'] ?>" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Controle de Estoque</label>
                                        <select id="produto_controle_estoque" name="produto_controle_estoque" class="form-control">
                                            <option value="0" <?= ($lista['produto_controle_estoque'] == '0') ? 'selected' : '' ?>>Nao</option>
                                            <option value="1" <?= ($lista['produto_controle_estoque'] == '1') ? 'selected' : '' ?>>Sim</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <legend>Tributação</legend>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Situação Tributaria</label>
                                        <select class="form-control" id="id_st" name="id_st">
                                            <?php
                                            while ($row1 = $stmt_st->fetch(PDO::FETCH_ASSOC)) {
                                                if ($row1['st_id'] == $lista['id_st']) {
                                                    ?>
                                                    <option selected="" value="<?php echo $row1['st_id']; ?>"><?php echo $row1['st_nome']; ?></option>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <option value="<?php echo $row1['st_id']; ?>"><?php echo $row1['st_nome']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Origem</label>
                                        <select class="form-control" name="produto_origem">
                                             
                                            <option value="0" <?= ($lista['produto_origem'] == '0') ? 'selected' : '' ?>>0- Nacional, exceto as indicadas nos códigos 3, 4, 5 e 8</option>
                                            <option value="1" <?= ($lista['produto_origem'] == '1') ? 'selected' : '' ?>>1- Estrangeira - Importação direta, exceto a indicada no código 6</option>
                                            <option value="2" <?= ($lista['produto_origem'] == '2') ? 'selected' : '' ?>>2- Estrangeira - Adquirida no mercado interno, exceto a indicada no código 7</option>
                                            <option value="3" <?= ($lista['produto_origem'] == '3') ? 'selected' : '' ?>>3- Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40% (quarenta por cento) e inferior ou igual a 70% (setenta por cento</option>
                                            <option value="4" <?= ($lista['produto_origem'] == '4') ? 'selected' : '' ?>>4- Nacional, cuja produção tenha sido feita em conformidade com os processos produtivos básicos de que tratam o Decreto-Lei nº 288/67, e as Leis nºs 8.248/91, 8.387/91, 10.176/01 e 11.484/07</option>
                                            <option value="5" <?= ($lista['produto_origem'] == '5') ? 'selected' : '' ?>>5- Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40% (quarenta por cento)</option>
                                            <option value="6" <?= ($lista['produto_origem'] == '6') ? 'selected' : '' ?>>6- Estrangeira - Importação direta, sem similar nacional, constante em lista de Resolução CAMEX e gás natural</option>
                                            <option value="7" <?= ($lista['produto_origem'] == '7') ? 'selected' : '' ?>>7- Estrangeira - Adquirida no mercado interno, sem similar nacional, constante em lista de Resolução CAMEX e gás natural</option>
                                            <option value="8" <?= ($lista['produto_origem'] == '8') ? 'selected' : '' ?>>8- Nacional, mercadoria ou bem com Conteúdo de Importação superior a 70% (setenta por cento)</option>
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="clearfix form-actions">
                                <div class="col-md-offset-10 col-md-9">
                                    <button type="submit" name="btn-salvar" class="btn btn-info btn-sm">
                                        Alterar
                                    </button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>



            <!--            <div class="row">
                            <div class="col-xs-12">
                                <form class="form-horizontal" method="post">
            
                                                            <div class="form-group">
                                                                <label class="col-sm-1 control-label no-padding-right"> ID </label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" id="produto_id" name="produto_id"  value="<?php echo $lista['produto_id']; ?>" class="col-xs-3 col-sm-2"/>
                                                                </div>
                                                            </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Nome</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="produto_nome"  name="produto_nome" value="<?php echo $lista['produto_nome']; ?>"  class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Descr.</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="produto_descricao"  name="produto_descricao" value="<?php echo $lista['produto_descricao']; ?>"  class="form-control" />
                                        </div>
                                    </div>
            
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Código</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="produto_codigo"  name="produto_codigo" value="<?php echo $lista['produto_codigo']; ?>"  class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label no-padding-right" for="form-field-tags">Preço</label>
                                        <div class="col-sm-9">
                                            <div class="inline">
                                                <input type="text" name="produto_preco" id="produto_preco" value="<?php echo $lista['produto_preco'] ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label no-padding-right" for="form-field-tags">EAN</label>
                                        <div class="col-sm-9">
                                            <div class="inline">
                                                <input type="text" name="produto_ean" id="produto_ean" value="<?php echo $lista['produto_ean'] ?>" />
                                            </div>
                                        </div>
                                    </div>
            
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">NCM</label>
                                        <div class="col-sm-9">
                                            <select class="col-sm-10" id="produto_ncm" name="produto_ncm">
            <?php
            while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {

                if ($row['ncm_id'] == $lista['id_ncm']) {
                    ?>
                                                                                                                        <option selected="" value="<?php echo $row['ncm_id']; ?>"><?php echo $row['ncm_codigo'] . ' ==> ' . $row['ncm_nome']; ?></option>
                                                                            
                    <?php
                } else {
                    ?>
                                                                                                                        <option value="<?php echo $row['ncm_id']; ?>"><?php echo $row['ncm_codigo'] . ' ==> ' . $row['ncm_nome']; ?></option>
                    <?php
                }
            }
            ?>
            
                                            </select>
            
                                        </div>
                                    </div>
            
            
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Unidade</label>
                                        <div class="col-sm-9">
                                            <select class="col-sm-10" id="produto_unidade" name="produto_unidade">
            <?php
            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {

                if ($row['unidade_id'] == $lista['id_unidade']) {
                    ?>
                                                                                                                        <option selected="" value="<?php echo $row['unidade_id']; ?>"><?php echo $row['unidade_nome'] . ' ==> ' . $row['unidade_descricao']; ?></option>
                                                                            
                    <?php
                } else {
                    ?>
                                                                                                                        <option value="<?php echo $row['unidade_id']; ?>"><?php echo $row['unidade_nome'] . ' ==> ' . $row['unidade_descricao']; ?></option>
                    <?php
                }
            }
            ?>
            
                                            </select>
            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">S.T</label>
                                        <div class="col-sm-9">
                                            <select class="col-sm-10" id="id_st" name="id_st">
            
            <?php
            while ($row1 = $stmt_st->fetch(PDO::FETCH_ASSOC)) {
                if ($row1['st_id'] == $lista['id_st']) {
                    ?>
                                                                                                                        <option selected="" value="<?php echo $row1['st_id']; ?>"><?php echo $row1['st_nome']; ?></option>
                                                                            
                    <?php
                } else {
                    ?>
                                                                                                                        <option value="<?php echo $row1['st_id']; ?>"><?php echo $row1['st_nome']; ?></option>
                    <?php
                }
            }
            ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label no-padding-right" for="form-field-tags">D. Cadas.</label>
            
                                        <div class="col-sm-9">
                                            <div class="inline">
                                                <input type="text" name="produto_data_cadastro" id="produto_data_cadastro" value="<?php echo $lista['produto_data_cadastro'] ?>" />
                                            </div>
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
                            </div> /.col 
                        </div> /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->




<?php
require_once '../pagina/footer.php';
?>