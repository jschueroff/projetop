<?php
require_once 'fornecedor_config.php';
require_once '../pagina/menu.php';


$fornecedor_id = $_GET['id_fornecedor'];

$busca_prod_for = $auth_user->runQuery("SELECT * FROM produto_fornecedor, fornecedor"
        . " WHERE id_fornecedor = fornecedor_id AND fornecedor_id = ?;");
$busca_prod_for->bindParam(1, $fornecedor_id, PDO::PARAM_STR);
$busca_prod_for->execute();
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
                <li class="active">Prod. Fornecedor</li>
            </ul><!-- /.breadcrumb -->
        </div>
        <div class="page-content">
            <?php
            require '../principal/principal_config.php';
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
                                                                    <input type="text" id="ncm_id" name="fornecedor_pesquisa" class="form-control" placeholder="Fornecedor"/>
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
                                                                <a href="fornecedor_cadastrar.php">
                                                                    <button class="btn btn-sm btn-success" name="btn-cadastrar" type="submit">
                                                                        <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                                                        Novo
                                                                    </button>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-group">
                                                                <a href="fornecedor_relatorio.php">
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
                                                        <th class="hidden-480">Produto</th>
                                                        <th class="hidden-480">Cod. For.</th>
                                                        <th class="hidden-480">Cod. Barras</th>
                                                        <th class="hidden-480">UN. For.</th>
                                                        <th class="hidden-480">Des. For.</th>
                                                        <th class="hidden-480">UN. Con.</th>
                                                        <th class="hidden-480">Fator Con.</th>
                                                        <th class="hidden-480 center" colspan="3" >Configurar</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php
                                                    while ($bus_for_prod = $busca_prod_for->fetch(PDO::FETCH_ASSOC)) {
                                                        ?>
                                                    <form method="post" id="login-form">
                                                        <tr>
                                                            <td><?php echo $bus_for_prod['produto_fornecedor_id']; ?></td>
                                                            <td class="hidden-480"><?php echo $bus_for_prod['id_produto']; ?></td>
                                                            <td class="hidden-480"><?php echo $bus_for_prod['produto_fornecedor_cod_fornecedor']; ?></td>
                                                            <td class="hidden-480"><?php echo $bus_for_prod['produto_fornecedor_cod_barras']; ?></td>
                                                            <td class="hidden-480"><?php echo $bus_for_prod['produto_fornecedor_un_fornecedor']; ?></td>
                                                            <td class="hidden-480"><?php echo $bus_for_prod['produto_fornecedor_des_fornecedor']; ?></td>
                                                            <td class="hidden-480"><?php echo $bus_for_prod['produto_fornecedor_un_conversao']; ?></td>
                                                            <td class="hidden-480"><?php echo $bus_for_prod['produto_fornecedor_fator_conversao']; ?></td>
                                                            <td class="hidden-480" align="center">
                                                                <div class="form-group">
                                                                    <button class="btn btn-warning btn-xs" name="btn-editar" type="submit">
                                                                        <i class="ace-icon fa glyphicon-pencil bigger-80 blue"></i>
                                                                        <input type="hidden" name="fornecedor_id" value="<?php echo $row['fornecedor_id']; ?>">
                                                                        Editar
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </form>
    <?php
}
?>
                                                </tbody>
                                            </table>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </div><!-- /.main-content -->

<?php
require_once '../pagina/footer.php';
?>