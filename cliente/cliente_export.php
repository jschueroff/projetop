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

$relatorio_clientea = $auth_user->runQuery("SELECT * FROM cliente, municipio WHERE id_municipio = municipio_id AND"
        . " cliente_status = 1");
$relatorio_clientea->execute();

$relatorio_cliente = $auth_user->runQuery("SELECT * FROM cliente, municipio WHERE id_municipio = municipio_id");
$relatorio_cliente->execute();

$empresa_nome = $auth_user->runQuery("SELECT * FROM EMPRESA WHERE empresa_id = 1");
$empresa_nome->execute();
$nome_em = $empresa_nome->fetch(PDO::FETCH_ASSOC);


//$connect = mysqli_connect("localhost", "root", "root", "sistema2");
$output = '';

function mb_str_pad($input, $pad_length, $pad_string = ' ', $pad_type = STR_PAD_RIGHT, $encoding = "UTF-8") {
    $diff = strlen($input) - mb_strlen($input, $encoding);
    return substr(str_pad($input, $pad_length + $diff, $pad_string, $pad_type), 0, $pad_length + $diff);
}

if (isset($_POST["export_"])) {
    
    $modelo = $_POST['modelo'];
    
     if ($modelo == "ordenados_estado") {
         
         $relatorio_ordenados_estado = $auth_user->runQuery("SELECT * FROM cliente, municipio WHERE id_municipio = municipio_id order by municipio_sigla asc");
$relatorio_ordenados_estado->execute();

        $output .= 'RELATORIO DE CLIENTES POR ESTADOS ';
        $output .= "\r\n";
        $output .= "\r\n";
        $output .= 'EMPRESA: '.$nome_em['empresa_nome'];
        $output .= "\r\n";
        $output .= 'DATA: '.date("d/m/Y");
        $output .= "\r\n";
        $output .= 'USUARIO: '.$userRow['funcionario_nome'];
        $output .= "\r\n";
        $output .= "\r\n";
        $output .= "====================================================================================================\r\n";
        $output .= "|ID  |NOME                                      |MUNICIPIO/UF             |CNPJ/CPF     |TEF       |\r\n";
        $output .= "====================================================================================================\r\n";
       // $output .= "\r\n";
        while ($order = $relatorio_ordenados_estado->fetch(PDO::FETCH_ASSOC)) {
            $output .= '|' . mb_str_pad($order["cliente_id"], 4, ' ') . '|'
                    . '' . mb_str_pad($order["cliente_nome"], 42, ' ') . '|'
//                    . '' . mb_str_pad($clientes["cliente_email"], 20, ' ') . '|'
//                    . '' . mb_str_pad($clientes["cliente_telefone"], 11, ' ') . '|'
                   // . '' . mb_str_pad($clientes["cliente_logradouro"] . ','.$clientes["cliente_numero"].'', 20, ' ') . '|'
                    . '' . mb_str_pad($order["municipio_nome"] . ',' . $order["municipio_sigla"] . '', 25, ' ') . '|'
                    . '' . mb_str_pad($order["cliente_cpf_cnpj"] . '' . $order["cliente_cpf"] . '', 13, ' ') . '|'
                    . '' . mb_str_pad($order["cliente_telefone"] . '', 10, ' ') . '|';
                   
                    

            $output .= "\r\n";
        }
        $output .= "====================================================================================================\r\n";
        header("Content-Type: application/txt");
        header("Content-Disposition: attachment; filename=Relatorio_Clientes_Ordenados.txt");
        echo $output;
        exit();
        //  }
    }

    if ($modelo == "txt") {

        $output .= 'RELATORIO DE CLIENTES ATIVOS ';
        $output .= "\r\n";
        $output .= "\r\n";
        $output .= 'EMPRESA: '.$nome_em['empresa_nome'];
        $output .= "\r\n";
        $output .= 'DATA: '.date("d/m/Y");
        $output .= "\r\n";
        $output .= 'USUARIO: '.$userRow['funcionario_nome'];
        $output .= "\r\n";
        $output .= "\r\n";
        $output .= "====================================================================================================\r\n";
        $output .= "|ID  |NOME                                      |MUNICIPIO/UF             |CNPJ/CPF     |TEF       |\r\n";
        $output .= "====================================================================================================\r\n";
       // $output .= "\r\n";
        while ($clientes = $relatorio_clientea->fetch(PDO::FETCH_ASSOC)) {
            $output .= '|' . mb_str_pad($clientes["cliente_id"], 4, ' ') . '|'
                    . '' . mb_str_pad($clientes["cliente_nome"], 42, ' ') . '|'
//                    . '' . mb_str_pad($clientes["cliente_email"], 20, ' ') . '|'
//                    . '' . mb_str_pad($clientes["cliente_telefone"], 11, ' ') . '|'
                   // . '' . mb_str_pad($clientes["cliente_logradouro"] . ','.$clientes["cliente_numero"].'', 20, ' ') . '|'
                    . '' . mb_str_pad($clientes["municipio_nome"] . ',' . $clientes["municipio_sigla"] . '', 25, ' ') . '|'
                    . '' . mb_str_pad($clientes["cliente_cpf_cnpj"] . '' . $clientes["cliente_cpf"] . '', 13, ' ') . '|'
                    . '' . mb_str_pad($clientes["cliente_telefone"] . '', 10, ' ') . '|';
                   
                    

            $output .= "\r\n";
        }
        $output .= "====================================================================================================\r\n";
        header("Content-Type: application/txt");
        header("Content-Disposition: attachment; filename=Relatorio_Clientes_Ativos.txt");
        echo $output;
        exit();
        //  }
    }
    if ($modelo == "excel") {

        $output .= '  
              
                <table class="table" bordered="1">  
                <tr>
                <th colspan ="3">Relatório de Clientes Ativos</th>
</tr>
                     <tr>  
                          <th>Id</th>  
                          <th>Nome</th>  
                          <th>Email</th>  
                     </tr>  
           ';
        while ($clientes = $relatorio_clientea->fetch(PDO::FETCH_ASSOC)) {
            $output .= '  
                     <tr>  
                          <td>' . $clientes["cliente_id"] . '</td>  
                          <td>' . $clientes["cliente_nome"] . '</td>  
                          <td>' . $clientes["cliente_email"] . '</td>  
                     </tr>  
                ';
        }
        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=download.xls");
        echo $output;
    }
    if ($modelo == "0") {
        header("Location:cliente_relatorio.php");
    }
    if ($modelo == "txt_todos") {

       $output .= 'RELATORIO DE CLIENTES ';
        $output .= "\r\n";
        $output .= "\r\n";
        $output .= 'EMPRESA: '.$nome_em['empresa_nome'];
        $output .= "\r\n";
        $output .= 'DATA: '.date("d/m/Y");
        $output .= "\r\n";
        $output .= 'USUARIO: '.$userRow['funcionario_nome'];
        $output .= "\r\n";
        $output .= "\r\n";
        $output .= "====================================================================================================\r\n";
        $output .= "|ID  |NOME                                      |MUNICIPIO/UF             |CNPJ/CPF     |TEF       |\r\n";
        $output .= "====================================================================================================\r\n";
        while ($clien = $relatorio_cliente->fetch(PDO::FETCH_ASSOC)) {
           $output .= '|' . mb_str_pad($clien["cliente_id"], 4, ' ') . '|'
                    . '' . mb_str_pad($clien["cliente_nome"], 42, ' ') . '|'
//                    . '' . mb_str_pad($clientes["cliente_email"], 20, ' ') . '|'
//                    . '' . mb_str_pad($clientes["cliente_telefone"], 11, ' ') . '|'
                   // . '' . mb_str_pad($clientes["cliente_logradouro"] . ','.$clientes["cliente_numero"].'', 20, ' ') . '|'
                    . '' . mb_str_pad($clien["municipio_nome"] . ',' . $clien["municipio_sigla"] . '', 25, ' ') . '|'
                    . '' . mb_str_pad($clien["cliente_cpf_cnpj"] . '' . $clien["cliente_cpf"] . '', 13, ' ') . '|'
                    . '' . mb_str_pad($clien["cliente_telefone"] . '', 10, ' ') . '|';
                   
                    

            $output .= "\r\n";
        }
        $output .= "====================================================================================================\r\n";
        header("Content-Type: application/txt");
       
        header("Content-Disposition: attachment; filename=Relatorios_Clientes.txt");
        echo $output;
        exit();
        //  }
    }
}

if(isset($_POST['visualizar']))
{
   //print_r("Chegou");
    $auth_user->redirect("cliente_relatorio_estado.php");
}
if(isset($_POST['visualizar_pdf_cli_estado']))
{
   //print_r("Chegou");
    $auth_user->redirect("cliente_relatorio_estado_pdf.php");
}

?>

