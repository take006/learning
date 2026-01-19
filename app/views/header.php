<header class="navbar navbar-expand-md bg-white shadow-sm" style="padding: 0;">
  <div class="container-fluid">
    <!-- ロゴ -->
    <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>">
      <img src="<?= BASE_URL ?>public/assets/images/Learning-Record-001.png" alt="Learning-Record" class="logo-img">
    </a>

    <!-- ハンバーガーボタン -->
    <button id="menu-btn" class="border-0 bg-transparent d-md-none" aria-controls="nav-menu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="menu-bar"></span>
      <span class="menu-bar"></span>
      <span class="menu-bar"></span>
    </button>
    <!-- オーバーレイ -->
    <div id="menu-overlay" class="menu-overlay"></div>
    <!-- ナビゲーションメニュー -->
    <nav id="nav-menu" class="nav-menu-mobile" role="navigation" aria-hidden="true">
      <a class="nav-link nav-menu-list-text fw-semibold" href="<?= BASE_URL ?>public/create.php">新規作成</a>
      <a class="nav-link nav-menu-list-text fw-semibold" href="<?= BASE_URL ?>public/archive.php">一覧</a>
      <a class="nav-link nav-menu-list-text fw-semibold" href="<?= BASE_URL ?>public/graph.php">集計</a>
    </nav>
  </div>
</header>

<!-- JavaScript制御 -->
<script>
  const menuBtn = document.getElementById('menu-btn');
  const navMenu = document.getElementById('nav-menu');
  const menuOverlay = document.getElementById('menu-overlay');

  if (menuBtn && navMenu && menuOverlay) {
    function openMenu() {
      navMenu.classList.remove('menu-hidden');
      navMenu.classList.add('menu-visible');
      menuOverlay.classList.add('active');
      menuBtn.classList.add('open');
      menuBtn.setAttribute('aria-expanded', 'true');
      navMenu.setAttribute('aria-hidden', 'false');
    }

    function closeMenu() {
      navMenu.classList.add('menu-hidden');
      navMenu.classList.remove('menu-visible');
      menuOverlay.classList.remove('active');
      menuBtn.classList.remove('open');
      menuBtn.setAttribute('aria-expanded', 'false');
      navMenu.setAttribute('aria-hidden', 'true');
    }

    // Toggle on button click
    menuBtn.addEventListener('click', () => {
      if (navMenu.classList.contains('menu-hidden')) openMenu();
      else closeMenu();
    });

    // Close menu when clicking overlay
    menuOverlay.addEventListener('click', closeMenu);

    // Keyboard accessibility
    menuBtn.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        menuBtn.click();
      }
    });

    // Close menu when clicking menu links
    const navLinks = navMenu.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
      link.addEventListener('click', closeMenu);
    });

    // Ensure correct state on resize (desktop: show menu; mobile: hide menu)
    function handleResize() {
      if (window.innerWidth >= 768) {
        navMenu.classList.remove('menu-hidden');
        navMenu.classList.remove('menu-visible');
        navMenu.setAttribute('aria-hidden', 'false');
        menuBtn.setAttribute('aria-expanded', 'false');
        menuBtn.classList.remove('open');
        menuOverlay.classList.remove('active');
      } else {
        navMenu.classList.add('menu-hidden');
        navMenu.setAttribute('aria-hidden', 'true');
        menuOverlay.classList.remove('active');
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
  .nav-menu-list-text {
    transition: opacity 0.3s ease;
  }
  .nav-menu-list-text:hover { opacity: 0.75; }

  /* レイアウト: ロゴ左、メニュー右（折り返し防止） */
  header.navbar .container-fluid {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    flex-wrap: nowrap;
    padding: 0;
    height: 64px;
  }

  .navbar-brand { font-size: 1.5rem; letter-spacing: 1px; white-space: nowrap; padding: 0.75rem 0; }

  .logo-img { height: 60px; width: auto; object-fit: contain; }

  /* ハンバーガーボタン */
  #menu-btn {
    width: 64px;
    height: 64px;
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    z-index: 1001;
    background-color: #f73b38;
    border-radius: 0;
    gap: 6px;
  }

  .menu-bar { width: 24px; height: 3px; background-color: #fff; border-radius: 2px; transition: all 0.3s ease; transform-origin: center; }

  /* 開閉アニメーション */
  #menu-btn.open .menu-bar:nth-child(1) { transform: translateY(9px) rotate(45deg); }
  #menu-btn.open .menu-bar:nth-child(2) { opacity: 0; }
  #menu-btn.open .menu-bar:nth-child(3) { transform: translateY(-9px) rotate(-45deg); }

  /* オーバーレイ */
  .menu-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 999;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
    display: none;
  }

  .menu-overlay.active {
    opacity: 1;
    visibility: visible;
    display: block;
  }

  /* デフォルトのナビ */
  #nav-menu { background-color: #fff; border-top: 1px solid rgba(180, 0, 255, 0.1); padding: 1rem 0; z-index: 1000; }

  /* フェードインアニメーション */
  .fade-in { animation: fadeIn 0.28s ease-in-out forwards; }
  @keyframes fadeIn { from { opacity: 0; transform: translateY(-6px); } to { opacity: 1; transform: translateY(0); } }

  /* ナビリンク */
  .nav-link { font-size: 1.1rem; margin: 0.4rem 1rem; white-space: nowrap; cursor: pointer; }

  /* デスクトップ以上: メニューは横並びで右寄せ、ハンバーガー非表示 */
  @media (min-width: 768px) {
    #nav-menu {
      display: flex !important;
      background: none;
      border: none;
      padding: 0;
      align-items: center;
      position: static;
      flex-direction: row;
      text-align: center;
      margin-top: 0;
    }

    #menu-btn { display: none !important; }

    .menu-overlay { display: none !important; }
  }

  /* モバイル/タブレット: ハンバーガーで切替 */
  @media (max-width: 767.98px) {
    /* デフォルトは非表示 */
    #nav-menu {
      position: fixed;
      top: 0px;
      left: 0;
      right: 0;
      width: 100%;
      flex-direction: column;
      background: #fff;
      padding: 1rem;
      border-top: 1px solid rgba(0,0,0,0.06);
      box-shadow: 0 8px 24px rgba(0,0,0,0.08);
      display: none !important;
    }

    #nav-menu.menu-visible {
      display: flex !important;
      animation: slideIn 0.3s ease-in-out forwards;
    }

    #nav-menu.menu-hidden {
      display: none !important;
    }

    @keyframes slideIn {
      from {
        transform: translateX(-100%);
        opacity: 0;
      }
      to {
        transform: translateX(0);
        opacity: 1;
      }
    }

    .nav-link { font-size: 1.15rem; margin: 0.5rem 0; }
  }
</style>
