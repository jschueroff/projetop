<?php

require_once("../class/session.php");
require_once '../class/conexao.class.php';
require_once("../class/class.user.php");

$auth_user = new USER();

//VERIFICAR A SESSAO
$user_id = $_SESSION['user_session'];
$stmt = $auth_user->runQuery("SELECT * FROM funcionarios WHERE funcionario_id=:user_id");
$stmt->execute(array(":user_id" => $user_id));
$userRow = $stmt->fetch(PDO::FETCH_ASSOC);

$stm = $auth_user->runQuery("SELECT * FROM produto ORDER BY produto_id DESC LIMIT 0,0");
$stm->execute();


//ITENS DO PEDIDO PARA A EMISSAO DA NFE
if (isset($_POST['btn-cadastro'])) {

    date_default_timezone_set('America/Sao_Paulo');
    $data = date('Y-m-d H:i:s');
    $id_pedido = $_POST['id_pedido'];
    $id_produto = $_POST['id_produto'];
    $pedido_itens_qtd = str_replace(",", ".", $_POST['pedido_itens_qtd']);
    $pedido_itens_valor = str_replace(",", ".", $_POST['pedido_itens_valor']);
    $pedido_itens_total = $pedido_itens_qtd * $pedido_itens_valor;
    $pedido_itens_valor_frete = str_replace(",", ".", $_POST['pedido_itens_valor_frete']);
    $pedido_itens_valor_seguro = str_replace(",", ".", $_POST['pedido_itens_valor_seguro']);
    $pedido_itens_valor_desconto = str_replace(",", ".", $_POST['pedido_itens_valor_desconto']);
    $pedido_itens_outras_despesas = str_replace(",", ".", $_POST['pedido_itens_outras_despesas']);
    $pedido_itens_descricao = $_POST['pedido_itens_descricao'];


    $pedido_itens_numero_compra = $_POST['pedido_itens_numero_compra'];
    $pedido_itens_item_compra = $_POST['pedido_itens_item_compra'];

    $pedido_itens_id_st = $_POST['pedido_itens_id_st'];
    $pedido_itens_id_tes = $_POST['pedido_itens_id_tes'];

    try {

        $stmt = $auth_user->runQuery("INSERT INTO pedido_itens
            (
            id_produto,
            id_pedido, 
            pedido_itens_qtd,
            pedido_itens_valor, 
            pedido_itens_total,
            pedido_itens_data_cadastro,
            pedido_itens_numero_compra,
            pedido_itens_item_compra,
            pedido_itens_id_st,
            pedido_itens_id_tes,
            pedido_itens_valor_frete,
            pedido_itens_valor_seguro,
            pedido_itens_valor_desconto,
            pedido_itens_outras_despesas, 
            pedido_itens_descricao)
            VALUES(
            :id_produto,
            :id_pedido, 
            :pedido_itens_qtd,
            :pedido_itens_valor, 
            :pedido_itens_total,
            :pedido_itens_data_cadastro,
            :pedido_itens_numero_compra,
            :pedido_itens_item_compra,
            :pedido_itens_id_st,
            :pedido_itens_id_tes,
            :pedido_itens_valor_frete,
            :pedido_itens_valor_seguro,
            :pedido_itens_valor_desconto,
            :pedido_itens_outras_despesas, 
            :pedido_itens_descricao)");

        $stmt->bindparam(":id_produto", $id_produto);
        $stmt->bindparam(":id_pedido", $id_pedido);
        $stmt->bindparam(":pedido_itens_qtd", $pedido_itens_qtd);
        $stmt->bindparam(":pedido_itens_valor", $pedido_itens_valor);
        $stmt->bindparam(":pedido_itens_total", $pedido_itens_total);
        $stmt->bindparam(":pedido_itens_data_cadastro", $data);

        $stmt->bindparam(":pedido_itens_numero_compra", $pedido_itens_numero_compra);
        $stmt->bindparam(":pedido_itens_item_compra", $pedido_itens_item_compra);

        $stmt->bindparam(":pedido_itens_id_st", $pedido_itens_id_st);
        $stmt->bindparam(":pedido_itens_id_tes", $pedido_itens_id_tes);
        $stmt->bindparam(":pedido_itens_valor_frete", $pedido_itens_valor_frete);
        $stmt->bindparam(":pedido_itens_valor_seguro", $pedido_itens_valor_seguro);
        $stmt->bindparam(":pedido_itens_valor_desconto", $pedido_itens_valor_desconto);
        $stmt->bindparam(":pedido_itens_outras_despesas", $pedido_itens_outras_despesas);
        $stmt->bindparam(":pedido_itens_descricao", $pedido_itens_descricao);
        $stmt->execute();
        //BUSCA NO CADASTRO DAS CONFIGURAÇÕES DO SISTEMA SE PODE CALCULAR AUTOMATICO O PESO E O VOLUME

        $busca_peso = $auth_user->runQuery("SELECT * FROM configura");
        $busca_peso->execute();
        $busca_i = $busca_peso->fetch(PDO::FETCH_ASSOC);

        if ($busca_i['configura_calculo_peso'] == TRUE) {
            //ATUALIZA O PESO DO PEDIDO DE ACORDO COM O CADASTRO DO PRODUTO
            $stmt_peso = $auth_user->runQuery("UPDATE pedido SET 
              pedido_peso_liquido = (( SELECT sum(produto_peso_liquido)  FROM pedido_itens, produto WHERE 
              id_produto = produto_id and id_pedido = :id_pedido)* :pedido_itens_qtd) ,
              pedido_peso_bruto = (( SELECT sum(produto_peso_bruto)  FROM pedido_itens, produto WHERE 
              id_produto = produto_id and id_pedido = :id_pedido)* :pedido_itens_qtd)               
              WHERE pedido_id = :id_pedido ");
            $stmt_peso->execute(array(
                ':id_pedido' => $id_pedido,
                ":pedido_itens_qtd" => $pedido_itens_qtd
            ));
        }
        // $auth_user->redirect("../pedido/pedido_editar.php?id=".$id_pedido);
        $auth_user->redirect("index.php?id=" . $id_pedido);
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Botao de Pesquisa
if (isset($_POST['btn-pesquisar'])) {
    //$funcionario_id = strip_tags($_POST['funcionario_id']);
    $pesquisa = strtoupper($_POST['produto_pesquisa']);
    $pesquisa2 = strtoupper($_POST['produto_pesquisa']);
    try {

        if (isset($pesquisa) && !empty($pesquisa2)) {
            $stm = $auth_user->runQuery("SELECT * FROM  produto AS p
LEFT JOIN  estoque  AS e  ON (p.produto_id = e.estoque_id_produto)
WHERE produto_status = 1 AND produto_nome like :nome OR "
                    . "produto_id like :id ");
            $stm->bindValue(':nome', '%' . $pesquisa2 . '%', PDO::PARAM_STR);
            $stm->bindValue(':id', '%' . $pesquisa . '%', PDO::PARAM_STR);
            $stm->execute();
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
//CADASTRO DE OUTRAS INFORMAÇÕES NO PEDIDO
if (isset($_POST['btn-cadastro_outras_informacoes'])) {
    $id_pedido = $_POST['id_pedido'];
    $id_transportador = $_POST['id_transportador'];
    $pedido_valor_frete = str_replace(",", ".", strip_tags($_POST['pedido_valor_frete']));
    $pedido_valor_frete = number_format($pedido_valor_frete, 2, '.', '');

    try {
        $result = $auth_user->runQuery('UPDATE pedido SET '
                . 'id_transportador = :id_transportador, '
                . 'pedido_valor_frete = :pedido_valor_frete '
                . ' WHERE pedido_id = :id_pedido');
        $result->execute(array(
            ':id_pedido' => $id_pedido,
            ':id_transportador' => $id_transportador,
            ':pedido_valor_frete' => $pedido_valor_frete
        ));
        $auth_user->redirect("index.php?id=" . $id_pedido);
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//CADASTRO DE OUTRAS INFORMAÇÕES NO PEDIDO
if (isset($_POST['btn-cadastro_dadonfe'])) {
    $id_pedido = $_POST['id_pedido'];
    $pedido_peso_liquido = str_replace(",", ".", strip_tags($_POST['pedido_peso_liquido']));
    $pedido_peso_liquido = number_format($pedido_peso_liquido, 3, '.', '');
    $pedido_peso_bruto = str_replace(",", ".", strip_tags($_POST['pedido_peso_bruto']));
    $pedido_peso_bruto = number_format($pedido_peso_bruto, 3, '.', '');
    $pedido_quantidade = $_POST['pedido_quantidade'];
    $pedido_especie = $_POST['pedido_especie'];
    $pedido_marca = $_POST['pedido_marca'];
    $pedido_inf_nfe = $_POST['pedido_inf_nfe'];
    $pedido_inf_comp = $_POST['pedido_inf_comp'];
    $pedido_referencia = $_POST['pedido_referencia'];

    try {
        $result = $auth_user->runQuery('UPDATE pedido SET '
                . 'pedido_peso_liquido = :pedido_peso_liquido, '
                . 'pedido_peso_bruto = :pedido_peso_bruto, '
                . 'pedido_quantidade = :pedido_quantidade, '
                . 'pedido_especie = :pedido_especie, '
                . 'pedido_marca = :pedido_marca, '
                . 'pedido_inf_nfe = :pedido_inf_nfe, '
                . 'pedido_inf_comp = :pedido_inf_comp, '
                . 'pedido_referencia = :pedido_referencia '
                . ' WHERE pedido_id = :id_pedido');
        $result->execute(array(
            ':id_pedido' => $id_pedido,
            ':pedido_peso_liquido' => $pedido_peso_liquido,
            ':pedido_peso_bruto' => $pedido_peso_bruto,
            ':pedido_quantidade' => $pedido_quantidade,
            ':pedido_especie' => $pedido_especie,
            ':pedido_marca' => $pedido_marca,
            ':pedido_inf_nfe' => $pedido_inf_nfe,
            ':pedido_inf_comp' => $pedido_inf_comp,
            ':pedido_referencia' => $pedido_referencia
        ));
        $auth_user->redirect("index.php?id=" . $id_pedido);
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>