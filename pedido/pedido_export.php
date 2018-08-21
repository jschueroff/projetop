<?php

require_once("../class/session.php");
require_once '../class/conexao.class.php';

require_once("../class/class.user.php");
$auth_user = new USER();

//Verificação da Sessao
$user_id = $_SESSION['user_session'];
$stmt = $auth_user->runQuery("SELECT * FROM funcionarios WHERE funcionario_id=:user_id");
$stmt->execute(array(":user_id" => $user_id));
$userRow = $stmt->fetch(PDO::FETCH_ASSOC);



$empresa_nome = $auth_user->runQuery("SELECT * FROM EMPRESA WHERE empresa_id = 1");
$empresa_nome->execute();
$nome_em = $empresa_nome->fetch(PDO::FETCH_ASSOC);




//$connect = mysqli_connect("localhost", "root", "root", "sistema2");
$output = '';

function mb_str_pad($input, $pad_length, $pad_string = ' ', $pad_type = STR_PAD_RIGHT, $encoding = "UTF-8") {
    $diff = strlen($input) - mb_strlen($input, $encoding);
    return substr(str_pad($input, $pad_length + $diff, $pad_string, $pad_type), 0, $pad_length + $diff);
}

//RELATORIO BASICOS DOS PEDIDOS
if (isset($_POST["export_"])) {

    $modelo = $_POST['modelo'];

//    if ($modelo == "ordenados_estado") {
//
//        $relatorio_ordenados_estado = $auth_user->runQuery("SELECT * FROM cliente, municipio WHERE id_municipio = municipio_id order by municipio_sigla asc");
//        $relatorio_ordenados_estado->execute();
//
//        $output .= 'RELATORIO DE CLIENTES POR ESTADOS ';
//        $output .= "\r\n";
//        $output .= "\r\n";
//        $output .= 'EMPRESA: ' . $nome_em['empresa_nome'];
//        $output .= "\r\n";
//        $output .= 'DATA: ' . date("d/m/Y");
//        $output .= "\r\n";
//        $output .= 'USUARIO: ' . $userRow['funcionario_nome'];
//        $output .= "\r\n";
//        $output .= "\r\n";
//        $output .= "====================================================================================================\r\n";
//        $output .= "|ID  |NOME                                      |MUNICIPIO/UF             |CNPJ/CPF     |TEF       |\r\n";
//        $output .= "====================================================================================================\r\n";
//        // $output .= "\r\n";
//        while ($order = $relatorio_ordenados_estado->fetch(PDO::FETCH_ASSOC)) {
//            $output .= '|' . mb_str_pad($order["cliente_id"], 4, ' ') . '|'
//                    . '' . mb_str_pad($order["cliente_nome"], 42, ' ') . '|'
////                    . '' . mb_str_pad($clientes["cliente_email"], 20, ' ') . '|'
////                    . '' . mb_str_pad($clientes["cliente_telefone"], 11, ' ') . '|'
//                    // . '' . mb_str_pad($clientes["cliente_logradouro"] . ','.$clientes["cliente_numero"].'', 20, ' ') . '|'
//                    . '' . mb_str_pad($order["municipio_nome"] . ',' . $order["municipio_sigla"] . '', 25, ' ') . '|'
//                    . '' . mb_str_pad($order["cliente_cpf_cnpj"] . '' . $order["cliente_cpf"] . '', 13, ' ') . '|'
//                    . '' . mb_str_pad($order["cliente_telefone"] . '', 10, ' ') . '|';
//
//
//
//            $output .= "\r\n";
//        }
//        $output .= "====================================================================================================\r\n";
//        header("Content-Type: application/txt");
//        header("Content-Disposition: attachment; filename=Relatorio_Clientes_Ordenados.txt");
//        echo $output;
//        exit();
//        //  }
//    }
//
//    if ($modelo == "txt") {
//
//        $output .= 'RELATORIO DE CLIENTES ATIVOS ';
//        $output .= "\r\n";
//        $output .= "\r\n";
//        $output .= 'EMPRESA: ' . $nome_em['empresa_nome'];
//        $output .= "\r\n";
//        $output .= 'DATA: ' . date("d/m/Y");
//        $output .= "\r\n";
//        $output .= 'USUARIO: ' . $userRow['funcionario_nome'];
//        $output .= "\r\n";
//        $output .= "\r\n";
//        $output .= "====================================================================================================\r\n";
//        $output .= "|ID  |NOME                                      |MUNICIPIO/UF             |CNPJ/CPF     |TEF       |\r\n";
//        $output .= "====================================================================================================\r\n";
//        // $output .= "\r\n";
//        while ($clientes = $relatorio_clientea->fetch(PDO::FETCH_ASSOC)) {
//            $output .= '|' . mb_str_pad($clientes["cliente_id"], 4, ' ') . '|'
//                    . '' . mb_str_pad($clientes["cliente_nome"], 42, ' ') . '|'
////                    . '' . mb_str_pad($clientes["cliente_email"], 20, ' ') . '|'
////                    . '' . mb_str_pad($clientes["cliente_telefone"], 11, ' ') . '|'
//                    // . '' . mb_str_pad($clientes["cliente_logradouro"] . ','.$clientes["cliente_numero"].'', 20, ' ') . '|'
//                    . '' . mb_str_pad($clientes["municipio_nome"] . ',' . $clientes["municipio_sigla"] . '', 25, ' ') . '|'
//                    . '' . mb_str_pad($clientes["cliente_cpf_cnpj"] . '' . $clientes["cliente_cpf"] . '', 13, ' ') . '|'
//                    . '' . mb_str_pad($clientes["cliente_telefone"] . '', 10, ' ') . '|';
//
//
//
//            $output .= "\r\n";
//        }
//        $output .= "====================================================================================================\r\n";
//        header("Content-Type: application/txt");
//        header("Content-Disposition: attachment; filename=Relatorio_Clientes_Ativos.txt");
//        echo $output;
//        exit();
//        //  }
//    }
//    if ($modelo == "excel") {
//
//        $output .= '  
//              
//                <table class="table" bordered="1">  
//                <tr>
//                <th colspan ="3">Relatório de Clientes Ativos</th>
//</tr>
//                     <tr>  
//                          <th>Id</th>  
//                          <th>Nome</th>  
//                          <th>Email</th>  
//                     </tr>  
//           ';
//        while ($clientes = $relatorio_clientea->fetch(PDO::FETCH_ASSOC)) {
//            $output .= '  
//                     <tr>  
//                          <td>' . $clientes["cliente_id"] . '</td>  
//                          <td>' . $clientes["cliente_nome"] . '</td>  
//                          <td>' . $clientes["cliente_email"] . '</td>  
//                     </tr>  
//                ';
//        }
//        $output .= '</table>';
//        header("Content-Type: application/xls");
//        header("Content-Disposition: attachment; filename=download.xls");
//        echo $output;
//    }
//    if ($modelo == "0") {
//        header("Location:cliente_relatorio.php");
//    }
    //RELATORIO DE TODOS OS PEDIDOS 
    if ($modelo == "txt_todos") {

        $relatorio_pedido = $auth_user->runQuery("SELECT 
        cliente.cliente_nome as NOME,
        pedido.pedido_id as ID_PEDIDO,
        sum(pedido_itens_total) AS Total,
        sum(pedido_itens_qtd) AS QTD,
        forma_pagamento.forma_pagamento_nome as Forma,
        pedido.pedido_numero_nf as NF,
        pedido.pedido_data as DATA_E,
        pedido.pedido_status as statu

        FROM pedido, pedido_itens, cliente, forma_pagamento 
        WHERE id_pedido = pedido_id  and 
        id_cliente = cliente_id and 
        id_forma_pagamento = forma_pagamento_id
        GROUP BY pedido.pedido_id");
        $relatorio_pedido->execute();

        $media = $auth_user->runQuery("SELECT 
        count(pedido_id) as Total_PEDIDO,
        sum(pedido_itens_total) as Total,
        avg(pedido_itens_total) as Media

        FROM pedido, pedido_itens, cliente, forma_pagamento WHERE
        id_pedido = pedido_id  and
        id_cliente = cliente_id and
        id_forma_pagamento = forma_pagamento_id GROUP BY pedido.pedido_id");
        $media->execute();
        $media_geral = $media->fetch(PDO::FETCH_ASSOC);


        $output .= 'RELATORIO DE PEDIDOS ';
        $output .= "\r\n";
        $output .= "\r\n";
        $output .= 'EMPRESA: ' . $nome_em['empresa_nome'];
        $output .= "\r\n";
        $output .= 'DATA: ' . date("d/m/Y");
        $output .= "\r\n";
        $output .= 'USUARIO: ' . $userRow['funcionario_nome'];
        $output .= "\r\n";
        $output .= "\r\n";
        $output .= "====================================================================================================\r\n";
        $output .= "|ID  |NOME CLIENTE                    |VALOR     |NUMERO NF  |STATUS |QTD   |FOR. PAG.  |DATA      |\r\n";
        $output .= "====================================================================================================\r\n";

        $flag = 1;
        $flag2 = 77;
        while ($ped = $relatorio_pedido->fetch(PDO::FETCH_ASSOC)) {

            if ($ped["statu"] == 4) {
                $stat = "E";
            } else {
                $stat = "L/P";
            }


            $output .= '|' . mb_str_pad($ped["ID_PEDIDO"], 4, ' ') . '|'
                    . '' . mb_str_pad($ped["NOME"], 32, ' ') . '|'
                    . '' . mb_str_pad($ped["Total"], 10, ' ') . '|'
//                    . '' . mb_str_pad($clientes["cliente_email"], 20, ' ') . '|'
//                    . '' . mb_str_pad($clientes["cliente_telefone"], 11, ' ') . '|'
                    // . '' . mb_str_pad($clientes["cliente_logradouro"] . ','.$clientes["cliente_numero"].'', 20, ' ') . '|'
                    . '' . mb_str_pad($ped["NF"], 11, ' ') . '|'
                    . '' . mb_str_pad($stat, 7, ' ') . '|'
                    . '' . mb_str_pad($ped['QTD'], 6, ' ') . '|'
                    . '' . mb_str_pad($ped["Forma"], 11, ' ') . '|'
                    . '' . mb_str_pad($ped["DATA_E"] . '', 10, ' ') . '|';

            $output .= "\r\n";
            if ($flag == $flag2) {
                $flag2 = $flag2 + 76;
                $output .= "\r\n";
                $output .= 'RELATORIO DE PEDIDOS ';
                $output .= "\r\n";
                $output .= "\r\n";
                $output .= 'EMPRESA: ' . $nome_em['empresa_nome'];
                $output .= "\r\n";
                $output .= 'DATA: ' . date("d/m/Y");
                $output .= "\r\n";
                $output .= 'USUARIO: ' . $userRow['funcionario_nome'];
                $output .= "\r\n";
                $output .= "\r\n";
                $output .= "====================================================================================================\r\n";
                $output .= "|ID  |NOME CLIENTE                    |VALOR     |NUMERO NF  |STATUS |QTD   |FOR. PAG.  |DATA      |\r\n";
                $output .= "====================================================================================================\r\n";
            }
            $flag++;
        }
        $output .= "====================================================================================================\r\n";

        $output .= "                                                                                                    \r\n";

        $output .= "QUANTIDADE DE PEDIDOS   :" . $media_geral['Total_PEDIDO'] . "                                               \r\n";
        $output .= "VALOR TOTAL DOS PEDIDOS :" . $media_geral['Total'] . "                                                      \r\n";
        $output .= "MEDIA DOS PEDIDOS       :" . $media_geral['Media'] . "                                                      \r\n";



        header("Content-Type: application/txt");

        header("Content-Disposition: attachment; filename=Relatorios_Pedidos.txt");
        echo $output;
        exit();
        //  }
    }
    //RELATORIO COM QTD DE PEDIDO/CLIENTE
    if ($modelo == "txt_qtd_cli") {

        $relatorio_pedido_cliente = $auth_user->runQuery("SELECT 
        cliente.cliente_id AS ID,
        cliente.cliente_nome AS NOME,
        cliente.cliente_cpf_cnpj as CPFCNPJ,
        COUNT(*) AS QTD
        FROM pedido, cliente WHERE id_cliente = cliente_id 
        GROUP BY cliente.cliente_nome
        ORDER BY COUNT(*) DESC");
        $relatorio_pedido_cliente->execute();




        $output .= 'RELATORIO DE CLIENTES/PEDIDOS ';
        $output .= "\r\n";
        $output .= "\r\n";
        $output .= 'EMPRESA: ' . $nome_em['empresa_nome'];
        $output .= "\r\n";
        $output .= 'DATA: ' . date("d/m/Y");
        $output .= "\r\n";
        $output .= 'USUARIO: ' . $userRow['funcionario_nome'];
        $output .= "\r\n";
        $output .= "\r\n";
        $output .= "====================================================================================================\r\n";
        $output .= "|ID  |CLIENTE                                             |CNPJ/CPF                     |QTD       |\r\n";
        $output .= "====================================================================================================\r\n";

        $flag = 1;
        $flag2 = 77;
        while ($ped_cli = $relatorio_pedido_cliente->fetch(PDO::FETCH_ASSOC)) {




            $output .= '|' . mb_str_pad($ped_cli["ID"], 4, ' ') . '|'
                    . '' . mb_str_pad($ped_cli["NOME"], 52, ' ') . '|'
                    . '' . mb_str_pad($ped_cli["CPFCNPJ"], 29, ' ') . '|'
//                 
                    . '' . mb_str_pad($ped_cli["QTD"] . '', 10, ' ') . '|';

            $output .= "\r\n";
            if ($flag == $flag2) {
                $flag2 = $flag2 + 76;
                $output .= "\r\n";
                $output .= 'RELATORIO DE PEDIDOS/CLIENTES ';
                $output .= "\r\n";
                $output .= "\r\n";
                $output .= 'EMPRESA: ' . $nome_em['empresa_nome'];
                $output .= "\r\n";
                $output .= 'DATA: ' . date("d/m/Y");
                $output .= "\r\n";
                $output .= 'USUARIO: ' . $userRow['funcionario_nome'];
                $output .= "\r\n";
                $output .= "\r\n";
                $output .= "====================================================================================================\r\n";
                $output .= "|ID  |CLIENTE                                             |CNPJ/CPF                     |QTD       |\r\n";
                $output .= "====================================================================================================\r\n";
            }
            $flag++;
        }
        $output .= "====================================================================================================\r\n";

        $output .= "                                                                                                    \r\n";

//        $output .= "QUANTIDADE DE PEDIDOS   :" . $media_geral['Total_PEDIDO'] . "                                               \r\n";
//        $output .= "VALOR TOTAL DOS PEDIDOS :" . $media_geral['Total'] . "                                                      \r\n";
//        $output .= "MEDIA DOS PEDIDOS       :" . $media_geral['Media'] . "                                                      \r\n";



        header("Content-Type: application/txt");

        header("Content-Disposition: attachment; filename=Relatorios_PedidosClientes.txt");
        echo $output;
        exit();
        //  }
    }
}
//RELATORIOS DE PEDIDOS PELAS DATAS
if (isset($_POST["export_data"])) {

    $data_inicial = $_POST['pedido_data_inicial'];

    $dataPi = explode('/', $data_inicial);
    $pedido_data_inicial = $dataPi[2] . '-' . $dataPi[1] . '-' . $dataPi[0];

    $data_final = $_POST['pedido_data_final'];
    $dataPf = explode('/', $data_final);
    $pedido_data_final = $dataPf[2] . '-' . $dataPf[1] . '-' . $dataPf[0];

    $relatorio_data = $auth_user->runQuery("SELECT * FROM pedido, cliente
    WHERE id_cliente = cliente_id and pedido_data BETWEEN '{$pedido_data_inicial}' AND '{$pedido_data_final}'");
    $relatorio_data->execute();

    $output .= 'RELATORIO DE CLIENTES/PEDIDOS ';
    $output .= "\r\n";
    $output .= "\r\n";
    $output .= 'EMPRESA: ' . $nome_em['empresa_nome'];
    $output .= "\r\n";
    $output .= 'DATA: ' . date("d/m/Y");
    $output .= "\r\n";
    $output .= 'USUARIO: ' . $userRow['funcionario_nome'];
    $output .= "\r\n";
    $output .= "\r\n";
    $output .= "====================================================================================================\r\n";
    $output .= "|ID  |CLIENTE                                             |CNPJ/CPF                     |QTD       |\r\n";
    $output .= "====================================================================================================\r\n";

    $flag = 1;
    $flag2 = 77;
    while ($ped_dat = $relatorio_data->fetch(PDO::FETCH_ASSOC)) {




        $output .= '|' . mb_str_pad($ped_dat["pedido_id"], 4, ' ') . '|'
                . '' . mb_str_pad($ped_dat["cliente_nome"], 52, ' ') . '|'
                . '' . mb_str_pad($ped_dat["cliente_cpf_cnpj"], 29, ' ') . '|'
                . '' . mb_str_pad($ped_dat["cliente_telefone"] . '', 10, ' ') . '|';

        $output .= "\r\n";
        if ($flag == $flag2) {
            $flag2 = $flag2 + 76;
            $output .= "\r\n";
            $output .= 'RELATORIO DE PEDIDOS/CLIENTES ';
            $output .= "\r\n";
            $output .= "\r\n";
            $output .= 'EMPRESA: ' . $nome_em['empresa_nome'];
            $output .= "\r\n";
            $output .= 'DATA: ' . date("d/m/Y");
            $output .= "\r\n";
            $output .= 'USUARIO: ' . $userRow['funcionario_nome'];
            $output .= "\r\n";
            $output .= "\r\n";
            $output .= "====================================================================================================\r\n";
            $output .= "|ID  |CLIENTE                                             |CNPJ/CPF                     |QTD       |\r\n";
            $output .= "====================================================================================================\r\n";
        }
        $flag++;
    }
    $output .= "====================================================================================================\r\n";

    $output .= "                                                                                                    \r\n";

//        $output .= "QUANTIDADE DE PEDIDOS   :" . $media_geral['Total_PEDIDO'] . "                                               \r\n";
//        $output .= "VALOR TOTAL DOS PEDIDOS :" . $media_geral['Total'] . "                                                      \r\n";
//        $output .= "MEDIA DOS PEDIDOS       :" . $media_geral['Media'] . "                                                      \r\n";



    header("Content-Type: application/txt");

    header("Content-Disposition: attachment; filename=Relatorios_PedidosClientes.txt");
    echo $output;
    exit();
    //  }
}
?>

