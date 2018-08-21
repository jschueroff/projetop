<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../../bootstrap.php';

use NFePHP\NFe\ToolsNFe;

$nfe = new ToolsNFe('../../config/config.json');
$aResposta = array();

$indSinc = '1'; //0=asíncrono, 1=síncrono
$chave = '42160711169963000130550010000158721379261412';
$recibo = '146776032502441';
$pathNFefile = "C:/xampp/htdocs/nota/nfe/nfes/homologacao/assinadas/{$chave}-nfe.xml";
if (! $indSinc) {
    $pathProtfile = "C:/xampp/htdocs/nota/nfe/nfes/homologacao/temporarias/201607/{$recibo}-retConsReciNFe.xml";
} else {
    $pathProtfile = "C:/xampp/htdocs/nota/nfe/nfes/homologacao/temporarias/201607/{$recibo}-retEnviNFe.xml";
}
$saveFile = true;
$retorno = $nfe->addProtocolo($pathNFefile, $pathProtfile, $saveFile);
echo '<br><br><pre>';
echo htmlspecialchars($retorno);
echo "</pre><br>";
