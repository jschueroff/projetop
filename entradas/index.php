<?php
require_once 'entradas_config.php';
require_once '../pagina/menu.php';

$stmt_dados_entrada = $auth_user->runQuery("SELECT * FROM entrada ORDER BY entrada_id DESC");
$stmt_dados_entrada->execute();
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
                                                            <div class='col-sm-4'>    
                                                                <div class='form-group'>
                                                                    <input type="text" id="forma_pagamento_id" name="forma_pagamento_pesquisa" class="form-control" placeholder="Forma Pagamento"/>
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
                                                                <a href="forma_pagamento_cadastrar.php">
                                                                    <button class="btn btn-sm btn-success" name="btn-cadastrar" type="submit">
                                                                        <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                                                        Novo
                                                                    </button>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-group">
                                                                <a href="forma_pagamento_relatorio.php">
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
                                            <th class="hidden-480">ID</th>
                                            <th >Nome</th>
                                            <th class="hidden-480">N°</th>
                                            <th class="hidden-480">Dt. Emi</th>
                                            <th class="hidden-480">UF</th>
                                            <th class="hidden-480">Status</th>
                                            <th class="hidden-480">Config.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = $stmt_dados_entrada->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                        <form method="post" id="login-form">
                                            <tr>
                                                <td class="hidden-480"><?php echo $row['entrada_id']; ?></td>
                                                <td ><?php echo $row['entrada_xNome_emit']; ?></td>
                                                <td class="hidden-480"><?php echo $row['entrada_numero']; ?></td>
                                                <td class="hidden-480"><?php echo date("d/m/Y", strtotime($row['entrada_dhEmi'])); ?></td>
                                                <td class="hidden-480"><?php echo $row['entrada_UF_emit']; ?></td>
                                                <td class="hidden-480"><?php if($row['entrada_status'] == 2){ 
                                                    echo "P";
                                                }
                                                if($row['entrada_status'] == 3){ 
                                                    echo "L";
                                                }
?>
                                                </td>
                                                <td class="hidden-480">
                                                    <div class="form-group">
                                                                    <button class="btn btn-warning btn-xs" name="btn-vincular" type="submit">
                                                                        <i class="ace-icon fa glyphicon-pencil bigger-80 blue"></i>
                                                                        <input type="hidden" name="entrada_chave" value="<?php echo $row['entrada_chave']; ?>">
                                                                        Editar
                                                                    </button>
                                                                </div>
                                                </td>
<!--                                                <td class="hidden-480" align="center">
                                                    <div class="form-group">
                                                        <button type="button" class="btn btn-xs btn-warning" 
                                                                data-toggle="modal" data-target="#liberaproduto" 
                                                                data-entrada_id="<?php echo $row['entrada_id']; ?>"
                                                                data-entrada_xnome_emit="<?php echo $row['entrada_xNome_emit']; ?>"  
                                                                >Editar

                                                        </button>
                                                    </div>
                                                </td>-->
                                            </tr>
                                        </form>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div><!-- /.span -->
                        </div><!-- /.row -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.page-content -->
        </div>
    </div>
</div><!-- /.main-content -->


<!--ALTERA DADOS DO ITENS DO PEDIDO-->
<div class="modal fade" id="liberaproduto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            </div>

            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-xs-12">
                            <legend>Dados da Entrada</legend>
                            <div class='row'>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">ID Entrada:</label>
                                        <input name="entrada_id" type="text" class="form-control" id="entrada_id2" disabled>
                                        <input name="entrada_id" type="hidden" class="form-control" id="entrada_id">
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Nome:</label>
                                        <input name="entrada_xnome_emit" type="text" class="form-control" disabled id="entrada_xnome_emit">
                                        <input name="entrada_xnome_emit" type="hidden" class="form-control" id="entrada_xnome_emit">
                                    </div>
                                </div>


                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Cancelar</button>
                                <button type="submit" name="btn-altera-tesitens" class="btn btn-xs btn-warning">Alterar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>



            <!--            <div class="modal-body">
                            <form method="POST" enctype="multipart/form-data">
                                <legend>Dados da Entrada</legend>
            
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">ID Entrada:</label>
                                            <input name="entrada_id" type="text" class="form-control" id="entrada_id2" disabled>
                                            <input name="entrada_id" type="hidden" class="form-control" id="entrada_id">
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">Nome:</label>
                                            <input name="entrada_xnome_emit" type="text" class="form-control" disabled id="entrada_xnome_emit">
                                            <input name="entrada_xnome_emit" type="hidden" class="form-control" id="entrada_xnome_emit">
                                        </div>
                                    </div>
                                    
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" name="btn-sucess" class="btn btn-xs btn-success">Vincular</button>
                                </div>
                            </form>
                        </div>
            
                    </div>-->
        </div>
    </div>

    <?php
    require_once '../pagina/footer.php';
    ?>