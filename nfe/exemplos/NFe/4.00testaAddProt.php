<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../../bootstrap.php';

use NFePHP\NFe\ToolsNFe;

$nfe = new ToolsNFe('../../config/config.json');
$aResposta = array();

$indSinc = '0'; //0=asíncrono, 1=síncrono
$chave = '42160811169963000130550010000000761371691895';
$recibo = '423002166678320';
$pathNFefile = "C:/xampp/htdocs/nota/nfe/nfes/homologacao/assinadas/{$chave}-nfe.xml";
if (! $indSinc) {
    $pathProtfile = "C:/xampp/htdocs/nota/nfe/nfes/homologacao/temporarias/201608/{$recibo}-retConsReciNFe.xml";
} else {
    $pathProtfile = "C:/xampp/htdocs/nota/nfe/nfes/homologacao/temporarias/201608/{$recibo}-retConsReciNFe.xml";
}

$saveFile = true;
$retorno = $nfe->addProtocolo($pathNFefile, $pathProtfile, $saveFile);
echo '<br><br><pre>';
echo htmlspecialchars($retorno);
echo "</pre><br>";

