<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../../bootstrap.php';

use NFePHP\NFe\ToolsNFe;

$nfe = new ToolsNFe('../../config/config.json');
$nfe->setModelo('55');

$aResposta = array();
$chave = '42160711169963000130550010000158721379261412';
$tpAmb = '2';
// $aXml = file_get_contents("/var/www/nfe/homologacao/assinadas/{$chave}-nfe.xml"); // Ambiente Linux
$aXml = file_get_contents("C:/xampp/htdocs/nota/nfe/nfes/homologacao/assinadas/{$chave}-nfe.xml"); // Ambiente Windows
$idLote = '';
$indSinc = '1';
$flagZip = false;
$retorno = $nfe->sefazEnviaLote($aXml, $tpAmb, $idLote, $aResposta, $indSinc, $flagZip);
echo '<br><br><pre>';
echo htmlspecialchars($nfe->soapDebug);
echo '</pre><br><br><pre>';
print_r($aResposta);
echo "</pre><br>";
