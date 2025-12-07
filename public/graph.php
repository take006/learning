<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/includes/functions.php';

try{

$pdo = getPDO();
$sql = "SELECT SUM(study_minutes) AS total_minutes FROM learning_history";

$ps = $pdo->prepare($sql);
$ps->execute();
$total_study_minutes = $ps->fetchColumn();

$sql ="SELECT SUM(study_minutes) / 60 AS total_hours FROM learning_history";
$ps = $pdo->prepare($sql);
$ps->execute();
$total_study_hours = $ps->fetchColumn();

} catch(PDOException $e){
  error_log("PDOException:" . $e->getMessage());
  header('Location: error.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
  <?php require_once __DIR__  . '/../app/views/_head_view.php'; ?>
<body>
  <?php require_once __DIR__ . '/../app/views/header.php'; ?>
  <h1 class="text-4xl">Graph Page</h1>
  <p>合計：<?=  h($total_study_minutes) ?>分</p>
  <p>合計：<?=  h($total_study_hours) ?>時間</p>
  <h2>○月の学習</h2>
  <ul>
    <li>合計～minutes</li>
    <li>合計～hours</li>
  </ul>
  <h2>実装予定</h2>
  <p>合計学習時間：毎週～毎月</p>
  <p>カテゴリ割合（円グラフ）</p>
  <p>学習時間の合計（棒グラフ化）：YouTubeの動画でよくあるグラフ推移のやつ風</p>
  <?php require_once __DIR__ . '/../app/views/footer.php'; ?>
</body>
</html>