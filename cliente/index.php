<?php
require_once 'cliente_config.php';
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
                <li class="active">Cliente</li>
            </ul><!-- /.breadcrumb -->


        </div>

        <div class="page-content">
            <?php
            require_once '../principal/principal_config.php';
            ?>

            <div class="row">
                <div class="col-xs-12">

                    <fieldset>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="widget-box">
                                    <div class="widget-header widget-header-flat">
                                        <h4 class="widget-title smaller">
                                            Pesquisar
                                        </h4>
                                    </div>

                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class='row'>
                                                        <form  method="post">
                                                            <div class='col-sm-6'>    
                                                                <div class='form-group'>
                                                                    <input type="text" name="cliente_pesquisa" class="form-control" placeholder="Nome ou CPF/CNPJ"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <div class="form-group">

                                                                    <button class="btn btn-primary btn-sm" name="btn-pesquisar" type="submit">
                                                                        <i class="ace-icon fa fa-filter bigger-100 green"></i>
                                                                        Pesquisar
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <div class="col-sm-2">
                                                            <div class="form-group">
                                                                <a href="cliente_cadastrar.php">
                                                                    <button class="btn btn-sm btn-success" name="btn-cadastrar" type="submit">
                                                                        <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                                                        Novo
                                                                    </button>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-group">
                                                                <a href="cliente_relatorio.php">
                                                                    <button class="btn btn-sm btn-success" type="submit">
                                                                        <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                                                        Relatórios
                                                                    </button>
                                                                </a>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <table id="simple-table" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th class="hidden-480">Nome</th>                                           
                                                        <th class="hidden-480">CPF/CNPJ</th>
                                                        <th class="hidden-480 center" colspan="2" >Configurar</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $id = 1;
                                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                        $valor[$id] = $row['cliente_id'];
                                                        ?>
                                                    <form method="post" id="login-form">
                                                        <tr>
                                                            <td><?php echo $row['cliente_id']; ?></td>
                                                            <td class="hidden-480"><?php echo $row['cliente_nome']; ?></td>                                              
                                                            <td class="hidden-480"><?php echo $row['cliente_cpf_cnpj'] . $row['cliente_cpf']; ?></td>
                                                            <td class="hidden-480" align="center">
                                                                <div class="form-group">
                                                                    <button class="btn btn-warning btn-xs" name="btn-editar" type="submit">
                                                                        <i class="ace-icon fa glyphicon-pencil bigger-80 blue"></i>
                                                                        <input type="hidden" name="cliente_id" value="<?php echo $valor[$id]; ?>">
                                                                        Editar
                                                                    </button>
                                                                </div>
                                                            </td>
                                                            <td class="hidden-480" align="center">
                                                                <div class="form-group">
                                                                    <?php
                                                                    if ($row['cliente_status'] == 1) {
                                                                        ?>

                                                                        <button class="btn btn-danger btn-xs" name="btn-inativar" type="submit">
                                                                            <i class="ace-icon fa fa-ban bigger-80 blue"></i>
                                                                            <input type="hidden" name="cliente_id" value="<?php echo $valor[$id]; ?>">
                                                                            Inativar
                                                                        </button>
                                                                        <?php
                                                                    }
                                                                    if ($row['cliente_status'] == 0) {
                                                                        ?>
                                                                        <button class="btn btn-info btn-xs" name="btn-ativar" type="submit">
                                                                            <i class="ace-icon fa fa-ban bigger-80 blue"></i>
                                                                            <input type="hidden" name="cliente_id" value="<?php echo $valor[$id]; ?>">
                                                                            Ativar
                                                                        </button>
                                                                        <?php
                                                                    }
                                                                    ?>

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
                                                            echo " <div class='pagination'><a href=" . $_SERVER['PHP_SELF'] . "?pagina=$next><input type='submit'  name='bt-enviar' id='bt-enviar' value='Proxima' class='button btn btn-white btn-sm btn-primary'/></a></div>";
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>

                                        </div> 
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



<!--


            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <div class="row">
                            <form class="form-horizontal" method="post">                            
                                <div class="col-xs-7">
                                    <input type="text" name="cliente_pesquisa" class="col-xs-6" placeholder="Nome ou CPF/CNPJ"/>
                                    <button class="btn btn-primary btn-sm" name="btn-pesquisar" type="submit">
                                        <i class="ace-icon fa fa-filter bigger-100 green"></i>
                                        Pesquisar
                                    </button>
                                </div>                            
                            </form>
                            <p>
                                <a href="cliente_cadastrar.php">
                                    <button class="btn btn-sm btn-success" name="btn-cadastrar" type="submit">
                                        <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                        Novo
                                    </button>
                                </a>
                            </p>
                            <p>
                                <a href="cliente_relatorio.php">
                                    <button class="btn btn-sm btn-success" type="submit">
                                        <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                        Relatórios
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
                                            <th class="hidden-480">Nome</th>                                           
                                            <th class="hidden-480">CPF/CNPJ</th>
                                            <th class="hidden-480 center" colspan="2" >Configurar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$id = 1;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $valor[$id] = $row['cliente_id'];
    ?>
                                                                                    <form method="post" id="login-form">
                                                                                        <tr>
                                                                                            <td><?php echo $row['cliente_id']; ?></td>
                                                                                            <td class="hidden-480"><?php echo $row['cliente_nome']; ?></td>                                              
                                                                                            <td class="hidden-480"><?php echo $row['cliente_cpf_cnpj']; ?></td>
                                                                                            <td class="hidden-480" align="center">
                                                                                                <div class="form-group">
                                                                                                    <button class="btn btn-warning btn-xs" name="btn-editar" type="submit">
                                                                                                        <i class="ace-icon fa glyphicon-pencil bigger-80 blue"></i>
                                                                                                        <input type="hidden" name="cliente_id" value="<?php echo $valor[$id]; ?>">
                                                                                                        Editar
                                                                                                    </button>
                                                                                                </div>
                                                                                            </td>
                                                                                            <td class="hidden-480" align="center">
                                                                                                <div class="form-group">
    <?php
    if ($row['cliente_status'] == 1) {
        ?>

                                                                                                                                                    <button class="btn btn-danger btn-xs" name="btn-inativar" type="submit">
                                                                                                                                                        <i class="ace-icon fa fa-ban bigger-80 blue"></i>
                                                                                                                                                        <input type="hidden" name="cliente_id" value="<?php echo $valor[$id]; ?>">
                                                                                                                                                        Inativar
                                                                                                                                                    </button>
        <?php
    }
    if ($row['cliente_status'] == 0) {
        ?>
                                                                                                                                                    <button class="btn btn-info btn-xs" name="btn-ativar" type="submit">
                                                                                                                                                        <i class="ace-icon fa fa-ban bigger-80 blue"></i>
                                                                                                                                                        <input type="hidden" name="cliente_id" value="<?php echo $valor[$id]; ?>">
                                                                                                                                                        Ativar
                                                                                                                                                    </button>
        <?php
    }
    ?>

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

                            </div> /.span 
                        </div> /.row 


                         PAGE CONTENT ENDS 
                    </div> /.col 
                </div> /.row 
            </div> /.page-content 
        </div>
    </div> /.main-content -->

<?php
require_once '../pagina/footer.php';
?>