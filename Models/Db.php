<?php

class Db {

    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db = "surfschool" ;
    private $pdo ;



    public function __construct($host, $user, $pass, $db) {
        $this->host = $host ;
        $this->user = $user ;
        $this->pass =$pass ;
        $this->db =$db ;

    }




    public function connect(){
        try {
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db ;

            $this->pdo = new PDO($dsn ,$this->user , $this->pass) ;

            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $this->pdo ;


        }catch(PDOException $e){
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function getPDO(){
        if($this->pdo == null){
            $this->connect();
        }
        return $this->pdo ;
    }

}

