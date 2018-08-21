<?php

require_once('conexao.php');

$opcao = isset($_GET['opcao']) ? $_GET['opcao'] : '';
$valor = isset($_GET['valor']) ? $_GET['valor'] : '';

if (!empty($opcao)) {
    switch ($opcao) {

        case 'estado': {
                echo getFilterEstado($valor);
                break;
            }
        case 'cidade': {
                echo getFilterCidade($valor);
                break;
            }
        case 'pis' : {
                echo filtroPis($valor);
                break;
            }
        case 'ipi' : {
                echo filtroIpi($valor);
                break;
            }  
        case 'cofins' : {
                echo filtroCofins($valor);
                break;
            }
    }
}

function getFilterEstado($pais) {
    $pdo = Conectar();
    //$sql = 'SELECT sigla, nome FROM estado WHERE pais = ?';
    $sql = 'SELECT * FROM icms';
    $stm = $pdo->prepare($sql);
    //$stm->bindValue(1, $pais);
    $stm->execute();
    //sleep(1);
    echo json_encode($stm->fetchAll(PDO::FETCH_ASSOC));
    $pdo = null;
}

function filtroPis($estado) {
    $pdo = Conectar();
    $sql = 'SELECT * FROM pis WHERE pis_tipo = ?';
    $stm = $pdo->prepare($sql);
    $stm->bindValue(1, $estado);
    $stm->execute();
    //sleep(1);
    echo json_encode($stm->fetchAll(PDO::FETCH_ASSOC));
    $pdo = null;
}

function filtroIpi($estado) {
    $pdo = Conectar();
    $sql = 'SELECT * FROM ipi WHERE ipi_tipo = ?';
    $stm = $pdo->prepare($sql);
    $stm->bindValue(1, $estado);
    $stm->execute();
    //sleep(1);
    echo json_encode($stm->fetchAll(PDO::FETCH_ASSOC));
    $pdo = null;
}
function filtroCofins($estado) {
    $pdo = Conectar();
    $sql = 'SELECT * FROM cofins WHERE cofins_tipo = ?';
    $stm = $pdo->prepare($sql);
    $stm->bindValue(1, $estado);
    $stm->execute();
    //sleep(1);
    echo json_encode($stm->fetchAll(PDO::FETCH_ASSOC));
    $pdo = null;
}

function getFilterCidade($estado) {
    $pdo = Conectar();
    $sql = 'SELECT * FROM `icms` WHERE icms_tipo = ?';
    $stm = $pdo->prepare($sql);
    $stm->bindValue(1, $estado);
    $stm->execute();
    //sleep(1);
    echo json_encode($stm->fetchAll(PDO::FETCH_ASSOC));
    $pdo = null;
}

?>