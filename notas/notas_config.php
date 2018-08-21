<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');
//require_once '../../bootstrap.php';
//require_once '../bootstrap.php';
require_once '../bootstrap.php';
require_once("../class/session.php");
require_once '../class/conexao.class.php';
require_once("../class/class.user.php");

use NFePHP\NFe\MakeNFe;
use NFePHP\NFe\ToolsNFe;
use NFePHP\Extras\Danfe;
use NFePHP\Common\Files\FilesFolders;
use NFePHP\Extras\Dacce;

$nfe = new ToolsNFe('../config/config.json');
$nfe2 = new ToolsNFe('../config/config.json');
$nfe->setModelo('55');
$nfe2->setModelo('55');

$auth_user = new USER();
//VERIFICA A SESSAO DO USUARIO
$user_id = $_SESSION['user_session'];
$stmt = $auth_user->runQuery("SELECT * FROM funcionarios WHERE funcionario_id=:user_id");
$stmt->execute(array(":user_id" => $user_id));
$userRow = $stmt->fetch(PDO::FETCH_ASSOC);
//
//DADOS PARA O INDEX E VISUALIZACAO DA NFE
//determina o numero de registros que serão mostrados na tela
$maximo = 8;
//pega o valor da pagina atual
$pagina = isset($_GET['pagina']) ? ($_GET['pagina']) : '1';

//subtraimos 1, porque os registros sempre começam do 0 (zero), como num array
$inicio = $pagina - 1;
//multiplicamos a quantidade de registros da pagina pelo valor da pagina atual 
$inicio = $maximo * $inicio;
//fazemos um select na tabela que iremos utilizar para saber quantos registros ela possui
$strCount = $auth_user->runQuery("SELECT COUNT(*) AS 'total_notas' FROM nota");
$strCount->execute();
//iniciamos uma var que será usada para armazenar a qtde de registros da tabela  
$total = 10;
if (count($strCount)) {
    foreach ($strCount as $row) {
        //armazeno o total de registros da tabela para fazer a paginação
        $total = $row["total_notas"];
    }
}
//DADOS DO PEDIDO PARA A NFE
$stmt_pedido = $auth_user->runQuery("SELECT * FROM pedido, forma_pagamento, cliente WHERE pedido.pedido_status = 3 AND forma_pagamento.forma_pagamento_id = pedido.id_forma_pagamento AND 
cliente.cliente_id = pedido.id_cliente ORDER BY pedido.pedido_id ASC");
$stmt_pedido->execute();
//DADOS PARA A PAGINAÇÃO DA NFE 
$stmt_notas_emitidas = $auth_user->runQuery("SELECT * FROM nota ORDER BY nota_numero_nf DESC LIMIT $inicio,$maximo");
$stmt_notas_emitidas->execute();

//EDITA OS DADOS DA NFE
if (isset($_POST['btn-edita-nfe'])) {

    //INFORMAÇÕES DA NF-E EDICAO

    $nota_id = $_POST['nota_id'];
    $nota_numero_uf = $_POST['nota_numero_uf'];
    $nota_natureza_operacao = $_POST['nota_natureza_operacao'];
    $nota_indpag = $_POST['nota_indpag'];
    $nota_numero_nf = $_POST['nota_numero_nf'];

    $nota_tipo_operacao = $_POST['nota_tipo_operacao'];
    $nota_codigo_municipio = $_POST['nota_codigo_municipio'];
    $nota_impressao = $_POST['nota_impressao'];
    $nota_tipo_emissao = $_POST['nota_tipo_emissao'];

    $nota_finalidade = $_POST['nota_finalidade'];
    $nota_indicador_finalidade = $_POST['nota_indicador_finalidade'];
    $nota_indicador_presencial = $_POST['nota_indicador_presencial'];
    $nota_status = $_POST['nota_status'];
    
    $nota_frete = $_POST['nota_frete'];

    //INFORMAÇÕES DO TRANSPORTADOR PARA A EDICAO DA NF-E
    $nota_id_transportador = $_POST['nota_id_tranportador'];

    $nota_valor_ser_transportador = $_POST['nota_valor_ser_transportador'];
    $nota_base_calculo_transportador = $_POST['nota_base_calculo_transportador'];
    $nota_cfop_transportador = $_POST['nota_cfop_transportador'];
    $nota_aliquota_transportador = $_POST['nota_aliquota_transportador'];
    $nota_valor_icms_transportador = $_POST['nota_valor_icms_transportador'];
    $nota_cod_municipio_transportador = $_POST['nota_cod_municipio_transportador'];


    if ($nota_id_transportador == 0) {
        $nota_nome_transportador = '';
        $nota_cnpjcpf_transportador = '';
        $nota_inscricao_transportador = '';
        $nota_endereco_transportador = '';
        $nota_municipio_transportador = '';
        $nota_uf_transportador = '';
    } else {
        $busca_trans = $auth_user->runQuery("SELECT * FROM transportador WHERE transportador_id = :transportador_id");
        $busca_trans->execute(array(":transportador_id" => $nota_id_transportador));
        $buscou_trans = $busca_trans->fetch(PDO::FETCH_ASSOC);

        $nota_nome_transportador = $buscou_trans['transportador_nome'];
        $nota_cnpjcpf_transportador = $buscou_trans['transportador_cnpj'];
        $nota_inscricao_transportador = $buscou_trans['transportador_ie'];
        $nota_endereco_transportador = $buscou_trans['transportador_logradouro'];
        $nota_municipio_transportador = $buscou_trans['transportador_municipio'];
        $nota_uf_transportador = $buscou_trans['transportador_uf'];
    }

    //ATUALIZA DADOS DA NFE NA EDICAO
    $result = $auth_user->runQuery('UPDATE nota SET '
            . 'nota_numero_uf = :nota_numero_uf, '
            . 'nota_natureza_operacao = :nota_natureza_operacao, '
            . 'nota_indpag = :nota_indpag, '
            . 'nota_numero_nf = :nota_numero_nf, '
            . 'nota_tipo_operacao = :nota_tipo_operacao, '
            . 'nota_codigo_municipio = :nota_codigo_municipio, '
            . 'nota_impressao = :nota_impressao, '
            . 'nota_tipo_emissao = :nota_tipo_emissao, '
            . 'nota_finalidade = :nota_finalidade, '
            . 'nota_indicador_finalidade = :nota_indicador_finalidade, '
            . 'nota_indicador_presencial = :nota_indicador_presencial, '
            . 'nota_status = :nota_status,'
            . 'nota_frete = :nota_frete,'
            . 'nota_id_transportador = :nota_id_transportador, '
            . 'nota_nome_transportador = :nota_nome_transportador,'
            . 'nota_cnpjcpf_transportador = :nota_cnpjcpf_transportador,'
            . 'nota_inscricao_transportador = :nota_inscricao_transportador,'
            . 'nota_endereco_transportador = :nota_endereco_transportador,'
            . 'nota_municipio_transportador = :nota_municipio_transportador,'
            . 'nota_uf_transportador = :nota_uf_transportador,'
            . 'nota_valor_ser_transportador = :nota_valor_ser_transportador,'
            . 'nota_base_calculo_transportador = :nota_base_calculo_transportador,'
            . 'nota_cfop_transportador = :nota_cfop_transportador,'
            . 'nota_aliquota_transportador = :nota_aliquota_transportador,'
            . 'nota_valor_icms_transportador = :nota_valor_icms_transportador,'
            . 'nota_cod_municipio_transportador = :nota_cod_municipio_transportador'
            . ' WHERE nota_id = :nota_id');

    $result->execute(array(
        ':nota_id' => $nota_id,
        ':nota_numero_uf' => $nota_numero_uf,
        ':nota_natureza_operacao' => $nota_natureza_operacao,
        ':nota_indpag' => $nota_indpag,
        ':nota_numero_nf' => $nota_numero_nf,
        ':nota_tipo_operacao' => $nota_tipo_operacao,
        ':nota_codigo_municipio' => $nota_codigo_municipio,
        ':nota_impressao' => $nota_impressao,
        ':nota_tipo_emissao' => $nota_tipo_emissao,
        ':nota_finalidade' => $nota_finalidade,
        ':nota_indicador_finalidade' => $nota_indicador_finalidade,
        ':nota_indicador_presencial' => $nota_indicador_presencial,
        ':nota_status' => $nota_status,
        ':nota_frete' => $nota_frete,
        ':nota_id_transportador' => $nota_id_transportador,
        ':nota_nome_transportador' => $nota_nome_transportador,
        ':nota_cnpjcpf_transportador' => $nota_cnpjcpf_transportador,
        ':nota_inscricao_transportador' => $nota_inscricao_transportador,
        ':nota_endereco_transportador' => $nota_endereco_transportador,
        ':nota_municipio_transportador' => $nota_municipio_transportador,
        ':nota_uf_transportador' => $nota_uf_transportador,
        ':nota_valor_ser_transportador' => $nota_valor_ser_transportador,
        ':nota_base_calculo_transportador' => $nota_base_calculo_transportador,
        ':nota_cfop_transportador' => $nota_cfop_transportador,
        ':nota_aliquota_transportador' => $nota_aliquota_transportador,
        ':nota_valor_icms_transportador' => $nota_valor_icms_transportador,
        ':nota_cod_municipio_transportador' => $nota_cod_municipio_transportador,
    ));
}

//PESQUISAR O NFE CADASTRADA NO SISTEMA
if (isset($_POST['btn-pesquisar'])) {

    $pesquisa = $_POST['notas_pesquisa'];
    $pesquisa2 = $_POST['notas_pesquisa'];
    try {

        if (isset($pesquisa) && !empty($pesquisa2)) {
            $stmt_notas_emitidas = $auth_user->runQuery("SELECT * FROM nota"
                    . " WHERE nota_cliente like :nome OR "
                    . "nota_numero_nf like :numero");
            $stmt_notas_emitidas->bindValue(':nome', '%' . $pesquisa2 . '%', PDO::PARAM_STR);
            $stmt_notas_emitidas->bindValue(':numero', '%' . $pesquisa . '%', PDO::PARAM_STR);
            $stmt_notas_emitidas->execute();
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
//PROCESSO DE EMISSAO DA NFE
if (isset($_POST['btn-emite'])) {

    // $nfe = new MakeNFe();
    //BUSCA O PEDIDO E A EMPRESA PARA OS DADOS DA EMISSAO
    $pedido_id = strip_tags($_POST['pedido_id']);
    $stmt_empresa = $auth_user->runQuery("SELECT * FROM empresa, estado, municipio WHERE empresa.id_estado = estado.estado_id "
            . "AND id_municipio = municipio_id");
    $stmt_empresa->execute();
    $dados_empresa = $stmt_empresa->fetch(PDO::FETCH_ASSOC);

    //BUSCA DADOS DO PEDIDO PARA A EMISSAO
    $stmt_pagamento = $auth_user->runQuery("SELECT * FROM pedido, forma_pagamento, cliente, municipio WHERE 
    id_forma_pagamento = forma_pagamento_id AND cliente_id = id_cliente AND id_municipio = municipio_id 
    AND pedido_id = :pedido_id");
    $stmt_pagamento->execute(array(":pedido_id" => $pedido_id));
    $dados_pedido = $stmt_pagamento->fetch(PDO::FETCH_ASSOC);


    //CADASTRAR O TIPO CERTO DO CLIENTE PARA PEGAR OS DADOS CORRETOS DA TES NO PRODUTO.

    $cliente_tipo = $dados_pedido['cliente_tipo'];
    $cliente_consumidor = $dados_pedido['cliente_consumidor'];
    if ($cliente_consumidor == 1) {
        $tipo_consumidor = 0;
    } else {
        $tipo_consumidor = 1;
    }
    //echo $tipo_consumidor."Consu";

    $tipo_cliente = $dados_pedido['cliente_tipo'] + $dados_pedido['cliente_consumidor'];

    //echo $tipo_cliente."tipo";
    $cliente_estado = $dados_pedido['municipio_sigla'];
    //echo $cliente_estado."estado";
    // BUSCAR DADOS DA TES E CFOP
    $stmt_tescfop = $auth_user->runQuery("SELECT * FROM  pedido_itens,tes, cfop WHERE "
            . "cfop_codigo = tes_cfop AND pedido_itens_id_tes = tes_id AND id_pedido = :pedido_id");
    $stmt_tescfop->execute(array(":pedido_id" => $pedido_id));
    $dados_tescfop = $stmt_tescfop->fetch(PDO::FETCH_ASSOC);

    //AQUI BUSCA INFORMAÇÕES DA TES PARA PEGAR A CORRETA DE DENTRO/FORA DO ESTADO OU EXTERIOR
    if ($dados_pedido['municipio_sigla'] == $dados_empresa['municipio_sigla']) {
        $tes_itens_origem = 1;
    }
    if ($dados_pedido['municipio_sigla'] != $dados_empresa['municipio_sigla']) {
        $tes_itens_origem = 2;
    }
    if ($dados_pedido['municipio_sigla'] == 'EX') {
        $tes_itens_origem = 3;
    }

    $id_tes_pedido = $dados_tescfop['pedido_itens_id_tes'];
    $id_st_pedido = $dados_tescfop['pedido_itens_id_st'];


    //BUSCA INFORMAÇÕES PARA A VALIDAÇÃO DA NFE.
    // BUSCA OS DADOS DO PEDIDO PARA GERAR VALORES DE IMPOSTOS DE ACORDO COM A TES E A ST
    $stmt_produtos = $auth_user->runQuery(
            "SELECT * FROM pedido_itens, sticms,icms, tes_itens,
    produto, unidade, ncm, st, ipi, pis, cofins WHERE
    sticms.id_st = pedido_itens.pedido_itens_id_st AND
    pedido_itens.id_pedido = :pedido_id AND
    sticms.sticms_uf = :cliente_estado AND 
    sticms.sticms_cso = icms.icms_id AND
    tes_itens.id_tes = pedido_itens.pedido_itens_id_tes AND
    tes_itens.tes_itens_contribuinte = :tipo_consumidor AND
    tes_itens.tes_itens_origem = " . $tes_itens_origem . " AND
    sticms.sticms_tipo_pessoa = :tipo_cliente AND
    pedido_itens.id_produto = produto.produto_id AND
    produto.id_unidade = unidade.unidade_id AND
    produto.id_ncm = ncm.ncm_id AND 
    sticms.id_st = st.st_id AND 
    st.id_ipi = ipi.ipi_id AND
    st.id_pis = pis.pis_id AND
    st.id_cofins = cofins.cofins_id"
    );

    $stmt_produtos->execute(array(
        ':pedido_id' => $pedido_id,
        ':tipo_cliente' => $tipo_cliente,
        ':tipo_consumidor' => $tipo_consumidor,
        ':cliente_estado' => $cliente_estado));

    $busca_config = $stmt_produtos->fetch(PDO::FETCH_ASSOC);

    if ($busca_config == TRUE) {


        //INFORMAÇÕES INICIAIS DA NFE
        require '../notaaux/inf_nfe.php';
        //REFERENCIA A NFE SE TIVER.
        require '../notaaux/inf_referencia.php';
        //DADOS E ENDERECO DO EMITENTE
        require '../notaaux/inf_emitente.php';
        //DADOS E ENDERECO DO DESTINATARIO
        require '../notaaux/inf_destinatario.php';
        //BUSCA OS ITENS DO PEDIDO PARA GERAR NO XML DA NFE
        require '../notaaux/inf_produtos.php';
        //TOTAIS DA NFE
        require '../notaaux/inf_totais.php';
        //INFORMAÇOES DO FRETE E VOLUME 
        require '../notaaux/inf_frete.php';
        //DADOS PARA A FATURA 
        require '../notaaux/inf_fatura.php';
        // Calculo de carga tributária similar ao IBPT - Lei 12.741/12
        $federal = number_format($vII + $vIPI + $vIOF + $vPIS + $vCOFINS, 2, ',', '.');
        $estadual = number_format($vICMS + $vST, 2, ',', '.');
        $municipal = number_format($vISS, 2, ',', '.');
        $totalT = number_format($federal + $estadual + $municipal, 2, ',', '.');
        $textoIBPT = "Valor Aprox. Tributos R$ {$totalT} - {$federal} Federal, {$estadual} Estadual e {$municipal} Municipal.";

//Informações Adicionais
//$infAdFisco = "SAIDA COM SUSPENSAO DO IPI CONFORME ART 29 DA LEI 10.637";
        $infAdFisco = "";
        $infCpl = "Pedido Nº: {$pedido_id} - {$textoIBPT} ";
        //$resp = $nfe->taginfAdic($infAdFisco, $infCpl);
        //ATUALIZA O NUMERO DA NFE DA NOTA
        $result = $auth_user->runQuery('UPDATE empresa SET '
                . 'empresa_numero_nfe = :numero_nfe '
                . ' WHERE empresa_id = :id_empresa');

        $result->execute(array(
            ':id_empresa' => $dados_empresa['empresa_id'],
            ':numero_nfe' => ($dados_empresa['empresa_numero_nfe'] + 1)
        ));


        try {

//GRAVA O PEDIDO NA TABELA DA NOTA
            $status = 3;
            $stmt = $auth_user->runQuery("INSERT INTO nota
            (nota_id, 
            id_pedido,
            nota_numero_uf,
            nota_numero,
            nota_natureza_operacao,
            nota_indpag,
            nota_modelo, 
            nota_serie,
            nota_numero_nf,
            nota_data_emissao,
            nota_data_saida, 
            nota_tipo,
            nota_frete,
            nota_tipo_operacao,
            nota_codigo_municipio,
            nota_impressao,
            nota_tipo_emissao,
            nota_ambiente,
            nota_finalidade,
            nota_indicador_finalidade,
            nota_indicador_presencial,
            nota_tipo_sistema,
            nota_versao_sistema,
            nota_data_contigencia,
            nota_justificativa_contigencia,
            nota_ano,
            nota_mes,
            nota_cnpj,
            nota_chave,
            nota_versao,
            nota_digito_verificador,
            nota_cliente,
            nota_status,
            identificador_cliente, 
            nota_id_transportador,
            nota_nome_transportador,
            nota_cnpjcpf_transportador,
            nota_inscricao_transportador,
            nota_endereco_transportador,
            nota_municipio_transportador,
            nota_uf_transportador)
            
VALUES(     '',
            :id_pedido,
            :nota_numero_uf,
            :nota_numero,
            :nota_natureza_operacao,
            :nota_indpag,
            :nota_modelo, 
            :nota_serie,
            :nota_numero_nf,
            :nota_data_emissao,
            :nota_data_saida, 
            :nota_tipo,
            :nota_frete,
            :nota_tipo_operacao,
            :nota_codigo_municipio,
            :nota_impressao,
            :nota_tipo_emissao,
            :nota_ambiente,
            :nota_finalidade,
            :nota_indicador_finalidade,
            :nota_indicador_presencial,
            :nota_tipo_sistema,
            :nota_versao_sistema,
            :nota_data_contigencia,
            :nota_justificativa_contigencia,
            :nota_ano,
            :nota_mes,
            :nota_cnpj,
            :nota_chave,
            :nota_versao,
            :nota_digito_verificador,
            :nota_cliente,
            :nota_status,
            :identificador_cliente,
            :nota_id_transportador,
            :nota_nome_transportador,
            :nota_cnpjcpf_transportador,
            :nota_inscricao_transportador,
            :nota_endereco_transportador,
            :nota_municipio_transportador,
            :nota_uf_transportador)");

            $stmt->bindparam(":id_pedido", $pedido_id);
            $stmt->bindparam(":nota_numero_uf", $cUF);
            $stmt->bindparam(":nota_numero", $cNF);
            $stmt->bindparam(":nota_natureza_operacao", $natOp);
            $stmt->bindparam(":nota_indpag", $indPag);
            $stmt->bindparam(":nota_modelo", $mod);
            $stmt->bindparam(":nota_serie", $serie);
            $stmt->bindparam(":nota_numero_nf", $nNF);
            $stmt->bindparam(":nota_data_emissao", $dhEmi);
            $stmt->bindparam(":nota_data_saida", $dhSaiEnt);
            $stmt->bindparam(":nota_tipo", $tpNF);
            $stmt->bindparam(":nota_frete", $dados_pedido['pedido_frete']);
            $stmt->bindparam(":nota_tipo_operacao", $idDest);
            $stmt->bindparam(":nota_codigo_municipio", $cMunFG);
            $stmt->bindparam(":nota_impressao", $tpImp);
            $stmt->bindparam(":nota_tipo_emissao", $tpEmis);
            $stmt->bindparam(":nota_ambiente", $tpAmb);
            $stmt->bindparam(":nota_finalidade", $finNFe);
            $stmt->bindparam(":nota_indicador_finalidade", $indFinal);
            $stmt->bindparam(":nota_indicador_presencial", $indPres);
            $stmt->bindparam(":nota_tipo_sistema", $procEmi);
            $stmt->bindparam(":nota_versao_sistema", $verProc);
            $stmt->bindparam(":nota_data_contigencia", $dhCont);
            $stmt->bindparam(":nota_justificativa_contigencia", $xJust);
            $stmt->bindparam(":nota_ano", $ano);
            $stmt->bindparam(":nota_mes", $mes);
            $stmt->bindparam(":nota_cnpj", $cnpj);
            $stmt->bindparam(":nota_chave", $chave);
            $stmt->bindparam(":nota_versao", $versao);
            $stmt->bindparam(":nota_digito_verificador", $cDV);
            $stmt->bindparam(":nota_cliente", $dados_pedido['cliente_nome']);
            $stmt->bindparam(":nota_status", $status);
            $stmt->bindparam(":identificador_cliente", $dados_pedido['cliente_id']);
            $stmt->bindparam(":nota_id_transportador", $id_transportador);
            $stmt->bindparam(":nota_nome_transportador", $transp['transportador_nome']);
            $stmt->bindparam(":nota_cnpjcpf_transportador", $transp['transportador_cnpj']);
            $stmt->bindparam(":nota_inscricao_transportador", $transp['transportador_ie']);
            $stmt->bindparam(":nota_endereco_transportador", $transp['transportador_logradouro']);
            $stmt->bindparam(":nota_municipio_transportador", $transp['transportador_municipio']);
            $stmt->bindparam(":nota_uf_transportador", $transp['transportador_uf']);
            //
            $stmt->execute();
            //PEGANDO O ULTIMO REGISTRO INSERIDO NO BANCO
            $last_id = $auth_user->registro($stmt);

            //VERIFICAR AS BASES DE CALCULO DOS ITENS A SEREM INSERIDO NA NFE
            //INSERINDO OS ITENS DO PEDIDO EM ITENS DA NOTA

            $sql_nota_itens = "SELECT $last_id, 
            produto_nome, 
            pedido_itens_qtd, 
            pedido_itens_valor, 
            pedido_itens_total,
            id_produto,
            pedido_itens_id_st,
            pedido_itens_id_tes, 
            pedido_itens_valor_frete,
            pedido_itens_valor_seguro,
            pedido_itens_valor_desconto,
            pedido_itens_outras_despesas,
            pedido_itens_idtot,
            pedido_itens_numero_compra,
            pedido_itens_item_compra,
            pedido_itens_numero_nfci,
            pedido_itens_descricao, 
            ncm_codigo,
            icms_codigo,
            produto_cest,
            produto_origem,
            
            IF(sticms_aliquota > 0.00 ,(pedido_itens_total + pedido_itens_valor_frete + 
            pedido_itens_valor_seguro + pedido_itens_outras_despesas - pedido_itens_valor_desconto),0.00),
            
                       
            sticms_modalidade_base_calculo,
            sticms_reducao_base_calculo,
            sticms_base_calculo,
            (pedido_itens_total * sticms_aliquota)/100,
            sticms_perc_diferimento,
            sticms_aliquota,
            (pedido_itens_total * sticms_aliquota)/100,
            
            IF(sticms_st_aliquota > 0.00 ,(pedido_itens_total + pedido_itens_valor_frete + 
            pedido_itens_valor_seguro + pedido_itens_outras_despesas -
            pedido_itens_valor_desconto) * (1 + (sticms_st_mva / 100)),0.00), 
            
            sticms_st_comportamento,
            sticms_st_modalidade_calculo,
            sticms_st_mva,
            sticms_st_reducao_calculo,
            sticms_st_aliquota,
            ((pedido_itens_total + pedido_itens_valor_frete + 
            pedido_itens_valor_seguro + pedido_itens_outras_despesas -
            pedido_itens_valor_desconto) * (1 + (sticms_st_mva / 100)) * sticms_st_aliquota) / 100 ,
            
            (pedido_itens_total + pedido_itens_valor_frete + 
            pedido_itens_valor_seguro + pedido_itens_outras_despesas - pedido_itens_valor_desconto),
            sticms_par_pobreza,
            ((pedido_itens_total + pedido_itens_valor_frete + 
            pedido_itens_valor_seguro + pedido_itens_outras_despesas - pedido_itens_valor_desconto)*sticms_par_pobreza)/100,
            
            (pedido_itens_total + pedido_itens_valor_frete + 
            pedido_itens_valor_seguro + pedido_itens_outras_despesas - pedido_itens_valor_desconto),
            sticms_par_destino,
            ((((pedido_itens_total + pedido_itens_valor_frete + 
            pedido_itens_valor_seguro + pedido_itens_outras_despesas - pedido_itens_valor_desconto)*
            (sticms_par_destino - sticms_par_origem))/100)*60)/100,
            
            (pedido_itens_total + pedido_itens_valor_frete + 
            pedido_itens_valor_seguro + pedido_itens_outras_despesas - pedido_itens_valor_desconto),
            sticms_par_origem,
            ((((pedido_itens_total + pedido_itens_valor_frete + 
            pedido_itens_valor_seguro + pedido_itens_outras_despesas - pedido_itens_valor_desconto)*
            (sticms_par_destino - sticms_par_origem))/100)*40)/100,
            
            
            ipi.ipi_id,
            st.st_ipi_classe,
            st.st_ipi_cod,
            st.st_ipi_tipo_calculo,
            st.st_ipi_aliquota,
            
            pis.pis_id,
            st.st_pis_tipo_calculo,
            pedido_itens_total,
            st.st_pis_aliquota,
            (pedido_itens_total * st.st_pis_aliquota)/100,

            st.st_pis_tipo_calculo_st,
            st.st_pis_aliquota_st,
            
            cofins.cofins_id,
            
            st.st_cofins_tipo_calculo,
            
            st.st_cofins_aliquota,
            (pedido_itens_total * st.st_cofins_aliquota)/100,
            
            tes_itens.tes_itens_cfop,
            tes_itens.tes_itens_contribuinte,
            tes_itens.tes_itens_tipo_produto,
            tes_itens.tes_itens_cst_icms,
                       
            IF(STRCMP(icms_codigo,'101'),0.00, b.aproveitamento_aliquota),
            IF(STRCMP(icms_codigo,'101'),0.00, (pedido_itens_total * b.aproveitamento_aliquota)/100)

            FROM pedido_itens, sticms,icms, tes_itens, produto, unidade, ncm, st, ipi, pis, cofins LEFT JOIN aproveitamento b
           ON Month(now()) = b.aproveitamento_mes   WHERE
                sticms.id_st = pedido_itens.pedido_itens_id_st AND
                pedido_itens.id_pedido = $pedido_id AND
                sticms.sticms_uf = '$cliente_estado' AND 
                sticms.sticms_cso = icms.icms_id AND
                tes_itens.id_tes = pedido_itens.pedido_itens_id_tes AND
                tes_itens.tes_itens_contribuinte = $tipo_consumidor AND
                tes_itens.tes_itens_origem = " . $tes_itens_origem . " AND
                sticms.sticms_tipo_pessoa = $tipo_cliente AND
                pedido_itens.id_produto = produto.produto_id AND
                produto.id_unidade = unidade.unidade_id AND
                produto.id_ncm = ncm.ncm_id AND 
                sticms.id_st = st.st_id AND 
                st.id_ipi = ipi.ipi_id AND
                st.id_pis = pis.pis_id AND
                st.id_cofins = cofins.cofins_id

            ";

         
            $stmt_busca = $auth_user->runQuery("INSERT INTO nota_itens 
            (id_nota_id,
            nota_itens_produto, 
            nota_itens_qtd, 
            nota_itens_valor, 
            nota_itens_total, 
            nota_itens_id_produto,
            nota_itens_id_st,
            nota_itens_id_tes,
            nota_itens_valor_frete,
            nota_itens_valor_seguro,
            nota_itens_valor_desconto,
            nota_itens_outras_despesas,
            nota_itens_idtot,
            nota_itens_numero_compra,
            nota_itens_item_compra,
            nota_itens_numero_nfci,
            nota_itens_descricao, 
            nota_itens_ncm,
            nota_itens_cst,
            nota_itens_cest,
            nota_itens_origem,
            
            nota_itens_bc_icms,
            nota_itens_modalidade_calculo_icms,
            nota_itens_reducao_calculo_icms,
            nota_itens_base_calculo_icms,
            nota_itens_valor_icms_op,
            nota_itens_perc_dif,
            nota_itens_aliquota,
            nota_itens_valor_icms,
            
            nota_itens_st_bc,
            nota_itens_st_comportamento,
            nota_itens_st_modalidade_calculo,
            nota_itens_st_mva,
            nota_itens_st_reducao_calculo,
            nota_itens_st_aliquota,
            nota_itens_st_valor,
            
            nota_itens_par_pobreza_bc,
            nota_itens_par_pobreza,
            nota_itens_par_pobreza_valor,
            
            nota_itens_par_destino_bc,
            nota_itens_par_destino,
            nota_itens_par_destino_valor,
            
            nota_itens_par_origem_bc,
            nota_itens_par_origem,
            nota_itens_par_origem_valor,
            
            nota_itens_id_ipi,
            nota_itens_ipi_classe,
            nota_itens_ipi_cod,

            nota_itens_ipi_aliquota,
            
            nota_itens_id_pis,
            nota_itens_pis_tipo_calculo,
            nota_itens_pis_base_calculo,
            nota_itens_pis_aliquota,
            nota_itens_pis_valor,
            
            nota_itens_pis_st_tipo_calculo,
            nota_itens_pis_st_aliquota,
            
            nota_itens_id_cofins,
            nota_itens_cofins_tipo_calculo,
           
            nota_itens_cofins_aliquota,
            nota_itens_cofins_valor,
            
            nota_itens_cfop,
            nota_itens_contribuinte,
            nota_itens_tipo_produto,
            nota_itens_cst_icms,
            
            nota_itens_aliquota_cred_icms,
            nota_itens_valor_cred_icms
            

            ) 
            $sql_nota_itens");
            $stmt_busca->execute();
            
            //INSERE INFORMAÇÕES NA TABELA NOTA_VOLUME

            if ($dados_pedido['pedido_peso_liquido'] != 0 && $dados_pedido['pedido_peso_bruto'] != 0) {

                $stmt_insere_nf_volume = $auth_user->runQuery("INSERT INTO nota_volume
            (id_nota,
            nota_volume_peso_liquido,
            nota_volume_peso_bruto,
            nota_volume_qtd,
            nota_volume_especie,
            nota_volume_marca
            )
            VALUES(:id_nota, 
            :nota_volume_peso_liquido, 
            :nota_volume_peso_bruto, 
            :nota_volume_qtd, 
            :nota_volume_especie, 
            :nota_volume_marca 
            )");
                $stmt_insere_nf_volume->bindparam(":id_nota", $last_id);
                $stmt_insere_nf_volume->bindparam(":nota_volume_peso_liquido", $dados_pedido['pedido_peso_liquido']);
                $stmt_insere_nf_volume->bindparam(":nota_volume_peso_bruto", $dados_pedido['pedido_peso_bruto']);
                $stmt_insere_nf_volume->bindparam(":nota_volume_qtd", $dados_pedido['pedido_quantidade']);
                $stmt_insere_nf_volume->bindparam(":nota_volume_especie", $dados_pedido['pedido_especie']);
                $stmt_insere_nf_volume->bindparam(":nota_volume_marca", $dados_pedido['pedido_marca']);

                $stmt_insere_nf_volume->execute();
            }
            //INSERE INFORMAÇÕES NA TABELA NOTA_REFERENCIA
            if ($dados_pedido['pedido_referencia']) {
                $stmt_insere_nf_referencia = $auth_user->runQuery("INSERT INTO nota_referencia
            (id_nota,
            nota_referencia_chave
            )
            VALUES(:id_nota, 
            :nota_referencia_chave 
            )");
                $stmt_insere_nf_referencia->bindparam(":id_nota", $last_id);
                $stmt_insere_nf_referencia->bindparam(":nota_referencia_chave", $dados_pedido['pedido_referencia']);
                $stmt_insere_nf_referencia->execute();
            }
            //INSERE DADOS DO CREDITO DO ICMS
            // INSERE AS INFORMAÇÕES DESCRITAS NO PEDIDO 
            $testey = '.';
            if ($dados_pedido['pedido_observacao']) {


                $stmt_insere_nf_inf_comp = $auth_user->runQuery("INSERT INTO nota_inf_comp
            (id_nota,
            nota_inf_comp_apelido,
            nota_inf_comp_complemento
            )
            VALUES(:id_nota, 
            
            :nota_inf_comp_apelido,
            :nota_inf_comp_complemento
            )");
                $stmt_insere_nf_inf_comp->bindparam(":id_nota", $last_id);
                $stmt_insere_nf_inf_comp->bindparam(":nota_inf_comp_apelido", $testey);
                $stmt_insere_nf_inf_comp->bindparam(":nota_inf_comp_complemento", $dados_pedido['pedido_observacao']);
                $stmt_insere_nf_inf_comp->execute();
            }

            //INSERE NO CONTAS A RECEBER

            $id_empre = '1';
            $sta = 0;
            //CONTINUAR AQUI E VERIFICAR OS ERROS
            foreach ($aDup as $dup) {
                $nDup = $dup[0]; //Código da Duplicata
                $dVenc = $dup[1]; //Vencimento
                $vDup = $dup[2]; // Valor
                //$resp = $nfe->tagdup($nDup, $dVenc, $vDup);

                $stmt_co = $auth_user->runQuery("INSERT INTO contas_receber
            (id_empresa, id_nota, id_pedido, contas_receber_valor, contas_receber_numero, contas_receber_data,
            contas_receber_vencimento, contas_receber_status, id_cliente)
            VALUES(:id_empresa, :id_nota, :id_pedido, :valor, :numero, :data, :vencimento, :status, :id_cliente)");

                $stmt_co->bindparam(":id_empresa", $id_empre);
                $stmt_co->bindparam(":id_nota", $nNF);
                $stmt_co->bindparam(":id_pedido", $pedido_id);
                $stmt_co->bindparam(":valor", $vDup);
                $stmt_co->bindparam(":numero", $nDup);
                $stmt_co->bindparam(":data", $dhEmi);
                $stmt_co->bindparam(":vencimento", $dVenc);
                $stmt_co->bindparam(":status", $sta);
                $stmt_co->bindparam(":id_cliente", $dados_pedido['cliente_id']);
                // $pedido_id
                $stmt_co->execute();
            }
            //VERIFICA A EXISTENCIA DO TRANSPORTADOR 
            if ($id_transportador != 0) {
                $result = $auth_user->runQuery('UPDATE pedido SET '
                        . 'id_transportador = :id_transportador '
                        . ' WHERE pedido_id = :id');

                $result->execute(array(
                    ':id' => $pedido_id,
                    ':id_transportador' => $id_transportador
                ));
            }
            //ATUALIZA O STATUS DO PEDIDO E O NUMERO DA NOTA PARA A EMISSAO
            //OBS DEVE SER FEITO QUANDO PASSAR POR TODAS AS VALIDAÇÕES ANTERIOR
            $result = $auth_user->runQuery('UPDATE pedido SET '
                    . 'pedido_status = :pedido_status, '
                    . 'pedido_numero_nf = :pedido_numero_nf '
                    . ' WHERE pedido_id = :id');

            $result->execute(array(
                ':id' => $pedido_id,
                ':pedido_status' => $pedido_status,
                ':pedido_numero_nf' => $nNF
            ));

            //ATUALIZA O NUMERO DA NOTA NA EMPRESA 
            $result = $auth_user->runQuery('UPDATE empresa SET '
                    . 'empresa_numero_nfe = :empresa_numero_nfe '
                    . ' WHERE empresa_id = :id');

            $result->execute(array(
                ':id' => 1,
                ':empresa_numero_nfe' => ($nNF + 1)
            ));
            $auth_user->redirect('notas_nova.php');
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    } else {
        $error = "CONFIGURAÇÔES INVALIDAS! VERIFIQUE AS CONFIGURAÇÕES TES/ST.<br>"
                . "N°= {$pedido_id} = Tipo Cliente = {$tipo_cliente}<br>"
                . "Con = {$tipo_consumidor} = UF = {$cliente_estado}<br>"
                . "Origem = {$tes_itens_origem}<br>"
                . "ST = {$id_st_pedido} TES = {$id_tes_pedido} <br>";
        return $error;
    }
}
//TRANSMITE A NFE PARA A SEFAZ E GUARDA OS DADOS NO BANCO
if (isset($_POST['btn-transmite'])) {

    $nota_id = strip_tags($_POST['nota_id']);
    // $chave = strip_tags($_POST['nota_chave']);
    $tpAmb = strip_tags($_POST['nota_ambiente']);
    $numero_nf = strip_tags($_POST['nota_numero_nf']);

    $stmt_busca_nf = $auth_user->runQuery("SELECT * FROM nota WHERE nota_id = :nota_id");
    $stmt_busca_nf->execute(array(":nota_id" => $nota_id));

    $resposta_busca_nf = $stmt_busca_nf->fetch(PDO::FETCH_ASSOC);

    require_once 'notas_gerarxml.php';

    $aResposta = array();
//ENVIA O LOTE A SEFAZ 
// $aXml = file_get_contents("/var/www/nfe/homologacao/assinadas/{$chave}-nfe.xml"); // Ambiente Linux
    $aXml = file_get_contents("C:/xampp/htdocs/alubrasc/nfe/nfes/homologacao/assinadas/{$resposta_busca_nf['nota_chave']}-nfe.xml"); // Ambiente Windows
    $idLote = '';
    $indSinc = '0';
    $flagZip = false;
    $retorno = $nfe2->sefazEnviaLote($aXml, $tpAmb, $idLote, $aResposta, $indSinc, $flagZip);

    // print_r($aResposta);
    //ATUALIZA O STATUS DA NOTA NO BANCO NO ENVIO !!!!!! 
    $atu_nota = $auth_user->runQuery('UPDATE nota SET '
            . 'nota_bStat = :nota_bStat, '
            . 'nota_cStat = :nota_cStat, '
            . 'nota_verAplic = :nota_verAplic, '
            . 'nota_xMotivo = :nota_xMotivo, '
            . 'nota_dhRecbto = :nota_dhRecbto, '
            . 'nota_cUF = :nota_cUF, '
            . 'nota_nREc = :nota_nRec '
            . ' WHERE nota_id = :nota_id');

    $atu_nota->execute(array(
        ':nota_id' => $nota_id,
        ':nota_bStat' => $aResposta['bStat'],
        ':nota_cStat' => $aResposta['cStat'],
        ':nota_verAplic' => $aResposta['verAplic'],
        ':nota_xMotivo' => $aResposta['xMotivo'],
        ':nota_dhRecbto' => $aResposta['dhRecbto'],
        ':nota_cUF' => $aResposta['cUF'],
        ':nota_nRec' => $aResposta['nRec']
    ));




    // echo "PEGUEI O RECIBO E PASSEI POR PARAMETRO = " . $aResposta['nRec'] . "<BR><BR>";
//$recibo = $_REQUEST[$aResposta['nRec']];
//PEGA O RETORNO DO PROTOCOLO DA SEFAZ
//VERIFICAR O SALVAMENTO DO ARQUIVO
    $recibo = $aResposta['nRec'];
//$recibo = '423002166623702';
    // echo $recibo;
    $retorno = $nfe2->sefazConsultaRecibo($recibo, $tpAmb, $aResposta);
    //  echo '<br><br><pre>';
    // echo htmlspecialchars($nfe2->soapDebug);
    // echo '</pre><br><br><pre>';
    // print_r($aResposta);
    // echo "</pre><br>";
//$tpAmb = '2';
//$recibo = '423002166620869';
//$aResposta = array();
//$retorno = $nfe2->sefazConsultaRecibo($aResposta['nRec'], $tpAmb, $aResposta);
//print_r($aResposta);
    //ATUALIZA O BANCO COM A CONSULTA DO RECIBO DA NOTA !!!!!! 
    $atu_protocolo = $auth_user->runQuery('UPDATE nota SET '
            . 'nota_cStat = :nota_cStat, '
            . 'nota_xMotivo = :nota_xMotivo, '
            . 'nota_digVal = :nota_digVal, '
            . 'nota_nProt = :nota_nProt '
            . ' WHERE nota_numero_nf = :nota_numero_nf');

    $atu_protocolo->execute(array(
        ':nota_numero_nf' => $numero_nf,
        ':nota_cStat' => $aResposta["aProt"]["0"]["cStat"],
        ':nota_xMotivo' => $aResposta["aProt"]["0"]["xMotivo"],
        ':nota_digVal' => $aResposta["aProt"]["0"]["digVal"],
        ':nota_nProt' => $aResposta["aProt"]["0"]["nProt"]
    ));




    //echo '<br><br>';
    // print_r($aResposta['nRec']);
//CONSULTA O PROTOCOLO E ADICIONA A AUTORIZACAO NA NOTA

    $pathNFefile = "C:/xampp/htdocs/alubrasc/nfe/nfes/homologacao/assinadas/{$resposta_busca_nf['nota_chave']}-nfe.xml";
    if (!$indSinc) {
        $pathProtfile = "C:/xampp/htdocs/alubrasc/nfe/nfes/homologacao/temporarias/201702/{$recibo}-retConsReciNFe.xml";
    } else {
        $pathProtfile = "C:/xampp/htdocs/alubrasc/nfe/nfes/homologacao/temporarias/201702/{$recibo}-retConsReciNFe.xml";
    }

    $saveFile = true;
    $retorno = $nfe2->addProtocolo($pathNFefile, $pathProtfile, $saveFile);
    // echo '<br><br><pre>';
    // echo htmlspecialchars($retorno);
    // echo "</pre><br>";
    if ($aResposta["aProt"]["0"]["cStat"] == 100) {
        $status = 4;
    } else {
        $status = 3;
    }

    //ATUALIZA O STATUS DA NOTA PARA PARA LIBERAR A IMPRESSAO OBS: isso deve ser feito depois que a nfe foi emitida
    $result = $auth_user->runQuery('UPDATE nota SET '
            . 'nota_status = :nota_status '
            . ' WHERE nota_id = :id');

    $result->execute(array(
        ':id' => $nota_id,
        ':nota_status' => $status
    ));
    $auth_user->redirect("index.php");
}
//GERA A DANFE DA NFE
if (isset($_POST['btn-danfe'])) {

    $chave = strip_tags($_POST['nota_chave']);

    // $chave = '42160811169963000130550010000000641729022219';
    $xmlProt = "C:/xampp/htdocs/alubrasc/nfe/nfes/homologacao/enviadas/aprovadas/201702/{$chave}-protNFe.xml";
// Uso da nomeclatura '-danfe.pdf' para facilitar a diferenciação entre PDFs DANFE e DANFCE salvos na mesma pasta...
    $pdfDanfe = "C:/xampp/htdocs/alubrasc/nfe/nfes/homologacao/pdf/201702/{$chave}-danfe.pdf";

    $docxml = FilesFolders::readFile($xmlProt);
    $danfe = new Danfe($docxml, 'P', 'A4', $nfe->aConfig['aDocFormat']->pathLogoFile, 'I', '');
    $id = $danfe->montaDANFE();
    $salva = $danfe->printDANFE($pdfDanfe, 'F'); //Salva o PDF na pasta
    //$abre = $danfe->printDANFE("{$id}-danfe.pdf", 'I'); //Abre o PDF no Navegador
    $abre = $danfe->printDANFE("{$id}-danfe.pdf", 'D'); // Forca abrir o Downloald
}
//ENVIA A DANFE E O XML POR EMAIL
if (isset($_POST['btn-email'])) {


    $chave = strip_tags($_POST['nota_chave']);

    $pathXml = "C:/xampp/htdocs/alubrasc/nfe/nfes/homologacao/enviadas/aprovadas/201702/{$chave}-protNFe.xml";
    $pathPdf = "C:/xampp/htdocs/alubrasc/nfe/nfes/homologacao/pdf/201702/{$chave}-danfe.pdf";

    $aMails = array(); //se for um array vazio a classe Mail irá pegar os emails do xml
    $templateFile = ''; //se vazio usará o template padrão da mensagem
    $comPdf = true; //se true, anexa a DANFE no e-mail
    try {
        $nfe2->enviaMail($pathXml, $aMails, $templateFile, $comPdf, $pathPdf);

        // echo "DANFE enviada com sucesso!!!";
    } catch (NFePHP\Common\Exception\RuntimeException $e) {
        echo $e->getMessage();
    }
}
// VISUALIZAR O DANFE ANTES DE EMITIR
if (isset($_POST['btn-visualizar'])) {

    // $chave = strip_tags($_POST['nota_chave']);
    //$chave = strip_tags($_POST['nota_chave']);
    $nota_id = strip_tags($_POST['nota_id']);

    $stmt_busca_nf = $auth_user->runQuery("SELECT * FROM nota WHERE nota_id = :nota_id");
    $stmt_busca_nf->execute(array(":nota_id" => $nota_id));

    $resposta_busca_nf = $stmt_busca_nf->fetch(PDO::FETCH_ASSOC);

    require_once 'notas_gerarxml.php';

    $stmt_busca_nf1 = $auth_user->runQuery("SELECT * FROM nota WHERE nota_id = :nota_id");
    $stmt_busca_nf1->execute(array(":nota_id" => $nota_id));

    $resposta_busca_nf1 = $stmt_busca_nf1->fetch(PDO::FETCH_ASSOC);

    $chave = $resposta_busca_nf1['nota_chave'];



    // $chave = '42160811169963000130550010000000641729022219';
    $xmlProt = "C:/xampp/htdocs/alubrasc/nfe/nfes/homologacao/assinadas/{$chave}-nfe.xml";
// Uso da nomeclatura '-danfe.pdf' para facilitar a diferenciação entre PDFs DANFE e DANFCE salvos na mesma pasta...
    $pdfDanfe = "C:/xampp/htdocs/alubrasc/nfe/nfes/homologacao/pdf/teste/{$chave}-danfe.pdf";

    $docxml = FilesFolders::readFile($xmlProt);
    //$danfe = new Danfe($docxml, 'P', 'A4', $nfe->aConfig['aDocFormat']->pathLogoFile, 'I', '');
    $danfe = new Danfe($docxml, 'P', 'A4', $nfe2->aConfig['aDocFormat']->pathLogoFile, 'I', '');
    $id = $danfe->montaDANFE();
    $salva = $danfe->printDANFE($pdfDanfe, 'F'); //Salva o PDF na pasta
    //$abre = $danfe->printDANFE("{$id}-danfe.pdf", 'I'); //Abre o PDF no Navegador
    $abre = $danfe->printDANFE("{$id}-danfe.pdf", 'D'); // Forca abrir o Downloald
}
//EMISSAO DA CARTA DE CORRECAO
if (isset($_POST['btn-cartacorrecao'])) {

    $nota_id = strip_tags($_POST['nota_id']);

    $chNFe = strip_tags($_POST['nota_chave']);
    $tpAmb = strip_tags($_POST['nota_ambiente']);
    $nota_numero_nf = strip_tags($_POST['nota_numero_nf']);
    $xCorrecao = ucwords(strip_tags($_POST['nota_cartacorrecao_xCorrecao']));

    $stmt_total = $auth_user->runQuery("SELECT COUNT(id_nota) FROM nota_cartacorrecao WHERE id_nota = $nota_id");
    $stmt_total->execute();
    $tot = $stmt_total->fetch(PDO::FETCH_ASSOC);

    $nSeqEvento = $tot['COUNT(id_nota)'] + 1;
    //echo "!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!".$nSeqEvento;
    //$chNFe = '42160811169963000130550010000000891578646854';
    //$tpAmb = '2';
    // $xCorrecao = 'Teste de carta de correcao em ambiente homologacao 2';
    //$nSeqEvento = 2;
    // var_dump("Chegou aqui certinho !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!");
    $aResposta = array();

    $retorno = $nfe->sefazCCe($chNFe, $tpAmb, $xCorrecao, $nSeqEvento, $aResposta);

    $stmt_carta = $auth_user->runQuery("INSERT INTO nota_cartacorrecao
            (nota_cartacorrecao_id, 
            id_nota, 
            nota_cartacorrecao_bStat,
            nota_cartacorrecao_versao,
            nota_cartacorrecao_idlote,
            nota_cartacorrecao_tpAmb,
            nota_cartacorrecao_verAplic,
            nota_cartacorrecao_cOrgao,
            nota_cartacorrecao_cStat,
            nota_cartacorrecao_xMotivo,
            nota_cartacorrecao_chNFe,
            nota_cartacorrecao_tpEvento,
            nota_cartacorrecao_xEvento,
            nota_cartacorrecao_nSeqEvento,
            nota_cartacorrecao_cOrgaoAutor,
            nota_cartacorrecao_dhRegEvento,
            nota_cartacorrecao_CNPJDest,
            nota_cartacorrecao_emailDest,
            nota_cartacorrecao_nProt,
            nota_cartacorrecao_xCorrecao)
            VALUES( '',
            :id_nota, 
            :nota_cartacorrecao_bStat,
            :nota_cartacorrecao_versao,
            :nota_cartacorrecao_idlote,
            :nota_cartacorrecao_tpAmb,
            :nota_cartacorrecao_verAplic,
            :nota_cartacorrecao_cOrgao,
            :nota_cartacorrecao_cStat,
            :nota_cartacorrecao_xMotivo,
            :nota_cartacorrecao_chNFe,
            :nota_cartacorrecao_tpEvento,
            :nota_cartacorrecao_xEvento,
            :nota_cartacorrecao_nSeqEvento,
            :nota_cartacorrecao_cOrgaoAutor,
            :nota_cartacorrecao_dhRegEvento,
            :nota_cartacorrecao_CNPJDest,
            :nota_cartacorrecao_emailDest,
            :nota_cartacorrecao_nProt,
            :nota_cartacorrecao_xCorrecao)");

    $stmt_carta->bindparam(":id_nota", $nota_id);
    $stmt_carta->bindparam(":nota_cartacorrecao_bStat", $aResposta['bStat']);
    $stmt_carta->bindparam(":nota_cartacorrecao_versao", $aResposta['versao']);
    $stmt_carta->bindparam(":nota_cartacorrecao_idlote", $aResposta['idLote']);
    $stmt_carta->bindparam(":nota_cartacorrecao_tpAmb", $aResposta['tpAmb']);
    $stmt_carta->bindparam(":nota_cartacorrecao_verAplic", $aResposta['verAplic']);
    $stmt_carta->bindparam(":nota_cartacorrecao_cOrgao", $aResposta['cOrgao']);
    $stmt_carta->bindparam(":nota_cartacorrecao_cStat", $aResposta["evento"]["0"]["cStat"]);
    $stmt_carta->bindparam(":nota_cartacorrecao_xMotivo", $aResposta["evento"]["0"]["xMotivo"]);
    $stmt_carta->bindparam(":nota_cartacorrecao_chNFe", $aResposta["evento"]["0"]["chNFe"]);
    $stmt_carta->bindparam(":nota_cartacorrecao_tpEvento", $aResposta["evento"]["0"]['tpEvento']);
    $stmt_carta->bindparam(":nota_cartacorrecao_xEvento", $aResposta["evento"]["0"]['xEvento']);
    $stmt_carta->bindparam(":nota_cartacorrecao_nSeqEvento", $aResposta["evento"]["0"]['nSeqEvento']);
    $stmt_carta->bindparam(":nota_cartacorrecao_cOrgaoAutor", $aResposta["evento"]["0"]['cOrgaoAutor']);
    $stmt_carta->bindparam(":nota_cartacorrecao_dhRegEvento", $aResposta["evento"]["0"]['dhRegEvento']);
    $stmt_carta->bindparam(":nota_cartacorrecao_CNPJDest", $aResposta["evento"]["0"]['CNPJDest']);
    $stmt_carta->bindparam(":nota_cartacorrecao_emailDest", $aResposta["evento"]["0"]['emailDest']);
    $stmt_carta->bindparam(":nota_cartacorrecao_nProt", $aResposta["evento"]["0"]['nProt']);
    $stmt_carta->bindparam(":nota_cartacorrecao_xCorrecao", $xCorrecao);
    $stmt_carta->execute();



    $auth_user->redirect("notas_cartacorrecao.php");

    // echo '<br><br><PRE>';
    // echo htmlspecialchars($nfe->soapDebug);
    // echo '</PRE><BR>';
    // print_r($aResposta);
    // echo "<br>";
}
//IMPRESSAO DA CARTA DE CORRECAO
if (isset($_POST['btn-cartaimprime'])) {

    $nota_id = strip_tags($_POST['nota_id']);

    $chave = strip_tags($_POST['nota_chave']);
    $nota_nseqevento = strip_tags($_POST['nota_nseqevento']);
    //$tpAmb = strip_tags($_POST['nota_ambiente']);

    $empresa_id = 1;
    $stmt_emp = $auth_user->runQuery("SELECT * FROM empresa, municipio WHERE id_municipio = municipio_id and empresa_id=:empresa_id");
    $stmt_emp->execute(array(":empresa_id" => $empresa_id));
    $empre = $stmt_emp->fetch(PDO::FETCH_ASSOC);



    //$xml = "C:/xampp/htdocs/nota/nfe/nfes/homologacao/cartacorrecao/201608/42160811169963000130550010000006501861077880-CCe-3-procEvento.xml";
    $xml = "C:/xampp/htdocs/alubrasc/nfe/nfes/homologacao/cartacorrecao/201702/{$chave}-CCe-{$nota_nseqevento}-procEvento.xml";
    $aEnd = array(
        'razao' => $empre['empresa_nome'],
        'logradouro' => $empre['empresa_logradouro'],
        'numero' => $empre['empresa_numero'],
        'complemento' => $empre['empresa_complemento'],
        'bairro' => $empre['empresa_bairro'],
        'CEP' => $empre['empresa_cep'],
        'municipio' => $empre['municipio_nome'],
        'UF' => $empre['municipio_sigla'],
        'telefone' => $empre['empresa_telefone'],
        'email' => $empre['empresa_email']
            /* 'razao' => 'QQ Comercio e Ind. Ltda',
              'logradouro' => 'Rua vinte e um de março',
              'numero' => '200',
              'complemento' => 'sobreloja',
              'bairro' => 'Nova Onda',
              'CEP' => '99999-999',
              'municipio' => 'Onda',
              'UF' => 'MG',
              'telefone' => '33333-3333',
              'email' => 'qq@gmail.com' */
    );

    $docxml = FilesFolders::readFile($xml);
    $dacce = new Dacce($docxml, 'P', 'A4', '../images/logo.jpg', 'I', $aEnd);
    $id = $dacce->chNFe . '-CCE';
    $teste = $dacce->printDACCE($id . '.pdf', 'D');
}
//CANCELA A NFE
if (isset($_POST['btn-cancelanfe'])) {

    $nota_id = strip_tags($_POST['nota_id']);
    $chave = strip_tags($_POST['nota_chave']);
    $nProt = strip_tags($_POST['nota_prot']);
    $xJust = strip_tags($_POST['nota_cancela_descricao']);
    $tpAmb = strip_tags($_POST['nota_ambiente']);
    $aResposta = array();
    //$chave = '42160811169963000130550010000006501861077880';
    //$nProt = '342160000420232';
    //$tpAmb = '2';
    //$xJust = 'Teste de cancelamento em ambiente de homologação';

    $retorno = $nfe->sefazCancela($chave, $tpAmb, $xJust, $nProt, $aResposta);
    /* echo '<br><br><PRE>';
      echo htmlspecialchars($nfe->soapDebug);
      echo '</PRE><BR>';
      print_r($aResposta);
      echo "<br>"; */
    $stmt_cancela = $auth_user->runQuery("INSERT INTO nota_cancela
            (nota_cancela_id, 
            id_nota,
            nota_cancela_bStat,
            nota_cancela_versao,
            nota_cancela_idLote,
            nota_cancela_tpAmb,
            nota_cancela_verAplic,
            nota_cancela_cOrgao,
            nota_cancela_cStat,
            nota_cancela_xMotivo,
            nota_cancela_chNFe,
            nota_cancela_tpEvento,
            nota_cancela_xEvento,
            nota_cancela_nSeqEvento,
            nota_cancela_cOrgaoAutor,
            nota_cancela_dhRegEvento,
            nota_cancela_CNPJDest,
            nota_cancela_emailDest,
            nota_cancela_nProt,
            nota_cancela_descricao)
            VALUES( '',
            :id_nota,
            :nota_cancela_bStat,
            :nota_cancela_versao,
            :nota_cancela_idLote,
            :nota_cancela_tpAmb,
            :nota_cancela_verAplic,
            :nota_cancela_cOrgao,
            :nota_cancela_cStat,
            :nota_cancela_xMotivo,
            :nota_cancela_chNFe,
            :nota_cancela_tpEvento,
            :nota_cancela_xEvento,
            :nota_cancela_nSeqEvento,
            :nota_cancela_cOrgaoAutor,
            :nota_cancela_dhRegEvento,
            :nota_cancela_CNPJDest,
            :nota_cancela_emailDest,
            :nota_cancela_nProt,
            :nota_cancela_descricao)");

    $stmt_cancela->bindparam(":id_nota", $nota_id);
    $stmt_cancela->bindparam(":nota_cancela_bStat", $aResposta['bStat']);
    $stmt_cancela->bindparam(":nota_cancela_versao", $aResposta['versao']);
    $stmt_cancela->bindparam(":nota_cancela_idLote", $aResposta['idLote']);
    $stmt_cancela->bindparam(":nota_cancela_tpAmb", $aResposta['tpAmb']);
    $stmt_cancela->bindparam(":nota_cancela_verAplic", $aResposta['verAplic']);
    $stmt_cancela->bindparam(":nota_cancela_cOrgao", $aResposta['cOrgao']);
    $stmt_cancela->bindparam(":nota_cancela_cStat", $aResposta["evento"]["0"]["cStat"]);
    $stmt_cancela->bindparam(":nota_cancela_xMotivo", $aResposta["evento"]["0"]["xMotivo"]);
    $stmt_cancela->bindparam(":nota_cancela_chNFe", $aResposta["evento"]["0"]["chNFe"]);
    $stmt_cancela->bindparam(":nota_cancela_tpEvento", $aResposta["evento"]["0"]["tpEvento"]);
    $stmt_cancela->bindparam(":nota_cancela_xEvento", $aResposta["evento"]["0"]["xEvento"]);
    $stmt_cancela->bindparam(":nota_cancela_nSeqEvento", $aResposta["evento"]["0"]["nSeqEvento"]);
    $stmt_cancela->bindparam(":nota_cancela_cOrgaoAutor", $aResposta["evento"]["0"]["cOrgaoAutor"]);
    $stmt_cancela->bindparam(":nota_cancela_dhRegEvento", $aResposta["evento"]["0"]["dhRegEvento"]);
    $stmt_cancela->bindparam(":nota_cancela_CNPJDest", $aResposta["evento"]["0"]["CNPJDest"]);
    $stmt_cancela->bindparam(":nota_cancela_emailDest", $aResposta["evento"]["0"]["emailDest"]);
    $stmt_cancela->bindparam(":nota_cancela_nProt", $aResposta["evento"]["0"]["nProt"]);
    $stmt_cancela->bindparam(":nota_cancela_descricao", $xJust);

    $stmt_cancela->execute();
    //ATUALIZA A NOTA PARA CANCELADA 
    $nota_status = 5;
    $atu_nota = $auth_user->runQuery('UPDATE nota SET '
            . 'nota_status = :nota_status '
            . ' WHERE nota_id = :nota_id');

    $atu_nota->execute(array(
        ':nota_id' => $nota_id,
        ':nota_status' => $nota_status
    ));


    $auth_user->redirect("notas_cancela.php");
}
//INUTILIZA NUMEROS DA NFE
if (isset($_POST['btn-inutilizar'])) {

    $id = 1;
    $stmt_inu = $auth_user->runQuery("SELECT * FROM empresa WHERE empresa_id = :empresa_id");
    $stmt_inu->execute(array(":empresa_id" => $id));
    $inu = $stmt_inu->fetch(PDO::FETCH_ASSOC);

    $inu['empresa_numero_nfe'];


    $aResposta = array();
    $nSerie = $inu['empresa_serie_nfe'];
    $nIni = strip_tags($_POST['nIni']);
    $nFin = strip_tags($_POST['nFin']);
    //$xJust = 'teste de inutilização de notas fiscais em homologacao';
    $xJust = ucwords(strip_tags($_POST['xJust']));
    $tpAmb = $inu['empresa_ambiente_nfe'];

    $xml = $nfe2->sefazInutiliza($nSerie, $nIni, $nFin, $xJust, $tpAmb, $aResposta);

    $stmt_inu_salva = $auth_user->runQuery("INSERT INTO nota_inu
            (nota_inu_id,
            id_nota,
            nota_inu_bStat,
            nota_inu_versao,
            nota_inu_tpAmb,
            nota_inu_verAplic,
            nota_inu_cStat,
            nota_inu_xMotivo,
            nota_inu_cUF,
            nota_inu_dhRecbto,
            nota_inu_ano,
            nota_inu_CNPJ,
            nota_inu_mod,
            nota_inu_serie,
            nota_inu_nNFIni,
            nota_inu_nNFFin,
            nota_inu_nProt,
            nota_inu_descricao)
            VALUES( '',
            :id_nota,
            :nota_inu_bStat,
            :nota_inu_versao,
            :nota_inu_tpAmb,
            :nota_inu_verAplic,
            :nota_inu_cStat,
            :nota_inu_xMotivo,
            :nota_inu_cUF,
            :nota_inu_dhRecbto,
            :nota_inu_ano,
            :nota_inu_CNPJ,
            :nota_inu_mod,
            :nota_inu_serie,
            :nota_inu_nNFIni,
            :nota_inu_nNFFin,
            :nota_inu_nProt,
            :nota_inu_descricao)");

    $stmt_inu_salva->bindparam(":id_nota", $nota_id);
    $stmt_inu_salva->bindparam(":nota_inu_bStat", $aResposta['bStat']);
    $stmt_inu_salva->bindparam(":nota_inu_versao", $aResposta['versao']);
    $stmt_inu_salva->bindparam(":nota_inu_tpAmb", $aResposta['tpAmb']);
    $stmt_inu_salva->bindparam(":nota_inu_verAplic", $aResposta['verAplic']);
    $stmt_inu_salva->bindparam(":nota_inu_cStat", $aResposta['cStat']);
    $stmt_inu_salva->bindparam(":nota_inu_xMotivo", $aResposta['xMotivo']);
    $stmt_inu_salva->bindparam(":nota_inu_cUF", $aResposta['cUF']);
    $stmt_inu_salva->bindparam(":nota_inu_dhRecbto", $aResposta['dhRecbto']);
    $stmt_inu_salva->bindparam(":nota_inu_ano", $aResposta['ano']);
    $stmt_inu_salva->bindparam(":nota_inu_CNPJ", $aResposta['CNPJ']);
    $stmt_inu_salva->bindparam(":nota_inu_mod", $aResposta['mod']);
    $stmt_inu_salva->bindparam(":nota_inu_serie", $aResposta['serie']);
    $stmt_inu_salva->bindparam(":nota_inu_nNFIni", $aResposta['nNFIni']);
    $stmt_inu_salva->bindparam(":nota_inu_nNFFin", $aResposta['nNFFin']);
    $stmt_inu_salva->bindparam(":nota_inu_nProt", $aResposta['nProt']);
    $stmt_inu_salva->bindparam(":nota_inu_descricao", $xJust);

    $stmt_inu_salva->execute();
    $nota_status = 6;

    for ($i = $nIni; $i <= $nFin; $i++) {
        $atu_nota = $auth_user->runQuery('UPDATE nota SET '
                . 'nota_status = :nota_status '
                . ' WHERE nota_id = :nota_id');

        $atu_nota->execute(array(
            ':nota_id' => $i,
            ':nota_status' => $nota_status
        ));
    }
    $auth_user->redirect("notas_inutilizar.php");
}
//BUSCA PARA A EDITAÇAO NFE COM REJEICAO DA SEFAZ
if (isset($_POST['btn-edita'])) {
    $nota_id = strip_tags($_POST['nota_id']);
   
    
    $auth_user->redirect("notas_editar.php?nota_id=$nota_id");
}
//BUSCA DINAMICA NOME CLIENTE NA EDICAO DA NOTA
if (isset($_POST["query"])) {
    $output = '';
    $query = $auth_user->runQuery("SELECT * FROM cliente WHERE cliente_nome LIKE '%" . strtoupper($_POST["query"]) . "%' or "
            . "cliente_cpf_cnpj LIKE '%" . $_POST["query"] . "%'");
    //$query->execute();
    $output = '<ul class="list-unstyled">';
    if ($query->execute() > 0) {
        for ($i = 0; $row = $query->fetch(); $i++) {
            $output .= '<li>' . $row["cliente_nome"] . '</li>';
        }
    } else {
        $output .= '<li>Cliente Não Encontrado</li>';
    }
    $output .= '</ul>';
    echo $output;

    unset($query);
}
//CADASTRA UMA NOVA NFE NO SISTEMA 
if (isset($_POST['btn-cadastro'])) {

    $nfe = new MakeNFe();

    $stmt_empre = $auth_user->runQuery("SELECT * FROM empresa, municipio, estado WHERE
    empresa.id_estado = estado.estado_id AND 
    empresa.id_municipio = municipio.municipio_id AND empresa.empresa_id = 1");
    $stmt_empre->execute();
    $dad = $stmt_empre->fetch(PDO::FETCH_ASSOC);

    $nome_cliente = $_POST['cliente_nome'];
    $status = 3;

    //BUSCA O CLIENTE NO BANCO DE DADOS PARA SALVAR NA NFE
    $stmt = $auth_user->runQuery("SELECT * FROM cliente WHERE"
            . " cliente_nome=:nome_cliente");
    $stmt->execute(array(":nome_cliente" => $nome_cliente));
    $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

    // BUSCA PELA FORMA DE PAGAMENTO DO CADASTRO DA NOTA

    $id_forma = $_POST['id_forma_pagamento'];

    $forma = $auth_user->runQuery("SELECT * FROM forma_pagamento WHERE forma_pagamento_id ="
            . " :forma_pagamento_id");
    $forma->execute(array("forma_pagamento_id" => $id_forma));
    $form = $forma->fetch(PDO::FETCH_ASSOC);

    $frete = $_POST['nota_frete'];
    $cUF = $dad['estado_codigo_ibge']; //codigo numerico do estado
    $cNF = rand(10000000, 99999999); //numero aleatório da NF
    $natOp = strtoupper($_POST['nota_natureza_operacao']); //natureza da operação
    $indPag = $form['forma_pagamento_tipo'];
    //0=Pagamento à vista; 1=Pagamento a prazo; 2=Outros
    $mod = $dad['empresa_modelo_nfe']; //modelo da NFe 55 ou 65 essa última NFCe
    $serie = $dad['empresa_serie_nfe']; //serie da NFe
    $nNF = $dad['empresa_numero_nfe']; // numero da NFe
    $dhEmi = date("y-m-d\TH:i:sP"); //Formato: “AAAA-MM-DDThh:mm:ssTZD” (UTC - Universal Coordinated Time).
    $dhSaiEnt = date("y-m-d\TH:i:sP"); //Não informar este campo para a NFC-e.
    $tpNF = $_POST['nota_tipo'];
    $idDest = $_POST['nota_tipo_operacao']; //1=Operação interna; 2=Operação interestadual; 3=Operação com exterior.
    $cMunFG = $dad['municipio_cod_ibge'];
    $tpImp = $dad['empresa_tipo_impressao']; //0=Sem geração de DANFE; 1=DANFE normal, Retrato; 2=DANFE normal, Paisagem;

    $tpEmis = '1'; //1=Emissão normal (não em contingência);

    $tpAmb = $dad['empresa_ambiente_nfe']; //1=Produção; 2=Homologação
    $finNFe = $_POST['nota_finalidade']; //1=NF-e normal; 2=NF-e complementar; 3=NF-e de ajuste; 4=Devolução/Retorno.
    $indFinal = $_POST['nota_indicador_finalidade']; //0=Normal; 1=Consumidor final;
    $indPres = $_POST['nota_indicador_presencial']; //0=Não se aplica (por exemplo, Nota Fiscal complementar ou de ajuste);

    $procEmi = '0'; //0=Emissão de NF-e com aplicativo do contribuinte;

    $verProc = $dad['empresa_versao_sistema']; //versão do aplicativo emissor
    $dhCont = ''; //entrada em contingência AAAA-MM-DDThh:mm:ssTZD
    $xJust = ''; //Justificativa da entrada em contingência
//Numero e versão da NFe (infNFe)
    $ano = date('y', strtotime($dhEmi));
    $mes = date('m', strtotime($dhEmi));
    $cnpj = $dad['empresa_cnpj'];

    $nota_cliente = $userRow["cliente_nome"];
    //ATUALIZA O NUMERO DA NFE NO BANCO DE DADOS 
    $atualiza_nu = $auth_user->runQuery('UPDATE empresa SET '
            . 'empresa_numero_nfe = :empresa_numero_nfe '
            . ' WHERE empresa_id = :empresa_id');

    $atualiza_nu->execute(array(
        ':empresa_id' => 1,
        ':empresa_numero_nfe' => ($nNF + 1)
    ));

    try {

        // GRAVA NA TABELA NOTA OS DADOS 
        if ($userRow > 0) {
            $sql2 = "INSERT INTO nota (
                nota_numero_uf,
                nota_numero,
                nota_natureza_operacao,
                nota_indpag,
                nota_modelo,
                nota_serie,
                nota_numero_nf,
                nota_data_emissao, 
                nota_data_saida, 
                nota_tipo,
                nota_frete,
                nota_tipo_operacao,
                nota_codigo_municipio,
                nota_impressao,
                nota_tipo_emissao,
                nota_ambiente,
                nota_finalidade,
                nota_indicador_finalidade,
                nota_indicador_presencial,                
                nota_tipo_sistema,
                nota_versao_sistema,
                nota_data_contigencia,
                nota_justificativa_contigencia,
                nota_ano,
                nota_mes,
                nota_cnpj,
                nota_cliente,
                nota_status,
                identificador_cliente
                )
                VALUES ('" . $cUF . "',"
                    . "'" . $cNF . "',"
                    . "'" . $natOp . "',"
                    . " '" . $indPag . "',"
                    . " '" . $mod . "',"
                    . " '" . $serie . "',"
                    . " '" . $nNF . "',"
                    . " '" . $dhEmi . "',"
                    . " '" . $dhSaiEnt . "',"
                    . " '" . $tpNF . "',"
                    . " '" . $frete . "',"
                    . " '" . $idDest . "',"
                    . " '" . $cMunFG . "',"
                    . " '" . $tpImp . "',"
                    . " '" . $tpEmis . "',"
                    . " '" . $tpAmb . "',"
                    . " '" . $finNFe . "',"
                    . " '" . $indFinal . "',"
                    . " '" . $indPres . "',"
                    . " '" . $procEmi . "', "
                    . " '" . $verProc . "', "
                    . " '" . $dhCont . "', "
                    . " '" . $xJust . "', "
                    . " '" . $ano . "', "
                    . " '" . $mes . "', "
                    . " '" . $cnpj . "', "
                    . " '" . $userRow["cliente_nome"] . "', "
                    . " '" . $status . "',"
                    . " '" . $userRow['cliente_id'] . "' "
                    . ")";

            $retorno = $auth_user->registro($sql2);

//REDIRECIONA PARA CADASTRAR OS ITENS DA NOTA
            $auth_user->redirect("../notas_itens/index.php?id=" . $retorno);
        } else {
            echo 'Erro na Busca do Cliente no banco de dados ';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//ALTERA DADOS DOS ITENS DA NFE REJEITADA OU NÃO VALIDADA.
if (isset($_POST['btn-altera'])) {

    //COMPLEMENTO NFE
    $nota_itens_id = $_POST['nota_itens_id'];
    $nota_itens_id_st = $_POST['nota_itens_id_st'];
    $nota_itens_id_tes = $_POST['nota_itens_id_tes'];
    $nota_itens_qtd = $_POST['nota_itens_qtd'];
    $nota_itens_valor = str_replace(",", ".", strip_tags($_POST['nota_itens_valor']));
    $nota_itens_total = number_format(($nota_itens_qtd * $nota_itens_valor), 2, '.', '');
    $nota_itens_total = str_replace(",", ".", $nota_itens_total);
    $nota_itens_valor_frete = str_replace(",", ".", strip_tags($_POST['nota_itens_valor_frete']));
    $nota_itens_valor_seguro = str_replace(",", ".", strip_tags($_POST['nota_itens_valor_seguro']));
    $nota_itens_valor_desconto = str_replace(",", ".", strip_tags($_POST['nota_itens_valor_desconto']));
    $nota_itens_outras_despesas = str_replace(",", ".", strip_tags($_POST['nota_itens_outras_despesas']));
    $nota_itens_idtot = $_POST['nota_itens_idtot'];
    $nota_itens_numero_compra = $_POST['nota_itens_numero_compra'];
    $nota_itens_item_compra = $_POST['nota_itens_item_compra'];
    $nota_itens_ncm = $_POST['nota_itens_ncm'];
    $nota_itens_numero_nfci = $_POST['nota_itens_numero_nfci'];
    $nota_itens_descricao = $_POST['nota_itens_descricao'];

    // ICMS
    $nota_itens_cst = $_POST['nota_itens_cst'];
    $nota_itens_cest = $_POST['nota_itens_cest'];
    $nota_itens_origem = $_POST['nota_itens_origem'];
    $nota_itens_modalidade_calculo_icms = $_POST['nota_itens_modalidade_calculo_icms'];
    $nota_itens_reducao_calculo_icms = $_POST['nota_itens_reducao_calculo_icms'];
    $nota_itens_base_calculo_icms = (($nota_itens_total + $nota_itens_valor_frete +
            $nota_itens_valor_seguro + $nota_itens_outras_despesas) - $nota_itens_valor_desconto);

    $nota_itens_aliquota = $_POST['nota_itens_aliquota'];
    $nota_itens_valor_icms_op = $_POST['nota_itens_valor_icms_op'];
    $nota_itens_perc_dif = $_POST['nota_itens_perc_dif'];
    $nota_itens_valor_perc_dif = $_POST['nota_itens_valor_perc_dif'];
    //$nota_itens_valor_icms = $_POST['nota_itens_valor_icms'];
    $nota_itens_valor_icms = number_format(($nota_itens_base_calculo_icms * $nota_itens_aliquota) / 100, 2, '.', '');
    $nota_itens_valor_icms = str_replace(",", ".", strip_tags($nota_itens_valor_icms));

    //ICMS PARTILHA
    $nota_itens_par_pobreza = str_replace(",", ".", strip_tags($_POST['nota_itens_par_pobreza']));
    $nota_itens_par_destino = str_replace(",", ".", strip_tags($_POST['nota_itens_par_destino']));
    $nota_itens_par_origem = str_replace(",", ".", strip_tags($_POST['nota_itens_par_origem']));

    //IPI
    $nota_itens_id_ipi = $_POST['nota_itens_id_ipi'];
    $nota_itens_ipi_classe = $_POST['nota_itens_ipi_classe'];
    $nota_itens_ipi_cod = $_POST['nota_itens_ipi_cod'];
   
    $nota_itens_ipi_aliquota = $_POST['nota_itens_ipi_aliquota'];
    $nota_itens_bc_ipi = ($nota_itens_total + $nota_itens_valor_frete + $nota_itens_valor_seguro + $nota_itens_outras_despesas);
    $nota_itens_ipi_valor = number_format(($nota_itens_bc_ipi * $nota_itens_ipi_aliquota) / 100, 2, '.', '');
    $nota_itens_ipi_valor = str_replace(",", ".", strip_tags($nota_itens_ipi_valor));
    //PIS
    $nota_itens_id_pis = $_POST['nota_itens_id_pis'];
    $nota_itens_pis_tipo_calculo = $_POST['nota_itens_pis_tipo_calculo'];
    //$nota_itens_pis_base_calculo = $_POST['nota_itens_pis_base_calculo'];
    //$nota_itens_total + $nota_itens_valor_frete + $nota_itens_valor_seguro + $nota_itens_outras_despesas
    $nota_itens_pis_base_calculo = (($nota_itens_total + $nota_itens_valor_frete + $nota_itens_valor_seguro + $nota_itens_outras_despesas) - $nota_itens_valor_desconto) + $nota_itens_ipi_valor;
    //Base = (Preço do Item + Despesas – Desconto + IPI Outros quando parametrizado*) – % Redução para os códigos de tributação Reduzido ou Outros**
    $nota_itens_pis_aliquota = str_replace(",", ".", strip_tags($_POST['nota_itens_pis_aliquota'])); //$_POST['nota_itens_pis_aliquota'];
    // $nota_itens_pis_valor = $_POST['nota_itens_pis_valor'];
    $nota_itens_pis_valor = number_format(($nota_itens_pis_base_calculo * $nota_itens_pis_aliquota) / 100, 2, '.', '');
    $nota_itens_pis_valor = str_replace(",", ".", strip_tags($nota_itens_pis_valor));

    //PIS ST *****VERIFICAR ISSO CERTINHO *****
    $nota_itens_pis_st_tipo_calculo = $_POST['nota_itens_pis_st_tipo_calculo'];
    $nota_itens_pis_st_base_calculo = $_POST['nota_itens_pis_st_base_calculo'];
    $nota_itens_pis_st_aliquota = str_replace(",", ".", strip_tags($_POST['nota_itens_pis_st_aliquota'])); //$_POST['nota_itens_pis_st_aliquota'];
    $nota_itens_pis_st_valor = $_POST['nota_itens_pis_st_valor'];

    //COFINS
    $nota_itens_id_cofins = $_POST['nota_itens_id_cofins'];
    $nota_itens_cofins_base_calculo = (($nota_itens_total + $nota_itens_valor_frete + $nota_itens_valor_seguro + $nota_itens_outras_despesas) - $nota_itens_valor_desconto) + $nota_itens_ipi_valor;
    $nota_itens_cofins_tipo_calculo = $_POST['nota_itens_cofins_tipo_calculo'];
    $nota_itens_cofins_aliquota = $_POST['nota_itens_cofins_aliquota'];
    //$nota_itens_cofins_valor = $_POST['nota_itens_cofins_valor'];

    $nota_itens_cofins_valor = number_format(($nota_itens_cofins_base_calculo * $nota_itens_cofins_aliquota) / 100, 2, '.', '');
    $nota_itens_cofins_valor = str_replace(",", ".", strip_tags($nota_itens_cofins_valor));

    try {

        $result_nota_itens = $auth_user->runQuery('UPDATE nota_itens SET '
                . 'nota_itens_qtd = :nota_itens_qtd, '
                . 'nota_itens_valor = :nota_itens_valor, '
                . 'nota_itens_total = :nota_itens_total, '
                . 'nota_itens_valor_frete = :nota_itens_valor_frete, '
                . 'nota_itens_valor_seguro = :nota_itens_valor_seguro, '
                . 'nota_itens_valor_desconto = :nota_itens_valor_desconto, '
                . 'nota_itens_outras_despesas = :nota_itens_outras_despesas, '
                . 'nota_itens_idtot = :nota_itens_idtot, '
                . 'nota_itens_numero_compra= :nota_itens_numero_compra, '
                . 'nota_itens_item_compra = :nota_itens_item_compra, '
                . 'nota_itens_numero_nfci = :nota_itens_numero_nfci, '
                . 'nota_itens_descricao = :nota_itens_descricao, '
                . 'nota_itens_ncm = :nota_itens_ncm,'
                . 'nota_itens_cst = :nota_itens_cst,'
                . 'nota_itens_cest = :nota_itens_cest,'
                . 'nota_itens_origem = :nota_itens_origem,'
                . 'nota_itens_modalidade_calculo_icms = :nota_itens_modalidade_calculo_icms,'
                . 'nota_itens_reducao_calculo_icms = :nota_itens_reducao_calculo_icms,'
                . 'nota_itens_base_calculo_icms = :nota_itens_base_calculo_icms,'
                . 'nota_itens_bc_icms = :nota_itens_bc_icms,'
                . 'nota_itens_aliquota = :nota_itens_aliquota,'
                . 'nota_itens_valor_icms_op = :nota_itens_valor_icms_op,'
                . 'nota_itens_perc_dif = :nota_itens_perc_dif,'
                . 'nota_itens_valor_perc_dif = :nota_itens_valor_perc_dif,'
                . 'nota_itens_valor_icms = :nota_itens_valor_icms,'
                . 'nota_itens_par_pobreza = :nota_itens_par_pobreza,'
                . 'nota_itens_par_destino = :nota_itens_par_destino,'
                . 'nota_itens_par_origem = :nota_itens_par_origem,'
                . 'nota_itens_id_ipi = :nota_itens_id_ipi,'
                . 'nota_itens_ipi_classe = :nota_itens_ipi_classe,'
                . 'nota_itens_ipi_cod = :nota_itens_ipi_cod,'
                . 'nota_itens_ipi_tipo_calculo = :nota_itens_ipi_tipo_calculo,'
                . 'nota_itens_ipi_aliquota = :nota_itens_ipi_aliquota,'
                . 'nota_itens_ipi_valor = :nota_itens_ipi_valor,'
                . 'nota_itens_id_pis = :nota_itens_id_pis,'
                . 'nota_itens_pis_tipo_calculo = :nota_itens_pis_tipo_calculo,'
                . 'nota_itens_pis_base_calculo = :nota_itens_pis_base_calculo,'
                . 'nota_itens_pis_aliquota = :nota_itens_pis_aliquota,'
                . 'nota_itens_pis_valor = :nota_itens_pis_valor,'
                . 'nota_itens_pis_st_tipo_calculo = :nota_itens_pis_st_tipo_calculo,'
                . 'nota_itens_pis_st_base_calculo = :nota_itens_pis_st_base_calculo,'
                . 'nota_itens_pis_st_aliquota = :nota_itens_pis_st_aliquota,'
                . 'nota_itens_pis_st_valor = :nota_itens_pis_st_valor,'
                . 'nota_itens_id_cofins = :nota_itens_id_cofins,'
                . 'nota_itens_cofins_tipo_calculo = :nota_itens_cofins_tipo_calculo,'
                . 'nota_itens_cofins_aliquota = :nota_itens_cofins_aliquota,'
                . 'nota_itens_cofins_valor = :nota_itens_cofins_valor'
                . ' WHERE nota_itens_id = :nota_itens_id');

        $result_nota_itens->execute(array(
            ':nota_itens_id' => $nota_itens_id,
            ':nota_itens_qtd' => $nota_itens_qtd,
            ':nota_itens_valor' => $nota_itens_valor,
            ':nota_itens_total' => $nota_itens_total,
            ':nota_itens_valor_frete' => $nota_itens_valor_frete,
            ':nota_itens_valor_seguro' => $nota_itens_valor_seguro,
            ':nota_itens_valor_desconto' => $nota_itens_valor_desconto,
            ':nota_itens_outras_despesas' => $nota_itens_outras_despesas,
            ':nota_itens_idtot' => $nota_itens_idtot,
            ':nota_itens_numero_compra' => $nota_itens_numero_compra,
            ':nota_itens_item_compra' => $nota_itens_item_compra,
            ':nota_itens_numero_nfci' => $nota_itens_numero_nfci,
            ':nota_itens_descricao' => $nota_itens_descricao,
            ':nota_itens_ncm' => $nota_itens_ncm,
            //VERIFICAR AQUI SE PASSA
            ':nota_itens_cst' => $nota_itens_cst,
            ':nota_itens_cest' => $nota_itens_cest,
            ':nota_itens_origem' => $nota_itens_origem,
            ':nota_itens_modalidade_calculo_icms' => $nota_itens_modalidade_calculo_icms,
            ':nota_itens_reducao_calculo_icms' => $nota_itens_reducao_calculo_icms,
            ':nota_itens_base_calculo_icms' => $nota_itens_base_calculo_icms,
            ':nota_itens_bc_icms' => $nota_itens_base_calculo_icms,
            ':nota_itens_aliquota' => $nota_itens_aliquota,
            ':nota_itens_valor_icms_op' => $nota_itens_valor_icms_op,
            ':nota_itens_perc_dif' => $nota_itens_perc_dif,
            ':nota_itens_valor_perc_dif' => $nota_itens_valor_perc_dif,
            ':nota_itens_valor_icms' => $nota_itens_valor_icms,
            //ICMS PARTILHA
            ':nota_itens_par_pobreza' => $nota_itens_par_pobreza,
            ':nota_itens_par_destino' => $nota_itens_par_destino,
            ':nota_itens_par_origem' => $nota_itens_par_origem,
            //IPI
            ':nota_itens_id_ipi' => $nota_itens_id_ipi,
            ':nota_itens_ipi_classe' => $nota_itens_ipi_classe,
            ':nota_itens_ipi_cod' => $nota_itens_ipi_cod,
            ':nota_itens_ipi_tipo_calculo' => $nota_itens_ipi_tipo_calculo,
            ':nota_itens_ipi_aliquota' => $nota_itens_ipi_aliquota,
            ':nota_itens_ipi_valor' => $nota_itens_ipi_valor,
            //PIS
            ':nota_itens_id_pis' => $nota_itens_id_pis,
            ':nota_itens_pis_tipo_calculo' => $nota_itens_pis_tipo_calculo,
            ':nota_itens_pis_base_calculo' => $nota_itens_pis_base_calculo,
            ':nota_itens_pis_aliquota' => $nota_itens_pis_aliquota,
            ':nota_itens_pis_valor' => $nota_itens_pis_valor,
            //PIS ST *****VERIFICAR ISSO CERTINHO *****
            ':nota_itens_pis_st_tipo_calculo' => $nota_itens_pis_st_tipo_calculo,
            ':nota_itens_pis_st_base_calculo' => $nota_itens_pis_st_base_calculo,
            ':nota_itens_pis_st_aliquota' => $nota_itens_pis_st_aliquota,
            ':nota_itens_pis_st_valor' => $nota_itens_pis_st_valor,
            //COFINS
            ':nota_itens_id_cofins' => $nota_itens_id_cofins,
            ':nota_itens_cofins_tipo_calculo' => $nota_itens_cofins_tipo_calculo,
            ':nota_itens_cofins_aliquota' => $nota_itens_cofins_aliquota,
            ':nota_itens_cofins_valor' => $nota_itens_cofins_valor
        ));
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

//.....:::: NOTA VOLUMES/VEICULOS/INF. COMPLEMENTARES/REFERENCIAÇÃO ::::....
//CADASTRA UM NOVO VOLUME NA NFE
if (isset($_POST['btn-cadastra_volume'])) {

    $id_nota = strtoupper($_POST['id_nota']);
    $nota_volume_qtd = $_POST['nota_volume_qtd'];
    $nota_volume_especie = $_POST['nota_volume_especie'];
    //$nota_volume_peso_bruto = $_POST['nota_volume_peso_bruto'];
    //$nota_volume_peso_liquido = $_POST['nota_volume_peso_liquido'];
    $nota_volume_marca = $_POST['nota_volume_marca'];
    $nota_volume_numero_volume = $_POST['nota_volume_numero_volume'];
    $nota_volume_lacre = $_POST['nota_volume_lacre'];

    $nota_volume_peso_bruto = str_replace(",", ".", strip_tags($_POST['nota_volume_peso_bruto']));
    $nota_volume_peso_liquido = str_replace(",", ".", strip_tags($_POST['nota_volume_peso_liquido']));

    try {
        //CADASTRO VOLUME
        $stmt = $auth_user->runQuery("INSERT INTO nota_volume
            (id_nota,
            nota_volume_qtd,
            nota_volume_especie,
            nota_volume_peso_bruto,
            nota_volume_peso_liquido,
            nota_volume_marca,
            nota_volume_numero_volume,
            nota_volume_lacre)
            VALUES(:id_nota, 
            :nota_volume_qtd,
            :nota_volume_especie,
            :nota_volume_peso_bruto,
            :nota_volume_peso_liquido,
            :nota_volume_marca,
            :nota_volume_numero_volume,
            :nota_volume_lacre)");

        $stmt->bindparam(":id_nota", $id_nota);
        $stmt->bindparam(":nota_volume_qtd", $nota_volume_qtd);
        $stmt->bindparam(":nota_volume_especie", $nota_volume_especie);
        $stmt->bindparam(":nota_volume_peso_bruto", $nota_volume_peso_bruto);
        $stmt->bindparam(":nota_volume_peso_liquido", $nota_volume_peso_liquido);
        $stmt->bindparam(":nota_volume_marca", $nota_volume_marca);
        $stmt->bindparam(":nota_volume_numero_volume", $nota_volume_numero_volume);
        $stmt->bindparam(":nota_volume_lacre", $nota_volume_lacre);

        $stmt->execute();
        // $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//ALTERA DADOS DO VOLUME DA NFE
if (isset($_POST['btn-altera_volume'])) {


    $nota_volume_id = $_POST['nota_volume_id'];
    $nota_volume_qtd = $_POST['nota_volume_qtd'];
    $nota_volume_especie = $_POST['nota_volume_especie'];
    //$nota_volume_peso_bruto = $_POST['nota_volume_peso_bruto'];
    //$nota_volume_peso_liquido = $_POST['nota_volume_peso_liquido'];
    $nota_volume_peso_bruto = str_replace(",", ".", strip_tags($_POST['nota_volume_peso_bruto']));
    $nota_volume_peso_liquido = str_replace(",", ".", strip_tags($_POST['nota_volume_peso_liquido']));
    $nota_volume_marca = $_POST['nota_volume_marca'];
    $nota_volume_numero_volume = $_POST['nota_volume_numero_volume'];
    $nota_volume_lacre = $_POST['nota_volume_lacre'];


    try {

        $nota_vol_edi = $auth_user->runQuery('UPDATE nota_volume SET '
                . 'nota_volume_qtd = :nota_volume_qtd, '
                . 'nota_volume_especie = :nota_volume_especie, '
                . 'nota_volume_peso_bruto = :nota_volume_peso_bruto, '
                . 'nota_volume_peso_liquido = :nota_volume_peso_liquido, '
                . 'nota_volume_marca = :nota_volume_marca, '
                . 'nota_volume_numero_volume = :nota_volume_numero_volume, '
                . 'nota_volume_lacre = :nota_volume_lacre'
                . ' WHERE nota_volume_id = :nota_volume_id');
        $nota_vol_edi->execute(array(
            ':nota_volume_id' => $nota_volume_id,
            ':nota_volume_qtd' => $nota_volume_qtd,
            ':nota_volume_especie' => $nota_volume_especie,
            ':nota_volume_peso_bruto' => $nota_volume_peso_bruto,
            ':nota_volume_peso_liquido' => $nota_volume_peso_liquido,
            ':nota_volume_marca' => $nota_volume_marca,
            ':nota_volume_numero_volume' => $nota_volume_numero_volume,
            ':nota_volume_lacre' => $nota_volume_lacre
        ));
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//EXCLUIR DADOS DO VOLUME DA NFE
if (isset($_POST['btn-excluir_volume'])) {
    $nota_volume_id = strip_tags($_POST['nota_volume_id']);

    try {

        $sql = "DELETE FROM nota_volume WHERE nota_volume_id =  :nota_volume_id";
        $stmt = $auth_user->runQuery($sql);
        $stmt->bindParam(':nota_volume_id', $nota_volume_id, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

// *******FUNCOES SOBRE A VEICULO DA NFE AQUI NA EDICAO DA NFE***************
//CADASTRA UM NOVO VEICULO NA NFE
if (isset($_POST['btn-cadastra_veiculo'])) {

    $id_nota = strtoupper($_POST['id_nota']);
    $nota_veiculo_tipo = $_POST['nota_veiculo_tipo'];
    $nota_veiculo_placa = $_POST['nota_veiculo_placa'];
    $nota_veiculo_uf = $_POST['nota_veiculo_uf'];
    $nota_veiculo_rntc = $_POST['nota_veiculo_rntc'];

    try {
        //CADASTRO DO VEICULO
        $stmt = $auth_user->runQuery("INSERT INTO nota_veiculo
            (id_nota,
            nota_veiculo_tipo,
            nota_veiculo_placa,
            nota_veiculo_uf,
            nota_veiculo_rntc)
            VALUES(:id_nota,
            :nota_veiculo_tipo,
            :nota_veiculo_placa,
            :nota_veiculo_uf,
            :nota_veiculo_rntc)");

        $stmt->bindparam(":id_nota", $id_nota);
        $stmt->bindparam(":nota_veiculo_tipo", $nota_veiculo_tipo);
        $stmt->bindparam(":nota_veiculo_placa", $nota_veiculo_placa);
        $stmt->bindparam(":nota_veiculo_uf", $nota_veiculo_uf);
        $stmt->bindparam(":nota_veiculo_rntc", $nota_veiculo_rntc);


        $stmt->execute();
        // $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//ALTERA DADOS DO VEICULO DA NFE
if (isset($_POST['btn-altera_veiculo'])) {


    $nota_veiculo_id = $_POST['nota_veiculo_id'];
    $nota_veiculo_tipo = $_POST['nota_veiculo_tipo'];
    $nota_veiculo_placa = $_POST['nota_veiculo_placa'];
    $nota_veiculo_uf = $_POST['nota_veiculo_uf'];
    $nota_veiculo_rntc = $_POST['nota_veiculo_rntc'];

    try {

        $nota_vei_edi = $auth_user->runQuery('UPDATE nota_veiculo SET '
                . 'nota_veiculo_tipo = :nota_veiculo_tipo, '
                . 'nota_veiculo_placa = :nota_veiculo_placa, '
                . 'nota_veiculo_uf = :nota_veiculo_uf, '
                . 'nota_veiculo_rntc = :nota_veiculo_rntc'
                . ' WHERE nota_veiculo_id = :nota_veiculo_id');
        $nota_vei_edi->execute(array(
            ':nota_veiculo_id' => $nota_veiculo_id,
            ':nota_veiculo_tipo' => $nota_veiculo_tipo,
            ':nota_veiculo_placa' => $nota_veiculo_placa,
            ':nota_veiculo_uf' => $nota_veiculo_uf,
            ':nota_veiculo_rntc' => $nota_veiculo_rntc
        ));
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//EXCLUIR DADOS DO VEICULO DA NFE
if (isset($_POST['btn-excluir_veiculo'])) {
    $nota_veiculo_id = strip_tags($_POST['nota_veiculo_id']);

    try {

        $sql = "DELETE FROM nota_veiculo WHERE nota_veiculo_id =  :nota_veiculo_id";
        $stmt = $auth_user->runQuery($sql);
        $stmt->bindParam(':nota_veiculo_id', $nota_veiculo_id, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

// *******FUNCOES SOBRE A INF COMPLEMENTARES DA NFE AQUI NA EDICAO DA NFE***************
//CADASTRA UMA NOVA INF. COMPLEMENTAR
if (isset($_POST['btn-cadastra_inf'])) {
    $id_nota = strtoupper($_POST['id_nota']);
    $nota_inf_busca_id = $_POST['nota_inf_busca_id'];
    $nota_inf_comp_complemento = $_POST['nota_inf_comp_complemento'];

    try {

        $busca_inf = $auth_user->runQuery("SELECT * FROM inf_comp WHERE inf_comp_id =:nota_inf_busca_id");
        $busca_inf->bindValue(':nota_inf_busca_id', $nota_inf_busca_id, PDO::PARAM_STR);
        $busca_inf->execute();
        $linha = $busca_inf->fetch(PDO::FETCH_ASSOC);
        //CADASTRO DO VEICULO
        $stmt = $auth_user->runQuery("INSERT INTO nota_inf_comp
            (id_nota,
            nota_inf_comp_apelido,
            nota_inf_comp_descricao,
            nota_inf_comp_complemento
            )
            VALUES(:id_nota,
            :nota_inf_comp_apelido,
            :nota_inf_comp_descricao,
            :nota_inf_comp_complemento
            )");

        $stmt->bindparam(":id_nota", $id_nota);
        $stmt->bindparam(":nota_inf_comp_apelido", $linha['inf_comp_apelido']);
        $stmt->bindparam(":nota_inf_comp_descricao", $linha['inf_comp_descricao']);
        $stmt->bindparam(":nota_inf_comp_complemento", $nota_inf_comp_complemento);

        $stmt->execute();
        // $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//ALTERA DADOS DA INF COMPLEMENTAR DA NFE
if (isset($_POST['btn-altera_inf'])) {


    $nota_inf_comp_id = $_POST['nota_inf_comp_id'];
    $nota_inf_comp_apelido = $_POST['nota_inf_comp_apelido'];
    $nota_inf_comp_descricao = $_POST['nota_inf_comp_descricao'];
    $nota_inf_comp_complemento = $_POST['nota_inf_comp_complemento'];


    try {

        $nota_vei_edi = $auth_user->runQuery('UPDATE nota_inf_comp SET '
                . 'nota_inf_comp_apelido = :nota_inf_comp_apelido, '
                . 'nota_inf_comp_descricao = :nota_inf_comp_descricao, '
                . 'nota_inf_comp_complemento = :nota_inf_comp_complemento'
                . ' WHERE nota_inf_comp_id = :nota_inf_comp_id');
        $nota_vei_edi->execute(array(
            ':nota_inf_comp_id' => $nota_inf_comp_id,
            ':nota_inf_comp_apelido' => $nota_inf_comp_apelido,
            ':nota_inf_comp_descricao' => $nota_inf_comp_descricao,
            ':nota_inf_comp_complemento' => $nota_inf_comp_complemento
        ));
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//EXCLUIR DADOS DA INF COMPLEMENTAR DA NFE
if (isset($_POST['btn-excluir_inf'])) {
    $nota_inf_comp_id = strip_tags($_POST['nota_inf_comp_id']);

    try {

        $sql = "DELETE FROM nota_inf_comp WHERE nota_inf_comp_id =  :nota_inf_comp_id";
        $stmt = $auth_user->runQuery($sql);
        $stmt->bindParam(':nota_inf_comp_id', $nota_inf_comp_id, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

// *******FUNCOES SOBRE A REFERENCIA DA NFE AQUI NA EDICAO DA NFE***************
//CADASTRA UMA NOVA REFERENCIA NA NFE
if (isset($_POST['btn-cadastra_ref'])) {
    $id_nota = strtoupper($_POST['id_nota']);
    $nota_referencia_chave = $_POST['nota_referencia_chave'];
    $nota_referencia_cod_uf = $_POST['nota_referencia_cod_uf'];
    $nota_referencia_data = $_POST['nota_referencia_data'];
    $nota_referencia_cnpj = $_POST['nota_referencia_cnpj'];
    $nota_referencia_modelo = $_POST['nota_referencia_modelo'];
    $nota_referencia_serie = $_POST['nota_referencia_serie'];
    $nota_referencia_numero_nfe = $_POST['nota_referencia_numero_nfe'];

    try {
        //CADASTRO VOLUME
        $stmt = $auth_user->runQuery("INSERT INTO nota_referencia
            (id_nota,
            nota_referencia_chave,
            nota_referencia_cod_uf,
            nota_referencia_data,
            nota_referencia_cnpj,
            nota_referencia_modelo,
            nota_referencia_serie,
            nota_referencia_numero_nfe)
            VALUES(:id_nota, 
            :nota_referencia_chave,
            :nota_referencia_cod_uf,
            :nota_referencia_data,
            :nota_referencia_cnpj,
            :nota_referencia_modelo,
            :nota_referencia_serie,
            :nota_referencia_numero_nfe)");

        $stmt->bindparam(":id_nota", $id_nota);
        $stmt->bindparam(":nota_referencia_chave", $nota_referencia_chave);
        $stmt->bindparam(":nota_referencia_cod_uf", $nota_referencia_cod_uf);
        $stmt->bindparam(":nota_referencia_data", $nota_referencia_data);
        $stmt->bindparam(":nota_referencia_cnpj", $nota_referencia_cnpj);
        $stmt->bindparam(":nota_referencia_modelo", $nota_referencia_modelo);
        $stmt->bindparam(":nota_referencia_serie", $nota_referencia_serie);
        $stmt->bindparam(":nota_referencia_numero_nfe", $nota_referencia_numero_nfe);
        $stmt->execute();
        // $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//ALTERAR DADOS DA REFERENCIA DA NFE
if (isset($_POST['btn-alterareferencia'])) {


    $nota_referencia_id = $_POST['nota_referencia_id'];
    $nota_referencia_chave = $_POST['nota_referencia_chave'];
    $nota_referencia_cod_uf = $_POST['nota_referencia_cod_uf'];
    $nota_referencia_data = $_POST['nota_referencia_data'];
    $nota_referencia_cnpj = $_POST['nota_referencia_cnpj'];
    $nota_referencia_modelo = $_POST['nota_referencia_modelo'];
    $nota_referencia_serie = $_POST['nota_referencia_serie'];
    $nota_referencia_numero_nfe = $_POST['nota_referencia_numero_nfe'];
    try {

        $nota_vei_edi = $auth_user->runQuery('UPDATE nota_referencia SET '
                . 'nota_referencia_chave = :nota_referencia_chave, '
                . 'nota_referencia_cod_uf = :nota_referencia_cod_uf, '
                . 'nota_referencia_data = :nota_referencia_data, '
                . 'nota_referencia_cnpj = :nota_referencia_cnpj, '
                . 'nota_referencia_modelo = :nota_referencia_modelo, '
                . 'nota_referencia_serie = :nota_referencia_serie, '
                . 'nota_referencia_numero_nfe = :nota_referencia_numero_nfe'
                . ' WHERE nota_referencia_id = :nota_referencia_id');
        $nota_vei_edi->execute(array(
            ':nota_referencia_id' => $nota_referencia_id,
            ':nota_referencia_chave' => $nota_referencia_chave,
            ':nota_referencia_cod_uf' => $nota_referencia_cod_uf,
            ':nota_referencia_data' => $nota_referencia_data,
            ':nota_referencia_cnpj' => $nota_referencia_cnpj,
            ':nota_referencia_modelo' => $nota_referencia_modelo,
            ':nota_referencia_serie' => $nota_referencia_serie,
            ':nota_referencia_numero_nfe' => $nota_referencia_numero_nfe
        ));
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//EXCLUIR REFERENCIA DA NFE
if (isset($_POST['btn-excluirreferencia'])) {
    $nota_referencia_id = strip_tags($_POST['nota_referencia_id']);

    try {

        $sql = "DELETE FROM nota_referencia WHERE nota_referencia_id =  :nota_referencia_id";
        $stmt = $auth_user->runQuery($sql);
        $stmt->bindParam(':nota_referencia_id', $nota_referencia_id, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>