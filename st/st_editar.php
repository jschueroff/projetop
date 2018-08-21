<?php
require_once 'st_config.php';
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

$stmt_pis = $auth_user->runQuery("SELECT * FROM pis where pis_tipo =$lista[st_tipo]");
$stmt_pis->execute();

$stmt_ipi = $auth_user->runQuery("SELECT * FROM ipi where ipi_tipo =$lista[st_tipo]");
$stmt_ipi->execute();

$stmt_cofins = $auth_user->runQuery("SELECT * FROM cofins where cofins_tipo =$lista[st_tipo]");
$stmt_cofins->execute();

$stmt_sticms = $auth_user->runQuery("SELECT * FROM sticms, icms WHERE sticms_cso = icms_id AND id_st =:id");
$stmt_sticms->execute(array(":id" => $id));

//BUSCAR O CRT DA EMPRESA PARA AJUSTAR O EDITAR DO ICMS DA EMPRESA

$stmt_e = $auth_user->runQuery("SELECT * FROM empresa WHERE empresa_id = 1");
$stmt_e->execute();

//BUSCAR O CRT DA EMPRESA PARA CADASTRAR UM NOVO ICMS NA EMPRESA
$stmt_e1 = $auth_user->runQuery("SELECT * FROM empresa WHERE empresa_id = 1");
$stmt_e1->execute();
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

            <div class="col-sm-12">

                <form method="post"> 
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-xs-12">
                                    <legend>Editar Situação Tributária</legend>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label>ID</label>
                                            <input type="text" id="st_id" required="" value="<?php echo $lista['st_id']; ?>" class="form-control"  disabled=""/>
                                            <input type="hidden" id="st_id" required="" value="<?php echo $lista['st_id']; ?>"  name="st_id" class="form-control" />
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nome</label>
                                            <input type="text" id="st_nome" required=""  name="st_nome" class="form-control" value="<?php echo $lista['st_nome']; ?>"  />
                                        </div> 
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label >UF</label>
                                            <select id="st_uf" name="st_uf" class="form-control">
                                                <?php
                                                while ($row = $stmt_estado->fetch(PDO::FETCH_ASSOC)) {
                                                    if ($row['estado_id'] == $lista['id_estado']) {
                                                        ?>
                                                        <option value="<?php echo $row['estado_id']; ?>" selected=""><?php echo $row['estado_sigla']; ?></option>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <option value="<?php echo $row['estado_id']; ?>"><?php echo $row['estado_sigla']; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Tipo</label>
                                            <div id="estado">
                                                <select id="cmbEstado" name="st_tipo" disabled="" class="form-control">
                                                    <option>
                                                        <?php
                                                        if ($lista['st_tipo'] == 0) {
                                                            echo 'ENTRADA';
                                                        }
                                                        if ($lista['st_tipo'] == 1) {
                                                            echo 'SAIDA';
                                                        }
                                                        ?>
                                                    </option>
                                                </select>
                                            </div>
                                        </div>  
                                    </div>
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                            <div class="tabbable tabs-left">
                                <ul class="nav nav-tabs" id="myTab3">
                                    <li class="active">
                                        <a data-toggle="tab" href="#icms">
                                            ICMS
                                        </a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#pis">
                                            PIS
                                        </a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#cofins">
                                            COFINS
                                        </a>
                                    </li>

                                    <li>
                                        <a data-toggle="tab" href="#ipi">
                                            IPI
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div id="icms" class="tab-pane in active">


                                        <div class="form-group">
                                            <label class="col-sm-10 control-label no-padding-right" for="form-field-tags"></label>
                                            <button type="button" class="btn btn-xs btn-success col-xs-1" 
                                                    data-toggle="modal" data-target="#novost" 
                                                    >Novo</button>
                                        </div>

                                        <table id="simple-table" class="table table-striped table-bordered table-hover responsive">
                                            <thead>
                                                <tr>

                                                    <th>UF Des.</th>
                                                    <th class="hidden-480">Contribuinte</th>
                                                    <th class="hidden-480">ST Esp.</th>
                                                    <th class="hidden-480">CST</th>

                                                    <th class="hidden-480">Redução BC</th>
                                                    <th class="hidden-480">Aliquota</th>
                                                    <th class="hidden-480">Redução BC ST</th>
                                                    <th class="hidden-480">Aliquota ST</th>
                                                    <th class="hidden-480">MVA</th>
                                                    <th class="hidden-480 center" colspan="2" >Configurar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                while ($row_lis = $stmt_sticms->fetch(PDO::FETCH_ASSOC)) {
                                                    ?>
                                                    <tr>

                                                        <th><?php echo $row_lis['sticms_uf'] ?></th>
                                                        <th class="hidden-480"><?php
                                                            if ($row_lis['sticms_tipo_pessoa'] == 1) {
                                                                echo " 1 - PJ Contribuinte";
                                                            }
                                                            if ($row_lis['sticms_tipo_pessoa'] == 2) {
                                                                echo "2 - PJ Contribuinte Consumidor";
                                                            }
                                                            if ($row_lis['sticms_tipo_pessoa'] == 3) {
                                                                echo "3 - PJ Não Contribuinte";
                                                            }
                                                            if ($row_lis['sticms_tipo_pessoa'] == 9) {
                                                                echo "9 - PF Contribuinte";
                                                            }
                                                            if ($row_lis['sticms_tipo_pessoa'] == 10) {
                                                                echo "10 - PF";
                                                            }
                                                            ?></th>




                                                        <th class="hidden-480"><?php echo $row_lis['sticms_st_especifica'] ?></th>
                                                        <th class="hidden-480"><?php echo $row_lis['icms_codigo'] ?></th>

                                                        <th class="hidden-480"><?php echo $row_lis['sticms_reducao_base_calculo'] ?></th>
                                                        <th class="hidden-480"><?php echo $row_lis['sticms_aliquota'] ?></th>
                                                        <th class="hidden-480"><?php echo $row_lis['sticms_st_reducao_calculo'] ?></th>
                                                        <th class="hidden-480"><?php echo $row_lis['sticms_st_aliquota'] ?></th>
                                                        <th class="hidden-480"><?php echo $row_lis['sticms_st_mva'] ?></th>
                                                        <th class="hidden-480">

                                                            <button type="button" class="btn btn-minier btn-warning" 
                                                                    data-toggle="modal" data-target="#editarsticms" 
                                                                    data-sticms_id="<?php echo $row_lis['sticms_id']; ?>"
                                                                    data-id_st="<?php echo $row_lis['id_st']; ?>"
                                                                    data-sticms_uf="<?php echo $row_lis['sticms_uf']; ?>"
                                                                    data-sticms_tipo_pessoa="<?php echo $row_lis['sticms_tipo_pessoa']; ?>"
                                                                    data-sticms_st_especifica="<?php echo $row_lis['sticms_st_especifica']; ?>"
                                                                    data-sticms_st="<?php echo $row_lis['sticms_st']; ?>"
                                                                    data-sticms_cso="<?php echo $row_lis['sticms_cso']; ?>"
                                                                    data-sticms_modalidade_base_calculo="<?php echo $row_lis['sticms_modalidade_base_calculo']; ?>"
                                                                    data-sticms_reducao_base_calculo="<?php echo $row_lis['sticms_reducao_base_calculo']; ?>"
                                                                    data-sticms_base_calculo="<?php echo $row_lis['sticms_base_calculo']; ?>"
                                                                    data-sticms_aliquota="<?php echo $row_lis['sticms_aliquota']; ?>"
                                                                    data-sticms_perc_diferimento="<?php echo $row_lis['sticms_perc_diferimento']; ?>"
                                                                    data-sticms_st_comportamento="<?php echo $row_lis['sticms_st_comportamento']; ?>"
                                                                    data-sticms_st_modalidade_calculo="<?php echo $row_lis['sticms_st_modalidade_calculo']; ?>"
                                                                    data-sticms_st_mva="<?php echo $row_lis['sticms_st_mva']; ?>"
                                                                    data-sticms_st_reducao_calculo="<?php echo $row_lis['sticms_st_reducao_calculo']; ?>"
                                                                    data-sticms_st_aliquota="<?php echo $row_lis['sticms_st_aliquota']; ?>"
                                                                    data-sticms_par_pobreza="<?php echo $row_lis['sticms_par_pobreza']; ?>"
                                                                    data-sticms_par_destino="<?php echo $row_lis['sticms_par_destino']; ?>"
                                                                    data-sticms_par_origem="<?php echo $row_lis['sticms_par_origem']; ?>"
                                                                    data-sticms_mensagem_nfe="<?php echo $row_lis['sticms_mensagem_nfe']; ?>"


                                                                    >Editar</button>

                                                        </th>
                                                        <th class="hidden-480">
                                                            <button type="button" class="btn btn-minier btn-danger" 
                                                                    data-toggle="modal" data-target="#excluirsticms" 
                                                                    data-sticms_id="<?php echo $row_lis['sticms_id']; ?>"
                                                                    data-id_st="<?php echo $row_lis['id_st']; ?>"
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
                                    <!--                                     EDITAR O PIS-->
                                    <div id="pis" class="tab-pane">
                                        <legend>Editar PIS</legend>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label >Situação Tributária</label>
                                                    <div id="pis">
                                                        <select id="cmbpis" name="id_pis" class="form-control">
                                                            <?php
                                                            while ($row = $stmt_pis->fetch(PDO::FETCH_ASSOC)) {
                                                                if ($row['pis_id'] == $lista['id_pis']) {
                                                                    ?>
                                                                    <option value="<?php echo $row['pis_id']; ?>" selected=""><?php echo $row['pis_descricao']; ?></option>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <option value="<?php echo $row['pis_id']; ?>"><?php echo $row['pis_descricao']; ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Reg. de Apu.</label>
                                                    <select name="st_pis_regime_apuracao" class="form-control">
                                                        <option value="0" <?= ($lista['st_pis_regime_apuracao'] == '') ? 'selected' : '' ?>>Não Tem</option>
                                                        <option value="1" <?= ($lista['st_pis_regime_apuracao'] == '1') ? 'selected' : '' ?>>Cumulativo</option>
                                                        <option value="2" <?= ($lista['st_pis_regime_apuracao'] == '2') ? 'selected' : '' ?>>Não Cumulativo</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Aliquota</label>
                                                    <input type="text" id="st_pis_aliquota"  name="st_pis_aliquota" class="form-control" value="<?php echo $lista['st_pis_aliquota']; ?>" />
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Tipo Calculo</label>
                                                    <select name="st_pis_tipo_calculo" class="form-control">

                                                        <option value="" <?= ($lista['st_pis_tipo_calculo'] == '') ? 'selected' : '' ?>></option>
                                                        <option value="1" <?= ($lista['st_pis_tipo_calculo'] == '1') ? 'selected' : '' ?>>Valor da Unidade</option>
                                                        <option value="2" <?= ($lista['st_pis_tipo_calculo'] == '2') ? 'selected' : '' ?>>Aliquota</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <legend>PIS Substituição Tributária</legend>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Tipo Calculo ST</label>
                                                    <select name="st_pis_tipo_calculo_st" class="form-control">

                                                        <option value="" <?= ($lista['st_pis_tipo_calculo_st'] == '') ? 'selected' : '' ?>></option>
                                                        <option value="1" <?= ($lista['st_pis_tipo_calculo_st'] == '1') ? 'selected' : '' ?>>Valor da Unidade</option>
                                                        <option value="2" <?= ($lista['st_pis_tipo_calculo_st'] == '2') ? 'selected' : '' ?>>Aliquota</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Aliquota</label>
                                                    <input type="text" id="st_pis_aliquota_st"  name="st_pis_aliquota_st" class="form-control" value="<?= $lista['st_pis_aliquota_st']; ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--                                    EDIÇÃO DO IPI-->
                                    <div id="ipi" class="tab-pane">
                                        <legend>Editar IPI</legend>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Situação Tributária</label>
                                                    <div id="pis">
                                                        <select id="cmbipi" name="id_ipi" class="form-control">
                                                            <?php
                                                            while ($row = $stmt_ipi->fetch(PDO::FETCH_ASSOC)) {
                                                                if ($row['ipi_id'] == $lista['id_ipi']) {
                                                                    ?>
                                                                    <option value="<?php echo $row['ipi_id']; ?>" selected=""><?php echo $row['ipi_descricao']; ?></option>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <option value="<?php echo $row['ipi_id']; ?>"><?php echo $row['ipi_descricao']; ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label >Classe Enq.</label>
                                                    <input type="text" id="st_ipi_classe"  name="st_ipi_classe" class="form-control" value="<?php echo $lista['st_ipi_classe'] ?>" />
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label >Código Enq.</label>
                                                    <input type="text" id="st_ipi_cod"  name="st_ipi_cod" class="form-control"  value="<?php echo $lista['st_ipi_cod'] ?>"/>
                                                </div> 
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Tipo Calculo</label>
                                                    <select name="st_ipi_tipo_calculo" class="form-control">

                                                        <option value="0" <?= ($lista['st_ipi_tipo_calculo'] == '0') ? 'selected' : '' ?>>Não Calcula</option>
                                                        <option value="1" <?= ($lista['st_ipi_tipo_calculo'] == '1') ? 'selected' : '' ?>>Valor Unidade</option>
                                                        <option value="2" <?= ($lista['st_ipi_tipo_calculo'] == '2') ? 'selected' : '' ?>>Aliquota</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Aliquota</label>
                                                    <input type="text" id="st_ipi_aliquota"  name="st_ipi_aliquota" class="form-control"  value="<?php echo $lista['st_ipi_aliquota'] ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- EDITAR O COFINS -->
                                    <div id="cofins" class="tab-pane">
                                        <legend>COFINS</legend>
                                        <div class="row">
                                            <div class="col-md-6">

                                                <div class="form-group">
                                                    <label >Situação Tributária</label>
                                                    <div id="pis">
                                                        <select id="cmbcofins" name="id_cofins" class="form-control">
                                                            <?php
                                                            while ($row = $stmt_cofins->fetch(PDO::FETCH_ASSOC)) {
                                                                if ($row['cofins_id'] == $lista['id_cofins']) {
                                                                    ?>
                                                                    <option value="<?php echo $row['cofins_id']; ?>" selected=""><?php echo $row['cofins_descricao']; ?></option>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <option value="<?php echo $row['cofins_id']; ?>"><?php echo $row['cofins_descricao']; ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Reg. de Apu.</label>
                                                    <select name="st_cofins_regime_apuracao" class="form-control">
                                                        <option value="" <?= ($lista['st_cofins_regime_apuracao'] == '') ? 'selected' : '' ?>>Não Tem</option>
                                                        <option value="1" <?= ($lista['st_cofins_regime_apuracao'] == '1') ? 'selected' : '' ?>>Cumulativo</option>
                                                        <option value="2" <?= ($lista['st_cofins_regime_apuracao'] == '2') ? 'selected' : '' ?>>Não Cumulativo</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Aliquota</label>
                                                    <input type="text" id="st_cofins_aliquota"  name="st_cofins_aliquota" class="form-control" value="<?= $lista['st_cofins_aliquota'] ?>" />
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Tipo Calculo</label>
                                                    <select name="st_cofins_tipo_calculo" class="form-control">
                                                        <option value="" <?= ($lista['st_cofins_tipo_calculo'] == '') ? 'selected' : '' ?>></option>
                                                        <option value="1" <?= ($lista['st_cofins_tipo_calculo'] == '1') ? 'selected' : '' ?>>Valor da Unidade</option>
                                                        <option value="2" <?= ($lista['st_cofins_tipo_calculo'] == '2') ? 'selected' : '' ?>>Aliquota</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <legend>COFINS Substituição Tributária</legend>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Tipo Calculo ST</label>
                                                    <select name="st_cofins_calculo_st" class="form-control">

                                                        <option value="" <?= ($lista['st_cofins_calculo_st'] == '') ? 'selected' : '' ?>></option>
                                                        <option value="1" <?= ($lista['st_cofins_calculo_st'] == '1') ? 'selected' : '' ?>>Valor da Unidade</option>
                                                        <option value="2" <?= ($lista['st_cofins_calculo_st'] == '2') ? 'selected' : '' ?>>Aliquota</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Aliquota</label>
                                                    <input type="text" id="st_cofins_aliquota_st"  name="st_cofins_aliquota_st" class="form-control"  value="<?= $lista['st_cofins_aliquota_st'] ?>"/>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix form-actions">
                                <div class="col-md-offset-10 col-md-9">
                                    <button type="submit" name="btn-salvar" class="btn btn-info btn-sm">
                                        Alterar
                                    </button>
                                </div>
                            </div>
                        </div><!-- /.col -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><!-- /.main-content -->

<!--CADASTRA UMA NOVO ICMS/ICMS-ST PARA A ST-->
<div class="modal fade" id="novost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Cadastro ICMS/ICMS-ST</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="widget-header">

                        <div class="row">
                            <div class="col-xs-12">
                                <input name="id_st" type="hidden" value="<?php echo $id; ?>">
                                <legend>ICMS</legend>
                                <div class='row'>
                                    <div class='col-sm-4'>    
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">UF Destino</label>
                    <!--                        <input name="id_produto" type="text" class="form-control" id="recipient-name">-->
                                            <select class="form-control" name="sticms_uf">
                                                <option value="AC">AC</option>
                                                <option value="AL">AL</option>
                                                <option value="AM">AM</option>
                                                <option value="AP">AP</option>
                                                <option value="BA">BA</option>
                                                <option value="CE">CE</option>
                                                <option value="DF">DF</option>
                                                <option value="ES">ES</option>
                                                <option value="GO">GO</option>
                                                <option value="MA">MA</option>
                                                <option value="MG">MG</option>
                                                <option value="MS">MS</option>
                                                <option value="MT">MT</option>
                                                <option value="PA">PA</option>
                                                <option value="PB">PB</option>
                                                <option value="PE">PE</option>
                                                <option value="PI">PI</option>
                                                <option value="PR">PR</option>
                                                <option value="RJ">RJ</option>
                                                <option value="RN">RN</option>
                                                <option value="RO">RO</option>
                                                <option value="RR">RR</option>
                                                <option value="RS">RS</option>
                                                <option value="SC" selected="">SC</option>
                                                <option value="SE">SE</option>                                                                        
                                                <option value="SP">SP</option>                                                                        
                                                <option value="TO">TO</option> 
                                            </select>
                                        </div>
                                    </div>
                                    <div class='col-sm-4'>
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">Tipo Contri.</label>
                                            <select class="form-control" name="sticms_tipo_pessoa">
                                                <option value="1">1 - PJ Contribuinte</option>
                                                <option value="2">2 - PJ Contribuinte Consumidor</option>
                                                <option value="3">3 - PJ Não Contribuinte</option>
                                                <option value="9">9 - PF Contribuinte</option>
                                                <option value="10">10 - PF</option>

                                            </select>
                                        </div> 


                                    </div>
                                    <div class='col-sm-4'>  
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">ST. Especifica</label>
                                            <input type="text" name="sticms_st_especifica" class="form-control">
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group">

                                            <label for="recipient-name" class="control-label">CSO - Simples Nacional</label>


                                            <select  name="sticms_cso" class="form-control">
                                                <?php
                                                while ($e1 = $stmt_e1->fetch(PDO::FETCH_ASSOC)) {
                                                    if ($e1['empresa_crt'] == 3) {
                                                        ?>
                                                        <option value="1"> 00: Tributada integralmente </option>
                                                        <option value="2"> 10: Tributada com cobr. por subst. trib. </option>
                                                        <option value="3"> 20: Com redução de base de cálculo </option>
                                                        <option value="4"> 30: Isenta ou não trib com cobr por subst trib </option>
                                                        <option value="5"> 40: Isenta </option>
                                                        <option value="6"> 41: Não tributada </option>
                                                        <option value="7"> 50: Suspesão </option>
                                                        <option value="8"> 51: Diferimento </option>
                                                        <option value="9"> 60: ICMS cobrado anteriormente por subst trib </option>
                                                        <option value="10"> 70: Redução de Base Calc e cobr ICMS por subst trib </option>
                                                        <option value="11"> 90: Outros </option>
                                                        <?php
                                                    }

                                                    if (($e1['empresa_crt'] == 1) || ($e1['empresa_crt'] == 2)) {
                                                        ?>

                                                        <option value="15"> Simples Nacional: 101: Com permissão de crédito </option>
                                                        <option value="16"> Simples Nacional: 102: Sem permissão de crédito </option>
                                                        <option value="17"> Simples Nacional: 103: Isenção do ICMS para faixa de receita bruta </option>
                                                        <option value="18"> Simples Nacional: 201: Com permissão de crédito, com cobr ICMS por Subst Trib</option>
                                                        <option value="19"> Simples Nacional: 202: Sem permissão de crédito, com cobr ICMS por Subst Trib </option>
                                                        <option value="20"> Simples Nacional: 203: Isenção ICMS p/ faixa de receita bruta e cobr do ICMS por ST</option>
                                                        <option value="21"> Simples Nacional: 300: Imune </option>
                                                        <option value="22"> Simples Nacional: 400: Não tributada </option>
                                                        <option value="23"> Simples Nacional: 500: ICMS cobrado antes por subst trib ou antecipação </option>
                                                        <option value="24"> Simples Nacional: 900: Outros </option>

                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>

                                        </div> 
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">Modalidade Base Calculo</label>
                                            <select name="sticms_modalidade_base_calculo" class="form-control">
                                                <option value=""></option>
                                                <option value="0" disabled="">0 - Margem Valor Agregado</option>
                                                <option value="1" disabled="">1 - Pauta</option>
                                                <option value="2" disabled="">2 - Preço Tabelado</option>
                                                <option value="3">3 - Valor da Operação</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">Redução Base Calculo</label>
                                            <input type="text" name="sticms_reducao_base_calculo" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">Base Calculo</label>
                                            <input type="text" name="sticms_base_calculo" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">Aliquota</label>
                                            <input type="text" name="sticms_aliquota" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">Perc. Diferimento</label>
                                            <input type="text" name="sticms_perc_diferimento" class="form-control">
                                        </div>
                                    </div>



                                </div>
                                <legend>ICMS ST</legend>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">Comportamento ST</label>
                                            <select name="sticms_st_comportamento" class="form-control" >
                                                <option value=""></option>
                                                <option value="1" disabled="">1 - Destacar NF-e</option>
                                                <option value="11" disabled="">11 - Icms Antecipado em dados adicionais</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">Modalidade de Cálculo ST</label>
                                            <!--<input type="text" name="sticms_st_modalidade_calculo" class="form-control">-->
                                            <select name="sticms_st_modalidade_calculo" class="form-control" >
                                                <option value=""></option>
                                                <option value="0">0 - Preço tabelado ou máximo sugerido;</option>
                                                <option value="1">1 - Lista Negativa (valor);</option>
                                                <option value="2">2 - Lista Positiva (valor);</option>
                                                <option value="3">3 - Lista Neutra (valor);</option>
                                                <option value="4">4 - Margem Valor Agregado (%);</option>
                                                <option value="5">5 - Pauta (valor);</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">MVA</label>
                                            <input type="text" name="sticms_st_mva" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">Redução Calculo ST</label>
                                            <input type="text" name="sticms_st_reducao_calculo" class="form-control">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">Redução Calculo ST</label>
                                            <input type="text" name="sticms_st_reducao_calculo" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">ST aliquota</label>
                                            <input type="text" name="sticms_st_aliquota" class="form-control">
                                        </div>
                                    </div>

                                </div>

                                <legend>ICMS PARTILHA</legend>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">ST Pobreza</label>
                                            <input type="text" name="sticms_par_pobreza" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">ST Par. Destino</label>
                                            <input type="text" name="sticms_par_destino" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">ST Par. Origem</label>
                                            <input type="text" name="sticms_par_origem" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">Mensagem NF-e</label>
                                            <input type="text" name="sticms_mensagem_nfe" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" name="btn-cadastra-sticms" class="btn btn-xs btn-success">Cadastrar</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>			  
        </div>
    </div>
</div>

<!--EDITA O ICMS/ICMS-ST DA ST-->
<div class="modal fade" id="editarsticms" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <input name="sticms_id" type="hidden" class="form-control" id="sticms_id">
                            </div>
                            <div class="form-group">
                                <input name="id_st" type="hidden" class="form-control" id="id_st">
                            </div>

                            <legend>ICMS</legend>
                            <div class='row'>

                                <div class='col-sm-1'>   

                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">UF</label>
                                        <input name="sticms_uf" type="text" class="form-control" id="sticms_uf">
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Tipo Pessoa</label>
                                        <select class="form-control" name="sticms_tipo_pessoa" id="sticms_tipo_pessoa">
                                            <option value="1">1 - PJ Contribuinte</option>
                                            <option value="2">2 - PJ Contribuinte Consumidor</option>
                                            <option value="3">3 - PJ Não Contribuinte</option>
                                            <option value="9">9 - PF Contribuinte</option>
                                            <option value="10">10 - PF</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">ST Especifica</label>
                                        <input name="sticms_st_especifica" type="text" class="form-control" id="sticms_st_especifica">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">ST</label>
                                        <input name="sticms_st" type="text" class="form-control" id="sticms_st">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="form-group">

                                        <label for="recipient-name" class="control-label">CSON</label>

                                        <select  name="sticms_cso" class="form-control" id="sticms_cso">

                                            <?php
                                            while ($e = $stmt_e->fetch(PDO::FETCH_ASSOC)) {
                                                if ($e['empresa_crt'] == 3) {
                                                    ?>
                                                    <option value="1"> 00: Tributada integralmente </option>
                                                    <option value="2"> 10: Tributada com cobr. por subst. trib. </option>
                                                    <option value="3"> 20: Com redução de base de cálculo </option>
                                                    <option value="4"> 30: Isenta ou não trib com cobr por subst trib </option>
                                                    <option value="5"> 40: Isenta </option>
                                                    <option value="6"> 41: Não tributada </option>
                                                    <option value="7"> 50: Suspesão </option>
                                                    <option value="8"> 51: Diferimento </option>
                                                    <option value="9"> 60: ICMS cobrado anteriormente por subst trib </option>
                                                    <option value="10"> 70: Redução de Base Calc e cobr ICMS por subst trib </option>
                                                    <option value="11"> 90: Outros </option>
                                                    <?php
                                                }

                                                if (($e['empresa_crt'] == 1) || ($e['empresa_crt'] == 2)) {
                                                    ?>

                                                    <option value="15"> Simples Nacional: 101: Com permissão de crédito </option>
                                                    <option value="16"> Simples Nacional: 102: Sem permissão de crédito </option>
                                                    <option value="17"> Simples Nacional: 103: Isenção do ICMS para faixa de receita bruta </option>
                                                    <option value="18"> Simples Nacional: 201: Com permissão de crédito, com cobr ICMS por Subst Trib</option>
                                                    <option value="19"> Simples Nacional: 202: Sem permissão de crédito, com cobr ICMS por Subst Trib </option>
                                                    <option value="20"> Simples Nacional: 203: Isenção ICMS p/ faixa de receita bruta e cobr do ICMS por ST</option>
                                                    <option value="21"> Simples Nacional: 300: Imune </option>
                                                    <option value="22"> Simples Nacional: 400: Não tributada </option>
                                                    <option value="23"> Simples Nacional: 500: ICMS cobrado antes por subst trib ou antecipação </option>
                                                    <option value="24"> Simples Nacional: 900: Outros </option>

                                                    <?php
                                                }
                                            }
                                            ?>

                                        </select>

                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Modalidade Base Calculo</label>
                                        <select name="sticms_modalidade_base_calculo" class="form-control"  id="sticms_modalidade_base_calculo">
                                            <option value=""></option>
                                            <option value="0" disabled="">0 - Margem Valor Agregado</option>
                                            <option value="1" disabled="">1 - Pauta</option>
                                            <option value="2" disabled="">2 - Preço Tabelado</option>
                                            <option value="3">3 - Valor da Operação</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Redução Base Calculo</label>
                                        <input type="text" name="sticms_reducao_base_calculo" class="form-control" id="sticms_reducao_base_calculo">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Base Calculo </label>
                                        <input type="text" name="sticms_base_calculo" class="form-control" id="sticms_base_calculo">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Aliquota</label>
                                        <input type="text" name="sticms_aliquota" class="form-control" id="sticms_aliquota">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Perc Diferimento</label>
                                        <input type="text" name="sticms_perc_diferimento" class="form-control" id="sticms_perc_diferimento">
                                    </div>
                                </div>
                            </div>

                            <legend>ICMS ST</legend>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Comportamento ST</label>
<!--                                        <input type="text" name="sticms_st_comportamento" class="form-control" >-->
                                        <select name="sticms_st_comportamento" class="form-control" id="sticms_st_comportamento">
                                            <option value=""></option>
                                            <option value="1" disabled="">1 - Destacar NF-e</option>
                                            <option value="11" disabled="">11 - Icms Antecipado em dados adicionais</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Modalidade de Cálculo ST</label>
                                        <!--<input type="text" name="sticms_st_modalidade_calculo" class="form-control" >-->
                                        <select name="sticms_st_modalidade_calculo" class="form-control" id="sticms_st_modalidade_calculo" >
                                            <option value=""></option>
                                            <option value="0">0 - Preço tabelado ou máximo sugerido;</option>
                                            <option value="1">1 - Lista Negativa (valor);</option>
                                            <option value="2">2 - Lista Positiva (valor);</option>
                                            <option value="3">3 - Lista Neutra (valor);</option>
                                            <option value="4">4 - Margem Valor Agregado (%);</option>
                                            <option value="5">5 - Pauta (valor);</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">MVA</label>
                                        <input type="text" name="sticms_st_mva" class="form-control" id="sticms_st_mva">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Redução Calculo ST</label>
                                        <input type="text" name="sticms_st_reducao_calculo" class="form-control" id="sticms_st_reducao_calculo">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">ST aliquota</label>
                                        <input type="text" name="sticms_st_aliquota" class="form-control" id="sticms_st_aliquota">
                                    </div>
                                </div>

                            </div>

                            <legend>ICMS PARTILHA</legend>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">ST Pobreza</label>
                                        <input type="text" name="sticms_par_pobreza" class="form-control" id="sticms_par_pobreza">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">ST Par. Destino</label>
                                        <input type="text" name="sticms_par_destino" class="form-control" id="sticms_par_destino">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">ST Par. Origem</label>
                                        <input type="text" name="sticms_par_origem" class="form-control" id="sticms_par_origem">
                                    </div>
                                </div>
                            </div>
                            <legend></legend>
                            <div class="form-group">
                                <label for="recipient-name" class="control-label">Mensagem NF-e</label>
                                <input type="text" name="sticms_mensagem_nfe" class="form-control" id="sticms_mensagem_nfe">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Cancelar</button>
                                <button type="submit" name="btn-altera-sticms" class="btn btn-xs btn-warning">Alterar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>			  
        </div>
    </div>
</div>

<!--EXCLUI O ICMS/ICMS-ST DA ST-->
<div class="modal fade" id="excluirsticms" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Itens</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <input name="sticms_id" type="hidden" class="form-control" id="sticms_id">
                    </div>
                    <div class="form-group">
                        <input name="id_st" type="hidden" class="form-control" id="id_st">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-excluir-sticms" class="btn btn-xs btn-danger">Excluir</button>
                    </div>

                </form>
            </div>			  
        </div>
    </div>
</div>
<?php
require_once '../pagina/footer.php';
?>