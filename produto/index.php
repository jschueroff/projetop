<?php
require_once 'produto_config.php';
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
                <li class="active">Produtos</li>
            </ul><!-- /.breadcrumb -->


        </div>

        <div class="page-content">
            <?php
            require_once '../principal/principal_config.php';
            ?>

            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-12">
                                <fieldset>
                                    <form method="post">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" id="funcionario_id" name="produto_pesquisa" class="form-control" placeholder="Pesquisa por Nome"/>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <button class="btn btn-info btn-sm" name="btn-pesquisar" type="submit">
                                                <i class="ace-icon fa fa-filter bigger-120 blue"></i>
                                                Pesquisar
                                            </button>                                           
                                        </div>
                                    </form>
                                    <p>
                                        <a href="produto_cadastrar.php">
                                            <button class="btn btn-success btn-sm" name="btn-cadastrar" type="submit">
                                                <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                                Novo
                                            </button>
                                        </a>
                                    </p>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <fieldset> 
                                    <legend>Listar Produtos</legend>
                                    <table id="simple-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th class="hidden-480">Nome</th>
                                                <th class="hidden-480">Preço</th>
                                                <th class="hidden-480">Est.</th>
                                                <th class="hidden-480">UNI</th>
                                                <th class="hidden-480 center" colspan="2" >Configurar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $id = 1;
                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                $valor[$id] = $row['produto_id'];
                                                ?>
                                            <form method="post" id="login-form">
                                                <tr>
                                                    <td><?php echo $row['produto_id']; ?></td>
                                                    <td class="hidden-480"><?php echo $row['produto_nome']; ?></td>
                                                    <td class="hidden-480"><?php echo $row['produto_preco']; ?></td>
                                                    <td class="hidden-480"><?php echo $row['estoque_quantidade']; ?></td>
                                                    <td class="hidden-480"><?php echo $row['unidade_nome']; ?></td>
                                                    <td class="hidden-480" align="center">
                                                        <div class="form-group">
                                                            <button class="btn btn-warning btn-xs" name="btn-editar" type="submit">
                                                                <i class="ace-icon fa glyphicon-pencil bigger-80 blue"></i>
                                                                <input type="hidden" name="produto_id" value="<?php echo $valor[$id]; ?>">
                                                                Editar
                                                            </button>
                                                        </div>
                                                    </td>

                                                    <td class="hidden-480" align="center">
                                                        <div class="form-group">
                                                            <?php
                                                            if ($row['produto_status'] == 1) {
                                                                ?>

                                                                <button class="btn btn-xs btn-danger" name="btn-inativar" type="submit">
                                                                    <i class="ace-icon fa fa-ban bigger-80 blue"></i>

                                                                    <input type="hidden" name="produto_id" value="<?php echo $valor[$id]; ?>">
                                                                    Inativar
                                                                </button>
                                                                <?php
                                                            }
                                                            if ($row['produto_status'] == 0) {
                                                                ?>
                                                                <button class="btn btn-xs btn-inverse" name="btn-ativar" type="submit">
                                                                    <i class="ace-icon fa fa-check bigger-80 blue"></i>
                                                                    <input type="hidden" name="produto_id" value="<?php echo $valor[$id]; ?>">
                                                                    Ativar
                                                                </button>

                                                                <?php
                                                            }
                                                            ?>



                                                        </div>
                                                    </td>




    <!--                                                    <td class="hidden-480" align="center">
        <div class="form-group">

            <button class="btn btn-danger btn-minier" name="btn-inativar" type="submit">
                <i class="ace-icon fa fa-ban bigger-80 blue"></i>
                <input type="hidden" name="produto_id" value="<?php echo $valor[$id]; ?>">
                Inativar
            </button>
        </div>
    </td>-->
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
                                            $max_links = 10;
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
                                                    echo "<div class='pagination'><a href=" . $_SERVER['PHP_SELF'] . "?pagina=$previous><input type='submit'  name='bt-enviar' id='bt-enviar' value='ANTERIOR' class='button btn btn-white btn-sm btn-primary' /></a></div>";
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
                                                                echo "<span class='btn btn-white btn-sm btn-primary'> " . $i . "</span>";
                                                            }
                                                        }
                                                    }
                                                }

                                                echo "</div>";

                                                //botao proximo
                                                if ($next <= $pgs) {
                                                    echo " <div class='pagination'><a href=" . $_SERVER['PHP_SELF'] . "?pagina=$next><input type='submit'  name='bt-enviar' id='bt-enviar' value='PROXIMA' class='button btn btn-white btn-sm btn-primary'/></a></div>";
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>

                                </fieldset>
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