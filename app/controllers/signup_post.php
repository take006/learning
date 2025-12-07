<?php
require_once __DIR__ . '/../../config/config.php';
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/AccountDAO.php';

$csrf_token = filter_input(INPUT_POST, "csrf_token");
if(!$csrf_token ||$csrf_token !== $_SESSION['csrf_token']){
  header('Location:' . BASE_URL . 'public/error.php');
  exit();
}
$name = filter_input(INPUT_POST, "name");
if($name === ""){
  header('Location: ' . BASE_URL . 'public/signup.php');
  exit();
}
if(mb_strlen($name) > 20){
  header('Location: ' . BASE_URL . 'public/signup.php');
  exit();
}
$password = filter_input(INPUT_POST, "password");
if($password === ""){
  header('Location: ' . BASE_URL . 'public/signup.php');
  exit();
}
if(mb_strlen($password) > 20){
  header('Location: ' . BASE_URL . 'public/signup.php');
  exit();
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

try{
  $pdo = getPDO();
  $account_dao = new AccountDAO($pdo);
  $account_dao->createAccount($name, $hashed_password);
  header("Location: signin_success.php");
  
  } catch(PDOException $e) {
    error_log($e->getMessage());
    header('Location: ' . BASE_URL . 'public/db_error.php');
    exit();
  }

?>