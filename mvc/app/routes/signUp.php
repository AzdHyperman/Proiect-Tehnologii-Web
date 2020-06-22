<?php
session_start();
require_once ("../controllers/UserController.php");
print_r($_POST);
print_r($_SESSION);
if(isset($_POST['user_sign'])){
    if(isset($_SESSION['LOGINstatus']) && $_SESSION['LOGINstatus']==="false" ){
        $userController = new UserController($_POST['username'],$_POST['password'],$_POST['firstName'],$_POST['lastName'],
        $_POST['email'],$_POST['birthday'],$_POST['gender']);
        $userController->new();
    }
    print_r('sal');
}
?>