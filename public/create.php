<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/includes/functions.php';
?>
<!DOCTYPE html>
<html lang="ja">
  <?php require_once __DIR__  . '/../app/views/_head_view.php'; ?>
<body class="bg-gray-50 min-h-screen flex flex-col">
  <?php include_once __DIR__  . '/../app/views/header.php' ?>
  <main class="flex-1">
    <section class="border border-gray-300 p-4 my-4 rounded w-full flex flex-col items-center">
      <!-- 新規作成フォーム -->
      <div class="p-6 w-full md:w-2/3 lg:w-1/2">
        <div class="flex flex-col justify-center border border-gray-200 bg-white p-6 my-4 rounded-2xl shadow">
          <form action="<?= BASE_URL ?>app/controllers/store.php" method="post">
            <h2 class="text-xl font-bold mb-6 text-center text-gray-800">新規作成</h2>

            <label for="post_date" class="block mb-2 text-sm font-medium text-gray-900">日付<span class="text-red-500">*</span></label>
            <input type="datetime-local" name="post_date" id="post_date"
                   class="border border-gray-300 w-full mb-4 p-2 rounded focus:outline-none focus:ring-2 focus:ring-green-400"
                   required>

            <label for="study_minutes" class="block mb-2 text-sm font-medium text-gray-900">学習時間<span class="text-red-500">*</span></label>
            <input type="number" name="study_minutes" id="study_minutes"
                   class="border border-gray-300 w-full mb-4 p-2 rounded focus:outline-none focus:ring-2 focus:ring-green-400"
                   required>

            <label for="category" class="block mb-2 text-sm font-medium text-gray-900">カテゴリー<span class="text-red-500">*</span></label>
            <input type="text" name="category" id="category"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 mb-4 focus:outline-none focus:ring-2 focus:ring-green-400"
                   placeholder="カテゴリーを入力" required>

            <label for="comment" class="block mb-2 text-sm font-medium text-gray-900">コメント<span class="text-red-500">*</span></label>
            <textarea name="comment" id="comment"
                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 mb-4 min-h-[250px] focus:outline-none focus:ring-2 focus:ring-green-400"
                      placeholder="コメントを入力" required></textarea>

            <div class="flex justify-center">
              <button type="submit"
                      class="text-white bg-green-700 hover:bg-green-800 border border-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-6 py-2 transition duration-150 ease-in-out">
                保存
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
