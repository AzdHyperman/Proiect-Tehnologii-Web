<?php
require_once 'core/App.php';
require_once 'core/Controller.php';
require_once '../config/Database.php';

session_start();

if(!isset($_SESSION['LOGINstatus'])) 
    $_SESSION['LOGINstatus'] = "false"; 

if(!isset($_SESSION['user']))
    $_SESSION['user'] = null;
