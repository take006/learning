<?php
class AccountDAO {
  public function __construct($pdo){
    $this->pdo = $pdo;
  }
  //signinの処理
  public function selectByName($name){
    $sql = "SELECT id, name, hashed_password FROM accounts WHERE name = :name";
    $ps = $this->pdo->prepare($sql);
    $ps->bindValue(":name", $name, PDO::PARAM_STR);
    $ps->execute();
    $account = $ps->fetch();
    return $account;
  }
  public function createAccount($name, $hashed_password){
    $sql = "INSERT INTO accounts(name, hashed_password) VALUES (:name, :hashed_password)";
    $ps = $this->pdo->prepare($sql);
    $ps->bindValue(":name", $name, PDO::PARAM_STR);
    $ps->bindValue(":hashed_password", $hashed_password, PDO::PARAM_STR);
    $ps->execute();
  }
} 
?>