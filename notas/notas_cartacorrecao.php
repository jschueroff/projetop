<?php
require_once 'notas_config.php';
require_once '../pagina/menu.php';

//
//$stmt_pedido = $auth_user->runQuery("SELECT * FROM pedido, forma_pagamento, cliente WHERE pedido.pedido_status = 3 AND forma_pagamento.forma_pagamento_id = pedido.id_forma_pagamento AND 
//cliente.cliente_id = pedido.id_cliente ORDER BY pedido.pedido_id ASC");
//
//$stmt_pedido->execute();
//
//$stmt_notas_emitidas = $auth_user->runQuery("SELECT * FROM nota ORDER BY nota_numero_nf DESC");
//$stmt_notas_emitidas->execute();
//
//$stmt_cce = $auth_user->runQuery("SELECT * FROM nota_cartacorrecao");
//$stmt_cce->execute();
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
                <li class="active">Carta de Correção</li>
            </ul><!-- /.breadcrumb -->


        </div>

        <div class="page-content">
            <?php
            require_once('../principal/principal_config.php');
            ?>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <div class="row">
                            <form class="form-horizontal" method="post">                            
                                <div class="col-xs-7">
                                    <input type="text" id="ncm_id" name="notas_pesquisa" class="col-xs-6" placeholder="Chave ou Cliente"/>
                                    <button class="btn btn-white btn-info btn-bold col-xs-3" name="btn-pesquisar" type="submit">
                                        <i class="ace-icon fa fa-filter bigger-100 green"></i>
                                        Pesquisar
                                    </button>
                                </div>                            
                            </form>
                          
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <table id="simple-table" class="table table-striped table-bordered table-responsive">

                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th class="hidden-480">Cliente</th> 
                                            <th class="hidden-480">N° NF-e</th> 
                                            <th class="hidden-480">Status/Motivo</th>
                                            <th class="hidden-480 center">CC-e</th>
                                            <th class="hidden-480 center">Visualizar/Emitir PDF</th>
                                        </tr>
                                    </thead>
                                    <tbody class="reponsive">
                                        <?php
                                        while ($row = $stmt_notas_emitidas->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                            <tr>
                                                <th><?php echo $row['nota_id'] ?></th>
                                                <th class="hidden-480"><?php echo $row['nota_cliente']; ?></th>
                                                <th class="hidden-480"><?php echo $row['nota_numero_nf']; ?></th>

                                                <!--VERIFICA O STATUS DA EMISSAO DA NFE-->
                                                <th class="hidden-480 center">
                                                    <?php if ($row['nota_status'] == 4) { ?>
                                                        <button type="button" class="btn btn-xs btn-success" 
                                                                >Autorizada</button>
                                                            <?php
                                                            }
                                                            if ($row['nota_status'] == 5) {
                                                                ?>

                                                        <button type="button" class="btn btn-xs btn-info2" 
                                                                >Cancelada</button>
                                                                <?php
                                                            }
                                                            ?>
                                                </th>
                                                <!--CARTA DE CORRECAO EMISSAO -->
                                                <th class="hidden-480 center">
                                                    <!-- CHAMADA ESTA NO FOOTER VERIFICAR LA ISSO SE PRECISAR MUDAR LINHA 60 -->
                                                     <?php if ($row['nota_status'] == 4) { ?>
                                                        <button type="button" class="btn btn-xs btn-warning" 
                                                                data-toggle="modal" data-target="#myModal2" 
                                                                data-nota_id="<?php echo $row['nota_id']; ?>"
                                                                data-nota_cliente="<?php echo $row['nota_cliente']; ?>"
                                                                data-nota_chave="<?php echo $row['nota_chave']; ?>"
                                                                data-nota_ambiente="<?php echo $row['nota_ambiente']; ?>"
                                                                data-nota_numero_nf="<?php echo $row['nota_numero_nf']; ?>"
                                                                >Carta de Correção</button>
                                                       <?php } ?>

                                                </th>
                                                <!-- VISUALIZACAO E IMPRESSAO DA CARTA DE CORRECAO -->
                                                <th class="hidden-480 center">
                                                    <?php
                                                    $stmt_cce = $auth_user->runQuery("SELECT * FROM nota_cartacorrecao");
                                                    $stmt_cce->execute();
                                                    while ($row1 = $stmt_cce->fetch(PDO::FETCH_ASSOC)) {
                                                        if ($row1['id_nota'] == $row['nota_id']) {
                                                            ?>

                                                            <button type="button" class="btn btn-xs btn-primary" 
                                                                    data-toggle="modal" data-target="#myModal11" 
                                                                    data-nota_id="<?php echo $row1['nota_cartacorrecao_id']; ?>"
                                                                    data-nota_nseqevento="<?php echo $row1['nota_cartacorrecao_nSeqEvento'] ?>"
                                                                    data-nota_chave="<?php echo $row1['nota_cartacorrecao_chNFe'] ?>"

                                                                    ><?php echo $row1['nota_cartacorrecao_nSeqEvento'] ?> Visualizar</button>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>


                                                </th>

                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                 <!-- depois de preencher a tabela com os valores, criamos os botoes de paginação -->		
                                <div class="row">
                                    <div class="col-xs-12">
                                        <?php
                                        //determina de quantos em quantos links serão adicionados e removidos
                                        $max_links = 8;
                                        //dados para os botões
                                        $previous = $pagina - 1;
                                        $next = $pagina + 1;
                                        //usa uma funcção "ceil" para arrendondar o numero pra cima, ex 1,01 será 2
                                        $pgs = ceil($total / $maximo);
                                    
                                        //se a tabela não for vazia, adiciona os botões
                                        if ($pgs > 1) {
                                            echo "<br/>";
                                            //botao anterior
                                            if ($previous > 0) {
                                                echo "<div class='pagination'><a href=" . $_SERVER['PHP_SELF'] . "?pagina=$previous><input type='submit'  name='bt-enviar' id='bt-enviar' value='Anterior' class='button btn btn-white btn-sm btn-primary' /></a></div>";
                                            }

                                            echo "<div class='pagination'>";
                                            for ($i = $pagina - $max_links; $i <= $pgs - 1; $i++) {

                                                if ($i <= 0) {
                                                    //enquanto for negativo, não faz nada
                                                } else {
                                                    //senão adiciona os links para outra pagina
                                                    if ($i != $pagina) {
                                                        if ($i == $pgs) { //se for o final da pagina, coloca tres pontinhos
                                                           
                                                               
                                                                echo "<a class='btn btn-white btn-sm btn-primary' href=" . $_SERVER['PHP_SELF'] . "?pagina=" . ($i) . ">$i</a> ...";
                                                            } else {
                                                                echo "<a class='btn btn-white btn-sm btn-primary' href=" . $_SERVER['PHP_SELF'] . "?pagina=" . ($i) . ">$i</a>";
                                                           
                                                        }
                                                    } else {
                                                        if ($i == $pgs) { //se for o final da pagina, coloca tres pontinhos
                                                            echo "<span class='btn btn-white btn-sm btn-primary'> " . $i . "</span> ...";
                                                        } else {

                                                            echo "<span class='btn btn-white btn-sm '> " . $i . "</span>";
                                                        }
                                                    }
                                                }
                                            }

                                            echo "</div>";

                                            //botao proximo
                                            if ($next <= $pgs) {
                                                echo " <div class='pagination'><a href=" . $_SERVER['PHP_SELF'] . "?pagina=$next><input type='submit'  name='bt-enviar' id='bt-enviar' value='Proxima' class='button btn btn-white btn-sm btn-primary'/></a></div>";
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div><!-- /.span -->
                        </div><!-- /.row -->
                        <!-- PAGE CONTENT ENDS -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.page-content -->
        </div>
    </div><!-- /.main-content -->
</div>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Carta de Correção</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <input name="nota_id" type="hidden" class="form-control" id="nota_id">
                    </div>
                    <div class="form-group">
                        <label for="nota_cliente" class="control-label">Nome</label>
                        <input name="nota_cliente" type="text" class="form-control" id="nota_cliente">
                    </div>
                    <!--                    <div class="form-group">
                                            <label for="nota_chave" class="control-label">Chave</label>
                                            <input name="nota_chave" type="text" class="form-control" id="nota_chave">
                                        </div>-->
                    <input type="hidden" name="nota_chave" class="form-control" id="nota_chave">
                    <div class="form-group">
                        <label for="nota_ambiente" class="control-label">Ambiente</label>
                        <input name="nota_ambiente" type="text" class="form-control" id="nota_ambiente">
                    </div>
                    <div class="form-group">
                        <label for="nota_numero_nf" class="control-label">N° NF-e</label>
                        <input name="nota_numero_nf" type="text" class="form-control" id="nota_numero_nf">
                    </div>
                    <div class="form-group">
                        <label for="nota_cartacorrecao_xCorrecao" class="control-label">Descrição</label>
                        <input name="nota_cartacorrecao_xCorrecao" type="text" class="form-control">
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-cartacorrecao" class="btn btn-xs btn-success">Enviar CC-e</button>
                    </div>
                </form>
            </div>			  
        </div>
    </div>
</div>

<!--IMPRIME A CARTA DE CORRECAO FEITA-->
<div class="modal fade" id="myModal11" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Imprime CC-e</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <input name="nota_id" type="hidden" class="form-control" id="nota_id">
                    </div>
                    <div class="form-group">
                        <label for="nota_nseqevento" class="control-label">Seq. Evento</label>
                        <input name="nota_nseqevento" type="text" class="form-control" id="nota_nseqevento">
                    </div>

                    <div class="form-group">
                        <label for="nota_id" class="control-label">Nota ID</label>
                        <input name="nota_id" type="text" class="form-control" id="nota_id">
                    </div>
                    <div class="form-group">
                        <label for="nota_chave" class="control-label">Chave</label>
                        <input name="nota_chave" type="text" class="form-control" id="nota_chave">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-cartaimprime" class="btn btn-xs btn-success">Imprimir CC-e</button>
                    </div>
                </form>
            </div>			  
        </div>
    </div>
</div>

<?php
require_once '../pagina/footer.php';
?>