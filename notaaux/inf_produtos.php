<?php

//AVISO O QUE MECHER AQUI VERIFICAR COM O TOTAL DA NFE
// BUSCA OS DADOS DO PEDIDO PARA GERAR VALORES DE IMPOSTOS DE ACORDO COM A TES E A ST

$flagICMS = 0;
$flagPIS = 0;
$flagCONFIS = 0;
$flagIPI = 0;
$flagDesc = 0;
$flagBCICMS = 0;
$totalICMSDest = 0;
$totalFCP = 0;
$totalICMSRemet = 0;


$stmt_produtos = $auth_user->runQuery(
        "SELECT * FROM pedido_itens, sticms,icms, tes_itens,
    produto, unidade, ncm, st, ipi, pis, cofins LEFT JOIN aproveitamento b
           ON Month(now()) = b.aproveitamento_mes WHERE
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

// $busca_config = $stmt_produtos->fetch(PDO::FETCH_ASSOC);
// BUSCA O TOTAL DE ICMS DO PRODUTO

$cont = 1;
$flagICMS = 0;
$flagPIS = 0;
$flagCONFIS = 0;
$flagIPI = 0;
$totalICMSDest = 0;
$totalFCP = 0;
$totalICMSRemet = 0;

while ($linha = $stmt_produtos->fetch(PDO::FETCH_ASSOC)) {
    //echo $linha['produto_nome'];

    $aP[] = array(
        'nItem' => $cont,
        'cProd' => $linha['produto_codigo'],
        'cEAN' => $linha['produto_ean'],
        'xProd' => $linha['produto_nome'],
        'NCM' => $linha['ncm_codigo'],
        'NVE' => $linha['produto_nve'],
        'CEST' => $linha['produto_cest'],
        'EXTIPI' => $linha['produto_extipi'],
        'CFOP' => $linha['tes_itens_cfop'], //'6101',
        'uCom' => $linha['unidade_nome'],
        'qCom' => $linha['pedido_itens_qtd'],
        'vUnCom' => $linha['pedido_itens_valor'],
        'vProd' => $linha['pedido_itens_total'],
        'cEANTrib' => $linha['produto_ean'],
        'uTrib' => $linha['unidade_nome'],
        'qTrib' => $linha['pedido_itens_qtd'],
        'vUnTrib' => $linha['pedido_itens_valor'],
        'vFrete' => $linha['pedido_itens_valor_frete'],
        'vSeg' => $linha['pedido_itens_valor_seguro'],
        'vDesc' => $linha['pedido_itens_valor_desconto'],
        'vOutro' => $linha['pedido_itens_outras_despesas'],
        'indTot' => '1',
        'xPed' => $linha['pedido_itens_numero_compra'],
        'nItemPed' => $cont,
        'nFCI' => $linha['pedido_itens_numero_nfci']
    );
    //INFORMAÇÕES ADICIONAIS DO PRODUTO

    if ($linha['pedido_itens_descricao'] != '') {
        $nItem = $cont; //produtos 2
        $vDesc = $linha['pedido_itens_descricao']; //'CaixaS';
        // $vDesc = 'Caixas';
        // $resp = $nfe->taginfAdProd($nItem, $vDesc);
    }

//  ======******  BUSCAR O IMPOSTO DO ITEM PARA GERAR O TOTAL DE IMPOSTO POR PRODUTO *****========
    //Base do ICMS Inter = (Valor do produto + Frete + Seguro + Outras Despesas Acessórias – Descontos)
    //Valor do ICMS Inter = Base ICMS Inter * (Alíquota ICMS Inter / 100)
    //ICMS
    if ($linha['sticms_aliquota'] > 0) {
        $base_icms = (($linha['pedido_itens_total'] + $linha['pedido_itens_valor_frete'] +
                $linha['pedido_itens_valor_seguro'] + $linha['pedido_itens_outras_despesas']) - $linha['pedido_itens_valor_desconto']);
        $valor_icms = $base_icms * ($linha['sticms_aliquota'] / 100);
    } else {
        $valor_icms = 0;
        $base_icms = 0;
    }




    //Base do ICMS ST = (Valor do produto + Valor do IPI + Frete + Seguro + Outras Despesas Acessórias – Descontos) * (1+(%MVA / 100))
    //Valor do ICMS ST = (Base do ICMS ST * (Alíquota do ICMS Intra / 100)) – Valor do ICMS Inter
    //ICMS ST
    if ($linha['sticms_st_aliquota'] > 0) {
        $base_icmsst = ($linha['pedido_itens_total'] + $linha['pedido_itens_valor_frete'] + $linha['pedido_itens_valor_seguro'] +
                $linha['pedido_itens_outras_despesas'] - $linha['pedido_itens_valor_desconto']) * (1 + ($linha['sticms_st_mva'] / 100));

        $valor_icmsst = ($base_icmsst * ($linha['sticms_st_aliquota'] / 100)) - $valor_icms;
    } else {
        $valor_icmsst = 0;
        $base_icmsst = 0;
    }
    //Base de cálculo = (Valor do produto + Frete + Seguro + Outras Despesas Acessórias)
    //Valor do IPI = Base de cálculo * (Alíquota / 100)
    //IPI
    if ($linha['st_ipi_aliquota'] > 0) {
        $base_ipi = ($linha['pedido_itens_total'] + $linha['pedido_itens_valor_frete'] + $linha['pedido_itens_valor_seguro'] +
                $linha['pedido_itens_outras_despesas']);
        $valor_ipi = $base_ipi * ($linha['st_ipi_aliquota'] / 100);
    } else {
        $valor_ipi = 0;
        $base_ipi = 0;
    }
    //PIS
    // Base = (Preço do Item + Despesas – Desconto + IPI Outros quando parametrizado*) – % Redução
    //     para os códigos de tributação Reduzido ou Outros**
    if ($linha['st_pis_aliquota'] > 0) {

        //$valor_pis = $linha['pedido_itens_total'] * ($linha['st_pis_aliquota'] / 100);
        $base_pis = (($linha['pedido_itens_total'] + $linha['pedido_itens_valor_frete'] +
                $linha['pedido_itens_valor_seguro'] + $linha['pedido_itens_outras_despesas']) - $linha['pedido_itens_valor_desconto']) + $valor_ipi;
        $valor_pis = $base_pis * ($linha['st_pis_aliquota'] / 100);
    } else {
        $valor_pis = 0;
        $base_pis = 0;
    }
    //COFINS
    if ($linha['st_cofins_aliquota'] > 0) {
        // $valor_cofins = $linha['pedido_itens_total'] * ($linha['st_cofins_aliquota'] / 100);
        $base_cofins = (($linha['pedido_itens_total'] + $linha['pedido_itens_valor_frete'] +
                $linha['pedido_itens_valor_seguro'] + $linha['pedido_itens_outras_despesas']) - $linha['pedido_itens_valor_desconto']) + $valor_ipi;
        $valor_cofins = $base_cofins * ($linha['st_cofins_aliquota'] / 100);
    } else {
        $valor_cofins = 0;
    }



    //TOTAL DE IMPOSTOS DO PRODUTO (ICMS + ICMS-ST + IPI + CONFIS)
    //VERIFICAR MAS CORRETAMENTE ESSE CAMPO AQUI.

    $nItem = $cont; //produtos 1
    //$vTotTrib = ''; // 226.80 ICMS + 51.50 ICMSST + 50.40 IPI + 39.36 PIS + 81.84 CONFIS
    $vTotTrib = number_format(($valor_icms + $valor_icmsst + $valor_ipi + $valor_pis + $valor_cofins), 2, '.', '');
    // $resp = $nfe->tagimposto($nItem, $vTotTrib);
    // 
    //ICMS - IMPOSTO SOBRE CIRCULAÇÃO DE MERCADORIAS E SERVIÇOS
    //AQUI TEM VER COMO FAZER, MAS ACREDITO QUE ISSO DEVE SER FEITO LA NO CADASTRO DO PRODUTO

    $nItem = $cont; //produtos 1
    $orig = $linha['produto_origem']; //'0';
    // $cst = '00'; // Tributado Integralmente
    $cst = $linha['icms_codigo'];
    $modBC = $linha['sticms_modalidade_base_calculo']; //'3';
    //$pRedBC = '';
    $pRedBC = $linha['sticms_reducao_base_calculo'];
    $vBC = number_format($base_icms, 2, '.', ''); //$linha['nota_itens_total']; // = $qTrib * $vUnTrib
    //
    $flagBCICMS = $flagBCICMS + $vBC;
    $flagBCICMS = number_format($flagBCICMS, 2, '.', '');
    //$pICMS = '7.00'; // Alíquota do Estado de GO p/ 'NCM 2203.00.00 - Cervejas de Malte, inclusive Chope'
    $pICMS = $linha['sticms_aliquota'];
    $vICMS = $vBC * ( $pICMS / 100 );
    $vICMS = number_format($vICMS, 2, '.', '');

    $flagICMS = $flagICMS + $vICMS;
    $flagICMS = number_format($flagICMS, 2, '.', '');

    $vICMSDeson = '';
    $motDesICMS = '';
    //$modBCST = '';
    $modBCST = $linha['sticms_st_modalidade_calculo'];
    $pMVAST = '';
    $pRedBCST = '';
    $vBCST = number_format($base_icmsst, 2, '.', '');
    $pICMSST = $linha['sticms_st_aliquota'];
    $vICMSST = number_format($valor_icmsst, 2, '.', '');
    $pDif = '';
    $vICMSDif = '';
    $vICMSOp = '';
    if ($cst == 51) {
        $vICMSOp = $vICMS;
    }
    $vBCSTRet = '';
    $vICMSSTRet = '';
    //FAZ A BUSCA DA ALIQUOTA MENSAL DO APROVEITAMENTO DO ICMS
    if ($cst == 101) {
        $mes = date("m");
        $ano = date("Y");

        $busca_ali_cred_icms = $auth_user->runQuery("select * from aproveitamento "
                . "where aproveitamento_mes = {$mes} and aproveitamento_ano = {$ano}");
        $busca_ali_cred_icms->execute();
        $busca_ali_cred = $busca_ali_cred_icms->fetch(PDO::FETCH_ASSOC);
        if (!$busca_ali_cred) {
            echo "Sem Cadastro na Aliquota Mensal do MES " . $mes . " e ano " . $ano;
            exit();
        }
        //CALCULO DA ALIQUOTA DE CREDITO DE ICMS
        $pCredSN = $busca_ali_cred['aproveitamento_aliquota'];
        $vCredICMSSN = number_format(($linha['pedido_itens_total'] * $pCredSN) / 100, 2, '.', '');
    }


    //IPI - Imposto sobre Produto Industrializado
    //VERIFICAR AQUI O IPI DA NO PRODUTO
    $nItem = $cont; //produtos 1
    //$cst = '51'; // 50 - Saída Tributada (Código da Situação Tributária)
    $cst = $linha['ipi_codigo'];
    //$clEnq = '';
    $clEnq = $linha['st_ipi_classe'];
    $cnpjProd = '';
    $cSelo = '';
    $qSelo = '';
    //$cEnq = '999';
    $cEnq = $linha['st_ipi_cod'];
    //$vBC = '';
    $vBC = ($linha['pedido_itens_total'] + $linha['pedido_itens_valor_frete'] + $linha['pedido_itens_valor_seguro'] +
            $linha['pedido_itens_outras_despesas']);
    $pIPI = $linha['st_ipi_aliquota']; //''; //Calculo por alíquota - 6% Alíquota GO.
    $qUnid = '';
    $vUnid = '';
    //$vIPI = ''; // = $vBC * ( $pIPI / 100 )
    $vIPI = number_format(($vBC * ( $pIPI / 100 )), 2, '.', '');
    $flagIPI = $flagIPI + $vIPI;
    $flagIPI = number_format($flagIPI, 2, '.', '');

    // $resp = $nfe->tagIPI($nItem, $cst, $clEnq, $cnpjProd, $cSelo, $qSelo, $cEnq, $vBC, $pIPI, $qUnid, $vUnid, $vIPI);
    //PIS AQUI ESTA A SITUAÇÃO DO PIS 
    //VERIFICAR A POSSIBILIDADE DE INTEGRAR A ST COM O PRODUTO
    /**/
    $nItem = $cont; //produtos 1
    // $cst = '01'; //Operação Tributável (base de cálculo = quantidade vendida x alíquota por unidade de produto)
    $cst = $linha['pis_codigo'];
    $vBC = number_format($base_pis, 2, '.', ''); //$linha['pedido_itens_total']; 
    //$pPIS = '1.65';
    $pPIS = $linha['st_pis_aliquota'];
    $vPIS = ($vBC * $pPIS ) / 100;
    $vPIS = number_format($vPIS, 2, '.', '');
    $flagPIS = $flagPIS + $vPIS;
    $flagPIS = number_format($flagPIS, 2, '.', '');
    $qBCProd = '';
    $vAliqProd = '';
    //$resp = $nfe->tagPIS($nItem, $cst, $vBC, $pPIS, $vPIS, $qBCProd, $vAliqProd);
    //COFINS - Contribuição para o Financiamento da Seguridade Social

    $nItem = $cont; //produtos 1
    //$cst = '01'; //Operação Tributável (base de cálculo = quantidade vendida x alíquota por unidade de produto)
    $cst = $linha['cofins_codigo'];
    $vBC = $linha['pedido_itens_total'];
    $pCOFINS = $linha['st_cofins_aliquota'];
    $vCOFINS = ($vBC * $pCOFINS ) / 100;
    $vCOFINS = number_format($vCOFINS, 2, '.', '');
    $flagCONFIS = $flagCONFIS + $vCOFINS;
    $flagCONFIS = number_format($flagCONFIS, 2, '.', '');
    $qBCProd = '';
    $vAliqProd = '';
    // $resp = $nfe->tagCOFINS($nItem, $cst, $vBC, $pCOFINS, $vCOFINS, $qBCProd, $vAliqProd);
    //AQUI VERIFICAR SE O CARA E CONSUMIDOR FINAL E GERAR O ICMS PARTILHA.

    if ($linha['sticms_tipo_pessoa'] == 10) {

        if ($dados_empresa['municipio_sigla'] != $dados_pedido['municipio_sigla']) {

            $nItem = $cont;
            //BASE DE CALCULO DO ICMS PARTILHA
            $vBCUFDest = (($linha['pedido_itens_total'] + $linha['pedido_itens_valor_frete'] +
                    $linha['pedido_itens_valor_seguro'] + $linha['pedido_itens_outras_despesas']) - $linha['pedido_itens_valor_desconto'] + $vIPI);
            $vBCUFDest = number_format($vBCUFDest, 2, '.', '');
            //ALIQUOTA DO ICMS POBREZA
            $pFCPUFDest = $linha['sticms_par_pobreza'];
            $pFCPUFDest = number_format($pFCPUFDest, 2, '.', '');
            //ALIQUOTA DO ICMS DE DESTINO
            $pICMSUFDest = $linha['sticms_par_destino'];
            $pICMSUFDest = number_format($pICMSUFDest, 2, '.', '');
            //ALIQUOTA DO ICMS ORIGEM
            $pICMSInter = $linha['sticms_par_origem'];
            $pICMSInter = number_format($pICMSInter, 2, '.', '');
            //PERCENTUAL DO ANO DO ICMS PARTILHA.
            $pICMSInterPart = 60;
            $pICMSInterPart = number_format($pICMSInterPart, 2, '.', '');
            //CALCULO E VALOR DO ICMS DE POBREZA
            $vFCPUFDest = ($vBCUFDest * $linha['sticms_par_pobreza']) / 100;
            $vFCPUFDest = number_format($vFCPUFDest, 2, '.', '');
            //CALCULO DO VALOR DO ICMS PARTILHA DA UF DESTINO.
            $total = ($vBCUFDest * ($pICMSUFDest - $pICMSInter) / 100);
            $vICMSUFDest = ($total * $pICMSInterPart) / 100;
            $vICMSUFDest = number_format($vICMSUFDest, 2, '.', '');
            //CALCULO DA VALOR DO ICMS PARTILHA DA UF ORIGEM
            $vICMSUFRemet = $total - $vICMSUFDest;
            $vICMSUFRemet = number_format($vICMSUFRemet, 2, '.', '');
            //GERACAO DO XML DOS DADOS 
            // $resp = $nfe->tagICMSUFDest($nItem, $vBCUFDest, $pFCPUFDest, $pICMSUFDest, $pICMSInter, $pICMSInterPart, $vFCPUFDest, $vICMSUFDest, $vICMSUFRemet);
            //PRECISO GRAVAR ISSO DO BANCO DE DADOS.

            $totalICMSDest = $totalICMSDest + $vICMSUFDest;
            //print_r($totalICMSDest);
            $totalICMSDest = number_format($totalICMSDest, 2, '.', '');

            $totalFCP = $totalFCP + $vFCPUFDest;
            $totalFCP = number_format($totalFCP, 2, '.', '');
            $totalICMSRemet = $totalICMSRemet + $vICMSUFRemet;
            $totalICMSRemet = number_format($totalICMSRemet, 2, '.', '');

            $aObsC = array(
                array('Valor', 'ICMS Inter. UF Des: R$' . $totalICMSDest . ' FCP: R$' . $totalFCP . ' UF Ori. R$' . $totalICMSRemet . ''));
            //array('DIFAL UF Des:'.$totalICMSDest.''),          
            // array('FCP:', 'R$'.$totalFCP.''),          
            //array('DIFAL UF Ori', ' R$'.$totalICMSRemet.''));          
        }
    }

    $cont++;
}
unset($cont);


//foreach ($aP as $prod) {
//    $nItem = $prod['nItem'];
//    $cProd = $prod['cProd'];
//    $cEAN = $prod['cEAN'];
//    $xProd = $prod['xProd'];
//    $NCM = $prod['NCM'];
//    $NVE = $prod['NVE'];
//    $CEST = $prod['CEST'];
//    $EXTIPI = $prod['EXTIPI'];
//    $CFOP = $prod['CFOP'];
//    $uCom = $prod['uCom'];
//    $qCom = $prod['qCom'];
//    $vUnCom = $prod['vUnCom'];
//    $vProd = $prod['vProd'];
//    $cEANTrib = $prod['cEANTrib'];
//    $uTrib = $prod['uTrib'];
//    $qTrib = $prod['qTrib'];
//    $vUnTrib = $prod['vUnTrib'];
//    $vFrete = $prod['vFrete'];
//    $vSeg = $prod['vSeg'];
//    $vDesc = $prod['vDesc'];
//    $vOutro = $prod['vOutro'];
//    $indTot = $prod['indTot'];
//    $xPed = $prod['xPed'];
//    $nItemPed = $prod['nItemPed'];
//    $nFCI = $prod['nFCI'];
//   // $resp = $nfe->tagprod($nItem, $cProd, $cEAN, $xProd, $NCM, $NVE, $CEST, $EXTIPI, $CFOP, $uCom, $qCom, $vUnCom, $vProd, $cEANTrib, $uTrib, $qTrib, $vUnTrib, $vFrete, $vSeg, $vDesc, $vOutro, $indTot, $xPed, $nItemPed, $nFCI);
//}

