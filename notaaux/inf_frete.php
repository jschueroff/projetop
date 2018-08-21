<?php


    $modFrete = $dados_pedido['pedido_frete']; //0=Por conta do emitente; 1=Por conta do destinatário/remetente; 2=Por conta de terceiros; 9=Sem Frete;
   // $resp = $nfe->tagtransp($modFrete);


    if ($id_transportador != 0) 
        {

        $stmt_transportador = $auth_user->runQuery("SELECT * FROM transportador WHERE "
                . "transportador_id = :transportador_id");
        $stmt_transportador->execute(array(":transportador_id" => $id_transportador));
        $transp = $stmt_transportador->fetch(PDO::FETCH_ASSOC);

        $CNPJ = $transp['transportador_cnpj'];
        $CPF = $transp['transportador_cpf'];
        $xNome = $transp['transportador_nome'];
        $IE = $transp['transportador_ie'];
        $xEnder = $transp['transportador_logradouro'];
        $xMun = $transp['transportador_municipio'];
        $UF = $transp['transportador_uf'];
       // $resp = $nfe->tagtransporta($CNPJ, $CPF, $xNome, $IE, $xEnder, $xMun, $UF);

//VALORES RETIDOS PARA O TRANSPORTE
//        
//        $vServ = '258,69'; //Valor do Serviço
//        $vBCRet = '258,69'; //BC da Retenção do ICMS
//        $pICMSRet = '10,00'; //Alíquota da Retenção
//        $vICMSRet = '25,87'; //Valor do ICMS Retido
//        $CFOP = '5352';
//        $cMunFG = '3509502'; //Código do município de ocorrência do fato gerador do ICMS do transporte
//        $resp = $nfe->tagretTransp($vServ, $vBCRet, $pICMSRet, $vICMSRet, $CFOP, $cMunFG);
        //dados dos veiculos de transporte
//$placa = 'AAA1212';
//$UF = 'SP';
//$RNTC = '12345678';
//$resp = $nfe->tagveicTransp($placa, $UF, $RNTC);
//dados dos reboques
//$aReboque = array(
//    array('ZZQ9999', 'SP', '', '', ''),
//    array('QZQ2323', 'SP', '', '', '')
//);
//foreach ($aReboque as $reb) {
//    $placa = $reb[0];
//    $UF = $reb[1];
//    $RNTC = $reb[2];
//    $vagao = $reb[3];
//    $balsa = $reb[4];
//    //$resp = $nfe->tagreboque($placa, $UF, $RNTC, $vagao, $balsa);
//}
//Dados dos Volumes Transportados
        /* $aVol = array(
          array('4', 'Barris', '', '', '120.000', '120.000', ''),
          array('2', 'Volume', '', '', '10.000', '10.000', '')
          );
          foreach ($aVol as $vol) {
          $qVol = $vol[0]; //Quantidade de volumes transportados
          $esp = $vol[1]; //Espécie dos volumes transportados
          $marca = $vol[2]; //Marca dos volumes transportados
          $nVol = $vol[3]; //Numeração dos volume
          $pesoL = intval($vol[4]); //Kg do tipo Int, mesmo que no manual diz que pode ter 3 digitos verificador...
          $pesoB = intval($vol[5]); //...se colocar Float não vai passar na expressão regular do Schema. =\
          $aLacres = $vol[6];
          $resp = $nfe->tagvol($qVol, $esp, $marca, $nVol, $pesoL, $pesoB, $aLacres);
          }
         */
    } 
    else {
        $transp['transportador_nome'] = '';
        $transp['transportador_cnpj'] = '';
        $transp['transportador_ie'] = '';
        $transp['transportador_logradouro'] = '';
        $transp['transportador_municipio'] = '';
        $transp['transportador_uf'] = '';
    }
