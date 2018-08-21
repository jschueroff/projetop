<?php
require_once 'entradas_config.php';
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
                <li class="active">Entradas</li>
            </ul><!-- /.breadcrumb -->

        </div>

        <div class="page-content">

            <?php
            include '../principal/principal_config.php';
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
                                                                    <input type="text"  name="nome_fornecedor_pesquisa" class="form-control" placeholder="Nome Fornecedor"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <div class="form-group">

                                                                    <button class="btn btn-primary btn-sm" name="btn-pesquisar" type="submit">
                                                                        <i class="ace-icon fa fa-filter bigger-100 white"></i>
                                                                        Pesquisar
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        
                                                        <div class="col-sm-2">
                                                            <div class="form-group">
                                                                <form  method="post">

                                                                    <button  class="btn btn-primary btn-sm" name="btn-buscar" type="submit">
<!--                                                                        <i class="ace-icon fa fa-download   bigger-100 white"></i>-->
                                                                        <i class="glyphicon glyphicon-check green"></i>
                                                                        Buscar
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
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

            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-12">
                                <table  class="table table-responsive table-bordered table-sm">
                                 
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th class="hidden-480">Nome</th>
                                            <th class="hidden-480">CNPJ</th>
                                            <th class="hidden-480">Valor</th>
                                            <th class="hidden-480">Dt. Emi</th>
                                            <th class="hidden-480">Vis.</th>
                                          
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        while ($row = $stmt_dados_busca->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                        <form method="post" id="login-form">
                                            <tr>
                                                <td class="hidden-480"><?php echo $row['entrada_nota_id']; ?></td>
                                                <td class="hidden-480"><?php echo $row['entrada_nota_xNome']; ?></td>
                                                <td ><?php echo $row['entrada_nota_CNPJ']; ?></td>
                                                <td class="hidden-480"><?php echo $row['entrada_nota_vNF']; ?></td>
                                                <td class="hidden-480"><?php echo date("d/m/Y", strtotime($row['entrada_nota_dhEmi']));   ?></td>
                                                <td class="hidden-480">
                                                    <button type="button" class="btn btn-xs btn-success" 
                                                            data-toggle="modal" data-target="#downloald-nfe" 
                                                            
                                                            data-entrada_nota_id="<?php echo $row['entrada_nota_id'] ?>"
                                                            data-downloald_chave="<?php echo $row['entrada_nota_chNFe'] ?>"
                                                            data-downloald_cnpj="<?php echo $row['entrada_nota_CNPJ'] ?>"

                                                            >Acessar</button>
                                                </td>

                                                
                                            </tr>
                                        </form>
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
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.page-content -->
        </div>
    </div>
</div><!-- /.main-content -->


<!--FAZ DOWNLOALD DA NFE DO SITE DA SEFAZ-->
<div class="modal fade" id="downloald-nfe" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Captcha</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">

                   

                    <div class="row">
                        
                        <input name="entrada_nota_id" class="form-control" type="hidden" id="entrada_nota_id">
                         
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">CNPJ</label>
                                <input name="downloald_cnpj1" id="downloald_cnpj1" type="text" disabled="" class="form-control">
<!--                                <input name="downloald_cnpj" id="downloald_cnpj" type="hidden" class="form-control">
                                <input name="downloald_chave" id="downloald_chave" type="hidden" class="form-control">-->
                                <input name="downloald_chave" id="downloald_chave" type="hidden" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Cancelar</button>

                        <button type="submit" name="btn-downloald" class="btn btn-xs btn-success">Confirmar</button>
                    </div>
                </form>
            </div>			  
        </div>
    </div>
</div>

<?php
require_once '../pagina/footer.php';
?>