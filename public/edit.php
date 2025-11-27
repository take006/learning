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
  $id = (int)filter_input(INPUT_GET, "id");
  
  $sql = "SELECT id, post_date, category, comment, study_minutes FROM learning_history WHERE id = :id";
  $ps = $pdo->prepare($sql);
  $ps->execute([':id' => $id]);
  $learning = $ps->fetch();

  if(!$learning){
    error_log("Validate:record not found");
    header("Location:error.php");
    exit();
  }

} catch (PDOException $e){
  $msg = urlencode($e->getMessage()); // URL用にエンコード
  header("Location:error.php?msg={$msg}");
  exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
  <?php require_once __DIR__  . '/../app/views/_head_view.php'; ?>
<body>
  <?php require_once __DIR__ .  '/../app/views/header.php' ?>
  <main>
<section class="flex flex-col justify-center">
  <div class="flex justify-center min-h-screen items-center px-4">
    <div class="w-full md:w-2/3 lg:w-1/2 bg-white border border-gray-200 p-6 rounded-2xl shadow">
      <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">編集</h2>
      <form action="<?= BASE_URL ?>app/controllers/update.php" method="post" class="flex flex-col">
        <input type="hidden" name="id" value="<?= h($learning['id']); ?>">

        <label for="post_date" class="block mb-2 text-sm font-medium text-gray-900">日付</label>
        <input type="datetime-local" id="post_date" name="post_date"
          value="<?= h(date('Y-m-d\TH:i', strtotime($learning['post_date'] ?? ''))); ?>"
          class="border border-gray-300 w-full mb-4 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-300">

        <label for="study_minutes" class="block mb-2 text-sm font-medium text-gray-900">学習時間</label>
         <input type="number" name="study_minutes" id="study_minutes" value="<?=  h($learning['study_minutes']); ?>"
        class="border border-gray-300 w-full mb-4 p-2 rounded focus:outline-none focus:ring-2 focus:ring-green-400">

        <label for="category" class="block mb-2 text-sm font-medium text-gray-900">カテゴリー</label>  
        <input type="text" id="category" name="category" 
          value="<?= h($learning['category']); ?>" 
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 mb-4 focus:outline-none focus:ring-2 focus:ring-blue-300">

        <label for="comment" class="block mb-2 text-sm font-medium text-gray-900">コメント</label>
        <textarea id="comment" name="comment"
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 mb-6 min-h-[200px] focus:outline-none focus:ring-2 focus:ring-blue-300"><?= htmlspecialchars($learning['comment'], ENT_QUOTES, 'UTF-8'); ?></textarea>

        <!-- ボタンエリア -->
        <div class="flex flex-col sm:flex-row justify-center items-center gap-3 sm:gap-6">
          <!-- 戻るボタン -->
          <a href="<?= BASE_URL ?>" 
             class="inline-block text-center w-full sm:w-40 bg-white text-blue-600 border border-blue-600 hover:opacity-75 focus:ring-2 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 transition duration-150 ease-in-out">
            戻る
          </a>

          <!-- 更新ボタン -->
          <button type="submit"
            class="w-full sm:w-40 text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:from-purple-700 hover:to-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition duration-150 ease-in-out">
            更新
          </button>
        </div>
      </form>
    </div>
  </div>
</section>
  </main>
  <?php require_once __DIR__ .  '/../app/views/footer.php' ?>
</body>
</html>
