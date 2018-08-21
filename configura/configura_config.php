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


if(isset($_POST['btn-cadastro_config'])){
    $configura_calculo_peso = $_POST['configura_calculo_peso'];
    $configura_calculo_volume = $_POST['configura_calculo_volume'];
     try {
        $configura = $auth_user->runQuery('UPDATE configura SET '
                . 'configura_calculo_peso = :configura_calculo_peso, '
                . 'configura_calculo_volume = :configura_calculo_volume '
                . ' WHERE configura_id = 1');
        $configura->execute(array(
            ':configura_calculo_peso' => $configura_calculo_peso,
            ':configura_calculo_volume' => $configura_calculo_volume
        ));
        //$auth_user->redirect("index.php?id=" . $id_pedido);
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}



?>