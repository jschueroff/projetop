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
$strCount = $auth_user->runQuery("SELECT COUNT(*) AS 'total_cliente' FROM cliente");
$strCount->execute();
//iniciamos uma var que será usada para armazenar a qtde de registros da tabela  
$total = 0;
if (count($strCount)) {
    foreach ($strCount as $row) {
        //armazeno o total de registros da tabela para fazer a paginação
        $total = $row["total_cliente"];
    }
}
//guardo o resultado na variavel pra exibir os dados na pagina		
$stmt = $auth_user->runQuery("SELECT * FROM cliente ORDER BY cliente_id DESC LIMIT $inicio,$maximo");
$stmt->execute();


$stmt_municipio = $auth_user->runQuery("SELECT * FROM municipio");
$stmt_municipio->execute();

// Acao para a Edicao
if (isset($_POST['btn-editar'])) {

    try {
        $unidade_id = strip_tags($_POST['cliente_id']);

        $consulta = $auth_user->runQuery("SELECT * FROM cliente WHERE cliente_id = ?;");
        $consulta->bindParam(1, $unidade_id, PDO::PARAM_STR);
        $consulta->execute();
        $linha = $consulta->fetch(PDO::FETCH_ASSOC);
        if ($linha) {
            $auth_user->redirect("cliente_editar.php?id=" . $linha['cliente_id']);
        } else {
            echo 'Erro na Busca do ID Cliente';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

//INATIVAR CLIENTE
if (isset($_POST['btn-inativar'])) {
    $cliente_id = strip_tags($_POST['cliente_id']);
    try {

        $sql = "UPDATE cliente SET cliente_status = 0 WHERE cliente_id = :cliente_id";
        $stmt = $auth_user->runQuery($sql);
        $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
        $stmt->execute();
        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//ATIVAR CLIENTE
if (isset($_POST['btn-ativar'])) {
    $cliente_id = strip_tags($_POST['cliente_id']);
    try {

        $sql = "UPDATE cliente SET cliente_status = 1 WHERE cliente_id = :cliente_id";
        $stmt = $auth_user->runQuery($sql);
        $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
        $stmt->execute();
        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Botao Salvar a Edicao
if (isset($_POST['btn-salvar'])) {

    $id = $_POST['cliente_id'];
    $id_municipio = $_POST['id_municipio'];
    $nome = strtoupper($_POST['cliente_nome']);
    $fantasia = strtoupper($_POST['cliente_fantasia']);
    $cpf_cnpj = $_POST['cliente_cpf_cnpj'];
    $ie = $_POST['cliente_ie'];
    $tipo = $_POST['cliente_tipo'];
    $consumidor = $_POST['cliente_consumidor'];
    $status = $_POST['cliente_status'];
    $email = strtolower($_POST['cliente_email']);
    $email_nfe = strtolower($_POST['cliente_email_nfe']);

    $telefone = $_POST['cliente_telefone'];
    $logradouro = strtoupper($_POST['cliente_logradouro']);
    $numero = $_POST['cliente_numero'];
    $complemento = strtoupper($_POST['cliente_complemento']);
    $bairro = strtoupper($_POST['cliente_bairro']);
    $cep = $_POST['cliente_cep'];

    try {

        $result = $auth_user->runQuery('UPDATE cliente SET '
                . 'id_municipio  = :id_municipio, '
                . 'cliente_nome  = :nome, '
                . 'cliente_fantasia  = :fantasia, '
                . 'cliente_cpf_cnpj = :cpf_cnpj, '
                . 'cliente_ie  = :ie, '
                . 'cliente_tipo  = :tipo, '
                . 'cliente_consumidor  = :consumidor, '
                . 'cliente_status  = :status, '
                . 'cliente_email  = :email, '
                . 'cliente_email_nfe  = :email_nfe, '
                . 'cliente_telefone  = :telefone, '
                . 'cliente_logradouro  = :logradouro, '
                . 'cliente_numero  = :numero, '
                . 'cliente_complemento  = :complemento, '
                . 'cliente_bairro  = :bairro, '
                . 'cliente_cep  = :cep '
                . ' WHERE cliente_id = :id');
        $result->execute(array(
            ':id_municipio' => $id_municipio,
            ':nome' => $nome,
            ':fantasia' => $fantasia,
            ':cpf_cnpj' => $cpf_cnpj,
            ':ie' => $ie,
            ':tipo' => $tipo,
            ':consumidor' => $consumidor,
            ':status' => $status,
            ':email' => $email,
            ':email_nfe' => $email_nfe,
            ':telefone' => $telefone,
            ':logradouro' => $logradouro,
            ':numero' => $numero,
            ':complemento' => $complemento,
            ':bairro' => $bairro,
            ':cep' => $cep,
            ':id' => $id
                //':data_cadastro' => $data_cadastro,
                // ':id_uni' => $id_uni,
                // ':id_ncm' => $id_ncm
        ));
        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Cadastrar NCM
if (isset($_POST['btn-cadastro'])) {

    $id_municipio = $_POST['id_municipio'];
    $nome = strtoupper($_POST['cliente_nome']);
    $fantasia = strtoupper($_POST['cliente_fantasia']);
    $cpf_cnpj = $_POST['cliente_cpf_cnpj'];
    $cliente_cpf = $_POST['cliente_cpf'];
    $ie = $_POST['cliente_ie'];
    $tipo = $_POST['cliente_tipo'];
    $consumidor = $_POST['cliente_consumidor'];
    $status = $_POST['cliente_status'];
    $email = strtolower($_POST['cliente_email']);
    $email_nfe = strtolower($_POST['cliente_email_nfe']);
    $telefone = $_POST['cliente_telefone'];
    $logradouro = strtoupper($_POST['cliente_logradouro']);
    $numero = $_POST['cliente_numero'];
    $complemento = strtoupper($_POST['cliente_complemento']);
    $bairro = strtoupper($_POST['cliente_bairro']);
    $cep = $_POST['cliente_cep'];



    try {
        $stmt = $auth_user->runQuery("INSERT INTO cliente
            (cliente_id,cliente_nome,cliente_fantasia, cliente_cpf_cnpj, cliente_cpf, cliente_ie, cliente_tipo, cliente_consumidor,
            cliente_status, cliente_email, cliente_email_nfe, id_municipio, cliente_telefone, 
            cliente_logradouro, cliente_numero, cliente_complemento, cliente_bairro, cliente_cep)
            VALUES('',:nome, :fantasia, :cpf_cnpj, :cliente_cpf, :ie, :tipo, :consumidor, :status, :email, :email_nfe, :id_municipio,
            :telefone, :logradouro, :numero, :complemento, :bairro, :cep)");

        $stmt->bindparam(":nome", $nome);
        $stmt->bindparam(":fantasia", $fantasia);
        $stmt->bindparam(":cpf_cnpj", $cpf_cnpj);
        $stmt->bindparam(":cliente_cpf", $cliente_cpf);
        $stmt->bindparam(":ie", $ie);
        $stmt->bindparam(":tipo", $tipo);
        $stmt->bindparam(":consumidor", $consumidor);
        $stmt->bindparam(":status", $status);
        $stmt->bindparam(":email", $email);
        $stmt->bindparam(":email_nfe", $email_nfe);
        $stmt->bindparam(":id_municipio", $id_municipio);
        $stmt->bindparam(":telefone", $telefone);
        $stmt->bindparam(":logradouro", $logradouro);
        $stmt->bindparam(":numero", $numero);
        $stmt->bindparam(":complemento", $complemento);
        $stmt->bindparam(":bairro", $bairro);
        $stmt->bindparam(":cep", $cep);

        $stmt->execute();

        $auth_user->redirect("index.php");
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//Botao de Pesquisa
if (isset($_POST['btn-pesquisar'])) {
    //$funcionario_id = strip_tags($_POST['funcionario_id']);

    $pesquisa = $_POST['cliente_pesquisa'];
    $pesquisa2 = $_POST['cliente_pesquisa'];
    try {

        if (isset($pesquisa) && !empty($pesquisa2)) {
            $stmt = $auth_user->runQuery("SELECT * FROM cliente"
                    . " WHERE cliente_nome like :nome OR "
                    . "cliente_cpf_cnpj like :cpf_cnpj LIMIT 0, 10");
            $stmt->bindValue(':nome', '%' . $pesquisa2 . '%', PDO::PARAM_STR);
            $stmt->bindValue(':cpf_cnpj', '%' . $pesquisa . '%', PDO::PARAM_STR);
            $stmt->execute();
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>