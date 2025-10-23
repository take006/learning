<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>勉強を記録するアプリケーション</title>
  <!-- TailwindCSS CDN（開発用。ビルド時はローカルビルド推奨） -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="reset.css">
</head>
<body>
<?php include_once './header.php' ?>
  <main>
      <section class="border border-gray-400 p-4 my-4 rounded w-100 flex flex-col">
      <!-- 新規作成フォーム -->
      <div class="p-10">
        <div class="w-1/2 flex flex-col justify-center border border-gray-200 p-6 my-4 rounded-2xl shadow">
          <form action="./create.php" method="post">
            <h2 class="text-lg font-bold mb-4">新規作成</h2>

            <label for="post_date" class="block mb-2 text-sm font-medium text-gray-900">日付</label>
            <input type="datetime-local" name="post_date" id="post_date" 
                   class="border border-gray-300 w-full mb-4 p-2 rounded">

            <label for="category" class="block mb-2 text-sm font-medium text-gray-900">カテゴリー</label>
            <input type="text" name="category" id="category" 
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 mb-4" 
                   placeholder="カテゴリーを入力" required>

            <label for="comment" class="block mb-2 text-sm font-medium text-gray-900">コメント</label>
            <textarea name="comment" id="comment" 
                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 mb-4 min-h-[250px]" 
                      placeholder="コメントを入力" required></textarea>

              <button type="submit" 
                        class="text-white border border-green-700 bg-green-700 hover:bg-green-900 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 transition duration-150 ease-in-out">
                  保存
                </button>
          </form>
        </div>
      </div>
  </section>
  </main>
  <?php include_once './footer.php' ?>
</body>
</html>