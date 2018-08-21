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

//determina o numero de registros que serão mostrados na tela
$maximo = 5;
//pega o valor da pagina atual
$pagina = isset($_GET['pagina']) ? ($_GET['pagina']) : '1';

//subtraimos 1, porque os registros sempre começam do 0 (zero), como num array
$inicio = $pagina - 1;
//multiplicamos a quantidade de registros da pagina pelo valor da pagina atual 
$inicio = $maximo * $inicio;
//fazemos um select na tabela que iremos utilizar para saber quantos registros ela possui
//$strCount = $auth_user->runQuery("SELECT COUNT(*) AS 'total_fornecedor' FROM fornecedor");
$strCount = $auth_user->runQuery("SELECT COUNT(*) AS 'total_pedido' FROM pedido, cliente, forma_pagamento where"
        . " id_cliente = cliente_id and id_forma_pagamento = forma_pagamento_id");
$strCount->execute();
//iniciamos uma var que será usada para armazenar a qtde de registros da tabela  
$total = 0;
if (count($strCount)) {
    foreach ($strCount as $row) {
        //armazeno o total de registros da tabela para fazer a paginação
        $total = $row["total_pedido"];
    }
}

$stmt = $auth_user->runQuery("SELECT * FROM pedido, cliente, forma_pagamento where"
        . " id_cliente = cliente_id and id_forma_pagamento = forma_pagamento_id ORDER BY pedido_id DESC LIMIT $inicio,$maximo");
$stmt->execute();

//ALTERA ITENS DO PEDIDO
if (isset($_POST['btn-altera'])) {

    $pedido_itens_id = strip_tags($_POST['pedido_itens_id']);
    $id_produto = strip_tags($_POST['id_produto']);
    $pedido_itens_qtd = str_replace(",", ".", strip_tags($_POST['pedido_itens_qtd']));

    $pedido_itens_valor = str_replace(",", ".", strip_tags($_POST['pedido_itens_valor']));
    $pedido_itens_total = $pedido_itens_qtd * $pedido_itens_valor;
    
    $pedido_itens_id_st = strip_tags($_POST['pedido_itens_id_st']);
    $pedido_itens_id_tes = strip_tags($_POST['pedido_itens_id_tes']);
    
    $pedido_itens_valor_frete = strip_tags($_POST['pedido_itens_valor_frete']);
    $pedido_itens_valor_seguro = strip_tags($_POST['pedido_itens_valor_seguro']);
    $pedido_itens_valor_desconto = strip_tags($_POST['pedido_itens_valor_desconto']);
    $pedido_itens_outras_despesas = strip_tags($_POST['pedido_itens_outras_despesas']);
    $pedido_itens_descricao = strip_tags($_POST['pedido_itens_descricao']);
    
    

    try {

        $result = $auth_user->runQuery('UPDATE pedido_itens SET '
                . 'id_produto  = :id_produto, '
                . 'pedido_itens_qtd = :pedido_itens_qtd, '
                . 'pedido_itens_total = :pedido_itens_total,'
                . 'pedido_itens_valor = :pedido_itens_valor,'
                . 'pedido_itens_id_st = :pedido_itens_id_st,'
                . 'pedido_itens_id_tes = :pedido_itens_id_tes,'
                . 'pedido_itens_valor_frete = :pedido_itens_valor_frete,'
                . 'pedido_itens_valor_seguro = :pedido_itens_valor_seguro,'
                . 'pedido_itens_valor_desconto = :pedido_itens_valor_desconto,'
                . 'pedido_itens_outras_despesas = :pedido_itens_outras_despesas,'
                . 'pedido_itens_descricao = :pedido_itens_descricao'
                // . 'produto_data_cadastro = :data_cadastro'
                . ' WHERE pedido_itens_id = :id');
        $result->execute(array(
            ':id' => $pedido_itens_id,
            ':id_produto' => $id_produto,
            ':pedido_itens_qtd' => $pedido_itens_qtd,
            ':pedido_itens_valor' => $pedido_itens_valor,
            ':pedido_itens_total' => $pedido_itens_total,
            ':pedido_itens_id_st' => $pedido_itens_id_st,
            ':pedido_itens_id_tes' => $pedido_itens_id_tes,
            ':pedido_itens_valor_frete' => $pedido_itens_valor_frete,
            ':pedido_itens_valor_seguro' => $pedido_itens_valor_seguro,
            ':pedido_itens_valor_desconto' => $pedido_itens_valor_desconto,
            ':pedido_itens_outras_despesas' => $pedido_itens_outras_despesas,
            ':pedido_itens_descricao' => $pedido_itens_descricao
        ));
        // $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Acao para Inativação
if (isset($_POST['btn-apaga'])) {
    $pedido_itens_id = strip_tags($_POST['pedido_itens_id']);

    try {

        $sql = "DELETE FROM pedido_itens WHERE pedido_itens_id = :pedido_itens_id";
        $stmt = $auth_user->runQuery($sql);
        $stmt->bindParam(':pedido_itens_id', $pedido_itens_id, PDO::PARAM_INT);
        $stmt->execute();
        // $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Busca de Nome Dinamica
if (isset($_POST["query"])) {
    $output = '';
    $query = $auth_user->runQuery("SELECT * FROM cliente WHERE cliente_nome LIKE '%" . strtoupper($_POST["query"]) . "%' or "
            . "cliente_cpf_cnpj LIKE '%" . $_POST["query"] . "%'");
    //$query->execute();
    $output = '<ul class="list-group">';
    if ($query->execute() > 0) {
        for ($i = 0; $row = $query->fetch(); $i++) {
            $output .= '<li class="list-group-item">' . $row["cliente_nome"] . '</li>';
        }
    } else {
        $output .= '<li>Cliente Não Encontrado</li>';
    }
    $output .= '</ul>';
    echo $output;

    unset($query);
}
// Acao para a Edicao
if (isset($_POST['btn-editar'])) {

    try {
        $pedido_id = strip_tags($_POST['pedido_id']);
        //$auth_user->buscar_funcionario($funcionario_id);
        $consulta = $auth_user->runQuery("SELECT * FROM pedido WHERE pedido_id = ?;");
        $consulta->bindParam(1, $pedido_id, PDO::PARAM_STR);
        $consulta->execute();
        $linha = $consulta->fetch(PDO::FETCH_ASSOC);
        if ($linha) {
            $auth_user->redirect("pedido_editar.php?id=" . $linha['pedido_id']);
        } else {
            echo 'Erro na Busca do ID UNIDADE';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
// Acao para a Edicao
if (isset($_POST['btn-consulta'])) {

    try {
        $pedido_id = strip_tags($_POST['pedido_id']);
        //$auth_user->buscar_funcionario($funcionario_id);
        $consulta = $auth_user->runQuery("SELECT * FROM pedido WHERE pedido_id = ?;");
        $consulta->bindParam(1, $pedido_id, PDO::PARAM_STR);
        $consulta->execute();
        $linha = $consulta->fetch(PDO::FETCH_ASSOC);
        if ($linha) {
            $auth_user->redirect("pedido_consultar.php?id=" . $linha['pedido_id']);
        } else {
            echo 'Erro na Busca do ID UNIDADE';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Botao Salvar a Edicao
if (isset($_POST['btn-salvar'])) {

    date_default_timezone_set('America/Sao_Paulo');
    $id = $_POST['pedido_id'];
    //$nome = strtoupper($_POST['cliente_nome']);
    $pedido_status = $_POST['pedido_status'];
    $id_forma_pagamento = $_POST['id_forma_pagamento'];
    $pedido_presencial = $_POST['pedido_presencial'];
    $pedido_frete = $_POST['pedido_frete'];
    $pedido_observacao = $_POST['pedido_observacao'];
    
     //Pegue a data no formato dd/mm/yyyy
    $data_old = $_POST['pedido_data_entrega'];
//Exploda a data para entrar no formato aceito pelo DB.
    $dataP = explode('/', $data_old);
    $pedido_data_entrega = $dataP[2] . '-' . $dataP[1] . '-' . $dataP[0];

    try {
        $result = $auth_user->runQuery('UPDATE pedido SET '
                . 'pedido_status  = :pedido_status,'
                . 'pedido_presencial  = :pedido_presencial,'
                . 'pedido_frete  = :pedido_frete,'
                . 'id_forma_pagamento = :id_forma_pagamento,'
                . 'pedido_data_entrega = :pedido_data_entrega,'
                . 'pedido_observacao = :pedido_observacao'
                . ' WHERE pedido_id = :id');

        $result->execute(array(
            ':id' => $id,
            ':pedido_status' => $pedido_status,
            ':pedido_presencial' => $pedido_presencial,
            ':pedido_frete' => $pedido_frete,
            ':id_forma_pagamento' => $id_forma_pagamento,
            ':pedido_data_entrega' => $pedido_data_entrega,
            ':pedido_observacao' => $pedido_observacao
        ));
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

}
//Cadastrar de Novo Pedido
if (isset($_POST['btn-cadastro_p'])) {

    date_default_timezone_set('America/Sao_Paulo');
    $data = date('Y-m-d H:i:s');

    //$data = $_POST['pedido_data'];
    $status = $_POST['pedido_status'];
    $nome_cliente = strtoupper($_POST['cliente_nome']);
    $id_forma_pagamento = $_POST['id_forma_pagamento'];
    $presencial = $_POST['pedido_presencial'];
    $frete = $_POST['pedido_frete'];
    $tipo = $_POST['pedido_tipo'];
    $pedido_observacao = $_POST['pedido_observacao'];
    //Pegue a data no formato dd/mm/yyyy
    $data_old = $_POST['pedido_data_entrega'];
//Exploda a data para entrar no formato aceito pelo DB.
    $dataP = explode('/', $data_old);
    $data_cadastro = $dataP[2] . '-' . $dataP[1] . '-' . $dataP[0];
    
 
    

    try {
        $stmt = $auth_user->runQuery("SELECT * FROM cliente WHERE"
                . " cliente_nome=:nome_cliente");
        $stmt->execute(array(":nome_cliente" => $nome_cliente));
        $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($userRow > 0) {
            $id_cliente = $userRow["cliente_id"];

            $sql2 = "INSERT INTO pedido (pedido_data, pedido_data_entrega,
                pedido_status, id_cliente, 
                id_forma_pagamento, pedido_presencial,
                pedido_frete, pedido_tipo, pedido_observacao)
             VALUES ('" . $data . "', '" . $data_cadastro . "',"
                    . "'" . $status . "', '" . $id_cliente . "', "
                    . "'" . $id_forma_pagamento . "', '" . $presencial . "',"
                    . "'" . $frete . "', '" . $tipo . "', '" . $pedido_observacao . "' )";

            $retorno = $auth_user->registro($sql2);



            $auth_user->redirect("../pedido_itens/index.php?id=" . $retorno);
        } else {
            echo 'Erro na Busca do Cliente no banco de dados ';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Botao de Pesquisa
if (isset($_POST['btn-pesquisar_p'])) {
    //$funcionario_id = strip_tags($_POST['funcionario_id']);
    $pesquisa = strtoupper($_POST['pesquisa_nome']);
    $pesquisa2 = $_POST['pesquisa_status'];
    $pesquisa3 = $_POST['pesquisa_data'];


    if ($pesquisa2 == 0) {
        try {
            $stmt = $auth_user->runQuery("SELECT * FROM pedido, cliente, forma_pagamento  WHERE id_cliente = cliente_id 
        AND id_forma_pagamento = forma_pagamento_id AND cliente_nome like :nome ORDER BY pedido_id DESC");
            $stmt->bindValue(':nome', '%' . $pesquisa . '%', PDO::PARAM_STR);
            // $stmt->bindValue(':status', '%' . $pesquisa2 . '%', PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        try {
            $stmt = $auth_user->runQuery("SELECT * FROM pedido, cliente, forma_pagamento  WHERE id_cliente = cliente_id 
        AND  id_forma_pagamento = forma_pagamento_id AND pedido_status in (" . $pesquisa2 . ") AND cliente_nome like :nome ORDER BY pedido_id DESC");
            $stmt->bindValue(':nome', '%' . $pesquisa . '%', PDO::PARAM_STR);
            // $stmt->bindValue(':status', '%' . $pesquisa2 . '%', PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    if ($pesquisa3) {

        //Pegue a data no formato dd/mm/yyyy
        $data_old = $_POST['pesquisa_data'];
        //Exploda a data para entrar no formato aceito pelo DB.
        $dataP = explode('/', $data_old);
        $data_cadastro = $dataP[2] . '-' . $dataP[1] . '-' . $dataP[0];


        try {
            $stmt = $auth_user->runQuery("SELECT * FROM pedido, cliente, forma_pagamento 
                WHERE id_cliente = cliente_id AND id_forma_pagamento = forma_pagamento_id 
                AND pedido_data like :pedido_data ORDER BY pedido_id DESC");
            $stmt->bindValue(':pedido_data', '%' . $data_cadastro . '%', PDO::PARAM_STR);
            // $stmt->bindValue(':status', '%' . $pesquisa2 . '%', PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>