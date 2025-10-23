<?php


$host = 'localhost';
$dbname = 'learning_db';
$username = 'root';
$password = '';

try {
    $options = [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false
  ];
  $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf-8", $username, $password, $options);


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