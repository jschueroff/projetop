<?php
class Database
{   
    private $host = "localhost";
    private $db_name = "sistema3";
    private $username = "root";
    private $password = "root";
    public $conn;
    
    public function dbConnection()
	{
     
	    $this->conn = null;    
        try
		{
            $opcoes = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8');
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password, $opcoes);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
        }
		catch(PDOException $exception)
		{
            echo "Connection error: " . $exception->getMessage();
        }
         
        return $this->conn;
    }
    
    public function dbHost(){
        return $this->host;
    }
    public function dbUsuario(){
        return $this->username;
    }
    public function dbSenha(){
        return $this->password;
    }
    public function dbBanco(){
        return $this->db_name;
    }
    
}
?>