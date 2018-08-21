<?php

//BUSCA ERROS NA NFE.
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//BUSCA A BIBLIOTECA DA NFE
require_once '../bootstrap.php';
//BUSCA BILIOTECAS LOCAIS.
require_once("../class/session.php");
require_once '../class/conexao.class.php';
require_once("../class/class.user.php");

//require './vendor/autoload.php';


$auth_user = new USER();


//VERIFICA A SESSAO DA PAGINA 
$user_id = $_SESSION['user_session'];
$stmt = $auth_user->runQuery("SELECT * FROM funcionarios WHERE funcionario_id=:user_id");
$stmt->execute(array(":user_id" => $user_id));
$userRow = $stmt->fetch(PDO::FETCH_ASSOC);


//determina o numero de registros que serão mostrados na tela
$maximo = 8;
//pega o valor da pagina atual
$pagina = isset($_GET['pagina']) ? ($_GET['pagina']) : '1';

//subtraimos 1, porque os registros sempre começam do 0 (zero), como num array
$inicio = $pagina - 1;
//multiplicamos a quantidade de registros da pagina pelo valor da pagina atual 
$inicio = $maximo * $inicio;
//fazemos um select na tabela que iremos utilizar para saber quantos registros ela possui
$strCount = $auth_user->runQuery("SELECT COUNT(*) AS 'total_entrada_nota' FROM entrada_nota");
$strCount->execute();
//iniciamos uma var que será usada para armazenar a qtde de registros da tabela  
$total = 10;
if (count($strCount)) {
    foreach ($strCount as $row) {
        //armazeno o total de registros da tabela para fazer a paginação
        $total = $row["total_entrada_nota"];
    }
}

//BUSCA DADOS DO BANCO DE DADOS
$stmt_dados_busca = $auth_user->runQuery("SELECT * FROM entrada_nota WHERE entrada_nota_tpEvento = 0 AND entrada_nota_cSitNFe = 1 ORDER BY entrada_nota_id DESC LIMIT $inicio,$maximo");
$stmt_dados_busca->execute();

use NFePHP\NFe\ToolsNFe;
//use DownloadNFeSefaz\DownloadNFeSefaz;

$nfe = new ToolsNFe('../config/config.json');
$nfe->setModelo('55');
//VINCULACAO DE DADOS DO SISTEMA
if (isset($_POST['btn-vincular-dados'])) {

    $chave = $_POST['chave'];
    $status = 3;
    try {
        //ATUALIZAR STATUS DA ENTRADA
        $atualizar = $auth_user->runQuery("UPDATE entrada SET
        entrada_status = :entrada_status
        WHERE entrada_chave = :entrada_chave
        ");
        $atualizar->execute(array(
            ':entrada_status' => $status,
            ':entrada_chave' => $chave
        ));
       //ATUALIZAR O ESTOQUE DO PRODUTO NA TABELA ESTOQUE ENTRADA
        $sql = "SELECT id_produto,"
                . "entrada_produto_qCom,"
                . " entrada_produto_vUnCom "
                . " FROM entrada_produto WHERE entrada_produto_chave =".$chave;
        
        $atualizar_estoque_entrada = $auth_user->runQuery("INSERT INTO estoque_entrada
                (
                estoque_entrada_id_produto,
                estoque_entrada_quantidade,
                estoque_entrada_valor_unitario
                )
                $sql");
                $atualizar_estoque_entrada->execute();

        //  $auth_user->redirect("entrada_vinculo.php?chave=".$entrada_produto_chave);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
//VINCULA PRODUTO DA NFE COM PRODUTOS INTERNO
if (isset($_POST["btn-vincular-produto"])) {
    $id_produto = $_POST['id_produto'];
    $entrada_produto_id = $_POST['entrada_produto_id'];
    $id_fornecedor = $_POST['id_fornecedor'];
    $entrada_produto_cprod = $_POST['entrada_produto_cprod'];
    $entrada_produto_ean = $_POST['entrada_produto_ean'];
    $entrada_produto_xprod = $_POST['entrada_produto_xprod'];
    $entrada_produto_ucom = $_POST['entrada_produto_ucom'];

    $busca_produto = $auth_user->runQuery("SELECT * FROM produto WHERE produto_nome = :produto_nome");
    $busca_produto->execute(array(":produto_nome" => $id_produto));
    $resul_busca_prod = $busca_produto->fetch(PDO::FETCH_ASSOC);

    try {

        $atualiza_entrada_produto = $auth_user->runQuery("UPDATE entrada_produto SET
        id_produto = :id_produto,
        produto_nome = :produto_nome
        WHERE entrada_produto_id = :entrada_produto_id
        ");
        $atualiza_entrada_produto->execute(array(
            ':id_produto' => $resul_busca_prod['produto_id'],
            ':produto_nome' => $id_produto,
            ':entrada_produto_id' => $entrada_produto_id
        ));
        //INSERE NA TABELA DE PRODUTO FORNECEDOR 

        $insere_procedure = $auth_user->runQuery("CALL SP_AtualizaProdFor(?,?,?,?,?,?)");
        $insere_procedure->bindParam(1, $id_fornecedor, PDO::PARAM_STR, 4000);
        $insere_procedure->bindParam(2, $entrada_produto_cprod, PDO::PARAM_STR, 4000);
        $insere_procedure->bindParam(3, $resul_busca_prod['produto_id'], PDO::PARAM_STR, 4000);
        $insere_procedure->bindParam(4, $entrada_produto_ean, PDO::PARAM_STR, 4000);
        $insere_procedure->bindParam(5, $entrada_produto_ucom, PDO::PARAM_STR, 4000);
        $insere_procedure->bindParam(6, $entrada_produto_xprod, PDO::PARAM_STR, 4000);

// call the stored procedure
        $insere_procedure->execute();

        // print "procedure returned $return_value\n";
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
//BUSCA DINAMICA DO PRODUTO NA TABELA DE PRODUTOS
if (isset($_POST["query"])) {
    $output = '';
    $query = $auth_user->runQuery("SELECT * FROM produto WHERE produto_nome LIKE '%" . strtoupper($_POST["query"]) . "%' or "
            . "produto_ean LIKE '%" . $_POST["query"] . "%'");
    //$query->execute();
    $output = '<ul class="list-unstyled">';
    if ($query->execute() > 0) {
        for ($i = 0; $row = $query->fetch(); $i++) {
            $output .= '<li>' . $row["produto_nome"] . '</li>';
        }
    } else {
        $output .= '<li>Produto Não Encontrado</li>';
    }
    $output .= '</ul>';
    echo $output;

    unset($query);
}
//PARAMETROS DE VINCULAÇÃO DA NFE.
if (isset($_POST['btn-vincular'])) {
    //print_r($_POST['entrada_id']);

    $auth_user->redirect("entrada_vinculo.php?chave=" . $_POST['entrada_chave']);
}
//PESQUISA DOS FORNECEDORES E NF-E
if(isset($_POST['btn-pesquisar'])){
    
    $nome_fornecedor_pesquisa = $_POST['nome_fornecedor_pesquisa'];
    
     try {

        if (isset($nome_fornecedor_pesquisa)) {
            $stmt_dados_busca = $auth_user->runQuery("SELECT * FROM entrada_nota 
                WHERE entrada_nota_tpEvento = 0 AND
                entrada_nota_cSitNFe = 1 AND
                entrada_nota_xNome like :nome_fornecedor ORDER BY entrada_nota_id DESC");
            $stmt_dados_busca->bindValue(':nome_fornecedor', '%' . $nome_fornecedor_pesquisa . '%', PDO::PARAM_STR);
            $stmt_dados_busca->execute();
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    
    
//    
//    $stmt_dados_busca = $auth_user->runQuery("SELECT * FROM entrada_nota WHERE entrada_nota_tpEvento = 0 AND entrada_nota_cSitNFe = 1 ORDER BY entrada_nota_id DESC");
//$stmt_dados_busca->execute();
}



//FAZ O DOWNLOALD DO XML DA SEFAZ COM O CERTIFICADO
if (isset($_POST['btn-downloald'])) {
    $captcha_texto = $_POST['captcha_nfe'];
    $entrada_nota_id = $_POST['entrada_nota_id'];
    $downloald_chave = $_POST['downloald_chave'];
    
    //$auth_user->redirect("entrada_captcha.php?chave={$downloald_chave}");
    
    $auth_user->redirect("../down/captcha.php?chave={$downloald_chave}");


   // $auth_user->redirect("entrada_config_downloald.php?chave={$downloald_chave}&captcha={$captcha_texto}&status=1");
}
//BUSCA DADOS DA SEFAZ PARA A IMPORTAÇÃO DE DADOS
if (isset($_POST['btn-buscar'])) {

    $busca_NSU = $auth_user->runQuery("SELECT * FROM empresa");
    $busca_NSU->execute();
    $Nsu = $busca_NSU->fetch(PDO::FETCH_ASSOC);

    $ultNSU = $Nsu['empresa_numero_NSU']; // se estiver como zero irá retornar os dados dos ultimos 15 dias até o limite de 50 registros
    $numNSU = 0; // se estiver como zero irá usar o ultNSU
    $tpAmb = '1'; // esses dados somente existirão em ambiente de produção pois em ambiente de testes
    $cnpj = ''; // deixando vazio irá pegar o CNPJ default do config
    $aResposta = array();
    $xml = $nfe->sefazDistDFe('AN', $tpAmb, $cnpj, $ultNSU, $numNSU, $aResposta);

    if ($aResposta["cStat"] == 138) {

        for ($i = 0; $i < 10; $i++) {
            $xml = simplexml_load_string($aResposta["aDoc"][$i]["doc"]);
            if ($xml) {
                $stmt_entrada_nota = $auth_user->runQuery("INSERT INTO entrada_nota
            ( 
            entrada_nota_bStat,
            entrada_nota_versao,
            entrada_nota_cStat,
            entrada_nota_xMotivo,
            entrada_nota_dhResp,
            entrada_nota_ultNSU,
            entrada_nota_maxNSU,
            entrada_nota_NSU,
            entrada_nota_schema,
            entrada_nota_cOrgao,
            entrada_nota_CNPJ,
            entrada_nota_IE,
            entrada_nota_xNome,
            entrada_nota_chNFe,
            entrada_nota_dhEmi,
            entrada_nota_tpNF,
            entrada_nota_vNF,
            entrada_nota_digVal,
            entrada_nota_cSitNFe,
            entrada_nota_dhEvento,
            entrada_nota_tpEvento,
            entrada_nota_nSeqEvento,
            entrada_nota_xEvento,
            entrada_nota_dhRecbto,
            entrada_nota_nProt,
            entrada_nota_ch_NFe,
            entrada_nota_cUF,
            entrada_nota_cNF,
            entrada_nota_natOp,
            
            entrada_nota_indPag,
            entrada_nota_mod,
            entrada_nota_serie,
            entrada_nota_nNF,
            entrada_nota_dhSaiEnt,
            entrada_nota_idDest,
            entrada_nota_cMunFG,
            entrada_nota_tpImp,
            entrada_nota_tpEmis,
            entrada_nota_cDV,
            entrada_nota_tpAmb,
            entrada_nota_finNFe,
            entrada_nota_indFinal,
            entrada_nota_indPres,
            entrada_nota_CNPJ_emit,
            entrada_nota_CPF_emit,
            entrada_nota_xNome_emit,
            entrada_nota_xFant_emit,
            entrada_nota_xLgr_emit,
            entrada_nota_nro_emit,
            entrada_nota_xCpl_emit,
            entrada_nota_xBairro_emit,
            entrada_nota_cMun_emit,
            entrada_nota_xMun_emit,
            entrada_nota_UF_emit,
            entrada_nota_CEP_emit,
            entrada_nota_cPais_emit,
            entrada_nota_xPais_emit,
            entrada_nota_fone_emit,
            entrada_nota_IE_emit,
            entrada_nota_IEST_emit,
            entrada_nota_CRT_emit
            
            )
            VALUES( 
            :entrada_nota_bStat,
            :entrada_nota_versao,
            :entrada_nota_cStat,
            :entrada_nota_xMotivo,
            :entrada_nota_dhResp,
            :entrada_nota_ultNSU,
            :entrada_nota_maxNSU,
            :entrada_nota_NSU,
            :entrada_nota_schema,
            :entrada_nota_cOrgao,
            :entrada_nota_CNPJ,
            :entrada_nota_IE,
            :entrada_nota_xNome,
            :entrada_nota_chNFe,
            :entrada_nota_dhEmi,
            :entrada_nota_tpNF,
            :entrada_nota_vNF,
            :entrada_nota_digVal,
            :entrada_nota_cSitNFe,
            :entrada_nota_dhEvento,
            :entrada_nota_tpEvento,
            :entrada_nota_nSeqEvento,
            :entrada_nota_xEvento,
            :entrada_nota_dhRecbto,
            :entrada_nota_nProt,
            :entrada_nota_ch_NFe,
            :entrada_nota_cUF,
            :entrada_nota_cNF,
            :entrada_nota_natOp,
            
            :entrada_nota_indPag,
            :entrada_nota_mod,
            :entrada_nota_serie,
            :entrada_nota_nNF,
            :entrada_nota_dhSaiEnt,
            :entrada_nota_idDest,
            :entrada_nota_cMunFG,
            :entrada_nota_tpImp,
            :entrada_nota_tpEmis,
            :entrada_nota_cDV,
            :entrada_nota_tpAmb,
            :entrada_nota_finNFe,
            :entrada_nota_indFinal,
            :entrada_nota_indPres,
            :entrada_nota_CNPJ_emit,
            :entrada_nota_CPF_emit,
            :entrada_nota_xNome_emit,
            :entrada_nota_xFant_emit,
            :entrada_nota_xLgr_emit,
            :entrada_nota_nro_emit,
            :entrada_nota_xCpl_emit,
            :entrada_nota_xBairro_emit,
            :entrada_nota_cMun_emit,
            :entrada_nota_xMun_emit,
            :entrada_nota_UF_emit,
            :entrada_nota_CEP_emit,
            :entrada_nota_cPais_emit,
            :entrada_nota_xPais_emit,
            :entrada_nota_fone_emit,
            :entrada_nota_IE_emit,
            :entrada_nota_IEST_emit,
            :entrada_nota_CRT_emit
            )");

                //$stmt_entrada_nota->bindparam(":id_nota", $nota_id);
                $stmt_entrada_nota->bindparam(":entrada_nota_bStat", $aResposta['bStat']);
                $stmt_entrada_nota->bindparam(":entrada_nota_versao", $aResposta['versao']);
                $stmt_entrada_nota->bindparam(":entrada_nota_cStat", $aResposta['cStat']);
                $stmt_entrada_nota->bindparam(":entrada_nota_xMotivo", $aResposta['xMotivo']);
                $stmt_entrada_nota->bindparam(":entrada_nota_dhResp", $aResposta['dhResp']);
                $stmt_entrada_nota->bindparam(":entrada_nota_ultNSU", $aResposta['ultNSU']);
                $stmt_entrada_nota->bindparam(":entrada_nota_maxNSU", $aResposta['maxNSU']);
                $stmt_entrada_nota->bindparam(":entrada_nota_NSU", $aResposta["aDoc"][$i]["NSU"]);
                $stmt_entrada_nota->bindparam(":entrada_nota_schema", $aResposta["aDoc"][$i]["schema"]);
                $stmt_entrada_nota->bindparam(":entrada_nota_cOrgao", $xml->cOrgao);
                $stmt_entrada_nota->bindparam(":entrada_nota_CNPJ", $xml->CNPJ);
                $stmt_entrada_nota->bindparam(":entrada_nota_IE", $xml->IE);
                $stmt_entrada_nota->bindparam(":entrada_nota_xNome", $xml->xNome);
                $stmt_entrada_nota->bindparam(":entrada_nota_chNFe", $xml->chNFe);
                $stmt_entrada_nota->bindparam(":entrada_nota_dhEmi", $xml->dhEmi);
                $stmt_entrada_nota->bindparam(":entrada_nota_tpNF", $xml->tpNF);
                $stmt_entrada_nota->bindparam(":entrada_nota_vNF", $xml->vNF);
                $stmt_entrada_nota->bindparam(":entrada_nota_digVal", $xml->digVal);
                $stmt_entrada_nota->bindparam(":entrada_nota_cSitNFe", $xml->cSitNFe);
                $stmt_entrada_nota->bindparam(":entrada_nota_dhEvento", $xml->dhEvento);
                $stmt_entrada_nota->bindparam(":entrada_nota_tpEvento", $xml->tpEvento);
                $stmt_entrada_nota->bindparam(":entrada_nota_nSeqEvento", $xml->nSeqEvento);
                $stmt_entrada_nota->bindparam(":entrada_nota_xEvento", $xml->xEvento);
                $stmt_entrada_nota->bindparam(":entrada_nota_dhRecbto", $xml->dhRecbto);
                $stmt_entrada_nota->bindparam(":entrada_nota_nProt", $xml->nProt);

                if ($xml->NFe) {
                    $teste = $xml->NFe->infNFe[0]->attributes();
                    $chave_nf = $teste["Id"];
                    $chave_nfe = substr($chave_nf, 3, 44);
                } else {
                    $chave_nfe = 0;
                }


                $stmt_entrada_nota->bindparam(":entrada_nota_ch_NFe", $chave_nfe);
                $stmt_entrada_nota->bindparam(":entrada_nota_cUF", $xml->NFe->infNFe->ide->cUF);
                $stmt_entrada_nota->bindparam(":entrada_nota_cNF", $xml->NFe->infNFe->ide->cNF);
                $stmt_entrada_nota->bindparam(":entrada_nota_natOp", $xml->NFe->infNFe->ide->natOp);
                $stmt_entrada_nota->bindparam(":entrada_nota_indPag", $xml->NFe->infNFe->ide->indPag);
                $stmt_entrada_nota->bindparam(":entrada_nota_mod", $xml->NFe->infNFe->ide->mod);
                $stmt_entrada_nota->bindparam(":entrada_nota_serie", $xml->NFe->infNFe->ide->serie);
                $stmt_entrada_nota->bindparam(":entrada_nota_nNF", $xml->NFe->infNFe->ide->nNF);
                $stmt_entrada_nota->bindparam(":entrada_nota_dhSaiEnt", $xml->NFe->infNFe->ide->dhSaiEnt);
                $stmt_entrada_nota->bindparam(":entrada_nota_idDest", $xml->NFe->infNFe->ide->idDest);
                $stmt_entrada_nota->bindparam(":entrada_nota_cMunFG", $xml->NFe->infNFe->ide->cMunFG);
                $stmt_entrada_nota->bindparam(":entrada_nota_tpImp", $xml->NFe->infNFe->ide->tpImp);
                $stmt_entrada_nota->bindparam(":entrada_nota_tpEmis", $xml->NFe->infNFe->ide->tpEmis);
                $stmt_entrada_nota->bindparam(":entrada_nota_cDV", $xml->NFe->infNFe->ide->cDV);
                $stmt_entrada_nota->bindparam(":entrada_nota_tpAmb", $xml->NFe->infNFe->ide->tpAmb);
                $stmt_entrada_nota->bindparam(":entrada_nota_finNFe", $xml->NFe->infNFe->ide->finNFe);
                $stmt_entrada_nota->bindparam(":entrada_nota_indFinal", $xml->NFe->infNFe->ide->indFinal);
                $stmt_entrada_nota->bindparam(":entrada_nota_indPres", $xml->NFe->infNFe->ide->indPres);
                $stmt_entrada_nota->bindparam(":entrada_nota_CNPJ_emit", $xml->NFe->infNFe->emit->CNPJ);
                $stmt_entrada_nota->bindparam(":entrada_nota_CPF_emit", $xml->NFe->infNFe->emit->CPF);
                $stmt_entrada_nota->bindparam(":entrada_nota_xNome_emit", $xml->NFe->infNFe->emit->xNome);
                $stmt_entrada_nota->bindparam(":entrada_nota_xFant_emit", $xml->NFe->infNFe->emit->xFant);
                $stmt_entrada_nota->bindparam(":entrada_nota_xLgr_emit", $xml->NFe->infNFe->emit->enderEmit->xLgr);
                $stmt_entrada_nota->bindparam(":entrada_nota_nro_emit", $xml->NFe->infNFe->emit->enderEmit->nro);
                $stmt_entrada_nota->bindparam(":entrada_nota_xCpl_emit", $xml->NFe->infNFe->emit->enderEmit->xCpl);
                $stmt_entrada_nota->bindparam(":entrada_nota_xBairro_emit", $xml->NFe->infNFe->emit->enderEmit->xBairro);
                $stmt_entrada_nota->bindparam(":entrada_nota_cMun_emit", $xml->NFe->infNFe->emit->enderEmit->cMun);
                $stmt_entrada_nota->bindparam(":entrada_nota_xMun_emit", $xml->NFe->infNFe->emit->enderEmit->xMun);
                $stmt_entrada_nota->bindparam(":entrada_nota_UF_emit", $xml->NFe->infNFe->emit->enderEmit->UF);
                $stmt_entrada_nota->bindparam(":entrada_nota_CEP_emit", $xml->NFe->infNFe->emit->enderEmit->CEP);
                $stmt_entrada_nota->bindparam(":entrada_nota_cPais_emit", $xml->NFe->infNFe->emit->enderEmit->cPais);
                $stmt_entrada_nota->bindparam(":entrada_nota_xPais_emit", $xml->NFe->infNFe->emit->enderEmit->xPais);
                $stmt_entrada_nota->bindparam(":entrada_nota_fone_emit", $xml->NFe->infNFe->emit->enderEmit->fone);
                $stmt_entrada_nota->bindparam(":entrada_nota_IE_emit", $xml->NFe->infNFe->emit->IE);
                $stmt_entrada_nota->bindparam(":entrada_nota_IEST_emit", $xml->NFe->infNFe->emit->IEST);
                $stmt_entrada_nota->bindparam(":entrada_nota_CRT_emit", $xml->NFe->infNFe->emit->CRT);

                $nu_nsu = $aResposta["aDoc"][$i]["NSU"];

                $stmt_entrada_nota->execute();
            }
        }



        $update_empresa_nsu = $auth_user->runQuery('UPDATE empresa SET '
                . 'empresa_numero_NSU  = :empresa_numero_NSU '
                . 'WHERE empresa_id = 1');


        $update_empresa_nsu->execute(array(
            ':empresa_numero_NSU' => $nu_nsu
        ));


        $auth_user->redirect("entrada_status.php");
    }
}


// FAZ A IMPORTACAO DE DADOS DO FORNECEDOR DO index VERIFICAR PARA EXCLUIR DEPOIS
if (isset($_POST['btn-importar-fornecedor'])) {
    $entrada_nota_id = $_POST['entrada_nota_id'];

    $busca_entra_for = $auth_user->runQuery("SELECT * FROM entrada_nota WHERE entrada_nota_id = :entrada_nota_id");
    $busca_entra_for->execute(array(":entrada_nota_id" => $entrada_nota_id));
    $fornecedor = $busca_entra_for->fetch(PDO::FETCH_ASSOC);

    $busca_for = $auth_user->runQuery("SELECT * FROM fornecedor WHERE fornecedor_cnpj = :fornecedor_cnpj");
    $busca_for->execute(array(":fornecedor_cnpj" => $fornecedor['entrada_nota_CNPJ_emit']));
    $encontrou_forne = $busca_for->fetch(PDO::FETCH_ASSOC);

    if (!$encontrou_forne) {

//CADASTRO DE UM NOVO CNPJ/CPF DE FORNECEDOR NÃO CADASTRADO.
        $fornecedor_tipo_cadastro = "Imp. NF-e";
        $fornecedor_status = 1;
        $fornecedor_nome = strtoupper($fornecedor['entrada_nota_xNome_emit']);
        $fornecedor_fantasia = strtoupper($fornecedor['entrada_nota_xFant_emit']);
        $fornecedor_cnpj = $fornecedor['entrada_nota_CNPJ_emit'];
        $fornecedor_cpf = $fornecedor['entrada_nota_CPF_emit'];
        $fornecedor_logradouro = strtoupper($fornecedor['entrada_nota_xLgr_emit']);
        $fornecedor_numero = $fornecedor['entrada_nota_nro_emit'];
        $fornecedor_complemento = strtoupper($fornecedor['entrada_nota_xCpl_emit']);
        $fornecedor_bairro = strtoupper($fornecedor['entrada_nota_xBairro_emit']);
        $fornecedor_cod_municipio = $fornecedor['entrada_nota_cMun_emit'];
        $fornecedor_nome_municipio = strtoupper($fornecedor['entrada_nota_xMun_emit']);
        $fornecedor_uf = strtoupper($fornecedor['entrada_nota_UF_emit']);
        $fornecedor_cep = $fornecedor['entrada_nota_CEP_emit'];
        $fornecedor_cod_pais = $fornecedor['entrada_nota_cPais_emit'];
        $fornecedor_nome_pais = strtoupper($fornecedor['entrada_nota_xPais_emit']);
        $fornecedor_telefone = $fornecedor['entrada_nota_fone_emit'];
        $fornecedor_ie = $fornecedor['entrada_nota_IE_emit'];
        $fornecedor_iest = $fornecedor['entrada_nota_IEST_emit'];
        $fornecedor_crt = $fornecedor['entrada_nota_CRT_emit'];

        try {
            $stmt_insere_fornecedor = $auth_user->runQuery("INSERT INTO fornecedor
            (
            fornecedor_status,
            fornecedor_tipo_cadastro,
            fornecedor_nome,
            fornecedor_fantasia,
            fornecedor_cnpj,
            fornecedor_cpf,
            fornecedor_logradouro,
            fornecedor_numero,
            fornecedor_complemento,
            fornecedor_bairro,
            fornecedor_cod_municipio,
            fornecedor_nome_municipio,
            fornecedor_uf,
            fornecedor_cep,
            fornecedor_cod_pais,
            fornecedor_nome_pais,
            fornecedor_telefone,
            fornecedor_ie,
            fornecedor_iest,
            fornecedor_crt
            )
            VALUES(
            :fornecedor_status,
            :fornecedor_tipo_cadastro,
            :fornecedor_nome,
            :fornecedor_fantasia,
            :fornecedor_cnpj,
            :fornecedor_cpf,
            :fornecedor_logradouro,
            :fornecedor_numero,
            :fornecedor_complemento,
            :fornecedor_bairro,
            :fornecedor_cod_municipio,
            :fornecedor_nome_municipio,
            :fornecedor_uf,
            :fornecedor_cep,
            :fornecedor_cod_pais,
            :fornecedor_nome_pais,
            :fornecedor_telefone,
            :fornecedor_ie,
            :fornecedor_iest,
            :fornecedor_crt)");

            $stmt_insere_fornecedor->bindparam(":fornecedor_status", $fornecedor_status);
            $stmt_insere_fornecedor->bindparam(":fornecedor_tipo_cadastro", $fornecedor_tipo_cadastro);
            $stmt_insere_fornecedor->bindparam(":fornecedor_nome", $fornecedor_nome);
            $stmt_insere_fornecedor->bindparam(":fornecedor_fantasia", $fornecedor_fantasia);
            $stmt_insere_fornecedor->bindparam(":fornecedor_cnpj", $fornecedor_cnpj);
            $stmt_insere_fornecedor->bindparam(":fornecedor_cpf", $fornecedor_cpf);
            $stmt_insere_fornecedor->bindparam(":fornecedor_logradouro", $fornecedor_logradouro);
            $stmt_insere_fornecedor->bindparam(":fornecedor_numero", $fornecedor_numero);
            $stmt_insere_fornecedor->bindparam(":fornecedor_complemento", $fornecedor_complemento);
            $stmt_insere_fornecedor->bindparam(":fornecedor_bairro", $fornecedor_bairro);
            $stmt_insere_fornecedor->bindparam(":fornecedor_cod_municipio", $fornecedor_cod_municipio);
            $stmt_insere_fornecedor->bindparam(":fornecedor_nome_municipio", $fornecedor_nome_municipio);
            $stmt_insere_fornecedor->bindparam(":fornecedor_uf", $fornecedor_uf);
            $stmt_insere_fornecedor->bindparam(":fornecedor_cep", $fornecedor_cep);
            $stmt_insere_fornecedor->bindparam(":fornecedor_cod_pais", $fornecedor_cod_pais);
            $stmt_insere_fornecedor->bindparam(":fornecedor_nome_pais", $fornecedor_nome_pais);
            $stmt_insere_fornecedor->bindparam(":fornecedor_telefone", $fornecedor_telefone);
            $stmt_insere_fornecedor->bindparam(":fornecedor_ie", $fornecedor_ie);
            $stmt_insere_fornecedor->bindparam(":fornecedor_iest", $fornecedor_iest);
            $stmt_insere_fornecedor->bindparam(":fornecedor_crt", $fornecedor_crt);

            $stmt_insere_fornecedor->execute();

            $auth_user->redirect("entrada_status.php");
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
?>