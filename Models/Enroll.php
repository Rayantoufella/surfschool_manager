<?php


class enroll {
    private $id ;
    private $student_id ;
    private $lesson_id ;
    private $enrolled_date ;
    private $status ;


    public function __construct($id, $student_id, $lesson_id, $enrolled_date, $status) {
        $this->id = $id;
        $this->student_id = $student_id;
        $this->lesson_id = $lesson_id;
        $this->enrolled_date = $enrolled_date;
        $this->status = $status;

        $db = new Db('localhost', 'root', '', 'surfschool');
        $this->pdo = $db->connect();
    }

    public function enrollStudent($studentId , $LessonId){
        try {
            $query = 'insert into enroll (student_id , lesson_id) value (?,?)';
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$studentId, $LessonId]);
            return true;
        }catch(PDOException $e){
            die('Erreur : ' . $e->getMessage());
        }

    }

    public function cancelEnroll($studentId){
        try{
            $query = 'DELETE FROM enroll WHERE student_id = ?' ;
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$studentId]);
            return true ;
        }catch(PDOexception $e){
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function isEnrolled($studentId , $lessonId){
        try{
            $query = 'SELECT * FROM enroll WHERE student_id = ? AND lesson_id = ?' ;
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$studentId , $lessonId]);
            $enroll = $stmt->fetch(PDO::FETCH_ASSOC);
            if($enroll){
                return true ;
            }
            return false ;
        }catch(PDOException $e){
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function getEnrollementById($id){
        try{
            $query = 'SELECT * FROM enroll WHERE id = ?' ;
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$id]);
            $enroll = $stmt->fetch(PDO::FETCH_ASSOC);
            return $enroll ;
        }catch(PDOException $e){
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function getStudentEnrollemets($studentId){
        try{
            $query = 'SELECT * FROM enroll WHERE student_id = ?' ;
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$studentId]);
            $enrolls = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $enrolls ;
        }catch(PDOException $e){
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function getStudentEnrollments($studentId){
        try{
            $query = 'SELECT * FROM enroll WHERE student_id = ?' ;
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$studentId]);
            $enrolls = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $enrolls ;
        }catch(PDOException $e){
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function getStudentEnrollemntsByLevel($studentId , $level){
        try{
            $query = 'SELECT * FROM enroll WHERE student_id = ? AND level = ?' ;
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$studentId , $level]);
            $enrolls = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $enrolls ;
        }catch(PDOException $e){
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function getLessonEnrollements($lessonId){
        try{
            $query = 'SELECT * FROM enroll WHERE lesson_id = ?' ;
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$lessonId]);
            $enrolls = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $enrolls ;
        }catch(PDOException $e){
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function getLessonCount($lessonId){
        try{
            $query= 'SELECT COUNT(*) AS count FROM enroll WHERE lesson_id = ?' ;
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$lessonId]);
            $enroll = $stmt->fetch(PDO::FETCH_ASSOC);
            return $enroll['count'] ;
        }catch(PDOException $e){
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function getEnrollmentsStats(){
        try{
            $query = 'SELECT COUNT(*) AS count, status FROM enroll GROUP BY status' ;
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $enrolls = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $enrolls ;
        }catch(PDOException $e){
            die('Erreur : ' . $e->getMessage());
        }
    }

}