<?php
require_once 'entradas_config.php';
require_once '../pagina/menu.php';

$chave = $_GET['chave'];

$busca_prod_nf = $auth_user->runQuery("SELECT * FROM entrada_produto , fornecedor WHERE"
        . " entrada_produto_cnpj = fornecedor_cnpj AND"
        . " entrada_produto_chave =:entrada_produto_chave");
$busca_prod_nf->execute(array(":entrada_produto_chave" => $chave));

$contador = $auth_user->runQuery("SELECT count(*) FROM entrada_produto WHERE"
        . " entrada_produto_chave = :entrada_produto_chave"
        . " AND id_produto = 0");
$contador->execute(array(":entrada_produto_chave" => $chave));
$res_cont = $contador->fetch(PDO::FETCH_ASSOC);
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
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-xs-12">
                                <legend>Dados da Entrada</legend>
                                <?php
                                while ($lista_nf = $busca_prod_nf->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                <input type="hidden" name="chave" value="<?php echo $lista_nf['entrada_produto_chave']; ?>">
                                <input type="hidden" name="id_fornecedor" class="form-control" value="<?php echo $lista_nf['fornecedor_id']; ?>">
                                    <div class='row'>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label for="recipient-name" class="control-label">ID</label>
                                                <input type="text" disabled="" name="entrada_produto_id" class="form-control" value="<?php echo $lista_nf['entrada_produto_id']; ?>">
                                            </div>
                                        </div>
                                        
                                               
                                        
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label for="recipient-name" class="control-label">C.F.</label>
                                                <input type="text" disabled="" name="entrada_produto_id" class="form-control" value="<?php echo $lista_nf['entrada_produto_cProd']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="recipient-name" class="control-label">Prod. NF-e</label>
                                                <input type="text" class="form-control" value="<?php echo $lista_nf['entrada_produto_xProd']; ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label for="recipient-name" class="control-label">ID</label>
                                                <input type="text" class="form-control" value="<?php echo $lista_nf['id_produto']; ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="recipient-name" class="control-label">ID</label>
                                                <input type="text" class="form-control" value="<?php echo $lista_nf['produto_nome']; ?>" disabled>
                                            </div>
                                        </div>

                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label for="recipient-name" class="control-label">Vinc.</label>
                                                <?php
                                                if ($lista_nf['id_produto'] > 0) {
                                                    ?>
<!--                                                INFORMAÇÕES DOS DADOS PARA VINCULAR NA TABELA PRODUTOS DO FORNECEDOR-->
                                                    <button type="button" class="btn btn-xs btn-default" 
                                                            data-toggle="modal" data-target="#vincular" 
                                                            data-entrada_produto_id="<?php echo $lista_nf['entrada_produto_id']; ?>"
                                                            data-fornecedor_id="<?php echo $lista_nf['fornecedor_id']; ?>"
                                                            data-entrada_produto_cprod="<?php echo $lista_nf['entrada_produto_cProd']; ?>"
                                                            data-entrada_produto_ean="<?php echo $lista_nf['entrada_produto_EAN']; ?>"
                                                            data-entrada_produto_xprod="<?php echo $lista_nf['entrada_produto_xProd']; ?>"
                                                            data-entrada_produto_ucom="<?php echo $lista_nf['entrada_produto_uCom']; ?>"
                                                            >
                                                        Editar
                                                    </button>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <button type="button" class="btn btn-xs btn-warning" 
                                                            data-toggle="modal" data-target="#vincular" 
                                                            data-entrada_produto_id="<?php echo $lista_nf['entrada_produto_id']; ?>"
                                                            data-fornecedor_id="<?php echo $lista_nf['fornecedor_id']; ?>"
                                                            data-entrada_produto_cprod="<?php echo $lista_nf['entrada_produto_cProd']; ?>"
                                                            data-entrada_produto_ean="<?php echo $lista_nf['entrada_produto_EAN']; ?>"
                                                            data-entrada_produto_xprod="<?php echo $lista_nf['entrada_produto_xProd']; ?>"
                                                            data-entrada_produto_ucom="<?php echo $lista_nf['entrada_produto_uCom']; ?>"
                                                            >
                                                        Vinc.
                                                    </button>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                 
                                <div class="modal-footer">
                                    <button type="submit" name="btn-vincular-dados" class="btn btn-xs btn-success" <?php
                                    if ($res_cont['count(*)'] != 0) {
                                        ?>
                                                disabled="" 
                                                <?php
                                            }
                                            ?>    
                                     >Cadastrar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div><!-- /.row -->
            </div><!-- /.page-content -->
        </div>
    </div>
</div><!-- /.main-content -->

<div class="modal fade" id="vincular" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <legend>Dados Produtos/Serviços</legend>
                    <div class="row">
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="recipient-name" class="control-label">ID.</label>
                                <input  type="text" disabled="" class="form-control" id="entrada_produto_id2">
                                <input name="entrada_produto_id" type="hidden"  class="form-control" id="entrada_produto_id">
                                <input name="id_fornecedor" type="hidden"  class="form-control" id="id_fornecedor">
                                <input name="entrada_produto_cprod" type="hidden"  class="form-control" id="entrada_produto_cprod">
                                <input name="entrada_produto_ean" type="hidden"  class="form-control" id="entrada_produto_ean">
                                <input name="entrada_produto_xprod" type="hidden"  class="form-control" id="entrada_produto_xprod">
                                <input name="entrada_produto_ucom" type="hidden"  class="form-control" id="entrada_produto_ucom">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class='form-group'>
                                <label for="user_title">Produto/Servico</label>
                                <input type="text" name="id_produto" id="produto_nome" class="form-control" placeholder="Produto/Servico" autocomplete="off"/>                                 
                                <div id="lista_produto"></div> 
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-vincular-produto" class="btn btn-xs btn-warning">Alterar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>




<script>
    $(document).ready(function () {
        $('#produto_nome').keyup(function () {
            var query = $(this).val();
            if (query != '')
            {
                $.ajax({
                    url: "entradas_config.php",
                    method: "POST",
                    data: {query: query},
                    success: function (data)
                    {
                        $('#lista_produto').fadeIn();
                        $('#lista_produto').html(data);
                    }
                });
            }
        });
        $(document).on('click', 'li', function () {
            $('#produto_nome').val($(this).text());
            $('#lista_produto').fadeOut();
        });
    });
</script> 

<?php
require_once '../pagina/footer.php';
?>