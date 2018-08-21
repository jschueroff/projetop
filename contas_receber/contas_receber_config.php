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

$stmt = $auth_user->runQuery("SELECT * FROM contas_receber, cliente WHERE cliente_id = id_cliente ORDER BY contas_receber_id DESC");
$stmt->execute();

//=================>CONTAS A RECEBER<=========================
// ACAO PARA EDITAR
if (isset($_POST['btn-editar'])) {

    try {
        $contas_receber_id = strip_tags($_POST['contas_receber_id']);
        //$auth_user->buscar_funcionario($funcionario_id);
        $consulta = $auth_user->runQuery("SELECT * FROM contas_receber WHERE contas_receber_id = ?;");
        $consulta->bindParam(1, $contas_receber_id, PDO::PARAM_STR);
        $consulta->execute();
        $linha = $consulta->fetch(PDO::FETCH_ASSOC);
        if ($linha) {
            $auth_user->redirect("contas_receber_editar.php?id=" . $linha['contas_receber_id']);
        } else {
            echo 'Erro na Busca do ID Contas a Receber';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//ACAO PARA EXCLUIR O CONTAS A RECEBER DA TABELA CONTAS_RECEBER
if (isset($_POST['btn-excluir'])) {

    $contas_receber_id = strip_tags($_POST['contas_receber_id']);

    try {
        $sql = "DELETE FROM contas_receber WHERE contas_receber_id =  :contas_receber_id";
        $stmt = $auth_user->runQuery($sql);
        $stmt->bindParam(':contas_receber_id', $contas_receber_id, PDO::PARAM_INT);
        $stmt->execute();
        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//SALVAR NO BANCO QUANDO EDITADO O CONTAS A RECEBER
if (isset($_POST['btn-salvar'])) {

    $contas_receber_id = $_POST['contas_receber_id'];
    $contas_receber_valor = $_POST['contas_receber_valor'];
    $contas_receber_valor = str_replace(",", ".", $contas_receber_valor);
    $contas_receber_numero = $_POST['contas_receber_numero'];
    $contas_receber_juros = $_POST['contas_receber_juros'];
    $contas_receber_juros = str_replace(",", ".", $contas_receber_juros);
    $contas_receber_obs = strtoupper($_POST['contas_receber_obs']);
    //TRANSFORMAR A DATA PARA O FORMATO DO BANCO DE DADOS
    $data_old = $_POST['contas_receber_data'];

    $dataP = explode('/', $data_old);
    $contas_receber_data = $dataP[2] . '-' . $dataP[1] . '-' . $dataP[0];

    $data_old1 = $_POST['contas_receber_vencimento'];
//Exploda a data para entrar no formato aceito pelo DB.
    $dataP1 = explode('/', $data_old1);
    $contas_receber_vencimento = $dataP1[2] . '-' . $dataP1[1] . '-' . $dataP1[0];



    try {

        $result = $auth_user->runQuery('UPDATE contas_receber SET '
                . 'contas_receber_valor  = :contas_receber_valor, '
                . 'contas_receber_numero = :contas_receber_numero, '
                . 'contas_receber_data = :contas_receber_data, '
                . 'contas_receber_vencimento = :contas_receber_vencimento, '
                . 'contas_receber_juros = :contas_receber_juros, '
                . 'contas_receber_obs = :contas_receber_obs '
                . ' WHERE contas_receber_id = :contas_receber_id');
        $result->execute(array(
            ':contas_receber_id' => $contas_receber_id,
            ':contas_receber_valor' => $contas_receber_valor,
            ':contas_receber_numero' => $contas_receber_numero,
            ':contas_receber_data' => $contas_receber_data,
            ':contas_receber_vencimento' => $contas_receber_vencimento,
            ':contas_receber_juros' => $contas_receber_juros,
            ':contas_receber_obs' => $contas_receber_obs
        ));
        
         //BUSCA DADOS DO BANCO PARA VERIFICAR SE O RECEBIMENTO ESTA DE ACORDO COM O CONTAS A RECEBER
        $stmt_calculo = $auth_user->runQuery("select sum(recebimento_valor), contas_receber_valor from 
            contas_receber, recebimento where contas_receber_id = id_contas_receber AND contas_receber_id =:contas_receber_id");
        $stmt_calculo->bindparam(":contas_receber_id", $contas_receber_id);
        $stmt_calculo->execute();
        $valor = $stmt_calculo->fetch(PDO::FETCH_ASSOC);



        if ($valor['sum(recebimento_valor)'] >= $valor['contas_receber_valor']) {
            //ATUALIZA O STATUS DO CONTAS A RECEBER RECEBIMENTO TOTAL
            $status = 2;
            $result = $auth_user->runQuery('UPDATE contas_receber SET '
                    . 'contas_receber_status  = :contas_receber_status, '
                    . 'contas_receber_saldo  = :contas_receber_saldo '
                    . ' WHERE contas_receber_id = :contas_receber_id');
            $result->execute(array(
                ':contas_receber_id' => $contas_receber_id,
                ':contas_receber_status' => $status,
                ':contas_receber_saldo' => $valor['sum(recebimento_valor)']
            ));
        }
        if ($valor['sum(recebimento_valor)'] < $valor['contas_receber_valor']) {
            //ATUALIZA O STATUS DO CONTAS A RECEBER RECEBIMENTO PARCIAL
            $status = 1;
            $result = $auth_user->runQuery('UPDATE contas_receber SET '
                    . 'contas_receber_status  = :contas_receber_status, '
                    . 'contas_receber_saldo  = :contas_receber_saldo '
                    . ' WHERE contas_receber_id = :contas_receber_id');
            $result->execute(array(
                ':contas_receber_id' => $contas_receber_id,
                ':contas_receber_status' => $status,
                ':contas_receber_saldo' => $valor['sum(recebimento_valor)']
            ));
        }
        
        
        

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//CADASTRAR CONTAS A RECEBER 
if (isset($_POST['btn-cadastro'])) {

    $numero = $_POST['contas_receber_numero'];
    $valor = $_POST['contas_receber_valor'];

    try {
        $stmt = $auth_user->runQuery("INSERT INTO contas_receber
            (contas_receber_numero,contas_receber_valor)
            VALUES(:numero, :valor)");
        $stmt->bindparam(":numero", $numero);
        $stmt->bindparam(":valor", $valor);

        $stmt->execute();

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//PESQUISAR CONTAS A RECEBER 
if (isset($_POST['btn-pesquisar'])) {
    //$funcionario_id = strip_tags($_POST['funcionario_id']);
    //$pesquisa = $_POST['contas_receber_pesquisa'];
    //$pesquisa2 = $_POST['contas_receber_pesquisa'];
    $pesquisa_cliente = $_POST['contas_receber_pesquisa'];
    $pesquisa_nota = $_POST['contas_receber_pesquisa2'];


    try {

        if (isset($pesquisa_cliente) && isset($pesquisa_nota)) {
            $stmt = $auth_user->runQuery("SELECT * FROM contas_receber, cliente WHERE id_cliente = cliente_id "
                    . "AND cliente_nome LIKE :cliente_nome AND id_nota LIKE :id_nota ORDER BY contas_receber_id DESC");
            $stmt->bindValue(':cliente_nome', '%' . $pesquisa_cliente . '%', PDO::PARAM_STR);
            $stmt->bindValue(':id_nota', '%' . $pesquisa_nota . '%', PDO::PARAM_STR);
            $stmt->execute();
            // $pequi1 = $stmt->fetch(PDO::FETCH_ASSOC);   
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//============>RECEBIMENTOS<=============
//REDIRECIONA PARA A PAGINA DO RECEBIMENTO DA CONTA ESPECIFICA
if (isset($_POST['btn-recebimento'])) {

    $id_contas_receber = $_POST['contas_receber_id'];
    $contas_receber_numero = $_POST['contas_receber_numero'];
    $auth_user->redirect("contas_receber_recebimento.php?id=$id_contas_receber");
}
//CADASTRA UM NOVO RECEBIMENTO
if (isset($_POST['btn-novo-recebimento'])) {

    $id_contas_receber = $_POST['contas_receber_id'];
    $data_old = $_POST['recebimento_data_pagamento'];
    //TRANSFORMA PARA O PADRAO DE DATA DO BANCO DE DADOS
    $dataP = explode('/', $data_old);
    $recebimento_data_pagamento = $dataP[2] . '-' . $dataP[1] . '-' . $dataP[0];

    $recebimento_valor = $_POST['recebimento_valor'];
    $recebimento_valor = str_replace(",", ".", $recebimento_valor);
    $recebimento_forma = strtoupper($_POST['recebimento_forma']);
    $recebimento_obs = strtoupper($_POST['recebimento_obs']);
    $recebimento_desconto = $_POST['recebimento_desconto'];
    $recebimento_desconto = str_replace(",", ".", $recebimento_desconto);

    try {
        // INSERE UM NOVO RECEBIMENTO
        $stmt_rece = $auth_user->runQuery("INSERT INTO recebimento
            (id_contas_receber, recebimento_data_pagamento, recebimento_valor, recebimento_forma, 
            recebimento_obs, recebimento_desconto)
            VALUES(:id_contas_receber, :recebimento_data_pagamento,:recebimento_valor, :recebimento_forma,
            :recebimento_obs, :recebimento_desconto)");

        $stmt_rece->bindparam(":id_contas_receber", $id_contas_receber);
        $stmt_rece->bindparam(":recebimento_data_pagamento", $recebimento_data_pagamento);
        $stmt_rece->bindparam(":recebimento_valor", $recebimento_valor);
        $stmt_rece->bindparam(":recebimento_forma", $recebimento_forma);
        $stmt_rece->bindparam(":recebimento_obs", $recebimento_obs);
        $stmt_rece->bindparam(":recebimento_desconto", $recebimento_desconto);
        $stmt_rece->execute();

        //BUSCA DADOS DO BANCO PARA VERIFICAR SE O RECEBIMENTO ESTA DE ACORDO COM O CONTAS A RECEBER
        $stmt_calculo = $auth_user->runQuery("select sum(recebimento_valor), contas_receber_valor from 
            contas_receber, recebimento where contas_receber_id = id_contas_receber AND id_contas_receber =:id_contas_receber");
        $stmt_calculo->bindparam(":id_contas_receber", $id_contas_receber);
        $stmt_calculo->execute();
        $valor = $stmt_calculo->fetch(PDO::FETCH_ASSOC);



        if ($valor['sum(recebimento_valor)'] >= $valor['contas_receber_valor']) {
            //ATUALIZA O STATUS DO CONTAS A RECEBER RECEBIMENTO TOTAL
            $status = 2;
            $result = $auth_user->runQuery('UPDATE contas_receber SET '
                    . 'contas_receber_status  = :contas_receber_status, '
                    . 'contas_receber_saldo  = :contas_receber_saldo '
                    . ' WHERE contas_receber_id = :contas_receber_id');
            $result->execute(array(
                ':contas_receber_id' => $id_contas_receber,
                ':contas_receber_status' => $status,
                ':contas_receber_saldo' => $valor['sum(recebimento_valor)']
            ));
        }
        if ($valor['sum(recebimento_valor)'] < $valor['contas_receber_valor']) {
            //ATUALIZA O STATUS DO CONTAS A RECEBER RECEBIMENTO PARCIAL
            $status = 1;
            $result = $auth_user->runQuery('UPDATE contas_receber SET '
                    . 'contas_receber_status  = :contas_receber_status, '
                    . 'contas_receber_saldo  = :contas_receber_saldo '
                    . ' WHERE contas_receber_id = :contas_receber_id');
            $result->execute(array(
                ':contas_receber_id' => $id_contas_receber,
                ':contas_receber_status' => $status,
                ':contas_receber_saldo' => $valor['sum(recebimento_valor)']
            ));
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//SALVAR NO BANCO QUANDO EDITADO O RECEBIMENTO
if (isset($_POST['btn-salvar-recebimento'])) {

    $recebimento_id = $_POST['recebimento_id'];
    $id_contas_receber = $_POST['id_contas_receber'];
    $data_old = $_POST['recebimento_data_pagamento'];
    $dataP = explode('/', $data_old);
    $recebimento_data_pagamento = $dataP[2] . '-' . $dataP[1] . '-' . $dataP[0];
    $recebimento_valor = $_POST['recebimento_valor'];
    $recebimento_valor = str_replace(",", ".", $recebimento_valor);
    $recebimento_forma = strtoupper($_POST['recebimento_forma']);
    $recebimento_obs = strtoupper($_POST['recebimento_obs']);
    $recebimento_desconto = $_POST['recebimento_desconto'];
    $recebimento_desconto = str_replace(",", ".", $recebimento_desconto);
    $recebimento_banco = $_POST['recebimento_banco'];


    try {

        $result = $auth_user->runQuery('UPDATE recebimento SET '
                . 'recebimento_data_pagamento = :recebimento_data_pagamento, '
                . 'recebimento_valor = :recebimento_valor, '
                . 'recebimento_forma = :recebimento_forma, '
                . 'recebimento_obs = :recebimento_obs, '
                . 'recebimento_desconto = :recebimento_desconto, '
                . 'recebimento_banco = :recebimento_banco '
                . ' WHERE recebimento_id = :recebimento_id');
        $result->execute(array(
            ':recebimento_id' => $recebimento_id,
            ':recebimento_data_pagamento' => $recebimento_data_pagamento,
            ':recebimento_valor' => $recebimento_valor,
            ':recebimento_forma' => $recebimento_forma,
            ':recebimento_obs' => $recebimento_obs,
            ':recebimento_desconto' => $recebimento_desconto,
            ':recebimento_banco' => $recebimento_banco
        ));
        //BUSCA DADOS DO BANCO PARA VERIFICAR SE O RECEBIMENTO ESTA DE ACORDO COM O CONTAS A RECEBER
        $stmt_calculo = $auth_user->runQuery("select sum(recebimento_valor), contas_receber_valor from 
            contas_receber, recebimento where contas_receber_id = id_contas_receber AND id_contas_receber =:id_contas_receber");
        $stmt_calculo->bindparam(":id_contas_receber", $id_contas_receber);
        $stmt_calculo->execute();
        $valor = $stmt_calculo->fetch(PDO::FETCH_ASSOC);



        if ($valor['sum(recebimento_valor)'] >= $valor['contas_receber_valor']) {
            //ATUALIZA O STATUS DO CONTAS A RECEBER RECEBIMENTO TOTAL
            $status = 2;
            $result = $auth_user->runQuery('UPDATE contas_receber SET '
                    . 'contas_receber_status  = :contas_receber_status, '
                    . 'contas_receber_saldo  = :contas_receber_saldo '
                    . ' WHERE contas_receber_id = :contas_receber_id');
            $result->execute(array(
                ':contas_receber_id' => $id_contas_receber,
                ':contas_receber_status' => $status,
                ':contas_receber_saldo' => $valor['sum(recebimento_valor)']
            ));
        }
        if ($valor['sum(recebimento_valor)'] < $valor['contas_receber_valor']) {
            //ATUALIZA O STATUS DO CONTAS A RECEBER RECEBIMENTO PARCIAL
            $status = 1;
            $result = $auth_user->runQuery('UPDATE contas_receber SET '
                    . 'contas_receber_status  = :contas_receber_status, '
                    . 'contas_receber_saldo  = :contas_receber_saldo '
                    . ' WHERE contas_receber_id = :contas_receber_id');
            $result->execute(array(
                ':contas_receber_id' => $id_contas_receber,
                ':contas_receber_status' => $status,
                ':contas_receber_saldo' => $valor['sum(recebimento_valor)']
            ));
        }

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//EXCLUIR DO BANCO O RECEBIMENTO CADASTRADO
if (isset($_POST['btn-excluir-recebimento'])) {

    $recebimento_id = $_POST['recebimento_id'];
    $id_contas_receber = $_POST['id_contas_receber'];
    
    try {
        // INSERE UM NOVO RECEBIMENTO
        $sql = "DELETE FROM recebimento WHERE recebimento_id = :recebimento_id";
        $stmt = $auth_user->runQuery($sql);
        $stmt->bindParam(':recebimento_id', $recebimento_id, PDO::PARAM_INT);
        $stmt->execute();

        //BUSCA DADOS DO BANCO PARA VERIFICAR SE O RECEBIMENTO ESTA DE ACORDO COM O CONTAS A RECEBER
        $stmt_calcul = $auth_user->runQuery("select sum(recebimento_valor), contas_receber_valor from 
            contas_receber, recebimento where contas_receber_id = id_contas_receber AND contas_receber_id =:contas_receber_id");
        $stmt_calcul->bindparam(":contas_receber_id", $id_contas_receber);
        $stmt_calcul->execute();
        $valor = $stmt_calcul->fetch(PDO::FETCH_ASSOC);



        if ($valor['sum(recebimento_valor)'] >= $valor['contas_receber_valor']) {
            //ATUALIZA O STATUS DO CONTAS A RECEBER RECEBIMENTO TOTAL
            $status = 2;
            $result = $auth_user->runQuery('UPDATE contas_receber SET '
                    . 'contas_receber_status  = :contas_receber_status, '
                    . 'contas_receber_saldo  = :contas_receber_saldo '
                    . ' WHERE contas_receber_id = :contas_receber_id');
            $result->execute(array(
                ':contas_receber_id' => $id_contas_receber,
                ':contas_receber_status' => $status,
                ':contas_receber_saldo' => $valor['sum(recebimento_valor)']
            ));
        }
        if ($valor['sum(recebimento_valor)'] < $valor['contas_receber_valor']) {
            //ATUALIZA O STATUS DO CONTAS A RECEBER RECEBIMENTO PARCIAL
            $status = 1;
            $result = $auth_user->runQuery('UPDATE contas_receber SET '
                    . 'contas_receber_status  = :contas_receber_status, '
                    . 'contas_receber_saldo  = :contas_receber_saldo '
                    . ' WHERE contas_receber_id = :contas_receber_id');
            $result->execute(array(
                ':contas_receber_id' => $id_contas_receber,
                ':contas_receber_status' => $status,
                ':contas_receber_saldo' => $valor['sum(recebimento_valor)']
            ));
        }
        $auth_user->redirect("index.php");
        
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>