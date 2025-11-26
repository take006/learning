<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/includes/functions.php';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Success</title>

  <script src="https://cdn.tailwindcss.com"></script>

  <!-- 1.5秒後にリダイレクト -->
  <script>
    setTimeout(() => {
      window.location.href = "index.php";
    }, 1500);
  </script>
</head>

<body class="bg-gray-50">

  <!-- 配置制御コンテナ -->
  <div class="flex items-start justify-center min-h-screen
              md:items-center">

    <!-- スマホ：上寄せ（mt-24）、PC：中央（md:mt-0） -->
    <div class="w-11/12 md:w-1/2 mt-24 md:mt-0">

      <h1 class="text-green-900 text-center text-xl font-bold mb-4">Successed!</h1>

      <div class="flex items-center justify-center p-4 mb-4 text-sm text-green-800 
                  border border-green-300 rounded-lg bg-green-50
                  dark:bg-gray-800 dark:text-green-400 dark:border-green-800">

        <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
             xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
          <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>

        <div>
          <span class="font-medium">更新完了</span> 3秒後にホームへリダイレクトします。
        </div>
      </div>
    </div>
  </div>
</body>
</html>
