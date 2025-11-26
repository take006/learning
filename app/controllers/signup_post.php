<?php
$csrf_token = filter_input(INPUT_POST, "csrf_token");
if(!$csrf_token ||$csrf_token !== $_SESSION['csrf_token']){
  header("Location: ../error/");
  exit();
}
$name = filter_input(INPUT_POST, "name");
if($name === ""){
  header('Location: signup.php');
  exit();
}
if(mb_strlen($name) > 20){
  header('Location: signup.php');
  exit();
}
$password = filter_input(INPUT_POST, "password");
if($password === ""){
  header('Location: signup.php');
  exit();
}
if(mb_strlen($password) > 20){
  header('Location: signup.php');
  exit();
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

try{
  $account_dao = new AccountDAO($pdo);
  $account_dao->insertAccount($name, $hashed_password);
  header("Location: signin.php");
}catch(PDOException $e){
  error_log($e->getMessage());
  header('Location: error.php');
  exit();
}
?>