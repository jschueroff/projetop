<?php

require_once("../class/session.php");
require_once '../class/conexao.class.php';
require_once("../class/class.user.php");

$auth_user = new USER();



$teste_fatura = $auth_user->runQuery("select * from forma_pagamento where forma_pagamento_id = 7");
$teste_fatura->execute();
$test_fatura = $teste_fatura->fetch(PDO::FETCH_ASSOC);
echo $test_fatura['forma_pagamento_nome'] . "<br>";
echo "VEZES :" . $test_fatura['forma_pagamento_vezes'] . "<br>";

//Pegue a data no formato dd/mm/yyyy
$prazo_banco = $test_fatura['forma_pagamento_prazo_pag'];
//Exploda a data para entrar no formato aceito pelo DB.
$prazo_oficial = explode('/', $prazo_banco);

//FORMATA O PERCENTUAL
$percentual_aux = $test_fatura['forma_pagamento_percentual'];
//Exploda a data para entrar no formato aceito pelo DB.
$percentual_oficial = explode('/', $percentual_aux);



echo "<br><br>";

$valor_produto = 150.00;


$flag = 0;
if ($test_fatura['forma_pagamento_vezes'] == 1) {
    $sql = " SELECT curdate() as dataatual, 
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[0]})  DAY) AS data1";
    $ver_teste = $auth_user->runQuery($sql);
    $ver_teste->execute();
    $resultado = $ver_teste->fetch(PDO::FETCH_ASSOC);
    echo "DATA ATUAL: ".$resultado['dataatual'] . "<br>";
    echo "VENCIMENTO1: ".$resultado['data1'] . "- DIAS ".$prazo_oficial[0]."<br>";
    echo "VALOR PRODUTO :".$valor_produto."<br>";
    echo "PERCENTUAL DE CALCULO :".$percentual_oficial[0]."<br>";
    
}
if ($test_fatura['forma_pagamento_vezes'] == 2) {
    $sql = " SELECT curdate() as dataatual, 
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[0]})  DAY) AS data0,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[1]})  DAY) AS data1";
    $ver_teste = $auth_user->runQuery($sql);
    $ver_teste->execute();
    $resultado = $ver_teste->fetch(PDO::FETCH_ASSOC);
    echo "DATA ATUAL: ".$resultado['dataatual'] . "<br>";
    echo "VENCIMENTO0: ".$resultado['data0'] ."- DIAS ".$prazo_oficial[0]."<br>";
    echo "VENCIMENTO1: ".$resultado['data1'] . "- DIAS ".$prazo_oficial[1]."<br>";
    echo "VALOR PRODUTO :".$valor_produto."<br>";
    echo "PERCENTUAL DE CALCULO0 :".$percentual_oficial[0]."<br>";
    echo "PERCENTUAL DE CALCULO1 :".$percentual_oficial[1]."<br>";
}
if ($test_fatura['forma_pagamento_vezes'] == 3) {
    $sql = " SELECT curdate() as dataatual, 
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[0]})  DAY) AS data0,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[1]})  DAY) AS data1,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[2]})  DAY) AS data2";
    $ver_teste = $auth_user->runQuery($sql);
    $ver_teste->execute();
    $resultado = $ver_teste->fetch(PDO::FETCH_ASSOC);
    echo "DATA ATUAL: ".$resultado['dataatual'] . "<br>";
    echo "VENCIMENTO0: ".$resultado['data0'] ."- DIAS ".$prazo_oficial[0]."<br>";
    echo "VENCIMENTO1: ".$resultado['data1'] . "- DIAS ".$prazo_oficial[1]."<br>";
    echo "VENCIMENTO2: ".$resultado['data2'] . "- DIAS ".$prazo_oficial[2]."<br>";
    echo "VALOR PRODUTO :".$valor_produto."<br>";
    
    //$valor_parcial = (($valor_produto * $percentual_oficial[0])/100);
    
    echo "PERCENTUAL DE CALCULO0 :".$percentual_oficial[0]." VALOR PARCIAL".  number_format((($valor_produto * $percentual_oficial[0])/100),2,'.','')."<br>";
    echo "PERCENTUAL DE CALCULO1 :".$percentual_oficial[1]." VALOR PARCIAL".  number_format((($valor_produto * $percentual_oficial[1])/100),2,'.','')."<br>";
    echo "PERCENTUAL DE CALCULO2 :".$percentual_oficial[2]." VALOR PARCIAL".  number_format((($valor_produto * $percentual_oficial[2])/100),2,'.','')."<br>";
}
if ($test_fatura['forma_pagamento_vezes'] == 4) {
    $sql = " SELECT curdate() as dataatual, 
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[0]})  DAY) AS data0,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[1]})  DAY) AS data1,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[2]})  DAY) AS data2,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[3]})  DAY) AS data3";
    $ver_teste = $auth_user->runQuery($sql);
    $ver_teste->execute();
    $resultado = $ver_teste->fetch(PDO::FETCH_ASSOC);
    echo "DATA ATUAL: ".$resultado['dataatual'] . "<br>";
    echo "VENCIMENTO0: ".$resultado['data0'] ."- DIAS ".$prazo_oficial[0]."<br>";
    echo "VENCIMENTO1: ".$resultado['data1'] . "- DIAS ".$prazo_oficial[1]."<br>";
    echo "VENCIMENTO2: ".$resultado['data2'] . "- DIAS ".$prazo_oficial[2]."<br>";
    echo "VENCIMENTO3: ".$resultado['data3'] . "- DIAS ".$prazo_oficial[3]."<br>";
    echo "VALOR PRODUTO :".$valor_produto."<br>";
    
    //$valor_parcial = (($valor_produto * $percentual_oficial[0])/100);
    
    echo "PERCENTUAL DE CALCULO0 :".$percentual_oficial[0]." VALOR PARCIAL".  number_format((($valor_produto * $percentual_oficial[0])/100),2,'.','')."<br>";
    echo "PERCENTUAL DE CALCULO1 :".$percentual_oficial[1]." VALOR PARCIAL".  number_format((($valor_produto * $percentual_oficial[1])/100),2,'.','')."<br>";
    echo "PERCENTUAL DE CALCULO2 :".$percentual_oficial[2]." VALOR PARCIAL".  number_format((($valor_produto * $percentual_oficial[2])/100),2,'.','')."<br>";
    echo "PERCENTUAL DE CALCULO3 :".$percentual_oficial[3]." VALOR PARCIAL".  number_format((($valor_produto * $percentual_oficial[3])/100),2,'.','')."<br>";
}

?>