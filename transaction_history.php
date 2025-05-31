<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Transactions • XPay</title>
  <style>
    /*--- Reset & Base ---*/
    *{box-sizing:border-box;margin:0;padding:0;}
    body{font-family:Arial,sans-serif;background:#f4f6fa;color:#333;padding-bottom:80px;}
    a{text-decoration:none;color:inherit;}

    /*--- Header ---*/
    .app-header {
      width:100%; background:#fff; padding:16px 0;
      display:flex; justify-content:center; align-items:center;
      box-shadow:0 1px 4px rgba(0,0,0,0.1); margin-bottom:16px;
    }
    .app-logo { height:40px; }

    /*--- Stats ---*/
    .stats-row { display:flex; gap:12px; padding:0 16px 16px; }
    .stat-card {
      flex:1; background:#fff; border-radius:12px; padding:12px;
      text-align:center; box-shadow:0 2px 6px rgba(0,0,0,0.05);
    }
    .label { font-size:14px; color:#777; }
    .value { font-size:24px; color:#3366FF; margin:4px 0; }
    .sub   { font-size:12px; color:#aaa; }

    /*--- Exchange Form ---*/
    .exchange-card {
      background:#fff; border-radius:12px; padding:16px;
      margin:0 16px 16px; box-shadow:0 2px 6px rgba(0,0,0,0.05);
    }
    .exchange-tabs { display:flex; gap:4px; margin-bottom:12px; }
    .exchange-tabs button {
      flex:1; padding:8px 0; border:none; border-radius:8px;
      background:#f0f0f0; color:#555; cursor:pointer;
    }
    .exchange-tabs button.active {
      background:#3366FF; color:#fff;
    }
    .rate { font-size:14px; color:#999; margin-bottom:12px; }
    .input-group {
      display:flex; align-items:center; background:#f9f9f9;
      border-radius:8px; padding:8px; margin-bottom:8px;
    }
    .input-group .icon { height:24px; margin-right:8px; }
    .input-group input {
      border:none; flex:1; font-size:16px; background:transparent; outline:none;
    }
    .approx { font-size:14px; color:#666; margin-bottom:16px; }
    .btn-primary {
      width:100%; padding:12px; background:#3366FF; border:none;
      border-radius:8px; color:#fff; font-size:16px; cursor:pointer;
    }
    .btn-primary:hover { background:#254eb8; }

    /*--- Flash ---*/
    .pending-msg {
      padding:16px; margin:0 16px; background:#fff;
      border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.05);
    }

    /*--- Modal ---*/
    .modal-overlay {
      position:fixed; top:0; left:0; right:0; bottom:0;
      background:rgba(0,0,0,0.4); display:none;
      align-items:center; justify-content:center; z-index:10;
    }
    .modal-content {
      background:#fff; border-radius:12px; padding:16px;
      width:90%; max-width:360px; box-shadow:0 4px 12px rgba(0,0,0,0.15);
      text-align:center;
    }
    .modal-content .message {
      background:#fff4e5; color:#a65a00;
      border-radius:8px; padding:12px; margin-bottom:12px;
    }
    .modal-content .qr img { max-width:200px; margin:12px 0; }
    .modal-content .wallet {
      display:flex; align-items:center; justify-content:center; margin:8px 0;
    }
    .modal-content .wallet span {
      font-family:monospace; overflow-wrap:anywhere; margin-right:8px;
    }
    .modal-content .wallet button {
      padding:4px 8px; font-size:12px; border:none;
      background:#3366FF; color:#fff; border-radius:4px; cursor:pointer;
    }
    .modal-content .timer { font-family:monospace; margin:8px 0; }
    .modal-content .notes {
      text-align:left; font-size:12px; color:#c00; margin-top:12px;
    }
    .modal-content .notes p { margin:4px 0; }
    .modal-content .submit-btn,
    .modal-content .close-btn {
      margin-top:12px; padding:8px 16px; border:none; border-radius:8px; cursor:pointer;
    }
    .modal-content .submit-btn { background:#3366FF; color:#fff; }
    .modal-content .close-btn  { background:#ccc; }

    /*--- History Filter & Cards ---*/
    .history-filter { display:flex; gap:8px; padding:0 16px; margin-bottom:8px; }
    .history-filter button {
      flex:1; padding:8px 0; border:none; border-radius:8px;
      background:#f0f0f0; color:#555; cursor:pointer;
    }
    .history-filter button.active {
      background:#3366FF; color:#fff;
    }
    .history-container { padding:0 16px 80px; }
    .tx-card {
      background:#fff; border-radius:8px; padding:12px 16px;
      box-shadow:0 2px 4px rgba(0,0,0,0.05);
      display:grid; grid-template-columns:1fr auto; align-items:center; gap:8px;
      margin-bottom:8px;
    }
    .tx-info { display:flex; flex-direction:column; gap:4px; }
    .tx-date { font-size:12px; color:#777; }
    .tx-type { font-size:14px; font-weight:bold; text-transform:capitalize; }
    .tx-amount { font-size:16px; color:#3366FF; text-align:right; }
    .tx-status {
      font-size:12px; font-weight:bold; padding:4px 8px; border-radius:8px; text-transform:capitalize;
    }
    .tx-status.pending  { background:#fff7e6; color:#a65a00; }
    .tx-status.approved { background:#e6ffed; color:#237804; }
    .tx-status.rejected { background:#ffe6e6; color:#a8071a; }
  </style>
</head>
<body>

  <!-- HEADER -->
  <header class="app-header">
    <a href="home.php">
      <img src="images/logo.png" alt="XPay" class="app-logo">
    </a>
  </header>

  <main>
    <!-- STATS -->   
    <section class="stats-row">
      <div class="stat-card">
        <p class="label">B Token</p>
        <p class="value" id="stat-balance">0.00</p>
        <p class="sub">Available</p>
      </div>
      <div class="stat-card">
        <p class="label">Received</p>
        <p class="value" id="stat-received">0.00</p>
        <p class="sub">Completed</p>
      </div>
      <div class="stat-card">
        <p class="label">Total Profit</p>
        <p class="value" id="stat-profit">0.00</p>
        <p class="sub">&nbsp;</p>
      </div>
    </section>

    <!-- EXCHANGE FORM -->
    <section class="exchange-card">
      <div class="exchange-tabs">
        <button class="active" data-cur="USDT">USDT</button>
        <button          data-cur="INR">INR</button>
      </div>
      <!-- We’ll dynamically update this text -->  
      <p class="rate" id="rate-line">1 USDT ≈ 93 B Token</p>

      <div id="form-USDT">
  <div class="input-group">
    <!-- Tether icon -->
    <img src="images/usdt-circle.svg" class="icon" alt="USDT">
    <input
      type="number"
      id="usdt-input"
      placeholder="Enter The Quantity"
      step="0.01"
    >
  </div>
        <p class="approx">≈ <span id="usdt-BPay">0.00</span> B Token</p>
        <button class="btn-primary" id="confirm-usdt">Confirm Recharge</button>
      </div>

      <div id="form-INR" style="display:none;">
        <div class="input-group">
          <span class="icon" style="font-size:18px;">₹</span>
          <input type="number" id="inr-input" placeholder="Enter The Quantity" step="0.01">
        </div>
        <p class="approx">≈ <span id="inr-BPay">0.00</span> BPay</p>
        <button class="btn-primary" id="confirm-inr">Confirm Recharge</button>
      </div>
    </section>

    <!-- FLASH MESSAGE -->
    
    <!-- PAYMENT MODAL -->
    <div class="modal-overlay" id="modal">
      <div class="modal-content">
        <div class="message" id="modal-msg"></div>
        <div><strong id="modal-amt"></strong></div>
        <div class="qr"><img id="modal-qr" src="" alt="QR"></div>
        <p id="modal-label"></p>
        <div class="wallet">
          <span id="modal-addr"></span>
          <button id="modal-copy">Copy</button>
        </div>
        <div class="timer" id="modal-timer">00:59:00</div>
        <div class="notes">
          <p>ℹ You pay network fee.</p>
          <p>ℹ Contact customer service if needed.</p>
        </div>
        <button class="submit-btn" id="modal-submit">Submit Payment</button>
        <button class="close-btn"  id="modal-close">Close</button>
      </div>
    </div>

    <!-- HISTORY FILTER -->
    <section class="history-filter">
      <button class="active" data-type="deposit">Recharge</button>
      <button          data-type="withdrawal">Withdraw</button>
      <button          data-type="other">Other</button>
    </section>

    <!-- HISTORY CARDS -->
    <section class="history-container">
      <div id="transactions-list"></div>
    </section>
  </main>

  <!-- BOTTOM NAV -->
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

  <script>
  (()=>{
    const usdtRate    = 93,
          inrRate     = 1,
          userWallet  = "TEdwBShb1hhMfba9jckU7NyPQXhcXmsTqA",
          userUpi     = "9354964196@jio",
          initialHistory = [],
          rateLine    = document.getElementById('rate-line');

    // Tab switching & rate‐line update
    document.querySelectorAll('.exchange-tabs button').forEach(btn=>{
      btn.onclick = ()=>{
        document.querySelectorAll('.exchange-tabs button')
                .forEach(x=>x.classList.remove('active'));
        btn.classList.add('active');
        const cur = btn.dataset.cur;
        document.getElementById('form-USDT').style.display = cur==='USDT'?'block':'none';
        document.getElementById('form-INR').style.display  = cur==='INR' ?'block':'none';
        // update rate‐line
        if(cur==='USDT') {
          rateLine.textContent = `1 USDT ≈ ${usdtRate} BPay`;
        } else {
          rateLine.textContent = `1 INR ≈ 1 BPay`;
        }
      };
    });

    // Live BPay calculation
    document.getElementById('usdt-input').oninput = e=>
      document.getElementById('usdt-BPay')
        .textContent = ((parseFloat(e.target.value)||0)*usdtRate).toFixed(2);

    document.getElementById('inr-input').oninput = e=>
      document.getElementById('inr-BPay')
        .textContent = ((parseFloat(e.target.value)||0)*inrRate).toFixed(2);

    // Modal plumbing…
    const modal     = document.getElementById('modal'),
          msgEl     = document.getElementById('modal-msg'),
          amtEl     = document.getElementById('modal-amt'),
          qrEl      = document.getElementById('modal-qr'),
          lblEl     = document.getElementById('modal-label'),
          addrEl    = document.getElementById('modal-addr'),
          copyBtn   = document.getElementById('modal-copy'),
          timerEl   = document.getElementById('modal-timer'),
          submitBtn = document.getElementById('modal-submit'),
          closeBtn  = document.getElementById('modal-close');

    function showModal(cur,amt,xt,addr,label){
      msgEl.textContent   = `You will receive ${xt.toFixed(2)} BPay — scan to pay.`;
      amtEl.textContent   = `${amt} ${cur}`;
      qrEl.src            = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(addr)}`;
      lblEl.textContent   = label;
      addrEl.textContent  = addr;
      timerEl.textContent = '00:59:00';
      submitBtn.dataset.cur = cur;
      submitBtn.dataset.amt = amt;
      modal.style.display  = 'flex';
      startTimer();
    }
    let iv;
    function startTimer(){
      let s=59*60; clearInterval(iv);
      iv=setInterval(()=>{
        const m = String(Math.floor(s/60)).padStart(2,'0'),
              sec= String(s%60).padStart(2,'0');
        timerEl.textContent = `${m}:${sec}`; if(s-->0)return; clearInterval(iv);
      },1000);
    }

    document.getElementById('confirm-usdt').onclick = ()=>{
      const a=parseFloat(document.getElementById('usdt-input').value)||0;
      showModal('USDT',a,a*usdtRate,userWallet,'Wallet Address (TRC-20)');
    };
    document.getElementById('confirm-inr').onclick = ()=>{
      const a=parseFloat(document.getElementById('inr-input').value)||0;
      showModal('INR',a,a*inrRate,userUpi,'UPI Address');
    };

    copyBtn.onclick  = ()=>{ navigator.clipboard.writeText(addrEl.textContent); alert('Copied!'); };
    closeBtn.onclick = ()=>{ alert('Canceled—will refund if deducted.'); modal.style.display='none'; };
    submitBtn.onclick= ()=>{
      alert('Submitted—allow up to 5 mins for approval.');
      const f=document.createElement('form');
      ['action','currency','amount'].forEach(n=>{
        const i=document.createElement('input');
        i.name=n;
        i.value= n==='action'      ? 'submit_payment'
                : n==='currency'   ? submitBtn.dataset.cur
                : submitBtn.dataset.amt;
        f.appendChild(i);
      });
      f.method='POST'; f.style.display='none'; document.body.appendChild(f); f.submit();
    };

    // History rendering…
    let currentHistory = initialHistory;
    function render(list){
      const ct  = document.getElementById('transactions-list'),
            typ = document.querySelector('.history-filter button.active').dataset.type;
      ct.innerHTML = '';
      const fil = list.filter(tx=>{
        if(typ==='deposit')    return tx.transaction_type==='deposit';
        if(typ==='withdrawal') return tx.transaction_type==='withdrawal';
        return tx.transaction_type!=='deposit' && tx.transaction_type!=='withdrawal';
      });
      if(!fil.length){
        ct.innerHTML = '<div class="no-data">No transactions here.</div>';
        return;
      }
      fil.forEach(tx=>{
        const lbl = tx.transaction_type==='deposit'    ? 'Deposit'
                  : tx.transaction_type==='withdrawal' ? 'Withdrawal'
                  : 'Other',
              cur = tx.currency || '';
        const card = document.createElement('div');
        card.className = 'tx-card';
        card.innerHTML=`
          <div class="tx-info">
            <div class="tx-date">${tx.created_at}</div>
            <div class="tx-type">${lbl}</div>
          </div>
          <div>
            <div class="tx-amount">
              ${parseFloat(tx.amount).toFixed(2)}${cur?' '+cur:''}
            </div>
            <div class="tx-status ${tx.status}">${tx.status}</div>
          </div>`;
        ct.appendChild(card);
      });
    }

    // History filter buttons
    document.querySelectorAll('.history-filter button').forEach(btn=>{
      btn.onclick=()=>{
        document.querySelectorAll('.history-filter button')
                .forEach(x=>x.classList.remove('active'));
        btn.classList.add('active');
        render(currentHistory);
      };
    });

    // Poll stats + history
    async function poll(){
      try {
        const [h,s] = await Promise.all([
          fetch('transaction_history.php?ajax_history=1').then(r=>r.json()),
          fetch('transaction_history.php?ajax_stats=1').then(r=>r.json())
        ]);
        currentHistory = h;
        render(h);
        document.getElementById('stat-balance').textContent  = s.balance.toFixed(2);
        document.getElementById('stat-received').textContent = s.last_deposit.toFixed(2);
        document.getElementById('stat-profit').textContent   = s.total_profit.toFixed(2);
      } catch(e){ console.error(e); }
    }

    render(initialHistory);
    setInterval(poll,5000);

  })();
  </script>
</body>
</html>
