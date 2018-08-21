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

$stmt_tes = $auth_user->runQuery("SELECT * FROM tes ORDER BY tes_id ASC");
$stmt_tes->execute();
//==========>>SITUACAO TRIBUTARIA <<================
// BUSCAR ST PARA A EDICAO
if (isset($_POST['btn-editar'])) {

    try {
        $tes_id = strip_tags($_POST['tes_id']);
        //$auth_user->buscar_funcionario($funcionario_id);
        $consulta = $auth_user->runQuery("SELECT * FROM tes WHERE tes_id = ?;");
        $consulta->bindParam(1, $tes_id, PDO::PARAM_STR);
        $consulta->execute();
        $linha = $consulta->fetch(PDO::FETCH_ASSOC);
        if ($linha) {
            $auth_user->redirect("tes_editar.php?id=" . $linha['tes_id']);
        } else {
            echo 'Erro na Busca do ID DA TES';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//INATIVAR UMA TES DO SISTEMA
if (isset($_POST['btn-inativar'])) {
    $tes_id = strip_tags($_POST['tes_id']);
    $status = false;
    try {
        $result = $auth_user->runQuery('UPDATE tes SET '
                . 'tes_status  = :status '
                . ' WHERE tes_id = :id');
        $result->execute(array(
            ':id' => $tes_id,
            ':status' => $status
        ));

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//ATIVAR UMA TES DO SISTEMA
if (isset($_POST['btn-ativar'])) {
    $tes_id = strip_tags($_POST['tes_id']);
    $status = true;
    try {
        $result = $auth_user->runQuery('UPDATE tes SET '
                . 'tes_status  = :status '
                . ' WHERE tes_id = :id');
        $result->execute(array(
            ':id' => $tes_id,
            ':status' => $status
        ));

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

//SALVAR DADOS DEPOIS DE EDITADOS
if (isset($_POST['btn-salvar'])) {

    $id = $_POST['tes_id'];
    $tes_descricao = strtoupper($_POST['tes_descricao']);
    $tes_tipo = $_POST['tes_tipo'];
    $tes_natureza = $_POST['tes_natureza'];
    $tes_cfop = $_POST['tes_cfop'];
    $tes_consumidor_final = $_POST['tes_consumidor_final'];
    $tes_icms = $_POST['tes_icms'];
    $tes_ipi = $_POST['tes_ipi'];
    $tes_estoque = $_POST['tes_estoque'];
    $tes_pis_confis = $_POST['tes_pis_confis'];
    $tes_status = $_POST['tes_status'];

    try 
    {

        $result = $auth_user->runQuery('UPDATE tes SET '
                . 'tes_descricao  = :tes_descricao, '
                . 'tes_tipo  = :tes_tipo, '
                . 'tes_natureza  = :tes_natureza, '
                . 'tes_cfop  = :tes_cfop, '
                . 'tes_consumidor_final  = :tes_consumidor_final, '
                . 'tes_icms  = :tes_icms, '
                . 'tes_ipi  = :tes_ipi, '
                . 'tes_pis_confis  = :tes_pis_confis, '
                . 'tes_estoque  = :tes_estoque, '
                . 'tes_status = :tes_status '
                . ' WHERE tes_id = :id');


        $result->execute(array(
            ':id' => $id,
            ':tes_descricao' => $tes_descricao,
            ':tes_tipo' => $tes_tipo,
            ':tes_natureza' => $tes_natureza,
            ':tes_cfop' => $tes_cfop,
            ':tes_consumidor_final' => $tes_consumidor_final,
            ':tes_icms' => $tes_icms,
            ':tes_ipi' => $tes_ipi,
            ':tes_pis_confis' => $tes_pis_confis,
            ':tes_estoque' => $tes_estoque,
            ':tes_status' => $tes_status
        ));

        $auth_user->redirect("index.php");
    }
    catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//CADASTRO DE TES NOVA 
if (isset($_POST['btn-cadastro'])) {

    $tes_descricao = strtoupper($_POST['tes_descricao']);
    $tes_tipo = $_POST['tes_tipo'];
    $tes_natureza = $_POST['tes_natureza'];
    $tes_cfop = $_POST['tes_cfop'];
    $tes_consumidor_final = $_POST['tes_consumidor_final'];
    $tes_icms = $_POST['tes_icms'];
    $tes_ipi = $_POST['tes_ipi'];
    $tes_estoque = $_POST['tes_estoque'];
    $tes_pis_confis = $_POST['tes_pis_confis'];
    $tes_status = 1;

    try {
        //CADASTRO DA ST
        $stmt = $auth_user->runQuery("INSERT INTO tes
            (tes_descricao, tes_tipo, tes_natureza, tes_cfop, tes_consumidor_final, tes_icms, tes_ipi, tes_estoque, tes_pis_confis, tes_status)
            VALUES(:tes_descricao, :tes_tipo, :tes_natureza, :tes_cfop, :tes_consumidor_final, :tes_icms, :tes_ipi, :tes_estoque, :tes_pis_confis, :tes_status)");

        $stmt->bindparam(":tes_descricao", $tes_descricao);
        $stmt->bindparam(":tes_tipo", $tes_tipo);
        $stmt->bindparam(":tes_natureza", $tes_natureza);
        $stmt->bindparam(":tes_cfop", $tes_cfop);
        $stmt->bindparam(":tes_consumidor_final", $tes_consumidor_final);
        $stmt->bindparam(":tes_icms", $tes_icms);
        $stmt->bindparam(":tes_ipi", $tes_ipi);
        $stmt->bindparam(":tes_estoque", $tes_estoque);
        $stmt->bindparam(":tes_pis_confis", $tes_pis_confis);
        $stmt->bindparam(":tes_status", $tes_status);
        
        $stmt->execute();
        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//PESQUISAR A ST CADASTRADA
if (isset($_POST['btn-pesquisar'])) {
    //$funcionario_id = strip_tags($_POST['funcionario_id']);
    $tes_descricao = strtoupper($_POST['tes_pesquisa']);
    try {
        $stmt_tes = $auth_user->runQuery("select * from tes WHERE tes_descricao like :tes_descricao");
        $stmt_tes->bindValue(':tes_descricao', '%'. $tes_descricao .'%', PDO::PARAM_STR);
        $stmt_tes->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//============>>>TES ITENS<<===================
//CADASTRA UM NOVO TES ITENS
if (isset($_POST['btn-cadastrates_itens'])) {
    
    $id_tes = $_POST['id_tes'];
    $tes_itens_cfop = $_POST['tes_itens_cfop'];
    $tes_itens_origem = $_POST['tes_itens_origem'];
    $tes_itens_contribuinte = $_POST['tes_itens_contribuinte'];
    $tes_itens_tipo_produto = $_POST['tes_itens_tipo_produto'];
    $tes_itens_cst_icms = $_POST['tes_itens_cst_icms'];
    

    try {
        //CADASTRO DA ST
        $stmt = $auth_user->runQuery("INSERT INTO tes_itens
            (id_tes,
             tes_itens_cfop,
             tes_itens_origem,
             tes_itens_contribuinte,
             tes_itens_tipo_produto,
             tes_itens_cst_icms
             )
            VALUES(
             :id_tes,
             :tes_itens_cfop,
             :tes_itens_origem,
             :tes_itens_contribuinte,
             :tes_itens_tipo_produto,
             :tes_itens_cst_icms )");

        $stmt->bindparam(":id_tes", $id_tes);
        $stmt->bindparam(":tes_itens_cfop", $tes_itens_cfop);
        $stmt->bindparam(":tes_itens_origem", $tes_itens_origem);
        $stmt->bindparam(":tes_itens_contribuinte", $tes_itens_contribuinte);
        $stmt->bindparam(":tes_itens_tipo_produto", $tes_itens_tipo_produto);
        $stmt->bindparam(":tes_itens_cst_icms", $tes_itens_cst_icms);
       
        $stmt->execute();
        $auth_user->redirect("tes_editar.php?id=" . $id_tes);
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//EDITA OS DADOS DO STICMS
if (isset($_POST['btn-altera-tesitens'])) {

    $tes_itens_id = $_POST['tes_itens_id'];
    $id_tes = $_POST['id_tes'];
    $tes_itens_cfop = $_POST['tes_itens_cfop'];
    $tes_itens_origem = $_POST['tes_itens_origem'];
    $tes_itens_contribuinte = $_POST['tes_itens_contribuinte'];
    $tes_itens_tipo_produto = $_POST['tes_itens_tipo_produto'];
    $tes_itens_cst_icms = $_POST['tes_itens_cst_icms'];

    try {

        $result = $auth_user->runQuery('UPDATE tes_itens SET '
                . 'tes_itens_cfop  = :tes_itens_cfop, '
                . 'tes_itens_origem = :tes_itens_origem, '
                . 'tes_itens_contribuinte = :tes_itens_contribuinte, '
                . 'tes_itens_tipo_produto = :tes_itens_tipo_produto, '
                . 'tes_itens_cst_icms  = :tes_itens_cst_icms '
                . ' WHERE tes_itens_id = :tes_itens_id');
        
        $result->execute(array(
            ':tes_itens_id' => $tes_itens_id,
            ':tes_itens_cfop' => $tes_itens_cfop,
            ':tes_itens_origem' => $tes_itens_origem,
            ':tes_itens_contribuinte' => $tes_itens_contribuinte,
            ':tes_itens_tipo_produto' => $tes_itens_tipo_produto,
            ':tes_itens_cst_icms' => $tes_itens_cst_icms
        ));

        $auth_user->redirect("tes_editar.php?id=" . $id_tes);
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//EXCLUI UMA TES ITENS DO SISTEMA
if (isset($_POST['btn-excluir-tesitens']))
{
    $tes_itens_id = strip_tags($_POST['tes_itens_id']);
    $id_tes = strip_tags($_POST['id_tes']);

    try {
        $sql = "DELETE FROM tes_itens WHERE tes_itens_id =  :tes_itens_id";
        $stmt = $auth_user->runQuery($sql);
        $stmt->bindParam(':tes_itens_id', $tes_itens_id, PDO::PARAM_INT);
        $stmt->execute();
        $auth_user->redirect("tes_editar.php?id=" . $id_tes);
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>