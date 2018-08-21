<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../../bootstrap.php';

use NFePHP\NFe\ToolsNFe;

$nfe = new ToolsNFe('../../config/config.json');
$nfe->setModelo('55');

$chave = '42160711169963000130550010000158721379261412';
$tpAmb = '2';
// $xml = "/var/www/nfe/homologacao/assinadas/{$chave}-nfe.xml"; // Ambiente Linux
$xml = "C:/xampp/htdocs/nota/nfe/nfes/homologacao/assinadas/{$chave}-nfe.xml"; // Ambiente Windows

if (! $nfe->validarXml($xml) || sizeof($nfeTools->errors)) {
    echo "<h3>Eita !?! Tem bicho na linha .... </h3>";    
    foreach ($nfe->errors as $erro) {
        if (is_array($erro)) { 
            foreach ($erro as $err) {
                echo "$err <br>";
            }
        } else {
            echo "$erro <br>";
        }
    }
    exit;
}
echo "NFe Valida !";
