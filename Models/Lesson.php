<?php


require_once __DIR__ . '/Db.php';

class lesson
{
    private $id;
    private $title;
    private $coach;
    private $level;
    private $capcite;
    private $date;

    public function __construct($id, $title, $coach, $level, $capcite, $date)
    {
        $this->id = $id;
        $this->title = $title;
        $this->coach = $coach;
        $this->level = $level;
        $this->capcite = $capcite;
        $this->date = $date;

        $db = new Db('localhost', 'root', '', 'surfschool');
        $this->pdo = $db->connect();
    }

    public function createLesson($title, $coach, $level, $capcite)
    {
        try {
            $query = 'insert into lesson (title , coach ,  level , capaciter ) value (?,?,?,?)';
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$title, $coach, $level, $capcite]);
            return true;
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function getAllLessons()
    {
        try {
            $query = 'SELECT * FROM lesson';
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $lessons = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $lessons;
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function getLessonByLevel($level)
    {
        try {
            $query = 'SELECT * FROM lesson where level = ? ';
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$level]);
            $lessons = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $lessons;
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function updateLesson($id, $title, $coach, $level, $capcite, $date)
    {
        try {
            $query = "UPDATE lesson SET title = ? , coach = ? , level = ? , capaciter = ? , date = ? WEHERE id = ? ";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$title, $coach, $level, $capcite, $date, $id]);
            return true;
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function deleteLesson($id)
    {
        try {
            $query = 'DELETE FROM lesson WHERE id = ?';
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function enrolledStudentId($id)
    {
        try {
            $query = 'SELECT student_id FROM enroll WHERE lesson_id = ? ';
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$id]);
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function getStudentCount($id)
    {
        try {
            $query = 'SELECT COUNT(*) AS student_count FROM enroll where lesson_id = ? ';
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$id]);
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function getAvailableLesson($studentId)
    {
        try {
            $query = 'SELECT * FROM lesson WHERE id NOT IN (SELECT lesson_id FROM enroll WHERE student_id = ?)';
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$studentId]);
            $lessons = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $lessons;
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function isLessonFull($lessonId)
    {
        try {
            $query = 'SELECT * from lesson WHERE id = ? AND capaciter = (SELECT COUNT(*) FROM enroll WHERE lesson_id = ?)';
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$lessonId, $lessonId]);
            $lesson = $stmt->fetch(PDO::FETCH_ASSOC);
            return true;
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function getLessonDetails($lessonId)
    {
        try {
            $query = 'SELECT * FROM lesson WHERE id = ?';
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$lessonId]);
            $lesson = $stmt->fetch(PDO::FETCH_ASSOC);
            return $lesson;
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    
}