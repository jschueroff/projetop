<?php

require_once('conexao.class.php');

class USER {

    private $conn;

    public function __construct() {
        $database = new Database();
        $db = $database->dbConnection();
        $this->conn = $db;
    }
    

    public function runQuery($sql) {
        $stmt = $this->conn->prepare($sql);
        return $stmt;
    }

    public function registro($sql) {

        $this->conn->exec($sql);
        $last_id = $this->conn->lastInsertId();
        return $last_id;
    }

    public function register($uname, $umail, $upass) {
        try {
            $new_password = password_hash($upass, PASSWORD_DEFAULT);

            $stmt = $this->conn->prepare("INSERT INTO users(user_name,user_email,user_pass) 
		                                               VALUES(:uname, :umail, :upass)");

            $stmt->bindparam(":uname", $uname);
            $stmt->bindparam(":umail", $umail);
            $stmt->bindparam(":upass", $new_password);

            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function doLogin($funcionario_nome, $funcionario_email, $funcionario_senha) {
        try {
            $stmt = $this->conn->prepare("SELECT "
                    . "funcionario_id, funcionario_nome, "
                    . "funcionario_email, funcionario_senha, "
                    . "funcionario_status FROM funcionarios"
                    . " WHERE funcionario_nome=:funcionario_nome OR "
                    . "funcionario_email=:funcionario_email AND "
                    . "funcionario_status = 1");
            $stmt->execute(array(':funcionario_nome' => $funcionario_nome, ':funcionario_email' => $funcionario_email));
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() == 1) {
                if (password_verify($funcionario_senha, $userRow['funcionario_senha'])) {
                    $_SESSION['user_session'] = $userRow['funcionario_id'];
                    return true;
                } else {
                    return false;
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function is_loggedin() {
        if (isset($_SESSION['user_session'])) {
            return true;
        }
    }

    public function redirect($url) {
        header("Location: $url");
    }

    public function doLogout() {
        session_destroy();
        unset($_SESSION['user_session']);
        return true;
    }

    public function buscar_funcionario($id) {
        try {
            $consulta = $this->conn->prepare("SELECT * FROM funcionarios WHERE funcionario_id = ?;");
            $consulta->bindParam(1, $id, PDO::PARAM_STR);
            $consulta->execute();
            $linha = $consulta->fetch(PDO::FETCH_ASSOC);
            if ($linha) {
                $this->redirect("../funcionarios/funcionario_editar.php?id=" . $linha['funcionario_id']);
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function total($id) {
        try {
            $stmte = $this->conn->prepare("SELECT SUM(pedido_itens_qtd) FROM pedido_itens WHERE id_pedido = ?;");
            $stmte->bindParam(1, $id, PDO::PARAM_INT);
            $stmte->execute();
            $count = $stmte->fetchColumn();
            return $count;
        } catch (PDOException $e) {
            setcookie("ErroPDO", "Falha no Calculo das Unidades - " . $e->getMessage());
            return false;
        }
    }
    
     public function totais($id) {
        try {
            $stmte = $this->conn->prepare("SELECT SUM(pedido_itens_total) FROM pedido_itens WHERE id_pedido = ?;");
            $stmte->bindParam(1, $id, PDO::PARAM_INT);
            $stmte->execute();
            $count = $stmte->fetchColumn();
            return $count;
        } catch (PDOException $e) {
            setcookie("ErroPDO", "Falha no Calculo do Total do Pedido - " . $e->getMessage());
            return false;
        }
    }

}

?>