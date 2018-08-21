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


//determina o numero de registros que serão mostrados na tela
$maximo = 5;
//pega o valor da pagina atual
$pagina = isset($_GET['pagina']) ? ($_GET['pagina']) : '1';

//subtraimos 1, porque os registros sempre começam do 0 (zero), como num array
$inicio = $pagina - 1;
//multiplicamos a quantidade de registros da pagina pelo valor da pagina atual 
$inicio = $maximo * $inicio;
//fazemos um select na tabela que iremos utilizar para saber quantos registros ela possui
$strCount = $auth_user->runQuery("SELECT COUNT(*) AS 'total_municipio' FROM municipio");
$strCount->execute();
//iniciamos uma var que será usada para armazenar a qtde de registros da tabela  
$total = 0;
if (count($strCount)) {
    foreach ($strCount as $row) {
        //armazeno o total de registros da tabela para fazer a paginação
        $total = $row["total_municipio"];
    }
}

$stmt = $auth_user->runQuery("SELECT * FROM municipio, estado WHERE id_estado = estado_id ORDER BY municipio_id DESC LIMIT $inicio,$maximo");
$stmt->execute();

// Acao para a Edicao
if (isset($_POST['btn-editar'])) {

    try {
        $municipio_id = strip_tags($_POST['municipio_id']);
        //$auth_user->buscar_funcionario($funcionario_id);
        $consulta = $auth_user->runQuery("SELECT * FROM municipio WHERE municipio_id = ?;");
        $consulta->bindParam(1, $municipio_id, PDO::PARAM_STR);
        $consulta->execute();
        $linha = $consulta->fetch(PDO::FETCH_ASSOC);
        if ($linha) {
            $auth_user->redirect("municipio_editar.php?id=" . $linha['municipio_id']);
        } else {
            echo 'Erro na Busca do ID Municpio';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Botao Salvar a Edicao
if (isset($_POST['btn-salvar'])) {

    $id = $_POST['municipio_id'];
    $cod_ibge = $_POST['municipio_cod_ibge'];
    $nome = $_POST['municipio_nome'];
    $id_estado = $_POST['id_estado'];


    // $data_cadastro = $_POST['produto_data_cadastro'];
    //$id_uni = $_POST['id_unidade'];
    //$id_ncm = $_POST['id_ncm'];

    try {

        $result = $auth_user->runQuery('UPDATE municipio SET '
                . 'municipio_cod_ibge  = :cod_ibge, '
                . 'municipio_nome = :nome, '
                . 'id_estado = :id_estado '
                // . 'produto_data_cadastro = :data_cadastro'
                . ' WHERE municipio_id = :id');


        $result->execute(array(
            ':id' => $id,
            ':cod_ibge' => $cod_ibge,
            ':nome' => $nome,
            ':id_estado' => $id_estado
        ));

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Cadastrar NCM
if (isset($_POST['btn-cadastro'])) {

    $cod_ibge = $_POST['municipio_cod_ibge'];
    $nome = strtoupper($_POST['municipio_nome']);
    $id_estado = $_POST['id_estado'];
    try {
        $stmt = $auth_user->runQuery("INSERT INTO municipio
            (municipio_id,municipio_cod_ibge,municipio_nome, id_estado)
            VALUES('',:cod_ibge, :nome, :id_estado)");
        $stmt->bindparam(":cod_ibge", $cod_ibge);
        $stmt->bindparam(":nome", $nome);
        $stmt->bindparam(":id_estado", $id_estado);
        $stmt->execute();

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Botao de Pesquisa
if (isset($_POST['btn-pesquisar'])) {
    //$funcionario_id = strip_tags($_POST['funcionario_id']);

    $pesquisa = $_POST['municipio_pesquisa'];
    $pesquisa2 = strtoupper($_POST['municipio_pesquisa']);
    try {

        if (isset($pesquisa) && !empty($pesquisa2)) {
            $stmt = $auth_user->runQuery("SELECT * FROM municipio, estado"
                    . " WHERE id_estado = estado_id AND municipio_nome like :nome OR "
                    . "municipio_cod_ibge like :cod_ibge");
            $stmt->bindValue(':nome', '%' . $pesquisa2 . '%', PDO::PARAM_STR);
            $stmt->bindValue(':cod_ibge', '%' . $pesquisa . '%', PDO::PARAM_STR);
            $stmt->execute();
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>