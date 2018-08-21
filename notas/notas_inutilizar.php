<?php
require_once 'notas_config.php';
require_once '../pagina/menu.php';

/*
  $stmt_pedido = $auth_user->runQuery("SELECT * FROM pedido, forma_pagamento, cliente WHERE pedido.pedido_status = 3 AND forma_pagamento.forma_pagamento_id = pedido.id_forma_pagamento AND
  cliente.cliente_id = pedido.id_cliente ORDER BY pedido.pedido_id ASC");

  $stmt_pedido->execute();

  $stmt_notas_emitidas = $auth_user->runQuery("SELECT * FROM nota ORDER BY nota_numero_nf DESC");
  $stmt_notas_emitidas->execute();
 * *
 */
$stmt_notas_inu = $auth_user->runQuery("SELECT * FROM nota_inu ORDER BY nota_inu_id DESC");
$stmt_notas_inu->execute();
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
                <li class="active">Inutilizar NF-e</li>
            </ul><!-- /.breadcrumb -->


        </div>

        <div class="page-content">
            <?php
            require_once('../principal/principal_config.php');
            ?>
            <div class="row">
                <div class="col-xs-12">

                    <form class="form-horizontal" method="post">

                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Série</label>
                            <div class="col-sm-9">
                                <input type="text" name="nSerie" class="form-control" value="1" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Inicio</label>
                            <div class="col-sm-9">
                                <input type="text" name="nIni" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Final</label>
                            <div class="col-sm-9">
                                <input type="text" name="nFin" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Justificativa</label>
                            <div class="col-sm-9">
                                <input type="text" name="xJust" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Ambiente</label>
                            <div class="col-sm-9">
                                <input type="text" name="tpAmb" class="form-control"  value="2"/>
                            </div>
                        </div>
                        <div class="clearfix form-actions">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" name="btn-inutilizar" class="btn btn-info btn-xs">
                                    Inutilizar
                                </button>
                            </div>
                        </div>
                    </form>
                </div><!-- /.row -->
            </div><!-- /.page-content -->

            <div class="row">
                <div class="col-xs-12">
                    <table id="simple-table" class="table table-striped table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th class="hidden-480">Status</th> 
                                <th class="hidden-480">Motivo</th> 
                                <th class="hidden-480">Inicio</th>
                                <th class="hidden-480">Final</th>
                                <th class="hidden-480 center">Descrição</th>
                            </tr>
                        </thead>
                        <tbody class="reponsive">
                            <?php
                            while ($row = $stmt_notas_inu->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <tr>
                                    <th><?php echo $row['nota_inu_id'] ?></th>
                                     <th class="hidden-480"><?php echo $row['nota_inu_cStat'] ?></th> 
                                     <th class="hidden-480"><?php echo $row['nota_inu_xMotivo'] ?></th> 
                                     <th class="hidden-480"><?php echo $row['nota_inu_nNFIni'] ?></th> 
                                     <th class="hidden-480"><?php echo $row['nota_inu_nNFFin'] ?></th> 
                                     <th class="hidden-480"><?php echo $row['nota_inu_descricao'] ?></th> 
                                </tr>
                                <?php
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- /.main-content -->
</div>



<?php
require_once '../pagina/footer.php';
?>