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
$strCount = $auth_user->runQuery("SELECT COUNT(*) AS 'total_produto' FROM produto");
$strCount->execute();
//iniciamos uma var que será usada para armazenar a qtde de registros da tabela  
$total = 0;
if (count($strCount)) {
    foreach ($strCount as $row) {
        //armazeno o total de registros da tabela para fazer a paginação
        $total = $row["total_produto"];
    }
}

$stmt = $auth_user->runQuery("SELECT * FROM ncm, unidade, produto AS p
LEFT JOIN  estoque  AS e  ON (p.produto_id = e.estoque_id_produto) WHERE 
id_ncm = ncm_id AND unidade_id = id_unidade ORDER BY produto_id DESC LIMIT $inicio,$maximo");
$stmt->execute();

// Acao para a Edicao
if (isset($_POST['btn-editar'])) {

    try {
        $produto_id = strip_tags($_POST['produto_id']);
        //$auth_user->buscar_funcionario($funcionario_id);
        $consulta = $auth_user->runQuery("SELECT * FROM produto WHERE produto_id = ?;");
        $consulta->bindParam(1, $produto_id, PDO::PARAM_STR);
        $consulta->execute();
        $linha = $consulta->fetch(PDO::FETCH_ASSOC);
        if ($linha) {
            $auth_user->redirect("produto_editar.php?id=" . $linha['produto_id']);
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//ACAO PARA INATIVAÇÃO DO PRODUTO
if (isset($_POST['btn-inativar'])) {
    $produto_id = strip_tags($_POST['produto_id']);
    try {
        $result = $auth_user->runQuery('UPDATE produto SET '
                . 'produto_status  = 0 WHERE produto_id = :produto_id');
        $result->execute(array(
            ':produto_id' => $produto_id
        ));
        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//ACAO PARA ATIVACAO DO PRODUTO
if (isset($_POST['btn-ativar'])) {
    $produto_id = strip_tags($_POST['produto_id']);
    try {
        $result = $auth_user->runQuery('UPDATE produto SET '
                . 'produto_status  = 1 WHERE produto_id = :produto_id');
        $result->execute(array(
            ':produto_id' => $produto_id
        ));
        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//EDITA DADOS DO PRODUTO
if (isset($_POST['btn-salvar'])) {

    $id_unidade = strtoupper($_POST['id_unidade']);
    $id_ncm = strtoupper($_POST['id_ncm']);
    $id_grupo = strtoupper($_POST['id_grupo']);
    $id_st = $_POST['id_st'];


    $produto_id = $_POST['produto_id'];
    $produto_codigo = $_POST['produto_codigo'];
    $produto_nome = strtoupper($_POST['produto_nome']);
    $produto_descricao = strtoupper($_POST['produto_descricao']);
    $produto_preco = str_replace(",", ".", strip_tags($_POST['produto_preco']));
    $produto_ean = $_POST['produto_ean'];
    $produto_categoria = $_POST['produto_categoria'];
    $produto_peso_liquido = str_replace(",", ".", strip_tags($_POST['produto_peso_liquido']));
    // $pedido_itens_valor = str_replace(",", ".", strip_tags($_POST['pedido_itens_valor']));
    $produto_peso_bruto = str_replace(",", ".", strip_tags($_POST['produto_peso_bruto']));
    $produto_controle_estoque = $_POST['produto_controle_estoque'];
    $produto_origem = $_POST['produto_origem'];

    try {
        $result = $auth_user->runQuery('UPDATE produto SET '
                . 'id_unidade  = :id_unidade, '
                . 'id_ncm  = :id_ncm, '
                . 'id_grupo  = :id_grupo, '
                . 'id_st  = :id_st, '
                . 'produto_codigo  = :produto_codigo, '
                . 'produto_nome  = :produto_nome, '
                . 'produto_descricao  = :produto_descricao ,'
                . 'produto_preco = :produto_preco, '
                . 'produto_ean = :produto_ean ,'
                . 'produto_categoria = :produto_categoria ,'
                . 'produto_peso_liquido = :produto_peso_liquido ,'
                . 'produto_peso_bruto = :produto_peso_bruto ,'
                . 'produto_controle_estoque = :produto_controle_estoque,'
                . 'produto_origem = :produto_origem'
                . ' WHERE produto_id = :produto_id');
        $result->execute(array(
            ':produto_id' => $produto_id,
            ':id_unidade' => $id_unidade,
            ':id_ncm' => $id_ncm,
            ':id_grupo' => $id_grupo,
            ':id_st' => $id_st,
            ':produto_codigo' => $produto_codigo,
            ':produto_nome' => $produto_nome,
            ':produto_descricao' => $produto_descricao,
            ':produto_preco' => $produto_preco,
            ':produto_ean' => $produto_ean,
            ':produto_categoria' => $produto_categoria,
            ':produto_peso_liquido' => $produto_peso_liquido,
            ':produto_peso_bruto' => $produto_peso_bruto,
            ':produto_controle_estoque' => $produto_controle_estoque,
            ':produto_origem' => $produto_origem
        ));
        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        echo $e->getLine();
    }
}
//CADASTRO DOS PRODUTOS
if (isset($_POST['btn-cadastro'])) {
    
    //CADASTRO GERAIS DO PRODUTO
    $id_unidade = strtoupper($_POST['id_unidade']);
    $id_ncm = strtoupper($_POST['id_ncm']);
    $id_grupo = strtoupper($_POST['id_grupo']);
    $produto_codigo = $_POST['produto_codigo'];
    $produto_nome = strtoupper($_POST['produto_nome']);
    $produto_descricao = strtoupper($_POST['produto_descricao']);
    $produto_preco = $_POST['produto_preco'];
    $produto_ean = $_POST['produto_ean'];
    date_default_timezone_set('America/Sao_Paulo');
    $produto_data_cadastro = date('Y-m-d H:i:s');
    $produto_status = true;
    $produto_categoria = $_POST['produto_categoria'];
    $produto_peso_liquido = str_replace(",", ".", strip_tags($_POST['produto_peso_liquido']));
    // $pedido_itens_valor = str_replace(",", ".", strip_tags($_POST['pedido_itens_valor']));
    $produto_peso_bruto = str_replace(",", ".", strip_tags($_POST['produto_peso_bruto']));
    $produto_controle_estoque = $_POST['produto_controle_estoque'];
    
    //TRIBUTAÇÃO DO PRODUTO
    $id_st = $_POST['id_st'];
    $produto_origem = $_POST['produto_origem'];
    

    try {
        $stmt = $auth_user->runQuery("INSERT INTO produto
            (
            id_unidade,
            id_ncm,
            id_grupo,
            id_st,
            produto_codigo,
            produto_nome,
            produto_descricao,
            produto_preco,
            produto_ean,
            produto_data_cadastro,
            produto_status,
            produto_categoria, 
            produto_peso_liquido,
            produto_peso_bruto, 
            produto_controle_estoque,
            produto_origem
            )VALUES(
            :id_unidade,
            :id_ncm,
            :id_grupo,
            :id_st,
            :produto_codigo,
            :produto_nome,
            :produto_descricao,
            :produto_preco,
            :produto_ean,
            :produto_data_cadastro,
            :produto_status,
            :produto_categoria,
            :produto_peso_liquido,
            :produto_peso_bruto,
            :produto_controle_estoque,
            :produto_origem
            )");

        $stmt->bindparam(":id_unidade", $id_unidade);
        $stmt->bindparam(":id_ncm", $id_ncm);
        $stmt->bindparam(":id_grupo", $id_grupo);
        $stmt->bindparam(":id_st", $id_st);
        $stmt->bindparam(":produto_codigo", $produto_codigo);
        $stmt->bindparam(":produto_nome", $produto_nome);
        $stmt->bindparam(":produto_descricao", $produto_descricao);
        $stmt->bindparam(":produto_preco", $produto_preco);
        $stmt->bindparam(":produto_ean", $produto_ean);
        $stmt->bindparam(":produto_data_cadastro", $produto_data_cadastro);
        $stmt->bindparam(":produto_status", $produto_status);
        $stmt->bindparam(":produto_categoria", $produto_categoria);
        $stmt->bindparam(":produto_peso_liquido", $produto_peso_liquido);
        $stmt->bindparam(":produto_peso_bruto", $produto_peso_bruto);
        $stmt->bindparam(":produto_controle_estoque", $produto_controle_estoque);
        $stmt->bindparam(":produto_origem", $produto_origem);
        $stmt->execute();
        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Botao de Pesquisa
if (isset($_POST['btn-pesquisar'])) {
    //$funcionario_id = strip_tags($_POST['funcionario_id']);

    $pesquisa = strtoupper($_POST['produto_pesquisa']);
    try {
        if (isset($pesquisa) && !empty($pesquisa)) {
            $stmt = $auth_user->runQuery("SELECT * FROM ncm, unidade, produto AS p
LEFT JOIN  estoque  AS e  ON (p.produto_id = e.estoque_id_produto) WHERE id_ncm = ncm_id AND 
                unidade_id = id_unidade AND produto_nome LIKE :nome");
            $stmt->bindValue(':nome', '%' . $pesquisa . '%', PDO::PARAM_STR);
            $stmt->execute();
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>