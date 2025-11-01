<?php
$host = "localhost";
$dbname = "learning_db";
$username = "root";
$password = "";

try {
  $options = [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false
  ];

  $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, $options);
  
  $sql = "SELECT id, post_date, category, comment
FROM learning_history
WHERE DATE(post_date) = CURDATE();
";
  $ps = $pdo->prepare($sql);
  $ps->execute();
  $record_today = $ps->fetch();
  
  //昨日
  $yesterday = date('Y-m-d', strtotime('-1 day'));
  $sql = "SELECT id, post_date, category, comment FROM learning_history WHERE post_date = :date_yesterday";
  $ps = $pdo->prepare($sql);
  $ps->bindValue(":date_yesterday", $yesterday, PDO::PARAM_STR);
  $ps->execute();
  $learning_yesterday = $ps->fetch();

  // $week_before = date('Y-m-d', strtotime('-7 day'));
  // $sql = "SELECT * FROM learning_history ORDER BY post_date DESC LIMIT :week_before OFFSET :yesterday";
  $sql = "SELECT * FROM learning_history WHERE post_date >= DATE_SUB(NOW(), INTERVAL 7 DAY) ORDER BY post_date ASC";
  $ps = $pdo->prepare($sql);
  // $ps->bindValue(':limit', $week_before, PDO::PARAM_STR);
  // $ps->bindValue(':offset', $yesterday, PDO::PARAM_STR);
  $ps->execute();
  $weekly_records = $ps->fetchAll(PDO::FETCH_ASSOC);

  //1週間前
} catch (PDOException $e) {
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
  <title>Learning-App</title>
  <!-- TailwindCSS CDN（開発用。ビルド時はローカルビルド推奨） -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="reset.css">
</head>
<body class="bg-gray-50">
  <?php include_once 'header.php' ?>
  <main>
    <section id="main-wrapper" class="flex flex-col justify-center min-h-screen">

          <div>
        <a href="newData.php"><button 
                class="text-white border border-green-700 bg-green-700 hover:bg-green-900 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 transition duration-150 ease-in-out">
                  新規作成
        </button></a>
      </div>
      
                  <!-- 学習記録一覧 -->
      <div class="p-10">
        <h2 class="text-lg font-bold mb-4">today</h2>
        <?php if (!empty($record_today)): ?>
        <div class="grid grid-cols-3 gap-4">
          <div class="bg-white border border-gray-200 p-4 rounded-2xl shadow">
              <ul class="mb-4">
                <li>ID：<?= htmlspecialchars($record_today['id'], ENT_QUOTES, 'UTF-8'); ?></li>
                <li><?= htmlspecialchars($record_today['post_date'], ENT_QUOTES, 'UTF-8'); ?></li>
                <li><?= htmlspecialchars($record_today['category'], ENT_QUOTES, 'UTF-8'); ?></li>
                <li><?= nl2br(htmlspecialchars($record_today['comment'], ENT_QUOTES, 'UTF-8')); ?></li>
              </ul>

              <!-- 編集フォーム -->
              <form action="./edit.php" method="get" class="inline-block">
                <input type="hidden" name="id" value="<?= htmlspecialchars($record_today['id'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="input comment or comment">
                <button type="submit" 
                        class="text-purple-700 hover:text-white border border-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-4 py-2">
                  編集
                </button>
              </form>

              <!-- 削除フォーム -->
              <form action="./delete.php" method="post" class="inline-block" 
                    onsubmit="return confirm('本当に削除しますか？');">
                <input type="hidden" name="id" value="<?= htmlspecialchars($record_today['id'], ENT_QUOTES, 'UTF-8'); ?>">
                <button type="submit" 
                        class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2">
                  削除
                </button>
              </form>
          </div>
          <?php else: ?>
            <p class="text-gray-500">今日の学習記録はありません。</p>
          <?php endif; ?>
        </div>
      </div>


            <!-- 学習記録一覧 -->
      <div class="p-10">
        <h2 class="text-lg font-bold mb-4">昨日</h2>
        <?php if (!empty($learning_yesterday)): ?>
        <div class="grid grid-cols-3 gap-4">
          <div class="bg-white border border-gray-200 p-4 rounded-2xl shadow">
              <ul class="mb-4">
                <li>ID：<?= htmlspecialchars($learning_yesterday['id'], ENT_QUOTES, 'UTF-8'); ?></li>
                <li><?= htmlspecialchars($learning_yesterday['post_date'], ENT_QUOTES, 'UTF-8'); ?></li>
                <li><?= htmlspecialchars($learning_yesterday['category'], ENT_QUOTES, 'UTF-8'); ?></li>
                <li><?= nl2br(htmlspecialchars($learning_yesterday['comment'], ENT_QUOTES, 'UTF-8')); ?></li>
              </ul>

              <!-- 編集フォーム -->
              <form action="./edit.php" method="get" class="inline-block">
                <input type="hidden" name="id" value="<?= htmlspecialchars($learning_yesterday['id'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="input comment or comment">
                <button type="submit" 
                        class="text-purple-700 hover:text-white border border-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-4 py-2">
                  編集
                </button>
              </form>

              <!-- 削除フォーム -->
              <form action="./delete.php" method="post" class="inline-block" 
                    onsubmit="return confirm('本当に削除しますか？');">
                <input type="hidden" name="id" value="<?= htmlspecialchars($learning_yesterday['id'], ENT_QUOTES, 'UTF-8'); ?>">
                <button type="submit" 
                        class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2">
                  削除
                </button>
              </form>
          </div>
        </div>
        <?php else: ?>
          <p class="text-gray-500">昨日の学習記録はありません。</p>
        <?php endif; ?>
      </div>

      <!-- 学習記録一覧 -->
      <div class="p-10">
        <h2 class="text-lg font-bold mb-4">今週</h2>
        <div class="grid grid-cols-3 gap-4">
        <?php foreach($weekly_records as $weekly_record){ ?>
          <div class="bg-white border border-gray-200 p-4 rounded-2xl shadow">
              <ul class="mb-4">
                <li>ID: <?= htmlspecialchars($weekly_record['id'], ENT_QUOTES, 'UTF-8'); ?></li>
                <li>日付: <?= htmlspecialchars($weekly_record['post_date'], ENT_QUOTES, 'UTF-8'); ?></li>
                <li>カテゴリー: <?= htmlspecialchars($weekly_record['category'], ENT_QUOTES, 'UTF-8'); ?></li>
                <li>コメント: <?= nl2br(htmlspecialchars($weekly_record['comment'], ENT_QUOTES, 'UTF-8')); ?></li>
              </ul>

              <!-- 編集フォーム -->
              <form action="./edit.php" method="get" class="inline-block">
                <input type="hidden" name="id" value="<?= htmlspecialchars($weekly_record['id'], ENT_QUOTES, 'UTF-8'); ?>">
                <button type="submit" 
                        class="text-purple-700 hover:text-white border border-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-4 py-2">
                  編集
                </button>
              </form>

              <!-- 削除フォーム -->
              <form action="./delete.php" method="post" class="inline-block" 
                    onsubmit="return confirm('本当に削除しますか？');">
                <input type="hidden" name="id" value="<?= htmlspecialchars($weekly_record['id'], ENT_QUOTES, 'UTF-8'); ?>">
                <button type="submit" 
                        class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2">
                  削除
                </button>
              </form>
          </div>
        <?php } ?>
        </div>
      </div>
            <!-- 学習記録一覧 -->
      <div class="p-10">
        <h2 class="text-lg font-bold mb-4">一か月前</h2>
        <div class="grid grid-cols-3 gap-4">
        <?php foreach($weekly_records as $weekly_record){ ?>
          <div class="bg-white border border-gray-200 p-4 rounded-2xl shadow">
              <ul class="mb-4">
                <li>ID: <?= htmlspecialchars($weekly_record['id'], ENT_QUOTES, 'UTF-8'); ?></li>
                <li>日付: <?= htmlspecialchars($weekly_record['post_date'], ENT_QUOTES, 'UTF-8'); ?></li>
                <li>カテゴリー: <?= htmlspecialchars($weekly_record['category'], ENT_QUOTES, 'UTF-8'); ?></li>
                <li>コメント: <?= nl2br(htmlspecialchars($weekly_record['comment'], ENT_QUOTES, 'UTF-8')); ?></li>
              </ul>

              <!-- 編集フォーム -->
              <form action="./edit.php" method="get" class="inline-block">
                <input type="hidden" name="id" value="<?= htmlspecialchars($weekly_record['id'], ENT_QUOTES, 'UTF-8'); ?>">
                <button type="submit" 
                        class="text-purple-700 hover:text-white border border-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-4 py-2">
                  編集
                </button>
              </form>

              <!-- 削除フォーム -->
              <form action="./delete.php" method="post" class="inline-block" 
                    onsubmit="return confirm('本当に削除しますか？');">
                <input type="hidden" name="id" value="<?= htmlspecialchars($weekly_record['id'], ENT_QUOTES, 'UTF-8'); ?>">
                <button type="submit" 
                        class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2">
                  削除
                </button>
              </form>
          </div>
        <?php } ?>
        </div>
      </div>
      <?php require_once("footer.php") ?>
    </section>
  </main>
</body>
</html>
