<?php

require_once __DIR__ . '/../config/config.php';

try {

  $pdo = getPDO();
  $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
  if (!$id) {
      // idが無効な場合はエラーページへ
      error_log("Delete: Invalid ID");
      header('Location:error.php?msg=invalid_id');
      exit();
  }

  $sql = "delete from learning_history where id = :id";
  $ps = $pdo->prepare($sql);
  $ps->bindValue(':id', $id, PDO::PARAM_INT);
  $ps->execute();
  header("Location: index.php?msg=deleted");
  exit();

} catch (PDOException $e){
  error_log("PDOException:" . $e->getMessage());
  header("Location:error.php?msg=db_error");
  exit();
}
?>