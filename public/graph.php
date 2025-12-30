<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/includes/functions.php';

try{

$pdo = getPDO();
$sql = "SELECT SUM(study_minutes) AS total_minutes FROM learning_history";

$ps = $pdo->prepare($sql);
$ps->execute();
$total_study_minutes = $ps->fetchColumn();

$sql ="SELECT ROUND(SUM(study_minutes) / 60, 2) AS total_hours FROM learning_history";
$ps = $pdo->prepare($sql);
$ps->execute();
$total_study_hours = $ps->fetchColumn();

$sql = "SELECT ROUND(SUM(study_minutes) / 60, 2)  AS total_minutes FROM learning_history WHERE category = 'PHP'";
$ps = $pdo->prepare($sql);
$ps->execute();
$php_study_hours = $ps->fetchColumn();


$sql = "SELECT ROUND(SUM(study_minutes) / 60, 2)  AS total_minutes FROM learning_history WHERE category = 'Laravel'";
$ps = $pdo->prepare($sql);
$ps->execute();
$laravel_study_hours = $ps->fetchColumn();


$sql = "SELECT ROUND(SUM(study_minutes) / 60, 2)  AS total_minutes FROM learning_history WHERE category = 'AWS'";
$ps = $pdo->prepare($sql);
$ps->execute();
$aws_study_hours = $ps->fetchColumn();

} catch(PDOException $e){
  error_log("PDOException:" . $e->getMessage());
  header('Location: error.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<?php require_once __DIR__  . '/../app/views/_head_view.php'; ?>
<body class="bg-gray-100 text-gray-800">
  <?php require_once __DIR__ . '/../app/views/header.php'; ?>

  <main class="max-w-5xl mx-auto px-4 py-10">
    <!-- タイトル -->
    <h1 class="text-3xl font-bold mb-8">学習記録ダッシュボード</h1>

    <!-- 合計学習時間 -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
      <div class="bg-white rounded-xl shadow p-6">
        <p class="text-sm text-gray-500 mb-2">合計学習時間（分）</p>
        <p class="text-4xl font-semibold text-indigo-600">
          <?= h($total_study_minutes) ?>
          <span class="text-base font-normal text-gray-600">分</span>
        </p>
      </div>

      <div class="bg-white rounded-xl shadow p-6">
        <p class="text-sm text-gray-500 mb-2">合計学習時間（時間）</p>
        <p class="text-4xl font-semibold text-indigo-600">
          <?= h($total_study_hours) ?>
          <span class="text-base font-normal text-gray-600">時間</span>
        </p>
      </div>
    </div>

    <!-- 月別学習 -->
    <section class="bg-white rounded-xl shadow p-6 mb-10">
      <h2 class="text-xl font-bold mb-4">○月の学習</h2>
      <ul class="space-y-2 text-gray-700">
        <li class="flex justify-between">
          <span>合計学習時間（分）</span>
          <span>～ minutes</span>
        </li>
        <li class="flex justify-between">
          <span>合計学習時間（時間）</span>
          <span>～ hours</span>
        </li>
      </ul>
    </section>

    <!-- 実装予定 -->
    <section class="bg-white rounded-xl shadow p-6">
      <h2 class="text-xl font-bold mb-4">実装予定</h2>
      <ul class="list-disc list-inside space-y-2 text-gray-700">
        <li>合計学習時間（週・月単位）</li>
        <li>カテゴリ割合（円グラフ）</li>
        <li>学習時間推移（棒グラフ）</li>
      </ul>
    </section>

    
    <h2 class="text-3xl font-bold my-8">PHP</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
      <div class="bg-white rounded-xl shadow p-6">
        <p class="text-sm text-gray-500 mb-2">合計学習時間（時間）</p>
        <p class="text-4xl font-semibold text-indigo-600">
          <?= h($php_study_hours) ?>
          <span class="text-base font-normal text-gray-600">時間</span>
        </p>
      </div>
    </div>

        <h2 class="text-3xl font-bold my-8">Laravel</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
      <div class="bg-white rounded-xl shadow p-6">
        <p class="text-sm text-gray-500 mb-2">合計学習時間（時間）</p>
        <p class="text-4xl font-semibold text-indigo-600">
          <?= h($laravel_study_hours) ?>
          <span class="text-base font-normal text-gray-600">時間</span>
        </p>
      </div>
    </div>

        <h2 class="text-3xl font-bold my-8">AWS</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
      <div class="bg-white rounded-xl shadow p-6">
        <p class="text-sm text-gray-500 mb-2">合計学習時間（時間）</p>
        <p class="text-4xl font-semibold text-indigo-600">
          <?= h($aws_study_hours) ?>
          <span class="text-base font-normal text-gray-600">時間</span>
        </p>
      </div>
    </div>
  </main>

  <?php require_once __DIR__ . '/../app/views/footer.php'; ?>
</body>
</html>
