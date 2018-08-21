<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once '../bootstrap.php';
require_once("../class/session.php");
require_once '../class/conexao.class.php';
require_once("../class/class.user.php");

use NFePHP\NFe\MakeNFe;
use NFePHP\NFe\ToolsNFe;
use NFePHP\Extras\Danfe;
use NFePHP\Common\Files\FilesFolders;
use NFePHP\Extras\Dacce;

$nfeTools = new ToolsNFe('../config/config.json');
$auth_user = new USER();

//Verificação da Sessao
$user_id = $_SESSION['user_session'];
$stmt = $auth_user->runQuery("SELECT * FROM funcionarios WHERE funcionario_id=:user_id");
$stmt->execute(array(":user_id" => $user_id));
$userRow = $stmt->fetch(PDO::FETCH_ASSOC);

$stm = $auth_user->runQuery("SELECT * FROM produto ORDER BY produto_id DESC LIMIT 0,0");
$stm->execute();

//GERAR O XML DA NOTA FEITA MANUALMENTE
if (isset($_POST['btn-gerarxml'])) {

    $nfe = new MakeNFe();

    $id_nota_id = $_POST['id'];
    // $id_transportador = strip_tags($_POST['id_transportador']);
    // PEGA OS DADOS DA NOTA PARA GERAR O XML DA NOTA
    $stmt_bus = $auth_user->runQuery("SELECT * FROM nota AS n
    LEFT JOIN  nota_referencia  AS r  ON (n.nota_id = r.id_nota) WHERE 
    n.nota_id = :nota_id");
    $stmt_bus->execute(array(":nota_id" => $id_nota_id));
    $recebe = $stmt_bus->fetch(PDO::FETCH_ASSOC);


    $stmt_busca_volume = $auth_user->runQuery("SELECT * FROM nota_volume WHERE id_nota = :id_nota");
    $stmt_busca_volume->execute(array(":id_nota" => $id_nota_id));
    // $recebe_volume = $stmt_busca_volume->fetch(PDO::FETCH_ASSOC);
    //PEGA OS DADOS DA EMPRESA PARA GERAR O XML DA NOTA
    $stmt_empresa = $auth_user->runQuery("SELECT * FROM empresa, estado, municipio WHERE empresa.id_estado = estado.estado_id "
            . "AND id_municipio = municipio_id");
    $stmt_empresa->execute();
    $dados_em = $stmt_empresa->fetch(PDO::FETCH_ASSOC);


    $stmt_cli = $auth_user->runQuery("SELECT * FROM cliente, municipio WHERE id_municipio = municipio_id AND cliente_id =:cliente_id");
    $stmt_cli->execute(array(":cliente_id" => $recebe['identificador_cliente']));
    $cli = $stmt_cli->fetch(PDO::FETCH_ASSOC);


    //PROCESSO DE GERACAO DO XML
    $cUF = $recebe['nota_numero_uf']; //codigo numerico do estado
    $cNF = $recebe['nota_numero'];
    //VERIFICAR COMO COLOCAR A NATUREZA DA OPERAÇÃO AQUI    
    $natOp = $recebe['nota_natureza_operacao']; //natureza da operação
    $indPag = $recebe['nota_indpag'];
    $mod = $recebe['nota_modelo']; //modelo da NFe 55 ou 65 essa última NFCe
    $serie = $recebe['nota_serie']; //serie da NFe
    $nNF = $recebe['nota_numero_nf']; // numero da NFe
    $dhEmi = date("Y-m-d\TH:i:sP"); //Formato: “AAAA-MM-DDThh:mm:ssTZD” (UTC - Universal Coordinated Time).
    $dhSaiEnt = date("Y-m-d\TH:i:sP"); //Não informar este campo para a NFC-e.
    $tpNF = $recebe['nota_tipo'];
    $idDest = $recebe['nota_tipo_operacao']; //1=Operação interna; 2=Operação interestadual; 3=Operação com exterior.
    $cMunFG = $recebe['nota_codigo_municipio'];
    $tpImp = $recebe['nota_impressao'];
    $tpEmis = $recebe['nota_tipo_emissao']; //1=Emissão normal (não em contingência);
    $tpAmb = $recebe['nota_ambiente']; //1=Produção; 2=Homologação
    $finNFe = $recebe['nota_finalidade']; //1=NF-e normal; 2=NF-e complementar; 3=NF-e de ajuste; 4=Devolução/Retorno.
    $indFinal = $recebe['nota_indicador_finalidade']; //0=Normal; 1=Consumidor final;
    $indPres = $recebe['nota_indicador_presencial']; //0=Não se aplica (por exemplo, Nota Fiscal complementar ou de ajuste);
    $procEmi = $recebe['nota_tipo_sistema']; //0=Emissão de NF-e com aplicativo do contribuinte;
    $verProc = $dados_em['empresa_versao_sistema']; //versão do aplicativo emissor
    $dhCont = $recebe['nota_data_contigencia']; //entrada em contingência AAAA-MM-DDThh:mm:ssTZD
    $xJust = $recebe['nota_justificativa_contigencia']; //Justificativa da entrada em contingência
    $cnpj = $recebe['nota_cnpj'];
    $ano = $recebe['nota_ano'];
    $mes = $recebe['nota_mes'];
    $chave = $nfe->montaChave($cUF, $ano, $mes, $cnpj, $mod, $serie, $nNF, $tpEmis, $cNF); // AQUI ATUALIZAR O BANCO CHAVE
    $versao = $dados_em['empresa_versao_nfe']; //$dados_em['empresa_versao_sistema'];
    $resp = $nfe->taginfNFe($chave, $versao);

    $cDV = substr($chave, -1); //Digito Verificador da Chave de Acesso da NF-e, o DV é calculado com a aplicação do algoritmo módulo 11 (base 2,9) da Chave de Acesso.
//tag IDE
    $resp = $nfe->tagide($cUF, $cNF, $natOp, $indPag, $mod, $serie, $nNF, $dhEmi, $dhSaiEnt, $tpNF, $idDest, $cMunFG, $tpImp, $tpEmis, $cDV, $tpAmb, $finNFe, $indFinal, $indPres, $procEmi, $verProc, $dhCont, $xJust);
//REFERENCIA NO CASO DE DEVOLUCAO 



    if ($recebe['nota_referencia_chave'] != '' && ($recebe['nota_finalidade'] == 4)) {
        $refNFe = $recebe['nota_referencia_chave'];
        $resp = $nfe->tagrefNFe($refNFe);
    }
    if (($recebe['nota_finalidade'] == 2)) {
        $refNFe = $recebe['nota_referencia_chave'];
        $resp = $nfe->tagrefNFe($refNFe);
    }

    $atu_not = $auth_user->runQuery('UPDATE nota SET '
            . 'nota_chave = :nota_chave, '
            . 'nota_versao = :nota_versao, '
            . 'nota_digito_verificador = :nota_digito_verificador '
            . ' WHERE nota_id = :nota_id');

    $atu_not->execute(array(
        ':nota_id' => $id_nota_id,
        ':nota_chave' => $chave,
        ':nota_versao' => $versao,
        ':nota_digito_verificador' => $cDV
    ));

    $CNPJ = $dados_em['empresa_cnpj'];
    $CPF = $dados_em['empresa_cpf']; // Utilizado para CPF na nota
    $xNome = $dados_em['empresa_nome'];
    $xFant = $dados_em['empresa_fantasia'];
    $IE = $dados_em['empresa_ie'];
    $IEST = $dados_em['empresa_ie_st'];
    $IM = $dados_em['empresa_im'];
    $CNAE = $dados_em['empresa_cnae'];
    $CRT = $dados_em['empresa_crt'];
    $resp = $nfe->tagemit($CNPJ, $CPF, $xNome, $xFant, $IE, $IEST, $IM, $CNAE, $CRT);
//endereço do emitente
    $xLgr = $dados_em['empresa_logradouro'];
    $nro = $dados_em['empresa_numero'];
    $xCpl = $dados_em['empresa_complemento'];
    $xBairro = $dados_em['empresa_bairro'];
    $cMun = $dados_em['municipio_cod_ibge'];
    $xMun = $dados_em['municipio_nome'];
    $UF = $dados_em['municipio_sigla'];
    $CEP = $dados_em['empresa_cep'];
    $cPais = '1058';
    $xPais = 'Brasil';
    $fone = $dados_em['empresa_telefone'];
    $resp = $nfe->tagenderEmit($xLgr, $nro, $xCpl, $xBairro, $cMun, $xMun, $UF, $CEP, $cPais, $xPais, $fone);

//destinatário
    $CNPJ = $cli['cliente_cpf_cnpj'];
    $CPF = $cli['cliente_cpf'];
    $idEstrangeiro = $cli['cliente_id_estrageiro'];
    $xNome = $cli['cliente_nome'];
    $indIEDest = $cli['cliente_tipo'];
    $IE = $cli['cliente_ie'];
//$ISUF = $dados_pedido['cliente_inscricao_suframa']; //'';
    if ($cli['cliente_inscricao_suframa'] == '') {
        $ISUF = '';
    } else {
        $ISUF = $cli['cliente_inscricao_suframa'];
    }
//$IM = $dados_pedido['cliente_inscricao_municipal']; //'';
    if ($cli['cliente_inscricao_municipal'] == '') {
        $IM = '';
    } else {
        $IM = $cli['cliente_inscricao_municipal'];
    }
    $email = $cli['cliente_email_nfe'];
    $resp = $nfe->tagdest($CNPJ, $CPF, $idEstrangeiro, $xNome, $indIEDest, $IE, $ISUF, $IM, $email);
//Endereço do destinatário
    $xLgr = $cli['cliente_logradouro'];
    $nro = $cli['cliente_numero'];
    $xCpl = $cli['cliente_complemento'];
    $xBairro = $cli['cliente_bairro'];
    $cMun = $cli['municipio_cod_ibge'];
    $xMun = $cli['municipio_nome'];
    $UF = $cli['municipio_sigla'];
    $CEP = $cli['cliente_cep'];
    $cPais = '1058';
    $xPais = 'Brasil';
    $fone = $cli['cliente_telefone'];
    $resp = $nfe->tagenderDest($xLgr, $nro, $xCpl, $xBairro, $cMun, $xMun, $UF, $CEP, $cPais, $xPais, $fone);

//AVISO O QUE MECHER AQUI VERIFICAR COM O TOTAL DA NFE
// BUSCA OS DADOS DO PEDIDO PARA GERAR VALORES DE IMPOSTOS DE ACORDO COM A TES E A ST
//VERIFICAR AQUI A BUSCA DE INFORMAÇÕES DE ACORDO COM O QUE ESTA NO BANCO DE 

    $cliente_consumidor = $cli['cliente_consumidor'];
    if ($cliente_consumidor == 1) {
        $tipo_consumidor = 0;
    } else {
        $tipo_consumidor = 1;
    }


    $tipo_cliente = $cli['cliente_tipo'] + $cli['cliente_consumidor'];

    //AQUI BUSCA INFORMAÇÕES DA TES PARA PEGAR A CORRETA DE DENTRO/FORA DO ESTADO OU EXTERIOR
    if ($cli['municipio_sigla'] == $dados_em['municipio_sigla']) {
        $tes_itens_origem = 1;
    }
    if ($cli['municipio_sigla'] != $dados_em['municipio_sigla']) {
        $tes_itens_origem = 2;
    }
    if ($cli['municipio_sigla'] == 'EX') {
        $tes_itens_origem = 3;
    }


    $stmt_produtos = $auth_user->runQuery(
            "SELECT * FROM nota_itens, sticms,icms, tes_itens,
    produto, unidade, ncm, st, ipi, pis, cofins WHERE
    sticms.id_st = nota_itens.nota_itens_id_st AND
    nota_itens.id_nota_id = {$id_nota_id} AND
    sticms.sticms_uf = '{$cli['municipio_sigla']}' AND 
    sticms.sticms_cso = icms.icms_id AND
    tes_itens.id_tes = nota_itens.nota_itens_id_tes AND
    tes_itens.tes_itens_contribuinte = :tipo_consumidor AND
    tes_itens.tes_itens_origem = {$tes_itens_origem} AND
    sticms.sticms_tipo_pessoa = :tipo_cliente AND
    nota_itens.nota_itens_id_produto = produto.produto_id AND
    produto.id_unidade = unidade.unidade_id AND
    produto.id_ncm = ncm.ncm_id AND 
    sticms.id_st = st.st_id AND 
    st.id_ipi = ipi.ipi_id AND
    st.id_pis = pis.pis_id AND
    st.id_cofins = cofins.cofins_id
    "
    );
//VERIRIFICAR AQUI E PASSAR OS PARAMENTROS CORRETOS
    $stmt_produtos->execute(array(
        //':pedido_id' => $pedido_id,
        ':tipo_cliente' => $tipo_cliente,
        ':tipo_consumidor' => $tipo_consumidor
            // ':cliente_estado' => $cliente_estado
    ));


// $busca_config = $stmt_produtos->fetch(PDO::FETCH_ASSOC);
// BUSCA O TOTAL DE ICMS DO PRODUTO

    $cont = 1;
    $flagICMS = 0;
    $flagPIS = 0;
    $flagCONFIS = 0;
    $flagIPI = 0;
    $flagDesc = 0;
    $flagBCICMS = 0;
    $totalICMSDest = 0;
    $totalFCP = 0;
    $totalICMSRemet = 0;

    while ($linha = $stmt_produtos->fetch(PDO::FETCH_ASSOC)) {
        //echo $linha['produto_nome'];


        if ($linha['nota_itens_valor_frete'] == 0.00) {
            $linha['nota_itens_valor_frete'] = '';
        }
        if ($linha['nota_itens_valor_seguro'] == 0.00) {
            $linha['nota_itens_valor_seguro'] = '';
        }
        if ($linha['nota_itens_valor_desconto'] == 0.00) {
            $linha['nota_itens_valor_desconto'] = '';
        }
        if ($linha['nota_itens_outras_despesas'] == 0.00) {
            $linha['nota_itens_outras_despesas'] = '';
        }

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
            'qCom' => $linha['nota_itens_qtd'],
            'vUnCom' => $linha['nota_itens_valor'],
            'vProd' => $linha['nota_itens_total'],
            'cEANTrib' => $linha['produto_ean'],
            'uTrib' => $linha['unidade_nome'],
            'qTrib' => $linha['nota_itens_qtd'],
            'vUnTrib' => $linha['nota_itens_valor'],
            'vFrete' => $linha['nota_itens_valor_frete'],
            'vSeg' => $linha['nota_itens_valor_seguro'],
            'vDesc' => $linha['nota_itens_valor_desconto'],
            'vOutro' => $linha['nota_itens_outras_despesas'],
            'indTot' => '1',
            'xPed' => $linha['nota_itens_numero_compra'],
            'nItemPed' => $cont,
            'nFCI' => $linha['nota_itens_numero_nfci']
        );
        //INFORMAÇÕES ADICIONAIS DO PRODUTO

        if ($linha['nota_itens_descricao'] != '') {
            $nItem = $cont; //produtos 2
            $vDesc = $linha['nota_itens_descricao']; //'CaixaS';
            // $vDesc = 'Caixas';
            $resp = $nfe->taginfAdProd($nItem, $vDesc);
        }


//  ======******  BUSCAR O IMPOSTO DO ITEM PARA GERAR O TOTAL DE IMPOSTO POR PRODUTO *****========
        //Base do ICMS Inter = (Valor do produto + Frete + Seguro + Outras Despesas Acessórias – Descontos)
        //Valor do ICMS Inter = Base ICMS Inter * (Alíquota ICMS Inter / 100)
        //ICMS
        if ($linha['sticms_aliquota'] > 0) {
            $base_icms = (($linha['nota_itens_total'] + $linha['nota_itens_valor_frete'] +
                    $linha['nota_itens_valor_seguro'] + $linha['nota_itens_outras_despesas']) - $linha['nota_itens_valor_desconto']);
            $valor_icms = $base_icms * ($linha['sticms_aliquota'] / 100);
        } else {
            $valor_icms = 0;
            $base_icms = 0;
        }


        //Base do ICMS ST = (Valor do produto + Valor do IPI + Frete + Seguro + Outras Despesas Acessórias – Descontos) * (1+(%MVA / 100))
        //Valor do ICMS ST = (Base do ICMS ST * (Alíquota do ICMS Intra / 100)) – Valor do ICMS Inter
        //ICMS ST
        if ($linha['sticms_st_aliquota'] > 0) {
            $base_icmsst = ($linha['nota_itens_total'] + $linha['nota_itens_valor_frete'] + $linha['nota_itens_valor_seguro'] +
                    $linha['nota_itens_outras_despesas'] - $linha['nota_itens_valor_desconto']) * (1 + ($linha['sticms_st_mva'] / 100));

            $valor_icmsst = ($base_icmsst * ($linha['sticms_st_aliquota'] / 100)) - $valor_icms;
        } else {
            $valor_icmsst = 0;
            $base_icmsst = 0;
        }
        //Base de cálculo = (Valor do produto + Frete + Seguro + Outras Despesas Acessórias)
        //Valor do IPI = Base de cálculo * (Alíquota / 100)
        //IPI
        if ($linha['st_ipi_aliquota'] > 0) {
            $base_ipi = ($linha['nota_itens_total'] + $linha['nota_itens_valor_frete'] + $linha['nota_itens_valor_seguro'] +
                    $linha['nota_itens_outras_despesas']);
            $valor_ipi = $base_ipi * ($linha['st_ipi_aliquota'] / 100);
        } else {
            $valor_ipi = 0;
            $base_ipi = 0;
        }
        //PIS
        if ($linha['st_pis_aliquota'] > 0) {
            $valor_pis = $linha['nota_itens_total'] * ($linha['st_pis_aliquota'] / 100);
        } else {
            $valor_pis = 0.00;
        }
        //COFINS
        if ($linha['st_cofins_aliquota'] > 0) {
            $valor_cofins = $linha['nota_itens_total'] * ($linha['st_cofins_aliquota'] / 100);
        } else {
            $valor_cofins = 0.00;
        }



        //TOTAL DE IMPOSTOS DO PRODUTO (ICMS + ICMS-ST + IPI + CONFIS)
        //VERIFICAR MAS CORRETAMENTE ESSE CAMPO AQUI.

        $nItem = $cont; //produtos 1
        //$vTotTrib = ''; // 226.80 ICMS + 51.50 ICMSST + 50.40 IPI + 39.36 PIS + 81.84 CONFIS
        $vTotTrib = number_format(($valor_icms + $valor_icmsst + $valor_ipi + $valor_pis + $valor_cofins), 2, '.', '');
        $resp = $nfe->tagimposto($nItem, $vTotTrib);


        //ICMS - IMPOSTO SOBRE CIRCULAÇÃO DE MERCADORIAS E SERVIÇOS
        //AQUI TEM VER COMO FAZER, MAS ACREDITO QUE ISSO DEVE SER FEITO LA NO CADASTRO DO PRODUTO
        //TOTAL DE IMPOSTOS DO PRODUTO (ICMS + ICMS-ST + IPI + CONFIS)
        //VERIFICAR MAS CORRETAMENTE ESSE CAMPO AQUI.

        $nItem = $cont; //produtos 1
        //$vTotTrib = ''; // 226.80 ICMS + 51.50 ICMSST + 50.40 IPI + 39.36 PIS + 81.84 CONFIS
        $vTotTrib = number_format(($valor_icms + $valor_icmsst + $valor_ipi + $valor_pis + $valor_cofins), 2, '.', '');
        $resp = $nfe->tagimposto($nItem, $vTotTrib);


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
        $modBCST = '';
        $pMVAST = '';
        $pRedBCST = '';
        $vBCST = '';
        $pICMSST = '';
        $vICMSST = '';
        $pDif = '';
        $vICMSDif = '';
        $vICMSOp = '';
        if ($cst == 51) {
            $vICMSOp = $vICMS;
        }

        $vBCSTRet = '';
        $vICMSSTRet = '';
        if ($dados_em['empresa_crt'] == 3) {
            $resp = $nfe->tagICMS($nItem, $orig, $cst, $modBC, $pRedBC, $vBC, $pICMS, $vICMS, $vICMSDeson, $motDesICMS, $modBCST, $pMVAST, $pRedBCST, $vBCST, $pICMSST, $vICMSST, $pDif, $vICMSDif, $vICMSOp, $vBCSTRet, $vICMSSTRet);
        }
        if ($dados_em['empresa_crt'] == 1) {
            //ICMSSN - Tributação ICMS pelo Simples Nacional - CSOSN 500
            $nItem = $cont; //produtos 1
            $orig = $linha['produto_origem']; //'0';
            //$csosn = '101'; //ICMS cobrado anteriormente por substituição tributária (substituído) ou por antecipação
            // $modBC = '1';
            $csosn = $linha['icms_codigo'];

            $modBC = $linha['sticms_modalidade_base_calculo']; //'3';

            $pRedBC = '';
            // $vBC = ''; //12.00 = $qTrib * $vUnTrib
            $vBC = number_format($base_icms, 2, '.', '');
            $pICMS = $linha['sticms_aliquota'];
            $vICMS = $vBC * ( $pICMS / 100 );
            $vICMS = number_format($vICMS, 2, '.', '');

            $flagICMS = $flagICMS + $vICMS;
            $flagICMS = number_format($flagICMS, 2, '.', '');


            $pCredSN = '';
            $vCredICMSSN = '';

            //FAZ A BUSCA DA ALIQUOTA MENSAL DO APROVEITAMENTO DO ICMS
            if ($csosn == 101) {

                $mes1 = date("m");
                $ano1 = date("Y");

                $busca_ali_cred_icms = $auth_user->runQuery("select * from aproveitamento "
                        . "where aproveitamento_mes = {$mes1} and aproveitamento_ano = {$ano1}");
                $busca_ali_cred_icms->execute();
                $busca_ali_cred = $busca_ali_cred_icms->fetch(PDO::FETCH_ASSOC);
                if (!$busca_ali_cred) {
                    echo "Sem Cadastro na Aliquota Mensal do MES " . $mes1 . " e ano " . $ano1;
                    exit();
                } else {

                    //CALCULO DA ALIQUOTA DE CREDITO DE ICMS
                    $pCredSN = $busca_ali_cred['aproveitamento_aliquota'];
                    $vCredICMSSN = number_format(($linha['nota_itens_total'] * $pCredSN) / 100, 2, '.', '');
                    
                    $up_cred_icms = $auth_user->runQuery('UPDATE nota_itens SET '
                            . 'nota_itens_aliquota_cred_icms = :nota_itens_aliquota_cred_icms, '
                            . 'nota_itens_valor_cred_icms = :nota_itens_valor_cred_icms'
                            . ' WHERE id_nota_id = :id_nota_id');

                    $up_cred_icms->execute(array(
                        ':id_nota_id' => $id_nota_id,
                        ':nota_itens_aliquota_cred_icms' => $pCredSN,
                        ':nota_itens_valor_cred_icms' => $vCredICMSSN
                    ));
                }
            }

            $modBCST = '';
            $pMVAST = '';
            $pRedBCST = '';
            $vBCST = '';
            $pICMSST = ''; //27.00 = GO para GO
            $vICMSST = '';
            $vBCSTRet = ''; // Pauta do Chope Claro 1000ml em GO R$ 8,59 x 0.660 Litros
            $vICMSSTRet = ''; // = (Valor da Pauta * Alíquota ICMS ST) - Valor ICMS Próprio

            $resp = $nfe->tagICMSSN($nItem, $orig, $csosn, $modBC, $vBC, $pRedBC, $pICMS, $vICMS, $pCredSN, $vCredICMSSN, $modBCST, $pMVAST, $pRedBCST, $vBCST, $pICMSST, $vICMSST, $vBCSTRet, $vICMSSTRet);
        }
//
//        $nItem = $cont; //produtos 1
//        $orig = $linha['produto_origem']; //'0';
//        // $cst = '00'; // Tributado Integralmente
//        $cst = $linha['icms_codigo'];
//        $modBC = $linha['sticms_modalidade_base_calculo']; //'3';
//        //$pRedBC = '';
//        $pRedBC = $linha['sticms_reducao_base_calculo'];
//        $vBC = $linha['nota_itens_total']; // = $qTrib * $vUnTrib
//        //$pICMS = '7.00'; // Alíquota do Estado de GO p/ 'NCM 2203.00.00 - Cervejas de Malte, inclusive Chope'
//        $pICMS = $linha['sticms_aliquota'];
//        $vICMS = $vBC * ( $pICMS / 100 );
//        $vICMS = number_format($vICMS, 2, '.', '');
//        $flagICMS = $flagICMS + $vICMS;
//        $flagICMS = number_format($flagICMS, 2, '.', '');
//        $vICMSDeson = '';
//        $motDesICMS = '';
//        $modBCST = '';
//        $pMVAST = '';
//        $pRedBCST = '';
//        $vBCST = '';
//        $pICMSST = '';
//        $vICMSST = '';
//        $pDif = '';
//        $vICMSDif = '';
//        $vICMSOp = '';
//        if ($cst == 51) {
//            $vICMSOp = $vICMS;
//        }
//        $vBCSTRet = '';
//        $vICMSSTRet = '';
//        $resp = $nfe->tagICMS($nItem, $orig, $cst, $modBC, $pRedBC, $vBC, $pICMS, $vICMS, $vICMSDeson, $motDesICMS, $modBCST, $pMVAST, $pRedBCST, $vBCST, $pICMSST, $vICMSST, $pDif, $vICMSDif, $vICMSOp, $vBCSTRet, $vICMSSTRet);
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
        $vBC = ($linha['nota_itens_total'] + $linha['nota_itens_valor_frete'] + $linha['nota_itens_valor_seguro'] +
                $linha['nota_itens_outras_despesas']);
        $vBC = number_format($vBC, 2, '.', '');
        $pIPI = $linha['st_ipi_aliquota']; //''; //Calculo por alíquota - 6% Alíquota GO.
        $qUnid = '';
        $vUnid = '';
        //$vIPI = ''; // = $vBC * ( $pIPI / 100 )
        $vIPI = number_format(($vBC * ( $pIPI / 100 )), 2, '.', '');
        $flagIPI = $flagIPI + $vIPI;
        $flagIPI = number_format($flagIPI, 2, '.', '');

        $resp = $nfe->tagIPI($nItem, $cst, $clEnq, $cnpjProd, $cSelo, $qSelo, $cEnq, $vBC, $pIPI, $qUnid, $vUnid, $vIPI);

        //PIS AQUI ESTA A SITUAÇÃO DO PIS 
        //VERIFICAR A POSSIBILIDADE DE INTEGRAR A ST COM O PRODUTO
        /**/
        $nItem = $cont; //produtos 1
        // $cst = '01'; //Operação Tributável (base de cálculo = quantidade vendida x alíquota por unidade de produto)
        $cst = $linha['pis_codigo'];
        $vBC = $linha['nota_itens_total'];
        $vBC = number_format($vBC, 2, '.', '');
        //$pPIS = '1.65';
        $pPIS = $linha['st_pis_aliquota'];
        $vPIS = ($vBC * $pPIS ) / 100;
        $vPIS = number_format($vPIS, 2, '.', '');
        $flagPIS = $flagPIS + $vPIS;
        $flagPIS = number_format($flagPIS, 2, '.', '');
        $qBCProd = '';
        $vAliqProd = '';
        $resp = $nfe->tagPIS($nItem, $cst, $vBC, $pPIS, $vPIS, $qBCProd, $vAliqProd);


        //COFINS - Contribuição para o Financiamento da Seguridade Social

        $nItem = $cont; //produtos 1
        //$cst = '01'; //Operação Tributável (base de cálculo = quantidade vendida x alíquota por unidade de produto)
        $cst = $linha['cofins_codigo'];
        $vBC = $linha['nota_itens_total'];
        $vBC = number_format($vBC, 2, '.', '');
        $pCOFINS = $linha['st_cofins_aliquota'];
        $vCOFINS = ($vBC * $pCOFINS ) / 100;
        $vCOFINS = number_format($vCOFINS, 2, '.', '');
        $flagCONFIS = $flagCONFIS + $vCOFINS;
        $flagCONFIS = number_format($flagCONFIS, 2, '.', '');
        $qBCProd = '';
        $vAliqProd = '';
        $resp = $nfe->tagCOFINS($nItem, $cst, $vBC, $pCOFINS, $vCOFINS, $qBCProd, $vAliqProd);


        //AQUI VERIFICAR SE O CARA E CONSUMIDOR FINAL E GERAR O ICMS PARTILHA.

        if ($linha['sticms_tipo_pessoa'] == 10) {

            if ($dados_em['municipio_sigla'] != $cli['municipio_sigla']) {

                $nItem = $cont;
                //BASE DE CALCULO DO ICMS PARTILHA
                $vBCUFDest = (($linha['nota_itens_total'] + $linha['nota_itens_valor_frete'] +
                        $linha['nota_itens_valor_seguro'] + $linha['nota_itens_outras_despesas']) - $linha['nota_itens_valor_desconto'] + $vIPI);
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
                $resp = $nfe->tagICMSUFDest($nItem, $vBCUFDest, $pFCPUFDest, $pICMSUFDest, $pICMSInter, $pICMSInterPart, $vFCPUFDest, $vICMSUFDest, $vICMSUFRemet);
                //PRECISO GRAVAR ISSO DO BANCO DE DADOS.

                $totalICMSDest = $totalICMSDest + $vICMSUFDest;
                //  print_r($totalICMSDest);
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

        //ATUALIZAR O BANCO
        //ATUALIZA O ICMS NO BANCO DE DADOS COM OS DADOS DA TES E ST.
        //VERIFICAR OS ITENS DE ICMS FALTANDO NA NF-E

        $up_nota_itens = $auth_user->runQuery('UPDATE nota_itens SET 
            nota_itens_cst = :nota_itens_cst,
            nota_itens_bc_icms = :nota_itens_bc_icms,
            nota_itens_modalidade_calculo_icms = :nota_itens_modalidade_calculo_icms,
            nota_itens_reducao_calculo_icms = :nota_itens_reducao_calculo_icms,
            nota_itens_base_calculo_icms = :nota_itens_base_calculo_icms,
            nota_itens_valor_icms_op = :nota_itens_valor_icms_op,
            nota_itens_perc_dif = :nota_itens_perc_dif,
            
            nota_itens_aliquota = :nota_itens_aliquota,
            nota_itens_valor_icms = :nota_itens_valor_icms,
            
            nota_itens_st_bc = :nota_itens_st_bc,
            nota_itens_st_comportamento = :nota_itens_st_comportamento,
            nota_itens_st_modalidade_calculo = :nota_itens_st_modalidade_calculo,
            nota_itens_st_mva = :nota_itens_st_mva,
            nota_itens_st_reducao_calculo = :nota_itens_st_reducao_calculo,
            nota_itens_st_aliquota = :nota_itens_st_aliquota,
            nota_itens_st_valor = :nota_itens_st_valor,
            nota_itens_par_pobreza = :nota_itens_par_pobreza,
            nota_itens_par_destino = :nota_itens_par_destino,
            nota_itens_par_origem = :nota_itens_par_origem,
            
            nota_itens_id_ipi = :nota_itens_id_ipi,
            nota_itens_ipi_classe = :nota_itens_ipi_classe,
            nota_itens_ipi_cod = :nota_itens_ipi_cod,
            nota_itens_ipi_tipo_calculo = :nota_itens_ipi_tipo_calculo,
            nota_itens_ipi_aliquota = :nota_itens_ipi_aliquota,
            nota_itens_ipi_valor = :nota_itens_ipi_valor,
            
            nota_itens_id_pis = :nota_itens_id_pis,
            nota_itens_pis_tipo_calculo = :nota_itens_pis_tipo_calculo,
            nota_itens_pis_base_calculo = :nota_itens_pis_base_calculo,
            nota_itens_pis_aliquota = :nota_itens_pis_aliquota,
            nota_itens_pis_valor = :nota_itens_pis_valor,
            nota_itens_pis_st_tipo_calculo = :nota_itens_pis_st_tipo_calculo,
            nota_itens_pis_st_base_calculo = :nota_itens_pis_st_base_calculo,
            nota_itens_pis_st_aliquota = :nota_itens_pis_st_aliquota,
            nota_itens_pis_st_valor = :nota_itens_pis_st_valor,
            
            nota_itens_id_cofins = :nota_itens_id_cofins,
            nota_itens_cofins_tipo_calculo = :nota_itens_cofins_tipo_calculo,
            nota_itens_cofins_aliquota = :nota_itens_cofins_aliquota,
            nota_itens_cofins_valor = :nota_itens_cofins_valor                  

            WHERE nota_itens_id = :nota_itens_id');

        $up_nota_itens->execute(array(
            //REVISAR QUANDO PUDER 
            ':nota_itens_id' => $linha['nota_itens_id'],
            ':nota_itens_cst' => $linha['icms_codigo'],
            ':nota_itens_bc_icms' => $base_icms,
            ':nota_itens_modalidade_calculo_icms' => $linha['sticms_modalidade_base_calculo'],
            ':nota_itens_reducao_calculo_icms' => $linha['sticms_reducao_base_calculo'],
            ':nota_itens_base_calculo_icms' => $linha['sticms_base_calculo'],
            ':nota_itens_valor_icms_op' => $linha['icms_codigo'],
            ':nota_itens_perc_dif' => $linha['sticms_perc_diferimento'],
            ':nota_itens_aliquota' => $linha['sticms_aliquota'],
            ':nota_itens_valor_icms' => $valor_icms, //
            ':nota_itens_st_bc' => $linha['sticms_base_calculo'], // VERIFICAR AQUI ESSA BASE DE ICMS 
            ':nota_itens_st_comportamento' => $linha['sticms_st_comportamento'],
            ':nota_itens_st_modalidade_calculo' => $linha['sticms_st_modalidade_calculo'],
            ':nota_itens_st_mva' => $linha['sticms_st_mva'],
            ':nota_itens_st_reducao_calculo' => $linha['sticms_st_reducao_calculo'],
            ':nota_itens_st_aliquota' => $linha['sticms_st_aliquota'],
            ':nota_itens_st_valor' => $valor_icmsst,
            ':nota_itens_par_pobreza' => $linha['sticms_par_pobreza'],
            ':nota_itens_par_destino' => $linha['sticms_par_destino'],
            ':nota_itens_par_origem' => $linha['sticms_par_origem'],
            ':nota_itens_id_ipi' => $linha['id_ipi'],
            ':nota_itens_ipi_classe' => $linha['st_ipi_classe'],
            ':nota_itens_ipi_cod' => $linha['st_ipi_cod'],
            ':nota_itens_ipi_tipo_calculo' => $linha['st_ipi_tipo_calculo'],
            ':nota_itens_ipi_aliquota' => $linha['st_ipi_aliquota'],
            ':nota_itens_ipi_valor' => $valor_ipi,
            ':nota_itens_id_pis' => $linha['id_pis'],
            ':nota_itens_pis_tipo_calculo' => $linha['st_pis_tipo_calculo'],
            ':nota_itens_pis_base_calculo' => $linha['nota_itens_total'],
            ':nota_itens_pis_aliquota' => $linha['st_pis_aliquota'],
            ':nota_itens_pis_valor' => $valor_pis,
            ':nota_itens_pis_st_tipo_calculo' => $linha['st_pis_tipo_calculo_st'],
            ':nota_itens_pis_st_base_calculo' => $linha['nota_itens_total'],
            ':nota_itens_pis_st_aliquota' => $linha['st_pis_aliquota_st'],
            ':nota_itens_pis_st_valor' => number_format(($linha['nota_itens_total'] * $linha['st_pis_aliquota_st']) / 100, 2, '.', ''),
            ':nota_itens_id_cofins' => $linha['id_cofins'],
            ':nota_itens_cofins_tipo_calculo' => $linha['st_cofins_tipo_calculo'],
            ':nota_itens_cofins_aliquota' => $linha['st_cofins_aliquota'],
            ':nota_itens_cofins_valor' => $valor_cofins
        ));


//        $pCredSN = $busca_ali_cred['aproveitamento_aliquota'];
//        $vCredICMSSN = number_format(($linha['nota_itens_total'] * $pCredSN) / 100, 2, '.', '');
//



        $cont++;
    }
    unset($cont);


    foreach ($aP as $prod) {
        $nItem = $prod['nItem'];
        $cProd = $prod['cProd'];
        $cEAN = $prod['cEAN'];
        $xProd = $prod['xProd'];
        $NCM = $prod['NCM'];
        $NVE = $prod['NVE'];
        $CEST = $prod['CEST'];
        $EXTIPI = $prod['EXTIPI'];
        $CFOP = $prod['CFOP'];
        $uCom = $prod['uCom'];
        $qCom = $prod['qCom'];
        $vUnCom = $prod['vUnCom'];
        $vProd = $prod['vProd'];
        $cEANTrib = $prod['cEANTrib'];
        $uTrib = $prod['uTrib'];
        $qTrib = $prod['qTrib'];
        $vUnTrib = $prod['vUnTrib'];
        $vFrete = $prod['vFrete'];
        $vSeg = $prod['vSeg'];
        $vDesc = $prod['vDesc'];
        $vOutro = $prod['vOutro'];
        $indTot = $prod['indTot'];
        $xPed = $prod['xPed'];
        $nItemPed = $prod['nItemPed'];
        $nFCI = $prod['nFCI'];
        $resp = $nfe->tagprod($nItem, $cProd, $cEAN, $xProd, $NCM, $NVE, $CEST, $EXTIPI, $CFOP, $uCom, $qCom, $vUnCom, $vProd, $cEANTrib, $uTrib, $qTrib, $vUnTrib, $vFrete, $vSeg, $vDesc, $vOutro, $indTot, $xPed, $nItemPed, $nFCI);
    }



    //INCIALIZAÇÃO DE VARIAVEIS NÃO DECLARADAS
    $vII = isset($vII) ? $vII : 0;
    $vIPI = isset($vIPI) ? $vIPI : 0;
    $vIOF = isset($vIOF) ? $vIOF : 0;
    $vPIS = isset($vPIS) ? $vPIS : 0;
    $vCOFINS = isset($vCOFINS) ? $vCOFINS : 0;
    $vICMS = isset($vICMS) ? $vICMS : 0;
    $vBCST = isset($vBCST) ? $vBCST : 0;
    $vST = isset($vST) ? $vST : 0;
    $vISS = isset($vISS) ? $vISS : 0;

//TOTAIS

    $stmt_total = $auth_user->runQuery("SELECT SUM(nota_itens_total) FROM nota_itens WHERE id_nota_id = $id_nota_id");
    $stmt_total->execute();
    $tot = $stmt_total->fetch(PDO::FETCH_ASSOC);


// CONTINUAR AQUI MAS TEM QUE VER COMO FAZ ISSO AQUI CERTINHO! ICMS E FAZER O CALCULO CORRETO
    $vBC = $tot['SUM(nota_itens_total)']; //'3720.00';
    $vICMS = $flagICMS;
    $vICMSDeson = '0.00';
    $vBCST = '0.00';
    $vST = '0.00';
    $vProd = $tot['SUM(nota_itens_total)'];
    $vFrete = '0.00';
    $vSeg = '0.00';
    $vDesc = '0.00';
    $vII = '0.00';
    $vIPI = $flagIPI;
    $vPIS = $flagPIS;
    $vCOFINS = $flagCONFIS;
    $vOutro = '0.00';
    $vNF = number_format($vProd - $vDesc - $vICMSDeson + $vST + $vFrete + $vSeg + $vOutro + $vII + $vIPI, 2, '.', '');
    $vTotTrib = number_format($vICMS + $vST + $vII + $vIPI + $vPIS + $vCOFINS + $vIOF + $vISS, 2, '.', '');
//$vTotTrib = '';
    $resp = $nfe->tagICMSTot($vBC, $vICMS, $vICMSDeson, $vBCST, $vST, $vProd, $vFrete, $vSeg, $vDesc, $vII, $vIPI, $vPIS, $vCOFINS, $vOutro, $vNF, $vTotTrib);


    $modFrete = $recebe['nota_frete']; //0=Por conta do emitente; 1=Por conta do destinatário/remetente; 2=Por conta de terceiros; 9=Sem Frete;
    $resp = $nfe->tagtransp($modFrete);


    if ($recebe['nota_id_transportador'] != 0) {

        $stmt_transportador = $auth_user->runQuery("SELECT * FROM transportador WHERE "
                . "transportador_id = :transportador_id");
        $stmt_transportador->execute(array(":transportador_id" => $recebe['nota_id_transportador']));
        $transp = $stmt_transportador->fetch(PDO::FETCH_ASSOC);

        $CNPJ = $transp['transportador_cnpj'];
        $CPF = $transp['transportador_cpf'];
        $xNome = $transp['transportador_nome'];
        $IE = $transp['transportador_ie'];
        $xEnder = $transp['transportador_logradouro'];
        $xMun = $transp['transportador_municipio'];
        $UF = $transp['transportador_uf'];
        $resp = $nfe->tagtransporta($CNPJ, $CPF, $xNome, $IE, $xEnder, $xMun, $UF);
    }

    while ($recebe_volume = $stmt_busca_volume->fetch(PDO::FETCH_ASSOC)) {
        $qVol = $recebe_volume['nota_volume_qtd']; //Quantidade de volumes transportados
        // $qVol = $vol[0]; //Quantidade de volumes transportados
        $esp = $recebe_volume['nota_volume_especie']; //Espécie dos volumes transportados
        // $esp = $vol[1]; //Espécie dos volumes transportados
        $marca = $recebe_volume['nota_volume_marca']; //Marca dos volumes transportados
        //  $marca = $vol[2]; //Marca dos volumes transportados
        $nVol = $recebe_volume['nota_volume_numero_volume']; //Numeração dos volume
        //$nVol = $vol[3]; //Numeração dos volume
        $pesoL = intval($recebe_volume['nota_volume_peso_liquido']); //Kg do tipo Int, mesmo que no manual diz que pode ter 3 digitos verificador...
        // $pesoL = intval($vol[4]); //Kg do tipo Int, mesmo que no manual diz que pode ter 3 digitos verificador...
        $pesoB = intval($recebe_volume['nota_volume_peso_bruto']); //...se colocar Float não vai passar na expressão regular do Schema. =\
        //  $pesoB = intval($vol[5]); //...se colocar Float não vai passar na expressão regular do Schema. =\
        $aLacres = $recebe_volume['nota_volume_lacre'];
        // $aLacres = $vol[6];
        $resp = $nfe->tagvol($qVol, $esp, $marca, $nVol, $pesoL, $pesoB, $aLacres);
    }








    $nfe->montaNFe();









    if ($resp) {
        //PROCESSO DE GRAVAÇÃO DO XML NO ARQUIVO
        header('Content-type: text/xml; charset=UTF-8');
        $xml = $nfe->getXML();
        // $filename = "/var/www/nfe/homologacao/entradas/{$chave}-nfe.xml"; // Ambiente Linux
        $filename = "C:/xampp/htdocs/alubrasc/nfe/nfes/homologacao/entradas/{$chave}-nfe.xml"; // Ambiente Windows
        file_put_contents($filename, $xml);
        chmod($filename, 0777);
    } else {
        header('Content-type: text/html; charset=UTF-8');
        foreach ($nfe->erros as $err) {
            echo 'tag: &lt;' . $err['tag'] . '&gt; ---- ' . $err['desc'] . '<br>';
        }
    }
//PROCESSO DE ASSINA O NFE !
    $filename = "C:/xampp/htdocs/alubrasc/nfe/nfes/homologacao/entradas/{$chave}-nfe.xml"; // Ambiente Windows
    $xml = file_get_contents($filename);
    $xml = $nfeTools->assina($xml);
// $filename = "/var/www/nfe/homologacao/assinadas/{$chave}-nfe.xml"; // Ambiente Linux
    $filename = "C:/xampp/htdocs/alubrasc/nfe/nfes/homologacao/assinadas/{$chave}-nfe.xml"; // Ambiente Windows
    file_put_contents($filename, $xml);
    chmod($filename, 0777);
    //echo $chave;
//PROCESSO DE VALIDAÇÃO DO XML
    if (!$nfeTools->validarXml($filename) || sizeof($nfeTools->errors)) {
        echo "<h3>Eita !?! Tem erro no XML </h3>";
        foreach ($nfeTools->errors as $erro) {
            if (is_array($erro)) {
                foreach ($erro as $err) {
                    echo "$err <br>";
                }
            } else {
                echo "$erro <br>";
            }
        }
        exit;
    }
    $auth_user->redirect("../notas/index.php");
}
//CADASTRO DOS ITENS NA NOTA
if (isset($_POST['btn-cadastro-itens'])) {

    date_default_timezone_set('America/Sao_Paulo');
    $data = date('Y-m-d H:i:s');

    $id_nota_id = $_POST['id_nota_id'];
    $nota_itens_id_produto = $_POST['nota_itens_id_produto'];
    $nota_itens_produto = $_POST['produto_nome'];
    $nota_itens_qtd = str_replace(",", ".", $_POST['nota_itens_qtd']);
    $nota_itens_valor = str_replace(",", ".", $_POST['nota_itens_valor']);

    $nota_itens_total = $nota_itens_qtd * $nota_itens_valor;
    $nota_itens_total = str_replace(",", ".", $nota_itens_total);

    $nota_itens_valor_frete = str_replace(",", ".", $_POST['nota_itens_valor_frete']);
    $nota_itens_valor_seguro = str_replace(",", ".", $_POST['nota_itens_valor_seguro']);
    $nota_itens_valor_desconto = str_replace(",", ".", $_POST['nota_itens_valor_desconto']);
    $nota_itens_outras_despesas = str_replace(",", ".", $_POST['nota_itens_outras_despesas']);
    $nota_itens_idtot = str_replace(",", ".", $_POST['nota_itens_idtot']);
    $nota_itens_descricao = str_replace(",", ".", $_POST['nota_itens_descricao']);
    $nota_itens_numero_compra = str_replace(",", ".", $_POST['nota_itens_numero_compra']);
    $nota_itens_item_compra = str_replace(",", ".", $_POST['nota_itens_item_compra']);
    $nota_itens_numero_nfci = $_POST['nota_itens_numero_nfci'];
    $nota_itens_id_st = str_replace(",", ".", $_POST['nota_itens_id_st']);
    $nota_itens_id_tes = str_replace(",", ".", $_POST['nota_itens_id_tes']);

    //BUSCA INFORMAÇÕES DO PRODUTO PARA O CADASTRO NA NFE(ncm, st, OUTROS).....
    $stmt_busca_produto = $auth_user->runQuery("SELECT * FROM produto, ncm, unidade, grupo WHERE"
            . " id_ncm = ncm_id AND"
            . " id_unidade = unidade_id AND"
            . " id_grupo = grupo_id AND"
            . " produto_id = {$nota_itens_id_produto}");
    $stmt_busca_produto->execute();
    $resposta_busca = $stmt_busca_produto->fetch(PDO::FETCH_ASSOC);


    try {
        $stmt = $auth_user->runQuery("INSERT INTO nota_itens
            (
            id_nota_id,
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
            nota_itens_cest,
            nota_itens_origem
            
            
            
            )
            VALUES(
            :id_nota_id,
            :nota_itens_produto, 
            :nota_itens_qtd, 
            :nota_itens_valor, 
            :nota_itens_total, 
            :nota_itens_id_produto,
            :nota_itens_id_st,
            :nota_itens_id_tes,
            :nota_itens_valor_frete,
            :nota_itens_valor_seguro,
            :nota_itens_valor_desconto,
            :nota_itens_outras_despesas,
            :nota_itens_idtot,
            :nota_itens_numero_compra,
            :nota_itens_item_compra,
            :nota_itens_numero_nfci,
            :nota_itens_descricao, 
            :nota_itens_ncm,
            :nota_itens_cest,
            :nota_itens_origem
            )");

        $stmt->bindparam(":id_nota_id", $id_nota_id);
        $stmt->bindparam(":nota_itens_produto", $resposta_busca['produto_nome']);
        $stmt->bindparam(":nota_itens_qtd", $nota_itens_qtd);
        $stmt->bindparam(":nota_itens_valor", $nota_itens_valor);
        $stmt->bindparam(":nota_itens_total", $nota_itens_total);
        $stmt->bindparam(":nota_itens_id_produto", $nota_itens_id_produto);
        $stmt->bindparam(":nota_itens_id_st", $nota_itens_id_st);
        $stmt->bindparam(":nota_itens_id_tes", $nota_itens_id_tes);
        $stmt->bindparam(":nota_itens_valor_frete", $nota_itens_valor_frete);
        $stmt->bindparam(":nota_itens_valor_seguro", $nota_itens_valor_seguro);
        $stmt->bindparam(":nota_itens_valor_desconto", $nota_itens_valor_desconto);
        $stmt->bindparam(":nota_itens_outras_despesas", $nota_itens_outras_despesas);
        $stmt->bindparam(":nota_itens_idtot", $nota_itens_idtot);
        $stmt->bindparam(":nota_itens_numero_compra", $nota_itens_numero_compra);
        $stmt->bindparam(":nota_itens_item_compra", $nota_itens_item_compra);
        $stmt->bindparam(":nota_itens_numero_nfci", $nota_itens_numero_nfci);
        $stmt->bindparam(":nota_itens_descricao", $nota_itens_descricao);
        $stmt->bindparam(":nota_itens_ncm", $resposta_busca['ncm_numero']);
        $stmt->bindparam(":nota_itens_cest", $resposta_busca['produto_cest']);
        $stmt->bindparam(":nota_itens_origem", $resposta_busca['produto_origem']);
        $stmt->bindparam(":nota_itens_ncm", $resposta_busca['ncm_codigo']);

        $stmt->execute();

        $auth_user->redirect("index.php?id=" . $id_nota_id);
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//PESQUISA DOS PRODUTOS NA NOTA
if (isset($_POST['btn-pesquisar2'])) {
    //$funcionario_id = strip_tags($_POST['funcionario_id']);
    $pesquisa = strtoupper($_POST['produto_pesquisa']);
    $pesquisa2 = strtoupper($_POST['produto_pesquisa']);
    try {

        if (isset($pesquisa) && !empty($pesquisa2)) {
            $stm = $auth_user->runQuery("SELECT * FROM  produto AS p
LEFT JOIN  estoque  AS e  ON (p.produto_id = e.estoque_id_produto)"
                    . " WHERE produto_nome like :nome OR "
                    . "produto_id like :id");
            $stm->bindValue(':nome', '%' . $pesquisa2 . '%', PDO::PARAM_STR);
            $stm->bindValue(':id', '%' . $pesquisa . '%', PDO::PARAM_STR);
            $stm->execute();
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
//CADASTRO DO TRANSPORTADOR DA NFE 
if (isset($_POST['btn-cadastro_nfe_outras_informacoes'])) {
    $id_nota_id = $_POST['id_nota_id'];
    $id_transportador = $_POST['id_transportador'];

    if ($id_transportador == '') {
        //CADASTRA NADA SE FOR SELECIONADO NADA
        $result = $auth_user->runQuery('UPDATE nota SET '
                . 'nota_id_transportador = :id_transportador,'
                . 'nota_nome_transportador = :nota_nome_transportador,'
                . 'nota_cnpjcpf_transportador = :nota_cnpjcpf_transportador,'
                . 'nota_inscricao_transportador = :nota_inscricao_transportador,'
                . 'nota_endereco_transportador = :nota_endereco_transportador,'
                . 'nota_municipio_transportador =:nota_municipio_transportador,'
                . 'nota_uf_transportador = :nota_uf_transportador '
                . ' WHERE nota_id = :id_nota_id');
        $result->execute(array(
            ':id_nota_id' => $id_nota_id,
            ':id_transportador' => '',
            ':nota_nome_transportador' => '',
            ':nota_cnpjcpf_transportador' => '',
            ':nota_inscricao_transportador' => '',
            ':nota_endereco_transportador' => '',
            ':nota_municipio_transportador' => '',
            ':nota_uf_transportador' => ''
        ));
    } else {
        //BUSCA DADOS DA TRANSPORTADOR SE TIVER ALGO CADASTRADO.

        $busca_transporte = $auth_user->runQuery("SELECT * FROM transportador "
                . "WHERE transportador_id = {$id_transportador}");
        $busca_transporte->execute();
        $respo_tras = $busca_transporte->fetch(PDO::FETCH_ASSOC);

        try {
            $result = $auth_user->runQuery('UPDATE nota SET '
                    . 'nota_id_transportador = :id_transportador,'
                    . 'nota_nome_transportador = :nota_nome_transportador,'
                    . 'nota_cnpjcpf_transportador = :nota_cnpjcpf_transportador,'
                    . 'nota_inscricao_transportador = :nota_inscricao_transportador,'
                    . 'nota_endereco_transportador = :nota_endereco_transportador,'
                    . 'nota_municipio_transportador =:nota_municipio_transportador,'
                    . 'nota_uf_transportador = :nota_uf_transportador '
                    . ' WHERE nota_id = :id_nota_id');
            $result->execute(array(
                ':id_nota_id' => $id_nota_id,
                ':id_transportador' => $id_transportador,
                ':nota_nome_transportador' => $respo_tras['transportador_nome'],
                ':nota_cnpjcpf_transportador' => $respo_tras['transportador_cnpj'],
                ':nota_inscricao_transportador' => $respo_tras['transportador_ie'],
                ':nota_endereco_transportador' => $respo_tras['transportador_logradouro'] . ", " . $respo_tras['transportador_numero'],
                ':nota_municipio_transportador' => $respo_tras['transportador_municipio'],
                ':nota_uf_transportador' => $respo_tras['transportador_uf']
            ));
            $auth_user->redirect("index.php?id=" . $id_nota_id);
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
//CADASTRO DE OUTRAS INFORMAÇÕES NA NFE
if (isset($_POST['btn-cadastro_dadonfe'])) {
    $id_nota_id = $_POST['id_pedido'];
    $nota_volume_peso_liquido = str_replace(",", ".", strip_tags($_POST['pedido_peso_liquido']));
    $nota_volume_peso_liquido = number_format($nota_volume_peso_liquido, 3, '.', '');
    $nota_volume_peso_bruto = str_replace(",", ".", strip_tags($_POST['pedido_peso_bruto']));
    $nota_volume_peso_bruto = number_format($nota_volume_peso_bruto, 3, '.', '');
    $nota_volume_quantidade = $_POST['pedido_quantidade'];
    $nota_volume_especie = $_POST['pedido_especie'];
    $nota_volume_marca = $_POST['pedido_marca'];

//    
    $pedido_inf_nfe = $_POST['pedido_inf_nfe'];
    $pedido_inf_comp = $_POST['pedido_inf_comp'];
    $pedido_referencia = $_POST['pedido_referencia'];

    try {

        $stmt_cadastro_info = $auth_user->runQuery("INSERT INTO nota_volume
            (
            id_nota,
            nota_volume_peso_liquido,
            nota_volume_peso_bruto,
            nota_volume_qtd,
            nota_volume_especie,
            nota_volume_marca
            )
            VALUES(
            :id_nota_id,
            :nota_volume_peso_liquido,
            :nota_volume_peso_bruto,
            :nota_volume_qtd,
            :nota_volume_especie,
            :nota_volume_marca 
            )");


        $stmt_cadastro_info->bindparam(":id_nota_id", $id_nota_id);
        $stmt_cadastro_info->bindparam(":nota_volume_peso_liquido", $nota_volume_peso_liquido);
        $stmt_cadastro_info->bindparam(":nota_volume_peso_bruto", $nota_volume_peso_bruto);
        $stmt_cadastro_info->bindparam(":nota_volume_qtd", $nota_volume_quantidade);
        $stmt_cadastro_info->bindparam(":nota_volume_especie", $nota_volume_especie);
        $stmt_cadastro_info->bindparam(":nota_volume_marca", $nota_volume_marca);
        $stmt_cadastro_info->execute();






//        
//        $result = $auth_user->runQuery('UPDATE nota_volume SET '
//                . 'nota_volume_peso_liquido = :nota_volume_peso_liquido, '
//                . 'nota_volume_peso_bruto = :nota_volume_peso_bruto, '
//                . 'nota_volume_qtd = :nota_volume_qtd, '
//                . 'nota_volume_especie = :nota_volume_especie, '
//                . 'nota_volume_marca = :nota_volume_marca '
//                . ' WHERE id_nota = :id_nota_id');
//        $result->execute(array(
//            ':id_nota_id' => $id_nota_id,
//            ':nota_volume_peso_liquido' => $nota_volume_peso_liquido,
//            ':nota_volume_peso_bruto' => $nota_volume_peso_bruto,
//            ':nota_volume_qtd' => $nota_volume_quantidade,
//            ':nota_volume_especie' => $nota_volume_especie,
//            ':nota_volume_marca' => $nota_volume_marca
//        ));
        $auth_user->redirect("index.php?id=" . $id_nota_id);
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//CADASTRA UMA NOVA REFERENCIA NA NFE
if (isset($_POST['btn-cadastra_ref_nfe'])) {

    date_default_timezone_set('America/Sao_Paulo');

    $id_nota = strtoupper($_POST['id_nota']);
    $nota_referencia_chave = $_POST['nota_referencia_chave'];
    $nota_referencia_cod_uf = $_POST['nota_referencia_cod_uf'];
    //$nota_referencia_data = $_POST['nota_referencia_data'];
    //Pegue a data no formato dd/mm/yyyy
    $data_old = $_POST['nota_referencia_data'];
//Exploda a data para entrar no formato aceito pelo DB.
    $dataP = explode('/', $data_old);
    $nota_referencia_data = $dataP[2] . '-' . $dataP[1] . '-' . $dataP[0];



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
?>