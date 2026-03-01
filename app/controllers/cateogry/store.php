<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../app/includes/functions.php';

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

try {
 $pdo = getPDO();
  // idは自動採番なので指定しない
  $sql = "INSERT INTO categories category VALUES :category";
  $ps = $pdo->prepare($sql);
  $ps->bindValue(":category", $category, PDO::PARAM_STR);
  $ps->execute();

  header('Location: '. BASE_URL . 'public/success.php');
  exit();
} catch (PDOException $e){
  $msg = urlencode($e->getMessage()); // URL用にエンコード
  header("Location:error.php?msg={$msg}");
  exit();
}
?>

