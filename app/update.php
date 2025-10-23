<?php
$post_date = (string)filter_input(INPUT_POST, "post_date");
if($post_date === ""){
  error_log("Validation Check: post_date を入力してください") ;
}
$category = (string)filter_input(INPUT_POST, "category");
if($post_date === ""){
  error_log("Validation check: カテゴリーを入力してください");
}
$comment = (string)filter_input(INPUT_POST, "comment");
if($comment === ""){
  error_log("Validation check: コメントを入力してください");
}
$id = (int)filter_input(INPUT_POST, "id");
if($id <= 0){
  error_log("Validation check: id is invalid");
  header("Location:error.php");
  exit();
}
$host = "localhost";
$dbname = "learning_db";
$username = "root";
$password = "";
try {
  $options = [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false
  ];
  $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, $options);
  $sql = "update learning_history set post_date = :post_date, category = :category, comment = :comment where id = :id";
  $ps = $pdo->prepare($sql);
  $ps->bindValue(":post_date", $post_date, PDO::PARAM_STR);
  $ps->bindValue(":category", $category, PDO::PARAM_STR);
  $ps->bindValue(":comment", $comment, PDO::PARAM_STR);
  $ps->bindValue(":id", $id, PDO::PARAM_INT);
  $ps->execute();
  header("Location: success.php");

} catch (PDOException $e){
  $msg = urlencode($e->getMessage()); // URL用にエンコード
  header("Location:error.php?msg={$msg}");
  exit();
}