<header class="navbar navbar-expand-md bg-white shadow-sm py-3">
  <div class="container-fluid">
    <!-- ロゴ -->
    <a class="navbar-brand fw-bold gradient-text" href="<?= BASE_URL ?>">
      🎮 Learning-Record
    </a>

    <!-- ハンバーガーボタン -->
    <button id="menu-btn" class="border-0 bg-transparent d-md-none" aria-controls="nav-menu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="menu-bar"></span>
      <span class="menu-bar"></span>
      <span class="menu-bar"></span>
    </button>
      <!-- ナビゲーションメニュー -->
      <nav id="nav-menu" class="d-none d-md-flex flex-column flex-md-row text-center mt-3 mt-md-0" role="navigation" aria-hidden="true">
        <a class="nav-link gradient-text fw-semibold" href="<?= BASE_URL ?>public/archive.php">一覧</a>
        <a class="nav-link gradient-text fw-semibold" href="<?= BASE_URL ?>public/create.php">新規作成</a>
        <a class="nav-link gradient-text fw-semibold" href="<?= BASE_URL ?>public/graph.php">グラフ</a>
        <span class="nav-link text-secondary disabled">カレンダー</span>
      </nav>
  </div>
</header>

<!-- JavaScript制御 -->
<script>
  const menuBtn = document.getElementById('menu-btn');
  const navMenu = document.getElementById('nav-menu');

  if (menuBtn && navMenu) {
    function openMenu() {
      navMenu.classList.remove('d-none');
      navMenu.classList.add('fade-in');
      menuBtn.classList.add('open');
      menuBtn.setAttribute('aria-expanded', 'true');
      navMenu.setAttribute('aria-hidden', 'false');
    }

    function closeMenu() {
      navMenu.classList.add('d-none');
      navMenu.classList.remove('fade-in');
      menuBtn.classList.remove('open');
      menuBtn.setAttribute('aria-expanded', 'false');
      navMenu.setAttribute('aria-hidden', 'true');
    }

    // Toggle on button click
    menuBtn.addEventListener('click', () => {
      if (navMenu.classList.contains('d-none')) openMenu();
      else closeMenu();
    });

    // Keyboard accessibility
    menuBtn.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        menuBtn.click();
      }
    });

    // Ensure correct state on resize (desktop: show menu; mobile: hide menu)
    function handleResize() {
      if (window.innerWidth >= 768) {
        navMenu.classList.remove('d-none');
        navMenu.setAttribute('aria-hidden', 'false');
        menuBtn.setAttribute('aria-expanded', 'false');
        menuBtn.classList.remove('open');
      } else {
        navMenu.classList.add('d-none');
        navMenu.setAttribute('aria-hidden', 'true');
      }
    }

    window.addEventListener('resize', handleResize);
    // Run once on load to set initial state
    handleResize();
  }
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
  .gradient-text:hover { opacity: 0.75; }

  /* レイアウト: ロゴ左、メニュー右（折り返し防止） */
  header.navbar .container-fluid {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    flex-wrap: nowrap;
  }

  .navbar-brand { font-size: 1.5rem; letter-spacing: 1px; white-space: nowrap; }

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

  .menu-bar { width: 100%; height: 3px; background-color: #000; border-radius: 2px; transition: all 0.3s ease; }

  /* 開閉アニメーション */
  #menu-btn.open .menu-bar:nth-child(1) { transform: rotate(45deg) translateY(9px); }
  #menu-btn.open .menu-bar:nth-child(2) { opacity: 0; }
  #menu-btn.open .menu-bar:nth-child(3) { transform: rotate(-45deg) translateY(-9px); }

  /* デフォルトのナビ（モバイルは非表示） */
  #nav-menu { background-color: #fff; border-top: 1px solid rgba(180, 0, 255, 0.1); padding: 1rem 0; z-index: 1000; }

  /* フェードインアニメーション */
  .fade-in { animation: fadeIn 0.28s ease-in-out forwards; }
  @keyframes fadeIn { from { opacity: 0; transform: translateY(-6px); } to { opacity: 1; transform: translateY(0); } }

  /* ナビリンク（折り返し防止） */
  .nav-link { font-size: 1.1rem; margin: 0.4rem 1rem; white-space: nowrap; }

  /* デスクトップ以上: メニューは横並びで右寄せ、ハンバーガー非表示 */
  @media (min-width: 768px) {
    #nav-menu { display: flex !important; background: none; border: none; padding: 0; align-items: center; position: static; flex-direction: row; }
    #menu-btn { display: none !important; }
  }

  /* モバイル/タブレット: ハンバーガーで切替、メニューは画面幅で縦並び表示 */
  @media (max-width: 767.98px) {
    /* メニューをヘッダの下に重なる形で表示 */
    #nav-menu {
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      display: flex !important;
      flex-direction: column;
      background: #fff;
      padding: 1rem;
      border-top: 1px solid rgba(0,0,0,0.06);
      box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    }

    .nav-link { font-size: 1.15rem; margin: 0.5rem 0; }
  }
</style>
