<?php

require_once __DIR__ . '/Db.php';

class student extends user {
    protected $niveau ;

    protected $paid_status ;

    public function __construct($id, $name, $email, $password , $pays, $niveau , $paid_status  ) {
        parent::__construct($id, $name, $email, $password ,$pays);
        $this->niveau = $niveau ;
        $this->paid_status = $paid_status ;





        $db = new Db('localhost', 'root', '', 'surfschool');
        $this->pdo = $db->connect();
    }


    public function getNiveau(){
        return $this->niveau ;
    }

    public function getPaid_status(){
        return $this->paid_status ;
    }


    public function setNiveau($niveau){
        $this->niveau = $niveau ;
    }

    public function setPaid_status($paid_status){
        $this->paid_status = $paid_status ;
    }

    public function viewMyProfile($studentId){

        try{
            $query = 'SELECT * FROM users WHERE id = ?' ;
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$studentId]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user ;
        }catch(PDOException $e){
            die('Erreur : ' . $e->getMessage());
        }

    }

    public function viewMyLevel($studentId){
        try{
            $query = 'SELECT niveau FROM users WHERE id = ?' ;
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$studentId]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user['niveau'] ;
        }catch(PDOException $e){
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function viewMyPaidStatus($studentId){
        try{
            $query = 'SELECT paid_status FROM users WHERE id = ?' ;
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$studentId]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user['paid_status'] ;
        }catch(PDoException $e){
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function viewsMyLesson($studentId){
        try{
            $query = 'SELECT * FROM lessons WHERE student_id = ?' ;
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$studentId]);
            $lessons = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $lessons ;
        }catch(PDOException $e){
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function viewAvailableLesson($studentId){
        try{
            $query = 'SELECT * FROM lessons WHERE student_id = ? AND level = ?' ;
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$studentId, $this->getNiveau()]);
            $lessons = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $lessons ;
        }catch(PDOException $e){
            die('Erreur : ' . $e->getMessage());
        }
    }



}