<?php

require_once 'Models/User.php' ;
class AuthController {
    private $userModel ;

    public function __construct(){
        $this->userModel = new User(null , null , null , null , null) ;
    }

    public function showRegisterForm(){
        include 'views/auth/register.php' ;
    }

    public function Register(){
        

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $name = $_POST['name'] ;
            $email = $_POST['email'] ;
            $password = $_POST['password'] ;
            $pays = $_POST['pays'] ;

            if(empty($name) || empty($email) || empty($password) || empty($pays)){
                $_SESSION['error'] = 'Tous les champs sont obligatoires' ;
                header('Location: /register') ;
                exit ;
            }
            else{
                $this->userModel->setName($name) ;
                $this->userModel->setEmail($email) ;
                $this->userModel->setPassword($password) ;
                $this->userModel->setPays($pays) ;
                $this->userModel->Registre() ;


            }

            header('Location: /login') ;
            exit ;
        }
        else{
            echo 'Erreur' ;

        }

    }

    public function showLoginForm(){
        include 'views/auth/login.php' ;
    }

    public function Login(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $email = $_POST['email'] ;
            $password = $_POST['password'] ;
            if(empty($email) || empty($password)){
                echo 'Tous les champs sont obligatoires' ;
            }else{
                $this->userModel->setEmail($email) ;
                $this->userModel->setPassword($password) ;
                $user = $this->userModel->Login() ;

                if($user && password_verify($password, $user['password'])){
                    $_SESSION['user_id'] = $user['id'] ;
                    $_SESSION['user_name'] = $user['name'] ;
                    $_SESSION['user_email'] = $user['email'] ;
                    header('Location: /student') ;
                    exit();
                }else{
                    $_SESSION['error'] = 'Email ou mot de passe incorrect' ;
                    header('Location: /login') ;
                    exit ;
                }

            }
        }
    }

    public function logout(){
        session_destroy();
        header('Location: /login') ;
        exit ;
    }


}
