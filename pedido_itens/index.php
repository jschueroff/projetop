<?php
require_once 'pedido_itens_config.php';
require_once '../pagina/menu.php';

$id = $_GET['id'];
$identificador = $_GET['id'];

$stmt = $auth_user->runQuery("SELECT * FROM pedido_itens, produto WHERE produto_status = 1 AND produto_id = id_produto and id_pedido ='" . $id . "' ORDER BY pedido_itens_id ASC");
$stmt->execute();

$st = $auth_user->total($id);
$st2 = $auth_user->totais($id);

$stmt_busca_st = $auth_user->runQuery("SELECT * FROM st WHERE st_status = 1");
$stmt_busca_st->execute();

$stmt_busca_tes = $auth_user->runQuery("SELECT * FROM tes WHERE tes_status = 1");
$stmt_busca_tes->execute();

$stmt_transporte = $auth_user->runQuery("SELECT * FROM transportador WHERE transportador_status = 1");
$stmt_transporte->execute();
//DADOS DO PEDIDO
$stmt_busca_ped = $auth_user->runQuery("SELECT * FROM pedido WHERE pedido_id =:pedido_id");
$stmt_busca_ped->execute(array(":pedido_id" => $identificador));
$pedi = $stmt_busca_ped->fetch(PDO::FETCH_ASSOC);
// DADOS DE INFORMAÇÕES COMPLEMENTARES PARA A NFE
$stmt_inf_c = $auth_user->runQuery("SELECT * FROM inf_comp WHERE inf_comp_status = 1");
$stmt_inf_c->execute();
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
                <li class="active">Pedidos</li>
            </ul><!-- /.breadcrumb -->           
        </div>
        <div class="page-content">
            <?php
            require_once '../principal/principal_config.php';
            ?>

            <div class="col-sm-12">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="widget-box">
                            <div class="widget-header widget-header-flat">
                                <h4 class="smaller">
                                    Cadastro Produtos Pedido
                                </h4>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main">
                                    <fieldset>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <form  method="post">                          
                                                            <div class="col-sm-9">
                                                                <input type="text" id="produto_pesquisa" name="produto_pesquisa" class="col-xs-3 col-sm-9" autofocus="" placeholder="Pesquisar ID/Produto"/>
                                                                <button class="btn btn-info btn-sm" name="btn-pesquisar" type="submit">
                                                                    <i class="ace-icon fa fa-filter bigger-120 blue"></i>
                                                                    Pesquisar
                                                                </button>
                                                            </div>
                                                        </form>
                                                        <button type="button" class="btn btn-sm btn-default" 
                                                                data-toggle="modal" data-target="#novoinfadicionais" 
                                                                data-id_pedido="<?php echo $identificador; ?>"
                                                                data-id_transportador="<?php echo $pedi['id_transportador']; ?>"
                                                                data-pedido_valor_frete="<?php echo $pedi['pedido_valor_frete']; ?>"
                                                                >Outras Inf.</button>

                                                        <button type="button" class="btn btn-sm btn-primary" 
                                                                data-toggle="modal" data-target="#novodadosnfe" 
                                                                data-id_pedido="<?php echo $identificador; ?>"
                                                                data-pedido_peso_liquido="<?php echo $pedi['pedido_peso_liquido']; ?>"
                                                                data-pedido_peso_bruto="<?php echo $pedi['pedido_peso_bruto']; ?>"
                                                                data-pedido_quantidade="<?php echo $pedi['pedido_quantidade']; ?>"
                                                                data-pedido_especie="<?php echo $pedi['pedido_especie']; ?>"
                                                                data-pedido_marca="<?php echo $pedi['pedido_marca']; ?>"
                                                                data-pedido_inf_nfe="<?php echo $pedi['pedido_inf_nfe']; ?>"
                                                                data-pedido_inf_comp="<?php echo $pedi['pedido_inf_comp']; ?>"
                                                                data-pedido_referencia="<?php echo $pedi['pedido_referencia']; ?>"

                                                                >Dados NF-e</button>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <table border="0" class="table table-condensed table-hover table-bordered table-responsive table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th class="hidden-480">Nome</th>                                           
                                                                <th class="hidden-480">EST.</th>
                                                                <th class="hidden-480">Status</th>
                                                                <th class="hidden-480">Valor</th>                                           
                                                                <th class="hidden-480">Incluir</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
                                                                ?>
                                                            <form class="form-horizontal" method="post"> 
                                                                <tr>
                                                                <input type="hidden" name="id_pedido" value="<?php echo $id; ?>">
                                                                <input type="hidden" name="id_produto" required=""value="<?php echo $row['produto_id']; ?>" />
                                                                <th><label><?php echo $row['produto_id']; ?></label></th>
                                                                <th class="hidden-480 form-group"><input type="hidden" name="produto_nome" required=""value="<?php echo $row['produto_nome']; ?>" /><label><?php echo $row['produto_nome']; ?></label></th>                                           
                                                                <th class="hidden-480"><?php echo $row['estoque_quantidade']; ?></th>
                                                                <th class="hidden-480"><?php
                                                                    if ($row['produto_status'] == 0) {
                                                                        echo "Inativo";
                                                                    } else {
                                                                        echo "Ativo";
                                                                    }
                                                                    ?></th>
                                                                <th class="hidden-480"><?php echo $row['produto_preco']; ?></th>
                                                                <th class="hidden-480">
                                                                    <!--                                            <button class="btn btn-sm btn-success" name="btn-cadastro" type="submit">
                                                                                                                    <i class="ace-icon fa fa-floppy-o bigger-60 green"></i>
                                                                                                                    Novo
                                                                                                                </button>-->
                                                                    <button type="button" class="btn btn-xs btn-success" 
                                                                            data-toggle="modal" data-target="#novoprodutoitem" 
                                                                            data-id_pedido="<?php echo $id; ?>"
                                                                            data-id_produto="<?php echo $row['produto_id']; ?>"
                                                                            data-produto_nome="<?php echo $row['produto_nome']; ?>"
                                                                            data-produto_preco="<?php echo $row['produto_preco']; ?>"
                                                                            >Novo</button>
                                                                </th>
                                                                </tr>
                                                            </form>

                                                            <?php
                                                        }
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset>  
                                        <legend>Produtos/Serviços</legend>
                                      
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <table id="simple-table" class="table table-striped table-responsive table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th class="hidden-480">Prod/Serv.</th>                                           
                                                            <th class="hidden-480">Peso T.</th>
                                                            <th class="hidden-480">QTD</th>
                                                            <th class="hidden-480">Valor</th>
                                                            <th class="hidden-480">Total</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $id = 1;
                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                            $valor[$id] = $row['pedido_itens_id'];
                                                            ?>
                                                        <form method="post" id="login-form">
                                                            <tr>
                                                                <td><?php echo $row['pedido_itens_id']; ?></td>
                                                                <td class="hidden-480"><?php echo $row['produto_nome']; ?></td>
                                                                <td class="hidden-480"><?php echo number_format(($row['produto_peso_bruto'] * $row['pedido_itens_qtd']), 3, ',', '') ; ?></td>                                              
                                                                <td class="hidden-480"><?php echo $row['pedido_itens_qtd']; ?></td>
                                                                <td class="hidden-480"><?php echo $row['pedido_itens_valor']; ?></td>
                                                                <td class="hidden-480"><?php echo $row['pedido_itens_total']; ?></td>
                                                            </tr>
                                                            <tr>

                                                            </tr>
                                                        </form>
                                                        <?php
                                                        $id++;
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td colspan="5">
                                                            SubTotal
                                                        </td>
                                                        <td colspan="3" >
                                                            <?php
                                                            echo $st2;
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div><!-- /.span -->
                                        </div><!-- /.row -->
                                        <!-- PAGE CONTENT ENDS -->
                                    </fieldset>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->
<!--CADASTRA NOVO ITEM NO PEDIDO-->
<div class="modal fade" id="novoprodutoitem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Cadastro ICMS/ICMS-ST</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <fieldset>
                        <legend>Dados do Produto</legend>
                        <div class="row">
                            <input name="id_pedido" type="hidden" class="form-control" id="id_pedido">
                            <input name="id_produto" type="hidden" class="form-control" id="id_produto">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Produto</label>
                                    <input name="produto_nome" class="form-control" id="produto_nome">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Qtd</label>
                                    <input name="pedido_itens_qtd" class="form-control" id="pedido_itens_qtd" required="">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Preço</label>
                                    <input name="pedido_itens_valor" class="form-control" id="produto_preco">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Frete</label>
                                    <input name="pedido_itens_valor_frete" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Seguro</label>
                                    <input name="pedido_itens_valor_seguro" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Desconto</label>
                                    <input name="pedido_itens_valor_desconto" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Outras Despesas</label>
                                    <input name="pedido_itens_outras_despesas" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Descrição/Inf. Complementar</label>
                                    <input name="pedido_itens_descricao" class="form-control">
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="message-text" class="control-label">N° O.C.</label>
                                    <input name="pedido_itens_numero_compra" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Item O.C.</label>
                                    <input name="pedido_itens_item_compra" class="form-control">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <legend>Tributação</legend>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Situação Tributária</label>
                                <select name="pedido_itens_id_st" class="form-control">
                                    <?php
                                    while ($row_st = $stmt_busca_st->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                        <option value="<?php echo $row_st['st_id']; ?>"><?php
                                            if ($row_st['st_tipo'] == 0) {
                                                $flag = "ENTRADA";
                                            }
                                            if ($row_st['st_tipo'] == 1) {
                                                $flag = "SAIDA";
                                            }
                                            echo $row_st['st_nome'] . " ==>" . $flag
                                            ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Tipo E/S</label>
                                <select name="pedido_itens_id_tes" class="form-control">
                                    <?php
                                    while ($row_tes = $stmt_busca_tes->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                        <option value="<?php echo $row_tes['tes_id']; ?>"><?php
                                            if ($row_tes['tes_tipo'] == 0) {
                                                $flag = "ENTRADA";
                                            }
                                            if ($row_tes['tes_tipo'] == 1) {
                                                $flag = "SAIDA";
                                            }
                                            echo $row_tes['tes_descricao'] . " ==>" . $flag
                                            ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-cadastro" class="btn btn-xs btn-success">Cadastro</button>
                    </div>
                </form>
            </div>			  
        </div>
    </div>
</div>
<!--CADASTRA OUTRAS INFORMAÇÕES NO PEDIDO-->
<div class="modal fade" id="novoinfadicionais" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title center" id="exampleModalLabel">...:::Cadastro:::...</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="widget-box">
                                <div class="widget-header widget-header-flat">
                                    <h4 class="widget-title smaller">
                                        Outras Informações
                                    </h4>
                                </div>
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <div class="row">
                                            <input name="id_pedido" type="hidden" class="form-control" value="<?php echo $identificador; ?>">
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label class="control-label">Transportador</label>    
                                                    <select class="form-control" name="id_transportador" id="id_transportador">
                                                        <option selected="" value=""></option>
                                                        <?php
                                                        while ($tra = $stmt_transporte->fetch(PDO::FETCH_ASSOC)) {
                                                            ?>
                                                            <option value="<?php echo $tra['transportador_id'] ?>"><?php echo $tra['transportador_nome'] ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Valor Frete</label>
                                                    <input name="pedido_valor_frete" class="form-control" id="pedido_valor_frete">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-cadastro_outras_informacoes" class="btn btn-xs btn-success">Cadastro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--CADASTRA DADOS PARA A NFE NO PEDIDO-->
<div class="modal fade" id="novodadosnfe" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title center" id="exampleModalLabel">...:::Cadastro:::...</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="widget-box">
                                <div class="widget-header widget-header-flat">
                                    <h4 class="widget-title smaller">
                                        Dados para a NF-e
                                    </h4>
                                </div>
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <div class="row">
                                            <input name="id_pedido" type="hidden" class="form-control" value="<?php echo $identificador; ?>">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Peso Liquido</label>    
                                                    <input name="pedido_peso_liquido" class="form-control" id="pedido_peso_liquido">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Peso Bruto</label>    
                                                    <input name="pedido_peso_bruto" class="form-control" id="pedido_peso_bruto">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Quantidade</label>
                                                    <input name="pedido_quantidade" class="form-control" id="pedido_quantidade">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Espécie</label>
                                                    <input name="pedido_especie" class="form-control" id="pedido_especie">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Marca</label>
                                                    <input name="pedido_marca" class="form-control" id="pedido_marca">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Inf. NF-e</label>
                                                    <input name="pedido_inf_nfe" class="form-control" id="pedido_inf_nfe">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Inf. Complementar</label>
                                                    <select name="pedido_inf_comp" class="form-control" id="pedido_inf_comp">
                                                        <option value=""></option>
                                                        <?php
                                                        while ($informa = $stmt_inf_c->fetch(PDO::FETCH_ASSOC)) {
                                                            ?>
                                                            <option value="<?php echo $informa['inf_comp_id'] ?>"><?php echo $informa['inf_comp_descricao_resumida'] . " ==> " . $informa['inf_comp_descricao'] ?></option>

                                                            <?php
                                                        }
                                                        ?>
                                                    </select> 



                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class="control-label">NF-e Referenciada</label>
                                                    <input name="pedido_referencia" class="form-control" id="pedido_referencia">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-cadastro_dadonfe" class="btn btn-xs btn-success">Cadastro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once '../pagina/footer.php';
?>