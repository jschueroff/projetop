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

$stmt = $auth_user->runQuery("SELECT * FROM inf_comp ORDER BY inf_comp_id ASC");
$stmt->execute();



// Acao para a Edicao
if (isset($_POST['btn-editar'])) {

    try {
        $inf_comp_id = strip_tags($_POST['inf_comp_id']);
        //$auth_user->buscar_funcionario($funcionario_id);
        $consulta = $auth_user->runQuery("SELECT * FROM inf_comp WHERE inf_comp_id = ?;");
        $consulta->bindParam(1, $inf_comp_id, PDO::PARAM_STR);
        $consulta->execute();
        $linha = $consulta->fetch(PDO::FETCH_ASSOC);
        if ($linha) {
            $auth_user->redirect("infcomp_editar.php?id=" . $linha['inf_comp_id']);
        } else {
            echo 'Erro na Busca do ID INF. COMP.';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//INATIVAR AS INFORMAÇÕES COMPLEMENTARES
if (isset($_POST['btn-inativar'])) {
    
     $inf_comp_id = $_POST['inf_comp_id'];
     $inf_comp_status = 0;
    try {
        $result = $auth_user->runQuery('UPDATE inf_comp SET '
                . 'inf_comp_status  = :inf_comp_status '
                . ' WHERE inf_comp_id = :inf_comp_id');
        $result->execute(array(
            ':inf_comp_id' => $inf_comp_id,
            ':inf_comp_status' => $inf_comp_status
        ));

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//ATIVAR AS INFORMAÇÕES COMPLEMENTARES
if (isset($_POST['btn-ativar'])) {
    
     $inf_comp_id = $_POST['inf_comp_id'];
     $inf_comp_status = 1;
    try {
        $result = $auth_user->runQuery('UPDATE inf_comp SET '
                . 'inf_comp_status  = :inf_comp_status '
                . ' WHERE inf_comp_id = :inf_comp_id');
        $result->execute(array(
            ':inf_comp_id' => $inf_comp_id,
            ':inf_comp_status' => $inf_comp_status
        ));

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//BOTAO SALVAR A EDICAO
if (isset($_POST['btn-salvar'])) {

    $inf_comp_id = $_POST['inf_comp_id'];
    $inf_comp_descricao_resumida = $_POST['inf_comp_descricao_resumida'];
    $inf_comp_apelido = $_POST['inf_comp_apelido'];
    $inf_comp_interesse = $_POST['inf_comp_interesse'];
    $inf_comp_descricao = $_POST['inf_comp_descricao'];
    $inf_comp_exportacao = $_POST['inf_comp_exportacao'];
    
    try {

        $result = $auth_user->runQuery('UPDATE inf_comp SET '
                . 'inf_comp_descricao_resumida  = :inf_comp_descricao_resumida, '
                . 'inf_comp_apelido  = :inf_comp_apelido, '
                . 'inf_comp_interesse  = :inf_comp_interesse, '
                . 'inf_comp_descricao  = :inf_comp_descricao, '
                . 'inf_comp_exportacao = :inf_comp_exportacao '
                . ' WHERE inf_comp_id = :inf_comp_id');
        $result->execute(array(
            ':inf_comp_id' => $inf_comp_id,
            ':inf_comp_descricao_resumida' => $inf_comp_descricao_resumida,
            ':inf_comp_apelido' => $inf_comp_apelido,
            ':inf_comp_interesse' => $inf_comp_interesse,
            ':inf_comp_descricao' => $inf_comp_descricao,
            ':inf_comp_exportacao' => $inf_comp_exportacao
        ));

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//CADASTRO DE INFORMAÇÕES COMPLEMENTARES
if (isset($_POST['btn-cadastro'])) {

    $inf_comp_descricao_resumida = strtoupper($_POST['inf_comp_descricao_resumida']);
    $inf_comp_apelido = strtoupper($_POST['inf_comp_apelido']);
    $inf_comp_interesse = strtoupper($_POST['inf_comp_interesse']);
    $inf_comp_descricao = strtoupper($_POST['inf_comp_descricao']);
    $inf_comp_exportacao = strtoupper($_POST['inf_comp_exportacao']);
    $inf_comp_status = 1;
    
    try {
        $stmt = $auth_user->runQuery("INSERT INTO inf_comp
            (inf_comp_descricao_resumida,
             inf_comp_apelido,
             inf_comp_interesse,
             inf_comp_descricao,
             inf_comp_exportacao,
             inf_comp_status
             )VALUES(
             :inf_comp_descricao_resumida, 
             :inf_comp_apelido, 
             :inf_comp_interesse, 
             :inf_comp_descricao, 
             :inf_comp_exportacao,
             :inf_comp_status)");
        
        $stmt->bindparam(":inf_comp_descricao_resumida", $inf_comp_descricao_resumida);
        $stmt->bindparam(":inf_comp_apelido", $inf_comp_apelido);
        $stmt->bindparam(":inf_comp_interesse", $inf_comp_interesse);
        $stmt->bindparam(":inf_comp_descricao", $inf_comp_descricao);
        $stmt->bindparam(":inf_comp_exportacao", $inf_comp_exportacao);
        $stmt->bindparam(":inf_comp_status", $inf_comp_status);
    
        $stmt->execute();
        
        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Botao de Pesquisa
if (isset($_POST['btn-pesquisar'])) {
    //$funcionario_id = strip_tags($_POST['funcionario_id']);

    $pesquisa = $_POST['inf_comp_pesquisa'];
    $pesquisa2 = $_POST['inf_comp_pesquisa'];
    try {

        if (isset($pesquisa) && !empty($pesquisa2)) {
            $stmt = $auth_user->runQuery("SELECT * FROM inf_comp"
                    . " WHERE inf_comp_descricao_resumida like :codigo OR "
                    . "inf_comp_descricao like :nome");
            $stmt->bindValue(':codigo', '%' . $pesquisa2 . '%', PDO::PARAM_STR);
            $stmt->bindValue(':nome', '%' . $pesquisa . '%', PDO::PARAM_STR);
            $stmt->execute();
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>