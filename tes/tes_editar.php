<?php
require_once 'tes_config.php';
require_once '../pagina/menu.php';

$id = $_GET['id'];
$stmt2 = $auth_user->runQuery("SELECT * FROM st WHERE  st_id =:id");
$stmt2->execute(array(":id" => $id));
$lista = $stmt2->fetch(PDO::FETCH_ASSOC);

$stmt = $auth_user->runQuery("SELECT * FROM icms ORDER BY icms_id ASC");
$stmt->execute();

$stmt_estado = $auth_user->runQuery("SELECT * FROM estado");
$stmt_estado->execute();

$stmt_icms = $auth_user->runQuery("SELECT * FROM icms");
$stmt_icms->execute();

//BUSCAR O CRT DA EMPRESA PARA AJUSTAR O EDITAR DO ICMS DA EMPRESA

$stmt_e = $auth_user->runQuery("SELECT * FROM empresa WHERE empresa_id = 1");
$stmt_e->execute();

//BUSCAR O CRT DA EMPRESA PARA CADASTRAR UM NOVO ICMS NA EMPRESA
$stmt_e1 = $auth_user->runQuery("SELECT * FROM empresa WHERE empresa_id = 1");
$stmt_e1->execute();

// AQUI COMECAO
$stmt_te = $auth_user->runQuery("SELECT * FROM tes WHERE  tes_id =:id");
$stmt_te->execute(array(":id" => $id));
$lista_tes = $stmt_te->fetch(PDO::FETCH_ASSOC);

$stmt_tes_itens = $auth_user->runQuery("SELECT * FROM tes_itens WHERE id_tes =:id");
$stmt_tes_itens->execute(array(":id" => $id));

$stmt_tes_itens = $auth_user->runQuery("SELECT * FROM tes, tes_itens WHERE tes_id = id_tes AND id_tes =:id");
$stmt_tes_itens->execute(array(":id" => $id));
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
                <li class="active">Cadastro</li>
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
                                <div class="col-sm-6">
                                    <div class="widget-box">
                                        <div class="widget-header widget-header-flat">
                                            <h4 class="widget-title smaller">
                                                Dados do Tipo E/S
                                            </h4>
                                        </div>

                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class='row'>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>ID</label>
                                                                    <input type="text" id="tes_id" disabled="" value="<?php echo $lista_tes['tes_id']; ?>"  name="tes_id" class="form-control" />
                                                                    <input type="hidden" id="tes_id"  value="<?php echo $lista_tes['tes_id']; ?>"  name="tes_id" class="form-control" />
                                                                </div>  
                                                            </div>
                                                            <div class="col-md-10">
                                                                <div class="form-group">
                                                                    <label class="control-label">Descrição</label>
                                                                    <input type="text" id="tes_descricao" required="" value="<?php echo $lista_tes['tes_descricao']; ?>"  name="tes_descricao" class="form-control" />
                                                                </div> 
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Status</label>
                                                                    <select class="form-control" name="tes_status">
                                                                        <option value="0" <?= ($lista_tes['tes_status'] == '0') ? 'selected' : '' ?>>0 - NÃO</option>
                                                                        <option value="1" <?= ($lista_tes['tes_status'] == '1') ? 'selected' : '' ?>>1 - SIM</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Tipo</label>
                                                                    <select class="form-control" name="tes_tipo">
                                                                        <option value="0" <?= ($lista_tes['tes_tipo'] == '0') ? 'selected' : '' ?>>0 - Entrada</option>
                                                                        <option value="1" <?= ($lista_tes['tes_tipo'] == '1') ? 'selected' : '' ?>>1 - Saida</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Natureza</label>
                                                                    <select class="form-control" name="tes_natureza">
                                                                        <option value="0" <?= ($lista_tes['tes_natureza'] == '0') ? 'selected' : '' ?>>0 - Normal</option>
                                                                        <option value="1" <?= ($lista_tes['tes_natureza'] == '1') ? 'selected' : '' ?>>1 - Devolução</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <!--                                                            <div class='col-sm-2'>   
                                                                                                                            <div class="form-group">
                                                                                                                                <label for="recipient-name" class="control-label">CFOP</label>
                                                                                                                                <input name="tes_cfop" type="text" class="form-control" id="tes_cfop" value="<?php echo $lista_tes['tes_cfop'] ?>">
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                        <div class="col-sm-2">
                                                                                                                            <div class="form-group">
                                                                                                                                <label class="control-label">Consumidor Final</label>
                                                                                                                                <select class="form-control" name="tes_consumidor_final">
                                                                                                                                    <option value="0" <?= ($lista_tes['tes_consumidor_final'] == '0') ? 'selected' : '' ?>>0 - NÃO</option>
                                                                                                                                    <option value="1" <?= ($lista_tes['tes_consumidor_final'] == '1') ? 'selected' : '' ?>>1 - SIM</option>
                                                                                                                                </select>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                        <div class="col-sm-2">
                                                                                                                            <div class="form-group">
                                                                                                                                <label class="control-label">Cálcula ICMS</label>
                                                                                                                                <select class="form-control" name="tes_icms">
                                                                                                                                    <option value="0" <?= ($lista_tes['tes_icms'] == '0') ? 'selected' : '' ?>>0 - NÃO</option>
                                                                                                                                    <option value="1" <?= ($lista_tes['tes_icms'] == '1') ? 'selected' : '' ?>>1 - SIM</option>
                                                                                                                                </select>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                        <div class="col-sm-2">
                                                                                                                            <div class="form-group">
                                                                                                                                <label class="control-label">Cálcula IPI</label>
                                                                                                                                <select class="form-control" name="tes_ipi">
                                                                                                                                    <option value="0" <?= ($lista_tes['tes_ipi'] == '0') ? 'selected' : '' ?>>0 - NÃO</option>
                                                                                                                                    <option value="1" <?= ($lista_tes['tes_ipi'] == '1') ? 'selected' : '' ?>>1 - SIM</option>
                                                                                                                                </select>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                        <div class="col-sm-2">
                                                                                                                            <div class="form-group">
                                                                                                                                <label class="control-label">Cálcula PIS/CONFIS</label>
                                                                                                                                <select class="form-control" name="tes_pis_confis">
                                                                                                                                    <option value="0" <?= ($lista_tes['tes_pis_confis'] == '0') ? 'selected' : '' ?>>0 - NÃO</option>
                                                                                                                                    <option value="1" <?= ($lista_tes['tes_pis_confis'] == '1') ? 'selected' : '' ?>>1 - SIM</option>
                                                                                                                                </select>
                                                                                                                            </div>
                                                                                                                        </div>-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="widget-box">
                                        <div class="widget-header widget-header-flat">
                                            <h4 class="widget-title smaller">
                                                IMPOSTOS
                                            </h4>
                                        </div>

                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class='row'>
                                                            <div class='col-sm-4'>   
                                                                <div class="form-group">
                                                                    <label for="recipient-name" class="control-label">CFOP</label>
                                                                    <input name="tes_cfop" type="text" class="form-control" id="tes_cfop" value="<?php echo $lista_tes['tes_cfop'] ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">C.F.</label>
                                                                    <select class="form-control" name="tes_consumidor_final">
                                                                        <option value="0" <?= ($lista_tes['tes_consumidor_final'] == '0') ? 'selected' : '' ?>>0 - NÃO</option>
                                                                        <option value="1" <?= ($lista_tes['tes_consumidor_final'] == '1') ? 'selected' : '' ?>>1 - SIM</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">ICMS</label>
                                                                    <select class="form-control" name="tes_icms">
                                                                        <option value="0" <?= ($lista_tes['tes_icms'] == '0') ? 'selected' : '' ?>>0 - NÃO</option>
                                                                        <option value="1" <?= ($lista_tes['tes_icms'] == '1') ? 'selected' : '' ?>>1 - SIM</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">IPI</label>
                                                                    <select class="form-control" name="tes_ipi">
                                                                        <option value="0" <?= ($lista_tes['tes_ipi'] == '0') ? 'selected' : '' ?>>0 - NÃO</option>
                                                                        <option value="1" <?= ($lista_tes['tes_ipi'] == '1') ? 'selected' : '' ?>>1 - SIM</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">PIS/CONFIS</label>
                                                                    <select class="form-control" name="tes_pis_confis">
                                                                        <option value="0" <?= ($lista_tes['tes_pis_confis'] == '0') ? 'selected' : '' ?>>0 - NÃO</option>
                                                                        <option value="1" <?= ($lista_tes['tes_pis_confis'] == '1') ? 'selected' : '' ?>>1 - SIM</option>
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
                            <div class="col-md-offset-10 col-md-10">
                                <button type="submit" name="btn-salvar" class="btn btn-warning btn-sm">
                                    Alterar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <form  method="post"> 
                        <fieldset>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="widget-box">
                                        <div class="widget-header widget-header-flat">
                                            <h4 class="widget-title smaller">
                                                INFORMAÇÕES DO TIPO E/S
                                            </h4>
                                        </div>

                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="row">

                                                    <div class="tabbable tabs-left">
                                                        <ul class="nav nav-tabs" id="myTab3">
                                                            <li class="active">
                                                                <a data-toggle="tab" href="#tes_itens">
                                                                    Config.
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a data-toggle="tab" href="#teste">
                                                                    #
                                                                </a>
                                                            </li>

                                                        </ul>
                                                        <div class="tab-content">
                                                            <div id="tes_itens" class="tab-pane in active">
                                                                <p>


                                                                <div class="form-group">
                                                                    <label class="col-sm-10 control-label no-padding-right" for="form-field-tags"></label>
                                                                    <button type="button" class="btn btn-xs btn-success col-xs-1" 
                                                                            data-toggle="modal" data-target="#novotesitens" 
                                                                            >Novo</button>
                                                                </div>
                                                                <table id="simple-table" class="table table-striped table-bordered table-hover responsive">
                                                                    <thead>
                                                                        <tr>

                                                                            <th>ID</th>
                                                                            <th class="hidden-480">CFOP</th>
                                                                            <th class="hidden-480">Origem</th>
                                                                            <th class="hidden-480">Contribuinte</th>
                                                                            <th class="hidden-480">Tipo Produto</th>
                                                                            <th class="hidden-480">CST ICMS</th>
                                                                            <th class="hidden-480 center" colspan="2" >Configurar</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        while ($row_lis = $stmt_tes_itens->fetch(PDO::FETCH_ASSOC)) {
                                                                            ?>
                                                                            <tr>

                                                                                <th><?php echo $row_lis['tes_itens_id'] ?></th>
                                                                                <th class="hidden-480"><?php echo $row_lis['tes_itens_cfop'] ?></th>
                                                                                <!--<th class="hidden-480"><?php echo $row_lis['tes_itens_origem'] ?></th>-->
    <!--                                                                                <th class="hidden-480"><?php echo $row_lis['tes_itens_contribuinte'] ?></th>-->
                                                                                <th class="hidden-480"><?php
                                                                                    if ($row_lis['tes_itens_origem'] == 1) {
                                                                                        echo 'D. Estado';  
                                                                                    }
                                                                                    if ($row_lis['tes_itens_origem'] == 2) {
                                                                                        echo 'F. Estado';  
                                                                                    }
                                                                                    if ($row_lis['tes_itens_origem'] == 3) {
                                                                                        echo 'Exterior';  
                                                                                    }
                                                                                    ?></th>
                                                                                <th class="hidden-480"><?php
                                                                                    if ($row_lis['tes_itens_contribuinte'] == 0) {
                                                                                        echo 'NAO';  
                                                                                    }
                                                                                    if ($row_lis['tes_itens_contribuinte'] == 1) {
                                                                                        echo 'SIM';  
                                                                                    }
                                                                                    ?></th>
                                                                                <th class="hidden-480"><?php
                                                                                    if ($row_lis['tes_itens_tipo_produto'] == 1) {
                                                                                        echo 'Prod. Acabado';  
                                                                                    }
                                                                                    if ($row_lis['tes_itens_tipo_produto'] == 2) {
                                                                                        echo 'Revenda';  
                                                                                    }
                                                                                    if ($row_lis['tes_itens_tipo_produto'] == 3) {
                                                                                        echo 'Outros';  
                                                                                    }
                                                                                    ?></th>



<!--                                                                                <th class="hidden-480"><?php echo $row_lis['tes_itens_tipo_produto'] ?></th>-->
                                                                                <th class="hidden-480"><?php echo $row_lis['tes_itens_cst_icms'] ?></th>
                                                                                <th class="hidden-480">

                                                                                    <button type="button" class="btn btn-minier btn-warning" 
                                                                                            data-toggle="modal" data-target="#editartesitens" 
                                                                                            data-tes_itens_id="<?php echo $row_lis['tes_itens_id']; ?>"
                                                                                            data-id_tes="<?php echo $row_lis['id_tes']; ?>"
                                                                                            data-tes_itens_cfop="<?php echo $row_lis['tes_itens_cfop']; ?>"
                                                                                            data-tes_itens_origem="<?php echo $row_lis['tes_itens_origem']; ?>"
                                                                                            data-tes_itens_contribuinte="<?php echo $row_lis['tes_itens_contribuinte']; ?>"
                                                                                            data-tes_itens_tipo_produto="<?php echo $row_lis['tes_itens_tipo_produto']; ?>"
                                                                                            data-tes_itens_cst_icms="<?php echo $row_lis['tes_itens_cst_icms']; ?>"

                                                                                            >Editar</button>

                                                                                </th>
                                                                                <th class="hidden-480">
                                                                                    <button type="button" class="btn btn-minier btn-danger" 
                                                                                            data-toggle="modal" data-target="#excluirtesitens" 
                                                                                            data-tes_itens_id="<?php echo $row_lis['tes_itens_id']; ?>"
                                                                                            data-id_tes="<?php echo $row_lis['id_tes']; ?>"
                                                                                            >Excluir</button>
                                                                                </th>

                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>


                                                                </p> 
                                                            </div>
                                                            <div id="teste" class="tab-pane">
                                                                <p>

                                                                </p>
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
                    </form>
                </div>
            </div>


        </div>
    </div>
</div>









<!--            <div class="row">
                <div class="col-xs-12">
                    <form class="form-horizontal" method="post"> 
                        <div class="row">

                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>ID</label>
                                            <input type="text" id="tes_id" required="" value="<?php echo $lista_tes['tes_id']; ?>"  name="tes_id" class="form-control" />
                                        </div>  
                                    </div> /.col 
                                </div> /.row 
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label class="control-label">Descrição</label>
                                            <input type="text" id="tes_descricao" required="" value="<?php echo $lista_tes['tes_descricao']; ?>"  name="tes_descricao" class="form-control" />
                                        </div> 
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="control-label">Status</label>
                                            <select class="form-control" name="tes_status">
                                                <option value="0" <?= ($lista_tes['tes_status'] == '0') ? 'selected' : '' ?>>0 - NÃO</option>
                                                <option value="1" <?= ($lista_tes['tes_status'] == '1') ? 'selected' : '' ?>>1 - SIM</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="control-label">Tipo</label>
                                            <select class="form-control" name="tes_tipo">
                                                <option value="0" <?= ($lista_tes['tes_tipo'] == '0') ? 'selected' : '' ?>>0 - Entrada</option>
                                                <option value="1" <?= ($lista_tes['tes_tipo'] == '1') ? 'selected' : '' ?>>1 - Saida</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="control-label">Natureza</label>
                                            <select class="form-control" name="tes_natureza">
                                                <option value="0" <?= ($lista_tes['tes_natureza'] == '0') ? 'selected' : '' ?>>0 - Normal</option>
                                                <option value="1" <?= ($lista_tes['tes_natureza'] == '1') ? 'selected' : '' ?>>1 - Devolução</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class='col-sm-3'>   
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">CFOP</label>
                                            <input name="tes_cfop" type="text" class="form-control" id="tes_cfop" value="<?php echo $lista_tes['tes_cfop'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="control-label">Consumidor Final</label>
                                            <select class="form-control" name="tes_consumidor_final">
                                                <option value="0" <?= ($lista_tes['tes_consumidor_final'] == '0') ? 'selected' : '' ?>>0 - NÃO</option>
                                                <option value="1" <?= ($lista_tes['tes_consumidor_final'] == '1') ? 'selected' : '' ?>>1 - SIM</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="control-label">Cálcula ICMS</label>
                                            <select class="form-control" name="tes_icms">
                                                <option value="0" <?= ($lista_tes['tes_icms'] == '0') ? 'selected' : '' ?>>0 - NÃO</option>
                                                <option value="1" <?= ($lista_tes['tes_icms'] == '1') ? 'selected' : '' ?>>1 - SIM</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="control-label">Cálcula IPI</label>
                                            <select class="form-control" name="tes_ipi">
                                                <option value="0" <?= ($lista_tes['tes_ipi'] == '0') ? 'selected' : '' ?>>0 - NÃO</option>
                                                <option value="1" <?= ($lista_tes['tes_ipi'] == '1') ? 'selected' : '' ?>>1 - SIM</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="control-label">Cálcula PIS/CONFIS</label>
                                            <select class="form-control" name="tes_pis_confis">
                                                <option value="0" <?= ($lista_tes['tes_pis_confis'] == '0') ? 'selected' : '' ?>>0 - NÃO</option>
                                                <option value="1" <?= ($lista_tes['tes_pis_confis'] == '1') ? 'selected' : '' ?>>1 - SIM</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="control-label">Controla Estoque</label>
                                            <select class="form-control" name="tes_estoque">
                                                <option value="0" <?= ($lista_tes['tes_estoque'] == '0') ? 'selected' : '' ?>>0 - NÃO</option>
                                                <option value="1" <?= ($lista_tes['tes_estoque'] == '1') ? 'selected' : '' ?>>1 - SIM</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix form-actions">
                                    <div class=" col-md-12">
                                        <button type="submit" name="btn-salvar" class="btn btn-info btn-sm">
                                            Alterar
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="tabbable tabs-left">
                                        <ul class="nav nav-tabs" id="myTab3">
                                            <li class="active">
                                                <a data-toggle="tab" href="#tes_itens">
                                                    Config.
                                                </a>
                                            </li>
                                            <li>
                                                <a data-toggle="tab" href="#teste">
                                                    #
                                                </a>
                                            </li>

                                        </ul>
                                        <div class="tab-content">
                                            <div id="tes_itens" class="tab-pane in active">
                                                <p>


                                                <div class="form-group">
                                                    <label class="col-sm-10 control-label no-padding-right" for="form-field-tags"></label>
                                                    <button type="button" class="btn btn-xs btn-success col-xs-1" 
                                                            data-toggle="modal" data-target="#novotesitens" 
                                                            >Novo</button>
                                                </div>
                                                <table id="simple-table" class="table table-striped table-bordered table-hover responsive">
                                                    <thead>
                                                        <tr>

                                                            <th>ID</th>
                                                            <th class="hidden-480">CFOP</th>
                                                            <th class="hidden-480">Origem</th>
                                                            <th class="hidden-480">Contribuinte</th>
                                                            <th class="hidden-480">Tipo Produto</th>
                                                            <th class="hidden-480">CST ICMS</th>
                                                            <th class="hidden-480 center" colspan="2" >Configurar</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
<?php
while ($row_lis = $stmt_tes_itens->fetch(PDO::FETCH_ASSOC)) {
    ?>
                                                                                                                <tr>
                                                    
                                                                                                                    <th><?php echo $row_lis['tes_itens_id'] ?></th>
                                                                                                                    <th class="hidden-480"><?php echo $row_lis['tes_itens_cfop'] ?></th>
                                                                                                                    <th class="hidden-480"><?php echo $row_lis['tes_itens_origem'] ?></th>
                                                                                                                    <th class="hidden-480"><?php echo $row_lis['tes_itens_contribuinte'] ?></th>
                                                                                                                    <th class="hidden-480"><?php echo $row_lis['tes_itens_tipo_produto'] ?></th>
                                                                                                                    <th class="hidden-480"><?php echo $row_lis['tes_itens_cst_icms'] ?></th>
                                                                                                                    <th class="hidden-480">
                                                    
                                                                                                                        <button type="button" class="btn btn-minier btn-warning" 
                                                                                                                                data-toggle="modal" data-target="#editartesitens" 
                                                                                                                                data-tes_itens_id="<?php echo $row_lis['tes_itens_id']; ?>"
                                                                                                                                data-id_tes="<?php echo $row_lis['id_tes']; ?>"
                                                                                                                                data-tes_itens_cfop="<?php echo $row_lis['tes_itens_cfop']; ?>"
                                                                                                                                data-tes_itens_origem="<?php echo $row_lis['tes_itens_origem']; ?>"
                                                                                                                                data-tes_itens_contribuinte="<?php echo $row_lis['tes_itens_contribuinte']; ?>"
                                                                                                                                data-tes_itens_tipo_produto="<?php echo $row_lis['tes_itens_tipo_produto']; ?>"
                                                                                                                                data-tes_itens_cst_icms="<?php echo $row_lis['tes_itens_cst_icms']; ?>"
                                                    
                                                                                                                                >Editar</button>
                                                    
                                                                                                                    </th>
                                                                                                                    <th class="hidden-480">
                                                                                                                        <button type="button" class="btn btn-minier btn-danger" 
                                                                                                                                data-toggle="modal" data-target="#excluirtesitens" 
                                                                                                                                data-tes_itens_id="<?php echo $row_lis['tes_itens_id']; ?>"
                                                                                                                                data-id_tes="<?php echo $row_lis['id_tes']; ?>"
                                                                                                                                >Excluir</button>
                                                                                                                    </th>
                                                    
                                                                                                                </tr>
    <?php
}
?>
                                                    </tbody>
                                                </table>


                                                </p> 
                                            </div>
                                            <div id="teste" class="tab-pane">
                                                <p>

                                                </p>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div> /.col 

                        </div>

                    </form>
                </div>
            </div>-->
<!--                                                        </div>
                                                    </div>
                                                </div> /.main-content -->

<!--CADASTRA UMA NOVO ITEM NA TES-->
<div class="modal fade" id="novotesitens" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Cadastro TES</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="widget-header">

                        <div class="row">
                            <div class="col-xs-12">
                                <input name="id_tes" type="hidden" value="<?php echo $id; ?>">
                                <legend>TES</legend>
                                <div class='row'>
                                    <div class='col-sm-4'>    
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">CFOP</label>
                                            <input name="tes_itens_cfop" type="text" class="form-control" id="recipient-name">
                                        </div>
                                    </div>
                                    <div class='col-sm-4'>
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">Origem</label>
                                            <select class="form-control" name="tes_itens_origem">
                                                <option value="1">1 - Dentro Estado</option>
                                                <option value="2">2 - Fora Estado</option>
                                                <option value="3">3 - Fora do Pais</option>
                                            </select>
                                        </div> 
                                    </div>
                                    <div class='col-sm-4'>
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">Contribuinte</label>
                                            <select class="form-control" name="tes_itens_contribuinte">
                                                <option value="1">1 - SIM</option>
                                                <option value="0">0 - NÃO</option>

                                            </select>
                                        </div> 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class='col-sm-4'>
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">Tipo Produto</label>
                                            <select class="form-control" name="tes_itens_tipo_produto">
                                                <option value="1">1 - Produto Acabado</option>
                                                <option value="2">2 - Revenda</option>
                                                <option value="3">3 - Outros</option>
                                            </select>
                                        </div> 
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">CST ICMS</label>
                                            <input type="text" name="tes_itens_cst_icms" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" name="btn-cadastrates_itens" class="btn btn-xs btn-success">Cadastrar</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>			  
        </div>
    </div>
</div>

<!--EDITA O ITEM DA TES-->
<div class="modal fade" id="editartesitens" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-xs-12">
                            <legend>ITENS TES</legend>
                            <div class='row'>
                                <div class='col-sm-2'>   
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">ID TES ITENS</label>
                                        <input name="tes_itens_id" type="text" class="form-control" id="tes_itens_id">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">ID TES</label>
                                        <input name="id_tes" type="text" class="form-control" id="id_tes">
                                    </div>
                                </div>
                                <div class='col-sm-3'>   
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">CFOP</label>
                                        <input name="tes_itens_cfop" type="text" class="form-control" id="tes_itens_cfop">
                                    </div>
                                </div>
                                <div class='col-sm-3'>   
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Origem</label>
                                        <select class="form-control" name="tes_itens_origem" id="tes_itens_origem">
                                            <option value="1">1 - Dentro do Estado</option>
                                            <option value="2">2 - Fora do Estado</option>
                                            <option value="3">3 - Fora do Pais</option>
                                        </select>
                                    </div>
                                </div>
                                <div class='col-sm-2'>   
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Contribuinte</label>
                                        <select class="form-control" name="tes_itens_contribuinte" id="tes_itens_contribuinte">
                                            <option value="1">1 - SIM</option>
                                            <option value="0">0 - NÃO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class='col-sm-3'>   
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Tipo Produto</label>
                                        <select class="form-control" name="tes_itens_tipo_produto" id="tes_itens_tipo_produto">
                                            <option value="1">1 - Produto Acabado</option>
                                            <option value="2">2 - Revenda</option>
                                            <option value="3">3 - Outros</option>
                                        </select>
                                    </div>
                                </div>
                                <div class='col-sm-2'>   
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">CST ICMS</label>
                                        <input name="tes_itens_cst_icms" type="text" class="form-control" id="tes_itens_cst_icms">
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
        </div>
    </div>
</div>

<!--EXCLUI O ICMS/ICMS-ST DA ST-->
<div class="modal fade" id="excluirtesitens" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Itens</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <input name="tes_itens_id" type="hidden" class="form-control" id="tes_itens_id">
                    </div>
                    <div class="form-group">
                        <input name="id_tes" type="hidden" class="form-control" id="id_tes">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-excluir-tesitens" class="btn btn-xs btn-danger">Excluir</button>
                    </div>

                </form>
            </div>			  
        </div>
    </div>
</div>
<?php
require_once '../pagina/footer.php';
?>