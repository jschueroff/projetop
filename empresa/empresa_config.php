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

$stmt = $auth_user->runQuery("SELECT * FROM empresa WHERE empresa_status = 1 ORDER BY empresa_id ASC");
$stmt->execute();

$stmt_municipio = $auth_user->runQuery("SELECT * FROM municipio");
$stmt_municipio->execute();

// Acao para a Edicao
if (isset($_POST['btn-editar'])) {
    try {
        $empresa_id = strip_tags($_POST['empresa_id']);
        //$auth_user->buscar_funcionario($funcionario_id);
        $consulta = $auth_user->runQuery("SELECT * FROM empresa WHERE empresa_id = ?;");
        $consulta->bindParam(1, $empresa_id, PDO::PARAM_STR);
        $consulta->execute();
        $linha = $consulta->fetch(PDO::FETCH_ASSOC);
        if ($linha) {
            $auth_user->redirect("empresa_editar.php?id=" . $linha['empresa_id']);
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Acao para Inativação
if (isset($_POST['btn-inativar'])) {
    $empresa_id = strip_tags($_POST['empresa_id']);

    try {

        $result = $auth_user->runQuery('UPDATE empresa SET '
                . 'empresa_status  = 0 WHERE empresa_id = :id');


        $result->execute(array(
            ':id' => $empresa_id
        ));

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Botao Salvar a Edicao
if (isset($_POST['btn-salvar'])) {

    $id = $_POST['empresa_id'];
    $nome = $_POST['empresa_nome'];
    $fantasia = $_POST['empresa_fantasia'];
    $cnpj = $_POST['empresa_cnpj'];
    $ie = $_POST['empresa_ie'];
    $im = $_POST['empresa_im'];
    $tipo = $_POST['empresa_tipo'];
    $cnae = $_POST['empresa_cnae'];
    $crt = $_POST['empresa_crt'];
    $email = $_POST['empresa_email'];
    $email_nfe = $_POST['empresa_email_nfe'];
    $telefone = $_POST['empresa_telefone'];
    $status = $_POST['empresa_status'];
    $logradouro = $_POST['empresa_logradouro'];
    $numero = $_POST['empresa_numero'];
    $complemento = $_POST['empresa_complemento'];
    $bairro = $_POST['empresa_bairro'];
    $cep = $_POST['empresa_cep'];
    $estado = $_POST['id_estado'];
    $municipio = $_POST['id_municipio'];

    try {
        $result = $auth_user->runQuery('UPDATE empresa SET '
                . 'empresa_nome  = :nome ,'
                . 'empresa_fantasia  = :fantasia, '
                . 'empresa_cnpj   = :cnpj,'
                . 'empresa_ie = :ie ,'
                . 'empresa_im = :im ,'
                . 'empresa_tipo = :tipo , '
                . 'empresa_cnae = :cnae ,'
                . 'empresa_crt = :crt ,'
                . 'empresa_email = :email ,'
                . 'empresa_email_nfe = :email_nfe ,'
                . 'empresa_telefone = :telefone ,'
                . 'empresa_status = :status ,'
                . 'empresa_logradouro = :logradouro ,'
                . 'empresa_numero = :numero ,'
                . 'empresa_complemento = :complemento ,'
                . 'empresa_bairro = :bairro ,'
                . 'empresa_cep = :cep ,'
                . 'id_municipio = :municipio ,'
                . 'id_estado = :estado '
                . 'WHERE empresa_id = :id');

        $result->execute(array(
            ':id' => $id,
            ':nome' => $nome,
            ':fantasia' => $fantasia,
            ':cnpj' => $cnpj,
            ':ie' => $ie,
            ':im' => $im,
            ':tipo' => $tipo,
            ':cnae' => $cnae,
            ':crt' => $crt,
            ':email' => $email,
            ':email_nfe' => $email_nfe,
            ':telefone' => $telefone,
            ':status' => $status,
            ':logradouro' => $logradouro,
            ':numero' => $numero,
            ':complemento' => $complemento,
            ':bairro' => $bairro,
            ':cep' => $cep,
            ':municipio' => $municipio,
            ':estado' => $estado
        ));

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Cadastrar Funcionario
if (isset($_POST['btn-cadastro'])) {

    
    $nome = $_POST['empresa_nome'];
    $fantasia = $_POST['empresa_fantasia'];
    $cnpj = $_POST['empresa_cnpj'];
    $ie = $_POST['empresa_ie'];
    $im = $_POST['empresa_im'];
    $tipo = $_POST['empresa_tipo'];
    $cnae = $_POST['empresa_cnae'];
    $crt = $_POST['empresa_crt'];
    $email = $_POST['empresa_email'];
    $email_nfe = $_POST['empresa_email_nfe'];
    $telefone = $_POST['empresa_telefone'];
    $status = 1;
    $logradouro = $_POST['empresa_logradouro'];
    $numero = $_POST['empresa_numero'];
    $complemento = $_POST['empresa_complemento'];
    $bairro = $_POST['empresa_bairro'];
    $cep = $_POST['empresa_cep'];
    $estado = $_POST['id_estado'];
    $municipio = $_POST['id_municipio'];

    try {
        $stmt = $auth_user->runQuery("INSERT INTO empresa
            (empresa_id,empresa_nome,empresa_fantasia, empresa_cnpj,
            empresa_ie, empresa_im, empresa_tipo, empresa_cnae,
            empresa_crt, empresa_email, empresa_email_nfe, empresa_telefone, empresa_status,
            empresa_logradouro, empresa_numero, empresa_complemento, empresa_bairro,
            empresa_cep, id_estado, id_municipio)
            VALUES('',:nome, :fantasia, :cnpj, :ie, :im, :tipo, :cnae, :crt, :email,
            :email_nfe, :telefone, :status, :logradouro, :numero, :complemento, :bairro,
            :cep, :estado, :municipio)");

        $stmt->bindparam(":nome", $nome);
        $stmt->bindparam(":fantasia", $fantasia);
        $stmt->bindparam(":cnpj", $cnpj);
        $stmt->bindparam(":ie", $ie);
        $stmt->bindparam(":im", $im);
        $stmt->bindparam(":tipo", $tipo);
        $stmt->bindparam(":cnae", $cnae);
        $stmt->bindparam(":crt", $crt);
        $stmt->bindparam(":email", $email);
        $stmt->bindparam(":email_nfe", $email_nfe);
        $stmt->bindparam(":telefone", $telefone);
        $stmt->bindparam(":status", $status);
        $stmt->bindparam(":logradouro", $logradouro);
        $stmt->bindparam(":numero", $numero);
        $stmt->bindparam(":complemento", $complemento);
        $stmt->bindparam(":bairro", $bairro);
        $stmt->bindparam(":cep", $cep);
        $stmt->bindparam(":estado", $estado);
        $stmt->bindparam(":municipio", $municipio);

        $stmt->execute();

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Botao de Pesquisa
if (isset($_POST['btn-pesquisar'])) {
    //$funcionario_id = strip_tags($_POST['funcionario_id']);

    $pesquisa = $_POST['empresa_pesquisa'];
    $pesquisa2 = $_POST['empresa_pesquisa'];
    try {

        if (isset($pesquisa) && !empty($pesquisa2)) {
            $stmt = $auth_user->runQuery("SELECT * FROM empresa"
                    . " WHERE empresa_nome like :nome OR "
                    . "empresa_email like :email");
            $stmt->bindValue(':nome', '%' . $pesquisa2 . '%', PDO::PARAM_STR);
            $stmt->bindValue(':email', '%' . $pesquisa . '%', PDO::PARAM_STR);
            $stmt->execute();
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>