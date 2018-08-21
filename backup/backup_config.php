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

if (isset($_POST['submit_caminho'])) {
    
    $caminho = $_POST['caminho'];
    
    
    $database = new Database();

    $host = $database->dbHost();
    $usuario = $database->dbUsuario();
    $senha = $database->dbSenha();
    $banco = $database->dbBanco();


    date_default_timezone_set('America/Sao_Paulo');

    $dbhost = $host;
    $dbuser = $usuario;
    $dbpwd = $senha;
    $dbname = $banco;


    $dumpfile = $caminho.$dbname . "_" . date("Y-m-d_H-i-s") . ".sql";
// AQUI VERIFICAR NO CASO O SISTEMA OPERACIONAL FOR LINUX OU WINDOWS 
    //PRECISA SER FEITO TESTE NO LINUX PARA VERIFICAR A SUA FUNCIONALIDADE.
    passthru("C:/xampp/mysql/bin/mysqldump --opt --routines=true --host=$dbhost --user=$dbuser --password=$dbpwd $dbname > $dumpfile");

// report - disable with // if not needed
// must look like "-- Dump completed on ..." 

   // echo "$dumpfile ";
    passthru("tail -1 $dumpfile");
}
?>