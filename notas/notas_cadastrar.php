<?php
require_once 'notas_config.php';
require_once '../pagina/menu.php';


$stmt3 = $auth_user->runQuery("SELECT * FROM forma_pagamento WHERE forma_pagamento_status = 1 ORDER BY forma_pagamento_id DESC");
$stmt3->execute();
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
                                                Nova NF-e
                                            </h4>
                                        </div>

                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label>Nome</label>

                                                                    <input type="text" name="cliente_nome" id="cliente_nome" class="form-control" placeholder="Nome do Cliente" autocomplete="off" required=""/>                                 
                                                                    <div id="listanome"></div> 


                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>Status</label>
                                                                    <select id="nota_status" name="nota_status" class="form-control">
                                                                        <option value="1" disabled="">PENDENTE</option>
                                                                        <option value="3" selected="">LIBERADO</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>Dt Emi</label>
                                                                    <input type="text" name="nota_data_emissao" id="nota_data_emissao" class="form-control input-mask-data" placeholder="dd/mm/yyyy"  />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Ind. Presencial</label>
                                                                    <select id="nota_indicador_presencial" name="nota_indicador_presencial" class="form-control">
                                                                        <option value="0">0 - Não se Aplica</option>
                                                                        <option value="1">1 - Operação Presencial</option>
                                                                        <option value="2">2 - Operação não presencial, pela Internet</option>
                                                                        <option value="3">3 - Operação não presencial, Teleatendimento</option>
                                                                        <option value="4" disabled="">4 - NFC-e em operação com entrega a domicílio</option>
                                                                        <option value="9" selected="">9 - Operação não presencial, outros</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>Forma Pag.</label>
                                                                    <select id="id_forma_pagamento" name="id_forma_pagamento" class="form-control">
                                                                        <?php
                                                                        while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                                                                            ?>
                                                                            <option class="form-control" value="<?php echo $row['forma_pagamento_id']; ?>"><?php echo $row['forma_pagamento_nome']; ?></option>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <div class="form-group">
                                                                    <label>Nat. Operação</label>
                                                                    <input type="text" name="nota_natureza_operacao"  class="form-control" placeholder="Natureza da Operação"  required=""/>                                 
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Frete</label>
                                                                    <select id="nota_frete" name="nota_frete" class="form-control">
                                                                        <option value="0">0 - Por Conta Emitente</option>
                                                                        <option value="1">1 - Por conta do destinatário/remetente</option>
                                                                        <option value="2">2 - Por conta de terceiros</option>
                                                                        <option value="9" selected="">9 - Sem Frete</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>Tipo</label>
                                                                    <select id="nota_tipo" name="nota_tipo" class="form-control">
                                                                        <option value="0">0 - ENTRADA</option>
                                                                        <option value="1" selected="">1 - SAIDA</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Tipo Operação</label>
                                                                    <select id="nota_tipo_operacao" name="nota_tipo_operacao" class="form-control">
                                                                        <option value="1">1- Operação Interna</option>
                                                                        <option value="2" selected="">2 - Operação Interestadual</option>
                                                                        <option value="3">3 - Operação com Exterior</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Finalidade</label>
                                                                    <select id="nota_finalidade" name="nota_finalidade" class="form-control">
                                                                        <option value="1"  selected="">1=NF-e normal</option>
                                                                        <option value="2">2=NF-e complementar</option>
                                                                        <option value="3">3=NF-e de ajuste</option>
                                                                        <option value="4">4=Devolução/Retorno</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Ind. Finalidade</label>
                                                                    <select id="nota_indicador_finalidade" name="nota_indicador_finalidade" class="form-control">
                                                                        <option value="0">0-Normal</option>
                                                                        <option value="1" selected="">1-Consumidor Final</option>
                                                                    </select>
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
                        <div class="clearfix form-actions">
                            <div class="col-md-offset-10 col-md-9">
                                <button type="submit" name="btn-cadastro" class="btn btn-success btn-xs">
                                    Cadastrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#cliente_nome').keyup(function () {
            var query = $(this).val();
            if (query != '')
            {
                $.ajax({
                    url: "notas_config.php",
                    method: "POST",
                    data: {query: query},
                    success: function (data)
                    {
                        $('#listanome').fadeIn();
                        $('#listanome').html(data);
                    }
                });
            }
        });
        $(document).on('click', 'li', function () {

            $('#cliente_nome').val($(this).text());
            $('#listanome').fadeOut();
        });
    });
</script> 

<?php
require_once '../pagina/footer.php';
?>