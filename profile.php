<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Me • BPay</title>
  <style>
    /* RESET & BASE */
    * { box-sizing:border-box; margin:0; padding:0 }
    body { font:16px/1.5 "Segoe UI",sans-serif; background:#f4f6fa; color:#333; }
    a { color:inherit; text-decoration:none; }
    img { display:block; }

    /* HEADER BAR */
    .header-main {
      background: linear-gradient(90deg,#4D8FFF,#8F4FFF);
      padding:16px; text-align:center;
    }
    .header-main img { height:24px; }

    /* SECTION HEADER */
    .header-sec {
      background:#fff; display:flex; align-items:center;
      padding:12px 16px; box-shadow:0 1px 4px rgba(0,0,0,0.1);
    }
    .header-sec .back {
      width:20px; margin-right:12px; cursor:pointer;
    }
    .header-sec h1 {
      flex:1; font-size:18px; font-weight:500; color:#111;
    }

    /* BOTTOM NAV */
    .nav-bottom {
      position:fixed; bottom:0; left:0; right:0; display:flex;
      background:#fff; box-shadow:0 -1px 4px rgba(0,0,0,0.1);
    }
    .nav-bottom a {
      flex:1; text-align:center; padding:8px 0;
      font-size:12px; color:#555;
    }
    .nav-bottom a.active { color:#4D8FFF; }

    /* CARD */
    .card {
      background:#fff; border-radius:12px; margin:16px;
      padding:16px; box-shadow:0 2px 6px rgba(0,0,0,0.05);
    }

    /* MAIN “Me” */
    .me-card {
      display:flex; align-items:center;
    }
    .me-card img { width:40px; margin-right:12px; }
    .me-info { flex:1; }
    .me-info .title { font-size:16px; color:#111; }
    .me-info .subtitle { font-size:14px; color:#777; margin-top:4px; }
    .me-id { font-size:14px; color:#aaa; }

    /* MENU */
    .menu-list {
      list-style:none;
    }
    .menu-list li {
      display:flex; align-items:center; justify-content:space-between;
      background:#fff; margin:0 16px; padding:12px 16px;
      border-bottom:1px solid #eee; cursor:pointer;
    }
    .menu-list li:last-child{border-bottom:none;}
    .menu-list .icon { width:24px; margin-right:12px; }
    .menu-list .text { flex:1; font-size:16px; color:#111; }
    .menu-list .arrow{ width:16px; opacity:0.5; }

    /* TABS */
    .tabs { display:flex; margin:16px; background:#fff; border-radius:8px; overflow:hidden; box-shadow:0 2px 4px rgba(0,0,0,0.05); }
    .tabs button {
      flex:1; padding:12px; border:none; background:transparent;
      font-size:14px; cursor:pointer; color:#555;
    }
    .tabs button.active {
      color:#4D8FFF; border-bottom:2px solid #4D8FFF;
    }

    /* SEARCH BAR */
    .search-wrap {
      display:flex; align-items:center; background:#fff;
      margin:0 16px; padding:8px 12px; border-radius:8px;
      box-shadow:0 2px 4px rgba(0,0,0,0.05); margin-top:8px;
    }
    .search-wrap input {
      flex:1; border:none; outline:none; font-size:14px;
    }
    .search-wrap .caret { font-size:12px; color:#aaa; }

    /* TOTAL */
    .total-bar {
      background:#fff; margin:8px 16px; padding:12px 16px;
      border-radius:8px; box-shadow:0 2px 4px rgba(0,0,0,0.05);
      display:flex; justify-content:space-between; font-size:14px; color:#555;
    }

    /* EMPTY STATE */
    .empty {
      text-align:center; color:#aaa; padding:48px 16px; font-size:14px;
    }
    .empty img { width:80px; margin:0 auto 16px; opacity:0.2; }

    /* TASKS */
    .task-nav {
      display:flex; gap:12px; margin:16px;
    }
    .task-nav button {
      flex:1; background:#fff; padding:12px;
      border-radius:12px; box-shadow:0 2px 6px rgba(0,0,0,0.05);
      font-size:14px; cursor:pointer;
    }
    .task-banner {
      background:#F0F7FF; color:#FF4D4F; text-align:center;
      margin:0 16px; padding:12px; border-radius:8px; font-size:14px;
    }
    .filter-wrap {
      display:flex; align-items:center; gap:8px; margin:16px;
      background:#fff; padding:8px 12px; border-radius:8px;
      box-shadow:0 2px 4px rgba(0,0,0,0.05);
    }
    .filter-wrap select, .filter-wrap input {
      border:1px solid #DDD; border-radius:4px; padding:4px 8px; font-size:14px;
    }
    .filter-wrap button {
      margin-left:auto; background:#4D8FFF; color:#fff;
      border:none; padding:6px 12px; border-radius:4px; cursor:pointer;
    }
  </style>
</head>
<body>
 <style>
  .app-header {
    width: 100%;
    background-color: #fff;
    padding: 16px 0;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 1px 4px rgba(0,0,0,0.1);
  }
  .app-logo {
    height: 40px;
  }
</style>

<header class="app-header">
  <a href="home.php">
    <img src="images/logo.png" alt="BPay" class="app-logo">
  </a>
</header>
  <!-- bottom_nav.php -->
<style>
    /* --- Bottom Nav --- */
    .bottom-nav {
        position: fixed;
        bottom: 0; 
        left: 0; 
        right: 0;
        background: #fff;
        display: flex;
        justify-content: space-around;
        padding: 8px 0;
        box-shadow: 0 -1px 3px rgba(0, 0, 0, 0.1);
    }
    .bottom-nav a {
        flex: 1;
        text-align: center;
        color: #333;
        font-size: 12px;
    }
    .bottom-nav a.active { 
        color: #3366ff; 
    }
    .bottom-nav img { 
        height: 24px; 
        display: block; 
        margin: 0 auto 4px; 
    }
</style>

<div class="bottom-nav">
    <a href="home.php" class="active">
        <img src="https://img.icons8.com/sf-black-filled/64/228BE6/home.png" alt="Home">
        <span>Home</span>
    </a>
    <a href="transaction_history.php">
        <img src="https://img.icons8.com/external-sbts2018-lineal-color-sbts2018/58/228BE6/external-add-money-ecommerce-basic-1-sbts2018-lineal-color-sbts2018.png" alt="Transaction">
        <span>Transaction</span>
    </a>
    <a href="payment.php">
        <img src="https://img.icons8.com/external-kmg-design-glyph-kmg-design/32/228BE6/external-withdraw-finance-2-kmg-design-glyph-kmg-design.png" alt="Payment">
        <span>Payment</span>
    </a>
    <a href="profile.php">
        <img src="https://img.icons8.com/ios-glyphs/30/228BE6/user--v1.png" alt="Me">
        <span>Me</span>
    </a>
</div>
      <!-- MAIN “Me” -->

    <div class="card me-card">
      <img src="assets/icons/user-circle.png" alt="">
      <div class="me-info">
        <div class="title">Reward ratio</div>
        <div class="subtitle">0.50%</div>
      </div>
      <div class="me-id">56</div>
    </div>

    <ul class="menu-list">
  <li  onclick="location='profile.php?section=order'">
  <img class="icon" src="assets/icons/order-history.png" alt="">
  <div class="text">Order History</div>
  <img class="arrow" src="assets/icons/chevron-right.png" alt="">
</li>
  <li  onclick="location='profile.php?section=recharge'">
  <img class="icon" src="assets/icons/recharge-history.png" alt="">
  <div class="text">Recharge History</div>
  <img class="arrow" src="assets/icons/chevron-right.png" alt="">
</li>
  <li  onclick="location='profile.php?section=Withdraw'">
  <img class="icon" src="assets/icons/token-history.png" alt="">
  <div class="text">Withdraw History</div>
  <img class="arrow" src="assets/icons/chevron-right.png" alt="">
</li>
  <li  onclick="location='profile.php?section=tasks'">
  <img class="icon" src="assets/icons/tasks.png" alt="">
  <div class="text">Tasks</div>
  <img class="arrow" src="assets/icons/chevron-right.png" alt="">
</li>
  <li  onclick="location='profile.php?section=team'">
  <img class="icon" src="assets/icons/team.png" alt="">
  <div class="text">My Team</div>
  <img class="arrow" src="assets/icons/chevron-right.png" alt="">
</li>
  <li  onclick="location='profile.php?section=account'">
  <img class="icon" src="assets/icons/id-card.png" alt="">
  <div class="text">Account Info</div>
  <img class="arrow" src="assets/icons/chevron-right.png" alt="">
</li>
  <li onclick="openShare()" style="cursor:pointer;" >
  <img class="icon" src="assets/icons/contact-us.png" alt="">
  <div class="text">Contact Us</div>
  <img class="arrow" src="assets/icons/chevron-right.png" alt="">
</li>
  <li  onclick="location='logout.php'">
  <img class="icon" src="assets/icons/sign-out.png" alt="">
  <div class="text">Sign Out</div>
  <img class="arrow" src="assets/icons/chevron-right.png" alt="">
</li>
  </ul>

  
  <!-- SHARE OVERLAY -->
<div id="shareOverlay" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.3); align-items:center; justify-content:center;">
  <div style="background:#fff; padding:16px; border-radius:12px; position:relative; width:90%; max-width:320px;">
    <!-- Close Button -->
    <div style="position:absolute; top:8px; right:12px; font-size:24px; cursor:pointer;" onclick="closeShare()">✕</div>

    <!-- Share Options -->
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; text-align:center; margin-top:24px;">
      
      <!-- Telegram Share Option -->
      <div onclick="share('telegram')" style="cursor:pointer; display: flex; align-items: center; justify-content: center; gap: 8px; text-align:center;">
        <img src="assets/icons/telegram.png" width="48" alt="Telegram" style="display:block;">
        <div style="font-size: 16px;">Telegram</div>
      </div>

      <!-- WhatsApp Share Option -->
      <div onclick="share('whatsapp')" style="cursor:pointer; display: flex; align-items: center; justify-content: center; gap: 8px; text-align:center;">
        <img src="assets/icons/whatsapp.png" width="48" alt="WhatsApp" style="display:block;">
        <div style="font-size: 16px;">WhatsApp</div>
      </div>

    </div>
  </div>
</div>


<script>
  // Function to open the share overlay when 'Contact Us' is clicked
  function openShare() {
    document.getElementById('shareOverlay').style.display = 'flex';
  }

  // Function to close the share overlay
  function closeShare() {
    document.getElementById('shareOverlay').style.display = 'none';
  }

  // Function to share via Telegram or WhatsApp
  function share(app) {
    const url = encodeURIComponent(window.location.href + '?ref=56');
    const text = encodeURIComponent('Check out Bpay!');
    
    let link = '';
    if (app === 'telegram') {
      // For Telegram
      link = `https://t.me/bpayexchangeofficial`;
    } else if (app === 'whatsapp') {
      // For WhatsApp
      link = `https://wa.me/+85257111754?text=${text}%20${url}`;
    }

    // Open the share link in a new tab
    window.open(link, '_blank');
  }
</script>

</body>
</html>
