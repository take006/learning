<?php
require_once __DIR__ . '/../config/config.php';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
  <body>
    <h2>error.php</h2>
    <?php if(isset($_GET['msg'])): ?>
      <p class="text-red-900"><?= htmlspecialchars($_GET['msg'], ENT_QUOTES, 'UTF-8'); ?></p>
    <?php else: ?>
      <p class="text-red-900">詳細はconsoleを確認してください。</p>
    <?php endif; ?>
  </body>
</html>