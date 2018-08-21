<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../../bootstrap.php';

use NFePHP\NFe\ToolsNFe;

$nfe = new ToolsNFe('../../config/config.json');
$nfe->setModelo('55');

$aResposta = array();
$chNFe = '42160711169963000130550010000158721379261412';
$tpAmb = '2';
$xCorrecao = 'Teste de carta de correcao em ambiente homologacao';
$nSeqEvento = 1;
$retorno = $nfe->sefazCCe($chNFe, $tpAmb, $xCorrecao, $nSeqEvento, $aResposta);
echo '<br><br><PRE>';
echo htmlspecialchars($nfe->soapDebug);
echo '</PRE><BR>';
print_r($aResposta);
echo "<br>";
