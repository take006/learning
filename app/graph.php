<?php
require_once __DIR__ . '/../config/config.php';
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
  <?php require_once("header.php"); ?>
  <h1 class="text-4xl">Graph Page</h1>
  <p>カテゴリ割合（円グラフ）</p>
  <p>学習時間の合計（棒グラフ化）：YouTubeの動画でよくあるグラフ推移のやつ風</p>
  <?php require_once("footer.php"); ?>
</body>
</html>