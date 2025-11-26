<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/includes/functions.php';

try{

  $pdo = getPDO();
$sql = "SELECT SUM(study_minutes) AS total_minutes FROM learning_history";

$ps = $pdo->prepare($sql);
$ps->execute();
$total_study_minutes = $ps->fetchColumn();
} catch(PDOException $e){
  error_log("PDOException:" . $e->getMessage());
  header('Location: error.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Graph</title>
  <!-- TailwindCSS CDN（開発用。ビルド時はローカルビルド推奨） -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
  <?php require_once __DIR__ . '/../app/views/header.php'; ?>
  <h1 class="text-4xl">Graph Page</h1>
  <p>合計学習時間：<?=  h($total_study_minutes) ?>分</p>
  <p>カテゴリ割合（円グラフ）</p>
  <p>学習時間の合計（棒グラフ化）：YouTubeの動画でよくあるグラフ推移のやつ風</p>
  <?php require_once __DIR__ . '/../app/views/footer.php'; ?>
</body>
</html>