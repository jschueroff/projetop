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

//RELATORIO BASICOS DAS NOTAS
if (isset($_POST["export_"])) {

    $modelo = $_POST['modelo'];

    //RELATORIO DE TODOS OS PEDIDOS 
    if ($modelo == "txt_nfe") {

        $relatorio_nfe = $auth_user->runQuery("SELECT 
        nota.nota_id as NOTA_ID,
        nota.nota_cliente as NOME,
        IF(STRCMP(nota.nota_tipo,'1'),'E','S') AS TIPO,
        nota.nota_numero_nf as NUMERO_NF,
        nota.nota_data_emissao as DATA_E,
        IF((nota.nota_status < 4),'P','E') AS STAT,
        sum(nota_itens_total) AS TOTAL
        FROM nota, nota_itens
        WHERE id_nota_id = nota_id  
        GROUP BY nota.nota_id");
        $relatorio_nfe->execute();

        $output .= 'RELATORIO NOTAS ';
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
        $output .= "|ID  |NOME CLIENTE                    |TIPO      |NUMERO NF  |DATA       |STATUS |TOTAL NF_E       |\r\n";
        $output .= "====================================================================================================\r\n";

        $flag = 1;
        $flag2 = 77;
        while ($nf_relatorio = $relatorio_nfe->fetch(PDO::FETCH_ASSOC)) {



            $output .= '|' . mb_str_pad($nf_relatorio["NOTA_ID"], 4, ' ') . '|'
                    . '' . mb_str_pad($nf_relatorio["NOME"], 32, ' ') . '|'
                    . '' . mb_str_pad($nf_relatorio["TIPO"], 10, ' ') . '|'
                    . '' . mb_str_pad($nf_relatorio["NUMERO_NF"], 11, ' ') . '|'
                    . '' . mb_str_pad($nf_relatorio["DATA_E"], 11, ' ') . '|'
                    . '' . mb_str_pad($nf_relatorio["STAT"], 7, ' ') . '|'
                    . '' . mb_str_pad($nf_relatorio["TOTAL"] . '', 17, ' ') . '|';

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
                $output .= "|ID  |NOME CLIENTE                    |NUMERO NF  |VALOR  |STATUS |QTD   |FOR. PAG.  |DATA      |\r\n";
                $output .= "====================================================================================================\r\n";
            }
            $flag++;
        }
        $output .= "====================================================================================================\r\n";

        $output .= "                                                                                                    \r\n";

        header("Content-Type: application/txt");

        header("Content-Disposition: attachment; filename=Relatorios_NFE.txt");
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

    $data_inicial = $_POST['notas_data_inicial'];

    $dataPi = explode('/', $data_inicial);
    $nota_data_inicial = $dataPi[2] . '-' . $dataPi[1] . '-' . $dataPi[0];

    $data_final = $_POST['notas_data_final'];
    $dataPf = explode('/', $data_final);
    $nota_data_final = $dataPf[2] . '-' . $dataPf[1] . '-' . $dataPf[0];

    $relatorio_data = $auth_user->runQuery("SELECT * FROM nota, cliente "
            . "WHERE identificador_cliente = cliente_id and nota_data_emissao BETWEEN '{$nota_data_inicial}' AND '{$nota_data_final}'");
    $relatorio_data->execute();

    $output .= 'RELATORIO DE NOTA/CLIENTES POR DATA';
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
    $output .= "|ID  |CLIENTE                                             |N° NFE  |STATUS |E/S  |FRETE |DATA      |\r\n";
    $output .= "====================================================================================================\r\n";

    $flag = 1;
    $flag2 = 77;
    while ($not_dat = $relatorio_data->fetch(PDO::FETCH_ASSOC)) {




        $output .= '|' . mb_str_pad($not_dat["nota_id"], 4, ' ') . '|'
                . '' . mb_str_pad($not_dat["cliente_nome"], 52, ' ') . '|'
                . '' . mb_str_pad($not_dat["nota_numero_nf"], 8, ' ') . '|'
                . '' . mb_str_pad($not_dat["nota_status"], 7, ' ') . '|'
                . '' . mb_str_pad($not_dat["nota_tipo"], 5, ' ') . '|'
                . '' . mb_str_pad($not_dat["nota_frete"], 6, ' ') . '|'
                . '' . mb_str_pad($not_dat["nota_data_emissao"] . '', 10, ' ') . '|';

        $output .= "\r\n";
        if ($flag == $flag2) {
            $flag2 = $flag2 + 76;
            $output .= "\r\n";
            $output .= 'RELATORIO DE NOTA/CLIENTES POR DATA';
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
            $output .= "|ID  |CLIENTE                                             |N° NFE  |STATUS |E/S  |FRETE |DATA      |\r\n";
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

    header("Content-Disposition: attachment; filename=Relatorios_NOTA/CLIENTE.txt");
    echo $output;
    exit();
    //  }
}
?>

