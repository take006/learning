<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/includes/functions.php';

// エラーメッセージを受け取る変数
$err = [];

// confirmからエラーを返された時
if (isset($_SESSION['err'])) {
  // エラー内容を変数に格納
  $err = $_SESSION['err'];
  // セッションのエラー内容を削除
  unset($_SESSION['err']);
}


?>
<!DOCTYPE html>
<html lang="ja">
  <?php require_once __DIR__  . '/../app/views/_head_view.php'; ?>
  <body>
    <h2 class="font-medium">error.php</h2>
    <?php if(isset($_GET['msg'])): ?>
      <p class="text-red-900"><?= htmlspecialchars($_GET['msg'], ENT_QUOTES, 'UTF-8'); ?></p>
    <?php else: ?>
      <p class="text-red-900">詳細はconsoleを確認してください。</p>
    <?php endif; ?>
    <?php require_once __DIR__ . '/../app/views/_message_view.php'; ?>
        <?php if (count($err) > 0) : ?>
      <!-- 入力エラーがある場合: メッセージを表示 -->
      <div class="error_messages_container">
        <ul>
          <?php for ($i = 0; $i < count($err); $i++) : ?>
            <li><?= $err[$i] ?></li>
          <?php endfor; ?>
        </ul>
      </div>
    <?php endif; ?>
  </body>
</html>
