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

$stmt = $auth_user->runQuery("SELECT * FROM forma_pagamento ORDER BY forma_pagamento_id ASC");
$stmt->execute();

// Acao para a Edicao
if (isset($_POST['btn-editar'])) {

    try {
        $forma_pagamento_id = strip_tags($_POST['forma_pagamento_id']);
        //$auth_user->buscar_funcionario($funcionario_id);
        $consulta = $auth_user->runQuery("SELECT * FROM forma_pagamento WHERE forma_pagamento_id = ?;");
        $consulta->bindParam(1, $forma_pagamento_id, PDO::PARAM_STR);
        $consulta->execute();
        $linha = $consulta->fetch(PDO::FETCH_ASSOC);
        if ($linha) {
            $auth_user->redirect("forma_pagamento_editar.php?id=" . $linha['forma_pagamento_id']);
        } else {
            echo 'Erro na Busca do ID Forma Pagamento';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//DESATIVAR FORMA DE PAGAMENTO
if (isset($_POST['btn-inativar'])) {
    $forma_pagamento_id = strip_tags($_POST['forma_pagamento_id']);
    
    try {

        $sql = "UPDATE forma_pagamento SET forma_pagamento_status = 0 WHERE forma_pagamento_id = :forma_pagamento_id";
        $stmt = $auth_user->runQuery($sql);
        $stmt->bindParam(':forma_pagamento_id', $forma_pagamento_id, PDO::PARAM_INT);
        $stmt->execute();
        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//ATIVAR FORMA DE PAGAMENTO
if (isset($_POST['btn-ativar'])) {
    $forma_pagamento_id = strip_tags($_POST['forma_pagamento_id']);
    
    try {

        $sql = "UPDATE forma_pagamento SET forma_pagamento_status = 1 WHERE forma_pagamento_id = :forma_pagamento_id";
        $stmt = $auth_user->runQuery($sql);
        $stmt->bindParam(':forma_pagamento_id', $forma_pagamento_id, PDO::PARAM_INT);
        $stmt->execute();
        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Botao Salvar a Edicao
if (isset($_POST['btn-salvar'])) {

    $id = $_POST['forma_pagamento_id'];
    $nome = strtoupper($_POST['forma_pagamento_nome']);
    $vezes = $_POST['forma_pagamento_vezes'];
    $tipo = $_POST['forma_pagamento_tipo'];
    $forma_pagamento_prazo_pag = $_POST['forma_pagamento_prazo_pag'];
    $forma_pagamento_percentual = $_POST['forma_pagamento_percentual'];

    try {

        $result = $auth_user->runQuery('UPDATE forma_pagamento SET '
                . 'forma_pagamento_nome  = :nome, '
                . 'forma_pagamento_vezes = :vezes, '
                . 'forma_pagamento_tipo = :tipo, '
                . 'forma_pagamento_prazo_pag = :forma_pagamento_prazo_pag, '
                . 'forma_pagamento_percentual = :forma_pagamento_percentual '
                . ' WHERE forma_pagamento_id = :id');


        $result->execute(array(
            ':id' => $id,
            ':nome' => $nome,
            ':vezes' => $vezes,
            ':tipo' => $tipo,            
            ':forma_pagamento_prazo_pag' => $forma_pagamento_prazo_pag,
            ':forma_pagamento_percentual' => $forma_pagamento_percentual
        ));

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Cadastrar NCM
if (isset($_POST['btn-cadastro'])) {

    $nome = strtoupper($_POST['forma_pagamento_nome']);
    $vezes = $_POST['forma_pagamento_vezes'];
    $tipo = $_POST['forma_pagamento_tipo'];
    $forma_pagamento_prazo_pag = $_POST['forma_pagamento_prazo_pag'];
    $forma_pagamento_percentual = $_POST['forma_pagamento_percentual'];

    try {
        $stmt = $auth_user->runQuery("INSERT INTO forma_pagamento
            (forma_pagamento_nome,
            forma_pagamento_vezes, 
            forma_pagamento_tipo,
            forma_pagamento_prazo_pag,
            forma_pagamento_percentual
            )
            VALUES(
            :nome, 
            :vezes, 
            :tipo,
            :forma_pagamento_prazo_pag,
            :forma_pagamento_percentual
            )");

        $stmt->bindparam(":nome", $nome);
        $stmt->bindparam(":vezes", $vezes);
        $stmt->bindparam(":tipo", $tipo);
        $stmt->bindparam(":forma_pagamento_prazo_pag", $forma_pagamento_prazo_pag);
        $stmt->bindparam(":forma_pagamento_percentual", $forma_pagamento_percentual);

        $stmt->execute();

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Botao de Pesquisa
if (isset($_POST['btn-pesquisar'])) {
    //$funcionario_id = strip_tags($_POST['funcionario_id']);

    $pesquisa = strtoupper($_POST['forma_pagamento_pesquisa']);
    try {

            $stmt = $auth_user->runQuery("SELECT * FROM forma_pagamento"
                    . " WHERE forma_pagamento_nome like :nome");
            $stmt->bindValue(':nome', '%' . $pesquisa . '%', PDO::PARAM_STR);
            $stmt->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>