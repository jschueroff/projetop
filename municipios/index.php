<?php
require_once 'municipio_config.php';
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
                <li class="active">MUNICIPIOS</li>
            </ul><!-- /.breadcrumb -->

        </div>

        <div class="page-content">
            <?php
            include_once '../principal/principal_config.php';
            ?>

            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <div class="row">
                            <form class="form-horizontal" method="post">                            
                                <div class="col-xs-7">

                                    <input type="text" id="municipio_pesquisa" name="municipio_pesquisa" class="col-xs-6" placeholder="Municipio ou Cod IBGE"/>

                                    <button class="btn btn-sm btn-primary" name="btn-pesquisar" type="submit">
                                        <i class="ace-icon fa fa-filter bigger-100 green"></i>
                                        Pesquisar
                                    </button>
                                </div>                            
                            </form>
                            <p>
                                <a href="municipio_cadastrar.php">
                                    <button class="btn btn-sm btn-success" name="btn-cadastrar" type="submit">
                                        <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                        Novo
                                    </button>
                                </a>
                            </p>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <table id="simple-table" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th class="hidden-480">Municipio</th>
                                            <th class="hidden-480">Cod. IBGE</th>
                                            <th class="hidden-480">Estado</th>
                                            <th class="hidden-480 center" colspan="2" >Configurar</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $id = 1;
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            $valor[$id] = $row['municipio_id'];
                                            ?>
                                        <form method="post" id="login-form">
                                            <tr>
                                                <td><?php echo $row['municipio_id']; ?></td>
                                                <td class="hidden-480"><?php echo $row['municipio_nome']; ?></td>

                                                <td class="hidden-480"><?php echo $row['municipio_cod_ibge']; ?></td>
                                                <th class="hidden-480"><?php echo $row['estado_sigla']; ?></th>
                                                <td class="hidden-480" align="center">
                                                    <div class="form-group">
                                                        <button class="btn btn-xs btn-warning" name="btn-editar" type="submit">
                                                            <i class="ace-icon fa glyphicon-pencil bigger-80 blue"></i>
                                                            <input type="hidden" name="municipio_id" value="<?php echo $valor[$id]; ?>">
                                                            Editar
                                                        </button>
                                                    </div>
                                                </td>
                                                <td class="hidden-480" align="center">
                                                    <div class="form-group">

                                                        <button class="btn btn-xs btn-danger" name="btn-inativar" type="submit">
                                                            <i class="ace-icon fa fa-ban bigger-80 blue"></i>
                                                            <input type="hidden" name="municipio_id" value="<?php echo $valor[$id]; ?>">
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
                                                    //senão adiciona os links para outra pagina
                                                    if ($i < $total) {
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