<?php

require_once __DIR__ . '/Db.php';


class User {
    protected $id;
    protected $name;
    protected $email;
    protected $password;
    protected $pdo;

    protected $pays ;



    public function __construct($id, $name, $email, $password , $pays) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->pays = $pays;

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

    public function getPays(){
        return $this->pays ;
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

    public function setPays($pays){
        $this->pays = $pays ;
    }

    public function Registre(){
        session_start();
        try{
            $query = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)" ;
            $stmt = $this->pdo->prepare($query);
            $hash = password_hash($this->getPassword(), PASSWORD_DEFAULT);
            $stmt->execute([$this->getName(), $this->getEmail() , $hash]);
            return true ;
        }catch(PDOException $e){
            die('Erreur : ' . $e->getMessage());

        }
    }

    public function Login(){
        session_start();
        try{
            $query = "SELECT * FROM users WHERE email = ?" ;
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$this->getEmail()]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if($user && password_verify($this->getPassword(), $user['password'])){
                $this->setId($user['id']);
                $this->setName($user['name']);
                $this->setEmail($user['email']);

            }

            return $user ;
        }catch(PDOException $e){
            die('Erreur : ' . $e->getMessage());

        }
    }

    public function logout(){
        session_start();

        session_destroy();
    }




}