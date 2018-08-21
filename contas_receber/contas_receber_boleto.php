<?php
require_once 'contas_receber_config.php';
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
                <li class="active">Boleto</li>
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
                            <form class="form-horizontal" method="post">                            
                                <div class="col-xs-7">
                                    <input type="text" id="contas_receber_pesquisa" name="contas_receber_pesquisa" class="col-xs-7" placeholder="Cliente" autofocus=""/>
                                    <input type="text" id="contas_receber_pesquisa2" name="contas_receber_pesquisa2" class="col-xs-2" placeholder="N° NF-e" />
                                    <button class="btn btn-sm btn-primary" name="btn-pesquisar" type="submit">
                                        <i class="ace-icon fa fa-filter bigger-100 green"></i>
                                        Pesquisar
                                    </button>
                                </div>                            
                            </form>
                            <p>
                                <a href="contas_receber_cadastro.php">
                                    <button class="btn btn-sm btn-success" name="btn-cadastrar" type="submit">
                                        <i class="ace-icon fa fa-floppy-o bigger-120 green"></i>
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
                                            <th class="hidden-480">Nome</th>
                                            <th class="hidden-480">N° NF-e</th>
                                            <th class="hidden-480">N° Ped.</th>
                                            <th class="hidden-480">N°</th>
                                           
                                            <th class="hidden-480">Vencimento</th>
                                            <th class="hidden-480">Valor</th>
                                            <th class="hidden-480">Pago</th>
                                            <th class="hidden-480">Subtotal</th>
                                            <th class="hidden-480">Status</th>
                                            <th class="hidden-480 center">Configurar</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $id = 1;
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            $valor[$id] = $row['contas_receber_id'];
                                            ?>
                                        <form method="post" id="login-form">
                                            <tr>
                                                <td><?php echo $row['contas_receber_id']; ?></td>
                                                <td class="hidden-480"><?php echo $row['cliente_nome']; ?></td>
                                                <td class="hidden-480"><?php echo $row['id_nota']; ?></td>
                                                <td class="hidden-480"><?php echo $row['id_pedido']; ?></td>
                                                <td class="hidden-480"><?php echo $row['contas_receber_numero']; ?></td>
                                                <td class="hidden-480"><?php echo date("d/m/Y", strtotime($row['contas_receber_vencimento'])); ?></td>
                                                <td class="hidden-480"><?php echo $row['contas_receber_valor']; ?></td>
                                                <td class="hidden-480"><?php echo $row['contas_receber_saldo']; ?></td>
                                                <td class="hidden-480"><?php $formatted = sprintf("%01.2f", ($row['contas_receber_valor'] - $row['contas_receber_saldo']));// ; 
                                                echo $formatted;
                                                
                                                ?></td>
                                                <td class="hidden-480"><?php
                                                    if ($row['contas_receber_status'] == 0) {
                                                        ?>
                                                    <button class="btn btn-xs btn-warning"  type="button">
                                                          Aberta
                                                        </button>

                                                        <?php
                                                    }
                                                    if ($row['contas_receber_status'] == 1) {
                                                     ?>
                                                    <button class="btn btn-xs btn-info2"  type="button">
                                                          Parcial
                                                        </button>
                                                    
                                                    <?php
                                                    }
                                              if ($row['contas_receber_status'] == 2) {
                                                  ?>
                                                     <button class="btn btn-xs btn-success"  type="button">
                                                          Pago
                                                        </button>
                                                    
                                                    <?php
                                              }


                                                   
                                                    ?></td>

                                                <td class="hidden-480" align="center">
                                                    <div class="form-group">

                                                        <!-- CHAMADA ESTA NO FOOTER VERIFICAR LA ISSO SE PRECISAR MUDAR LINHA 60 -->
                                                        <button type="button" class="btn btn-xs btn-success" 
                                                                data-toggle="modal" data-target="#myModalgeraboleto" 
                                                                data-contas_receber_id="<?php echo $row['contas_receber_id']; ?>"
                                                                data-contas_receber_numero="<?php echo $row['contas_receber_numero']; ?>">
                                                            Boleto
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

<
A CHAMADA DO JAVASCRIP ESTA NO FOOTER VERIFCAR LA ISSO E ABAIXO MOSTRA OS DADOS NO FOOTER
-->
<!--MODAL PARA A EMISSAO DO BOLETO-->
<div class="modal fade" id="myModalgeraboleto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">BOLETO</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data" target="_blank" action="../boleto/boleto_config_bancoob.php">
                    <div class="form-group">
                        <input name="contas_receber_id" type="hidden" class="form-control" id="contas_receber_id">
                    </div>
                    <div class="form-group">
                        <label for="contas_receber_numero" class="control-label">Número</label>
                        <input name="contas_receber_numero" type="text" class="form-control" id="contas_receber_numero">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-emite-boleto" class="btn btn-xs btn-success">Emitir Boleto</button>
                    </div>
                </form>
            </div>			  
        </div>
    </div>
</div>


<?php
require_once '../pagina/footer.php';
?>