<?php

require_once("../class/session.php");
require_once '../class/conexao.class.php';

require_once("../class/class.user.php");
$auth_user = new USER();

//Verificação da Sessao
$user_id = $_SESSION['user_session'];
$stmt = $auth_user->runQuery("SELECT * FROM funcionarios WHERE funcionario_id=:user_id");
$stmt->execute(array(":user_id" => $user_id));
$userRow = $stmt->fetch(PDO::FETCH_ASSOC);



$contas_receber_id = $_POST['contas_receber_id'];
$contas_numero = $_POST['contas_receber_numero'];
$empresa_id = 1;
//BUSCA AS INFORMAÇÕES DO BOLETO PARA SER EMITIDO
$stmt_boleto = $auth_user->runQuery("SELECT * FROM contas_receber, cliente, municipio WHERE "
        . "id_cliente = cliente_id AND id_municipio = municipio_id AND contas_receber_id =:id_boleto");
$stmt_boleto->bindParam(":id_boleto", $contas_receber_id, PDO::PARAM_STR);
$stmt_boleto->execute();
$linha = $stmt_boleto->fetch(PDO::FETCH_ASSOC);

//BUSCA OS DADOS DA EMPRESA
$stmt_empres = $auth_user->runQuery("SELECT * FROM empresa, municipio WHERE"
        . " id_municipio = municipio_id AND empresa_id =:empresa_id");
$stmt_empres->bindParam(":empresa_id", $empresa_id, PDO::PARAM_STR);
$stmt_empres->execute();
$dados_empres = $stmt_empres->fetch(PDO::FETCH_ASSOC);

//CALCULO DA DIFERENÇA DE DATA PARA OS DIAS DE PRAZO PARA O PAGAMENTO.
$stmt_dias = $auth_user->runQuery("SELECT
contas_receber_id,
contas_receber_numero,
contas_receber_data,
contas_receber_vencimento,
DATEDIFF (contas_receber_vencimento, contas_receber_data) AS quantidade_dias
FROM contas_receber WHERE contas_receber_numero = :numero");
$stmt_dias->bindParam(":numero", $contas_numero, PDO::PARAM_STR);
$stmt_dias->execute();
$dados_numero = $stmt_dias->fetch(PDO::FETCH_ASSOC);


// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc)	//
// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = $dados_numero['quantidade_dias'];
$taxa_boleto = 0;
$data_venc = date("d/m/Y", strtotime($linha['contas_receber_vencimento']));//"14/05/2013"; //date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
$valor_cobrado = $linha['contas_receber_valor']; //"1,00"; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".", $valor_cobrado);
$valor_boleto = number_format($valor_cobrado + $taxa_boleto, 2, ',', '');
//$dadosboleto["nosso_numero"] = "08123456";  // Até 8 digitos, sendo os 2 primeiros o ano atual (Ex.: 08 se for 2008)
/* * ***********************************************************************
 * +++
 * *********************************************************************** */
// http://www.bancoob.com.br/atendimentocobranca/CAS/2_Implanta%C3%A7%C3%A3o_do_Servi%C3%A7o/Sistema_Proprio/DigitoVerificador.htm
// http://blog.inhosting.com.br/calculo-do-nosso-numero-no-boleto-bancoob-sicoob-do-boletophp/
// http://www.samuca.eti.br
// 
// http://www.bancoob.com.br/atendimentocobranca/CAS/2_Implanta%C3%A7%C3%A3o_do_Servi%C3%A7o/Sistema_Proprio/LinhaDigitavelCodicodeBarras.htm
// Contribuição de script por:
// 
// Samuel de L. Hantschel
// Site: www.samuca.eti.br
// 
if (!function_exists('formata_numdoc')) {

    function formata_numdoc($num, $tamanho) {
        while (strlen($num) < $tamanho) {
            $num = "0" . $num;
        }
        return $num;
    }

}
$IdDoSeuSistemaAutoIncremento = $linha['contas_receber_id']; //'2'; // Deve informar um numero sequencial a ser passada a função abaixo, Até 6 dígitos
$agencia = "3087"; // Num da agencia, sem digito
$conta = "4593"; // Num da conta, sem digito
$convenio = "56235"; //Número do convênio indicado no frontend
$NossoNumero = formata_numdoc($IdDoSeuSistemaAutoIncremento, 7);
$qtde_nosso_numero = strlen($NossoNumero);
$sequencia = formata_numdoc($agencia, 4) . formata_numdoc(str_replace("-", "", $convenio), 10) . formata_numdoc($NossoNumero, 7);
$cont = 0;
$calculoDv = '';
for ($num = 0; $num <= strlen($sequencia); $num++) {
    $cont++;
    if ($cont == 1) {
        // constante fixa Sicoob » 3197 
        $constante = 3;
    }
    if ($cont == 2) {
        $constante = 1;
    }
    if ($cont == 3) {
        $constante = 9;
    }
    if ($cont == 4) {
        $constante = 7;
        $cont = 0;
    }
    $calculoDv = $calculoDv + (substr($sequencia, $num, 1) * $constante);
}
$Resto = $calculoDv % 11;
$Dv = 11 - $Resto;
if ($Dv == 0)
    $Dv = 0;
if ($Dv == 1)
    $Dv = 0;
if ($Dv > 9)
    $Dv = 0;
$dadosboleto["nosso_numero"] = $NossoNumero . $Dv;
/* * ***********************************************************************
 * +++
 * *********************************************************************** */
$dadosboleto["numero_documento"] = $linha['contas_receber_numero'];//"12"; // Num do pedido ou do documento
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto;  // Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula
// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = $linha['cliente_nome']; //"Nome do seu Cliente";
$dadosboleto["endereco1"] = $linha['cliente_logradouro'].", ".$linha['cliente_numero'];   //"Endereço do seu Cliente";
$dadosboleto["endereco2"] = $linha['municipio_nome']." - ".$linha['municipio_sigla']." - ".$linha['cliente_cep']; //"Cidade - Estado -  CEP: 00000-000";
// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "Pagamento referente a fatura N°:".$linha['contas_receber_numero']; //"Pagamento de Compra na Loja Nonononono";
//$dadosboleto["demonstrativo2"] = "Mensalidade referente a nonon nonooon nononon<br>Taxa bancária - R$ " . number_format($taxa_boleto, 2, ',', '');
//$dadosboleto["demonstrativo3"] = "BoletoPhp - http://www.boletophp.com.br";
// INSTRUÇÕES PARA O CAIXA
$dadosboleto["instrucoes1"] = "- Sr. Caixa, cobrar multa de 2% após o vencimento";
$dadosboleto["instrucoes2"] = "- Não receber após o vencimento";
$dadosboleto["instrucoes3"] = "- Em caso de dúvidas entre em contato conosco:".$dados_empres['empresa_email'];
//$dadosboleto["instrucoes4"] = "&nbsp; Emitido pelo sistema Projeto BoletoPhp - www.boletophp.com.br";
// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "10";
$dadosboleto["valor_unitario"] = "10";
$dadosboleto["aceite"] = "N";
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "DM";
// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //
// DADOS ESPECIFICOS DO SICOOB
$dadosboleto["modalidade_cobranca"] = "02";
$dadosboleto["numero_parcela"] = "901";
// DADOS DA SUA CONTA - BANCO SICOOB
$dadosboleto["agencia"] = $agencia; // Num da agencia, sem digito
$dadosboleto["conta"] = $conta; // Num da conta, sem digito
// DADOS PERSONALIZADOS - SICOOB
$dadosboleto["convenio"] = $convenio; // Num do convênio - REGRA: No máximo 7 dígitos
$dadosboleto["carteira"] = "1";
// SEUS DADOS
$dadosboleto["identificacao"] = $dados_empres['empresa_fantasia']; //"BoletoPhp - Código Aberto de Sistema de Boletos";
$dadosboleto["cpf_cnpj"] = $dados_empres['empresa_cnpj']; //"";
$dadosboleto["endereco"] = $dados_empres['empresa_logradouro'].",".$dados_empres['empresa_numero']; //"Coloque o endereço da sua empresa aqui";
$dadosboleto["cidade_uf"] = $dados_empres['municipio_nome'].",".$dados_empres['municipio_sigla']; //"Cidade / Estado";
$dadosboleto["cedente"] = $dados_empres['empresa_nome']; //"Coloque a Razão Social da sua empresa aqui";
// NÃO ALTERAR!
include("include/funcoes_bancoob.php");
include("include/layout_bancoob.php");
?>





