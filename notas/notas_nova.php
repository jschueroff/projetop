<?php
require_once 'notas_config.php';
require_once '../pagina/menu.php';


$stmt_pedido = $auth_user->runQuery("SELECT * FROM pedido, forma_pagamento, cliente WHERE pedido.pedido_status = 3 AND forma_pagamento.forma_pagamento_id = pedido.id_forma_pagamento AND 
cliente.cliente_id = pedido.id_cliente ORDER BY pedido.pedido_id ASC");
$stmt_pedido->execute();


$stmt_transportador = $auth_user->runQuery("SELECT * FROM transportador WHERE transportador_status = 1");
$stmt_transportador->execute();

//MOSTRA OS PEDIDOS LIBERADO PARA A EMISSAO DA NFE
$stmt_nota = $auth_user->runQuery("select * from nota, pedido, cliente where"
        . " id_pedido = pedido_id and id_cliente = cliente_id ORDER BY nota_id DESC");
$stmt_nota->execute();
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
                                    <input type="text" id="ncm_id" name="notas_pesquisa" class="col-xs-6" placeholder="Chave ou Cliente"/>
                                    <button class="btn btn-white btn-info btn-bold col-xs-3" name="btn-pesquisar" type="submit">
                                        <i class="ace-icon fa fa-filter bigger-100 green"></i>
                                        Pesquisar
                                    </button>
                                </div>                            
                            </form>
                            <p>
                                <a href="notas_cadastrar.php">
                                    <button class="btn btn-white btn-info btn-bold" name="btn-cadastrar" type="submit">
                                        <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                        Novo
                                    </button>
                                </a>
                            </p>
                        </div>
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
                                <table id="simple-table" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th class="hidden-480">Data Ped.</th>                                           
                                            <th class="hidden-480">Cliente</th>
                                            <th class="hidden-480">CNPJ/CPF</th>
                                            <th class="hidden-480">For. Pag.</th>
                                            <th class="hidden-480">Vezes</th>
                                            <th class="hidden-480">Transportador</th>
                                            <th class="hidden-480 center">Liberadas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = $stmt_pedido->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                            <tr>
                                                <th><?php echo $row['pedido_id'] ?></th>
                                                <th class="hidden-480"><?php echo date("d/m/Y = H:i:s", strtotime($row['pedido_data'])); ?></th>                                           
                                                <th class="hidden-480"><?php echo $row['cliente_nome']; ?></th>
                                                <th class="hidden-480"><?php echo $row['cliente_cpf_cnpj']; ?></th>
                                                <th class="hidden-480"><?php echo $row['forma_pagamento_nome']; ?></th>
                                                <th class="hidden-480"><?php echo $row['forma_pagamento_vezes']; ?></th>
                                                <th class="hidden-480"><?php echo $row['id_transportador']; ?></th>
                                                <th class="hidden-480 center">
                                                    <!-- CHAMADA ESTA NO FOOTER VERIFICAR LA ISSO SE PRECISAR MUDAR LINHA 60 -->
                                                    <button type="button" class="btn btn-xs btn-warning" 
                                                            data-toggle="modal" data-target="#myModal" 
                                                            data-pedido_id="<?php echo $row['pedido_id']; ?>"
                                                            data-pedido_cliente="<?php echo $row['cliente_nome']; ?>"
                                                            data-id_transportador="<?php echo $row['id_transportador']; ?>"
                                                            >Gerar</button>

                                                </th>
                                            </tr>
                                            <?php
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

A CHAMADA DO JAVASCRIP ESTA NO FOOTER VERIFCAR LA ISSO E ABAIXO MOSTRA OS DADOS NO FOOTER
-->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Pedido</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <input name="pedido_id" type="hidden" class="form-control" id="pedido_id">
                    </div>
                    <div class="form-group">
                        <label for="pedido_cliente" class="control-label">Nome</label>
                        <input name="pedido_cliente" type="text" class="form-control" id="pedido_cliente">
                    </div>
                    <div class="form-group">

                        <label for="transportador_id" class="control-label">Transportador</label>
                        <select class="form-control" name="transportador_id" id="id_transportador">
                            <option  value="0">****====****</option>
                            <?php
                            while ($row1 = $stmt_transportador->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <option value="<?php echo $row1['transportador_id'] ?>" ><?php echo $row1['transportador_nome'] . "->" . $row1['transportador_cnpj']; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <?php
                    date_default_timezone_set('America/Sao_Paulo');
                    $date = date('Y-m-d H:i:s');
                    ?>
                    <div class="form-group">
                        <label for="nota_data_emissao" class="control-label">Dt. Emissão</label>
                        <input name="nota_data_emissao" type="text" class="form-control" id="nota_data_emissao" value="<?php echo date("d/m/Y", strtotime($date)); ?>" >
                    </div>
                    <div class="form-group">
                        <label for="nota_hora_emissao" class="control-label">Hr. Emissão</label>
                        <input name="nota_hora_emissao" type="text" class="form-control" id="nota_hora_emissao" value="<?php echo date("H:i:s", strtotime($date)); ?>">
                    </div>
                    <div class="form-group">
                        <label for="nota_data_saida" class="control-label">Dt. Saída</label>
                        <input name="nota_data_saida" type="text" class="form-control" id="nota_data_saida" value="<?php echo date("d/m/Y", strtotime($date)); ?>">
                    </div>
                    <div class="form-group">
                        <label for="nota_hora_saida" class="control-label">Hr. Saída</label>
                        <input name="nota_hora_saida" type="text" class="form-control" id="nota_data_saida" value="<?php echo date("H:i:s", strtotime($date)); ?>">
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-emite" class="btn btn-xs btn-success">Emitir NF-e</button>
                    </div>
                </form>
            </div>			  
        </div>
    </div>
</div>



<?php
require_once '../pagina/footer.php';
?>