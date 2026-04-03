<?php

require_once __DIR__ . '/Db.php';

class Admin extends user {
    public function __construct($id, $name, $email, $password , $pays) {
        parent::__construct($id, $name, $email, $password ,$pays);

        $db = new Db('localhost', 'root', '', 'surfschool');
        $this->pdo = $db->connect();
    }

    public function viewAllStudents(){
        try{
            $query = 'SELECT * FROM students' ;
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $students ;
        }catch(PDOException $e){
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function viewStudentbyId($studentId){
        try{
            $query = 'SELECT * FROM students WHERE id = ?' ;
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$studentId]);
            $student = $stmt->fetch(PDO::FETCH_ASSOC);
            return $student ;
        }catch(PDOException $e){
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function updateStudentLevel($studentId , $level){
        try{
            $querry = 'Update Students SET niveau = ? WHERE id = ?' ;
            $stmt = $this->pdo->prepare($querry);
            $stmt->execute([$level , $studentId]);
            return true ;
        }catch(PDOException $e){
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function updateStudentPaidStatus($studentId , $paidStatus){
        try{
            $querry = 'UPDATE students SET paid_status = ? WHERE id= ? ' ;
            $stmt = $this->pdo->prepare($querry);
            $stmt->execute([$paidStatus , $studentId]);
            return true ;
        }catch(PDOException $e){
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function deleteStudent($studentId){
        try{
            $querry = 'DELETE FROM students WHERE id = ?' ;
            $stmt = $this->pdo->prepare($querry);
            $stmt->execute([$studentId]);
            return true ;
        }catch(PDOException $e){
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function viewsStatuses(){
        try{
            $query = 'SELECT 
                u.name, 
                u.email, 
                s.level AS student_level, 
                e.status AS paid_status, 
                l.title AS lesson_title, 
                l.level AS lesson_level, 
                l.coach
            FROM enroll e 
            JOIN student s ON e.student_id = s.id 
            JOIN lesson l ON e.lesson_id = l.id 
            INNER JOIN user u ON s.user_id = u.id' ;
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // statistique apres ...

        }catch(PDOException $e){
            die('Erreur : ' . $e->getMessage());
        }
    }






}