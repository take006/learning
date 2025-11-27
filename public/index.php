<?php
  require_once __DIR__ . '/../config/config.php';
  require_once __DIR__ . '/../app/includes/functions.php';

try {
  $options = [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false
  ];


  $pdo = getPDO();  
  $sql = "SELECT id, post_date, category, comment, study_minutes
  FROM learning_history
  WHERE DATE(post_date) = CURDATE()";
  $ps = $pdo->prepare($sql);
  $ps->execute();
  $record_today = $ps->fetch();
  
  //昨日
  $yesterday = date('Y-m-d', strtotime('-1 day'));
  $sql = "SELECT id, post_date, category, comment, study_minutes
          FROM learning_history
          WHERE DATE(post_date) = :yesterday";
  $ps = $pdo->prepare($sql);
  $ps->bindValue(':yesterday', $yesterday, PDO::PARAM_STR);
  $ps->execute();
  $records_yesterday = $ps->fetchAll();

  //1週間前
  $sql = "SELECT * FROM learning_history WHERE post_date >= DATE_SUB(NOW(), INTERVAL 7 DAY) ORDER BY post_date DESC";
  $ps = $pdo->prepare($sql);
  $ps->execute();
  $weekly_records = $ps->fetchAll();


} catch (PDOException $e) {
  error_log("PDOException:" . $e->getMessage());
  header("Location:error.php");
  exit();  
}
?>

<!DOCTYPE html>
<html lang="ja">
  <?php require_once __DIR__  . '/../app/views/_head_view.php'; ?>
<body class="bg-gray-50">
  <?php require_once __DIR__  . '/../app/views/header.php'; ?>
  <main>
    <section id="main-wrapper" class="flex flex-col justify-center min-h-screen">
      <div>
        <a href="<?= BASE_URL ?>public/create.php"><button 
                class="text-white border border-green-700 bg-green-700 hover:bg-green-900 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 transition duration-150 ease-in-out">
                  新規作成
        </button></a>
      </div>
      <div>
        <a href="<?= BASE_URL ?>public/signin.php"><button 
                class="text-white border border-green-700 bg-green-700 hover:bg-green-900 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 transition duration-150 ease-in-out">
                  Login
        </button></a>
      </div>

      <!-- 今日 -->
      <div class="p-10">
        <h2 class="text-lg font-bold mb-4">today</h2>
        <?php if (!empty($record_today)): ?>
        <!-- grid-colsをレスポンシブ化 -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          <div class="bg-white border border-gray-200 p-4 rounded-2xl shadow">
            <p class="max-w-7xl mx-auto py-1 px-4 text-right text-sm text-gray-500">
              <?= date('Y年n月j日 G時i分', strtotime($record_today['post_date'])) ?>
            </p>
            <ul class="p-0">
              <li class="font-bold"><?= h($record_today['category']); ?></li>
              <li><?= h($record_today['study_minutes']); ?>分</li>
              <li><?= nl2br(h($record_today['comment'])); ?></li>
            </ul>
            <!-- 編集フォーム -->
            <form action="<?= BASE_URL ?>app/edit.php" method="get" class="inline-block">
              <input type="hidden" name="id" value="<?= h($record_today['id']); ?>" placeholder="input comment or comment">
              <button type="submit" 
                      class="text-purple-700 hover:text-white border border-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-4 py-2">
                編集
              </button>
            </form>

            <!-- 削除フォーム -->
            <form action="<?= BASE_URL ?>app/delete.php" method="post" class="inline-block" 
                  onsubmit="return confirm('本当に削除しますか？');">
              <input type="hidden" name="id" value="<?= h($record_today['id']); ?>">
              <button type="submit" 
                      class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2">
                削除
              </button>
            </form>
          </div>
        </div>
        <?php else: ?>
          <p class="text-gray-500">今日の学習記録はありません。</p>
        <?php endif; ?>
      </div>

      <!-- 昨日 -->
      <div class="p-10">
        <h2 class="text-lg font-bold mb-4">昨日</h2>

        <?php if (!empty($records_yesterday)) : ?>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

            <?php foreach ($records_yesterday as $yesterday) : ?>
              <div class="bg-white border border-gray-200 p-4 rounded-2xl shadow">
                <p class="max-w-7xl mx-auto py-1 px-4 text-right text-sm text-gray-500">
                  <?= date('Y年n月j日 G時i分', strtotime($yesterday['post_date'])) ?>
                </p>
                <ul class="p-0">
                  <li class="font-bold"><?= h($yesterday['category']); ?></li>
                  <li><?= h($yesterday['study_minutes']); ?>分</li>
                  <li><?= nl2br(h($yesterday['comment'])); ?></li>
                </ul>

                <!-- 編集フォーム -->
                <form action="<?= BASE_URL ?>app/edit.php" method="get" class="inline-block">
                  <input type="hidden" name="id" value="<?= h($yesterday['id']); ?>">
                  <button type="submit"
                    class="text-purple-700 hover:text-white border border-purple-700 hover:bg-purple-800
                          focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-4 py-2">
                    編集
                  </button>
                </form>

                <!-- 削除フォーム -->
                <form action="<?= BASE_URL ?>app/delete.php" method="post" class="inline-block"
                      onsubmit="return confirm('本当に削除しますか？');">
                  <input type="hidden" name="id" value="<?= h($yesterday['id']); ?>">
                  <button type="submit"
                    class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800
                          focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2">
                    削除
                  </button>
                </form>

              </div>
            <?php endforeach; ?>

          </div>

        <?php else : ?>
          <p class="text-gray-500">昨日の学習記録はありません。</p>
        <?php endif; ?>
      </div>


      <!-- 学習記録一覧 -->
      <div class="p-10">
        <h2 class="text-lg font-bold mb-4">今週</h2>
        <!-- 昨日・今週・一か月前も同様に以下のように修正 -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          <?php foreach($weekly_records as $weekly_record){ ?>
          <div class="bg-white border border-gray-200 p-4 rounded-2xl shadow">
              <p class="max-w-7xl mx-auto py-1 text-right text-sm text-gray-500">
                <?= date('Y年n月j日 G時i分', strtotime($weekly_record['post_date'])) ?>
              </p>
              <ul class="mb-4 p-0">
                <li class="font-bold"><?= h($weekly_record['category']); ?></li>
                <li><?= h($weekly_record['study_minutes']); ?></li>
                <li><?= nl2br(h($weekly_record['comment'])); ?></li>
              </ul>

              <!-- 編集フォーム -->
              <form action="<?= BASE_URL ?>app/edit.php" method="get" class="inline-block">
                <input type="hidden" name="id" value="<?= h($weekly_record['id']); ?>">
                <button type="submit" 
                        class="text-purple-700 hover:text-white border border-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-4 py-2">
                  編集
                </button>
              </form>

              <!-- 削除フォーム -->
              <form action="<?= BASE_URL ?>app/delete.php" method="post" class="inline-block" 
                    onsubmit="return confirm('本当に削除しますか？');">
                <input type="hidden" name="id" value="<?= h($weekly_record['id']); ?>">
                <button type="submit" 
                        class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2">
                  削除
                </button>
              </form>
          </div>
          <?php } ?>
        </div>
      </div>
      <?php require_once __DIR__ . '/../app/views/footer.php'; ?>
    </section>
  </main>
</body>
</html>
