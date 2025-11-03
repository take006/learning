<?php
require_once __DIR__ . '/../config/config.php';
try {
$pdo = getPDO();
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$sql = "SELECT * FROM learning_history ORDER BY post_date DESC LIMIT :limit OFFSET :offset";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = $pdo->query("SELECT COUNT(*) FROM learning_history")->fetchColumn();
$total_pages = ceil($total / $limit);
} catch (PDOException $e) {
  error_log($e->getMessage());
  $msg = urlencode($e->getMessage()); // URL用にエンコード
  header("Location:error.php?msg={$msg}");
  exit();
}
?>

<?php




?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home:learning-app</title>
  <!-- TailwindCSS CDN（開発用。ビルド時はローカルビルド推奨） -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="reset.css">
</head>
<body class="bg-gray-50">
  <?php include_once './header.php' ?>
  <main>
    <section id="main-wrapper" class="flex flex-col justify-center min-h-screen">
      <!-- 学習記録一覧 -->
      <div class="p-10">
        <h2 class="text-2xl font-bold mb-10 text-center">学習記録一覧</h2>
        <div class="grid grid-cols-2 gap-4">
        <?php foreach($records as $record){ ?>
          <div class="bg-white border border-gray-200 p-4 rounded-2xl shadow">
              <ul class="mb-4">
                <li>ID: <?= htmlspecialchars($record['id'], ENT_QUOTES, 'UTF-8'); ?></li>
                <li>日付: <?= htmlspecialchars($record['post_date'], ENT_QUOTES, 'UTF-8'); ?></li>
                <li>カテゴリー: <?= htmlspecialchars($record['category'], ENT_QUOTES, 'UTF-8'); ?></li>
                <li>コメント: <?= nl2br(htmlspecialchars($record['comment'], ENT_QUOTES, 'UTF-8')); ?></li>
              </ul>

              <!-- 編集フォーム -->
              <form action="./edit.php" method="get" class="inline-block">
                <input type="hidden" name="id" value="<?= htmlspecialchars($record['id'], ENT_QUOTES, 'UTF-8'); ?>">
                <button type="submit" 
                        class="text-purple-700 hover:text-white border border-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-4 py-2">
                  編集
                </button>
              </form>

              <!-- 削除フォーム -->
              <form action="./delete.php" method="post" class="inline-block" 
                    onsubmit="return confirm('本当に削除しますか？');">
                <input type="hidden" name="id" value="<?= htmlspecialchars($record['id'], ENT_QUOTES, 'UTF-8'); ?>">
                <button type="submit" 
                        class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2">
                  削除
                </button>
              </form>
          </div>
        <?php } ?>
        </div>
      </div>
      <div>
        <!-- ページネーション -->
      <div class="flex justify-center space-x-2 mt-4">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?= $i ?>" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300"><?= $i ?></a>
        <?php endfor; ?>
      </div>
      </div>
      <?php require_once("footer.php") ?>
    </section>
  </main>
</body>
</html>
