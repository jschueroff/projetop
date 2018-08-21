<?php
require_once 'notas_itens_config.php';
require_once '../pagina/menu.php';

$id = $_GET['id'];
$identificador = $_GET['id'];

$stmt = $auth_user->runQuery("SELECT * FROM nota_itens, produto WHERE produto_status = 1 AND produto_id = nota_itens_id_produto and id_nota_id ='" . $id . "' ORDER BY nota_itens_id ASC");
$stmt->execute();

$st = $auth_user->total($id);
$st2 = $auth_user->totais($id);
//DADOS DA TES NO CADASTRO DE PRODUTOS
$stmt_busca_st = $auth_user->runQuery("SELECT * FROM st WHERE st_status = 1");
$stmt_busca_st->execute();
//DADOS DA TES NO CADASTRO DE PRODUTOS
$stmt_busca_tes = $auth_user->runQuery("SELECT * FROM tes WHERE tes_status = 1");
$stmt_busca_tes->execute();
//DADOS DO TRANSPORTADOR
$stmt_transporte = $auth_user->runQuery("SELECT * FROM transportador WHERE transportador_status = 1");
$stmt_transporte->execute();
//DADOS DA NOTA PARA DEPOIS VINCULAR DADOS DO TRANSPORTADOR
$stmt_busca_ped = $auth_user->runQuery("SELECT * FROM nota WHERE nota_id =:nota_id");
$stmt_busca_ped->execute(array(":nota_id" => $identificador));
$pedi = $stmt_busca_ped->fetch(PDO::FETCH_ASSOC);

//DADOS DA NOTA PARA DEPOIS VINCULAR DADOS AOS VOLUMES DA NFE.
$stmt_busca_vol = $auth_user->runQuery("SELECT * FROM nota_volume WHERE id_nota =:nota_id");
$stmt_busca_vol->execute(array(":nota_id" => $identificador));
$vol = $stmt_busca_vol->fetch(PDO::FETCH_ASSOC);

// DADOS DE INFORMAÇÕES COMPLEMENTARES PARA A NFE
$stmt_inf_c = $auth_user->runQuery("SELECT * FROM inf_comp WHERE inf_comp_status = 1");
$stmt_inf_c->execute();

//BUSCA O VALOR TOTAL DE UMA NF-E DOS ITENS CADASTRADOS
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
                <li class="active">Pedidos</li>
            </ul><!-- /.breadcrumb -->           
        </div>
        <div class="page-content">
            <?php
            require_once '../principal/principal_config.php';
            ?>

            <div class="col-sm-12">
                 <div id="error">
                            <?php
                            if (isset($error)) {
                                ?>
                                <div class="alert alert-danger">
                                    <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="widget-box">
                            <div class="widget-header widget-header-flat">
                                <h4 class="smaller">
                                    Cadastro Produtos NF-e
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
                                                            <div class="col-sm-8">
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
                                                                data-id_transportador="<?php echo $pedi['nota_id_transportador']; ?>"
                                                                data-pedido_valor_frete="<?php echo "0"; ?>"
                                                                >Outras Inf.</button>

                                                        <button type="button" class="btn btn-sm btn-default" 
                                                                data-toggle="modal" data-target="#novodadosnfe" 
                                                                data-id_pedido="<?php echo $identificador; ?>"
                                                                data-pedido_peso_liquido="<?php echo $vol['nota_volume_peso_liquido']; ?>"
                                                                data-pedido_peso_bruto="<?php echo $vol['nota_volume_peso_bruto']; ?>"
                                                                data-pedido_quantidade="<?php echo $vol['nota_volume_qtd']; ?>"
                                                                data-pedido_especie="<?php echo $vol['nota_volume_especie']; ?>"
                                                                data-pedido_marca="<?php echo $vol['nota_volume_marca']; ?>"
                                                                data-pedido_inf_nfe="<?php echo $vol['pedido_inf_nfe']; ?>"
                                                                data-pedido_inf_comp="<?php echo $vol['pedido_inf_comp']; ?>"
                                                                data-pedido_referencia="<?php echo $vol['pedido_referencia']; ?>"

                                                                >Dados NF-e</button>
                                                        
                                                        <button type="button" class="btn btn-sm btn-default" 
                                                                    data-toggle="modal" data-target="#novareferencia" 
                                                                    data-nota_itens_id="<?php echo $identificador; ?>">

                                                                Ref.
                                                            </button>
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
                                                                            data-toggle="modal" data-target="#novoprodutoitemnfe" 
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

                                                            <th class="hidden-480">QTD</th>
                                                            <th class="hidden-480">Valor</th>
                                                            <th class="hidden-480">Total</th>

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
                                                                <td class="hidden-480"><?php echo $row['produto_nome']; ?></td>

                                                                <td class="hidden-480"><?php echo $row['nota_itens_qtd']; ?></td>
                                                                <td class="hidden-480"><?php echo $row['nota_itens_valor']; ?></td>
                                                                <td class="hidden-480"><?php echo $row['nota_itens_total']; ?></td>
                                                            </tr>
                                                            <tr>

                                                            </tr>
                                                        </form>
                                                        <?php
                                                        $id++;
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td colspan="4">
                                                            SubTotal
                                                        </td>
                                                        <td colspan="3" >
                                                            <?php
                                                            echo $count;
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                    <form class="form-horizontal form-control-sm" method="post">                          


                                                        <button class="btn btn-white btn-info btn-sm" name="btn-gerarxml" type="submit">
                                                            <i class="ace-icon fa fa-asterisk bigger-120 blue"></i>
                                                            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                                                            Gerar XML
                                                        </button>

                                                    </form>
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
<div class="modal fade" id="novoprodutoitemnfe" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Cadastro ICMS/ICMS-ST</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <fieldset>
                        <div class="row">
                            <input name="id_nota_id" type="hidden" class="form-control" id="id_pedido">
                            <input name="nota_itens_id_produto" type="hidden" class="form-control" id="id_produto">
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
                                    <input name="nota_itens_qtd" class="form-control" id="pedido_itens_qtd" required="">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Preço</label>
                                    <input name="nota_itens_valor" class="form-control" id="produto_preco">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Frete</label>
                                    <input name="nota_itens_valor_frete" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Seguro</label>
                                    <input name="nota_itens_valor_seguro" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Desconto</label>
                                    <input name="nota_itens_valor_desconto" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Outras Despesas</label>
                                    <input name="nota_itens_outras_despesas" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="message-text" class="control-label">ID TOT</label>
                                    <input name="nota_itens_idtot" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="message-text" class="control-label">FCI</label>
                                    <input name="nota_itens_numero_nfci" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Descrição/Inf. Complementar</label>
                                    <input name="nota_itens_descricao" class="form-control">
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="message-text" class="control-label">N° O.C.</label>
                                    <input name="nota_itens_numero_compra" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Item O.C.</label>
                                    <input name="nota_itens_item_compra" class="form-control">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <legend>Tributação</legend>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Situação Tributária</label>
                                <select name="nota_itens_id_st" class="form-control">
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
                                <select name="nota_itens_id_tes" class="form-control">
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
                      
                        <button type="submit" name="btn-cadastro-itens" class="btn btn-xs btn-success">Cadastro</button>
                    </div>
                </form>
            </div>			  
        </div>
    </div>
</div>
<!--CADASTRA OUTRAS INFORMAÇÕES NA NFE (TRANSPORTADOR)-->
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
                                            <input name="id_nota_id" type="hidden" class="form-control" value="<?php echo $identificador; ?>">
                                            <div class="col-md-12">
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
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-cadastro_nfe_outras_informacoes" class="btn btn-xs btn-success">Cadastro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--CADASTRA DADOS PARA A NFE COMO (VOLUME, MARCA, QUANTIDADE)-->
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
                                        Dados da NF-e
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
<!--                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Inf. NF-e</label>
                                                    <input name="pedido_inf_nfe" class="form-control" id="pedido_inf_nfe">
                                                </div>
                                            </div>
                                        </div>-->
<!--                                        <div class="row">
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
                                        </div>-->

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


<!--CADASTRA UM NOVA REFERENCIA DA NFE-->
<div class="modal fade" id="novareferencia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Referencia</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <legend>Nota Referenciada</legend>
                    <div class="row">


                        <div class="col-md-7">
                            <div class="form-group">
                                <label  class="control-label">Chave</label>
<!--                                <textarea name="nota_inf_comp_complemento" class="form-control"></textarea>-->
                                <input name="nota_referencia_chave" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label  class="control-label">UF</label>
                                <select name="nota_referencia_cod_uf" class="form-control">
                                    <option value="12">AC</option>
                                    <option value="27">AL</option>
                                    <option value="13">AM</option>
                                    <option value="16">AP</option>
                                    <option value="29">BA</option>
                                    <option value="23">CE</option>
                                    <option value="53">DF</option>
                                    <option value="32">ES</option>
                                    <option value="52">GO</option>
                                    <option value="21">MA</option>
                                    <option value="31">MG</option>
                                    <option value="50">MS</option>
                                    <option value="51">MT</option>
                                    <option value="15">PA</option>
                                    <option value="25">PB</option>
                                    <option value="26">PE</option>
                                    <option value="22">PI</option>
                                    <option value="41">PR</option>
                                    <option value="33">RJ</option>
                                    <option value="24">RN</option>
                                    <option value="11">RO</option>
                                    <option value="14">RR</option>
                                    <option value="43">RS</option>
                                    <option value="42" selected="" >SC</option>
                                    <option value="28">SE</option>
                                    <option value="35">SP</option>
                                    <option value="17">TO</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label  class="control-label">Data</label>
                                <input name="nota_referencia_data" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label  class="control-label">CNPJ</label>
                                <input name="nota_referencia_cnpj" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label  class="control-label">Modelo</label>
                                <input name="nota_referencia_modelo" type="text" class="form-control" value="55">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label  class="control-label">Serie</label>
                                <input name="nota_referencia_serie" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label  class="control-label">N° Nfe</label>
                                <input name="nota_referencia_numero_nfe" type="text" class="form-control">
                            </div>
                        </div>


                    </div>
                    <input name="id_nota" type="hidden" value="<?php echo $identificador ?>">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-xs" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-cadastra_ref_nfe" class="btn btn-success btn-xs">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php
require_once '../pagina/footer.php';
?>