<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../../bootstrap.php';

use NFePHP\NFe\ToolsNFe;

$nfe = new ToolsNFe('../../config/config.json');
$nfe->setModelo('55');

$chNFe = '42161209531045000248550010000583131914581356';
$tpAmb = '1';
$cnpj = '11169963000130';
$aResposta = array();

$resp = $nfe->sefazDownload($chNFe, $tpAmb, $cnpj, $aResposta);
echo '<br><br><PRE>';
echo htmlspecialchars($nfe->soapDebug);
echo '</PRE><BR>';
print_r($aResposta);
echo "<br>";
