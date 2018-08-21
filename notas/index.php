<?php
require_once 'notas_config.php';
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
                <li class="active">Nova NF-e</li>
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
                                    <input type="text" name="notas_pesquisa" class="col-xs-6" placeholder="N° NF-e/Destinatário"/>
                                    <button class="btn btn-info btn-sm" name="btn-pesquisar" type="submit">
                                        <i class="ace-icon fa fa-filter bigger-100 green"></i>
                                        Pesquisar
                                    </button>
                                </div>                            
                            </form>
                            <p>
                                <a href="notas_cadastrar.php">
                                    <button class="btn btn-success btn-sm" name="btn-cadastrar" type="submit">
                                        <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                        Novo
                                    </button>
                                </a>
                            </p>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <table id="simple-table" class="table table-striped table-bordered table-responsive">

                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th class="hidden-480">Cliente</th> 
                                            <th class="hidden-480">E/S</th> 
                                            <th class="hidden-480">N° NF-e</th> 
                                            <th class="hidden-480">N° Ped.</th>
                                            <th class="hidden-480">Status</th>
                                            <th class="hidden-480 center" colspan="2">Enviar/Visualizar</th>
                                            <th class="hidden-480 center" colspan="2">Danfe/Email</th>
                                            <th>Editar</th>

                                        </tr>
                                    </thead>
                                    <tbody class="reponsive">
                                        <?php
                                        while ($row = $stmt_notas_emitidas->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                            <tr>
                                                <th><?php echo $row['nota_id'] ?></th>

                                                <th class="hidden-480"><?php echo $row['nota_cliente']; ?></th>
                                                <th class="hidden-480"><?php
                                                    if ($row['nota_tipo'] == 0) {
                                                        echo "E";
                                                    } else {
                                                        echo "S";
                                                    }
                                                    ?></th>
                                                <th class="hidden-480"><?php echo $row['nota_numero_nf']; ?></th>
                                                <th class="hidden-480"><?php echo $row['id_pedido']; ?></th>

                                                <!--VERIFICA O STATUS DA EMISSAO DA NFE-->
                                                <th class="hidden-480 center"><?php
                                                    if ($row['nota_status'] == 6) {
                                                        ?> 
                                                        <button type="button" class="btn btn-xs btn-info2">Inutilizada</button>
                                                        <?php
                                                    } else {
                                                        if ($row['nota_cStat'] != 100) {
                                                            if ($row['nota_cStat'] != NULL) {
                                                                ?>
                                                                <button type="button" class="btn btn-minier btn-danger" 
                                                                        data-toggle="modal" data-target="#myModal9" 
                                                                        data-nota_id="<?php echo $row['nota_id']; ?>"
                                                                        data-nota_cliente="<?php echo $row['nota_cliente']; ?>"
                                                                        data-nota_chave="<?php echo $row['nota_chave']; ?>"
                                                                        data-nota_ambiente="<?php echo $row['nota_xMotivo']; ?>"
                                                                        data-nota_numero_nf="<?php echo $row['nota_cStat']; ?>"
                                                                        >Status</button>
                                                                        <?php
                                                                    }
                                                                } else {
                                                                    if ($row['nota_status'] == 5) {
                                                                        ?> 
                                                                <button type="button" class="btn btn-minier btn-info2">Cancelada</button>
                                                                <?php
                                                            }
                                                            if ($row['nota_status'] == 4) {
                                                                ?> 
                                                                <button type="button" class="btn btn-minier btn-success">Autorizada</button>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </th>
                                                <!--ENVIA PARA A SEFAZ-->
                                                <th class="hidden-480 center">
                                                    <!-- CHAMADA ESTA NO FOOTER VERIFICAR LA ISSO SE PRECISAR MUDAR LINHA 60 -->
                                                    <?php if ($row['nota_status'] == 3) { ?>
                                                        <button type="button" class="btn btn-minier btn-warning" 
                                                                data-toggle="modal" data-target="#myModal2" 
                                                                data-nota_id="<?php echo $row['nota_id']; ?>"
                                                                data-nota_cliente="<?php echo $row['nota_cliente']; ?>"
                                                                data-nota_chave="<?php echo $row['nota_chave']; ?>"
                                                                data-nota_ambiente="<?php echo $row['nota_ambiente']; ?>"
                                                                data-nota_numero_nf="<?php echo $row['nota_numero_nf']; ?>"
                                                                >Envia</button>
                                                            <?php } ?>

                                                </th>
                                                <!-- VISUALIZA A NOTA 110 -->
                                                <th class="hidden-480 center">
                                                    <?php if ($row['nota_status'] == 3) { ?>
                                                        <button type="button" class="btn btn-minier btn-primary" 
                                                                data-toggle="modal" data-target="#myModal5" 
                                                                data-nota_id="<?php echo $row['nota_id']; ?>"
                                                                data-nota_cliente="<?php echo $row['nota_cliente']; ?>"
                                                                data-nota_chave="<?php echo $row['nota_chave']; ?>"
                                                                >Vis.</button>
                                                            <?php } ?>

                                                </th>
                                                <!--GERA O PDF DA NOTA-->
                                                <th class="hidden-480 center">
                                                    <!-- CHAMADA ESTA NO FOOTER VERIFICAR LA ISSO SE PRECISAR MUDAR LINHA 110 -->
                                                    <?php if ($row['nota_status'] == 4) { ?>
                                                        <button type="button" class="btn btn-minier btn-warning" 
                                                                data-toggle="modal" data-target="#myModal3" 
                                                                data-nota_id="<?php echo $row['nota_id']; ?>"
                                                                data-nota_cliente="<?php echo $row['nota_cliente']; ?>"
                                                                data-nota_chave="<?php echo $row['nota_chave']; ?>"

                                                                >Danfe</button>
                                                            <?php } ?>

                                                </th>
                                                <!--ENVIA O EMAIL COM O XML E O PDF-->
                                                <th class="hidden-480 center">
                                                    <!-- CHAMADA ESTA NO FOOTER VERIFICAR LA ISSO SE PRECISAR MUDAR LINHA 110 -->
                                                    <?php if ($row['nota_status'] == 4) { ?>
                                                        <button type="button" class="btn btn-minier btn-warning" 
                                                                data-toggle="modal" data-target="#myModal4" 
                                                                data-nota_id="<?php echo $row['nota_id']; ?>"
                                                                data-nota_cliente="<?php echo $row['nota_cliente']; ?>"
                                                                data-nota_chave="<?php echo $row['nota_chave']; ?>"

                                                                >Envio XML/PDF</button>
                                                            <?php } ?>

                                                </th>
                                                <th>
                                                    <!-- CHAMADA ESTA NO FOOTER VERIFICAR LA ISSO SE PRECISAR MUDAR LINHA 110 -->
                                                    <?php if ($row['nota_status'] == 4) { ?>
                                                        <button type="button" class="btn btn-minier btn-success" 
                                                                data-toggle="modal" data-target="#myModal98" 
                                                                data-nota_id="<?php echo $row['nota_id']; ?>"
                                                                data-nota_cliente="<?php echo $row['nota_cliente']; ?>"
                                                                data-nota_chave="<?php echo $row['nota_chave']; ?>"
                                                                data-nota_stat ="4"

                                                                >Consultar</button>
                                                                <?php
                                                            }
                                                            if ($row['nota_status'] == 3) {
                                                                ?>
                                                        <button type="button" class="btn btn-minier btn-info2" 
                                                                data-toggle="modal" data-target="#myModal98" 
                                                                data-nota_id="<?php echo $row['nota_id']; ?>"
                                                                data-nota_cliente="<?php echo $row['nota_cliente']; ?>"
                                                                data-nota_chave="<?php echo $row['nota_chave']; ?>"
                                                               
                                                                >

                                                            Editar</button>
                                                        <?php
                                                    }
                                                  
                                                            if ($row['nota_status'] == 5) {
                                                                ?>
                                                        <button type="button" class="btn btn-minier btn-info2" 
                                                                data-toggle="modal" data-target="#myModal98" 
                                                                data-nota_id="<?php echo $row['nota_id']; ?>"
                                                                data-nota_cliente="<?php echo $row['nota_cliente']; ?>"
                                                                data-nota_chave="<?php echo $row['nota_chave']; ?>"
                                                                
                                                                >

                                                            Consultar</button>
                                                        <?php
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
</div>

<!--

A CHAMADA DO JAVASCRIP ESTA NO FOOTER VERIFCAR LA ISSO E ABAIXO MOSTRA OS DADOS NO FOOTER
-->
<!--ENVIA PARA A SEFAZ-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Pedido</h4>
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
                    <input type="hidden" name="nota_chave" class="form-control" id="nota_chave">
                    <div class="form-group">
                        <label for="nota_ambiente" class="control-label">Ambiente</label>
                        <input name="nota_ambiente" type="text" class="form-control" id="nota_ambiente">
                    </div>
                    <div class="form-group">
                        <label for="nota_numero_nf" class="control-label">N° NF-e</label>
                        <input name="nota_numero_nf" type="text" class="form-control" id="nota_numero_nf">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-transmite" class="btn btn-xs btn-success">Emitir NF-e</button>
                    </div>
                </form>
            </div>			  
        </div>
    </div>
</div>
<!--IMPRIME O PDF-->
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Nota</h4>
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-danfe" target="_blank" class="btn btn-xs btn-success">Emitir Danfe</button>
                    </div>
                </form>
            </div>			  
        </div>
    </div>
</div>
<!--ENVIA EMAIL PARA O CLIENTE-->
<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Envio XML/DANFE</h4>
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-email" class="btn btn-xs btn-success">Enviar XML/PDF</button>
                    </div>
                </form>
            </div>			  
        </div>
    </div>
</div>
<!--VISUALIZA A DANFE ANTES DE EMITIR-->
<div class="modal fade" id="myModal5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Nota</h4>
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
                    <input type="text" name="nota_chave" class="form-control" id="nota_chave">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-visualizar" target="_blank" class="btn btn-xs btn-success">Visualizar</button>
                    </div>
                </form>
            </div>			  
        </div>
    </div>
</div>
<!--CONSULTA O STATUS DO RETORNO/VALIDAÇÃO OK-->
<div class="modal fade" id="myModal9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Pedido</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <input name="nota_id" type="hidden" class="form-control" id="nota_id">
                    </div>
                    <div class="form-group">
                        <label for="nota_cliente" class="control-label">Nome</label>
                        <input name="nota_cliente" type="text" class="form-control" id="nota_cliente">


                        <div class="form-group">
                            <label for="nota_numero_nf" class="control-label">Status</label>
                            <input name="nota_numero_nf" type="text" class="form-control" id="nota_numero_nf">
                        </div>

                        <div class="form-group">
                            <label for="nota_ambiente" class="control-label">Motivo</label>
                            <input name="nota_ambiente" type="text" class="form-control" id="nota_ambiente">
                        </div>


                        <div class="modal-footer">

                            <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Cancelar</button>
                        </div>
                </form>
            </div>			  
        </div>
    </div>
</div>
</div>
<!--EDITA A NFE QUANDO REJEITADA PELA SEFAZ-->
<div class="modal fade" id="myModal98" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Edita/Consulta a NF-e</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nota_id" class="control-label">ID</label>
                        <input name="nota_id" type="text" class="form-control" id="nota_id">
                    </div>
                    <div class="form-group">
                        <label for="nota_cliente" class="control-label">Nome</label>
                        <input name="nota_cliente" type="text" class="form-control" id="nota_cliente">
                    </div>
                    <div class="form-group">
                        <label for="nota_cliente" class="control-label">Chave</label>
                        <input type="text" name="nota_chave" class="form-control" id="nota_chave">
                    </div>
                 
                    

                    <div class="modal-footer">
                        <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-edita" class="btn btn-xs btn-success">Editar</button>
                    </div>
                </form>
            </div>			  
        </div>
    </div>
</div>

<?php
require_once '../pagina/footer.php';
?>