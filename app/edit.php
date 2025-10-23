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
  $id = (int)filter_input(INPUT_GET, "id");
  
  $sql = "SELECT id, post_date, category, comment FROM learning_history WHERE id = :id";
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
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="reset.css">
</head>
<body>
  <?php include_once './header.php' ?>
  <main>
    <section class="flex flex-col justify-center">
    <div class="flex justify-center min-h-screen">
      <h2>Edit</h2>
      <form action="./update.php" method="post" class="w-1/2">
        <input type="hidden" name="id" value="<?= htmlspecialchars($learning['id'], ENT_QUOTES, 'UTF-8'); ?>">

        <label for="post_date" class="block mb-2 text-sm font-medium text-gray-900">日付</label>
        <input type="date" id="post_date" name="post_date"
  value="<?= htmlspecialchars(date('Y-m-d', strtotime($learning['post_date'])), ENT_QUOTES, 'UTF-8'); ?>"
  class="border border-gray-300 w-full mb-4 p-2 rounded">
        
        <label for="category" class="block mb-2 text-sm font-medium text-gray-900">category</label>  
        <input type="text" id="category" name="category" 
          value="<?= htmlspecialchars($learning['category'], ENT_QUOTES, 'UTF-8'); ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 mb-4">

        <label for="comment" class="block mb-2 text-sm font-medium text-gray-900">comment</label>
        <textarea id="comment" name="comment" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 mb-4 min-h-[250px]"><?= htmlspecialchars($learning['comment'], ENT_QUOTES, 'UTF-8'); ?></textarea>
        <button class="text-gray-700 hover:text-white border border-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2">
        <a href="index.php">戻る</a>
        </button>
        <button type="submit" class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">更新</button>
      </form>
    </div>
    </section>
  </main>
</body>
</html>
