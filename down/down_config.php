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


//IMPORTA FORNECEDOR DO XML BAIXANDO DO SISTEMA
if (isset($_POST['btn-importe-fornecedor'])) {

    $fornecedor_tipo_cadastro = "Imp. NF-e";
    $fornecedor_status = 1;
    $fornecedor_cpf = $_POST['fornecedor_cpf'];
    $fornecedor_cnpj = $_POST['fornecedor_cnpj'];
    $fornecedor_nome = strtoupper($_POST['fornecedor_nome']);
    $fornecedor_fantasia = strtoupper($_POST['fornecedor_fantasia']);

    $fornecedor_logradouro = strtoupper($_POST['fornecedor_logradouro']);
    $fornecedor_numero = $_POST['fornecedor_numero'];
    $fornecedor_complemento = strtoupper($_POST['fornecedor_complemento']);
    $fornecedor_bairro = strtoupper($_POST['fornecedor_bairro']);
    $fornecedor_cod_municipio = $_POST['fornecedor_cod_municipio'];
    $fornecedor_nome_municipio = strtoupper($_POST['fornecedor_nome_municipio']);
    $fornecedor_uf = strtoupper($_POST['fornecedor_uf']);
    $fornecedor_cep = $_POST['fornecedor_cep'];
    $fornecedor_cod_pais = $_POST['fornecedor_cod_pais'];
    $fornecedor_nome_pais = strtoupper($_POST['fornecedor_nome_pais']);
    $fornecedor_telefone = $_POST['fornecedor_fone'];
    $fornecedor_ie = $_POST['fornecedor_ie'];
    $fornecedor_iest = $_POST['fornecedor_iest'];
    $fornecedor_crt = $_POST['fornecedor_crt'];

    try {
        $stmt_insere_fornecedor_xml = $auth_user->runQuery("INSERT INTO fornecedor
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

        $stmt_insere_fornecedor_xml->bindparam(":fornecedor_status", $fornecedor_status);
        $stmt_insere_fornecedor_xml->bindparam(":fornecedor_tipo_cadastro", $fornecedor_tipo_cadastro);
        $stmt_insere_fornecedor_xml->bindparam(":fornecedor_nome", $fornecedor_nome);
        $stmt_insere_fornecedor_xml->bindparam(":fornecedor_fantasia", $fornecedor_fantasia);
        $stmt_insere_fornecedor_xml->bindparam(":fornecedor_cnpj", $fornecedor_cnpj);
        $stmt_insere_fornecedor_xml->bindparam(":fornecedor_cpf", $fornecedor_cpf);
        $stmt_insere_fornecedor_xml->bindparam(":fornecedor_logradouro", $fornecedor_logradouro);
        $stmt_insere_fornecedor_xml->bindparam(":fornecedor_numero", $fornecedor_numero);
        $stmt_insere_fornecedor_xml->bindparam(":fornecedor_complemento", $fornecedor_complemento);
        $stmt_insere_fornecedor_xml->bindparam(":fornecedor_bairro", $fornecedor_bairro);
        $stmt_insere_fornecedor_xml->bindparam(":fornecedor_cod_municipio", $fornecedor_cod_municipio);
        $stmt_insere_fornecedor_xml->bindparam(":fornecedor_nome_municipio", $fornecedor_nome_municipio);
        $stmt_insere_fornecedor_xml->bindparam(":fornecedor_uf", $fornecedor_uf);
        $stmt_insere_fornecedor_xml->bindparam(":fornecedor_cep", $fornecedor_cep);
        $stmt_insere_fornecedor_xml->bindparam(":fornecedor_cod_pais", $fornecedor_cod_pais);
        $stmt_insere_fornecedor_xml->bindparam(":fornecedor_nome_pais", $fornecedor_nome_pais);
        $stmt_insere_fornecedor_xml->bindparam(":fornecedor_telefone", $fornecedor_telefone);
        $stmt_insere_fornecedor_xml->bindparam(":fornecedor_ie", $fornecedor_ie);
        $stmt_insere_fornecedor_xml->bindparam(":fornecedor_iest", $fornecedor_iest);
        $stmt_insere_fornecedor_xml->bindparam(":fornecedor_crt", $fornecedor_crt);

        $stmt_insere_fornecedor_xml->execute();

 //$auth_user->redirect("download_xml1.php?status=2");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

//IMPORTA PRODUTOS DO XML BAIXANDO DO SISTEMA
if (isset($_POST['btn-importe-nfe'])) {


    //DADOS E INFORMAÇÕES DA NFE
    $status = 2;
    $chave = $_POST['chave'];
    $cUF = $_POST['cUF'];
    $cNF = $_POST['cNF'];
    $natOp = $_POST['natOp'];
    $indPag = $_POST['indPag'];
    $mod = $_POST['mod'];
    $serie = $_POST['serie'];
    $nNF = $_POST['nNF'];
    $dEmi = $_POST['dEmi'];
    $dSaiEnt = $_POST['dSaiEnt'];
    $tpNF = $_POST['tpNF'];
    $cMunFG = $_POST['cMunFG'];
    $tpImp = $_POST['tpImp'];
    $tpEmis = $_POST['tpEmis'];
    $cDV = $_POST['cDV'];
    $tpAmb = $_POST['tpAmb'];
    $finNFe = $_POST['finNFe'];
    $indFinal = $_POST['indFinal'];
    $indPres = $_POST['indPres'];
    $procEmi = $_POST['procEmi'];
    $verProc = $_POST['verProc'];
    // DADOS DO EMITENTE
    $entrada_cpf_emit = $_POST['fornecedor_cpf'];
    $entrada_cnpj_emit = $_POST['fornecedor_cnpj'];
    $entrada_xNome_emit = strtoupper($_POST['fornecedor_nome']);
    $entrada_xFant_emit = strtoupper($_POST['fornecedor_fantasia']);
    $entrada_xLgr_emit = strtoupper($_POST['fornecedor_logradouro']);
    $entrada_nro_emit = $_POST['fornecedor_numero'];
    $entrada_xCpl_emit = $_POST['fornecedor_complemento'];
    $entrada_xBairro_emit = strtoupper($_POST['fornecedor_bairro']);
    $entrada_cMun_emit = $_POST['fornecedor_cod_municipio'];
    $entrada_xMun_emit = strtoupper($_POST['fornecedor_nome_municipio']);
    $entrada_UF_emit = strtoupper($_POST['fornecedor_uf']);
    $entrada_CEP_emit = $_POST['fornecedor_cep'];
    $entrada_cPais_emit = $_POST['fornecedor_cod_pais'];
    $entrada_xPais_emit = strtoupper($_POST['fornecedor_nome_pais']);
    $entrada_fone_emit = $_POST['fornecedor_fone'];
    $entrada_ie_emit = $_POST['fornecedor_ie'];
    $entrada_iest_emit = $_POST['fornecedor_iest'];
    $entrada_crt_emit = $_POST['fornecedor_crt'];

    //DADOS DO DESTINATARIO

    $entrada_cnpj_dest = $_POST['dest_cnpj'];
    $entrada_cpf_dest = $_POST['dest_cpf'];
    $entrada_xNome_dest = $_POST['dest_xNome'];
    $entrada_xLgr_dest = $_POST['dest_xLgr'];
    $entrada_nro_dest = $_POST['dest_nro'];
    $entrada_xCpl_dest = $_POST['dest_xCpl'];
    $entrada_xBairro_dest = $_POST['dest_xBairro'];
    $entrada_cMun_dest = $_POST['dest_cMun'];
    $entrada_xMun_dest = $_POST['dest_xMun'];
    $entrada_UF_dest = $_POST['dest_UF'];
    $entrada_CEP_dest = $_POST['dest_CEP'];
    $entrada_cPais_dest = $_POST['dest_cPais'];
    $entrada_xPais_dest = $_POST['dest_xPais'];
    $entrada_fone_dest = $_POST['dest_fone'];
    $entrada_ie_dest = $_POST['dest_IE'];
    $entrada_email_dest = $_POST['dest_email'];

    //TOTAIS DA NFE

    $entrada_vBC = $_POST['vBC'];
    $entrada_vICMS = $_POST['vICMS'];
    $entrada_vICMSDeson = $_POST['vICMSDeson'];
    $entrada_vBCST = $_POST['vBCST'];
    $entrada_vST = $_POST['vST'];
    $entrada_vProd = $_POST['vProd'];
    $entrada_vNF = $_POST['vNF'];
    $entrada_vFrete = $_POST['vFrete'];
    $entrada_vSeg = $_POST['vSeg'];
    $entrada_vDesc = $_POST['vDesc'];
    $entrada_vIPI = $_POST['vIPI'];


    //CADASTRA O PRODUTO CASO NAO TIVER NO CADASTRO DO FORNECEDOR/ PRODUTO NOVO
    try {
        $stmt_insere_entrada = $auth_user->runQuery("INSERT INTO entrada
            (
            entrada_status,
            entrada_chave,
            entrada_cod_uf,
            entrada_cod_nf,
            entrada_natOp,
            entrada_indPag,
            entrada_modelo,
            entrada_serie,
            entrada_numero,
            entrada_dhEmi,
            entrada_dhSaiEnt,
            entrada_tpNF,
            entrada_cMunFG,
            entrada_tpImp,
            entrada_tpEmis,
            entrada_cDV,
            entrada_tpAmb,
            entrada_finNFe,
            entrada_indFinal,
            entrada_indPres,
            entrada_procEmi,
            entrada_verProc,
            
            entrada_cnpj_emit,
            entrada_cpf_emit,
            entrada_xNome_emit,
            entrada_xFant_emit,
            entrada_xLgr_emit,
            entrada_nro_emit,
            entrada_xCpl_emit,
            entrada_xBairro_emit,
            entrada_cMun_emit,
            entrada_xMun_emit,
            entrada_UF_emit,
            entrada_CEP_emit,
            entrada_cPais_emit,
            entrada_xPais_emit,
            entrada_fone_emit,
            entrada_ie_emit,
            entrada_iest_emit,
            entrada_crt_emit,
            
            entrada_cnpj_dest,
            entrada_cpf_dest,
            entrada_xNome_dest,
            entrada_xLgr_dest,
            entrada_nro_dest,
            entrada_xCpl_dest,
            entrada_xBairro_dest,
            entrada_cMun_dest,
            entrada_xMun_dest,
            
            entrada_UF_dest,
            entrada_CEP_dest,
            entrada_cPais_dest,
            entrada_xPais_dest,
            entrada_fone_dest,
            entrada_ie_dest,
            entrada_email_dest,
            
            entrada_vBC,
            entrada_vICMS,
            entrada_vICMSDeson,
            entrada_vBCST,
            entrada_vST,
            entrada_vProd,
            entrada_vNF,
            entrada_vFrete,
            entrada_vSeg,
            entrada_vDesc,
            entrada_vIPI

            )
            VALUES(
            :entrada_status,
            :entrada_chave,
            :entrada_cod_uf,
            :entrada_cod_nf,
            :entrada_natOp,
            :entrada_indPag,
            :entrada_modelo,
            :entrada_serie,
            :entrada_numero,
            :entrada_dhEmi,
            :entrada_dhSaiEnt,
            :entrada_tpNF,
            :entrada_cMunFG,
            :entrada_tpImp,
            :entrada_tpEmis,
            :entrada_cDV,
            :entrada_tpAmb,
            :entrada_finNFe,
            :entrada_indFinal,
            :entrada_indPres,
            :entrada_procEmi,
            :entrada_verProc,
            
            :entrada_cnpj_emit,
            :entrada_cpf_emit,
            :entrada_xNome_emit,
            :entrada_xFant_emit,
            :entrada_xLgr_emit,
            :entrada_nro_emit,
            :entrada_xCpl_emit,
            :entrada_xBairro_emit,
            :entrada_cMun_emit,
            :entrada_xMun_emit,
            :entrada_UF_emit,
            :entrada_CEP_emit,
            :entrada_cPais_emit,
            :entrada_xPais_emit,
            :entrada_fone_emit,
            :entrada_ie_emit,
            :entrada_iest_emit,
            :entrada_crt_emit,
            
            :entrada_cnpj_dest,
            :entrada_cpf_dest,
            :entrada_xNome_dest,
            :entrada_xLgr_dest,
            :entrada_nro_dest,
            :entrada_xCpl_dest,
            :entrada_xBairro_dest,
            :entrada_cMun_dest,
            :entrada_xMun_dest,
            :entrada_UF_dest,
            

            :entrada_CEP_dest,
            :entrada_cPais_dest,
            :entrada_xPais_dest,
            :entrada_fone_dest,
            :entrada_ie_dest,
            :entrada_email_dest,
            
            :entrada_vBC,
            :entrada_vICMS,
            :entrada_vICMSDeson,
            :entrada_vBCST,
            :entrada_vST,
            :entrada_vProd,
            :entrada_vNF,
            :entrada_vFrete,
            :entrada_vSeg,
            :entrada_vDesc,
            :entrada_vIPI
            
            )");

        $stmt_insere_entrada->bindparam(":entrada_status", $status);
        $stmt_insere_entrada->bindparam(":entrada_chave", $chave);
        $stmt_insere_entrada->bindparam(":entrada_cod_uf", $cUF);
        $stmt_insere_entrada->bindparam(":entrada_cod_nf", $cNF);
        $stmt_insere_entrada->bindparam(":entrada_natOp", $natOp);
        $stmt_insere_entrada->bindparam(":entrada_indPag", $indPag);
        $stmt_insere_entrada->bindparam(":entrada_modelo", $mod);
        $stmt_insere_entrada->bindparam(":entrada_serie", $serie);
        $stmt_insere_entrada->bindparam(":entrada_numero", $nNF);
        $stmt_insere_entrada->bindparam(":entrada_dhEmi", $dEmi);
        $stmt_insere_entrada->bindparam(":entrada_dhSaiEnt", $dSaiEnt);
        $stmt_insere_entrada->bindparam(":entrada_tpNF", $tpNF);
        $stmt_insere_entrada->bindparam(":entrada_cMunFG", $cMunFG);
        $stmt_insere_entrada->bindparam(":entrada_tpImp", $tpImp);
        $stmt_insere_entrada->bindparam(":entrada_tpEmis", $tpEmis);
        $stmt_insere_entrada->bindparam(":entrada_cDV", $cDV);
        $stmt_insere_entrada->bindparam(":entrada_tpAmb", $tpAmb);
        $stmt_insere_entrada->bindparam(":entrada_finNFe", $finNFe);
        $stmt_insere_entrada->bindparam(":entrada_indFinal", $indFinal);
        $stmt_insere_entrada->bindparam(":entrada_indPres", $indPres);
        $stmt_insere_entrada->bindparam(":entrada_procEmi", $procEmi);
        $stmt_insere_entrada->bindparam(":entrada_verProc", $verProc);

        $stmt_insere_entrada->bindparam(":entrada_cnpj_emit", $entrada_cnpj_emit);
        $stmt_insere_entrada->bindparam(":entrada_cpf_emit", $entrada_cpf_emit);
        $stmt_insere_entrada->bindparam(":entrada_xNome_emit", $entrada_xNome_emit);
        $stmt_insere_entrada->bindparam(":entrada_xFant_emit", $entrada_xFant_emit);
        $stmt_insere_entrada->bindparam(":entrada_xLgr_emit", $entrada_xLgr_emit);
        $stmt_insere_entrada->bindparam(":entrada_nro_emit", $entrada_nro_emit);
        $stmt_insere_entrada->bindparam(":entrada_xCpl_emit", $entrada_xCpl_emit);
        $stmt_insere_entrada->bindparam(":entrada_xBairro_emit", $entrada_xBairro_emit);
        $stmt_insere_entrada->bindparam(":entrada_cMun_emit", $entrada_cMun_emit);
        $stmt_insere_entrada->bindparam(":entrada_xMun_emit", $entrada_xMun_emit);
        $stmt_insere_entrada->bindparam(":entrada_UF_emit", $entrada_UF_emit);
        $stmt_insere_entrada->bindparam(":entrada_CEP_emit", $entrada_CEP_emit);
        $stmt_insere_entrada->bindparam(":entrada_cPais_emit", $entrada_cPais_emit);
        $stmt_insere_entrada->bindparam(":entrada_xPais_emit", $entrada_xPais_emit);
        $stmt_insere_entrada->bindparam(":entrada_fone_emit", $entrada_fone_emit);
        $stmt_insere_entrada->bindparam(":entrada_ie_emit", $entrada_ie_emit);
        $stmt_insere_entrada->bindparam(":entrada_iest_emit", $entrada_iest_emit);
        $stmt_insere_entrada->bindparam(":entrada_crt_emit", $entrada_crt_emit);

        $stmt_insere_entrada->bindparam(":entrada_cnpj_dest", $entrada_cnpj_dest);
        $stmt_insere_entrada->bindparam(":entrada_cpf_dest", $entrada_cpf_dest);
        $stmt_insere_entrada->bindparam(":entrada_xNome_dest", $entrada_xNome_dest);
        $stmt_insere_entrada->bindparam(":entrada_xLgr_dest", $entrada_xLgr_dest);
        $stmt_insere_entrada->bindparam(":entrada_nro_dest", $entrada_nro_dest);
        $stmt_insere_entrada->bindparam(":entrada_xCpl_dest", $entrada_xCpl_dest);
        $stmt_insere_entrada->bindparam(":entrada_xBairro_dest", $entrada_xBairro_dest);
        $stmt_insere_entrada->bindparam(":entrada_cMun_dest", $entrada_cMun_dest);
        $stmt_insere_entrada->bindparam(":entrada_xMun_dest", $entrada_xMun_dest);
        $stmt_insere_entrada->bindparam(":entrada_UF_dest", $entrada_UF_dest);

        $stmt_insere_entrada->bindparam(":entrada_CEP_dest", $entrada_CEP_dest);
        $stmt_insere_entrada->bindparam(":entrada_cPais_dest", $entrada_cPais_dest);
        $stmt_insere_entrada->bindparam(":entrada_xPais_dest", $entrada_xPais_dest);
        $stmt_insere_entrada->bindparam(":entrada_fone_dest", $entrada_fone_dest);
        $stmt_insere_entrada->bindparam(":entrada_ie_dest", $entrada_ie_dest);
        $stmt_insere_entrada->bindparam(":entrada_email_dest", $entrada_email_dest);

        $stmt_insere_entrada->bindparam(":entrada_vBC", $entrada_vBC);
        $stmt_insere_entrada->bindparam(":entrada_vICMS", $entrada_vICMS);
        $stmt_insere_entrada->bindparam(":entrada_vICMSDeson", $entrada_vICMSDeson);
        $stmt_insere_entrada->bindparam(":entrada_vBCST", $entrada_vBCST);
        $stmt_insere_entrada->bindparam(":entrada_vST", $entrada_vST);
        $stmt_insere_entrada->bindparam(":entrada_vProd", $entrada_vProd);
        $stmt_insere_entrada->bindparam(":entrada_vNF", $entrada_vNF);
        $stmt_insere_entrada->bindparam(":entrada_vFrete", $entrada_vFrete);
        $stmt_insere_entrada->bindparam(":entrada_vSeg", $entrada_vSeg);
        $stmt_insere_entrada->bindparam(":entrada_vDesc", $entrada_vDesc);
        $stmt_insere_entrada->bindparam(":entrada_vIPI", $entrada_vIPI);

        $stmt_insere_entrada->execute();
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }

    $seq = $_POST['seq'];
    $codigo = $_POST['codigo'];
    $cEAN = $_POST['cEAN'];
    $id_cnpj = $_POST['id_cnpj'];
    $xProd = $_POST['xProd'];
    $NCM = $_POST['NCM'];
    $CFOP = $_POST['CFOP'];
    $uCom = $_POST['uCom'];
    $qCom = $_POST['qCom'];
    $vUnCom = $_POST['vUnCom'];
    $vProdu = $_POST['vProdu'];

    $cEANTrib = $_POST['cEANTrib'];
    $uTrib = $_POST['uTrib'];
    $qTrib = $_POST['qTrib'];
    $vUnTrib = $_POST['vUnTrib'];
    $indTot = $_POST['indTot'];
    $nItemPed = $_POST['nItemPed'];
    $vTotTrib = $_POST['vTotTrib'];

    $bc_icms = $_POST['bc_icms'];
    $vlr_icms = $_POST['vlr_icms'];
    $vlr_ipi = $_POST['vlr_ipi'];
    $pICMS = $_POST['pICMS'];
    $perc_ipi = $_POST['perc_ipi'];



    for ($i = 0; $i < count($_POST['seq']); $i++) {

        // print_r($vUnTrib[$i]);
//CONTINUAR AQUI NA INSERCAO DOS PRODUTOS
        $insere_produto_nota = $auth_user->runQuery("INSERT INTO entrada_produto
                (
                entrada_produto_chave,
                entrada_produto_cnpj,
                entrada_produto_nNF,
                entrada_produto_dhEmi,
                entrada_produto_cProd,
                entrada_produto_EAN,
                entrada_produto_xProd,
                entrada_produto_NCM,
                entrada_produto_CFOP,
                entrada_produto_uCom,
                entrada_produto_qCom,
                entrada_produto_vUnCom,
                entrada_produto_vProd,
                
                entrada_produto_cEANTrib,
                entrada_produto_uTrib,
                entrada_produto_qTrib,
                entrada_produto_vUnTrib,
                entrada_produto_indTot,
                entrada_produto_nItemPed,
                entrada_produto_vTotTrib
                
                )
                VALUES(
                :entrada_produto_chave,
                :entrada_produto_cnpj,
                :entrada_produto_nNF,
                :entrada_produto_dhEmi,
                :entrada_produto_cProd,
                :entrada_produto_EAN,
                :entrada_produto_xProd,
                :entrada_produto_NCM,
                :entrada_produto_CFOP,
                :entrada_produto_uCom,
                :entrada_produto_qCom,
                :entrada_produto_vUnCom,
                :entrada_produto_vProd,
                
                :entrada_produto_cEANTrib,
                :entrada_produto_uTrib,
                :entrada_produto_qTrib,
                :entrada_produto_vUnTrib,
                :entrada_produto_indTot,
                :entrada_produto_nItemPed,
                :entrada_produto_vTotTrib
               )
                ");

        $insere_produto_nota->bindparam(":entrada_produto_chave", $chave);
        $insere_produto_nota->bindparam(":entrada_produto_cnpj", $entrada_cnpj_emit);
        $insere_produto_nota->bindparam(":entrada_produto_nNF", $nNF);
        $insere_produto_nota->bindparam(":entrada_produto_dhEmi", $dEmi);
        $insere_produto_nota->bindparam(":entrada_produto_cProd", $codigo[$i]);
        $insere_produto_nota->bindparam(":entrada_produto_EAN", $cEAN[$i]);
        $insere_produto_nota->bindparam(":entrada_produto_xProd", $xProd[$i]);
        $insere_produto_nota->bindparam(":entrada_produto_NCM", $NCM[$i]);
        $insere_produto_nota->bindparam(":entrada_produto_CFOP", $CFOP[$i]);
        $insere_produto_nota->bindparam(":entrada_produto_uCom", $uCom[$i]);
        $insere_produto_nota->bindparam(":entrada_produto_qCom", $qCom[$i]);
        $insere_produto_nota->bindparam(":entrada_produto_vUnCom", $vUnCom[$i]);
        $insere_produto_nota->bindparam(":entrada_produto_vProd", $vProdu[$i]);
        $insere_produto_nota->bindparam(":entrada_produto_cEANTrib", $cEANTrib[$i]);
        $insere_produto_nota->bindparam(":entrada_produto_uTrib", $uTrib[$i]);
        $insere_produto_nota->bindparam(":entrada_produto_qTrib", $qTrib[$i]);
        $insere_produto_nota->bindparam(":entrada_produto_vUnTrib", $vUnTrib[$i]);
        $insere_produto_nota->bindparam(":entrada_produto_indTot", $indTot[$i]);
        $insere_produto_nota->bindparam(":entrada_produto_nItemPed", $nItemPed[$i]);
        $insere_produto_nota->bindparam(":entrada_produto_vTotTrib", $vTotTrib[$i]);

        $insere_produto_nota->execute();

        //BUSCA POR PRODUTO JA CADASTRADO NA TABELA

        $busca_prod_tabela = $auth_user->runQuery("SELECT * FROM produto_fornecedor"
                . " WHERE id_fornecedor = :id_fornecedor AND "
                . "produto_fornecedor_cod_fornecedor = :produto_fornecedor_cod_fornecedor");
        $busca_prod_tabela->bindValue(':id_fornecedor', $id_cnpj[$i], PDO::PARAM_STR);
        $busca_prod_tabela->bindValue(':produto_fornecedor_cod_fornecedor', $codigo[$i], PDO::PARAM_STR);
        $busca_prod_tabela->execute();
        $resultado_busca = $busca_prod_tabela->fetch(PDO::FETCH_ASSOC);

        if (!$resultado_busca) {
            try {
                //CADASTRA O PRODUTO CASO NAO TIVER NO CADASTRO DO FORNECEDOR/ PRODUTO NOVO
                $stmt_insere_produto_xml = $auth_user->runQuery("INSERT INTO produto_fornecedor
                (
                id_fornecedor,
                produto_fornecedor_cod_fornecedor,
                produto_fornecedor_cod_barras,
                produto_fornecedor_un_fornecedor,
                produto_fornecedor_des_fornecedor
                )
                VALUES(
                :id_fornecedor,
                :produto_fornecedor_cod_fornecedor,
                :produto_fornecedor_cod_barras,
                :produto_fornecedor_un_fornecedor,
                :produto_fornecedor_des_fornecedor)");

                $stmt_insere_produto_xml->bindparam(":id_fornecedor", $id_cnpj[$i]);
                $stmt_insere_produto_xml->bindparam(":produto_fornecedor_cod_fornecedor", $codigo[$i]);
                $stmt_insere_produto_xml->bindparam(":produto_fornecedor_cod_barras", $cEAN[$i]);
                $stmt_insere_produto_xml->bindparam(":produto_fornecedor_un_fornecedor", $uCom[$i]);
                $stmt_insere_produto_xml->bindparam(":produto_fornecedor_des_fornecedor", $xProd[$i]);
                $stmt_insere_produto_xml->execute();

                // $auth_user->redirect("index.php?busca = 3");
            } catch (PDOException $e) {
                echo 'Error: ' . $e->getMessage();
            }
        }
    }
   // $auth_user->redirect("download_xml1.php?status=3");
}

//SALVA O ARQUIVO XML NA PASTA
if (isset($_POST['submit'])) {

    $target_dir = "C:/xampp/htdocs/nota/down/arquivos/";

    $target_file = $target_dir . basename($_FILES['file']['name']);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
// Allow certain file formats
    if ($imageFileType != "xml") {
        echo "Não é um Arquivo XML.";
        $uploadOk = 0;
    }
    if (file_exists($target_file)) {
        echo "Arquivo ja existe.";
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        echo "Arquivo não carregado!.";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
            // echo "XML " . basename($_FILES['file']['name']) . " carregado com Sucesso.";
            // $arquivo = "arquivos/" . $chave . ".xml";
            $arquivo = "arquivos/" . $_FILES['file']['name'];

            if (file_exists($arquivo)) {
                // $arquivo = $arquivo;
                $xml = simplexml_load_file($arquivo);
                // imprime os atributos do objeto criado

                if (empty($xml->protNFe->infProt->nProt)) {
                    echo "<h4>Arquivo sem dados de autorizado!</h4>";
                    exit;
                }
                $chave_texto = $xml->NFe->infNFe->attributes()->Id;
                $chave_texto = strtr(strtoupper($chave_texto), array("NFE" => NULL));
            }

//$auth_user->redirect("entrada_por_xml.php?chave_texto={$chave_texto}&status=0");
            $auth_user->redirect("download_xml1.php?chave_texto={$chave_texto}&status=0");
        }
    }
}