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

//$stmt = $auth_user->runQuery("select * from fornecedor");
//$stmt->execute();

//determina o numero de registros que serão mostrados na tela
$maximo = 5;
//pega o valor da pagina atual
$pagina = isset($_GET['pagina']) ? ($_GET['pagina']) : '1';

//subtraimos 1, porque os registros sempre começam do 0 (zero), como num array
$inicio = $pagina - 1;
//multiplicamos a quantidade de registros da pagina pelo valor da pagina atual 
$inicio = $maximo * $inicio;

//fazemos um select na tabela que iremos utilizar para saber quantos registros ela possui
$strCount = $auth_user->runQuery("SELECT COUNT(*) AS 'total_fornecedor' FROM fornecedor");
$strCount->execute();
//iniciamos uma var que será usada para armazenar a qtde de registros da tabela  
$total = 0;
if (count($strCount)) {
    foreach ($strCount as $row) {
        //armazeno o total de registros da tabela para fazer a paginação
        $total = $row["total_fornecedor"];
    }
}
//guardo o resultado na variavel pra exibir os dados na pagina		
$stmt = $auth_user->runQuery("SELECT * FROM fornecedor ORDER BY fornecedor_id DESC LIMIT $inicio,$maximo");
$stmt->execute();







//BUSCA PRODUTOS DO FORNECEDOR
if(isset($_POST['btn-produtos'])){
    
    try {
        $fornecedor_id = strip_tags($_POST['fornecedor_id']);
        //$auth_user->buscar_funcionario($funcionario_id);
//        $busca_prod_for = $auth_user->runQuery("SELECT * FROM produto_fornecedor, fornecedor"
//                . " WHERE id_fornecedor = fornecedor_id AND fornecedor_id = ?;");
//        $busca_prod_for->bindParam(1, $fornecedor_id, PDO::PARAM_STR);
//        $busca_prod_for->execute();
//        $linha = $busca_prod_for->fetch(PDO::FETCH_ASSOC);
//        if ($linha) {
           //$auth_user->redirect("fornecedor_editar.php?fornecedor_id=" . $linha['fornecedor_id']);
            $auth_user->redirect("fornecedor_produtos.php?id_fornecedor=" .$fornecedor_id );
//        } else {
//            echo 'Erro na Busca do ID Fornecedor';
//        }
        
        
        
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
    
}

// Acao para a Edicao
if (isset($_POST['btn-editar'])) {

    try {
        $fornecedor_id = strip_tags($_POST['fornecedor_id']);
        //$auth_user->buscar_funcionario($funcionario_id);
        $consulta = $auth_user->runQuery("SELECT * FROM fornecedor WHERE fornecedor_id = ?;");
        $consulta->bindParam(1, $fornecedor_id, PDO::PARAM_STR);
        $consulta->execute();
        $linha = $consulta->fetch(PDO::FETCH_ASSOC);
        if ($linha) {
            $auth_user->redirect("fornecedor_editar.php?fornecedor_id=" . $linha['fornecedor_id']);
        } else {
            echo 'Erro na Busca do ID Fornecedor';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//INATIVAR TRANSPORTADOR
if (isset($_POST['btn-inativar'])) {
    $fornecedor_id = strip_tags($_POST['fornecedor_id']);
    $status = 0;

    try {

        $result = $auth_user->runQuery('UPDATE fornecedor SET '
                . 'fornecedor_status  = :status '
                . ' WHERE fornecedor_id = :fornecedor_id');

        $result->execute(array(
            ':fornecedor_id' => $fornecedor_id,
            ':status' => $status
        ));

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//ATIVAR TRANSPORTADOR
if (isset($_POST['btn-ativar'])) {
    $fornecedor_id = strip_tags($_POST['fornecedor_id']);
    $status = 1;

    try {

        $result = $auth_user->runQuery('UPDATE fornecedor SET '
                . 'fornecedor_status  = :status '
                . ' WHERE fornecedor_id = :fornecedor_id');

        $result->execute(array(
            ':fornecedor_id' => $fornecedor_id,
            ':status' => $status
        ));

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Botao Salvar a Edicao
if (isset($_POST['btn-salvar'])) {


    $fornecedor_id = $_POST['fornecedor_id'];
    $fornecedor_status = $_POST['fornecedor_status'];
    $fornecedor_nome = strtoupper($_POST['fornecedor_nome']);
    $fornecedor_fantasia = strtoupper($_POST['fornecedor_fantasia']);
    $fornecedor_cnpj = $_POST['fornecedor_cnpj'];
    $fornecedor_logradouro = strtoupper($_POST['fornecedor_logradouro']);
    $fornecedor_numero = strtoupper($_POST['fornecedor_numero']);
    $fornecedor_complemento = strtoupper($_POST['fornecedor_complemento']);
    $fornecedor_bairro = strtoupper($_POST['fornecedor_bairro']);
    $fornecedor_nome_municipio = strtoupper($_POST['fornecedor_nome_municipio']);
    $fornecedor_uf = strtoupper($_POST['fornecedor_uf']);
    $fornecedor_cep = $_POST['fornecedor_cep'];
    $fornecedor_telefone = $_POST['fornecedor_telefone'];
    $fornecedor_email = $_POST['fornecedor_email'];
    $fornecedor_ie = $_POST['fornecedor_ie'];

    try {

        $result = $auth_user->runQuery('UPDATE fornecedor SET '
                . 'fornecedor_status  = :fornecedor_status, '
                . 'fornecedor_nome  = :fornecedor_nome, '
                . 'fornecedor_fantasia  = :fornecedor_fantasia, '
                . 'fornecedor_cnpj  = :fornecedor_cnpj, '
                . 'fornecedor_logradouro  = :fornecedor_logradouro, '
                . 'fornecedor_numero  = :fornecedor_numero, '
                . 'fornecedor_complemento  = :fornecedor_complemento, '
                . 'fornecedor_bairro  = :fornecedor_bairro, '
                . 'fornecedor_nome_municipio  = :fornecedor_nome_municipio, '
                . 'fornecedor_uf  = :fornecedor_uf, '
                . 'fornecedor_cep  = :fornecedor_cep, '
                . 'fornecedor_telefone  = :fornecedor_telefone, '
                . 'fornecedor_email  = :fornecedor_email, '
                . 'fornecedor_ie  = :fornecedor_ie '
                . ' WHERE fornecedor_id = :fornecedor_id');


        $result->execute(array(
            ':fornecedor_id' => $fornecedor_id,
            ':fornecedor_status' => $fornecedor_status,
            ':fornecedor_nome' => $fornecedor_nome,
            ':fornecedor_fantasia' => $fornecedor_fantasia,
            ':fornecedor_cnpj' => $fornecedor_cnpj,
            ':fornecedor_logradouro' => $fornecedor_logradouro,
            ':fornecedor_numero' => $fornecedor_numero,
            ':fornecedor_complemento' => $fornecedor_complemento,
            ':fornecedor_bairro' => $fornecedor_bairro,
            ':fornecedor_nome_municipio' => $fornecedor_nome_municipio,
            ':fornecedor_uf' => $fornecedor_uf,
            ':fornecedor_cep' => $fornecedor_cep,
            ':fornecedor_telefone' => $fornecedor_telefone,
            ':fornecedor_email' => $fornecedor_email,
            ':fornecedor_ie' => $fornecedor_ie
        ));

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Cadastrar NCM
if (isset($_POST['btn-cadastro'])) {

    $fornecedor_status = $_POST['fornecedor_status'];
    $fornecedor_tipo_cadastro = 'Normal';
    $fornecedor_nome = strtoupper($_POST['fornecedor_nome']);
    $fornecedor_fantasia = strtoupper($_POST['fornecedor_fantasia']);
    $fornecedor_cnpj = $_POST['fornecedor_cnpj'];
    $fornecedor_logradouro = strtoupper($_POST['fornecedor_logradouro']);
    $fornecedor_numero = strtoupper($_POST['fornecedor_numero']);
    $fornecedor_complemento = strtoupper($_POST['fornecedor_complemento']);
    $fornecedor_bairro = strtoupper($_POST['fornecedor_bairro']);
    $fornecedor_nome_municipio = strtoupper($_POST['fornecedor_nome_municipio']);
    $fornecedor_uf = strtoupper($_POST['fornecedor_uf']);
    $fornecedor_cep = $_POST['fornecedor_cep'];
    $fornecedor_telefone = $_POST['fornecedor_telefone'];
    $fornecedor_email = $_POST['fornecedor_email'];
    $fornecedor_ie = $_POST['fornecedor_ie'];

    try {
        $stmt_ins = $auth_user->runQuery("INSERT INTO fornecedor
            (fornecedor_status,
            fornecedor_tipo_cadastro,
            fornecedor_nome,
            fornecedor_fantasia,
            fornecedor_cnpj,
            fornecedor_logradouro,
            fornecedor_numero,
            fornecedor_complemento,
            fornecedor_bairro,
            fornecedor_nome_municipio,
            fornecedor_uf,
            fornecedor_cep,
            fornecedor_telefone,
            fornecedor_email,
            fornecedor_ie)
            VALUES(
            :fornecedor_status,
            :fornecedor_tipo_cadastro,
            :fornecedor_nome,
            :fornecedor_fantasia,
            :fornecedor_cnpj,
            :fornecedor_logradouro,
            :fornecedor_numero,
            :fornecedor_complemento,
            :fornecedor_bairro,
            :fornecedor_nome_municipio,
            :fornecedor_uf,
            :fornecedor_cep,
            :fornecedor_telefone,
            :fornecedor_email,
            :fornecedor_ie)");


        $stmt_ins->bindparam(":fornecedor_status", $fornecedor_status);
        $stmt_ins->bindparam(":fornecedor_tipo_cadastro", $fornecedor_tipo_cadastro);
        $stmt_ins->bindparam(":fornecedor_nome", $fornecedor_nome);
        $stmt_ins->bindparam(":fornecedor_fantasia", $fornecedor_fantasia);
        $stmt_ins->bindparam(":fornecedor_cnpj", $fornecedor_cnpj);
        $stmt_ins->bindparam(":fornecedor_logradouro", $fornecedor_logradouro);
        $stmt_ins->bindparam(":fornecedor_numero", $fornecedor_numero);
        $stmt_ins->bindparam(":fornecedor_complemento", $fornecedor_complemento);
        $stmt_ins->bindparam(":fornecedor_bairro", $fornecedor_bairro);
        $stmt_ins->bindparam(":fornecedor_nome_municipio", $fornecedor_nome_municipio);
        $stmt_ins->bindparam(":fornecedor_uf", $fornecedor_uf);
        $stmt_ins->bindparam(":fornecedor_cep", $fornecedor_cep);
        $stmt_ins->bindparam(":fornecedor_telefone", $fornecedor_telefone);
        $stmt_ins->bindparam(":fornecedor_email", $fornecedor_email);
        $stmt_ins->bindparam(":fornecedor_ie", $fornecedor_ie);

        $stmt_ins->execute();

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Botao de Pesquisa
if (isset($_POST['btn-pesquisar'])) {
    //$funcionario_id = strip_tags($_POST['funcionario_id']);

    $pesquisa = $_POST['fornecedor_pesquisa'];
    $pesquisa2 = $_POST['fornecedor_pesquisa'];
    try {

        if (isset($pesquisa) && !empty($pesquisa2)) {
            $stmt = $auth_user->runQuery("SELECT * FROM fornecedor"
                    . " WHERE fornecedor_nome like :nome OR "
                    . "fornecedor_fantasia like :fantasia");
            $stmt->bindValue(':nome', '%' . $pesquisa2 . '%', PDO::PARAM_STR);
            $stmt->bindValue(':fantasia', '%' . $pesquisa . '%', PDO::PARAM_STR);
            $stmt->execute();
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>