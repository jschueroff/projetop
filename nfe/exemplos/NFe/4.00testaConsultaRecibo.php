<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../../bootstrap.php';

use NFePHP\NFe\ToolsNFe;

$nfe = new ToolsNFe('../../config/config.json');
$nfe->setModelo('55');

$aResposta = array();
$tpAmb = '2';
$recibo = '423002166678320';
$retorno = $nfe->sefazConsultaRecibo($recibo, $tpAmb, $aResposta);
echo '<br><br><pre>';
echo htmlspecialchars($nfe->soapDebug);
echo '</pre><br><br><pre>';
print_r($aResposta);
echo "</pre><br>";


print_r($aResposta["aProt"]["0"]["digVal"]);
print_r($aResposta["aProt"]["0"]["cStat"]);
