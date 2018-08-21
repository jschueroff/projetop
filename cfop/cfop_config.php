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

$stmt = $auth_user->runQuery("SELECT * FROM cfop ORDER BY cfop_id ASC");
$stmt->execute();

// EDITAR CFOP DA EMPRESA
if (isset($_POST['btn-editar'])) {

    try {
        $cfop_id = strip_tags($_POST['cfop_id']);
        //$auth_user->buscar_funcionario($funcionario_id);
        $consulta = $auth_user->runQuery("SELECT * FROM cfop WHERE cfop_id = ?;");
        $consulta->bindParam(1, $cfop_id, PDO::PARAM_STR);
        $consulta->execute();
        $linha = $consulta->fetch(PDO::FETCH_ASSOC);
        if ($linha) {
            $auth_user->redirect("cfop_editar.php?id=" . $linha['cfop_id']);
        } else {
            echo 'Erro na Busca do ID CFOP';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

//SALVAR DADOS DA EDICAO DO CFOP    
if (isset($_POST['btn-salvar'])) {

    $id = $_POST['cfop_id'];
    $codigo = $_POST['cfop_codigo'];
    $nome = $_POST['cfop_descricao'];
    $aplicacao = $_POST['cfop_aplicacao'];
    try {

        $result = $auth_user->runQuery('UPDATE cfop SET '
                . 'cfop_codigo  = :codigo, '
                . 'cfop_descricao = :nome, '
                . 'cfop_aplicacao = :aplicacao'
                . ' WHERE cfop_id = :id');
        $result->execute(array(
            ':id' => $id,
            ':codigo' => $codigo,
            ':nome' => $nome,
            ':aplicacao' => $aplicacao
        ));

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//CADASTRO DE UM NOVO CFOP
if (isset($_POST['btn-cadastro'])) {

    $codigo = $_POST['cfop_codigo'];
    $nome = $_POST['cfop_descricao'];
    $aplicacao = $_POST['cfop_aplicacao'];
    try {
        $stmt = $auth_user->runQuery("INSERT INTO cfop
            (cfop_codigo,cfop_descricao, cfop_aplicacao)
            VALUES(:codigo, :nome, :aplicacao)");
        $stmt->bindparam(":codigo", $codigo);
        $stmt->bindparam(":nome", $nome);
        $stmt->bindparam(":aplicacao", $aplicacao);

        $stmt->execute();
        
        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Botao de Pesquisa
if (isset($_POST['btn-pesquisar'])) {
    //$funcionario_id = strip_tags($_POST['funcionario_id']);

    $pesquisa = $_POST['cfop_pesquisa'];
    $pesquisa2 = $_POST['cfop_pesquisa'];
    try {

        if (isset($pesquisa) && !empty($pesquisa2)) {
            $stmt = $auth_user->runQuery("SELECT * FROM cfop"
                    . " WHERE cfop_codigo like :codigo OR "
                    . "cfop_descricao like :nome");
            $stmt->bindValue(':codigo', '%' . $pesquisa2 . '%', PDO::PARAM_STR);
            $stmt->bindValue(':nome', '%' . $pesquisa . '%', PDO::PARAM_STR);
            $stmt->execute();
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>