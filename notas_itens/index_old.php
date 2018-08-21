<?php
require_once 'notas_itens_config.php';
require_once '../pagina/menu.php';

$id = $_GET['id'];

$stmt = $auth_user->runQuery("SELECT * FROM nota_itens, produto WHERE
    nota_itens_id_produto = produto_id AND id_nota_id = $id
 ORDER BY nota_itens_id");
$stmt->execute();

$st = $auth_user->total($id);
//$st2 = $auth_user->totais($id);
$stmt_tot = $auth_user->runQuery("select sum(nota_itens_total) from nota_itens where id_nota_id =$id");
$stmt_tot->execute();
$count = $stmt_tot->fetchColumn();
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
                <li class="active">Itens da Nota</li>
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
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <form  method="post">                          
                                                                    <div class="col-sm-9">
                                                                        <input type="text" id="produto_pesquisa" name="produto_pesquisa" class="col-xs-3 col-sm-9" autofocus="" placeholder="Pesquisar ID/Produto"/>
                                                                        <button class="btn btn-info btn-sm" name="btn-pesquisar2" type="submit">
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
                                                        <?php
                                                        while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
                                                            ?>

                                                            <div class="form-group">
                                                                <form class="form-horizontal form-control-sm" method="post"> 
                                                                    <table id="simple-table" class="table table-striped table-responsive table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="col-xs-5">ID</th>
                                                                                <th class="hidden-480">Nome</th>                                           
                                                                                <th class="hidden-480">QTD.</th>
                                                                                <th class="hidden-480">Valor</th>                                           
                                                                                <th class="hidden-480">INCLUIR</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <input type="hidden" name="id_nota_id" value="<?php echo $id; ?>">
                                                                        <th class="col-xs-5"><input type="text" name="nota_itens_id_produto" class="col-xs-5"  required=""value="<?php echo $row['produto_id']; ?>" /></th>
                                                                        <th class="hidden-480"><input type="text" name="produto_nome" required=""value="<?php echo $row['produto_nome']; ?>" /></th>                                           
                                                                        <th class="hidden-480"><input type="text" name="nota_itens_qtd" required="" /></th>
                                                                        <th class="hidden-480"><input type="text" name="nota_itens_valor" required=""value="<?php echo $row['produto_preco']; ?>" /></th>
                                                                        <th class="hidden-480"><button class="btn btn-white  btn-success" name="btn-cadastro-itens" type="submit">
                                                                                <i class="ace-icon fa fa-floppy-o bigger-60 green"></i>
                                                                                Novo Item
                                                                            </button></th>

                                                                        </tbody>
                                                                    </table>
                                                                </form>
                                                            </div>


                                                            <?php
                                                        }
                                                        ?>

                                                        <div class="row">
                                                            <div class="col-xs-12">
                                                                <table id="simple-table" class="table table-striped table-responsive table-hover">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>ID</th>
                                                                            <th class="hidden-480">ID Produto</th>                                           
                                                                            <th class="hidden-480">Produto</th>
                                                                            <th class="hidden-480">QTD</th>
                                                                            <th class="hidden-480">Valor</th>
                                                                            <th class="hidden-480">Total</th>
                                                                            <th class="hidden-480 center" colspan="2" >Configurar</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $id = 1;
                                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                            $valor[$id] = $row['nota_itens_id'];
                                                                            ?>
                                                                        <form method="post" id="login-form">
                                                                            <tr>
                                                                                <td><?php echo $row['nota_itens_id']; ?></td>
                                                                                <td class="hidden-480"><?php echo $row['nota_itens_id_produto']; ?></td>
                                                                                <td class="hidden-480"><?php echo $row['nota_itens_produto']; ?></td>
                                                                                <td class="hidden-480"><?php echo $row['nota_itens_qtd']; ?></td>
                                                                                <td class="hidden-480"><?php echo $row['nota_itens_valor']; ?></td>
                                                                                <td class="hidden-480"><?php echo $row['nota_itens_total']; ?></td>
                                                                                <td class="hidden-480" align="center">
                                                                                    <div class="form-group">
                                                                                        <button class="btn btn-white btn-info btn-bold" name="btn-editar" type="submit">
                                                                                            <i class="ace-icon fa glyphicon-pencil bigger-80 blue"></i>
                                                                                            <input type="hidden" name="nota_itens_id" value="<?php echo $valor[$id]; ?>">
                                                                                            Editar
                                                                                        </button>
                                                                                    </div>
                                                                                </td>
                                                                                <td class="hidden-480" align="center">
                                                                                    <div class="form-group">

                                                                                        <button class="btn btn-white btn-info btn-bold" name="btn-gerarxml" type="submit">
                                                                                            <i class="ace-icon fa fa-ban bigger-80 blue"></i>
                                                                                            <input type="hidden" name="nota_id" value="<?php echo $valor[$id]; ?>">
                                                                                            Excluir
                                                                                        </button>

                                                                                    </div>
                                                                                </td>
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
                                                                            echo $count;
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                                <form class="form-horizontal form-control-sm" method="post">                          


                                                                    <button class="btn btn-white btn-info btn-xs" name="btn-gerarxml" type="submit">
                                                                        <i class="ace-icon fa fa-asterisk bigger-120 blue"></i>
                                                                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                                                                        Gerar NF-e
                                                                    </button>

                                                                </form>
                                                            </div><!-- /.span -->
                                                        </div><!-- /.row -->
                                                        <!-- PAGE CONTENT ENDS -->
                                                    </div><!-- /.col -->
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>













<?php
require_once '../pagina/footer.php';
?>