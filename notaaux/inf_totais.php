<?php
//INCIALIZAÇÃO DE VARIAVEIS NÃO DECLARADAS
$vII = isset($vII) ? $vII : 0;
$vIPI = isset($vIPI) ? $vIPI : 0;
$vIOF = isset($vIOF) ? $vIOF : 0;
$vPIS = isset($vPIS) ? $vPIS : 0;
$vCOFINS = isset($vCOFINS) ? $vCOFINS : 0;
$vICMS = isset($vICMS) ? $vICMS : 0;
$vBCST = isset($vBCST) ? $vBCST : 0;
$vST = isset($vST) ? $vST : 0;
$vISS = isset($vISS) ? $vISS : 0;

//TOTAIS

$stmt_total = $auth_user->runQuery("SELECT SUM(pedido_itens_total) FROM pedido_itens WHERE id_pedido = $pedido_id");
$stmt_total->execute();
$tot = $stmt_total->fetch(PDO::FETCH_ASSOC);


// CONTINUAR AQUI MAS TEM QUE VER COMO FAZ ISSO AQUI CERTINHO! ICMS E FAZER O CALCULO CORRETO
$vBC = $tot['SUM(pedido_itens_total)']; //'3720.00';
$vICMS = $flagICMS;
$vICMSDeson = '0.00';
$vBCST = '0.00';
$vST = '0.00';
$vProd = $tot['SUM(pedido_itens_total)'];
$vFrete = '0.00';
$vSeg = '0.00';
$vDesc = '0.00';
$vII = '0.00';
$vIPI = $flagIPI;
$vPIS = $flagPIS;
$vCOFINS = $flagCONFIS;
$vOutro = '0.00';
$vNF = number_format($vProd - $vDesc - $vICMSDeson + $vST + $vFrete + $vSeg + $vOutro + $vII + $vIPI, 2, '.', '');
$vTotTrib = number_format($vICMS + $vST + $vII + $vIPI + $vPIS + $vCOFINS + $vIOF + $vISS, 2, '.', '');
//$vTotTrib = '';
//$resp = $nfe->tagICMSTot($vBC, $vICMS, $vICMSDeson, $vBCST, $vST, $vProd, $vFrete, $vSeg, $vDesc, $vII, $vIPI, $vPIS, $vCOFINS, $vOutro, $vNF, $vTotTrib);


