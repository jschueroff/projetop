<?php
/**
 * ATENÇÃO : Esse exemplo usa classe PROVISÓRIA que será removida assim que 
 * a nova classe DANFE estiver refatorada e a pasta EXTRAS será removida.
 */

error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../../bootstrap.php';

use NFePHP\NFe\ToolsNFe;
use NFePHP\Extras\Danfe;
use NFePHP\Common\Files\FilesFolders;

$nfe = new ToolsNFe('../../config/config.json');

$chave = '42160811169963000130550010000000641729022219';
$xmlProt = "C:/xampp/htdocs/nota/nfe/nfes/homologacao/enviadas/aprovadas/201608/{$chave}-protNFe.xml";
// Uso da nomeclatura '-danfe.pdf' para facilitar a diferenciação entre PDFs DANFE e DANFCE salvos na mesma pasta...
$pdfDanfe = "C:/xampp/htdocs/nota/nfe/nfes/homologacao/pdf/201608/{$chave}-danfe.pdf";

$docxml = FilesFolders::readFile($xmlProt);
$danfe = new Danfe($docxml, 'P', 'A4', $nfe->aConfig['aDocFormat']->pathLogoFile, 'I', '');
$id = $danfe->montaDANFE();
$salva = $danfe->printDANFE($pdfDanfe, 'F'); //Salva o PDF na pasta
$abre = $danfe->printDANFE("{$id}-danfe.pdf", 'I'); //Abre o PDF no Navegador


//Aqui pode fazer a visualização da NFE antes de validar a mesma
/*
$chave = '42160811169963000130550010000000151237548824';
$xmlProt = "C:/xampp/htdocs/nota/nfe/nfes/homologacao/assinadas/{$chave}-nfe.xml";
// Uso da nomeclatura '-danfe.pdf' para facilitar a diferenciação entre PDFs DANFE e DANFCE salvos na mesma pasta...
$pdfDanfe = "C:/xampp/htdocs/nota/nfe/nfes/homologacao/pdf/teste/{$chave}-danfe.pdf";

$docxml = FilesFolders::readFile($xmlProt);
$danfe = new Danfe($docxml, 'P', 'A4', $nfe->aConfig['aDocFormat']->pathLogoFile, 'I', '');
$id = $danfe->montaDANFE();
$salva = $danfe->printDANFE($pdfDanfe, 'F'); //Salva o PDF na pasta
$abre = $danfe->printDANFE("{$id}-danfe.pdf", 'I'); //Abre o PDF no Navegador
 * 
 */