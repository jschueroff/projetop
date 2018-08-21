<?php
require_once 'pedido_config.php';
require_once '../pagina/menu.php';


$stmt3 = $auth_user->runQuery("SELECT * FROM forma_pagamento WHERE forma_pagamento_status = 1 ORDER BY forma_pagamento_id DESC");
$stmt3->execute();

$stmt_trans = $auth_user->runQuery("SELECT * FROM transportador WHERE transportador_status = 1");
$stmt_trans->execute();

date_default_timezone_set('America/Sao_Paulo');
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
                <li class="active">Cadastro Pedido</li>
            </ul><!-- /.breadcrumb -->
        </div>

        <div class="page-content">
            <?php
            require_once '../principal/principal_config.php';
            ?>


            <div class="row">
                <div class="col-xs-12">
                    <form  method="post"> 
                        <fieldset>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="widget-box">
                                        <div class="widget-header widget-header-flat">
                                            <h4 class="widget-title smaller">
                                                Dados do Pedido
                                            </h4>
                                        </div>

                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class='row'>
                                                            <div class='col-sm-9'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">Nome</label>
                                                                    <input type="text" name="cliente_nome" id="cliente_nome" class="form-control" placeholder="Nome/Fantasia/CNPJ/CPF" autocomplete="off" required=""/>                                 
                                                                    <div id="lista_nome"></div> 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-3'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">Status</label>
                                                                    <select id="pedido_status" name="pedido_status" class="form-control">
                                                                        <option value="1">PENDENTE</option>
                                                                        <option value="2">CONFERIDO</option>
                                                                        <option value="3">LIBERADO</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class='row'>

                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">Data</label>
                                                                    <input type="text" name="pedido_data" id="pedido_data" class="form-control" disabled="" value="<?php echo date("d/m/Y"); ?>"  />
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">P. Entre</label>
                                                                    <input type="text" name="pedido_data_entrega" id="pedido_data_entrega" class="form-control input-mask-data" placeholder="dd/mm/yyyy"  />
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">For. Pag.</label>
                                                                    <select id="pedido_status" name="id_forma_pagamento" class="form-control">
                                                                        <?php
                                                                        while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                                                                            ?>
                                                                            <option value="<?php echo $row['forma_pagamento_id']; ?>"><?php echo $row['forma_pagamento_nome'] . " ==> " . $row['forma_pagamento_vezes'] . "X" ?></option>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">Tipo Frete</label>
                                                                    <select id="pedido_frete" name="pedido_frete" class="form-control">
                                                                        <option value="0">0 - Por Conta Emitente</option>
                                                                        <option value="1">1 - Por conta do destinatário/remetente</option>
                                                                        <option value="2">2 - Por conta de terceiros</option>
                                                                        <option value="9" selected="">9 - Sem Frete</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-4'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">Tipo de Operação</label>
                                                                    <select id="pedido_presencial" name="pedido_presencial" class="form-control">
                                                                        <option value="0">0 - Não se Aplica</option>
                                                                        <option value="1">1 - Operação Presencial</option>
                                                                        <option value="2">2 - Operação não presencial, pela Internet</option>
                                                                        <option value="3">3 - Operação não presencial, Teleatendimento</option>
                                                                        <option value="4" disabled="">4 - NFC-e em operação com entrega a domicílio</option>
                                                                        <option value="9" selected="">9 - Operação não presencial, outros</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class='row'>
                                                        </div>
                                                        <div class='row'>
                                                            <div class='col-sm-3'>    
                                                                <div class='form-group'>
                                                                    <label for="user_title">Tipo</label>
                                                                    <select id="pedido_tipo" name="pedido_tipo" class="form-control">
                                                                        <option value="5" disabled="">Orçamento</option>
                                                                        <option value="1" selected="">Normal</option>
                                                                        <option value="4">Devolução</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-9">
                                                                <div class='form-group'>
                                                                    <label for="user_title">Observação</label>
                                                                    <input type="text" name="pedido_observacao" id="pedido_observacao" class="form-control" placeholder="Observação do Pedido"  />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                
                            </div>
                        </fieldset>
                        <div class="clearfix form-actions">
                            <div class="col-md-offset-10 col-md-10">
                                <button type="submit" name="btn-cadastro_p" class="btn btn-xs btn-success">
                                    Cadastrar
                                </button>
                            </div>
                        </div>
                    </form>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->

<script>
    $(document).ready(function () {
        $('#cliente_nome').keyup(function () {
            var query = $(this).val();
            if (query != '')
            {
                $.ajax({
                    url: "pedido_config.php",
                    method: "POST",
                    data: {query: query},
                    success: function (data)
                    {
                        $('#lista_nome').fadeIn();
                        $('#lista_nome').html(data);
                    }
                });
            }
        });
        $(document).on('click', 'li', function () {

            $('#cliente_nome').val($(this).text());
            $('#lista_nome').fadeOut();
        });
    });
</script> 

<?php
require_once '../pagina/footer.php';
?>