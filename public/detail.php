<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/includes/functions.php';

  $id = (int)filter_input(INPUT_GET, "id");
  if($id === ""){
  error_log("Validate:id is required");
  header("Location:error.php");
  exit();
  }
  if(filter_var($id, FILTER_VALIDATE_INT) === false){
    error_log("Validate:id is not int");
    header("Location:error.php");
    exit();
  }


  try {
    $pdo = getPDO();
    $sql = "select id, post_date, category, comment from learning_history where id = :id";
    $ps = $pdo->prepare($sql);
    $ps->bindValue(":id", $id, PDO::PARAM_INT);
    $ps->execute();
    $learning = $ps->fetch();
  } catch (PDOException $e){
    error_log("PDOException:" . $e->getMessage());
    header("Location:error.php");
    exit();  
  }
?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>detail</title>
  <!-- TailwindCSS CDN（開発用。ビルド時はローカルビルド推奨） -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="reset.css">
</head>
<body>
  <?php include_once './header.php' ?>
  <main>
    <section id="main-wrapper" class="flex flex-col justify-center">
      <div class="p-10">
        <h2>details redord</h2>
        <div class="bg-gray-100 p-4 my-4 rounded-4xl w-1/3 shadow-gray-100">
            <ul>
            <li><?= h($learning['id']) ?></li>
            <li><?= h( $learning['post_date']) ?></li>
            <li><?= h($learning['category']) ?></li>
            <li><?= h($learning['comment']) ?></li>
            </ul>
        </div>
      </div>
    </section>
  </main>
  <script></script>
</body>
</html>