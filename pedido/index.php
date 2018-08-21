<?php
require_once 'pedido_config.php';
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
                <li class="active">Pedidos</li>
            </ul><!-- /.breadcrumb -->


        </div>

        <div class="page-content">
            <?php
            require_once '../principal/principal_config.php';
            ?>

            <div class="row">
                <div class="col-xs-12">
                    <table id="simple-table" class="table table-striped table-responsive table-hover">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th class="hidden-480">Status</th> 
                                <th class="hidden-480">Data Cadastro</th> 
                                <th class="hidden-480">Pesquisa</th>                                           
                                <th class="hidden-480 center">Cadastro</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                        <form method="POST">
                            <th class="hidden-480"> 
                                <input type="text" id="pedido_pesquisa" name="pesquisa_nome" placeholder="Cliente"/>
                            </th> 
                            <th class="">
                                <select name="pesquisa_status">
                                    <option value="0">========</option>
                                    <option value="1">PENDENTE</option>
                                    <option value="2">CONFERIDO</option>
                                    <option value="3">LIBERADO</option>
                                    <option value="4">FATURADO</option>
                                </select>
                            </th>
                            <th class="col-xs-1"> 
                                <input type="text" id="pesquisa_data" name="pesquisa_data" class="input-mask-data" placeholder="dd/mm/yyyy" >
<!--                                <input type="text" name="pedido_data_entrega" id="pedido_data_entrega" class="form-control input-mask-data" placeholder="dd/mm/yyyy"  />-->
                            </th>
                            <th class="hidden-480">
                                <button class="btn btn-xs btn-alert" name="btn-pesquisar_p" type="submit">
                                    <i class="ace-icon fa fa-filter bigger-120 blue"></i>
                                    Filtrar
                                </button>
                            </th>                                           
                        </form>
                        <th class="hidden-480 center"  > 
                            <p>
                                <a href="pedido_cadastrar.php">
                                    <button class="btn btn-xs btn-success" name="btn-cadastrar" type="submit">
                                        <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                        Novo
                                    </button>
                                </a>
                            </p>
                        </th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <table id="simple-table " class="table table-striped table-responsive table-hover responsive">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th class="hidden-480">Cliente</th> 
                                <th class="hidden-480">Status</th>                                           
                                <th class="hidden-480">Data Cad.</th>
                                <th class="hidden-480">N° NF-e</th>
                                <th class="hidden-480">CPF/CNPJ</th>
                                <th class="hidden-480">F. Pag.</th>

                                <th class="hidden-480 center" colspan="2" >Configurar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $id = 1;
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $valor[$id] = $row['pedido_id'];
                                ?>
                            <form method="post" id="login-form">
                                <tr>
                                    <td><?php echo $row['pedido_id']; ?></td>
                                    <td class="hidden-480"><?php echo $row['cliente_nome']; ?></td>
                                    <td class="hidden-480">
                                        <?php
                                        if ($row['pedido_status'] == 1) {
                                            echo "P.";
                                        }
                                        if ($row['pedido_status'] == 2) {
                                            echo "C";
                                        }
                                        if ($row['pedido_status'] == 3) {
                                            echo "L";
                                        }
                                        if ($row['pedido_status'] == 4) {
                                            echo "F";
                                        }
                                        ?>
    <!--                                        <select class="col-sm-10" id="pedido_status" name="pedido_status" disabled="">
                                            <option value="1" <?= ($row['pedido_status'] == '1') ? 'selected' : '' ?> >P</option>
                                            <option value="2" <?= ($row['pedido_status'] == '2') ? 'selected' : '' ?> >C</option>
                                            <option value="3" <?= ($row['pedido_status'] == '3') ? 'selected' : '' ?> >L</option>
                                            <option value="4" <?= ($row['pedido_status'] == '4') ? 'selected' : '' ?> >F</option>
                                        </select>-->
                                    </td>                                              
                                    <td class="hidden-480"><?php echo date("d/m/Y", strtotime($row['pedido_data'])); ?></td>
                                    <td class="hidden-480"><?php echo $row['pedido_numero_nf']; ?></td>
                                    <td class="hidden-480"><?php echo $row['cliente_cpf_cnpj'] . $row['cliente_cpf']; ?></td>
                                    <td class="hidden-480"><?php echo $row['forma_pagamento_nome']; ?></td>

                                    <td class="hidden-480" align="center">
                                        <div class="form-group">
                                            <?php
                                            if ($row['pedido_status'] == '4') {
                                                ?>

                                                <button class="btn btn-xs btn-info" name="btn-consulta" type="submit">
                                                    <i class="ace-icon fa glyphicon-pencil bigger-40 blue"></i>
                                                    <input type="hidden" name="pedido_id" value="<?php echo $valor[$id]; ?>">
                                                    Cons.
                                                    <?php
                                                } else {
                                                    ?>
                                                    <button class="btn btn-xs btn-warning"  name="btn-editar" type="submit">
                                                        <i class="ace-icon fa glyphicon-pencil bigger-40 blue"></i>
                                                        <input type="hidden" name="pedido_id" value="<?php echo $valor[$id]; ?>">
                                                        Editar


                                                    </button>
                                                    <?php
                                                }
                                                ?>
                                        </div>
                                    </td>
                                    <?php
                                    if ($row['pedido_status'] == '3') {
                                        ?>

                                        <td class="hidden-480" align="center">
                                            <div class="form-group">
                                                <button class="btn btn-xs btn-danger"  name="btn-inativar" type="submit">
                                                    <i class="ace-icon fa fa-ban bigger-80 blue"></i>
                                                    <input type="hidden" name="pedido_id" value="<?php echo $valor[$id]; ?>">
                                                    Excluir

                                                </button>
                                            </div>
                                        </td>
                                        <?php
                                    }
                                    ?>
                                </tr>
                            </form>
                            <?php
                            $id++;
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

                            $total = $pagina + 10;

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
                                        if ($i < $total) {
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

<?php
require_once '../pagina/footer.php';
?>