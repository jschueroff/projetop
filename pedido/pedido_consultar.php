<?php
require_once 'pedido_config.php';
require_once '../pagina/menu.php';

$id = $_GET['id'];
$stmt2 = $auth_user->runQuery("SELECT * FROM pedido, cliente, forma_pagamento WHERE id_cliente = cliente_id AND  pedido_id =:id");
$stmt2->execute(array(":id" => $id));
$lista = $stmt2->fetch(PDO::FETCH_ASSOC);

$st = $auth_user->runQuery("SELECT * FROM forma_pagamento");
$st->execute();

$stmt_pedido_itens = $auth_user->runQuery("SELECT pedido_itens.*, produto_nome FROM pedido, pedido_itens, produto WHERE"
        . " produto_id = id_produto and pedido_id = id_pedido and pedido_id = $lista[pedido_id]");
$stmt_pedido_itens->execute();

$stmt_total = $auth_user->runQuery("SELECT SUM(pedido_itens_total) FROM pedido_itens WHERE id_pedido = $lista[pedido_id]");
$stmt_total->execute();
$tot = $stmt_total->fetch(PDO::FETCH_ASSOC);
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
                <li class="active">Consultar</li>
            </ul><!-- /.breadcrumb -->
        </div>
        <div class="page-content">
            <?php
            require_once '../principal/principal_config.php';
            ?>
            <div class="row">
                <div class="col-xs-12">
                    <form class="form-horizontal" method="post">  
                        <input type="hidden" name="pedido_id" value="<?php echo $lista['pedido_id'] ?>">
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-tags">Nome</label>
                            <div class="col-sm-9">
                                <input type="text" name="cliente_nome" id="cliente_nome" class="form-control" value="<?php echo $lista['cliente_nome'] ?>" disabled="" required=""/>                                 

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Status</label>
                            <div class="col-sm-9">
                                <select class="col-sm-4" id="pedido_status" name="pedido_status" disabled="">

                                    <?php
                                    if ($lista['pedido_status'] == '4') {
                                        ?>

                                        <option value="1" <?= ($lista['pedido_status'] == '1') ? 'selected' : '' ?> disabled="">PENDENTE</option>
                                        <option value="2" <?= ($lista['pedido_status'] == '2') ? 'selected' : '' ?> disabled="">CONFERIDO</option>
                                        <option value="3" <?= ($lista['pedido_status'] == '3') ? 'selected' : '' ?> disabled="">LIBERADO</option>
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
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Forma Pag.</label>
                            <div class="col-sm-9">
                                <select class="col-sm-4" id="pedido_status" disabled="" name="id_forma_pagamento">
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
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-tags">Data</label>
                            <div class="col-sm-9">
                                <input type="text" name="pedido_data" id="pedido_data" disabled="" value="<?php echo $lista['pedido_data'] ?>" class="form-control"  />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-tags">N° NF</label>
                            <div class="col-sm-9">
                                <input type="text" name="pedido_numero_nf" id="pedido_numero_nf" disabled="" value="<?php echo $lista['pedido_numero_nf'] ?>" class="form-control"  />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12">
                                    <table id="simple-table" class="table table-striped table-responsive table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th class="hidden-480">Produto</th>
                                                <td class="hidden-480">Quantidade</td>
                                                <td class="hidden-480">Preço</td>
                                                <td class="hidden-480">Total</td>
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
                                                <td><?php echo $tot['SUM(pedido_itens_total)'] ?></td>
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


<?php
require_once '../pagina/footer.php';
?>