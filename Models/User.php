<?php

class user {
    protected $id;
    protected $name;
    protected $email;
    protected $password;
    protected $pdo;

    public function __construct($id, $name, $email, $password) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;

        require_once __DIR__ . '/Db.php';
        $db = new Db('localhost', 'root', '', 'surfschool');
        $this->pdo = $db->connect();
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function creeProfile(){
        try{
            $pdo = $this->pdo;
            $stmt = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $this->password);
            $stmt->execute();
        }catch(PDOException $e){
            echo 'Erreur : ' . $e->getMessage();
        }
    }

    public function consulter(){
        $pdo = $this->pdo;
        $stmt = $pdo->prepare('SELECT * FROM lesson');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function afficher(){
        echo $this->name;
    }
}