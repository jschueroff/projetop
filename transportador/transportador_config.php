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

$stmt = $auth_user->runQuery("select * from transportador");
$stmt->execute();

// Acao para a Edicao
if (isset($_POST['btn-editar'])) {

    try {
        $transportador_id = strip_tags($_POST['transportador_id']);
        //$auth_user->buscar_funcionario($funcionario_id);
        $consulta = $auth_user->runQuery("SELECT * FROM transportador WHERE transportador_id = ?;");
        $consulta->bindParam(1, $transportador_id, PDO::PARAM_STR);
        $consulta->execute();
        $linha = $consulta->fetch(PDO::FETCH_ASSOC);
        if ($linha) {
            $auth_user->redirect("transportador_editar.php?id=" . $linha['transportador_id']);
        } else {
            echo 'Erro na Busca do ID Transportador';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//INATIVAR TRANSPORTADOR
if (isset($_POST['btn-inativar'])) {
    $transportador_id = strip_tags($_POST['transportador_id']);
    $status = 0;

    try {

        $result = $auth_user->runQuery('UPDATE transportador SET '
                . 'transportador_status  = :status '
                . ' WHERE transportador_id = :transportador_id');

        $result->execute(array(
            ':transportador_id' => $transportador_id,
            ':status' => $status
        ));

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//ATIVAR TRANSPORTADOR
if (isset($_POST['btn-ativar'])) {
    $transportador_id = strip_tags($_POST['transportador_id']);
    $status = 1;

    try {

        $result = $auth_user->runQuery('UPDATE transportador SET '
                . 'transportador_status  = :status '
                . ' WHERE transportador_id = :transportador_id');

        $result->execute(array(
            ':transportador_id' => $transportador_id,
            ':status' => $status
        ));

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Botao Salvar a Edicao
if (isset($_POST['btn-salvar'])) {

    $id = $_POST['transportador_id'];
    $nome = strtoupper($_POST['transportador_nome']);
    $fantasia = strtoupper($_POST['transportador_fantasia']);
    $cnpj = $_POST['transportador_cnpj'];
    $ie = $_POST['transportador_ie'];
    $email = strtolower($_POST['transportador_email']);
    $email_nfe = strtolower($_POST['transportador_email_nfe']);
    $telefone = $_POST['transportador_telefone'];
    $status = $_POST['transportador_status'];
    $logradouro = strtoupper($_POST['transportador_logradouro']);
    $numero = $_POST['transportador_numero'];
    $complemento = strtoupper($_POST['transportador_complemento']);
    $bairro = strtoupper($_POST['transportador_bairro']);
    $cep = $_POST['transportador_cep'];
    $transportador_municipio = $_POST['transportador_municipio'];
    $transportador_uf = $_POST['transportador_uf'];



    // $data_cadastro = $_POST['produto_data_cadastro'];
    //$id_uni = $_POST['id_unidade'];
    //$id_ncm = $_POST['id_ncm'];

    try {

        $result = $auth_user->runQuery('UPDATE transportador SET '
                . 'transportador_nome  = :nome, '
                . 'transportador_fantasia = :fantasia, '
                . 'transportador_cnpj  = :cnpj, '
                . 'transportador_ie  = :ie, '
                . 'transportador_email  = :email, '
                . 'transportador_email_nfe  = :email_nfe, '
                . 'transportador_telefone  = :telefone, '
                . 'transportador_status  = :status, '
                . 'transportador_logradouro  = :logradouro, '
                . 'transportador_numero  = :numero, '
                . 'transportador_complemento  = :complemento, '
                . 'transportador_bairro  = :bairro, '
                . 'transportador_cep  = :cep, '
                . 'transportador_municipio  = :transportador_municipio, '
                . 'transportador_uf  = :transportador_uf '
                . ' WHERE transportador_id = :id');


        $result->execute(array(
            ':id' => $id,
            ':nome' => $nome,
            ':fantasia' => $fantasia,
            ':cnpj' => $cnpj,
            ':ie' => $ie,
            ':email' => $email,
            ':email_nfe' => $email_nfe,
            ':telefone' => $telefone,
            ':status' => $status,
            ':logradouro' => $logradouro,
            ':numero' => $numero,
            ':complemento' => $complemento,
            ':bairro' => $bairro,
            ':cep' => $cep,
            ':transportador_municipio' => $transportador_municipio,
            ':transportador_uf' => $transportador_uf
        ));

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Cadastrar NCM
if (isset($_POST['btn-cadastro'])) {



    $nome = strtoupper($_POST['transportador_nome']);
    $fantasia = strtoupper($_POST['transportador_fantasia']);
    $cnpj = $_POST['transportador_cnpj'];
    $ie = $_POST['transportador_ie'];
    $email = strtolower($_POST['transportador_email']);
    $email_nfe = strtolower($_POST['transportador_email_nfe']);
    $telefone = $_POST['transportador_telefone'];
    $status = $_POST['transportador_status'];
    $logradouro = strtoupper($_POST['transportador_logradouro']);
    $numero = $_POST['transportador_numero'];
    $complemento = strtoupper($_POST['transportador_complemento']);
    $bairro = strtoupper($_POST['transportador_bairro']);
    $cep = $_POST['transportador_cep'];
    $transportador_municipio = $_POST['transportador_municipio'];
    $transportador_uf = $_POST['transportador_uf'];




    try {
        $stmt = $auth_user->runQuery("INSERT INTO transportador
            (
            transportador_nome,
            transportador_fantasia, 
            transportador_cnpj,
            transportador_ie,
            transportador_email,
            transportador_email_nfe, 
            transportador_telefone,
            transportador_status, 
            transportador_logradouro,
            transportador_numero, 
            transportador_complemento,
            transportador_bairro, 
            transportador_cep,
            transportador_municipio,
            transportador_uf)
            VALUES(
            :nome, 
            :fantasia, 
            :cnpj, 
            :ie,
            :email, 
            :email_nfe, 
            :telefone, 
            :status, 
            :logradouro,
            :numero, 
            :complemento, 
            :bairro,
            :cep,
            :transportador_municipio,
            :transportador_uf
            )");

        $stmt->bindparam(":nome", $nome);
        $stmt->bindparam(":fantasia", $fantasia);
        $stmt->bindparam(":cnpj", $cnpj);
        $stmt->bindparam(":ie", $ie);
        $stmt->bindparam(":email", $email);
        $stmt->bindparam(":email_nfe", $email_nfe);
        $stmt->bindparam(":telefone", $telefone);
        $stmt->bindparam(":status", $status);
        $stmt->bindparam(":logradouro", $logradouro);
        $stmt->bindparam(":numero", $numero);
        $stmt->bindparam(":complemento", $complemento);
        $stmt->bindparam(":bairro", $bairro);
        $stmt->bindparam(":cep", $cep);
        $stmt->bindparam(":transportador_municipio", $transportador_municipio);
        $stmt->bindparam(":transportador_uf", $transportador_uf);

        $stmt->execute();

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Botao de Pesquisa
if (isset($_POST['btn-pesquisar'])) {
    //$funcionario_id = strip_tags($_POST['funcionario_id']);

    $pesquisa = $_POST['transportador_pesquisa'];
    $pesquisa2 = $_POST['transportador_pesquisa'];
    try {

        if (isset($pesquisa) && !empty($pesquisa2)) {
            $stmt = $auth_user->runQuery("SELECT * FROM transportador"
                    . " WHERE transportador_nome like :nome OR "
                    . "transportador_fantasia like :fantasia");
            $stmt->bindValue(':nome', '%' . $pesquisa2 . '%', PDO::PARAM_STR);
            $stmt->bindValue(':fantasia', '%' . $pesquisa . '%', PDO::PARAM_STR);
            $stmt->execute();
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>