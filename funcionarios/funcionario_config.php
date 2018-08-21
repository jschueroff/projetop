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

$stmt = $auth_user->runQuery("SELECT * FROM funcionarios WHERE funcionario_status = 1 ORDER BY funcionario_id ASC");
$stmt->execute();

// Acao para a Edicao
if (isset($_POST['btn-editar'])) {

    try {
        $funcionario_id = strip_tags($_POST['funcionario_id']);
        //$auth_user->buscar_funcionario($funcionario_id);
         $consulta = $auth_user->runQuery("SELECT * FROM funcionarios WHERE funcionario_id = ?;");
            $consulta->bindParam(1, $funcionario_id, PDO::PARAM_STR);
            $consulta->execute();
            $linha = $consulta->fetch(PDO::FETCH_ASSOC);            
            if($linha){
                $auth_user->redirect("funcionario_editar.php?id=".$linha['funcionario_id']);
            }        
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Acao para Inativação
if (isset($_POST['btn-inativar'])) {
    $funcionario_id = strip_tags($_POST['funcionario_id']);

    try {

        $result = $auth_user->runQuery('UPDATE funcionarios SET '
                . 'funcionario_status  = 0 WHERE funcionario_id = :id');


        $result->execute(array(
            ':id' => $funcionario_id
        ));

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Botao Salvar a Edicao
if (isset($_POST['btn-salvar'])) {

    $id = $_POST['funcionario_id'];
    $nome = $_POST['funcionario_nome'];
    $cpf = $_POST['funcionario_cpf'];
    $email = $_POST['funcionario_email'];
    $status = $_POST['funcionario_status'];
    $endereco = $_POST['funcionario_endereco'];
    $nasc = $_POST['funcionario_data_nascimento'];
    $cidade = $_POST['funcionario_cidade'];



    try {

        $result = $auth_user->runQuery('UPDATE funcionarios SET '
                . 'funcionario_nome  = :nome ,'
                . 'funcionario_cpf   = :cpf ,'
                . 'funcionario_email = :email ,'
                . 'funcionario_status = :status ,'
                . 'funcionario_endereco = :endereco ,'
                . 'funcionario_data_nascimento = :nasc ,'
                . 'funcionario_cidade = :cidade'
                . ' WHERE funcionario_id = :id');


        $result->execute(array(
            ':id' => $id,
            ':nome' => $nome,
            ':cpf' => $cpf,
            ':email' => $email,
            ':status' => $status,
            ':endereco' => $endereco,
            ':nasc' => $nasc,
            ':cidade' => $cidade
        ));

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Cadastrar Funcionario
if (isset($_POST['btn-cadastro'])) {

    $nome = $_POST['funcionario_nome'];
    $cpf = $_POST['funcionario_cpf'];
    $email = $_POST['funcionario_email'];
    $endereco = $_POST['funcionario_endereco'];

    //Pegue a data no formato dd/mm/yyyy
    $data_old = $_POST['funcionario_data_nascimento'];
//Exploda a data para entrar no formato aceito pelo DB.
    $dataP = explode('/', $data_old);
    $nasc = $dataP[2] . '-' . $dataP[1] . '-' . $dataP[0];

    //$nasc = implode('/', array_reverse(explode('-', $nasc_old)));
    $cidade = $_POST['funcionario_cidade'];
    $status = '1';
    $nova_senha = $_POST['funcionario_senha'];
    $senha = password_hash($nova_senha, PASSWORD_DEFAULT);

    try {
        $stmt = $auth_user->runQuery("INSERT INTO funcionarios
            (funcionario_id,funcionario_nome,funcionario_cpf, funcionario_email,
            funcionario_senha, funcionario_status, funcionario_endereco, 
            funcionario_data_nascimento, funcionario_cidade)
            VALUES(0,:nome, :cpf, :email, :senha, :status, :endereco, :nasc, :cidade)");

        $stmt->bindparam(":nome", $nome);
        $stmt->bindparam(":cpf", $cpf);
        $stmt->bindparam(":email", $email);
        $stmt->bindparam(":senha", $senha);
        $stmt->bindparam(":status", $status);
        $stmt->bindparam(":endereco", $endereco);
        $stmt->bindparam(":nasc", $nasc);
        $stmt->bindparam(":cidade", $cidade);

        $stmt->execute();

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Botao de Pesquisa
if (isset($_POST['btn-pesquisar'])) {
    //$funcionario_id = strip_tags($_POST['funcionario_id']);

    $pesquisa = $_POST['funcionario_pesquisa'];
    $pesquisa2 = $_POST['funcionario_pesquisa'];
    try {

        if (isset($pesquisa) && !empty($pesquisa2)) {
            $stmt = $auth_user->runQuery("SELECT * FROM funcionarios"
                    . " WHERE funcionario_nome like :nome OR "
                    . "funcionario_email like :email");
            $stmt->bindValue(':nome', '%' . $pesquisa2 . '%', PDO::PARAM_STR);
            $stmt->bindValue(':email', '%' . $pesquisa . '%', PDO::PARAM_STR);
            $stmt->execute();


            
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>