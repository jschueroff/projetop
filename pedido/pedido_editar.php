<?php
require_once 'pedido_config.php';
require_once '../pedido_itens/pedido_itens_config.php';
require_once '../pagina/menu.php';

$id = $_GET['id'];
$identificador = $_GET['id'];

$stmt2 = $auth_user->runQuery("SELECT * FROM pedido, cliente, forma_pagamento WHERE id_cliente = cliente_id AND  pedido_id =:id");
$stmt2->execute(array(":id" => $id));
$lista = $stmt2->fetch(PDO::FETCH_ASSOC);

$st = $auth_user->runQuery("SELECT * FROM forma_pagamento WHERE forma_pagamento_status = 1");
$st->execute();
//BUSCAR DADOS DO PEDIDO
$stmt_pedido_itens = $auth_user->runQuery("SELECT pedido_itens.*, produto_nome FROM pedido, pedido_itens, produto WHERE"
        . " produto_id = id_produto and pedido_id = id_pedido and pedido_id = $lista[pedido_id]");
$stmt_pedido_itens->execute();

//BUSCAR A SOMA TOTAL DO PEDIDO 
$stmt_total = $auth_user->runQuery("SELECT SUM(pedido_itens_total) FROM pedido_itens WHERE id_pedido = $lista[pedido_id]");
$stmt_total->execute();
$tot = $stmt_total->fetch(PDO::FETCH_ASSOC);

//BUSCAR A ST VALIDA PARA CADASTRAR NO PEDIDO
$stmt_buscast = $auth_user->runQuery("SELECT * FROM st WHERE st_status = 1");
$stmt_buscast->execute();

// BUSCAR A TES VALIDA PARA CADASTRAR NO PEDIDO
$stmt_buscates = $auth_user->runQuery("SELECT * FROM tes WHERE tes_status = 1");
$stmt_buscates->execute();

//BUSCA O TRANSPORTADOR 
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
                            <legend>Editar Pedido</legend>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>ID. Pedido</label>
                                        <input type="text" name="pedido_id" id="pedido_id" class="form-control" value="<?php echo $lista['pedido_id'] ?>" disabled="" required=""/>                                 
                                    </div>
                                </div>
                                <input type="hidden" name="pedido_id" value="<?php echo $lista['pedido_id'] ?>">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nome</label>
                                        <input type="text" name="cliente_nome" id="cliente_nome" class="form-control" value="<?php echo $lista['cliente_nome'] ?>" disabled="" required=""/>                                 
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>CPF/CNPJ</label>
                                        <input type="text" name="cliente_cpf_cnpj" id="cliente_cpf_cnpj" class="form-control" value="<?php echo $lista['cliente_cpf_cnpj'] ?>" disabled="" required=""/>                                 
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control" id="pedido_status" name="pedido_status">

                                            <?php
                                            if ($lista['pedido_status'] == '4') {
                                                ?>

                                                <option value="1" <?= ($lista['pedido_status'] == '1') ? 'selected' : '' ?> >PENDENTE</option>
                                                <option value="2" <?= ($lista['pedido_status'] == '2') ? 'selected' : '' ?> >CONFERIDO</option>
                                                <option value="3" <?= ($lista['pedido_status'] == '3') ? 'selected' : '' ?> >LIBERADO</option>
                                                <option value="4" <?= ($lista['pedido_status'] == '4') ? 'selected' : '' ?> disabled="">FATURADO</option>
                                            <?php } else {
                                                ?>
                                                <option value="1" <?= ($lista['pedido_status'] == '1') ? 'selected' : '' ?> >PENDENTE</option>
                                                <option value="2" <?= ($lista['pedido_status'] == '2') ? 'selected' : '' ?> >CONFERIDO</option>
                                                <option value="3" <?= ($lista['pedido_status'] == '3') ? 'selected' : '' ?> >LIBERADO</option>
                                                <option value="4" <?= ($lista['pedido_status'] == '4') ? 'selected' : '' ?> disabled="" >FATURADO</option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Venda</label>

                                        <select id="pedido_presencial" name="pedido_presencial" class="form-control">
                                            <option value="0" disabled=""<?= ($lista['pedido_presencial'] == '0') ? 'selected' : '' ?>>0 - Não se Aplica</option>
                                            <option value="1" <?= ($lista['pedido_presencial'] == '1') ? 'selected' : '' ?>>1 - Operação Presencial</option>
                                            <option value="2" <?= ($lista['pedido_presencial'] == '2') ? 'selected' : '' ?>>2 - Operação não presencial, pela Internet</option>
                                            <option value="3" <?= ($lista['pedido_presencial'] == '3') ? 'selected' : '' ?>>3 - Operação não presencial, Teleatendimento</option>
                                            <option value="4" disabled="" <?= ($lista['pedido_presencial'] == '4') ? 'selected' : '' ?>>4 - NFC-e em operação com entrega a domicílio</option>
                                            <option value="9" <?= ($lista['pedido_presencial'] == '9') ? 'selected' : '' ?>>9 - Operação não presencial, outros</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label >Frete</label>
                                        <select id="pedido_frete" name="pedido_frete" class="form-control">
                                            <option value="0" <?= ($lista['pedido_frete'] == '0') ? 'selected' : '' ?>>0 - Por Conta Emitente</option>
                                            <option value="1" <?= ($lista['pedido_frete'] == '1') ? 'selected' : '' ?>>1 - Por conta do destinatário/remetente</option>
                                            <option value="2" <?= ($lista['pedido_frete'] == '2') ? 'selected' : '' ?>>2 - Por conta de terceiros</option>
                                            <option value="9" <?= ($lista['pedido_frete'] == '9') ? 'selected' : '' ?>>9 - Sem Frete</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Forma Pag.</label>
                                        <select class="form-control" id="id_forma_pagamento" name="id_forma_pagamento">
                                            <?php
                                            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                                                if ($lista['id_forma_pagamento'] == $row['forma_pagamento_id']) {
                                                    ?>
                                                    <option value="<?php echo $row['forma_pagamento_id']; ?>" selected=""><?php echo $row['forma_pagamento_nome']; ?></option>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <option value="<?php echo $row['forma_pagamento_id']; ?>"><?php echo $row['forma_pagamento_nome']; ?></option>

                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Data</label>
                                        <input type="text" name="pedido_data" id="pedido_data" disabled="" value="<?php echo date("d/m/Y H:m", strtotime($lista['pedido_data'])); ?>" class="form-control"  />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Data Entrega</label>
                                        <input type="text" name="pedido_data_entrega" id="pedido_data_entrega" value="<?php echo date("d/m/Y", strtotime($lista['pedido_data_entrega'])); ?>" class="form-control input-mask-data" placeholder="dd/mm/yyyy"   />
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>N° NF</label>
                                        <input type="text" name="pedido_numero_nf" id="pedido_numero_nf" disabled="" value="<?php echo $lista['pedido_numero_nf'] ?>" class="form-control"  />
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Observação</label>
                                        <input type="text" name="pedido_observacao" id="pedido_observacao" value="<?php echo $lista['pedido_observacao'] ?>" class="form-control"  />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-sm btn-default" 
                                                data-toggle="modal" data-target="#novoinfadicionais" 
                                                data-id_pedido="<?php echo $identificador; ?>"
                                                data-id_transportador="<?php echo $pedi['id_transportador']; ?>"
                                                data-pedido_valor_frete="<?php echo $pedi['pedido_valor_frete']; ?>"
                                                >Outras Inf.</button>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">

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
                            </div>
                            <div class="clearfix form-actions">
                                <div class="col-md-offset-11 col-md-9">
                                    <?php
                                    if ($lista['pedido_status'] != 4) {
                                        ?>
                                        <button type="submit" name="btn-salvar" class=" btn btn-xs btn-info">
                                            Alterar
                                        </button>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>

                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <!--MOSTRA OS ITENS DO PEDIDO CADASTRADOS-->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-12">
                                <legend>Editar Produtos do Pedido</legend>
                                <table id="simple-table" class="table table-striped table-responsive table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th class="hidden-480">Produto</th>
                                            <td class="hidden-480">Quantidade</td>
                                            <td class="hidden-480">Preço</td>
                                            <td class="hidden-480">Total</td>
                                            <td class="hidden-480">Configurar</td>
                                            <td class="hidden-480">
                                                <?php
                                                if ($lista['pedido_status'] != 4) {
                                                    ?>

                                                    <a href="../pedido_itens/index.php?id=<?php echo $id; ?>">
                                                        <button type="button" class="btn btn-xs btn-success"> Novo</button></a>
                                                    <?php
                                                }
                                                ?>

                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = $stmt_pedido_itens->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $row['pedido_itens_id']; ?></td>
                                                <td class="hidden-480"><?php echo $row['produto_nome']; ?></td>
                                                <td class="hidden-480"><?php echo $row['pedido_itens_qtd']; ?></td>                                           
                                                <td class="hidden-480"><?php echo $row['pedido_itens_valor']; ?></td> 
                                                <td class="hidden-480"><?php echo $row['pedido_itens_total']; ?></td>
                                                <!--<td class="hidden-480">Editar</td>-->
                                                <td colspan="2">

                                                    <?php
                                                    if ($lista['pedido_status'] != 4) {
                                                        ?>

                                                        <button type="button" class="btn btn-xs btn-warning" 
                                                                data-toggle="modal" data-target="#exampleModal" 
                                                                data-pedido_itens_id="<?php echo $row['pedido_itens_id']; ?>"
                                                                data-id_produto="<?php echo $row['id_produto']; ?>"  
                                                                data-produto_nome="<?php echo $row['produto_nome']; ?>"
                                                                data-pedido_itens_valor="<?php echo $row['pedido_itens_valor']; ?>"
                                                                data-pedido_itens_qtd="<?php echo $row['pedido_itens_qtd']; ?>"
                                                                data-pedido_itens_id_st="<?php echo $row['pedido_itens_id_st']; ?>"
                                                                data-pedido_itens_id_tes="<?php echo $row['pedido_itens_id_tes']; ?>"
                                                                data-pedido_itens_valor_frete="<?php echo $row['pedido_itens_valor_frete']; ?>"
                                                                data-pedido_itens_valor_seguro="<?php echo $row['pedido_itens_valor_seguro']; ?>"
                                                                data-pedido_itens_valor_desconto="<?php echo $row['pedido_itens_valor_desconto']; ?>"
                                                                data-pedido_itens_outras_despesas="<?php echo $row['pedido_itens_outras_despesas']; ?>"
                                                                data-pedido_itens_descricao="<?php echo $row['pedido_itens_descricao']; ?>"
                                                                >Editar</button>
                                                        <button type="button" class="btn btn-xs btn-danger" 
                                                                data-toggle="modal" data-target="#excluirproduto" 
                                                                data-pedido_itens_id="<?php echo $row['pedido_itens_id']; ?>"

                                                                >Excluir</button>


                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                    <tbody>
                                        <tr>
                                            <td colspan="4" class="hidden-480">
                                                Sub-Total
                                            </td>
                                            <td colspan="2"><?php echo $tot['SUM(pedido_itens_total)'] ?></td>
                                        </tr>
                                    </tbody>
                                </table>


                            </div><!-- /.span -->
                        </div><!-- /.row -->
                    </div>

                    </form>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->
<!--ALTERA DADOS DO ITENS DO PEDIDO-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <legend>Dados Produtos/Serviços</legend>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="recipient-name" class="control-label">ID Produto:</label>
                                <input name="id_produto" type="text" class="form-control" id="recipient-name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Produto</label>
                                <input name="produto_nome" type="text" class="form-control" id="produto_nome" disabled="">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="pedido_qtd" class="control-label">QTD:</label>
                                <input name="pedido_itens_qtd" type="text" class="form-control" id="pedido_qtd">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="message-text" class="control-label">Valor:</label>
                                <input name="pedido_itens_valor" class="form-control" id="detalhes-text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="message-text" class="control-label">Frete:</label>
                                <input name="pedido_itens_valor_frete" class="form-control" id="pedido_itens_valor_frete">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="message-text" class="control-label">Seguro:</label>
                                <input name="pedido_itens_valor_seguro" class="form-control" id="pedido_itens_valor_seguro">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="message-text" class="control-label">Desconto:</label>
                                <input name="pedido_itens_valor_desconto" class="form-control" id="pedido_itens_valor_desconto">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="message-text" class="control-label">Outras Despesas:</label>
                                <input name="pedido_itens_outras_despesas" class="form-control" id="pedido_itens_outras_despesas">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Descrição</label>
                                <input name="pedido_itens_descricao" class="form-control" id="pedido_itens_descricao">
                            </div>
                        </div>
                    </div>
                    <legend>Tributação</legend>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="message-text" class="control-label">Situação Tributária</label>
<!--                                <input name="pedido_itens_id_st" class="form-control" id="pedido_itens_id_st">-->
                                <select name="pedido_itens_id_st" class="form-control" id="pedido_itens_id_st">
                                    <?php
                                    while ($row = $stmt_buscast->fetch(PDO::FETCH_ASSOC)) {
                                        if ($row['st_tipo'] == 0) {
                                            $fla = "ENTRADA";
                                        } else {
                                            $fla = "SAIDA";
                                        }
                                        ?>
                                        <option value="<?php echo $row['st_id'] ?>"><?php echo $row['st_nome'] . "==>" . $fla; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="message-text" class="control-label">TES</label>
<!--                                <input name="pedido_itens_id_tes" class="form-control" id="pedido_itens_id_tes">-->
                                <select name="pedido_itens_id_tes" class="form-control" id="pedido_itens_id_tes">
                                    <?php
                                    while ($row = $stmt_buscates->fetch(PDO::FETCH_ASSOC)) {
                                        if ($row['tes_tipo'] == 0) {
                                            $fl = "ENTRADA";
                                        } else {
                                            $fl = "SAIDA";
                                        }
                                        ?>
                                        <option value="<?php echo $row['tes_id'] ?>"><?php echo $row['tes_descricao'] . "==>" . $fl; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>
                    </div>
                    <input name="pedido_itens_id" type="hidden" id="id_pedido_item">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-altera" class="btn btn-xs btn-warning">Alterar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!--EXCLUIR PRODUTO DO PEDIDO-->
<div class="modal fade" id="excluirproduto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Item</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <input name="pedido_itens_id" type="hidden" class="form-control" id="pedido_itens_id">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-apaga" class="btn btn-xs btn-danger">Excluir</button>
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
                                                        <option value="<?php echo $informa['inf_comp_id'] ?>"><?php echo $informa['inf_comp_descricao_resumida']." ==> " .$informa['inf_comp_descricao'] ?></option>

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