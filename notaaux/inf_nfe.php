<?php

//HORA E DATA DA EMISSAO DA NOTA         
    date_default_timezone_set('America/Sao_Paulo');
    $data = date('Y-m-d H:i:s');

    //INFORMAÇÕES DADOR SE TIVER
    $pedido_status = 4;
    $id_transportador = strip_tags($_POST['transportador_id']);
    $nota_data_emissao = strip_tags($_POST['nota_data_emissao']);
    $nota_hora_emissao = strip_tags($_POST['nota_hora_emissao']);
    $nota_data_saida = strip_tags($_POST['nota_data_saida']);
    $nota_hora_saida = strip_tags($_POST['nota_hora_saida']);

//FORMATA A DATA PARA PADRAO PARA O MYSQL E O SISTEMA
    $dataP = explode('/', $nota_data_emissao);
    $nota_data_emissao = $dataP[2] . '-' . $dataP[1] . '-' . $dataP[0];
    $dataE = explode('/', $nota_data_saida);
    $nota_data_saida = $dataE[2] . '-' . $dataE[1] . '-' . $dataE[0];

// DADOS INICIAIS PARA A EMISSAO DA NOTA
    $cUF = $dados_empresa['estado_codigo_ibge']; //codigo numerico do estado
    $cNF = rand(10000000, 99999999);
    //VERIFICAR COMO COLOCAR A NATUREZA DA OPERAÇÃO AQUI    
    //$natOp = 'Venda de Produto'; //natureza da operação
    $natOp = $dados_tescfop['tes_descricao'];
    $indPag = $dados_pedido['forma_pagamento_tipo'];
    // $mod = '55'; //modelo da NFe 55 ou 65 essa última NFCe
    $mod = $dados_empresa['empresa_modelo_nfe'];
    // $serie = '1'; //serie da NFe
    $serie = $dados_empresa['empresa_serie_nfe'];
    $nNF = $dados_empresa['empresa_numero_nfe']; // numero da NFe
    $dhEmi = date("y-m-d\TH:i:sP"); //Formato: “AAAA-MM-DDThh:mm:ssTZD” (UTC - Universal Coordinated Time).
    $dhSaiEnt = date("y-m-d\TH:i:sP"); //Não informar este campo para a NFC-e.
    //$tpNF = '1';
    $tpNF = $dados_tescfop['tes_tipo']; // ENTRADA OU SAIDA
    if ($dados_empresa['municipio_sigla'] == $dados_pedido['municipio_sigla']) {
        $idDest = 1; // OPERACAO INTERNA
    }
    if ($dados_empresa['municipio_sigla'] != $dados_pedido['municipio_sigla']) {
        $idDest = 2; //OPERACAO INTERESTADUAL
    }
    if ($dados_pedido['municipio_sigla'] == 'EX') {
        $idDest = 3; // OPERACAO COM O EXTERIOR
    }
    $cMunFG = $dados_empresa['municipio_cod_ibge']; // MUNICIPIO CODIGO DO IBGE
    $tpImp = $dados_empresa['empresa_tipo_impressao']; //'1'; //TIPO DE IMPRESSAO DA NFE.
    $tpEmis = $dados_empresa['empresa_tipo_emissao']; //'1'; //1=Emissão normal (não em contingência);
    $tpAmb = $dados_empresa['empresa_ambiente_nfe']; //'2'; //1=Produção; 2=Homologação
    $finNFe = $dados_pedido['pedido_tipo']; //'1'; //1=NF-e normal; 2=NF-e complementar; 3=NF-e de ajuste; 4=Devolução/Retorno.
    $indFinal = $dados_pedido['cliente_consumidor']; //0=Normal; 1=Consumidor final;
    $indPres = $dados_pedido['pedido_presencial']; //0=Não se aplica (por exemplo, Nota Fiscal complementar ou de ajuste);
    $procEmi = '0'; //0=Emissão de NF-e com aplicativo do contribuinte;
    $verProc = $dados_empresa['empresa_versao_sistema']; //'1.01'; //versão do aplicativo emissor
    $dhCont = ''; //entrada em contingência AAAA-MM-DDThh:mm:ssTZD
    $xJust = ''; //Justificativa da entrada em contingência
    $cnpj = $dados_empresa['empresa_cnpj'];
    $ano = date('y', strtotime($data));
    $mes = date('m', strtotime($data));
    //$ano = date('y', strtotime($recebe['nota_ano'])); //$recebe['nota_ano'];
    //$mes = $recebe['nota_mes'];
   // $chave = $nfe->montaChave($cUF, $ano, $mes, $cnpj, $mod, $serie, $nNF, $tpEmis, $cNF);
    $versao = $dados_empresa['empresa_versao_nfe']; //'3.10';
    //$resp = $nfe->taginfNFe($chave, $versao);

    //$cDV = substr($chave, -1); //Digito Verificador da Chave de Acesso da NF-e, o DV é calculado com a aplicação do algoritmo módulo 11 (base 2,9) da Chave de Acesso.
//tag IDE
   // $resp = $nfe->tagide($cUF, $cNF, $natOp, $indPag, $mod, $serie, $nNF, $dhEmi, $dhSaiEnt, $tpNF, $idDest, $cMunFG, $tpImp, $tpEmis, $cDV, $tpAmb, $finNFe, $indFinal, $indPres, $procEmi, $verProc, $dhCont, $xJust);


