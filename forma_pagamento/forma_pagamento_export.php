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

$relatorio_clientea = $auth_user->runQuery("SELECT * FROM forma_pagamento WHERE forma_pagamento_status = 1");
$relatorio_clientea->execute();

$relatorio_cliente = $auth_user->runQuery("SELECT * FROM forma_pagamento");
$relatorio_cliente->execute();


//$connect = mysqli_connect("localhost", "root", "root", "sistema2");
$output = '';

function mb_str_pad($input, $pad_length, $pad_string = ' ', $pad_type = STR_PAD_RIGHT, $encoding = "UTF-8") {
    $diff = strlen($input) - mb_strlen($input, $encoding);
    return substr(str_pad($input, $pad_length + $diff, $pad_string, $pad_type), 0, $pad_length + $diff);
}



if (isset($_POST["export_"])) {

    $modelo = $_POST['modelo'];
    

    if ($modelo == "txt") {

        $output .= 'RELATORIO DE FORMA DE PAGAMENTOS ATIVOS                                                EMPRESA TESTE';
        $output .= "\r\n";
        $output .= 'DATA                                                                                  '.date("d/m/Y");
        $output .= "\r\n";
        $output .= 'USUARIO                                                                   '.$userRow['funcionario_nome'];
        $output .= "\r\n";
        $output .= "======================================================================================================\r\n";
        $output .= "ID |NOME                                  |VEZES               |FORMA PAG.           |STATUS         |";
        $output .= "======================================================================================================\r\n";
       // $output .= "\r\n";
        while ($clientes = $relatorio_clientea->fetch(PDO::FETCH_ASSOC)) {
            $output .= '' . mb_str_pad($clientes["forma_pagamento_id"], 3, ' ') . '|'
                    . '' . mb_str_pad($clientes["forma_pagamento_nome"], 38, ' ') . '|'
                    . '' . mb_str_pad($clientes["forma_pagamento_vezes"], 20, ' ') . '|'
                    . '' . mb_str_pad($clientes["forma_pagamento_prazo_pag"], 21, ' ') . '|'
                    . '' . mb_str_pad($clientes["forma_pagamento_status"], 15, ' ') . '|';
                   
                    

            $output .= "\r\n";
        }
         $output .= "======================================================================================================\r\n";
        header("Content-Type: application/txt");
        header("Content-Disposition: attachment; filename=download.txt");
        echo $output;
        exit();
        //  }
    }
    if ($modelo == "excel") {

        $output .= '  
              
                <table class="table" bordered="1">  
                <tr>
                <th colspan ="3">Relatório de Forma de Pagamento</th>
</tr>
                     <tr>  
                          <th>Id</th>  
                          <th>Nome</th>  
                          <th>Vezes</th>  
                          <th>Prazo Pag</th>  
                          <th>Status</th>  
                     </tr>  
           ';
        while ($clientes = $relatorio_clientea->fetch(PDO::FETCH_ASSOC)) {
            $output .= '  
                     <tr>  
                          <td>' . $clientes["forma_pagamento_id"] . '</td>  
                          <td>' . $clientes["forma_pagamento_nome"] . '</td>  
                          <td>' . $clientes["forma_pagamento_vezes"] . '</td>  
                          <td>' . $clientes["forma_pagamento_prazo_pag"] . '</td>  
                          <td>' . $clientes["forma_pagamento_status"] . '</td>  
                     </tr>  
                ';
        }
        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=download.xls");
        echo $output;
    }
    if ($modelo == "0") {
        header("Location:forma_pagamento_relatorio.php");
    }
    if ($modelo == "txt_todos") {

       $output .= 'RELATORIO DE FORMA DE PAGAMENTOS                                                 EMPRESA TESTE';
        $output .= "\r\n";
        $output .= 'DATA                                                                                  '.date("d/m/Y");
        $output .= "\r\n";
        $output .= 'USUARIO                                                                   '.$userRow['funcionario_nome'];
        $output .= "\r\n";
        $output .= "======================================================================================================\r\n";
        $output .= "ID |NOME                                  |VEZES               |FORMA PAG.           |STATUS         |";
        $output .= "======================================================================================================\r\n";
       // $output .= "\r\n";
        while ($clien = $relatorio_cliente->fetch(PDO::FETCH_ASSOC)) {
            $output .= '' . mb_str_pad($clien["forma_pagamento_id"], 3, ' ') . '|'
                    . '' . mb_str_pad($clien["forma_pagamento_nome"], 38, ' ') . '|'
                    . '' . mb_str_pad($clien["forma_pagamento_vezes"], 20, ' ') . '|'
                    . '' . mb_str_pad($clien["forma_pagamento_prazo_pag"], 21, ' ') . '|'
                    . '' . mb_str_pad($clien["forma_pagamento_status"], 15, ' ') . '|';
                   
                    

            $output .= "\r\n";
        }
         $output .= "======================================================================================================\r\n";
        header("Content-Type: application/txt");
        header("Content-Disposition: attachment; filename=download.txt");
        echo $output;
        exit();
        //  }
    }
}
?>

