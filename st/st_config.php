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

$stmt = $auth_user->runQuery("SELECT * FROM st, estado where id_estado = estado_id ORDER BY st_id ASC");
$stmt->execute();
//==========>>SITUACAO TRIBUTARIA <<================
// BUSCAR ST PARA A EDICAO
if (isset($_POST['btn-editar'])) {

    try {
        $st_id = strip_tags($_POST['st_id']);
        //$auth_user->buscar_funcionario($funcionario_id);
        $consulta = $auth_user->runQuery("SELECT * FROM st WHERE st_id = ?;");
        $consulta->bindParam(1, $st_id, PDO::PARAM_STR);
        $consulta->execute();
        $linha = $consulta->fetch(PDO::FETCH_ASSOC);
        if ($linha) {
            $auth_user->redirect("st_editar.php?id=" . $linha['st_id']);
        } else {
            echo 'Erro na Busca do ID DA ST';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//INATIVAR UMA ST DO SISTEMA
if (isset($_POST['btn-inativar'])) {
    $st_id = strip_tags($_POST['st_id']);
    $status = false;

    try {
        $result = $auth_user->runQuery('UPDATE st SET '
                . 'st_status  = :status '
                . ' WHERE st_id = :id');
        $result->execute(array(
            ':id' => $st_id,
            ':status' => $status
        ));

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//ATIVAR UMA ST DO SISTEMA
if (isset($_POST['btn-ativar'])) {
    $st_id = strip_tags($_POST['st_id']);
    $status = true;

    try {
        $result = $auth_user->runQuery('UPDATE st SET '
                . 'st_status  = :status '
                . ' WHERE st_id = :id');
        $result->execute(array(
            ':id' => $st_id,
            ':status' => $status
        ));

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//SALVAR DADOS DEPOIS DE EDITADOS
if (isset($_POST['btn-salvar'])) {

//    $id = $_POST['st_id'];
//    $nome = strtoupper($_POST['st_nome']);
//    $uf = $_POST['st_uf'];
//
//    $id_estado = $_POST['st_uf'];
//    $id_icms = $_POST['id_icms'];
//    $id_pis = $_POST['id_pis'];
//    $id_ipi = $_POST['id_ipi'];
//    $st_ipi_classe = $_POST['st_ipi_classe'];
//    $st_ipi_cod = $_POST['st_ipi_cod'];
//    $st_ipi_tipo_calculo = $_POST['st_ipi_tipo_calculo'];
//    $st_ipi_aliquota = $_POST['st_ipi_aliquota'];

    //DADOS DA ST 
    $id = $_POST['st_id'];
    $nome = strtoupper($_POST['st_nome']);
    $uf = $_POST['st_uf'];
    $status = true;

    //DADOS DA ST DO PIS
    $id_pis = $_POST['id_pis'];
    $st_pis_regime_apuracao = $_POST['st_pis_regime_apuracao'];
    
    $st_pis_aliquota = $_POST['st_pis_aliquota'];
    $st_pis_aliquota = str_replace(",", ".", $st_pis_aliquota);
    
    $st_pis_tipo_calculo = $_POST['st_pis_tipo_calculo'];
    $st_pis_tipo_calculo_st = $_POST['st_pis_tipo_calculo_st'];
    
    $st_pis_aliquota_st = $_POST['st_pis_aliquota_st'];
    $st_pis_aliquota_st = str_replace(",", ".", $st_pis_aliquota_st);

    // DADOS DA ST DO IPI
    $id_ipi = $_POST['id_ipi'];
    $st_ipi_classe = $_POST['st_ipi_classe'];
    $st_ipi_cod = $_POST['st_ipi_cod'];
    $st_ipi_tipo_calculo = $_POST['st_ipi_tipo_calculo'];
    $st_ipi_aliquota = $_POST['st_ipi_aliquota'];

    //DADOS DO COFINS
    $id_cofins = $_POST['id_cofins'];
    $st_cofins_regime_apuracao = $_POST['st_cofins_regime_apuracao'];
    
    $st_cofins_aliquota = $_POST['st_cofins_aliquota'];
    $st_cofins_aliquota = str_replace(",", ".", $st_cofins_aliquota);
    
    $st_cofins_tipo_calculo = $_POST['st_cofins_tipo_calculo'];
    $st_cofins_calculo_st = $_POST['st_cofins_calculo_st'];
    $st_cofins_aliquota_st = $_POST['st_cofins_aliquota_st'];


    try {

        $result = $auth_user->runQuery('UPDATE st SET '
                . 'st_nome = :nome,'
                . 'st_uf = :uf,'
                . 'id_pis = :id_pis,'
                . 'st_pis_regime_apuracao = :st_pis_regime_apuracao, '
                . 'st_pis_aliquota = :st_pis_aliquota,'
                . 'st_pis_tipo_calculo = :st_pis_tipo_calculo,'
                . 'st_pis_tipo_calculo_st = :st_pis_tipo_calculo_st,'
                . 'st_pis_aliquota_st = :st_pis_aliquota_st,'
                . 'id_ipi = :id_ipi, '
                . 'st_ipi_classe = :st_ipi_classe, '
                . 'st_ipi_cod = :st_ipi_cod, '
                . 'st_ipi_tipo_calculo = :st_ipi_tipo_calculo, '
                . 'st_ipi_aliquota = :st_ipi_aliquota, '
                . 'id_cofins = :id_cofins,'
                . 'st_cofins_regime_apuracao = :st_cofins_regime_apuracao,'
                . 'st_cofins_aliquota = :st_cofins_aliquota,'
                . 'st_cofins_tipo_calculo = :st_cofins_tipo_calculo,'
                . 'st_cofins_calculo_st = :st_cofins_calculo_st,'
                . 'st_cofins_aliquota_st = :st_cofins_aliquota_st '
                . ' WHERE st_id = :id');


        $result->execute(array(
            ':id' => $id,
            ':nome' => $nome,
            ':uf' => $uf,
            ':id_pis' => $id_pis,
            ':st_pis_regime_apuracao' => $st_pis_regime_apuracao,
            ':st_pis_aliquota' => $st_pis_aliquota,
            ':st_pis_tipo_calculo' => $st_pis_tipo_calculo,
            ':st_pis_tipo_calculo_st' => $st_pis_tipo_calculo_st,
            ':st_pis_aliquota_st' => $st_pis_aliquota_st,
            ':id_ipi' => $id_ipi,
            ':st_ipi_classe' => $st_ipi_classe,
            ':st_ipi_cod' => $st_ipi_cod,
            ':st_ipi_tipo_calculo' => $st_ipi_tipo_calculo,
            ':st_ipi_aliquota' => $st_ipi_aliquota,
            ':id_cofins' => $id_cofins,
            ':st_cofins_regime_apuracao' => $st_cofins_regime_apuracao,
            ':st_cofins_aliquota' => $st_cofins_aliquota,
            ':st_cofins_tipo_calculo' => $st_cofins_tipo_calculo,
            ':st_cofins_calculo_st' => $st_cofins_calculo_st,
            ':st_cofins_aliquota_st' => $st_cofins_aliquota_st
          
        ));

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//CADASTRO DE ST NOVA 
if (isset($_POST['btn-cadastro'])) {

    //DADOS DA ST 
    $nome = strtoupper($_POST['st_nome']);
    $uf = $_POST['st_uf'];
    $tipo = $_POST['st_tipo'];
    $id_estado = $_POST['st_uf'];
    $status = true;

    //DADOS DA ST DO PIS
    $id_pis = $_POST['id_pis'];
    $st_pis_regime_apuracao = $_POST['st_pis_regime_apuracao'];
    $st_pis_aliquota = $_POST['st_pis_aliquota'];
    $st_pis_tipo_calculo = $_POST['st_pis_tipo_calculo'];
    $st_pis_tipo_calculo_st = $_POST['st_pis_tipo_calculo_st'];
    $st_pis_aliquota_st = $_POST['st_pis_aliquota_st'];

    // DADOS DA ST DO IPI
    $id_ipi = $_POST['id_ipi'];
    $st_ipi_classe = $_POST['st_ipi_classe'];
    $st_ipi_cod = $_POST['st_ipi_cod'];
    $st_ipi_tipo_calculo = $_POST['st_ipi_tipo_calculo'];
    $st_ipi_aliquota = $_POST['st_ipi_aliquota'];

    //DADOS DO COFINS
    $id_cofins = $_POST['id_cofins'];
    $st_cofins_regime_apuracao = $_POST['st_cofins_regime_apuracao'];
    $st_cofins_aliquota = $_POST['st_cofins_aliquota'];
    $st_cofins_tipo_calculo = $_POST['st_cofins_tipo_calculo'];
    $st_cofins_tipo_calculo_st = $_POST['st_cofins_tipo_calculo_st'];
    $st_cofins_aliquota_st = $_POST['st_cofins_aliquota_st'];



    try {
        //CADASTRO DA ST
        $stmt = $auth_user->runQuery("INSERT INTO st
            (
            id_estado,
            st_nome, 
            st_uf,
            st_status, 
            st_tipo,
            id_pis,
            st_pis_regime_apuracao,
            st_pis_aliquota,
            st_pis_tipo_calculo,
            st_pis_tipo_calculo_st,
            st_pis_aliquota_st,
            id_ipi, 
            st_ipi_classe, 
            st_ipi_cod, 
            st_ipi_tipo_calculo, 
            st_ipi_aliquota,
            id_cofins,
            st_cofins_regime_apuracao,
            st_cofins_aliquota,
            st_cofins_tipo_calculo,
            st_cofins_calculo_st,
            st_cofins_aliquota_st)
            VALUES(
            :id_estado,
            :nome, 
            :uf, 
            :status, 
            :tipo,
            :id_pis,
            :st_pis_regime_apuracao,
            :st_pis_aliquota,
            :st_pis_tipo_calculo,
            :st_pis_tipo_calculo_st,
            :st_pis_aliquota_st,
            :id_ipi, 
            :st_ipi_classe, 
            :st_ipi_cod, 
            :st_ipi_tipo_calculo, 
            :st_ipi_aliquota,
            :id_cofins,
            :st_cofins_regime_apuracao,
            :st_cofins_aliquota,
            :st_cofins_tipo_calculo,
            :st_cofins_calculo_st,
            :st_cofins_aliquota_st)");
        // DADOS DA ST
        $stmt->bindparam(":id_estado", $id_estado);
        $stmt->bindparam(":nome", $nome);
        $stmt->bindparam(":uf", $uf);
        $stmt->bindparam(":status", $status);
        $stmt->bindparam(":tipo", $tipo);
        //DADOS DO PIS
        $stmt->bindparam(":id_pis", $id_pis);
        $stmt->bindparam(":st_pis_regime_apuracao", $st_pis_regime_apuracao);
        $stmt->bindparam(":st_pis_aliquota", $st_pis_aliquota);
        $stmt->bindparam(":st_pis_tipo_calculo", $st_pis_tipo_calculo);
        $stmt->bindparam(":st_pis_tipo_calculo_st", $st_pis_tipo_calculo_st);
        $stmt->bindparam(":st_pis_aliquota_st", $st_pis_aliquota_st);
        //DADOS DO IPI
        $stmt->bindparam(":id_ipi", $id_ipi);
        $stmt->bindparam(":st_ipi_classe", $st_ipi_classe);
        $stmt->bindparam(":st_ipi_cod", $st_ipi_cod);
        $stmt->bindparam(":st_ipi_tipo_calculo", $st_ipi_tipo_calculo);
        $stmt->bindparam(":st_ipi_aliquota", $st_ipi_aliquota);
        //DADOS DO COFINS
        $stmt->bindparam(":id_cofins", $id_cofins);
        $stmt->bindparam(":st_cofins_regime_apuracao", $st_cofins_regime_apuracao);
        $stmt->bindparam(":st_cofins_aliquota", $st_cofins_aliquota);
        $stmt->bindparam(":st_cofins_tipo_calculo", $st_cofins_tipo_calculo);
        $stmt->bindparam(":st_cofins_calculo_st", $st_cofins_calculo_st);
        $stmt->bindparam(":st_cofins_aliquota_st", $st_cofins_aliquota_st);
        
        $stmt->execute();
        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//PESQUISAR A ST CADASTRADA
if (isset($_POST['btn-pesquisar'])) {
    //$funcionario_id = strip_tags($_POST['funcionario_id']);

    $pesquisa = strtoupper($_POST['st_pesquisa']);

    try {


        $stmt = $auth_user->runQuery("SELECT * FROM st, estado WHERE id_estado = estado_id"
                . " AND st_nome like :nome");

        $stmt->bindValue(':nome', '%' . $pesquisa . '%', PDO::PARAM_STR);
        $stmt->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//============>>>STICMS<<===================
//CADASTRA UM NOVO ICMS NA ST
if (isset($_POST['btn-cadastra-sticms'])) {

    $id_st = $_POST['id_st'];
    $sticms_uf = $_POST['sticms_uf'];
    $sticms_tipo_pessoa = $_POST['sticms_tipo_pessoa'];
    $sticms_st_especifica = $_POST['sticms_st_especifica'];
    $sticms_st = $_POST['sticms_st'];
    $sticms_cso = $_POST['sticms_cso'];
    $sticms_modalidade_base_calculo = $_POST['sticms_modalidade_base_calculo'];

    $sticms_reducao_base_calculo = $_POST['sticms_reducao_base_calculo'];
    $sticms_reducao_base_calculo = str_replace(",", ".", $sticms_reducao_base_calculo);

    $sticms_base_calculo = $_POST['sticms_base_calculo'];
    $sticms_base_calculo = str_replace(",", ".", $sticms_base_calculo);

    $sticms_aliquota = $_POST['sticms_aliquota'];
    $sticms_aliquota = str_replace(",", ".", $sticms_aliquota);
    
    $sticms_perc_diferimento = $_POST['sticms_perc_diferimento'];
    $sticms_perc_diferimento = str_replace(",", ".", $sticms_perc_diferimento);

    $sticms_st_comportamento = $_POST['sticms_st_comportamento'];
    $sticms_st_modalidade_calculo = $_POST['sticms_st_modalidade_calculo'];

    $sticms_st_mva = $_POST['sticms_st_mva'];
    $sticms_st_mva = str_replace(",", ".", $sticms_st_mva);

    $sticms_st_reducao_calculo = $_POST['sticms_st_reducao_calculo'];
    $sticms_st_reducao_calculo = str_replace(",", ".", $sticms_st_reducao_calculo);

    $sticms_st_aliquota = $_POST['sticms_st_aliquota'];
    $sticms_st_aliquota = str_replace(",", ".", $sticms_st_aliquota);

    $sticms_par_pobreza = $_POST['sticms_par_pobreza'];
    $sticms_par_pobreza = str_replace(",", ".", $sticms_par_pobreza);

    $sticms_par_destino = $_POST['sticms_par_destino'];
    $sticms_par_destino = str_replace(",", ".", $sticms_par_destino);

    $sticms_par_origem = $_POST['sticms_par_origem'];
    $sticms_par_origem = str_replace(",", ".", $sticms_par_origem);

    $sticms_mensagem_nfe = $_POST['sticms_mensagem_nfe'];

    try {
        //CADASTRO DA ST
        $stmt = $auth_user->runQuery("INSERT INTO sticms
            (id_st,
             sticms_uf,
             sticms_tipo_pessoa,
             sticms_st_especifica,
             sticms_st,
             sticms_cso,
             sticms_modalidade_base_calculo,
             sticms_reducao_base_calculo,
             sticms_base_calculo,
             sticms_aliquota,
             sticms_perc_diferimento,
             sticms_st_comportamento,
             sticms_st_modalidade_calculo,
             sticms_st_mva,
             sticms_st_reducao_calculo,
             sticms_st_aliquota,
             sticms_par_pobreza,
             sticms_par_destino,
             sticms_par_origem,
             sticms_mensagem_nfe
             )
            VALUES(
             :id_st,
             :sticms_uf,
             :sticms_tipo_pessoa,
             :sticms_st_especifica,
             :sticms_st,
             :sticms_cso,
             :sticms_modalidade_base_calculo,
             :sticms_reducao_base_calculo,
             :sticms_base_calculo,
             :sticms_aliquota,
             :sticms_perc_diferimento,
             :sticms_st_comportamento,
             :sticms_st_modalidade_calculo,
             :sticms_st_mva,
             :sticms_st_reducao_calculo,
             :sticms_st_aliquota,
             :sticms_par_pobreza,
             :sticms_par_destino,
             :sticms_par_origem,
             :sticms_mensagem_nfe )");

        $stmt->bindparam(":id_st", $id_st);
        $stmt->bindparam(":sticms_uf", $sticms_uf);
        $stmt->bindparam(":sticms_tipo_pessoa", $sticms_tipo_pessoa);
        $stmt->bindparam(":sticms_st_especifica", $sticms_st_especifica);
        $stmt->bindparam(":sticms_st", $sticms_st);
        $stmt->bindparam(":sticms_cso", $sticms_cso);
        $stmt->bindparam(":sticms_modalidade_base_calculo", $sticms_modalidade_base_calculo);
        $stmt->bindparam(":sticms_reducao_base_calculo", $sticms_reducao_base_calculo);
        $stmt->bindparam(":sticms_base_calculo", $sticms_base_calculo);
        $stmt->bindparam(":sticms_aliquota", $sticms_aliquota);
        $stmt->bindparam(":sticms_perc_diferimento", $sticms_perc_diferimento);
        $stmt->bindparam(":sticms_st_comportamento", $sticms_st_comportamento);
        $stmt->bindparam(":sticms_st_modalidade_calculo", $sticms_st_modalidade_calculo);
        $stmt->bindparam(":sticms_st_mva", $sticms_st_mva);
        $stmt->bindparam(":sticms_st_reducao_calculo", $sticms_st_reducao_calculo);
        $stmt->bindparam(":sticms_st_aliquota", $sticms_st_aliquota);
        $stmt->bindparam(":sticms_par_pobreza", $sticms_par_pobreza);
        $stmt->bindparam(":sticms_par_destino", $sticms_par_destino);
        $stmt->bindparam(":sticms_par_origem", $sticms_par_origem);
        $stmt->bindparam(":sticms_mensagem_nfe", $sticms_mensagem_nfe);
        $stmt->execute();
        $auth_user->redirect("st_editar.php?id=" . $id_st);
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//EDITA OS DADOS DO STICMS
if (isset($_POST['btn-altera-sticms'])) {

    $id_st = $_POST['id_st'];

    $sticms_id = $_POST['sticms_id'];
    $sticms_uf = $_POST['sticms_uf'];
    $sticms_tipo_pessoa = $_POST['sticms_tipo_pessoa'];
    $sticms_st_especifica = $_POST['sticms_st_especifica'];
    $sticms_st = $_POST['sticms_st'];
    $sticms_cso = $_POST['sticms_cso'];
    $sticms_modalidade_base_calculo = $_POST['sticms_modalidade_base_calculo'];

    $sticms_reducao_base_calculo = $_POST['sticms_reducao_base_calculo'];
    $sticms_reducao_base_calculo = str_replace(",", ".", $sticms_reducao_base_calculo);

    $sticms_base_calculo = $_POST['sticms_base_calculo'];
    $sticms_base_calculo = str_replace(",", ".", $sticms_base_calculo);

    $sticms_aliquota = $_POST['sticms_aliquota'];
    $sticms_aliquota = str_replace(",", ".", $sticms_aliquota);
    
    $sticms_perc_diferimento = $_POST['sticms_perc_diferimento'];
    $sticms_perc_diferimento = str_replace(",", ".", $sticms_perc_diferimento);

    $sticms_st_comportamento = $_POST['sticms_st_comportamento'];
    $sticms_st_modalidade_calculo = $_POST['sticms_st_modalidade_calculo'];

    $sticms_st_mva = $_POST['sticms_st_mva'];
    $sticms_st_mva = str_replace(",", ".", $sticms_st_mva);

    $sticms_st_reducao_calculo = $_POST['sticms_st_reducao_calculo'];
    $sticms_st_reducao_calculo = str_replace(",", ".", $sticms_st_reducao_calculo);

    $sticms_st_aliquota = $_POST['sticms_st_aliquota'];
    $sticms_st_aliquota = str_replace(",", ".", $sticms_st_aliquota);

    $sticms_par_pobreza = $_POST['sticms_par_pobreza'];
    $sticms_par_pobreza = str_replace(",", ".", $sticms_par_pobreza);

    $sticms_par_destino = $_POST['sticms_par_destino'];
    $sticms_par_destino = str_replace(",", ".", $sticms_par_destino);

    $sticms_par_origem = $_POST['sticms_par_origem'];
    $sticms_par_origem = str_replace(",", ".", $sticms_par_origem);

    $sticms_mensagem_nfe = $_POST['sticms_mensagem_nfe'];

    try {

        $result = $auth_user->runQuery('UPDATE sticms SET '
                . 'sticms_uf  = :sticms_uf, '
                . 'sticms_tipo_pessoa = :sticms_tipo_pessoa, '
                . 'sticms_st_especifica = :sticms_st_especifica, '
                . 'sticms_st= :sticms_st, '
                . 'sticms_cso = :sticms_cso, '
                . 'sticms_modalidade_base_calculo = :sticms_modalidade_base_calculo, '
                . 'sticms_reducao_base_calculo = :sticms_reducao_base_calculo, '
                . 'sticms_base_calculo  = :sticms_base_calculo, '
                . 'sticms_aliquota  = :sticms_aliquota, '
                . 'sticms_perc_diferimento  = :sticms_perc_diferimento, '
                . 'sticms_st_comportamento  = :sticms_st_comportamento, '
                . 'sticms_st_modalidade_calculo  = :sticms_st_modalidade_calculo, '
                . 'sticms_st_mva  = :sticms_st_mva, '
                . 'sticms_st_reducao_calculo  = :sticms_st_reducao_calculo, '
                . 'sticms_st_aliquota  = :sticms_st_aliquota, '
                . 'sticms_par_pobreza  = :sticms_par_pobreza, '
                . 'sticms_par_destino  = :sticms_par_destino, '
                . 'sticms_par_origem  = :sticms_par_origem, '
                . 'sticms_mensagem_nfe  = :sticms_mensagem_nfe '
                . ' WHERE sticms_id = :sticms_id');


        $result->execute(array(
            ':sticms_id' => $sticms_id,
            ':sticms_uf' => $sticms_uf,
            ':sticms_tipo_pessoa' => $sticms_tipo_pessoa,
            ':sticms_st_especifica' => $sticms_st_especifica,
            ':sticms_st' => $sticms_st,
            ':sticms_cso' => $sticms_cso,
            ':sticms_modalidade_base_calculo' => $sticms_modalidade_base_calculo,
            ':sticms_reducao_base_calculo' => $sticms_reducao_base_calculo,
            ':sticms_base_calculo' => $sticms_base_calculo,
            ':sticms_aliquota' => $sticms_aliquota,
            ':sticms_perc_diferimento' => $sticms_perc_diferimento,
            ':sticms_st_comportamento' => $sticms_st_comportamento,
            ':sticms_st_modalidade_calculo' => $sticms_st_modalidade_calculo,
            ':sticms_st_mva' => $sticms_st_mva,
            ':sticms_st_reducao_calculo' => $sticms_st_reducao_calculo,
            ':sticms_st_aliquota' => $sticms_st_aliquota,
            ':sticms_par_pobreza' => $sticms_par_pobreza,
            ':sticms_par_destino' => $sticms_par_destino,
            ':sticms_par_origem' => $sticms_par_origem,
            ':sticms_mensagem_nfe' => $sticms_mensagem_nfe,
        ));

        $auth_user->redirect("st_editar.php?id=" . $id_st);
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//EXCLUI UMA STICMS DO SISTEMA
if (isset($_POST['btn-excluir-sticms'])) {
    $sticms_id = strip_tags($_POST['sticms_id']);
    $id_st = strip_tags($_POST['id_st']);

    try {
        $sql = "DELETE FROM sticms WHERE sticms_id =  :sticms_id";
        $stmt = $auth_user->runQuery($sql);
        $stmt->bindParam(':sticms_id', $sticms_id, PDO::PARAM_INT);
        $stmt->execute();
        $auth_user->redirect("st_editar.php?id=" . $id_st);
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>