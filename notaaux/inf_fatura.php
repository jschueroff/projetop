<?php

//dados da fatura
$nFat = $dados_empresa['empresa_numero_nfe'];
$vOrig = $vNF;
$vDesc = '';
$vLiq = $vNF;
//$resp = $nfe->tagfat($nFat, $vOrig, $vDesc, $vLiq);

//PRAZO CADASTRADO NA FORMA DE PAGAMENTO
$prazo_banco = $dados_pedido['forma_pagamento_prazo_pag'];
//Exploda a data para entrar no formato aceito pelo DB.
$prazo_oficial = explode('/', $prazo_banco);

//FORMATA O PERCENTUAL CADASTRADO NO BANCO DE DADOS.
$percentual_aux = $dados_pedido['forma_pagamento_percentual'];
//Exploda a data para entrar no formato aceito pelo DB.
$percentual_oficial = explode('/', $percentual_aux);

if ($dados_pedido['forma_pagamento_vezes'] == 1) {
    $sql = " SELECT curdate() as dataatual, 
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[0]})  DAY) AS data0";
    $ver_teste = $auth_user->runQuery($sql);
    $ver_teste->execute();
    $resultado = $ver_teste->fetch(PDO::FETCH_ASSOC);
    $aDup = array(
        array($dados_empresa['empresa_numero_nfe'] . '-1', $resultado['data0'], number_format((($vNF * $percentual_oficial[0]) / 100), 2, '.', ''))
    );
}
if ($dados_pedido['forma_pagamento_vezes'] == 2) {
    $sql = " SELECT curdate() as dataatual, 
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[0]})  DAY) AS data0,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[1]})  DAY) AS data1";
    $ver_teste = $auth_user->runQuery($sql);
    $ver_teste->execute();
    $resultado = $ver_teste->fetch(PDO::FETCH_ASSOC);
    $aDup = array(
        array($dados_empresa['empresa_numero_nfe'] . '-1', $resultado['data0'], number_format((($vNF * $percentual_oficial[0]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-2', $resultado['data1'], number_format((($vNF * $percentual_oficial[1]) / 100), 2, '.', ''))
    );
}
if ($dados_pedido['forma_pagamento_vezes'] == 3) {
    $sql = " SELECT curdate() as dataatual, 
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[0]})  DAY) AS data0,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[1]})  DAY) AS data1,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[2]})  DAY) AS data2";
    $ver_teste = $auth_user->runQuery($sql);
    $ver_teste->execute();
    $resultado = $ver_teste->fetch(PDO::FETCH_ASSOC);
    $aDup = array(
        array($dados_empresa['empresa_numero_nfe'] . '-1', $resultado['data0'], number_format((($vNF * $percentual_oficial[0]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-2', $resultado['data1'], number_format((($vNF * $percentual_oficial[1]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-3', $resultado['data2'], number_format((($vNF * $percentual_oficial[2]) / 100), 2, '.', ''))
    );
}
if ($dados_pedido['forma_pagamento_vezes'] == 4) {
    $sql = " SELECT curdate() as dataatual, 
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[0]})  DAY) AS data0,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[1]})  DAY) AS data1,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[2]})  DAY) AS data2,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[3]})  DAY) AS data3";
    $ver_teste = $auth_user->runQuery($sql);
    $ver_teste->execute();
    $resultado = $ver_teste->fetch(PDO::FETCH_ASSOC);
    $aDup = array(
        array($dados_empresa['empresa_numero_nfe'] . '-1', $resultado['data0'], number_format((($vNF * $percentual_oficial[0]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-2', $resultado['data1'], number_format((($vNF * $percentual_oficial[1]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-3', $resultado['data2'], number_format((($vNF * $percentual_oficial[2]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-4', $resultado['data3'], number_format((($vNF * $percentual_oficial[3]) / 100), 2, '.', ''))
    );
}
if ($dados_pedido['forma_pagamento_vezes'] == 5) {
    $sql = " SELECT curdate() as dataatual, 
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[0]})  DAY) AS data0,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[1]})  DAY) AS data1,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[2]})  DAY) AS data2,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[3]})  DAY) AS data3,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[4]})  DAY) AS data4";
    $ver_teste = $auth_user->runQuery($sql);
    $ver_teste->execute();
    $resultado = $ver_teste->fetch(PDO::FETCH_ASSOC);
    $aDup = array(
        array($dados_empresa['empresa_numero_nfe'] . '-1', $resultado['data0'], number_format((($vNF * $percentual_oficial[0]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-2', $resultado['data1'], number_format((($vNF * $percentual_oficial[1]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-3', $resultado['data2'], number_format((($vNF * $percentual_oficial[2]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-4', $resultado['data3'], number_format((($vNF * $percentual_oficial[3]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-5', $resultado['data4'], number_format((($vNF * $percentual_oficial[4]) / 100), 2, '.', ''))
    );
}
if ($dados_pedido['forma_pagamento_vezes'] == 6) {
    $sql = " SELECT curdate() as dataatual, 
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[0]})  DAY) AS data0,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[1]})  DAY) AS data1,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[2]})  DAY) AS data2,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[3]})  DAY) AS data3,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[4]})  DAY) AS data4,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[5]})  DAY) AS data5";
    $ver_teste = $auth_user->runQuery($sql);
    $ver_teste->execute();
    $resultado = $ver_teste->fetch(PDO::FETCH_ASSOC);
    $aDup = array(
        array($dados_empresa['empresa_numero_nfe'] . '-1', $resultado['data0'], number_format((($vNF * $percentual_oficial[0]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-2', $resultado['data1'], number_format((($vNF * $percentual_oficial[1]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-3', $resultado['data2'], number_format((($vNF * $percentual_oficial[2]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-4', $resultado['data3'], number_format((($vNF * $percentual_oficial[3]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-5', $resultado['data4'], number_format((($vNF * $percentual_oficial[4]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-6', $resultado['data5'], number_format((($vNF * $percentual_oficial[5]) / 100), 2, '.', ''))
    );
}
if ($dados_pedido['forma_pagamento_vezes'] == 7) {
    $sql = " SELECT curdate() as dataatual, 
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[0]})  DAY) AS data0,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[1]})  DAY) AS data1,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[2]})  DAY) AS data2,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[3]})  DAY) AS data3,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[4]})  DAY) AS data4,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[5]})  DAY) AS data5,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[6]})  DAY) AS data6";
    $ver_teste = $auth_user->runQuery($sql);
    $ver_teste->execute();
    $resultado = $ver_teste->fetch(PDO::FETCH_ASSOC);
    $aDup = array(
        array($dados_empresa['empresa_numero_nfe'] . '-1', $resultado['data0'], number_format((($vNF * $percentual_oficial[0]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-2', $resultado['data1'], number_format((($vNF * $percentual_oficial[1]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-3', $resultado['data2'], number_format((($vNF * $percentual_oficial[2]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-4', $resultado['data3'], number_format((($vNF * $percentual_oficial[3]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-5', $resultado['data4'], number_format((($vNF * $percentual_oficial[4]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-6', $resultado['data5'], number_format((($vNF * $percentual_oficial[5]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-7', $resultado['data6'], number_format((($vNF * $percentual_oficial[6]) / 100), 2, '.', ''))
    );
}
if ($dados_pedido['forma_pagamento_vezes'] == 8) {
    $sql = " SELECT curdate() as dataatual, 
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[0]})  DAY) AS data0,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[1]})  DAY) AS data1,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[2]})  DAY) AS data2,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[3]})  DAY) AS data3,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[4]})  DAY) AS data4,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[5]})  DAY) AS data5,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[6]})  DAY) AS data6,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[7]})  DAY) AS data7";
    $ver_teste = $auth_user->runQuery($sql);
    $ver_teste->execute();
    $resultado = $ver_teste->fetch(PDO::FETCH_ASSOC);
    $aDup = array(
        array($dados_empresa['empresa_numero_nfe'] . '-1', $resultado['data0'], number_format((($vNF * $percentual_oficial[0]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-2', $resultado['data1'], number_format((($vNF * $percentual_oficial[1]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-3', $resultado['data2'], number_format((($vNF * $percentual_oficial[2]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-4', $resultado['data3'], number_format((($vNF * $percentual_oficial[3]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-5', $resultado['data4'], number_format((($vNF * $percentual_oficial[4]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-6', $resultado['data5'], number_format((($vNF * $percentual_oficial[5]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-7', $resultado['data6'], number_format((($vNF * $percentual_oficial[6]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-8', $resultado['data7'], number_format((($vNF * $percentual_oficial[7]) / 100), 2, '.', ''))
    );
}
if ($dados_pedido['forma_pagamento_vezes'] == 9) {
    $sql = " SELECT curdate() as dataatual, 
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[0]})  DAY) AS data0,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[1]})  DAY) AS data1,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[2]})  DAY) AS data2,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[3]})  DAY) AS data3,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[4]})  DAY) AS data4,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[5]})  DAY) AS data5,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[6]})  DAY) AS data6,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[7]})  DAY) AS data7,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[8]})  DAY) AS data8";
    $ver_teste = $auth_user->runQuery($sql);
    $ver_teste->execute();
    $resultado = $ver_teste->fetch(PDO::FETCH_ASSOC);
    $aDup = array(
        array($dados_empresa['empresa_numero_nfe'] . '-1', $resultado['data0'], number_format((($vNF * $percentual_oficial[0]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-2', $resultado['data1'], number_format((($vNF * $percentual_oficial[1]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-3', $resultado['data2'], number_format((($vNF * $percentual_oficial[2]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-4', $resultado['data3'], number_format((($vNF * $percentual_oficial[3]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-5', $resultado['data4'], number_format((($vNF * $percentual_oficial[4]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-6', $resultado['data5'], number_format((($vNF * $percentual_oficial[5]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-7', $resultado['data6'], number_format((($vNF * $percentual_oficial[6]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-8', $resultado['data7'], number_format((($vNF * $percentual_oficial[7]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-9', $resultado['data8'], number_format((($vNF * $percentual_oficial[8]) / 100), 2, '.', ''))
    );
}
if ($dados_pedido['forma_pagamento_vezes'] == 10) {
    $sql = " SELECT curdate() as dataatual, 
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[0]})  DAY) AS data0,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[1]})  DAY) AS data1,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[2]})  DAY) AS data2,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[3]})  DAY) AS data3,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[4]})  DAY) AS data4,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[5]})  DAY) AS data5,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[6]})  DAY) AS data6,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[7]})  DAY) AS data7,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[8]})  DAY) AS data8,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[9]})  DAY) AS data9";
    $ver_teste = $auth_user->runQuery($sql);
    $ver_teste->execute();
    $resultado = $ver_teste->fetch(PDO::FETCH_ASSOC);
    $aDup = array(
        array($dados_empresa['empresa_numero_nfe'] . '-1', $resultado['data0'], number_format((($vNF * $percentual_oficial[0]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-2', $resultado['data1'], number_format((($vNF * $percentual_oficial[1]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-3', $resultado['data2'], number_format((($vNF * $percentual_oficial[2]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-4', $resultado['data3'], number_format((($vNF * $percentual_oficial[3]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-5', $resultado['data4'], number_format((($vNF * $percentual_oficial[4]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-6', $resultado['data5'], number_format((($vNF * $percentual_oficial[5]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-7', $resultado['data6'], number_format((($vNF * $percentual_oficial[6]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-8', $resultado['data7'], number_format((($vNF * $percentual_oficial[7]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-9', $resultado['data8'], number_format((($vNF * $percentual_oficial[8]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-10', $resultado['data9'], number_format((($vNF * $percentual_oficial[9]) / 100), 2, '.', ''))
    );
}
if ($dados_pedido['forma_pagamento_vezes'] == 11) {
    $sql = " SELECT curdate() as dataatual, 
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[0]})  DAY) AS data0,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[1]})  DAY) AS data1,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[2]})  DAY) AS data2,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[3]})  DAY) AS data3,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[4]})  DAY) AS data4,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[5]})  DAY) AS data5,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[6]})  DAY) AS data6,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[7]})  DAY) AS data7,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[8]})  DAY) AS data8,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[9]})  DAY) AS data9,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[10]})  DAY) AS data10";
    $ver_teste = $auth_user->runQuery($sql);
    $ver_teste->execute();
    $resultado = $ver_teste->fetch(PDO::FETCH_ASSOC);
    $aDup = array(
        array($dados_empresa['empresa_numero_nfe'] . '-1', $resultado['data0'], number_format((($vNF * $percentual_oficial[0]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-2', $resultado['data1'], number_format((($vNF * $percentual_oficial[1]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-3', $resultado['data2'], number_format((($vNF * $percentual_oficial[2]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-4', $resultado['data3'], number_format((($vNF * $percentual_oficial[3]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-5', $resultado['data4'], number_format((($vNF * $percentual_oficial[4]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-6', $resultado['data5'], number_format((($vNF * $percentual_oficial[5]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-7', $resultado['data6'], number_format((($vNF * $percentual_oficial[6]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-8', $resultado['data7'], number_format((($vNF * $percentual_oficial[7]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-9', $resultado['data8'], number_format((($vNF * $percentual_oficial[8]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-10', $resultado['data9'], number_format((($vNF * $percentual_oficial[9]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-11', $resultado['data10'], number_format((($vNF * $percentual_oficial[10]) / 100), 2, '.', ''))
    );
}
if ($dados_pedido['forma_pagamento_vezes'] == 12) {
    $sql = " SELECT curdate() as dataatual, 
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[0]})  DAY) AS data0,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[1]})  DAY) AS data1,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[2]})  DAY) AS data2,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[3]})  DAY) AS data3,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[4]})  DAY) AS data4,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[5]})  DAY) AS data5,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[6]})  DAY) AS data6,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[7]})  DAY) AS data7,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[8]})  DAY) AS data8,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[9]})  DAY) AS data9,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[10]})  DAY) AS data10,
    DATE_ADD(CURDATE(), INTERVAL ({$prazo_oficial[11]})  DAY) AS data11";
    $ver_teste = $auth_user->runQuery($sql);
    $ver_teste->execute();
    $resultado = $ver_teste->fetch(PDO::FETCH_ASSOC);
    $aDup = array(
        array($dados_empresa['empresa_numero_nfe'] . '-1', $resultado['data0'], number_format((($vNF * $percentual_oficial[0]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-2', $resultado['data1'], number_format((($vNF * $percentual_oficial[1]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-3', $resultado['data2'], number_format((($vNF * $percentual_oficial[2]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-4', $resultado['data3'], number_format((($vNF * $percentual_oficial[3]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-5', $resultado['data4'], number_format((($vNF * $percentual_oficial[4]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-6', $resultado['data5'], number_format((($vNF * $percentual_oficial[5]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-7', $resultado['data6'], number_format((($vNF * $percentual_oficial[6]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-8', $resultado['data7'], number_format((($vNF * $percentual_oficial[7]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-9', $resultado['data8'], number_format((($vNF * $percentual_oficial[8]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-10', $resultado['data9'], number_format((($vNF * $percentual_oficial[9]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-11', $resultado['data10'], number_format((($vNF * $percentual_oficial[10]) / 100), 2, '.', '')),
        array($dados_empresa['empresa_numero_nfe'] . '-12', $resultado['data11'], number_format((($vNF * $percentual_oficial[11]) / 100), 2, '.', ''))
    );
}


foreach ($aDup as $dup) {
    $nDup = $dup[0]; //Código da Duplicata
    $dVenc = $dup[1]; //Vencimento
    $vDup = $dup[2]; // Valor
   // $resp = $nfe->tagdup($nDup, $dVenc, $vDup);
}
