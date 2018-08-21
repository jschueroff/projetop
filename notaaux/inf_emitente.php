<?php
//DADOS DO EMITENTE

$CNPJ = $dados_empresa['empresa_cnpj'];
$CPF = $dados_empresa['empresa_cpf'];  //''; // Utilizado para CPF na nota
$xNome = $dados_empresa['empresa_nome'];
$xFant = $dados_empresa['empresa_fantasia'];
$IE = $dados_empresa['empresa_ie'];
//VERIFICAR AQUI SE TEM ALGUMA POSSIBILIDADE DE PEGAR ESSES DADOS DO BANCO
$IEST = $dados_empresa['empresa_ie_st']; //'';
$IM = $dados_empresa['empresa_im']; //'';
$CNAE = $dados_empresa['empresa_cnae']; //'';
$CRT = $dados_empresa['empresa_crt'];
//$resp = $nfe->tagemit($CNPJ, $CPF, $xNome, $xFant, $IE, $IEST, $IM, $CNAE, $CRT);

//ENDERECO DO EMITENTE

$xLgr = $dados_empresa['empresa_logradouro'];
$nro = $dados_empresa['empresa_numero'];
//VERIFICAR O COMPLEMENTO DO BANCO
$xCpl = $dados_empresa['empresa_complemento']; //'KM 128';
$xBairro = $dados_empresa['empresa_bairro'];
$cMun = $dados_empresa['municipio_cod_ibge'];
$xMun = strtoupper($dados_empresa['municipio_nome']);
$UF = $dados_empresa['municipio_sigla'];
$CEP = $dados_empresa['empresa_cep'];
$cPais = '1058';
$xPais = 'Brasil';
$fone = $dados_empresa['empresa_telefone'];
//$resp = $nfe->tagenderEmit($xLgr, $nro, $xCpl, $xBairro, $cMun, $xMun, $UF, $CEP, $cPais, $xPais, $fone);
