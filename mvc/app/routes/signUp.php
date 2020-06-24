<?php
session_start();
require_once ("../controllers/UserController.php");
if(isset($_POST['user_sign'])){
    if(isset($_SESSION['LOGINstatus']) && $_SESSION['LOGINstatus']==="false" ){
        $userController = new UserController();
        $gender = isset($_POST['gender'])? $_POST['gender'] : null;
        $userController->setUser($_POST['username'],$_POST['password'],$_POST['firstName'],$_POST['lastName'],
        $_POST['email'],$_POST['birthday'],$gender);
        $userController->new();
    }
}
?>