<?php
require_once 'notas_config.php';
require_once '../pagina/menu.php';

$id = $_GET['nota_id'];
//BUSCA OS DADOS DA NFE PARA EDICAO/CONSULTA
$stmt_edi = $auth_user->runQuery("SELECT * FROM nota_itens, nota, municipio WHERE"
        . " municipio_cod_ibge = nota_codigo_municipio and id_nota_id = nota_id "
        . " AND id_nota_id =:id");
$stmt_edi->execute(array(":id" => $id));
$edi = $stmt_edi->fetch(PDO::FETCH_ASSOC);


//BUSCA DADOS DO PRODUTOS DA NOTA
$stmt_produ = $auth_user->runQuery("SELECT * FROM nota_itens WHERE id_nota_id =:id");
$stmt_produ->execute(array(":id" => $id));

$stmt_totais = $auth_user->runQuery("SELECT  SUM(nota_itens_bc_icms),
    SUM(nota_itens_valor_icms),
    SUM(nota_itens_total),
    SUM(nota_itens_valor_frete),
    SUM(nota_itens_valor_seguro), 
    SUM(nota_itens_valor_desconto),
    SUM(nota_itens_outras_despesas),
    SUM(nota_itens_ipi_valor),
    SUM(nota_itens_pis_valor), 
    SUM(nota_itens_cofins_valor),
    SUM(nota_itens_st_bc),
    SUM(nota_itens_st_valor),
    SUM(nota_itens_icms_des_valor),
    SUM(nota_itens_icmsII_valor),
    SUM(nota_itens_iof_valor),
    SUM(nota_itens_viss_valor),
    nota_itens_aliquota_cred_icms,
    SUM(nota_itens_valor_cred_icms),
    SUM(nota_itens_par_pobreza_valor),
    SUM(nota_itens_par_destino_valor),
    SUM(nota_itens_par_origem_valor)
    FROM nota_itens WHERE id_nota_id =:id");

//$vProd - $vDesc - $vICMSDeson + $vST + $vFrete + $vSeg + $vOutro + $vII + $vIPI,


$stmt_totais->execute(array(":id" => $id));
$total = $stmt_totais->fetch(PDO::FETCH_ASSOC);

//SOMA O TOTAL DA NFE
$stmt_total = $auth_user->runQuery("SELECT SUM(nota_itens_total) FROM nota_itens WHERE id_nota_id = $id");
$stmt_total->execute();
$tot = $stmt_total->fetch(PDO::FETCH_ASSOC);

//BUSCAR DADOS DA EMPRESA 
$stmt_dados_empresa = $auth_user->runQuery("SELECT * FROM empresa, municipio WHERE id_municipio = municipio_id AND empresa_id = 1");
$stmt_dados_empresa->execute();
$dados_emitente = $stmt_dados_empresa->fetch(PDO::FETCH_ASSOC);

//BUSCAR DADOS DO DESTINATARIO 
$stmt_dados_destinatario = $auth_user->runQuery("SELECT * FROM nota , cliente, municipio WHERE id_municipio = municipio_id AND 
identificador_cliente = cliente_id AND nota_id = :id");
$stmt_dados_destinatario->execute(array(":id" => $id));
$dados_destinatario = $stmt_dados_destinatario->fetch(PDO::FETCH_ASSOC);

//BUSCAR A ST VALIDA PARA CADASTRAR NO PEDIDO
$stmt_buscast = $auth_user->runQuery("SELECT * FROM st WHERE st_status = 1");
$stmt_buscast->execute();

// BUSCAR A TES VALIDA PARA CADASTRAR NO PEDIDO
$stmt_buscates = $auth_user->runQuery("SELECT * FROM tes WHERE tes_status = 1");
$stmt_buscates->execute();

//BUSCAR O CRT DA EMPRESA PARA AJUSTAR O EDITAR DO CST DA EMPRESA
$stmt_e = $auth_user->runQuery("SELECT * FROM empresa WHERE empresa_id = 1");
$stmt_e->execute();

// BUSCAR O TRANSPORTADOR DA NOTA 
$stmt_tranota = $auth_user->runQuery("SELECT * FROM transportador WHERE transportador_status = 1");
$stmt_tranota->execute();

// BUSCA OS VOLUMES DA NFE
$stmt_volume = $auth_user->runQuery("SELECT * FROM nota_volume WHERE id_nota =:id");
$stmt_volume->execute(array(":id" => $id));

// BUSCA OS VEICULO DA NFE
$stmt_veiculo = $auth_user->runQuery("SELECT * FROM nota_veiculo WHERE id_nota =:id");
$stmt_veiculo->execute(array(":id" => $id));

// BUSCA AS INFORMAÇÕES COMPLEMENTARES DA NFE
$stmt_inf_comp = $auth_user->runQuery("SELECT * FROM nota_inf_comp WHERE id_nota =:id");
$stmt_inf_comp->execute(array(":id" => $id));

// BUSCA INFORMAÇÕES COMPLEMENTARES PARA O CADASTRO/EDICAO NFE
$stmt_inf = $auth_user->runQuery("SELECT * FROM inf_comp WHERE inf_comp_status = 1");
$stmt_inf->execute();

// BUSCA NOTAS REFERENCIADAS PARA A NFE
$stmt_referencia = $auth_user->runQuery("SELECT * FROM nota_referencia WHERE id_nota =:id");
$stmt_referencia->execute(array(":id" => $id));

//BUSCA DOS DADOS DO TRIBUTOS 
$stmt_tributos = $auth_user->runQuery(" SELECT nota_itens.nota_itens_cfop AS cfops,
   COUNT(*) AS QtdCFOP,
   SUM(nota_itens.nota_itens_total) AS valorproduto,
   SUM(nota_itens.nota_itens_qtd) AS QTDPROD,
   
   SUM(nota_itens.nota_itens_bc_icms) AS bc_icms,
  nota_itens.nota_itens_aliquota AS aliquota_icms,
  SUM(nota_itens.nota_itens_valor_icms) AS valor_icms,
  
  SUM(nota_itens.nota_itens_st_bc) AS bc_icmsst,
  nota_itens.nota_itens_st_aliquota AS aliquota_icmsst,
  SUM(nota_itens.nota_itens_st_valor) AS valor_icmsst,
  
  nota_itens.nota_itens_ipi_aliquota AS aliquotaipi,
SUM(nota_itens.nota_itens_ipi_valor) AS valoripi,

SUM(nota_itens.nota_itens_pis_base_calculo) AS bc_pis,
nota_itens.nota_itens_pis_aliquota AS aliquotapis,
SUM(nota_itens.nota_itens_pis_valor) AS valorpis,


nota_itens.nota_itens_cofins_aliquota AS aliquotacofins,
SUM(nota_itens.nota_itens_cofins_valor) AS valorcofins
   

FROM nota_itens WHERE id_nota_id = :id
GROUP BY nota_itens.nota_itens_cfop
 ORDER BY COUNT(*) DESC;
   ");
$stmt_tributos->execute(array(":id" => $id));
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
                <li class="active">Editar/Consultar NF-e</li>
            </ul><!-- /.breadcrumb -->


        </div>

        <div class="page-content">
            <?php
            require_once('../principal/principal_config.php');
            ?>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <form method="POST">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="tabbable tabs-left">
                                        <ul class="nav nav-tabs" id="myTab3">
                                            <li class="active">
                                                <a data-toggle="tab" href="#home3">
                                                    <i class=" ace-icon fa fa-info"></i>
                                                    Home
                                                </a>
                                            </li>
                                            <li>
                                                <a data-toggle="tab" href="#emitente">
                                                    <i class=" ace-icon fa fa-envelope"></i>
                                                    Emit.
                                                </a>
                                            </li>
                                            <li>
                                                <a data-toggle="tab" href="#destinatario">
                                                    <i class=" ace-icon fa fa-male"></i>
                                                    Dest.
                                                </a>
                                            </li>
                                            <li>
                                                <a data-toggle="tab" href="#produto">
                                                    <i class=" ace-icon fa fa-barcode"></i>
                                                    Prod.
                                                </a>
                                            </li>
                                            <li>
                                                <a data-toggle="tab" href="#totais">
                                                    <i class="ace-icon fa fa-money"></i>
                                                    Totais
                                                </a>
                                            </li>
                                            <li>
                                                <a data-toggle="tab" href="#transportador">
                                                    <i class="ace-icon fa fa-car"></i>
                                                    Trans.
                                                </a>
                                            </li>
                                            <li >
                                                <a data-toggle="tab" href="#tributos" >
                                                    <i class="ace-icon fa fa-asterisk "></i>
                                                    Trib.
                                                </a>
                                            </li>
                                            <li>
                                                <a data-toggle="tab" href="#info">
                                                    <i class="ace-icon fa fa-rocket"></i>
                                                    Inf. Ad.
                                                </a>
                                            </li>
                                            <li>
                                                <a data-toggle="tab" href="#outras">
                                                    <i class="ace-icon fa fa-check"></i>
                                                    Ou. Inf.
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">

                                            <div id="home3" class="tab-pane in active">
                                                <legend class="col-xs-12">Status/Evento</legend>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="nota_cStat" class="control-label">Cód</label>
                                                            <input type="text" name="nota_cStat" class="form-control" disabled="" value="<?php echo $edi['nota_cStat']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="form-group">
                                                            <label for="nota_xMotivo" class="control-label">Status</label>
                                                            <input type="text" name="nota_xMotivo" class="form-control" disabled="" value="<?php echo $edi['nota_xMotivo']; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <legend>Dados da NF-e</legend>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="nota_id" class="control-label">ID</label>
                                                            <input name="nota_id" type="text" class="form-control input-sm" disabled="" value="<?php echo $edi['nota_id']; ?>">
                                                            <input name="nota_id" type="hidden" class="form-control input-sm"  value="<?php echo $edi['nota_id']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label class="control-label">Nome</label>
                                                            <input type="text" name="nota_cliente" id="nota_cliente" class="form-control input-sm" placeholder="Nome/Fantasia/CNPJ/CPF" autocomplete="off" disabled="" value="<?php echo $edi['nota_cliente']; ?>"/>                                 
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label class="control-label">Mod./Ser. NF-e</label>
                                                            <input class="form-control input-sm" name="nota_modelo" value="<?php echo $edi['nota_modelo'] . " === " . $edi['nota_serie'] ?>" disabled="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label for="nota_chave" class="control-label">Chave</label>
                                                            <input type="text" name="nota_chave" class="form-control input-sm" disabled="" value="<?php echo $edi['nota_chave']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label for="nota_cliente" class="control-label">Nat. Operação</label>
                                                            <input type="text" name="nota_natureza_operacao" class="form-control input-sm"  value="<?php echo $edi['nota_natureza_operacao']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label class="control-label">N° NF-e</label>
                                                            <input class="form-control input-sm" name="nota_numero_nf" value="<?php echo $edi['nota_numero_nf']; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label class="control-label">Fin. Emissão</label>
                                                            <select name="nota_finalidade" class="form-control ">
                                                                <option value="1" <?= ($edi['nota_finalidade'] == '1') ? 'selected' : '' ?> >NF-e Normal</option>
                                                                <option value="2" <?= ($edi['nota_finalidade'] == '2') ? 'selected' : '' ?> >NF-e Complementar</option>
                                                                <option value="3" <?= ($edi['nota_finalidade'] == '3') ? 'selected' : '' ?> >NF-e Ajuste</option>
                                                                <option value="4" <?= ($edi['nota_finalidade'] == '4') ? 'selected' : '' ?> >Devolução/Retorno</option>
                                                            </select>
                                                        </div>                                                    
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label class="control-label">Forma Emissão</label>
                                                            <select name="nota_tipo_emissao" class="form-control">
                                                                <option value="1" <?= ($edi['nota_tipo_emissao'] == '1') ? 'selected' : '' ?> >1-Emissão normal</option>
                                                                <option value="2" <?= ($edi['nota_tipo_emissao'] == '2') ? 'selected' : '' ?> >2-Contingência FS-IA</option>
                                                                <option value="3" <?= ($edi['nota_tipo_emissao'] == '3') ? 'selected' : '' ?> >3-Contingência SCAN</option>
                                                                <option value="4" <?= ($edi['nota_tipo_emissao'] == '4') ? 'selected' : '' ?> >4-Contingência DPEC</option>
                                                                <option value="5" <?= ($edi['nota_tipo_emissao'] == '5') ? 'selected' : '' ?> >5-Contingência FS-DA</option>
                                                                <option value="6" <?= ($edi['nota_tipo_emissao'] == '6') ? 'selected' : '' ?> >6-Contingência SVC-AN</option>
                                                                <option value="7" <?= ($edi['nota_tipo_emissao'] == '7') ? 'selected' : '' ?> >7-Contingência SVC-RS</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label class="control-label">Tipo Danfe</label>
                                                            <select name="nota_impressao" class="form-control">
                                                                <option value="1" <?= ($edi['nota_impressao'] == '1') ? 'selected' : '' ?>>Retrato</option>
                                                                <option value="2" <?= ($edi['nota_impressao'] == '2') ? 'selected' : '' ?>>Paisagem</option>
                                                            </select>                                                        
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="control-label">Tipo Operação</label>
                                                            <select name="nota_indicador_presencial" class="form-control">
                                                                <option disabled="" value="0" <?= ($edi['nota_indicador_presencial'] == '0') ? 'selected' : '' ?>>0-Não se aplica</option>
                                                                <option value="1" <?= ($edi['nota_indicador_presencial'] == '1') ? 'selected' : '' ?>>1-Operação presencial</option>
                                                                <option value="2" <?= ($edi['nota_indicador_presencial'] == '2') ? 'selected' : '' ?>>2-Operação não presencial, pela Internet</option>
                                                                <option value="3" <?= ($edi['nota_indicador_presencial'] == '3') ? 'selected' : '' ?>>3-Operação não presencial, Teleatendimento</option>
                                                                <option disabled="" value="4" <?= ($edi['nota_indicador_presencial'] == '4') ? 'selected' : '' ?>>4-NFC-e em operação com entrega a domicílio</option>
                                                                <option value="9" <?= ($edi['nota_indicador_presencial'] == '9') ? 'selected' : '' ?>>9-Operação não presencial, outros</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label class="control-label">N° Pedido</label>
                                                            <input class="form-control" name="id_pedido" value="<?php echo $edi['id_pedido']; ?>" disabled="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="nota_tipo_operacao" class="control-label">Tipo</label>
                                                            <select name="nota_tipo_operacao" class="form-control">
                                                                <?php
                                                                if ($edi['nota_tipo_operacao'] == 0) {
                                                                    ?>
                                                                    <option value="0" selected="">
                                                                        ENTRADA
                                                                    </option>
                                                                <?php } else {
                                                                    ?>
                                                                    <option value="1">
                                                                        SAIDA
                                                                    </option>
                                                                    <?php
                                                                }
                                                                if ($edi['nota_tipo_operacao'] == 1) {
                                                                    ?>
                                                                    <option value="1" selected="">
                                                                        SAIDA
                                                                    </option>
                                                                <?php } else {
                                                                    ?>
                                                                    <option value="0">
                                                                        ENTRADA
                                                                    </option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label class="control-label">Status</label>
                                                            <select name="nota_status" class="form-control">
                                                                <option value="1" <?= ($edi['nota_status'] == '1') ? 'selected' : '' ?> >PENDENTE</option>
                                                                <option value="2" <?= ($edi['nota_status'] == '2') ? 'selected' : '' ?> >CONFERIDO</option>
                                                                <option value="3" <?= ($edi['nota_status'] == '3') ? 'selected' : '' ?> >LIBERADO</option>
                                                                <option value="4" <?= ($edi['nota_status'] == '4') ? 'selected' : '' ?> disabled="">FATURADO</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label class="control-label">Cons. Final</label>
                                                            <select class="form-control" name="nota_indicador_finalidade">
                                                                <option value="0" <?= ($edi['nota_indicador_finalidade'] == '0') ? 'selected' : '' ?>>Não</option>
                                                                <option value="1" <?= ($edi['nota_indicador_finalidade'] == '1') ? 'selected' : '' ?>>Sim</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label class="control-label">Cód. Estado</label>
                                                            <input type="text" name="nota_numero_uf" class="form-control" value="<?php echo $edi['nota_numero_uf']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label class="control-label">Forma Pag.</label>
                                                            <select name="nota_indpag" class="form-control">
                                                                <option value="0" <?= ($edi['nota_indpag'] == '0') ? 'selected' : '' ?>>0-À Vista</option>
                                                                <option value="1" <?= ($edi['nota_indpag'] == '1') ? 'selected' : '' ?>>1-À Prazo</option>
                                                                <option value="2" <?= ($edi['nota_indpag'] == '2') ? 'selected' : '' ?>>2-Outros</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label class="control-label">Cód IBGE</label>
                                                            <input type="text" name="nota_codigo_municipio" class="form-control" value="<?php echo $edi['nota_codigo_municipio']; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="control-label">Municipio de Ocorrencia</label>
                                                        <input type="text" class="form-control" value="<?php echo $edi['municipio_nome']; ?>" disabled="">
                                                    </div>
                                                    <div class='col-md-3'>    

                                                        <label for="user_title">Tipo Frete</label>
                                                        <select id="nota_frete" name="nota_frete" class="form-control">
                                                            <option value="0" <?= ($edi['nota_frete'] == '0') ? 'selected' : '' ?> >0 - Por Conta Emitente</option>
                                                            <option value="1" <?= ($edi['nota_frete'] == '1') ? 'selected' : '' ?> >1 - Por conta do destinatário/remetente</option>
                                                            <option value="2" <?= ($edi['nota_frete'] == '2') ? 'selected' : '' ?> >2 - Por conta de terceiros</option>
                                                            <option value="9" <?= ($edi['nota_frete'] == '9') ? 'selected' : '' ?> >9 - Sem Frete</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Tipo Operação</label>
                                                            <select id="nota_tipo_operacao" name="nota_tipo_operacao" class="form-control">
                                                                <option value="1" <?= ($edi['nota_tipo_operacao'] == '1') ? 'selected' : '' ?> >1- Operação Interna</option>
                                                                <option value="2" <?= ($edi['nota_tipo_operacao'] == '2') ? 'selected' : '' ?> >2 - Operação Interestadual</option>
                                                                <option value="3" <?= ($edi['nota_tipo_operacao'] == '3') ? 'selected' : '' ?> >3 - Operação com Exterior</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="emitente" class="tab-pane">
                                                <div class="form-group">
                                                    <legend class="col-xs-12">Emitente</legend>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label class="control-label">ID</label>
                                                                <input type="text" class="form-control" disabled="" value="<?php echo $dados_emitente['empresa_id'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="form-group">
                                                                <label  class="control-label">Emitente</label>
                                                                <input type="text"  class="form-control" disabled="" value="<?php echo $dados_emitente['empresa_nome'] ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="control-label">CNPJ</label>
                                                                <input type="text" class="form-control" disabled="" value="<?php echo $dados_emitente['empresa_cnpj'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label  class="control-label">I.E.</label>
                                                                <input type="text"  class="form-control" disabled="" value="<?php echo $dados_emitente['empresa_ie'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label  class="control-label">CRT</label>
                                                                <select  class="form-control" disabled="">
                                                                    <option  <?= ($dados_emitente['empresa_crt'] == '1') ? 'selected' : '' ?> >1 - SIMPLES NACIONAL</option>
                                                                    <option <?= ($dados_emitente['empresa_crt'] == '2') ? 'selected' : '' ?> >2 - SIMPLES NACIONAL - excesso de sublimite da receita bruta</option>
                                                                    <option  <?= ($dados_emitente['empresa_crt'] == '3') ? 'selected' : '' ?> >3 - REGIME NORMAL</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="control-label">LOGRADOURO</label>
                                                                <input type="text" class="form-control" disabled="" value="<?php echo $dados_emitente['empresa_logradouro'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="form-group">
                                                                <label  class="control-label">N°</label>
                                                                <input type="text"  class="form-control" disabled="" value="<?php echo $dados_emitente['empresa_numero'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label  class="control-label">COMPL.</label>
                                                                <input type="text"  class="form-control" disabled="" value="<?php echo $dados_emitente['empresa_complemento'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label  class="control-label">BAIRRO</label>
                                                                <input type="text"  class="form-control" disabled="" value="<?php echo $dados_emitente['empresa_bairro'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label  class="control-label">CEP</label>
                                                                <input type="text"  class="form-control" disabled="" value="<?php echo $dados_emitente['empresa_cep'] ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="control-label">MUNICIPIO</label>
                                                                <input type="text" class="form-control" disabled="" value="<?php echo $dados_emitente['municipio_nome'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="form-group">
                                                                <label  class="control-label">UF</label>
                                                                <input type="text"  class="form-control" disabled="" value="<?php echo $dados_emitente['municipio_sigla'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label  class="control-label">Cod IBGE</label>
                                                                <input type="text"  class="form-control" disabled="" value="<?php echo $dados_emitente['municipio_cod_ibge'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label  class="control-label">TEL</label>
                                                                <input type="text"  class="form-control" disabled="" value="<?php echo $dados_emitente['empresa_telefone'] ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="destinatario" class="tab-pane">
                                                <div class="form-group">
                                                    <legend class="col-xs-12">Destinatário</legend>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label class="control-label">ID</label>
                                                                <input type="text" class="form-control" disabled="" value="<?php echo $dados_destinatario['cliente_id'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="form-group">
                                                                <label  class="control-label">DESTINATARIO</label>
                                                                <input type="text"  class="form-control" disabled="" value="<?php echo $dados_destinatario['cliente_nome'] ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">CNPJ</label>
                                                                <input type="text" class="form-control" disabled="" value="<?php echo $dados_destinatario['cliente_cpf_cnpj'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label  class="control-label">I.E.</label>
                                                                <input type="text"  class="form-control" disabled="" value="<?php echo $dados_destinatario['cliente_ie'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label  class="control-label">TIPO</label>
                                                                <select  class="form-control" disabled="">
                                                                    <option  <?= ($dados_destinatario['cliente_tipo'] == '1') ? 'selected' : '' ?> >1 - CONTRIBUINTE</option>
                                                                    <option <?= ($dados_destinatario['cliente_tipo'] == '2') ? 'selected' : '' ?> >2 - CONTRIBUINTE ISENTO DE INSCRIÇÃO</option>
                                                                    <option  <?= ($dados_destinatario['cliente_tipo'] == '9') ? 'selected' : '' ?> >9 - NÃO CONTRIBUINTE</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label  class="control-label">CONS. FINAL</label>
                                                                <select  class="form-control" disabled="">
                                                                    <option  <?= ($dados_destinatario['cliente_consumidor'] == '1') ? 'selected' : '' ?> >1 - SIM</option>
                                                                    <option  <?= ($dados_destinatario['cliente_consumidor'] == '0') ? 'selected' : '' ?> >0 - NÃO</option>

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="control-label">LOGRADOURO</label>
                                                                <input type="text" class="form-control" disabled="" value="<?php echo $dados_destinatario['cliente_logradouro'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="form-group">
                                                                <label  class="control-label">N°</label>
                                                                <input type="text"  class="form-control" disabled="" value="<?php echo $dados_destinatario['cliente_numero'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label  class="control-label">COMPL.</label>
                                                                <input type="text"  class="form-control" disabled="" value="<?php echo $dados_destinatario['cliente_complemento'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label  class="control-label">BAIRRO</label>
                                                                <input type="text"  class="form-control" disabled="" value="<?php echo $dados_destinatario['cliente_bairro'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label  class="control-label">CEP</label>
                                                                <input type="text"  class="form-control" disabled="" value="<?php echo $dados_destinatario['cliente_cep'] ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="control-label">MUNICIPIO</label>
                                                                <input type="text" class="form-control" disabled="" value="<?php echo $dados_destinatario['municipio_nome'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="form-group">
                                                                <label  class="control-label">UF</label>
                                                                <input type="text"  class="form-control" disabled="" value="<?php echo $dados_destinatario['municipio_sigla'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label  class="control-label">Cod IBGE</label>
                                                                <input type="text"  class="form-control" disabled="" value="<?php echo $dados_destinatario['municipio_cod_ibge'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label  class="control-label">TEL</label>
                                                                <input type="text"  class="form-control" disabled="" value="<?php echo $dados_destinatario['cliente_telefone'] ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="produto" class="tab-pane">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <table id="simple-table" class="table table-striped table-responsive table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>ID</th>
                                                                        <th class="hidden-480">Produto</th>
                                                                        <td class="hidden-480">Quantidade</td>
                                                                        <td class="hidden-480">Preço</td>
                                                                        <td class="hidden-480">Total</td>
                                                                        <td class="hidden-480">Configurar</td>
                                                                        <td class="hidden-480">
                                                                        </td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    while ($row = $stmt_produ->fetch(PDO::FETCH_ASSOC)) {
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo $row['nota_itens_id']; ?></td>
                                                                            <td class="hidden-480"><?php echo $row['nota_itens_produto']; ?></td>
                                                                            <td class="hidden-480"><?php echo $row['nota_itens_qtd']; ?></td>                                           
                                                                            <td class="hidden-480"><?php echo $row['nota_itens_valor']; ?></td> 
                                                                            <td class="hidden-480"><?php echo $row['nota_itens_total']; ?></td>
                                                                            <!--<td class="hidden-480">Editar</td>-->
                                                                            <td colspan="2">
                                                                                <button type="button" class="btn btn-xs btn-warning" 

                                                                                        data-toggle="modal" data-target="#exampleModal2" 
                                                                                        data-nota_itens_id="<?php echo $row['nota_itens_id']; ?>"
                                                                                        data-nota_itens_produto="<?php echo $row['nota_itens_produto']; ?>"  
                                                                                        data-nota_itens_valor="<?php echo $row['nota_itens_valor']; ?>"
                                                                                        data-nota_itens_qtd="<?php echo $row['nota_itens_qtd']; ?>"
                                                                                        data-nota_itens_total="<?php echo $row['nota_itens_total']; ?>"
                                                                                        data-nota_itens_id_st="<?php echo $row['nota_itens_id_st']; ?>"
                                                                                        data-nota_itens_id_tes="<?php echo $row['nota_itens_id_tes']; ?>"
                                                                                        data-nota_itens_valor_frete="<?php echo $row['nota_itens_valor_frete']; ?>"
                                                                                        data-nota_itens_valor_seguro="<?php echo $row['nota_itens_valor_seguro']; ?>"
                                                                                        data-nota_itens_valor_desconto="<?php echo $row['nota_itens_valor_desconto']; ?>"
                                                                                        data-nota_itens_outras_despesas="<?php echo $row['nota_itens_outras_despesas']; ?>"
                                                                                        data-nota_itens_idtot="<?php echo $row['nota_itens_idtot']; ?>"
                                                                                        data-nota_itens_numero_compra="<?php echo $row['nota_itens_numero_compra']; ?>"
                                                                                        data-nota_itens_item_compra="<?php echo $row['nota_itens_item_compra']; ?>"
                                                                                        data-nota_itens_numero_nfci="<?php echo $row['nota_itens_numero_nfci']; ?>"
                                                                                        data-nota_itens_descricao="<?php echo $row['nota_itens_descricao']; ?>"
                                                                                        data-nota_itens_ncm="<?php echo $row['nota_itens_ncm']; ?>"
                                                                                        data-nota_itens_cst="<?php echo $row['nota_itens_cst']; ?>"
                                                                                        data-nota_itens_cest="<?php echo $row['nota_itens_cest']; ?>"
                                                                                        data-nota_itens_origem="<?php echo $row['nota_itens_origem']; ?>"
                                                                                        data-nota_itens_modalidade_calculo_icms="<?php echo $row['nota_itens_modalidade_calculo_icms']; ?>"
                                                                                        data-nota_itens_reducao_calculo_icms="<?php echo $row['nota_itens_reducao_calculo_icms']; ?>"
                                                                                        data-nota_itens_base_calculo_icms="<?php echo $row['nota_itens_base_calculo_icms']; ?>"
                                                                                        data-nota_itens_valor_icms_op="<?php echo $row['nota_itens_valor_icms_op']; ?>"
                                                                                        data-nota_itens_perc_dif="<?php echo $row['nota_itens_perc_dif']; ?>"
                                                                                        data-nota_itens_valor_perc_dif="<?php
                                                                                        if ($row['nota_itens_perc_dif'] == 0) {
                                                                                            echo "0.00";
                                                                                        } else {
                                                                                            echo ($row['nota_itens_valor_icms_op'] * $row['nota_itens_perc_dif']) / 100;
                                                                                        }
                                                                                        ?>"
                                                                                        data-nota_itens_aliquota="<?php echo $row['nota_itens_aliquota']; ?>"
                                                                                        data-nota_itens_valor_icms="<?php echo $row['nota_itens_valor_icms']; ?>"

                                                                                        data-nota_itens_st_comportamento="<?php echo $row['nota_itens_st_comportamento']; ?>"
                                                                                        data-nota_itens_st_modalidade_calculo="<?php echo $row['nota_itens_st_modalidade_calculo']; ?>"
                                                                                        data-nota_itens_st_mva="<?php echo $row['nota_itens_st_mva']; ?>"
                                                                                        data-nota_itens_st_reducao_calculo="<?php echo $row['nota_itens_st_reducao_calculo']; ?>"
                                                                                        data-nota_itens_st_aliquota="<?php echo $row['nota_itens_st_aliquota']; ?>"
                                                                                        data-nota_itens_st_valor="<?php echo $row['nota_itens_st_valor']; ?>"

                                                                                        data-nota_itens_par_pobreza="<?php echo $row['nota_itens_par_pobreza']; ?>"
                                                                                        data-nota_itens_par_destino="<?php echo $row['nota_itens_par_destino']; ?>"
                                                                                        data-nota_itens_par_origem="<?php echo $row['nota_itens_par_origem']; ?>"
                                                                                        data-nota_itens_mensagem_nfe="<?php echo $row['nota_itens_mensagem_nfe']; ?>"

                                                                                        data-nota_itens_id_ipi="<?php echo $row['nota_itens_id_ipi']; ?>"
                                                                                        data-nota_itens_ipi_classe="<?php echo $row['nota_itens_ipi_classe']; ?>"
                                                                                        data-nota_itens_ipi_cod="<?php echo $row['nota_itens_ipi_cod']; ?>"
                                                                                        data-nota_itens_ipi_tipo_calculo="<?php echo $row['nota_itens_ipi_calculo']; ?>"
                                                                                        data-nota_itens_ipi_aliquota="<?php echo $row['nota_itens_ipi_aliquota']; ?>"

                                                                                        data-nota_itens_id_pis="<?php echo $row['nota_itens_id_pis']; ?>"
                                                                                        data-nota_itens_pis_tipo_calculo="<?php echo $row['nota_itens_pis_tipo_calculo']; ?>"
                                                                                        data-nota_itens_pis_base_calculo="<?php echo $row['nota_itens_pis_base_calculo']; ?>"
                                                                                        data-nota_itens_pis_aliquota="<?php echo $row['nota_itens_pis_aliquota']; ?>"
                                                                                        data-nota_itens_pis_valor="<?php echo $row['nota_itens_pis_valor']; ?>"
                                                                                        data-nota_itens_pis_st_tipo_calculo="<?php echo $row['nota_itens_pis_st_tipo_calculo']; ?>"
                                                                                        data-nota_itens_pis_st_aliquota="<?php echo $row['nota_itens_pis_st_aliquota']; ?>"

                                                                                        data-nota_itens_id_cofins="<?php echo $row['nota_itens_id_cofins']; ?>"
                                                                                        data-nota_itens_cofins_tipo_calculo="<?php echo $row['nota_itens_cofins_tipo_calculo']; ?>"
                                                                                        data-nota_itens_cofins_base_calculo="<?php echo $row['nota_itens_cofins_base_calculo']; ?>"
                                                                                        data-nota_itens_cofins_aliquota="<?php echo $row['nota_itens_cofins_aliquota']; ?>"
                                                                                        data-nota_itens_cofins_valor="<?php echo $row['nota_itens_cofins_valor']; ?>"

                                                                                        data-nota_itens_aliquota_cred_icms="<?php echo $row['nota_itens_aliquota_cred_icms']; ?>"
                                                                                        data-nota_itens_valor_cred_icms="<?php echo $row['nota_itens_valor_cred_icms']; ?>"


                                                                                        >Editar/Consultar</button>

                                                                                <?php
                                                                                if ($edi['nota_status'] < 4) {
                                                                                    ?>
                                                                                    <button class="btn btn-xs btn-danger" name="btn-apaga" type="submit">
                                                                                        <i class="ace-icon fa fa-ban bigger-80 blue"></i>
                                                                                        <input type="hidden" name="nota_itens_id" value="<?php echo $row['nota_itens_id']; ?>">
                                                                                        Excluir
                                                                                    </button>
                                                                                    <?php
                                                                                }
                                                                                ?>


                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="4" class="hidden-480">
                                                                            Sub-Total
                                                                        </td>
                                                                        <td colspan="2"><?php echo $tot['SUM(nota_itens_total)'] ?></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>


                                                        </div><!-- /.span -->
                                                    </div><!-- /.row -->
                                                </div>

                                            </div>

                                            <div id="totais" class="tab-pane">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <legend>Totais</legend>
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">B.C. ICMS</label>
                                                                        <input type="text" name="nota_itens_bc_icms" class="form-control" value="<?php echo $total['SUM(nota_itens_bc_icms)']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Valor ICMS</label>
                                                                        <input type="text" name="nota_itens_valor_icms" class="form-control" value="<?php echo $total['SUM(nota_itens_valor_icms)']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">B.C. ICMS-ST</label>
                                                                        <input type="text" name="nota_itens_st_bc" class="form-control" value="<?php echo $total['SUM(nota_itens_st_bc)']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Valor ICMS-ST</label>
                                                                        <input type="text" name="nota_itens_st_valor" class="form-control" value="<?php echo $total['SUM(nota_itens_st_valor)']; ?>">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">T. dos Produtos</label>
                                                                        <input type="text" name="nota_itens_total" class="form-control" value="<?php echo $total['SUM(nota_itens_total)']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">V. do Frete</label>
                                                                        <input type="text" name="nota_itens_valor_frete" class="form-control" value="<?php echo $total['SUM(nota_itens_valor_frete)']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">V. do Seguro</label>
                                                                        <input type="text" name="nota_itens_valor_seguro" class="form-control" value="<?php echo $total['SUM(nota_itens_valor_seguro)']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">V. do Desconto</label>
                                                                        <input type="text" name="nota_itens_valor_desconto" class="form-control" value="<?php echo $total['SUM(nota_itens_valor_desconto)']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">O. Despesas</label>
                                                                        <input type="text" name="nota_itens_outras_despesas" class="form-control" value="<?php echo $total['SUM(nota_itens_outras_despesas)']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">V. do IPI</label>
                                                                        <input type="text" name="nota_itens_ipi_valor" class="form-control" value="<?php echo $total['SUM(nota_itens_ipi_valor)']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">V. do PIS</label>
                                                                        <input type="text" name="nota_itens_pis_valor" class="form-control" value="<?php echo $total['SUM(nota_itens_pis_valor)']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">V. do COFINS</label>
                                                                        <input type="text" name="nota_itens_cofins_valor" class="form-control" value="<?php echo $total['SUM(nota_itens_cofins_valor)']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">V. ICMS Des.</label>
                                                                        <input type="text" name="nota_itens_icms_des_valor" class="form-control" value="<?php echo $total['SUM(nota_itens_icms_des_valor)']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Valor II</label>
                                                                        <input type="text" name="nota_itens_icmsII_valor" class="form-control" value="<?php echo $total['SUM(nota_itens_icmsII_valor)']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">FCP</label>
                                                                        <input type="text" name="nota_itens_par_pobreza_valor" class="form-control" value="<?php echo $total['SUM(nota_itens_par_pobreza_valor)']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">V.ICMS UF DEST.</label>
                                                                        <input type="text" name="nota_itens_par_destino_valor" class="form-control" value="<?php echo $total['SUM(nota_itens_par_destino_valor)']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">V.ICMS UF REM.</label>
                                                                        <input type="text" name="nota_itens_par_origem_valor" class="form-control" value="<?php echo $total['SUM(nota_itens_par_origem_valor)']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Total NF-e</label>
                                                                        <input type="text" name="nota_total_nfe" class="form-control" value="<?php
                                                                        echo number_format($total['SUM(nota_itens_total)'] - $total['SUM(nota_itens_valor_desconto)'] - $total['SUM(nota_itens_icms_des_valor)'] +
                                                                                $total['SUM(nota_itens_st_valor)'] + $total['SUM(nota_itens_valor_frete)'] + $total['SUM(nota_itens_valor_seguro)'] +
                                                                                $total['SUM(nota_itens_valor_frete)'] + $total['SUM(nota_itens_outras_despesas)'] + $total['SUM(nota_itens_icmsII_valor)'] +
                                                                                $total['SUM(nota_itens_ipi_valor)'], 2, '.', '');
                                                                        ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">

                                                                        <label class="control-label">Total Tributos</label>
                                                                        <input type="text" name="nota_total_nfe" class="form-control" value="<?php
                                                                        echo number_format($total['SUM(nota_itens_valor_icms)'] + $total['SUM(nota_itens_st_valor)'] +
                                                                                $total['SUM(nota_itens_icmsII_valor)'] + $total['SUM(nota_itens_ipi_valor)'] +
                                                                                $total['SUM(nota_itens_pis_valor)'] + $total['SUM(nota_itens_cofins_valor)'] +
                                                                                $total['SUM(nota_itens_iof_valor)'] + $total['SUM(nota_itens_viss_valor)'], 2, '.', '');
                                                                        ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <legend>Aprov. ICMS</legend>
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Ali. Aprov. ICMS</label>
                                                                        <input type="text" name="nota_itens_aliquota_cred_icms" class="form-control" value="<?php echo $total['nota_itens_aliquota_cred_icms']; ?>">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Valor Cred. ICMS</label>
                                                                        <input type="text" name="nota_itens_valor_cred_icms" class="form-control" value="<?php echo $total['SUM(nota_itens_valor_cred_icms)']; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="transportador" class="tab-pane">

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <legend>Transportador</legend>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Transportador</label>
    <!--                                                                    <input type="text" name="nota_nome_transportador" class="form-control">-->
                                                                        <select name="nota_id_tranportador" class="form-control">
                                                                            <option value="0" selected="" class="form-control">...::****::...</option>
                                                                            <?php
                                                                            while ($row2 = $stmt_tranota->fetch(PDO::FETCH_ASSOC)) {


                                                                                if ($row2['transportador_id'] == $edi['nota_id_transportador']) {
                                                                                    ?>
                                                                                    <option selected="" value="<?php echo $row2['transportador_id'] ?>"><?php echo $row2['transportador_nome'] . " ==> " . $row2['transportador_cnpj'] ?></option> 
                                                                                    <?php
                                                                                } else {
                                                                                    ?>
                                                                                    <option value="<?php echo $row2['transportador_id'] ?>"><?php echo $row2['transportador_nome'] . " ==> " . $row2['transportador_cnpj'] ?></option> 
                                                                                    <?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>

                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label">CPF/CNPJ</label>
                                                                        <input type="text" name="nota_cnpjcpf_transportador" class="form-control" value="<?php echo $edi['nota_cnpjcpf_transportador']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label">I.E.</label>
                                                                        <input type="text" name="nota_inscricao_transportador" class="form-control" value="<?php echo $edi['nota_inscricao_transportador']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Endereço Transportador</label>
                                                                        <input type="text" name="nota_endereco_transportador" class="form-control" value="<?php echo $edi['nota_endereco_transportador']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Municipio Tra.</label>
                                                                        <input type="text" name="nota_municipio_transportador" class="form-control" value="<?php echo $edi['nota_municipio_transportador']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label">UF Tra.</label>
                                                                        <input type="text" name="nota_uf_transportador" class="form-control" value="<?php echo $edi['nota_uf_transportador']; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <legend>Retenção ICMS</legend>
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Valor Serviço</label>
                                                                        <input type="text" name="nota_valor_ser_transportador" class="form-control" value="<?php echo $edi['nota_valor_ser_transportador']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">B.C. ICMS</label>
                                                                        <input type="text" name="nota_base_calculo_transportador" class="form-control" value="<?php echo $edi['nota_base_calculo_transportador']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">CFOP</label>
                                                                        <input type="text" name="nota_cfop_transportador" class="form-control" value="<?php echo $edi['nota_cfop_transportador']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Aliquota</label>
                                                                        <input type="text" name="nota_aliquota_transportador" class="form-control" value="<?php echo $edi['nota_aliquota_transportador']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Valor ICMS</label>
                                                                        <input type="text" name="nota_valor_icms_transportador" class="form-control" value="<?php echo $edi['nota_valor_icms_transportador']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Municipio</label>
                                                                        <input type="text" name="nota_cod_municipio_transportador" class="form-control" value="<?php echo $edi['nota_cod_municipio_transportador']; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <legend>Veiculo</legend>
                                                            <div class="col-xs-12">
                                                                <div class="row">

                                                                    <table class="table table-bordered table-responsive">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>ID</th>
                                                                                <th class="hidden-480">N° Nota</th>
                                                                                <th class="hidden-480">T. Veiculo</th>
                                                                                <th class="hidden-480">Placa</th>
                                                                                <th class="hidden-480">UF</th>
                                                                                <th class="hidden-480">RNTC</th>
                                                                                <th class="hidden-480">Configurar</th>

                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            while ($vei = $stmt_veiculo->fetch(PDO::FETCH_ASSOC)) {
                                                                                ?>
                                                                                <tr>

                                                                                    <th><?php echo $vei['nota_veiculo_id']; ?></th>
                                                                                    <th class="hidden-480"><?php echo $vei['id_nota']; ?></th>
                                                                                    <th class="hidden-480"><?php echo $vei['nota_veiculo_tipo']; ?></th>
                                                                                    <th class="hidden-480"><?php echo $vei['nota_veiculo_placa']; ?></th>
                                                                                    <th class="hidden-480"><?php echo $vei['nota_veiculo_uf']; ?></th>
                                                                                    <th class="hidden-480"><?php echo $vei['nota_veiculo_rntc']; ?></th>
                                                                                    <th class="hidden-480">



                                                                                        <button type="button" class="btn btn-xs btn-warning" 
                                                                                                data-toggle="modal" data-target="#veiculoeditar" 
                                                                                                data-nota_veiculo_id="<?php echo $vei['nota_veiculo_id']; ?>"
                                                                                                data-nota_veiculo_tipo="<?php echo $vei['nota_veiculo_tipo']; ?>"
                                                                                                data-nota_veiculo_placa="<?php echo $vei['nota_veiculo_placa']; ?>"
                                                                                                data-nota_veiculo_uf="<?php echo $vei['nota_veiculo_uf']; ?>"
                                                                                                data-nota_veiculo_rntc="<?php echo $vei['nota_veiculo_rntc']; ?>"
                                                                                                >Editar/Cons.</button>

                                                                                        <?php
                                                                                        if ($edi['nota_status'] < 4) {
                                                                                            ?>

                                                                                            <button type="button" class="btn btn-xs btn-danger" 
                                                                                                    data-toggle="modal" data-target="#veiculoexcluir" 
                                                                                                    data-nota_veiculo_id="<?php echo $vei['nota_veiculo_id']; ?>"

                                                                                                    >Excluir</button>
                                                                                                    <?php
                                                                                                }
                                                                                                ?>

                                                                                    </th>
                                                                                </tr>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>

                                                                </div>
                                                            </div>
                                                            <?php
                                                            if ($edi['nota_status'] < 4) {
                                                                ?>
                                                                <button type="button" class="btn btn-xs btn-success" 
                                                                        data-toggle="modal" data-target="#novoveiculo" 
                                                                        data-nota_itens_id="<?php echo $edi['id_nota_id']; ?>">

                                                                    Novo
                                                                </button>
                                                                <?php
                                                            }
                                                            ?>
                                                            <legend>Volumes</legend>
                                                            <div class="col-xs-12">
                                                                <div class="row">

                                                                    <table class="table table-bordered table-responsive">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>ID</th>
                                                                                <th class="hidden-480">N° Nota</th>
                                                                                <th class="hidden-480">Qtd.</th>
                                                                                <th class="hidden-480">Espécie</th>
                                                                                <th class="hidden-480">Peso Bruto</th>
                                                                                <th class="hidden-480">Peso Liquido</th>
                                                                                <th class="hidden-480">Marca</th>
                                                                                <th class="hidden-480">N° Volume</th>
                                                                                <th class="hidden-480">Lacre</th>
                                                                                <th class="hidden-480">Configurar</th>

                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            while ($vol = $stmt_volume->fetch(PDO::FETCH_ASSOC)) {
                                                                                ?>
                                                                                <tr>

                                                                                    <th><?php echo $vol['nota_volume_id']; ?></th>
                                                                                    <th class="hidden-480"><?php echo $vol['id_nota']; ?></th>
                                                                                    <th class="hidden-480"><?php echo $vol['nota_volume_qtd']; ?></th>
                                                                                    <th class="hidden-480"><?php echo $vol['nota_volume_especie']; ?></th>
                                                                                    <th class="hidden-480"><?php echo $vol['nota_volume_peso_bruto']; ?></th>
                                                                                    <th class="hidden-480"><?php echo $vol['nota_volume_peso_liquido']; ?></th>
                                                                                    <th class="hidden-480"><?php echo $vol['nota_volume_marca']; ?></th>
                                                                                    <th class="hidden-480"><?php echo $vol['nota_volume_numero_volume']; ?></th>
                                                                                    <th class="hidden-480"><?php echo $vol['nota_volume_lacre']; ?></th>
                                                                                    <th class="hidden-480">
                                                                                        <button type="button" class="btn btn-xs btn-warning" 
                                                                                                data-toggle="modal" data-target="#volumeeditar" 
                                                                                                data-nota_volume_id="<?php echo $vol['nota_volume_id']; ?>"
                                                                                                data-nota_volume_qtd="<?php echo $vol['nota_volume_qtd']; ?>"
                                                                                                data-nota_volume_especie="<?php echo $vol['nota_volume_especie']; ?>"
                                                                                                data-nota_volume_peso_bruto="<?php echo $vol['nota_volume_peso_bruto']; ?>"
                                                                                                data-nota_volume_peso_liquido="<?php echo $vol['nota_volume_peso_liquido']; ?>"
                                                                                                data-nota_volume_marca="<?php echo $vol['nota_volume_marca']; ?>"
                                                                                                data-nota_volume_numero_volume="<?php echo $vol['nota_volume_numero_volume']; ?>"
                                                                                                data-nota_volume_lacre="<?php echo $vol['nota_volume_lacre']; ?>"

                                                                                                >Editar/Cons.</button>

                                                                                        <?php
                                                                                        if ($edi['nota_status'] < 4) {
                                                                                            ?>

                                                                                            <button type="button" class="btn btn-xs btn-danger" 
                                                                                                    data-toggle="modal" data-target="#volumeexcluir" 
                                                                                                    data-nota_volume_id="<?php echo $vol['nota_volume_id']; ?>"

                                                                                                    >Excluir</button>
                                                                                                    <?php
                                                                                                }
                                                                                                ?>

                                                                                    </th>

                                                                                </tr>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>




                                                                </div>
                                                            </div>
                                                            <?php
                                                            if ($edi['nota_status'] < 4) {
                                                                ?>
                                                                <button type="button" class="btn btn-xs btn-success" 

                                                                        data-toggle="modal" data-target="#novovolume" 
                                                                        data-nota_itens_id="<?php echo $edi['id_nota_id']; ?>">

                                                                    Novo
                                                                </button>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="tributos" class="tab-pane">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <legend>TRIBUTOS</legend>
                                                            <div class="col-xs-12">
                                                                <div class="row">

                                                                    <table class="table table-bordered table-responsive">
                                                                        <thead>
                                                                            <tr>

                                                                                <th class="hidden-480">CFOP</th>
                                                                                <th class="hidden-480">Tributo</th>
                                                                                <th class="hidden-480">B.C</th>
                                                                                <th class="hidden-480">Aliquota</th>
                                                                                <th class="hidden-480">Val. ICMS</th>


                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            while ($trib = $stmt_tributos->fetch(PDO::FETCH_ASSOC)) {
                                                                                ?>
                                                                                <tr>

                                                                                    <th><?php echo $trib['cfops']; ?></th>

                                                                                    <th class="hidden-480"><?php echo "ICMS" ?></th>
                                                                                    <th class="hidden-480"><?php echo $trib['bc_icms']; ?></th>
                                                                                    <th class="hidden-480"><?php echo $trib['aliquota_icms']; ?></th>
                                                                                    <th class="hidden-480"><?php echo $trib['valor_icms']; ?></th>


                                                                                </tr>
                                                                                <tr>

                                                                                    <th><?php echo $trib['cfops']; ?></th>

                                                                                    <th class="hidden-480"><?php echo "IPI"; ?></th>
                                                                                    <th class="hidden-480"><?php ?></th>
                                                                                    <th class="hidden-480"><?php echo $trib['aliquotaipi']; ?></th>
                                                                                    <th class="hidden-480"><?php echo $trib['valoripi']; ?></th>


                                                                                </tr>
                                                                                <tr>

                                                                                    <th><?php echo $trib['cfops']; ?></th>

                                                                                    <th class="hidden-480"><?php echo "PIS"; ?></th>
                                                                                    <th class="hidden-480"><?php echo $trib['bc_pis']; ?></th>
                                                                                    <th class="hidden-480"><?php echo $trib['aliquotapis']; ?></th>
                                                                                    <th class="hidden-480"><?php echo $trib['valorpis']; ?></th>


                                                                                </tr>
                                                                                <tr>

                                                                                    <th><?php echo $trib['cfops']; ?></th>

                                                                                    <th class="hidden-480"><?php echo "COFINS"; ?></th>
                                                                                    <th class="hidden-480"><?php ?></th>
                                                                                    <th class="hidden-480"><?php echo $trib['aliquotacofins']; ?></th>
                                                                                    <th class="hidden-480"><?php echo $trib['valorcofins']; ?></th>


                                                                                </tr>
                                                                                <tr>
                                                                                    <th colspan="6"></th>
                                                                                </tr>
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
                                            </div>

                                            <div id="info" class="tab-pane">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <legend>INF. COMPLEMENTARES</legend>
                                                            <div class="col-xs-12">
                                                                <div class="row">

                                                                    <table class="table table-bordered table-responsive">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>ID</th>
                                                                                <th class="hidden-480">N° Nota</th>
                                                                                <th class="hidden-480">Apelido</th>
                                                                                <th class="hidden-480">Descricao Resumida</th>
                                                                                <th class="hidden-480 center" colspan="2">Configurar</th>

                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            while ($inf = $stmt_inf_comp->fetch(PDO::FETCH_ASSOC)) {
                                                                                ?>
                                                                                <tr>

                                                                                    <th><?php echo $inf['nota_inf_comp_id']; ?></th>
                                                                                    <th class="hidden-480"><?php echo $inf['id_nota']; ?></th>
                                                                                    <th class="hidden-480"><?php echo $inf['nota_inf_comp_apelido']; ?></th>
                                                                                    <th class="hidden-480"><?php echo $inf['nota_inf_comp_descricao']; ?></th>

                                                                                    <th class="hidden-480">
                                                                                        <button type="button" class="btn btn-xs btn-warning" 
                                                                                                data-toggle="modal" data-target="#inf_comp_editar" 
                                                                                                data-nota_inf_comp_id="<?php echo $inf['nota_inf_comp_id']; ?>"
                                                                                                data-nota_inf_comp_apelido="<?php echo $inf['nota_inf_comp_apelido']; ?>"
                                                                                                data-nota_inf_comp_descricao="<?php echo $inf['nota_inf_comp_descricao']; ?>"
                                                                                                data-nota_inf_comp_complemento="<?php echo $inf['nota_inf_comp_complemento']; ?>"

                                                                                                >Editar</button>



                                                                                    </th>
                                                                                    <th class="hidden-480">
                                                                                        <?php
                                                                                        if ($edi['nota_status'] < 4) {
                                                                                            ?>
                                                                                            <button type="button" class="btn btn-xs btn-danger" 
                                                                                                    data-toggle="modal" data-target="#inf_comp_excluir" 
                                                                                                    data-nota_inf_comp_id="<?php echo $inf['nota_inf_comp_id']; ?>"
                                                                                                    >Excluir</button>
                                                                                                    <?php
                                                                                                }
                                                                                                ?>
                                                                                    </th>
                                                                                </tr>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>

                                                                </div>
                                                            </div>
                                                            <?php
                                                            if ($edi['nota_status'] < 4) {
                                                                ?>
                                                                <button type="button" class="btn btn-xs btn-success" 
                                                                        data-toggle="modal" data-target="#novoinf_comp" 
                                                                        data-nota_itens_id="<?php echo $edi['id_nota_id']; ?>">

                                                                    Novo
                                                                </button>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="outras" class="tab-pane">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <legend>Notas Referenciadas</legend>
                                                            <div class="col-xs-12">
                                                                <div class="row">

                                                                    <table class="table table-bordered table-responsive">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>ID</th>
                                                                                <th class="hidden-480">N° Nota</th>
                                                                                <th class="hidden-480">Chave</th>
                                                                                <th class="hidden-480">Modelo</th>
                                                                                <th class="hidden-480">Data</th>


                                                                                <th class="hidden-480 center" colspan="2">Configurar</th>

                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            while ($ref = $stmt_referencia->fetch(PDO::FETCH_ASSOC)) {
                                                                                ?>
                                                                                <tr>

                                                                                    <th><?php echo $ref['nota_referencia_id']; ?></th>
                                                                                    <th class="hidden-480"><?php echo $ref['id_nota']; ?></th>
                                                                                    <th class="hidden-480"><?php echo $ref['nota_referencia_chave']; ?></th>
                                                                                    <th class="hidden-480"><?php echo $ref['nota_referencia_modelo']; ?></th>
                                                                                    <th class="hidden-480"><?php echo $ref['nota_referencia_data']; ?></th>


                                                                                    <th class="hidden-480">
                                                                                        <button type="button" class="btn btn-xs btn-warning" 
                                                                                                data-toggle="modal" data-target="#editarreferencia" 
                                                                                                data-nota_referencia_id="<?php echo $ref['nota_referencia_id']; ?>"
                                                                                                data-nota_referencia_chave="<?php echo $ref['nota_referencia_chave']; ?>"
                                                                                                data-nota_referencia_cod_uf="<?php echo $ref['nota_referencia_cod_uf']; ?>"
                                                                                                data-nota_referencia_data="<?php echo $ref['nota_referencia_data']; ?>"
                                                                                                data-nota_referencia_cnpj="<?php echo $ref['nota_referencia_cnpj']; ?>"
                                                                                                data-nota_referencia_modelo="<?php echo $ref['nota_referencia_modelo']; ?>"
                                                                                                data-nota_referencia_serie="<?php echo $ref['nota_referencia_serie']; ?>"
                                                                                                data-nota_referencia_numero_nfe="<?php echo $ref['nota_referencia_numero_nfe']; ?>"

                                                                                                >Editar</button>



                                                                                    </th>
                                                                                    <th class="hidden-480">
                                                                                        <?php
                                                                                        if ($edi['nota_status'] < 4) {
                                                                                            ?>
                                                                                            <button type="button" class="btn btn-xs btn-danger" 
                                                                                                    data-toggle="modal" data-target="#excluirreferencia" 
                                                                                                    data-nota_referencia_id="<?php echo $ref['nota_referencia_id']; ?>"

                                                                                                    >Excluir</button>
                                                                                                    <?php
                                                                                                }
                                                                                                ?>
                                                                                    </th>
                                                                                </tr>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>

                                                                </div>
                                                            </div>
                                                            <?php
                                                            if ($edi['nota_status'] < 4) {
                                                                ?>
                                                                <button type="button" class="btn btn-xs btn-success" 
                                                                        data-toggle="modal" data-target="#novareferencia" 
                                                                        data-nota_itens_id="<?php echo $edi['id_nota_id']; ?>">

                                                                    Novo
                                                                </button>
                                                                <?php
                                                            }
                                                            ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.span -->
                            </div><!-- /.row -->
                            <?php
                            if ($edi['nota_status'] == 3) {
                                ?>
                                <div class="modal-footer">
                                    <button type="submit" name="btn-edita-nfe" class="btn btn-warning btn-xs">Alterar</button>
                                </div>
                                <?php
                            }
                            ?>
                        </form>
                        <!-- PAGE CONTENT ENDS -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.page-content -->
        </div>
    </div><!-- /.main-content -->
</div>

<!--CADASTRA UM NOVA REFERENCIA DA NFE-->
<div class="modal fade" id="novareferencia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Referencia</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <legend>Nota Referenciada</legend>
                    <div class="row">


                        <div class="col-md-7">
                            <div class="form-group">
                                <label  class="control-label">Chave</label>
<!--                                <textarea name="nota_inf_comp_complemento" class="form-control"></textarea>-->
                                <input name="nota_referencia_chave" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label  class="control-label">UF</label>
                                <select name="nota_referencia_cod_uf" class="form-control">
                                    <option value="12">AC</option>
                                    <option value="27">AL</option>
                                    <option value="13">AM</option>
                                    <option value="16">AP</option>
                                    <option value="29">BA</option>
                                    <option value="23">CE</option>
                                    <option value="53">DF</option>
                                    <option value="32">ES</option>
                                    <option value="52">GO</option>
                                    <option value="21">MA</option>
                                    <option value="31">MG</option>
                                    <option value="50">MS</option>
                                    <option value="51">MT</option>
                                    <option value="15">PA</option>
                                    <option value="25">PB</option>
                                    <option value="26">PE</option>
                                    <option value="22">PI</option>
                                    <option value="41">PR</option>
                                    <option value="33">RJ</option>
                                    <option value="24">RN</option>
                                    <option value="11">RO</option>
                                    <option value="14">RR</option>
                                    <option value="43">RS</option>
                                    <option value="42" selected="" >SC</option>
                                    <option value="28">SE</option>
                                    <option value="35">SP</option>
                                    <option value="17">TO</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label  class="control-label">Data</label>
                                <input name="nota_referencia_data" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label  class="control-label">CNPJ</label>
                                <input name="nota_referencia_cnpj" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label  class="control-label">Modelo</label>
                                <input name="nota_referencia_modelo" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label  class="control-label">Serie</label>
                                <input name="nota_referencia_serie" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label  class="control-label">N° Nfe</label>
                                <input name="nota_referencia_numero_nfe" type="text" class="form-control">
                            </div>
                        </div>


                    </div>
                    <input name="id_nota" type="hidden" value="<?php echo $edi['id_nota_id']; ?>">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-xs" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-cadastra_ref" class="btn btn-success btn-xs">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--EDITAR UM NOVA REFERENCIA DA NFE-->
<div class="modal fade" id="editarreferencia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Referencia</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <legend>Nota Referenciada</legend>
                    <div class="row">


                        <div class="col-md-7">
                            <div class="form-group">
                                <label  class="control-label">Chave</label>
                                <input name="nota_referencia_chave" type="text" class="form-control" id="nota_referencia_chave">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label  class="control-label">UF</label>
                                <select name="nota_referencia_cod_uf" class="form-control" id="nota_referencia_cod_uf">
                                    <option value="12">AC</option>
                                    <option value="27">AL</option>
                                    <option value="13">AM</option>
                                    <option value="16">AP</option>
                                    <option value="29">BA</option>
                                    <option value="23">CE</option>
                                    <option value="53">DF</option>
                                    <option value="32">ES</option>
                                    <option value="52">GO</option>
                                    <option value="21">MA</option>
                                    <option value="31">MG</option>
                                    <option value="50">MS</option>
                                    <option value="51">MT</option>
                                    <option value="15">PA</option>
                                    <option value="25">PB</option>
                                    <option value="26">PE</option>
                                    <option value="22">PI</option>
                                    <option value="41">PR</option>
                                    <option value="33">RJ</option>
                                    <option value="24">RN</option>
                                    <option value="11">RO</option>
                                    <option value="14">RR</option>
                                    <option value="43">RS</option>
                                    <option value="42">SC</option>
                                    <option value="28">SE</option>
                                    <option value="35">SP</option>
                                    <option value="17">TO</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label  class="control-label">Data</label>
                                <input name="nota_referencia_data" type="text" class="form-control" id="nota_referencia_data">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label  class="control-label">CNPJ</label>
                                <input name="nota_referencia_cnpj" type="text" class="form-control" id="nota_referencia_cnpj">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label  class="control-label">Modelo</label>
                                <input name="nota_referencia_modelo" type="text" class="form-control" id="nota_referencia_modelo">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label  class="control-label">Serie</label>
                                <input name="nota_referencia_serie" type="text" class="form-control" id="nota_referencia_serie">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label  class="control-label">N° Nfe</label>
                                <input name="nota_referencia_numero_nfe" type="text" class="form-control" id="nota_referencia_numero_nfe">
                            </div>
                        </div>


                    </div>
                    <input name="nota_referencia_id" type="hidden" id="nota_referencia_id">
                    <div class="modal-footer">
                        <?php
                        if ($edi['nota_status'] < 4) {
                            ?>
                            <button type="button" class="btn btn-primary btn-xs" data-dismiss="modal">Cancelar</button>
                            <button type="submit" name="btn-alterareferencia" class="btn btn-warning btn-xs">Alterar</button>
                            <?php
                        }
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--EXCLUIR REFERENCIA DA NFE-->
<div class="modal fade" id="excluirreferencia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Excluir Referencia</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <legend>Excluir Referencia</legend>

                    <input type="hidden" name="nota_referencia_id" class="form-control" id="nota_referencia_id">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-xs" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-excluirreferencia" class="btn btn-danger btn-xs">Excluir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!--EXCLUIR INF COMP DA NFE-->
<div class="modal fade" id="inf_comp_excluir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Excluir INF. COMPL.</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <legend>INF. COMPLEMENTAR</legend>

                    <input type="hidden" name="nota_inf_comp_id" class="form-control" id="nota_inf_comp_id">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-xs" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-excluir_inf" class="btn btn-danger btn-xs">Excluir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--EDITAR INF COMP DA NFE-->
<div class="modal fade" id="inf_comp_editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">INF. COMPLEMENTARES</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <legend>INF. COMP.</legend>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Apelido</label>
                                <input type="text" name="nota_inf_comp_apelido" class="form-control" id="nota_inf_comp_apelido">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="control-label">Descrição</label>
                                <input type="text" name="nota_inf_comp_descricao" class="form-control" id="nota_inf_comp_descricao">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label  class="control-label">Complemento</label>
                                <textarea name="nota_inf_comp_complemento" id="nota_inf_comp_complemento" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="nota_inf_comp_id" class="form-control" id="nota_inf_comp_id">
                    <div class="modal-footer">
                        <?php
                        if ($edi['nota_status'] < 4) {
                            ?>
                            <button type="button" class="btn btn-primary btn-xs" data-dismiss="modal">Cancelar</button>
                            <button type="submit" name="btn-altera_inf" class="btn btn-warning btn-xs">Alterar</button>
                            <?php
                        }
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--CADASTRA UM NOVA INF COMP-->
<div class="modal fade" id="novoinf_comp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Novo INF. COMP.</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <legend>INFORMAÇÕES COMPLEMETARES</legend>
                    <div class="row">

                        <div class="col-md-12">
                            <select name="nota_inf_busca_id" class="form-control" >
                                <?php
                                while ($infor = $stmt_inf->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <option value="<?php echo $infor['inf_comp_id'] ?>"><?php echo $infor['inf_comp_descricao_resumida'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div> 
                        <div class="col-md-12">
                            <div class="form-group">
                                <label  class="control-label">Descrição</label>
                                <textarea name="nota_inf_comp_complemento" class="form-control"></textarea>
                            </div>
                        </div>

                    </div>
                    <input name="id_nota" type="hidden" value="<?php echo $edi['id_nota_id']; ?>">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-xs" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-cadastra_inf" class="btn btn-success btn-xs">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!--EXCLUIR VEICULO DA NFE-->
<div class="modal fade" id="veiculoexcluir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Excluir Veiculo</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <legend>Veiculos</legend>

                    <input type="hidden" name="nota_veiculo_id" class="form-control" id="nota_veiculo_id">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-xs" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-excluir_veiculo" class="btn btn-danger btn-xs">Excluir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--EDITAR VEICULO DA NFE-->
<div class="modal fade" id="veiculoeditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Editar veiculo</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <legend>Veiculos</legend>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Tipo</label>
<!--                                <input type="text" name="nota_tipo_veiculo_transportador" class="form-control" value="<?php echo $edi['nota_tipo_veiculo_transportador']; ?>">-->
                                <select name="nota_veiculo_tipo" class="form-control" id="nota_veiculo_tipo">
                                    <option value="1">Reboque</option>
                                    <option value="2">Caminhão</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Placa</label>
                                <input type="text" name="nota_veiculo_placa" class="form-control" id="nota_veiculo_placa">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Placa UF</label>
                                <input type="text" name="nota_veiculo_uf" class="form-control" id="nota_veiculo_uf">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">RNTC</label>
                                <input type="text" name="nota_veiculo_rntc" class="form-control" id="nota_veiculo_rntc">
                            </div>
                        </div>  
                    </div>

                    <input type="hidden" name="nota_veiculo_id" class="form-control" id="nota_veiculo_id">


                    <div class="modal-footer">
                        <?php
                        if ($edi['nota_status'] < 4) {
                            ?>

                            <button type="button" class="btn btn-primary btn-xs" data-dismiss="modal">Cancelar</button>
                            <button type="submit" name="btn-altera_veiculo" class="btn btn-warning btn-xs">Alterar</button>
                            <?php
                        }
                        ?>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<!--CADASTRA UM NOVO VEICULO-->
<div class="modal fade" id="novoveiculo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Novo Veiculo</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <legend>Produto/Serviços</legend>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Tipo</label>
<!--                                <input type="text" name="nota_tipo_veiculo_transportador" class="form-control" value="<?php echo $edi['nota_tipo_veiculo_transportador']; ?>">-->
                                <select name="nota_veiculo_tipo" class="form-control">
                                    <option value="1">Reboque</option>
                                    <option value="2">Caminhão</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Placa</label>
                                <input type="text" name="nota_veiculo_placa" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Placa UF</label>
                                <input type="text" name="nota_veiculo_uf" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">RNTC</label>
                                <input type="text" name="nota_veiculo_rntc" class="form-control">
                            </div>
                        </div>  
                    </div>
                    <input name="id_nota" type="hidden" value="<?php echo $edi['id_nota_id']; ?>">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-xs" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-cadastra_veiculo" class="btn btn-success btn-xs">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--CADASTRA UM NOVO VOLUME NA NFE-->
<div class="modal fade" id="novovolume" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Editar Itens</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <legend>Produto/Serviços</legend>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Quantidade</label>
                                <input type="text" name="nota_volume_qtd" class="form-control">
                            </div>
                        </div> 
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Espécie</label>
                                <input type="text" name="nota_volume_especie" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Peso Bruto</label>
                                <input type="text" name="nota_volume_peso_bruto" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Peso Líquido</label>
                                <input type="text" name="nota_volume_peso_liquido" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">MARCA</label>
                                <input type="text" name="nota_volume_marca" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">N° Volume</label>
                                <input type="text" name="nota_volume_numero_volume" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Lacre</label>
                                <input type="text" name="nota_volume_lacre" class="form-control">
                            </div>
                        </div>
                    </div>
                    <input name="id_nota" type="hidden" value="<?php echo $edi['id_nota_id']; ?>">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-xs" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-cadastra_volume" class="btn btn-success btn-xs">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--EDITAR VOLUME DA NFE-->
<div class="modal fade" id="volumeeditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Editar Volume</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <legend>Volume</legend>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">QTD</label>
                                <input type="text" name="nota_volume_qtd" class="form-control" id="nota_volume_qtd">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Espécie</label>
                                <input type="text" name="nota_volume_especie" class="form-control" id="nota_volume_especie">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Peso Bruto</label>
                                <input type="text" name="nota_volume_peso_bruto" class="form-control" id="nota_volume_peso_bruto">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Peso Liquido</label>
                                <input type="text" name="nota_volume_peso_liquido" class="form-control" id="nota_volume_peso_liquido">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Marca</label>
                                <input type="text" name="nota_volume_marca" class="form-control" id="nota_volume_marca">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">N° Volume</label>
                                <input type="text" name="nota_volume_numero_volume" class="form-control" id="nota_volume_numero_volume">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Lacre</label>
                                <input type="text" name="nota_volume_lacre" class="form-control" id="nota_volume_lacre">
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="nota_volume_id" class="form-control" id="nota_volume_id">

                    <div class="modal-footer">
                        <?php
                        if ($edi['nota_status'] < 4) {
                            ?>
                            <button type="button" class="btn btn-primary btn-xs" data-dismiss="modal">Cancelar</button>
                            <button type="submit" name="btn-altera_volume" class="btn btn-warning btn-xs">Alterar</button>
                            <?php
                        }
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--EXCLUIR VOLUME DA NFE-->
<div class="modal fade" id="volumeexcluir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Excluir Volume</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <legend>Volumes</legend>

                    <input type="hidden" name="nota_volume_id" class="form-control" id="nota_volume_id">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-xs" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-excluir_volume" class="btn btn-danger btn-xs">Excluir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--EDITA OS ITENS DA NFE-->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Editar Itens</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <legend>Produto/Serviços</legend>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label  class="control-label">Produto</label>
                                <input name="nota_itens_produto" type="text" class="form-control" disabled="" id="nota_itens_produto">
                            </div>
                        </div>
                    </div>

                    <legend>Tributação</legend>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="message-text" class="control-label">ST</label>
<!--                                <input name="pedido_itens_id_st" class="form-control" id="pedido_itens_id_st">-->
                                <select name="nota_itens_id_st" class="form-control" id="nota_itens_id_st">
                                    <?php
                                    while ($row = $stmt_buscast->fetch(PDO::FETCH_ASSOC)) {
                                        if ($row['st_tipo'] == 0) {
                                            $fla = "ENTRADA";
                                        } else {
                                            $fla = "SAIDA";
                                        }
                                        ?>
                                        <option value="<?php echo $row['st_id'] ?>"><?php echo $row['st_nome'] . "==>" . $fla; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="message-text" class="control-label">TES</label>
<!--                                <input name="pedido_itens_id_tes" class="form-control" id="pedido_itens_id_tes">-->
                                <select name="nota_itens_id_tes" class="form-control" id="nota_itens_id_tes">
                                    <?php
                                    while ($row = $stmt_buscates->fetch(PDO::FETCH_ASSOC)) {
                                        if ($row['tes_tipo'] == 0) {
                                            $fl = "ENTRADA";
                                        } else {
                                            $fl = "SAIDA";
                                        }
                                        ?>
                                        <option value="<?php echo $row['tes_id'] ?>"><?php echo $row['tes_descricao'] . "==>" . $fl; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tabbable tabs-left">
                                <ul class="nav nav-tabs" id="myTab3">
                                    <li class="active">
                                        <a data-toggle="tab" href="#complemento">
                                            Comp
                                        </a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#icms">
                                            ICMS
                                        </a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#icmsst">
                                            ICMS-ST
                                        </a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#icmscred">
                                            Créd. ICMS
                                        </a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#icmspar">
                                            ICMS Par.
                                        </a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#ipi">
                                            IPI
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
                                </ul>
                                <div class="tab-content">
                                    <div id="complemento" class="tab-pane in active">
                                        <legend>Complemento</legend>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label  class="control-label">QTD</label>
                                                    <input name="nota_itens_qtd" type="text" class="form-control" id="nota_itens_qtd">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label  class="control-label">Valor</label>
                                                    <input name="nota_itens_valor" class="form-control" id="nota_itens_valor" >
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label  class="control-label">Total</label>
                                                    <input name="nota_itens_total" class="form-control" id="nota_itens_total" disabled="">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label  class="control-label">Frete</label>
                                                    <input name="nota_itens_valor_frete" class="form-control" id="nota_itens_valor_frete">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label  class="control-label">Seguro</label>
                                                    <input name="nota_itens_valor_seguro" class="form-control" id="nota_itens_valor_seguro">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label  class="control-label">Desconto</label>
                                                    <input name="nota_itens_valor_desconto" class="form-control" id="nota_itens_valor_desconto">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label  class="control-label">O. Despesas</label>
                                                    <input name="nota_itens_outras_despesas" class="form-control" id="nota_itens_outras_despesas">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label  class="control-label">IDTOT</label>
                                                    <input name="nota_itens_idtot" class="form-control" id="nota_itens_idtot">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label  class="control-label">N° Compra</label>
                                                    <input name="nota_itens_numero_compra" class="form-control" id="nota_itens_numero_compra">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label  class="control-label">Item Compra</label>
                                                    <input name="nota_itens_item_compra" class="form-control" id="nota_itens_item_compra">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label  class="control-label">NCM</label>
                                                    <input name="nota_itens_ncm" class="form-control" id="nota_itens_ncm">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label  class="control-label">N° FCI</label>
                                                    <input name="nota_itens_numero_nfci" class="form-control" id="nota_itens_numero_nfci">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label  class="control-label">Descricao</label>
                                                    <input name="nota_itens_descricao" class="form-control" id="nota_itens_descricao">
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    <div id="icms" class="tab-pane">
                                        <legend>ICMS</legend>
                                        <div class="row">

                                            <div class="col-sm-5">
                                                <div class="form-group">

                                                    <label for="recipient-name" class="control-label">CSON</label>

                                                    <select  name="nota_itens_cst" class="form-control" id="nota_itens_cst">

                                                        <?php
                                                        while ($e = $stmt_e->fetch(PDO::FETCH_ASSOC)) {
                                                            if ($e['empresa_crt'] == 3) {
                                                                ?>
                                                                <option value="00"> 00: Tributada integralmente </option>
                                                                <option value="10"> 10: Tributada com cobr. por subst. trib. </option>
                                                                <option value="20"> 20: Com redução de base de cálculo </option>
                                                                <option value="30"> 30: Isenta ou não trib com cobr por subst trib </option>
                                                                <option value="40"> 40: Isenta </option>
                                                                <option value="41"> 41: Não tributada </option>
                                                                <option value="50"> 50: Suspesão </option>
                                                                <option value="51"> 51: Diferimento </option>
                                                                <option value="60"> 60: ICMS cobrado anteriormente por subst trib </option>
                                                                <option value="70"> 70: Redução de Base Calc e cobr ICMS por subst trib </option>
                                                                <option value="90"> 90: Outros </option>
                                                                <?php
                                                            }

                                                            if (($e['empresa_crt'] == 1) || ($e['empresa_crt'] == 2)) {
                                                                ?>

                                                                <option value="101"> Simples Nacional: 101: Com permissão de crédito </option>
                                                                <option value="102"> Simples Nacional: 102: Sem permissão de crédito </option>
                                                                <option value="103"> Simples Nacional: 103: Isenção do ICMS para faixa de receita bruta </option>
                                                                <option value="201"> Simples Nacional: 201: Com permissão de crédito, com cobr ICMS por Subst Trib</option>
                                                                <option value="202"> Simples Nacional: 202: Sem permissão de crédito, com cobr ICMS por Subst Trib </option>
                                                                <option value="203"> Simples Nacional: 203: Isenção ICMS p/ faixa de receita bruta e cobr do ICMS por ST</option>
                                                                <option value="300"> Simples Nacional: 300: Imune </option>
                                                                <option value="400"> Simples Nacional: 400: Não tributada </option>
                                                                <option value="500"> Simples Nacional: 500: ICMS cobrado antes por subst trib ou antecipação </option>
                                                                <option value="900"> Simples Nacional: 900: Outros </option>

                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label  class="control-label">CEST</label>
                                                    <input name="nota_itens_cest" class="form-control" id="nota_itens_cest">
                                                </div>
                                            </div>

                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Origem</label>
                                                    <select class="form-control" name="nota_itens_origem">
                                                        <option value="0">0- Nacional, exceto as indicadas nos códigos 3, 4, 5 e 8</option>
                                                        <option value="1">1- Estrangeira - Importação direta, exceto a indicada no código 6</option>
                                                        <option value="2">2- Estrangeira - Adquirida no mercado interno, exceto a indicada no código 7</option>
                                                        <option value="3">3- Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40% (quarenta por cento) e inferior ou igual a 70% (setenta por cento</option>
                                                        <option value="4">4- Nacional, cuja produção tenha sido feita em conformidade com os processos produtivos básicos de que tratam o Decreto-Lei nº 288/67, e as Leis nºs 8.248/91, 8.387/91, 10.176/01 e 11.484/07</option>
                                                        <option value="5">5- Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40% (quarenta por cento)</option>
                                                        <option value="6">6- Estrangeira - Importação direta, sem similar nacional, constante em lista de Resolução CAMEX e gás natural</option>
                                                        <option value="7">7- Estrangeira - Adquirida no mercado interno, sem similar nacional, constante em lista de Resolução CAMEX e gás natural</option>
                                                        <option value="8">8- Nacional, mercadoria ou bem com Conteúdo de Importação superior a 70% (setenta por cento)</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="recipient-name" class="control-label">Mod. B. Calculo</label>
                                                    <select name="nota_itens_modalidade_calculo_icms" class="form-control" id="nota_itens_modalidade_calculo_icms">
                                                        <option value=""></option>
                                                        <option value="0">0 - Margem Valor Agregado</option>
                                                        <option value="1">1 - Pauta</option>
                                                        <option value="2">2 - Preço Tabelado</option>
                                                        <option value="3">3 - Valor da Operação</option>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label  class="control-label">Red. Cálc. ICMS</label>
                                                    <input name="nota_itens_reducao_calculo_icms" class="form-control" id="nota_itens_reducao_calculo_icms">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label  class="control-label">Base Cálc. ICMS</label>
                                                    <input name="nota_itens_base_calculo_icms" class="form-control" id="nota_itens_base_calculo_icms">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label  class="control-label">Aliquota ICMS</label>
                                                    <input name="nota_itens_aliquota" class="form-control" id="nota_itens_aliquota">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label  class="control-label">Valor ICMS Op.</label>
                                                    <input name="nota_itens_valor_icms_op" class="form-control" id="nota_itens_valor_icms_op">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label  class="control-label">Perc Dif</label>
                                                    <input name="nota_itens_perc_dif" class="form-control" id="nota_itens_perc_dif">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label  class="control-label">Valor Perc Dif</label>
                                                    <input name="nota_itens_valor_perc_dif" class="form-control" id="nota_itens_valor_perc_dif">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label  class="control-label">Valor ICMS</label>
                                                    <input name="nota_itens_valor_icms" class="form-control" id="nota_itens_valor_icms">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div id="icmsst" class="tab-pane">
                                        <legend>ICMS-ST</legend>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="recipient-name" class="control-label">B. Calculo ST</label>
                                                    <select name="nota_itens_st_modalidade_calculo" class="form-control" id="nota_itens_st_modalidade_calculo">
                                                        <option value=""></option>
                                                        <option value="0">0 - Preço tabelado ou máximo sugerido</option>
                                                        <option value="1">1 - Lista Negativa(valor)</option>
                                                        <option value="2">2 - Lista Positiva(valor)</option>
                                                        <option value="3">3 - Lista Neutra(valor)</option>
                                                        <option value="4">4 - Margem Valor Agregado(%)</option>
                                                        <option value="5">5 - Pauta(valor)</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label  class="control-label">ST Comportamento</label>
                                                    <input name="nota_itens_st_comportamento" class="form-control" id="nota_itens_st_comportamento">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label  class="control-label">MVA</label>
                                                    <input name="nota_itens_st_mva" class="form-control" id="nota_itens_st_mva">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label  class="control-label">Red. Calculo ST</label>
                                                    <input name="nota_itens_st_reducao_calculo" class="form-control" id="nota_itens_st_reducao_calculo">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label  class="control-label">Aliquota ST</label>
                                                    <input name="nota_itens_st_aliquota" class="form-control" id="nota_itens_st_aliquota">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label  class="control-label">Valor ST</label>
                                                    <input name="nota_itens_st_valor" class="form-control" id="nota_itens_st_valor">
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    <div id="icmscred" class="tab-pane">
                                        <legend>Crédito ICMS</legend>
                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label  class="control-label">Aliquota</label>
                                                    <input name="nota_itens_aliquota_cred_icms" class="form-control" id="nota_itens_aliquota_cred_icms">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label  class="control-label">Valor</label>
                                                    <input name="nota_itens_valor_cred_icms" class="form-control" id="nota_itens_valor_cred_icms">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div id="icmspar" class="tab-pane">
                                        <legend>ICMS Partilha</legend>
                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label  class="control-label">Partilha Pobreza</label>
                                                    <input name="nota_itens_par_pobreza" class="form-control" id="nota_itens_par_pobreza">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label  class="control-label">Partilha Destino</label>
                                                    <input name="nota_itens_par_destino" class="form-control" id="nota_itens_par_destino">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label  class="control-label">Partilha Origem</label>
                                                    <input name="nota_itens_par_origem" class="form-control" id="nota_itens_par_origem">
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                    <div id="ipi" class="tab-pane">
                                        <legend>IPI</legend>
                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label  class="control-label">CST</label>
                                                    <select name="nota_itens_id_ipi" class="form-control" id="nota_itens_id_ipi">
                                                        <?php
                                                        if ($edi['nota_tipo'] == 0) {
                                                            ?>
                                                            <option value="1"> 00: Entrada com recuperação de crédito </option>
                                                            <option value="2"> 01: Entrada tributada com alíquota zero </option>
                                                            <option value="3"> 02: Entrada isenta</option>
                                                            <option value="4"> 03: Entrada não-tributada </option>
                                                            <option value="5"> 04: Entrada imune </option>
                                                            <option value="6"> 05: Entrada com suspensão </option>
                                                            <option value="7"> 49: Outras entradas </option>
                                                            <option value="15"> NA:Não se Aplica(Empresa sem IPI) </option>
                                                            <?php
                                                        }
                                                        if ($edi['nota_tipo'] == 1) {
                                                            ?>

                                                            <option value="8"> 50: Saída tributada </option>
                                                            <option value="9"> 51: Saída tributada com alíquota zero </option>
                                                            <option value="10"> 52: Saída isenta</option>
                                                            <option value="11"> 53: Saída não-tributada </option>
                                                            <option value="12"> 54: Saída imune</option>
                                                            <option value="13"> 55: Saída com suspensão </option>
                                                            <option value="14"> 99: Outras saídas </option>
                                                            <option value="16"> NA:Não se Aplica(Empresa sem IPI) </option>
                                                            <?php
                                                        }
                                                        ?>

                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label  class="control-label">Classe</label>
                                                    <input name="nota_itens_ipi_classe" class="form-control" id="nota_itens_ipi_classe">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label  class="control-label">Cod. Enq</label>
                                                    <input name="nota_itens_ipi_cod" class="form-control" id="nota_itens_ipi_cod">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label  class="control-label">Tipo Calculo</label>
                                                    <input name="nota_itens_ipi_tipo_calculo" class="form-control" id="nota_itens_ipi_tipo_calculo">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label  class="control-label">Aliquota</label>
                                                    <input name="nota_itens_ipi_aliquota" class="form-control" id="nota_itens_ipi_aliquota">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="pis" class="tab-pane">
                                        <legend>PIS</legend>
                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label  class="control-label">CST</label>
                                                    <select name="nota_itens_id_pis" class="form-control" id="nota_itens_id_pis">
                                                        <?php
                                                        if ($edi['nota_tipo'] == 0) {
                                                            ?>
                                                            <option value="10"> 50: Direito a Crédito. Vinculada Exclusivamente a Receita Tributada no Mercado Interno </option>
                                                            <option value="11"> 51: Direito a Crédito. Vinculada Exclusivamente a Receita Não Tributada no Mercado Interno </option>
                                                            <option value="12"> 52: Direito a Crédito. Vinculada Exclusivamente a Receita de Exportação</option>
                                                            <option value="13"> 53: Direito a Crédito. Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno </option>
                                                            <option value="14"> 54: Direito a Crédito. Vinculada a Receitas Tributadas no Mercado Interno e de Exportação </option>
                                                            <option value="15"> 55: Direito a Crédito. Vinculada a Receitas Não-Trib. no Mercado Interno e de Exportação </option>
                                                            <option value="16"> 56: Direito a Crédito. Vinculada a Rec. Trib. e Não-Trib. Mercado Interno e Exportação </option>
                                                            <option value="17"> 60: Créd. Presumido. Aquisição Vinc. Exclusivamente a Receita Tributada no Mercado Interno </option>
                                                            <option value="18"> 61: Créd. Presumido. Aquisição Vinc. Exclusivamente a Rec. Não-Trib. no Mercado Interno </option>
                                                            <option value="19"> 62: Créd. Presumido. Aquisição Vinc. Exclusivamente a Receita de Exportação </option>
                                                            <option value="20"> 63: Créd. Presumido. Aquisição Vinc. a Rec. Trib. e Não-Trib. no Mercado Interno </option>
                                                            <option value="21"> 64: Créd. Presumido. Aquisição Vinc. a Rec. Trib. no Mercado Interno e de Exportação </option>
                                                            <option value="22"> 65: Créd. Presumido. Aquisição Vinc. a Rec. Não-Trib. Mercado Interno e Exportação </option>
                                                            <option value="23"> 66: Créd. Presumido. Aquisição Vinc. a Rec. Trib. e Não-Trib. Mercado Interno e Exportação </option>
                                                            <option value="24"> 67: Crédito Presumido - Outras Operações </option>
                                                            <option value="25"> 70: Operação de Aquisição sem Direito a Crédito </option>
                                                            <option value="26"> 71: Operação de Aquisição com Isenção </option>
                                                            <option value="27"> 72: Operação de Aquisição com Suspensão </option>
                                                            <option value="28"> 73: Operação de Aquisição a Alíquota Zero </option>
                                                            <option value="29"> 74: Operação de Aquisição sem Incidência da Contribuição </option>
                                                            <option value="30"> 75: Operação de Aquisição por Substituição Tributária </option>
                                                            <option value="31"> 98: Outras Operações de Entrada </option>
                                                            <option value="32"> 99: Outras operações </option>
                                                            <?php
                                                        }
                                                        if ($edi['nota_tipo'] == 1) {
                                                            ?>

                                                            <option value="1"> 01: Operação tributável (BC = Operação alíq. normal (cumul./não cumul.) </option>
                                                            <option value="2"> 02: Operação tributável (BC = valor da operação (alíquota diferenciada)</option>
                                                            <option value="3"> 03: Operação tributável (BC = quant. x alíq. por unidade de produto)</option>
                                                            <option value="4"> 04: Operação tributável (tributação monofásica, alíquota zero) </option>
                                                            <option value="5"> 06: Operação tributável (alíquota zero)</option>
                                                            <option value="6"> 07: Operação isenta da contribuição </option>
                                                            <option value="7"> 08: Operação sem incidência da contribuição </option>
                                                            <option value="8"> 09: Operação com suspensão da contribuição </option>
                                                            <option value="9"> 49: Outras Operações de Saída </option>
                                                            <option value="33"> 99: Outras operações </option>
                                                            <?php
                                                        }
                                                        ?>

                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label  class="control-label">Tipo Calculo</label>
                                                    <input name="nota_itens_pis_tipo_calculo" class="form-control" id="nota_itens_tipo_calculo">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label  class="control-label">B.C. Pis</label>
                                                    <input name="nota_itens_pis_base_calculo" class="form-control" id="nota_itens_pis_base_calculo">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label  class="control-label">Aliquota</label>
                                                    <input name="nota_itens_pis_aliquota" class="form-control" id="nota_itens_pis_aliquota">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label  class="control-label">Valor</label>
                                                    <input name="nota_itens_pis_valor" class="form-control" id="nota_itens_pis_valor">
                                                </div>
                                            </div>

                                        </div>
                                        <legend>PIS ST</legend>
                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label  class="control-label">Tipo Calculo PIS ST</label>
                                                    <input name="nota_itens_pis_st_tipo_calculo" class="form-control" id="nota_itens_pis_st_tipo_calculo">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label  class="control-label">B.C PIS ST</label>
                                                    <input name="nota_itens_pis_st_base_calculo" class="form-control" id="nota_itens_pis_st_base_calculo">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label  class="control-label">Aliquota PIS ST</label>
                                                    <input name="nota_itens_pis_st_aliquota" class="form-control" id="nota_itens_pis_st_aliquota">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label  class="control-label">Valor PIS ST</label>
                                                    <input name="nota_itens_pis_st_valor" class="form-control" id="nota_itens_pis_st_valor">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="cofins" class="tab-pane">
                                        <legend>COFINS</legend>
                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label  class="control-label">CST</label>
                                                    <select name="nota_itens_id_cofins" class="form-control" id="nota_itens_id_cofins">
                                                        <?php
                                                        if ($edi['nota_tipo'] == 0) {
                                                            ?>
                                                            <option value="10"> 50: Direito a Crédito. Vinculada Exclusivamente a Receita Tributada no Mercado Interno </option>
                                                            <option value="11"> 51: Direito a Crédito. Vinculada Exclusivamente a Receita Não Tributada no Mercado Interno </option>
                                                            <option value="12"> 52: Direito a Crédito. Vinculada Exclusivamente a Receita de Exportação</option>
                                                            <option value="13"> 53: Direito a Crédito. Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno </option>
                                                            <option value="14"> 54: Direito a Crédito. Vinculada a Receitas Tributadas no Mercado Interno e de Exportação </option>
                                                            <option value="15"> 55: Direito a Crédito. Vinculada a Receitas Não-Trib. no Mercado Interno e de Exportação </option>
                                                            <option value="16"> 56: Direito a Crédito. Vinculada a Rec. Trib. e Não-Trib. Mercado Interno e Exportação </option>
                                                            <option value="17"> 60: Créd. Presumido. Aquisição Vinc. Exclusivamente a Receita Tributada no Mercado Interno </option>
                                                            <option value="18"> 61: Créd. Presumido. Aquisição Vinc. Exclusivamente a Rec. Não-Trib. no Mercado Interno </option>
                                                            <option value="19"> 62: Créd. Presumido. Aquisição Vinc. Exclusivamente a Receita de Exportação </option>
                                                            <option value="20"> 63: Créd. Presumido. Aquisição Vinc. a Rec. Trib. e Não-Trib. no Mercado Interno </option>
                                                            <option value="21"> 64: Créd. Presumido. Aquisição Vinc. a Rec. Trib. no Mercado Interno e de Exportação </option>
                                                            <option value="22"> 65: Créd. Presumido. Aquisição Vinc. a Rec. Não-Trib. Mercado Interno e Exportação </option>
                                                            <option value="23"> 66: Créd. Presumido. Aquisição Vinc. a Rec. Trib. e Não-Trib. Mercado Interno e Exportação </option>
                                                            <option value="24"> 67: Crédito Presumido - Outras Operações </option>
                                                            <option value="25"> 70: Operação de Aquisição sem Direito a Crédito </option>
                                                            <option value="26"> 71: Operação de Aquisição com Isenção </option>
                                                            <option value="27"> 72: Operação de Aquisição com Suspensão </option>
                                                            <option value="28"> 73: Operação de Aquisição a Alíquota Zero </option>
                                                            <option value="29"> 74: Operação de Aquisição sem Incidência da Contribuição </option>
                                                            <option value="30"> 75: Operação de Aquisição por Substituição Tributária </option>
                                                            <option value="31"> 98: Outras Operações de Entrada </option>
                                                            <option value="32"> 99: Outras operações </option>
                                                            <?php
                                                        }
                                                        if ($edi['nota_tipo'] == 1) {
                                                            ?>

                                                            <option value="1"> 01: Operação tributável (BC = Operação alíq. normal (cumul./não cumul.) </option>
                                                            <option value="2"> 02: Operação tributável (BC = valor da operação (alíquota diferenciada)</option>
                                                            <option value="3"> 03: Operação tributável (BC = quant. x alíq. por unidade de produto)</option>
                                                            <option value="4"> 04: Operação tributável (tributação monofásica, alíquota zero) </option>
                                                            <option value="5"> 06: Operação tributável (alíquota zero)</option>
                                                            <option value="6"> 07: Operação isenta da contribuição </option>
                                                            <option value="7"> 08: Operação sem incidência da contribuição </option>
                                                            <option value="8"> 09: Operação com suspensão da contribuição </option>
                                                            <option value="9"> 49: Outras Operações de Saída </option>
                                                            <option value="33"> 99: Outras operações </option>
                                                            <?php
                                                        }
                                                        ?>

                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label  class="control-label">Tipo Calculo</label>
                                                    <input name="nota_itens_cofins_tipo_calculo" class="form-control" id="nota_itens_cofins_tipo_calculo">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label  class="control-label">B.C. COFINS</label>
                                                    <input name="nota_itens_cofins_base_calculo" class="form-control" id="nota_itens_cofins_base_calculo">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label  class="control-label">Aliquota</label>
                                                    <input name="nota_itens_cofins_aliquota" class="form-control" id="nota_itens_cofins_aliquota">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label  class="control-label">Valor</label>
                                                    <input name="nota_itens_cofins_valor" class="form-control" id="nota_itens_cofins_valor">
                                                </div>
                                            </div>

                                        </div>


                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <input name="nota_itens_id" type="hidden" id="nota_itens_id">

                    <?php
                    if ($edi['nota_status'] < 4) {
                        ?>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary btn-xs" data-dismiss="modal">Cancelar</button>
                            <button type="submit" name="btn-altera" class="btn btn-warning btn-xs">Alterar</button>
                        </div>
                        <?php
                    }
                    ?>
                </form>
            </div>			  
        </div>
    </div>
</div>


<?php
require_once '../pagina/footer.php';
?>
