<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/includes/functions.php';
?>
<!DOCTYPE html>
<html lang="ja">
  <?php require_once __DIR__  . '/../app/views/_head_view.php'; ?>
  <body>
    <h2 class="font-medium">db_error.php</h2>
    <?php if(isset($_GET['msg'])): ?>
      <p class="text-red-900"><?= htmlspecialchars($_GET['msg'], ENT_QUOTES, 'UTF-8'); ?></p>
    <?php else: ?>
      <p class="text-red-900">詳細はconsoleを確認してください。</p>
    <?php endif; ?>
    <?php require_once __DIR__ . '/../app/views/_message_view.php'; ?>
  </body>
</html>