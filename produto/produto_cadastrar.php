<?php
require_once 'produto_config.php';

$stm = $auth_user->runQuery("SELECT * FROM ncm");
$stm->execute();

$st = $auth_user->runQuery("SELECT * FROM unidade");
$st->execute();

$stm_grupo = $auth_user->runQuery("SELECT * FROM grupo");
$stm_grupo->execute();

$stmt_st = $auth_user->runQuery("SELECT * FROM st WHERE st_status = 1");
$stmt_st->execute();

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
                <li class="active">Cadastrar Produto</li>
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
                            <legend>Cadastro Produto</legend>
                            <div class='row'>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Código Interno</label>
                                        <input type="text" id="produto_codigo"  name="produto_codigo"  class="form-control" />
                                    </div>
                                </div>
                                <div class='col-sm-10'>    
                                    <div class='form-group'>
                                        <label>Nome</label>
                                        <input type="text" id="produto_nome"  name="produto_nome" class="form-control" required=""/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label >Descrição Resumida</label>
                                        <input type="text" id="produto_descricao"  name="produto_descricao"  class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Preço</label>
                                        <input type="text" name="produto_preco" id="produto_preco" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>EAN</label>
                                        <input type="text" name="produto_ean" id="produto_ean" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>NCM</label>
                                        <select class="form-control" id="id_ncm" name="id_ncm" required="">
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
                                        <label>Unidade de Medida</label>
                                        <select class="form-control" id="id_unidade" name="id_unidade" required="">
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
                                        <label>Ativo</label>
                                        <select class="form-control" name="produto_status" disabled="">
                                            <option value="1" selected="">SIM</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Categoria</label>
                                        <select class="form-control" name="produto_categoria">
                                            <option value="1">Revenda</option>
                                            <option value="2" selected="">Produto Acabado</option>
                                            <option value="3">Produto Intermediário</option>
                                            <option value="4">Insumos de Produção</option>
                                            <option value="5">Consumo</option>
                                            <option value="6">Serviços</option>
                                            <option value="7">Embalagens</option>
                                            <option value="8">Outros</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Peso Líquido</label>
                                        <input class="form-control" name="produto_peso_liquido" >
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Peso Bruto</label>
                                        <input class="form-control" name="produto_peso_bruto" >
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Controlar Estoque</label>
                                        <select class="form-control" name="produto_controle_estoque">
                                            <option value="0">Não</option>
                                            <option value="1">Sim</option>
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
                                                ?>
                                                <option value="<?php echo $row1['st_id']; ?>"><?php
                                                    if ($row1['st_tipo'] == 1) {
                                                        echo $row1['st_nome'] . " ==> ENTRADA";
                                                    } else {
                                                        echo $row1['st_nome'] . " ==> SAIDA";
                                                    }
                                                    ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Origem</label>
                                        <select class="form-control" name="produto_origem">
                                            <option value="0" selected="">0- Nacional, exceto as indicadas nos códigos 3, 4, 5 e 8</option>
                                            <option value="1">1- Estrangeira - Importação direta, exceto a indicada no código 6</option>
                                            <option value="2">2- Estrangeira - Adquirida no mercado interno, exceto a indicada no código 7</option>
                                            <option value="3">3- Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40% (quarenta por cento) e inferior ou igual a 70% (setenta por cento</option>
                                            <option value="4">4- Nacional, cuja produção tenha sido feita em conformidade com os processos produtivos básicos de que tratam o Decreto-Lei nº 288/67, e as Leis nºs 8.248/91, 8.387/91, 10.176/01 e 11.484/07</option>
                                            <option value="5">5- Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40% (quarenta por cento)</option>
                                            <option value="6">6- Estrangeira - Importação direta, sem similar nacional, constante em lista de Resolução CAMEX e gás natural</option>
                                            <option value="7">7- Estrangeira - Adquirida no mercado interno, sem similar nacional, constante em lista de Resolução CAMEX e gás natural</option>
                                            <option value="8">8- Nacional, mercadoria ou bem com Conteúdo de Importação superior a 70% (setenta por cento)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix form-actions">
                                <div class="col-md-offset-11 col-md-11">
                                    <button type="submit" name="btn-cadastro" class="btn btn-info btn-sm">
                                        Cadastrar
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
                                        <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Nome</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="produto_nome"  name="produto_nome" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Descr.</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="produto_descricao"  name="produto_descricao"  class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Código</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="produto_codigo"  name="produto_codigo"  class="form-control" />
                                        </div>
                                    </div>
            
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label no-padding-right" for="form-field-tags">Preço</label>
                                        <div class="col-sm-9">
                                            <div class="inline">
                                                <input type="text" name="produto_preco" id="produto_preco"  />
                                            </div>
                                        </div>
                                    </div>
            
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label no-padding-right" for="form-field-tags">EAN</label>
                                        <div class="col-sm-9">
                                            <div class="inline">
                                                <input type="text" name="produto_ean" id="produto_ean"  />
                                            </div>
                                        </div>
                                    </div>
            
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">NCM</label>
                                        <div class="col-sm-9">
                                            <select class="col-sm-10" id="produto_ncm" name="produto_ncm" required="">
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
                                            <select class="col-sm-10" id="produto_unidade" name="produto_unidade" required="">
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
                                        <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Grupo/Sub-Grupo</label>
                                        <div class="col-sm-9">
                                            <select class="col-sm-10" id="produto_grupo" name="produto_grupo">
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
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">S.T</label>
                                        <div class="col-sm-9">
                                            <select class="col-sm-10" id="id_st" name="id_st">
                                                <option value=""> =========</option>
            <?php
            while ($row1 = $stmt_st->fetch(PDO::FETCH_ASSOC)) {
                ?>
                                                                                                                                <option value="<?php echo $row1['st_id']; ?>"><?php
                if ($row1['st_tipo'] == 1) {
                    echo $row1['st_nome'] . " ==> ENTRADA";
                } else {
                    echo $row1['st_nome'] . " ==> SAIDA";
                }
                ?></option>
                <?php
            }
            ?>
                                            </select>
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
                            </div> /.col 
                        </div> /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->




<?php
require_once '../pagina/footer.php';
?>