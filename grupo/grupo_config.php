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

$stmt = $auth_user->runQuery("SELECT * FROM grupo ORDER BY grupo_id ASC");
$stmt->execute();

// Acao para a Edicao
if (isset($_POST['btn-editar'])) {

    try {
        $ncm_id = strip_tags($_POST['ncm_id']);
        //$auth_user->buscar_funcionario($funcionario_id);
        $consulta = $auth_user->runQuery("SELECT * FROM ncm WHERE ncm_id = ?;");
        $consulta->bindParam(1, $ncm_id, PDO::PARAM_STR);
        $consulta->execute();
        $linha = $consulta->fetch(PDO::FETCH_ASSOC);
        if ($linha) {
            $auth_user->redirect("ncm_editar.php?id=" . $linha['ncm_id']);
        } else {
            echo 'Erro na Busca do ID NCM';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Acao para Inativação
if (isset($_POST['btn-inativar'])) {
    $ncm_id = strip_tags($_POST['ncm_id']);

    try {

        $sql = "DELETE FROM ncm WHERE ncm_id =  :ncm_id";
        $stmt = $auth_user->runQuery($sql);
        $stmt->bindParam(':ncm_id', $ncm_id, PDO::PARAM_INT);
        $stmt->execute();
        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Botao Salvar a Edicao
if (isset($_POST['btn-salvar'])) {

    $id = $_POST['ncm_id'];
    $codigo = $_POST['ncm_codigo'];
    $nome = $_POST['ncm_nome'];


    // $data_cadastro = $_POST['produto_data_cadastro'];
    //$id_uni = $_POST['id_unidade'];
    //$id_ncm = $_POST['id_ncm'];

    try {

        $result = $auth_user->runQuery('UPDATE ncm SET '
                . 'ncm_codigo  = :codigo, '
                . 'ncm_nome = :nome '
                // . 'produto_data_cadastro = :data_cadastro'
                . ' WHERE ncm_id = :id');


        $result->execute(array(
            ':id' => $id,
            ':codigo' => $codigo,
            ':nome' => $nome
                //':data_cadastro' => $data_cadastro,
                // ':id_uni' => $id_uni,
                // ':id_ncm' => $id_ncm
        ));

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Cadastrar NCM
if (isset($_POST['btn-cadastro'])) {

    $grupo_nome = strtoupper($_POST['grupo_nome']);
    $grupo_descricao = strtoupper($_POST['grupo_descricao']);
    $grupo_tipo = $_POST['grupo_tipo'];


    try {
        $stmt = $auth_user->runQuery("INSERT INTO grupo
            (grupo_id,grupo_nome,grupo_descricao, grupo_tipo)
            VALUES('',:grupo_nome, :grupo_descricao, :grupo_tipo)");

        $stmt->bindparam(":grupo_nome", $grupo_nome);
        $stmt->bindparam(":grupo_descricao", $grupo_descricao);
        $stmt->bindparam(":grupo_tipo", $grupo_tipo);


        $stmt->execute();

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Botao de Pesquisa
if (isset($_POST['btn-pesquisar'])) {
    //$funcionario_id = strip_tags($_POST['funcionario_id']);

    $pesquisa = strtoupper($_POST['grupo_pesquisa']);
    $pesquisa2 = strtoupper($_POST['grupo_pesquisa']);
    try {

        if (isset($pesquisa) && !empty($pesquisa2)) {
            $stmt = $auth_user->runQuery("SELECT * FROM grupo"
                    . " WHERE grupo_nome like :nome OR "
                    . "grupo_descricao like :descricao");
            $stmt->bindValue(':descricao', '%' . $pesquisa2 . '%', PDO::PARAM_STR);
            $stmt->bindValue(':nome', '%' . $pesquisa . '%', PDO::PARAM_STR);
            $stmt->execute();
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>