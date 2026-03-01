<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/includes/functions.php';

try {
$pdo = getPDO();
$limit = 10;
$requestedPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$sql = "SELECT * FROM learning_history ORDER BY post_date DESC LIMIT :limit OFFSET :offset";

$total = (int)$pdo->query("SELECT COUNT(*) FROM learning_history")->fetchColumn();
$total_pages = max(1, (int)ceil($total / $limit));

$page = max(1, min($requestedPage, $total_pages));
$offset = ($page - 1) * $limit;

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  error_log($e->getMessage());
  $msg = urlencode($e->getMessage()); // URL用にエンコード
  header("Location:error.php?msg={$msg}");
  exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
  <?php require_once __DIR__  . '/../app/views/_head_view.php'; ?>
<body class="bg-gray-50">
  <?php include_once __DIR__ .'/../app/views/header.php' ?>
  <main>
    <section id="main-wrapper" class="flex flex-col justify-center min-h-screen">
      <!-- 学習記録一覧 -->
      <div class="p-10">
        <h2 class="text-2xl font-bold mb-10 text-center">学習記録一覧</h2>

        <!-- grid-colsをレスポンシブ対応に変更 -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          <?php if (!empty($records)): ?>
            <?php foreach ($records as $record): ?>
            <div class="bg-white border border-gray-200 p-4 rounded-2xl shadow">
              <p class="max-w-7xl mx-auto py-1 px-4 text-right text-sm text-gray-500">
                <?= date('Y年n月j日 G時i分', strtotime($record['post_date'])) ?>
              </p>
              <ul class="mb-4 p-0">
                <li class="font-bold"><?= h($record['category']); ?></li>
                <li class="font-medium"><?= h($record['study_minutes']); ?>分</li>
                <li class="py-2"><?= nl2br(h($record['comment'])); ?></li>
              </ul>
              <!-- 編集フォーム -->
              <form action="<?= BASE_URL ?>public/edit.php" method="get" class="inline-block">
                <input type="hidden" name="id" value="<?= h($record['id']); ?>">
                <button type="submit" 
                        class="text-purple-700 hover:text-white border border-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-4 py-2">
                  編集
                </button>
              </form>

              <!-- 削除フォーム -->
              <form action="<?= BASE_URL ?>app/controllers/delete.php" method="post" class="inline-block" 
                    onsubmit="return confirm('本当に削除しますか？');">
                <input type="hidden" name="id" value="<?= h($record['id']); ?>">
                <button type="submit" 
                        class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2">
                  削除
                </button>
              </form>
            </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p class="text-gray-500">学習記録はまだありません。</p>
          <?php endif; ?>
        </div>
      </div>
      <!-- ページネーション -->
      <div class="px-4 pb-8">
        <?php
          $prevPage = max(1, $page - 1);
          $nextPage = min($total_pages, $page + 1);
          $startPage = max(1, $page - 2);
          $endPage = min($total_pages, $startPage + 4);
          $startPage = max(1, $endPage - 4);
        ?>
        <div class="flex justify-center items-center gap-1 md:gap-2 mt-2 flex-wrap">
          <a href="?page=1"
             class="min-w-9 text-center px-2 py-2 text-sm rounded border <?= $page === 1 ? 'pointer-events-none text-gray-300 border-gray-200 bg-gray-50' : 'text-gray-700 border-gray-300 bg-white hover:bg-gray-100' ?>"
             aria-label="最初のページ">
            ≪
          </a>

          <a href="?page=<?= $prevPage ?>"
             class="min-w-9 text-center px-2 py-2 text-sm rounded border <?= $page === 1 ? 'pointer-events-none text-gray-300 border-gray-200 bg-gray-50' : 'text-gray-700 border-gray-300 bg-white hover:bg-gray-100' ?>"
             aria-label="前のページ">
            ＜
          </a>

          <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
            <a href="?page=<?= $i ?>"
               class="min-w-9 text-center px-3 py-2 text-sm rounded border <?= $i === $page ? 'text-white bg-purple-700 border-purple-700' : 'text-gray-700 border-gray-300 bg-white hover:bg-gray-100' ?>"
               aria-label="<?= $i ?>ページ">
              <?= $i ?>
            </a>
          <?php endfor; ?>

          <a href="?page=<?= $nextPage ?>"
             class="min-w-9 text-center px-2 py-2 text-sm rounded border <?= $page === $total_pages ? 'pointer-events-none text-gray-300 border-gray-200 bg-gray-50' : 'text-gray-700 border-gray-300 bg-white hover:bg-gray-100' ?>"
             aria-label="次のページ">
            ＞
          </a>

          <a href="?page=<?= $total_pages ?>"
             class="min-w-9 text-center px-2 py-2 text-sm rounded border <?= $page === $total_pages ? 'pointer-events-none text-gray-300 border-gray-200 bg-gray-50' : 'text-gray-700 border-gray-300 bg-white hover:bg-gray-100' ?>"
             aria-label="最後のページ">
            ≫
          </a>
        </div>
      </div>
  <?php include_once __DIR__ .'/../app/views/footer.php' ?>
    </section>
  </main>
</body>
</html>
