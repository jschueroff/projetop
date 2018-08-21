<?php

//DADOS DO CLIENTE/DESTINATARIO
$CNPJ = $dados_pedido['cliente_cpf_cnpj'];
$CPF = $dados_pedido['cliente_cpf'];
$idEstrangeiro = $dados_pedido['cliente_id_estrageiro'];
$xNome = $dados_pedido['cliente_nome'];
$indIEDest = $dados_pedido['cliente_tipo'];
$IE = $dados_pedido['cliente_ie'];
//$ISUF = $dados_pedido['cliente_inscricao_suframa']; //'';
if ($dados_pedido['cliente_inscricao_suframa'] == '') {
    $ISUF = '';
} else {
    $ISUF = $dados_pedido['cliente_inscricao_suframa'];
}
//$IM = $dados_pedido['cliente_inscricao_municipal']; //'';
if ($dados_pedido['cliente_inscricao_municipal'] == '') {
    $IM = '';
} else {
    $IM = $dados_pedido['cliente_inscricao_municipal'];
}
$email = $dados_pedido['cliente_email_nfe'];
//$resp = $nfe->tagdest($CNPJ, $CPF, $idEstrangeiro, $xNome, $indIEDest, $IE, $ISUF, $IM, $email);

//ENDERECO DO DESTINATARIO //CONTINUAR AQUI PRA FRENTE CONTINUAR A ALTERAÇÃO DO CLIENTE QUE ESTA INCOMPLETA
$xLgr = $dados_pedido['cliente_logradouro'];
$nro = $dados_pedido['cliente_numero'];
$xCpl = $dados_pedido['cliente_complemento'];
$xBairro = $dados_pedido['cliente_bairro'];
$cMun = $dados_pedido['municipio_cod_ibge'];
$xMun = strtoupper($dados_pedido['municipio_nome']);
$UF = $dados_pedido['municipio_sigla'];
$CEP = $dados_pedido['cliente_cep'];
$cPais = '1058';
$xPais = 'Brasil';
$fone = $dados_pedido['cliente_telefone'];
//$resp = $nfe->tagenderDest($xLgr, $nro, $xCpl, $xBairro, $cMun, $xMun, $UF, $CEP, $cPais, $xPais, $fone);
