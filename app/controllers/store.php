<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../app/includes/functions.php';
$post_date = trim((string)filter_input(INPUT_POST, "post_date"));
if($post_date === ""){
  error_log("Validate:post_date is required");
  header("Location:error.php");
  exit();
}
$study_minutes = filter_input(INPUT_POST, 'study_minutes', FILTER_VALIDATE_INT);
if($study_minutes === ""){
  error_log("Validate:study_minutes is required");
  header('Location: error.php');
  exit();
}
$category = trim((string)filter_input(INPUT_POST, "category"));
if($category === ""){
  error_log("Validate:category is required");
  header("Location:error.php");
  exit();
}
if(mb_strlen($category) > 255){
  error_log("Validate:category length > 255");
  header("Location:error.php");
  exit();
}
$comment = trim((string)filter_input(INPUT_POST, "comment"));
if($comment === ""){
  error_log("Validate:comment is required");
  header("Location:error.php");
  exit();
}
if(mb_strlen($comment) > 255){
  error_log("Validate:comment length > 255");
  header("Location:error.php");
  exit();
}


try {
 $pdo = getPDO();
  // idは自動採番なので指定しない
  $sql = "INSERT INTO learning_history (post_date, category, comment, study_minutes ) 
  VALUES (:post_date, :category, :comment, :study_minutes) ";
  $ps = $pdo->prepare($sql);
  $ps->bindValue(":post_date", $post_date, PDO::PARAM_STR);
  $ps->bindValue(":category", $category, PDO::PARAM_STR);
  $ps->bindValue(":comment", $comment, PDO::PARAM_STR);
  $ps->bindValue(":study_minutes", $study_minutes, PDO::PARAM_INT);
  $ps->execute();

  header('Location: '. BASE_URL . 'public/success.php');
  exit();
} catch (PDOException $e){
  $msg = urlencode($e->getMessage()); // URL用にエンコード
  header("Location:error.php?msg={$msg}");
  exit();
}
?>

