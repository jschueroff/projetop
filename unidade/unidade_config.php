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

$stmt = $auth_user->runQuery("SELECT * FROM unidade ORDER BY unidade_id ASC");
$stmt->execute();

// Acao para a Edicao
if (isset($_POST['btn-editar'])) {

    try {
        $unidade_id = strip_tags($_POST['unidade_id']);
        //$auth_user->buscar_funcionario($funcionario_id);
        $consulta = $auth_user->runQuery("SELECT * FROM unidade WHERE unidade_id = ?;");
        $consulta->bindParam(1, $unidade_id, PDO::PARAM_STR);
        $consulta->execute();
        $linha = $consulta->fetch(PDO::FETCH_ASSOC);
        if ($linha) {
            $auth_user->redirect("unidade_editar.php?id=" . $linha['unidade_id']);
        } else {
            echo 'Erro na Busca do ID UNIDADE';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Acao para Inativação
if (isset($_POST['btn-inativar'])) {
    $ncm_id = strip_tags($_POST['unidade_id']);

    try {

        $sql = "DELETE FROM unidade WHERE unidade_id =  :unidade_id";
        $stmt = $auth_user->runQuery($sql);
        $stmt->bindParam(':unidade_id', $unidade_id, PDO::PARAM_INT);
        $stmt->execute();
        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Botao Salvar a Edicao
if (isset($_POST['btn-salvar'])) {

    $id = $_POST['unidade_id'];
    $nome = $_POST['unidade_nome'];
    $descricao = $_POST['unidade_descricao'];


    // $data_cadastro = $_POST['produto_data_cadastro'];
    //$id_uni = $_POST['id_unidade'];
    //$id_ncm = $_POST['id_ncm'];

    try {

        $result = $auth_user->runQuery('UPDATE unidade SET '
                . 'unidade_nome  = :nome, '
                . 'unidade_descricao = :descricao '
                // . 'produto_data_cadastro = :data_cadastro'
                . ' WHERE unidade_id = :id');


        $result->execute(array(
            ':id' => $id,
            ':nome' => $nome,
            ':descricao' => $descricao
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

    $nome = $_POST['unidade_nome'];
    $descricao = $_POST['unidade_descricao'];


    try {
        $stmt = $auth_user->runQuery("INSERT INTO unidade
            (unidade_id,unidade_nome,unidade_descricao)
            VALUES('',:nome, :descricao)");

        $stmt->bindparam(":nome", $nome);
        $stmt->bindparam(":descricao", $descricao);


        $stmt->execute();

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Botao de Pesquisa
if (isset($_POST['btn-pesquisar'])) {
    //$funcionario_id = strip_tags($_POST['funcionario_id']);

    $pesquisa = $_POST['unidade_pesquisa'];
    $pesquisa2 = $_POST['unidade_pesquisa'];
    try {

        if (isset($pesquisa) && !empty($pesquisa2)) {
            $stmt = $auth_user->runQuery("SELECT * FROM unidade"
                    . " WHERE unidade_nome like :nome OR "
                    . "unidade_descricao like :descricao");
            $stmt->bindValue(':nome', '%' . $pesquisa2 . '%', PDO::PARAM_STR);
            $stmt->bindValue(':descricao', '%' . $pesquisa . '%', PDO::PARAM_STR);
            $stmt->execute();
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>