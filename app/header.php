<!-- Bootstrap CSSのみ（JS制御するのでBootstrapのJSは不要） -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<header class="navbar navbar-expand-md bg-white shadow-sm py-3">
  <div class="container-fluid">
    <!-- ロゴ -->
    <a class="navbar-brand fw-bold gradient-text" href="<?= BASE_URL ?>">
      🎮 Learning-Record
    </a>

    <!-- ハンバーガーボタン -->
    <button id="menu-btn" class="border-0 bg-transparent d-md-none">
      <span class="menu-bar"></span>
      <span class="menu-bar"></span>
      <span class="menu-bar"></span>
    </button>

    <!-- ナビゲーションメニュー -->
    <nav id="nav-menu" class="d-none d-md-flex flex-column flex-md-row text-center mt-3 mt-md-0">
      <a class="nav-link gradient-text fw-semibold" href="<?= BASE_URL ?>app/archive.php">一覧</a>
      <a class="nav-link gradient-text fw-semibold" href="<?= BASE_URL ?>app/newData.php">新規作成</a>
      <a class="nav-link gradient-text fw-semibold" href="<?= BASE_URL ?>app/graph.php">グラフ</a>
      <span class="nav-link text-secondary disabled">カレンダー</span>
    </nav>
  </div>
</header>

<!-- JavaScript制御 -->
<script>
  const menuBtn = document.getElementById('menu-btn');
  const navMenu = document.getElementById('nav-menu');

  menuBtn.addEventListener('click', () => {
    navMenu.classList.toggle('d-none');
    navMenu.classList.toggle('fade-in');
    menuBtn.classList.toggle('open');
  });
</script>

<!-- スタイル -->
<style>
  /* グラデーション文字 */
  .gradient-text {
    background: linear-gradient(90deg, #6a00ff, #b000ff, #ff0080);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    transition: opacity 0.3s ease;
  }
  .gradient-text:hover {
    opacity: 0.75;
  }

  /* ハンバーガーボタン */
  #menu-btn {
    width: 30px;
    height: 24px;
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    cursor: pointer;
  }

  .menu-bar {
    width: 100%;
    height: 3px;
    background-color: #000;
    border-radius: 2px;
    transition: all 0.3s ease;
  }

  /* 開閉アニメーション */
  #menu-btn.open .menu-bar:nth-child(1) {
    transform: rotate(45deg) translateY(9px);
  }
  #menu-btn.open .menu-bar:nth-child(2) {
    opacity: 0;
  }
  #menu-btn.open .menu-bar:nth-child(3) {
    transform: rotate(-45deg) translateY(-9px);
  }

  /* メニュー展開時 */
  #nav-menu {
    background-color: #fff;
    border-top: 1px solid rgba(180, 0, 255, 0.1);
    padding: 1rem 0;
  }

  /* フェードインアニメーション */
  .fade-in {
    animation: fadeIn 0.3s ease-in-out forwards;
  }
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
  }

  /* ナビリンク */
  .nav-link {
    font-size: 1.1rem;
    margin: 0.4rem 1rem;
  }

  .navbar-brand {
    font-size: 1.5rem;
    letter-spacing: 1px;
  }

  @media (min-width: 768px) {
    #nav-menu {
      display: flex !important;
      background: none;
      border: none;
      padding: 0;
      align-items: center;
    }
  }
</style>
