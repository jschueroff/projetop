<?php
require_once 'contas_receber_config.php';
require_once '../pagina/menu.php';

$id_contas_receber = $_GET['id'];

$stmt_recebe = $auth_user->runQuery("SELECT * FROM recebimento, contas_receber WHERE"
        . " id_contas_receber = contas_receber_id AND id_contas_receber = :id_contas_receber");
$stmt_recebe->bindValue(':id_contas_receber', $id_contas_receber, PDO::PARAM_STR);
$stmt_recebe->execute();
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
                <li class="active">Recebimento</li>
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
                                    <button class="btn btn-sm btn-success" name="btn-pesquisar" type="submit">
                                        <i class="ace-icon fa fa-filter bigger-100 green"></i>
                                        Pesquisar
                                    </button>
                                </div>                            
                            </form>
                            <p>
                                <!--                                <a href="contas_receber_novo_recebimento.php">
                                                                    <button class="btn btn-xs btn-alert" type="submit">
                                                                        <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                                                        Novo
                                                                    </button>
                                                                </a>-->
                                <button type="button" class="btn btn-sm btn-info2" 
                                        data-toggle="modal" data-target="#modalrecebimento" 
                                        data-contas_receber_id="<?php echo $id_contas_receber ?>"

                                        >Novo</button>
                            </p>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <table id="simple-table" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th class="hidden-480">ID Contas</th>
                                            <th class="hidden-480">Dt. Pag.</th>
                                            <th class="hidden-480">Valor</th>
                                            <th class="hidden-480">Forma</th>
                                            <th class="hidden-480">Obs.</th>
                                            <th class="hidden-480">Tarifa</th>
                                            <th class="hidden-480">Banco</th>
                                            <th class="hidden-480">Desc</th>
                                            <th class="hidden-480 center" colspan="2" >Configurar</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $id = 1;
                                        while ($row = $stmt_recebe->fetch(PDO::FETCH_ASSOC)) {
                                            $valor[$id] = $row['recebimento_id'];
                                            ?>
                                        <form method="post" id="login-form">
                                            <tr>
                                                <td><?php echo $row['recebimento_id']; ?></td>
                                                <td class="hidden-480"><?php echo $row['id_contas_receber']; ?></td>
                                                <td class="hidden-480"><?php echo date("d/m/Y", strtotime($row['recebimento_data_pagamento'])); ?></td>

                                                <td class="hidden-480"><?php echo $row['recebimento_valor']; ?></td>
                                                <td class="hidden-480"><?php echo $row['recebimento_forma']; ?></td>
                                                <td class="hidden-480"><?php echo $row['recebimento_obs']; ?></td>
                                                <td class="hidden-480"><?php echo $row['recebimento_tarifa']; ?></td>
                                                <td class="hidden-480"><?php echo $row['recebimento_banco']; ?></td>
                                                <td class="hidden-480"><?php echo $row['recebimento_desconto']; ?></td>

                                                <td class="hidden-480" align="center">
                                                    <div class="form-group">
                                                        <!-- CHAMADA ESTA FUNCAO ESTA NO FOOTER -->
                                                        <button type="button" class="btn btn-xs btn-warning" 
                                                                data-toggle="modal" data-target="#myModaleditarrecebimento" 
                                                                data-recebimento_id="<?php echo $row['recebimento_id']; ?>"
                                                                data-id_contas_receber="<?php echo $row['id_contas_receber']; ?>"
                                                                data-recebimento_data_pagamento="<?php echo date("d/m/Y", strtotime($row['recebimento_data_pagamento'])); ?>"
                                                                data-recebimento_valor="<?php echo $row['recebimento_valor']; ?>"
                                                                data-recebimento_forma="<?php echo $row['recebimento_forma']; ?>"
                                                                data-recebimento_obs="<?php echo $row['recebimento_obs']; ?>"
                                                                data-recebimento_desconto="<?php echo $row['recebimento_desconto']; ?>"
                                                                data-recebimento_banco="<?php echo $row['recebimento_banco']; ?>"
                                                               
                                                                >
                                                            Editar
                                                        </button>
                                                    </div>
                                                </td>
                                                <td class="hidden-480" align="center">
                                                    <div class="form-group">
                                                        <!-- CHAMADA ESTA NO FOOTER VERIFICAR LA ISSO SE PRECISAR MUDAR LINHA 60 -->
                                                        <button type="button" class="btn btn-xs btn-danger" 
                                                                data-toggle="modal" data-target="#myModalexcluirrecebimentos" 
                                                                data-recebimento_id="<?php echo $row['recebimento_id']; ?>"
                                                                data-id_contas_receber="<?php echo $row['id_contas_receber']; ?>"
                                                                >
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

                            </div><!-- /.span -->
                        </div><!-- /.row -->


                        <!-- PAGE CONTENT ENDS -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.page-content -->
        </div>
    </div><!-- /.main-content -->
</div>

<!--MODAL DE EDICAO DO RECEBIMENTOS -->
<div class="modal fade" id="myModaleditarrecebimento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Recebimento</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <input name="recebimento_id" type="hidden" class="form-control" id="recebimento_id">
                    </div>
                    <div class="form-group">
                        <input name="id_contas_receber" type="hidden" class="form-control" id="id_contas_receber">
                    </div>
                    <div class="form-group">
                        <label for="recebimento_data_pagamento" class="control-label">Dt. Pagamento</label>
                        <input name="recebimento_data_pagamento" type="text" class="form-control" id="recebimento_data_pagamento">
                    </div>
                    <div class="form-group">
                        <label for="recebimento_valor" class="control-label">Valor</label>
                        <input name="recebimento_valor" type="text" class="form-control" id="recebimento_valor">
                    </div>
                    <div class="form-group">
                        <label for="recebimento_forma" class="control-label">Forma</label>
                        <input name="recebimento_forma" type="text" class="form-control" id="recebimento_forma">
                    </div>
                    <div class="form-group">
                        <label for="recebimento_obs" class="control-label">Obs.</label>
                        <input name="recebimento_obs" type="text" class="form-control" id="recebimento_obs">
                    </div>
                  
                    <div class="form-group">
                        <label for="recebimento_desconto" class="control-label">Desconto</label>
                        <input name="recebimento_desconto" type="text" class="form-control" id="recebimento_desconto">
                    </div>
                    <div class="form-group">
                        <label for="recebimento_banco" class="control-label">Banco</label>
                        <input name="recebimento_banco" type="text" class="form-control" id="recebimento_banco">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-salvar-recebimento" class="btn btn-xs btn-warning">Editar</button>
                    </div>
                </form>
            </div>			  
        </div>
    </div>
</div>

<!--MODAL PARA CADASTRAR NOVO RECEBIMENTO-->
<div class="modal fade" id="modalrecebimento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Recebimento</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="contas_receber_id" class="control-label">ID Contas Receber</label>
                        <input name="contas_receber_id" type="text" class="form-control" id="contas_receber_id">
                    </div>
                    <div class="form-group">
                        <label for="recebimento_data_pagamento" class="control-label">Dt. Pagamento</label>
                        <input name="recebimento_data_pagamento" type="text" class="form-control" value="<?php
                        date_default_timezone_set('America/Sao_Paulo');
                        echo date('d/m/Y');
                        ?>">
                    </div>
                    <div class="form-group">
                        <label for="recebimento_valor" class="control-label">Valor</label>
                        <input name="recebimento_valor" type="text" class="form-control" id="recebimento_valor" placeholder="0,00">
                    </div>
                    <div class="form-group">
                        <label for="recebimento_forma" class="control-label">Forma</label>
                        
                                <select class="form-control" name="recebimento_forma">
                                    
                                   
                                    <option value="DINHEIRO" selected="">DINHEIRO</option>
                                    <option value="CHEQUE">CHEQUE</option>                                                                        
                                    <option value="BANCO">BANCO</option>
                                                                                                          
                                </select>
                            
                    </div>
                    <div class="form-group">
                        <label for="recebimento_obs" class="control-label">Obs.</label>
                        <input name="recebimento_obs" type="text" class="form-control" id="recebimento_obs">
                    </div>
                    <div class="form-group">
                        <label for="recebimento_desconto" class="control-label">Desconto</label>
                        <input name="recebimento_desconto" type="text" class="form-control" id="recebimento_desconto">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-novo-recebimento" class="btn btn-xs btn-success">Cadastrar</button>
                    </div>
                </form>
            </div>			  
        </div>
    </div>
</div>

<!--MODAL PARA A EXCLUSÃO DE RECEBIMENTOS -->
<div class="modal fade" id="myModalexcluirrecebimentos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Recebimento</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                         <label for="recebimento_id" class="control-label">ID Recebimento</label>
                        <input name="recebimento_id" type="text" class="form-control" id="recebimento_id">
                    </div>
                    <div class="form-group">
                         <label for="id_contas_receber" class="control-label">ID Contas Receber</label>
                        <input name="id_contas_receber" type="text" class="form-control" id="id_contas_receber">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-excluir-recebimento" class="btn btn-xs btn-danger">Excluir</button>
                    </div>
                </form>
            </div>			  
        </div>
    </div>
</div>

<?php
require_once '../pagina/footer.php';
?>