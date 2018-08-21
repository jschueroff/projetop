<?php
    
    //ASSINA A NFE 

// $filename = "/var/www/nfe/homologacao/entradas/{$chave}-nfe.xml"; // Ambiente Linux
    $filename = "C:/xampp/htdocs/alubrasc/nfe/nfes/homologacao/entradas/{$chave}-nfe.xml"; // Ambiente Windows
    $xml = file_get_contents($filename);
    $xml = $nfe2->assina($xml);
// $filename = "/var/www/nfe/homologacao/assinadas/{$chave}-nfe.xml"; // Ambiente Linux
    $filename = "C:/xampp/htdocs/alubrasc/nfe/nfes/homologacao/assinadas/{$chave}-nfe.xml"; // Ambiente Windows
    file_put_contents($filename, $xml);
    chmod($filename, 0777);
   //echo $chave;
    
    ?>
