<?php

// Autoload
require './vendor/autoload.php';

// Namespace
use DownloadNFeSefaz\DownloadNFeSefaz;

// Iniciando a classe
$downloadXml = new DownloadNFeSefaz();


$chave = $_POST['chave'];
$captcha = $_POST['captcha'];

// CNPJ do certificado digital
$CNPJ = '11169963000130';

// Pasta onde se encontram os arquivos .pem
// {CNPJ}_priKEY.pem
// {CNPJ}_certKEY.pem
// {CNPJ}_pubKEY.pem
//$path_cert = '\pasta_do_certificado\\';
$path_cert ='C:/xampp/htdocs/nota/certs/';

// Senha do certificado
$senha_cert = '2010';

// Sabendo o captcha é só fazer o download do XML informando o mesmo e a chave de acesso da NF-e
//$captcha = '{captcha}';
//$captcha = 'oqi8xo';

// Chave de acesso
//$chave_acesso = '42170117524772000125550010000001151805901062';
$chave_acesso = $chave;

$xml = $downloadXml->downloadXmlSefaz($captcha, $chave_acesso, $CNPJ, $path_cert, $senha_cert);

//echo $xml;
$xml = simplexml_load_string($xml);

$emit_CPF = $xml->NFe->infNFe->emit->CPF;
$emit_CNPJ = $xml->NFe->infNFe->emit->CNPJ;
$chave = $xml->NFe->infNFe->attributes()->Id;
$chave = strtr(strtoupper($chave), array("NFE" => NULL));


echo $emit_CPF."<br>";
echo $emit_CNPJ."<br>";
echo $chave."<br>";
//return $xml;

