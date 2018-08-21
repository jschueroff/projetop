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

$stmt = $auth_user->runQuery("SELECT * FROM aproveitamento ORDER BY aproveitamento_id DESC");
$stmt->execute();

// Acao para a Edicao
if (isset($_POST['btn-editar'])) {

    try {
        $aproveitamento_id = strip_tags($_POST['aproveitamento_id']);
        //$auth_user->buscar_funcionario($funcionario_id);
        $consulta = $auth_user->runQuery("SELECT * FROM aproveitamento WHERE aproveitamento_id = ?;");
        $consulta->bindParam(1, $aproveitamento_id, PDO::PARAM_STR);
        $consulta->execute();
        $linha = $consulta->fetch(PDO::FETCH_ASSOC);
        if ($linha) {
            $auth_user->redirect("aproveitamento_editar.php?id=" . $linha['aproveitamento_id']);
        } else {
            echo 'Erro na Busca do ID Aproveitamento ICMS';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

//Botao Salvar a Edicao
if (isset($_POST['btn-salvar'])) {

    $aproveitamento_id = $_POST['aproveitamento_id'];
    //$aproveitamento_aliquota = strtoupper($_POST['aproveitamento_aliquota']);
    $aproveitamento_aliquota = str_replace(",", ".", strip_tags($_POST['aproveitamento_aliquota']));
    $aproveitamento_aliquota = number_format($aproveitamento_aliquota, 2, '.','');
    
    $aproveitamento_mes = $_POST['aproveitamento_mes'];
    $aproveitamento_ano = $_POST['aproveitamento_ano'];
    

    try {

        $result = $auth_user->runQuery('UPDATE aproveitamento SET '
                . 'aproveitamento_aliquota  = :aproveitamento_aliquota, '
                . 'aproveitamento_mes = :aproveitamento_mes, '
                . 'aproveitamento_ano = :aproveitamento_ano'
                . ' WHERE aproveitamento_id = :aproveitamento_id');


        $result->execute(array(
            ':aproveitamento_id' => $aproveitamento_id,
            ':aproveitamento_aliquota' => $aproveitamento_aliquota,
            ':aproveitamento_mes' => $aproveitamento_mes,
            ':aproveitamento_ano' => $aproveitamento_ano
        ));

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Cadastrar NCM
if (isset($_POST['btn-cadastro'])) {

    //$aproveitamento_id = $_POST['aproveitamento_id'];
    //$aproveitamento_aliquota = strtoupper($_POST['aproveitamento_aliquota']);
    $aproveitamento_aliquota = str_replace(",", ".", strip_tags($_POST['aproveitamento_aliquota']));
    $aproveitamento_mes = $_POST['aproveitamento_mes'];
    $aproveitamento_ano = $_POST['aproveitamento_ano'];

    try {
        $stmt = $auth_user->runQuery("INSERT INTO aproveitamento
            (aproveitamento_aliquota,
            aproveitamento_mes, 
            aproveitamento_ano
            
            )
            VALUES(
            :aproveitamento_aliquota,
            :aproveitamento_mes, 
            :aproveitamento_ano
            )");

        $stmt->bindparam(":aproveitamento_aliquota", $aproveitamento_aliquota);
        $stmt->bindparam(":aproveitamento_mes", $aproveitamento_mes);
        $stmt->bindparam(":aproveitamento_ano", $aproveitamento_ano);
        $stmt->execute();

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Botao de Pesquisa
if (isset($_POST['btn-pesquisar'])) {
    //$funcionario_id = strip_tags($_POST['funcionario_id']);

    $pesquisa = strtoupper($_POST['aproveitamento_pesquisa']);
    try {

            $stmt = $auth_user->runQuery("SELECT * FROM aproveitamento"
                    . " WHERE aproveitamento_ano like :aproveitamento_ano");
            $stmt->bindValue(':aproveitamento_ano', '%' . $pesquisa . '%', PDO::PARAM_STR);
            $stmt->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>